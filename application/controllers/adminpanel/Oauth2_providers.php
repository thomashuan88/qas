<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OAuth2_providers extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('adminpanel/oauth2_providers_model');

        if (! self::check_permissions(7)) {
            redirect("/private/no_access");
        }
    }

    public function index() {
        $content_data['providers'] = $this->oauth2_providers_model->get_providers();
        $content_data['enabled'] = array('1' => 'Yes', '0' => 'No');
        $content_data['enabled_selected'] = '0';

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('oauth2 providers title'), 'oauth2_providers', 'header', 'footer', '', $content_data);
    }

    /**
     *
     * action: used to handle both save and delete below
     *
     */

    public function action() {
        if (isset($_POST['delete'])) {
            $this->_delete();
        }else{ // delete needs to be sent or else it will always save, for example when hitting enter on keyboard
            $this->_save();
        }
    }

    private function _save() {
        if ($this->input->post('id') != strval(intval($this->input->post('id')))) {
            redirect('/adminpanel/oauth2_providers');
        }

        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('name', $this->lang->line('provider_name'), 'trim|required|max_length[50]|min_length[2]');
        $this->form_validation->set_rules('client_id', $this->lang->line('provider_client_id'), 'trim|required|max_length[255]|min_length[2]');
        $this->form_validation->set_rules('client_secret', $this->lang->line('provider_client_secret'), 'trim|required|max_length[255]|min_length[2]');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('/adminpanel/oauth2_providers');
            exit();
        }

        $data = array(
            'id' => $this->input->post('id'),
            'name' => $this->input->post('name'),
            'client_id' => $this->input->post('client_id'),
            'client_secret' => $this->input->post('client_secret'),
            'enabled' => $this->input->post('enabled') == 1 ? true : false,
        );

        if ($this->oauth2_providers_model->save_provider($data)) {
            $this->session->set_flashdata('success', '<p>Provider saved.</p>');
        }

        redirect('/adminpanel/oauth2_providers');
    }

    private function _delete() {
        if ($this->input->post('id') != strval(intval($this->input->post('id')))) {
            redirect('/adminpanel/oauth2_providers');
        }

        if ($this->oauth2_providers_model->delete_provider($this->input->post('id'))) {
            $this->session->set_flashdata('success', '<p>Provider deleted.</p>');
        }

        redirect('/adminpanel/oauth2_providers');
    }

}

/* End of file OAuth2_providers.php */
/* Location: ./application/controllers/adminpanel/OAuth2_providers.php */