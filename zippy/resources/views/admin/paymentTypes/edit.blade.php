{{ Form::model($model, ['route' => [ 'admin.paymentTypes.update', $model->id ], 'method' => 'put', 'files' => true, 'class' => '' ] ) }}
    @include('admin.paymentTypes.form')
{{ Form::close() }}