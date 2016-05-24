<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('password');
        }

    /**
     *
     * create_member
     *
     * @param string $username
     * @param string $password
     * @param string $email
     * @param string $first_name
     * @param string $last_name
     * @return mixed
     *
     */

    public function create_member($username, $password, $email, $first_name, $last_name, $role_id = 4, $active = 0) {

        if ($username == ADMINISTRATOR) {
            $this->db->select('user_id')->from('users')->where('username', $username);
            $q = $this->db->get();
            if ($q->num_rows() == 1) {
                return "installed";
            }
        }

        $nonce = md5(uniqid(mt_rand(), true));

        $data = array(
            'username' => $username,
            'password' => hash_password($password, $nonce),
            'email' => $email,
            'nonce' => $nonce,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'active' => $active,
            'cookie_part' => $nonce
        );

        $this->db->set('date_registered', 'NOW()', FALSE);
        $this->db->set('last_login', 'NOW()', FALSE);
        $this->db->insert('users', $data);
        
        if ($this->db->affected_rows() == 1) {
            return array('nonce' => $nonce, 'user_id' => $this->db->insert_id());
        }
        return false;
    }


    public function create_member_oauth($username, $email) {

        $nonce = md5(uniqid(mt_rand(), true));

        $data = array(
            'username' => $username,
            'email' => $email,
            'active' => 1,
            'nonce' => $nonce,
            'cookie_part' => $nonce
        );

        $this->db->set('date_registered', 'NOW()', FALSE);
        $this->db->set('last_login', 'NOW()', FALSE);
        $this->db->insert('users', $data);

        if ($this->db->affected_rows() == 1) {
            return $this->db->insert_id();
        }

        return false;
    }
}

/* End of file Register_model.php */
/* Location: ./application/models/auth/Register_model.php */