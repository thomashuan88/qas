<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roles_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_roles() {
        $this->db->select('r.role_id, r.role_name, r.status,r.role_description, p.permission_id, p.permission_description,p.permission_system,rp.add,rp.edit,rp.view,rp.delete')->from('role r');
        $this->db->join('role_permission rp', 'rp.role_id = r.role_id', 'left');
        $this->db->join('permission p', 'p.permission_id = rp.permission_id', 'left');
        $q = $this->db->get();
        if($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function create($data) {
        $this->db->insert('role', $data);
        return $this->db->affected_rows();
    }

    public function get_all_permission_ids() {
        $this->db->select('permission_id,permission_system')->from('permission');
        $q = $this->db->get();
        return $q->result();
    }

    public function toggle_active($id, $active) {
        if($active == "inactive"){
            $data = "active";
        }else{
             $data = "inactive";
        }
        $this->db->set('status', $data);
        $this->db->where('role_id', $id);
        $this->db->update('role');
        if($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }

    public function get_role_name(){
        $this->db->select('role_name,role_id');
        $this->db->from('role');
        $this->db->where('status','active');

         $q = $this->db->get();

        if($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function get_role_id($role_name){
        $this->db->select('role_id');
        $this->db->from('role');
        $this->db->where('role_name',$role_name);
        $this->db->limit('1');
        $q = $this->db->get();
        if($q->num_rows() > 0) {
            return $q->result_array();
        }
        return false;
    }

    public function check_role($role){
        $this->db->select('role_name');
        $this->db->from('role');
        $this->db->where('role_name',$role);
        $q = $this->db->get();
        if($q->num_rows() > 0) {
            return true;
        }else{
             return false;
        }    
    }
	
	public function select_roles($status){
		$this->db->select('role_name,role_id,status');
        $this->db->from('role');
        if($status != "all"){
            $this->db->where('status',$status);
        }
		$q = $this->db->get();
        if($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
	}
}
