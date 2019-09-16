@if( isset($model) && $model )
<!--begin::Item-->
<div class="m-accordion__item">
    <div class="m-accordion__item-head" role="tab" id="m_accordion_5_item_1_head" data-toggle="collapse" href="#bookings" aria-expanded="true">
        <span class="m-accordion__item-icon"><i class="fa flaticon-route"></i></span>
        <span class="m-accordion__item-title">Bookings Details</span>
        <span class="m-accordion__item-mode"><i class="la la-plus"></i></span>
    </div>
    <div class="m-accordion__item-body collapse show" id="bookings" role="tabpanel" aria-labelledby="m_accordion_5_item_1_head" data-parent="#m_accordion_5" style="">
        <span>
            @if( $model->type == \App\Booking::TYPE_INTER )
			    <div style="border-bottom: 2px solid #e6e3e3;" class="row text-center">
				    <div class="col-6 col-md-2">
					    <p><strong> {{ $model->id }} </strong></p>
						<p>Order ID</p>
					</div>
				    <div class="col-6 col-md-2">
					    <p><strong>{{ $model->total_distance }} kms</strong></p>
						<p>Total Distance</p>
					</div>
					<div class="col-6 col-md-2">
					    <p><strong> {{ currencySign(). $model->total_amount }}</strong>&nbsp;</p>
						<p>Vendor Amount</p>
					</div>
                    <div class="col-6 col-md-2">
					    <p>
                            <strong> {{ currencySign(). $model->customer_amount }}</strong>&nbsp;
                            @if(! in_array($model->status, [\App\Booking::EXPIRED, \App\Booking::CANCEL, \App\Booking::COMPLETE]) )
                                <button
                                    data-href="{{ route('admin.bookings.edit', $model->id) }}"
                                    class=" btn btn-sm dataModel"
                                    data-title="Update"
                                >
                                    <i class="m-nav__link-icon la la-edit"></i>
                                </button>
                            @endif
                        </p>
						<p>Customer Amount</p>
					</div>
					<div class="col-6 col-md-2">
					    <p><strong>{{ getDateTimeValue($model->created_at) }}</strong></p>
						<p>Created Date Time</p>
					</div>
                    @if( optional($model->vehicle_type)->title )
                        <div class="col-6 col-md-2">
                            <p><strong>{{ $model->vehicle_type->short_code }}</strong></p>
                            <p>Vehicle Type</p>
                        </div>
                    @endif
                    
				</div>
				<div style="margin:2% 3%;" class="row">
					<div class="col-md-6 m-widget13">

                        <div class="m-widget13__item">
                            <span class="m-widget13__desc ">
                                Status:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                <p class="m-badge m-badge--primary m-badge--wide">{{ optional($model->booking_status)->title  }}</p>
                            </span>
                        </div>

                        @if( optional($model->cargo_type)->title )
                            <div class="m-widget13__item">
                            <span class="m-widget13__desc ">
                                Cargo Type:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                {{ $model->cargo_type->title }}
                            </span>
                        </div>
                        @endif

						<div class="m-widget13__item">
                            <span class="m-widget13__desc">
                                Actual Gross Weight
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                               {{ $model->actual_gross_weight }}
                            </span>
                        </div>

                        <div class="m-widget13__item">
                            <span class="m-widget13__desc">
                                No of vehicle required
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                {{ $model->no_of_vehicle }}
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc">
                                Gross weight of shipment
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                {{ $model->gross_weight }}
                            </span>
                        </div>
                       
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc ">
                                Volumetric Weight
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                {{ $model->volumetric_weight }}
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc">
                                Additional Info
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                {{ $model->additional_info }}
                            </span>
                        </div>
					</div>
					
					<div class="col-md-6 m-widget13">
					    <div class="m-widget13__item">
                            <span class="m-widget13__desc"><i class="la la-map text-primary"></i>&nbsp;
                                Pickup Location:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                {{ $model->pickup_address }}
                            </span>
                        </div> 
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc "><i class="la la-map text-danger"></i>&nbsp;
                                Drop Location:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                {{ $model->drop_address }}
                            </span>
                        </div>

                        @if( optional($model->paymentType)->title )
                            <div class="m-widget13__item">
                            <span class="m-widget13__desc ">
                                Payment Type:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                {{ $model->paymentType->title }}
                            </span>
                        </div>
                        @endif

                        
                        {{-- <div class="m-widget13__item">
                            <span class="m-widget13__desc ">
                                Customer Signature:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                @if( $model->customer_sign )
                                    <img src="data:image/png;base64,{{ $model->customer_sign }}" class="customer_sign" style="width: 20%">
                                @else
                                    <img src="{{ getImageUrl('') }}" class="customer_sign" style="width: 20%">
                                @endif
                            </span>
                        </div> --}}
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc ">
                                Client Signature:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                @if( $model->consignor_sign )
                                    <img src="data:image/png;base64,{{ $model->consignor_sign }}" class="consignor_sign" style="width: 20%">
                                @else
                                    <img src="{{ getImageUrl('') }}" class="consignor_sign" style="width: 20%">
                                @endif
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc ">
                                Consignee Signature:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                @if( $model->customer_sign )
                                    <img src="data:image/png;base64,{{ $model->customer_sign }}" class="customer_sign" style="width: 20%">
                                @else
                                    <img src="{{ getImageUrl('') }}" class="customer_sign" style="width: 20%">
                                @endif
                            </span>
                        </div>
					</div>
				</div>
            @else
			<div style="border-bottom: 2px solid #e6e3e3;" class="row text-center">
				    <div class="col-md-2">
					    <p><strong> {{ $model->id }} </strong></p>
						<p>Order ID</p>
					</div>
					<div class="col-md-2">
					    <p class="m-badge m-badge--primary m-badge--wide">{{ optional($model->booking_status)->title  }}</p>
						<p>Order Status</p>
					</div>
				    <div class="col-md-2">
					    <p><strong>{{ $model->total_distance }}</strong></p>
						<p>Total Distance</p>
					</div>
					<div class="col-md-2">
					    <p><strong> {{ $model->total_amount }}</strong></p>
						<p>Total Amount</p>
					</div>
					<div class="col-md-2">
					    <p><strong>{{ getDateValue($model->pickup_date) }}</strong></p>
						<p>Pickup Date</p>
					</div>
					<div class="col-md-2">
					    <p><strong>{{ getTimeValue($model->pickup_time) }}</strong></p>
						<p>Pickup Time</p>
					</div>
				</div>
				<div style="margin:2% 3%;" class="row">
					<div class="col-md-6 m-widget13">
					    <div class="m-widget13__item">
                            <span class="m-widget13__desc">
                                 Gross Weight
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                               {{ $model->gross_weight }}
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc ">
                                Cargo Type:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                {{ $model->cargo_type->title }}
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Vehicle Category:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                {{ optional($model->vehicle_category)->title }}
                            </span>
                        </div>
                
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Carton Length:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                {{ $model->carton_lenght }}
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Carton Breadth:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                {{ $model->carton_breadth }}
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Carton Height:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                {{ $model->carton_height }}
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Volume:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                {{ $model->volume }}
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Freight Cost:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                               {{ $model->freight_cost }}
                            </span>
                        </div>
					</div>
					
					<div class="col-md-6 m-widget13">
					    <div class="m-widget13__item">
                            <span class="m-widget13__desc">
                                Pickup Location:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                {{ $model->pickup_address }}
                            </span>
                        </div> 
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc ">
                                Drop Location:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                {{ $model->drop_address }}
                            </span>
                        </div>						
					</div>
					
				</div>
            @endif
        </span>
    </div>
    <hr>

    <div class="row" style="padding: 2%">
        <div class="col-md-12">
            <h5>Bidding History</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-mobile">
                    <thead class="thead-default">
                        <tr>
                            <th>Vendor ID</th>
                            <th>Vendor Name</th>
                            <th>Quote to the Client </th>
                            <th>Created On</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $model->biddings as $bid ) 
                            <?php
                                $vendor = \App\User::where('id', $bid->vendor_id)->first(['id', 'first_name', 'last_name']);
                                if(!$vendor) continue;
                            ?>
                            <tr>
                                <td data-label="Vendor ID">{{ $vendor->id }}</td>
                                <td data-label="Vendor Name">{{ $vendor->getFullName() }}</td>
                                <td data-label="Client's Quote">{{currencySign()}} {{ $bid->amount }}</td>
                                <td data-label="Created On">{{ getDateTimeValue($bid->created_at) }}</td>
                            </tr>
                        @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!--end::Item-->
@endif