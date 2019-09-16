<?php

use App\AppConfig;
use Twilio\Rest\Client;

// define('API_BASE', '');

function generateOTP(){
    return mt_rand(1111, 9999);
}

function sendOtp($mobile_no, $message = '') {


    $otp = generateOTP();

    if(!$message) $message = 'Please enter '.$otp.' as your one time verification for mobile number. Team Zippy';

    sendMessage($mobile_no, rawurlencode( $message ) );

    return $otp;

    $sender = 'ZippyO';
    $route = '4';
    $country = '91';
    $mobiles = $mobile_no;
    $authkey = '182030AOM3FNio06Wb5a7acf5c';

    try{
        $api = "http://api.msg91.com/api/sendhttp.php?sender=". $sender;

        $api .= '&route='. $route;
        $api .= '&country='. $country;
        $api .= '&message='. $message;
        $api .= '&mobiles='. $mobiles;
        $api .= '&authkey='. $authkey;

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $api);

        if( $res->getStatusCode() != 200 ) return [];

        $res = (array)json_decode($res->getBody());

    } catch ( Exception $e ) {

    }

    return $otp;
}

function executeApi($data, $url) {
    
    $base = 'http://zippy.co.in/zippy/public/api/'. decrypt($url);
    
    // return $base;
    $ch = curl_init();

    curl_setopt_array($ch, array(
        CURLOPT_URL => $base,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            "content-type: multipart/form-data"
        ),
    ));
    // curl_setopt($ch, CURLOPT_URL, $base);
    // curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_HTTPHEADER, array("cache-control: no-cache", "content-type: multipart/form-data"));

    $result = curl_exec($ch);

    $err = curl_error($ch);
    curl_close($ch);
    if(!$err) {
        return json_decode($result);
    } else {
        return "cURL Error #:" . $err;
    }
    
}

function sendMessage( $mobileNo, $message ) {

    $api = 'interconnectsms.com/sendurlcomma.aspx?user=20078677&pwd=sanjay_1973&senderid=ZIIPPY&mobileno='.$mobileNo.'&msgtext='.$message.'&smstype=0';
    
    try {

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $api);

    } catch ( \Exception $e ) {

    }
}

function getImageUrl($image) {
    if(!$image) return asset('uploads/not-found.png');
    return asset($image);
}

function getFrontImageUrl($image) {
    if(!$image) return 'http://zippy.co.in/zippy/public/uploads/not-found.png';
    return 'http://zippy.co.in/zippy/public/'. $image;
}

function getFrontMediaUrl($file) {
	return 'http://zippy.co.in/zippy/public/'. $file;
}

function currencySign() {
    return '₹';
}

function distanceSign() {
    return 'Km';
}

function redirectToDashboard() {
    return redirect()->route('admin.dashboard')->withErrors('Something went wrong');
}

if (! function_exists('sendAndroidPushNotification')) {

    function sendAndroidPushNotification($token, $notification, $otherData) {
        try {

            ini_set('display_errors', '1');
            error_reporting(E_ALL);
            // if(!$ids) return;

            $ch = curl_init("https://fcm.googleapis.com/fcm/send");

            //This array contains, the token and the notification. The 'to' attribute stores the token.
            $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
            if(!is_null($otherData)){
                $otkey["d"] = $otherData;
                $arrayToSend['data']= $otkey;
            }
            //Generating JSON encoded string form the above array.
            $json = json_encode($arrayToSend);
            //Setup headers:

            $fire_base_api_key = 'AIzaSyBT_j5MBbutEOYLlDjxMB0A-hhjzqg4bcM'; //setting('admin.firebase_api_key');

            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $fire_base_api_key;

            //Setup curl, add headers and post parameters.
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);       

            //Send the request
            $response = curl_exec($ch);

            //Close request
            curl_close($ch);
            // print_r($response);exit;
            return $response;


        } catch (Exception $e) {
            // echo $e->getMesssage();
            // die;
        }
    }

    function sendAndroidPushNotification2($registrationIDs, $data, $fire_base_api_key, $debug = false) {

        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';
        // $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array(
            'registration_ids' => $registrationIDs,
            'data' => $data,
        );

        $headers = array(
            'Authorization: key=' . $fire_base_api_key,
            'Content-Type: application/json'
        );

        // Open connection
        $ch = curl_init();

        // Set the URL, number of POST vars, POST data
        curl_setopt( $ch, CURLOPT_URL, $url);
        curl_setopt( $ch, CURLOPT_POST, true);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $fields));
        $result = curl_exec($ch);
        curl_close($ch);

        if($debug) {
            echo '<pre> Message=';
            print_r($result);
            die;
        }

    }

}

