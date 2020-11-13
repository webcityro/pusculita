<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Repositories\Eloquent\AffiliateLinksRepository;
use App\Repositories\Contracts\AffiliateLinksRepositoryContract;

class AppServiceProvider extends ServiceProvider {

	public function register() {
		//
	}

	public function boot() {
		JsonResource::withoutWrapping();

		$this->app->bind(AffiliateLinksRepositoryContract::class, AffiliateLinksRepository::class);
	}
}
