<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PnlNotes extends CI_Controller {

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

    public function categories() {
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
        $data = array();

        $allowmpf_select = array("Income" => "Income", "Expenditure" => "Expenditure");
        $dependes = array(
            "allowmpf_data" => $allowmpf_select,
        );

        $data['depends'] = $dependes;

        $data['title'] = "P&L Categories";
        $data['description'] = "P&L Categories";
        $data['form_title'] = "Add Category";
        $data['table_name'] = 'pnl_category';
        $form_attr = array(
            "title" => array("title" => "Category Name", "required" => true, "place_holder" => "Category Name", "type" => "text", "default" => "", "width" => "50%"),
            "nature" => array("title" => "Nature", "required" => false, "place_holder" => "Nature", "type" => "select", "default" => "", "depends" => "allowmpf_data", "width" => "50%"),
            "display_index" => array("title" => "", "required" => false, "place_holder" => "", "type" => "hidden", "default" => ""),
        );

        if (isset($_POST['submitData'])) {
            $postarray = array();
            foreach ($form_attr as $key => $value) {
                $postarray[$key] = $this->input->post($key);
            }
            $this->Curd_model->insert('pnl_category', $postarray);
            redirect("PnlNotes/categories");
        }


        $categories_data = $this->Curd_model->get('pnl_category');
        $data['list_data'] = $categories_data;

        $fields = array(
            "id" => array("title" => "ID#", "width" => "100px", "depends" => "location_data",),
        );
        foreach ($form_attr as $key => $value) {
            $fields[$key] = $value;
        }

        $data['fields'] = $fields;
        $data['form_attr'] = $form_attr;
        $this->load->view('layout/curd', $data);
    }

    public function subcategories() {
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
        $data = array();
        $mcategorydata = array();
        $m_categories_data = $this->Curd_model->get('pnl_category');
        foreach ($m_categories_data as $key => $value) {
            $mcategorydata[$value["id"]] = $value["title"];
        }

        $allowmpf_select = array("Income" => "Income", "Expenditure" => "Expenditure");

        $dependes = array(
            "allowmpf_data" => $mcategorydata,
        );

        $data['depends'] = $dependes;

        $data['title'] = "P&L Categories Heads";
        $data['description'] = "P&L Categories Heads";
        $data['form_title'] = "Add Category  Heads";
        $data['table_name'] = 'pnl_category';
        $form_attr = array(
            "title" => array("title" => "Category  Heads", "required" => true, "place_holder" => "Category  Heads", "type" => "text", "default" => "", "width" => "50%"),
            "category_id" => array("title" => "Nature", "required" => false, "place_holder" => "Nature", "type" => "select", "default" => "", "depends" => "allowmpf_data", "width" => "50%"),
            "display_index" => array("title" => "", "required" => false, "place_holder" => "", "type" => "hidden", "default" => ""),
        );

        if (isset($_POST['submitData'])) {
            $postarray = array();
            foreach ($form_attr as $key => $value) {
                $postarray[$key] = $this->input->post($key);
            }
            $this->Curd_model->insert('pnl_category_heads', $postarray);
            redirect("PnlNotes/subcategories");
        }


        $categories_data = $this->Curd_model->get('pnl_category_heads');
        $data['list_data'] = $categories_data;

        $fields = array(
            "id" => array("title" => "ID#", "width" => "100px", "depends" => "location_data",),
        );
        foreach ($form_attr as $key => $value) {
            $fields[$key] = $value;
        }

        $data['fields'] = $fields;
        $data['form_attr'] = $form_attr;
        $this->load->view('layout/curd', $data);
    }

    function budgetEntry() {
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
        $a_date = date("Y-04-01");
        if (isset($_GET["entry_date"])) {
            $a_date = $_GET["entry_date"];
        }
        $time = strtotime($a_date);

        $data["select_year"] = $a_date;

        $this->db->order_by("display_index asc");
        $query = $this->db->get("pnl_category_heads");
        $headsdata = $query->result_array();

        $entry_year = date('Y', $time);
        $entry_month = "04";

        $this->db->where("entry_date", $a_date);
        $query = $this->db->get("pnl_entry_budget");
        $headsdataentry = $query->result_array();
        if ($headsdataentry) {
            
        } else {
            foreach ($headsdata as $key => $value) {
                $pnlinsert = array(
                    "head_value" => "0",
                    "head_id" => $value["id"],
                    "entry_month" => $entry_month,
                    "entry_year" => $entry_year,
                    "entry_date" => "$entry_year-$entry_month-01",
                );
                $this->db->insert("pnl_entry_budget", $pnlinsert);
            }
        }
        $this->load->view('pnlnotes/entrybudget', $data);
    }

    function entry() {
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
        $pnldata = $this->Account_model->getPnLNoteHeads();
        $data = array();
        $a_date = date("M-Y");
        if (isset($_GET["select_month"])) {
            $a_date = $_GET["entry_date"];
        }
        $data["select_month"] = $a_date;
        if (isset($_POST["submitdata"])) {
            $entry_date = $this->input->post("entry_date");
            $pnl_input_id = $this->input->post("notes_id[]");
            $pnl_input_value = $this->input->post("notes_value[]");
            $time = strtotime($entry_date);
            $entry_month = date('m', $time);
            $entry_year = date('Y', $time);
            foreach ($pnl_input_id as $key => $value) {
                $pnlinsert = array(
                    "head_value" => $pnl_input_value[$key],
                    "head_id" => $pnl_input_id[$key],
                    "entry_month" => $entry_month,
                    "entry_year" => $entry_year,
                    "entry_date" => "$entry_year-$entry_month-01",
                );
                $this->db->insert("pnl_entry", $pnlinsert);
            }
        }

        $this->load->view('pnlnotes/reportCreate', $data);
    }

    function edit() {
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
        $a_date = date("M-Y");
        if (isset($_GET["entry_date"])) {
            $a_date = $_GET["entry_date"];
        }
        $data["select_month"] = $a_date;
        $this->load->view('pnlnotes/editreport', $data);
    }

    function report() {
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
        $a_date = date("M-Y");
        if (isset($_GET["entry_date"])) {
            $a_date = $_GET["entry_date"];
        }
        $data["select_month"] = $a_date;
        $time = strtotime($a_date);
        $entry_month = date('m', $time);
        $entry_year = date('Y', $time);

        $c_date = date("F Y", $time);

        $diffr = strtotime("-1 month", $time);
        $p_date = "April - " . date("F Y", $diffr);

        $f_date = "April - " . date("F Y", $time);
        
        $byear = date("y", $time);
        $diffr = strtotime("+1 year", $time);
        $byearn = date("y", $diffr);

        $b_date = "April $byear - March $byearn";

        $data["c_date"] = $c_date;
        $data["p_date"] = $p_date;
        $data["f_date"] = $f_date;
        $data["b_date"] = $b_date;

        $pnldata = $this->Account_model->getPnLNoteHeadsReports($entry_month, $entry_year);
        $data["pnldata"] = $pnldata;
        $this->load->view('pnlnotes/report', $data);
    }

}

?>
