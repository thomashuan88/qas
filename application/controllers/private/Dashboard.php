<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Private_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index() {

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', 'Dashboard', 'private/dashboard', 'header', 'footer', Settings_model::$db_config['active_theme']);

    }

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/private/Dashboard.php */