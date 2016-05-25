<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Time_sheet_model extends CI_Model {

    private $table = 'time_sheet';
    private $fields;
    private $user;
    private $time;

    public function __construct() {
        parent::__construct();
        $this->fields = $this->db->list_fields($this->table);
        $this->user = $this->session->userdata('username');
        $this->time = date('Y-m-d H:i:s',time());
    }

    public function get_all_time_sheets($order_by = "time_sheet_id", $sort_order = "DESC", $search_data, $limit = 0, $offset = 0) {
        if (!in_array($order_by, $this->fields)) return array();
        $this->search_query($order_by, $sort_order, $search_data);
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $query->total_rows = $this->count_all_search_time_sheet($order_by, $sort_order, $search_data);
        if ($query->num_rows() > 0) {
            return $query;
        }
        return false;
    }

    private function search_query($order_by, $sort_order, $search_data) {
        if(!empty($search_data['created_by'])) {
            $cond['created_by'] = $search_data['created_by'];
        }

        if (!empty($search_data['submit_time_start']) && !empty($search_data['submit_time_end'])) {
            $cond['created_time >='] = $search_data['submit_time_start'];
            $cond['created_time <='] = $search_data['submit_time_end'];
        }

        $cond['status'] = 'active';
        $this->db->select($this->fields);
        $this->db->from($this->table);
        $this->db->where($cond);
        $this->db->order_by($order_by, $sort_order);
    }

    private function count_all_search_time_sheet($order_by, $sort_order, $search_data) {
        $this->search_query($order_by, $sort_order, $search_data);
        return $this->db->count_all_results();
    }

    public function get_one_time_sheet($key) {
        $this->db->select($this->fields);
        $this->db->from($this->table);
        $this->db->where('time_sheet_id', $key);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function insert_time_sheet($data) {
        $new_data = array(
            'shift' => $data['shift'],
            'product' => $data['product'],
            'title' => $data['title'],
            'remarks' => $data['remarks'],
            'time_start' => $data['time_start'],
            'time_end' => $data['time_end'],
            'status' => 'active',
            'created_by' => $this->user,
            'created_time' => $this->time,
            'last_updated_by' => $this->user,
            'last_updated_time' => $this->time
        );
        $this->db->insert($this->table, $new_data);
        return $this->is_query_working();
    }

    public function edit_time_sheet($data) {
        if ($this->is_exist($data['id'])) {
            $new_data = array(
                'shift' => $data['shift'],
                'product' => $data['product'],
                'title' => $data['title'],
                'remarks' => $data['remarks'],
                'time_start' => $data['time_start'],
                'time_end' => $data['time_end'],
                'last_updated_by' => $this->user,
                'last_updated_time' => $this->time
            );
            $this->db->where('time_sheet_id', $data['id']);
            $this->db->update($this->table, $new_data);
            return $this->is_query_working();
        } else {
            return false;
        }
    }

    public function delete_time_sheet($key) {
        if($this->is_exist($key)){
            $this->db->where('time_sheet_id', $key);
            $this->db->update($this->table, array('status' => 'delete'));
            return $this->is_query_working();
        } else{
            return false;
        }
    }

    private function is_exist($key) {
        $this->db->select($this->fields);
        $this->db->from($this->table);
        $this->db->where('time_sheet_id', $key);
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
