<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewRating extends Model {

    protected $fillable = [
        'booking_id',
        'rated_by_id',
        'rated_id',
        'rating',
        'review',
    ];

    public function rating_by() {
        return $this->belongsTo(User::class, 'rated_by_id');
    }

}
