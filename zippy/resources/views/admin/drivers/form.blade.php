<ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
    <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1" role="tab">Personal Info</a>
    </li>
    <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab">Image</a>
    </li>
    <li class="nav-item m-tabs__item">
        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_3" role="tab">Address</a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('first_name',  null, ['label' => 'Name']) !!}
            </div>
            <div class="col-md-6">
                {!! HTML::vtext('mobile_no', null, ['label' => 'Mobile No']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('email') !!}
            </div>
            <div class="col-md-6">
                @if( isset($model) )
                    {!! HTML::vtext('password', '') !!}
                @else
                    {!! HTML::vtext('password') !!}
                @endif

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! HTML::vtext('licence_no', null, ['label' => 'Licence No']) !!}        
            </div>
            <div class="col-md-6">
                {!! HTML::vtext('dl_valid_upto', null, ['label' => 'Licence Validity']) !!}
            </div>
        </div>
        {!! HTML::vtext('aadhar_no', null, ['label' => 'Aadhar Number']) !!}

    </div>
    <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
        @if( isset($model) && $model->image )
            {!!  HTML::vimage('image', ['value' => $model->image]) !!}
        @else
            {!! HTML::vimage('image') !!}
        @endif
        @if( isset($model) && $model->licence_pic )
            {!!  HTML::vimage('licence_pic', ['value' => $model->licence_pic, 'label' => 'Licence Pic']) !!}
        @else
            {!! HTML::vimage('licence_pic', ['label' => 'Licence Pic']) !!}
        @endif
    </div>
    <div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
        {!! HTML::vtext('address1', null, ['label' => 'Address1']) !!}
        {!! HTML::vtext('address2', null, ['label' => 'Address2']) !!}
        {!! HTML::vtext('city', null, ['label' => 'City']) !!}
        {!! HTML::vtext('state', null, ['label' => 'State']) !!}
        {!! HTML::vtext('pincode', null, ['label' => 'Pincode']) !!}
    </div>
</div>