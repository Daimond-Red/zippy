<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Zippy {

    var $CI;
    var $apiURL;
    var $apiAdminURL;

    public function __construct($params = array()) {
        $this->CI = & get_instance();
        $this->apiURL = 'http://www.zippy.co.in/zippy/public/api/';
        $this->apiAdminURL = 'http://admin.zippy.co.in/api/';
    }

    public function isUserExits($data) {
        $response = $this->postRequest('customers/getProfile', $data, 'admin');
        return $response;
    }

    public function customer_register($data) {
        $response = $this->postRequest('customers/signup', $data);
        return $response;
    }

    public function vendor_register($data) {
        $response = $this->postRequest('vendors/signup', $data);
        return $response;
    }

    public function login($data) {
        $response = $this->postRequest('customers/signin', $data);
        return $response;
    }

    public function verify_otp($data) {
        $response = $this->postRequest('customers/verify-otp', $data);
        return $response;
    }

    public function resend_otp($data) {
        $response = $this->postRequest('customers/resent-otp', $data);
        return $response;
    }

    public function forgot_password($data) {
        $response = $this->postRequest('customers/forget-password', $data);
        return $response;
    }

    public function updateProfile($data) {

        if (isset($data['image'])) {
            $response = $this->postImageRequest('customers/updateProfile', $data);
        } else {
            $response = $this->postRequest('customers/updateProfile', $data);
        }

        return $response;
    }

    public function create_order($data) {
        $response = $this->postRequest('bookings/create', $data);
        return $response;
    }

    public function customer_orders($data) {
        $response = $this->postRequest('bookings/customer/my_history', $data);
        return $response;
    }

    public function getListOfAreas() {
        $response = $this->postRequest('getAreas');
        return $response;
    }

    public function getListOfCargos() {
        $response = $this->postRequest('typeOfCargos');
        return $response;
    }

    public function getSuggestedVehicles() {
        $response = $this->postRequest('suggestedVehicles');
        return $response;
    }

    public function getListOfVehiclesType() {
        $response = $this->postRequest('typeOfVehicleRequired');
        return $response;
    }

    public function postRequest($url, $fields = array(), $type = '') {
        $fields_string = "";
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        if ($type == 'admin') {
            curl_setopt($ch, CURLOPT_URL, $this->apiAdminURL . $url);
        } else {
            curl_setopt($ch, CURLOPT_URL, $this->apiURL . $url);
        }
        /* curl_setopt($ch, CURLOPT_HEADER, 1);
          curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data')); */
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);

        return $result;
    }

    public function postImageRequest($url, $fields = array(), $type = '') {

        //open connection
        $ch = curl_init();
        //  $headers = array("Content-Type:multipart/form-data");
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //set the url, number of POST vars, POST data
        if ($type == 'admin') {
            curl_setopt($ch, CURLOPT_URL, $this->apiAdminURL . $url);
        } else {
            curl_setopt($ch, CURLOPT_URL, $this->apiURL . $url);
        }
        /* curl_setopt($ch, CURLOPT_HEADER, 1);
          curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data')); */
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute post
        $result = curl_exec($ch);
        //close connection
        $error = curl_error($ch);
        curl_close($ch);
        //  echo '<pre>';
        //   print_r($result);
        //   echo '</pre>';
        //  exit;
        return $result;
    }

}

?>