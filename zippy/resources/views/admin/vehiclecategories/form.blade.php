<div class="row">
    <div class="col-md-6">
        {!!  HTML::vtext('title') !!}
    </div>
    <div class="col-md-6">
        {!!  HTML::vtext('price') !!}
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        {!!  HTML::vtext('max_gross_weight', null, ['label' => 'Max gross weight']) !!}
    </div>
    <div class="col-md-3">
        {!!  HTML::vtext('max_carton_length', null, ['label' => 'Max carton length']) !!}
    </div>
    <div class="col-md-3">
        {!!  HTML::vtext('max_carton_breadth', null, ['label' => 'Max carton breadth']) !!}
    </div>
    <div class="col-md-3">
        {!!  HTML::vtext('max_carton_height', null, ['label' => 'Max carton height']) !!}
    </div>
</div>
@if( isset($model) && $model->image )
    {!!  HTML::vimage('image', ['value' => $model->image]) !!}
@else
    {!! HTML::vimage('image') !!}
@endif