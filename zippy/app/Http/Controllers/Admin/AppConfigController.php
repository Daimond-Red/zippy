<?php

namespace App\Http\Controllers\Admin;

use App\AppConfig;
use App\AppTranslation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppConfigController extends Controller {

    public function configurations() {

        $fields = [
            'ios_firebase_api_user1',
            'android_firebase_api_user1',
            'ios_firebase_api_user2',
            'android_firebase_api_user2',
        ];

        $data = [];

        foreach ($fields as $field) $data[$field] = Appconfig::get_config_value('pushnotification', $field);

        return view('configurations.pushnotifications.index', $data);
    }

    public function push_user1_store() {

        $attrs = request()->all();

        $fields = [
            'ios_firebase_api_user1',
            'android_firebase_api_user1',
        ];

        $files = ['sandbox_pem_user1', 'production_pem_user1'];

        foreach( $files as $file ) {
            if(! request()->hasFile($file) ) unset( $attrs[$file] );
        }

        foreach ($fields as $field) {
            if(array_key_exists($field, $attrs) ) Appconfig::save_config_value('pushnotification', $field, request($field, '') );
        }

        return redirect()->back()->withSuccess('Configuration saved');

    }

    public function push_user2_store() {

        $attrs = request()->all();

        $fields = [
            'ios_firebase_api_user2',
            'android_firebase_api_user2',
        ];

        $files = ['sandbox_pem_user2', 'production_pem_user2'];

        foreach( $files as $file ) {
            if(! request()->hasFile($file) ) unset( $attrs[$file] );
        }

        foreach ($fields as $field) {
            if(array_key_exists($field, $attrs) ) Appconfig::save_config_value('pushnotification', $field, request($field, '') );
        }

        return redirect()->back()->withSuccess('Configuration saved');

    }

    public function send_create() {
        return view('configurations.pushnotifications.send');
    }

    public function send() {

        if( \request('user_type') == 'customer' ) {

            if ( \request('device_type') == 'ios' ) {
                $key = Appconfig::get_config_value('pushnotification', 'ios_firebase_api_user1');
            } else {
                $key = Appconfig::get_config_value('pushnotification', 'android_firebase_api_user1');
            }

        } else {

            if ( \request('device_type') == 'ios' ) {
                $key = Appconfig::get_config_value('pushnotification', 'ios_firebase_api_user2');
            } else {
                $key = Appconfig::get_config_value('pushnotification', 'android_firebase_api_user2');
            }

        }

        $data = [
            'title'     => \request('title'),
            'message'   => \request('description'),
            'body'   => \request('description'),
            'category'  => 'test',
            'data'      => [
                'test_id'       => 2,
                'test_content'  => 'test'
            ],
        ];

        sendIOSPushFirebaseNotification( [request('device_token')], $data,  $key, true);

        return redirect()->back()->withSuccess('Push Notification Send');

    }

    public function upload_image( $img = 'image' ) {

        $url = '';

        if (! request()->hasFile( $img ) ) return $url;

        $file = request()->file( $img );

        $url = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) .'.'. $file->getClientOriginalExtension();

        $image = $url;

        $file->move(public_path(), $url);

        return $image;

    }

    public function translation() {
        $collection = AppTranslation::orderBy('id', 'desc')->get();
        return view('configurations.translation', compact('collection'));
    }

    public function translationStore() {

        $languageId = 1;

        $model = new AppTranslation;
        $model->language_id = $languageId;
        $model->comment = request('comment');
        $model->value = request('value');
        $model->save();

        if( request('tag') ) {
            $model->tag = str_slug(\request('tag'), '_'). '_'. $model->id;
        } else {
            $model->tag = 'tag_field_'. $model->id;
        }

        $model->save();

        return ['status' => 1, 'msg' => 'Added Successfully'];

    }

    public function translationUpdate($id) {

        $model = AppTranslation::findOrFail($id);

        $model->value = request('value');
        $model->comment = request('comment');
        $model->save();

        return ['status' => 1, 'msg' => 'Updated Successfully'];

    }

    public function translationRemove( $id ) {

        $model = AppTranslation::findOrFail($id);
        $model->delete();

        return ['status' => 1, 'msg' => 'Removed Successfully'];

    }

    public function dashboardText() {

        $fields = [
            'customer_dashboard_text',
        ];

        $data = [];

        foreach ($fields as $field) $data[$field] = Appconfig::get_config_value('appCustomer', $field);

        return view('configurations.customer_dashboard_text', $data);

    }

    public function dashboardTextStore() {

        $attrs = request()->all();

        $fields = [
            'customer_dashboard_text',
        ];

        foreach ($fields as $field) {
            if(array_key_exists($field, $attrs) ) Appconfig::save_config_value('appCustomer', $field, request($field, '') );
        }

        return redirect()->back()->withSuccess('Configuration saved');

    }
}
