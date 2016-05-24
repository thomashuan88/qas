<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends Private_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index() {
        // set content data
        $this->load->model('private/profile_model');
        $content_data = $this->profile_model->get_profile();

        $this->template->set_js('widget', base_url() .'assets/js/vendor/jquery.ui.widget.js');
        $this->template->set_js('upload', base_url() .'assets/js/vendor/jquery.fileupload.js');

        if ($glob = glob(FCPATH .'assets/img/members/'. $this->session->userdata('username') .'/profile.{jpg,jpeg,png}', GLOB_BRACE)) {
            $content_data->profile_image = true;
            $path_parts = pathinfo($glob[0]);
            //var_dump($path_parts);
            $content_data->ext = $path_parts['extension']; // get the extension of the file
        }

        //var_dump($content_data);

        $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', $this->lang->line('my_profile'), 'private/profile', 'header', 'footer', Settings_model::$db_config['active_theme'], $content_data);
    }

    /**
     *
     * update_account: change member info
     *
     *
     */

    public function update_account() {
        // form input validation
        if ($this->input->post('user_id') != strval(intval($this->input->post('user_id')))) {
            redirect('private/profile');
        }
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('first_name', $this->lang->line('first_name'), 'trim|required|max_length[40]|min_length[2]');
        $this->form_validation->set_rules('last_name', $this->lang->line('last_name'), 'trim|required|max_length[60]|min_length[2]');
        $this->form_validation->set_rules('email', $this->lang->line('email_address'), 'trim|max_length[255]|is_valid_email|is_db_cell_available_by_id[users.email.'. $this->input->post('user_id') .'.user_id]');
        $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required|is_member_password');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('private/profile');
            exit();
        }

        $this->load->model('private/profile_model');
        $this->profile_model->set_profile($this->input->post('first_name'), $this->input->post('last_name'), $this->input->post('email'));
        $this->session->set_flashdata('success', '<p>'. $this->lang->line('account_updated') .'</p>');
        redirect('private/profile');
        exit();
    }

    /**
     *
     * update_password: change member password
     *
     *
     */

    public function update_password() {
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('current_password', $this->lang->line('current_password'), 'trim|required|max_length[64]|is_member_password');
        $this->form_validation->set_rules('new_password', $this->lang->line('new_password'), 'trim|required|max_length[64]|min_length[9]|matches[new_password_again]|is_valid_password');
        $this->form_validation->set_rules('new_password_again', $this->lang->line('new_password_again'), 'trim|required|max_length[64]|min_length[9]');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('pwd_error', validation_errors());
            redirect('private/profile#profile_pwd_form');
            exit();
        }

        $this->load->model('private/profile_model');
        if ($this->profile_model->set_password($this->input->post('new_password'))) {
            if ($this->input->post('send_copy') != "") {
                $this->load->helper('send_email');
                $this->load->library('email', load_email_config(Settings_model::$db_config['email_protocol']));
                $this->email->from(Settings_model::$db_config['admin_email_address'], $_SERVER['HTTP_HOST']);
                $this->email->to($this->input->post('email'));
                $this->email->subject($this->lang->line('profile_subject'));
                $this->email->message($this->lang->line('email_greeting') ." ". $this->session->userdata('username') . $this->lang->line('profile_message') . addslashes($this->input->post('new_password')));
                $this->email->send();
            }
            $this->session->set_flashdata('pwd_success', '<p>'. $this->lang->line('profile_success') .'</p>');
        }
        redirect('private/profile');
    }
	
	/**
     *
     * delete_account: delete all user data!
     *
     */
	
	public function delete_account() {
		if ($this->session->userdata('username') == ADMINISTRATOR) {
			$this->session->set_flashdata('error', '<p>Not allowed to delete administrator account.</p>');
			redirect('private/profile'); 
		}
		
		$this->load->model('private/profile_model');
		if ($this->profile_model->delete_membership()) {

            // delete img folders
            $path = FCPATH .'assets/img/members/'. $this->session->userdata('username');
            $this->load->helper("file"); // load the helper
            delete_files($path, true); // delete all files/folders
            rmdir($path); // remove member folder

			redirect("logout"); // logout controller destroys session and cookies
		}
		$this->session->set_flashdata('error', '<p>Failed to remove your profile.</p>');
		redirect('private/profile');
	}


    public function do_upload() {

        $upload_path_url = base_url() . 'uploads/';

        $config['upload_path'] = FCPATH . 'uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = '30000';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload()) {
            $data = $this->upload->data();

            $info = new StdClass;
            $info->name = $data['file_name'];
            $info->size = $data['file_size'] * 1024;
            $info->type = $data['file_type'];
            $info->url = $upload_path_url . $data['file_name'];
            $info->deleteUrl = base_url() . 'private/profile/deleteImage/' . $data['file_name'];
            $info->deleteType = 'DELETE';
            $info->error = null;

            $files[] = $info;
            //this is why we put this in the constants to pass only json data
            if ($this->input->is_ajax_request()) {
                echo json_encode(array("files" => $files));
                //this has to be the only data returned or you will get an error.
                //if you don't give this a json array it will give you a Empty file upload result error
                //it you set this without the if($this->input->is_ajax_request())...else... you get ERROR:TRUE (my experience anyway)
                // so that this will still work if javascript is not enabled
            } else {
                $file_data['upload_data'] = $this->upload->data();
                //$this->load->view('upload/upload_success', $file_data);
                //echo json_encode(array("success" => "OK!!!Bruno"));
            }
        }
    }



    public function deleteImage($file) {//gets the job done but you might want to add error checking and security
        $success = unlink(FCPATH . 'uploads/' . $file);
        $success = unlink(FCPATH . 'uploads/thumbs/' . $file);
        //info to see if it is doing what it is supposed to
        $info = new StdClass;
        $info->sucess = $success;
        $info->path = base_url() . 'uploads/' . $file;
        $info->file = is_file(FCPATH . 'uploads/' . $file);

        if (IS_AJAX) {
            //I don't think it matters if this is set but good for error checking in the console/firebug
            echo json_encode(array($info));
        } else {
            //here you will need to decide what you want to show for a successful delete
            $file_data['delete_data'] = $file;
            $this->load->view('admin/delete_success', $file_data);
        }
    }






}

/* End of file Profile.php */
/* Location: ./application/controllers/private/Profile.php */