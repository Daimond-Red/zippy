<section class="login">

	<div class="container-fluid">

		<div class="row">

			<div class="col-md-6 col-sm-6">

				<div class="login-wrapper">

					<div class="login-detail">

						<img src="<?= base_url() ?>assets/images/logo.png" alt="logo">

						<h1>Welcome back!</h1>

						<p>Use your existing Zippy credentials to </p>

						<p>Login to your account.</p>

					</div>



					<div class="col-md-12 col-sm-12">

						<?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>

						<?php

							if(isset($error) == 1){

								if(isset($message)){

									echo '<div class="alert alert-danger">';

									echo $message;

									echo '</div>';

								}

							}else{

								if(isset($message)){

									echo '<div class="alert alert-success">';

									echo $message;

									echo '</div>';

								}

							}

						?>

					</div>

					<div class="clear"></div>

					<div class="login-form">

						<form method="post" action="<?= site_url('login') ?>">

							<div class="form-group">								

								<input type="text" placeholder="Registered Email Address" name="email" class="form-control">

								<img src="<?= base_url() ?>assets/images/icons/email.png" alt="email">

							</div>

							<div class="form-group">

								<input type="Password" placeholder="Password" name="password" class="form-control">

								<img src="<?= base_url() ?>assets/images/icons/lock.png" alt="lock">

							</div>



							<button type="submit" class="btn btn-main">Login <span></span></button>

							<div class="gplogin">

								<a href="<?=base_url()?>google"><i class="fa fa-google-plus"></i> Sign in with Google+</a>

								<a href="#" scope="public_profile,email"  onclick="javascript:login();"><i class="fa fa-facebook"></i> Login with Facebook</a>
								
							</div>
						<!--<fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
								</fb:login-button> -->

								<div id="status">
								</div>
							<a href="<?= site_url('forgot-password') ?>"><p>Forgot password?</p></a>



							<div class="new-user">

								<p>Don’t have an account yet? Join us today</p>

								<a href="<?= site_url('signup') ?>" class="btn-main">SIGNUP NOW</a>

							</div>

						</form>

					</div>



				</div>

			</div>



			<div class="col-md-6 col-sm-6">

				<div class="deliver-img">

					<img src="<?= base_url() ?>assets/images/vector/delivery-man.jpg">

				</div>

			</div>

		</div>

	</div>

</section>
<!--
<script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else {
      // The person is not logged into your app or we are unable to tell.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
      alert("dd");
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '142841113051085',
      cookie     : true,  // enable cookies to allow the server to access 
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.8' // use graph api version 2.8
    });

    // Now that we've initialized the JavaScript SDK, we call 
    // FB.getLoginStatus().  This function gets the state of the
    // person visiting this page and can return one of three states to
    // the callback you provide.  They can be:
    //
    // 1. Logged into your app ('connected')
    // 2. Logged into Facebook, but not your app ('not_authorized')
    // 3. Not logged into Facebook and can't tell if they are logged into
    //    your app or not.
    //
    // These three cases are handled in the callback function.

    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me?fields=id,name,email', function(response) {
        alert(response.toSource());
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
  }
</script>-->
<script>
        window.fbAsyncInit = function() {
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
	             url: '<?= base_url() ?>customers/set_fb_access_token', 
	             data:{
	                 access_token:response.authResponse.accessToken,
	             },
	             type:'post',
	             dataType:'text',
	             success: function(result){
	                 
	                   window.location.href ="<?= base_url() ?>facebook";

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

        console.log(status);

</script>