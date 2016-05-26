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
        $this->load->library('MY_Permission');
        $this->load->model('adminpanel/permissions_model');
        $this->load->model('adminpanel/roles_model');
        $this->load->model('adminpanel/role_permission_model');
    }

    public function index(){
        
        //$check_this = $this->my_permission->find_permission();

        $permissions = $this->permissions_model->get_permissions();
        //log_message("error",print_r($permissions,true));
        $roles = $this->roles_model->get_roles();

        $content_data = array();
        $content_data['roles_name'] = $this->roles_model->get_role_name();

        $role_id = 0;
        foreach ($roles as $role) {
            //echo print_r($role,true);
            //log_message("error",print_r($role,true));

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
                    //$content_data['roles'][$role->role_id]['permissions'][$permission->permission_id]['active'] = false;
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
                   // $content_data['roles'][$role->role_id]['permissions'][$permission->permission_id]['active'] = true;
                    $content_data['roles'][$role->role_id]['permissions'][$permission->permission_id]['add'] = $role->add;
                    $content_data['roles'][$role->role_id]['permissions'][$permission->permission_id]['edit'] = $role->edit;
                    $content_data['roles'][$role->role_id]['permissions'][$permission->permission_id]['delete'] = $role->delete;
                    $content_data['roles'][$role->role_id]['permissions'][$permission->permission_id]['view'] = $role->view;
                    
                }
            }
        }
        $content_data['get_permission'] = $this->role_permission_model->get_all_data();
        
        
        $content_data['permissions'] = $permissions;
//log_message("error",print_r( $content_data['permissions'],true));
        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('permissions'), 'permissions', 'header', 'footer', '', $content_data);
    }

    // public function permissions_multi() {
    //     $this->form_validation->set_error_delimiters('', '');
    //     $this->form_validation->set_rules('permission_id', 'permission id', 'trim|integer');
    //     $this->form_validation->set_rules('permission_description', 'description', 'trim|alpha_numeric_spaces|max_length[255]');
    //     $this->form_validation->set_rules('permission_order', 'permission order', 'trim|required|integer');

    //     if (!$this->form_validation->run()) {
    //         $this->session->set_flashdata('error', validation_errors());
    //         redirect('/adminpanel/permissions');
    //     }

    //     if (isset($_POST['edit'])) {
    //         $this->_edit($this->input->post('permission_id'), array('permission_description' => $this->input->post('permission_description'), 'permission_order' => $this->input->post('permission_order')));
    //     }elseif(isset($_POST['delete'])) {
    //         $this->_delete($this->input->post('permission_id'));
    //     }
    // }

    // private function _edit($id, $data) {
    //     $result = $this->permissions_model->save($id, $data);

    //     if (!$result || $result == "system") {
    //         $this->session->set_flashdata('error', 'System permissions can not be edited.');
    //         redirect('/adminpanel/permissions');
    //     }

    //     $this->session->set_flashdata('success', 'Permission with id '. $id .' updated.');
    //     redirect('adminpanel/permissions');
    // }

    // private function _delete($id) {
    //     $result = $this->permissions_model->delete($id);

    //     if (!$result || $result == "system") {
    //         $this->session->set_flashdata('error', 'System permissions can not be deleted.');
    //         redirect('/adminpanel/permissions');
    //     }

    //     $this->session->set_flashdata('success', 'Permission and all links to it removed.');
    //     redirect('adminpanel/permissions');
    // }

    // public function add_permission() {
    //     $this->form_validation->set_error_delimiters('', '');
    //     $this->form_validation->set_rules('permission_description', 'description', 'trim|required|alpha_numeric_spaces|max_length[255]');
    //     $this->form_validation->set_rules('permission_order', 'order', 'trim|required|integer');

    //     if (!$this->form_validation->run()) {
    //         $this->session->set_flashdata('error', validation_errors());
    //         redirect('/adminpanel/permissions');
    //         exit();
    //     }

    //     if(!$this->permissions_model->create(array('permission_description' => $this->input->post('permission_description'), 'permission_order' => $this->input->post('permission_order')))) {
    //         $this->session->set_flashdata('error', 'Unable to add permission.');
    //         redirect('adminpanel/permissions');
    //     }

    //     $this->session->set_flashdata('success', 'Permission '. $this->input->post('permission_description') .' created.');
    //     redirect('adminpanel/permissions');
    // }

}

/* End of file Permissions.php */
/* Location: ./application/controllers/adminpanel/Permissions.php */