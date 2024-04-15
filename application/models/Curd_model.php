<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Curd_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function query($query) {
        $query = $this->db->query($query);
        $data = $query->result_array();
        return $data; //format the array into json data
    }

    public function insert($table, $data) {
        $this->db->insert($table, $data);
        return $insert_id = $this->db->insert_id();
    }

    public function get($table, $order_by = 'asc', $order_field = "id") {
        $this->db->order_by('id', $order_by);
        $query = $this->db->get($table);
        $data = $query->result_array();
        return $data;
    }

    public function get_single($table, $id) {
        $this->db->where('id', $id);
        $query = $this->db->get($table);
        $data = $query->row();
        return $data;
    }

    public function get_single2($table, $id) {
        $this->db->where('id', $id);
        $query = $this->db->get($table);
        $data = $query->row_array();
        return $data;
    }

    function curdForm($data) {
        $table_name = $data["table_name"];
        $form_attr = $data['form_attr'];
        $data["addnew"] = isset($data["addnew"]) ? $data["addnew"] : true;
        $data['depends'] = isset($data['depends'])? $data['depends']:[];
        if (isset($_POST['submitData'])) {
            $postarray = array();
            foreach ($form_attr as $key => $value) {
                $postarray[$key] = $this->input->post($key);
            }
            $this->Curd_model->insert($table_name, $postarray);
            redirect($data["link"]);
        }
        $categories_data = $this->Curd_model->get($table_name);
        $data['list_data'] = $categories_data;
        $fields = array();
        $fields["id"] = array("title" => "ID#", "width" => "100px");
        $fields = array_merge($fields, $form_attr);
        $data['fields'] = $fields;
        $data['form_attr'] = $form_attr;
        return $data;
    }

    public function getApiConfig($apipath, $parent_id = 0) {

        $serviceObj = json_decode(APISET, true)[$apipath];

        $fieldsName = $this->db->list_fields($serviceObj["table"]);
        $ignoreField = $serviceObj["ignore_field"];
        $has_link = isset($serviceObj["child_api"]) ? true : false;
        $writable = isset($serviceObj["writable"]) ? true : false;
        $imageField = isset($serviceObj["image_field"]) ? $serviceObj["image_field"] : "";
        $title = $serviceObj["title"];
        $writelink = site_url("Services/addData/$apipath/$parent_id");
        $redirect_url = isset($serviceObj["redirect_url"]) ? $serviceObj["redirect_url"] : "";
        $parent_link = "";
        if ($parent_id) {
            $foreign_key = $serviceObj["foreign_key"];
            $child_table = isset($serviceObj["child_api"]) ? $serviceObj["child_api"] : array();
            $parent_table = $this->Curd_model->get_single($foreign_key["table_name"], $parent_id, $foreign_key["pk"], true);
            $title = $title . " -> " . $parent_table[$foreign_key["title"]];
            $parent_link_api = $foreign_key["parent_api"];
            $parent_link = site_url("Services/tableReport/$parent_link_api");
        }
        $data = array(
            "serviceObj" => $serviceObj,
            "apipath" => $apipath,
            "fieldsName" => $fieldsName,
            "title" => $title,
            "has_link" => $has_link,
            "parent_id" => $parent_id,
            "parent_link" => $parent_link,
            "ignore_field" => $ignoreField,
            "writable" => $writable,
            "writelink" => $writelink,
            "imageField" => $imageField,
            "pk" => $serviceObj["pk"],
            "redirect_url" => $redirect_url
        );
        return $data;
    }

    public function generateRandomString($length = 10, $suffix = "") {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString . "-" . $suffix;
    }

    public function deleteRecord($apipath, $id) {
        $serviceObj = json_decode(APISET, true)[$apipath];
        echo $pk_name = $serviceObj["pk"];
        echo $id;
        $this->db->where($pk_name, $id);
        $this->db->delete($serviceObj["table"]);
    }

    public function createUrlSlug($urlString) {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $urlString);
        return strtolower($slug);
//        return  $slug;
    }
}

?>