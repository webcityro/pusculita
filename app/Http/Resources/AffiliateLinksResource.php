<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AffiliateLinksResource extends JsonResource {

	public function toArray($request) {
		return [
			'id' => $this->id,
			'name' => $this->name,
			'originalURL' => $this->originalURL,
			'affiliateURL' => $this->affiliateURL,
			'purchased' => $this->purchased,
			'payed' => $this->payed,
			'goToURL' => route('affiliate_links.show', $this->id),
			'updateURL' => route('affiliate_links.update', $this->id),
			'destroyURL' => route('affiliate_links.destroy', $this->id),
			'user' => $this->user,
		];
	}
}
