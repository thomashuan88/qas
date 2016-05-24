<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roles extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        if (! self::check_permissions(5)) {
            redirect("/private/no_access");
        }
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('adminpanel/roles_model');
        $this->load->model('adminpanel/users_model');
        $this->load->model('adminpanel/role_permission_model');
    }

    public function index(){
		$status = "active";
        $roles = $this->roles_model->select_roles($status);
        //log_message("error",$this->input->post("hidden_status"));
		//error_log($this->input->post("status"));

        $content_data = array();

        // $this->load->model('adminpanel/permissions_model');
        // $permissions = $this->permissions_model->get_permissions();

        // loop through roles for each permission
        $role_id = 0;
        foreach ($roles as $role) {
            // new role detected
			$content_data['roles'][$role->role_id]['role_name'] = $role->role_name;
			$content_data['roles'][$role->role_id]['status'] = $role->status;
			$role_id = $role->role_id;

                // foreach ($permissions as $permission) {
                //     $content_data['roles'][$role->role_id]['permissions'][$permission->permission_id]['active'] = false;
                //     //$content_data['roles'][$role->role_id]['permissions'][$permission->permission_id]['active2'] = 'false';
                //     $content_data['roles'][$role->role_id]['status'] = $role->status;
                //     $content_data['roles'][$role->role_id]['permissions'][$permission->permission_id]['description'] = $permission->permission_description;
                // }
            

            // foreach ($permissions as $permission) {
            //     if ($permission->permission_id == $role->permission_id) {
            //         $content_data['roles'][$role->role_id]['permissions'][$permission->permission_id]['active'] = true;
            //     }
            // }
        }

       // $content_data['permissions'] = $permissions;
        //log_message("error",print_r($content_data,true));
        ksort($content_data['roles'][$role->role_id]);

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('role'), 'roles', 'header', 'footer', '', $content_data);
    }


    public function roles_multi() {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('role_id', 'role id', 'trim|integer');
        $this->form_validation->set_rules('role_name', 'role name', 'trim|required|max_length[50]');
        //$this->form_validation->set_rules('role_description', 'description', 'trim|max_length[255]');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('/adminpanel/roles');
            exit();
        }

        if (isset($_POST['save'])) {
            $this->_save($this->input->post('role_id'), array('role_name' => $this->input->post('role_name')));
        }elseif(isset($_POST['delete'])) {
            $this->_delete($this->input->post('role_id'));
        }
    }

    public function toggle_active($id,$active,$role_name) {

        if ($id == 1) { // check for admin role id - cannot be removed
            $this->session->set_flashdata('error', 'Never allowed to change admin role permissions.');
            redirect('adminpanel/roles');
        }

        if($active == "active"){
            $role_name = urldecode($role_name);
            $result = $this->users_model->check_leader($role_name);
            if($result != ""){
                $this->session->set_flashdata('error', $this->lang->line('deactivated_error'));
                redirect('adminpanel/roles');
            }else{
                if($this->roles_model->toggle_active($id, $active)){
                    if($active == "inactive"){
                        $active = $this->lang->line('activated');
                    }else{
                        $active = $this->lang->line('deactivated');
                    }
                     //$active ? $active = $this->lang->line('deactivated') : $active = $this->lang->line('activated');
                     $this->session->set_flashdata('success', $this->lang->line('role')." ". $active);
                }
            }
        }
            if($this->roles_model->toggle_active($id, $active)){
                if($active == "inactive"){
                    $active = $this->lang->line('activated');
                }else{
                    $active = $this->lang->line('deactivated');
                }
                 //$active ? $active = $this->lang->line('deactivated') : $active = $this->lang->line('activated');
                 $this->session->set_flashdata('success', $this->lang->line('role')." ". $active);
            }

           
        
        redirect('/adminpanel/roles');
    }



    private function _save($id, $data) {
        if ($id == 1) { // check for admin role id - cannot be removed
            $this->session->set_flashdata('error', 'Never allowed to change admin role description.');
            redirect('adminpanel/roles');
        }

        $this->roles_model->save($id, $data);

        $this->session->set_flashdata('success', 'Role with id '. $id .' updated.');
        redirect('adminpanel/roles');
    }


    private function _delete($id) {

        if ($id == 1) { // check for admin role id - cannot be removed
            $this->session->set_flashdata('error', 'Never allowed to delete admin role.');
            redirect('adminpanel/roles');
        }elseif ($id == 4) { // check for member role id - cannot be removed
            $this->session->set_flashdata('error', 'Never allowed to delete member role - is needed by system.');
            redirect('adminpanel/roles');
        }

        $this->roles_model->delete($id);


        $this->session->set_flashdata('success', 'Role and all links to it removed.');
        redirect('adminpanel/roles');
    }


    public function add_role() {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('role_name', $this->lang->line('role'), 'trim|required|max_length[50]');
        //$this->form_validation->set_rules('role_description', 'description', 'trim|max_length[255]');
        $data['post']['role'] = $this->input->post('role_name');
        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            $data['post']['iswrong'] = "error";
            $this->session->set_flashdata($data['post']);
            redirect('/adminpanel/roles');
        } 

        $check_result = $this->roles_model->check_role($this->input->post('role_name'));
        if($check_result != ""){
            $data['post']['iswrong'] = "error";
            $this->session->set_flashdata($data['post']);
            $this->session->set_flashdata('error', $this->lang->line('existed_error'));
        }else{
            if(!$this->roles_model->create(array('role_name' => $this->input->post('role_name')))) {
                 $this->session->set_flashdata('error', $this->lang->line('unable_add'));
                 redirect('adminpanel/roles');
            }
            $this->session->set_flashdata('success', $this->lang->line('add_success'));
            
        }
        redirect('adminpanel/roles');
    }

    public function save_role_permissions() {
        if ($this->input->post('role_id') == 1) { // check for admin role id - cannot be removed
            $this->session->set_flashdata('error', 'Never allowed to change admin role permissions.');
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

        //log_message("error",print_r($new_arr,true));

        foreach ($new_arr as $permi_id=>$val) {
            foreach($val as $parentid=>$value){
                $result = explode(",",$value);
           // result [0] = add,result [1] = edit,$result[2] = delete,$result[3] = view
                $result_exist = $this->role_permission_model->check_exist($permi_id);
                if($result_exist == true){
                   // log_message("error",print_r($permi_id,true));
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
        log_message("error",print_r($update_parent_result,true));


        $data['post']['role_id'] = $_POST['role_id'];
        $this->session->set_flashdata($data['post']);
        $this->session->set_flashdata('success', 'Role permissions updated.');
        redirect('adminpanel/permissions');
    }
	
	public function search_status(){
		if(!empty($this->input->post("status"))){
			$status = $this->input->post("status");
		}else{
			$status = "active";
		}
        $roles = $this->roles_model->select_roles($status);

		if($roles != ""){
			echo json_encode($roles);
		}else{
			echo json_encode("norecord");
		}
	}

}

/* End of file Roles.php */
/* Location: ./application/controllers/adminpanel/Roles.php */