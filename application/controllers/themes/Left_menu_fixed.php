<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Left_menu_fixed extends Site_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel-fixed', 'Left menu fixed', 'themes/left_menu_fixed', 'header', 'footer', Settings_model::$db_config['active_theme']);
    }

}

/* End of file Left_menu_fixed.php */
/* Location: ./application/controllers/themes/Left_menu_fixed.php */