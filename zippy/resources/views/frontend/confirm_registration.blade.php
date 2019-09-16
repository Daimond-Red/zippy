<section class="login">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 col-sm-6">
				<div class="login-wrapper">
					<div class="login-detail">
						<img src="{{ getFrontImageUrl('frontend/assets/images/logo.png')}}" alt="logo">
						<h1>Add Mobile Number</h1>
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
							<?php
									if($error == 1){
										foreach($errorData as $err){
											foreach($err as $key => $value){
												echo '<div class="alert alert-danger">';
												echo $value;
												echo '</div>';
											}
										}
									}else{
										if(isset($message)){
											echo '<div class="alert alert-success">';
											echo $message;
											echo '</div>';
										}
									}
								?>
							<?php 
								foreach($userInfo as $key => $value){ 
									if($key != 'mobile_no'){
							?>
									<input type="hidden" name="<?= $key ?>" value="<?= $value ?>" class="form-control">
							<?php
									}
								}
							?>
							<div class="form-group">								
								<input type="text" placeholder="Mobile Number" name="mobile_no" maxlength="10" class="form-control" required>
								<img src="{{ getFrontImageUrl('frontend/assets/images/icons/cellphone.png') }}">
							</div>
							<div class="form-group">								
								<input type="text" placeholder="Pancard No." name="pancard_no" maxlength="10" class="form-control" required>
								<img src="{{ getFrontImageUrl('frontend/assets/images/icons/pan-card.png') }}">
							</div>
							<button type="submit" name="submit" class="btn btn-main">Submit <span></span></button>
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