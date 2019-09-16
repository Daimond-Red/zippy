<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleCategory extends Model
{
    protected $fillable = [
        'title',
        'image',
        'price',
        'max_gross_weight',
        'max_carton_length',
        'max_carton_breadth',
        'max_carton_height',
    ];

}
