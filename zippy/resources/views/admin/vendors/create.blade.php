{{ Form::open( [ 'class' => '', 'route' => 'admin.vendors.store', 'method' => 'POST', 'files' => true ]) }}
    @include('admin.vendors.form')
{{ Form::close() }}