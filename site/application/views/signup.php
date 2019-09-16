<section class="registor-block">
    <div class="container-fluid">
        <div class="register-page">
            <img src="<?= base_url() ?>assets/images/vector/delivery-process.jpg">
        </div>
        <div class="col-sm-4 col-md-4">
            <div class="signup-form">
                <img src="<?= base_url() ?>assets/images/logo-tagline.png">

                <div class="register-img">
                    <img src="<?= base_url() ?>assets/images/vector/delivery-process.jpg">
                </div>

                <p>Good job. Thanks for showing interest in joining
                    our platform. We will make sure you enjoy using
                    it everytime as we do..</p>

                <div class="login-form">
                    <form action="<?= site_url('signup') ?>" method="post">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
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
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">								
                                    <input type="text" placeholder="First Name" name="first_name" value="<?php echo set_value('first_name') ?>" class="form-control">
                                    <img src="<?= base_url() ?>assets/images/icons/user.png">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">								
                                    <input type="text" placeholder="Last Name" name="last_name" value="<?php echo set_value('last_name') ?>" class="form-control">
                                    <img src="<?= base_url() ?>assets/images/icons/user.png">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">								
                            <input type="text" placeholder="Mobile Number" name="mobile_no" value="<?php echo set_value('mobile_no') ?>" maxlength="10" class="form-control">
                            <img src="<?= base_url() ?>assets/images/icons/cellphone.png">
                        </div>
                        <div class="form-group">								
                            <input type="text" placeholder="Email Address" name="email" value="<?php echo set_value('email') ?>" class="form-control">
                            <img src="<?= base_url() ?>assets/images/icons/mail.png">
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">								
                                    <input type="Password" placeholder="Password" name="password" value="<?php echo set_value('password') ?>" class="form-control">
                                    <img src="<?= base_url() ?>assets/images/icons/lock-small.png">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">								
                                    <input type="Password" placeholder="Confirm Password" name="confirm_password" value="<?php echo set_value('confirm_password') ?>" class="form-control">
                                    <img src="<?= base_url() ?>assets/images/icons/repassword.png">
                                </div>
                            </div>
                        </div>
                        <div class="form-group new-add">								
                            <select class="form-control" id="jointeam" name="type">
                                <option value="customer">Customer</option>
                                <option value="vendor">Vendor</option>
                            </select>
                        </div>

                        <div class="company" id="company-form" >
                            <div class="form-group">								
                                <input type="text" placeholder="Company Name" name="company_name" value="<?php echo set_value('company_name') ?>" class="form-control">
                                <img src="<?= base_url() ?>assets/images/icons/building.png">
                            </div>
                            <div class="form-group">								
                                <input type="text" placeholder="GSTIN" name="gstin" value="<?php echo set_value('gstin') ?>" class="form-control">
                                <img src="<?= base_url() ?>assets/images/icons/building.png">
                            </div>
                            <div class="form-group">								
                                <input type="text" placeholder="PAN Number" name="v_pancard_no" value="<?php echo set_value('v_pancard_no') ?>" maxlength="10" class="form-control">
                                <img src="<?= base_url() ?>assets/images/icons/pan-card.png">
                            </div>
                            <div class="form-group">								
                                <select class="form-control" name="service_area">
                                    <option value="">Serviceable Areas</option>
                                    <option value="member">Member</option>
                                    <option value="company">Company</option>
                                </select>
                                <img src="<?= base_url() ?>assets/images/icons/mappin.png">
                            </div>
                        </div>
                        <div class="member" id="member-form">
                            <div class="form-group">								
                                <input type="text" placeholder="PAN Number" name="pancard_no" value="<?php echo set_value('pancard_no') ?>" maxlength="10" class="form-control">
                                <img src="<?= base_url() ?>assets/images/icons/pan-card.png">
                            </div>
                        </div>
                        <button type="submit" class="btn-main btn register-btn">Get Registered <span></span></button>
                        <p>By signing up with Zippy, you agree to <a href="#">Terms and Conditions</a></p>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</section>
