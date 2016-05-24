<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_offline extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    function index() {

        if (Settings_model::$db_config['disable_all']) {
            $this->quick_page_setup(Settings_model::$db_config['active_theme'], 'main', 'Site offline', 'site_offline', 'header', 'footer');
        }else{
            redirect('/');
        }

        // todo: if site setting is not true for site offline then redirect to public main page as defined in settings


    }

}

/* End of file Site_offline.php */
/* Location: ./application/controllers/Site_offline.php */