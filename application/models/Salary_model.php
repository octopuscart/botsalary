<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Salary_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
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
        return  $query->result_array();
    }

  

}

?>