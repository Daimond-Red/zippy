<ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
    <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1" role="tab">Personal Info</a>
    </li>
    <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab">Profile Image</a>
    </li>
    <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_3" role="tab">Device Details</a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('first_name', null, ['label' => 'First Name']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vtext('lastname_name', null, ['label' => 'Last Name']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('email', null, ['label' => 'Email']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vpassword('password', ['label' => 'Password']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('pancard_no', null, ['label' => 'Pancard No']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vtext('aadhar_no', null, ['label' => 'Aadhaar Number']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('mobile_no', null, ['label' => 'Mobile No']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vselect('is_enable', ['Disable', 'Enable'], null, ['label' => 'Enable / Disable']) !!}
            </div>
        </div>


    </div>
    <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
        @if( isset($model) && $model->image )
            {!!  HTML::vimage('image', ['value' => $model->image]) !!}
        @else
            {!! HTML::vimage('image') !!}
        @endif
    </div>
    <div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
        {!! HTML::vtext('device_id', null, ['label' => 'Device ID']) !!}
        {!! HTML::vtext('device_type', null, ['label' => 'Device Type', 'disabled']) !!}
        {!! HTML::vtextarea('device_token', null, ['label' => 'Device Token']) !!}
    </div>
</div>