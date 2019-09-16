@extends('layouts.master')

@section('header')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"> Vendors </h3>
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
                    <li class="m-nav__item"><span class="m-nav__link-text">Serviceable Areas</span></li>
                </ul>
            </div>
        </div>
    </div>
@stop

@section('content')

    <div class="row">
        <div class="col-md-4">
            <div class="m-portlet m-portlet--primary m-portlet--brand m-portlet--head-solid-bg" data-portlet="true" id="m_portlet_tools_2">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="la la-map"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Add New
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">

                    {!! Form::open(['route' => ['admin.vendors.storeAreas', $vendorId], 'method' => 'post']) !!}

                    {!! HTML::vselect('base_location', ['' => 'Please select'], null, ['class' => 'form-control select2-ajaxselect', 'data-url' => route('admin.states.search'), 'label' => 'Base Location']) !!}
                    {!! HTML::vselect('drop_locations[]', [], null, ['class' => 'form-control select2-ajaxselect', 'data-url' => route('admin.states.search'), 'label' => 'Drop Locations', 'multiple']) !!}
                    <div class="m-separator m-separator--space m-separator--dashed"></div>

                    <button type="submit" class="btn btn-brand  m-btn m-btn--icon m-btn--wide m-btn--md">
                        <span>
                        <i class="la la-save"></i>
                        <span>Save</span>
                        </span>
                    </button>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="m-portlet m-portlet--primary m-portlet--brand m-portlet--head-solid-bg ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon "><i class="flaticon-grid-menu-v2"></i></span>
                            <h3 class="m-portlet__head-text">Serviceable Areas</h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body table-responsive" >
                    <table class="table table-bordered table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th>Base Location</th>
                            <th>Drop Locations</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(! count($collection) )
                            <tr>
                                <td colspan="50">
                                    <p>No Matching Records Found</p>
                                </td>
                            </tr>
                        @endif
                        @foreach( $collection as $baseStateId => $dropStateIds )
                            <tr>
                                <td>{{ \App\City::getStatesNames($baseStateId) }}</td>
                                <td>{{ \App\City::getStatesNames($dropStateIds) }}</td>
                                <td>

                                    <button
                                            class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                            title="Edit details"
                                            data-title="Edit"
                                            data-toggle="modal" data-target="#edit-{{ $baseStateId }}"
                                    >
                                        <i class="la la-edit"></i>
                                    </button>

                                    <a
                                            data-toggle="m-tooltip"
                                            href="{{ route('admin.vendors.deleteAreas', $baseStateId) }}"
                                            class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete"
                                            title="Delete"
                                    >
                                        <i class="la la-trash"></i>
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @foreach( $collection as $baseStateId => $dropStateIds )
        <div class="modal fade" id="edit-{{$baseStateId}}" tabindex="-1" role="dialog"  style="display: none;" aria-hidden="true">
            {!! Form::open(['route' => ['admin.vendors.updateAreas', $baseStateId, $vendorId], 'method' => 'post']) !!}
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <?php
                            $cities = \App\State::whereIn('id', $dropStateIds)->pluck('title', 'id')->toArray();
                        ?>

                        {!! HTML::vselect('drop_locations[]', $cities, $dropStateIds, ['class' => 'form-control select2-ajaxselect', 'data-url' => route('admin.cities.search'), 'label' => 'Drop Locations', 'multiple', 'id' => 'edit'.$baseStateId ]) !!}
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Address</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    @endforeach

@stop

@section('style')
    <style>
        .m-portlet.m-portlet--head-sm .m-portlet__head {
            height: 6.1rem;

        }
        .m-portlet:hover{
            box-shadow: 0px 3px 20px 0px #bdc3d4;
        }

        .pac-container {
            z-index: 100000;
        }

    </style>
@stop

@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyDC6FU6iM6b6JyG_gHPWjGPfZXWoc1rlLc"></script>
    <script>

        $(document).ready(function(){
            $('.vendor-menu').addClass('m-menu__item--active');
        });
    </script>
@stop