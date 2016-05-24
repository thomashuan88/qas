<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Settings extends Admin_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('encrypt');
        $this->load->library('form_validation');
        $this->load->model('adminpanel/setting_model');

    }

     public function index() {
        
        if (! self::check_permissions(21)) {
            redirect("/private/no_access");
        }

        if (! self::check_action(21)) {
            redirect("/private/no_access");
        }
        $this->load->model('adminpanel/setting_model');
        $content_data['shift'] = $this->setting_model->get_shift();
        $content_data['product'] = $this->setting_model->get_product();
        $live_person = $this->setting_model->get_live_person();
        
        $arr = array();
          foreach($live_person as $value){
              $arr[$value->group][$value->key] = $value->value;
          }
        
        $content_data["live_person"] = $arr; 


        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('settings'), 'settings', 'header', 'footer', '', $content_data);
    }



 	// public function save_shift()
  //   {
  //       $this->form_validation->set_error_delimiters('<p>', '</p>');
  //       $this->form_validation->set_rules('shift','working shift','trim|required');
  //       $this->form_validation->set_rules('hour','working hour','trim|required');

  //       if (!$this->form_validation->run()) {
  //           $this->session->set_flashdata('error', validation_errors());
  //           redirect('/adminpanel/system_settings');
  //           exit();
  //       }

  //       $data = array(
  //           'type' => 'shift',
  //           'key' => $this->input->post('shift'),
  //           'value' => $this->input->post('hour'),
  //       );

  //       $this->load->model('adminpanel/system_settings_model');

  //       if ($this->system_settings_model->save_setting($data)) {
  //           $this->session->set_flashdata('success', '<p>'. $this->lang->line('settings_update') .'</p>');
  //           //unlink(APPPATH .'cache/settings.cache');
  //           $this->load->library('cache');
  //           $this->cache->delete('settings');
  //       }

  //       redirect('/adminpanel/system_settings/'.'?tab=shift');
  //   }


    public function save_product()
    {
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('product','product type','trim|required|is_db_cell_available[system_setting.value]');

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

        $this->load->model('adminpanel/setting_model');

        if ($this->setting_model->save_setting($data)) {
            $this->session->set_flashdata('success', '<p>'. $this->lang->line('settings_update') .'</p>');
            //unlink(APPPATH .'cache/settings.cache');
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
      if (!empty($key)) {
        $content_data = array();
        $content_data['shift'] = $this->setting_model->get_one_record($key);
        if (!empty($content_data['shift'])) {
            $post_data = $this->input->post();
            if (!empty($post_data)) {
                $this->form_validation->set_error_delimiters('<p>', '</p>');
                $this->form_validation->set_rules('shift','working shift','trim|required');
                $this->form_validation->set_rules('hour','working hour','trim|required|is_db_cell_available[system_setting.value]|is_valid_time');

                if (!$this->form_validation->run()) {
                        $this->session->set_flashdata('error', validation_errors());
                        redirect('/adminpanel/settings/edit_shift/'.$key);
                }
                $post_data['id'] = $key;
                $res = $this->setting_model->edit_shift($post_data);
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
    redirect('/adminpanel/settings/');


   }


   public function edit_product($key)
   {
      if (!empty($key)) {
        $content_data = array();
        $content_data['product'] = $this->setting_model->get_one_record($key);
        if (!empty($content_data['product'])) {
            $post_data = $this->input->post();

            if (!empty($post_data)) {
                $this->form_validation->set_error_delimiters('<p>', '</p>');
                $this->form_validation->set_rules('product','product type','trim|required|is_db_cell_available[system_setting.value]');

                if (!$this->form_validation->run()) {
                        $this->session->set_flashdata('error', validation_errors());
                        redirect('/adminpanel/settings/edit_product/'.$key);
                }
                $post_data['id'] = $key;

                $res = $this->setting_model->edit_product($post_data);
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

   public function save_system_settings(){

    $this->form_validation->set_rules('site_title', $this->lang->line('site_title'), 'trim|required');

    if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('/adminpanel/settings/'.'?tab=system');
            exit();
    }

    $data = array('site_title' => $this->input->post('site_title'));

    $this->load->model('setting_model');

    if ($this->setting_model->save_system_settings($data)) {

      $this->session->set_flashdata('success', '<p>'. $this->lang->line('settings_update') .'</p>');
  
      $this->load->library('cache');
      $this->cache->delete('settings');
      $this->session->set_userdata('language', $this->input->post('language'));
      $language = $this->session->userdata("language");
      $this->lang->load("messages_lang", $language);
    }
    redirect('/adminpanel/settings/'.'?tab=system');
   }

  public function live_person_settings_add()
   {
        $content_data = array();

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('settings'), 'live_person_settings_add', 'header', 'footer', '', $content_data);

   }
  
  public function save_live_person(){

    $this->form_validation->set_error_delimiters('<p>', '</p>');
    $this->form_validation->set_rules('product','Product Type','trim|required');
    $this->form_validation->set_rules('account_id','Account ID','trim|required');
    $this->form_validation->set_rules('consumer_key','Consumer Key','trim|required');
    $this->form_validation->set_rules('consumer_secret','Consumer Secret','trim|required');
    $this->form_validation->set_rules('access_token','Access Token','trim|required');
    $this->form_validation->set_rules('access_token_secret','Access Token Secret','trim|required');

    if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('/adminpanel/settings/'.'?tab=live_person');
            exit();
    }

    $this->load->model('adminpanel/setting_model');
    $key = array('account_id', 'consumer_key', 'consumer_secret', 'access_token', 'access_token_secret');

    foreach($key as $value){
      $data = array(
            'type' => 'live_person',
            'group' => $this->input->post('product'),
            'key' => $value,
            // 'value' => $this->input->post($value)
          );

      $this->setting_model->save_setting($data);
    }
 
    if ($this->setting_model->save_setting($data)) {
          $this->session->set_flashdata('success', '<p>'. $this->lang->line('settings_update') .'</p>');
          $this->load->library('cache');
          $this->cache->delete('settings');
    }
    redirect('/adminpanel/settings/'.'?tab=live_person');

   }
}