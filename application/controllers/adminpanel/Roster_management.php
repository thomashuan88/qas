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
        $action_result = self::check_action(21);
        ($action_result->add == 'yes') ?  $content_data['scheduler'] = TRUE : $content_data['scheduler'] = FALSE;
        //$postData = $this->input->post();
        //(isset($postData['schedule_month'])) ? $search_month = $postData['schedule_month'] : $search_month = "";
        //$result = $this->select_shift($search_month);
        //$result = array();
        $content_data['dow_arr'] = $this->lang->line('day_of_week_short');
        //(empty($result)) ? $content_data['data'] = '' : $content_data['data'] = $result;

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('roster'), 'roster_page', 'header', 'footer', '', $content_data);
    }

    public function get_roster(){
        $postData = $this->input->post();
        (isset($postData['schedule_month'])) ? $search_month = $postData['schedule_month'] : $search_month = "";
        //log_message('error', $search_month."-month");
        $result = $this->select_shift($search_month, $this->session->userdata('username'));
        (empty($result)) ? $content_data['data'] = '' : $content_data['data'] = $result;
        log_message('error', print_r($result,true));
        //set table structure
        $content_data['table_structure']['day_per_shift'] = "2"; 
        $content_data['table_structure']['leader_per_shift'] = "1"; 
        $content_data['table_structure']['senior_per_shift'] = "1"; 
        $content_data['table_structure']['cs_per_shift'] = "7";

        //select from system setting table
        //time and shifts
        $content_data['table_structure']['shift'] = array('Morning'=>'07:00', 'Noon'=>'14:00','Night'=>'22:30','Normal'=>'11:00',); 
        $content_data['table_structure']['cs_per_shift'] = "7";

        return $content_data;
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

            // foreach ($pairdata AS $child => $parent) {
            //     if (!isset($flat[$child])) {
            //         $flat[$child] = array();
            //     }
            //     if (!empty($parent)) {
            //         $flat[$parent][$child] =& $flat[$child];
            //     } else {
            //         $tree[$child] =& $flat[$child];
            //         //$new_array[] = $flat[$child];
            //     }
            // }

            //log_message('error', print_r($tree,true));
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


    private function select_shift($date='', $username){
        if($date == ''){
            $today = strtotime(date('Y-m-d'));
        }else{
            $date_arr = explode("/", $date);
            $date = "01-".$date_arr[0]."-".$date_arr[1];
            $today = strtotime($date);
        }

        $first_day = date('Y-m-01', $today);
        $last_day = date('Y-m-t', $today);

        $search_data['from'] = $first_day;
        $search_data['to'] = $last_day;

        $result = $this->roster_management_model->get_shift($search_data);

        return $result;
    }

}

/* End of file Roster_management.php */
/* Location: ./application/controllers/adminpanel/Roster_management.php */