{{ Form::open( [ 'class' => '', 'route' => 'admin.pages.store', 'method' => 'POST', 'files' => true ]) }}
    @include('admin.pages.form')
{{ Form::close() }}