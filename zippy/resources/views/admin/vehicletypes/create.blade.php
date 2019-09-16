{{ Form::open( [ 'class' => '', 'route' => 'admin.vehicletypes.store', 'method' => 'POST', 'files' => true ]) }}
    @include('admin.vehicletypes.form')
{{ Form::close() }}