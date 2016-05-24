<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends MY_Controller {


    public function __construct()
    {
        parent::__construct();
      
    }

    public function index() {
        $this->session->sess_destroy();
        $this->load->helper('cookie');
        delete_cookie('unique_token');
        redirect('login');
    }

}

/* End of file Logout.php */
/* Location: ./application/controllers/auth/Logout.php */