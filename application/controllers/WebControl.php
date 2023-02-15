<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class WebControl extends CI_Controller {

    public function __construct() {
        parent::__construct();
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
        $data = array();
        $this->load->view('WebControl/dashboard', $data);
    }

    public function createPage() {
        $pageobj = array(
            "title" => "",
            "content" => "",
            "uri" => "",
            "page_type" => "main",
            "template" => ""
        );
        $data["pageobj"] = $pageobj;
        $data["operation"] = "create";
        if (isset($_POST["update_data"])) {
            $content_pages = array(
                "title" => $this->input->post("title"),
                "uri" => $this->input->post("uriname"),
                "content" => $this->input->post("content"),
                "page_type" => "",
                "template" => "",
            );
            $this->db->insert("content_pages", $content_pages);
            $last_id = $this->db->insert_id();
            redirect("WebControl/editPage/$last_id");
        }
        $this->load->view('WebControl/Pages/create', $data);
    }

    public function pageList() {
        $data = array();
        $this->db->where('page_type', 'main');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('content_pages');
        $templatelist = $query->result_array();
        $data['pagelist'] = $templatelist;
        $this->load->view('WebControl/Pages/list', $data);
    }

    public function editPage($id = 0) {
        $this->db->where('id', $id);
        $query = $this->db->get('content_pages');
        $data["operation"] = "edit";
        $metaDataList = [];
        if ($query) {
            $pageobj = $query->row_array();
            $this->db->where('page_id', $id);
            $query = $this->db->get("content_page_meta");
            $contentDataMeta = $query->result_array();
            if ($contentDataMeta) {
                foreach ($contentDataMeta as $key => $value) {
                    $this->db->where('id', $value["meta_value"]);
                    $query = $this->db->get("content_pages");
                    $contentMetaData = $query->row_array();
                    array_push($metaDataList, $contentMetaData);
                }
            }
        } else {
            $pageobj = array("title" => "", "content" => "", "uri" => "");
        }
        $data["metaData"] = $metaDataList;
        $data["pageobj"] = $pageobj;
        if (isset($_POST["update_data"])) {
            $content_pages = array(
                "title" => $this->input->post("title"),
                "content" => $this->input->post("content"),
            );
            $this->db->where('id', $id);
            $this->db->update("content_pages", $content_pages);
            redirect("WebControl/editPage/$id");
        }
        $this->load->view('WebControl/Pages/create', $data);
    }

}

?>
