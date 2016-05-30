<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qa_evaluation extends Admin_Controller {

		public function __construct()
		{
				parent::__construct();
				// pre-load
				$this->load->helper('form');
				$this->load->library('form_validation');
				$this->load->model('adminpanel/user_evaluation_model');
				$this->load->model('adminpanel/user_evaluation_chat_model');
				$this->load->model('adminpanel/user_evaluation_form_model');
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
				$this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel',  $this->lang->line('qa_evaluation'), 'performance_report/qa_evaluation', 'header', 'footer', '');
		}

		public function qa_detail($id=0) {
				// get id
				$data = $this->user_evaluation_model->get_qa_data($id);

				if (empty($id) || empty($data)) {
						$this->quick_page_setup(Settings_model::$db_config['active_theme'], 'main', $this->lang->line('page_not_found'), 'page_not_found', 'header', 'footer');
						$this->output->set_status_header('404'); // setting header to 404
						return;
				}

				$this->ev_data = $data;
				$this->ev_chat_data = $this->user_evaluation_form_model->get_all_qa_form(array("user_evaluation_id"=>$id));

				if (!$this->ev_chat_data) {
					$this->ev_chat_data = $this->user_evaluation_form_model->get_all_qa_form(array("user_evaluation_id"=>0));

				}

				// echo $this->user_evaluation_form_model->db->last_query();exit;
				// print_r($this->ev_chat_data);exit;
				
				$this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel',  $this->lang->line('qa_evaluation'), 'performance_report/qa_evaluation_detail', 'header', 'footer', '');

		}

		public function get_report() {
			 if ( $this->input->post() ) {
					 $array = $this->input->post();
					 $array1 = array_keys($array);
					 $paging = json_decode($this->input->post('data'), true);

					 $offset = $paging['offset'];
					 $order_by = $paging['order_by'];
					 $sort_order = $paging['sort_order'];
					 $search_data = $paging['search_data'];
					 if (isset($search_data['status']) && $search_data['status'] == 'all') {
								$search_data['status'] = "";
					 }
					 $per_page = Settings_model::$db_config['members_per_page'];
					 $data = $this->user_evaluation_model->get_qa($per_page, $offset, $order_by, $sort_order, $search_data);
					 $content_data['total_rows'] = $this->user_evaluation_model->count_all_search_qa($search_data);

					 if ( $content_data['total_rows'] > 0 ) {
							 $content_data['table_data'] = !empty($data)?$data->result_array():array();
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
						$time = strtotime($val['imported_time']);
						$val['imported_time'] = date('Y/m/d', $time).'<br>'.date('h:m A', $time);
						$result[] = $val;
				}
				return $result;
		}

		public function change_status() {
				$post = $this->input->post();

				if (empty($post)) {
						die('{"status":"error"}');
				}

				$data = $this->user_evaluation_model->update(array("status"=>$post['status']), array("id"=>$post['id']));

				if ($data) {
						die('{"status":"success"}');
				}
				die('{"status":"error"}');
		}

		public function mark_delete() {
				$post = $this->input->post();

				if (empty($post)) {
						die('{"status":"error"}');
				}     
				
				$data = $this->user_evaluation_model->update(array("mark_delete"=>'Y'), array("id"=>$post['id']));

				if ($data) {
						die('{"status":"success"}');
				}
				die('{"status":"error"}');

		}

		public function delete_all() {
				$post = $this->input->post();

				if (empty($post)) {
						die('{"status":"error"}');
				}           
				$data = $this->user_evaluation_model->update(array("mark_delete"=>'Y'), "id in (".implode(",", $post['deleteall']).")");

				if ($data) {
						die('{"status":"success"}');
				}
				die('{"status":"error"}');
		}
}