if (! function_exists('sendIOSPushNotification')) {

    function sendIOSPushNotification($deviceToken, $data, $otherData) {
        if(is_null($deviceToken) || $deviceToken == '' || strlen($deviceToken) < 64){
            return true;
        }
        $mode = 'sandbox';
        $PEM = '/var/www/html/';
        $passphrase = '123456';
        $ctx = stream_context_create();

        stream_context_set_option($ctx, 'ssl', 'local_cert', $PEM);

        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

        if($mode == 'sandbox') {
            // Open a connection to the APNS server
            $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
        } else {
            // Open a connection to the APNS server
            $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
        }

        // Put your alert message here:
        $message = $data['message'];

        $body['aps'] = array(
            'alert' => array(
                // 'title' => $data['title'],
                'body' => $message,
                'action-loc-key' => 'zippy',
            ),
            'badge' => 0,
            'sound' => 'default',
            // 'body' => $data['data'],
            );
        if(!is_null($otherData)){
            $body['aps']['data'] = $otherData;
        }

        // Encode the payload as JSON
        $payload = json_encode($body);

        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        // Close the connection to the server
        fclose($fp);
        return true;
    }

    function sendPush($user, $data, $otherData = null) {
        try {
            if( $user['device_type'] == 'ios' ) { 
            // WILL SEND PUSH NOTIFICATIONS TO IOS DEVICE.
                sendIOSPushNotification($user['device_token'], $data, $otherData);
            } else { 
            // WILL SEND PUSH NOTIFICATIONS TO ANDROID DEVICE
                sendAndroidPushNotification($user['device_token'], $data, $otherData);
            }
        } catch (Exception $e) {
             echo $e->getMessage();
        }
    }

}

function getNAddMailAddress($email = null){

    $arr = [
        'pleasefindphp@gmail.com',
    ];

    if( $email ) return array_merge($arr, [$email]);
    return $arr;

}

define('DATE_FORMAT', 'd-m-Y');
define('DATETIME_FORMAT', 'd-m-Y g:i A');
define('TIME_FORMAT', 'g:i A');

if (! function_exists('getDateTimeValue')) {

    function getDateTimeValue($date, $format = null) {

        if(!$format) $format = DATETIME_FORMAT;

        if( in_array($date, ['0000-00-00', '0000-00-00 00:00:00']) || (!$date)) return '';
        return date($format, strtotime($date));
    }

}

if (! function_exists('getDateValue')) {

    function getDateValue($date, $format = 'd-m-Y') {
        if( in_array($date, ['0000-00-00', '0000-00-00 00:00:00']) || (!$date)) return '';
        return date( $format, strtotime($date));
    }

}

if (! function_exists('getTimeValue')) {

    function getTimeValue($date) {
        if( in_array($date, ['0000-00-00', '0000-00-00 00:00:00']) || (!$date)) return '';
        return date(TIME_FORMAT, strtotime($date));
    }

}

function getAddressFromGoogle( $address = '', $lat = '', $lng = '' ){

    $data = [
        'lat'                   => '',
        'lng'                   => '',
        'locality'              => '',
        'street_number'         => '',
        'route'                 => '',
        'sublocality_level_1'   => '',
        'postal_code'           => '',
        'city'                  => '',
        'short_city'            => '',
        'state'                 => '',
        'short_state'           => '',
        'country'               => '',
        'short_country'         => '',
    ];

    if( $address ) {
        $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?key=AIzaSyAKrYvcyFVz3Ao4R60OzZzj0zttjzsQRwE&address='.urlencode($address).'&sensor=false');
    } else {
        $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?key=AIzaSyAKrYvcyFVz3Ao4R60OzZzj0zttjzsQRwE&latlng='.$lat.','.$lng.'&sensor=false');
    }

    $output = json_decode($geocode);

    // echo '<pre>'; print_r($output); die;

    if(! isset( $output->results ) ) return $data;
    if(! isset($output->results[0]) ) return $data;

    if( isset($output->results[0]->geometry) && isset( $output->results[0]->geometry->location ) && $output->results[0]->geometry->location->lat ) $data['lat'] = $output->results[0]->geometry->location->lat;
    if( isset($output->results[0]->geometry) && isset( $output->results[0]->geometry->location ) && $output->results[0]->geometry->location->lng ) $data['lng'] = $output->results[0]->geometry->location->lng;

    if( isset($output->results[0]->address_components) ) {

        foreach( $output->results[0]->address_components as $res ) {

            if( isset($res->types[0]) && $res->types[0] == 'administrative_area_level_1' ) {
                $data['state'] = $res->long_name;
                $data['short_state'] = $res->short_name;
            } elseif( isset($res->types[0]) && $res->types[0] == 'administrative_area_level_2' ) {
                $data['city'] = $res->long_name;
                $data['short_city'] = $res->short_name;
            } elseif( isset($res->types[0]) && $res->types[0] == 'country' ) {
                $data['country'] = $res->long_name;
                $data['short_country'] = $res->short_name;
            } elseif( isset($res->types[0]) && $res->types[0] == 'locality' ) {
                $data['locality'] = $res->long_name;
            }elseif( isset($res->types[2]) && $res->types[2] == 'sublocality_level_1' ) {
                $data['sublocality_level_1'] = $res->long_name;
            } elseif( isset($res->types[0]) && $res->types[0] == 'postal_code' ) {
                $data['postal_code'] = $res->long_name;
            } elseif( isset($res->types[0]) && $res->types[0] == 'street_number' ) {
                $data['street_number'] = $res->long_name;
            } elseif( isset($res->types[0]) && $res->types[0] == 'route' ) {
                $data['route'] = $res->long_name;
            }

        }

    }

    if( isset($output->results[0]->formatted_address) ) $data['address'] = $output->results[0]->formatted_address;

    return $data;

}

