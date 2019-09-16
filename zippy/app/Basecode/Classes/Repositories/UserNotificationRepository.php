<?php

namespace App\Basecode\Classes\Repositories;

class UserNotificationRepository extends Repository {

    public $model = '\App\UserNotification';

    public $viewIndex = '';
    public $viewCreate = '';
    public $viewEdit = '';
    public $viewShow = '';

    public $storeValidateRules = [
        'user_id'    => 'required',
        'message'     => 'required',
    ];

    public $updateValidateRules = [
        'user_id'    => 'required',
        'message'     => 'required',
    ];

    public function getCollection() {
        $model = new $this->model;
        $model = $model->orderBy('created_at', 'desc');

        if(  array_key_exists('user_id', request()->all())) $model = $model->where('user_id', request('user_id'));

        return $model;
    }

    public function notificationTrigger($userId, $notification, $otherData = null) {
        $model = new $this->model;
        $data = array
                (
                    'title'     => 'Zippy',
                    'message'   => $notification,
                    'sound'     => 'default'
                );
        $userDetails = \App\User::select('id', 'device_type', 'device_token')->whereIn('id', $userId)->get()->toArray();
        foreach($userDetails as $user){
            $insert = $model->create(['user_id' => $user['id'], 'message' => $notification]);
            if($insert){ sendPush($user, $data, $otherData); }
        }

        return $model;
    }

    public function parseModel($model) {

        $arr = [];
        $arr['id'] = (int)$this->prepare_field('id', $model);
        $arr['user_id'] = (string)$this->prepare_field('user_id', $model);
        $arr['message'] = (string)$this->prepare_field('message', $model);
        $arr['seen'] = (string)$this->prepare_field('seen', $model);

        return $arr;
    }

}