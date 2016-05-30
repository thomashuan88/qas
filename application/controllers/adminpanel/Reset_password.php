<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reset_password extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
     
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index() {

        $this->template->set_js('js', base_url() .'assets/js/vendor/parsley.min.js');

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('reset_password'), 'edit_member_detail', 'header', 'footer');
    }

    public function send_password(){

        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('email', $this->lang->line('email_address'), 'trim|required|is_valid_email');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('adminpanel/edit_member_detail/'. $this->input->post('user_id').'?tab=password');
            exit();
        }

        $this->load->model('adminpanel/reset_password_model');
        $data = $this->reset_password_model->get_data_by_email($this->input->post('email'));

        if ($data['status'] != "Active") {
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('is_account_active') .'<p>');
            redirect('adminpanel/edit_member_detail/'. $this->input->post('user_id').'?tab=password');

        }elseif (!empty($data['nonce'])) {

            $token = hash_hmac('ripemd160', md5($data['nonce'] . uniqid(mt_rand(), true)), SITE_KEY);
            $this->load->model('adminpanel/reset_password_model');   
            $this->reset_password_model->delete_tokens_by_email($this->input->post('email'));

            if ($this->reset_password_model->insert_recover_password_data($data['user_id'], $token, $this->input->post('email'))) {

                $this->load->helper('send_email');
                $this->load->library('email', load_email_config(Settings_model::$db_config['email_protocol']));
                $this->email->from(Settings_model::$db_config['admin_email_address'], $_SERVER['HTTP_HOST']);
                $this->email->to($this->input->post('email'));
                $this->email->subject($this->lang->line('forgot_password_subject'));
                $this->email->message($this->lang->line('email_greeting') ." ". $data['username'] . $this->lang->line('forgot_password_message') ."\r\n\r\n". base_url() ."auth/login/reset/". urlencode($this->input->post('email')) ."/". $token);
                $this->email->send();

                $this->session->set_flashdata('success', sprintf($this->lang->line('forgot_password_success'), $this->input->post('email')));
            }else{
                $this->session->set_flashdata('error', '<p>'. $this->lang->line('reset_password_failed_db') .'</p>');   
            }
            redirect('adminpanel/edit_member_detail/'. $this->input->post('user_id').'?tab=password');
        }else{
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('email_not_found') .'</p>');
        }
        
        $this->session->set_flashdata('email', $this->input->post('email'));
            redirect('adminpanel/edit_member_detail/'. $this->input->post('user_id').'?tab=password');
    }

}
