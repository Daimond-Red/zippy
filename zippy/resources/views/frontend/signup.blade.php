@extends('frontend/layouts.app')

@section('content')

<section class="registor-block">
    <div class="container-fluid">
        <div class="register-page">
            <img src="{{ getFrontImageUrl('frontend/assets/images/vector/delivery-process.jpg') }}">
        </div>
        <div class="col-sm-8 col-sm-offset-2 col-md-offset-0 col-md-4">
            <div class="signup-form">
                <img src="{{ getFrontImageUrl('frontend/assets/images/logo-tagline.png') }}">

                <div class="register-img">
                    <img src="{{ getFrontImageUrl('frontend/assets/images/vector/delivery-process.jpg') }}">
                </div>

                <p>Good job. Thanks for showing interest in joining
                    our platform. We will make sure you enjoy using
                    it everytime as we do..</p>

                <div class="login-form">
                    <form action="{{ route('frontend.signup') }}" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <?php /* echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                                <?php 
                                if ($error == 1) {
                                    foreach ($errorData as $err) {
                                        foreach ($err as $key => $value) {
                                            echo '<div class="alert alert-danger">';
                                            echo $value;
                                            echo '</div>';
                                        }
                                    }
                                } else {
                                    if (isset($message)) {
                                        echo '<div class="alert alert-success">';
                                        echo $message;
                                        echo '</div>';
                                    }
                                }
                                if ($this->session->flashdata('error')) {
                                    ?>
                                    <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('successs')) { ?>
                                    <div class="alert alert-success"> <?= $this->session->flashdata('successs') ?> </div>
                                <?php }
                                */?>
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input id="asCustomer" type="radio" name="signup" value="individual" checked>
                                <label for="asCustomer" class="radio-inline">Individual</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input id="asPartner" type="radio" name="signup" value="company">
                                <label for="asPartner" class="radio-inline">Company</label>
                            </div>

                        </div>

                        <div id="divindividualoption" class="row mt-5 option-div" style="display:block;">
                            <div class="col-md-6">
                                <div class="form-group">								
                                    <input type="text" placeholder="First Name" name="first_name" value="<?php /* echo set_value('first_name') */ ?>" class="form-control"  data-validation="required" >
                                    <img src="{{ getFrontImageUrl('frontend/assets/images/icons/user.png') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">								
                                    <input type="text" placeholder="Last Name" name="last_name" value="<?php /* echo set_value('last_name')  */ ?>" class="form-control"  data-validation="required" >
                                    <img src="{{ getFrontImageUrl('frontend/assets/images/icons/user.png') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">								
                            <input type="text" placeholder="Mobile Number" name="mobile_no" value="<?php /* echo set_value('mobile_no')  */ ?>" maxlength="10" class="form-control" data-validation="length" data-validation-length="10" data-validation-error-msg="Phone Number must be equal to 10 digit">
                            <img src="{{ getFrontImageUrl('frontend/assets/images/icons/cellphone.png') }}">
                        </div>
                        <div class="form-group">								
                            <input type="text" placeholder="Email Address" name="email" value="<?php /* echo set_value('email')  */ ?>" class="form-control" data-validation="email">
                            <img src="{{ getFrontImageUrl('frontend/assets/images/icons/mail.png') }}">
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">								
                                    <input type="Password" placeholder="Password"  value="<?php /* echo set_value('password')  */ ?>" class="form-control" name="pass_confirmation" data-validation="length"   data-validation-length="min8" data-validation-error-msg="Password is shortan than 8 characters">
                                    <img src="{{ getFrontImageUrl('frontend/assets/images/icons/lock-small.png') }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">								
                                    <input type="Password" placeholder="Confirm Password" value="<?php /* echo set_value('confirm_password')  */ ?>" class="form-control" name="pass" data-validation="confirmation">
                                    <img src="{{ getFrontImageUrl('frontend/assets/images/icons/repassword.png') }}">
                                </div>
                            </div>
                        </div>
                        
                        <div id="divindividual" class="form-group option-div">								
                            <input type="text" placeholder="AADHAAR Number (optional)" name="gstin" value="<?php /* echo set_value('gstin')  */ ?>" class="form-control">
                            <img src="{{ getFrontImageUrl('frontend/assets/images/icons/building.png') }}">
                        </div>

                        <div id="divcompany" class="form-group option-div" style="display:none;">                                
                            <input type="text" placeholder="GSTIN (optional)" name="gstin" value="<?php /* echo set_value('gstin')  */ ?>" class="form-control">
                            <img src="{{ getFrontImageUrl('frontend/assets/images/icons/building.png') }}">
                        </div>
                          
                        <div class="member" id="member-form">
                            <div class="form-group">								
                                <input type="text" placeholder="PAN Number (optional)" name="pancard_no" value="<?php /* echo set_value('pancard_no') */ ?>" maxlength="10" class="form-control">
                                <img src="{{ getFrontImageUrl('frontend/assets/images/icons/pan-card.png') }}">
                            </div>
                        </div>
                        <button type="submit" class="btn-main btn register-btn">Get Registered <span></span></button>
						<p class="already-account">Already have an account? <a href="{{ route('frontend.login') }}">login here</a></p>
                        <p>By signing up with Zippy, you agree to <a href="#">Terms and Conditions</a></p>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</section>

@endsection


@section('script')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>

<script>
    $(document).ready(function() {
        $("input[name$='signup']").click(function() {
            var test = $(this).val();

            $(".option-div").hide();
            $("#div" + test).show();
        });

        $("input[value$='individual']").click(function() {
            $("#divindividualoption").show();
        });    
    });
</script>

<script>
    $.validate({
        lang: 'en',
        modules : 'security'
    });
    $.validate();
</script>
@endsection