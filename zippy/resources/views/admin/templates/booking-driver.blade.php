@if( isset($driver) && $driver )
<!--begin::Item-->
<div class="">
   
    <div class="m-accordion__item-body" id="driver-{{$driver->id}}" role="tabpanel" aria-labelledby="m_accordion_5_item_1_head" data-parent="#m_accordion_5" style="">
            <span>
                <div class="m-widget13">
				
				<h5>
				    <span class="m-accordion__item-icon"><i class="fa flaticon-users"></i></span>
                    <span class="m-accordion__item-title">Driver</span>
				</h5>
		
		            <div class="row">
					
                    <div class="m-widget13__item col-md-2">
                        <span class="m-widget13__text m-widget13__text-bolder">
                            <a href="{{ getImageUrl($driver->image) }}" class="light-image">
                                <img
                                        class="m-widget7__img"
                                        src="{{ getImageUrl($driver->image) }}"
                                        alt=""
                                        style="width: 75px; height:75px; border-radius:50%;"
                                >
                            </a>
                        </span>
                    </div>
					
					<div class="col-md-7">
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc ">
                            Full Name:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder m--align-right">
                            {{ ucfirst($driver->first_name). ' '. ucfirst($driver->last_name) }}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc ">
                            Email:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder m--align-right">
                            {{ $driver->email }}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc ">
                            Mobile No:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder m--align-right">
                            {{ $driver->mobile_no }}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc ">
                            Licence No:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder m--align-right">
                            {{ $driver->licence_no }}
                        </span>
                    </div>
					</div>
					</div>
                </div>
            </span>
    </div>
</div>
<!--end::Item-->
@endif