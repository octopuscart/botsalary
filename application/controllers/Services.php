<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $session_user = $this->session->userdata('logged_in');
        $session_user = $this->session->userdata('logged_in');
        if ($session_user) {
            $this->user_id = $session_user['login_id'];
            $this->user_type = isset($session_user['user_type']) ? $session_user['user_type'] : "";
        } else {
            $this->user_id = 0;
            $this->user_type = "";
        }
        $this->load->model('Curd_model');
    }

    public function tableReport($apipath, $parent_id = 0) {
        $data = $this->Curd_model->getApiConfig($apipath, $parent_id);
        $this->load->view('Services/tableReport', $data);
    }

    public function addData($apipath, $parent_id = 0) {
        $data = $this->Curd_model->getApiConfig($apipath, $parent_id);
        $inputData = $this->input->post();
        if (isset($inputData["submit"])) {

            unset($inputData["submit"]);
            $this->db->insert($data["serviceObj"]["table"], $inputData);
            if (isset($data["redirect_url"])) {
                redirect($data["redirect_url"]);
            } else {
                redirect("Services/tableReport/$apipath/$parent_id");
            }
        }
        $this->load->view('Services/addRecord', $data);
    }

    public function updateData($apipath, $parent_id = 0) {
        $data = $this->Curd_model->getApiConfig($apipath, $parent_id);
        $inputData = $this->input->post();
        if (isset($inputData["submit"])) {

            unset($inputData["submit"]);
            $this->db->insert($data["serviceObj"]["table"], $inputData);
            redirect("Services/tableReport/$apipath/$parent_id");
        }
        $this->load->view('Services/addRecord', $data);
    }
}

?>
