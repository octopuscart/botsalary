<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Salary_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Curd_model');
    }

    function employeeSalary($salary_date, $employee_id) {
        $a_date = $salary_date;
        $last_date = date("Y-m-t", strtotime($a_date));
        $first_date = date("Y-m-01", strtotime($a_date));
        $this->db->where("salary_date between '$first_date' and '$last_date'");
        $this->db->where("employee_id", $employee_id);
        $query = $this->db->get("salary");
        return $query->row_array();
    }

    function employeeAllownceMPF($salary_id) {
        $this->db->select("sum(amount) as amount");
        $this->db->where("salary_id", $salary_id);
        $this->db->where("apply_mpf", "Yes");
        $query = $this->db->get("salary_allowances_apply");
        $amountobj = $query->row_array();
        return $amountobj ? $amountobj["amount"] : 0;
    }

    function employeeAllownceNoMPF($salary_id) {
        $this->db->select("sum(amount) as amount");
        $this->db->where("salary_id", $salary_id);
        $this->db->where("apply_mpf", "No");
        $query = $this->db->get("salary_allowances_apply");
        $amountobj = $query->row_array();
        return $amountobj ? $amountobj["amount"] : 0;
    }

    function employeeDuductionNoMPF($salary_id) {

        $this->db->select("sum(amount) as amount");
        $this->db->where("salary_id", $salary_id);
        $this->db->where("apply_mpf", "No");
        $query = $this->db->get("salary_deduction_apply");
        $amountobj = $query->row_array();

        return $amountobj ? $amountobj["amount"] : 0;
    }

    function employeeDuductionMPF($salary_id) {
        $this->db->select("sum(amount) as amount");
        $this->db->where("salary_id", $salary_id);
        $this->db->where("apply_mpf", "Yes");
        $query = $this->db->get("salary_deduction_apply");
        $amountobj = $query->row_array();
        return $amountobj ? $amountobj["amount"] : 0;
    }

    function employeeSalarySingle($salary_id) {
        $this->db->where("id", $salary_id);
        $query = $this->db->get("salary");
        return $query->row_array();
    }

    function employeeAllownceAll($salary_id) {
        $this->db->where("salary_id", $salary_id);
        $query = $this->db->get("salary_allowances_apply");
        return $query->result_array();
    }

    function employeeDuductionAll($salary_id) {
        $this->db->where("salary_id", $salary_id);
        $query = $this->db->get("salary_deduction_apply");
        return $query->result_array();
    }

    function mpfSalary($base_salary, $salary_id) {
        $mpfamount = $this->employeeAllownceMPF($salary_id);
        return $base_salary + $mpfamount;
    }

    function appliedMpf($first_date, $last_date) {
        $querympf = "SELECT sa.title FROM salary as sl 
  join salary_allowances_apply as sa on sa.salary_id = sl.id 
  where sl.salary_date between '$first_date' and '$last_date' group by title
  order by apply_mpf";
        $query = $this->db->query($querympf);
        $resultmpf = $query->result_array();
        $finallist = array();
        foreach ($resultmpf as $key => $value) {
            $finallist[$value["title"]] = 0;
        }
        return $finallist;
    }

    function employeeAllownceList($allownceslist, $salary_id) {
        $this->db->select("title, amount");
        $this->db->where("salary_id", $salary_id);
        $query = $this->db->get("salary_allowances_apply");
        $mpflist = $query->result_array();
        foreach ($mpflist as $key => $value) {
            $allownceslist[$value["title"]] = $value["amount"];
        }
        return $allownceslist;
    }

    function salaryData($a_date) {
        $last_date = date("Y-m-t", strtotime($a_date));
        $first_date = date("Y-m-01", strtotime($a_date));
        $this->db->where("salary_date between '$first_date' and '$last_date'");
        $query = $this->db->get("salary");
        $salary_data = $query->result_array($query);
        $salaryFinal = array();
        $location_data = $this->Curd_model->get('salary_location');

        $allownceslist = $this->appliedMpf($first_date, $last_date);

        foreach ($location_data as $key => $value) {
            $value["salary"] = [];
            $salaryFinal[$value["id"]] = $value;
        }

        foreach ($salary_data as $key => $value) {
            $value["employee"] = $this->Curd_model->get_single2('salary_employee', $value["employee_id"]);
            $value["allownce_mpf"] = $this->employeeAllownceMPF($value["id"]);
            $value["allownce_no_mpf"] = $this->employeeAllownceNoMPF($value["id"]);
            $value["deduction_mpf"] = $this->employeeDuductionMPF($value["id"]);
            $value["deduction_no_mpf"] = $this->employeeDuductionNoMPF($value["id"]);
            $value["salary_mpf"] = $this->mpfSalary($value["base_salary"], $value["id"]);
            $value["salary_all_mpf"] = $this->employeeAllownceList($allownceslist, $value["id"]);
            array_push($salaryFinal[$value["location_id"]]["salary"], $value);
        }
        return $salaryFinal;
    }

    function salaryDatav2($a_date) {
        $last_date = date("Y-m-t", strtotime($a_date));
        $first_date = date("Y-m-01", strtotime($a_date));
        $this->db->where("salary_date between '$first_date' and '$last_date'");
        $query = $this->db->get("salary");
        $salary_data = $query->result_array($query);
        
        $finaldata = array();
        $salaryFinal = array();
        $location_data = $this->Curd_model->get('salary_location');

        $allownceslist = $this->appliedMpf($first_date, $last_date);
        $finaldata["allownceslist"] = $allownceslist;

        foreach ($location_data as $key => $value) {
            $value["salary"] = [];
            $salaryFinal[$value["id"]] = $value;
        }

        foreach ($salary_data as $key => $value) {
            $value["employee"] = $this->Curd_model->get_single2('salary_employee', $value["employee_id"]);
            $value["allownce_mpf"] = $this->employeeAllownceMPF($value["id"]);
            $value["allownce_no_mpf"] = $this->employeeAllownceNoMPF($value["id"]);
            $value["deduction_mpf"] = $this->employeeDuductionMPF($value["id"]);
            $value["deduction_no_mpf"] = $this->employeeDuductionNoMPF($value["id"]);
            $value["salary_mpf"] = $this->mpfSalary($value["base_salary"], $value["id"]);
            $value["allownceslist"] = $this->employeeAllownceList($allownceslist, $value["id"]);
            array_push($salaryFinal[$value["location_id"]]["salary"], $value);
        }
        $finaldata["salary_data"] = $salaryFinal;
        return $finaldata;
    }

}

?>