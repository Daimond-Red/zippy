<section class="login">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 col-sm-6">
				<div class="login-wrapper">
					<div class="login-detail">
						<img src="<?= base_url() ?>assets/images/logo.png" alt="logo">
						<h1>Forgot Password</h1>
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
								<input type="email" placeholder="Enter Email" name="email" class="form-control" required>
								<img src="<?= base_url() ?>assets/images/icons/mail.png">
							</div>
							<button type="submit" name="submit" class="btn btn-main">Submit <span></span></button>
							<a href="<?= site_url('login') ?>"><p>Back to Login</p></a>
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