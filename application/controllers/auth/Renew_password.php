<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Renew_password extends Auth_Controller {

    public function __construct()
    {
        parent::__construct();
        // pre-load
        $this->load->helper('form');
        $this->load->library('form_validation');
        //$this->load->library('recaptcha');
        if (Settings_model::$db_config['recaptchav2_enabled'] == 1) {
            $this->load->library('recaptchaV2');
        }
        //$this->lang->load('recaptcha');
    }

    public function index() {

        $this->template->set_js('js', base_url() .'assets/js/vendor/parsley.min.js');

        $this->quick_page_setup(Settings_model::$db_config['active_theme'], 'main', $this->lang->line('renew_password_title'), 'auth/renew_password', 'header', 'footer');
    }

    /**
     *
     * send_password: send the reset member password link
     *
     *
     */

    public function send_password() {
        // form input validation
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('email', $this->lang->line('email_address'), 'trim|required|is_valid_email');
        if (Settings_model::$db_config['recaptchav2_enabled'] == true) {
            //$this->form_validation->set_rules('recaptcha_response_field', 'captcha response field', 'required|check_captcha');
            // this is the Recaptcha V2 code, above is for V1 but it's commented out, same in login view
            $this->form_validation->set_rules('g-recaptcha-response', $this->lang->line('recaptchav2_response'), 'required|check_captcha');
        }

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('renew_password');
            exit();
        }

        $this->load->model('system/email_tools_model');
        $data = $this->email_tools_model->get_data_by_email($this->input->post('email'));

        if (isset($data['active']) && $data['active'] != 1) {
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('is_account_active') .'<p>');
            redirect('renew_password');
        }elseif (!empty($data['nonce'])) {

            $token = hash_hmac('ripemd160', md5($data['nonce'] . uniqid(mt_rand(), true)), SITE_KEY);
            $this->load->model('auth/renew_password_model');

            $this->renew_password_model->delete_tokens_by_email($this->input->post('email'));

            if ($this->renew_password_model->insert_recover_password_data($data['user_id'], $token, $this->input->post('email'))) {
                $this->load->helper('send_email');
                $this->load->library('email', load_email_config(Settings_model::$db_config['email_protocol']));
                $this->email->from(Settings_model::$db_config['admin_email_address'], $_SERVER['HTTP_HOST']);
                $this->email->to($this->input->post('email'));
                $this->email->subject($this->lang->line('forgot_password_subject'));
                $this->email->message($this->lang->line('email_greeting') ." ". $data['username'] . $this->lang->line('forgot_password_message') ."\r\n\r\n". base_url() ."auth/renew_password/reset/". urlencode($this->input->post('email')) ."/". $token);
                $this->email->send();
                $this->session->set_flashdata('success', '<p>'. $this->lang->line('forgot_password_success') .'</p>');
            }else{
                $this->session->set_flashdata('error', '<p>'. $this->lang->line('renew_password_failed_db') .'</p>');
            }

            redirect('renew_password');
        }else{
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('email_not_found') .'</p>');
        }

        $this->session->set_flashdata('email', $this->input->post('email'));
        redirect('renew_password');
    }

    public function reset($email, $token) {
        // check whether the recover_password row if there
        $this->load->model('auth/renew_password_model');
        $data = $this->renew_password_model->verify_token(urldecode($email), $token);

        // remove token: one shot per email
        $this->renew_password_model->delete_token_data($token);

        // if there is a date for this row, basically check for row and create timediff
        if (!empty($data['date_added'])) {
            $time_diff = strtotime("now") - strtotime($data['date_added']);
        }

        // expired? compare to setting
        if (isset($time_diff) && $time_diff > Settings_model::$db_config['password_link_expires']) {
            // link has expired
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('renew_password_link_expired') .'</p>');
            redirect("renew_password");
            exit();
        }elseif (isset($data['token']) && $data['token'] == $token) { // check token given and stored
            // time is not expired for this reset link: create/send new password
            $new_password = $this->_random_letter().
                $this->_random_symbol().
                $this->_random_symbol().
                $this->_random_letter().
                $this->_random_number().
                $this->_random_symbol().
                $this->_random_letter().
                $this->_random_letter().
                $this->_random_number();
            $new_password = str_shuffle($new_password);

            // set new nonce and password to DB
            if ($this->renew_password_model->update_password_and_nonce(urldecode($email), $new_password)) {

                // send email
                $this->load->helper('send_email');
                $this->load->library('email', load_email_config(Settings_model::$db_config['email_protocol']));

                $this->email->from(Settings_model::$db_config['admin_email_address'], $_SERVER['HTTP_HOST']);
                $this->email->to(urldecode($email));
                $this->email->subject($this->lang->line('reset_password_subject'));
                $this->email->message($this->lang->line('email_greeting') ." ". $data['username'] . $this->lang->line('reset_password_message'). addslashes($new_password));

                $this->email->send();
                $this->session->set_flashdata('success', '<p>'. $this->lang->line('reset_password_success') .'</p>');
                redirect("login");
            }else{
                $this->session->set_flashdata('error', '<p>'. $this->lang->line('reset_password_failed_db') .'</p>');
            }
        }else{
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('reset_password_failed_token') .'</p>');
        }
        redirect("renew_password");

    }

    /**
     *
     * _random_symbol: take one random symbol
     * @return array
     *
     *
     */

    private function _random_symbol() {
        $symbol_arr = array("!", "$", ".", "[", "]", "|", "(", ")", "?", "*", "+", "{", "}", "@", "#");
        $i = rand(0, 14);
        return $symbol_arr[$i];
    }

    /**
     *
     * _random_letter: take one random letter
     * @return array
     *
     *
     */

    private function _random_letter() {
        $letter_arr = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
        $i = rand(0, 25);
        return $letter_arr[$i];
    }

    /**
     *
     * _random_number: taken one random number
     * @return array
     *
     *
     */

    private function _random_number() {
        $number_arr = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $i = rand(0, 9);
        return $number_arr[$i];
    }
    
}

/* End of file Renew_password.php */
/* Location: ./application/controllers/auth/Renew_password.php */