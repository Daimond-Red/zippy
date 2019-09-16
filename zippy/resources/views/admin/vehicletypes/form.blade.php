{!!  HTML::vtext('title') !!}
@if( isset($model) && $model->icon )
    {!!  HTML::vimage('icon', ['value' => $model->icon]) !!}
@else
    {!! HTML::vimage('icon') !!}
@endif

{!!  HTML::vtext('short_code', null, ['label' => 'Short Code']) !!}

{!!  HTML::vtext('payload') !!}