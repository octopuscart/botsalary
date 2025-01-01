<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . '/third_party/tcpdf-main/examples/config/tcpdf_config_alt.php');
include_once APPPATH . '/third_party/tcpdf-main/tcpdf.php';

class HalalReports extends CI_Controller
{

    public function __construct()
    {
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
        $this->login_user = ['Admin', 'HalalAdmin'];;
    }

    public function index()
    {
        $date1 = date('Y-m-d', strtotime('-30 days'));
        $date2 = date('Y-m-d');
        $data = array();
    
        if (in_array($this->user_type, $this->login_user)) 
        {
            $this->db->order_by("id desc");
            $query = $this->db->get("hala_certification_form");
            $hala_certification_data = $query->result_array();
            $data["hala_certification_data"] = $hala_certification_data;
            $this->load->view('HalalService/formlist', $data);
        } else {
            redirect('UserManager/not_granted');
        }
    }

    function importData()
    {
        require_once 'D:\wamp64\www\salary\application\controllers\test.php';
        $count = 1;

        foreach ($halal_data_array as &$item) {
            $formId = "";
            $date = DateTime::createFromFormat('d-M-y', $item['val5']);
            if ($date) {
                $item['val5'] = $date->format('Y-m-d');
                $formId = "HL" . $date->format("ymdhis");
            }
            $dbinsert = array(
                "applicant_name" => $item['val1'],
                "address" => $item['val2'],
                "telephone" => $item['val3'],
                "expiry_date" => $item['val5'],
                "cuisine" => $item["val4"],
            );
            $dbinsert["form_id"] = $formId;
            echo "<br/>";
            print_r($dbinsert);
            $count++;
            echo $count;
            // $this->db->insert('hala_certification_form', $dbinsert);
            //   echo  $f_id = $this->db->insert_id();
        }

    }

