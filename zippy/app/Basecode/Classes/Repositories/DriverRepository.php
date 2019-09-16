<?php

namespace App\Basecode\Classes\Repositories;

use App\User;

class DriverRepository extends Repository {

    public $model = '\App\User';

    public $viewIndex = 'admin.drivers.index';
    public $viewCreate = 'admin.drivers.create';
    public $viewEdit = 'admin.drivers.edit';
    public $viewShow = 'admin.drivers.show';

    public $storeValidateRules = [
        'mobile_no'  => 'required'
    ];

    public $updateValidateRules = [

    ];

    public function getAttrs()
    {
        $attrs = parent::getAttrs();

        $uploads = ['licence_pic', 'image'];

        foreach ( $uploads as $upload ) {
            if( request()->hasFile($upload) ){
                $attrs[$upload] = self::upload_file($upload, 'drivers');
            } elseif( $attrs && count($attrs) && array_key_exists($upload, $attrs) ) {
                unset($attrs[$upload]);
            }
        }

        if( $val = request('name') ) $attrs['first_name'] = $val;
        if( $val = request('mobile') ) $attrs['mobile_no'] = $val;
        if( $pass = request('password') ) $attrs['password'] = bcrypt($pass);

        $attrs['role'] = User::DRIVER;

        return $attrs;

    }

    public function save( $attrs ) {

        $attrs = $this->getValueArray($attrs);

        $model = new $this->model;
        $model->fill($attrs);
        $model->role = User::DRIVER;
        $model->save();
        return $model;
    }

    public function getRatting($id){
        $ratting = \App\ReviewRating::where('rated_id', $id)->where('type', 'driver')->avg('rating');
        return number_format($ratting, 1, '.', '');
    }


    public function parseModel($model) {

        $arr = [];
        $arr['driver_id'] = (int)$this->prepare_field('id', $model);

        $arr['name']  = (string)$this->prepare_field('first_name', $model);
        $arr['email']  = (string)$this->prepare_field('email', $model);
        $arr['image']  = (string)$this->prepare_field('image', $model);
        $arr['mobile']  = (string)$this->prepare_field('mobile_no', $model);
        $arr['rating'] = (string)$this->getRatting($model->id);;
        $arr['licence_no']  = (string)$this->prepare_field('licence_no', $model);
        $arr['licence_pic']  = (string)$this->prepare_field('licence_pic', $model);
        $arr['dl_valid_upto']  = (string)$this->prepare_field('dl_valid_upto', $model);
        $arr['address1']  = (string)$this->prepare_field('address1', $model);
        $arr['address2']  = (string)$this->prepare_field('address2', $model);
        $arr['city']  = (string)$this->prepare_field('city', $model);
        $arr['state']  = (string)$this->prepare_field('state', $model);
        $arr['pincode']  = (string)$this->prepare_field('pincode', $model);

        $arr['created_at'] = (string)$this->prepare_field('created_at', $model);

        return $arr;
    }

    public function getCollection() {
        $model = new $this->model;
        $model = $model->where('role', User::DRIVER)->orderBy('created_at', 'desc');
        return $model;
    }

    public function find( $id ) {
        $model = $this->model;
        $model = $model::find($id);
        if( $model->role != \App\User::DRIVER ) throw new  \Illuminate\Database\Eloquent\ModelNotFoundException;
        return $model;
    }

}