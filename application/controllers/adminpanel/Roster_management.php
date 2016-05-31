<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roster_management extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        if (! self::check_permissions(21)) {
            redirect("/private/no_access");
        }

        $this->load->model('adminpanel/roster_management_model');
        $this->load->model('adminpanel/users_model');
        $this->load->model('adminpanel/system_settings_model');
    }

    public function index() {
        $content_data = array();
        $action_result = self::check_action(21);
        ($action_result->add == 'yes') ?  $content_data['scheduler'] = TRUE : $content_data['scheduler'] = FALSE;
        $content_data['dow_arr'] = $this->lang->line('day_of_week_short');

        //select from system setting table
        //time and shifts
        $result_shift_raw = $this->system_settings_model->get_shift();
        $result_shift = $result_shift_raw->result('array');
        if(!empty($result_shift)){
            foreach($result_shift AS $key=>$val){
                $content_data['shift'][$val['key']] = $val['value'];
            }
        }else{
            $content_data['shift'] = array('Morning'=>'07:00', 'Afternoon'=>'14:00', 'Night'=>'22:30', 'Normal'=>'11:00'); 
        }

        //select users
        $alluserdata = $this->users_model->get_all_member();
        $pairdata = array();
        foreach($alluserdata AS $k=>$v){
            $pairdata[$v['role']][] = $v['username'];
        }
        //log_message('error', print_r($pairdata,true));
        $content_data['role'] = $pairdata;

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('roster'), 'roster_page', 'header', 'footer', '', $content_data);
    }

    public function get_roster(){
        $postData = $this->input->post();
        (isset($postData['schedule_month'])) ? $search_month = $postData['schedule_month'] : $search_month = "";
        //log_message('error', $search_month."-month");
        $result = $this->select_shift($search_month, $this->session->userdata('username'));
        (empty($result)) ? $content_data['data'] = '' : $content_data['data'] = $result;

        if(empty($result)){
            $content_data['data']['success'] = FALSE;
            $content_data['data']['result'] = '';
        }else{
            $content_data['data']['success'] = TRUE;
            $content_data['data']['result'] = $result;
        }

        //set table structure
        $content_data['table_structure']['shift_per_day'] = "3"; 
        $content_data['table_structure']['leader_per_shift'] = "1"; 
        $content_data['table_structure']['senior_per_shift'] = "1"; 
        $content_data['table_structure']['cs_per_shift'] = "7";

        //select from system setting table
        //time and shifts
        $result_shift_raw = $this->system_settings_model->get_shift();
        $result_shift = $result_shift_raw->result('array');
        //log_message('error', print_r($result_shift,true));
        if(!empty($result_shift)){
            foreach($result_shift AS $key=>$val){
                $content_data['table_structure']['shift'][$val['key']] = $val['value'];
            }
        }else{
            $content_data['table_structure']['shift'] = array('Morning'=>'07:00', 'Afternoon'=>'14:00', 'Night'=>'22:30', 'Normal'=>'11:00'); 
        }


        $offdays['admin'][1] = array(
                                    'on', //sunday
                                    'on', //monday
                                    'on', //tuesday
                                    'on', //wednesday
                                    'on', //thursday
                                    'off', //friday
                                    'off' //saturday
                                );
        $offdays['admin'][2] = array(
                                    'off', //sunday
                                    'off', //monday
                                    'on', //tuesday
                                    'on', //wednesday
                                    'on', //thursday
                                    'on', //friday
                                    'on' //saturday
                                );
        $offdays['admin'][3] = array(
                                    'off', //sunday
                                    'on', //monday
                                    'on', //tuesday
                                    'on', //wednesday
                                    'on', //thursday
                                    'on', //friday
                                    'off' //saturday
                                );
        $offdays['admin'][4] = array(
                                    'off', //sunday
                                    'on', //monday
                                    'on', //tuesday
                                    'on', //wednesday
                                    'on', //thursday
                                    'on', //friday
                                    'off' //saturday
                                );

        $offdays['leader'][1] = array(
                                    'on', //sunday
                                    'on', //monday
                                    'on', //tuesday
                                    'off', //wednesday
                                    'off', //thursday
                                    'on', //friday
                                    'on' //saturday
                                );
        $offdays['leader'][2] = array(
                                    'on', //sunday
                                    'off', //monday
                                    'off', //tuesday
                                    'on', //wednesday
                                    'on', //thursday
                                    'on', //friday
                                    'on' //saturday
                                );
        $offdays['leader'][3] = array(
                                    'on', //sunday
                                    'on', //monday
                                    'on', //tuesday
                                    'on', //wednesday
                                    'on', //thursday
                                    'off', //friday
                                    'off' //saturday
                                );

        $offdays['senior'][1] = array(
                                    'off', //sunday
                                    'on', //monday
                                    'on', //tuesday
                                    'on', //wednesday
                                    'on', //thursday
                                    'on', //friday
                                    'off' //saturday
                                );
        $offdays['senior'][2] = array(
                                    'on', //sunday
                                    'on', //monday
                                    'on', //tuesday
                                    'on', //wednesday
                                    'off', //thursday
                                    'off', //friday
                                    'on' //saturday
                                );
        $offdays['senior'][3] = array(
                                    'on', //sunday
                                    'off', //monday
                                    'off', //tuesday
                                    'on', //wednesday
                                    'on', //thursday
                                    'on', //friday
                                    'on' //saturday
                                );

        $offdays['cs'][1] = array(
                                    'off', //sunday
                                    'off', //monday
                                    'on', //tuesday
                                    'on', //wednesday
                                    'on', //thursday
                                    'on', //friday
                                    'on' //saturday
                                );
        $offdays['cs'][2] = array(
                                    'off', //sunday
                                    'on', //monday
                                    'on', //tuesday
                                    'on', //wednesday
                                    'on', //thursday
                                    'on', //friday
                                    'off' //saturday
                                );
        $offdays['cs'][3] = array(
                                    'on', //sunday
                                    'on', //monday
                                    'on', //tuesday
                                    'on', //wednesday
                                    'on', //thursday
                                    'off', //friday
                                    'off' //saturday
                                );
        $offdays['cs'][4] = array(
                                    'on', //sunday
                                    'on', //monday
                                    'on', //tuesday
                                    'on', //wednesday
                                    'off', //thursday
                                    'off', //friday
                                    'on' //saturday
                                );
        $offdays['cs'][5] = array(
                                    'on', //sunday
                                    'on', //monday
                                    'on', //tuesday
                                    'off', //wednesday
                                    'off', //thursday
                                    'on', //friday
                                    'on' //saturday
                                );
        $offdays['cs'][6] = array(
                                    'on', //sunday
                                    'on', //monday
                                    'off', //tuesday
                                    'off', //wednesday
                                    'on', //thursday
                                    'on', //friday
                                    'on' //saturday
                                );
        $offdays['cs'][7] = array(
                                    'on', //sunday
                                    'off', //monday
                                    'off', //tuesday
                                    'on', //wednesday
                                    'on', //thursday
                                    'on', //friday
                                    'on' //saturday
                                );

        $content_data['offdays'] = $offdays;
        //log_message('error', print_r($content_data,true));
        echo json_encode($content_data);
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