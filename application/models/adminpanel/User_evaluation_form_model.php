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

}    


