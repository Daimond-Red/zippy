{!! Form::model($model, ['route' => ['admin.bookings.update', $model], 'method' => 'put' ]) !!}

    {!! HTML::vtext('customer_amount', null, ['label' => 'Amount', 'data-validation' => 'required']) !!}

{!! Form::close() !!}