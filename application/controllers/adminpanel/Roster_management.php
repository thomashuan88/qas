<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roster_management extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        if (! self::check_permissions(21)) {
            redirect("/private/no_access");
        }

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('adminpanel/roster_management_model');
        $this->load->model('adminpanel/users_model');
    }

    public function index() {
        $content_data = array();
        //$username = $this->session->userdata['username'];
        //$userid = $this->session->userdata['user_id'];
        //$userdata = $this->users_model->get_member_data($userid);

        //$content_data['userdata'] = $userdata;
        $action_result = self::check_action(21);
        ($action_result->add == 'yes') ?  $content_data['scheduler'] = TRUE : $content_data['scheduler'] = FALSE;
        
        $result = $this->select_shift();
        $result = array();
        //log_message('error', print_r($result,true));
        $content_data['dow_arr'] = $this->lang->line('day_of_week_short');
        (empty($result)) ? $content_data['data'] = '' : $content_data['data'] = $result;

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('roster'), 'roster', 'header', 'footer', '', $content_data);
    }

    public function set_roster_page() {
        $action_result = self::check_action(21);
        ($action_result->add != 'yes') ?  redirect("/private/no_access") : "";

        $content_data = array();
        //$username = $this->session->userdata['username'];
        //$user_id = $this->session->userdata['user_id'];
        $alluserdata = $this->users_model->get_all_member();
        //log_message('error', print_r($alluserdata,true));
        if(!empty($alluserdata)){
            $pairdata = array();
            foreach($alluserdata AS $k=>$v){
                $pairdata[$v['username']] = $v['leader'];
            }

            $flat = array();
            $tree = array();

            foreach ($pairdata AS $child => $parent) {
                if (!isset($flat[$child])) {
                    $flat[$child] = array();
                }
                if (!empty($parent)) {
                    $flat[$parent][$child] =& $flat[$child];
                } else {
                    $tree[$child] =& $flat[$child];
                    //$new_array[] = $flat[$child];
                }
            }
            log_message('error', print_r($tree,true));
            //log_message('error', print_r($new_array,true));
            //$result_rec = $this->traverseArray($tree);
            //log_message('error', print_r($result_rec,true));

            $content_data['active_member'] = $tree;
        }else{
            $content_data['active_member'] = "";
        }
        //$content_data['active_member'] = $alluserdata;

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('roster_management'), 'roster_management', 'header', 'footer', '', $content_data);
    }

    public function set_roster() {
        $action_result = self::check_action(21);
        ($action_result->add != 'yes') ?  redirect("/private/no_access") : "";
    }


    private function select_shift($date=''){
        ($date == '') ? $today = strtotime(date('Y-m-d')) : $today = strtotime($date);

        $first_day = date('Y-m-01', $today);
        $last_day = date('Y-m-t', $today);

        $search_data['from'] = $first_day;
        $search_data['to'] = $last_day;

        $result = $this->roster_management_model->get_shift($search_data);

        return $result;
    }

    // Recursively traverses a multi-dimensional array.
    private function traverseArray($array){
        // Loops through each element. If element again is array, function is recalled. If not, result is echoed.
        foreach($array as $key=>$value){ 
            if(is_array($value)){ 
                log_message('error', $key."<br />\n");
                $this->traverseArray($value); 
            }else{
                log_message('error', $key." = ".$value."<br />\n"); 
            }
        }
    }
}

/* End of file Roster_management.php */
/* Location: ./application/controllers/adminpanel/Roster_management.php */