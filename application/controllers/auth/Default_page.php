<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Default_page extends Auth_Controller {

    // is needed for usage: example.com/auth/ without anything after it

    public function __construct()
    {
        parent::__construct();
        redirect('login');
    }

    public function index() {}

}

/* End of file Default_page.php */
/* Location: ./application/controllers/auth/Default_page.php */