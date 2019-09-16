{{ Form::model($model, ['route' => [ 'admin.vehicletypes.update', $model->id ], 'method' => 'put', 'files' => true, 'class' => '' ] ) }}
    @include('admin.vehicletypes.form')
{{ Form::close() }}