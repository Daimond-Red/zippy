{{ Form::model($model, ['route' => [ 'admin.pages.update', $model->id ], 'method' => 'put', 'files' => true, 'class' => '' ] ) }}
    @include('admin.pages.form')
{{ Form::close() }}