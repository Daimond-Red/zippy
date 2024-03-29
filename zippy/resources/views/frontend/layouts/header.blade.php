<header>
	<nav class="navbar navbar-secondary">
	  <div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand" href="#"><img src="{{ getFrontImageUrl('frontend/assets/images/logo.png') }}" alt="logo"></a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		  <ul class="nav navbar-nav">
			<li class="active"><a href="{{ route('frontend.booking') }}">Book Now<span class="sr-only">(current)</span></a></li>
			<li class="active"><a href="{{ route('frontend.my_booking') }}">My Bookings <span class="sr-only">(current)</span></a></li>
			<li><a href="{{ route('frontend.vehicle_types') }}">Vehicle Types</a></li>
			<li><a href="{{ route('frontend.trade_definition') }}">Trade Defination</a></li>
		  </ul>
		</div><!-- /.navbar-collapse -->
		 <ul class="nav navbar-nav navbar-right">
			<li><a href="#"><i class="fa fa-bell-o" aria-hidden="true"></i></a></li>
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i><span class="caret"></span></a>
			  <ul class="dropdown-menu">
				<li><a href="{{ route('frontend.profile') }}">My Profile</a></li>
				<li><a href="{{ route('frontend.signoutCustomer') }}" id="header-logout">Logout</a></li>
			  </ul>
			</li>
		  </ul>
	  </div><!-- /.container-fluid -->
    </nav>
</header>