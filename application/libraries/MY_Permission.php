<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class MY_Permission {
    private $response = array();

    public  function find_permission(){
        $CI =& get_instance();
        $username = $CI->session->userdata('username');
        $response = $this->check_user_permission($username);
    }

    public function check_user_permission($username){	
        $CI =& get_instance();
        $CI->load->model("adminpanel/users_model");
        $arr = array();
        //$response = array();
        $data = array();

        if(gettype($username) == "string"){
            array_push($data, $username);
        }elseif(gettype($username) == "array"){
            $data = $username;
        }

        //log_message("error",print_r($data,true));

        foreach($data as $value){
            //log_message("error",$value."--value");
            $result = $CI->users_model->find_downline($value);
            //log_message("error",print_r($result,true));
            foreach($result as $val){
               $arr[$value][] = $val['username'];
            }

            log_message("error",print_r($arr,true));
            if(isset($arr[$value]) AND empty($arr[$value])){
                //log_message("error",print_r($arr,true));
                return $arr;
            }else{
                $response = $this->check_user_permission($arr[$value]);
                //log_message("error",$response."---+++");
                $result = array_merge($arr, $response);
            }
          
        }  //log_message("error",print_r($result,true)."sdfdsfs");
       //      foreach ($arr[$username] as $val) {

       //          
       //          $response[] = $this->check_user_permission($val);
       //          log_message("error",print_r($response,true)."response");
       //          //$result = array_merge($arr, $response);
       //      }
       //  }
        
           
     } 


        
    //$items = array();				
    	//foreach($data as $value)
    	//user_result = select username where leader = value
    	//}

    	//$items[] = user_result;

    	//if(user_result == ""){return $items[] }else{ $this->check_user_permission(user_result) }

    

}

