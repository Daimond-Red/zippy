{{ Form::model($model, ['route' => [ 'admin.cargos.update', $model->id ], 'method' => 'put', 'files' => true, 'class' => '' ] ) }}
    @include('admin.cargotypes.form')
{{ Form::close() }}