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
        $this->db->where("file_category", "Bot Members");
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
        $data["pageId"] =$id;
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

    function dbinsert() {
        $rhingra = ["DSC_8406.jpg",   "DSC_8567.jpg",   "DSC_8686.jpg",   "DSC_8827.jpg",   "DSC_8903.jpg",   "DSC_9018.jpg",   "DSC_9071.jpg",   "DSC_9134.jpg", 
"DSC_8453.jpg",   "DSC_8568.jpg",   "DSC_8688.jpg",   "DSC_8828.jpg",   "DSC_8904.jpg",   "DSC_9019.jpg",   "DSC_9072.jpg",   "DSC_9135.jpg", 
"DSC_8472.jpg",   "DSC_8572.jpg",   "DSC_8689.jpg",   "DSC_8829.jpg",   "DSC_8905.jpg",   "DSC_9020.jpg",   "DSC_9074.jpg",   "DSC_9136.jpg", 
"DSC_8473.jpg",   "DSC_8574.jpg",   "DSC_8690.jpg",   "DSC_8830.jpg",   "DSC_8906.jpg",   "DSC_9028.jpg",   "DSC_9076.jpg",   "DSC_9137.jpg", 
"DSC_8476.jpg",   "DSC_8578.jpg",   "DSC_8691.jpg",   "DSC_8832.jpg",   "DSC_8912.jpg",   "DSC_9029.jpg",   "DSC_9077.jpg",   "DSC_9139.jpg", 
"DSC_8477.jpg",   "DSC_8587.jpg",   "DSC_8692.jpg",   "DSC_8837.jpg",   "DSC_8913.jpg",   "DSC_9031.jpg",   "DSC_9078.jpg",   "DSC_9140.jpg", 
"DSC_8478.jpg",   "DSC_8605.jpg",   "DSC_8697.jpg",   "DSC_8838.jpg",   "DSC_8914.jpg",   "DSC_9037.jpg",   "DSC_9082.jpg",   "DSC_9141.jpg", 
"DSC_8479.jpg",   "DSC_8606.jpg",   "DSC_8700.jpg",   "DSC_8846.jpg",   "DSC_8916.jpg",   "DSC_9038.jpg",   "DSC_9083.jpg",   "DSC_9142.jpg", 
"DSC_8501.jpg",   "DSC_8607.jpg",   "DSC_8733.jpg",   "DSC_8848.jpg",   "DSC_8922.jpg",   "DSC_9040.jpg",   "DSC_9098.jpg",   "DSC_9143.jpg", 
"DSC_8515.jpg",   "DSC_8608.jpg",   "DSC_8739.jpg",   "DSC_8864.jpg",   "DSC_8933.jpg",   "DSC_9041.jpg",   "DSC_9099.jpg",   "DSC_9146.jpg", 
"DSC_8519.jpg",   "DSC_8631.jpg",   "DSC_8740.jpg",   "DSC_8865.jpg",   "DSC_8942.jpg",   "DSC_9042.jpg",   "DSC_9100.jpg",   "DSC_9148.jpg", 
"DSC_8520.jpg",   "DSC_8633.jpg",   "DSC_8742.jpg",   "DSC_8867.jpg",   "DSC_8943.jpg",   "DSC_9043.jpg",   "DSC_9101.jpg",   "DSC_9149.jpg", 
"DSC_8521.jpg",   "DSC_8635.jpg",   "DSC_8745.jpg",   "DSC_8868.jpg",   "DSC_8957.jpg",   "DSC_9045.jpg",   "DSC_9102.jpg",   "DSC_9154.jpg", 
"DSC_8522.jpg",   "DSC_8637.jpg",   "DSC_8746.jpg",   "DSC_8871.jpg",   "DSC_8958.jpg",   "DSC_9046.jpg",   "DSC_9103.jpg",   "DSC_9156.jpg", 
"DSC_8523.jpg",   "DSC_8641.jpg",   "DSC_8747.jpg",   "DSC_8872.jpg",   "DSC_8959.jpg",   "DSC_9047.jpg",   "DSC_9104.jpg",   "DSC_9158.jpg", 
"DSC_8524.jpg",   "DSC_8642.jpg",   "DSC_8748.jpg",   "DSC_8875.jpg",   "DSC_8960.jpg",   "DSC_9050.jpg",   "DSC_9105.jpg",   "DSC_9162.jpg", 
"DSC_8525.jpg",   "DSC_8643.jpg",   "DSC_8797.jpg",   "DSC_8880.jpg",   "DSC_8961.jpg",   "DSC_9051.jpg",   "DSC_9106.jpg",   "DSC_9213.jpg", 
"DSC_8527.jpg",   "DSC_8645.jpg",   "DSC_8798.jpg",   "DSC_8888.jpg",   "DSC_8962.jpg",   "DSC_9053.jpg",   "DSC_9107.jpg",   "DSC_9218.jpg", 
"DSC_8530.jpg",   "DSC_8646.jpg",   "DSC_8799.jpg",   "DSC_8892.jpg",   "DSC_8964.jpg",   "DSC_9054.jpg",   "DSC_9109.jpg",   "DSC_9220.jpg", 
"DSC_8531.jpg",   "DSC_8674.jpg",   "DSC_8802.jpg",   "DSC_8893.jpg",   "DSC_8971.jpg",   "DSC_9055.jpg",   "DSC_9110.jpg",   "DSC_9221.jpg", 
"DSC_8532.jpg",   "DSC_8675.jpg",   "DSC_8806.jpg",   "DSC_8894.jpg",   "DSC_8973.jpg",   "DSC_9056.jpg",   "DSC_9114.jpg",   "DSC_9227.jpg", 
"DSC_8538.jpg",   "DSC_8676.jpg",   "DSC_8808.jpg",   "DSC_8895.jpg",   "DSC_8974.jpg",   "DSC_9057.jpg",   "DSC_9115.jpg",   "DSC_9236.jpg", 
"DSC_8541.jpg",   "DSC_8677.jpg",   "DSC_8810.jpg",   "DSC_8896.jpg",   "DSC_8975.jpg",   "DSC_9058.jpg",   "DSC_9122.jpg",   "DSC_9243.jpg", 
"DSC_8542.jpg",   "DSC_8678.jpg",   "DSC_8811.jpg",   "DSC_8897.jpg",   "DSC_8994.jpg",   "DSC_9059.jpg",   "DSC_9123.jpg",   "DSC_9244.jpg", 
"DSC_8550.jpg",   "DSC_8679.jpg",   "DSC_8812.jpg",   "DSC_8898.jpg",   "DSC_8995.jpg",   "DSC_9062.jpg",   "DSC_9124.jpg",   "DSC_9245.jpg", 
"DSC_8551.jpg",   "DSC_8680.jpg",   "DSC_8814.jpg",   "DSC_8899.jpg",   "DSC_8996.jpg",   "DSC_9064.jpg",   "DSC_9125.jpg",   "DSC_9246.jpg", 
"DSC_8559.jpg",   "DSC_8682.jpg",   "DSC_8815.jpg",   "DSC_8900.jpg",   "DSC_8999.jpg",   "DSC_9066.jpg",   "DSC_9128.jpg",   "DSC_9247.jpg", 
"DSC_8561.jpg",   "DSC_8683.jpg",   "DSC_8820.jpg",   "DSC_8901.jpg",   "DSC_9014.jpg",   "DSC_9068.jpg",   "DSC_9130.jpg",   
"DSC_8563.jpg",   "DSC_8685.jpg",   "DSC_8826.jpg",   "DSC_8902.jpg",   "DSC_9015.jpg",   "DSC_9070.jpg",   "DSC_9132.jpg", ];
        foreach ($rhingra as $key => $value) {
            echo $value;
            $fileinsert = array(
                "file_name" => $value,
                "file_category" => "11",
                "file_caption" => "MWL conference $key",
                "datetime" => date("Y-m-d H:i:s a"),
                "display_index" => $key
            );
//            $this->db->insert("content_photo_gallery", $fileinsert);
        }
    }

}

?>
