<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {

	protected $fillable = [
		'sortname',
		'name',
	];

	const DEFAULT_COUNTRY = 101;

	public function states() {
		return $this->hasMany('State');
	}

	public static function get_lists() {

		if (!cache()->has('country_lists')) {
			$value = cache()->rememberForever('country_lists', function() {
                return Country::get(['name', 'id']);
			});
		} else {
			$value = cache()->get('country_lists');
		}

		return $value;
	}

}