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
				$this->load->model('adminpanel/system_settings_model');

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

	    public function import_chat() {
	        // check permission
	        if($this->permission->add != 'yes') {
	            echo json_encode( array( 'error' => true, 'message' => $this->lang->line('msg_no_import') ), true);
	            exit();
	        }
	        // check pending upload exists


            if( isset( $_FILES['file'] ) ) {
                $chat_data = $this->read_read_file($_FILES['file']['tmp_name']);
                $result = $this->user_evaluation_model->save_import($chat_data);
                if (!$result) {

                }
            }
	    }

		public function read_chat_file($file_path='') {
			// echo FCPATH;
			$file = fopen($file_path, "r");
			$head_data = array();
			$chat_data = array();

			$hit = "";
			$previous_hit = "";

			while (!feof($file)) {
				$line = fgets($file);
				if (preg_match("/^account\=/i", $line)) {
					$hit = "account";
					// echo $hit.'<br>';
				}
				if (preg_match("/^Export Index\:/i", $line)) {
					$hit = $line;
					// echo $hit.'<br>';
				}

				if ($hit == "account") {
					if (!preg_match("/limit|More Sessions/i", $line) && preg_match("/\=/", $line)) {
						list($key, $val) = explode("=",$line);
						if (preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}/i", $val)) {
							$val = preg_replace("/T/", " ", $val);
							$val = preg_replace("/\+00\:00/", "", $val);
							$head_data[$key] = $val;
						} else {
							$head_data[$key] = $val;
						}
					}
				} else { 
					if ($hit == $previous_hit) {
						if (preg_match("/^Chat start date\: /i", $line)) {
							$temp_data['chat_start_date'] = preg_replace("/Chat start date\: /i", "", $line);
							$temp_data['chat_start_date'] = preg_replace("/T/", " ", $temp_data['chat_start_date']);
							$temp_data['chat_start_date'] = preg_replace("/\+00\:00/", "", $temp_data['chat_start_date']);
						}
						if (preg_match("/^Caller Identifier\: /i", $line)) {
							$temp_data['player'] = preg_replace("/Caller Identifier\: /i", "", $line);
						}
						if (preg_match("/^http User Agent\: /i", $line)) {
							$temp_data['browser'] = preg_replace("/http User Agent\: /i", "", $line);
						}
						if (preg_match("/^City \= /i", $line)) {
							$temp_data['city'] = preg_replace("/City \= /i", "", $line);
						}
						if (preg_match("/^Real Time Session id\: /i", $line)) {
							$temp_data['real_time_session_ref'] = preg_replace("/Real Time Session id\: /i", "", $line);
						}
						if (preg_match("/^Country \= /i", $line)) {
							$temp_data['country'] = preg_replace("/Country \= /i", "", $line);
						}
						if (preg_match("/^IP Address \= /i", $line)) {
							$temp_data['host_ip'] = preg_replace("/IP Address \= /i", "", $line);
						}
						if (preg_match("/^ISP \= /i", $line)) {
							$temp_data['isp'] = preg_replace("/ISP \= /i", "", $line);
						}
						if (preg_match("/^Organization \= /i", $line)) {
							$temp_data['organization'] = preg_replace("/Organization \= /i", "", $line);
						}
						if (preg_match("/^World Region \= /i", $line)) {
							$temp_data['world_region'] = preg_replace("/World Region \= /i", "", $line);
						}
						if (preg_match("/^Time Zone \= /i", $line)) {
							$temp_data['time_zone'] = preg_replace("/Time Zone \= /i", "", $line);
						}

						if (preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}\:[0-9]{2}\:[0-9]{2}\+00\:00\s.+\: /i", $line, $match)) {
							if (empty($temp_data['chat_list'])) {
								$temp_data['chat_list'] = array();
							}
							if (!preg_match("/info\:/i", $line)) {
								$chat_time = preg_replace("/\+00\:00.+$/i","", $match[0]);
								$chat_time = preg_replace("/T/i"," ", $chat_time);
								$temp_data['chat_list'][] = array(
									"chat_time" => $chat_time,
									"chat_text" => preg_replace("/^[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}\:[0-9]{2}\:[0-9]{2}\+00\:00\s.+\: /i", "", $line)
								);
							}
						}
					
					} else {
						if (!empty($temp_data)) $chat_data[] = $temp_data;
						$temp_data = array();
					}
					$previous_hit = $hit;
				}

			}
			 
			fclose($file);
			return array($head_data, $chat_data);
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

		public function qa_detail_post() {
			$post = $this->input->post();

			if (empty($post)) {
				die('{"status":"error"}');
			}

			$rating_data = json_decode($post['rating_data'], true);


			$qa_score = 0;
			foreach ($rating_data as $key => $val) {
				$qa_score += floatval($val['weight']) * (floatval($val['rating']) / 5);
			}

			$update_qa = $this->user_evaluation_model->update(array(
				"evaluate_by" => $this->session->userdata('username'),
				"evaluate_mark" => $qa_score,
				"evaluate_time" => time(),
				"areas_of_strength" => empty($post['areas_of_strength'])?"":$post['areas_of_strength'],
				"areas_of_improvement" => empty($post['areas_of_improvement'])?"":$post['areas_of_improvement'],
				"action_plan" => empty($post['action_plan'])?"":$post['action_plan'],
				"employee_comments" => empty($post['employee_comments'])?"":$post['employee_comments']

			), array("id"=>$post['qaid']));

			$update_qa_detail = $this->user_evaluation_form_model->update_qa(
				array(0, $post['qaid']),
				$post['qaid'],
				$rating_data,
				$this->session->userdata('username')
			);


			if ($update_qa && $update_qa_detail) {
				die('{"status":"success"}');
			}
			die('{"status":"error"}');
			// update to user_evaluation first
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