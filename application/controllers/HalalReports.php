<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . '/third_party/tcpdf-main/examples/config/tcpdf_config_alt.php');
include_once APPPATH . '/third_party/tcpdf-main/tcpdf.php';

class HalalReports extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->curd = $this->load->model('Curd_model');
        $session_user = $this->session->userdata('logged_in');

        if ($session_user) {
            $this->user_id = $session_user['login_id'];
        } else {
            $this->user_id = 0;
        }
        $this->load->library('parser');
        $this->user_id = $this->session->userdata('logged_in')['login_id'];
        $this->user_type = $this->session->logged_in['user_type'];
        $this->login_user = "Admin";
    }

    public function index() {
        $date1 = date('Y-m-d', strtotime('-30 days'));
        $date2 = date('Y-m-d');
        $data = array();
        if ($this->user_type == $this->login_user) {
            $this->db->order_by("id desc");
            $query = $this->db->get("hala_certification_form");
            $hala_certification_data = $query->result_array();
            $data["hala_certification_data"] = $hala_certification_data;
            $this->load->view('HalalService/formlist', $data);
        } else {
            redirect('UserManager/not_granted');
        }
    }

    function getDetails($form_id, $isArray = false) {
        $this->db->where("id", $form_id);
        $query = $this->db->get("hala_certification_form");
        $halaldata = $query->row_array();

        $data = array();
        $halaformdata = array();
        $halal_form = $this->db->select("attr_details")->where("attr_key", "hala-attribute")->get("configuration_attr")->row_array();
        if ($halal_form) {
            $form_details = json_decode($halal_form["attr_details"], $isArray);
            foreach ($form_details as $fkey => $formvalue) {
                foreach ($formvalue as $fskey => $fsvalue) {
                    if ($isArray) {
                        $fsvalue["value"] = $halaldata[$fsvalue["name"]];
                        $fsvalue["mock"] = $halaldata[$fsvalue["name"]];
                    } else {
                        $fsvalue->value = $halaldata[$fsvalue->name];
                        $fsvalue->mock = $halaldata[$fsvalue->name];
                    }
                }
                $halaformdata[$fkey] = $formvalue;
            }
        }

        foreach ($halaldata as $key => $value) {

            $halaformdata[$key] = $value;
        }
        return $halaformdata;
    }

    function details($form_id) {
        $data = array();
        if ($this->user_type == $this->login_user) {
            $data["halaformdata"] = $this->getDetails($form_id);
            $data["hid"] = $form_id;
            $this->load->view('HalalService/details', $data);
        } else {
            redirect('UserManager/not_granted');
        }
    }

    function reportPdf($form_id, $viewmode = "i") {
        $data = array();
        if ($this->user_type == $this->login_user) {
            $halaformdata = $this->getDetails($form_id, true);
//            print_r($halaformdata);
            $halaformdata["css"] = true;
            $htmloutput = $this->parser->parse('HalalService/halalBasePdf', $halaformdata, true);

            $filetitle = "HalaForm-".$form_id . '-report.pdf';
            if ($viewmode != "h") {
                $pdf = new TCPdf("P", "mm", "A4", true, 'UTF-8', false);
                $pdf->AddPage();
                $pdf->SetTitle($filetitle);
                $pdf->writeHTML($htmloutput);
                $pdf->Output($filetitle, $viewmode);
            }
            else{
                echo $htmloutput;
            }
        }
    }
}

?>
