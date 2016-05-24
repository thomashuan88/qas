<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Default_Page extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        redirect('adminpanel/list_members');
    }

    public function index(){} // doesn't work without this
}

/* End of file Default_page.php */
/* Location: ./application/controllers/adminpanel/Default_page.php */