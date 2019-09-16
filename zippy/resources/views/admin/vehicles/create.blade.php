{{ Form::open( [ 'class' => '', 'route' => ['admin.vehicles.store', $vendor->id], 'method' => 'POST', 'files' => true ]) }}
    @include('admin.vehicles.form')
{{ Form::close() }}