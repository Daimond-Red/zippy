<?php

namespace App\Basecode\Classes\Repositories;

use App\AppConfig;

class CustomerRepository extends Repository {

    public $model = '\App\User';

    public $viewIndex = 'admin.customers.index';
    public $viewCreate = 'admin.customers.create';
    public $viewEdit = 'admin.customers.edit';
    public $viewShow = 'admin.customers.show';

    public $storeValidateRules = [
        'first_name'    => 'required',
        'last_name'     => 'required',
        'email'         => 'required|email|unique:users,email',
        'password'      => 'required',
        'locations'     => 'required',
    ];

    public $updateValidateRules = [
        'first_name'    => 'required',
        'last_name'     => 'required',
        'email'         => 'required',
        'locations'     => 'required',
    ];

    public function getCollection() {
        $model = new $this->model;
        $model = $model->orderBy('created_at', 'desc')->where('role', \App\User::CUSTOMER);

        $whereLikefields = ['first_name', 'last_name', 'email', 'pancard_no', 'signup_type' ];

        foreach ($whereLikefields as $field) {

            if( $value = \request($field) ) $model = $model->where($field, 'like', '%'.$value.'%');
        }

        if(  array_key_exists('status', \request()->all()) && request('status') == 0 ) $model = $model->where('status', 0);

        if( request('status') == 1 ) $model = $model->where('status', 1);

        return $model;
    }

    public function find( $id ) {
        $model = $this->model;
        $model = $model::find($id);
        if( $model->role != \App\User::CUSTOMER ) throw new  \Illuminate\Database\Eloquent\ModelNotFoundException;
        return $model;
    }

    public function save( $attrs ) {

        $model = new $this->model;
        $model->fill($attrs);

        $attrs['status'] = 0;
        if( isset($attrs['role']) ) $model->role = $attrs['role']; // it's needed

        $model->save();

        return $model;

    }

    public function update($model, $attrs = null) {
        
        if(! $attrs ) $attrs = $this->getAttrs();

        $model->fill($attrs);

        if( isset($attrs['role']) )$model->role = $attrs['role']; // it's needed
        if( isset($attrs['status']) ) unset($attrs['status']);

        $model->update();
        return $model;

    }

    public function getAttrs()
    {
        $attrs = parent::getAttrs();
        $attrs['role'] = \App\User::CUSTOMER;

        if( $pass = request('password') ) {
            $attrs['password'] = bcrypt($pass);
        } elseif( array_key_exists('password', $attrs) ) {
            unset($attrs['password']);
        }

        $uploads = ['image'];
        if(request('image_type') == 'social'){
            $attrs['image'] = request('image');
        }else{
            if (filter_var(request('image'), FILTER_VALIDATE_URL)) {
                $attrs['image'] = $this->download_image(request('image'));
            } else {
                foreach ( $uploads as $upload ) {
                    if( request()->hasFile($upload) ){
                        $attrs[$upload] = self::upload_file($upload, 'vendors');
                    } elseif( $attrs && count($attrs) && array_key_exists($upload, $attrs) ) {
                        unset($attrs[$upload]);
                    }
                }
            }
        }
        
        return $attrs;

    }

    public function getRatting($id){
        $ratting = \App\ReviewRating::where('rated_id', $id)->avg('rating');
        return number_format($ratting, 1, '.', '');
    }

    public function parseModel($model) {

        $arr = [];
        $arr['customer_id'] = (int)$this->prepare_field('id', $model);
        $arr['first_name'] = (string)$this->prepare_field('first_name', $model);
        $arr['last_name'] = (string)$this->prepare_field('last_name', $model);
        $arr['email'] = (string)$this->prepare_field('email', $model);
        $arr['mobile_no'] = (string) $this->prepare_field('mobile_no', $model);
        $arr['pancard_no'] = (string) $this->prepare_field('pancard_no', $model);
        $arr['image_type'] = (string) $this->prepare_field('image_type', $model);
        $arr['image'] = (string)$this->prepare_field('image', $model);
        $arr['facebook_id'] = (string)$this->prepare_field('facebook_id', $model);
        $arr['gplus_id'] = (string)$this->prepare_field('gplus_id', $model);
        $arr['signup_type'] = (string)$this->prepare_field('signup_type', $model);
        $arr['locations'] = (string)$this->prepare_field('locations', $model);
        $arr['device_id'] = (string)$this->prepare_field('device_id', $model);
        $arr['device_type'] = (string)$this->prepare_field('device_type', $model);
        $arr['device_token'] = (string)$this->prepare_field('device_token', $model);
        $arr['rating'] = (string)$this->getRatting($model->id);
        $arr['status'] = (string)$this->prepare_field('status', $model);
        $arr['created_at'] = (string)$this->prepare_field('created_at', $model);
        $arr['aadhar_no'] = (string)$this->prepare_field('aadhar_no', $model);
        $arr['company_name'] = (string)$this->prepare_field('company_name', $model);
        $arr['business_type'] = (string)$this->prepare_field('business_type', $model);
        $arr['customer_type'] = (string)$this->prepare_field('customer_type', $model);
        $arr['gstin'] = (string)$this->prepare_field('gstin', $model);
        $arr['dashboard_text'] = (string) Appconfig::get_config_value('appCustomer', 'customer_dashboard_text');
        return $arr;
    }

}