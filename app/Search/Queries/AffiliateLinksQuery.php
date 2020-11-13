<?php

namespace App\Search\Queries;

use App\Models\AffiliateLink;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Webcityro\Larasearch\Search\Queries\Search;
use Webcityro\Larasearch\Search\Queries\EloquentSearch;

class AffiliateLinksQuery extends Search {

	use EloquentSearch;

	protected function query(): Builder {
	 	return Auth::user()->affiliateLinks()->getQuery();
	}

	protected function filter(Builder $query, string $field, string $value): Builder {
		return $query->where($field, 'LIKE', '%'.$value.'%');
	}
}
