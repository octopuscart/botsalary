<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Account_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function getPnLCategory($nature) {
        $this->db->where("nature", $nature);
        $query = $this->db->get("pnl_category");
        $category_data = $query->result_array($query);
        return $category_data;
    }

    function getPnLCategoryHeads($category_id) {
        $this->db->select("*, '' as value");
        $this->db->where("category_id", $category_id);
        $this->db->order_by("display_index asc");
        $query = $this->db->get("pnl_category_heads");
        $category_head_data = $query->result_array($query);
        return $category_head_data;
    }

    function getPnLNoteHeads() {
        $headdata = array(
            "Income" => [],
            "Expenditure" => [],
        );
        foreach ($headdata as $key => $value) {
            $temparray = $this->getPnLCategory($key);
            $tempdata = [];
            foreach ($temparray as $key2 => $value2) {

                $value2["heads"] = $this->getPnLCategoryHeads($value2["id"]);
                array_push($tempdata, $value2);
            }
            $headdata[$key] = $tempdata;
        }
        return $headdata;
    }

    function getPnLCategoryHeadsBudgetReport($category_id, $entry_month, $entry_year) {
        $query = "SELECT title, pe.id, pe.head_value FROM pnl_category_heads as pch 
      join pnl_entry_budget as pe on pch.id=pe.head_id where pch.category_id = $category_id
       and entry_month = '$entry_month' and entry_year = '$entry_year' order by pch.display_index asc
       ";

        $query = $this->db->query($query);
        $category_head_data = $query->result_array($query);
        $total = 0;
        $category_head_data_array = [];
        foreach ($category_head_data as $key => $value) {
//            $value["head_value"] = number_format($value["head_value"], 2, '.', '');
            $total += number_format($value["head_value"], 2, '.', '');

            array_push($category_head_data_array, $value);
        }
        return array("head" => $category_head_data_array, "total" => $total);
    }

    function getPnLCategoryHeadsReport($category_id, $entry_month, $entry_year) {
        $query = "SELECT title, pe.id, pe.head_value FROM pnl_category_heads as pch 
      join pnl_entry as pe on pch.id=pe.head_id where pch.category_id = $category_id
       and entry_month = '$entry_month' and entry_year = '$entry_year' order by pch.display_index asc
       ";

        $query = $this->db->query($query);
        $category_head_data = $query->result_array($query);
        $total = 0;
        $category_head_data_array = [];
        foreach ($category_head_data as $key => $value) {
//            $value["head_value"] = number_format($value["head_value"], 2, '.', '');
            $total += number_format($value["head_value"], 2, '.', '');

            array_push($category_head_data_array, $value);
        }
        return array("head" => $category_head_data_array, "total" => $total);
    }

    function getPnLCategoryHeadsReportSum($category_id, $entry_month, $entry_year) {
        $startyear = START_YEAR;
        $query = "
            SELECT title, pe.id, sum(pe.head_value) as head_value FROM pnl_category_heads as pch 
      join pnl_entry as pe on pch.id=pe.head_id where pch.category_id = $category_id
       and  entry_date BETWEEN '$startyear-04-01' and '$entry_year-$entry_month-01' group by pe.head_id
           order by pch.display_index asc
       ";

        $query = $this->db->query($query);
        $category_head_data = $query->result_array($query);
        $total = 0;
        $category_head_data_array = [];
        foreach ($category_head_data as $key => $value) {
            $value["head_value"] = number_format($value["head_value"], 2, '.', '');
            $total += $value["head_value"];
            array_push($category_head_data_array, $value);
        }
        return array("head" => $category_head_data_array, "total" => $total);
    }

    function getPnLNoteHeadsBudgetEdit($entry_month, $entry_year) {
        $headdata = array(
            "Income" => [],
            "Expenditure" => [],
        );
        $dt = strtotime("$entry_year-$entry_month-1");
        $diffr = strtotime("-1 month", $dt);

        $pre_month = date("m", $diffr);
        $pre_year = date("Y", $diffr);

        foreach ($headdata as $key => $value) {
            $temparray = $this->getPnLCategory($key);
            $tempdata = [];
            $totalg = 0;
            foreach ($temparray as $key2 => $value2) {
                $edithead = $this->getPnLCategoryHeadsBudgetReport($value2["id"], $entry_month, $entry_year);
                $value2["heads"] = $edithead["head"];
                $value2["total"] = $edithead["total"];
                array_push($tempdata, $value2);
                $totalg += $edithead["total"];
            }
            $headdata[$key] = $tempdata;
            $headdata[$key . "Total"] = number_format($totalg, 2, '.', '');
        }
        return $headdata;
    }

    function getPnLNoteHeadsEdit($entry_month, $entry_year) {
        $headdata = array(
            "Income" => [],
            "Expenditure" => [],
        );
        $dt = strtotime("$entry_year-$entry_month-1");
        $diffr = strtotime("-1 month", $dt);

        $pre_month = date("m", $diffr);
        $pre_year = date("Y", $diffr);

        foreach ($headdata as $key => $value) {
            $temparray = $this->getPnLCategory($key);
            $tempdata = [];
            $totalg = 0;
            foreach ($temparray as $key2 => $value2) {
                $edithead = $this->getPnLCategoryHeadsReport($value2["id"], $entry_month, $entry_year);
                $value2["heads"] = $edithead["head"];
                $value2["total"] = $edithead["total"];
                array_push($tempdata, $value2);
                $totalg += $edithead["total"];
            }
            $headdata[$key] = $tempdata;
            $headdata[$key . "Total"] = number_format($totalg, 2, '.', '');
        }
        return $headdata;
    }

    function minusValueCheck($inputval) {
        if ($inputval < 0) {
           return "(".number_format($inputval * (-1), 2, '.', ',').")";
        } else {
            return number_format($inputval, 2, '.', ',');
        }
    }

    function getPnLNoteHeadsReports($entry_month, $entry_year) {
        $headdata = array(
            "Income" => [],
            "Expenditure" => [],
        );
        $dt = strtotime("$entry_year-$entry_month-1");
        $diffr = strtotime("-1 month", $dt);

        $pre_month = date("m", $diffr);
        $pre_year = date("Y", $diffr);

        foreach ($headdata as $key => $value) {
            $temparray = $this->getPnLCategory($key);
            $tempdata = [];
            $total_c = 0;
            $total_p = 0;
            $total_f = 0;
            $total_b = 0;
            foreach ($temparray as $key2 => $value2) {

                $entrydata = $this->getPnLCategoryHeadsReport($value2["id"], $entry_month, $entry_year);
                $value2["heads"] = $entrydata["head"];
                $value2["total"] = number_format($entrydata["total"], 2, '.', ',');
                $total_c += $entrydata["total"];

                $pre_entrydata = $this->getPnLCategoryHeadsReportSum($value2["id"], $pre_month, $pre_year);
                $value2["heads_p"] = $pre_entrydata["head"];
                $value2["total_p"] = number_format($pre_entrydata["total"], 2, '.', ',');
                $total_p += $pre_entrydata["total"];

                $now_entrydata = $this->getPnLCategoryHeadsReportSum($value2["id"], $entry_month, $entry_year);
                $value2["heads_f"] = $now_entrydata["head"];
                $value2["total_f"] = number_format($now_entrydata["total"], 2, '.', ',');
                $total_f += $now_entrydata["total"];

                $budgetdata = $this->getPnLCategoryHeadsBudgetReport($value2["id"], "04", START_YEAR);
                $value2["heads_b"] = $budgetdata["head"];
                $value2["total_b"] = number_format($budgetdata["total"], 2, '.', ',');
                $total_b += $budgetdata["total"];

                array_push($tempdata, $value2);
            }
            $headdata[$key] = $tempdata;
            $headdata[$key . "Total"] = number_format($total_c, 2, '.', ',');
            $headdata[$key . "Total_P"] = number_format($total_p, 2, '.', ',');
            $headdata[$key . "Total_F"] = number_format($total_f, 2, '.', ',');
            $headdata[$key . "Total_B"] = number_format($total_b, 2, '.', ',');

            $headdata[$key . "Total_n"] = number_format($total_c, 2, '.', '');
            $headdata[$key . "Total_P_n"] = number_format($total_p, 2, '.', '');
            $headdata[$key . "Total_F_n"] = number_format($total_f, 2, '.', '');
            $headdata[$key . "Total_B_n"] = number_format($total_b, 2, '.', '');
        }
        $pnltotal = $headdata["IncomeTotal_n"] - $headdata["ExpenditureTotal_n"];
        $pnltotalp = $headdata["IncomeTotal_P_n"] - $headdata["ExpenditureTotal_P_n"];
        $pnltotalf = $headdata["IncomeTotal_F_n"] - $headdata["ExpenditureTotal_F_n"];
        $pnltotalb = $headdata["IncomeTotal_B_n"] - $headdata["ExpenditureTotal_B_n"];

        $headdata["pnl_total"] = $this->minusValueCheck($pnltotal);
        $headdata["pnl_total_f"] = $this->minusValueCheck($pnltotalf);
        $headdata["pnl_total_p"] = $this->minusValueCheck($pnltotalp);
        $headdata["pnl_total_b"] = $this->minusValueCheck($pnltotalb);

        return $headdata;
    }

}
