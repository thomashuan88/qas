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

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('reset_password'), 'member_detail', 'header', 'footer');
    }

    public function send_password(){

        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('email', $this->lang->line('email_address'), 'trim|required|is_valid_email');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('adminpanel/member_detail/'. $this->input->post('user_id').'?tab=password');
            exit();
        }

        $this->load->model('adminpanel/reset_password_model');
        $data = $this->reset_password_model->get_data_by_email($this->input->post('email'));

        if ($data['status'] != "active") {
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('is_account_active') .'<p>');
            redirect('adminpanel/member_detail/'. $this->input->post('user_id').'?tab=password');

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
                $this->email->message($this->lang->line('email_greeting') ." ". $data['username'] . $this->lang->line('forgot_password_message') ."\r\n\r\n". base_url() ."adminpanel/reset_password/reset/". urlencode($this->input->post('email')) ."/". $token);
                $this->email->send();
                $this->session->set_flashdata('success', '<p>'. $this->lang->line('forgot_password_success') .'</p>');
            }else{
                $this->session->set_flashdata('error', '<p>'. $this->lang->line('reset_password_failed_db') .'</p>');   
            }
            redirect('adminpanel/member_detail/'. $this->input->post('user_id').'?tab=password');
        }else{
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('email_not_found') .'</p>');
        }

        $this->session->set_flashdata('email', $this->input->post('email'));
            redirect('adminpanel/member_detail/'. $this->input->post('user_id').'?tab=password');
    }


    public function reset($email, $token) {

        $this->load->model('adminpanel/reset_password_model');
        $data = $this->reset_password_model->verify_token(urldecode($email), $token);
        $this->reset_password_model->delete_token_data($token);
        $user_id = $this->reset_password_model->get_user(urldecode($email));

        if (!empty($data['date_added'])) {
            $time_diff = strtotime("now") - strtotime($data['date_added']);
        }

        if (isset($time_diff) && $time_diff > Settings_model::$db_config['password_link_expires']) {

            $this->session->set_flashdata('error', '<p>'. $this->lang->line('renew_password_link_expired') .'</p>');  //dun have language
            redirect('adminpanel/member_detail/'. $user_id.'?tab=password');
            exit();

        }elseif (isset($data['token']) && $data['token'] == $token) { 

            $new_password = $this->_random_letter().
            $this->_random_symbol().
            $this->_random_capital_letter().
            $this->_random_letter().
            $this->_random_number().
            $this->_random_symbol();

            $new_password = str_shuffle($new_password);

            if ($this->reset_password_model->update_password_and_nonce(urldecode($email), $new_password)) {

                $this->load->helper('send_email');
                $this->load->library('email', load_email_config(Settings_model::$db_config['email_protocol']));
                $this->email->from(Settings_model::$db_config['admin_email_address'], $_SERVER['HTTP_HOST']);
                $this->email->to(urldecode($email));
                $this->email->subject($this->lang->line('reset_password_subject'));
                $this->email->message($this->lang->line('email_greeting') ." ". $data['username'] . $this->lang->line('reset_password_message'). addslashes($new_password));

                $this->email->send();
                $this->session->set_flashdata('success', '<p>'. $this->lang->line('reset_password_success') .'</p>');
                
                redirect('adminpanel/member_detail/'. $user_id.'?tab=password');

            }else{
                            
                $this->session->set_flashdata('error', '<p>'. $this->lang->line('reset_password_failed_db') .'</p>');
            }
        }else{

            $this->session->set_flashdata('error', '<p>'. $this->lang->line('reset_password_failed_token') .'</p>');
        }
            redirect('adminpanel/member_detail/'. $user_id.'?tab=password');

    }

    private function _random_symbol() {
        $symbol_arr = array("!", "$", ".", "[", "]", "|", "(", ")", "?", "*", "+", "{", "}", "@", "#");
        $i = rand(0, 14);
        return $symbol_arr[$i];
    }

    private function _random_capital_letter(){
        $capital_letter_arr = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
        $i = rand(0, 25);
        return $capital_letter_arr[$i];
    }

    private function _random_letter() {
        $letter_arr = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
        $i = rand(0, 25);
        return $letter_arr[$i];
    }

    private function _random_number() {
        $number_arr = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $i = rand(0, 9);
        return $number_arr[$i];
    }

    }
