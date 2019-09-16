@extends('layouts.master')

@section('header')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"> Customers </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ route('admin.dashboard') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator"> - </li>
                    <li class="m-nav__item"><span class="m-nav__link-text">Customers</span></li>
                </ul>
				
            </div>
			<div>
				<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    {{--<li class="m-portlet__nav-item">--}}
                        {{--<button--}}
                            {{--class="m-portlet__nav-link btn btn-light m-btn m-btn--pill m-btn--air datamodel"--}}
                            {{--data-href="{{ route('admin.customers.create') }}"--}}
                            {{--data-title="add new"--}}
                        {{-->--}}
                            {{--add new--}}
                        {{--</button>--}}
                    {{--</li>--}}
                    <li class="m-nav__item">
                        <button
                            id="m_quick_sidebar_toggle"
                            class="m-portlet__nav-link btn btn-info btn-sm m-btn m-btn--air"
                        >
                         <i class="m-nav__link-icon la la-search"></i>   Search
                        </button>
                    </li>

                </ul>
			</div>
        </div>
		
		   
    </div>
@stop

@section('sidebarSearch')
    <form action="{{route('admin.customers.index')}}" method="GET" id="search-form">
        {!! HTML::vtext('first_name', null, ['label' => 'First Name']) !!}

        {!! HTML::vtext('last_name', null, ['label' => 'Last Name']) !!}

        {!! HTML::vtext('email', null, ['label' => 'Email']) !!}
        
        {!! HTML::vtext('pancard_no', null, ['label' => 'PAN Card no']) !!}
        
        {!! HTML::vselect('signup_type', ['' => '', 'facebook' => 'Facebook', 'gplus' => 'Google Plus', 'normal' => 'Normal'], null, ['label' => 'Registration Type']) !!}
        
        {{-- {!! HTML::vselect('status', ['' => '', 0 => 'Unverified', 1 => 'Verified'], null, ['label' => 'Status']) !!} --}}

        <input type="submit" value="search" style="display: none">

    </form>
@stop


@section('content')

	<div class="m-portlet__body table-responsive">
        <table class="table data-table-custom table-mobile">
            <thead class="thead-default">
            <tr>
                <th>#</th>
                <th>CUSTOMER INFO</th>
                <th>Mobile No</th>
                <th>Account Status</th>
                <th>Signup Type</th>
                <th>Login Access</th>
                <th>Created On</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach( $collection as $model )
                <tr>
                    <td data-label="#" scope="row">{{ $model->id }}</td>
                    <td data-label="Customer Info" class="customer-info">
                        <a href="{{ getImageUrl($model->image) }}" class="light-image">
                            <img style="width: 40px; height:40px" src="{{ getImageUrl($model->image) }}" >
                        </a>
                        <strong>{{ $model->first_name }} {{ $model->last_name }}</strong> </br>
						{{ $model->email }} </br>

                        {{-- rating --}}
						<div style="margin-left:50px;">
                        @if( isset($ratings[$model->id]) )
                            @for( $i = 1; $i <= 5; $i++ )
                                @if( $i <= $ratings[$model->id] )
                                    <span class="fa fa-star checked"></span>
                                @else
                                    <span style="color:lightgrey;" class="fa fa-star"></span>
                                @endif
                            @endfor
                        @else
							
								<span style="color:lightgrey;" class="fa fa-star"></span>
								<span style="color:lightgrey;" class="fa fa-star"></span>
								<span style="color:lightgrey;" class="fa fa-star"></span>
								<span style="color:lightgrey;" class="fa fa-star"></span>
								<span style="color:lightgrey;" class="fa fa-star"></span>
							
							
                        @endif
						</div>
                        {{-- ./ rating --}}
					</td>
                    <td data-label="Mobile No." >{{ $model->mobile_no }}</td>
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
                            <button
                               class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill dataModel"
                               title="Edit details"
                               data-href="{{ route('admin.customers.edit', $model->id) }}"
                               data-title="Edit"
                            >
                                <i class="la la-edit"></i>
                            </button>

                            <!-- <a
                                href="{{ route('admin.customers.delete', $model->id) }}"
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

        
@stop

@section('style')
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <style>
        .m-portlet.m-portlet--head-sm .m-portlet__head {
            height: 6.1rem;

        }
        .m-portlet:hover{
            box-shadow: 0px 3px 20px 0px #bdc3d4;
        }
    </style>
    <style>
.checked {
  color: orange;
}
.fa.fa-star{
    font-size: 72%;
}
</style>
@stop

@section('script')
    <script>
        $(document).ready(function(){
            $('.customer-menu').addClass('m-menu__item--active');
        });
    </script>
@stop