<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Category_group_model extends CI_Model {

    private $table = 'category_group';
    private $fields;
    private $user;
    private $time;

    public function __construct() {
        parent::__construct();
        $this->fields = $this->db->list_fields($this->table);
        $this->user = $this->session->userdata('username');
        $this->time = date('Y-m-d H:i:s', time());
    }

    public function get_all_category_group($order_by, $sort_order, $search_data, $limit, $offset) {
        if (!in_array($order_by, $this->fields)) return array();
        $this->search_category_group($order_by, $sort_order, $search_data);
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $query->total_rows = $this->count_all_search_category_group($order_by, $sort_order, $search_data);
        if ($query->num_rows() > 0) {
            return $query;
        }
        return false;
    }

    private function count_all_search_category_group($order_by, $sort_order, $search_data) {
        $this->search_category_group($order_by, $sort_order, $search_data);
        return $this->db->count_all_results();
    }

    private function search_category_group($order_by, $sort_order, $search_data) {
        if (!empty($search_data)) {
            $data = array(
                'category_group_id' => $search_data['id'] ? $search_data['id'] : "",
                'content' => $search_data['content'] ? $search_data['content'] : ""
            );
        }

        if (!empty($search_data['status'])) {
            if($search_data['status'] == "all"){
                $cond = array('status !=' => 'delete');
            } else {
                $cond = array('status' => $search_data['status']);
            }
        } else {
            $cond = array('status' => 'active');
        }

        $this->db->select($this->fields);
        $this->db->from($this->table);
        $this->db->where($cond);
        if (!empty($data)) {
            $this->db->group_start();
            $this->db->like($data);
            $this->db->group_end();
        }
        $this->db->order_by($order_by, $sort_order);
    }

    public function get_types(){
        $this->db->select($this->fields);
        $this->db->from($this->table);
        $this->db->where('status', 'active');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        }
        return false;
    }

    public function get_one_category_group($key) {
        $this->db->select($this->fields);
        $this->db->from($this->table);
        $this->db->where('category_group_id', $key);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function insert_category_group($data) {
        $new_data = array(
            'content' => $data['content'],
            'status' => $data['status'],
            'created_by' => $this->user,
            'created_time' => $this->time,
            'last_updated_by' => $this->user,
            'last_updated_time' => $this->time
        );
        $this->db->insert($this->table, $new_data);
        return $this->is_query_working();
    }

    public function edit_category_group($data){
        if ($this->is_exist($data['id'])) {
            $new_data = array(
                'content' => $data['content'],
                'status' => $data['status'],
                'last_updated_by' => $this->user,
                'last_updated_time' => $this->time
            );
            $this->db->where('category_group_id', $data['id']);
            $this->db->update($this->table, $new_data);
            return $this->is_query_working();
        } else {
            return false;
        }
    }

    public function delete_category_group($key){
        if($this->is_exist($key)){
            $this->db->where('category_group_id', $key);
            $this->db->update($this->table, array('status' => 'delete'));
            return $this->is_query_working();
        } else{
            return false;
        }
    }

    private function is_exist($key) {
        $this->db->select($this->fields);
        $this->db->from($this->table);
        $this->db->where('category_group_id', $key);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }

    private function is_query_working() {
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}