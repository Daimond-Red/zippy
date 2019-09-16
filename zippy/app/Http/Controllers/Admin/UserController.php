<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function searchCities() {

        $data = [];

        $collection = new \App\City();

        if( $val = request('state_id') ) {
            $collection = $collection->where('state_id', $val);
        } else {
            $stateIds = State::where('country_id', Country::DEFAULT_COUNTRY)->pluck('id');
            $collection = $collection->whereIn('state_id', $stateIds);
        }

        if( request('q') ) $collection = $collection->where('title', 'like', '%'. request('q'). '%');

        $collection = $collection->take(20)->get(['id', 'title']);

        foreach($collection as $model) $data['items'][] = [
            'id' => $model->id,
            'text' => $model->title
        ];

        return $data;

    }

    public function searchStates() {

        $data = [];

        $collection = new \App\State();

        if( $val = request('country_id') ) {
            $collection = $collection->where('country_id', $val);
        } else {
            $collection = $collection->where('country_id', Country::DEFAULT_COUNTRY);
        }

        if( request('q') ) $collection = $collection->where('title', 'like', '%'. request('q'). '%');

        $collection = $collection->take(20)->get(['id', 'title']);

        foreach($collection as $model) $data['items'][] = [
            'id' => $model->id,
            'text' => $model->title
        ];

        return $data;

    }

    public function globalSearch() {

        $collection = new \App\User;

        if( request('q') ) {
            $collection = $collection->where(function($q){
                $q->orWhere('mobile_no', 'like', '%'.request('q').'%');
            });
        }

        $collection = $collection->whereIn('role', [
            \App\User::VENDOR,
            \App\User::DRIVER,
            \App\User::CUSTOMER,
        ])->orderBy('id')->take(8)->get();

        return view('admin.globalSearch', compact('collection'));

    }

}
