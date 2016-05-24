<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Default_page extends Site_Controller {

	public function __construct()
    {
        parent::__construct();
        redirect('adminpanel/list_members');
    }
    /**
     * Class index
     *
     */
    public function index() {
        //$this->quick_page_setup(Settings_model::$db_config['active_theme'], 'main', 'Default page', 'default_page', 'header', 'footer');
    }

}

/* End of file Default_page.php */
/* Location: ./application/controllers/Default_page.php */