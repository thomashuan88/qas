<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OAuth2 extends Auth_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function init($provider) {

        if (!$this->form_validation->alpha_numeric($provider)) {
            $this->session->set_flashdata('error', '<p>Illegal provider name</p>');
            redirect('login');
        }

        if (!Settings_model::$db_config['oauth2_enabled']) {
            $this->session->set_flashdata('error', '<p>Social login has been temporarily disabled.</p>');
            redirect('login');
        }

        $this->load->model('auth/Oauth2_model');
        $row = $this->Oauth2_model->get_provider_data($provider);

        if ($row) {
            require APPPATH . 'vendor/PHPLeague-OAuth2/autoload.php';
            $this->load->library('OAuth2/'. $provider);
            $url = $this->{strtolower($provider)}->loadProviderClass($row);
            $_SESSION[strtolower($provider) .'state'] = $this->{strtolower($provider)}->getState();
            redirect($url);
        }else{
            $this->session->set_flashdata('error', '<p>Illegal provider initiation.</p>');
            redirect('login');
        }
    }

    public function verify($provider) {

        if (!$this->form_validation->alpha_numeric($provider)) {
            $this->session->set_flashdata('error', '<p>Illegal provider name</p>');
            redirect('login');
        }

        // check site settings
        if ((Settings_model::$db_config['disable_all'] == 1)) {
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('site_disabled') .'</p>');
            redirect('login');
        }elseif(Settings_model::$db_config['login_enabled'] == 0) {
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('login_disabled') .'</p>');
            redirect('login');
        }

        // check state and cross site forgery mitigation
        if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION[strtolower($provider) .'state'])) {
            unset($_SESSION[strtolower($provider) .'state']);
            $this->session->set_flashdata('error', $this->lang->line('invalid_state'));
            redirect('login');
        }

        // only if OAuth2 enabled we allow continuing
        if (Settings_model::$db_config['oauth2_enabled']) {

            $this->load->model('auth/Oauth2_model');

            $row = $this->Oauth2_model->get_provider_data($provider);

            // no provider found - die
            if (!$row) {
                $this->session->set_flashdata('error', $this->lang->line('no_provider_found'));
                redirect('login');
            }

            // set and get providerObject
            require APPPATH . 'vendor/PHPLeague-OAuth2/autoload.php';
            $this->load->library('OAuth2/'. $provider);
            $this->{strtolower($provider)}->setProvider($row);
            $providerObject = $this->{strtolower($provider)}->getProvider();

            // Validate the token and die if not OK
            try {
                // Try to get an access token (using the authorization code grant)
                $token = $providerObject->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);
            } catch (Exception $e) {
                $this->session->set_flashdata('error', $this->lang->line('invalid_token'));
                redirect('login');
            }


            // Get profile data
            try {
                // Grab user details
                $user = $providerObject->getResourceOwner($token);

            } catch (Exception $e) {

                $this->session->set_flashdata('error', $this->lang->line('load_userdata_failed'));
                redirect('login');
            }

            // Check db for existing e-mail
            $email = $user->getEmail();

            if (empty($email)) {
                $this->session->set_flashdata('error', $this->lang->line('email_not_returned'));
                redirect('login');
            }

            $userdata = $this->Oauth2_model->get_user_by_email($email);

            if ($userdata) {

                if ($userdata->banned) {
                    $this->session->set_flashdata('error', $this->lang->line('account_is_banned'));
                    redirect('login');
                }

                if (!$userdata->active) {
                    $this->session->set_flashdata('error', $this->lang->line('oauth2_not_active'));
                    redirect('login');
                }

                // user exists - set session data and log in
                $this->session->set_userdata('logged_in', true);
                $this->session->set_userdata('user_id', $userdata->user_id);
                $this->session->set_userdata('username', $userdata->username);

                // redirect to private section
                redirect('private/'. strtolower(Settings_model::$db_config['home_page']));

            }else{
                // user does not exist: show username creation form
                $this->session->set_flashdata('provider', $provider);
                $this->session->set_flashdata('email', $email);

                $this->template->set_js('js', base_url() .'assets/js/vendor/parsley.min.js');

                // catch error if it is already set
                $this->session->set_flashdata('error', $this->session->flashdata('error'));

                $this->quick_page_setup(Settings_model::$db_config['active_theme'], 'main', 'Add username', 'auth/oauth2_user', 'header', 'footer');
            }
        }else{
            $this->session->set_flashdata('error', $this->lang->line('login_disabled'));
            redirect('login');
        }
    }


    public function finalize() {

        // only if OAuth2 enabled we allow continuing
        if (Settings_model::$db_config['oauth2_enabled']) {

            // check site settings
            if (Settings_model::$db_config['disable_all'] == 1 || Settings_model::$db_config['login_enabled'] == 0) {
                $this->session->set_flashdata('error', '<p>'. $this->lang->line('site_disabled') .'</p>');
                redirect('login');
            }

            // form input validation
            $this->form_validation->set_error_delimiters('<p>', '</p>');
            $this->form_validation->set_rules('oauth2_username', $this->lang->line('username'), 'trim|required|max_length[16]|min_length[6]|is_valid_username|is_db_cell_available[users.username]');


            // request new Object, need to reinit to get new url and state
            $this->load->model('auth/Oauth2_model');
            $row = $this->Oauth2_model->get_provider_data($this->session->flashdata('provider'));

            // build the new provider data
            if ($row) {
                require APPPATH . 'vendor/PHPLeague-OAuth2/autoload.php';
                $this->load->library('OAuth2/'. $this->session->flashdata('provider'));
                // set the new url
                $data['providers'][strtolower($this->session->flashdata('provider'))]['url'] = $this->{strtolower($this->session->flashdata('provider'))}->loadProviderClass($row);
                // renew state with updated token data
                $_SESSION[strtolower($this->session->flashdata('provider')) .'state'] = $this->{strtolower($this->session->flashdata('provider'))}->getState();
            }else{
                $this->session->set_flashdata('error', $this->lang->line('refresh_token_failed'));
                redirect('login');
            }

            // return form errors
            if (!$this->form_validation->run()) {
                $this->session->set_flashdata('error', validation_errors());
                redirect($data['providers'][strtolower($this->session->flashdata('provider'))]['url']);
            }

            $this->load->model('auth/register_model');

            $user_id = $this->register_model->create_member_oauth($this->input->post('oauth2_username'), $this->session->flashdata('email'), $this->session->flashdata('provider'));

            // create directory
            if (!file_exists(FCPATH .'assets/img/members/'. $this->input->post('oauth2_username'))) {
                mkdir(FCPATH .'assets/img/members/'. $this->input->post('oauth2_username'));
            }else{
                $this->session->set_flashdata('error', $this->lang->line('create_imgfolder_failed'));
                redirect($data['providers'][strtolower($this->session->flashdata('provider'))]['url']);
            }

            $this->load->model('system/rbac_model');
            $this->rbac_model->create_user_role(array('user_id' => $user_id, 'role_id' => 4));

            // user exists - set session data and log in
            $this->session->set_userdata('logged_in', true);
            $this->session->set_userdata('user_id', $user_id);
            $this->session->set_userdata('username', $this->input->post('oauth2_username'));

            redirect('private/'. strtolower(Settings_model::$db_config['home_page']));
        }else{
            $this->session->set_flashdata('error', $this->lang->line('login_disabled'));
            redirect('login');
        }
    }

}

/* End of file OAuth2.php */
/* Location: ./application/controllers/auth/OAuth2.php */