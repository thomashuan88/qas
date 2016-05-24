<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monthly_Qa extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        // pre-load
        // $this->load->helper('form');
        // $this->load->library('form_validation');
        $this->load->model('adminpanel/Performance_monthly_qa_model');
        // $this->load->library('pagination');
    }

    public function index() {
        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('monthly_qa'), 'performance_report/monthly_qa', 'header', 'footer');
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
            $monthlyQaObj = $this->Performance_monthly_qa_model->get_monthly_qa($per_page, $offset, $order_by, $sort_order, $search_data);
            $content_data['total_rows'] = $this->Performance_monthly_qa_model->count_all_monthly_qa($search_data);

            if ( $content_data['total_rows'] > 0 ) {
                $content_data['table_data'] = $monthlyQaObj->result();
            } else {
                $content_data['table_data'] = array();
            }

            $content_data['offset'] = $offset;
            $content_data['per_page'] = Settings_model::$db_config['members_per_page'];

            echo json_encode($content_data, true);
        }
    }

    public function import_report() {

        if( isset($_FILES['file']) ) {
            $spreadData = array();
            $error = false;
            
            $objPHPExcel = PHPExcel_IOFactory::load($_FILES['file']['tmp_name']);
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

            $arrayCount = count($allDataInSheet);  // total row
            $today = date('Y-m-d H:i:s');
            $myUsername = $this->session->userdata('username');

            for( $i = 2; $i <= $arrayCount; $i++ ) {
                $spreadData[] = array(
                        'month' => $allDataInSheet[$i]["A"],
                        'username' => $allDataInSheet[$i]["B"],
                        'typing_test' => $allDataInSheet[$i]["C"],
                        'monthly_assessment' => trim($allDataInSheet[$i]["D"], '%'),
                        'leader' => $allDataInSheet[$i]["E"],
                        'import_date' => $today,
                        'import_by' => $myUsername
                );
            }

            if ($error) {
                echo json_encode( array('error' => true, 'error_line' => $errorLine), true );
            } else {
                $this->Performance_monthly_qa_model->insert_multi_monthly_qa($spreadData);
                
                echo json_encode( array('error' => false),true );
            }

        }
    }

    public function export_report() {
        $order_by = $this->uri->segment(4);
        $sort_order = $this->uri->segment(5);
        $search_data = array();
        $search_data = $this->uri->uri_to_assoc(6);

        $monthlyQaObj = $this->Performance_monthly_qa_model->get_monthly_qa( 0, 0, $order_by, $sort_order, $search_data );
        $total_rows = $this->Performance_monthly_qa_model->count_all_monthly_qa($search_data);
        
        if ($total_rows >0) {
            $data = $monthlyQaObj->result('array');
        } else {
            die("Record is empty");
        }

        $excel = new PHPExcel();

        $num_rows = 2;
        $typing_test = 0;
        $monthly_assessment = 0;
        $totalRow = count( $data );

        $excel->getActiveSheet()->fromArray( array('ID', 'Month', 'Username', 'Typing Test', 'Monthly Assessment', 'Leader', 'Import Date', 'Import By', 'Update Date', 'Update By'), NULL, 'A1');

        foreach ($data as $value) {
            $excel->getActiveSheet()->fromArray( array_values($value), NULL, 'A' . $num_rows); 
            
            $typing_test += $value['typing_test'];
            $monthly_assessment += $value['monthly_assessment'];
            
            $num_rows++;
        }

        $excel->getActiveSheet()->setCellValueByColumnAndRow('1', $num_rows + 2, 'Average Typing Test' ); 
        $excel->getActiveSheet()->setCellValueByColumnAndRow('1', $num_rows + 3, 'Average Monthly Assessment' ); 

        $excel->getActiveSheet()->setCellValueByColumnAndRow('2', $num_rows + 2, $typing_test / $totalRow ); 
        $excel->getActiveSheet()->setCellValueByColumnAndRow('2', $num_rows + 3, $monthly_assessment / $totalRow ); 

        $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

        // force download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="monthly_qa.xls"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');

    }
    public function edit_report() {
        if ( $this->input->post() ) {
            $array = $this->input->post();
            $today = date('Y-m-d H:i:s');
            $myUsername = $this->session->userdata('username');

            try {
                $this->Performance_monthly_qa_model->edit_monthly_qa($array['record_id'], $array['month'], $array['typing_test'], $array['monthly_assessment'], $array['leader'], $today, $myUsername);
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
                $this->Performance_monthly_qa_model->delete_monthly_qa($id);
                echo json_encode( array('error' => false),true ); 
            } catch ( Exception $e ){
                echo json_encode( array('error' => true),true ); 
            }
        }
    }
}