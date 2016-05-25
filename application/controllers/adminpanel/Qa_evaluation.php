<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qa_evaluation extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        // pre-load
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('adminpanel/user_evaluation_model');
        $this->load->model('adminpanel/users_model');

    }

    /**
     *
     * index: main function with search and pagination built into it
     *
     * @param int|string $order_by order by this data column
     * @param string $sort_order asc or desc
     * @param string $search search type, used in index to determine what to display
     * @param int $offset the offset to be used for selecting data
     */

    public function index() {
        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel',  $this->lang->line('user_listing'), 'performance_report/qa_evaluation', 'header', 'footer', '');
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
           $data = $this->user_evaluation_model->get_qa($per_page, $offset, $order_by, $sort_order, $search_data);
           $content_data['total_rows'] = $this->user_evaluation_model->count_all_search_qa($search_data);

           if ( $content_data['total_rows'] > 0 ) {
               $content_data['table_data'] = $data->result_array();
               $content_data['table_data'] = $this->filter_data($content_data['table_data']);

           } else {
               $content_data['table_data'] = array();
           }

           $content_data['total_rows'] = $this->user_evaluation_model->count_all_search_qa($search_data);
           $content_data['offset'] = $offset;
           $content_data['per_page'] = Settings_model::$db_config['members_per_page'];
           echo json_encode($content_data, true);

       }
    }

    public function filter_data($data=array()) {
        $result = array();
        foreach ($data as $key => $val) {
            $val['imported_time'] = date('Y/m/d', strtotime($val['imported_time'])).'<br>'.date('h:m A', strtotime($val['imported_time']));
            $result[] = $val;
        }
        return $result;
    }
}