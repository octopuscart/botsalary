<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Salary extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Salary_model');
        $this->load->model('User_model');
        $this->load->model('Order_model');
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
            $this->load->view('Salary/dashboard', $data);
        } if ($this->user_type == 'Employee') {
            $loginuser = $this->session->userdata('logged_in');

            if (isset($loginuser["employee_id"])) {
                $employee_id = $loginuser["employee_id"];
                $this->db->where("employee_id", $employee_id);
                $this->db->order_by("salary_date desc");
                $query = $this->db->get("salary");
                $salary_data = $query->result_array();
                $data["salary"] = $salary_data;
            }
            $this->load->view('Salary/salarylist', $data);
        }
    }

    public function allowanceCategories() {
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
        $data = array();

        $allowmpf_select = array("Yes" => "Yes", "No" => "No");
        $dependes = array(
            "allowmpf_data" => $allowmpf_select,
        );

        $data['depends'] = $dependes;

        $data['title'] = "Allowances Categories";
        $data['description'] = "Allowances Categories";
        $data['form_title'] = "Add Allowances";
        $data['table_name'] = 'salary_allowances';
        $form_attr = array(
            "title" => array("title" => "Allowances Name", "required" => true, "place_holder" => "Allowances Name", "type" => "text", "default" => "", "width" => "50%"),
            "apply_mpf" => array("title" => "Apply MPF", "required" => false, "place_holder" => "Apply MPF", "type" => "select", "default" => "", "depends" => "allowmpf_data", "width" => "50%"),
            "display_index" => array("title" => "", "required" => false, "place_holder" => "", "type" => "hidden", "default" => ""),
        );

        if (isset($_POST['submitData'])) {
            $postarray = array();
            foreach ($form_attr as $key => $value) {
                $postarray[$key] = $this->input->post($key);
            }
            $this->Curd_model->insert('salary_allowances', $postarray);
            redirect("Salary/allowanceCategories");
        }


        $categories_data = $this->Curd_model->get('salary_allowances');
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

    public function locations() {
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
        $data = array();
        $data['title'] = "Locations";
        $data['description'] = "Locations";
        $data['form_title'] = "Add Locations";
        $data['table_name'] = 'salary_location';
        $form_attr = array(
            "location" => array("title" => "Locations Name", "required" => true, "place_holder" => "Locations Name", "type" => "text", "default" => ""),
            "address" => array("title" => "", "required" => false, "place_holder" => "Locations Address", "type" => "text", "default" => ""),
            "display_index" => array("title" => "", "required" => false, "place_holder" => "", "type" => "hidden", "default" => ""),
        );

        if (isset($_POST['submitData'])) {
            $postarray = array();
            foreach ($form_attr as $key => $value) {
                $postarray[$key] = $this->input->post($key);
            }
            $this->Curd_model->insert('salary_location', $postarray);
            redirect("Salary/locations");
        }


        $categories_data = $this->Curd_model->get('salary_location');
        $data['list_data'] = $categories_data;

        $fields = array(
            "id" => array("title" => "ID#", "width" => "100px"),
            "location" => array("title" => "Locations Name", "width" => "50%"),
            "address" => array("title" => "Locations Address", "width" => "50%"),
        );

        $data['fields'] = $fields;
        $data['form_attr'] = $form_attr;
        $data['depends'] = array();
        $this->load->view('layout/curd', $data);
    }

    public function employee() {
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
        $data = array();

        $location_data = $this->Curd_model->get('salary_location');
        $location_select = array();
        foreach ($location_data as $key => $value) {
            $location_select[$value["id"]] = $value["location"];
        }

        $dependes = array(
            "location_data" => $location_select,
        );

        $data['depends'] = $dependes;


        $data['title'] = "Employee";
        $data['description'] = "";
        $data['form_title'] = "Add Employee";
        $data['table_name'] = 'salary_employee';
        $form_attr = array(
            "employee_id" => array("title" => "Employee ID", "required" => false, "place_holder" => "Employee ID", "type" => "text", "default" => "", "depends" => "", "width" => "100px",),
            "name" => array("title" => "Name", "required" => true, "place_holder" => "Name", "type" => "text", "default" => "", "depends" => "", "width" => "280px",),
            "base_salary" => array("title" => "Basic Salary", "required" => true, "place_holder" => "Basic Salary", "type" => "text", "default" => "", "depends" => "", "width" => "280px",),
            "contact_no" => array("title" => "Contact No.", "required" => false, "place_holder" => "Contact No", "type" => "text", "default" => "", "depends" => "", "width" => "70px",),
            "email" => array("title" => "Email ID", "required" => false, "place_holder" => "Email ID", "type" => "text", "default" => "", "depends" => "", "width" => "150px",),
            "age" => array("title" => "Age", "required" => false, "place_holder" => "Age", "type" => "text", "default" => "", "depends" => "", "width" => "100px",),
            "location_id" => array("title" => "Location", "required" => true, "place_holder" => "Location", "type" => "select", "default" => "", "depends" => "location_data", "width" => "200px",),
        );



        if (isset($_POST['submitData'])) {
            $postarray = array();
            foreach ($form_attr as $key => $value) {
                $postarray[$key] = $this->input->post($key);
            }
            $this->Curd_model->insert('salary_employee', $postarray);
            redirect("Salary/employee");
        }


        $categories_data = $this->Curd_model->get('salary_employee', 'asc', 'location_id');
        $data['list_data'] = $categories_data;

        $fields = array(
            "id" => array("title" => "ID#", "width" => "100px", "type" => "text"),
        );
        foreach ($form_attr as $key => $value) {
            $fields[$key] = $value;
        }

        $data['fields'] = $fields;
        $data['form_attr'] = $form_attr;
        $this->load->view('layout/curd', $data);
    }

    function getSessionDates() {
        $session_dates = $this->session->userdata('session_dates');
        if ($session_dates) {
            return $session_dates;
        } else {
            return array(
                "salary_date" => date("Y-m-d"),
                "mpf_date" => date("Y-m-d"),
            );
        }
    }

    function setSessionsDates($salary_date, $mpf_date) {
        $session_dates = $this->session->userdata('session_dates');
        if ($session_dates) {
            if ($session_dates["salary_date"] != $salary_date) {
                $sess_data = array(
                    'salary_date' => $salary_date,
                    'mpf_date' => $mpf_date,
                );
                $this->session->set_userdata('session_dates', $sess_data);
            } else {
                $salary_date = $session_dates["salary_date"];
                $mpf_date = $session_dates["mpf_date"];
            }
        } else {
            $sess_data = array(
                'salary_date' => $salary_date,
                'mpf_date' => $mpf_date,
            );
            $this->session->set_userdata('session_dates', $sess_data);
        }
    }

    function create($employee_id) {
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
        $employee_data = $this->Curd_model->get_single2('salary_employee', $employee_id);
        $allownce_data = $this->Curd_model->get('salary_allowances');
        $location_data = $this->Curd_model->get('salary_location');
        $location_select = array();
        foreach ($location_data as $key => $value) {
            $location_select[$value["id"]] = $value["location"];
        }
        $employee_select = array();
        $salary_date = date("Y-m-d");
        $data["location"] = $location_select;
        $data["employee"] = $employee_data;
        $data["allownce"] = $allownce_data;
        $data["mpf_percent"] = "5";


        $data["c_period"] = $this->getSessionDates();

        if (isset($_POST["submit"])) {
            $salarydata = $this->input->post();
            $salary_date = $salarydata["salary_date"];
            $mpf_date = $salarydata["mpf_date"];
            $this->setSessionsDates($salary_date, $mpf_date);

            print_r($salarydata);
            $salaryinsert = array(
                "employee_id" => $employee_id,
                "location_id" => $employee_data["location_id"],
                "salary_date" => $salarydata["salary_date"],
                "mpf_date" => $salarydata["mpf_date"],
                "base_salary" => $salarydata["base_salary"],
                "gross_salary" => $salarydata["gross_salary"],
                "net_salary" => $salarydata["net_salary"],
                "mpf_employee" => $salarydata["mpf_employee"],
                "mpf_employer" => $salarydata["mpf_employer"],
                "op_date" => date("Y-m-d"),
                "op_time" => date("h:m:s a"),
            );
            $salary_id = $this->Curd_model->insert('salary', $salaryinsert);
            if (isset($salarydata["allowance_amount_no_mpf"])) {
                foreach ($salarydata["allowance_amount_no_mpf"] as $alkey => $alvalue) {
                    $al_title = $salarydata["allowance_title_no_mpf"];
                    $al_amount = $salarydata["allowance_amount_no_mpf"];
                    if ($alvalue) {
                        $allowance_no_mpf = array(
                            "employee_id" => $employee_id,
                            "location_id" => $employee_data["location_id"],
                            "op_date" => date("Y-m-d"),
                            "op_time" => date("h:m:s a"),
                            "salary_id" => $salary_id,
                            "title" => $al_title[$alkey],
                            "amount" => $al_amount[$alkey],
                            "apply_mpf" => "No",
                        );
                        $this->Curd_model->insert('salary_allowances_apply', $allowance_no_mpf);
                    }
                }
            }
            if (isset($salarydata["allowance_amount_mpf"])) {
                foreach ($salarydata["allowance_amount_mpf"] as $alkey => $alvalue) {
                    $al_title = $salarydata["allowance_title_mpf"];
                    $al_amount = $salarydata["allowance_amount_mpf"];
                    if ($alvalue) {
                        $allowance_no_mpf = array(
                            "employee_id" => $employee_id,
                            "location_id" => $employee_data["location_id"],
                            "op_date" => date("Y-m-d"),
                            "op_time" => date("h:m:s a"),
                            "salary_id" => $salary_id,
                            "title" => $al_title[$alkey],
                            "amount" => $al_amount[$alkey],
                            "apply_mpf" => "Yes",
                        );
                        $this->Curd_model->insert('salary_allowances_apply', $allowance_no_mpf);
                    }
                }
            }
            if ($salarydata["deduction"]) {
                $deduation_no_mpf = array(
                    "employee_id" => $employee_id,
                    "location_id" => $employee_data["location_id"],
                    "op_date" => date("Y-m-d"),
                    "op_time" => date("h:m:s a"),
                    "salary_id" => $salary_id,
                    "title" => $salarydata["deduction_note"],
                    "amount" => $salarydata["deduction"],
                    "apply_mpf" => "Yes",
                );
                $this->Curd_model->insert('salary_deduction_apply', $deduation_no_mpf);
            }

            if ($salarydata["deduction_loan"]) {
                $deduation_mpf = array(
                    "employee_id" => $employee_id,
                    "location_id" => $employee_data["location_id"],
                    "op_date" => date("Y-m-d"),
                    "op_time" => date("h:m:s a"),
                    "salary_id" => $salary_id,
                    "title" => $salarydata["deduction_loan_note"],
                    "amount" => $salarydata["deduction_loan"],
                    "apply_mpf" => "No",
                );
                $this->Curd_model->insert('salary_deduction_apply', $deduation_mpf);
            }
            redirect(site_url("Salary/paySlip/$salary_id"));
        }
        $this->load->view('Salary/addSalary', $data);
    }

    function selectEmployee() {
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
        $a_date = date("M-Y");
        if (isset($_GET["select_month"])) {
            $a_date = $_GET["salary_date"];
        }
        $data["salary_date"] = $a_date;
        $a_date = date("Y-m-t", strtotime($a_date));

        $querysql = "select se.id as id, name, employee_id, location from salary_employee as se join salary_location as sl on sl.id = se.location_id order by sl.id";
        $query = $this->db->query($querysql);
        $employee_data = $query->result_array($query);
        $employee_data2 = [];
        foreach ($employee_data as $key => $value) {
            $salary_data = $this->Salary_model->employeeSalary($a_date, $value['id']);
            $netpay = 0;
            $salary_id = 0;
            if ($salary_data) {
                $netpay = $salary_data["net_salary"];
                $salary_id = $salary_data["id"];
            }
            $value["net_salary"] = $netpay;
            $value["salary_id"] = $salary_id;
            array_push($employee_data2, $value);
        }
        $data["employee"] = $employee_data2;
        $this->load->view('Salary/employeelist', $data);
    }

    function paySlip($salary_id) {
        $data["deletable"] = true;
        if ($this->user_type != 'Admin') {
            $data["deletable"] = false;
        }
        $salaryobj = $this->Salary_model->employeeSalarySingle($salary_id);
        $data["salaryobj"] = $salaryobj;
        $data["allownce"] = $this->Salary_model->employeeAllownceAll($salary_id);
        $data["paydate"] = date("M-Y", strtotime($salaryobj["salary_date"]));

        $data["deduction"] = $this->Salary_model->employeeDuductionAll($salary_id);
        $data["employee"] = $this->Curd_model->get_single2('salary_employee', $salaryobj["employee_id"]);

        $this->load->view("Salary/paySlip", $data);
    }

    function salaryReport() {
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
        $a_date = date("M-Y");
        if (isset($_GET["select_month"])) {
            $a_date = $_GET["salary_date"];
        }
        $data["select_month"] = $a_date;
        $data["salary_report"] = $this->Salary_model->salaryData($a_date);
        $this->load->view('Salary/report', $data);
    }

    function salaryReportXls() {
        $a_date = date("M-Y");
        if (isset($_GET["salary_date"])) {
            $a_date = $_GET["salary_date"];
        }
        $salary_report = $this->Salary_model->salaryData($a_date);
        $html = $this->load->view('Salary/reportbase', array("salary_report" => $salary_report, "remark" => true), true);
        $filename = 'salary_report_' . $a_date . ".xls";
        ob_clean();
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/vnd.ms-excel");
        echo $html;
    }

    function salaryReportPDF() {
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
        $a_date = date("M-Y");
        if (isset($_GET["salary_date"])) {
            $a_date = $_GET["salary_date"];
        }
        $salary_report = $this->Salary_model->salaryData($a_date);
        $html = $this->load->view('Salary/reportbase', array("salary_report" => $salary_report, "remark" => true), true);
        $filename = 'salary_report_' . $a_date . ".xls";
        $this->load->library('m_pdf');


        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    function deletePayslip($id) {
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
        $this->db->where("id", $id);
        $this->db->delete("salary");
        $salarydate = $this->input->get("salary_date");
        $this->db->where("salary_id", $salary_id);
        $query = $this->db->delete("salary_allowances_apply");
        $this->db->where("salary_id", $salary_id);
        $query = $this->db->delete("salary_deduction_apply");
        redirect(site_url("Salary/selectEmployee?salary_date=$salarydate&select_month=1"));
    }

    function salaryReportV2() {
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
        $a_date = date("M-Y");
        if (isset($_GET["select_month"])) {
            $a_date = $_GET["salary_date"];
        }
        $data["select_month"] = $a_date;
        $salarydata = $this->Salary_model->salaryDatav2($a_date);
        $data["salary_report"] = $salarydata["salary_data"];
        $data["allownceslist"] = $salarydata["allownceslist"];
        $data["showimage"] = true;
        $this->load->view('Salary/reportv2', $data);
    }

    function salaryReporV2tXls() {
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
        $a_date = date("M-Y");
        if (isset($_GET["salary_date"])) {
            $a_date = $_GET["salary_date"];
        }
        $salarydata = $this->Salary_model->salaryDatav2($a_date);
        $data["salary_report"] = $salarydata["salary_data"];
        $data["allownceslist"] = $salarydata["allownceslist"];
        $data["showimage"] = false;

        $html = $this->load->view('Salary/reportbasev2', $data, true);
        $filename = 'salary_report_' . $a_date . ".xls";
        ob_clean();
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/vnd.ms-excel");
        echo $html;
    }

    function salaryReportV2PDF() {
        if ($this->user_type != 'Admin') {
            redirect('UserManager/not_granted');
        }
        $a_date = date("M-Y");
        if (isset($_GET["salary_date"])) {
            $a_date = $_GET["salary_date"];
        }
        $data["showimage"] = true;
        $salarydata = $this->Salary_model->salaryDatav2($a_date);
        $data["salary_report"] = $salarydata["salary_data"];
        $data["allownceslist"] = $salarydata["allownceslist"];
        echo $html = $this->load->view('Salary/reportbasev2', $data, true);
    }

}

?>
