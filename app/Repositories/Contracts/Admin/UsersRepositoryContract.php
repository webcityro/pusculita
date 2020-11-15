<?php

namespace App\Repositories\Contracts\Admin;

use Webcityro\Larasearch\Search\Queries\Search;
use Webcityro\Larasearch\Http\Requests\SearchFormRequest;

interface UsersRepositoryContract {

	public function search(SearchFormRequest $request): Search;
}
