<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Settings extends Admin_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('encrypt');
        $this->load->library('form_validation');
        $this->load->model('adminpanel/system_settings_model');

        if (! self::check_permissions(22)) {
            redirect("/private/no_access");
        }
        $this->permission = self::check_action(22);
        $this->load->library('MY_Permission');

    }

     public function index() {
        
        $content_data['permission'] = array();
        ($this->permission->add == 'yes') ?  $content_data['permission']['add'] = TRUE : '';
        ($this->permission->edit == 'yes') ?  $content_data['permission']['edit'] = TRUE : '';

        $this->load->model('adminpanel/system_settings_model');
        $this->load->model('adminpanel/roles_model');
        $this->load->model('adminpanel/users_model');


        $current_user = $this->users_model->get_member_info($this->session->userdata('username'));

        $content_data['permission']['general_setting']['disable_input'] = ($current_user->role == "Administrator")?' ' : 'disabled';


        $content_data['permission']['mail_setting']['disable_input'] = ($current_user->role == "Administrator" )?' ' : 'disabled';

        $content_data['shift'] = $this->system_settings_model->get_shift();
        $content_data['product'] = $this->system_settings_model->get_product();
        $content_data['roles'] = $this->roles_model->get_role_name();


        $live_person = $this->system_settings_model->get_live_person();

        if(!empty($live_person)){

        $arr = array();
          foreach($live_person as $value){
              $arr[$value->group][$value->key] = $value->value;
          }
        $content_data["live_person"] = $arr; 

      }
      $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('settings'), 'settings', 'header', 'footer', '', $content_data);
    }

    public function save_product()
    {

        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('product',$this->lang->line('product_type'),'trim|required|is_db_cell_available[system_setting.value]');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('/adminpanel/settings/product_settings_add');
            exit();
        }

        $data = array(
            'type' => 'product',
            'key' => $this->input->post('product'),
            'value' => $this->input->post('product'),
        );        

        $this->load->model('adminpanel/system_settings_model');

        if ($this->system_settings_model->save_setting($data)) {
            $this->session->set_flashdata('success', '<p>'. $this->lang->line('settings_update') .'</p>');
            $this->load->library('cache');
            $this->cache->delete('settings');
        }
        redirect('/adminpanel/settings/'.'?tab=product');
    }

   public function product_settings_add()
   {
        $content_data = array();

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('settings'), 'product_settings_add', 'header', 'footer', '', $content_data);

   }

   public function edit_shift($key)
   {
      if($this->permission->edit != 'yes'){
            redirect("/private/no_access");
      };

      if (!empty($key)) {
        $content_data = array();
        $content_data['shift'] = $this->system_settings_model->get_one_record($key);
        if (!empty($content_data['shift'])) {
            $post_data = $this->input->post();
            if (!empty($post_data)) {
                $this->form_validation->set_error_delimiters('<p>', '</p>');
                $this->form_validation->set_rules('shift',$this->lang->line('working_shift'),'trim|required');
                $this->form_validation->set_rules('hour',$this->lang->line('working_hour'),'trim|required|is_db_cell_available[system_setting.value]|is_valid_time');

                if (!$this->form_validation->run()) {
                        $this->session->set_flashdata('error', validation_errors());
                        redirect('/adminpanel/settings/edit_shift/'.$key);
                }
                $post_data['id'] = $key;
                $res = $this->system_settings_model->edit_shift($post_data);
                if ($res) {
                    $this->session->set_flashdata('success', $this->lang->line('update_success'));
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('update_failure'));
                }
            }else {
                return $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('settings'), 'shift_settings_edit', 'header', 'footer', '', $content_data);
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('no_result'));
        }
    } else {
            $this->session->set_flashdata('error', $this->lang->line('invalid_data'));
    }
        redirect('/adminpanel/settings/'.'?tab=shift');
   }

   public function edit_product($key)
   {
      if($this->permission->edit != 'yes'){
            redirect("/private/no_access");
      };

      if (!empty($key)) {
        $content_data = array();
        $content_data['product'] = $this->system_settings_model->get_one_record($key);
        if (!empty($content_data['product'])) {
            $post_data = $this->input->post();

            if (!empty($post_data)) {
                $this->form_validation->set_error_delimiters('<p>', '</p>');
                $this->form_validation->set_rules('product',$this->lang->line('product_type'),'trim|required|is_db_cell_available[system_setting.value]');

                if (!$this->form_validation->run()) {
                        $this->session->set_flashdata('error', validation_errors());
                        redirect('/adminpanel/settings/edit_product/'.$key);
                }
                $post_data['id'] = $key;

                $res = $this->system_settings_model->edit_product($post_data);
                if ($res) {
                    $this->session->set_flashdata('success', $this->lang->line('update_success'));
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('update_failure'));
                }
            }else {
                return $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('settings'), 'product_settings_edit', 'header', 'footer', '', $content_data);
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('no_result'));
        }
    } else {
            $this->session->set_flashdata('error', $this->lang->line('invalid_data'));
    }

    redirect('/adminpanel/settings/'.'?tab=product');

   }

   public function save_general_setting(){

    if($this->permission->edit != 'yes'){
            redirect("/private/no_access");
      };

    $this->form_validation->set_error_delimiters('<p>', '</p>');
    $this->form_validation->set_rules('site_title', $this->lang->line('site_title'), 'trim|required');
    $this->form_validation->set_rules('site_language', $this->lang->line('site_language'), 'trim|required');
    $this->form_validation->set_rules('system_role', $this->lang->line('system_role'), 'trim|required');
    $this->form_validation->set_rules('predefined_email', $this->lang->line('predefined_email'), 'trim|required');
    $this->form_validation->set_rules('userfile', $this->lang->line('logo'),'');
    $this->form_validation->set_rules('footer_title', $this->lang->line('footer_title'), 'trim|required');
    $this->form_validation->set_rules('data_mask', $this->lang->line('confidential_data_masking'), 'trim|required');
    $this->form_validation->set_rules('search_section', $this->lang->line('search_section'));
    $this->form_validation->set_rules('operator_leader_role', $this->lang->line('operator_leader_role'));


    if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('/adminpanel/settings/'.'?tab=system');
            exit();
    }
    
    $config['upload_path'] = './assets/img';
    $config['allowed_types'] = 'gif|jpg|png|jpeg';
    $config['max_size'] = '0';
    $config['max_width']  = '3000';
    $config['max_height']  = '2000';
    $config['overwrite']  = TRUE;
    $config['file_name'] = 'Logo';
    $this->load->library('upload', $config);
    $this->upload->do_upload('userfile');
    $data = $this->upload->data(); 
    $config['image_library'] = 'gd2';
    $config['source_image'] = $data['full_path'];
    $config['maintain_ratio'] = TRUE;
    $config['width'] = '50';
    $config['height'] = '50';


    $this->load->library('image_lib', $config); 
    $this->image_lib->resize();

    $data = array(
          'site_title' => $this->input->post('site_title'),
          'site_language' => $this->input->post('site_language'),
          'system_role' => $this->input->post('system_role'),
          'predefined_email' => $this->input->post('predefined_email'),
          'footer_title' => $this->input->post('footer_title'),
          'data_mask' =>  $this->input->post('data_mask'),
          'search_section' =>  $this->input->post('search_section'),
          'operator_leader_role' =>  $this->input->post('operator_leader_role'),
      );

    if(!empty($_FILES) && $_FILES['userfile']['name'] != '')
    {
      $extension = end((explode(".", $_FILES["userfile"]["name"])));
      $data['logo'] = 'Logo.'.$extension;
    }

    $this->load->model('system_settings_model');

    if ($this->system_settings_model->save_system_settings($data)) {


      $this->session->set_flashdata('success', '<p>'. $this->lang->line('settings_update') .'</p>');
      $this->load->library('cache');
      $this->cache->delete('settings');

    }
    redirect('/adminpanel/settings/');
   }

   public function save_mail_setting(){

    if($this->permission->edit != 'yes'){
            redirect("/private/no_access");
      };

    $this->form_validation->set_error_delimiters('<p>', '</p>');
    $this->form_validation->set_rules('admin_email', $this->lang->line('admin_email'), 'trim|required');
    $this->form_validation->set_rules('smtp_user', $this->lang->line('smtp_user'), 'trim|required');
    $this->form_validation->set_rules('send_mail_path', $this->lang->line('send_mail_path'), 'trim|required');
    $this->form_validation->set_rules('smtp_password', $this->lang->line('smtp_password'), 'trim|required');
    $this->form_validation->set_rules('email_protocol', $this->lang->line('email_protocol'), 'trim|required');
    $this->form_validation->set_rules('smtp_host', $this->lang->line('smtp_host'), 'trim|required');
    $this->form_validation->set_rules('smtp_port', $this->lang->line('smtp_port'), 'trim|required');

    if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('/adminpanel/settings/'.'?tab=mail_setting');
            exit();
    }

    $data = array(
          'admin_email' => $this->input->post('admin_email'),
          'smtp_user' => $this->input->post('smtp_user'),
          'sendmail_path' => $this->input->post('send_mail_path'),
          'smtp_pass' => $this->input->post('smtp_password'),
          'email_protocol' => $this->input->post('email_protocol'),
          'smtp_host' =>  $this->input->post('smtp_host'),
          'smtp_port' =>  $this->input->post('smtp_port')
      );

    $this->load->model('system_settings_model');

    if ($this->system_settings_model->save_system_settings($data)) {

      $this->session->set_flashdata('success', '<p>'. $this->lang->line('settings_update') .'</p>');
      $this->load->library('cache');
      $this->cache->delete('settings');

    }
    redirect('/adminpanel/settings/'.'?tab=mail_setting');
   }

  public function live_person_settings_add()
   {
      if($this->permission->add != 'yes'){
            redirect("/private/no_access");
      };
        $content_data = array();

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('settings'), 'live_person_settings_add', 'header', 'footer', '', $content_data);

   }
  
  public function save_live_person(){

      if($this->permission->add !== 'yes'){
            redirect("/private/no_access");
      };

    $this->form_validation->set_error_delimiters('<p>', '</p>');
    $this->form_validation->set_rules('product',$this->lang->line('product_type'),'trim|required|is_product_type_exists');
    $this->form_validation->set_rules('account_id',$this->lang->line('account_id'),'trim|required|is_account_id_exists');
    $this->form_validation->set_rules('consumer_key',$this->lang->line('consumer_key'),'trim');
    $this->form_validation->set_rules('consumer_secret',$this->lang->line('consumer_secret'),'trim');
    $this->form_validation->set_rules('access_token',$this->lang->line('access_token'),'trim');
    $this->form_validation->set_rules('access_token_secret',$this->lang->line('access_token_secret'),'trim');

    if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('/adminpanel/settings/live_person_settings_add');
            exit();
    }

    $this->load->model('adminpanel/system_settings_model');
    $key = array('account_id', 'consumer_key', 'consumer_secret' ,'access_token_secret','access_token');

    foreach($key as $value){

      $data = array(
            'type' => 'live_person',
            'group' => $this->input->post('product'),
            'key' => $value,
            'value' => $this->input->post($value)
          );
       if ($this->system_settings_model->save_setting($data)) {
          $this->session->set_flashdata('success', '<p>'. $this->lang->line('settings_update') .'</p>');
        }
    }
    redirect('/adminpanel/settings/'.'?tab=live_person');
   }



    public function edit_live_person($product_type){

      if($this->permission->edit != 'yes'){
            redirect("/private/no_access");
      };
      
      $product = urldecode($product_type);

      if (!empty($product)) {

        $live_person = $this->system_settings_model->get_one_live_person($product);
        $content_data = array();
        $arr = array();
          foreach($live_person as $value){
              $arr[$value->group][$value->key] = $value->value;
          }
        $content_data['live_person'] = $arr ;
        $content_data["product"] = $product;

        if (!empty($content_data['product'])) {
            $post_data = $this->input->post();
            if (!empty($post_data)) {
              $this->form_validation->set_error_delimiters('<p>', '</p>');
              $this->form_validation->set_rules('product',$this->lang->line('product_type'),'trim|required');
              $this->form_validation->set_rules('account_id',$this->lang->line('account_id'),'trim|required');
              $this->form_validation->set_rules('consumer_key',$this->lang->line('consumer_key'),'trim');
              $this->form_validation->set_rules('consumer_secret',$this->lang->line('consumer_secret'),'trim');
              $this->form_validation->set_rules('access_token',$this->lang->line('access_token'),'trim');
              $this->form_validation->set_rules('access_token_secret',$this->lang->line('access_token_secret'),'trim');

              if (!$this->form_validation->run()) {
                      $this->session->set_flashdata('error', validation_errors());
                      redirect('/adminpanel/settings/edit_live_person/'.$product);
              }
                $post_data['product'] = $product;

                $key = array('account_id', 'consumer_key', 'consumer_secret' ,'access_token_secret','access_token');

                foreach($key as $value){

                  $data = array(
                      'type' => 'live_person',
                      'group' => $this->input->post('product'),
                      'key' => $value,
                      'value' => $this->input->post($value)
                  );

                   if ($this->system_settings_model->edit_live_person($data, $product)) {
                    $this->session->set_flashdata('success', $this->lang->line('update_success'));
                  }
                  else{
                    $this->session->set_flashdata('error', $this->lang->line('update_failure'));
                  }
                }
            }else {
                 return $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('settings'), 'live_person_settings_edit', 'header', 'footer', '', $content_data);
            }
        }else {
            $this->session->set_flashdata('error', $this->lang->line('no_result'));
        }
    
      }else {
            $this->session->set_flashdata('error', $this->lang->line('invalid_data'));
      }
    redirect('/adminpanel/settings/'.'?tab=live_person');
   }


}