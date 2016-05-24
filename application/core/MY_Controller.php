<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $language = $this->session->userdata("language");
        $this->lang->load("messages_lang", $language);      
    }

    /**
     *
     * process_partial: load the default view when no view exists in the current theme's views folder
     *
     * @param $name string the name of the partial
     * @param $path the path to the correct view file
     * @return -
     *
     */

    public function process_partial($name, $path) {
        if (file_exists(APPPATH . 'views/themes/'. $path .'.php')) {
            $this->template->set_partial($name, 'themes/'. $path);
        }else{
            $this->template->set_partial($name, 'themes/bootstrap3/'. $path); // fallback
                 
        }
    }

    /**
     *
     * process_template_build: build the default view when no view is available in the current theme's views folder
     *
     * @param $path the path to the correct view file
     * @param $data array of data passed to view
     * @return -
     *
     */

    public function process_template_build($path, $data = null) {
        if (file_exists(APPPATH . 'views/themes/' . $path .'.php')) {
            $this->template->build('themes/'. $path, $data);
        }else{
            $this->template->build('themes/bootstrap3/'. $path, $data);


        }
    }

    /**
     *
     * quick_page_setup: a page preparation function for usage in controller index() to quickly configure page layout.
     *
     * @param $theme theme folder
     * @param $layout layout name php file
     * @param $title page title
     * @param $path correct path to view file
     * @param $viewTheme alternate folder location for views if you need some from other themes
     * @param $data array of data passed to view
     * @return -
     *
     */

    public function quick_page_setup($theme, $layout, $title, $path, $header, $footer, $viewTheme = "", $data = array()) {



        if (empty($viewTheme)) {
            $viewTheme = $theme;
        }


        $this->template->set_theme($theme);
        $this->template->set_layout($layout);
        $this->template->title($title);
        $this->process_partial('header', $theme .'/partials/'. $header);
        $this->process_partial('footer', $theme .'/partials/'. $footer);

        if (!empty($data)) {
            $this->process_template_build($viewTheme .'/'. $path, $data);
        }else{
            $this->process_template_build($viewTheme .'/'. $path);
        }

      
    }
}
/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */