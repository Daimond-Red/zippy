<?php

namespace App\Basecode\Classes\Repositories;

class BookingStatusTrackerRepository extends Repository {

    public $model = '\App\BookingStatusTracker';

    public $viewIndex = '';
    public $viewCreate = '';
    public $viewEdit = '';
    public $viewShow = '';

    public $storeValidateRules = [
        'booking_id' => 'required',
        'user_id' => 'required',
        'status' => 'required',
    ];

    public $updateValidateRules = [
        'booking_id' => 'required',
        'user_id' => 'required',
        'status' => 'required',
    ];



    public function parseModel($model) {

        $arr = [];
        $arr['booking_id']   = (int)$this->prepare_field('booking_id', $model);
        $arr['user_id']      = (int)$this->prepare_field('user_id', $model);
        $arr['status']      = (int)$this->prepare_field('status', $model);
        return $arr;
    }

}