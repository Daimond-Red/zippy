{{ Form::model($model, ['route' => [ 'admin.driverNotifications.update', $model->id ], 'method' => 'put', 'files' => true, 'class' => '' ] ) }}
    @include('admin.driverNotifications.form')
{{ Form::close() }}