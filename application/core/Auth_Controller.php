<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_Controller extends Site_Controller
{
    public function __construct ()
    {
        parent::__construct();

        $this->load->helper('cookie');
        
        if ($this->session->userdata('logged_in') != "" || get_cookie('unique_token') != "") {
            redirect('private/'. strtolower(Settings_model::$db_config['home_page']));
        }

    }
}

/* End of file Auth_Controller.php */
/* Location: ./application/core/Auth_Controller.php */