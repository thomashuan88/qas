<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Permission {

	 public function __construct()
    {
        parent::__construct();
        $this->load->model('adminpanel/user_model');
    }


    public function permission($data){
    	//get session name
    
    	//check_user_permission($data)
    }

    public function check_user_permission($data){	
    //$items = array();				
    	//foreach($data as $value)
    	//user_result = select username where leader = value
    	//}

    	//$items[] = user_result;

    	//if(user_result == ""){return $items[] }else{ $this->check_user_permission(user_result) }

    }

}

