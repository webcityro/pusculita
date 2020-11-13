@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Create a affiliate link</div>

				<div class="card-body">
					<add-link-form api-url="{{ route('affiliate_links.store') }}"></add-link-form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
