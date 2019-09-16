<!DOCTYPE html>
<html lang="en" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title> Zippy - Admin Panel </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->
    <!--begin::Base Styles -->
    <!--begin::Page Vendors -->
    <link href="{{ asset('assets/vendors/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors -->
    <link href="{{ asset('assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />

    <!--end::Base Styles -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/app/media/img//logos/fab_icon_zippy.png') }}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.4/jquery.fancybox.min.css">

    @yield('style')
    <style>
        .clickable-row {
            cursor: pointer;
        }
        .select2-container{
            display: block;
            width: 100% !important;
        }
		
		table span{
			white-space:nowrap;
		}
		
		@media only screen and (max-device-width:767px){
			
			.m-portlet .m-portlet__body{
				padding:5px !important;
			}
			
			.m-portlet .m-portlet__head {
				padding: 0 0.5rem !important;
			}
			
			.table-mobile .customer-info img{
				float:inherit !important;
				width:20px !important;
				height:20px !important;
			}

			.table-mobile, .table-mobile thead, .table-mobile tbody, .table-mobile th, .table-mobile td, .table-mobile tr {
				display: block;
			}


			.table-mobile thead tr {
				position: absolute;
				top: -9999px;
				left: -9999px;
			}

			.table-mobile tr {
				border: 1px solid #ccc;
				margin-top:5px;
				padding:10px;
			}

			.table-mobile tr:nth-of-type(odd){
				background:#efefef;
			}

			.table-mobile td {
				border: none;
				border-bottom: 1px solid #eee;
				position: relative;
				padding-left: 20% !important;
				text-align:right;
				min-height:28px;
				font-size:12px;
			}

			.table-mobile td:before{
				content:attr(data-label);
				position: absolute;
				top: 6px;
				left: 6px;
				width: 45%;
				padding-right: 10px;
				white-space: nowrap;
				text-align:left;
				font-weight:500;
			}
			
			.btn.m-btn--custom{
				margin:10px;
			}

		}
    </style>
</head>
<!-- end::Head -->
<!-- end::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <!-- BEGIN: Header -->
    <header class="m-grid__item    m-header "  data-minimize-offset="200" data-minimize-mobile-offset="200" >
        <div class="m-container m-container--fluid m-container--full-height">
            <div class="m-stack m-stack--ver m-stack--desktop">
                <!-- BEGIN: Brand -->
                <div class="m-stack__item m-brand  m-brand--skin-dark ">
                    <div class="m-stack m-stack--ver m-stack--general">
                        <div class="m-stack__item m-stack__item--middle m-brand__logo">
                            <a href="{{ route('admin.dashboard') }}" class="m-brand__logo-wrapper">
                                <img alt="" src="{{ asset('assets/demo/default/media/img/logo/logo_default_dark.png') }}"/>
                            </a>
                        </div>
                        <div class="m-stack__item m-stack__item--middle m-brand__tools">
                            <!-- BEGIN: Left Aside Minimize Toggle -->
                            <a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block
					 ">
                                <span></span>
                            </a>
                            <!-- END -->
                            <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                            <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                                <span></span>
                            </a>
                            <!-- END -->
                            <!-- BEGIN: Responsive Header Menu Toggler -->
                            <!--<a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                                <span></span>
                            </a>-->
                            <!-- END -->
                            <!-- BEGIN: Topbar Toggler -->
                            <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                                <i class="flaticon-more"></i>
                            </a>
                            <!-- BEGIN: Topbar Toggler -->
                        </div>
                    </div>
                </div>
                <!-- END: Brand -->
                <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                    <!-- BEGIN: Horizontal Menu -->
                    <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn">
                        <i class="la la-close"></i>
                    </button>


                    <!-- END: Horizontal Menu -->								<!-- BEGIN: Topbar -->
                    <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                        <div class="m-stack__item m-topbar__nav-wrapper">
                            <ul class="m-topbar__nav m-nav m-nav--inline">

                                <li class="m-nav__item m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center m-dropdown--mobile-full-width m-dropdown--skin-light m-list-search m-list-search--skin-light m-list-search--has-result" data-dropdown-toggle="click" data-dropdown-persistent="true" id="m_quicksearch" data-search-type="dropdown" aria-expanded="true">
                                            <a href="#" class="m-nav__link m-dropdown__toggle" id="globalSearch">
                                                <span class="m-nav__link-icon">
                                                    <i class="flaticon-search-1"></i>
                                                </span>
                                            </a>
                                        </li>
                                        
                                <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" data-dropdown-toggle="click">
                                </li>
                            </ul>
                            <a href="{{ route('logout') }}"
                               class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder"
                               onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                    <!-- END: Topbar -->
                </div>
            </div>
        </div>
    </header>
    <!-- END: Header -->
    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        <!-- BEGIN: Left Aside -->
        <button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
            <i class="la la-close"></i>
        </button>
        <div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
            <!-- BEGIN: Aside Menu -->
            <div
                    id="m_ver_menu"
                    class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark "
                    data-menu-vertical="true"
                    data-menu-scrollable="false" data-menu-dropdown-timeout="500"
            >

                @include('layouts.menu')

            </div>
            <!-- END: Aside Menu -->
        </div>
        <!-- END: Left Aside -->
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <!-- BEGIN: Subheader -->
            @yield('header')

            <!-- END: Subheader -->
            <div class="m-content">