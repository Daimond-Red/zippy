<div class="row">
    <div class="col-md-6">
        {!! HTML::vselect('driver_id[]', $driverIds, null, ['label' => 'Drivers', 'multiple', 'data-validation' => 'required']) !!}
    </div>
    <div class="col-md-6">
        {!! HTML::vselect('vehicle_id[]', $vehicleIds, null, ['label' => 'Vehicle ID', 'multiple', 'data-validation' => 'required' ]) !!}
    </div>
</div>