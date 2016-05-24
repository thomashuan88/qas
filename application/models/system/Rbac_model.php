<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rbac_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_roles() {
        $this->db->select('role_id, role_name')->from('role')->where('role_selectable', true);
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public  function get_permissions_by_role_id($role_id) {
        $this->db->select('p.permission_id')->from('permission p')->join('role_permission rp', 'rp.permission_id = p.permission_id')->where('rp.role_id', $role_id);
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public  function get_member_roles($user_id) {
        $this->db->select('ur.role_id, r.role_name')->from('user_role ur')->join('role r', 'r.role_id = ur.role_id')->where('ur.user_id', $user_id);
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function get_member_permissions($user_id) {
        $this->db->select('rp.permission_id, rp.add,rp.edit,rp.delete,rp.view,rp.role_id')->from('role_permission rp')
            ->join('permission p', 'rp.permission_id = p.permission_id')
            ->join('user_role ur', 'ur.role_id = rp.role_id')
            ->where('ur.user_id', $user_id);
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    // public function get_member_permissions($user_id) {
    //     $this->db->select('p.permission_id, p.permission_description')->from('permission p')
    //         ->join('role_permission rp', 'rp.permission_id = p.permission_id')
    //         ->join('user_role ur', 'ur.role_id = rp.role_id')
    //         ->where('ur.user_id', $user_id);
    //     $q = $this->db->get();
    //     if ($q->num_rows() > 0) {
    //         return $q->result();
    //     }
    //     return false;
    // }

    public  function create_user_role($data) {
        $this->db->insert('user_role', $data);
        return $this->db->affected_rows();
    }

    public  function update_user_role($data) {
        $this->db->where('user_id', $data['user_id'])
                 ->update('user_role', $data);
        return $this->db->affected_rows();
    }

    public function delete_user_roles($user_id) {
        $this->db->where('user_id', $user_id)->where('role_id != 4')->delete('user_role');
        return $this->db->affected_rows();
    }

    public function add_role_to_member($selected_role) {
        $this->db->insert('user_role', array('user_id' => $this->input->post('user_id'), 'role_id' => $selected_role));
        return $this->db->affected_rows();
    }

    public function delete_unchecked_roles($delete_arr) {
        $this->db->where('user_id', $this->input->post('user_id'));
        $this->db->where_not_in('role_id', $delete_arr);
        $this->db->delete('user_role');
        return $this->db->affected_rows();
    }



}


/* End of file Rbac.php */
/* Location: ./application/models/system/Rbac_model.php */
