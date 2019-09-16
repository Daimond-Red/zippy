@extends('frontend/layouts.app')

@section('content')


<section class="login">

	<div class="container-fluid">

		<div class="row">

			<div class="col-md-6 col-sm-6">

				<div class="login-wrapper">

					<div class="login-detail">

						<img src="{{ getFrontImageUrl('frontend/assets/images/logo.png') }}" alt="logo">

						<h1>Welcome back!</h1>

						<p>Use your existing Zippy credentials to </p>

						<p>Login to your account.</p>
                        @if (\Session::has('error'))
                            <div class="alert alert-danger">
                                <ul>
                                    <li>{!! \Session::get('error') !!}</li>
                                </ul>
                            </div>
                        @endif
					</div>
                    <div class="clear"></div>

					<div class="login-form">

						<form method="post" action="{{ route('frontend.login') }}">
                            {{ csrf_field() }}
                            <div class="form-group row">

                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input id="asCustomer" type="radio" name="login" value="customer" checked>
                                    <label for="asCustomer" class="radio-inline">Login</label>
                                </div>

                                {{-- <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input id="asPartner" type="radio" name="login" value="partner">
                                    <label for="asPartner" class="radio-inline">Login as Partner</label>
                                </div> --}}

                            </div>

							<div  id="divcustomer" class="form-group option-div mt-5">
                                <input type="text" placeholder="Email Address" name="email" class="form-control">
                                <img src="{{ getFrontImageUrl('frontend/assets/images/icons/email.png') }}" alt="email">

							</div>

                            <div id="divpartner"  class="form-group mt-5 option-div"  style="display:none;">               

                                <input type="text" placeholder="Mobile Number" name="mobile-number" class="form-control">

                                <img src="{{ getFrontImageUrl('frontend/assets/images/icons/email.png')}}" alt="email">

                            </div>

							<div class="form-group">

								<input type="Password" placeholder="Password" name="password" class="form-control">

								<img src="{{ getFrontImageUrl('frontend/assets/images/icons/lock.png')}}" alt="lock">

							</div>
                            <button type="submit" class="btn btn-main">Login <span></span></button>

							<div class="gplogin">

								{{-- <a href="google"><i class="fa fa-google-plus"></i> Sign in with Google+</a>

								<a href="#" scope="public_profile,email"  onclick="javascript:login();"><i class="fa fa-facebook"></i> Login with Facebook</a> --}}
								
							</div>
						<!--<fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
								</fb:login-button> -->

								<div id="status">
								</div>
							<a href="{{ route('frontend.forgot_password') }}"><p>Forgot password?</p></a>
							<div class="new-user">
								<p>Don’t have an account yet? Join us today</p>
								<a href="{{ route('frontend.signup') }}" class="btn-main">SIGNUP NOW</a>
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

@section('script')


<script>
        /*window.fbAsyncInit = function() {
                FB.init({
                appId: '142841113051085',
                status: true,
                cookie: true,
                xfbml: true
            });
        };

        // Load the SDK asynchronously
        (function(d){
        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement('script'); js.id = id; js.async = true;
        js.src = "//connect.facebook.net/en_US/all.js";
        ref.parentNode.insertBefore(js, ref);
        }(document));

        function login() {
            FB.login(function(response) {
        
           $.ajax({
               url: 'customers/set_fb_access_token', 
               data:{
                   access_token:response.authResponse.accessToken,
               },
               type:'post',
               dataType:'text',
               success: function(result){
                   
                     window.location.href ="facebook";

              }
           });
            // handle the response
            console.log("Response goes here!");

            }, {scope: 'public_profile,email'});            
        }

        function logout() {
            FB.logout(function(response) {
              // user is now logged out
            });
        }

        //var status = FB.getLoginStatus();

        console.log(status);*/



        $(document).ready(function() {
            $("input[name$='login']").click(function() {
                var test = $(this).val();

                $(".option-div").hide();
                $("#div" + test).show();
            });
        });

</script>

@endsection