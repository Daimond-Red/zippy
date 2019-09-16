@if( isset($vehicle) && $vehicle )
<!--begin::Item-->
<div class="">
   
    <div class="m-accordion__item-body  " id="vehicle-{{$vehicle->id}}" role="tabpanel" aria-labelledby="m_accordion_5_item_1_head" data-parent="#m_accordion_5" style="">
            <span>
                <div class="m-widget13">
				    <h5>
					    <span class="m-accordion__item-icon"><i class="fa flaticon-truck"></i></span>
						<span class="m-accordion__item-title">Vehicle</span>
					</h5>
				    <div class="row">
                    <div class="m-widget13__item col-md-2">
                        <span class="m-widget13__text m-widget13__text-bolder">
                            <a href="{{ getImageUrl($vehicle->image) }}" class="light-image">
                                <img
                                        class="m-widget7__img"
                                        src="{{ getImageUrl($vehicle->image) }}"
                                        alt=""
                                        style="width:75px; height:75px; border-radius:50%;"
                                >
                            </a>
                        </span>
                    </div>
					
					<div class="col-md-7">
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc ">
                            Registration no:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder m--align-right">
                            {{ $vehicle->registration_no }}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc">
                            Owner name:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder m--align-right">
                            {{ $vehicle->owner_name }}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc ">
                            Owner mobile:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder m--align-right">
                            {{ $vehicle->owner_mobile }}
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc ">
                            GPS:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder m--align-right">
                            @if (! $vehicle->gpsenabled )
                                <span class="m-badge  m-badge--danger m-badge--wide">No</span>
                            @else
                                <span class="m-badge m-badge--brand m-badge--wide">Yes</span>
                            @endif
                        </span>
                    </div>
                    <div class="m-widget13__item">
                        <span class="m-widget13__desc">
                            No Entry:
                        </span>
                        <span class="m-widget13__text m-widget13__text-bolder m--align-right">
                            @if (! $vehicle->noentrypermit )
                                <span class="m-badge  m-badge--danger m-badge--wide">No</span>
                            @else
                                <span class="m-badge m-badge--brand m-badge--wide">Yes</span>
                            @endif
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