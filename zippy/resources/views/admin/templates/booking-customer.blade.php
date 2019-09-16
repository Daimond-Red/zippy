<!--begin::Item-->
<div class="m-accordion__item">
    <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_5_item_3_head" data-toggle="collapse" href="#m_accordion_5_item_3_body" aria-expanded="    false">
                <span class="m-accordion__item-icon">
                    <i class="fa  flaticon-user"></i>
                </span>
        <span class="m-accordion__item-title">
                    Customer
                </span>
        <span class="m-accordion__item-mode">
                    <i class="la la-plus"></i>
                </span>
    </div>
    <div class="m-accordion__item-body collapse" id="m_accordion_5_item_3_body" role="tabpanel" aria-labelledby="m_accordion_5_item_3_head" data-parent="#m_accordion_5">
                <span>
                    <div class="m-widget13">
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Profile Image:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                <a href="{{ getImageUrl($customer->image) }}" class="light-image">
                                    <img
                                            class="m-widget7__img"
                                            src="{{ getImageUrl($customer->image) }}"
                                            alt=""
                                            style="width: 300px; height:300px"
                                    >
                                </a>
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Full Name:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                {{ ucfirst($customer->first_name). ' '. $customer->last_name }}
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Email:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                {{ $customer->email }}
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Mobile No:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                {{ $customer->mobile_no }}
                            </span>
                        </div>
                        <div class="m-widget13__item">
                            <span class="m-widget13__desc m--align-right">
                                Pancard No:
                            </span>
                            <span class="m-widget13__text m-widget13__text-bolder">
                                {{ $customer->pancard_no }}
                            </span>
                        </div>
                    </div>
                </span>
    </div>
</div>
<!--end::Item-->