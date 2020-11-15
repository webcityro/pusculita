<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Webcityro\Larasearch\Search\Payloads\Payload;
use Webcityro\Larasearch\Http\Requests\SearchRequest;
use Webcityro\Larasearch\Http\Requests\SearchFormRequest;
use Webcityro\Larasearch\Search\Payloads\MultiFieldsPayload;

class UsersRequest extends FormRequest implements SearchFormRequest {

	use SearchRequest;

	public function authorize(): bool {
		return true;
	}

	public function searchFields(): array {
		return ['id', 'name', 'email', 'role'];
	}

	protected function orderByFields(): array {
		return ['id', 'name', 'email', 'role'];
	}

	protected function defaultOrderByField(): string {
		return 'name';
	}

	protected function payload(): Payload {
		return new MultiFieldsPayload($this->search ?? []);
	}

}
