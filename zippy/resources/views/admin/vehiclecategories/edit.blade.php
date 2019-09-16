{{ Form::model($model, ['route' => [ 'admin.vehiclecategories.update', $model->id ], 'method' => 'put', 'files' => true, 'class' => '' ] ) }}
    @include('admin.vehiclecategories.form')
{{ Form::close() }}