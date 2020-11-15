<?php

namespace App\Search\Queries\Admin;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Webcityro\Larasearch\Search\Queries\Search;
use Webcityro\Larasearch\Search\Queries\EloquentSearch;

class UsersQuery extends Search {

	use EloquentSearch;

	protected function query(): Builder {
	 	return User::query();
	}

	protected function filter(Builder $query, string $field, string $value): Builder {
		return $query->where($field, 'LIKE', '%'.$value.'%');
	}
}
