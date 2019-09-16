{{ Form::open( [ 'class' => '', 'route' => 'admin.paymentTypes.store', 'method' => 'POST', 'files' => true ]) }}
    @include('admin.paymentTypes.form')
{{ Form::close() }}