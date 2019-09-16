<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'vendor_id',
        'vehicle_type_id',
        'vehicle_category_id',
        'registration_no',
        'registration_pic',
        'image',
        'owner_name',
        'owner_mobile',
        'owner_address1',
        'owner_address2',
        'owner_city',
        'owner_state',
        'owner_pincode',
        'parking_location',
        'gpsenabled',
        'noentrypermit',
        'reg_validity',
        'insurance_validity',
        'vehicle_payload',
    ];

    public function vehicle_type() {
        return $this->belongsTo(VehicleType::class);
    }

}
