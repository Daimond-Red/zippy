<?php

namespace App\Basecode\Classes\Repositories;

class BookingStatusRepository extends Repository {

    public $model = '\App\BookingStatus';

    public $viewIndex = 'admin.cargotypes.index';
    public $viewCreate = 'admin.cargotypes.create';
    public $viewEdit = 'admin.cargotypes.edit';
    public $viewShow = 'admin.cargotypes.show';

    public $storeValidateRules = [
        'title' => 'required'
    ];

    public $updateValidateRules = [
        'title' => 'required'
    ];

    public function parseModel($model) {

        $arr = [];
        $arr['title']   = (string)$this->prepare_field('title', $model);
        $arr['color_code']           = (string)$this->prepare_field('color_code', $model);

        return $arr;
    }

}