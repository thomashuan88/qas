<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_detail_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_member_data($id) {
        $this->db->select('u.user_id, u.username, u.email, u.first_name, u.last_name, u.last_login, u.date_registered,
        u.banned, u.active')
            ->from('users u')
            ->where('u.user_id', $id)
            ->limit(1);

        $q = $this->db->get();

        if ($q->num_rows() == 1) {
            return $q->row();
        }

        return false;
    }

    public function save($data) {
        $this->db->where('username', $data['username'])
                 ->update('users', $data);

        return $this->db->affected_rows();
    }

    public function get_username() {
        $this->db->select('username')->from('users')->where('user_id', $this->input->post('user_id'))->limit(1);
        $q = $this->db->get();
        return $q->row();
    }



}
