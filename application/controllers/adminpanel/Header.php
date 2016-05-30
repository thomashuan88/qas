  <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Header extends Admin_Controller {

	public function __construct(){
        parent::__construct();

     }

  public function change_language(){
    
    $data['language'] = $this->input->post('language') ;
    $this->session->set_userdata('language', $data['language']);
    $language = $this->session->userdata("language");
    $this->lang->load("messages_lang", $language);
    }
}