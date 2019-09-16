<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppNotification extends Model {

    protected $fillable = [
        'title',
        'message',
    ];

    public function users() {
        return $this->belongsToMany(User::class);
    }

}
