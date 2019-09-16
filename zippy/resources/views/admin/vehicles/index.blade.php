@extends('layouts.master')

@section('header')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"> Vehicles </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ route('admin.dashboard') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator"> - </li>
                    <li class="m-nav__item">
                        <a href="{{ route('admin.vendors.index') }}" class="m-nav__link">
                            <span class="m-nav__link-text">Vendors</span>
                        </a>
                    </li>
                    <li class="m-nav__separator"> - </li>
                    <li class="m-nav__item"><span class="m-nav__link-text">Vehicles</span></li>
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
                    <span class="m-portlet__head-icon "><i class="flaticon-grid-menu-v2"></i></span>
                    <h3 class="m-portlet__head-text">Vehicles</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <button
                            class="m-portlet__nav-link btn btn-light m-btn m-btn--pill m-btn--air dataModel"
                            data-href="{{ route('admin.vehicles.create', $vendor->id) }}"
                            data-title="Add new"
                        >
                            Add New
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body table-responsive" >
            <table class="table table-bordered table-hover table-mobile">
                <thead class="thead-default">
                <tr>
                    <th>#</th>
                    <!--<th>Image</th>-->
                    <th>Registration no</th>
                    <th>Owner name</th>
                    <th>Registration Validity</th>
                    <th>Vehicle Type</th>
                    <!--<th>Vehicle Payload</th>-->
                    <th>GPS</th>
                    <th>No Entry</th>
                    <th>Created On</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $collection as $model )
                    <tr>
                        <td data-label="#" scope="row">{{ $model->id }}</td>
                        <!--<td data-label="Image">
                            <a href="{{ getImageUrl($model->image) }}" class="light-image">
                                <img style="width: 70px; height:70px" src="{{ getImageUrl($model->image) }}" >
                            </a>
                        </td>-->
                        <td data-label="Registration No."> {{ $model->registration_no }} </td>
                        <td data-label="Owner Name"> {{ $model->owner_name }} </td>
                        <td data-label="Reg. Validity"> {{ $model->reg_validity }} </td>
                        <td data-label="Vehicle">
                            @if( isset($model->vehicle_type) && $model->vehicle_type && $model->vehicle_type->title )
                            {{ $model->vehicle_type->title }}
                            @endif
                            </td>
                        </td>
                        <!--<td data-label="Vehicle Payload"> {{ $model->vehicle_payload }} </td>-->
                        <td data-label="GPS">
                            @if (! $model->gpsenabled )
                                <span class="m-badge  m-badge--danger m-badge--wide">No</span>
                            @else
                                <span class="m-badge m-badge--brand m-badge--wide">Yes</span>
                            @endif
                        </td>
                        <td data-label="No Entry">
                            @if (! $model->noentrypermit )
                                <span class="m-badge  m-badge--danger m-badge--wide">No</span>
                            @else
                                <span class="m-badge m-badge--brand m-badge--wide">Yes</span>
                            @endif
                        </td>
                        <td data-label="Created On">{{ date('d/m/Y', strtotime($model->created_at)) }}</td>
                        <td data-label="Action">
                            <span class="">
                                <button
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill dataModel"
                                   title="Edit details"
                                   data-href="{{ route('admin.vehicles.edit', [ 'vendor_id' => $vendor->id, 'driver_id' => $model->id ]) }}"
                                   data-title="Edit"
                                >
                                    <i class="la la-edit"></i>
                                </button>

                                <a
                                    href="{{ route('admin.vehicles.delete', [ 'vendor_id' => $vendor->id, 'driver_id' => $model->id ]) }}"
                                    class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete"
                                    title="Delete"
                                >
                                    <i class="la la-trash"></i>
                                </a>
                            </span>
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
    </style>
@stop

@section('script')
    <script>
        $(document).ready(function(){
            $('.vendor-menu').addClass('m-menu__item--active');
        });
    </script>
@stop