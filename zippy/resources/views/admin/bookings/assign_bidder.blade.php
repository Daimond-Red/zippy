@extends('layouts.master')

@section('header')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"> Assign Vendor </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ route('admin.dashboard') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator"> - </li>
                    <li class="m-nav__item">
                        <a href="{{route('admin.bookings.pending')}}" class="m-nav__link">
                            <span class="m-nav__link-text">Business Inquiries</span>
                        </a>
                    </li>
                    <li class="m-nav__separator"> - </li>
                    <li class="m-nav__item"><span class="m-nav__link-text">Assign Vendor</span></li>
                </ul>
            </div>
        </div>
    </div>
@stop

@section('content')

    <?php $customer = $model->customer; ?>

    <div class="m-accordion m-accordion--default m-accordion--solid" id="m_accordion_5" role="tablist">

        @if(count($biddings) > 0)

            <!--begin::Item-->
            <div class="m-accordion__item">
                <div class="m-accordion__item-head" role="tab" id="m_accordion_5_item_1_head" data-toggle="collapse" href="#vendors" aria-expanded="true">
                    <span class="m-accordion__item-icon"><i class="fa flaticon-users"></i></span>
                    <span class="m-accordion__item-title">Accept Bidding</span>
                    <span class="m-accordion__item-mode"><i class="la la-plus"></i></span>
                </div>
                <div class="m-accordion__item-body collapse show" id="vendors" role="tabpanel" aria-labelledby="m_accordion_5_item_1_head" data-parent="#m_accordion_5" style="">
                    <span style="width: 100%">

                        {{ Form::open( [ 'route' => ['admin.bookings.custom_assign_bidding_vendor_store', $model->id], 'method' => 'POST', 'files' => true ]) }}

                        <?php /* Reload Content *important*  */ ?>
                        <div id="bidContent">
						<div class="row mb-3">
                            @foreach( $biddings as $log )
							<div class="col-md-3 custom-card">
                            <?php if(! $log->vendor ) continue; $vendor = $log->vendor; ?>
								<label class="m-radio m-radio--state-primary bidding-amount" data-id="{{$log->id}}" data-amount="{{$log->amount}}">
									<input type="radio" name="id" value="{{$log->id}}">
									<span></span>
									<div class="text-center">
										<img class="" src="{{ getImageUrl($vendor->image)}}" /> 
									</div>
									<h6 class="mt-2 text-center">
										{{ ucfirst($vendor->first_name). ' '. $vendor->last_name }}
									</h6>
									<div class="row">
										<div class="col-md-4">
											<small><strong>Company</strong></br>{{$vendor->company_name}}</small>
										</div>
                                        <div class="col-md-4">
											<small><strong>Mobile No</strong></br>{{$vendor->mobile_no}}</small>
										</div>
										<div class="col-md-4">
											<small class="text-danger" ><strong>Bid</strong></br> {{ currencySign(). $log->amount}}</small>
										</div>
									</div>
								</label>
							</div>
                            @endforeach
						</div>	
                        </div>

                        <div class="m-widget13__action">
                            <div class="row">
                                <div class="col-md-2">
                                    {!! HTML::vinteger('amount', null, ['label' => 'Bidding Amount', 'id' => 'bidding-amount', 'placeholder' => 'Amount']) !!}
                                </div>
                            </div>

                            <button type="submit" class="btn m-btn--pill m-btn--air btn-primary">
                                Assign
                            </button>
                            <a href="{{ route('admin.bookings.pending') }}" class="btn m-btn--pill    btn-secondary">
                                Cancel
                            </a>
                        </div>

                        {{ Form::close() }}

                    </span>
                </div>
            </div>
            <!--end::Item-->

        @else

        <!--begin::Item-->
        <div class="m-accordion__item">
            <div class="m-accordion__item-head" role="tab" id="m_accordion_5_item_1_head" data-toggle="collapse" href="#vendors" aria-expanded="true">
                <span class="m-accordion__item-icon"><i class="fa flaticon-users"></i></span>
                <span class="m-accordion__item-title">Manually Assign Vendor</span>
                <span class="m-accordion__item-mode"><i class="la la-plus"></i></span>
            </div>
            <div class="m-accordion__item-body collapse show" id="vendors" role="tabpanel" aria-labelledby="m_accordion_5_item_1_head" data-parent="#m_accordion_5" style="">
                <span style="width: 100%">

                    <div class="alert m-alert m-alert--default" role="alert">
                        We have not received any bidding on this Order. No Of Vehicle Required: {{ $model->no_of_vehicle }}.
                    </div>

                    {{ Form::open( [ 'route' => ['admin.bookings.custom_assign_bidding_vendor_store', $model->id], 'method' => 'POST', 'files' => true ]) }}

                        <div class="row">
                            <div class="col-md-3">
                                {!! HTML::vselect('id', ['' => 'Please select'] + array_column($vendorLists, 'email', 'id'), null, ['label' => 'Vendor', 'data-validation' => 'required']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! HTML::vinteger('amount') !!}
                            </div>
                        </div>

                        <div class="m-widget13__action">
                            <button type="submit" class="btn m-btn--pill m-btn--air btn-primary">
                                Assign
                            </button>
                            <a href="{{ route('admin.bookings.pending') }}" class="btn m-btn--pill    btn-secondary">
                                Cancel
                            </a>
                        </div>

                    {{ Form::close() }}

                </span>
            </div>
        </div>
        <!--end::Item-->

        @endif

        @include('admin.templates.booking-details')

        @include('admin.templates.booking-customer')

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
        .m-radio.m-radio--state-primary > span{
            margin-top: 7%;
        }
        .m-portlet .m-portlet__body{
            padding-bottom: 0px;
        }
		
		.custom-card{
			border:1px solid lightgrey;
			box-shadow:0 0 5px lightgrey;
			padding:0;
			transition:all 0.5s;
			background:white;
			postition:relative;
		}
		
		.custom-card:hover{
			transform:scale(1.05,1.05);
			box-shadow:0 0 20px lightgrey;
			z-index:50;
		}
		
		.custom-card small{
			white-space:nowrap;
		}
		
		.custom-card img{
			height:30px;
			width:30px;
			border-radius:50%;
		}
		
		.custom-card .m-radio{
			width:100%;
			padding:10px;
			margin:0;
		}
		
		.custom-card .m-radio.m-radio--state-primary > span{
			margin:9% 7% !important;
		}
    </style>
@stop

@section('script')
    <script>
        $(document).ready(function(){
            $('.booking-menu').addClass('m-menu__item--submenu m-menu__item--open m-menu__item--expanded');
            $('.pendingbooking-menu').addClass('m-menu__item--active');

            $('#manual_vendor_id').on('change', function() {

                pageLoader();

                $.get('{{ route('templates.getDriverVehicleDropdown') }}', {vendor_id: $(this).val()}, function(res){

                    $('.driver-vehicle').html(res);
                    removePageLoader();

                });

            });

            var amount = 0;
            var itemId;

            $('body').on('click', '.bidding-amount', function(){
                $('#bidding-amount').val($(this).attr('data-amount'));
            });

            setInterval( function(){

                amount = $('#bidding-amount').val();
                itemId = $('input[name="id"]:checked').val();

                $.get(window.location.href, function(data){

                    //create jquery object from the response html
                    var $response=$(data);

                    //query the jq object for the values
                    var elements = [
                        '#bidContent',
                    ];

                    for ( var i = 0;  i < elements.length; i++ ) {
                        var dataToday = $response.find(elements[i]).html();
                        $(elements[i]).html(dataToday);

                        $("input[name='id'][value='"+itemId+"']").prop('checked', true)
                        $('#bidding-amount').val(amount);

                    }

                    init();

                });
            }, 20000);


        });
    </script>
@stop