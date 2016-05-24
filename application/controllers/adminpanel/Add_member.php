<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add_member extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('adminpanel/users_model');
        $this->load->model('adminpanel/roles_model');
        $this->load->model('system/rbac_model');

    }

    public function index() {

        $content_data['roles'] = $this->roles_model->get_role_name();
        $content_data['leaders'] = $this->users_model->get_leaders();
        $this->template->set_js('js', base_url() .'assets/js/vendor/parsley.min.js');

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('add_user'), 'add_member', 'header', 'footer', '', $content_data);
    }

    /**
     *
     * add: add member from post data.
     *
     */

     public function validate_input(){

         $this->form_validation->set_error_delimiters('<p>', '</p>');
         $this->form_validation->set_rules('username', $this->lang->line('username'), 'trim|required|max_length[20]|min_length[6]|is_valid_username|is_db_cell_available[users.username]');
         $this->form_validation->set_rules('password', $this->lang->line('password'), 'required|max_length[20]|min_length[6]|is_valid_password');
         $this->form_validation->set_rules('leader', $this->lang->line('leader'), 'trim|is_value_exists[users.username]');
         $this->form_validation->set_rules('email', $this->lang->line('email_address'), 'trim|required|max_length[255]|is_valid_email|is_db_cell_available[users.email]');
         $this->form_validation->set_rules('role', $this->lang->line('role'), 'trim|required|is_value_exists[role.role_name]');
         $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'trim|regex_match[/(\\d{3})\\D{0,2}(\\d{3})\\D{0,2}(\\d{4})[x\\.\\s]{0,2}(\\d{4}|\\d{0})/]');

         if (!$this->form_validation->run()) {
             echo json_encode($this->form_validation->error_array(), true);
             exit();

         }
     }

    public function add() {

        if (! self::check_permissions(4)) {
            redirect("/private/no_access");
        }

        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('username', $this->lang->line('username'), 'trim|required|max_length[20]|min_length[6]|is_valid_username|is_db_cell_available[users.username]');
        $this->form_validation->set_rules('password', $this->lang->line('password'), 'required|max_length[20]|min_length[6]|is_valid_password');
        $this->form_validation->set_rules('leader', $this->lang->line('leader'), 'trim|is_value_exists[users.username]');
        $this->form_validation->set_rules('email', $this->lang->line('email_address'), 'trim|required|max_length[255]|is_valid_email|is_db_cell_available[users.email]');
        $this->form_validation->set_rules('role', $this->lang->line('role'), 'trim|required|is_value_exists[role.role_name]');
        $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'trim|regex_match[/^((((\\+[\\d\\-.]{1,5})?[ \\-.]?\\d{3})|(\\+[\\d\\-.]{1,5})?[ \\-.]?\\((\\d{3}\\)))?[ \\-.]?\\d{3}[ \\-.]?\\d{4}\\s?(e?x?t?\\.?\\s?\\d{1,7})?)?$/]');
        //validation fail

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            $data['post'] = $_POST;
            $this->session->set_flashdata($data['post']);

            redirect('/adminpanel/add_member');
            exit();
        }

        //save user into table
        if($return_array = $this->users_model->create_user($this->input->post('username'), $this->input->post('password'), $this->input->post('email'), $this->input->post('leader'), $this->input->post('role'), "pending")) {

            // set roles
            if ($result = $this->roles_model->get_role_id($_POST['role']) ) {
                $this->rbac_model->create_user_role(array('user_id' => $return_array['user_id'], 'role_id' => $result['0']['role_id']));
            }

            // Data to be Save
            $data = array();
            $fields = array('real_name', 'nickname', 'phone', 'emergency_contact', 'emergency_name', 'relationship', 'tb_lp_id', 'tp_lp_name', 'sy_lp_id', 'sy_lp_name', 'tb_bo', 'gd_bo', 'keno_bo', 'cyber_roam', 'rtx', 'windows_id');
            $data['username'] = $this->input->post('username');
            foreach($fields as $field){
                isset($_POST[$field])?$data[$field] = $this->input->post($field) : "";
            }
            (isset($_POST['dob']) && !empty($_POST['dob'])) ?$data['dob'] = date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('dob')))) : "";

            $this->users_model->save($data);

            // send confirmation email
            $this->load->helper('send_email');
            $this->load->library('email', load_email_config(Settings_model::$db_config['email_protocol']));
            $this->email->from('wq.wong@eagleeye.xyz', $_SERVER['HTTP_HOST']);
            // Settings_model::$db_config['admin_email_address']
            $this->email->to('wq.wong@eagleeye.xyz');
            // $this->input->post('email')
            $this->email->subject($this->lang->line('membership_subject'));
            $message ="";
            $message .=$this->lang->line('email_greeting') ." ".$this->input->post('username');
            // $message .=$this->lang->line('email_greeting') . " ". $this->input->post('username');
            $message .=$this->lang->line('membership_credentials').$this->input->post('username');
            $message .=$this->lang->line('membership_credentials_password').$this->input->post('password');
            $message .=$this->lang->line('membership_message'). base_url() ."auth/activate_account/check/". urlencode($this->input->post('email')) ."/". $return_array['nonce']." ";
            // $this->email->message($this->lang->line('email_greeting') . " ". $this->input->post('username') . $this->lang->line('membership_message'). base_url() ."auth/activate_account/check/". urlencode($this->input->post('email')) ."/". $return_array['nonce']." ".$this->lang->line('membership_credentials').$this->input->post('username').$this->lang->line('membership_credentials_password').$this->input->post('password'));
            $this->email->message($message);
            $this->email->send();

            $this->session->set_flashdata('success', '<p>'. $this->lang->line('account_created') .'</p>');
        }else{
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('unable_to_register') .'</p>');
        }
        redirect('/adminpanel/add_member');
    }

}

/* End of file add_member.php */
/* Location: ./application/controllers/adminpanel/add_member.php */