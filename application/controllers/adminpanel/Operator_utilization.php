<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Operator_utilization extends Admin_Controller {
    private $permission = array();

    public function __construct() {
        parent::__construct();

        if (! self::check_permissions(13)) {
            redirect("/private/no_access");
        }

        $this->permission = self::check_action(13);
        $this->load->model('adminpanel/Performance_daily_qa_model');
        $this->load->model('adminpanel/Users_model');
        $this->load->library('MY_Permission');
    }

    public function index() {
        $content_data = array();
        $content_data['permission']['add'] = ($this->permission->add == 'yes') ?  TRUE : FALSE;
        $content_data['permission']['edit'] = ($this->permission->edit == 'yes') ?  TRUE : FALSE;
        $content_data['permission']['delete'] = ($this->permission->delete == 'yes') ?  TRUE : FALSE;

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('operator_utilization'), 'performance_report/operator_utilization', 'header', 'footer', '', $content_data);
    }

    public function get_report() {
        if ( $this->input->post() ) {
            $paging = json_decode( $this->input->post('data'), true );
            $offset = $paging['offset'];
            $order_by = $paging['order_by'];
            $sort_order = $paging['sort_order'];
            $search_data = $paging['search_data'];
            $per_page = Settings_model::$db_config['members_per_page'];

            $userSearch['username'] = ( !empty( $search_data['username'] ) ) ? $search_data['username']: '';
            $userSearch['leader'] = ( !empty( $search_data['leader'] ) ) ? $search_data['leader'] : '';

            $usersToGet = array();
            $userSearch['status'] = 'Active';
            $userSearch['role'] = Settings_model::$db_config['operator_leader_role'];
            $resultObj = $this->Users_model->get_members( 0, 0, 'username', 'asc', $userSearch, $usersToGet );

            $content_data['table_data'] = array();

            if ( $resultObj != false ) {
                $userList = $resultObj->result('array');

                $leaders = array();
                $resultArr = array();
                $finalResultArray = array();
                $usersDailyData = array();
                $totalQty = 0;
                $totalAvailableResources = 0;

                foreach ($userList as $user) {
                    $leaders[] = $user['username'];
                    $finalResultArray[ $user['username'] ] = array('leader' =>  $user['leader'], 'status' => 0); 
                }

                $startDate = ( !empty( $search_data['date_start'] ) ) ? $search_data['date_start'] : '';
                $endDate = ( !empty( $search_data['date_end'] ) ) ? $search_data['date_end'] : '';

                foreach ($leaders as $leader) {
                    $leaderQuantity = 0;
                    $directDownlineUsername = array();
                    
                    $directDownline = $this->Users_model->getDirectDownline($leader);
                    
                    if ($directDownline != false) {
                        foreach ($directDownline as $value) {
                            $directDownlineUsername[] = $value['username'];
                        }
                    }

                    if ( $directDownlineUsername != false) {
                        $usersDailyData = $this->Performance_daily_qa_model->get_record_by_users( $directDownlineUsername, $startDate , $endDate );

                        if ($usersDailyData != false) {
                            foreach ($usersDailyData as $userDailyData) {
                                $totalQty += $userDailyData['quantity'];
                                $leaderQuantity += $userDailyData['quantity'];
                            }
                            $totalAvailableResources += 1;
                            $finalResultArray[ $leader ]['status'] = 1;
                        }

                    }

                    $finalResultArray[ $leader ]['quantity'] = $leaderQuantity;
                }
                if ( $totalAvailableResources == 0 || $totalQty == 0) {
                    $averageQuantity = 0;                    
                } else {
                    $averageQuantity = $totalQty / $totalAvailableResources;
                }

                foreach ($finalResultArray as $username => $value) {
                    if ( $totalAvailableResources == 0 || $totalQty == 0) {
                        $finalResultArray[ $username ]['percentage'] = 0;
                    } else {
                        $finalResultArray[ $username ]['percentage'] = number_format( $value['quantity'] / $averageQuantity * 100, 2, '.', ',' );
                    }
                }


                // array reorder
                foreach ($finalResultArray as $key => $value) {
                    $finalResultArray[$key]['username'] = $key; 
                }

                $finalResultArray = $this->aasort($finalResultArray, $order_by);

                if ( $sort_order == 'desc') {
                    $finalResultArray = array_reverse( $finalResultArray );
                }

                $content_data['table_data'] = $finalResultArray;
            }

            // $content_data['total_rows'] = count( $resultArr );
            $content_data['offset'] = $offset;
            $content_data['per_page'] = $per_page;

            echo json_encode($content_data, true);
        }
    }

    public function get_direct_downline_report() {
        if ( $this->input->post() ) {
            $data = json_decode( $this->input->post('data'), true );
            
            $leader = $data['leader'];
            $startDate = $data['date_start'];
            $endDate = $data['date_end'];

            $directDownlineArray = array();
            $directDownline = $this->Users_model->getDirectDownline($leader);

            if ( $directDownline != false ) {
                foreach ($directDownline as $value) {
                    array_push($directDownlineArray, $value['username']);
                }

                $downlineReports = $this->Performance_daily_qa_model->get_record_by_users( $directDownlineArray, $startDate , $endDate );
                if ( $downlineReports != false ) {

                    echo json_encode( array('error' => false, 'status' => true, 'message' => $downlineReports), true);
                    
                } else { // no downline reports
                    echo json_encode( array('error' => false, 'status' => false, 'message' => $this->lang->line('msg_no_downline_report') ), true);
                }

            } else { // no downline
                echo json_encode( array('error' => false, 'status' => false, 'message' => $this->lang->line('msg_no_downline') ), true);
                
            }
        }
    }

    // array sorting
    function aasort (&$array, $key) {
        $sorter=array();
        $ret=array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii]=$va[$key];
        }
        asort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii]=$array[$ii];
        }
        $array=$ret;
        return $array;
    }

}