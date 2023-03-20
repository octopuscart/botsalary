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

    public function index() {
        if ($this->user_type != 'WebAdmin') {
            redirect('UserManager/not_granted');
        }
        $data = array();
        $this->load->view('WebControl/dashboard', $data);
    }

    public function createPage() {
        if ($this->user_type != 'WebAdmin') {
            redirect('UserManager/not_granted');
        }
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
                "page_type" => $this->input->post("page_type"),
                "template" => "",
            );
            $this->db->insert("content_pages", $content_pages);
            $last_id = $this->db->insert_id();
            redirect("WebControl/editPage/$last_id");
        }
        $this->load->view('WebControl/Pages/create', $data);
    }

    public function botMembersList() {
        if ($this->user_type != 'WebAdmin') {
            redirect('UserManager/not_granted');
        }
        $data = array();
        $this->db->order_by('display_index');
        $query = $this->db->get('content_bot_members');
        $memberslist = $query->result_array();
        $data['memberslist'] = $memberslist;

//        $this->db->where('id', $id);
        $this->db->where( "file_category", "Bot Members");
        $query = $this->db->get("content_files");
        $filesdata = $query->result_array();
        $data["filesdata"] = $filesdata;
        
        $this->load->view('WebControl/Pages/botmembers', $data);
    }

    public function pageList() {
        if ($this->user_type != 'WebAdmin') {
            redirect('UserManager/not_granted');
        }
        $data = array();
        $this->db->where('page_type', 'main');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('content_pages');
        $templatelist = $query->result_array();
        $data['pagelist'] = $templatelist;
        $this->load->view('WebControl/Pages/list', $data);
    }

    public function editPage($id = 0) {
        if ($this->user_type != 'WebAdmin') {
            redirect('UserManager/not_granted');
        }
        $this->db->where('id', $id);
        $query = $this->db->get('content_pages');
        $data["operation"] = "edit";
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

    function contentFiles() {
        $data = array();
        if ($this->user_type != 'WebAdmin') {
            redirect('UserManager/not_granted');
        }
        $a_date = date("Ymdhis");

        $query = $this->db->get("content_files");
        $filesdata = $query->result_array();
        $data["filesdata"] = $filesdata;

        $this->db->where('meta_key', "file_category");
        $query = $this->db->get("content_page_meta");
        $filescategorydata = $query->result_array();
        $data["filescategorydata"] = $filescategorydata;

        $config['upload_path'] = 'assets/content_files';
        $config['allowed_types'] = '*';
        if (isset($_POST['submit'])) {
            $picture = '';
            if (!empty($_FILES['fileData']['name'])) {
                $temp1 = rand(100, 1000000);
                $config['overwrite'] = TRUE;
                $ext1 = explode('.', $_FILES['fileData']['name']);
                $ext = strtolower(end($ext1));
                $file_newname = $a_date . $temp1 . $ext;
                $picture = $file_newname;
                $config['file_name'] = $file_newname;
                //Load upload library and initialize configuration
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('fileData')) {
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                } else {
                    $picture = '';
                }
            }
            $filecaption = $this->input->post("fileName");

            $fileinsert = array(
                "file_name" => $picture,
                "file_category" => $this->input->post("fileCategory"),
                "file_caption" => $this->input->post("fileName"),
                "datetime" => date("Y-m-d H:i:s a"),
            );
            $this->db->insert("content_files", $fileinsert);

            redirect(site_url("WebControl/contentFiles"));
        }

        $this->load->view('WebControl/fileUpload', $data);
    }

}

?>
