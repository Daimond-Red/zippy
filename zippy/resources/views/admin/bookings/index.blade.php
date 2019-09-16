@extends('layouts.master')

@section('header')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"> Bookings</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ route('admin.dashboard') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator"> - </li>
                    <li class="m-nav__item"><span class="m-nav__link-text"> Bookings </span></li>
                </ul>
            </div>
        </div>
    </div>
@stop

@section('sidebarSearch')
    <form action="{{route('admin.bookings.index')}}" method="GET" id="search-form">

        {!! HTML::vselect('customer_id', ['Please select...'], null, ['label' => 'Customer', 'id' => 'customer-select']) !!}

        {!! HTML::vselect('vendor_id', ['Please select...'], null, ['label' => 'Vendor', 'id' => 'vendor-select']) !!}

        {!! HTML::vselect('status', [ \App\Booking::ACCEPT => 'Accept', \App\Booking::PROCESS => 'In Transit', \App\Booking::COMPLETE => 'Completed'], null) !!}

        <div id="m_datepicker_5" class="input-daterange">
            {!! HTML::vtext('start', null, ['label' => 'Bookings From Date']) !!}
            {!! HTML::vtext('end', null, ['label' => 'Bookings From To']) !!}
        </div>


        <input type="submit" value="search" style="display: none">

    </form>
@stop

@section('content')

    <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg ">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon "><i class="flaticon-grid-menu-v2"></i></span>
                    <h3 class="m-portlet__head-text"> Bookings </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <button
                                id="m_quick_sidebar_toggle"
                                class="m-portlet__nav-link btn btn-light m-btn m-btn--pill m-btn--air"
                        >
                            Search
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body table-responsive" >
            <table class="table table-sm table-bordered table-hover table-mobile">
                <thead class="thead-default">
                <tr>
                    <th>#</th>
                    {{-- <th>Customer</th> --}}
                    <th>Type</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Vehicle Type</th>

                    <th>Status</th>
                    <th>Created On</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $collection as $model )
                    <?php
                    if(! $model->customer ) continue;
                    $customer = $model->customer;
                    ?>
                    <tr>
                        <td data-label="#" scope="row">{{ $model->id }}</td>
                        {{-- <td>
                            <a href="{{ getImageUrl($model->customer->image) }}" class="light-image">
                                <img
                                        style="width: 50px; height:50px"
                                        src="{{ getImageUrl($model->customer->image) }}"
                                >
                            </a>

                        </td> --}}
                        <td data-label="Type">
                            @if( $model->type == \App\Booking::TYPE_INTRA )
                                <span class="m-badge m-badge--warning m-badge--wide">Intra</span>
                            @else
                                <span class="m-badge m-badge--primary m-badge--wide">Inter</span>
                            @endif
                        </td>
                        <td data-label="From">{{ \App\City::getCitiesNames($model->pickup_city_id) }}</td>
                        <td data-label="To">{{ \App\City::getCitiesNames($model->drop_city_id) }}</td>
                        <td data-label="Vehicle">
                            @if( isset($model->vehicle_type) && $model->vehicle_type && $model->vehicle_type->title )
                            {{ $model->vehicle_type->title }}
                            @endif
                            </td>
                        </td>
                        <td data-label="Status">
                            <span class="m-badge m-badge--primary m-badge--wide" >{{ $model->booking_status->title  }}</span>
                        </td>
                        <td data-label="Created On">{{ date('d/m/Y H:i', strtotime($model->created_at)) }}</td>
                        <td data-label="Action">
                            <span class="dropdown">
                                <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                                  <i class="la la-ellipsis-h"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('admin.bookings.show', $model->id) }}"><i class="la la-edit"></i> View Details </a>
                                    <a class="dropdown-item" href="{{ route('admin.bookings.showBill', $model->id) }}"><i class="la la-print"></i> Bills Details</a>
                                    @if( \App\Booking::checkBeforeBookingLiveStatus($model->status) )
                                        <a class="dropdown-item confirmModel" href="{{ route('admin.bookings.cancelBooking', $model->id) }}"><i class="la la-trash"></i> Cancel Booking</a>
                                    @endif
                                </div>
                            </span>
                            {{--<a href="{{ route('admin.bookings.show', $model->id) }}" class="btn m-btn--pill m-btn--air btn-primary btn-sm">--}}
                                {{--Details--}}
                            {{--</a>--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

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
        .select2-container{
            display: block;
        }
        .input-daterange input {
             text-align: left;
        }
    </style>
@stop

@section('script')
    <script>
        $(document).ready(function(){
            $('.booking-menu').addClass('m-menu__item--submenu m-menu__item--open m-menu__item--expanded');
            $('.bookinglist-menu').addClass('m-menu__item--active');

            $("#customer-select").select2({
                width: "off",
                ajax: {
                    url: "{{route('admin.customers.search')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function(data, page) {
                        return {
                            results: data.items
                        };
                    },
                    cache: true
                }
            });

            $("#vendor-select").select2({
                width: "off",
                ajax: {
                    url: "{{route('admin.vendors.search')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function(data, page) {
                        return {
                            results: data.items
                        };
                    },
                    cache: true
                }
            });

            $('#m_datepicker_5').datepicker({
                todayHighlight: true,
                format:'yyyy-mm-dd',
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            });

        });
    </script>
@stop