    function getDetails($form_id, $isArray = false)
    {
        $this->db->where("id", $form_id);
        $query = $this->db->get("hala_certification_form");
        $halaldata = $query->row_array();
        if(!$halaldata){
            redirect("HalalReports");
        }

        $data = array();
        $halaformdata = array();
        $halal_form = $this->db->select("attr_details")->where("attr_key", "hala-attribute")->get("configuration_attr")->row_array();
        if ($halal_form) {
            $form_details = json_decode($halal_form["attr_details"], $isArray);
            foreach ($form_details as $fkey => $formvalue) {

                foreach ($formvalue as $fskey => $fsvalue) {
                    if ($isArray) {

                        $fsvalue["value"] = $halaldata[$fsvalue["name"]];
                        $fsvalue["mock"] = "";
                        if ($fkey == "hala_form_fields_block4") {

                            $selectedelements = explode(", ", $halaldata[$fsvalue["name"]]);
                            foreach ($fsvalue["elementlist"] as $key => $value) {
                                $elementvalue = $fsvalue["elementlist"][$key]["value"];

                                if (in_array($elementvalue, $selectedelements)) {
                                    $formvalue[$fskey]["elementlist"][$key]["mock"] = true;
                                } else {
                                    $formvalue[$fskey]["elementlist"][$key]["mock"] = false;
                                }
                            }
                        }
                           
                        $formvalue[$fskey]["value"] = $halaldata[$fsvalue["name"]];
                        $formvalue[$fskey]["mock"] = $halaldata[$fsvalue["name"]];
                    } else {
                        
                        if($isArray){
                          
                            $formvalue[$fskey]["value"] = $halaldata[$fsvalue["name"]];
                            $formvalue[$fskey]["mock"] = $halaldata[$fsvalue["name"]];
                        }
                        else{
                            $formvalue[$fskey]->value = $halaldata[$fsvalue->name];
                            $formvalue[$fskey]->mock = $halaldata[$fsvalue->name];
                        }
                     
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

    function details($form_id)
    {
        $data = array();
        if (in_array($this->user_type, $this->login_user)) {

            $data["halaformdata"] = $this->getDetails($form_id);
            $data["hid"] = $form_id;
            $this->load->view('HalalService/details', $data);
        } else {
            redirect('UserManager/not_granted');
        }
    }

    function reportPdf($form_id, $viewmode = "i")
    {
        $data = array();
        if (in_array($this->user_type, $this->login_user)) 
        {
            $halaformdata = $this->getDetails($form_id, true);
            //            print_r($halaformdata);
            $halaformdata["css"] = true;
            $htmloutput = $this->parser->parse('HalalService/halalBasePdf', $halaformdata, true);

            $filetitle = "HalaForm-" . $form_id . '-report.pdf';
            if ($viewmode != "h") {
                $pdf = new TCPdf("P", "mm", "A4", true, 'UTF-8', false);
                $pdf->AddPage();
                $pdf->SetTitle($filetitle);
                $pdf->writeHTML($htmloutput);
                $pdf->Output($filetitle, $viewmode);
            } else {
                echo $htmloutput;
            }
        }
    }

    public function halalCirtificateRequests()
    {

        $halal_form = $this->db->select("attr_details")->where("attr_key", "hala-attribute")->get("configuration_attr")->row_array();
        if ($halal_form) {
            $form_details = json_decode($halal_form["attr_details"]);
            foreach ($form_details as $fkey => $fvalue) {
                $data[$fkey] = $fvalue;
            }
        }

        if (isset($_POST["submit"])) {
            $fieldinput = $this->input->post();
            foreach ($fieldinput as $key => $value) {
                if (gettype($value) == "array") {
                    $fieldinput[$key] = implode(", ", $value);
                }
            }

            $fieldinput["form_date"] = date("Y-m-d");
            $fieldinput["form_time"] = date("h:i:s a");
            $fieldinput["form_id"] = "HL" . date("ymdhis");
            unset($fieldinput["submit"]);
            $form_id = $fieldinput["form_id"];
            try {
                $signature_path = "assets/halalfiles/signature";
                $br_file_path = "assets/halalfiles/brn";
                $signature_file_status = $this->Curd_model->uploadfiles("signature", $signature_path, "jpg|png|jpeg", $form_id);
                $bre_file_status = $this->Curd_model->uploadfiles("business_registration_no_file", $br_file_path, "pdf", $form_id);
                if ($signature_file_status && $signature_file_status["status"] == "200") {
                    $fieldinput["signatory_file"] = base_url($signature_path . "/" . $signature_file_status["filename"]);
                }
                if ($bre_file_status && $bre_file_status["status"] == "200") {
                    $fieldinput["business_registration_file"] = base_url($br_file_path . "/" . $bre_file_status["filename"]);
                }
            } catch (Exception $e) {
                print_r($e);
            }
            $this->db->insert('hala_certification_form', $fieldinput);

            try {
                //                $this->halalCirtificateConfirmEmail($form_id);
            } catch (Exception $e) {

            }
            $f_id = $this->db->insert_id();
            //redirect(site_url("HalalReports/details/" . $f_id));
        }

        $this->parser->parse('HalalService/halal_certificate_request', $data);
    }

    public function halalCirtificateUpdate($form_id)
    {
        $halal_form_data = $this->getDetails($form_id, true);

        if ($halal_form_data) {
            $form_details = $halal_form_data;
            foreach ($form_details as $fkey => $fvalue) {
                $data[$fkey] = $fvalue;
            }
        }

        if (isset($_POST["submit"])) {
            $fieldinput = $this->input->post();
            print_r($fieldinput);
            foreach ($fieldinput as $key => $value) {
                if (gettype($value) == "array") {
                    $fieldinput[$key] = implode(", ", $value);
                }
            }
            // $fieldinput["form_date"] = date("Y-m-d");
            // $fieldinput["form_time"] = date("h:i:s a");
            // $fieldinput["form_id"] = "HL" . date("ymdhis");
            unset($fieldinput["submit"]);
            $halal_form_id = $fieldinput["form_id"];
            try {
                $signature_path = "assets/halalfiles/signature";
                $br_file_path = "assets/halalfiles/brn";
                $signature_file_status = $this->Curd_model->uploadfiles("signature", $signature_path, "jpg|png|jpeg", $form_id);
                $bre_file_status = $this->Curd_model->uploadfiles("business_registration_no_file", $br_file_path, "pdf", $form_id);
                if ($signature_file_status["status"] == "200") {
                    $fieldinput["signatory_file"] = base_url($signature_path . "/" . $signature_file_status["filename"]);
                }
                if ($bre_file_status["status"] == "200") {
                    $fieldinput["business_registration_file"] = base_url($br_file_path . "/" . $bre_file_status["filename"]);
                }
            } catch (Exception $e) {
                print_r($e);
            }
            $this->db->where('id', $form_id);
            $this->db->update('hala_certification_form', $fieldinput);

            try {
                //                $this->halalCirtificateConfirmEmail($form_id);
            } catch (Exception $e) {

            }

            redirect(site_url("HalalReports/halalCirtificateUpdate/" . $form_id));
        }

        $this->parser->parse('HalalService/halal_certificate_request_update', $data);
    }
}

?>