<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /**
     *
     * validate_login: check login data against database information
     *
     * @param string $username the username to be validated
     * @param string $password the password to be validated
     * @return mixed
     *
     */

    public function validate_login($username, $password) {

        $this->load->helper('password');

        $this->db->select('user_id, username, password, date_registered, nonce, active, banned, login_attempts,status,role');
        $this->db->select('username, password');
        $this->db->from('users');
        $this->db->where('username', $username);
        $this->db->limit(1);

        $query = $this->db->get();

        if($query->num_rows() == 1) {
           $row = $query->row();

           // check for password match based on password_helper.php
           if ($row->banned == 1) {
               return "banned";
           }


           if (hash_password($password, $row->nonce) == $row->password) {


               $array['user_id'] = $row->user_id;
               $array['username'] = $row->username;
               $array['role'] = $row->role;
               $array['date_registered'] = $row->date_registered;
               $array['active'] = $row->active;
               $array['nonce'] = $row->nonce;
               $array['status'] = $row->status;
               // update last login on successful login
               $array['cookie_part'] = $this->_update_last_login($username);

               return $array;
           }
        }

        // login attempts +1 because login failed
        $this->_increase_login_attempts($username);
        return ($row->login_attempts + 1);

    }

    /**
     *
     * _update_last_login: update the last time the member logged in
     *
     * @param string $username the username to be validated
     * @return boolean
     *
     */

    private function _update_last_login($username) {
        $cookie_part = md5(uniqid(mt_rand(), true));
        $this->db->set('last_login', 'NOW()', FALSE);
        $this->db->where('username', $username);
        $this->db->update('users', array('cookie_part' => $cookie_part));

        if ($this->db->affected_rows() == 1) {
            return $cookie_part;
        }
        return false;
    }

    /**
     *
     * _increase_login_attempts: add +1 to login attempts for member
     *
     * @param string $username the username to be validated
     * @return boolean
     *
     */

    private function _increase_login_attempts($username) {
        $this->db->set('login_attempts', 'login_attempts + 1', FALSE);
        $this->db->where('username', $username);
        $this->db->update('users');

        if ($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }

    /**
     *
     * reset_login_attempts: bring login attempts back to 0
     *
     * @param string $username the username to be validated
     * @return boolean
     *
     */

    // public function reset_login_attempts($username) {
    //     $this->db->where('username', $username);
    //     $this->db->update('users', array('login_attempts' => 0));
    // }


    public function check_max_logins($username) {
        $this->db->select('login_attempts')->from('users')->where('username', $username);
        $q = $this->db->get();

        if ($q->num_rows() == 1) {
            if ($q->row()->login_attempts >= Settings_model::$db_config['max_login_attempts']) {
                return true;
            }
        }

        return false;
    }


    public function get_session($username){
        $this->db->select('id');
        $this->db->from('ci_sessions');
        $this->db->like('data',$username);
        $q = $this->db->get();

        //if ($q->num_rows() == 1) {
            // log_message("error",print_r($q,true));

            return $q->result();
        //}
        // return false;
    }

    public function delete_session($id){


        $this->db->delete('ci_sessions', array('id' => $id)); 

        if ($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }

    public function get_password_hint($username){

        $this->db->select('password_hint');
        $this->db->from('users');
        $this->db->where('username',$username);
        $query = $this->db->get();

        if($query->num_rows() == 1) {

            return $query->row();
        }
        return false;

    }

}

/* End of file Login_model.php */
/* Location: ./application/models/auth/Login_model.php */