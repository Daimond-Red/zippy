<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title> Admin Configurations </title>
    <!-- Bootstrap core CSS-->
    {{ HTML::style('media/front/push_asset/vendor/bootstrap/css/bootstrap.min.css') }}
    <!-- Custom fonts for this template-->
    {{ HTML::style('media/front/push_asset/vendor/font-awesome/css/font-awesome.min.css') }}
    <!-- Page level plugin CSS-->
    {{ HTML::style('media/front/push_asset/vendor/datatables/dataTables.bootstrap4.css') }}
    <!-- Custom styles for this template-->
    {{ HTML::style('media/front/push_asset/css/sb-admin.css') }}

    {{ HTML::style('media/front/global/plugins/bootstrap-toastr/toastr.min.css') }}
    {{ HTML::style('media/front/global/plugins/bootstrap-sweetalert/sweetalert.css') }}

    <link rel="shortcut icon" type="image/png" href="{{ asset('fav.png') }}"/>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="{{route('admin.dashboard')}}">Admin Configurations</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        @include('configurations.layouts.menu')
        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.dashboard')}}">
                    <i class="fa fa-fw fa-sign-out"></i>Back To Dashboard</a>
            </li>
        </ul>
    </div>
</nav>
<div class="content-wrapper">
    <div class="container-fluid">