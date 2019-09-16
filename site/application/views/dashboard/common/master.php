<section class="admin-header">
	<div class="container-fluid">
		<div class="row">
			<div class="top-bar">
				<div class="row">
					<div class="col-md-3 col-sm-3">
						<div class="logo">
							<a href="<?= site_url('/dashboard/create_order') ?>"><img src="<?= base_url() ?>assets/images/logo.png" alt="logo.png"></a>

							<!-- <a href="#" type="button" id="sidebarCollapse" class="pull-right"><i class="fa fa-bars"></i></a> -->
						</div>
					</div>
					<div class="col-md-9 col-sm-9 nav-barup">
						 <div class="user pull-right btn">
						 	<i class="fa fa-lg fa-sign-out"></i> <Br>
							<a href="<?= site_url('/dashboard/logout') ?>" class="text-center"> Logout</a>
						</div>
						<div class="user pull-right">
							<a href="<?= site_url('/dashboard/update_profile') ?>"><img src="<?= base_url() ?>assets/images/user.png" alt="user"></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<nav class="navbar navbar-default">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<div class="col-md-9 col-sm-9 nav-barup res-nav">
				 <div class="user pull-right btn">
				 	<i class="fa fa-lg fa-sign-out"></i> <Br>
					<a href="<?= site_url('/dashboard/logout') ?>" class="text-center"> Logout</a>
				</div>
				<div class="user pull-right">
					<a href="<?= site_url('/dashboard/update_profile') ?>"><img src="<?= base_url() ?>assets/images/user.png" alt="user"></a>
				</div>
			</div>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav sidebar side-bar" id="manu">
				<li><a href="<?= site_url('dashboard/create_order') ?>"><img src="<?= base_url() ?>assets/images/location-1.png"> Create new order</a></li>
	          	<li><a href="<?= site_url('dashboard/my_orders') ?>"><img src="<?= base_url() ?>assets/images/location-1.png"> My orders</a></li>
	          	<li><a href="<?= site_url('dashboard/support') ?>"><img src="<?= base_url() ?>assets/images/location-1.png"> Support</a></li>	
			</ul> 
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
<div class="wrapper">
	<!-- Sidebar Holder -->
    <nav id="sidebar">
        <ul class="side-bar">
          	<li><a href="<?= site_url('dashboard/create_order') ?>"><img src="<?= base_url() ?>assets/images/create-order.png"> Create new order</a></li>
          	<li><a href="<?= site_url('dashboard/my_orders') ?>"><img src="<?= base_url() ?>assets/images/my-orders.png"> My orders</a></li>
          	<li><a href="<?= site_url('dashboard/support') ?>"><img src="<?= base_url() ?>assets/images/support.png"> Support</a></li>
        </ul>
    </nav>
	<div id="content">
		<section>
			<?php if ($this->session->flashdata('error')) { ?>
				<div class="row">
					<div class="col-md-12 col-sm-12">
		        		<div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div>
		       		</div>
		       	</div>
		    <?php } ?>
		    <?php if ($this->session->flashdata('success')) { ?>
		    <div class="row">
				<div class="col-md-12 col-sm-12">
		        	<div class="alert alert-success"> <?= $this->session->flashdata('success') ?> </div>
		        </div>
		    </div>
		    <?php } ?>
		</section>
		<?= $content ?>
	</div>
</div>
