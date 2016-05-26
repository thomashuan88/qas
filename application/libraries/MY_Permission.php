<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class MY_Permission {
    private $response = array();

    public  function find_permission(){
        $CI =& get_instance();
        $CI->load->model("adminpanel/users_model");
        $username = "administrator";
        $result = $CI->users_model->find_downline($username);
        $arr = array();

        foreach ($result as $key => $value) {

            foreach ($value as $role => $name) {
               
                if($name != "" && $name != $username){
                    $arr[] = $name;
                }
            }
        }
        $arr2[$username] = array_unique($arr);
        return $arr2; 
    }
}

