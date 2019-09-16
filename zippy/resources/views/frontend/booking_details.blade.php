@extends('frontend/layouts.app')

@section('content')

@include('frontend/layouts/header')

@if( count($details) > 0 )
	<section class="my-booking">
		<h2>Booking Details</h3>
		<div class="booking-detail">
			<div class="row main-info">
				<div class="col-md-3 col-sm-3 col-xs-6 card">
					<p class="heading">{{ $details->total_distance }}</p>
					<p>Distance</p>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6 card">
					<p class="heading"><i class="fa fa-inr" aria-hidden="true"></i> {{ $details->total_amount }}</p>
					<p>Amount</p>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6 card">
					<p class="heading">{{ $details->actual_gross_weight }} Tonnes</p>
					<p>Weight</p>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6 card">
					<p class="heading">{{ $details->no_of_vehicle }}</p>
					<p>No of Vehicle(s)</p>
				</div>
			</div>
			<hr/>
			<div class="address">
				<div>
					<p class="heading"><i class="fa fa-compass" aria-hidden="true"></i> Pick Up Location (Place of Loading)</p>
					<div class="content">
						<p>{{ $details->pickup_address }}</p>
						{{-- <p>Uttar Pradesh 201301, India</p> --}}
				    </div>
			    </div>
			    <div class="drop-location">
					<p class="heading"><i class="fa fa-map-marker text-danger" aria-hidden="true"></i> Drop Location (Place of Unloading)</p>
					<div class="content">
					<p>{{ $details->drop_address }}</p>
					{{-- <p>Uttar Pradesh 201301, India</p> --}}
				    </div>
			    </div>
			</div>
			<div class="other-info">
				<div class="row">
					<div class="col-md-6 card">
						<p>Type of Cargo</p>
						<p class="heading">{{ $details->cargo_type->title }}</p>
					</div>
					<div class="col-md-6 card">
						<p>Payment Type</p>
						<p class="heading">{{ $details->payment_type->title }}</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 card">
						<p>Status</p>
						<p class="heading text-danger"><em>Veh Allocation Pending</em></p>
					</div>
					<div class="col-md-6 card">
						<p>Pickup Date and Time</p>
						<p class="heading">{{ date('d-m-Y', strtotime($details->pickup_date)). ' ' .$details->pickup_time }}</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 card">
						<p class="heading">Additional Info</p>
						<p>Testing</p>
					</div>
				</div>
			</div>
			<div class="row btn-section">
				<div class="col-md-4 col-sm-4">
					<button  class="btn btn-primary btn-block">e-Consignment Note</button>
				</div>
				<div class="col-md-4 col-sm-4">
					<button class="btn btn-primary btn-block">Cancel Booking</button>
				</div>
			</div>		
		</div>
		
	</section>
@endif
@endsection

@section('script')
	
@endsection