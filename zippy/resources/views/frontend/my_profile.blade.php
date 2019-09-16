@extends('frontend/layouts.app')

@section('content')

@include('frontend/layouts/header')

@if(isset($user)) 
{{-- {{ dd($user) }} --}}
<section class="my-profile">
	<h2>My profile</h3>
    <div class="profile-card">
		<div class="row">

		<div class="col-md-3 col-sm-4">
		  <ul class="nav nav-pills nav-stacked">
		    <li class="active"><a data-toggle="pill" href="#home"><i class="fa fa-user" aria-hidden="true"></i> My Profile</a></li>
		    <li><a data-toggle="pill" href="#menu1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Profile</a></li>
		    <li>
		    	<form action="{{ route('frontend.signoutCustomer') }}" id="logout-form" method='post'>
		    		{{ csrf_field() }}
		    		<input type="hidden" name="customer_id" value="{{ $user->id }}">
		    	</form>
		    	<a data-toggle="pill" href="#" id="logout-customer" ><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
		    </li>
		  </ul>
	    </div>

		  <div class="tab-content col-md-9 col-sm-8">
		    <div id="home" class="tab-pane fade in active">
		    	<div class="row">
		    		<div class="col-md-3 col-sm-4">
		    			@if( !$user->image )
		    				<img class="user-img" src="{{ getFrontImageUrl('frontend/assets/images/default.jpg') }}"/>
		    			@else
		    				<img class="user-img" src="{{ getFrontImageUrl(''.$user->image) }}"/>
		    			@endif
		    		</div>
		    		<div class="col-md-9">
		    			<h3 class="name">{{ $user->first_name .' '. $user->last_name}} </h3>
		    			<div class="star-rating">
		    				<i class="fa fa-star" aria-hidden="true"></i>
		    				<i class="fa fa-star" aria-hidden="true"></i>
		    				<i class="fa fa-star" aria-hidden="true"></i>
		    				<i class="fa fa-star" aria-hidden="true"></i>
		    				<i class="fa fa-star" aria-hidden="true"></i>
		    			</div>
		    		</div>
		    	</div>
		    	<hr/>
		    	<div class="row info">
		    		<div class="col-md-4 col-xs-5 heading">
		    			<p>Mobile Number</p>
		    			<p>Email Address</p>
		    			<p>Account Type</p>
		    			<p>Aadhaar Number</p>
		    			<p>Pan Card</p>
		    		</div>
		    		<div class="col-md-8 col-xs-7">
		    			<p>+91 {{ $user->mobile_no }}</p>
		    			<p>{{ $user->email }}</p>
		    			<p><strong class="text-warning">{{ $user->customer_type == 1 ? 'Individual' : 'Company' }}</strong></p>
		    			<p>{{ $user->aadhar_no }}</p>
		    			<p>{{ $user->pancard_no }}</p>
		    		</div>
		    	</div>
		    </div>
		    <div id="menu1" class="tab-pane fade">
		    	<form class="form-horizontal" action="{{ route('frontend.edit_profile') }}" method="post" enctype="multipart/form-data">
		    		{{ csrf_field() }}
		    		<input type="hidden" name="customer_id" value="{{ $user->id }}"> 
			    	<div class="row">
			    		<div class="col-sm-4">
			    			@if( !$user->image )
			    				<img id="profile-pic" class="user-img" src="{{ getFrontImageUrl('frontend/assets/images/default.jpg') }}"/>
			    			@else
			    				<img id="profile-pic" class="user-img" src="{{ getFrontImageUrl(''.$user->image) }}"/>
			    			@endif
			    			{{-- <img id="profile-pic" class="user-img" src="{{ getFrontImageUrl('frontend/assets/images/default.jpg') }}"/> --}}
			    		</div>
			    		<div class="col-sm-6 custom-file">
			    			<label class="custom-file-upload">
							    <input type="file" name="image" id="upload" />
							    Change Profile Pic
							</label>
			    		</div>
			    	</div>
		    		<hr/>
			    	<div class="row">
			    		<div class="col-md-12">
		    				<div class="form-group">
							    <label for="first_name" class="col-sm-4 col-xs-5  control-label">First Name</label>
							    <div class="col-sm-6 col-xs-7">
							      	<input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->first_name }}" >
							    </div>
							</div>
			    			<div class="form-group">
							    <label for="last_name" class="col-sm-4 col-xs-5  control-label">Last Name</label>
							    <div class="col-sm-6 col-xs-7">
							      	<input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user->last_name }}">
							    </div>
							</div>
							<div class="form-group">
							    <label for="mobile_no" class="col-sm-4 col-xs-5 control-label">Mobile Number</label>
							    <div class="col-sm-6 col-xs-7">
							      	<input type="text" class="form-control" id="mobile_no" name="mobile_no" value="{{ $user->mobile_no }}">
							    </div>
							</div>
							<div class="form-group">
							    <label for="email" class="col-sm-4 col-xs-5 control-label">Email Address</label>
							    <div class="col-sm-6 col-xs-7">
							      	<input type="email" class="form-control" id="email"  name="email" value="{{ $user->email }}" disabled>
							    </div>
							</div>
							<div class="form-group">
							    <label for="aadhar_no" class="col-sm-4 col-xs-5 control-label">Aaadhar Number</label>
							    <div class="col-sm-6 col-xs-7">
							      	<input type="text" class="form-control" id="aadhar_no" name="aadhar_no" value="{{ $user->aadhar_no }}">
							    </div>
							</div>
							<div class="form-group">
							    <label for="pancard_no" class="col-sm-4 col-xs-5 control-label">Pan Card</label>
							    <div class="col-sm-6 col-xs-7">
							      	<input type="text" class="form-control" id="pancard_no" name="pancard_no" value="{{ $user->pancard_no }}" >
							    </div>
							</div>
						 	<div class="form-group">
						    	<div class="col-sm-offset-4 col-sm-6">
						      		<button type="submit" class="btn btn-primary">UPDATE</button>
						    	</div>
						  	</div>
			    		</div>
			    	</div>
			    </form>
		    </div>
		  </div>
	</div>
    </div>
</section>
@endif
@endsection

@section('script')

<script>
$(function(){
  $('#upload').change(function(){
    var input = this;
    var url = $(this).val();
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
     {
        var reader = new FileReader();

        reader.onload = function (e) {
           $('#profile-pic').attr('src', e.target.result);
        }
       reader.readAsDataURL(input.files[0]);
    }
    else
    {
      $('#profile-pic').attr('src', "{{ getFrontImageUrl('frontend/assets/images/default.jpg') }}");
    }
  });

  	$('#logout-customer').on('click', function(e) { 
  		e.preventDefault();
  		$('#logout-form').submit(); 
  	});
});
</script>

@endsection