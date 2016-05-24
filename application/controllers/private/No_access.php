<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class No_access extends Private_Controller {

    public function __construct ()
    {
        parent::__construct();
    }

    public function index() {
        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('no_access'), 'private/no_access', 'header', 'footer', Settings_model::$db_config['active_theme']);
    }
}

/* End of file No_access.php */
/* Location: ./application/controllers/private/No_access.php */