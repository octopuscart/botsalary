<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH . 'libraries/REST_Controller.php');

class Api extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Account_model');
        $this->load->model('Curd_model');
        $this->load->model('Service_model');
        $this->load->library('session');
        $this->checklogin = $this->session->userdata('logged_in');

        $session_user = $this->session->userdata('logged_in');
        if ($session_user) {
            $this->user_id = $session_user['login_id'];
            $this->user_type = isset($session_user['user_type']) ? $session_user['user_type'] : "";
        } else {
            $this->user_id = 0;
            $this->user_type = "";
        }
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

    function deleteRecordTable_get($tablename, $id) {
        if ($this->checklogin) {
            $this->db->where("id", $id);
            $this->db->delete($tablename);
        }
    }

    function listApiData_get($apipath, $isDataTableCall = "no") {

        $meta_data = $this->input->get();
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $search = $this->input->get("search");

        $apiSet = json_decode(APISET, true);
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header('Access-Control-Allow-Origin: *');
        $finaldata = [];
        if (isset($apiSet[$apipath])) {
            $tablename = $apiSet[$apipath]["table"];
            $imagepath = $apiSet[$apipath]["imagefolder"];
            $fields = $this->db->field_data($tablename);
            $tableFieldsName = array();

            foreach ($fields as $fik => $fiv) {
                array_push($tableFieldsName, $fiv->name);
            }

            $model_data = $this->Curd_model->get($tablename);
            foreach ($model_data as $key => $value) {
                if ($isDataTableCall == "no") {
                    $value["image"] = base_url("assets/uploadata/$imagepath/" . $value["image"]);
                } else {
                    $value["image"] = "<img class='shortImageTableData' src='" . base_url("assets/uploadata/$imagepath/" . $value["image"]) . "'>";
                }
                array_push($finaldata, $value);
            }
        }
        if ($isDataTableCall == "yes") {
            $output = array(
                "draw" => $draw,
                "recordsTotal" => $this->db->count_all("$tablename"),
                "recordsFiltered" => 10,
                "data" => $finaldata
            );
            $this->response($output);
        } else {
            $this->response($finaldata);
        }
    }

    function dataTableApi_get($apipath, $parent_id = 0) {
        $apiSet = json_decode(APISET, true);
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header('Access-Control-Allow-Origin: *');
        $finaldata = [];
        $post_data = $this->input->get();
        if (isset($apiSet[$apipath])) {
            $apiObj = $apiSet[$apipath];
            $tablename = $apiObj["table"];
            $imagepath = isset($apiObj["imagefolder"]) ? $apiObj["imagefolder"] : "";
            $image_field = isset($apiObj["image_field"]) ? $apiObj["image_field"] : "";
            $child_table = isset($apiObj["child_api"]) ? $apiObj["child_api"] : array();
            $has_audio = isset($apiObj["has_audio"]) ? $apiObj["has_audio"] : array();

            $config = array("field_config" => array());

            if ($imagepath) {
                $backgroundImage = "background-image:url(' " . base_url("assets/uploadata/$imagepath/") . "{field_value}')";
                $config["field_config"]["$image_field"] = array(
                    "field_value" => $image_field,
                    "template" => '<div class="shortImageTableData" style="' . $backgroundImage . '"></div><p><a target="_blank" href="' . base_url("assets/uploadata/$imagepath/") . '{field_value}">View Image</a></p>'
                );
            }

            if ($has_audio) {
                $songfilepath = $has_audio["upload_folder"];

                $config["field_config"][$has_audio["field_name"]] = array(
                    "field_value" => $has_audio["field_name"],
                    "template" => '<div class="shortImageTableData" >{field_value}</div><p><a target="_blank" href="' . base_url("$songfilepath") . '/{field_value}">View File</a><audio controls><source src="' . base_url("$songfilepath") . '/{field_value}" type="audio/mpeg"></audio></p>'
                );
            }

            if ($child_table) {
                $config["link"] = array(
                    "field_value" => $child_table["pk"],
                    "field_title" => $child_table["connect_button"],
                    "template" => ''
                    . '<a class="btn btn-primary btn-sm" href="' . site_url("Services/tableReport/" . $child_table["child_api"]) . '/{field_value}">{field_title}</a>'
                );
            }


            if (isset($apiObj["writable"])) {
                $config["operations"] = '<a class="btn btn-warning btn-sm" href="' . site_url("Services/updateData/$apipath") . '/{pk}"><i class="fa fa-edit"></i></a>&nbsp;'
                        . '<button class="btn btn-danger btn-sm button deleterow"  href="' . site_url("Api/deleteRecord/$apipath") . '/{pk}"><i class="fa fa-trash"></i></button>';
            } else {
                $config["operations"] = '<button class="btn btn-danger btn-sm button deleterow"  href="' . site_url("Api/deleteRecord/$apipath") . '/{pk}"><i class="fa fa-trash"></i></button>';
            }

            $this->Service_model->init($tablename, $post_data, $config, $apiObj["pk"], $apiObj["foreign_key"], $child_table, $parent_id);
            $response = $this->Service_model->getOutput();
            $this->response($response);
        }
    }

    function insertDataApi_post($apipath) {
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header('Access-Control-Allow-Origin: *');
        $response = array("status" => 404, "message" => "Error to submit request Error: 10001");
        try {
            $data = $this->Curd_model->getApiConfig($apipath);

            $inputData = $this->input->post();
            if (isset($inputData["apikey"])) {
                unset($inputData["apikey"]);
                $this->db->insert($data["serviceObj"]["table"], $inputData);
                $response = array("status" => 200, "message" => "Request has been submitted");
                $this->response($response);
            }
        } catch (Exception $e) {
            $response["error"] = 'Message: ' . $e->getMessage();
            $this->response($response);
        }
    }

    function ajax_upload_post($filename) {
        $response = array("file_path" => "", "file_name" => "", "error" => "");
        $temp1 = rand(100, 1000000);

        if (isset($_FILES["file_name_$filename"]["name"])) {
            $apipath = $this->input->post("apipath_$filename");
            $upload_folder_field = $this->input->post("upload_folder_field_$filename");
            $allowed_types = $this->input->post("allowed_types_field_$filename");
            $url_types = $this->input->post("url_types_field_$filename");
            $randomefilename = $this->Curd_model->generateRandomString(25, $apipath);
            $ext1 = explode('.', $_FILES["file_name_$filename"]['name']);
            $ext = strtolower(end($ext1));
            $file_newname = $randomefilename . "." . $ext;
            $config['file_name'] = $file_newname;
            $config['upload_path'] = $upload_folder_field;
            $config['allowed_types'] = $allowed_types;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload("file_name_$filename")) {
                $response["error"] = $this->upload->display_errors();
            } else {
                $data = $this->upload->data();
                $response["file_path"] =$url_types=="absolute" ?site_url("$upload_folder_field/" . $data["file_name"]) : base_url("$upload_folder_field/" . $data["file_name"]);
                $response["file_name"] = $data["file_name"];
            }
        }
        $this->response($response);
    }

    function deleteRecord_get($apipath, $id) {
        if ($this->user_id) {
            $this->Curd_model->deleteRecord($apipath, $id);
        }
    }

    function ajax_upload_file_post() {
        $apiConfig = $this->Curd_model->getApiConfig($apipath);
        $serviceObj = $apiConfig["serviceObj"];
        $imageFolder = (isset($serviceObj["imagefolder"]) ? $serviceObj["imagefolder"] : "");
        $response = array("image_path" => "", "image_name" => "");
        if (isset($_FILES["image_file"]["name"])) {
            $config['upload_path'] = 'assets/uploadata/' . $imageFolder;
            $config['allowed_types'] = 'mp3|pdf|doc|docx';
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image_file')) {
                echo $this->upload->display_errors();
            } else {
                $data = $this->upload->data();
                $response = array();
                $this->response($response);
                echo '<img src="' . base_url("assets/uploadata/") . '' . $data["file_name"] . '" width="300" height="225" class="img-thumbnail" />';
            }
        }
    }
}

?>