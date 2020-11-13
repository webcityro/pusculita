@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-12">
			<affiliate-links
				fetch-url="{{ route('affiliate_links.fetch') }}"
				save-url="{{ route('affiliate_links.store') }}"
			></affiliate-links>
		</div>
	</div>
</div>
@endsection
