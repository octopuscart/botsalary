<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH . 'libraries/REST_Controller.php');

class Api extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Account_model');

        $this->load->library('session');
        $this->checklogin = $this->session->userdata('logged_in');
        $this->user_id = $this->session->userdata('logged_in')['login_id'];
    }

    public function index() {
        $this->load->view('welcome_message');
    }

    function updateCurd_post() {
        $fieldname = $this->post('name');
        $value = $this->post('value');
        $pk_id = $this->post('pk');
        $tablename = $this->post('tablename');
        if ($this->checklogin) {
            $data = array($fieldname => $value);
            $this->db->set($data);
            $this->db->where("id", $pk_id);
            $this->db->update($tablename, $data);
        }
    }

    //function for product list
    function allowances_get() {
        $this->db->order_by("display_index asc");
        $query = $this->db->get("salary_allowances");
        $result = $query->result_array();
        $allowncearray = [];
        foreach ($result as $key => $value) {
            $value["status"] = false;
            $value["value"] = 0;
            array_push($allowncearray, $value);
        }
        $this->response($allowncearray);
    }

    function employee_get() {
        $query = $this->db->get("employee");
        $result = $query->result_array();
        $employee = array();
        foreach ($result as $key => $value) {
            $employee[$value["id"]] = $value;
        }
        $this->response($employee);
    }

    function pnl_notes_get() {
        $pnldata = $this->Account_model->getPnLNoteHeads();
        $this->response($pnldata);
    }

    function pnl_notes_edit_get($entry_month, $entry_year) {
        $pnldata = $this->Account_model->getPnLNoteHeadsEdit($entry_month, $entry_year);
        $this->response($pnldata);
    }
    
    function pnl_notes_budget_edit_get($entry_month, $entry_year) {
        $pnldata = $this->Account_model->getPnLNoteHeadsBudgetEdit($entry_month, $entry_year);
        $this->response($pnldata);
    }

    function updateHeads_post() {
        $fieldname = $this->post('name');
        $value = $this->post('value');
        $pk_id = $this->post('pk');
        $tablename = $this->post('tablename');
        if ($this->checklogin) {
            $data = array($fieldname => $value);
            $this->db->set($data);
            $this->db->where("id", $pk_id);
            $this->db->update($tablename, $data);
        }
    }
    

}

?>