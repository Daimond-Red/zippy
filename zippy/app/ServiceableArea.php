<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceableArea extends Model {

    protected $fillable = [
        'user_id',
        'base_city_id',
        'base_state_id',
        'drop_city_id',
        'drop_state_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function baseCity() {
        return $this->belongsTo(City::class, 'base_city_id');
    }

    public function dropCity() {
        return $this->belongsTo(City::class, 'drop_city_id');
    }

    public function baseState() {
        return $this->belongsTo(State::class, 'base_state_id');
    }

    public function dropState() {
        return $this->belongsTo(State::class, 'drop_state_id');
    }

    public function vendors() {
        return $this->hasMany(User::class, 'user_id');
    }

}
