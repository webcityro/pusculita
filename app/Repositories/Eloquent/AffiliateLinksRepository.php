<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\AffiliateLinksRepositoryContract;
use Webcityro\Larasearch\Search\Queries\Search;
use Webcityro\Larasearch\Http\Requests\SearchFormRequest;

class AffiliateLinksRepository implements AffiliateLinksRepositoryContract {

	public function search(SearchFormRequest $request): Search {
		return (new \App\Search\Queries\AffiliateLinksQuery($request->requestParams(), $request->requestOrder(), $request->searchFields()));
	}
}
