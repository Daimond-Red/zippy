{!! Form::open(['route' => ['admin.bookings.bidStore', $model->id]]) !!}

{!! HTML::vselect('vendor_id', ['' => 'Please select'] + $vendors->toArray(), null, ['label' => 'Select Vendor', 'data-validation' => 'required']) !!}

{!! HTML::vinteger('amount', null, ['data-validation' => 'required']) !!}

{!! Form::close() !!}