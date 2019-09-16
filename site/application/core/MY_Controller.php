<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('curl');
        $this->load->library('zippy');
        $this->load->library('form_validation');
        $this->load->library('facebook');
        $this->load->library('Facebookgraphapi');
        require_once APPPATH.'third_party/src/Google_Client.php';
        require_once APPPATH.'third_party/src/contrib/Google_Oauth2Service.php';
        define("IMAGEPATH",'http://www.zippy.co.in/zippy/public/');
    }

    public function loadFrontView($file,$data = array()){
        $this->load->view('common/header',$data);    
    	$this->load->view($file,$data);
    	$this->load->view('common/footer',$data);
        $this->load->view('common/script',$data);
    }

    public function loadDashboardView($data = array()){
        $this->load->view('dashboard/common/header',$data);    
        $this->load->view('dashboard/common/master',$data);        
        $this->load->view('dashboard/common/footer',$data);        
    }
}