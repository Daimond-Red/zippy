@extends('frontend/layouts.app')

@section('content')
	<section class="login">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<div class="login-wrapper">
						<div class="login-detail">
							<img src="{{ getFrontImageUrl('frontend/assets/images/logo.png') }}" alt="logo">
							<h1>OTP Verify</h1>
						</div>

						<div class="col-md-12 col-sm-12">
							
						</div>
						<div class="clear"></div>
						<div class="login-form">
							<form method="post" action="{{ route('frontend.otpVerified') }}">
								{{ csrf_field() }}
								<div class="form-group">		
									<input type="text" placeholder="Enter OTP Here" name="otp" class="form-control">
									<img src="{{ getFrontImageUrl('frontend/assets/images/icons/lock.png') }}" alt="lock">
								</div>
								<button type="submit" name="verify_otp" class="btn btn-main">Verify <span></span></button>
							</form>
							<form action="{{ route('frontend.resendOtp') }}">
								{{ csrf_field() }}
								<div class="new-user">
									<button class="btn btn-main" name="resend_otp" type="submit">Click to Resend OTP</button>
								</div>
							</form>
						</div>

					</div>
				</div>

				<div class="col-md-6 col-sm-6">
					<div class="deliver-img">
						<img src="{{ getFrontImageUrl('frontend/assets/images/vector/delivery-man.jpg') }}">
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection