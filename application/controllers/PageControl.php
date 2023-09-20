<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class WebControl extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->curd = $this->load->model('Curd_model');
        $session_user = $this->session->userdata('logged_in');
        if ($session_user) {
            $this->user_id = $session_user['login_id'];
            $this->user_type = $this->session->logged_in['user_type'];
        } else {
            $this->user_id = 0;
            $this->user_type = "";
        }
    }

    public function editPage($id = 0) {
        if ($this->user_type != 'WebAdmin') {
            redirect('UserManager/not_granted');
        }
        $this->db->where('id', $id);
        $query = $this->db->get('content_pages');
        $data["operation"] = "edit";
        $data["pageId"] = "edit";
        $metaDataList = [];
        if ($query) {
            $pageobj = $query->row_array();
            $this->db->where('page_id', $id);
            $this->db->where('meta_key', "side_page_key_id");
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
        $componentPageDataList = [];
        $this->db->where('page_type', "sidebar");
        $query = $this->db->get("content_pages");
        $contentPageData = $query->result_array();
        $data["pageData"] = $contentPageData;

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
        if (isset($_POST["add_component"])) {
            $content_pages = array(
                "page_id" => $id,
                "meta_key" => "side_page_key_id",
                "meta_value" => $this->input->post("component_id")
            );
            $this->db->insert("content_page_meta", $content_pages);
            $last_id = $this->db->insert_id();

            redirect("WebControl/editPage/$id");
        }
        $this->load->view('WebControl/Pages/create', $data);
    }

}
