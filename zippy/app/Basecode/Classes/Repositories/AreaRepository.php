<?php

namespace App\Basecode\Classes\Repositories;

class AreaRepository extends Repository {

    public $model = '\App\Area';

    public $viewIndex = 'admin.areas.index';
    public $viewCreate = 'admin.areas.create';
    public $viewEdit = 'admin.areas.edit';
    public $viewShow = 'admin.areas.show';

    public $storeValidateRules = [
        'name' => 'required',
        'zipcode' => 'required|unique:areas,zipcode',
    ];

    public $updateValidateRules = [
        'name' => 'required',
        'zipcode' => 'required',
    ];

    public function getCollection() {
        $model = new $this->model;
        $model = $model->orderBy('created_at', 'desc');

        $whereLikefields = ['name', 'zipcode' ];

        foreach ($whereLikefields as $field) {
            if( $value = request($field) ) $model = $model->where($field, 'like', '%'.$value.'%');
        }

        return $model;
    }

}