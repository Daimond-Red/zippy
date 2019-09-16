{{ Form::model($model, ['route' => [ 'admin.vendors.update', $model->id ], 'method' => 'put', 'files' => true, 'class' => '' ] ) }}
    @include('admin.vendors.form')
{{ Form::close() }}