<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends Private_Controller
{

    public function __construct()
    {
        parent::__construct();

        // if ( !self::check_roles(array(1,2,3,5))) { // catch-all for extra protection on role level
        //     redirect("/private/no_access");
        // }
    }
}

/* End of file Admin_Controller.php */
/* Location: ./application/core/Admin_Controller.php */