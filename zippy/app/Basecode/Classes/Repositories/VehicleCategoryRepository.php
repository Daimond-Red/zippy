<?php

namespace App\Basecode\Classes\Repositories;

class VehicleCategoryRepository extends Repository {

    public $model = '\App\VehicleCategory';

    public $viewIndex = 'admin.vehiclecategories.index';
    public $viewCreate = 'admin.vehiclecategories.create';
    public $viewEdit = 'admin.vehiclecategories.edit';
    public $viewShow = 'admin.vehiclecategories.show';

    public $storeValidateRules = [
        'title' => 'required'
    ];

    public $updateValidateRules = [
        'title' => 'required'
    ];

    public function getAttrs()
    {
        $attrs = parent::getAttrs();

        $uploads = ['image'];

        foreach ( $uploads as $upload ) {
            if( request()->hasFile($upload) ){
                $attrs[$upload] = self::upload_file($upload, 'vendors');
            } elseif( $attrs && count($attrs) && array_key_exists($upload, $attrs) ) {
                unset($attrs[$upload]);
            }
        }

        return $attrs;

    }

    public function parseModel($model) {

        $arr = [];
        $arr['vehicle_category_id'] = (string)$this->prepare_field('id', $model);
        $arr['title']               = (string)$this->prepare_field('title', $model);
        $arr['image']               = (string)$this->prepare_field('image', $model);
        $arr['price']               = (string)$this->prepare_field('price', $model);
        $arr['max_gross_weight']    = (string)$this->prepare_field('title', $model);
        $arr['max_carton_length']   = (string)$this->prepare_field('title', $model);
        $arr['max_carton_breadth']  = (string)$this->prepare_field('title', $model);
        $arr['max_carton_height']   = (string)$this->prepare_field('title', $model);

        return $arr;
    }

}