<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();

class Configuration extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->user_id = $this->session->userdata('logged_in')['login_id'];
        $this->user_type = $this->session->logged_in['user_type'];
    }

    public function reportConfiguration() {
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
        $data = array();
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('configuration_report');
        $systemlog = $query->row();
        $data['configuration_report'] = $systemlog;



        if (isset($_POST['update_data'])) {
            $confArray = array(
                "email_header" => $this->input->post("email_header"),
                "email_footer" => $this->input->post("email_footer"),
                "pdf_report_header" => $this->input->post("pdf_report_header"),
            );
            $this->db->update('configuration_report', $confArray);
            redirect("Configuration/reportConfiguration");
        }


        $this->load->view("configuration/reportConfiguration", $data);
    }

   

}
