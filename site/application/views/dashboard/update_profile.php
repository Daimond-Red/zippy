<section class="admin-order">
  <div class="container">
    <div class="row">
      <div class="new-order">
        <h1>Update Profile</h1>
      </div>
    </div>
  </div>
</section>

<section class="admin-wrapper">
  <form id="booking" name="booking" method="post" enctype='multipart/form-data'>
  <div id="booking-form" class="container">
      <div class="profile-form">
        <div class="col-md-3 col-lg-3 col-sm-6">
            <div class="profile-img">
              <?php if($userData['image'] != ''){ ?>
              <img src="<?= IMAGEPATH.$userData['image'] ?>">
              <?php }else{ ?>
                <img src="<?= base_url() ?>assets/images/default.jpg" width="200">
              <?php }
              ?>
            </div>
          </div>
        <div class="col-md-9 col-lg-9 col-sm-6">
          <div class="picup-wrap login-form pichup-frm update-profile">
              <?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>
              <?php 
                if(isset($error)){
                  if($error == '1'){
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
                }
                 if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div>
                <?php } ?>
                <?php if ($this->session->flashdata('successs')) { ?>
                    <div class="alert alert-success"> <?= $this->session->flashdata('successs') ?> </div>
                <?php }
              ?>
              <div class="row">
                <input type="hidden" value="<?= $userData['customer_id'] ?>" name="customer_id">
                <div class="col-md-6 col-sm-6">
                  <div class="form-group">                
                    <input type="text" placeholder="First Name" name="first_name" value="<?= $userData['first_name'] ?>" class="form-control">
                    <img src="<?= base_url() ?>assets/images/icons/user.png">
                  </div>
                </div>
                <div class="col-md-6 col-sm-6">
                  <div class="form-group">                
                    <input type="text" placeholder="Last Name" name="last_name" value="<?= $userData['last_name'] ?>" class="form-control">
                    <img src="<?= base_url() ?>assets/images/icons/user.png">
                  </div>
                </div>
              </div>
              <div class="form-group">                
                <input type="text" placeholder="Mobile Number" name="mobile_no" value="<?= $userData['mobile_no'] ?>" size="10" class="form-control">
                <img src="<?= base_url() ?>assets/images/icons/cellphone.png">
              </div>
              <div class="form-group">                
                <input type="text" placeholder="Email Address" name="email" value="<?= $userData['email'] ?>" class="form-control">
                <img src="<?= base_url() ?>assets/images/icons/mail.png">
              </div>

              <div class="member" id="member-form">
                <div class="form-group">                
                  <input type="text" placeholder="PAN Number" value="<?= $userData['pancard_no'] ?>" name="pancard_no" maxlength="10" class="form-control">
                  <img src="<?= base_url() ?>assets/images/icons/id.png">
                </div>
              </div>
              <div class="form-group">                
                <input type="file" name="image" class="form-control">
                <img src="<?= base_url() ?>assets/images/icons/user.png">
              </div>
              <button type="submit"class="btn btn-main">Submit</button>
          </div>
        </div>
          
      </div>
  </div>  
</form>
</section>
