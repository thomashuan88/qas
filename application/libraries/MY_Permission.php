<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class MY_Permission {

    public  function find_permission(){
        $CI =& get_instance();
        $CI->load->model("adminpanel/users_model");
        $username = $CI->session->userdata('username');
        $result = $CI->users_model->find_downline($username);
        $users = array();

        foreach ($result as $key => $value) {
            foreach ($value as $role => $name) {
                if(!empty($name)){
                    $users[] = $name;
                }
            }
        }
        $user_permission = array_unique($users);
        return $user_permission; 
    }
}

