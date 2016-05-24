<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role_permission_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_data(){
        $this->db->select('*');
        $this->db->from('role_permission');
        $q = $this->db->get();

        if($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    // public function insert_checked_permission($permission_id) {
    //     $this->db->select("role_id,permission_id");
    //     $this->db->from("role_permission");
    //     $this->db->where("role_id",$this->input->post('role_id'));
    //     $this->db->where("permission_id",$permission_id);
    //     $q = $this->db->get();
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
    //     }else{
    //         $insert_query = $this->db->insert_string('role_permission', array('role_id' => $this->input->post('role_id'), 'permission_id' => $permission_id,'add' => 'yes','edit' => 'yes','view' => 'yes'));
    //         $insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
    //         $this->db->query($insert_query);
    //     }
    // }

    public function check_exist($permi_id){
        $this->db->select("role_id,permission_id");
        $this->db->from("role_permission");
        $this->db->where("role_id",$this->input->post('role_id'));
        $this->db->where("permission_id",$permi_id);
        $q = $this->db->get();
        if($q->num_rows() > 0) {
           return true;
        }else{
            return false;
        }
    }

    public function update_permission($permi_id,$parentid,$add,$edit,$delete,$view){
        $this->db->set("add",$add);
        $this->db->set("edit",$edit);
        $this->db->set("delete",$delete);
        $this->db->set("view",$view);
        $this->db->set("parentid",$parentid);
        $this->db->where("role_id",$this->input->post('role_id'));
        $this->db->where("permission_id",$permi_id);
        $this->db->update('role_permission');
        return $this->db->affected_rows(); 
    }

    public function insert_permission($permi_id,$parentid,$add,$edit,$delete,$view){
        $this->db->set("add",$add);
        $this->db->set("edit",$edit);
        $this->db->set("delete",$delete);
        $this->db->set("view",$view);
        $this->db->set("parentid",$parentid);
        $this->db->set("role_id",$this->input->post('role_id'));
        $this->db->set("permission_id",$permi_id);
        $this->db->insert('role_permission');
        return $this->db->affected_rows(); 

    }

    public function select_action($role_id,$permi_id){

        $this->db->select("add,edit,delete");
        $this->db->from("role_permission");
        $this->db->where("role_id",$role_id);
        $this->db->where("permission_id",$permi_id);
        $q = $this->db->get();
        if($q->num_rows() > 0) {
           return $q->row();
        }else{
            return false;
        }

    }

    public function select_view($role_id){
        $this->db->select("parentid");
        $this->db->from("role_permission");
        $this->db->where("view","yes");
        $this->db->where("role_id",$role_id);
        $this->db->group_by("parentid");
        $q = $this->db->get();
        if($q->num_rows() > 0) {
           return $q->result();
        }else{
            return false;
        }

    }

    public function update_parent($parent,$role_id){
        $this->db->set("view","yes");
        $this->db->where("role_id",$role_id);
        $this->db->where_in("permission_id",$parent);
        $this->db->update('role_permission');
        return $this->db->affected_rows(); 
    }
}
