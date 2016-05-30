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

        $content_data = array();
        // loop through roles for each permission
        $role_id = 0;
        foreach ($roles as $role) {
            // new role detected
			$content_data['roles'][$role->role_id]['role_name'] = $role->role_name;
			$content_data['roles'][$role->role_id]['status'] = $role->status;
			$role_id = $role->role_id;
        }
        ksort($content_data['roles'][$role->role_id]);
        $action_result = self::check_action(5);
        ($action_result->add == 'yes') ?  $content_data['add_role_page'] = TRUE : $content_data['add_role_page'] = FALSE;

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('role'), 'roles', 'header', 'footer', '', $content_data);
    }

    public function toggle_active($id,$active,$role_name) {
        if ($id == 1) { // check for admin role id - cannot be removed
            $this->session->set_flashdata('error', $this->lang->line('never_allowed'));
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
            $this->session->set_flashdata('success', $this->lang->line('role')." ". $active);
        }
        redirect('/adminpanel/roles');
    }

    public function add_role() {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('role_name', $this->lang->line('role'), 'trim|required|max_length[50]');

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