
{{ Form::open( [ 'class' => '', 'route' => 'admin.bookingNotification.store', 'method' => 'POST', 'files' => true ]) }}
	{{ Form::hidden('booking_id', $model->id) }}
	<div class="row">
		<div class="col-md-4 checkbox">
			<label><input type="checkbox" name="customer_id" value="{{ $model->customer_id }}"> Customer</label>
		</div>
		<div class="col-md-4 checkbox">
			<label><input type="checkbox" name="vendor_id" value="{{ $model->vendor_id }}" > Vendor </label>
		</div>
	</div>

    @include('admin.appNotifications.form')

{{ Form::close() }}