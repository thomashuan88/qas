<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit_member_detail extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        // pre-load
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('MY_Permission');

        $this->load->model('adminpanel/member_detail_model');
        $this->load->model('adminpanel/users_model');
        $this->load->model('adminpanel/roles_model');

        if (! self::check_permissions(2)) {
            redirect("/private/no_access");
        }

        $this->permission = self::check_action(2);
        if ($this->permission->edit !== 'yes') {
            redirect("/private/no_access");
        }
    }

    public function _remap($method, $params = array()) {
        $content_data['permission'] = array();
        ($this->permission->add == 'yes') ?  $content_data['permission']['add'] = TRUE : '';
        ($this->permission->edit == 'yes') ?  $content_data['permission']['edit'] = TRUE : '';
        ($this->permission->delete == 'yes') ?  $content_data['permission']['delete'] = TRUE : '';
        if ( $this->form_validation->is_natural_no_zero($this->uri->segment(3))) {
            $member_data = $this->users_model->get_member_data($this->uri->segment(3));
            $current_user = $this->users_model->get_member_info($this->session->userdata('username'));

            $content_data['permission']['user_details']['disable_input'] = ($current_user->role == "Administrator" && $this->session->userdata('username') != $member_data->username) ?' ' : 'disabled';
            
            $content_data['permission']['user_profile']['disable_input'] = ($current_user->role == "Administrator" || $this->session->userdata('username') == $member_data->username) ?' ' : 'disabled';
            $content_data['permission']['user_ids']['disable_input'] =($current_user->role == "Administrator" && $this->session->userdata('username') != $member_data->username)?  ' ' : 'disabled';
            $content_data['permission']['user_remark']['disable_input'] =(($current_user->role == "Administrator" || in_array($this->session->userdata('username'), $this->my_permission->find_permission())) && $this->session->userdata('username') != $member_data->username ) ? ' ' : 'disabled';
            $content_data['permission']['user_password']['disable_input'] = ($current_user->role == "Administrator" || $this->session->userdata('username') == $member_data->username)? ' ' : 'disabled';
        }

        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }

        if ( ! $this->form_validation->is_natural_no_zero($this->uri->segment(3))) {
            $this->session->set_flashdata('error', '<p>Illegal request.</p>');
            redirect('adminpanel/list_members');
        }

        // if (! self::check_permissions(1)) {
        //     redirect("/private/no_access");
        // }
        foreach($member_data as &$value){
            if($value=="0" | $value=="+60" ){
                $value="";
            }
        }
        $content_data['member'] = $member_data;
        // $content_data['member'] = $this->users_model->get_member_data($this->uri->segment(3));

        $this->load->model('system/rbac_model');
        $content_data['roles'] = $this->roles_model->get_role_name();
        $content_data['leaders'] = $this->users_model->get_leaders();

        if (! $content_data['member']) {
            $this->session->set_flashdata('error', 'Nothing found.');
            redirect('adminpanel/list_members');
        }

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('member_detail'), 'edit_member_detail', 'header', 'footer', '', $content_data);

        return $this;
    }
    /**
     *
     * save: store data about member
     *
     */

    public function save_details() {


        if ($this->permission->edit !== 'yes') {
            redirect("/private/no_access");
        }
        $member_data = $this->users_model->get_member_info($this->session->userdata('username'));
        if($member_data->role !== "Administrator"){
            redirect("/private/no_access");
        }

        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('real_name', $this->lang->line('full_name'), 'trim|max_length[40]|min_length[2]');
        $this->form_validation->set_rules('email', $this->lang->line('email_address'), 'trim|max_length[255]|is_db_cell_available_by_id[users.email.'. $this->input->post('user_id') .'.user_id]');
        $this->form_validation->set_rules('role', $this->lang->line('role'), 'trim|max_length[20]|min_length[2]');
        $this->form_validation->set_rules('leader', $this->lang->line('leader'), 'trim');
        $this->form_validation->set_rules('status', $this->lang->line('status'), 'trim');
        $this->form_validation->set_rules('windows_id', 'windows_id', 'trim');
        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('/adminpanel/edit_member_detail/'. $this->input->post('user_id'));
            exit();
        }

        $data = array();

        isset($_POST['username'])?$data['username'] = $this->input->post('username') : "";
        isset($_POST['real_name'])?$data['real_name']= $this->input->post('real_name') : "";
        isset($_POST['role'])?$data['role']= $this->input->post('role') : "";
        isset($_POST['email'])?$data['email']= $this->input->post('email') : "";
        isset($_POST['leader'])?$data['leader']= $this->input->post('leader') : "";
        isset($_POST['status'])?$data['status']= $this->input->post('status') : "";
        isset($_POST['windows_id'])?$data['windows_id']= $this->input->post('windows_id') : "";
        $this->load->model('system/rbac_model');

        if ($result = $this->roles_model->get_role_id($_POST['role']) ) {
            $this->rbac_model->update_user_role(array('user_id' => $this->input->post('user_id'), 'role_id' => $result['0']['role_id']));
        }

        // save profile data
        $this->users_model->save($data);

        $this->session->set_flashdata('success', sprintf($this->lang->line('member_updated'), $this->input->post('username')));

        redirect('/adminpanel/edit_member_detail/'. $this->input->post('user_id'));
    }

    public function save_profile() {

        // if ($this->permission->edit !== 'yes') {
        //     redirect("/private/no_access");
        // }
        $member_data = $this->users_model->get_member_info($this->session->userdata('username'));
        if($member_data->role !== "Administrator" && !in_array($this->input->post('username'), $this->my_permission->find_permission())){
            redirect("/private/no_access");
        }

        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('phone_display', $this->lang->line('phone'), 'trim|is_valid_phone');
        $this->form_validation->set_rules('emergency_contact_display', $this->lang->line('emergency_contact'), 'trim|is_valid_phone');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('/adminpanel/edit_member_detail/'. $this->input->post('user_id').'?tab=profile');
            exit();
        }

        $data = array();
        $data['username'] = $this->input->post('username');
        isset($_POST['nickname'])?$data['nickname'] = $this->input->post('nickname') : "";
        (isset($_POST['dob']) && !empty($_POST['dob'])) ?$data['dob']= date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('dob')))) : "";
        isset($_POST['phone'])?$data['phone']= $this->input->post('phone') : "";
        isset($_POST['emergency_contact'])?$data['emergency_contact']= $this->input->post('emergency_contact') : "";
        isset($_POST['emergency_name'])?$data['emergency_name']= $this->input->post('emergency_name') : "";
        isset($_POST['relationship'])?$data['relationship']= $this->input->post('relationship') : "";
        // save profile data
        $this->users_model->save($data);

        $this->session->set_flashdata('success', sprintf($this->lang->line('member_updated'), $this->input->post('username')));

        redirect('/adminpanel/edit_member_detail/'. $this->input->post('user_id').'?tab=profile');
    }

    public function save_ids() {

        if ($this->permission->edit !== 'yes') {
            redirect("/private/no_access");
        }
        $member_data = $this->users_model->get_member_info($this->session->userdata('username'));
        if($member_data->role !== "Administrator" && !in_array($this->input->post('username'), $this->my_permission->find_permission())){
            redirect("/private/no_access");
        }

        $data = array();
        $data['username'] = $this->input->post('username');
        isset($_POST['tb_lp_id'])?$data['tb_lp_id'] = strtolower($this->input->post('tb_lp_id')) : "";
        isset($_POST['tb_lp_name']) ?$data['tb_lp_name']= strtolower($this->input->post('tb_lp_name')) : "";
        isset($_POST['sy_lp_id'])?$data['sy_lp_id']= strtolower($this->input->post('sy_lp_id')) : "";
        isset($_POST['sy_lp_name'])?$data['sy_lp_name']= strtolower($this->input->post('sy_lp_name')) : "";
        isset($_POST['tb_bo'])?$data['tb_bo']= strtolower($this->input->post('tb_bo')) : "";
        isset($_POST['gd_bo'])?$data['gd_bo']= strtolower($this->input->post('gd_bo')) : "";
        isset($_POST['keno_bo'])?$data['keno_bo']= strtolower($this->input->post('keno_bo')) : "";
        isset($_POST['cyber_roam'])?$data['cyber_roam']= strtolower($this->input->post('cyber_roam')) : "";
        isset($_POST['rtx'])?$data['rtx']= strtolower($this->input->post('rtx')) : "";

        // save profile data
        $this->users_model->save($data);

        $this->session->set_flashdata('success', sprintf($this->lang->line('member_updated'), $this->input->post('username')));

        redirect('/adminpanel/edit_member_detail/'. $this->input->post('user_id').'?tab=ids');
    }

    public function save_remarks(){
        if ($this->permission->edit !== 'yes') {
            redirect("/private/no_access");
        }
        $member_data = $this->users_model->get_member_info($this->session->userdata('username'));

        if($this->session->userdata('username')==$this->input->post('username') && $member_data->role !== "Administrator" &&!in_array($this->input->post('username'), $this->my_permission->find_permission())){
            redirect("/private/no_access");
        }

        $data = array();
        $data['username'] = $this->input->post('username');
        isset($_POST['remark'])?$data['remark'] = $this->input->post('remark') : "";

        // save profile data
        $this->load->model('adminpanel/remarks_model');
        $this->remarks_model->save($data);

        $this->session->set_flashdata('success', sprintf($this->lang->line('member_updated'), $this->input->post('username')));
        log_message('error', $this->lang->line('member_updated'));
        redirect('/adminpanel/edit_member_detail/'. $this->input->post('user_id').'?tab=remark');
    }

    public function save_password(){

        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('old_password', $this->lang->line('old_password'), 'trim|required|max_length[20]|min_length[8]|is_member_password');
        $this->form_validation->set_rules('new_password', $this->lang->line('new_password'), 'trim|required|max_length[20]|min_length[8]|is_valid_new_password|is_new_password_secure|is_valid_both_password|password_not_equal_username['.$this->input->post("username").']');
        $this->form_validation->set_rules('confirm_password', $this->lang->line('confirm_password'), 'trim|required|max_length[20]|min_length[8]|matches[new_password]');
        $this->form_validation->set_rules('password_hint', $this->lang->line('password_hint'), 'trim|required|max_length[30]');
        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('adminpanel/edit_member_detail/'.$this->input->post('user_id').'?tab=password');
        }
        $this->load->model('adminpanel/users_model');

        $data = $this->users_model->save_password($this->input->post('user_id'), $this->input->post('new_password'),$this->input->post('password_hint'));

            if($data){
                $this->session->set_flashdata('success', '<p>'. $this->lang->line('change_password_success') .'</p>');
            }
            else{
                $this->session->set_flashdata('error', '<p>'. $this->lang->line('change_password_failed') .'</p>');
            }
        redirect('/adminpanel/edit_member_detail/'. $this->input->post('user_id').'?tab=password');

    }

}
