{{ Form::model($model, ['route' => [ 'admin.customers.update', $model->id ], 'method' => 'put', 'files' => true, 'class' => '' ] ) }}
    @include('admin.customers.form')
{{ Form::close() }}