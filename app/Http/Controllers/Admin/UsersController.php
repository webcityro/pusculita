<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Actions\Fortify\CreateNewUser;

use App\Http\Requests\Admin\UsersRequest;
use App\Http\Resources\Admin\UsersResource;
use Webcityro\Larasearch\Http\Resources\SearchCollection;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use App\Repositories\Contracts\Admin\UsersRepositoryContract;

class UsersController extends Controller {

	public function index() {
		return view('admin.users.index');
	}

	public function fetch(UsersRequest $request, UsersRepositoryContract $repository) {
		return new SearchCollection(
			$repository->search($request), UsersResource::class
		);
	}

	public function store(Request $request, CreateNewUser $creator) {
		return $this->apiResponse(
			new UsersResource($creator->create($request->all())),
			'The user "'.$request->name.'" was added successfully.',
			201
		);
	}

	public function show($id) {
		//
	}

	public function edit($id) {
		//
	}

	public function update(
		Request $request,
		UpdatesUserProfileInformation $updater,
		User $user
	) {
		$updater->update($user, $request->all());

		return $this->apiResponse(
			new UsersResource($user->fresh()),
			'The user "'.$request->name.'" was updated successfully.'
		);
	}

	public function destroy(User $user) {
		abort_if($user->id === Auth::id(), 403, 'you can not delete yourself dummy!');
		$user->delete();
		return $this->apiResponse(
			new UsersResource($user),
			'The user "'.$user->name.'" was deleted successfully!'
		);
	}
}
