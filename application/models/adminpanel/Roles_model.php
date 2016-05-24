<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roles_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_roles() {
        $this->db->select('r.role_id, r.role_name, r.status,r.role_description, p.permission_id, p.permission_description,p.permission_system,rp.add,rp.edit,rp.view,rp.delete')->from('role r');
        $this->db->join('role_permission rp', 'rp.role_id = r.role_id', 'left');
        $this->db->join('permission p', 'p.permission_id = rp.permission_id', 'left');
       // $this->db->order_by('r.role_id', 'DESC');

        $q = $this->db->get();

        if($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function save($id, $data) {
        $this->db->where('role_id', $id)->update('role', $data);
        return $this->db->affected_rows();
    }

    public function delete($id) {

        // check whether role is still linked to permissions and to users
        $this->db->trans_start();

        $this->db->where('role_id', $id)->delete('role_permission');
        $this->db->where('role_id', $id)->delete('user_role');
        $this->db->where('role_id', $id)->delete('role');

        //$affected_rows = return $this->db->affected_rows();


        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            return false;
        }

        return $this->db->affected_rows();
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

    public function delete_permissions_by_role() {
        $this->db->where('role_id', $this->input->post('role_id'))->delete('role_permission');
        return $this->db->affected_rows();
    }

    // public function insert_checked_permission($permission_id) {
    //     $this->db->select("role_id,permission_id");
    //     $this->db->from("role_permission");
    //     $this->db->where("role_id",$this->input->post('role_id'));
    //     $this->db->where("permission_id",$permission_id);
    //     if($q->num_rows() > 0) {
    //         $result = 1;
    //     }else{
    //          $result = 0;
    //     }

    //     if($result == 1){
    //         $this->db->set('add', "yes");
    //         $this->db->set('edit', "yes");
    //         $this->db->set('view', "yes");
    //         $this->db->where('role_id', $this->input->post('role_id'));
    //         $this->db->where('permission_id', $permission_id);
    //         $this->db->update('role_permission');
    //         if($this->db->affected_rows() == 1) {
    //             return true;
    //         }
    //         return false;
    //     }

    //     // $insert_query = $this->db->insert_string('role_permission', array('role_id' => $this->input->post('role_id'), 'permission_id' => $permission_id,'add' => 'yes','edit' => 'yes','view' => 'yes'));
    //     // $insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
    //     //  $this->db->query($insert_query);
    // }

    public function remove_unchecked_permission($permission_id) {
        //$this->db->where(array('role_id' => $this->input->post('role_id'), 'permission_id' => $permission_id))->delete('role_permission');
        $this->db->set(array('role_id' => $this->input->post('role_id'), 'permission_id' => $permission_id,'add' => 'no','edit' => 'no','view' => 'no'));
        $this->db->where(array('role_id' => $this->input->post('role_id'), 'permission_id' => $permission_id))->update('role_permission');
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
