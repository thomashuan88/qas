<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_detail extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        // pre-load
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('MY_Permission');

        $this->load->model('adminpanel/member_detail_model');
        $this->load->model('adminpanel/users_model');
        $this->load->model('adminpanel/roles_model');
        $this->load->model('adminpanel/Performance_ops_monthly_model');



        if (! self::check_permissions(2)) {
            redirect("/private/no_access");
        }

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

        if (! self::check_permissions(1)) {
            redirect("/private/no_access");
        }

        // change default value "0" to ""
        $member_data = $this->users_model->get_member_data($this->uri->segment(3));        $member_data = $this->users_model->get_member_data($this->uri->segment(3));
        $leave_data = $this->Performance_ops_monthly_model->get_sum( $member_data->username);


        if (!in_array($member_data->username, $this->my_permission->find_permission())) {
            redirect("/private/no_access");
        }
        foreach($member_data as &$value){
            if($value=="0" | $value=="+60"){
                $value="";
            }
        }
        if(Settings_model::$db_config['data_mask'] == 'Yes') {
            (isset($member_data->phone) && $member_data->phone!=="")? $member_data->phone = substr($member_data->phone, 0, -4) . 'xxxx' : '';
            (isset($member_data->emergency_contact)&& $member_data->emergency_contact!=="")? $member_data->emergency_contact =substr($member_data->emergency_contact, 0, -4) . 'xxxx' : '';
        }

        $content_data['member'] = $member_data;
        $content_data['leave'] = $leave_data;

        $this->load->model('system/rbac_model');
        $content_data['roles'] = $this->roles_model->get_role_name();
        $content_data['leaders'] = $this->users_model->get_leaders();

        if (! $content_data['member']) {
            $this->session->set_flashdata('error', 'Nothing found.');
            redirect('adminpanel/list_members');
        }

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('user_details'), 'member_detail', 'header', 'footer', '', $content_data);

        return $this;
    }

    public function get_remarks($username="") {
        $this->load->model('adminpanel/remarks_model');

        if($username == $this->session->userdata('username') &&!in_array($username, $this->my_permission->find_permission())){
             echo "no access";
             exit();
        }

       if ( $this->input->post() ) {

           $paging = json_decode($this->input->post('data'), true);

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
