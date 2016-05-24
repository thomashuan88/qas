<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Private_Controller extends Site_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->output->set_header("HTTP/1.0 200 OK");
        $this->output->set_header("HTTP/1.1 200 OK");
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

        $this->load->helper('cookie');
        $cookie_domain = config_item('cookie_domain');

        // credentials are missing?
        if (!$this->session->userdata('logged_in') && get_cookie('unique_token') != "") {

            // check cookie data
            $this->load->model('system/set_cookies_model');
            $cookie = get_cookie('unique_token');
            $a = substr($cookie, 0, 32);
            $b = substr($cookie, 42, 74);
            $data = $this->set_cookies_model->load_session_vars($a, $b);

            if (!empty($data)) {
                // check banned and active
                if ($data->banned != 0) {
                    $this->session->set_flashdata('error', '<p>You are banned.</p>');
                    setcookie("unique_token", null, time() - 60*60*24*3, '/', $cookie_domain, false, false);
                    redirect("login");
                }elseif($data->active != 1) {
                    $this->session->set_flashdata('error', '<p>Your acount is inactive.</p>');
                    setcookie("unique_token", null, time() - 60*60*24*3, '/', $cookie_domain, false, false);
                    redirect("login");
                }

                // renew cookie
                setcookie("unique_token", get_cookie('unique_token'), time() + Settings_model::$db_config['cookie_expires'], '/', $cookie_domain, false, false);

                // set session data
                $this->session->set_userdata('logged_in', true);
                $this->session->set_userdata('user_id', $data->user_id);
                $this->session->set_userdata('username', $data->username);

                // get permissions
                $this->permissions_roles($data->user_id);

                redirect('private/'. strtolower(Settings_model::$db_config['home_page']));
            }else{
                setcookie("unique_token", null, time() - 60*60*24*3, '/', $cookie_domain, false, false);
                redirect("login");
            }

        }elseif (!$this->session->userdata('logged_in') && !get_cookie('unique_token')) {
            setcookie("unique_token", null, time() - 60*60*24*3, '/', $cookie_domain, false, false);
            redirect("login");
        }


        // get permissions when seesion is present, too but then from session in stead of query
        $this->permissions_roles($this->session->userdata('user_id'));

    }

    public function permissions_roles($user_id) {
        $this->load->model('system/rbac_model');
        self::$permissions = $this->rbac_model->get_member_permissions($user_id);
        self::$roles = $this->rbac_model->get_member_roles($user_id);
    }

}

/* End of file Private_Controller.php */
/* Location: ./application/core/Private_Controller.php */