function sendNotification( $userId, $data, $isMessage = true, $debug = false ) {

    $data['title'] = 'Zippy';
    $data['sound'] = 'default';

    $userIds = [$userId];

    if( is_array($userId) ) $userIds = $userId;

    $iosVendorTokens = $iosCustomerTokens = $androidVendorTokens = $androidCustomerTokens = $mobileNos = $emails = [];

    $users = \App\User::whereIn('id', $userIds)->get(['device_type', 'device_token', 'role', 'mobile_no', 'email']);

    if(!$users) return [];

    // App notification store in database
    
    try {
        $notifiactionModel = new \App\AppNotification;

        $notifiactionModel->title = 'Booking Notification';
        $notifiactionModel->message = $data['body'];

        $notifiactionModel->save();

        $notifiactionModel->users()->sync( $userIds );
    } catch (\Exception $e) {
        
    }

    foreach ( $users as $user ) {

        if( $user->role == \App\User::CUSTOMER ) {

            if( $user->device_type == 'ios' ) {
                $iosCustomerTokens[] = $user->device_token;
            } else {
                $androidCustomerTokens[] = $user->device_token;
            }

        } else {

            if( $user->device_type == 'ios' ) {
                $iosVendorTokens[] = $user->device_token;
            } else {
                $androidVendorTokens[] = $user->device_token;
            }

        }

        $mobileNos[] = $user->mobile_no;
        $emails[] = $user->email;

    }

    try {
        // IOS CUSTOMERS
        if( count($iosCustomerTokens) ) {
            $key = Appconfig::get_config_value('pushnotification', 'ios_firebase_api_user1');
            sendIOSPushFirebaseNotification( $iosCustomerTokens, $data,  $key, $debug);
        }
    } catch (\Exception $e) {
        if($debug) {
            echo $e->getMessage();die;
        }
    }

    try {
        // IOS VENDORS
        if( count($iosVendorTokens) ) {
            $key = Appconfig::get_config_value('pushnotification', 'ios_firebase_api_user2');
            sendIOSPushFirebaseNotification( $iosVendorTokens, $data,  $key, $debug);
        }
    } catch (\Exception $e) {
        if($debug) {
            echo $e->getMessage();die;
        }
    }

    try {
        // ANDROID CUSTOMERS
        if( count($androidCustomerTokens) ) {
            $key = Appconfig::get_config_value('pushnotification', 'android_firebase_api_user1');
            sendIOSPushFirebaseNotification( $androidCustomerTokens, $data,  $key, $debug);
        }
    } catch (\Exception $e) {
        if($debug) {
            echo $e->getMessage();die;
        }
    }

    try {
        // ANDROID VENDORS
        if( count($androidVendorTokens) ) {
            $key = Appconfig::get_config_value('pushnotification', 'android_firebase_api_user2');
            sendIOSPushFirebaseNotification( $androidVendorTokens, $data,  $key, $debug);
        }
    } catch (\Exception $e) {
        if($debug) {
            echo $e->getMessage();die;
        }
    }

    foreach( $mobileNos as $mobileNo ) {
        if( $isMessage && $mobileNo && isset($data['body']) ) sendOtp( $mobileNo, $data['body'] );
    }

    try {

       // \Mail::send('emails.notifications', array('msg' => $data['body']), function($message) use( $emails ) {
       //     $message
       //             ->to($emails, 'Zippy Support')
       //             ->bcc('pleasefindphp@gmail.com', 'PleaseFindPhp ')
       //             ->subject('New Notification');
       // });
    } catch (\Exception $e) {
        if($debug) {
            echo $e->getMessage();die;
        }
    }

}


