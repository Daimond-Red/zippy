@extends('layouts.master')

@section('header')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"> Booking Details </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ route('admin.dashboard') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator"> - </li>
                    <li class="m-nav__item">
                        <a href="{{route('admin.bookings.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">Bookings</span>
                        </a>
                    </li>
                    <li class="m-nav__separator"> - </li>
                    <li class="m-nav__item"><span class="m-nav__link-text">Booking Details</span></li>
                </ul>
            </div>
        </div>
    </div>
@stop

@section('content')
    <?php
        $customer = $model->customer;
        $vendor = null;

        if( $model->vendor ) $vendor = $model->vendor;

    ?>
    @if(! in_array($model->status, [\App\Booking::COMPLETE, \App\Booking::PENDING]) )
        <div class="row">
            <div class="text-right">
                <button class="m-portlet__nav-link btn btn-light m-btn m-btn--pill m-btn--air dataModel" data-href="{{ route('admin.notification.send', ['id' => $model->id]) }}">Send Notification </button>
            </div>
        </div>
    @endif
    <div class="m-accordion m-accordion--default m-accordion--solid" id="m_accordion_5" role="tablist">

        @include('admin.templates.booking-vendor')

        @if(count($drivers))
           <div class="row main-section">
                <div class="col-md-6">
                    <div class="item">
						@foreach( $drivers as $driver )
							<div>
								@include('admin.templates.booking-driver')
							</div>
						@endforeach
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="item">
                        @foreach(  $vehicles as $vehicle )
                            <div>
                                @include('admin.templates.booking-vehicle')
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @include('admin.templates.booking-details')

        

    </div>


    <div class="modal fade" id="m_modal_1_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

            </div>
        </div>
    </div>

@stop

@section('style')

<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

<style>  

	
        .main-section{
		    background: white;
            padding: 2%;
            margin: 2% 0%;
		    box-shadow: 0 0 2px lightgrey;
	    }
		
        .m-portlet.m-portlet--head-sm .m-portlet__head {
            height: 6.1rem;

        }
        .m-portlet:hover{
            box-shadow: 0px 3px 20px 0px #bdc3d4;
        }
        .m-radio.m-radio--state-primary > span{
            margin-top: 7%;
        }
        .m-portlet .m-portlet__body{
            padding-bottom: 0px;
        }
		
		.owl-carousel .owl-nav {
            display: none;
        }
		
		.owl-carousel .owl-nav.disabled {
            display: none;
        }
		
		.owl-carousel .owl-dot {
            background: none repeat scroll 0 0 lightgrey;
            border-radius: 20px;
            display: inline-block;
            height: 12px;
			margin-left:1%;
            width: 12px;
        }
		
		.owl-carousel .owl-dot.active{
			background:gray;
		}
		
		.owl-dots{
			margin-left:45%;
		}
		
		.modal-body{
			height:60vh;
			overflow-y:auto;
			padding:8px 25px !important;
		}
		
		.m-radio .checkmark, .m-checkbox .checkmark{
			right:0;
			left:unset;
			top:10px;
			height:22px;
			width:22px;
			border-radius:50%;
			border-color:black;
		}
		
		.m-checkbox div{
			display:inline;
		}
		
		.m-checkbox .user-name{
			color:black;
			font-weight:400;
		}
		
		.m-checkbox i{
			padding:2px 5px;
			color: #111c6f;
		}
		
		.m-radio, .m-checkbox{
			padding-left:0;
			border-bottom: 1px solid #e4e4e4;
            padding-bottom: 10px;
			font-size:13px;
		}
		
		.m-radio p, .m-checkbox p{
			margin-bottom:2px;
			font-weight:bold;
		}
         
		.slick-dots{
			text-align:center;
		} 
		 
		.slick-dots button{
			display:none !important;
		}

        .slick-dots .slick-active{
			background:#716aca !important;
		}		
		
		.slick-dots li{
			display:inline-block;
			height:8px;
			width:8px;
			background:lightgrey;
			margin:10% 5px;
			border-radius:100%;
			cursor:pointer;
		}
		
    </style>
@stop

@section('script')
<script type="text/javascript" src="{{ asset('js/slider.js') }}"></script>

<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
 <script>
    $(document).ready(function(){

        $('.booking-menu').addClass('m-menu__item--submenu m-menu__item--open m-menu__item--expanded');

        @if( $model->status == \App\Booking::CANCEL )
            $('.cancelledlist-menu').addClass('m-menu__item--active');
        @elseif( $model->status == \App\Booking::COMPLETE )
            $('.completelist-menu').addClass('m-menu__item--active');
        @elseif( $model->status == \App\Booking::EXPIRED )
            $('.expired-menu').addClass('m-menu__item--active');
        @else 
            $('.bookinglist-menu').addClass('m-menu__item--active');
        @endif
        

        
        $('body').on('click', '#assignVendor', function(){
            pageLoader();
            $.get('{{ route('admin.bookings.assignVendor', ['id' => $model->id]) }}' , function (res) {
                removePageLoader();
                $('#m_modal_1_2 .modal-content').html(res);
                $('#m_modal_1_2').modal('show');
            });

        });

        $('body').on('click', '.select-vendor', function () {

            $('#final-amount').val($(this).data('amount'));

        });

    });
</script>

<script type="text/javascript">
   
	$('.item').slick({
	  slidesToShow: 1,
	  slidesToScroll: 1,
	  autoplay: true,
	  dots: true,
	  arrows: false,
	  autoplaySpeed: 2000,
	});
	
</script>




@stop