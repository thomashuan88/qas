<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permissions extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        if (! self::check_permissions(6)) {
            redirect("/private/no_access");
        }
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('adminpanel/permissions_model');
        $this->load->model('adminpanel/roles_model');
        $this->load->model('adminpanel/role_permission_model');
        $this->load->model('system/rbac_model');
    }

    public function index(){  
        $permissions = $this->permissions_model->get_permissions();
        $roles = $this->roles_model->get_roles();
        $content_data = array();
        $content_data['roles_name'] = $this->roles_model->get_role_name();

        $role_id = 0;
        foreach ($roles as $role) {
            if ($role_id != $role->role_id) {
                // new role detected
                $content_data['roles'][$role->role_id]['role_name'] = $role->role_name;
                $content_data['roles'][$role->role_id]['role_description'] = $role->role_description;
                $content_data['roles'][$role->role_id]['status'] = $role->status;
                $content_data['roles'][$role->role_id]['add'] = $role->add;
                $content_data['roles'][$role->role_id]['edit'] = $role->edit;
                $content_data['roles'][$role->role_id]['delete'] = $role->delete;
                $content_data['roles'][$role->role_id]['view'] = $role->view;
                $role_id = $role->role_id;

                foreach ($permissions as $permission) {
                   
                    $content_data['roles'][$role->role_id]['status'] = $role->status;
                    $content_data['roles'][$role->role_id]['permissions'][$permission->permission_id]['description'] = $this->lang->line($permission->permission_description);
                    $content_data['roles'][$role->role_id]['permissions'][$permission->permission_id]['permission_id'] = $permission->permission_id;
                    $content_data['roles'][$role->role_id]['permissions'][$permission->permission_id]['parentid'] = $permission->permission_system;
                    $content_data['roles'][$role->role_id]['permissions'][$permission->permission_id]['add'] = 'no';
                    $content_data['roles'][$role->role_id]['permissions'][$permission->permission_id]['edit'] = 'no';
                    $content_data['roles'][$role->role_id]['permissions'][$permission->permission_id]['delete'] = 'no';
                    $content_data['roles'][$role->role_id]['permissions'][$permission->permission_id]['view'] = 'no';
                    ksort($content_data['roles'][$role->role_id]['permissions']);
                 }
            }

            foreach ($permissions as $permission) {
                if ($permission->permission_id == $role->permission_id) {
                    $content_data['roles'][$role->role_id]['permissions'][$permission->permission_id]['add'] = $role->add;
                    $content_data['roles'][$role->role_id]['permissions'][$permission->permission_id]['edit'] = $role->edit;
                    $content_data['roles'][$role->role_id]['permissions'][$permission->permission_id]['delete'] = $role->delete;
                    $content_data['roles'][$role->role_id]['permissions'][$permission->permission_id]['view'] = $role->view;
                }
            }
        }
        $content_data['get_permission'] = $this->role_permission_model->get_all_data();
        $result_roleid = $this->rbac_model->find_role($this->session->userdata('user_id'));
        $content_data['roleid'] = $result_roleid->role_id;
        $content_data['permissions'] = $permissions;
        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('permissions'), 'permissions', 'header', 'footer', '', $content_data);
    }

    public function save_role_permissions() {
        if ($this->input->post('role_id') == 1) {
            $data['post']['role_id'] = $_POST['role_id'];
            $this->session->set_flashdata($data['post']); // check for admin role id - cannot be removed
            $this->session->set_flashdata('error', $this->lang->line('never_allowed'));
            redirect('adminpanel/permissions');
        }

        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('role_id', 'role ID', 'trim|required|integer');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('/adminpanel/permissions');
        }

        $permissions = $this->roles_model->get_all_permission_ids();

        if(!isset($_POST["add"])){
            $_POST["add"] = array();
        }

        if(!isset($_POST["edit"])){
            $_POST["edit"] = array();
        }

        if(!isset($_POST["delete"])){
            $_POST["delete"] = array();
        }

        if(!isset($_POST["view"])){
            $_POST["view"] = array();
        }

        foreach ($permissions as $value) {
        
            if(in_array($value->permission_id, $_POST["add"])){
                $new_arr[$value->permission_id][$value->permission_system] = "yes,";
             }else{
                $new_arr[$value->permission_id][$value->permission_system] = "no,";
            }
            
            if(in_array($value->permission_id, $_POST["edit"])){
                 $new_arr[$value->permission_id][$value->permission_system] .= "yes,";
            }else{
                $new_arr[$value->permission_id][$value->permission_system] .= "no,";
            }

            if(in_array($value->permission_id, $_POST["delete"])){
                 $new_arr[$value->permission_id][$value->permission_system] .= "yes,";
            }else{
                $new_arr[$value->permission_id][$value->permission_system] .= "no,";
            }

            if(in_array($value->permission_id, $_POST["view"])){
                $new_arr[$value->permission_id][$value->permission_system] .= "yes,";
            }else{
                $new_arr[$value->permission_id][$value->permission_system] .= "no,";
            }

            $new_arr[$value->permission_id][$value->permission_system] = substr($new_arr[$value->permission_id][$value->permission_system], 0, -1);
        }

        foreach ($new_arr as $permi_id=>$val) {
            foreach($val as $parentid=>$value){
                $result = explode(",",$value);
                $result_exist = $this->role_permission_model->check_exist($permi_id);
                if($result_exist == true){
                    $result_update_permission = $this->role_permission_model->update_permission($permi_id,$parentid,$result[0],$result[1],$result[2],$result[3]);
                }else{
                    $result_insert_permission = $this->role_permission_model->insert_permission($permi_id,$parentid,$result[0],$result[1],$result[2],$result[3]);
                }
            }
            
        }
       $parent = "";

        $result_view = $this->role_permission_model->select_view($_POST['role_id']);
        foreach ($result_view as  $value) {
            if($value->parentid != 0){
                $parent .= $value->parentid.",";
            }else{
                $parent .= "";
            }   
          
        }
        $parent = trim($parent, ",");
        $parent = explode(",", $parent);
        $update_parent_result = $this->role_permission_model->update_parent($parent ,$_POST['role_id']);

        $data['post']['role_id'] = $_POST['role_id'];
        $this->session->set_flashdata($data['post']);
        $this->session->set_flashdata('success', 'Role permissions updated.');
        redirect('adminpanel/permissions');
    }
}

/* End of file Permissions.php */
/* Location: ./application/controllers/adminpanel/Permissions.php */