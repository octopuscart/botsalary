<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admission extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->curd = $this->load->model('Curd_model');
        $session_user = $this->session->userdata('logged_in');

        if ($session_user) {
            $this->user_id = $session_user['login_id'];
        } else {
            $this->user_id = 0;
        }
        $this->user_id = $this->session->userdata('logged_in')['login_id'];
        $this->user_type = $this->session->logged_in['user_type'];
    }

    public function index() {
        $date1 = date('Y-m-d', strtotime('-30 days'));
        $date2 = date('Y-m-d');
        $data = array();
        if ($this->user_type == 'Admin') {
            $this->db->order_by("id desc");
            $query = $this->db->get("madrasa_admission");
            $admissiondata = $query->result_array();
            $data["admissiondata"] = $admissiondata;
            $this->load->view('Admission/admissionlist', $data);
        } else {
            redirect('UserManager/not_granted');
        }
    }

    function details($form_id) {
        if ($this->user_type == 'Admin') {
            $this->db->where("id", $form_id);
            $query = $this->db->get("madrasa_admission");
            $admissiondata = $query->row_array();
//            if ($admissiondata) {
//                redirect('UserManager/not_granted');
//            }
            $data["admissiondata"] = $admissiondata;
            $this->load->view('Admission/details', $data);
        } else {
            redirect('UserManager/not_granted');
        }
    }

}

?>
