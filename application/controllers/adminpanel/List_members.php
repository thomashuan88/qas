<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class List_members extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        // pre-load
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('adminpanel/list_members_model');
        $this->load->model('adminpanel/users_model');
        $this->load->model('adminpanel/roles_model');

        if (! self::check_permissions(2)) {
            redirect("/private/no_access");
        }
        $this->permission = self::check_action(2);
        $this->load->library('MY_Permission');

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
         $content_data['permission'] = array();
         ($this->permission->add == 'yes') ?  $content_data['permission']['add'] = TRUE : '';
         ($this->permission->edit == 'yes') ?  $content_data['permission']['edit'] = TRUE : '';
         ($this->permission->delete == 'yes') ?  $content_data['permission']['delete'] = TRUE : '';
         (Settings_model::$db_config['data_mask'] == 'Yes') ?  $content_data['permission']['data_mask'] = TRUE : '';




         $content_data['roles'] = $this->roles_model->get_role_name();


        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel',  $this->lang->line('user_listing'), 'list_members', 'header', 'footer', '', $content_data);
    }

    public function get_users($type="") {
        $paging = $this->session->userdata('paging');

        if($type == 'session' && !empty($paging)){
            if($this->input->post()){
                $post_data = json_decode($this->input->post('data'), true);

                if(!empty($post_data['search_data'])){
                    $search_session = array('paging' => $post_data);
                    $this->session->set_userdata($search_session);
                    $paging = $post_data ;
                }
            }
        } else{
            if($this->input->post()){
                $post_data = json_decode($this->input->post('data'), true);
                if(!empty($post_data['search_data'])){
                    $search_session = array('paging' => $post_data);
                    $this->session->set_userdata($search_session);
                } else{
                    $post_data['search_data'] = array('status'=>'active');
                    // $unset_search_session  = array('paging' => '');
                    $this->session->unset_userdata('paging');

                }
                $paging = $post_data ;
            }
        }

               $offset = $paging['offset'];
               $order_by = $paging['order_by'];
               $sort_order = $paging['sort_order'];
               $search_data = $paging['search_data'];
               $per_page = Settings_model::$db_config['members_per_page'];
               $users_data = $this->users_model->get_members($per_page, $offset, $order_by, $sort_order, $search_data, $this->my_permission->find_permission());
               $content_data['total_rows'] = $this->users_model->count_all_search_members($search_data, $this->my_permission->find_permission());

               if ( $content_data['total_rows'] > 0 ) {
                   $content_data['table_data'] = $users_data->result();
               } else {
                   $content_data['table_data'] = array();
               }

               $content_data['total_rows'] = $this->users_model->count_all_search_members($search_data, $this->my_permission->find_permission());
               $content_data['offset'] = $offset;
               $content_data['per_page'] = Settings_model::$db_config['members_per_page'];
               echo json_encode($content_data, true);

   }

   public function change_status() {
       $member_data = $this->users_model->get_member_info($this->session->userdata('username'));
       if($member_data->role !== "Administrator"){
           echo "You have no permission to perform this action";
           exit();
       }
       if ( $this->input->post() ) {
           $value = $this->input->post();
           if($this->users_model->toggle_active($value['username'], $value['current_status'])){
               $message =  ($value['current_status']=='Active'?'deactivated' : 'activated');
                echo "User has been " .$message;
           }else {
               echo "Fail to change user status";
           }
       }
   }


   public function resend_link_ajax(){
       $this->load->helper(array('form', 'send_email'));
       $this->load->model('system/email_tools_model');
       $data = $this->email_tools_model->get_data_by_email($this->input->post('email'));

       if ($data['status'] == "Active") {
           echo "Account is already activated";
       }elseif (!empty($data['nonce'])) {
           $this->load->model('auth/resend_activation_model');
           $this->resend_activation_model->update_last_login($data['username']);
           $this->load->helper('send_email');
           $this->load->library('email', load_email_config(Settings_model::$db_config['email_protocol']));
           $this->email->from(Settings_model::$db_config['admin_email_address'], $_SERVER['HTTP_HOST']);
           $this->email->to($this->input->post('email'));
           $this->email->subject($this->lang->line('resend_activation_subject'));

           $message ="";
           $message .=$this->lang->line('email_greeting') ." ".$this->input->post('uname');
           $message .=$this->lang->line('resend_activation_message'). base_url() ."auth/activate_account/check/". urlencode($this->input->post('email')) ."/". $data['nonce']."/".$data['username']." ";
           $this->email->message($message);
           if ($this->email->send()) {
               echo "Activation email has been resend";
           }
       }else{
           echo "Email not found";
       }
   }

    /**
     *
     * toggle_ban: (un)ban member from adminpanel
     *
     * @param int $id the id of the member to be banned
     * @param string $username the username of the member involved
     * @param int $offset the offset to be used for selecting data
     * @param int $order_by order by this data column
     * @param string $sort_order asc or desc
     * @param string $search search type, used in index to determine what to display
     * @param bool $banned ban or unban?
     *
     */

    public function toggle_ban($id, $username, $offset, $order_by, $sort_order, $search, $banned) {

        if (! self::check_permissions(9)) {
            redirect("/private/no_access");
        }

        if ($this->list_members_model->get_username_by_id($id) == ADMINISTRATOR) {
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('admin_noban') .'</p>');
            redirect('/adminpanel/list_members/index');
            return;
        }elseif ($this->list_members_model->toggle_ban($id, $banned)) {
            $banned ? $banned = $this->lang->line('unbanned') : $banned = $this->lang->line('banned');
            $this->session->set_flashdata('success', '<p>'. sprintf($this->lang->line('toggle_ban'), $username) . $banned .'</p>');
        }
        redirect('/adminpanel/list_members/index/'. $order_by .'/'. $sort_order .'/'. $search .'/'. $offset);
    }

    /**
     *
     * toggle_active: (de)activate member from adminpanel
     *
     * @param int $id the id of the member to be activated
     * @param string $username the username of the member involved
     * @param int $offset the offset to be used for selecting data
     * @param int $order_by order by this data column
     * @param string $sort_order asc or desc
     * @param string $search search type, used in index to determine what to display
     * @param bool $active or deactivate?
     *
     */

    public function toggle_active($username, $active) {

        if (! self::check_permissions(10)) {
            redirect("/private/no_access");
        }

        if ($this->list_members_model->get_username_by_id($id) == ADMINISTRATOR) {
            $this->session->set_flashdata('error', '<p>'. $this->lang->line('admin_noactivate') .'</p>');
            redirect('/adminpanel/list_members/index');
            return;
        }elseif ($this->list_members_model->toggle_active($id, $active)) {
            $active ? $active = $this->lang->line('deactivated') : $active = $this->lang->line('activated');
            $this->session->set_flashdata('success', '<p>'. sprintf($this->lang->line('toggle_active'), $username) . $active .'</p>');
        }
        redirect('/adminpanel/list_members/index/'. $order_by .'/'. $sort_order .'/'. $search .'/'. $offset);
    }

    /**
     *
     * mass_action: takes care of the checkbox selection functionality
     * @param int $offset the offset to be used for selecting data
     * @param int $order_by order by this data column
     * @param string $sort_order asc or desc
     * @param string $search search type, used in index to determine what to display
     *
     */

    public function mass_action($offset, $order_by, $sort_order, $search) {
        if (!isset($_POST['mass']) || empty($_POST['mass'])) {
            $this->session->set_flashdata('error', '<p>Nothing selected.</p>');
            redirect('adminpanel/list_members');
        }
        foreach ($_POST['mass'] as $value) {
            $value = trim($value);
            if( ! $this->form_validation->is_natural_no_zero($value)) {
                $this->session->set_flashdata('error', '<p>Illegal input detected.</p>');
                redirect('adminpanel/list_members');
            }
        }
        if ($_POST['mass_action'] == 'delete') {
            $this->_delete($offset, $order_by, $sort_order, $search);
        }elseif ($_POST['mass_action'] == 'ban') {
            $this->_ban($offset, $order_by, $sort_order, $search);
        }elseif ($_POST['mass_action'] == 'unban') {
            $this->_unban($offset, $order_by, $sort_order, $search);
        }elseif ($_POST['mass_action'] == 'activate') {
            $this->_activate($offset, $order_by, $sort_order, $search);
        }elseif ($_POST['mass_action'] == 'deactivate') {
            $this->_deactivate($offset, $order_by, $sort_order, $search);
        }
    }

    /**
     *
     * _delete: deletion of selected members
     *
     * @param int $id the id of the member to be deleted
     * @param int $offset the offset to be used for selecting data
     * @param int $order_by order by this data column
     * @param string $sort_order asc or desc
     * @param string $search search type, used in index to determine what to display
     *
     */

    private function _delete($offset, $order_by, $sort_order, $search) {

        if (! self::check_permissions(6)) {
            redirect("/private/no_access");
        }

        // loop through the given ids
        foreach($_POST['mass'] as $id) {

            // select username from id
            if ($username = $this->list_members_model->get_username_by_id($id)) {

                // grab the files that need to be purged
                $files = glob(FCPATH .'assets/img/members/'. $username .'/*');

                // loop through files
                if ($files) {
                    foreach($files as $file){
                        if(is_file($file)) {
                            // purge if exists, send error on failure
                            if(!unlink($file)) {
                                $this->session->set_flashdata('error', '<p>Could not remove file - aborted at '. $id .'.</p>');
                                redirect('/adminpanel/list_members/index/'. $order_by .'/'. $sort_order .'/'. $search .'/'. $offset);
                            }
                        }
                    }
                }

                // once all files are removed (or none are found) then we remove the empty folder and redirect
                if(rmdir(FCPATH .'assets/img/members/'. $username)) {

                    // remove user from DB
                    if (!$this->list_members_model->delete_member($id)) {
                        $this->session->set_flashdata('error', '<p>Deletion failed - aborted at '. $id .'.</p>');
                        redirect('/adminpanel/list_members/index/'. $order_by .'/'. $sort_order .'/'. $search .'/'. $offset);
                    }
                }else{
                    // rmdir() failed error
                    $this->session->set_flashdata('error', '<p>Failed to remove member directory - aborted at '. $id .'.</p>');
                    redirect('/adminpanel/list_members/index/'. $order_by .'/'. $sort_order .'/'. $search .'/'. $offset);
                }
            }
        }

        $this->session->set_flashdata('success', '<p>Selected members deleted.</p>');
        redirect('/adminpanel/list_members/index/'. $order_by .'/'. $sort_order .'/'. $search .'/'. $offset);

    }

    /**
     *
     * _ban: ban selected members
     *
     * @param int $id the id of the member to be banned
     * @param int $offset the offset to be used for selecting data
     * @param int $order_by order by this data column
     * @param string $sort_order asc or desc
     * @param string $search search type, used in index to determine what to display
     *
     */

    private function _ban($offset, $order_by, $sort_order, $search) {

        if (! self::check_permissions(9)) {
            redirect("/private/no_access");
        }

        if (!$this->list_members_model->ban_checked($_POST['mass'])) {
            $this->session->set_flashdata('error', '<p>Nobody was banned.</p>');
        }else{
            $this->session->set_flashdata('success', '<p>Banned '. count($_POST['mass']) .' members.</p>');
        }

        redirect('/adminpanel/list_members/index/'. $order_by .'/'. $sort_order .'/'. $search .'/'. $offset);
    }

    /**
     *
     * _unban: unban selected members
     *
     * @param int $id the id of the member to be unbanned
     * @param int $offset the offset to be used for selecting data
     * @param int $order_by order by this data column
     * @param string $sort_order asc or desc
     * @param string $search search type, used in index to determine what to display
     *
     */

    private function _unban($offset, $order_by, $sort_order, $search) {

        if (! self::check_permissions(9)) {
            redirect("/private/no_access");
        }


        if (!$this->list_members_model->unban_checked($_POST['mass'])) {
            $this->session->set_flashdata('error', '<p>Nobody was unbanned.</p>');
        }else{
            $this->session->set_flashdata('success', '<p>Unbanned '. count($_POST['mass']) .' members.</p>');
        }

        redirect('/adminpanel/list_members/index/'. $order_by .'/'. $sort_order .'/'. $search .'/'. $offset);
    }

    /**
     *
     * _activate: make active selected members
     *
     * @param int $id the id of the member to be activated
     * @param int $offset the offset to be used for selecting data
     * @param int $order_by order by this data column
     * @param string $sort_order asc or desc
     * @param string $search search type, used in index to determine what to display
     *
     */

    private function _activate($offset, $order_by, $sort_order, $search) {

        if (! self::check_permissions(10)) {
            redirect("/private/no_access");
        }

        if (!$this->list_members_model->activate_checked($_POST['mass'])) {
            $this->session->set_flashdata('error', '<p>Nobody was activated.</p>');
        }else{
            $this->session->set_flashdata('success', '<p>Activated '. count($_POST['mass']) .' members.</p>');
        }

        redirect('/adminpanel/list_members/index/'. $order_by .'/'. $sort_order .'/'. $search .'/'. $offset);
    }

    /**
     *
     * _deactivate: make inactive selected members
     *
     * @param int $id the id of the member to be deactivated
     * @param int $offset the offset to be used for selecting data
     * @param int $order_by order by this data column
     * @param string $sort_order asc or desc
     * @param string $search search type, used in index to determine what to display
     *
     */

    private function _deactivate($offset, $order_by, $sort_order, $search) {

        if (! self::check_permissions(10)) {
            redirect("/private/no_access");
        }

        if (!$this->list_members_model->deactivate_checked($_POST['mass'])) {
            $this->session->set_flashdata('error', '<p>Nobody was deactivated.</p>');
        }else{
            $this->session->set_flashdata('success', '<p>Deactivated '. count($_POST['mass']) .' members.</p>');
        }

        redirect('/adminpanel/list_members/index/'. $order_by .'/'. $sort_order .'/'. $search .'/'. $offset);
    }
}

/* End of file List_members.php */
/* Location: ./application/controllers/adminpanel/List_members.php */