function sendNotification2( $userId, $data, $isMessage = true, $debug = false ) {

    $data['title'] = 'Zippy';
    $data['sound'] = 'default';

    $userIds = [$userId];

    if( is_array($userId) ) $userIds = $userId;

    $iosVendorTokens = $iosCustomerTokens = $androidVendorTokens = $androidCustomerTokens = $mobileNos = $emails = [];

    $users = \App\User::whereIn('id', $userIds)->get(['device_type', 'device_token', 'role', 'mobile_no', 'email']);

    if(!$users) return [];

    // App notification store in database
    
    // try {
    //     $notifiactionModel = new \App\AppNotification;

    //     $notifiactionModel->title = 'Booking Notification';
    //     $notifiactionModel->message = $data['body'];

    //     $notifiactionModel->save();

    //     $notifiactionModel->users()->sync( $userIds );
    // } catch (\Exception $e) {
        
    // }

    foreach ( $users as $user ) {

        if( $user->role == \App\User::CUSTOMER ) {

            if( $user->device_type == 'ios' ) {
                $iosCustomerTokens[] = $user->device_token;
            } else {
                $androidCustomerTokens[] = $user->device_token;
            }

        } else {

            if( $user->device_type == 'ios' ) {
                $iosVendorTokens[] = $user->device_token;
            } else {
                $androidVendorTokens[] = $user->device_token;
            }

        }

        $mobileNos[] = $user->mobile_no;
        $emails[] = $user->email;

    }

    try {
        // IOS CUSTOMERS
        if( count($iosCustomerTokens) ) {
            $key = Appconfig::get_config_value('pushnotification', 'ios_firebase_api_user1');
            sendIOSPushFirebaseNotification( $iosCustomerTokens, $data,  $key, $debug);
        }
    } catch (\Exception $e) {
        if($debug) {
            echo $e->getMessage();die;
        }
    }

    try {
        // IOS VENDORS
        if( count($iosVendorTokens) ) {
            $key = Appconfig::get_config_value('pushnotification', 'ios_firebase_api_user2');
            sendIOSPushFirebaseNotification( $iosVendorTokens, $data,  $key, $debug);
        }
    } catch (\Exception $e) {
        if($debug) {
            echo $e->getMessage();die;
        }
    }

    try {
        // ANDROID CUSTOMERS
        if( count($androidCustomerTokens) ) {
            $key = Appconfig::get_config_value('pushnotification', 'android_firebase_api_user1');
            sendIOSPushFirebaseNotification( $androidCustomerTokens, $data,  $key, $debug);
        }
    } catch (\Exception $e) {
        if($debug) {
            echo $e->getMessage();die;
        }
    }

    try {
        // ANDROID VENDORS
        if( count($androidVendorTokens) ) {
            $key = Appconfig::get_config_value('pushnotification', 'android_firebase_api_user2');
            sendIOSPushFirebaseNotification( $androidVendorTokens, $data,  $key, $debug);
        }
    } catch (\Exception $e) {
        if($debug) {
            echo $e->getMessage();die;
        }
    }

    foreach( $mobileNos as $mobileNo ) {
        if( $isMessage && $mobileNo && isset($data['body']) ) sendOtp( $mobileNo, $data['body'] );
    }

    try {

       // \Mail::send('emails.notifications', array('msg' => $data['body']), function($message) use( $emails ) {
       //     $message
       //             ->to($emails, 'Zippy Support')
       //             ->bcc('pleasefindphp@gmail.com', 'PleaseFindPhp ')
       //             ->subject('New Notification');
       // });
    } catch (\Exception $e) {
        if($debug) {
            echo $e->getMessage();die;
        }
    }

}
function sendIOSPushFirebaseNotification( $registrationIDs, $data, $fire_base_api_key, $debug = false ) {

    $fcmFields = [
        'registration_ids'  => $registrationIDs,
        'priority'          => 'high',
        'notification'      => $data
    ];

    $headers = array(
        'Authorization: key=' . $fire_base_api_key,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fcmFields ) );
    $result = curl_exec($ch );
    curl_close( $ch );

    if( $debug ) {
        echo $result . "\n\n";die;
    }

}

function getAmountToWord($number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise ;
}

function _t($tag) {

    return \App\AppTranslation::where('tag', $tag)->first()->value;

}

function getBookingStatusText( $model ) {

    if( $model->status != 3 ){
        return optional($model->booking_status)->title;
    } elseif( $model->status == 3 && $model->customer_id == $model->cancelled_by_id ){
        return 'Cancelled by Client';
    } else {
        return 'Cancelled by System Admin';
    }

}