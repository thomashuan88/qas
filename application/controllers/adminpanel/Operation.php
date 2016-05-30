<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Operation extends Admin_Controller {

    private $limit_per_page;
    private $user;
    private $user_list;

    public function __construct() {
        parent::__construct();
        // pre-load
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('MY_Permission');
        $this->load->model('adminpanel/shift_reports_model');
        $this->load->model('adminpanel/follow_up_model');
        $this->load->model('adminpanel/time_sheet_model');
        $this->load->model('adminpanel/category_group_model');
        $this->load->model('adminpanel/category_list_model');
        $this->load->model('adminpanel/system_settings_model');
        $this->limit_per_page = Settings_model::$db_config['members_per_page'];
        $this->user = $this->session->userdata('username');
        $this->user_list = $this->my_permission->find_permission();
    }

    private function check_permission($key) {
        if (!self::check_permissions($key)) {
            redirect("/private/no_access");
        }
    }

    private function user_permission($user) {
        if (in_array($user, $this->user_list)) {
            return true;
        } else {
            return false;
        }
    }

    private function check_page_action($id, $key) {
        $res = self::check_action($id);
        if ($res->$key == 'yes') {
            return true;
        } else {
            return false;
        }
    }

    private function get_category_list($key = '') {
        $data = $this->category_group_model->get_types();
        if (!empty($data)) {
            $output = '<select class="form-control" id="category_id" name="category_id" data-parsley-trigger="change focusout" data-parsley-errors-messages-disabled data-parsley-required>';
            $output .= '<option value="">'.$this->lang->line('select').'</option>';
            if ($key) {
                foreach ($data->result() as $data) {
                    $output .= '<option value="' . $data->category_group_id . '"' . ($key == $data->category_group_id ? "selected" : "") . '>' . $data->content . '</option>';
                }
            } else {
                foreach ($data->result() as $data) {
                    $output .= '<option value="' . $data->category_group_id . '"' . ($this->session->flashdata('category_id') == $data->category_group_id ? "selected" : "") . '>' . $data->content . '</option>';
                }
            }
        } else {
            $output = '<select class="form-control" id="category_id" name="category_id" disabled><option>' . $this->lang->line('no_option') . '</option>';
        }
        $output .= '</select>';
        return $output;
    }

    public function ajax_get_sub_category_list($parent_id = "", $key = "") {
        echo $this->get_sub_category_list($parent_id, $key);
    }

    private function get_sub_category_list($parent_id = "", $key = "") {
        if ($parent_id) {
            $data = $this->category_list_model->get_lists($parent_id);
            if (!empty($data)) {
                $output = '<select class="form-control" id="sub_category_id" name="sub_category_id" data-parsley-trigger="change focusout" data-parsley-errors-messages-disabled data-parsley-required>';
                $output .= '<option value="">' . $this->lang->line('select') . '</option>';
                if ($key) {
                    foreach ($data->result() as $data) {
                        $output .= '<option value="' . $data->category_list_id . '"' . ($key == $data->category_list_id ? "selected" : "") . '>' . $data->content . '</option>';
                    }
                } else {
                    foreach ($data->result() as $data) {
                        $output .= '<option value="' . $data->category_list_id . '"' . ($this->session->flashdata('sub_category_id') == $data->category_list_id ? "selected" : "") . '>' . $data->content . '</option>';
                    }
                }
            } else {
                $output = '<select class="form-control" id="sub_category_id" name="sub_category_id" disabled><option>' . $this->lang->line('no_option') . '</option>';
            }
        } else {
            $output = '<select class="form-control" id="sub_category_id" name="sub_category_id" disabled><option>' . $this->lang->line('no_category') . '</option>';
        }
        $output .= '</select>';
        return $output;
    }

    private function get_product_list($key = '') {
        $data = $this->system_settings_model->get_product();
        if (!empty($data)) {
            $output = '<select class="form-control" id="product" name="product" data-parsley-trigger="change focusout" data-parsley-errors-messages-disabled data-parsley-required>';
            $output .= '<option value="">'.$this->lang->line('select').'</option>';
            if ($key) {
                foreach ($data->result() as $data) {
                    $output .= '<option value="' . $data->key . '"' . ($key == $data->key ? "selected" : "") . '>' . $data->value . '</option>';
                }
            } else {
                foreach ($data->result() as $data) {
                    $output .= '<option value="' . $data->key . '"' . ($this->session->flashdata('product') == $data->key ? "selected" : "") . '>' . $data->value . '</option>';
                }
            }
        } else {
            $output = '<select class="form-control" id="product" name="product" disabled><option>' . $this->lang->line('no_option') . '</option>';
        }
        $output .= '</select>';
        return $output;
    }

    private function get_shift_list($key = '') {
        $data = $this->system_settings_model->get_shift();
        if (!empty($data)) {
            $output = '<select class="form-control" id="shift" name="shift" data-parsley-trigger="change focusout" data-parsley-errors-messages-disabled data-parsley-required>';
            $output .= '<option value="">' . $this->lang->line('select') . '</option>';
            if ($key) {
                foreach ($data->result() as $data) {
                    $output .= '<option value="' . $data->key . '"' . ($key == $data->key ? "selected" : "") . '>' . $data->key . '</option>';
                }
            } else {
                foreach ($data->result() as $data) {
                    $output .= '<option value="' . $data->key . '"' . ($this->session->flashdata('shift') == $data->key ? "selected" : "") . '>' . $data->key . '</option>';
                }
            }
        } else {
            $output = '<select class="form-control" id="shift" name="shift" disabled><option>' . $this->lang->line('no_option') . '</option>';
        }
        $output .= '</select>';
        return $output;
    }

    private function check_category_list($key) {
        $res = array();
        $data = $this->category_group_model->get_types();;
        foreach ($data->result() as $data) {
            $res[$data->category_group_id] = $data->category_group_id;
        }

        if (in_array($key, $res)) {
            return true;
        } else {
            return false;
        }
    }

    private function check_sub_category_list($parent_id, $key) {
        $res = array();
        $data = $this->category_list_model->get_lists($parent_id);
        foreach ($data->result() as $data) {
            $res[$data->category_list_id] = $data->category_list_id;
        }

        if (in_array($key, $res)) {
            return true;
        } else {
            return false;
        }
    }

    private function check_product_list($key) {
        $res = array();
        $data = $this->system_settings_model->get_product();
        foreach ($data->result() as $data) {
            $res[$data->key] = $data->key;
        }

        if (in_array($key, $res)) {
            return true;
        } else {
            return false;
        }
    }

    private function check_shift_list($key) {
        $res = array();
        $data = $this->system_settings_model->get_shift();
        foreach ($data->result() as $data) {
            $res[$data->key] = $data->key;
        }

        if (in_array($key, $res)) {
            return true;
        } else {
            return false;
        }
    }

    private function change_date_format($date_time, $line = true) {
        if($date_time != 0){
            $time = strtotime($date_time);
            $res = date('Y', $time) . '/' . date('m', $time) . '/' . date('d', $time);
            if ($line) {
                $res .= '<br/>';
            } else {
                $res .= '&nbsp;';
            }
            $res .= date('h', $time) . ':' . date('i', $time) . ' ' . date('A', $time);
        } else {
            $res = '-';
        }
        return $res;
    }

    private function trim_data($post_data) {
        if ($post_data) {
            foreach ($post_data as $key => $value) {
                $post_data[$key] = trim($value);
            }
        }
        return $post_data;
    }
//==================================================== shift_report ====================================================
    public function shift_report() {
        $this->check_permission(15);
        $content_data['add'] = $this->check_page_action(15, 'add');
        $content_data['product_list'] = $this->get_product_list();
        $content_data['shift_list'] = $this->get_shift_list();
        $content_data['category_list'] = $this->get_category_list();
        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('shift_report'), 'operation/shift_report', 'header', 'footer', '', $content_data);
    }

    public function get_shift_report($type = "") {
        $paging = $this->session->userdata('search_shift_report');

        if ($type == 'session' && !empty($paging)) {
            if ($this->input->post()) {
                $post_data = json_decode($this->input->post('data'), true);
                if (!empty($post_data['search_data'])) {
                    $this->session->set_userdata(array('search_shift_report' => $post_data));
                    $paging = $post_data;
                }
            }
        } else {
            if ($this->input->post()) {
                $post_data = json_decode($this->input->post('data'), true);
                if (!empty($post_data['search_data'])) {
                    $this->session->set_userdata(array('search_shift_report' => $post_data));
                } else {
                    $this->session->unset_userdata('search_shift_report');
                }
                $paging = $post_data;
            }
        }

        if (!is_numeric($paging['offset'])) {
            redirect('/adminpanel/operation/time_sheet');
        }

        $this->session->set_flashdata($paging['search_data']);
        $content_data['table_data'] = array();
        $content_data['permission']['edit'] = $this->check_page_action(15, 'edit');
        $content_data['permission']['delete'] = $this->check_page_action(15, 'delete');
        $content_data['total_rows'] = '0';

        $content_data['reports'] = $this->shift_reports_model->get_all_reports($paging['order_by'], $paging['sort_order'], $paging['search_data'], $this->limit_per_page, $paging['offset'], $this->user_list);
        if (!empty($content_data['reports'])) {
            foreach ($content_data['reports']->result() as $value) {
                if ($value->status == 'done') {
                    $value->status = '<label class = "label label-info">' . $this->lang->line($value->status) . '</label>';
                } else {
                    $value->status = '<label class = "label label-pending">' . $this->lang->line($value->status) . '</label>';
                }
                $value->remarks = (mb_strlen($value->remarks) > 15) ? mb_substr($value->remarks, 0, 15) . "..." : $value->remarks;
                $value->finish = $this->change_date_format($value->finish);
                $value->created_time = $this->change_date_format($value->created_time);
            }
            $content_data['table_data'] = $content_data['reports']->result();
            $content_data['total_rows'] = $content_data['reports']->total_rows;
        }

        $content_data['offset'] = $paging['offset'];
        $content_data['per_page'] = $this->limit_per_page;

        echo json_encode($content_data, true);
    }

    public function shift_report_insert() {
        $this->check_permission(15);
        if (!$this->check_page_action(15, 'add')) {
            $this->session->set_flashdata('error', $this->lang->line('no_access_add_record'));
            redirect('/adminpanel/operation/shift_report');
        }

        $content_data = array();
        $content_data['product_list'] = $this->get_product_list();
        $content_data['shift_list'] = $this->get_shift_list();
        $content_data['category_list'] = $this->get_category_list();
        $content_data['sub_category_list'] = $this->get_sub_category_list();
        $post_data = $this->trim_data($this->input->post());
        if (!empty($post_data)) {
            $this->form_validation->set_error_delimiters('<p>', '</p>');
            $this->form_validation->set_rules('finish', $this->lang->line('finish_time'), 'trim|required');
            $this->form_validation->set_rules('player_name', $this->lang->line('player_name'), 'trim|required');
            $this->form_validation->set_rules('shift', $this->lang->line('shift'), 'trim|required');
            $this->form_validation->set_rules('product', $this->lang->line('product'), 'trim|required');
            $this->form_validation->set_rules('status', $this->lang->line('status'), 'trim|required');
            $this->form_validation->set_rules('follow_up', $this->lang->line('follow_up_by'), 'trim|required');
            $this->form_validation->set_rules('category_id', $this->lang->line('category'), 'trim|required');
            $this->form_validation->set_rules('sub_category_id', $this->lang->line('sub_category'), 'trim|required');
            $this->form_validation->set_rules('remarks', $this->lang->line('remark'), 'trim|required');

            if (!$this->form_validation->run()) {
                $this->session->set_flashdata($post_data);
                $this->session->set_flashdata('error', validation_errors());
                redirect('/adminpanel/operation/shift_report_insert');
            }

            if (!$this->check_category_list($post_data['category_id']) || !$this->check_sub_category_list($post_data['category_id'], $post_data['sub_category_id']) || !$this->check_product_list($post_data['product']) || !$this->check_shift_list($post_data['shift'])){
                $this->session->set_flashdata('error', $this->lang->line('invalid_post_data'));
                redirect('/adminpanel/operation/shift_report_insert');
            }
            $post_data['category_content'] = $this->category_group_model->get_one_category_group($post_data['category_id'])->content;
            $post_data['sub_category_content'] = $this->category_list_model->get_one_category_list($post_data['sub_category_id'])->content;
            $res = $this->shift_reports_model->insert_report($post_data);
            if ($res) {
                $this->session->set_flashdata('success', $this->lang->line('insert_success'));
            } else {
                $this->session->set_flashdata('error', $this->lang->line('insert_failure'));
            }
            redirect('/adminpanel/operation/shift_report');
        }

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('shift_report_insert'), 'operation/shift_report_insert', 'header', 'footer', '', $content_data);
    }

    public function shift_report_edit($key) {
        $this->check_permission(15);
        if (!$this->check_page_action(15, 'edit')) {
            $this->session->set_flashdata('error', $this->lang->line('no_access_edit_record'));
            redirect('/adminpanel/operation/time_sheet');
        }
        if (!empty($key)) {
            $content_data = array();
            $content_data['report'] = $this->shift_reports_model->get_one_report($key);
            if (!empty($content_data['report'])) {
                if ($this->user_permission($content_data['report']->created_by)) {
                    $content_data['product_list'] = $this->get_product_list($content_data['report']->product);
                    $content_data['shift_list'] = $this->get_shift_list($content_data['report']->shift);
                    $content_data['category_list'] = $this->get_category_list($content_data['report']->category_id);
                    $content_data['sub_category_list'] = $this->get_sub_category_list($content_data['report']->category_id, $content_data['report']->sub_category_id);
                    $post_data = $this->trim_data($this->input->post());
                    if (!empty($post_data)) {
                        $this->form_validation->set_error_delimiters('<p>', '</p>');
                        $this->form_validation->set_rules('player_name', $this->lang->line('player_name'), 'trim|required');
                        $this->form_validation->set_rules('shift', $this->lang->line('shift'), 'trim|required');
                        $this->form_validation->set_rules('product', $this->lang->line('product'), 'trim|required');
                        $this->form_validation->set_rules('status', $this->lang->line('status'), 'trim|required');
                        $this->form_validation->set_rules('follow_up', $this->lang->line('follow_up_by'), 'trim|required');
                        $this->form_validation->set_rules('category_id', $this->lang->line('category'), 'trim|required');
                        $this->form_validation->set_rules('sub_category_id', $this->lang->line('sub_category'), 'trim|required');
                        $this->form_validation->set_rules('remarks', $this->lang->line('remark'), 'trim|required');

                        if (!$this->form_validation->run()) {
                            $this->session->set_flashdata('error', validation_errors());
                            redirect('/adminpanel/operation/shift_report_edit/' . $key);
                        }

                        if (!$this->check_category_list($post_data['category_id']) || !$this->check_sub_category_list($post_data['category_id'], $post_data['sub_category_id']) || !$this->check_product_list($post_data['product']) || !$this->check_shift_list($post_data['shift'])){
                            $this->session->set_flashdata('error', $this->lang->line('invalid_post_data'));
                            redirect('/adminpanel/operation/shift_report_edit/' . $key);
                        }

                        $follow_report = $this->follow_up_model->get_follow_up_records($key);
                        if($follow_report && $post_data['status'] == 'done') {
                            $this->session->set_flashdata('error', $this->lang->line('exist_follow_up_record'));
                            redirect('/adminpanel/operation/shift_report?type=session');
                        }

                        $post_data['id'] = $key;
                        $post_data['category_content'] = $this->category_group_model->get_one_category_group($post_data['category_id'])->content;
                        $post_data['sub_category_content'] = $this->category_list_model->get_one_category_list($post_data['sub_category_id'])->content;
                        $res = $this->shift_reports_model->edit_report($post_data);
                        if ($res) {
                            $this->session->set_flashdata('success', $this->lang->line('update_success'));
                        } else {
                            $this->session->set_flashdata('error', $this->lang->line('update_failure'));
                        }
                    } else {
                        return $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('shift_report_edit'), 'operation/shift_report_edit', 'header', 'footer', '', $content_data);
                    }
                }else{
                    $this->session->set_flashdata('error', $this->lang->line('no_access_edit_record'));
                }
            } else {
                $this->session->set_flashdata('error', $this->lang->line('no_result'));
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('invalid_data'));
        }
        redirect('/adminpanel/operation/shift_report?type=session');
    }

    public function shift_report_delete($key) {
        $this->check_permission(15);
        if (!$this->check_page_action(15, 'delete')) {
            echo $this->lang->line('no_access_delete_record');
            exit();
        }

        if (!empty($key)) {
            $report = $this->shift_reports_model->get_one_report($key);
            if (!empty($report)) {
                if ($this->user_permission($report->created_by)) {
                    $res = $this->shift_reports_model->delete_report($key);
                    if ($res) {
                        $result = $this->follow_up_model->parent_batch_delete_follow_up($key);
                        if ($result) {
                            echo $this->lang->line('delete_success');
                        } else {
                            echo $this->lang->line('delete_failure');
                        }
                    } else {
                        echo $this->lang->line('delete_failure');
                    }
                } else {
                    echo $this->lang->line('no_access_delete_record');
                }
            } else {
                echo $this->lang->line('no_result');
            }
        } else {
            echo $this->lang->line('invalid_data');
        }
    }

    public function shift_report_follow_up ($key) {
        $this->check_permission(15);
        $content_data['add'] = $this->check_page_action(15, 'add');
        if (!empty($key)) {
            $content_data['report'] = $this->shift_reports_model->get_one_report($key);
            if (!empty($content_data['report'])) {
                $content_data['report']->status = $this->lang->line($content_data['report']->status);
                $content_data['report']->finish = $this->change_date_format($content_data['report']->finish, false);
                $content_data['report']->created_time = $this->change_date_format($content_data['report']->created_time, false);
                return $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('shift_report_follow_up'), 'operation/shift_report_follow_up', 'header', 'footer', '', $content_data);
            } else {
                $this->session->set_flashdata('error', $this->lang->line('no_result'));
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('invalid_data'));
        }
        redirect('/adminpanel/operation/shift_report');
    }

    public function get_shift_report_follow_up($key, $type = "") {
        $paging = $this->session->userdata('search_shift_report_follow_up');

        if ($type == 'session' && !empty($paging)) {
            if ($this->input->post()) {
                $post_data = json_decode($this->input->post('data'), true);
                if (!empty($post_data['search_data'])) {
                    $this->session->set_userdata(array('search_shift_report_follow_up' => $post_data));
                    $paging = $post_data;
                }
            }
        } else {
            if ($this->input->post()) {
                $post_data = json_decode($this->input->post('data'), true);
                if (!empty($post_data['search_data'])) {
                    $this->session->set_userdata(array('search_shift_report_follow_up' => $post_data));
                } else {
                    $this->session->unset_userdata('search_shift_report_follow_up');
                }
                $paging = $post_data;
            }
        }

        if (!is_numeric($paging['offset'])) {
            redirect('/adminpanel/operation/shift_report');
        }

        $report = $this->shift_reports_model->get_one_report($key);
        if (!empty($report)) {
            $content_data['table_data'] = array();
            $content_data['permission']['edit'] = $this->check_page_action(15, 'edit');
            $content_data['permission']['delete'] = $this->check_page_action(15, 'delete');
            $content_data['total_rows'] = '0';
            $content_data['follow_up'] = $this->follow_up_model->get_all_follow_up_reports($paging['order_by'], $paging['sort_order'], $key, $this->limit_per_page, $paging['offset'], $this->user_list, true);
            if (!empty($content_data['follow_up'])) {
                foreach ($content_data['follow_up']->result() as $value) {
                    if ($value->status == 'done') {
                        $value->status = '<label class = "label label-info">' . $this->lang->line($value->status) . '</label>';
                    } else {
                        $value->status = '<label class = "label label-pending">' . $this->lang->line($value->status) . '</label>';
                    }
                    $value->remarks = (mb_strlen($value->remarks) > 15) ? mb_substr($value->remarks, 0, 15) . "..." : $value->remarks;
                    $value->created_time = $this->change_date_format($value->created_time);
                }
                $content_data['table_data'] = $content_data['follow_up']->result();
                $content_data['total_rows'] = $content_data['follow_up']->total_rows;
            }
        }

        $content_data['offset'] = $paging['offset'];
        $content_data['per_page'] = $this->limit_per_page;

        echo json_encode($content_data, true);
    }

    public function shift_report_follow_up_insert($key) {
        $this->check_permission(15);
        if (!$this->check_page_action(15, 'add')) {
            $this->session->set_flashdata('error', $this->lang->line('no_access_add_record'));
            redirect('/adminpanel/operation/shift_report_follow_up');
        }

        if (!empty($key)) {
            $content_data = array();
            $content_data['key'] = $key;
            $report = $this->shift_reports_model->get_one_report($key);
            if (!empty($report)) {
                $post_data = $this->trim_data($this->input->post());
                if (!empty($post_data)) {
                    $this->form_validation->set_error_delimiters('<p>', '</p>');
                    $this->form_validation->set_rules('status', $this->lang->line('status'), 'trim|required');
                    $this->form_validation->set_rules('follow_up', $this->lang->line('follow_up_by'), 'trim|required');
                    $this->form_validation->set_rules('remarks', $this->lang->line('remark'), 'trim|required');

                    if (!$this->form_validation->run()) {
                        $this->session->set_flashdata($post_data);
                        $this->session->set_flashdata('error', validation_errors());
                        redirect('/adminpanel/operation/shift_report_follow_up_insert/' . $key);
                    }
                    $post_data['id'] = $key;
                    $res = $this->follow_up_model->insert_follow_up($post_data);
                    if ($res) {
                        $this->session->set_flashdata('success', $this->lang->line('insert_success'));
                    } else {
                        $this->session->set_flashdata('error', $this->lang->line('insert_failure'));
                    }
                } else {
                    return $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('shift_report_follow_up_insert'), 'operation/shift_report_follow_up_insert', 'header', 'footer', '', $content_data);
                }
            } else {
                $this->session->set_flashdata('error', $this->lang->line('no_result'));
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('invalid_data'));
        }
        redirect('/adminpanel/operation/shift_report_follow_up/' . $key);
    }

    public function shift_report_follow_up_edit($key, $id) {
        $this->check_permission(15);
        if (!$this->check_page_action(15, 'add')) {
            $this->session->set_flashdata('error', $this->lang->line('no_access_add_record'));
            redirect('/adminpanel/operation/shift_report_follow_up');
        }

        if (!empty($key)) {
            $content_data = array();
            $content_data['key'] = $key;
            $content_data['follow_up'] = $this->follow_up_model->get_one_follow_up($id);
            if (!empty($content_data['follow_up'])) {
                if ($this->user_permission($content_data['follow_up']->created_by)) {
                    $post_data = $this->trim_data($this->input->post());
                    if (!empty($post_data)) {
                        $this->form_validation->set_error_delimiters('<p>', '</p>');
                        $this->form_validation->set_rules('status', $this->lang->line('status'), 'trim|required');
                        $this->form_validation->set_rules('follow_up', $this->lang->line('follow_up_by'), 'trim|required');
                        $this->form_validation->set_rules('remarks', $this->lang->line('remark'), 'trim|required');

                        if (!$this->form_validation->run()) {
                            $this->session->set_flashdata($post_data);
                            $this->session->set_flashdata('error', validation_errors());
                            redirect('/adminpanel/operation/shift_report_follow_up_edit/' . $key . '/' . $id);
                        }
                        $post_data['id'] = $id;
                        $res = $this->follow_up_model->edit_follow_up($post_data);
                        if ($res) {
                            $this->session->set_flashdata('success', $this->lang->line('update_success'));
                        } else {
                            $this->session->set_flashdata('error', $this->lang->line('update_failure'));
                        }
                    } else {
                        return $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('shift_report_follow_up_edit'), 'operation/shift_report_follow_up_edit', 'header', 'footer', '', $content_data);
                    }
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('no_access_add_record'));
                }
            } else {
                $this->session->set_flashdata('error', $this->lang->line('no_result'));
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('invalid_data'));
        }
        redirect('/adminpanel/operation/shift_report_follow_up/' . $key . '?type=session');
    }

    public function shift_report_follow_up_delete($key) {
        $this->check_permission(15);
        if (!$this->check_page_action(15, 'delete')) {
            echo $this->lang->line('no_access_delete_record');
            exit();
        }

        if (!empty($key)) {
            $follow_up = $this->follow_up_model->get_one_follow_up($key);
            if (!empty($follow_up)) {
                if ($this->user_permission($follow_up->created_by)) {
                    $res = $this->follow_up_model->delete_follow_up($key);
                    if ($res) {
                        echo $this->lang->line('delete_success');
                    } else {
                        echo $this->lang->line('delete_failure');
                    }
                } else {
                    echo $this->lang->line('no_access_delete_record');
                }
            } else {
                echo $this->lang->line('no_result');
            }
        } else {
            echo $this->lang->line('invalid_data');
        }
    }
