{{ Form::open( [ 'class' => '', 'route' => 'admin.vehiclecategories.store', 'method' => 'POST', 'files' => true ]) }}
    @include('admin.vehiclecategories.form')
{{ Form::close() }}