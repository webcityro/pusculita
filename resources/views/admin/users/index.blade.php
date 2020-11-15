@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-12">
			<users
				fetch-url="{{ route('users.fetch') }}"
				save-url="{{ route('users.store') }}"
			></users>
		</div>
	</div>
</div>
@endsection
