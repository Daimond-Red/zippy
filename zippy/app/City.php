<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model {

    public $timestamps = false;
        
	protected $fillable = [
		'title',
        'state_id'
	];

	const DEFAULT_CITY = 37541;

    public static function getCitiesNames($id, $isArray = false) {

        if(! is_array($id) ) $id = [$id];

        if( $isArray ) return City::whereIn('id', $id)->pluck('title')->toArray();

        return implode(', ', City::whereIn('id', $id)->pluck('title')->toArray());

    }

    public static function getStatesNames($id, $isArray = false) {

        if(! is_array($id) ) $id = [$id];

        if( $isArray ) return State::whereIn('id', $id)->pluck('title')->toArray();

        return implode(', ', State::whereIn('id', $id)->pluck('title')->toArray());

    }

    public function states() {
		return $this->hasOne('State');
	}

	public static function get_lists() {

		if (!cache()->has('city_lists')) {
			$value = cache()->rememberForever('city_lists', function() {
			    return City::pluck('title', 'id');
			});
		} else {
			$value = cache()->get('city_lists');
		}

		return $value;
	}

}
