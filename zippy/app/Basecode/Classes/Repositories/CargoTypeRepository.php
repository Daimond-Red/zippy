<?php

namespace App\Basecode\Classes\Repositories;

class CargoTypeRepository extends Repository {

    public $model = '\App\CargoType';

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
        $arr['cargo_type_id']   = (string)$this->prepare_field('id', $model);
        $arr['title']           = (string)$this->prepare_field('title', $model);

        return $arr;
    }

}