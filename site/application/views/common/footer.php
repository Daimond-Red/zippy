<section class="footer">
<div class="container">
  <div class="row">
    <div class="col-md-6 col-sm-6">
      <p>Copyright © 2018 Zippy. All rights reserved.</p>
    </div>
    <div class="col-md-6 col-sm-6">
      <ul class="pull-right">
        <li><a href="#">Terms &amp; Conditions</a></li>
        <li><a href="#">Privacy Policy</a></li>
      </ul>
    </div>
  </div>
</div>
</section>
	<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
	<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
	<script src="<?= base_url() ?>assets/js/wow.min.js"></script>
	<script type="text/javascript">
		new WOW().init();
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#company-form").hide("slow");
			$('#jointeam').change(function(){
				if($('#jointeam').val() == 'customer') {
					$("#member-form").show("slow");
					$("#company-form").hide("slow");
				} else {
					$("#member-form").hide("slow");
					$("#company-form").show("slow");
				} 
			});
			$("#customer").click(function () {
				alert("h");
			});
			
		});
	</script>
<script type="text/javascript">
	<?php
	if ($this->session->flashdata('vendor_register')) { ?>
	$("#vendor_register").modal("show");
	setTimeout(function(){
	$(".close").trigger('click');
	},5000)
	<?php } ?>
</script>
</body>
</html>