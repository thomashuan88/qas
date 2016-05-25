<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_evaluation_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_qa($limit = 0, $offset = 0, $order_by = "username", $sort_order = "asc", $search_data) {
        $fields = $this->db->list_fields('user_evaluation');
        if (!in_array($order_by, $fields)) return array();

        if (!empty($search_data['username'])) {
             $this->db->where('username', $search_data['username']);
        }
        if (!empty($search_data['import_date'])) {
             $this->db->like('imported_time', $search_data['imported_time']);
        }
        if (!empty($search_data['status']) && $search_data['status'] !== 'all') {
             $this->db->where('status', $search_data['status']);
        }

        $this->db->select('`id`, `username`, `imported_time`, `status`, `evaluate_mark`, `evaluate_by`, `mark_delete`, `evaluate_time`, `chat_start_time`, `chat_end_time`, `duration`, `chat_starting_page`, `opterator`, `browser`, `os`, `host_address`, `host_ip`, `real_time_session_ref`, `country`, `city`, `organization`, `world_region`, `time_zone`, `isp`, `player`, `brand`, `update_time`, `update_by`');
        $this->db->from('user_evaluation');

        $this->db->order_by($order_by, $sort_order);
        $this->db->limit($limit, $offset);

        $q = $this->db->get();
        if($q->num_rows() > 0) {
            return $q;
        }

        return false;
    }

    public function get_qa_data($id) {
        $this->db->select('`id`, `username`, `imported_time`, `status`, `evaluate_mark`, `evaluate_by`, `mark_delete`, `evaluate_time`, `chat_start_time`, `chat_end_time`, `duration`, `chat_starting_page`, `opterator`, `browser`, `os`, `host_address`, `host_ip`, `real_time_session_ref`, `country`, `city`, `organization`, `world_region`, `time_zone`, `isp`, `player`, `brand`, `update_time`, `update_by`')
            ->from('user_evaluation')
            ->where('id', $id)
            ->limit(1);

        $q = $this->db->get();

        if ($q->num_rows() == 1) {
            return $q->row();
        }

        return false;
    }
    public function count_all_qa()
    {
        return $this->db->count_all_results('user_evaluation');
    }
    public function count_all_search_qa($search_data) {

        if (!empty($search_data['username'])) {
             $this->db->where('username', $search_data['username']);
        }
        if (!empty($search_data['import_date'])) {
             $this->db->like('imported_time', $search_data['imported_time']);
        }
        if (!empty($search_data['status'])) {
             $this->db->where('status', $search_data['status']);
        }
        $this->db->select('id');
        $this->db->from('user_evaluation');

        return $this->db->count_all_results();
    }


    public function get_all_qa(){
        $this->db->select('user_id,username,role,leader');
        $this->db->from('users');
        $this->db->where('`status`','active');
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->result('array');
        }
        return false;
    }


    public function toggle_active($username, $active) {
        $data = array('status' => ($active=="active" ? "inactive" : "active"));
        $this->db->where('username', $username);
        $this->db->update('users', $data);
        if($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }


}
