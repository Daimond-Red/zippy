<?php

namespace App\Basecode\Classes\Repositories;

class DriverNotificationRepository extends Repository {

    public $model = '\App\DriverNotification';

    public $viewIndex = 'admin.driverNotifications.index';
    public $viewCreate = 'admin.driverNotifications.create';
    public $viewEdit = 'admin.driverNotifications.edit';
    public $viewShow = 'admin.driverNotifications.show';

    public $storeValidateRules = [
        'title' => 'required',
    ];

    public $updateValidateRules = [
        'title' => 'required',
    ];

    public function getCollection() {
        $model = new $this->model;
        $model = $model->orderBy('created_at', 'desc');

        $whereLikefields = ['title'];

        foreach ($whereLikefields as $field) {
            if( $value = request($field) ) $model = $model->where($field, 'like', '%'.$value.'%');
        }

        return $model;
    }

    public function parseModel($model) {
        $arr = [];

        $arr['notification_id'] = (string) $this->prepare_field('id', $model);
        $arr['title'] = (string) $this->prepare_field('title', $model);
        $arr['message'] = (string) $this->prepare_field('message', $model);
        $arr['created_at'] = (string) $this->prepare_field('created_at', $model);

        return $arr;
    }

    public function save( $attrs ) {

        $attrs = $this->getValueArray($attrs);

        $model = new $this->model;
        $model->fill($attrs);
        $model->save();

        if( $val = request('users') ) {

            $userIds = explode(',', $val);

            $model->users()->sync( $userIds );

            sendNotification2($userIds, [
                'notification_id'       => $model->id,
                'category'              => 'create_notification',
                'body'                  => request('message')
            ]);

        }


        return $model;
    }

}