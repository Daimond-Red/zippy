@extends('layouts.master')

@section('header')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"> Bookings </h3>
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
                    <li class="m-nav__item"><span class="m-nav__link-text"> Bill </span></li>
                </ul>
            </div>
        </div>
    </div>
@stop

@section('content')

    <div class="m-portlet m-portlet--brand ">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon "><i class="flaticon-grid-menu-v2"></i></span>
                    <h3 class="m-portlet__head-text"> e-Consignment Note </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body" >

            {!! Form::model($model, ['route' => ['admin.bookings.showBillStore', $model->id], 'method' => 'post']) !!}

            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            {!! HTML::vtext('invoice_no', null, ['label' => 'Invoice No']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! HTML::vtext('declared_value', null, ['label' => 'Declared Value']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {!! HTML::vtext('air_way_bill', $model->id, ['label' => 'DWB / GR NO']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! HTML::vtext('eway_bill', null, ['label' => 'EWAY BILL NO.']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {!! HTML::vtext('consignor_gst', null, ['label' => 'CONSIGNOR\'S GST NO']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! HTML::vtext('consignee_gst', null, ['label' => 'CONSIGNEE\'S GST NO']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! HTML::vselect('is_insured', ['No', 'Yes'], null, ['label' => 'Insured']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! HTML::vtext('package', null, ['label' => 'Package']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! HTML::vtext('contact_person', null, ['label' => 'CONTACT PERSON', 'placeholder' => 'Enter Contact Person']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! HTML::vtext('consignee_company', null, ['label' => 'CONSIGNEE COMPANY NAME', 'placeholder' => 'Enter Company Name']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {!! HTML::vtext('contact_person_no', null, ['label' => 'CONTACT MOBILE NUMBER', 'placeholder' => 'Enter Contact Mobile No']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! HTML::vtext('consignor_company', null, ['label' => 'CONSIGNOR COMPANY NAME', 'placeholder' => 'Enter Company Name']) !!}
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {!! HTML::vtext('consignee_name', null, ['label' => 'CONSIGNEE NAME', 'placeholder' => 'Enter Name']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! HTML::vtext('consignee_mobile_no', null, ['label' => 'CONSIGNEE MOBILE NUMBER', 'placeholder' => 'Enter Mobile Number']) !!}
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {!! HTML::vtext('actual_booking_date', null, ['label' => 'Actual Booking Date', 'class' => 'form-control datepicker', 'style' => 'width:220px!important;']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! HTML::vtext('volumetric_weight', null, ['label' => 'Volumetric Weight', 'placeholder' => 'Enter Volumetric Weight']) !!}
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {!! HTML::vtextarea('bill_pickup_address', null, ['label' => 'Pickup Address']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! HTML::vtextarea('bill_drop_address', null, ['label' => 'Drop Address']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {!! HTML::vtextarea('content') !!}
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <table class="table table-bordered m-table m-table--border-metal">
                        <thead>
                        <tr>
                            <th></th>
                            <th>PAID (Rs.)</th>
                            <th>FOD (Rs.)</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td>DKT. Charges</td>
                            <td>{!! Form::text('paid_dkt_charges', null, ['class' => 'form-control']) !!}</td>
                            <td>{!! Form::text('fod_dkt_charges', null, ['class' => 'form-control']) !!}</td>
                        </tr>
                        <tr>
                            <td>Freight</td>
                            <td>{!! Form::text('paid_freight', null, ['class' => 'form-control']) !!}</td>
                            <td>{!! Form::text('fod_freight', null, ['class' => 'form-control']) !!}</td>
                        </tr>
                        <tr>
                            <td>Service Charges</td>
                            <td>{!! Form::text('paid_service_charges', null, ['class' => 'form-control']) !!}</td>
                            <td>{!! Form::text('fod_service_charges', null, ['class' => 'form-control']) !!}</td>
                        </tr>
                        <tr>
                            <td>CGST {{--FOV--}}</td>
                            <td>{!! Form::text('paid_fov', null, ['class' => 'form-control']) !!}</td>
                            <td>{!! Form::text('fod_fov', null, ['class' => 'form-control']) !!}</td>
                        </tr>
                        <tr>
                            <td>SGST {{--COD / FOD--}}</td>
                            <td>{!! Form::text('paid_cod', null, ['class' => 'form-control']) !!}</td>
                            <td>{!! Form::text('fod_cod', null, ['class' => 'form-control']) !!}</td>
                        </tr>
                        <tr>
                            <td>IGST {{-- New field --}}</td>
                            <td>{!! Form::text('paid_igst', null, ['class' => 'form-control']) !!}</td>
                            <td>{!! Form::text('fod_igst', null, ['class' => 'form-control']) !!}</td>
                        </tr>
                        <tr>
                            <td>Misc.</td>
                            <td>{!! Form::text('paid_misc', null, ['class' => 'form-control']) !!}</td>
                            <td>{!! Form::text('fod_misc', null, ['class' => 'form-control']) !!}</td>
                        </tr>
                        {{-- <tr>
                            <td>Sub Total</td>
                            <td>
                                {{ $model->paid_dkt_charges + $model->customer_amount + $model->paid_service_charges + $model->paid_fov + $model->paid_cod + $model->paid_misc
                                 }}
                            </td>
                            <td>
                                {{ $model->fod_dkt_charges + $model->fod_freight + $model->fod_service_charges + $model->fod_fov + $model->fod_cod + $model->fod_misc
                                 }}
                            </td>
                        </tr> --}}
                        <tr>
                            <td>Grand Total</td>
                            
                            <td colspan="2">
                                {{ $model->paid_dkt_charges + $model->paid_freight + $model->paid_service_charges + $model->paid_fov + $model->paid_cod + $model->paid_misc + $model->fod_dkt_charges + $model->fod_freight + $model->fod_service_charges + $model->fod_fov + $model->fod_cod + $model->fod_misc + $model->paid_igst + $model->fod_igst
                                 }}
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="m-widget13__action">
                <button type="submit" class="btn m-btn--air btn-primary">Save</button>
                <button
                        class="btn m-btn--air btn-primary pull-right"
                        style="margin-left: 10px;"
                        onClick="MyWindow=window.open('http://zippy.co.in/dcs-cargo-web.php?booking_id={{ $model->id }}','MyWindow',width=900,height=300); return false;">View Bill</button>
                <button
                        class="btn m-btn--air btn-primary pull-right"
                        onClick="MyWindow=window.open('http://zippy.co.in/dcs-cargo.php?booking_id={{ $model->id }}','MyWindow',width=900,height=300); return false;">View TBB</button>
            </div>
            {!! Form::close() !!}
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
        });
    </script>
@stop