//================================================== End shift_report ==================================================

//================================================= information update =================================================
    public function information_update() {
        $this->check_permission(16);
        $content_data['add'] = $this->check_page_action(16, 'add');
        $content_data['product_list'] = $this->get_product_list();
        $content_data['shift_list'] = $this->get_shift_list();
        $content_data['category_list'] = $this->get_category_list();
        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('information_update'), 'operation/information_update', 'header', 'footer', '', $content_data);
    }

    public function get_information_update($type = "") {
        $paging = $this->session->userdata('search_shift_report');

        if ($type == 'session' && !empty($paging)) {
            if ($this->input->post()) {
                $post_data = json_decode($this->input->post('data'), true);
                if (!empty($post_data['search_data'])) {
                    $this->session->set_userdata(array('search_shift_report' => $post_data));
                    $paging = $post_data;
                }
            }
        } else {
            if ($this->input->post()) {
                $post_data = json_decode($this->input->post('data'), true);
                if (!empty($post_data['search_data'])) {
                    $this->session->set_userdata(array('search_shift_report' => $post_data));
                } else {
                    $this->session->unset_userdata('search_shift_report');
                }
                $paging = $post_data;
            }
        }

        if (!is_numeric($paging['offset'])) {
            redirect('/adminpanel/operation/time_sheet');
        }

        $this->session->set_flashdata($paging['search_data']);
        $content_data['table_data'] = array();
        $content_data['permission']['edit'] = $this->check_page_action(16, 'edit');
        $content_data['permission']['delete'] = $this->check_page_action(16, 'delete');
        $content_data['total_rows'] = '0';

        $content_data['reports'] = $this->shift_reports_model->get_all_reports($paging['order_by'], $paging['sort_order'], $paging['search_data'], $this->limit_per_page, $paging['offset'], $this->user_list);
        if (!empty($content_data['reports'])) {
            foreach ($content_data['reports']->result() as $value) {
                if ($value->status == 'done') {
                    $value->status = '<label class = "label label-info">' . $this->lang->line($value->status) . '</label>';
                } else {
                    $value->status = '<label class = "label label-danger">' . $this->lang->line($value->status) . '</label>';
                }
                $value->remarks = (mb_strlen($value->remarks) > 15) ? mb_substr($value->remarks, 0, 15) . "..." : $value->remarks;
                $value->finish = $this->change_date_format($value->finish);
                $value->created_time = $this->change_date_format($value->created_time);
            }
            $content_data['table_data'] = $content_data['reports']->result();
            $content_data['total_rows'] = $content_data['reports']->total_rows;
        }

        $content_data['offset'] = $paging['offset'];
        $content_data['per_page'] = $this->limit_per_page;

        echo json_encode($content_data, true);
    }
