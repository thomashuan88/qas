<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ops_monthly extends Admin_Controller {
    private $permission = array();

    public function __construct() {
        parent::__construct();

        if (! self::check_permissions(10)) {
            redirect("/private/no_access");
        }

        $this->permission = self::check_action(10);
        $this->load->model('adminpanel/Performance_ops_monthly_model');
        $this->load->library('MY_Permission');
    }

    public function index() {
        $content_data = array();
        ($this->permission->add == 'yes') ?  $content_data['permission']['add'] = TRUE : '';
        ($this->permission->edit == 'yes') ?  $content_data['permission']['edit'] = TRUE : '';
        ($this->permission->delete == 'yes') ?  $content_data['permission']['delete'] = TRUE : '';

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('ops_monthly'), 'performance_report/ops_monthly', 'header', 'footer', '', $content_data);
    }

    public function get_report() {
        if ( $this->input->post() ) {
            $paging = json_decode($this->input->post('data'), true);

            
            $offset = $paging['offset'];
            $order_by = $paging['order_by'];
            $sort_order = $paging['sort_order'];
            $search_data = $paging['search_data'];
            $per_page = Settings_model::$db_config['members_per_page'];

            $resultObj = $this->Performance_ops_monthly_model->get_records($per_page, $offset, $order_by, $sort_order, $search_data, 1, $this->my_permission->find_permission());

            $content_data['total_rows'] = $this->Performance_ops_monthly_model->count_confirm_records($search_data, $this->my_permission->find_permission() );

            $content_data['table_data'] = ( $resultObj != false ) ? $resultObj->result() : array();

            $content_data['offset'] = $offset;
            $content_data['per_page'] = Settings_model::$db_config['members_per_page'];

            echo json_encode($content_data, true);
        }
    }

    public function export_report() {
        $order_by = $this->uri->segment(4);
        $sort_order = $this->uri->segment(5);
        $search_data = array();
        $search_data = $this->uri->uri_to_assoc(6);

        $resultObj = $this->Performance_ops_monthly_model->get_records( 0, 0, $order_by, $sort_order, $search_data, 1, $this->my_permission->find_permission() );
        $total_rows = $this->Performance_ops_monthly_model->count_confirm_records($search_data, $this->my_permission->find_permission() );

        if ( $total_rows > 0 ) {
            $data = $resultObj->result('array');
        } else {
            die("Record is empty");
        }
        $excel = new PHPExcel();

        $num_rows = 2;
        $AL = 0;
        $ML = 0;
        $EL = 0;
        $UL = 0;
        $VW = 0;
        $FW = 0;
        $totalRow = count( $data );

        $excel->getActiveSheet()->fromArray( array('ID', 'Month', 'Username', 'AL', 'ML', 'EL', 'UL', 'VW', 'FW', 'Leader', 'Import Date', 'Import By'), NULL, 'A1');

        foreach ($data as $value) {
            $excel->getActiveSheet()->fromArray( array_values( $value ), NULL, 'A' . $num_rows);

            $AL += $value['al'];
            $ML += $value['ml'];
            $EL += $value['el'];
            $UL += $value['ul'];
            $VW += $value['vw'];
            $FW += $value['fw'];
            
            $num_rows++;
        }

        $excel->getActiveSheet()->setCellValueByColumnAndRow('1', $num_rows + 2, 'Total AL' ); 
        $excel->getActiveSheet()->setCellValueByColumnAndRow('1', $num_rows + 3, 'Total ML' ); 
        $excel->getActiveSheet()->setCellValueByColumnAndRow('1', $num_rows + 4, 'Total EL' ); 
        $excel->getActiveSheet()->setCellValueByColumnAndRow('1', $num_rows + 5, 'Total UL' ); 
        $excel->getActiveSheet()->setCellValueByColumnAndRow('1', $num_rows + 6, 'Total VW' ); 
        $excel->getActiveSheet()->setCellValueByColumnAndRow('1', $num_rows + 7, 'Total FW' ); 

        $excel->getActiveSheet()->setCellValueByColumnAndRow('2', $num_rows + 2, $AL ); 
        $excel->getActiveSheet()->setCellValueByColumnAndRow('2', $num_rows + 3, $ML ); 
        $excel->getActiveSheet()->setCellValueByColumnAndRow('2', $num_rows + 4, $EL ); 
        $excel->getActiveSheet()->setCellValueByColumnAndRow('2', $num_rows + 5, $UL ); 
        $excel->getActiveSheet()->setCellValueByColumnAndRow('2', $num_rows + 6, $VW ); 
        $excel->getActiveSheet()->setCellValueByColumnAndRow('2', $num_rows + 7, $FW ); 

        $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

        // force download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="ops_monthly-' . date("Y-m-d") . '.xls"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function get_pending() {
        if ( $this->input->post() ) {
            $paging = json_decode($this->input->post('data'), true);
            
            $offset = $paging['offset'];
            $order_by = $paging['order_by'];
            $sort_order = $paging['sort_order'];
            $search_data = $paging['search_data'];

            $per_page = Settings_model::$db_config['members_per_page'];
            $resultObj = $this->Performance_ops_monthly_model->get_records($per_page, $offset, $order_by, $sort_order, array(), 0, array() );
            $content_data['total_rows'] = $this->Performance_ops_monthly_model->count_pending_records();

            if ( $content_data['total_rows'] > 0 ) {
                $content_data['table_data'] = $resultObj->result();
            } else {
                $content_data['table_data'] = array();
            }

            $content_data['offset'] = $offset;
            $content_data['per_page'] = Settings_model::$db_config['members_per_page'];

            echo json_encode($content_data, true);
        }
    }

    public function import_report() {
        // check permission
        if($this->permission->add != 'yes') {
            echo json_encode( array( 'error' => true, 'message' => $this->lang->line('msg_no_import') ), true);
            exit();
        }
        // check pending upload exists
        $pendingNo = $this->Performance_ops_monthly_model->count_not_my_pending();
        $total_rows = $this->Performance_ops_monthly_model->count_not_current_upload();

        if ( $total_rows > 0 || $pendingNo > 0 ) {
            $pendingBy = $this->Performance_ops_monthly_model->get_pending_import_by();
            echo json_encode( array( 'error' => true, 'message' => $this->lang->line('msg_import_clear_pending') . $pendingBy[0]['import_by'] ), true);
        
        } else { // upload file
            if( isset( $_FILES['file'] ) ) {
                $spreadData = array();
                $error = false;
                
                $objPHPExcel = PHPExcel_IOFactory::load( $_FILES['file']['tmp_name'] );
                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

                $arrayCount = count($allDataInSheet); // total row
                $today = date('Y-m-d H:i:s');
                $myUsername = $this->session->userdata('username');

                for( $i = 2; $i <= $arrayCount; $i++ ) {
                    if (
                        !isset($allDataInSheet[$i]["A"]) ||
                        !isset($allDataInSheet[$i]["B"]) ||
                        !isset($allDataInSheet[$i]["C"]) ||
                        !isset($allDataInSheet[$i]["D"]) ||
                        !isset($allDataInSheet[$i]["E"]) 
                        ) {
                        die(json_encode( array('error' => true, 'message' => $this->lang->line('account_unknown_error') ),true )); 
                    }

                    $spreadData[] = array(
                        'month' => $allDataInSheet[$i]["A"],
                        'username' => $allDataInSheet[$i]["B"],
                        'AL' => $allDataInSheet[$i]["C"],
                        'ML' => $allDataInSheet[$i]["D"],
                        'EL' => $allDataInSheet[$i]["E"],
                        'UL' => $allDataInSheet[$i]["F"],
                        'VW' => $allDataInSheet[$i]["G"],
                        'FW' => $allDataInSheet[$i]["H"],
                        'leader' => $allDataInSheet[$i]["I"],
                        'import_date' => $today,
                        'import_by' => $myUsername
                    );
                }

                if ($error) {
                    echo json_encode( array('error' => true, 'message' => $this->lang->line('msg_import_invalid_filename') . $_FILES['file']['name'] . $this->lang->line('msg_import_invalid_line') . $errorLine ), true );
                } else {
                    $this->Performance_ops_monthly_model->insert_multi_records($spreadData);
                    
                    echo json_encode( array('error' => false), true );
                }
            }
        }
    }

    public function delete_report() {
        // check permission
        if($this->permission->delete != 'yes') { 
            echo json_encode( array( 'error' => true, 'message' => $this->lang->line('msg_no_delete') ), true);
            exit();
        }

        //delete record
        if ( $this->input->post() ) {
            $id = json_decode($this->input->post('data'), true);
            $recordDetails = $this->Performance_ops_monthly_model->get_single_record( $id )->result('array');

            if (  in_array( $this->session->userdata('username'), $this->my_permission->find_permission() ) ) {
                try {
                    $this->Performance_ops_monthly_model->delete_record($id);
                    echo json_encode( array('error' => false, 'message' => $this->lang->line('delete_success') ),true ); 
                } catch ( Exception $e ){
                    echo json_encode( array('error' => true, 'message' => $this->lang->line('account_unknown_error') ),true ); 
                }
            } else {
                echo json_encode( array( 'error' => true, 'message' => $this->lang->line('no_permission') ), true ); 
            }
        }
    }

    public function confirm_pending() {
        // check permission
        if( $this->permission->add != 'yes' ) {
            echo json_encode( array( 'error' => true, 'message' => $this->lang->line('msg_no_import') ), true);
            exit();
        }

        if ( $this->input->post() ) {
            $array = $this->Performance_ops_monthly_model->get_pending_import_by();

            if ( in_array( $array[0]['import_by'], $this->my_permission->find_permission() ) ) {
                try {
                    $this->Performance_ops_monthly_model->confirm_records_import();
                    echo json_encode( array( 'error' => false, 'message' => $this->lang->line('msg_success_confirm_import') ), true );
                } catch ( Exception $e ){
                    echo json_encode( array( 'error' => true, 'message' => $this->lang->line('account_unknown_error') ), true ); 
                }
            }
        }
    }

    public function delete_pending() {
        if($this->permission->delete != 'yes') {  // check permission
            echo json_encode( array( 'error' => true, 'message' => $this->lang->line('msg_no_delete') ), true);
            exit();
        } else { //delete pending record
            if ( $this->input->post() ) {
                $array = $this->Performance_ops_monthly_model->get_pending_import_by();
                
                if ( in_array( $array[0]['import_by'], $this->my_permission->find_permission() ) ) {
                    try {
                        $this->Performance_ops_monthly_model->delete_pending_records();
                        echo json_encode( array('error' => false, 'message' => $this->lang->line('delete_success') ),true );
                    } catch ( Exception $e ){
                        echo json_encode( array( 'error' => true, 'message' => $this->lang->line('account_unknown_error') ), true ); 
                    }
                } else {
                    echo json_encode( array( 'error' => true, 'message' => $this->lang->line('no_permission') ), true ); 
                }
            }
        }
    }
}