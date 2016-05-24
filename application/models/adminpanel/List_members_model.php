<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class List_Members_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     *
     * get_members: get the members data
     *
     * @param int $limit db limit (members per page)
     * @param int $offset db offset (current page)
     * @param int $order_by db sort order
     * @param string $sort_order asc or desc
     * @param array $search_data search input
     * @return mixed
     *
     */

    public function get_members($limit = 0, $offset = 0, $order_by = "username", $sort_order = "asc", $search_data) {
        $fields = $this->db->list_fields('users');
        if (!in_array($order_by, $fields)) return array();
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
        $this->db->select('users.user_id, users.username, users.email, users.real_name, users.last_name, users.date_registered, users.last_login, users.active, users.banned, users.login_attempts');
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

        // $this->db->group_end();
        // !empty($status['data']) ? $this->db->where('status', $status['data']) : "";
        $this->db->order_by($order_by, $sort_order);
        $this->db->limit($limit, $offset);

        $q = $this->db->get();
        if($q->num_rows() > 0) {
            return $q;
        }

        return false;
    }

    /**
     *
     * count_all_members: count all members in the table
     *
     *
     */

    public function count_all_members()
    {
        return $this->db->count_all_results('users');
    }

    /**
     *
     * update_member: update member data
     *
     * @param int $id the member id
     * @param string $username the member username
     * @param string $email the member e-mail address
     * @param string $first_name the member first name
     * @param string $last_name the member last name
     * @param bool $change_username do we want to change the username?
     * @param bool $change_email do we want to change the user e-mail?
     * @return mixed
     *
     */

    public function update_member($user_id, $username, $email, $first_name, $last_name, $change_username = false, $change_email = false) {
        // if there are more fields you can turn the data into an array. The reason I don't do this is because it's an extra array in controller List_members.

        $data = array(
                'user_id'            => $user_id,
                'first_name'    => $first_name,
                'last_name'     => $last_name);

        if ($change_username) {
            $data['username'] = $username;
        }
        if ($change_email) {
            $data['email'] = $email;
        }
        $this->db->where('user_id', $user_id);
        $this->db->update('users', $data);

        if($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }

    /**
     *
     * delete_member: delete a single member
     *
     * @param int $id the member id
     * @return boolean
     *
     */

    public function delete_member($id) {

        $this->db->trans_start();
        // remove roles
        $this->db->where('user_id', $id)->delete('user_role');

        // delete member
        $this->db->where('user_id', $id);
        $this->db->delete('users');

        $affected_rows = $this->db->affected_rows();

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            return false;
        }

        if($affected_rows == 1) {
            return true;
        }

        return false;
    }

    /**
     *
     * get_username_by_id: return username by id
     *
     * @param int $id the member id
     * @return mixed
     *
     */

    public function get_username_by_id($id) {
        $this->db->select('username')->from('users')->where('user_id', $id);
        $q = $this->db->get();
        if($q->num_rows() == 1) {
            $row = $q->row();
            return $row->username;
        }
        return false;
    }

    /**
     *
     * count_all_search_members: count all members when performing search
     *
     * @param string $username the member username
     * @param string $first_name the member first name
     * @param string $last_name the member last name
     * @param string $email the member e-mail address
     * @return mixed
     *
     */

    public function count_all_search_members($search_data) {
        $data = array();
        !empty($search_data['username']) ? $data['username'] = $search_data['username'] : "";
        !empty($search_data['first_name']) ? $data['first_name'] = $search_data['first_name'] : "";
        !empty($search_data['last_name']) ? $data['last_name'] = $search_data['last_name'] : "";
        !empty($search_data['email']) ? $data['email'] = $search_data['email'] : "";

        $this->db->select('users.user_id, users.username, users.email, users.first_name, users.last_name, users.date_registered, users.last_login');
        $this->db->from('users');
        !empty($data) ? $this->db->or_like($data) : "";
        $this->db->order_by("users.user_id", "asc");
        return $this->db->count_all_results();
    }

    /**
     *
     * toggle_ban: (un)ban member
     *
     * @param int $id the member id
     * @param bool $banned ban or unban?
     * @return boolean
     *
     */

    public function toggle_ban($id, $banned) {
        $data = array('banned' => ($banned ? false : true));
        $this->db->where('user_id', $id);
        $this->db->update('users', $data);
        if($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }

    /**
     *
     * toggle_active: (de)activate member
     *
     * @param int $id the member id
     * @param string $active activate or deactivate?
     * @return boolean
     *
     */

    public function toggle_active($id, $active) {
        $data = array('active' => ($active ? false : true));
        $this->db->where('user_id', $id);
        $this->db->update('users', $data);
        if($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }

    public function ban_checked($ids) {
        $this->db->where_in('user_id', $ids)->where('username != ', ADMINISTRATOR)->update('users', array('banned' => true));
        return $this->db->affected_rows();
    }

    public function unban_checked($ids) {
        $this->db->where_in('user_id', $ids)->where('username != ', ADMINISTRATOR)->update('users', array('banned' => false));
        return $this->db->affected_rows();
    }

    public function activate_checked($ids) {
        $this->db->where_in('user_id', $ids)->where('username != ', ADMINISTRATOR)->update('users', array('active' => true));
        return $this->db->affected_rows();
    }

    public function deactivate_checked($ids) {
        $this->db->where_in('user_id', $ids)->where('username != ', ADMINISTRATOR)->update('users', array('active' => false));
        return $this->db->affected_rows();
    }

}

/* End of file List_members_model.php */
/* Location: ./application/models/adminpanel/List_members_model.php */
