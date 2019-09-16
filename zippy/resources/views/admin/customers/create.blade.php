{{ Form::open( [ 'class' => '', 'route' => 'admin.customers.store', 'method' => 'POST', 'files' => true ]) }}
    @include('admin.customers.form')
{{ Form::close() }}