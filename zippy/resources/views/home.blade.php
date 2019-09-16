@extends('layouts.master')

@section('header')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"> Dashboard </h3>
            </div>
        </div>
    </div>
@stop

@section('content')

    <div id="dashboard-content">
        <div class="row">
            <div class="col-6 col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-primary o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="m-menu__link-icon flaticon-users"></i>
                        </div>
                        <div class="mr-5">{{$customer_count}} Customers!</div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="{{route('admin.customers.index')}}">
                        <span class="float-left">View Details</span>
                        <span class="float-right">
                    <i class="fa fa-angle-right"></i>
                  </span>
                    </a>
                </div>
            </div>
            <div class="col-6 col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-warning o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="flaticon-truck"></i>
                        </div>
                        <div class="mr-5">{{$vendor_count}} Vendors!</div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="{{ route('admin.vendors.index') }}">
                        <span class="float-left">View Details</span>
                        <span class="float-right">
                    <i class="fa fa-angle-right"></i>
                  </span>
                    </a>
                </div>
            </div>
            <div class="col-6 col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-success o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="flaticon-route"></i>
                        </div>
                        <div class="mr-5">{{$ongoing_booking_count}} Live Trip!</div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="{{route('admin.bookings.index')}}">
                        <span class="float-left">View Details</span>
                        <span class="float-right">
                    <i class="fa fa-angle-right"></i>
                  </span>
                    </a>
                </div>
            </div>
            <div class="col-6 col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-danger o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="flaticon-route"></i>
                        </div>
                        <div class="mr-5">{{$pending_booking_count}} Business Inquiries!</div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="{{ route('admin.bookings.pending') }}">
                        <span class="float-left">View Details</span>
                        <span class="float-right">
                    <i class="fa fa-angle-right"></i>
                  </span>
                    </a>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Business Inquiries
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="{{ route('admin.bookings.pending') }}" class="m-portlet__nav-link btn m-btn--pill m-btn--air btn-primary">
                                        View All
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body table-responsive">
                        <table class="table table-sm table-bordered table-hover table-mobile">
                            <thead class="thead-default">
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Type</th>
                                <th>From</th>
                                <th>To</th>
                                {{--<th>Cargo Type</th>--}}
                                <th>Vehicle Type</th>
                                {{--<th>Vehicle Category</th>--}}
                                {{--<th>Distance({{distanceSign()}}.)</th>--}}
                                {{--<th>Amount(₹)</th>--}}
                                <th>Created On</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $pending_bookings as $model )
                                <?php
                                if(! $model->customer ) continue;
                                $customer = $model->customer;
                                ?>
                                <tr>
                                    <td data-label="#" scope="row">{{ $model->id }}</td>
                                    <td data-label="Customer">
                                        <a href="{{ getImageUrl($model->customer->image) }}" class="light-image">
                                            <img style="width: 40px; height:40px" src="{{ getImageUrl($model->customer->image) }}" >
                                        </a>
                                    </td>
                                    <td data-label="Type">
                                        @if( $model->type == \App\Booking::TYPE_INTRA )
                                            <span class="m-badge m-badge--warning m-badge--wide">Intra</span>
                                        @else
                                            <span class="m-badge m-badge--primary m-badge--wide">Inter</span>
                                        @endif
                                    </td>
                                    <td data-label="From">{{ \App\City::getCitiesNames($model->pickup_city_id) }}</td>
                                    <td data-label="To">{{ \App\City::getCitiesNames($model->drop_city_id) }}</td>
                                    {{--<td>--}}
                                        {{--@if( isset($model->cargo_type) && $model->cargo_type && $model->cargo_type->title )--}}
                                            {{--{{ $model->cargo_type->title }}--}}
                                        {{--@endif--}}
                                    {{--</td>--}}
                                    <td data-label="Vehicle Type">
                                        @if( isset($model->vehicle_type) && $model->vehicle_type && $model->vehicle_type->title )
                                            {{ $model->vehicle_type->title }}
                                        @endif
                                    </td>
                                    {{--<td>--}}
                                        {{--@if( isset($model->vehicle_category) && $model->vehicle_category && $model->vehicle_category->title )--}}
                                            {{--{{ $model->vehicle_category->title }}--}}
                                        {{--@endif--}}
                                    {{--</td>--}}
                                    {{--<td>{{ $model->total_distance. distanceSign() }}</td>--}}
                                    {{--<td>{{ currencySign(). $model->total_amount }}</td>--}}
                                    <td data-label="Created On">{{ date('d/m/Y', strtotime($model->created_at)) }}</td>
                                    <td data-label="Action">

                                        @if( $model->type == \App\Booking::TYPE_INTER )
                                            @if( $model->biddings->count() )
                                                <a title="Manual assign vendor" href="{{route('admin.bookings.custom_assign_vendor', $model->id)}}" class="btn m-btn--pill m-btn--air btn-info btn-sm">
                                                    Assign Vendor
                                                    <span class="m-badge m-badge--danger">
                                            {{$model->biddings->count()}}
                                        </span>
                                                </a>
                                            @else
                                                <a title="Manual assign vendor" href="{{route('admin.bookings.custom_assign_vendor', $model->id)}}" class="btn m-btn--pill m-btn--air btn-info btn-sm">
                                                    Assign Vendor
                                                    <span class="m-badge m-badge--danger">0</span>
                                                </a>
                                            @endif
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

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Latest Customer
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="{{ route('admin.customers.index') }}" class="m-portlet__nav-link btn m-btn--pill m-btn--air btn-primary">
                                        View All
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body table-responsive">
                        <table class="table table-bordered table-hover table-mobile">
                            <thead class="thead-default">
                            <tr>
                                <th>#</th>
                                <th>Profile</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Email</th>
                                <th>MobileNo</th>
                                <th>Account Status</th>
                                <th>Signup Type</th>
                                <th>Created On</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $latest_customers as $model )
                                <tr>
                                    <td data-label="#" scope="row">{{ $model->id }}</td>
                                    <td data-label="Profile">
                                        <a href="{{ getImageUrl($model->image) }}" class="light-image">
                                            <img style="width: 40px; height:40px" src="{{ getImageUrl($model->image) }}" >
                                        </a>
                                    </td>
                                    <td data-label="First Name">{{ $model->first_name }}</td>
                                    <td data-label="Last Name">{{ $model->last_name }}</td>
                                    <td data-label="Email">{{ $model->email }}</td>
                                    <td data-label="Mobile No.">{{ $model->mobile_no }}</td>
                                    <td data-label="Account Status">
                                        @if (! $model->status )
                                            <span class="m-badge  m-badge--danger m-badge--wide">Unverified</span>
                                        @else
                                            <span class="m-badge m-badge--brand m-badge--wide">Verified</span>
                                        @endif
                                    </td>
                                    <td data-label="Signup Type">
                                        @if( $model->signup_type == 'normal' )
                                            <span class="m-badge m-badge--metal m-badge--wide">Normal</span>
                                        @elseif( $model->signup_type == 'facebook' )
                                            <span class="m-badge m-badge--primary m-badge--wide">Facebook</span>
                                        @elseif( $model->signup_type == 'gplus' )
                                            <span class="m-badge m-badge--danger m-badge--wide">Google</span>
                                        @endif
                                    </td>
                                    <td data-label="Created On">{{ date('d/m/Y', strtotime($model->created_at)) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Latest Vendors
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="{{ route('admin.vendors.index') }}" class="m-portlet__nav-link btn m-btn--pill m-btn--air btn-primary">
                                        View All
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body table-responsive">
                        <table class="table table-bordered table-hover table-mobile">
                            <thead class="thead-default">
                            <tr>
                                <th>#</th>
                                <th>Profile</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Email</th>
                                <th>MobileNo</th>
                                <th>Account Status</th>
                                <th>Created On</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $latest_vendors as $model )
                                <tr>
                                    <td data-label="#" scope="row">{{ $model->id }}</td>
                                    <td data-label="Profile">
                                        <a href="{{ getImageUrl($model->image) }}" class="light-image">
                                            <img style="width: 40px; height:40px" src="{{ getImageUrl($model->image) }}" >
                                        </a>
                                    </td>
                                    <td data-label="First Name">{{ $model->first_name }}</td>
                                    <td data-label="Last Name">{{ $model->last_name }}</td>
                                    <td data-label="Email">{{ $model->email }}</td>
                                    <td data-label="Mobile No.">{{ $model->mobile_no }}</td>
                                    <td data-label="Account Status">
                                        @if (! $model->status )
                                            <span class="m-badge  m-badge--danger m-badge--wide">Unverified</span>
                                        @else
                                            <span class="m-badge m-badge--brand m-badge--wide">Verified</span>
                                        @endif
                                    </td>
                                    <td data-label="Created On">{{ date('d/m/Y', strtotime($model->created_at)) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function(){
            $('.dashboard-menu').addClass('m-menu__item--active');

            setInterval( function(){
                $.get('{{ route('admin.dashboard') }}', function(data){

                    //create jquery object from the response html
                    var $response=$(data);

                    //query the jq object for the values
                    var elements = [
                        '#dashboard-content',
                        '.pendingbooking-menu',
                    ];

                    for ( var i = 0;  i < elements.length; i++ ) {
                        var dataToday = $response.find(elements[i]).html();
                        $(elements[i]).html(dataToday);
                    }

                    init();

                });
            }, 20000);

        });
    </script>
@stop