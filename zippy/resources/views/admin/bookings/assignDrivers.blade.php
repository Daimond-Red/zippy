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
                    <li class="m-nav__item">
                        <a href="{{route('admin.bookings.show', $booking->id)}}" class="m-nav__link">
                            <span class="m-nav__link-text">Bookings Details</span>
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
    
    <div class="m-accordion m-accordion--default m-accordion--solid" id="m_accordion_5" role="tablist">
        @include('admin.templates.booking-details', ['model' => $booking])
    </div>
    {!! Form::open(['route' => ['admin.bookings.assignVendorStore', $booking->id], 'method' => 'post', 'id' => 'form-asssign-vendor']) !!}

    <div class="m-portlet m-portlet--bordered m-portlet--bordered-semi m-portlet--rounded">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Vendors
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="m-checkbox-list">

                @foreach( $vendors as $model )
                    <label data-id="{{$model->id}}" class="m-checkbox m-checkbox--bold select-vendor"  @if( isset($biddingAmounts[$model->id]) ) data-amount="{{$biddingAmounts[$model->id]}}" @else data-amount=0 @endif>


                        @if( isset($biddingAmounts[$model->id]) )
                            <p style="color:black;">Bid Amount: {{$biddingAmounts[$model->id]}}</p>
                        @else
                            <p class="text-danger">Not Bid</p>
                        @endif

                        <input type="radio" name="vendor" value="{{$model->id}}" @if( $model->id == $vendor->id ) checked @endif>
                        <div class="user-name"><i class="m-nav__link-icon la la-user"></i>{{ $model->first_name. ' '. $model->last_name }} </div>
                        <div class="user-email"><i class="m-nav__link-icon la la-envelope"></i>{{ $model->email }} </div>
                        <div class="user-phone"><i class="m-nav__link-icon la la-phone"></i>{{ $model->mobile_no }} </div>
                        <span class="checkmark"></span>

                    </label>
                @endforeach

                @if( count($vendors) )
                    <div class="row">
                        <div class="col-md-4">
                            {!! HTML::vtext('amount', null, ['data-validation' => 'required', 'id' => 'final-amount']) !!}
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

        @foreach( $vendors as $vendor )
            <?php
                $drivers = $vendor->drivers()->where('role', \App\User::DRIVER)->get();
                //dd($drivers->toArray());
                $vehicles = $vendor->vehicles;
            ?>
            <div class="driversNVehicles " id="driverNVehicle{{$vendor->id}}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="m-portlet m-portlet--bordered m-portlet--bordered-semi m-portlet--rounded">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            Drivers
                                        </h3>
                                    </div>
                                </div>
                                <div class="m-portlet__head-tools">
                                    <ul class="m-portlet__nav">
                                        <li class="m-portlet__nav-item">
                                            <input type="text" name="" class="form-control m-input  m-input--pill form-control-sm m-input--solid" placeholder="Search..." id="searchDrivers">
                                        </li>                       
                                    </ul>
                                </div>
                            </div>
                            <div class="m-portlet__body">
                                <div class="m-checkbox-list">
                                    @foreach( $drivers as $model )
                                        <label class="m-checkbox m-checkbox--bold driverList"  data-searchText="{{ strtolower(implode('', [$model->first_name, $model->last_name, $model->email, $model->mobile_no])) }}">
                                            <input type="checkbox" name="drivers_{{$vendor->id}}[]" value="{{$model->id}}" @if( in_array($model->id, $assignDriverIds->toArray()) ) checked @endif>
                                            <div class="user-name"><i class="m-nav__link-icon la la-user"></i>{{ $model->first_name. ' '. $model->last_name }} </div>
                                            <div class="user-email"><i class="m-nav__link-icon la la-envelope"></i>{{ $model->email }} </div>
                                            <div class="user-phone"><i class="m-nav__link-icon la la-phone"></i>{{ $model->mobile_no }} </div>
                                            <span class="checkmark"></span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="m-portlet m-portlet--bordered m-portlet--bordered-semi m-portlet--rounded">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            Vehicles
                                        </h3>
                                    </div>
                                </div>
                                <div class="m-portlet__head-tools">
                                    <ul class="m-portlet__nav">
                                        <li class="m-portlet__nav-item">
                                            <input type="text" name="" class="form-control m-input  m-input--pill form-control-sm m-input--solid" placeholder="Search..." id="searchVehicles">
                                        </li>                       
                                    </ul>
                                </div>
                            </div>
                            <div class="m-portlet__body">
                                <div class="m-checkbox-list">
                                    @foreach( $vehicles as $model )
                                        <?php if(! $model->vehicle_type ) continue; ?>
                                        <label class="m-checkbox m-checkbox--bold vehicleList"  data-searchText="{{ strtolower(implode('', [optional($model->vehicle_type)->title, $model->owner_mobile])) }}">

                                            <input type="checkbox" name="vehicles_{{$vendor->id}}[]" value="{{$model->id}}" @if( in_array($model->id, $assignVehicleIds->toArray()) ) checked @endif>

                                            <div class="user-email">
                                                <i class="m-nav__link-icon la la-truck"></i>
                                                <strong>Reg: </strong>{{$model->registration_no}} /
                                                {{ $model->vehicle_type->title }} 
                                            </div>
                                            <div class="user-phone"><i class="m-nav__link-icon la la-phone"></i>{{ $model->owner_mobile }} </div>
                                            <span class="checkmark"></span>

                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    <button type="submit" class="btn btn-primary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
        <span>
        <i class="la la-check"></i>
        <span>Submit</span>
        </span>
    </button>

    {!! Form::close() !!}
@stop

@section('style')
    <style>
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

        .driversNVehicles{
            display: none;
        }
    </style>
@stop

@section('script')
    <script>
        $(document).ready(function () {

            $('body').on('click', '.select-vendor', function () {

                $('#final-amount').val($(this).data('amount'));

                $('.driversNVehicles').hide();
                $('#driverNVehicle'+$(this).data('id')).show();

            });

            $('.select-vendor').click();

            $('body').on('submit', '#form-asssign-vendor',  function(e){

                var noOfVehicle = '{{ $booking->no_of_vehicle }}';

                var vendorId = $('input[name=vendor]:checked').val();

                var actualChecked = $('input[name="drivers_'+vendorId+'[]"]:checked').length;

                if( actualChecked != noOfVehicle ) {
                    e.preventDefault();
                    showErrorMsg('No of vehicle required :' + noOfVehicle + '. Plz Assign drivers & vehicles accordingly');
                }

                var actualChecked = $('input[name="vehicles_'+vendorId+'[]"]:checked').length;

                if( actualChecked != noOfVehicle ) {
                    e.preventDefault();
                    showErrorMsg('No of vehicle required :' + noOfVehicle + '. Plz Assign drivers & vehicles accordingly');
                }

            });

            $('.booking-menu').addClass('m-menu__item--submenu m-menu__item--open m-menu__item--expanded');
            $('.bookinglist-menu').addClass('m-menu__item--active');

            $('body').on('input', '#searchDrivers', function(){
                var search = $('#searchDrivers').val().toLowerCase();

                $('.driverList').hide();

                $('.driverList').each(function(i,v){
                    if( $(this).attr('data-searchText').indexOf(search) >= 0 ){
                        $(this).show();
                    }
                });

            });

            $('body').on('input', '#searchVehicles', function(){
                var search = $('#searchVehicles').val().toLowerCase();

                $('.vehicleList').hide();

                $('.vehicleList').each(function(i,v){
                    if( $(this).attr('data-searchText').indexOf(search) >= 0 ){
                        $(this).show();
                    }
                });

            });

        });
    </script>
@stop