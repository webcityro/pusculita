<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource {

	public function toArray($request) {
		return [
			'id' => $this->id,
			'name' => $this->name,
			'email' => $this->email,
			'role' => $this->role,
			'active' => (bool)$this->active,
			'affiliateLinks' => $this->affiliateLinks,
			'updateURL' => route('users.update', $this->id),
			'destroyURL' => route('users.destroy', $this->id),
		];
	}
}
