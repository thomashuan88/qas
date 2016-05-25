<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Auth_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        if (Settings_model::$db_config['recaptchav2_enabled'] == 1) {
            $this->load->library('recaptchaV2');
        }

    }

    public function index() {
        $data = array();
        $data["language"] = "english";

        if($this->input->get("language")){
            $data["language"] = $this->input->get("language");
             $this->lang->load("messages_lang", $data["language"]);
        } 
                   
        // if OAuth2 enabled
        if (Settings_model::$db_config['oauth2_enabled']) {
            // generate all active OAuth2 Providers
            $this->load->model('auth/Oauth2_model');
            $data['providers'] = $this->Oauth2_model->get_all();
        }

        $this->template->set_js('js', base_url() .'assets/js/vendor/parsley.min.js');

        $this->quick_page_setup(Settings_model::$db_config['active_theme'], 'main', 'Login', 'auth/login', 'header', 'footer', '', $data);
    }

    /**
     *
     * validate: validate login after input fields have met requirements
     *
     *
     */

    public function validate(){

        // form input validation
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('username', $this->lang->line('username'), 'trim|required|max_length[16]');
        $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required|max_length[128]');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('login');
        }

        $this->load->model('auth/login_model');

        // database work
      

        //if got result - delete data from ci_slssion with the selected id from previous result
        //else no result - do nth
        $session_id = $this->login_model->get_session($this->input->post('username'));

        // log_message("error", $session_id);

        // if($session_id){
            
        //     $this->login_model->delete_session($session_id);
        // }

        // else{

            $data = $this->login_model->validate_login($this->input->post('username'), $this->input->post('password'));

            if (is_array($data)) {
            // set session data

                if ($data['status'] == "inactive") //check active
                {  
                    $this->session->set_flashdata('error', '<p>'. $this->lang->line('is_account_active') .'</p>');
                    redirect('login');
                }
                else
                {
                    $this->session->set_userdata('logged_in', true);
                    $this->session->set_userdata('user_id', $data['user_id']);
                    $this->session->set_userdata('username', $data['username']);
                }    

                $data['language'] = $this->input->post('language') ;
                $this->session->set_userdata('language', $data['language']);
                // redirect('private/'. strtolower(Settings_model::$db_config['home_page']));
                redirect('adminpanel/list_members');

            
            }else{
                $this->session->set_flashdata('error', $this->lang->line('login_incorrect'));
                redirect('login');
            }
        // }     
    }

    // public function validate() {

    //     if ($this->session->userdata('login_attempts') == false) {
    //         $v = 0;
    //     }else{
    //         $v = $this->session->userdata('login_attempts');
    //     }

    //     // form input validation
    //     $this->form_validation->set_error_delimiters('<p>', '</p>');
    //     $this->form_validation->set_rules('username', $this->lang->line('username'), 'trim|required|max_length[16]');
    //     $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required|max_length[64]');
    //     if ($v >= Settings_model::$db_config['login_attempts'] && Settings_model::$db_config['recaptchav2_enabled'] == true) {
        
    //         // this is the Recaptcha V2 code, above is for V1 but it's commented out, same in register view
    //         $this->form_validation->set_rules('g-recaptcha-response', $this->lang->line('recaptchav2_response'), 'required|check_captcha');
    //     }

    //     if (!$this->form_validation->run()) {
    //         $this->session->set_flashdata('error', validation_errors());
    //         redirect('login');
    //     }

    //     $this->load->model('auth/login_model');

    //     // check max login attempts first
    //     if ($this->login_model->check_max_logins($this->input->post('username'))) {
    //         $this->session->set_flashdata('error', $this->lang->line('max_login_attempts_reached'));
    //         redirect('login');
    //     }

    //     // database work
    //     $data = $this->login_model->validate_login($this->input->post('username'), $this->input->post('password'));

    //     if ($data == "banned") { // check banned
    //         $this->session->set_flashdata('error', '<p>'. $this->lang->line('account_access_denied') .'</p>');
    //         redirect('login');
    //     }elseif (is_array($data)) {
    //         if ($data['active'] == 0) { // check active
    //             $this->session->set_flashdata('error', '<p>'. $this->lang->line('activate_account') .'</p>');
    //             redirect('login');
    //         }else{

    //             // let administrators through, the other roles will be redirected when checks below match
    //             if (!self::check_roles(1)) {
    //                 if (Settings_model::$db_config['disable_all'] == 1) {
    //                     $this->session->set_flashdata('error', '<p>'. $this->lang->line('site_disabled') .'</p>');
    //                     redirect('login');
    //                 }elseif(Settings_model::$db_config['login_enabled'] == 0) {
    //                     $this->session->set_flashdata('error', '<p>'. $this->lang->line('login_disabled') .'</p>');
    //                     redirect('login');
    //                 }
    //             }

    //             // set the cookie if remember me option is set
    //             $this->load->helper('cookie');
    //             $cookie_domain = config_item('cookie_domain');
    //             if ($this->input->post('remember_me') && !get_cookie('unique_token') && Settings_model::$db_config['remember_me_enabled'] == true) {
    //                 setcookie("unique_token", $data['nonce'] . substr(uniqid(mt_rand(), true), -10) . $data['cookie_part'], time() + Settings_model::$db_config['cookie_expires'], '/', $cookie_domain, false, false);
    //             }

    //             // set session data
    //             $this->session->set_userdata('logged_in', true);
    //             $this->session->set_userdata('user_id', $data['user_id']);
    //             $this->session->set_userdata('username', $data['username']);
    //             // reset login attempts to 0
    //             $this->login_model->reset_login_attempts($data['username']);
    //             $this->session->set_userdata('login_attempts', 0);
    //             redirect('private/'. strtolower(Settings_model::$db_config['home_page']));
    //         }
    //     }else{
    //         $this->session->set_flashdata('error', $this->lang->line('login_incorrect'));
    //         $this->session->set_userdata('login_attempts', $data);
    //         redirect('login');
    //     }
    // }


}

/* End of file Login.php */
/* Location: ./application/controllers/auth/Login.php */