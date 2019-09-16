@extends('frontend/layouts.app')

@section('content')

@include('frontend/layouts/header')

<section class="map-area">
	<div class="overlay"></div>
	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d224368.39371590235!2d77.25804244618055!3d28.516983403738145!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!3m2!1sen!2sin!4v1543304868902" width="100%" height="600px" frameborder="0" style="border:0" allowfullscreen></iframe>
	<div class="search-section-block">
		@if (\Session::has('error'))
            <div class="alert alert-danger">
                <ul>
                    <li>{!! \Session::get('error') !!}</li>
                </ul>
            </div>
        @endif
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
        @endif
		<form action="{{ route('frontend.booking') }}" method="post">

			{{ csrf_field() }}
			<div class="input-group">
			  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-map-marker text-success" aria-hidden="true"></i></span>
			  <input id="pick-location" type="text" name="pickup_address" class="form-control" placeholder="Your Location" onkeyup="showList(this.value)" aria-describedby="basic-addon1">
			</div>
			<hr>
			<div class="input-group">
			  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-map-marker text-danger" aria-hidden="true"></i></span>
			  <input id="drop-location" type="text" name="drop_address" class="form-control" placeholder="Drop Location" onkeyup="showList(this.value)" aria-describedby="basic-addon1">
			</div>
			<div class="booking-form">
			  <div class="form-group">
			    <label for="typeOfVehicle">Type of Vehicle Required</label>
			    <select class="form-control" name="vehicle_type_id" id="typeOfvehicle">
			    	<option value="" >Select</option>
			    	@foreach($type_of_vehicles as $vehicle)
			    		<option value="{{ $vehicle->vehicle_type_id }}" data-payload="{{ $vehicle->payload }}">{{ $vehicle->title }}</option>
			    	@endforeach
		    	</select>
			  </div>
			  <div class="row">
			  	<div class="col-md-6">
			  		<div class="form-group">
					    <label for="no_of_vehicle">No Of Vehicle(s)<br><span>Required</span></label>
					    <input type="text" class="form-control" name="no_of_vehicle" id="no_of_vehicle">
					</div>
			  	</div>
			  	<div class="col-md-6">
			  		<div class="form-group">
					    <label for="actual_gross_weight">Gross Weight<br><span>(Tonnes)</span></label>
					    <input type="text" class="form-control" name="actual_gross_weight" id="actual_gross_weight">
					</div>
			  	</div>		
			  </div>
			  <div class="form-group">
			    <label for="typeOfVehicle">Payment Type</label>
			    <select class="form-control" name="payment_type" id="typeOfvehicle">
			    	<option value="" >Select</option>
			    	@foreach($payment_types as $pay)
			    		<option value="{{ $pay->payment_type }}">{{ $pay->title }}</option>
			    	@endforeach
		    	</select>
			  </div>
			  <div class="form-group">
			    <label for="typeOfVehicle">Type of Cargo</label>
			    <select class="form-control" name="cargo_type_id" id="typeOfvehicle">
			    	<option value="" >Select</option>
			    	@foreach($cargos as $cargo)
			    		<option value="{{ $cargo->cargo_type_id }}">{{ $cargo->title }}</option>
			    	@endforeach
		    	</select>
			  </div>
			  <button type="submit" class="btn btn-primary btn-block">Book Now</button>
			</div>
			<div class="search-list" style="display:none;">
				<ul class="list-group">
				  <li class="list-group-item">Dilshad Garden, Delhi</li>
				  <li class="list-group-item">Sec-63, Noida</li>
				  <li class="list-group-item">Indirapuram, Ghaziabad</li>
				  <li class="list-group-item">Porta ac consectetur ac</li>
				  <li class="list-group-item">Vestibulum at eros</li>
				  <li class="list-group-item">Dilshad Garden, Delhi</li>
				  <li class="list-group-item">Sec-63, Noida</li>
				  <li class="list-group-item">Indirapuram, Ghaziabad</li>
				  <li class="list-group-item">Porta ac consectetur ac</li>
				  <li class="list-group-item">Vestibulum at eros</li>
				</ul>
			</div>
		</form>
	</div>
<section>

@endsection

@section('script')

<script>
	$(document).ready(function(){
		$("#pick-location, #drop-location").on("keyup", function() {
			$('.search-list').show();
			$('.booking-form').hide();
			var id = $(this).attr('id');
			var value = $(this).val().toLowerCase();
			$(".search-list li").filter(function() {
			  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
			$('.search-list li').click(function(){
				$('#' + id).val($(this).text());
				$('.search-list').hide();
			    $('.booking-form').show();  
				id = "";
			});
			
		});
	});
</script>
@endsection