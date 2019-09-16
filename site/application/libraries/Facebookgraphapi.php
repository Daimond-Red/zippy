<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facebookgraphapi {
    var  $app_id;
    var $app_secret;
    public function __construct($params = array())
    {
        $this->CI =& get_instance();
        $this->apiURL = 'https://graph.facebook.com/endpoint?';
        
        $this->app_id ='142841113051085';
        $this->app_secret ='b97bf62511aabdfac529fba6a7077849';
        
    }

    public function get_user_info($access_token){
        $fb = new Facebook\Facebook([
              'app_id' => $this->app_id,
              'app_secret' => $this->app_secret,
              'default_graph_version' => 'v2.12',
              ]);
            
            try {
              // Returns a `Facebook\FacebookResponse` object
              $response = $fb->get('/me?fields=id,name,email', $access_token);
              $response = $response->getDecodedBody();
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
              echo 'Graph returned an error: ' . $e->getMessage();
              exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
              echo 'Facebook SDK returned an error: ' . $e->getMessage();
              exit;
            }
        return $response;
    }
    
    public function postRequest($url,$fields = array()){
        
        $fields_string = "";
        foreach($fields as $key=>$value) {
        $fields_string .= $key.'='.$value.'&';
        }
        rtrim($fields_string,'&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL,$this->apiURL.$url);
        curl_setopt($ch,CURLOPT_POST,count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);

        return $result;
    }
}