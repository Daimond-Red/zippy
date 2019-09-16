{{ Form::model($model, ['route' => [ 'admin.appNotifications.update', $model->id ], 'method' => 'put', 'files' => true, 'class' => '' ] ) }}
    @include('admin.appNotifications.form')
{{ Form::close() }}