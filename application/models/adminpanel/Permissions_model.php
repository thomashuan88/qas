<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permissions_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_permissions() {
        $this->db->select('permission_id, permission_description, permission_system, permission_order')->from('permission')->order_by('permission_order');
        $q = $this->db->get();

        if($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function save($id, $data) {

        $this->db->trans_start();

        $this->db->select('permission_system')->from('permission')->where('permission_id', $id);
        $q = $this->db->get();

        if ($q->num_rows() == 1) {
            if ($q->row()->permission_system == 0) {
                return "system";
            }
        }

        $this->db->where(array('permission_id' => $id, 'permission_system' => 0))->update('permission', $data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            return false;
        }

        return $this->db->affected_rows();
    }

    public function delete($id) {

        // check whether permission is still linked to permissions and to users
        $this->db->trans_start();

        $this->db->select('permission_system')->from('permission')->where('permission_id', $id);
        $q = $this->db->get();

        if ($q->num_rows() == 1) {
            if ($q->row()->permission_system == 1) {
                return "system";
            }
        }

        $this->db->where('permission_id', $id)->delete('role_permission');

        $this->db->where('permission_id', $id)->delete('permission');

        //$affected_rows = return $this->db->affected_rows();


        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            return false;
        }

        return $this->db->affected_rows();
    }

    public function create($data) {
        $this->db->insert('permission', $data);
        return $this->db->affected_rows();
    }

}

