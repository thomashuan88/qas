<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	
	public function __construct() {
        parent::__construct();
    }
	
	public function count_users() {
		return $this->db->count_all_results('users');
	}

    public function count_users_this_week() {
        return $this->db->query("SELECT count(1) as count FROM users WHERE date_registered > DATE_SUB(NOW(), INTERVAL 1 WEEK)")->row();
    }

    public function count_users_this_month() {
        return $this->db->query("SELECT count(1) as count FROM users WHERE date_registered > DATE_SUB(NOW(), INTERVAL 1 MONTH)")->row();
    }

    public function count_users_this_year() {
        return $this->db->query("SELECT count(1) as count FROM users WHERE date_registered > DATE_SUB(NOW(), INTERVAL 1 YEAR)")->row();
    }

    public function get_latest_members() {
        $this->db->select('user_id, username, first_name, last_name, email')->from('users');
        $this->db->order_by("user_id", "asc");
        $this->db->limit(5);
        $q = $this->db->get();

        if ($q->num_rows() > 0) {
            return $q->result();
        }

        return false;
    }

}