//=============================================== End information update ===============================================

//===================================================== Time sheet =====================================================
    public function time_sheet() {
        $this->check_permission(17);
        $content_data['add'] = $this->check_page_action(17, 'add');
        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('time_sheet'), 'operation/time_sheet', 'header', 'footer', '', $content_data);
    }

    public function get_time_sheet($type = "") {
            $paging = $this->session->userdata('search_time_sheet');

            if ($type == 'session' && !empty($paging)) {
                if ($this->input->post()) {
                    $post_data = json_decode($this->input->post('data'), true);
                    if (!empty($post_data['search_data'])) {
                        $this->session->set_userdata(array('search_time_sheet' => $post_data));
                        $paging = $post_data;
                    }
                }
            } else {
                if ($this->input->post()) {
                    $post_data = json_decode($this->input->post('data'), true);
                    if (!empty($post_data['search_data'])) {
                        $this->session->set_userdata(array('search_time_sheet' => $post_data));
                    } else {
                        $this->session->unset_userdata('search_time_sheet');
                    }
                    $paging = $post_data;
                }
            }

            if (!is_numeric($paging['offset'])) {
                redirect('/adminpanel/operation/time_sheet');
            }

            $this->session->set_flashdata($paging['search_data']);
            $content_data['table_data'] = array();
            $content_data['permission']['edit'] = $this->check_page_action(17, 'edit');
            $content_data['permission']['delete'] = $this->check_page_action(17, 'delete');
            $content_data['total_rows'] = '0';

            $content_data['time_sheet'] = $this->time_sheet_model->get_all_time_sheets($paging['order_by'], $paging['sort_order'], $paging['search_data'], $this->limit_per_page, $paging['offset'], $this->user_list);
            if (!empty($content_data['time_sheet'])) {
                foreach ($content_data['time_sheet']->result() as $value) {
                    $value->content = '<strong>' . $value->title . '</strong> - ' . ((mb_strlen($value->remarks) > 6) ? mb_substr($value->remarks, 0, 6) . "..." : $value->remarks);
                    if($value->time_end != 0){
                        $value->duration = date_diff(date_create($value->time_start), date_create($value->time_end), true)->format('%dd %hh %im');
                    } else {
                        $value->duration = $this->lang->line('pending');
                    }
                    $value->created_time = $this->change_date_format($value->created_time);
                }
                $content_data['table_data'] = $content_data['time_sheet']->result();
                $content_data['total_rows'] = $content_data['time_sheet']->total_rows;
            }

            $content_data['offset'] = $paging['offset'];
            $content_data['per_page'] = $this->limit_per_page;

        echo json_encode($content_data, true);
    }

    public function time_sheet_insert() {
        $this->check_permission(17);
        if (!$this->check_page_action(17, 'add')) {
            $this->session->set_flashdata('error', $this->lang->line('no_access_add_record'));
            redirect('/adminpanel/operation/time_sheet');
        }

        $time_sheet = $this->time_sheet_model->get_last_record();
        if(!empty($time_sheet) && $time_sheet->time_end == 0) {
            $this->session->set_flashdata('error', $this->lang->line('no_access_pending_record'));
            redirect('/adminpanel/operation/time_sheet');
        }

        $content_data = array();
        $content_data['shift_list'] = $this->get_shift_list();
        $content_data['product_list'] = $this->get_product_list();
        $post_data = $this->trim_data($this->input->post());
        if (!empty($post_data)) {
            $this->form_validation->set_error_delimiters('<p>', '</p>');
            $this->form_validation->set_rules('shift', $this->lang->line('shift'), 'trim|required');
            $this->form_validation->set_rules('product', $this->lang->line('product'), 'trim|required');
            $this->form_validation->set_rules('title', $this->lang->line('title'), 'trim|required');
            $this->form_validation->set_rules('remarks', $this->lang->line('remark'), 'trim|required');
            $this->form_validation->set_rules('time_start', $this->lang->line('time_start'), 'trim|required');

            if (!$this->form_validation->run()) {
                $this->session->set_flashdata($post_data);
                $this->session->set_flashdata('error', validation_errors());
                redirect('/adminpanel/operation/time_sheet_insert');
            }

            if (!$this->check_shift_list($post_data['shift']) || !$this->check_product_list($post_data['product'])) {
                $this->session->set_flashdata('error', $this->lang->line('invalid_post_data'));
                redirect('/adminpanel/operation/time_sheet_insert');
            }

            $res = $this->time_sheet_model->insert_time_sheet($post_data);
            if ($res) {
                $this->session->set_flashdata('success', $this->lang->line('insert_success'));
            } else {
                $this->session->set_flashdata('error', $this->lang->line('insert_failure'));
            }
            redirect('/adminpanel/operation/time_sheet');
        }

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('time_sheet_insert'), 'operation/time_sheet_insert', 'header', 'footer', '', $content_data);
    }

    public function time_sheet_edit($key) {
        $this->check_permission(17);
        if (!$this->check_page_action(17, 'edit')) {
            $this->session->set_flashdata('error', $this->lang->line('no_access_edit_record'));
            redirect('/adminpanel/operation/time_sheet');
        }

        if (!empty($key)) {
            $content_data = array();
            $content_data['time_sheet'] = $this->time_sheet_model->get_one_time_sheet($key);
            if (!empty($content_data['time_sheet'])) {
                if ($this->user_permission($content_data['time_sheet']->created_by)) {
                    $content_data['shift_list'] = $this->get_shift_list($content_data['time_sheet']->shift);
                    $content_data['product_list'] = $this->get_product_list($content_data['time_sheet']->product);
                    $post_data = $this->trim_data($this->input->post());
                    if (!empty($post_data)) {
                        $this->form_validation->set_error_delimiters("<p>", "</p>");
                        $this->form_validation->set_rules('shift', $this->lang->line('shift'), 'trim|required');
                        $this->form_validation->set_rules('product', $this->lang->line('product'), 'trim|required');
                        $this->form_validation->set_rules('title', $this->lang->line('title'), 'trim|required');
                        $this->form_validation->set_rules('remarks', $this->lang->line('remark'), 'trim|required');
                        $this->form_validation->set_rules('time_start', $this->lang->line('time_start'), 'trim|required');

                        if (!$this->form_validation->run()) {
                            $this->session->set_flashdata('error', validation_errors());
                            redirect('/adminpanel/operation/time_sheet_edit/' . $key);
                        }

                        $post_data['id'] = $key;
                        $res = $this->time_sheet_model->edit_time_sheet($this->trim_data($post_data));
                        if ($res) {
                            $this->session->set_flashdata('success', $this->lang->line('update_success'));
                        } else {
                            $this->session->set_flashdata('error', $this->lang->line('update_failure'));
                        }
                    } else {
                        return $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('time_sheet_edit'), 'operation/time_sheet_edit', 'header', 'footer', '', $content_data);
                    }
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('no_access_edit_record'));
                }
            } else {
                $this->session->set_flashdata('error', $this->lang->line('no_result'));
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('invalid_data'));
        }
        redirect('/adminpanel/operation/time_sheet?type=session');
    }

    public function time_sheet_details($key) {
        $this->check_permission(17);

        if (!empty($key)) {
            $content_data = array();
            $content_data['time_sheet'] = $this->time_sheet_model->get_one_time_sheet($key);
            if (!empty($content_data['time_sheet'])) {
                if ($this->user_permission($content_data['time_sheet']->created_by)) {
                    $content_data['time_sheet']->time_start = $this->change_date_format($content_data['time_sheet']->time_start, false);
                    $content_data['time_sheet']->time_end = $this->change_date_format($content_data['time_sheet']->time_end, false);
                    $content_data['time_sheet']->created_time = $this->change_date_format($content_data['time_sheet']->created_time, false);
                    echo json_encode($content_data['time_sheet']);
                } else {
                    echo $this->lang->line('no_access_view_record');
                }
            } else {
                echo $this->lang->line('no_result');
            }
        } else {
            echo $this->lang->line('invalid_data');
        }
    }

    public function time_sheet_delete($key) {
        $this->check_permission(17);
        if (!$this->check_page_action(17, 'delete')) {
            echo $this->lang->line('no_access_delete_record');
            exit();
        }

        if (!empty($key)) {
            $time_sheet = $this->time_sheet_model->get_one_time_sheet($key);
            if (!empty($time_sheet)) {
                if ($this->user_permission($time_sheet->created_by)) {
                    $res = $this->time_sheet_model->delete_time_sheet($key);
                    if ($res) {
                        echo $this->lang->line('delete_success');
                    } else {
                        echo $this->lang->line('delete_failure');
                    }
                } else {
                    echo $this->lang->line('no_access_delete_record');
                }
            } else {
                echo $this->lang->line('no_result');
            }
        } else {
            echo $this->lang->line('invalid_data');
        }
    }
