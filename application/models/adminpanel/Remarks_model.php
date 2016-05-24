<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Remarks_model extends CI_Model {
    private $table = 'remarks';
    private $fields;
    public function __construct() {
        parent::__construct();
        $this->load->helper('password');
        $this->fields = $this->db->list_fields($this->table);

    }

    public function save($data){

        $this->db->set('create_time', 'NOW()', FALSE);
        $this->db->set('create_by',  $this->session->userdata('username'));
        $this->db->insert('remarks', $data);
    }

    public function get_remarks($limit = 0, $offset = 0, $order_by = "username", $sort_order = "asc", $search_data){
        $this->db->select($this->fields);
        $this->db->from('remarks');
        $this->db->where($search_data);
        $this->db->order_by($order_by, $sort_order);
        $this->db->limit($limit, $offset);

        $q = $this->db->get();
        if($q->num_rows() > 0) {
            return $q;

        }
        return false;

    }

    public function count_all_search_remarks($search_data){
        $this->db->select($this->fields);
        $this->db->from('remarks');
        $this->db->where($search_data);
        return $this->db->count_all_results();
    }

}
