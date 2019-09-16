<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppConfig extends Model {

    protected $fillable = [
        'module',
        'field',
        'value',
    ];

    public static function get_config_value ($module, $field) {
        $model = Appconfig::where('module', $module)->where('field', $field)->first();
        if(!$model) return '';
        return $model->value;
    }

    public static function save_config_value ( $module, $field, $value ) {

        $model = Appconfig::where('module', $module)->where('field', $field)->first();
        if(!$model) $model = new Appconfig;

        if( request()->hasFile($field) ) {

            $file = request()->file($field);
            $url = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) .'.'. $file->getClientOriginalExtension();
            $value = 'uploads/pem/'. $url;
            $file->move(public_path(). '/uploads/pem/', $url);

            $model->module = $module;
            $model->field = $field;
            $model->value = $value;
            $model->save();
            return $model;

        } elseif( array_key_exists($field, request()->all()) ) {

            $model->module = $module;
            $model->field = $field;
            $model->value = $value;
            $model->save();
            return $model;
        }


    }

}
