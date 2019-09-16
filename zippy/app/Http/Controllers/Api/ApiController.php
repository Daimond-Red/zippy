<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Http\Controllers\Controller;

class ApiController extends Controller {

    protected function cvalidate( $rules, $attrs = [] ) {

        if(! count($attrs) ) $attrs = request()->all();
        $validation = Validator::make( $attrs, $rules );
        if(! $validation->fails() ) return false;
        return $validation->messages();

    }

    protected function error($messages = [], $message = '') {

        try {

            $response = json_encode($messages);

            \DB::table('logs')->insert([
                'url'       =>  request()->url(),
                'json'      => json_encode(request()->all()),
                'req'       => serialize(request()->all()),
                'res'       => $response,
                'status'    => false,
                'created_at'=> date('Y-m-d H:i:s')
            ]);

        } catch (\Exception $e) {

        }

        if((!$messages) && is_array($messages)) return ['error' => true, 'data' => new \stdClass, 'message' => $message];
        if(!$messages) return ['error' => true, 'data' => new \stdClass, 'message' => $message];
        return ['error' => true, 'data' => $messages, 'message' => $message];
    }

    protected function data($res, $message = '', $results_name = 'results') {

        try {

            $response = json_encode($res);

            \DB::table('logs')->insert([
                'url'       => request()->url(),
                'json'      => json_encode(request()->all()),
                'req'       => json_encode(request()->all()),
                'res'       => $response,
                'status'    => true,
                'created_at'=> date('Y-m-d H:i:s')
            ]);

        } catch ( \Exception $e) {
//            echo $e->getMessage();die;
        }
        
        if((!$res) && is_array($res))  return response()->json (['error' => false, 'data' => [ $results_name => [] ], 'message' => $message ]);

        if(!$res) return response()->json (['error' => false, 'data' => [ $results_name => [] ], 'message' => $message ]);
        return response()->json (['error' => false, 'data' => [ $results_name => $res ], 'message' => $message ]);
    }

    protected function emptyData($res, $message = '', $results_name = 'results') {

        try {

            $response = json_encode($res);

            \DB::table('logs')->insert([
                'url'       => request()->url(),
                'json'      => json_encode(request()->all()),
                'req'       => json_encode(request()->all()),
                'res'       => $response,
                'status'    => true,
                'created_at'=> date('Y-m-d H:i:s')
            ]);

        } catch ( \Exception $e) {
//            echo $e->getMessage();die;
        }

        return response()->json (['error' => false, 'data' => [ $results_name => [] ], 'message' => $message ]);

    }

}
