<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->helper('password');
      }

    public function get_members($limit = 0, $offset = 0, $order_by = "username", $sort_order = "asc", $search_data) {
        $fields = $this->db->list_fields('users');
        if (!in_array($order_by, $fields)) return array();

        // search condition
        if (!empty($search_data)) {
            !empty($search_data['username']) ? $data['username'] = $search_data['username'] : "";
            !empty($search_data['real_name']) ? $data['real_name'] = $search_data['real_name'] : "";
            !empty($search_data['last_name']) ? $data['leader_name'] = $search_data['leader_name'] : "";
            !empty($search_data['email']) ? $data['email'] = $search_data['email'] : "";
        }

        // status searched
        if (isset($search_data['status'])) {
            !empty($search_data['status']) ? $status['data'] = $search_data['status'] : "";
        }

        $this->db->select('users.user_id, users.username, users.email, users.real_name, users.leader, users.role, users.phone, users.status');
        $this->db->from('users');
        // $this->db->group_start();
        if(isset($status['data'])){
        $this->db->where('status', $status['data']);
        }
        if(!empty($data)) {
                $this->db->group_start();
             $this->db->like($data);
              $this->db->group_end();
        }
        $this->db->order_by($order_by, $sort_order);
        $this->db->limit($limit, $offset);

        $q = $this->db->get();
        if($q->num_rows() > 0) {
            return $q;
        }

        return false;
    }

    public function get_member_data($id) {
        $this->db->select('user_id, username, email, real_name, nickname, dob, role,
        windows_id, tb_lp_id, tb_lp_name, sy_lp_id, sy_lp_name, tb_bo,
        gd_bo, keno_bo, cyber_roam, rtx, emergency_contact, emergency_name, relationship,
        leader, status, remark, phone')
            ->from('users')
            ->where('user_id', $id)
            ->limit(1);

        $q = $this->db->get();

        if ($q->num_rows() == 1) {
            return $q->row();
        }

        return false;
    }
    public function count_all_members()
    {
        return $this->db->count_all_results('users');
    }
    public function count_all_search_members($search_data) {
        $data = array();

        if (!empty($search_data)) {
            !empty($search_data['username']) ? $data['username'] = $search_data['username'] : "";
            !empty($search_data['real_name']) ? $data['real_name'] = $search_data['real_name'] : "";
            !empty($search_data['last_name']) ? $data['leader_name'] = $search_data['leader_name'] : "";
            !empty($search_data['email']) ? $data['email'] = $search_data['email'] : "";
            // !empty($search_data['status']) ? $data['status'] = $search_data['status'] : "";

        }
        if (isset($search_data['status'])) {
            !empty($search_data['status']) ? $status['data'] = $search_data['status'] : "";
        }
        $this->db->select('users.user_id, users.username, users.email, users.real_name, users.leader, users.role, users.phone, users.status');
        $this->db->from('users');
        // $this->db->group_start();
        if(isset($status['data'])){
        $this->db->where('status', $status['data']);
        }
        if(!empty($data)) {
                $this->db->group_start();
             $this->db->like($data);
              $this->db->group_end();
        }

        $this->db->order_by("users.user_id", "asc");
        return $this->db->count_all_results();
    }

    public function get_leaders(){
            $this->db->select('username')->from('users')->where('role !=', 'CS');
            $q = $this->db->get();
                if ($q->num_rows() > 0) {
                    return $q->result();
                }
                return false;
    }

    public function create_user($username, $password, $email, $leader, $role, $status) {

        $nonce = md5(uniqid(mt_rand(), true));

        $data = array(
            'username' => $username,
            'password' => hash_password($password, $nonce),
            'email' => $email,
            'nonce' => $nonce,
            'role' => $role,
            'leader' => $leader,
            'status' => $status,
            'cookie_part' => $nonce
        );

        $this->db->set('created_time', 'NOW()', FALSE);
        $this->db->set('created_by', $this->session->userdata('username'));
        $this->db->insert('users', $data);

        if ($this->db->affected_rows() == 1) {
            return array('nonce' => $nonce, 'user_id' => $this->db->insert_id());
        }
        return false;
    }

    public function check_leader($role_name){
        $this->db->select('username');
        $this->db->from('users');
        $this->db->where('role',$role_name);
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;

    }

    public function save($data) {
        log_message("error", print_r($data, true));

        $this->db->where('username', $data['username'])
                 ->set('last_updated_by', $this->session->userdata('username'))
                 ->set('last_updated_time', 'NOW()', FALSE)
                 ->update('users', $data);

        return $this->db->affected_rows();
    }

    public function get_all_member(){
        $this->db->select('user_id,username,role,leader');
        $this->db->from('users');
        $this->db->where('`status`','active');
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->result('array');
        }
        return false;
    }

    public function save_password($user_id, $new_password){

        $nonce = md5(uniqid(mt_rand(), true));
        $data = array(
            'password' => hash_password($new_password, $nonce),
            'nonce' => $nonce
        );

        $this->db->where('user_id', $user_id);
        $this->db->update('users', $data);
        return $this->db->affected_rows();
    }

    public function toggle_active($username, $active) {
        $data = array('status' => ($active=="active" ? "inactive" : "active"));
        $this->db->where('username', $username);
        $this->db->update('users', $data);
        if($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }


}
