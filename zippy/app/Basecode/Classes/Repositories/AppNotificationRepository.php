<?php

namespace App\Basecode\Classes\Repositories;

class AppNotificationRepository extends Repository {

    public $model = '\App\AppNotification';

    public $viewIndex = 'admin.appNotifications.index';
    public $viewCreate = 'admin.appNotifications.create';
    public $viewEdit = 'admin.appNotifications.edit';
    public $viewShow = 'admin.appNotifications.show';

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

        // dd($attrs);

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

    public function getUserCollection( ) {
        $model = new \App\User;

        $whereLikefields = ['first_name', 'last_name', 'email' ];

        foreach ($whereLikefields as $field) {

            if( $value = \request($field) ) $model = $model->where($field, 'like', '%'.$value.'%');
        }

        if($val = \request('role')) $model = $model->where('role', $val);
        
        return $model;
    }

}