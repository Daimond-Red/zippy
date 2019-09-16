<?php

namespace App\Basecode\Classes\Repositories;

class PaymentTypeRepository extends Repository {

    public $model = '\App\PaymentType';

    public $viewIndex = 'admin.paymentTypes.index';
    public $viewCreate = 'admin.paymentTypes.create';
    public $viewEdit = 'admin.paymentTypes.edit';
    public $viewShow = 'admin.paymentTypes.show';

    public $storeValidateRules = [
        'title' => 'required|unique:payment_types,title',
    ];

    public $updateValidateRules = [
        'title' => 'required',
    ];

    public function parseModel($model)
    {
        $arr = [];

        $arr['payment_type'] = (string)$this->prepare_field('id', $model);
        $arr['title'] = (string)$this->prepare_field('title', $model);

        return $arr;
    }

}