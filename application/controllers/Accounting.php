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
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
        $date1 = date('Y-m-d', strtotime('-30 days'));
        $date2 = date('Y-m-d');

        $data = array();
        $this->load->view('Salary/dashboard', $data);
    }

    function activity($rtype) {
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
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
            "activity_reports" => "Activity Report $a_date",
            "bs_reports" => "Balance sheet Report $a_date",
            "monthly_exp_reports" => "Monthly Expenses Report $a_date"
        );
        $data["report_title"] = isset($report_typs[$rtype]) ? $report_typs[$rtype] : "";

        $config['upload_path'] = 'assets/reports';
        $config['allowed_types'] = '*';
        if (isset($_POST['submit'])) {
            $picture = '';
            if (!empty($_FILES['picture']['name'])) {
                $temp1 = rand(100, 1000000);
                $config['overwrite'] = TRUE;
                $ext1 = explode('.', $_FILES['picture']['name']);
                $ext = strtolower(end($ext1));
                $file_newname = $temp1 . $ext;
                $picture = $file_newname;
                $config['file_name'] = $file_newname;
                //Load upload library and initialize configuration
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('picture')) {
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                } else {
                    $picture = '';
                }
            }
            $param = "entry_date=$a_date";
            if ($report_data) {
                $this->db->set('report_file', $picture);
                $this->db->where("report_type", $rtype);
                $this->db->where("report_date", $entry_date);
                $this->db->update("account_reports");
            } else {
                $reportinsert = array(
                    "report_type" => $rtype,
                    "report_file" => $picture,
                    "report_date" => $entry_date,
                );
                $this->db->insert("account_reports", $reportinsert);
            }

            redirect(site_url("Accounting/activity/$rtype?$param"));
        }

        $this->load->view('Accounting/activity', $data);
    }

    function activityAnnual($rtype) {
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
        $entry_date = "2021-04-01";
        if (isset($_GET["entry_date"])) {
            $entry_date = $_GET["entry_date"];
        }
        $data["select_month"] = $entry_date;

        $entry_year = array("2021-04-01" => "2021-2022");

        $this->db->where("report_type", $rtype);
        $this->db->where("report_date", $entry_date);
        $query = $this->db->get("account_reports");
        $report_data = $query->row_array();
        $data["report_data"] = $report_data;

        $report_typs = array(
            "annual_exp_reports" => "Annual Expenses Report " . $entry_year[$entry_date]
        );
        $data["report_title"] = isset($report_typs[$rtype]) ? $report_typs[$rtype] : "";
        $config['upload_path'] = 'assets/reports';
        $config['allowed_types'] = '*';
        if (isset($_POST['submit'])) {
            $picture = '';
            if (!empty($_FILES['picture']['name'])) {
                $temp1 = rand(100, 1000000);
                $config['overwrite'] = TRUE;
                $ext1 = explode('.', $_FILES['picture']['name']);
                $ext = strtolower(end($ext1));
                $file_newname = $temp1 . $ext;
                $picture = $file_newname;
                $config['file_name'] = $file_newname;
                //Load upload library and initialize configuration
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('picture')) {
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                } else {
                    $picture = '';
                }
            }
            $param = "entry_date=$entry_date";
            if ($report_data) {
                $this->db->set('report_file', $picture);
                $this->db->where("report_type", $rtype);
                $this->db->where("report_date", $entry_date);
                $this->db->update("account_reports");
            } else {
                $reportinsert = array(
                    "report_type" => $rtype,
                    "report_file" => $picture,
                    "report_date" => $entry_date,
                );
                $this->db->insert("account_reports", $reportinsert);
            }
             redirect(site_url("Accounting/activityAnnual/$rtype?$param"));
        }

        $this->load->view('Accounting/activityAnnual', $data);
    }

}

?>
