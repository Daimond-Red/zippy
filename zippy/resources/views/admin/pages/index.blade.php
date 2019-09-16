@extends('layouts.master')

@section('header')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"> Pages </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ route('admin.dashboard') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator"> - </li>
                    <li class="m-nav__item"><span class="m-nav__link-text">Pages</span></li>
                </ul>
            </div>
        </div>
    </div>
@stop

@section('sidebarSearch')
    <form action="{{route('admin.pages.index')}}" method="GET" id="search-form">

        {!! HTML::vtext('title', null, ['label' => 'Page Title']) !!}

        {!! HTML::vtext('slug', null, ['label' => 'Page Slug']) !!}

        <input type="submit" value="search" style="display: none">

    </form>
@stop

@section('content')

    <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg ">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon "><i class="flaticon-grid-menu-v2"></i></span>
                    <h3 class="m-portlet__head-text">Pages</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <button
                            class="m-portlet__nav-link btn btn-light m-btn m-btn--pill m-btn--air dataModel"
                            data-href="{{ route('admin.pages.create') }}"
                            data-title="Add new"
                        >
                            Add New
                        </button>
                    </li>
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
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Created On</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $collection as $model )
                    <tr>
                        <td data-label="#" scope="row">{{ $model->id }}</td>
                        <td data-label="Title">{{ $model->title }}</td>
                        <td data-label="Slug">{{ $model->slug }}</td>
                        <td data-label="Created On">{{ date('d/m/Y', strtotime($model->created_at)) }}</td>
                        <td data-label="Action">
                            <span class="">
                                <button
                                   class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill dataModel"
                                   title="Edit details"
                                   data-href="{{ route('admin.pages.edit', $model->id) }}"
                                   data-title="Edit"
                                >
                                    <i class="la la-edit"></i>
                                </button>

                                <a
                                    href="{{ route('admin.pages.delete', $model->id) }}"
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
            $('.page-menu').addClass('m-menu__item--active');
        });
    </script>
@stop