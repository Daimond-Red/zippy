<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends MY_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('is_login') == 'true') {
            redirect("dashboard/create_order");
        }
    }

    public function signup() {
        $data = array();
        $data['error'] = 0;
        if ($this->input->post()) {
            $postData = $this->input->post();
            $mobile_no = $postData['mobile_no'];
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
            $this->form_validation->set_rules('mobile_no', 'Mobile Number', 'required|min_length[10]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('type', 'Type', 'required');
            if ($postData['type'] == 'vendor') {
                $this->form_validation->set_rules('v_pancard_no', 'Pancard', 'required|min_length[10]');
                $this->form_validation->set_rules('company_name', 'Company Name', 'required');
                $this->form_validation->set_rules('gstin', 'GSTIN', 'required');
                $this->form_validation->set_rules('service_area', 'Service Area', 'required');
            } else {
                $this->form_validation->set_rules('pancard_no', 'Pancard', 'required|min_length[10]');
            }
            if ($this->form_validation->run() != FALSE) {
                $response = $this->register($postData);
                $response = json_decode($response, true);
                if ($response['error'] == 1) {
                    $data['error'] = 1;
                    $data['errorData'] = $response['data'];
                    $this->session->set_flashdata('error', $response['message']);
                } else {
                    if ($postData['type'] == 'vendor') {
                        $this->session->set_flashdata('vendor_register', $response['message']);
                        redirect("/");
                    }else{
                        $data['message'] = $response['message'];
                        $this->session->set_flashdata('success', $response['message']);
                        redirect("/verify-otp?mobile_no=" . $mobile_no);
                    }
                }
            }
        }
        $this->loadFrontView('signup', $data);
    }

    public function register($postData) {

        $data['first_name'] = $postData['first_name'];
        $data['last_name'] = $postData['last_name'];
        $data['mobile_no'] = $postData['mobile_no'];
        $data['email'] = $postData['email'];
        $data['password'] = $postData['password'];
        $data['signup_type'] = 'normal';
        if ($postData['type'] == 'vendor') {
            $data['company_name'] = $postData['company_name'];
            $data['gstin'] = $postData['gstin'];
            $data['pancard_no'] = $postData['v_pancard_no'];
        } else {
            $data['pancard_no'] = $postData['pancard_no'];
        }

        if ($postData['type'] == 'vendor') {
            $response = $this->zippy->vendor_register($data);
        } else {
            $response = $this->zippy->customer_register($data);
        }

        return $response;
    }

    public function login() {
        $data = array();

        if ($this->input->post()) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if ($this->form_validation->run() != FALSE) {
                $postData = $this->input->post();
                $data['email'] = $postData['email'];
                $data['password'] = $postData['password'];
                $data['device_id'] = '1122334455';
                $data['device_type'] = 'ios';
                $data['device_token'] = 'A7393NJ873NFH327RNJMVKSD983KJXJUFRHY';
                $response = $this->zippy->login($data);
                $response = json_decode($response, true);

                if ($response['error'] == 1) {
                    $data['error'] = 1;

                    if ($response['message'] == 'your account is not verified yet') {
                        $cdata['email'] = $postData['email'];
                        $is_exists = json_decode($this->zippy->isUserExits($cdata), true);

                        $udata['mobile_no'] = $is_exists['data']['results']['mobile_no'];
                        $res = json_decode($this->zippy->resend_otp($postData), true);
                        redirect("/verify-otp?mobile_no=" . $udata['mobile_no']);
                    }

                    $data['message'] = $response['message'];
                } else {
                    $userData = $response['data']['customer_details'];
                    $this->session->set_userdata('is_login', 'true');
                    $this->session->set_userdata('userData', $userData);
                    $this->session->set_flashdata('success', $response['message']);
                    redirect("/dashboard/create_order");
                }
            }
        }
        $this->loadFrontView('login', $data);
    }

    public function google() {
        $clientId = '433789051680-8j2ainh9h0tvntsn5uk6quqi40spc6p8.apps.googleusercontent.com'; //Google client ID
        $clientSecret = 'uuNpl0KQ7VeKnd6crEHCGFJe'; //Google client secret
        $redirectURL = base_url() . 'google';

        //Call Google API
        $gClient = new Google_Client();
        $gClient->setApplicationName('Login');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectURL);
        $google_oauthV2 = new Google_Oauth2Service($gClient);

        if (isset($_GET['code'])) {
            $gClient->authenticate($_GET['code']);
            $_SESSION['token'] = $gClient->getAccessToken();
            //header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
        }

        if (isset($_SESSION['token'])) {
            $gClient->setAccessToken($_SESSION['token']);
        }

        if ($gClient->getAccessToken()) {
            $userProfile = $google_oauthV2->userinfo->get();

            $udata['first_name'] = $userProfile['given_name'];
            $udata['last_name'] = $userProfile['family_name'];
            $udata['email'] = $userProfile['email'];
            $udata['password'] = 'test';
            $udata['signup_type'] = 'normal';
            $udata['gplus_id'] = $userProfile['id'];

            $this->session->set_flashdata('userInfo', $udata);

            $cdata['email'] = $userProfile['email'];
            $is_exists = json_decode($this->zippy->isUserExits($cdata), true);
            if ($is_exists['error'] == 1) {
                $this->session->set_flashdata('userInfo', $udata);
                redirect("/customers/confirm_registration");
            } else {
                $userData = $is_exists['data']['results'];
                $this->session->set_userdata('is_login', 'true');
                $this->session->set_userdata('userData', $userData);
                $this->session->set_flashdata('success', "Your are login successfully");
                redirect("/dashboard/create_order");
            }
            //redirect("/customers/confirm_registration");

            $userData = $response['data']['customer_details'];

            return $response;
        } else {
            $url = $gClient->createAuthUrl();
            header("Location: $url");
            exit;
        }
    }

    public function set_fb_access_token() {
        $access_token = $this->input->post("access_token");
        $this->session->set_userdata("fb_access_token", $access_token);
        echo $this->session->userdata('fb_access_token');
    }

    public function facebook_success() {
        $access_token = $this->session->userdata('fb_access_token');
        $response = $this->facebookgraphapi->get_user_info($access_token);

        $name = explode(" ", $response['name']);
        $udata['first_name'] = $name[0];
        $udata['last_name'] = $name[1];
        $udata['email'] = $response['email'];
        $udata['password'] = 'test';
        $udata['signup_type'] = 'normal';
        $udata['facebook_id'] = $response['id'];

        $this->session->set_flashdata('userInfo', $udata);
        $cdata['email'] = $response['email'];
        $is_exists = json_decode($this->zippy->isUserExits($cdata), true);

        if ($is_exists['error'] == 1) {
            $this->session->set_flashdata('userInfo', $udata);
            redirect("/customers/confirm_registration");
        } else {
            $userData = $is_exists['data']['results'];
            $this->session->set_userdata('is_login', 'true');
            $this->session->set_userdata('userData', $userData);
            $this->session->set_flashdata('success', "Your are login successfully");
            redirect("/dashboard/create_order");
        }
        //redirect("/customers/confirm_registration");
    }

    public function verify_otp() {
        $data = array();
        $data['mobile_no'] = $this->input->get('mobile_no');
        $data['email'] = $this->input->get('email');
        if ($this->input->post()) {
            $postData = $this->input->post();
            $mobile_no = $this->input->post('mobile_no');
            if (isset($postData['verify_otp'])) {


                $udata['mobile_no'] = $this->input->post('mobile_no');
                $udata['otp'] = $this->input->post('otp');
                $response = json_decode($this->zippy->verify_otp($postData), true);
                if ($response['error'] == 1) {
                    $this->session->set_flashdata('error', $response['message']);
                } else {
                    $this->session->set_flashdata('success', $response['message']);

                    $cdata['email'] = $postData['email'];
                    $is_exists = json_decode($this->zippy->isUserExits($cdata), true);
                    if ($is_exists['error'] == 1) {
                        $this->session->set_flashdata('userInfo', $udata);
                        redirect("/customers/confirm_registration");
                    } else {
                        $userData = $is_exists['data']['results'];
                        $this->session->set_userdata('is_login', 'true');
                        $this->session->set_userdata('userData', $userData);
                        $this->session->set_flashdata('success', "Your are login successfully");
                        redirect("/dashboard/create_order");
                    }
                    redirect("/login");
                }
                redirect("/verify-otp?mobile_no=" . $mobile_no);
            }
            if (isset($postData['resend_otp'])) {
                $udata['mobile_no'] = $this->input->post('mobile_no');
                $response = json_decode($this->zippy->resend_otp($postData), true);

                if ($response['error'] == 1) {
                    $this->session->set_flashdata('error', $response['message']);
                } else {
                    $this->session->set_flashdata('success', $response['message']);
                }
                redirect("/verify-otp?mobile_no=" . $mobile_no);
            }
        }
        $this->loadFrontView('verify_otp', $data);
    }

    public function forgot_password() {
        $data = array();
        if ($this->input->post()) {
            $postData = $this->input->post();

            $data['email'] = $postData['email'];
            $response = json_decode($this->zippy->forgot_password($data), true);

            if ($response['error'] == 1) {
                $this->session->set_flashdata('error', $response['message']);
            } else {
                $this->session->set_flashdata('success', $response['message']);

                redirect("/login");
            }
            redirect("/forgot-password");
        }
        $this->loadFrontView('forgot_password', $data);
    }

    public function confirm_registration() {
        $userinfo = array();
        $data['error'] = 0;
        if ($this->input->post()) {
            $postData = $this->input->post();
            $mobile_no = $postData['mobile_no'];
            $postData['type'] = 'customer';
            $udata = array();
            foreach ($postData as $key => $value) {
                if ($key != 'submit') {
                    $udata[$key] = $value;
                }
            }

            $response = $this->register($udata);

            $response = json_decode($response, true);

            if ($response['error'] == 1) {
                $data['error'] = 1;
                $data['errorData'] = $response['data'];
                $data['message'] = $response['message'];
                $this->session->set_flashdata('error', $response['message']);
            } else {
                $data['message'] = $response['message'];
                $this->session->set_flashdata('success', $response['message']);
                redirect("/verify-otp?mobile_no=" . $mobile_no . "&email=" . $postData['email']);
            }

            $userinfo = $udata;
        } else {
            $userinfo = $this->session->flashdata('userInfo');
            $data['userInfo'] = $userinfo;
            if ($userinfo == '') {
                redirect("/signup");
            }
        }
        $data['userInfo'] = $userinfo;
        $this->loadFrontView('confirm_registration', $data);
    }

    public function test() {
        $cdata['email'] = "";
        $is_exists = json_decode($this->zippy->isUserExits($cdata), true);
        echo "<pre>";
        print_r($is_exists);
        exit;
    }

}
