@extends('frontend/layouts.app')

@section('content')

@include('frontend/layouts/header')

<section class="my-booking">
	<h2>Booking History</h3>
	<div>
		  <ul class="nav nav-pills">
		    <li class="active"><a data-toggle="pill" href="#home">Pending</a></li>
		    <li><a data-toggle="pill" href="#menu1">Completed</a></li>
		    <li><a data-toggle="pill" href="#menu2">Cancelled</a></li>
		  </ul>

		  <hr>
		  
		  <div class="tab-content">
		    <div id="home" class="tab-pane fade in active">
		    	@if(count($pending) != 0)
		    		@foreach($pending as $book)
				    	<a href="{{ route('frontend.booking_details', $book->booking_id) }}">
				      	    <div class="list-card">
					      		<div class="row">
					      			<div class="col-md-4 col-sm-4 col-xs-4">
					      				<p class="heading">BOOKING NO.</p>
					      				<P>{{ $book->booking_id }}</P>
					      			</div>
					      			<div class="col-md-4 col-sm-4 col-xs-4">
					      				<p class="heading">STATUS</p>
					      				<P class="status">PENDING</P>
					      			</div>
					      			<div class="col-md-4 col-sm-4 col-xs-4">
					      				<p class="heading">DATE</p>
					      				<P>{{ date('d-m-Y' , strtotime($book->pickup_date)) }}</P>
					      			</div>
					      		</div>
				      	    </div>
				      	</a>
				    @endforeach
			    @endif
		      	

		    </div>
		    <div id="menu1" class="tab-pane fade">
		    	@if(count($completed) != 0)
		    		@foreach($completed as $book)
				    	<a href="{{ route('frontend.booking_details', $book->booking_id) }}">
				      	    <div class="list-card">
					      		<div class="row">
					      			<div class="col-md-4 col-sm-4 col-xs-4">
					      				<p class="heading">BOOKING NO.</p>
					      				<P>{{ $book->booking_id }}</P>
					      			</div>
					      			<div class="col-md-4 col-sm-4 col-xs-4">
					      				<p class="heading">STATUS</p>
					      				<P class="status">COMPLETED</P>
					      			</div>
					      			<div class="col-md-4 col-sm-4 col-xs-4">
					      				<p class="heading">DATE</p>
					      				<P>{{ date('d-m-Y' , strtotime($book->pickup_date)) }}</P>
					      			</div>
					      		</div>
				      	    </div>
				      	</a>
				    @endforeach
			    @endif
		    </div>
		    <div id="menu2" class="tab-pane fade">
		    	@if(count($cancel) != 0)
		    		@foreach($cancel as $book)
				    	<a href="{{ route('frontend.booking_details', $book->booking_id) }}">
				      	    <div class="list-card">
					      		<div class="row">
					      			<div class="col-md-4 col-sm-4 col-xs-4">
					      				<p class="heading">BOOKING NO.</p>
					      				<P>{{ $book->booking_id }}</P>
					      			</div>
					      			<div class="col-md-4 col-sm-4 col-xs-4">
					      				<p class="heading">STATUS</p>
					      				<P class="status">CANCELED</P>
					      			</div>
					      			<div class="col-md-4 col-sm-4 col-xs-4">
					      				<p class="heading">DATE</p>
					      				<P>{{ date('d-m-Y' , strtotime($book->pickup_date)) }}</P>
					      			</div>
					      		</div>
				      	    </div>
				      	</a>
				    @endforeach
			    @endif
		    </div>
		  </div>
	</div>
</section>

@endsection

@section('script')

@endsection