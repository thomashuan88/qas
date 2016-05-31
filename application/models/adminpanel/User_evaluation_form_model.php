<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_evaluation_form_model extends CI_Model {
    public $tablename = 'user_evaluation_form';
    public $fields = 'id,  user_evaluation_id, username, question_type, question_text, weight, rating, update_time,  update_by';

    public function __construct() {
        parent::__construct();
    }

    public function get_all_qa_form($cond){
        $this->db->select($this->fields);
        $this->db->from($this->tablename);
        foreach($cond as $k => $v) {
            $this->db->where($k, $v);
        }
        
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->result('array');
        }
        return false;
    }

    public function del_qa($fields, $cond=array()) {
        $this->db->where_in($fields, $cond);    
        return $this->db->delete($this->tablename);
    }

    public function update_qa($cond=array(), $qaid, $data, $update_by) {
        $this->db->trans_start();
        
        $this->db->where_in("user_evaluation_id", $cond);
        $this->db->delete($this->tablename);

        $default = array();
        foreach($data as $key => $val) {
            $val['user_evaluation_id'] = 0;
            $val['rating'] = 0;
            $default[] = $val;
        }

        $this->db->insert_batch($this->tablename, $default);

        $qa_data = array();
        foreach($data as $key => $val) {
            $val['user_evaluation_id'] = $qaid;
            $val['update_time'] = time();
            $val['update_by'] = $update_by;
            $qa_data[] = $val;
        }

        $this->db->insert_batch($this->tablename, $qa_data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return false;
        }
        return true;
    }

}    


