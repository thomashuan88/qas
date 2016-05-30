<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resend_activation extends Auth_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'send_email'));
        $this->load->library('form_validation');
        //$this->load->library('recaptcha');
        if (Settings_model::$db_config['recaptchav2_enabled'] == 1) {
            $this->load->library('recaptchaV2');
        }
        //$this->lang->load('recaptcha');
    }

    public function index() {

        $this->template->set_js('js', base_url() .'assets/js/vendor/parsley.min.js');

        $this->quick_page_setup(Settings_model::$db_config['active_theme'], 'main', $this->lang->line('resend_activation'), 'auth/resend_activation', 'header', 'footer');
    }

    /**
     *
     * send_link: resend activation link
     *
     *
     */

    public function send_link() {
        // form input validation
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('email', $this->lang->line('email_address'), 'trim|required|is_valid_email');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('resend_activation');
            exit();
        }

        $this->load->model('system/email_tools_model');
        $data = $this->email_tools_model->get_data_by_email($this->input->post('email'));

        if ($data['status'] == "Active") {
            $this->session->set_flashdata('error', '<p>'.$this->lang->line('account_activated') .'</p>');
            redirect('resend_activation');
        }elseif (!empty($data['nonce'])) {
            $this->load->model('auth/resend_activation_model');
            $this->resend_activation_model->update_last_login($data['username']);
            $this->load->helper('send_email');
            $this->load->library('email', load_email_config(Settings_model::$db_config['email_protocol']));
            $this->email->from(Settings_model::$db_config['admin_email_address'], $_SERVER['HTTP_HOST']);
            $this->email->to($this->input->post('email'));
            $this->email->subject($this->lang->line('resend_activation_subject'));

            $message ="";
            $message .=$this->lang->line('email_greeting') ." ".$this->input->post('uname');
            $message .=$this->lang->line('resend_activation_message'). base_url() ."auth/activate_account/check/". urlencode($this->input->post('email')) ."/". $data['nonce']."/".$data['username']." ";
            $this->email->message($message);
            if ($this->email->send()) {
                $this->session->set_flashdata('success', '<p>'. $this->lang->line('resend_activation_success') .'</p>');
            }
            redirect('resend_activation');
        }else{
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('email_not_found') .'</p>');
        }

        $this->session->set_flashdata('email', $this->input->post('email'));
        redirect('resend_activation');
    }

}

/* End of file Resend_activation.php */
/* Location: ./application/controllers/auth/Resend_activation.php */
