<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Default_page extends Site_Controller {

    public function __construct()
    {
        parent::__construct();
        redirect('themes/left_menu_fluid');
    }

    public function index() {
    }

}

/* End of file Default_page.php */
/* Location: ./application/controllers/themes/Default_page.php */