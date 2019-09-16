@extends('layouts.master')

@section('header')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"> Dashboard Text </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ route('admin.dashboard') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator"> - </li>
                    <li class="m-nav__item"><span class="m-nav__link-text">Dashboard Text</span></li>
                </ul>
            </div>
        </div>
    </div>
@stop

@section('content')

    <div class="m-portlet m-portlet--bordered m-portlet--bordered-semi m-portlet--rounded">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Dashboard Text
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">

            {!! Form::open(['route' => 'admin.dashboardText', 'method' => 'post']) !!}

                {!! Form::textarea('customer_dashboard_text', $customer_dashboard_text, ['class' => 'form-control']) !!}

                <div class="m-form__actions">
                    <br>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

            {!! Form::close() !!}

        </div>
    </div>

@stop

@section('script')
    <script>
        $(document).ready(function(){
            $('.master-menu').addClass('m-menu__item--submenu m-menu__item--open m-menu__item--expanded');
            $('.dashboardText-menu').addClass('m-menu__item--active');
        });
    </script>
@stop