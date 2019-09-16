@extends('layouts.master')

@section('header')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"> Business Inquiries</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ route('admin.dashboard') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator"> - </li>
                    <li class="m-nav__item"><span class="m-nav__link-text">Business Inquiries</span></li>
                </ul>
            </div>
        </div>
    </div>
@stop

@section('content')

    <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg ">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon "><i class="flaticon-route"></i></span>
                    <h3 class="m-portlet__head-text">Business Inquiries</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body table-responsive" >
            <table class="table table-sm table-bordered table-hover table-mobile">
                <thead class="thead-default">
                <tr>
                    <th>#</th>
                    {{-- <th>Customer</th> --}}
                    <th>Type</th>
                    {{-- <th>Pickup</th> --}}
                    <th>From</th>
                    <th>To</th>
                    <th>Weight(MT)</th>
                    {{--<th>Cargo Type</th>--}}
                    <th>Vehicle Type</th>
                    <th>Payment</th>
                    {{--<th>Vehicle Category</th>--}}
                    {{--<th>Distance({{distanceSign()}}.)</th>--}}
                    {{--<th>Amount(₹)</th>--}}
                    <th>Created On</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @if( isset( $collection ) && count($collection) )
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
                            {{-- <td>
                                <p class="text-primary">{{ getDateTimeValue($model->pickup_datetime, 'd/m/Y g:i A') }}</p>
                            </td> --}}
                            <td data-label="From">{{ \App\City::getCitiesNames($model->pickup_city_id) }}</td>
                            <td data-label="To">{{ \App\City::getCitiesNames($model->drop_city_id) }}</td>
                            <td data-label="Weight(MT)"> {{ $model->actual_gross_weight }} </td>
                            {{--<td>--}}
                                {{--@if( isset($model->cargo_type) && $model->cargo_type && $model->cargo_type->title )--}}
                                    {{--{{ $model->cargo_type->title }}--}}
                                {{--@endif--}}
                            {{--</td>--}}
                            <td data-label="Vehicle">
                            @if( isset($model->vehicle_type) && $model->vehicle_type && $model->vehicle_type->title )
                            {{ $model->vehicle_type->title }}
                            @endif
                            </td>
                            <td data-label="Payment">
                                <span class="m-badge m-badge--success m-badge--wide">
                                    {{ optional($model->paymentType)->title }}
                                </span>
                            </td>
                            {{--<td>--}}
                            {{--@if( isset($model->vehicle_category) && $model->vehicle_category && $model->vehicle_category->title )--}}
                            {{--{{ $model->vehicle_category->title }}--}}
                            {{--@endif--}}
                            {{--</td>--}}
                            {{--<td>{{ $model->total_distance. distanceSign() }}</td>--}}
                            {{--<td>{{ currencySign(). $model->total_amount }}</td>--}}
                            <td data-label="Created On">{{ date('d/m/Y H:i', strtotime($model->created_at)) }}</td>
                            <td data-label="Action">



                                @if( $model->type == \App\Booking::TYPE_INTER )
                                    <a data-toggle="tooltip" title="Assign Vendor" href="{{route('admin.bookings.custom_assign_vendor', $model->id)}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill">
                                        <i class="la la-check-circle-o"></i>
                                        <span class="check-badge m-badge m-badge--danger"> {{ $model->biddings()->count() }} </span>
                                    </a>
                                    <button
                                        data-toggle="tooltip"
                                        title="Bid On this Booking"
                                        href="{{route('admin.bookings.custom_assign_vendor', $model->id)}}"
                                        class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill dataModel"
                                        data-href="{{ route('admin.bookings.bid', ['id' => $model->id]) }}"
                                        data-title="Bid On This Booking"
                                    >
                                        <i class="la la-commenting-o"></i>
                                    </button>
                                @else
                                    @if( isset($vendors_count[$model->id]) )
                                        <a title="Request accepted assign vendor" href="{{route('admin.bookings.assign_vendor', $model->id)}}" class="btn m-btn--pill m-btn--air btn-primary btn-sm">
                                            Assign Vendor
                                            <span class="m-badge m-badge--danger">{{$vendors_count[$model->id]}}</span>
                                        </a>
                                    @else
                                        <a title="Manual assign vendor" href="{{route('admin.bookings.custom_assign_vendor', $model->id)}}" class="btn m-btn--pill m-btn--air btn-info btn-sm">
                                            Assign Vendor
                                            <span class="m-badge m-badge--danger">0</span>
                                        </a>
                                    @endif
                                @endif

                                <a title="Cancel Booking" 
                                    href="{{route('admin.bookings.markBookingCancel', $model->id)}}" 
                                    class="btn m-btn--pill m-btn--air btn-info btn-sm"
                                >
                                    Cancel Booking
                                </a>
                                <a class="btn m-btn--pill m-btn--air btn-info btn-sm" 
                                    href="{{ route('admin.bookings.show', $model->id) }}"

                                    >
                                    View Details 
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="50" style="text-align: center">No matching records found</td>
                    </tr>
                @endif

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
		
		.check-badge{
			margin-left: 17px;
            margin-top: -5px;
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