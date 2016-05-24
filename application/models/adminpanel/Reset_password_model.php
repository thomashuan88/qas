<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Reset_password_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }



    public function get_data_by_email($email) {

        $this->db->select('user_id, username, nonce, active, status');
        $this->db->from('users');
        $this->db->where('email', $email);
        $this->db->limit(1);

        $query = $this->db->get();

        if($query->num_rows() == 1) {
            $row = $query->row();
            return array('user_id' => $row->user_id, 'username' => $row->username, 'nonce' => $row->nonce, 'active' => $row->active, 'status' => $row->status);
        }
        return "";
    }

    public function delete_tokens_by_email($email) {
        $this->db->delete('recover_password', array('email' => $email));
        if($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }

     public function insert_recover_password_data($user_id, $token, $email) {
        $data = array(
           'user_id' => $user_id,
           'token' => $token,
           'email' => $email
        );
        $this->db->set('date_added', 'NOW()', FALSE);
        $this->db->insert('recover_password', $data);
        if ($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }

    public function verify_token($email, $token) {
        $this->db->select('u.username, rp.token, rp.date_added');
        $this->db->from('users u');
        $this->db->join('recover_password rp', 'u.email = rp.email');
        $this->db->where(array('rp.email' => $email, 'rp.token' => $token));
        $this->db->limit(1);

        $query = $this->db->get();
        if($query->num_rows() == 1) {
            $row = $query->row();
            $data['username'] = $row->username;
            $data['token'] = $row->token;
            $data['date_added'] = $row->date_added;
            return $data;
        }
        return array();
    }


    public function delete_token_data($token) {
        $this->db->delete('recover_password', array('token' => $token));
        if($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }

    public function update_password_and_nonce($email, $password) {
        $this->load->helper('password');
        $new_nonce = md5(uniqid(mt_rand(), true));

        $data = array('password' => hash_password($password, $new_nonce),
            'nonce'    => $new_nonce);

        $this->db->where('email', $email);
        $this->db->update('users', $data);

        if($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }

    public function get_user($email){

        $this->db->select('user_id');
        $this->db->from('users');
        $this->db->where('email',$email);

        $query = $this->db->get();
        if($query->num_rows() == 1) {

            return $this->db->affected_rows();
        
        }else{
            return false;
        }

    }



}