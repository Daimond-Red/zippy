@extends('frontend/layouts.app')

@section('content')

@include('frontend/layouts/header')

<section class="my-booking">
	<h2>Vehicle Types</h3>
    <div class="vehicle-card">
    	@foreach($type_of_vehicles as $vehicle)
			<div class="row">
				<div class="col-md-9 col-sm-9 col-xs-9">
					<p class="text-seconcary">{{ $vehicle->title }}</p>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					<p class="right">{{ $vehicle->payload }}</p>
				</div>
			</div>
			<hr/>
		@endforeach
    </div>
</section>

@endsection

@section('script')

@endsection