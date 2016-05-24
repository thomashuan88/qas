<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_settings extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('encrypt');
        $this->load->library('form_validation');
    }

    public function index() {

        if (! self::check_permissions(3)) {
            redirect("/private/no_access");
        }

        $content_data['private_pages'] = $this->_load_private_pages();
        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('site_settings'), 'site_settings', 'header', 'footer', '', $content_data);
    }

    private function _load_private_pages() {
        if ($handle = opendir(APPPATH. 'controllers/private')) {
            $pages = array();
            while (false !== ($file = readdir($handle))) {
                $last_four = substr($file, -4);
                $newfile = str_replace(".php", "", $file);
                if ($last_four == ".php") {
                    $pages[$newfile] = strtolower(str_replace("_", " ", $newfile));
                }
            }

            closedir($handle);
            return $pages;
        }

        return false;
    }

    /**
     *
     * update_settings: update settings from adminpanel
     *
     *
     */

    public function update_settings() {
        if (! self::check_permissions(11)) {
            redirect('/adminpanel/site_settings');
        }

        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('site_title', $this->lang->line('site_title'), 'trim|required');
        $this->form_validation->set_rules('members_per_page', 'members per page', 'trim|required|numeric');
        $this->form_validation->set_rules('admin_email', 'admin e-mail', 'trim|required|max_length[255]|is_valid_email');
        $this->form_validation->set_rules('home_page', 'home page', 'trim|required');
        $this->form_validation->set_rules('active_theme', 'active theme', 'trim|required');
        $this->form_validation->set_rules('adminpanel_theme', 'adminpanel theme', 'trim|required');
        $this->form_validation->set_rules('login_attempts', 'login attempts', 'trim|required|numeric');
        $this->form_validation->set_rules('max_login_attempts', 'maximum login attempts', 'trim|required|numeric');
        $this->form_validation->set_rules('sendmail_path', 'sendmail path', 'trim');
        $this->form_validation->set_rules('email_protocol', 'email protocol', 'trim');
        $this->form_validation->set_rules('smtp_host', 'smtp host', 'trim');
        $this->form_validation->set_rules('smtp_port', 'smtp port', 'trim');
        $this->form_validation->set_rules('smtp_user', 'smtp user', 'trim');
        $this->form_validation->set_rules('smtp_pass', 'smtp pass', 'trim');
        $this->form_validation->set_rules('cookie_expires', 'cookie expires', 'trim|required|numeric');
        $this->form_validation->set_rules('password_link_expires', 'password link expires', 'trim|required|numeric');
        $this->form_validation->set_rules('activation_link_expires', 'activation link expires', 'trim|required|numeric');
        $this->form_validation->set_rules('site_disabled_text', 'site disabled text', 'trim');
        $this->form_validation->set_rules('recaptchav2_site_key', 'recaptchav2_site_key', 'trim');
        $this->form_validation->set_rules('recaptchav2_secret', 'recaptchav2_secret', 'trim');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('/adminpanel/site_settings');
            exit();
        }

        $active_theme = FALSE;
        $list = glob(APPPATH .'views/themes/'. $this->input->post('active_theme') .'/layouts/*.php');
        if (!empty($list)) {
            $active_theme = TRUE;
        }else{
            $this->session->set_flashdata('error', '<p>'. sprintf($this->lang->line('main_not_found'), $this->input->post('active_theme')) .'</p>');
            redirect('/adminpanel/site_settings');
            exit();
        }

        $adminpanel_theme = FALSE;
        if (file_exists(APPPATH .'views/themes/'. $this->input->post('adminpanel_theme') .'/layouts/adminpanel.php')) {
            $active_theme = TRUE;
        }else{
            $this->session->set_flashdata('error', '<p>'. sprintf($this->lang->line('main_not_found'), $this->input->post('adminpanel_theme')) .'</p>');
            redirect('/adminpanel/site_settings');
            exit();
        }

        $home_page = FALSE;
        if (file_exists(APPPATH .'controllers/private/'. $this->input->post('home_page') .'.php')) {
            $home_page = TRUE;
        }else{
            $this->session->set_flashdata('error', '<p>'. sprintf($this->lang->line('controller_not_found'), $this->input->post('home_page')) .'</p>');
            redirect('/adminpanel/site_settings');
            exit();
        }

        // delete cache before prepping and inserting data
        $this->cache->delete('settings');

        $data = array(
            'site_title' => $this->input->post('site_title'),
            'login_enabled' => ($this->input->post('login_enabled') == "" ? 1 : 0),
            'register_enabled' => ($this->input->post('register_enabled') == "" ? 1 : 0),
            'install_enabled' => ($this->input->post('install_enabled') == "" ? 0 : 1),
            'members_per_page' => ($this->input->post('members_per_page') > 0 ? $this->input->post('members_per_page') : 10),
            'admin_email' => $this->input->post('admin_email'),
            'home_page' => ($home_page == TRUE ? $this->input->post('home_page') : strtolower(Settings_model::$db_config['home_page'])),
            'active_theme' => ($active_theme == TRUE ? $this->input->post('active_theme') : Settings_model::$db_config['active_theme']),
            'adminpanel_theme' => ($adminpanel_theme == TRUE ? $this->input->post('adminpanel_theme') : Settings_model::$db_config['adminpanel_theme']),
            'login_attempts' => $this->input->post('login_attempts'),
            'max_login_attempts' => $this->input->post('max_login_attempts'),
            'email_protocol' => $this->input->post('email_protocol'),
            'sendmail_path' => $this->input->post('sendmail_path'),
            'smtp_host' => $this->input->post('smtp_host'),
            'smtp_port' => $this->input->post('smtp_port'),
            'smtp_user' => $this->encrypt->encode($this->input->post('smtp_user')),
            'smtp_pass' => $this->encrypt->encode($this->input->post('smtp_pass')),
            'cookie_expires' => $this->input->post('cookie_expires'),
            'password_link_expires' => $this->input->post('password_link_expires'),
            'activation_link_expires' => $this->input->post('activation_link_expires'),
            'disable_all' => ($this->input->post('disable_all') == "" ? 0 : 1),
            'site_disabled_text' => $this->input->post('site_disabled_text'),
            'remember_me_enabled' => ($this->input->post('remember_me_enabled') != "" ? true : false),
            'recaptchav2_enabled' => ($this->input->post('recaptchav2_enabled') != "" ? true : false),
            'recaptchav2_site_key' => $this->input->post('recaptchav2_site_key'),
            'recaptchav2_secret' => $this->input->post('recaptchav2_secret'),
            'oauth2_enabled' => ($this->input->post('oauth2_enabled') == "" ? 0 : 1)
        );

        $this->load->model('adminpanel/site_settings_model');
        if ($this->site_settings_model->save_settings($data)) {
            $this->session->set_flashdata('success', '<p>'. $this->lang->line('settings_update') .'</p>');
            //unlink(APPPATH .'cache/settings.cache');
            $this->load->library('cache');
            $this->cache->delete('settings');
        }

        redirect('/adminpanel/site_settings');
    }

    public function clear_sessions() {
        if (! self::check_permissions(12)) {
            redirect('/adminpanel/site_settings');
        }
        $this->load->model('adminpanel/site_settings_model');
        if ($this->site_settings_model->clear_sessions()) {
            $this->session->set_flashdata('sessions_message', '<p>'. $this->lang->line('sessions_cleared') .'</p>');
        }else{
            $this->session->set_flashdata('sessions_message', '<p>'. $this->lang->line('sessions_not_cleared') .'</p>');
        }

        redirect('/adminpanel/site_settings#clear_sessions');
    }

}

/* End of file Site_settings.php */
/* Location: ./application/controllers/adminpanel/Site_settings.php */