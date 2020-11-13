<?php

namespace App\Repositories\Contracts;

use Webcityro\Larasearch\Search\Queries\Search;
use Webcityro\Larasearch\Http\Requests\SearchFormRequest;

interface AffiliateLinksRepositoryContract {

	public function search(SearchFormRequest $request): Search;
}
