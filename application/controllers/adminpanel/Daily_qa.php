<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Daily_Qa extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        // pre-load
        // $this->load->helper('form');
        // $this->load->library('form_validation');
        $this->load->model('adminpanel/Performance_daily_qa_model');
        // $this->load->library('pagination');
    }

    public function index() {
        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('daily_qa'), 'performance_report/daily_qa', 'header', 'footer');
    }

    public function get_report() {
        if ( $this->input->post() ) {
            $array = $this->input->post();
            $array1 = array_keys($array);
            $paging = json_decode($array1[0], true);
            
            $offset = $paging['offset'];
            $order_by = $paging['order_by'];
            $sort_order = $paging['sort_order'];
            $search_data = $paging['search_data'];

            $per_page = Settings_model::$db_config['members_per_page'];
            $dailyQaObj = $this->Performance_daily_qa_model->get_daily_qa($per_page, $offset, $order_by, $sort_order, $search_data, 1);
            $content_data['total_rows'] = $this->Performance_daily_qa_model->count_confirm_daily_qa($search_data);

            $content_data['table_data'] = ( $dailyQaObj != false ) ? $dailyQaObj->result() : array();

            $content_data['offset'] = $offset;
            $content_data['per_page'] = Settings_model::$db_config['members_per_page'];

            echo json_encode($content_data, true);
        }
    }

    public function pending_list() {
        $dailyQaObj = $this->Performance_daily_qa_model->pending_list();

        $pendingList = ( $dailyQaObj != false ) ? $dailyQaObj->result('array') : array();

        if ( $this->input->is_ajax_request() ) {
            echo json_encode($pendingList, true);
        } else {
            return $pendingList;    
        }
    }

    public function get_pending() {
        if ( $this->input->post() ) {
            $array = $this->input->post();
            $array1 = array_keys($array);
            $paging = json_decode($array1[0], true);
            
            $offset = $paging['offset'];
            $order_by = $paging['order_by'];
            $sort_order = $paging['sort_order'];
            $search_data = $paging['search_data'];

            $per_page = Settings_model::$db_config['members_per_page'];
            $dailyQaObj = $this->Performance_daily_qa_model->get_daily_qa($per_page, $offset, $order_by, $sort_order, $search_data, 0);
            $content_data['total_rows'] = $this->Performance_daily_qa_model->count_pending_daily_qa($search_data);

            if ( $content_data['total_rows'] > 0 ) {
                $content_data['table_data'] = $dailyQaObj->result();
            } else {
                $content_data['table_data'] = array();
            }

            $content_data['offset'] = $offset;
            $content_data['per_page'] = Settings_model::$db_config['members_per_page'];

            echo json_encode($content_data, true);
        }
    }

    public function confirm_pending() {
        if ( $this->input->post() ) {
            $arr = $this->input->post();

            try {
                $this->Performance_daily_qa_model->confirm_dailyqa_import($arr['import_by']);

                echo json_encode( array('error' => false), true );

            } catch ( Exception $e ){
                echo json_encode( array('error' => true), true ); 
            }
        }
    }

    public function import_report() {

        if( isset($_FILES['file']) ) {
            $spreadData = array();
            $error = false;
            
            $objPHPExcel = PHPExcel_IOFactory::load($_FILES['file']['tmp_name']);
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

            $arrayCount = count($allDataInSheet); // total row
            $today = date('Y-m-d H:i:s');
            $myUsername = $this->session->userdata('username');

            for( $i = 2; $i <= $arrayCount; $i++ ) {

                if (
                    !preg_match( "/^\S{6,}$/", $allDataInSheet[$i]["A"] ) ||
                    !is_numeric( $allDataInSheet[$i]["B"] ) ||
                    !is_numeric( $allDataInSheet[$i]["C"] ) ||
                    !is_numeric( trim( $allDataInSheet[$i]["D"] , '%') ) ||
                    !preg_match( "/^\d+:\d{2}:\d{2}$/", $allDataInSheet[$i]["E"] ) ||
                    !preg_match( "/^\d+:\d{2}:\d{2}$/", $allDataInSheet[$i]["F"] ) ||
                    !is_numeric( $allDataInSheet[$i]["G"] )
                    ) {

                    $error = true;
                    $errorLine = $i;

                    break;
                }

                $spreadData[] = array(
                        'username' => $allDataInSheet[$i]["A"],
                        'yes' => $allDataInSheet[$i]["B"],
                        'no' => $allDataInSheet[$i]["C"],
                        'csi' => trim($allDataInSheet[$i]["D"], '%'),
                        'art' => $allDataInSheet[$i]["E"],
                        'aht' => $allDataInSheet[$i]["F"],
                        'quantity' => $allDataInSheet[$i]["G"],
                        'import_date' => $today,
                        'import_by' => $myUsername
                );
            }

            if ($error) {
                echo json_encode( array('error' => true, 'error_line' => $errorLine), true );
            } else {
                $this->Performance_daily_qa_model->insert_multi_daily_qa($spreadData);
                
                echo json_encode( array('error' => false),true );
            }

        }
    }

    public function export_report() {
        $order_by = $this->uri->segment(4);
        $sort_order = $this->uri->segment(5);
        $search_data = array();
        $search_data = $this->uri->uri_to_assoc(6);

        $dailyQaObj = $this->Performance_daily_qa_model->get_daily_qa( 0, 0, $order_by, $sort_order, $search_data );
        $total_rows = $this->Performance_daily_qa_model->count_all_daily_qa($search_data);

        if ($total_rows >0) {
            $data = $dailyQaObj->result('array');
        } else {
            die("Record is empty");
        }
        $excel = new PHPExcel();

        $num_rows = 2;
        $csi = 0;
        $art = array();
        $aht = array();
        $totalRow = count( $data );

        $excel->getActiveSheet()->fromArray( array('ID', 'Username', 'Yes', 'No', 'CSI', 'ART', 'AHT', 'Quantity', 'Import Date', 'Import By', 'Update Date', 'Update By'), NULL, 'A1');

        foreach ($data as $value) {
            $excel->getActiveSheet()->fromArray( array_values($value), NULL, 'A' . $num_rows); 
            
            $csi += $value['csi'];
            $art[] = $value['art'];
            $aht[] = $value['aht'];
            
            $num_rows++;
        }

        $excel->getActiveSheet()->getStyle('F2:F'.$num_rows)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME6);

        $this->load->helper('get_average_time');

        $totalArt = get_average_time($art);
        $totalAht = get_average_time($aht);

        $excel->getActiveSheet()->setCellValueByColumnAndRow('1', $num_rows + 2, 'Average CSI' ); 
        $excel->getActiveSheet()->setCellValueByColumnAndRow('1', $num_rows + 3, 'Average ART' ); 
        $excel->getActiveSheet()->setCellValueByColumnAndRow('1', $num_rows + 4, 'Average AHT' ); 

        $excel->getActiveSheet()->setCellValueByColumnAndRow('2', $num_rows + 2, $csi / $totalRow ); 
        $excel->getActiveSheet()->setCellValueByColumnAndRow('2', $num_rows + 3, $totalArt ); 
        $excel->getActiveSheet()->setCellValueByColumnAndRow('2', $num_rows + 4, $totalAht ); 

        $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

        // force download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="daily_qa.xls"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
    
    public function edit_report() {
        if ( $this->input->post() ) {
            $array = $this->input->post();
            $today = date('Y-m-d H:i:s');
            $myUsername = $this->session->userdata('username');

            try {
                $this->Performance_daily_qa_model->edit_daily_qa($array['record_id'], $array['yes'], $array['no'], $array['csi'], $array['art'], $array['aht'], $array['quantity'], $today, $myUsername);
                echo json_encode( array('error' => false),true ); 
            } catch ( Exception $e ){
                echo json_encode( array('error' => true),true ); 
            }
        }
    }

    public function delete_report() {
        if ( $this->input->post() ) {
            $array = $this->input->post();
            $array1 = array_keys($array);
            $id = json_decode($array1[0], true);

            try {
                $this->Performance_daily_qa_model->delete_daily_qa($id);
                echo json_encode( array('error' => false),true ); 
            } catch ( Exception $e ){
                echo json_encode( array('error' => true),true ); 
            }
        }
    }
}