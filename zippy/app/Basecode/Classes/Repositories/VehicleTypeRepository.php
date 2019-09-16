<?php

namespace App\Basecode\Classes\Repositories;

class VehicleTypeRepository extends Repository {

    public $model = '\App\VehicleType';

    public $viewIndex = 'admin.vehicletypes.index';
    public $viewCreate = 'admin.vehicletypes.create';
    public $viewEdit = 'admin.vehicletypes.edit';
    public $viewShow = 'admin.vehicletypes.show';

    public $storeValidateRules = [
        'title' => 'required'
    ];

    public $updateValidateRules = [
        'title' => 'required'
    ];

    public function parseModel($model) {

        $arr = [];
        $arr['vehicle_type_id'] = (string)$this->prepare_field('id', $model);
        $arr['title']           = (string)$this->prepare_field('title', $model);
        $arr['short_code']      = (string)$this->prepare_field('short_code', $model);

        return $arr;
    }

    public function getAttrs() {
        $attrs = parent::getAttrs();

        $uploads = ['icon'];

        foreach ( $uploads as $upload ) {
            if( request()->hasFile($upload) ){
                $attrs[$upload] = self::upload_file($upload, 'vendors');
            } elseif( $attrs && count($attrs) && array_key_exists($upload, $attrs) ) {
                unset($attrs[$upload]);
            }
        }

        return $attrs;
    }

}