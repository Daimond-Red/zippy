@if( isset($vendor) && $vendor )
    <!--begin::Item-->
    <div class="row main-section">
	    <div style="border-right:1px solid lightgray;" class="col-md-6">
            <div class="m-accordion__item-body collapse show" id="vendor-{{$vendor->id}}" role="tabpanel" aria-labelledby="m_accordion_5_item_1_head" data-parent="#m_accordion_5" style="">
               
            <div class="m-widget13">
			    <h5 class="m-subheader__title m-subheader__title--separator">
                    <i class="fa flaticon-users"></i> Assigned Vendor
                    <a
                        class="btn btn-sm pull-right"
                        href="{{ route('admin.bookings.assignVendor', $model->id) }}"
                        title="Update"
                    >
                        <i class="la la-edit"></i> Edit
                    </a>
                </h5>
				<div class="row" style="width:115%;">
                    <div class="m-widget13__item col-md-2">
                        
                        <span class="m-widget13__text m-widget13__text-bolder">
                            <a href="{{ getImageUrl($vendor->image) }}" class="light-image">
                                <img
                                        class="m-widget7__img"
                                        src="{{ getImageUrl($vendor->image) }}"
                                        alt=""
                                        style="width: 75px; height:75px; border-radius:50%;"
                                >
                            </a>
                        </span>
                    </div>
    				
    				<div class="col-md-8">
    					<div class="m-widget13__item">
    						<span class="m-widget13__desc">
    							Full Name:
    						</span>
    						<span class="m-widget13__text m-widget13__text-bolder m--align-right">
    							{{ ucfirst($vendor->first_name). ' '. $vendor->last_name }}
    						</span>
    					</div>
    					<div class="m-widget13__item">
    						<span class="m-widget13__desc">
    							Email:
    						</span>
    						<span class="m-widget13__text m-widget13__text-bolder m--align-right">
    							{{ $vendor->email }}
    						</span>
    					</div>
    					<div class="m-widget13__item">
    						<span class="m-widget13__desc">
    							Mobile No:
    						</span>
    						<span class="m-widget13__text m-widget13__text-bolder m--align-right">
    							{{ $vendor->mobile_no }}
    						</span>
    					</div>
    					<div class="m-widget13__item">
    						<span class="m-widget13__desc">
    							Pancard No:
    						</span>
    						<span class="m-widget13__text m-widget13__text-bolder m--align-right">
    							{{ $vendor->pancard_no }}
    						</span>
    					</div>
    				</div>
			    </div>
            </div>
        </div>
		</div>
		
		
		
		<div class="col-md-6">
		
		    <div class="m-accordion__item-body " id="m_accordion_5_item_3_body" role="tabpanel" aria-labelledby="m_accordion_5_item_3_head" data-parent="#m_accordion_5">
                
                <div class="m-widget13">
    			    <h5>
    				    <span class="m-accordion__item-icon">
                        <i class="fa  flaticon-user"></i>
                        </span>
                        <span class="m-accordion__item-title">
                            Customer
                        </span>
    				</h5>
    				<div class="row">
                    <div class="m-widget13__item col-md-2">
                       
                        <span class="m-widget13__text m-widget13__text-bolder">
                            <a href="{{ getImageUrl($customer->image) }}" class="light-image">
                                <img
                                    class="m-widget7__img"
                                    src="{{ getImageUrl($customer->image) }}"
                                    alt=""
                                    style="width: 75px; height:75px; border-radius:50%;"
                                >
                            </a>
                        </span>
                    </div>
    				<div class="col-md-9">
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc">
                            Full Name:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder m--align-right">
                            {{ ucfirst($customer->first_name). ' '. $customer->last_name }}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc">
                            Email:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder m--align-right">
                            {{ $customer->email }}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc">
                            Mobile No:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder m--align-right">
                            {{ $customer->mobile_no }}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc">
                            Pancard No:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder m--align-right">
                            {{ $customer->pancard_no }}
                        </span>
                    </div>

                    <div class="m-widget13__item">
                        <span class="m-widget13__desc">
                            Contact Person:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder m--align-right">
                            {{ $model->contact_person }}
                        </span>
                    </div>

                    <div class="m-widget13__item">
                        <span class="m-widget13__desc">
                            Contact Person Mobile:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder m--align-right">
                            {{ $model->contact_person_no }}
                        </span>
                    </div>
    				</div>
    				</div>
                </div>
              
            </div>
		    
		</div>
    </div>
    <!--end::Item-->

@else 

    <div class="row main-section">
        <div class="col-md-8">
        
            <div class="m-accordion__item-body " id="m_accordion_5_item_3_body" role="tabpanel" aria-labelledby="m_accordion_5_item_3_head" data-parent="#m_accordion_5">
                
                <div class="m-widget13">
                    <h5>
                        <span class="m-accordion__item-icon">
                        <i class="fa  flaticon-user"></i>
                        </span>
                        <span class="m-accordion__item-title">
                            Customer Details
                        </span>
                    </h5>
                    <div class="row">
                    <div class="m-widget13__item col-md-2">
                       
                        <span class="m-widget13__text m-widget13__text-bolder">
                            <a href="{{ getImageUrl($customer->image) }}" class="light-image">
                                <img
                                    class="m-widget7__img"
                                    src="{{ getImageUrl($customer->image) }}"
                                    alt=""
                                    style="width: 75px; height:75px; border-radius:50%;"
                                >
                            </a>
                        </span>
                    </div>
                    <div class="col-md-9">
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc">
                            Full Name:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder m--align-right">
                            {{ ucfirst($customer->first_name). ' '. $customer->last_name }}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc">
                            Email:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder m--align-right">
                            {{ $customer->email }}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc">
                            Mobile No:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder m--align-right">
                            {{ $customer->mobile_no }}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc">
                            Pancard No:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder m--align-right">
                            {{ $customer->pancard_no }}
                        </span>
                    </div>

                    <div class="m-widget13__item">
                        <span class="m-widget13__desc">
                            Contact Person:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder m--align-right">
                            {{ $model->contact_person }}
                        </span>
                    </div>

                    <div class="m-widget13__item">
                        <span class="m-widget13__desc">
                            Contact Person Mobile:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder m--align-right">
                            {{ $model->contact_person_no }}
                        </span>
                    </div>

                    </div>
                    </div>
                </div>
              
            </div>
            
        </div>
    </div>
@endif