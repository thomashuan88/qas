<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends Auth_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
       // $this->load->library('recaptcha');
        //$this->lang->load('recaptcha');
        if (Settings_model::$db_config['recaptchav2_enabled'] == 1) {
            $this->load->library('recaptchaV2');
        }
        $this->load->model('auth/register_model');
    }

    public function index() {
        $data = array();

        // if OAuth2 enabled
        if (Settings_model::$db_config['oauth2_enabled']) {
            // generate all active OAuth2 Providers
            $this->load->model('auth/Oauth2_model');
            $data['providers'] = $this->Oauth2_model->get_all();
        }

        $this->template->set_js('js', base_url() .'assets/js/vendor/parsley.min.js');
        $this->quick_page_setup(Settings_model::$db_config['active_theme'], 'main', $this->lang->line('create_account'), 'auth/register', 'header', 'footer', '', $data);
    }

    /**
     *
     * add_member: insert a new member into the database after all input fields have met the requirements
     *
     *
     */
    public function add_member() {
        // check whether creating member is allowed
        if (Settings_model::$db_config['registration_enabled'] == 0) {
            $this->session->set_flashdata('error', $this->lang->line('registration_disabled'));
            redirect('register');
        }

        // form input validation
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('first_name', $this->lang->line('first_name'), 'trim|required|max_length[40]|min_length[2]');
        $this->form_validation->set_rules('last_name', $this->lang->line('last_name'), 'trim|required|max_length[60]|min_length[2]');
        $this->form_validation->set_rules('email', $this->lang->line('email_address'), 'trim|required|max_length[255]|is_valid_email|is_db_cell_available[users.email]');
        $this->form_validation->set_rules('username', $this->lang->line('username'), 'trim|required|max_length[16]|min_length[6]|is_valid_username|is_db_cell_available[users.username]');
        $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required|max_length[64]|min_length[9]|matches[password_confirm]|is_valid_password');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('confirm_password'), 'trim|required|max_length[64]|min_length[9]');
        if (Settings_model::$db_config['recaptchav2_enabled'] == true) {
            //$this->form_validation->set_rules('recaptcha_response_field', 'captcha response field', 'required|check_captcha');
            $this->form_validation->set_rules('g-recaptcha-response', $this->lang->line('recaptchav2_response'), 'required|check_captcha');
        }

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            $data['post'] = $_POST;
            $this->session->set_flashdata($data['post']);
            redirect('register');
        }

        if ($return_array = $this->register_model->create_member($this->input->post('username'), $this->input->post('password'), $this->input->post('email'), $this->input->post('first_name'), $this->input->post('last_name'))) {

            // add default member role
            $this->load->model('system/rbac_model');
            $this->rbac_model->create_user_role(array('user_id' => $return_array['user_id'], 'role_id' => 4));

            // create directory
            if (!file_exists(FCPATH .'assets/img/members/'. $this->input->post('username'))) {
                mkdir(FCPATH .'assets/img/members/'. $this->input->post('username'));
            }else{
                $this->session->set_flashdata('error', $this->lang->line('create_imgfolder_failed'));
                redirect('register');
            }

            // send email
            $this->load->helper('send_email');
            $this->load->library('email', load_email_config(Settings_model::$db_config['email_protocol']));
            $this->email->from(Settings_model::$db_config['admin_email_address'], $_SERVER['HTTP_HOST']);
            $this->email->to($this->input->post('email'));
            $this->email->subject($this->lang->line('membership_subject'));
            $this->email->message($this->lang->line('email_greeting') . " ". $this->input->post('username') . $this->lang->line('membership_message'). base_url() ."auth/activate_account/check/". urlencode($this->input->post('email')) ."/". $return_array['nonce']);
            $this->email->send();
            $this->session->set_flashdata('success', '<p>'. $this->lang->line('membership_success') .'</p>');

            redirect('register');

        }else{
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('membership_failed_db') .'</p>');
            redirect('register');
        }
    }
    
}

/* End of file Register.php */
/* Location: ./application/controllers/auth/Register.php */