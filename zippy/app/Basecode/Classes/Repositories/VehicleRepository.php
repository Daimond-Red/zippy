<?php

namespace App\Basecode\Classes\Repositories;

class VehicleRepository extends Repository {

    public $model = '\App\Vehicle';

    public $viewIndex = 'admin.vehicles.index';
    public $viewCreate = 'admin.vehicles.create';
    public $viewEdit = 'admin.vehicles.edit';
    public $viewShow = 'admin.vehicles.show';

    public $storeValidateRules = [

    ];

    public $updateValidateRules = [

    ];

    public $vehicleTypeRepository;

    public function __construct( VehicleTypeRepository $vehicleTypeRepository ) {
        $this->vehicleTypeRepository = $vehicleTypeRepository;
    }

    public function getAttrs()
    {
        $attrs = parent::getAttrs();

        $uploads = ['image', 'registration_pic'];

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

        $arr['id'] = (string) $this->prepare_field('id', $model);
        $arr['vendor_id'] = (string) $this->prepare_field('vendor_id', $model);
        $arr['vehicle_type_id'] = (string) $this->prepare_field('vehicle_type_id', $model);
        $arr['vehicle_category_id'] = (string) $this->prepare_field('vehicle_category_id', $model);
        $arr['registration_no'] = (string) $this->prepare_field('registration_no', $model);
        $arr['registration_pic'] = (string) $this->prepare_field('registration_pic', $model);
        $arr['image'] = (string) $this->prepare_field('image', $model);
        $arr['owner_name'] = (string) $this->prepare_field('owner_name', $model);
        $arr['owner_mobile'] = (string) $this->prepare_field('owner_mobile', $model);
        $arr['owner_address1'] = (string) $this->prepare_field('owner_address1', $model);
        $arr['owner_address2'] = (string) $this->prepare_field('owner_address2', $model);
        $arr['owner_city'] = (string) $this->prepare_field('owner_city', $model);
        $arr['owner_state'] = (string) $this->prepare_field('owner_state', $model);
        $arr['owner_pincode'] = (string) $this->prepare_field('owner_pincode', $model);
        $arr['parking_location'] = (string) $this->prepare_field('parking_location', $model);
        $arr['gpsenabled'] = (string) $this->prepare_field('gpsenabled', $model);
        $arr['noentrypermit'] = (string) $this->prepare_field('noentrypermit', $model);

        $arr['reg_validity'] = (string) $this->prepare_field('reg_validity', $model);
        $arr['insurance_validity'] = (string) $this->prepare_field('insurance_validity', $model);
        $arr['vehicle_payload'] = (string) $this->prepare_field('vehicle_payload', $model);

        $arr['created_at'] = (string) $this->prepare_field('created_at', $model);

        $arr['vehicle_type'] = new \stdClass();

        if( isset($model->vehicle_type) && $model->vehicle_type ) $arr['vehicle_type'] = $this->vehicleTypeRepository->parseModel($model->vehicle_type);

        return $arr;

    }

}