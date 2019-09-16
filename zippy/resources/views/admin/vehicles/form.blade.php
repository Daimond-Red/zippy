<ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
    <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1" role="tab">Vehicle Info</a>
    </li>
    <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab">Owner</a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
        @if( isset($model) && $model->image )
            {!!  HTML::vimage('image', ['value' => $model->image]) !!}
        @else
            {!! HTML::vimage('image') !!}
        @endif
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vselect('vehicle_type_id', $vehicletypes, null, ['label' => 'Type of vehicle required']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vselect('vehicle_category_id', $vehiclecategories, null, ['label' => 'Vehicle category']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('registration_no', null, ['label' => 'Registration no']) !!}
            </div>
            <div class="col-md-6">
                @if( isset($model) && $model->registration_pic )
                    {!!  HTML::vimage('registration_pic', ['value' => $model->registration_pic, 'label' => 'Registration Pic']) !!}
                @else
                    {!! HTML::vimage('registration_pic', ['label' => 'Registration Pic']) !!}
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                {!! HTML::vselect('gpsenabled', ['No', 'Yes'], null, ['label' => 'GSP Enabled']) !!}

            </div>
            <div class="col-md-6">
                {!! HTML::vselect('noentrypermit', ['No', 'Yes'], null, ['label' => 'No Entry Permit']) !!}
            </div>
        </div>

    </div>
    <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('owner_name', null, ['label' => 'Owner Name']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vtext('owner_mobile', null, ['label' => 'Owner Mobile']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                {!! HTML::vtext('reg_validity', null, ['label' => 'Registration Validity']) !!}
            </div>
            <div class="col-md-4">
                {!! HTML::vtext('insurance_validity', null, ['label' => 'Insurance Validity']) !!}
            </div>
            <div class="col-md-4">
                {!! HTML::vtext('vehicle_payload', null, ['label' => 'Vehicle Payload']) !!}
            </div>
        </div>

    </div>
</div>