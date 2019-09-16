<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model {

    protected $fillable = [
        'vendor_id',
        'name',
        'email',
        'image',
        'mobile',
        'licence_no',
        'licence_pic',
        'address1',
        'address2',
        'city',
        'state',
        'pincode',
    ];

    public function vendor() {
        return $this->belongsTo(User::class, 'vendor_id');
    }

}
