<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_evaluation_model extends CI_Model {
    public $tablename = 'user_evaluation';
    public $fields = '`id`, `username`, `imported_time`, `status`, `coverage`, `evaluate_mark`, `evaluate_by`, `mark_delete`, `evaluate_time`, `chat_start_time`, `chat_end_time`, `duration`, `chat_starting_page`, `opterator`, `browser`, `os`, `host_address`, `host_ip`, `real_time_session_ref`, `country`, `city`, `organization`, `world_region`, `time_zone`, `isp`, `player`, `brand`, `areas_of_strength`, `areas_of_improvement`, `action_plan`, `employee_comments`, `update_time`, `update_by`';

    public function __construct() {
        parent::__construct();
    }

    public function get_qa($limit = 0, $offset = 0, $order_by = "username", $sort_order = "asc", $search_data) {
        $fields = $this->db->list_fields($this->tablename);
        if (!in_array($order_by, $fields)) return array();

        if (!empty($search_data['username'])) {
             $this->db->where('username', $search_data['username']);
        }
        if (!empty($search_data['imported_time'])) {
             $this->db->like('imported_time', $search_data['imported_time']);
        }
        if (!empty($search_data['status']) && $search_data['status'] !== 'all') {
             $this->db->where('status', $search_data['status']);
        }
        $this->db->where('mark_delete', 'N');
        $this->db->select($this->fields);
        $this->db->from($this->tablename);

        $this->db->order_by($order_by, $sort_order);
        $this->db->limit($limit, $offset);

        $q = $this->db->get();
        if($q->num_rows() > 0) {
            return $q;
        }

        return false;
    }

    public function get_qa_data($id) {
        $this->db->select($this->fields)
            ->from($this->tablename)
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
        return $this->db->count_all_results($this->tablename);
    }
    public function count_all_search_qa($search_data) {

        if (!empty($search_data['username'])) {
             $this->db->where('username', $search_data['username']);
        }
        if (!empty($search_data['imported_time'])) {
             $this->db->like('imported_time', $search_data['imported_time']);
        }
        if (!empty($search_data['status'])) {
             $this->db->where('status', $search_data['status']);
        }
        $this->db->where('mark_delete', 'N');
        $this->db->select('id');
        $this->db->from($this->tablename);

        return $this->db->count_all_results();
    }


    public function get_all_qa($cond){
        $this->db->select($this->fields);
        $this->db->from($this->tablename);
        $this->db->where('`mark_delete`','N');
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->result('array');
        }
        return false;
    }

    public function update($data=array(), $cond=array()) {
        $this->db->trans_start();
        
        $this->db->where($cond);
        $this->db->update($this->tablename, $data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return false;
        }
        return true;
    }


}
