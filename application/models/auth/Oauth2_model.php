<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OAuth2_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        $this->db->select('id, name, client_id, client_secret')->from('oauth_providers')->where('enabled', true);
        $q = $this->db->get();

        if ($q->num_rows() > 0) {
            return $q->result();
        }

        return false;
    }

    public function get_provider_data($provider) {
        $this->db->select('client_id, client_secret')->from('oauth_providers')->where('name', $provider);
        $q = $this->db->get();

        if ($q->num_rows() == 1) {
            return $q->row();
        }

        return false;
    }

    public function get_user_by_email($email) {
        $this->db->select('user_id, username, active, banned')->from('users')->where('email', $email);
        $q = $this->db->get();
        return $q->row();
    }

}