<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roster_management_model extends CI_Model {
    private $table = 'roster_management';

    public function __construct() {
        parent::__construct();
    }

    public function get_shift($search_data=array()){
        if(!empty($search_data)){
            $fields = $this->db->list_fields($this->table);
            $where = array(
                        'shift_date >=' => $search_data['from'],
                        'shift_date <=' => $search_data['to']
                    );
            $this->db->select($fields)->from($this->table)->where($where);
            //$this->db->order_by($order_by, $sort_order);
            $q = $this->db->get();

            if(empty($q)){
                return false;
            }
            return $q->result();
        }else{
            return -1;
        }
    }


}