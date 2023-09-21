<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PageControl extends CI_Controller {

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

    public function editPage($id=0) {
  
        if ($this->user_type != 'WebAdmin') {
            redirect('UserManager/not_granted');
        }
        $this->db->where('id', $id);
        $query = $this->db->get('content_pages');
        $data["operation"] = "edit";
        $data["pageId"] = "$id";
        $pageobj = $query->row_array();

        $data["pageobj"] = $pageobj;
        $data["redirecturl"] = site_url("PageControl/editPage/$id"); 
        if (isset($_POST["update_data"])) {
//            $content_pages = array(
//                "title" => $this->input->post("title"),
//                "content" => $this->input->post("content"),
//            );
//            $this->db->where('id', $id);
//            $this->db->update("content_pages", $content_pages);
//            redirect("PageControl/editPage/$id");
        }

        $this->load->view('PageControl/create', $data);
    }

}
