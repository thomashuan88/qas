<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Header_fluid extends Site_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel-header-fluid', 'Header fluid', 'themes/header_fluid', 'header', 'footer', Settings_model::$db_config['active_theme']);
    }

}

/* End of file Header_fluid.php */
/* Location: ./application/controllers/themes/Header_fluid.php */