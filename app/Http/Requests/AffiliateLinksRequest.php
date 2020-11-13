<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Webcityro\Larasearch\Search\Payloads\Payload;
use Webcityro\Larasearch\Http\Requests\SearchRequest;
use Webcityro\Larasearch\Http\Requests\SearchFormRequest;
use Webcityro\Larasearch\Search\Payloads\MultiFieldsPayload;

class AffiliateLinksRequest extends FormRequest implements SearchFormRequest {

	use SearchRequest;

	public function authorize(): bool {
		return true;
	}

	public function searchFields(): array {
		return ['name', 'originalURL', 'affiliateURL'];
	}

	protected function orderByFields(): array {
		return ['id', 'name'];
	}

	protected function defaultOrderByField(): string {
		return 'name';
	}

	protected function payload(): Payload {
		return new MultiFieldsPayload($this->search ?? []);
	}

}
