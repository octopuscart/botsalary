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
                "template" => $this->input->post("template_type"),
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

        $current_id = $this->input->post("member_current_id");
        $current_pos = $this->input->post("member_current_pos");
        if ($current_id) {
            foreach ($current_id as $idkey => $idvalue) {
                $cpos = $current_pos[$idkey];
                $this->db->where('id', $idvalue);
                $this->db->update("content_bot_members", array("display_index" => $cpos));
            }
            redirect("WebControl/botMembersList");
        }


        $this->load->view('WebControl/Pages/botmembers', $data);
    }

    public function addMember($member_id = 0) {
        $data = array();
        if ($this->user_type != 'WebAdmin') {
            redirect('UserManager/not_granted');
        }
        $a_date = date("Ymdhis");

        $this->db->where("id", $member_id);
        $member_data_check = $this->db->get("content_bot_members")->row_array();
        $member_data = array(
            "name" => "",
            "position" => "",
            "display_index" => "",
            "image" => ""
        );
        $data["has_member"] = "no";
        if ($member_data_check) {
            $member_data = $member_data_check;
            $data["has_member"] = "yes";
        }
        $data["member_data"] = $member_data;

        $config['upload_path'] = 'assets/content_files';
        $config['allowed_types'] = '*';
        if (isset($_POST['submit'])) {
            $picture = '';
            if (!empty($_FILES['imagename']['name'])) {
                $temp1 = rand(100, 1000000);
                $config['overwrite'] = TRUE;
                $ext1 = explode('.', $_FILES['imagename']['name']);
                $ext = strtolower(end($ext1));
                $file_newname = $a_date . $temp1 . "." . $ext;
                $picture = $file_newname;
                $config['file_name'] = $file_newname;
                //Load upload library and initialize configuration
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('imagename')) {
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                } else {
                    $picture = '';
                }
            }
            $member_array = array(
                "name" => $this->input->post("name"),
                "position" => $this->input->post("position"),
                "display_index" => $this->input->post("display_index"),
                "image" => base_url("assets/content_files/$picture")
            );
            if ($member_data_check) {
                $this->db->where("id", $member_id);
                $this->db->update("content_bot_members", $member_array);
            } else {
                $this->db->insert("content_bot_members", $member_array);
            }
            redirect(site_url("WebControl/botMembersList"));
        }

        $this->load->view('WebControl/addmember', $data);
    }

    public function pageList($page_type = "main") {
        if ($this->user_type != 'WebAdmin') {
            redirect('UserManager/not_granted');
        }
        $data = array();
        $this->db->where("page_type='$page_type'");
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('content_pages');
        $templatelist = $query->result_array();
        $data['pagelist'] = $templatelist;
        $data["page_type"] = PAGE_TYPE_OPTIONS[$page_type];
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
        $meta_attribute = "side_page_key_id";
        if ($query) {
            $pageobj = $query->row_array();
            $this->db->where('page_type', "sidebar");
            $query = $this->db->get("content_pages");
            $contentPageData = $query->result_array();
            $data["pageData"] = $contentPageData;
            $data["component_type"] = "Sidebar";

            if ($pageobj["page_type"] == "service") {
                $this->db->order_by('display_index');
                $query = $this->db->get("content_contact_data");
                $contactList = $query->result_array();
                $data["pageData"] = $contactList;
                $data["component_type"] = "Contect Page";
                $meta_attribute = "service_page_key_id";
            }


            $this->db->where('page_id', $id);
            $this->db->where('meta_key', $meta_attribute);
            $query = $this->db->get("content_page_meta");
            $contentDataMeta = $query->result_array();
            if ($contentDataMeta) {
                foreach ($contentDataMeta as $key => $value) {
                    $this->db->where('id', $value["meta_value"]);

                    if ($pageobj["page_type"] == "service") {
                        $query = $this->db->get("content_contact_data");
                    } else {
                        $query = $this->db->get("content_pages");
                    }
                    $contentMetaData = $query->row_array();
                    $contentMetaData["meta_id"] = $value["id"];
                    array_push($metaDataList, $contentMetaData);
                }
            }
        } else {
            $pageobj = array("title" => "", "content" => "", "uri" => "");
        }


        $componentPageDataList = [];

        $data["metaData"] = $metaDataList;
        $data["pageobj"] = $pageobj;
//       echo $pageobj["title"];
        $linkurl = $this->Curd_model->createUrlSlug($pageobj["title"]);

        if (isset($_POST["update_data"])) {
            $content_pages = array(
                "title" => $this->input->post("title"),
                "content" => $_POST['content'],
                "page_type" => $this->input->post("page_type"),
                "uri" => $this->input->post("uriname"),
                "template" => $this->input->post("template_type"),
            );
            $this->db->where('id', $id);
            $this->db->update("content_pages", $content_pages);

            $orderlog = array(
                'log_type' => 'Page Updated',
                'log_datetime' => date('Y-m-d H:i:s'),
                'user_id' => $this->user_id,
                'log_detail' => "Page has been Updated - " . $pageobj["title"]
            );
            $this->db->insert('system_log', $orderlog);

            redirect("WebControl/editPage/$id");
        }
        if (isset($_POST["add_component"])) {
            $content_pages = array(
                "page_id" => $id,
                "meta_key" => $meta_attribute,
                "meta_value" => $this->input->post("component_id")
            );
            $this->db->insert("content_page_meta", $content_pages);
            $last_id = $this->db->insert_id();

            redirect("WebControl/editPage/$id");
        }
        $this->load->view('WebControl/Pages/create', $data);
    }

    function deletePage($page_id) {
        $this->db->where('id', $page_id);
        $query = $this->db->get('content_pages');
        $pageobj = $query->row_array();
        $orderlog = array(
            'log_type' => 'Page Delete',
            'log_datetime' => date('Y-m-d H:i:s'),
            'user_id' => $this->user_id,
            'log_detail' => "Page has been Deleted - " . $pageobj["title"]
        );
        $this->db->insert('system_log', $orderlog);

        $this->db->where('id', $page_id);
        $this->db->delete("content_pages");
        redirect("WebControl/pageList");
    }

    function removeComponent($component_id, $page_id) {
        $this->db->where('id', $component_id);
        $this->db->delete("content_page_meta");
        redirect("WebControl/editPage/$page_id");
    }

    function contentFiles() {
        $data = array();
        if ($this->user_type != 'WebAdmin') {
            redirect('UserManager/not_granted');
        }
        $a_date = date("Ymdhis");
        $this->db->order_by('id', 'desc');
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
                $file_newname = $a_date . $temp1 . "." . $ext;
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

    public function contactPageList() {
        $data = array();
        $data['title'] = "Set Contact For Website";
        $data['description'] = "Contact List";
        $data['form_title'] = "Contact";
        $data['table_name'] = "content_contact_data";
        $data["link"] = "WebControl/contactPageList";
        $form_attr = array(
            "title" => array("title" => "Title", "width" => "250px", "required" => true, "place_holder" => "Title", "type" => "text", "default" => ""),
            "sub_title" => array("title" => "Sub Title", "width" => "250px", "required" => true, "place_holder" => "Sub Title", "type" => "text", "default" => ""),
            "address" => array("title" => "Address", "width" => "300px", "required" => true, "place_holder" => "Address", "type" => "textarea", "default" => ""),
            "contact_no" => array("title" => "Contact No.", "width" => "250px", "required" => true, "place_holder" => "Contact No.", "type" => "text", "default" => ""),
            "fax_no" => array("title" => "Fax No.", "width" => "250px", "required" => true, "place_holder" => "Fax No.", "type" => "text", "default" => ""),
            "email" => array("title" => "Email", "width" => "250px", "required" => true, "place_holder" => "Email", "type" => "text", "default" => ""),
            "image" => array("title" => "Image", "width" => "300px", "required" => true, "place_holder" => "Image", "type" => "textarea", "default" => ""),
            "display_index" => array("title" => "Display Index", "required" => false, "place_holder" => "Display Index", "type" => "number", "default" => ""),
        );
        $data['form_attr'] = $form_attr;
        $rdata = $this->Curd_model->curdForm($data);

        $this->load->view('layout/curd2', $rdata);
    }

    public function announcementList() {
        $data = array();
        $data['title'] = "Set Announcement";
        $data['description'] = "Announcement List";
        $data['form_title'] = "Announcement";
        $data['table_name'] = "content_announcement";
        $data["link"] = "WebControl/announcementList";
        $category_select = array("fastival" => "Fastival", "general" => "General");

        $dependes = array(
            "category" => $category_select,
        );

        $data['depends'] = $dependes;
        $form_attr = array(
            "title" => array("title" => "Title", "width" => "250px", "required" => true, "place_holder" => "Title", "type" => "text", "default" => ""),
            "description" => array("title" => "Description", "width" => "300px", "required" => true, "place_holder" => "Description", "type" => "textarea", "default" => ""),
            "date" => array("title" => "Date", "width" => "150px", "required" => true, "place_holder" => "Date", "type" => "text", "default" => ""),
            "month" => array("title" => "Month (Ex: June, July)", "width" => "250px", "required" => true, "place_holder" => "Month should be in string", "type" => "text", "default" => ""),
            "year" => array("title" => "Year", "width" => "100px", "required" => true, "place_holder" => "Year (YYYY)", "type" => "text", "default" => ""),
            "category" => array("title" => "Category", "width" => "200px", "required" => true, "place_holder" => "Category", "type" => "select", "default" => "", "depends" => "category", "default" => ""),
        );
        $data['form_attr'] = $form_attr;
        $rdata = $this->Curd_model->curdForm($data);

        $this->load->view('layout/curd2', $rdata);
    }

    public function serviceEmailPageList() {
        $data = array();
        $data['title'] = "Set Email Receiver For Service";
        $data['description'] = "Service Email List";
        $data['form_title'] = "Contact";
        $data['table_name'] = "content_service_email";
        $data["link"] = "WebControl/serviceEmailPageList";
        $data["addnew"] = false;
        $form_attr = array(
            "service_title" => array("title" => "Title", "width" => "250px", "required" => true, "place_holder" => "Service", "type" => "disabled", "default" => ""),
            "email" => array("title" => "Email", "width" => "250px", "required" => true, "place_holder" => "Email", "type" => "text", "default" => ""),
        );
        $data['form_attr'] = $form_attr;
        $rdata = $this->Curd_model->curdForm($data);

        $this->load->view('layout/curd2', $rdata);
    }

    function photoGallery() {
        $data = array();
        if ($this->user_type != 'WebAdmin') {
            redirect('UserManager/not_granted');
        }
        $a_date = date("Ymdhis");

        $query = $this->db->get("content_photo_gallery");
        $filesdata = $query->result_array();
        $data["filesdata"] = $filesdata;

        $query = $this->db->get("content_photo_gallery_category");
        $filescategorydata = $query->result_array();
        $data["filescategorydata"] = $filescategorydata;

        $config['upload_path'] = 'assets/photo-gallery';
        $config['allowed_types'] = '*';
        if (isset($_POST['submit'])) {
            $picture = '';
            if (!empty($_FILES['fileData']['name'])) {
                $temp1 = rand(100, 1000000);
                $config['overwrite'] = TRUE;
                $ext1 = explode('.', $_FILES['fileData']['name']);
                $ext = strtolower(end($ext1));
                $file_newname = $a_date . $temp1 . "." . $ext;
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
                "display_index" => 0,
            );
            $this->db->insert("content_photo_gallery", $fileinsert);

            redirect(site_url("WebControl/photoGallery"));
        }

        $this->load->view('WebControl/fileUpload2', $data);
    }

    public function photoGalleryAlbumEdit() {
        $data = array();
        $data['title'] = "Set Photo Album";
        $data['description'] = "Photo Album List";
        $data['form_title'] = "Photo Album";
        $data['table_name'] = "content_photo_gallery";
        $data["link"] = "WebControl/photoGalleryAlbumEdit";
        $form_attr = array(
            "file_name" => array("title" => "Title", "width" => "250px", "required" => true, "place_holder" => "Title", "type" => "text", "default" => ""),
            "file_category" => array("title" => "Category", "width" => "250px", "required" => true, "place_holder" => "Year", "type" => "text", "default" => ""),
            "file_caption" => array("title" => "Caption", "width" => "300px", "required" => true, "place_holder" => "Month", "type" => "text", "default" => ""),
            "datetime" => array("title" => "Date Time", "required" => false, "place_holder" => "Display Index", "type" => "number", "default" => ""),
            "display_index" => array("title" => "Display Index", "required" => false, "place_holder" => "Display Index", "type" => "number", "default" => ""),
        );
        $data['form_attr'] = $form_attr;
        $rdata = $this->Curd_model->curdForm($data);

        $this->load->view('layout/curd2', $rdata);
    }

    public function photoGalleryAlbum() {
        $data = array();
        $data['title'] = "Set Photo Album";
        $data['description'] = "Photo Album List";
        $data['form_title'] = "Photo Album";
        $data['table_name'] = "content_photo_gallery_category";
        $data["link"] = "WebControl/photoGalleryAlbum";
        $form_attr = array(
            "title" => array("title" => "Title", "width" => "250px", "required" => true, "place_holder" => "Title", "type" => "text", "default" => ""),
            "year" => array("title" => "Year", "width" => "250px", "required" => true, "place_holder" => "Year", "type" => "text", "default" => ""),
            "month" => array("title" => "Month", "width" => "300px", "required" => true, "place_holder" => "Month", "type" => "text", "default" => ""),
            "display_index" => array("title" => "Display Index", "required" => false, "place_holder" => "Display Index", "type" => "number", "default" => ""),
        );
        $data['form_attr'] = $form_attr;
        $rdata = $this->Curd_model->curdForm($data);

        $this->load->view('layout/curd2', $rdata);
    }

    ///Category management 
    public function category_api() {
        $this->db->select('c.id as id,  c.title as text, p.id as parent, c.page_url, c.is_editable');
        $this->db->join('content_menu as p', 'p.id = c.parent_id', 'left');
        $this->db->from('content_menu as c');
        $this->db->order_by('c.display_index');
        $query = $this->db->get();
        $result = $query->result();
        $category = array();
        $categorylist = array();
        foreach ($result as $key => $value) {
            $cat = array('id' => $value->id,
                'parent' => $value->parent ? $value->parent : '#',
                'state' => array('opened' => TRUE),
                'page_url' => $value->page_url,
                'is_editable' => $value->is_editable,
                'a_attr' => array('selectCategory' => ($value->id)),
                'text' => $value->text);
            array_push($category, $cat);
            $categorylist[$value->id] = $cat;
        }
        echo json_encode(array('tree' => $category, 'list' => $categorylist));
    }

    //Add Categories
    function categorie_delete($category_id) {
        $this->db->delete('content_menu', array('id' => $category_id));
    }

    //Add Categories
    function menuSetting() {

//        $this->db->where('page_type', 'main');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('content_pages');
        $templatelist = $query->result_array();
        $data['pages_list'] = $templatelist;

        $this->db->select('c.id as id, c.title as text, p.id as parent, c.is_editable');
        $this->db->join('content_menu as p', 'p.id = c.parent_id', 'left');
        $this->db->from('content_menu as c');
        $query = $this->db->get();

        $data['category_data'] = $query->result();

        if (isset($_POST['submit'])) {
            if ($_POST['submit'] == 'Add Menu') {
                $category_array = array(
                    'title' => $this->input->post('category_name'),
                    'page_url' => $this->input->post('page_url') ? $this->input->post('page_url') : "",
                    'parent_id' => $this->input->post('parent_id'),
                    'page_type' => $this->input->post('parent_id') ? "sub_menu" : "main",
                );
                $this->db->insert('content_menu', $category_array);
            }
            if ($_POST['submit'] == 'Edit') {
                $category_array = array(
                    'title' => $this->input->post('category_name'),
                );
                if ($this->input->post('page_url')) {
                    $category_array["page_url"] = $this->input->post('page_url');
                }
            
                $id = $this->input->post('parent_id');
                $this->db->set($category_array);
                $this->db->where('id', $id);
                $this->db->update('content_menu');
            }
            redirect('WebControl/menuSetting');
        }


        $data['images'] = [];

        $this->load->view('WebControl/Pages/webmenu', $data);
    }

    public function galleryImageList($album_id = 1) {
        if ($this->user_type != 'WebAdmin') {
            redirect('UserManager/not_granted');
        }
        $data = array();

        $a_date = date("Ymdhis");

        $this->db->order_by('display_index');
        $query = $this->db->get('content_photo_gallery_category');
        $album_list = $query->result_array();

        $data["album_list"] = $album_list;
        $data["album_id"] = $album_id;

        $this->db->where("file_category", $album_id);
        $this->db->order_by('display_index');
        $query = $this->db->get('content_photo_gallery');
        $memberslist = $query->result_array();
        $data['memberslist'] = $memberslist;

        $current_id = $this->input->post("member_current_id");
        $current_pos = $this->input->post("member_current_pos");
        if ($current_id) {
            foreach ($current_id as $idkey => $idvalue) {
                $cpos = $current_pos[$idkey];
                $this->db->where('id', $idvalue);
                $this->db->update("content_photo_gallery", array("display_index" => $cpos));
            }
            redirect("WebControl/galleryImageList");
        }

        $config['upload_path'] = 'assets/photo-gallery';
        $config['allowed_types'] = '*';
        if (isset($_POST['submit'])) {
            $picture = '';
            if (!empty($_FILES['fileData']['name'])) {
                $temp1 = rand(100, 1000000);
                $config['overwrite'] = TRUE;
                $ext1 = explode('.', $_FILES['fileData']['name']);
                $ext = strtolower(end($ext1));
                $file_newname = $a_date . $temp1 . "." . $ext;
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
                "display_index" => 0,
            );
            $this->db->insert("content_photo_gallery", $fileinsert);

            redirect(site_url("WebControl/galleryImageList/$album_id"));
        }


        $this->load->view('WebControl/Pages/galleryimages', $data);
    }
}

?>
