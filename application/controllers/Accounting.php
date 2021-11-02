<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Accounting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Salary_model');
        $this->load->model('Account_model');

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
        $this->load->view('Salary/dashboard', $data);
    }

    function activity($rtype) {
      
        $a_date = date("M-Y");
        if (isset($_GET["entry_date"])) {
            $a_date = $_GET["entry_date"];
        }
        $data["select_month"] = $a_date;
        $time = strtotime($a_date);
        $entry_date = date('Y-m-01', $time);

        $this->db->where("report_type", $rtype);
        $this->db->where("report_date", $entry_date);
        $query = $this->db->get("account_reports");
        $report_data = $query->row_array();
        $data["report_data"] = $report_data;
        
        $report_typs = array(
            "activity_reports"=>"Activity Report $a_date",
             "bs_reports"=>"Balance sheet Report $a_date"
        );
        $data["report_title"] = isset($report_typs[$rtype])?$report_typs[$rtype]:"";
        
        $this->load->view('Accounting/activity', $data);
    }

}

?>
