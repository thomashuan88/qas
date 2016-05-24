<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('init_providers')) {
    /**
     *
     * init_providers: grab all active providers, pass received & created data, set sessions
     *
     *
     */
    function init_providers() {

        $_ci =& get_instance();

        $_ci->load->model('auth/OAuth2_model');

        $data = $_ci->OAuth2_model->get_all();

        if ($data) {
            require APPPATH . 'vendor/PHPLeague-OAuth2/autoload.php';

            $i=0;
            foreach ($data as $row) {
                $_ci->load->library('OAuth2/'. $row->name);
                $data['providers'][strtolower($row->name)]['url'] = $_ci->{strtolower($row->name)}->loadProviderClass($row);
                $data['providers'][strtolower($row->name)]['name'] = $row->name;
                $_SESSION[strtolower($row->name) .'state'] = $_ci->{strtolower($row->name)}->getState();
                $i++;
            }

            return $data;
        }

        return array();
    }
}


if (!function_exists('unload_provider_session_data')) {
    /**
     *
     * unload_provider_session_data: unset all provider session data
     *
     *
     */
    function unload_provider_session_data() {

        $_ci =& get_instance();

        $_ci->load->model('auth/OAuth2_model');

        $data = $_ci->OAuth2_model->get_all();

        if ($data) {
            foreach ($data as $row) {
                $_ci->session->unset_userdata(strtolower($row->name) .'state');
            }

        }
    }
}

/* End of file oauth2_helper.php */
/* Location: ./application/helpers/oauth2_helper.php */