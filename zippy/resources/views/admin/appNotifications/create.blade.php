@extends('layouts.master')


@section('header')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">Notifications </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ route('admin.dashboard') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-bell"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator"> - </li>
                    <li class="m-nav__item"><span class="m-nav__link-text">Add New</span></li>
                </ul>
            </div>

        </div>
    </div>
@stop
@section('sidebarSearch')
    {{ Form::open( [ 'class' => '', 'route' => 'admin.appNotifications.create', 'method' =>'GET', 'id' => 'search-form']) }}
                    
        {!! HTML::vtext('first_name', null, ['label' => 'First Name']) !!}
    
        {!! HTML::vtext('last_name', null, ['label' => 'Last Name']) !!}
                       
        {!! HTML::vtext('email', null, ['label' => 'Email']) !!}

        {!! HTML::vselect('role', ['' => 'Select User Type', \App\User::CUSTOMER => 'Customer', \App\User::VENDOR => 'Vendor' ], null, ['label' => 'User Type']) !!}
                       
    {{ Form::close() }}
@stop

@section('content')
	<div class="m-portlet m-portlet--brand m-portlet--head-solid-bg ">
	
	    <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon "><i class="flaticon-grid-menu-v2"></i></span>
                    <h3 class="m-portlet__head-text">Add New</h3>
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
	
	<div class="m-portlet__body" >

    <div class="row">
        <div class="col-md-4">
            <div style="border: 1px solid #e2e2e2;" class="m-portlet m-portlet--brand m-portlet--head-solid-bg ">
                
                <div class="m-portlet__body" >
                    {{ Form::open( [ 'class' => '', 'route' => 'admin.appNotifications.store', 'method' => 'POST', 'files' => true ]) }}
                    @include('admin.appNotifications.form')
                    {!! Form::hidden('users', null, ['class' => 'users']) !!}
                    <div class=" m-portlet__foot--fit">
                        <div class="m-form__actions">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <div class="col-md-8">
           
            <div class="table-responsive ajax-collection" id="user-collection">
                {{ Form::hidden('allUserIds', implode(',', $allUserIds)) }}
                <table class="table table-bordered table-hover">
                    <thead class="thead-default">
						<tr>
							<th>
								<input type="checkbox" data-group=".user_list" class="select-all-users" name="select-all" value="" />
							</th>
							<th> Name </th>
							<th> Email </th>
							<th> User Type </th>
						</tr>
                    </thead>
                    <tbody>
                    @if(! count($collection) )
                        <tr>
                            <td colspan="15" style="text-align: center">No matching records found</td>
                        </tr>
                    @else
                        @foreach( $collection as $model )
                            <?php
                            $user_list = [];
                            if( request('isAjax') ) $user_list = json_decode($_COOKIE['user_list']);
                            ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="user_list" name="user_list[]" value="{{$model->id}}" <?php if( in_array($model->id, $user_list) ) echo 'checked'; ?>>
                                </td>
                               
                                <td> {{ $model->getFullName() }} </td>
                                <td> {{ $model->email }} </td>
                                <td>
                                    @if( $model->role == \App\User::CUSTOMER )
                                        <p>Customer</p>
                                    @elseif( $model->role == \App\User::VENDOR )
                                        <p>Vendor</p>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                {{ $collection->appends(array_merge(request()->all(), ['isAjax' => 1]))->links() }}
            </div>

        </div>
    </div>
	</div>
	</div>

@stop

@section('style')
    <style>
        table tr td{
			padding:0.3rem 0.75rem !important;
			vertical-align:middle !important;
			font-size:13px;
		}
    </style>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            
            $('.notification-menu').addClass('m-menu__item--active');

            Cookies.set('user_list', []);

            $('body').on('change', '.user_list', function (e) {

                var arr = Cookies.get('user_list');
                arr = JSON.parse(arr);
                if(  typeof arr == 'undefined') arr = [];

                if( $(this).is(':checked') ) {
                    arr.push($(this).val());
                } else {
                    var itemtoRemove = $(this).val();
                    arr.splice($.inArray(itemtoRemove, arr),1);
                }
                console.log(arr);
                Cookies.set('user_list', arr);
                $('.users').val(arr.join(','));
            });

            function clearUsers() {
                Cookies.set('user_list', []);
                $('.users').val('');
            }

            function setUsers() {
                var arr = $('input[name="allUserIds').val();
                arr = arr.split(',');
                Cookies.set('user_list', arr);
                $('.users').val(arr.join(','));
            }

            // select all checkbox
            $('body').on('click', '.select-all-users', function (e) {

                var group = $(this).attr('data-group');
                // console.log(group)
                if ( $(this).is(':checked') ) {
                    $(group).prop('checked', true);
                    setUsers();
                } else {
                    $(group).prop('checked', false);
                    clearUsers();
                }



                //$(group).change();
            });

        });
    </script>
@stop