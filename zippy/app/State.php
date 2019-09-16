<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model {
        
    public $timestamps = false;
        
	protected $fillable = [
		'title',
	];

	const DEFAULT_STATE = 3186;

	public static $india_id = 101;

	public function cities() {
		return $this->hasMany('City');
	}

	public static function get_lists() {

		if (!config()->has('state_lists')) {
			$value = config()->rememberForever('state_lists', function() {
			    return State::pluck('title', 'id');
			});
		} else {
			$value = config()->get('state_lists');
		}

		return $value;
	}

}
