{{ Form::open( [ 'class' => '', 'route' => 'admin.cargos.store', 'method' => 'POST', 'files' => true ]) }}
    @include('admin.cargotypes.form')
{{ Form::close() }}