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
                    <li class="m-nav__item"><span class="m-nav__link-text">Vendors</span></li>
                </ul>
            </div>
        </div>
    </div>
@stop

@section('sidebarSearch')
    <form action="{{route('admin.vendors.index')}}" method="GET" id="search-form">

        {!! HTML::vtext('first_name', null, ['label' => 'First Name']) !!}

        {!! HTML::vtext('last_name', null, ['label' => 'Last Name']) !!}

        {!! HTML::vtext('email', null, ['label' => 'Email']) !!}

        {!! HTML::vtext('pancard_no', null, ['label' => 'PAN Card no']) !!}

        {!! HTML::vtext('company_name', null, ['label' => 'Company Name']) !!}

        {!! HTML::vtext('gstin', null, ['label' => 'GSTIN']) !!}

        {{-- {!! HTML::vselect('status', ['' => '', 0 => 'Unverified', 1 => 'Verified'], null, ['label' => 'Status']) !!} --}}

        <input type="submit" value="search" style="display: none">

    </form>
@stop

@section('content')

    <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg ">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon "><i class="flaticon-grid-menu-v2"></i></span>
                    <h3 class="m-portlet__head-text">Vendors</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    {{--<li class="m-portlet__nav-item">--}}
                        {{--<button--}}
                            {{--class="m-portlet__nav-link btn btn-light m-btn m-btn--pill m-btn--air dataModel"--}}
                            {{--data-href="{{ route('admin.vendors.create') }}"--}}
                            {{--data-title="Add new"--}}
                        {{-->--}}
                            {{--Add New--}}
                        {{--</button>--}}
                    {{--</li>--}}
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
            <table class="table table-bordered table-hover table-mobile">
                <thead class="thead-default">
                <tr>
                    <th>#</th>
                    <th>Profile</th>
                    <th>Full name</th>
                    <th>Email</th>
                    <th>MobileNo</th>
                    <th>Overall Rating</th>
                    <th>Account Status</th>
                    <th>Login Access</th>
                    <th>Created On</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $collection as $model )
                    <tr>
                        <td data-label="#" scope="row">{{ $model->id }}</td>
                        <td data-label="Profile">
                            <a href="{{ getImageUrl($model->image) }}" class="light-image">
                                <img style="width: 40px; height:40px" src="{{ getImageUrl($model->image) }}" >
                            </a>
                        </td>
                        <td data-label="First Name">{{ $model->first_name. ' '. $model->last_name  }}</td>
                        <td data-label="Email">{{ $model->email }}</td>
                        <td data-label="Mobile No.">{{ $model->mobile_no }}</td>
                        <td>
                            {{-- rating --}}
                            @if( isset($ratings[$model->id]) )
                                @for( $i = 1; $i <= 5; $i++ )
                                    @if( $i <= $ratings[$model->id] )
                                        <span class="fa fa-star checked"></span>
                                    @else
                                        <span class="fa fa-star"></span>
                                    @endif
                                @endfor
                            @else
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            @endif
                            {{-- ./ rating --}}
                        </td>
                        <td data-label="Account Status">
                            @if (! $model->status )
                                <span class="m-badge  m-badge--danger m-badge--wide">Unverified</span>
                            @else
                                <span class="m-badge m-badge--brand m-badge--wide">Verified</span>
                            @endif
                        </td>
                        <td data-label="Login Access">
                            @if (! $model->is_enable )
                                <span class="m-badge  m-badge--danger m-badge--wide">Disable</span>
                            @else
                                <span class="m-badge m-badge--brand m-badge--wide">Enable</span>
                            @endif
                        </td>
                        <td data-label="Created On">{{ date('d/m/Y', strtotime($model->created_at)) }}</td>
                        <td data-label="Action">
                            <span class="">

                                <a
                                        data-toggle="m-tooltip"
                                        data-original-title="Serviceable Areas"
                                        href="{{ route('admin.vendors.areas', $model->id) }}"
                                        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                >
                                   <i class="la la-map"></i>
                                </a>

                                <a
                                   data-toggle="m-tooltip"
                                   data-original-title="Drivers"
                                   href="{{ route('admin.drivers.index', $model->id) }}"
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                >
                                   <i class="la la-users"></i>
                                </a>
                                <a
                                    data-toggle="m-tooltip"
                                    data-original-title="Vehicle"
                                    href="{{ route('admin.vehicles.index', $model->id) }}"
                                    class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill "
                                >
                                   <i class="la la-truck"></i>
                                </a>
                                <button
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill dataModel"
                                   title="Edit details"
                                   data-toggle="m-tooltip"
                                   data-href="{{ route('admin.vendors.edit', $model->id) }}"
                                   data-title="Edit"
                                >
                                    <i class="la la-edit"></i>
                                </button>

                                <!-- <a
                                    data-toggle="m-tooltip"
                                    href="{{ route('admin.vendors.delete', $model->id) }}"
                                    class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete"
                                    title="Delete"
                                >
                                    <i class="la la-trash"></i> -->
                                </a>
                            </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $collection->appends(request()->all())->links() }}
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