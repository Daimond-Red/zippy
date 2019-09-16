@extends('layouts.master')

@section('header')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"> Assign Vendor </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ route('admin.dashboard') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator"> - </li>
                    <li class="m-nav__item">
                        <a href="{{route('admin.bookings.pending')}}" class="m-nav__link">
                            <span class="m-nav__link-text">Pending Bookings</span>
                        </a>
                    </li>
                    <li class="m-nav__separator"> - </li>
                    <li class="m-nav__item"><span class="m-nav__link-text">Assign Vendor</span></li>
                </ul>
            </div>
        </div>
    </div>
@stop

@section('content')
    <?php
        $customer = $model->customer;
    ?>

    <div class="m-accordion m-accordion--default m-accordion--solid" id="m_accordion_5" role="tablist">

        <!--begin::Item-->
        <div class="m-accordion__item">
            <div class="m-accordion__item-head" role="tab" id="m_accordion_5_item_1_head" data-toggle="collapse" href="#vendors" aria-expanded="true">
                <span class="m-accordion__item-icon"><i class="fa flaticon-users"></i></span>
                <span class="m-accordion__item-title">Applied Vendors</span>
                <span class="m-accordion__item-mode"><i class="la la-plus"></i></span>
            </div>
            <div class="m-accordion__item-body collapse show" id="vendors" role="tabpanel" aria-labelledby="m_accordion_5_item_1_head" data-parent="#m_accordion_5" style="">
                <span style="width: 100%">
                    {{ Form::open( [ 'route' => ['admin.bookings.assign_vendor_store', $model->id], 'method' => 'POST', 'files' => true ]) }}
                    @if(count($logs) > 0)
                        @foreach( $logs as $log )
                            <?php
                                if(! $log->vendor ) continue;
                                if(! $log->driver ) continue;
                                if(! $log->vehicle ) continue;
                                $vendor = $log->vendor;
                                $driver = $log->driver;
                                $vehicle = $log->vehicle;
                            ?>
                            <label class="m-radio m-radio--state-primary" >

                                <input type="radio" name="id" value="{{$log->id}}">
                                <div class="m-portlet m-portlet--bordered m-portlet--bordered-semi m-portlet--rounded">
                                    <div class="m-portlet__body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="m-widget5">
                                            <div class="m-widget5__item">
                                                <div class="m-widget5__pic">
                                                    <img
                                                        class="m-widget7__img"
                                                        src="{{ getImageUrl($vendor->image) }}"
                                                        alt=""
                                                        style="width: 100px; height:100px"
                                                    >
                                                </div>
                                                <div class="m-widget5__content">
                                                    <h4 class="m-widget5__title">
                                                        {{ ucfirst($vendor->first_name). ' '. $vendor->last_name }}
                                                    </h4>
                                                    <span class="m-widget5__desc">
                                                        Email: {{$vendor->email}} <br>
                                                        Mobile No: {{$vendor->mobile_no}} <br>
                                                        Pancard No: {{$vendor->pancard_no}} <br>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="m-widget5">
                                            <div class="m-widget5__item">
                                                <div class="m-widget5__pic">
                                                    <img
                                                        class="m-widget7__img"
                                                        src="{{ getImageUrl($driver->image) }}"
                                                        alt=""
                                                        style="width: 100px; height:100px"
                                                    >
                                                </div>
                                                <div class="m-widget5__content">
                                                    <h4 class="m-widget5__title">
                                                        {{ ucfirst($driver->name) }}
                                                    </h4>
                                                    <span class="m-widget5__desc">
                                                        Email: {{$driver->email}} <br>
                                                        Mobile No: {{$vendor->mobile}} <br>
                                                        Licence No: {{$vendor->licence_no}} <br>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="m-widget5">
                                            <div class="m-widget5__item">
                                                <div class="m-widget5__pic">
                                                    <img class="m-widget7__img" src="{{ getImageUrl($vehicle->image) }}" alt="">
                                                </div>
                                                <div class="m-widget5__content">
                                                    <h4 class="m-widget5__title">
                                                        {{ $vehicle->registration_no }}
                                                    </h4>
                                                    <span class="m-widget5__desc">
                                                        Owner Name: {{$vehicle->owner_name}} <br>
                                                        Owner Mobile: {{$vehicle->owner_mobile}} <br>
                                                        Owner Pincode: {{$vehicle->owner_pincode}} <br>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span></span>
                            </label>
                        @endforeach
                    @else
                        @foreach($vendorLists as $vendorList)
                        <?php //print_r($vendorList);exit; ?>
                        <label class="m-radio m-radio--state-primary" style="width: 100%">

                                <input type="radio" name="vendor_id" value="{{ $vendorList['id'] }}">
                                <div class="m-portlet m-portlet--bordered m-portlet--bordered-semi m-portlet--rounded">
                                    <div class="m-portlet__body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="m-widget5">
                                            <div class="m-widget5__item">
                                                <div class="m-widget5__pic">
                                                    <img
                                                        class="m-widget7__img"
                                                        src="{{ getImageUrl($vendorList['image']) }}"
                                                        alt=""
                                                        style="width: 100px; height:100px"
                                                    >
                                                </div>
                                                <div class="m-widget5__content">
                                                    <h4 class="m-widget5__title">
                                                        {{ ucfirst($vendorList['first_name']). ' '. $vendorList['last_name'] }}
                                                    </h4>
                                                    <span class="m-widget5__desc">
                                                        Email: {{$vendorList['email']}} <br>
                                                        Mobile No: {{$vendorList['mobile_no']}} <br>
                                                        Pancard No: {{$vendorList['pancard_no']}} <br>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="m-widget5">
                                            <div class="m-widget5__item">
                                                <div class="m-widget5__pic">
                                                </div>
                                                <div class="m-widget5__content">
                                                    <h4 class="m-widget5__title">
                                                    </h4>
                                                    <span class="m-widget5__desc">
                                                        <label for="driver_id_{{$vendorList['id']}}" class="form-control-label">Select Driver</label>
                                                    <select id="driver_id_{{$vendorList['id']}}" class="form-control" name="driver_id_{{$vendorList['id']}}">
                                                        @foreach($vendorList['drivers'] as $driver)
                                                        <option value="{{ @$driver['id'] }}">{{ @$driver['name'] . ' ( ' . @$driver['licence_no'] . ' ) ' }}</option>
                                                        @endforeach
                                                    </select>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="m-widget5">
                                            <div class="m-widget5__item">
                                                <div class="m-widget5__pic">
                                                </div>
                                                <div class="m-widget5__content">
                                                    <h4 class="m-widget5__title">
                                                    </h4>
                                                    <span class="m-widget5__desc">
                                                        <label for="vehicle_id_{{$vendorList['id']}}" class="form-control-label">Select Vehicle</label>
                                                    <select id="vehicle_id_{{$vendorList['id']}}" class="form-control" name="vehicle_id_{{$vendorList['id']}}">
                                                        @foreach($vendorList['vehicles'] as $vehicle)
                                                        <option value="{{ @$vehicle['id'] }}">{{ @$vehicle['owner_name'] . ' ( ' . $vehicle['owner_mobile'] .' ) '}}</option>
                                                        @endforeach
                                                    </select>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span></span>
                            </label>
                        @endforeach
                    @endif
                        <div class="m-widget13__action">
                            <button type="submit" class="btn m-btn--pill m-btn--air btn-primary">
                                Assign
                            </button>
                            <a href="{{ route('admin.bookings.pending') }}" class="btn m-btn--pill    btn-secondary">
                                Cancel
                            </a>
                        </div>

                    {{ Form::close() }}
                </span>
            </div>
        </div>
        <!--end::Item-->

        @include('admin.templates.booking-details')

        @include('admin.templates.booking-customer')

    </div>


@stop

@section('style')
    <style>
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
    </style>
@stop

@section('script')
    <script>
        $(document).ready(function(){
            $('.booking-menu').addClass('m-menu__item--submenu m-menu__item--open m-menu__item--expanded');
            $('.pendingbooking-menu').addClass('m-menu__item--active');
        });
    </script>
@stop