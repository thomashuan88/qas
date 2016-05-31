<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Follow_up_model extends CI_Model {

    private $table = 'follow_up';
    private $fields;
    private $user;
    private $time;

    public function __construct() {
        parent::__construct();
        $this->fields = $this->db->list_fields($this->table);
        $this->user = $this->session->userdata('username');
        $this->time = date('Y-m-d H:i:s', time());
    }

    public function get_all_follow_up_reports($order_by, $sort_order, $search_data, $limit, $offset, $users, $status) {
        if (!in_array($order_by, $this->fields)) return array();
        $this->search_follow_up($order_by, $sort_order, $search_data, $users, $status);
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $query->total_rows = $this->count_all_search_follow_up($order_by, $sort_order, $search_data, $users, $status);
        if ($query->num_rows() > 0) {
            return $query;
        }
        return false;
    }

    private function count_all_search_follow_up($order_by, $sort_order, $search_data, $users, $status) {
        $this->search_follow_up($order_by, $sort_order, $search_data, $users, $status);
        return $this->db->count_all_results();
    }

    private function search_follow_up($order_by, $sort_order, $search_data, $users, $status) {
        $cond = array('shift_reports_id' => $search_data);

        $this->db->select($this->fields);
        $this->db->from($this->table);
        if (!empty($users)) {
            $this->db->where_in('created_by', $users);
        }
        if ($status) {
            $this->db->where_in('status', array('done', 'follow-up'));
        } else {
            $this->db->where_in('status', array('inform', 'informed'));
        }
        $this->db->where($cond);
        $this->db->order_by($order_by, $sort_order);
    }

    public function get_one_follow_up($key) {
        $this->db->select($this->fields);
        $this->db->from($this->table);
        $this->db->where('follow_up_id', $key);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function get_follow_up_records($key, $status) {
        $cond = array(
            'shift_reports_id' => $key,
            'status' => $status ? 'follow-up' : 'inform'
        );
        $this->db->select($this->fields);
        $this->db->from($this->table);
        $this->db->where($cond);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }

    public function insert_follow_up($data) {
        $new_data = array(
            'shift_reports_id' => $data['id'],
            'follow_up' => !empty($data['follow_up']) ? $data['follow_up'] : "N/A",
            'status' => $data['status'],
            'remarks' => $data['remarks'],
            'created_by' => $this->user,
            'created_time' => $this->time,
            'last_updated_by' => $this->user,
            'last_updated_time' => $this->time
        );
        $this->db->insert($this->table, $new_data);
        return $this->is_query_working();
    }

    public function edit_follow_up($data) {
        if ($this->is_exist($data['id'])) {
            $new_data = array(
                'follow_up' => !empty($data['follow_up']) ? $data['follow_up'] : "N/A",
                'status' => $data['status'],
                'remarks' => $data['remarks'],
                'last_updated_by' => $this->user,
                'last_updated_time' => $this->time
            );
            $this->db->where('follow_up_id', $data['id']);
            $this->db->update($this->table, $new_data);
            return $this->is_query_working();
        } else {
            return true;
        }
    }

    public function delete_follow_up($key) {
        if ($this->is_exist($key)) {
            $this->db->where('follow_up_id', $key);
            $this->db->update($this->table, array('status' => 'delete'));
            return $this->is_query_working();
        } else {
            return true;
        }
    }

    public function parent_batch_delete_follow_up($key){
        if($this->is_exist_reports($key)){
            $this->db->where('shift_reports_id', $key);
            $this->db->update($this->table, array('status' => 'delete'));
            return $this->is_query_working();
        } else{
            return true;
        }
    }

    private function is_exist($key) {
        $this->db->select($this->fields);
        $this->db->from($this->table);
        $this->db->where('follow_up_id', $key);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }

    private function is_exist_reports($key) {
        $this->db->select($this->fields);
        $this->db->from($this->table);
        $this->db->where('shift_reports_id', $key);
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