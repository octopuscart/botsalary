<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CMS extends CI_Controller {

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

    public function allowanceCategories() {
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
        $data = array();
        $data['title'] = "Allowances Categories";
        $data['description'] = "Allowances Categories";
        $data['form_title'] = "Add Allowances";
        $data['table_name'] = 'salary_allowances';
        $form_attr = array(
            "title" => array("title" => "Allowances Name", "required" => true, "place_holder" => "Allowances Name", "type" => "text", "default" => ""),
            "apply_mpf" => array("title" => "", "required" => false, "place_holder" => "Apply MPF", "type" => "select", "default" => ""),
            "display_index" => array("title" => "", "required" => false, "place_holder" => "", "type" => "hidden", "default" => ""),
        );

        if (isset($_POST['submitData'])) {
            $postarray = array();
            foreach ($form_attr as $key => $value) {
                $postarray[$key] = $this->input->post($key);
            }
            $this->Curd_model->insert('salary_allowances', $postarray);
            redirect("CMS/allowanceCategories");
        }


        $categories_data = $this->Curd_model->get('salary_allowances');
        $data['list_data'] = $categories_data;

        $fields = array(
            "id" => array("title" => "ID#", "width" => "100px"),
            "title" => array("title" => "Allowances Name", "width" => "50%"),
            "apply_mpf" => array("title" => "Apply MPF", "width" => "50%"),
        );

        $data['fields'] = $fields;

        $data['form_attr'] = $form_attr;
        $this->load->view('layout/curd', $data);
    }

}

?>
