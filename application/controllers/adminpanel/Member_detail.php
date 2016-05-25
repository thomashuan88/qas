<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_detail extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        // pre-load
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('adminpanel/member_detail_model');
        $this->load->model('adminpanel/users_model');
        $this->load->model('adminpanel/roles_model');

    }

    public function _remap($method, $params = array()) {

        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }

        if ( ! $this->form_validation->is_natural_no_zero($this->uri->segment(3))) {
            $this->session->set_flashdata('error', '<p>Illegal request.</p>');
            redirect('adminpanel/list_members');
        }

        // if (! self::check_permissions(1)) {
        //     redirect("/private/no_access");
        // }

        $content_data['member'] = $this->users_model->get_member_data($this->uri->segment(3));

        $this->load->model('system/rbac_model');
        $content_data['roles'] = $this->roles_model->get_role_name();
        $content_data['leaders'] = $this->users_model->get_leaders();

        if (! $content_data['member']) {
            $this->session->set_flashdata('error', 'Nothing found.');
            redirect('adminpanel/list_members');
        }

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('member_detail'), 'member_detail', 'header', 'footer', '', $content_data);

        return $this;
    }

    public function get_remarks() {
        $this->load->model('adminpanel/remarks_model');

       if ( $this->input->post() ) {
           $array = $this->input->post();
           $array1 = array_keys($array);
           $paging = json_decode($array1[0], true);

           $offset = $paging['offset'];
           $order_by = $paging['order_by'];
           $sort_order = $paging['sort_order'];
           $search_data = $paging['search_data'];
           $per_page = Settings_model::$db_config['members_per_page'];

           $remarks = $this->remarks_model->get_remarks($per_page, $offset, $order_by, $sort_order, $search_data);
           $content_data['total_rows'] = $this->remarks_model->count_all_search_remarks($search_data);
           $content_data['table_data']['offset'] = $offset;

           if ( $content_data['total_rows'] > 0 ) {
               $content_data['table_data'] = $remarks->result();
           } else {
               $content_data['table_data'] = array();
           }

           $content_data['total_rows'] = $this->remarks_model->count_all_search_remarks($search_data);
           $content_data['offset'] = $offset;
           $content_data['per_page'] = Settings_model::$db_config['members_per_page'];
           echo json_encode($content_data, true);

       }
   }



}
