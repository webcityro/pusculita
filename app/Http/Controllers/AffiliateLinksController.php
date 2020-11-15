<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AffiliateLink;
use App\Services\ApiCallerService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AffiliateLinksRequest;
use App\Http\Resources\AffiliateLinksResource;
use App\Http\Requests\AffiliateLinksStoreRequest;
use Webcityro\Larasearch\Http\Resources\SearchCollection;
use App\Repositories\Contracts\AffiliateLinksRepositoryContract;

class AffiliateLinksController extends Controller {

	public function index() {
		return view('affiliateLinks.index');
	}

	public function fetch(
		AffiliateLinksRequest $request,
		AffiliateLinksRepositoryContract $repository
	) {
		return new SearchCollection(
			$repository->search($request), AffiliateLinksResource::class
		);
	}

	public function store(AffiliateLinksStoreRequest $request, ApiCallerService $api) {
		$affiliateLink = Auth::user()->affiliateLinks()->where('originalURL', $request->input('originalURL'))->whereNull('payed')->first();

		if ($affiliateLink) {
			return $this->apiResponse(
				new AffiliateLinksResource($affiliateLink),
				'The affiliate link "'.$affiliateLink->originalURL.'" already exists with the name "'.$affiliateLink->name.'".',
				304
			);
		}

		$apiResponse = $api->call('POST', 'affiliate-links', [
			'name' => $request->input('name'),
			'originalURL' => $request->input('originalURL')
		]);

		$affiliateLink = Auth::user()->affiliateLinks()->create([
			'name' => $apiResponse->result[0]->name,
			'originalURL' => $apiResponse->result[0]->originalURL,
			'affiliateURL' => $apiResponse->result[0]->ps_url,
		]);

		return $this->apiResponse(
			new AffiliateLinksResource($affiliateLink),
			'The affiliate link "'.$affiliateLink->name.'" was added successfully!',
			201
		);
	}

	public function show(AffiliateLink $affiliateLink) {
		return redirect($affiliateLink->affiliateURL.'/'.$affiliateLink->id);
	}

	public function update(
		AffiliateLinksStoreRequest $request,
		AffiliateLink $affiliateLink
	) {
		$affiliateLink->update(['name' => $request->name]);
		return $this->apiResponse(
			new AffiliateLinksResource($affiliateLink->fresh()),
			'The affiliate link "'.$affiliateLink->name.'" was renamed to "'.$request->name.'" successfully!'
		);
	}

	public function destroy(AffiliateLink $affiliateLink) {
		$affiliateLink->delete();
		return $this->apiResponse(
			new AffiliateLinksResource($affiliateLink),
			'The affiliate link "'.$affiliateLink->name.'" was deleted successfully!'
		);
	}
}
