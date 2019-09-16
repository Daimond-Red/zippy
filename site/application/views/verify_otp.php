<section class="login">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 col-sm-6">
				<div class="login-wrapper">
					<div class="login-detail">
						<img src="<?= base_url() ?>assets/images/logo.png" alt="logo">
						<h1>OTP Verify</h1>
					</div>

					<div class="col-md-12 col-sm-12">
						<?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>
						
						<?php if ($this->session->flashdata('error')) { ?>
					        <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div>
					    <?php } ?>
					    <?php if ($this->session->flashdata('success')) { ?>
					        <div class="alert alert-success"> <?= $this->session->flashdata('success') ?> </div>
					    <?php } ?>
					</div>
					<div class="clear"></div>
					<div class="login-form">
						<form method="post">
							<div class="form-group">					
								<input type="hidden" name="mobile_no" value="<?= $mobile_no ?>" class="form-control">			
								<input type="hidden" name="email" value="<?= $email ?>" class="form-control">			
								<input type="text" placeholder="Enter OTP Here" name="otp" class="form-control">
								<img src="<?= base_url() ?>assets/images/icons/lock.png" alt="lock">
							</div>
							<button type="submit" name="verify_otp" class="btn btn-main">Verify <span></span></button>
							<div class="new-user">
								<button class="btn btn-main" name="resend_otp" type="submit">Click to Resend OTP</button>
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