//=================================================== End Time sheet ===================================================

//=================================================== question type ====================================================
    public function question_type() {
        $this->check_permission(18);
        $content_data['add'] = $this->check_page_action(18, 'add');
        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('question_type'), 'operation/question_type', 'header', 'footer', '', $content_data);
    }

    public function get_question_type($type = "") {
        $paging = $this->session->userdata('search_question_type');

        if ($type == 'session' && !empty($paging)) {
            if ($this->input->post()) {
                $post_data = json_decode($this->input->post('data'), true);
                if (!empty($post_data['search_data'])) {
                    $this->session->set_userdata(array('search_question_type' => $post_data));
                    $paging = $post_data;
                }
            }
        } else {
            if ($this->input->post()) {
                $post_data = json_decode($this->input->post('data'), true);
                if (!empty($post_data['search_data'])) {
                    $this->session->set_userdata(array('search_question_type' => $post_data));
                } else {
                    $this->session->unset_userdata('search_question_type');
                }
                $paging = $post_data;
            }
        }

        if (!is_numeric($paging['offset'])) {
            redirect('/adminpanel/operation/question_type');
        }

        $this->session->set_flashdata($paging['search_data']);
        $content_data['table_data'] = array();
        $content_data['permission']['edit'] = $this->check_page_action(18, 'edit');
        $content_data['permission']['delete'] = $this->check_page_action(18, 'delete');
        $content_data['total_rows'] = '0';

        $content_data['types'] = $this->category_group_model->get_all_category_group($paging['order_by'], $paging['sort_order'], $paging['search_data'], $this->limit_per_page, $paging['offset']);
        if (!empty($content_data['types'])) {
            foreach ($content_data['types']->result() as $value) {
                if ($value->status == 'active') {
                    $value->status = '<label class = "label label-success">' . $this->lang->line($value->status) . '</label>';
                } else {
                    $value->status = '<label class = "label label-danger">' . $this->lang->line($value->status) . '</label>';
                }
                $value->created_time = $this->change_date_format($value->created_time);
            }
            $content_data['table_data'] = $content_data['types']->result();
            $content_data['total_rows'] = $content_data['types']->total_rows;
        }

        $content_data['offset'] = $paging['offset'];
        $content_data['per_page'] = $this->limit_per_page;

        echo json_encode($content_data, true);
    }

    public function question_type_insert() {
        $this->check_permission(18);
        if (!$this->check_page_action(18, 'add')) {
            $this->session->set_flashdata('error', $this->lang->line('no_access_add_record'));
            redirect('/adminpanel/operation/question_type');
        }

        $post_data = $this->trim_data($this->input->post());
        if (!empty($post_data)) {
            $this->form_validation->set_error_delimiters('<p>', '</p>');
            $this->form_validation->set_rules('content', $this->lang->line('content'), 'trim|required');
            $this->form_validation->set_rules('status', $this->lang->line('status'), 'trim|required');

            if (!$this->form_validation->run()) {
                $this->session->set_flashdata($post_data);
                $this->session->set_flashdata('error', validation_errors());
                redirect('/adminpanel/operation/question_type_insert');
            }

            $res = $this->category_group_model->insert_category_group($this->trim_data($post_data));
            if ($res) {
                $this->session->set_flashdata('success', $this->lang->line('insert_success'));
            } else {
                $this->session->set_flashdata('error', $this->lang->line('insert_failure_duplicate'));
            }
            redirect('/adminpanel/operation/question_type');
        }

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('question_type_insert'), 'operation/question_type_insert', 'header', 'footer');
    }

    public function question_type_edit($key) {
        $this->check_permission(18);
        if (!$this->check_page_action(18, 'edit')) {
            $this->session->set_flashdata('error', $this->lang->line('no_access_edit_record'));
            redirect('/adminpanel/operation/question_type');
        }

        if (!empty($key)) {
            $content_data = array();
            $content_data['type'] = $this->category_group_model->get_one_category_group($key);
            if (!empty($content_data['type'])) {
                if ($this->user_permission($content_data['type']->created_by)) {
                    $post_data = $this->trim_data($this->input->post());
                    if (!empty($post_data)) {
                        $this->form_validation->set_error_delimiters("<p>", "</p>");
                        $this->form_validation->set_rules('content', $this->lang->line('content'), 'trim|required');
                        $this->form_validation->set_rules('status', $this->lang->line('status'), 'trim|required');

                        if (!$this->form_validation->run()) {
                            $this->session->set_flashdata('error', validation_errors());
                            redirect('/adminpanel/operation/question_type_edit/' . $key);
                        }

                        $post_data['id'] = $key;
                        $res = $this->category_group_model->edit_category_group($post_data);
                        if ($res) {
                            $this->session->set_flashdata('success', $this->lang->line('update_success'));
                        } else {
                            $this->session->set_flashdata('error', $this->lang->line('update_failure_duplicate'));
                        }
                    } else {
                        return $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('question_type_edit'), 'operation/question_type_edit', 'header', 'footer', '', $content_data);
                    }
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('no_access_edit_record'));
                }
            } else {
                $this->session->set_flashdata('error', $this->lang->line('no_result'));
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('invalid_data'));
        }
        redirect('/adminpanel/operation/question_type?type=session');
    }

    public function question_type_delete($key) {
        $this->check_permission(18);
        if (!$this->check_page_action(18, 'delete')) {
            echo $this->lang->line('no_access_delete_record');
            exit();
        }

        if (!empty($key)) {
            $report = $this->category_group_model->get_one_category_group($key);
            if (!empty($report)) {
                if ($this->user_permission($report->created_by)) {
                    $res = $this->category_group_model->delete_category_group($key);
                    if ($res) {
                        $result = $this->category_list_model->parent_batch_delete_category_list($key);
                        if ($result) {
                            echo $this->lang->line('delete_success');
                        } else {
                            echo $this->lang->line('delete_failure');
                        }
                    } else {
                        echo $this->lang->line('delete_failure');
                    }
                } else {
                    echo $this->lang->line('no_access_delete_record');
                }
            } else {
                echo $this->lang->line('no_result');
            }
        } else {
            echo $this->lang->line('invalid_data');
        }
    }
