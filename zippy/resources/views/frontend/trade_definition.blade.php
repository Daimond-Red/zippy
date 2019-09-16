@extends('frontend/layouts.app')

@section('content')

@include('frontend/layouts/header')

<section class="my-booking">
	<h2>Trade Definition</h3>
    <div class="trade-card texyt-justify">
		@if(isset($page))
			{!! $page->body !!}
		@endif
    </div>
</section>

@endsection

@section('script')

@endsection

