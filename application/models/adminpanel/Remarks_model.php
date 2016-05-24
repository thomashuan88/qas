<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Remarks_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->helper('password');
    }

    public function save($data){

        $this->db->set('create_time', 'NOW()', FALSE);
        $this->db->set('create_by',  $this->session->userdata('username'));
        $this->db->insert('remarks', $data);
    }

    public function get_remarks($username){
        $this->db->select($this->fields);
        $this->db->from('remarks');
        $this->db->where($username);
        $q = $this->db->get();
        if($q->num_rows() > 0) {
            return $q;
        }

        return false;
    }

}
