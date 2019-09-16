<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    function __construct() {
        parent::__construct();

        if ($this->session->userdata('is_login') != true) {
            redirect("/login");
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        $this->session->unset_userdata('is_login');
        $this->session->unset_userdata('userData');
        redirect('login');
    }

    public function create_order() {

        $data = array();
        $areas = json_decode($this->zippy->getListOfAreas(), true);
        $cargos = json_decode($this->zippy->getListOfCargos(), true);
        $vehicles = json_decode($this->zippy->getListOfVehiclesType(), true);
        $vehiclesList = json_decode($this->zippy->getSuggestedVehicles(), true);

        $data['areas'] = $areas['data']['get_areas'];
        $data['cargos'] = $cargos['data']['type_of_cargos'];
        $data['vehicles'] = $vehicles['data']['type_of_vehicle_required'];
        $data['vehiclesList'] = $vehiclesList['data']['suggested_vehicles'];


        if ($this->input->post()) {
            $this->form_validation->set_rules('pickup_address', 'Pickup Address', 'required');
            $this->form_validation->set_rules('drop_address', 'Drop Address', 'required');
            $this->form_validation->set_rules('total_distance', 'Total Distance', 'required');
            $this->form_validation->set_rules('cargo_type_id', 'Cargo', 'required');
            $this->form_validation->set_rules('vehicle_type_id', 'Vehicle', 'required');
            $this->form_validation->set_rules('gross_weight', 'Gross Weight', 'required');
            $this->form_validation->set_rules('carton_lenght', 'Carton length', 'required');
            $this->form_validation->set_rules('carton_breadth', 'Carton Breadth', 'required');
            $this->form_validation->set_rules('carton_height', 'Carton Height', 'required');
            $this->form_validation->set_rules('vehicle_category_id', 'Vehicle Category', 'required');


            if ($this->form_validation->run() != FALSE) {
                $postData = $this->input->post();

                $userData = $this->session->userdata('userData');
                $postData['customer_id'] = $userData['customer_id'];
                $response = $this->zippy->create_order($postData);

                $response = json_decode($response, true);

                if ($response['error'] == 1) {
                    $data['error'] = 1;
                    $data['errorData'] = $response['data'];
                } else {
                    $data['message'] = $response['message'];
                    $this->session->set_flashdata('success', $response['message']);
                    $this->session->set_flashdata('booking_confirm', 'true');
                    $this->session->set_flashdata('bookingData', $response['data']['booking']);
                    redirect("/dashboard/booking_confirm");
                }
            }
        }
        $viewData['content'] = $this->load->view('dashboard/create_order', $data, true);
        $this->loadDashboardView($viewData, $data);
    }

    public function booking_confirm() {
        $booking_confirm = $this->session->flashdata('booking_confirm');
        if ($booking_confirm == '') {
            redirect("/dashboard/create_order");
        }
        $bookingData = $this->session->flashdata('bookingData');

        /* $vehiclesList  = json_decode($this->zippy->getSuggestedVehicles(),true);
          foreach($vehiclesList['data']['suggested_vehicles'] as $vehicles){
          if($vehicles['id'] == $bookingData['vehicle_category_id']){
          $vehicleInfo = $vehicles;
          }
          } */
        $data['bookingData'] = $bookingData;
        //$data['vehicleInfo'] = $vehicleInfo;

        $viewData['content'] = $this->load->view('dashboard/booking_confirm', $data, true);
        $this->loadDashboardView($viewData, $data);
    }

    public function update_profile() {
        $userData = $this->session->userdata("userData");

        $data['userData'] = $userData;
        if ($this->input->post()) {
            $postData = $this->input->post();

            if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
              $img_curl =  curl_file_create($_FILES['image']['tmp_name'], $_FILES['image']['type'], $_FILES['image']['name']);
               // $postData['image'] = '@' . $_FILES['image']['tmp_name'].';filename=' . $_FILES['image']['name'].';type='. $_FILES['image']['type'];
                $postData['image'] = $img_curl;
            }

            $response = json_decode($this->zippy->updateProfile($postData), true);

            if ($response['error'] == 1) {
                $data['error'] = 1;
                $data['errorData'] = $response['data'];
                $this->session->set_flashdata('error', $response['message']);
            } else {
                $data['message'] = $response['message'];

                $this->session->set_flashdata('successs', "Profile updated successfully");
                $this->session->set_userdata('userData', $response['data']['customer_details']);
                redirect("/dashboard/update_profile");
            }
        }
        $viewData['content'] = $this->load->view('dashboard/update_profile', $data, true);
        $this->loadDashboardView($viewData, $data);
    }

    public function my_orders() {
        $data = array();
        $userData = $this->session->userdata('userData');
        $postData['customer_id'] = $userData['customer_id'];

        $orders = json_decode($this->zippy->customer_orders($postData), true);
        $data['orders'] = $orders['data']['results'];

        $viewData['content'] = $this->load->view('dashboard/my_orders', $data, true);
        $this->loadDashboardView($viewData, $data);
    }

    public function order_detail() {
        if (!$this->input->post()) {
            redirect("/dashboard/my_orders");
        }
        $postData = $this->input->post();
        $data['bookingData'] = json_decode($postData['order_data'], true);

        $viewData['content'] = $this->load->view('dashboard/order_detail', $data, true);
        $this->loadDashboardView($viewData, $data);
    }

}
