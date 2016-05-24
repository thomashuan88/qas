<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Renew_password_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     *
     * insert_recover_password_data: add a new token row for password reset functionality
     *
     * @param int $user_id the member id
     * @param string $token the unique token used in the e-mail link
     * @param string $email the member e-mail address
     * @return boolean
     *
     */

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

    /**
     *
     * delete_tokens_by_email: remove all tokens for a member
     *
     * @param string $email remove all tokens with this e-mail address associated
     * @return boolean
     *
     */

    public function delete_tokens_by_email($email) {
        $this->db->delete('recover_password', array('email' => $email));
        if($this->db->affected_rows() == 1) {
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

    /**
     *
     * delete_token_data: delete all token data for an e-mail address
     *
     * @param string $token the token sent to the model comming from the e-mail link
     * @return boolean
     *
     */

    public function delete_token_data($token) {
        $this->db->delete('recover_password', array('token' => $token));
        if($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }

    /**
     *
     * update_password_and_nonce: update the password and create new nonce
     *
     * @param string $email the member e-mail address
     * @param string $password the newly created member password
     * @return boolean
     *
     */

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

}

/* End of file Forgot_password_model.php */
/* Location: ./application/models/auth/Renew_password_model.php */