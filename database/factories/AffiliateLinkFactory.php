<?php

namespace Database\Factories;

use App\Models\AffiliateLink;
use Illuminate\Database\Eloquent\Factories\Factory;

class AffiliateLinkFactory extends Factory {

	protected $model = AffiliateLink::class;

	public function definition() {
		return [
			'userID' => auth()->check() ? auth()->id() : 1,
			'name' => $this->faker->name,
			'originalURL' => $this->faker->url,
			'affiliateURL' => $this->faker->url,
		];
	}
}
