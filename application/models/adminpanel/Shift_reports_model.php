<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Shift_reports_model extends CI_Model {

    private $table = 'shift_reports';
    private $fields;
    private $user;
    private $time;

    public function __construct() {
        parent::__construct();
        $this->fields = $this->db->list_fields($this->table);
        $this->user = $this->session->userdata('username');
        $this->time = date('Y-m-d H:i:s',time());
    }

    public function get_all_reports($order_by = "shift_reports_id", $sort_order = "DESC", $search_data, $limit = 0, $offset = 0) {
        if (!in_array($order_by, $this->fields)) return array();
        $this->search_query($order_by, $sort_order, $search_data);
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $query->total_rows = $this->count_all_search_reports($order_by, $sort_order, $search_data);
        if ($query->num_rows() > 0) {
            return $query;
        }
        return false;
    }

    private function search_query($order_by, $sort_order, $search_data) {
        if (!empty($search_data)) {
            $data = array(
                'shift_reports_id' => $search_data['id'] ? $search_data['id'] : "",
                'shift' => $search_data['shift'] ? $search_data['shift'] : "",
                'category_id' => $search_data['category'] ? $search_data['category'] : "",
                'product' => $search_data['product'] ? $search_data['product'] : "",
                'remarks' => $search_data['remarks'] ? $search_data['remarks'] : "",
            );
        }
        if (!empty($search_data['finish_time']) && !empty($search_data['submit_time'])) {
            $cond = array(
                'status' => $search_data['status'],
                'finish' => $search_data['finish_time'],
                'created_time' => $search_data['submit_time']
            );
        } else {
            $cond = array('status' => !empty($search_data['status']) ? $search_data['status'] : 'active');
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

    private function count_all_search_reports($order_by, $sort_order, $search_data) {
        $this->search_query($order_by, $sort_order, $search_data);
        return $this->db->count_all_results();
    }

    public function get_one_report($key) {
        $this->db->select($this->fields);
        $this->db->from($this->table);
        $this->db->where('shift_reports_id', $key);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function insert_report($data) {
        $new_data = array(
            'product' => $data['product'],
            'player_name' => $data['player_name'],
            'shift' => $data['shift'],
            'finish' => $data['finish'],
            'follow_up' => $data['follow_up'],
            'status' => $data['status'],
            'remarks' => $data['remarks'],
            'category_id' => $data['category_id'],
            'sub_category_id' => $data['sub_category_id'],
            'created_by' => $this->user,
            'created_time' => $this->time,
            'last_updated_by' => $this->user,
            'last_updated_time' => $this->time
        );
        $this->db->insert($this->table, $new_data);
        return $this->is_query_working();
    }

    public function edit_report($data) {
        if ($this->is_exist($data['id'])) {
            $new_data = array(
                'product' => $data['product'],
                'player_name' => $data['player_name'],
                'shift' => $data['shift'],
                'follow_up' => $data['follow_up'],
                'status' => $data['status'],
                'remarks' => $data['remarks'],
                'category_id' => $data['category_id'],
                'sub_category_id' => $data['sub_category_id'],
                'last_updated_by' => $this->user,
                'last_updated_time' => $this->time
            );
            $this->db->where('shift_reports_id', $data['id']);
            $this->db->update($this->table, $new_data);
            return $this->is_query_working();
        } else {
            return false;
        }
    }

    public function delete_report($key) {
        $this->db->where('shift_reports_id', $key);
        $this->db->update($this->table, array('status' => 'delete'));
        return $this->is_query_working();
    }

    private function is_exist($key) {
        $this->db->select($this->fields);
        $this->db->from($this->table);
        $this->db->where('shift_reports_id', $key);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }

    private function is_query_working(){
        if($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }


}