//================================================== End question type =================================================

//================================================== question content ==================================================
    public function question_content() {
        $this->check_permission(19);
        $content_data['add'] = $this->check_page_action(19, 'add');

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('question_content'), 'operation/question_content', 'header', 'footer', '', $content_data);
    }

    public function get_question_content($type = "") {
        $paging = $this->session->userdata('search_question_content');

        if ($type == 'session' && !empty($paging)) {
            if ($this->input->post()) {
                $post_data = json_decode($this->input->post('data'), true);
                if (!empty($post_data['search_data'])) {
                    $this->session->set_userdata(array('search_question_content' => $post_data));
                    $paging = $post_data;
                }
            }
        } else {
            if ($this->input->post()) {
                $post_data = json_decode($this->input->post('data'), true);
                if (!empty($post_data['search_data'])) {
                    $this->session->set_userdata(array('search_question_content' => $post_data));
                } else {
                    $this->session->unset_userdata('search_question_content');
                }
                $paging = $post_data;
            }
        }

        if (!is_numeric($paging['offset'])) {
            redirect('/adminpanel/operation/question_type');
        }

        $this->session->set_flashdata($paging['search_data']);
        $content_data['table_data'] = array();
        $content_data['permission']['edit'] = $this->check_page_action(19, 'edit');
        $content_data['permission']['delete'] = $this->check_page_action(19, 'delete');
        $content_data['total_rows'] = '0';

        $content_data['list'] = $this->category_list_model->get_all_category_list($paging['order_by'], $paging['sort_order'], $paging['search_data'], $this->limit_per_page, $paging['offset']);
        if (!empty($content_data['list'])) {
            foreach ($content_data['list']->result() as $value) {
                if ($value->status == 'active') {
                    $value->status = '<label class = "label label-success">' . $this->lang->line($value->status) . '</label>';
                } else {
                    $value->status = '<label class = "label label-danger">' . $this->lang->line($value->status) . '</label>';
                }
                $value->created_time = $this->change_date_format($value->created_time);
            }
            $content_data['table_data'] = $content_data['list']->result();
            $content_data['total_rows'] = $content_data['list']->total_rows;
        }

        $content_data['offset'] = $paging['offset'];
        $content_data['per_page'] = $this->limit_per_page;

        echo json_encode($content_data, true);
    }

    public function question_content_insert() {
        $this->check_permission(19);
        if (!$this->check_page_action(19, 'add')) {
            $this->session->set_flashdata('error', $this->lang->line('no_access_add_record'));
            redirect('/adminpanel/operation/question_content');
        }

        $content_data = array();
        $content_data['category_list'] = $this->get_category_list();
        $post_data = $this->trim_data($this->input->post());
        if (!empty($post_data)) {
            $this->form_validation->set_error_delimiters('<p>', '</p>');
            $this->form_validation->set_rules('category_id', $this->lang->line('category'), 'trim|required');
            $this->form_validation->set_rules('content', $this->lang->line('content'), 'trim|required');
            $this->form_validation->set_rules('status', $this->lang->line('status'), 'trim|required');

            if (!$this->form_validation->run()) {
                $this->session->set_flashdata($post_data);
                $this->session->set_flashdata('error', validation_errors());
                redirect('/adminpanel/operation/question_content_insert');
            }

            if (!$this->check_category_list($post_data['category_id'])) {
                $this->session->set_flashdata('error', $this->lang->line('invalid_post_data'));
                redirect('/adminpanel/operation/question_content_insert');
            }

            $post_data['parent_content'] = $this->category_group_model->get_one_category_group($post_data['category_id'])->content;
            $res = $this->category_list_model->insert_category_list($post_data);
            if ($res) {
                $this->session->set_flashdata('success', $this->lang->line('insert_success'));
            } else {
                $this->session->set_flashdata('error', $this->lang->line('insert_failure_duplicate'));
            }
            redirect('/adminpanel/operation/question_content');
        }

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('question_content_insert'), 'operation/question_content_insert', 'header', 'footer', '', $content_data);
    }

    public function question_content_edit($key) {
        $this->check_permission(19);
        if (!$this->check_page_action(19, 'edit')) {
            $this->session->set_flashdata('error', $this->lang->line('no_access_edit_record'));
            redirect('/adminpanel/operation/question_content');
        }

        if (!empty($key)) {
            $content_data = array();
            $content_data['list'] = $this->category_list_model->get_one_category_list($key);
            if (!empty($content_data['list'])) {
                if ($this->user_permission($content_data['list']->created_by)) {
                    $content_data['category_list'] = $this->get_category_list($content_data['list']->parent_id);
                    $post_data = $this->trim_data($this->input->post());
                    if (!empty($post_data)) {
                        $this->form_validation->set_error_delimiters("<p>", "</p>");
                        $this->form_validation->set_rules('category_id', $this->lang->line('category'), 'trim|required');
                        $this->form_validation->set_rules('content', $this->lang->line('product'), 'trim|required');
                        $this->form_validation->set_rules('status', $this->lang->line('status'), 'trim|required');

                        if (!$this->form_validation->run()) {
                            $this->session->set_flashdata('error', validation_errors());
                            redirect('/adminpanel/operation/question_content_edit/' . $key);
                        }

                        if (!$this->check_category_list($post_data['category_id'])) {
                            $this->session->set_flashdata('error', $this->lang->line('invalid_post_data'));
                            redirect('/adminpanel/operation/question_content_edit/' . $key);
                        }

                        $post_data['id'] = $key;
                        $post_data['parent_content'] = $this->category_group_model->get_one_category_group($post_data['category_id'])->content;
                        $res = $this->category_list_model->edit_category_list($post_data);
                        if ($res) {
                            $this->session->set_flashdata('success', $this->lang->line('update_success'));
                        } else {
                            $this->session->set_flashdata('error', $this->lang->line('update_failure_duplicate'));
                        }
                    } else {
                        return $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('question_content_edit'), 'operation/question_content_edit', 'header', 'footer', '', $content_data);
                    }
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('no_access_edit_record'));
                }
            } else {
                $this->session->set_flashdata('error', $this->lang->line('no_result'));
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('invalid_data'));
        }
        redirect('/adminpanel/operation/question_content?type=session');
    }

    public function question_content_delete($key) {
        $this->check_permission(19);
        if (!$this->check_page_action(19, 'delete')) {
            echo $this->lang->line('no_access_delete_record');
            exit();
        }

        if (!empty($key)) {
            $report = $this->category_list_model->get_one_category_list($key);
            if (!empty($report)) {
                if ($this->user_permission($report->created_by)) {
                    $res = $this->category_list_model->delete_category_list($key);
                    if ($res) {
                        echo $this->lang->line('delete_success');
                    } else {
                        echo $this->lang->line('delete_failure');
                    }
                } else {
                    echo $this->lang->line('no_access_delete_record');
                }
            } else {
                echo $this->lang->line('no_result');
            }
        } else {
            echo $this->lang->line('invalid_data');
        }
    }
//================================================ End question content ================================================
}
