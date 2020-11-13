<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class AffiliateLinksStoreRequest extends FormRequest {

	public function authorize() {
		return Auth::check();
	}

	public function rules() {
		return [
			'name' => 'required|between:3,50',
			'originalURL' => 'required|url'
		];
	}

	public function attributes() {
        return [
			'originalURL' => 'Product URL'
		];
    }
}
