<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends Private_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'file'));
    }

    public function index() {
        // todo: direct access denied message
        redirect('login');
        //$this->load->view('private/upload', array('error' => ''));
    }

    public function upload_profile_picture() {

        if ($this->input->is_ajax_request()) {

            require APPPATH . 'vendor/Gargron-FileUpload/autoload.php';

            // Simple validation
            $validator = new FileUpload\Validator\Simple(50000, ['image/png', 'image/jpg', 'image/jpeg']);

            // Simple path resolver, where uploads will be put
            $pathresolver = new FileUpload\PathResolver\Simple('uploads/');

            // The machine's filesystem
            $filesystem = new FileUpload\FileSystem\Simple();

            // FileUploader itself
            $fileupload = new FileUpload\FileUpload($_FILES['files'], $_SERVER);

            // Adding it all together. Note that you can use multiple validators or none at all
            $fileupload->setPathResolver($pathresolver);
            $fileupload->setFileSystem($filesystem);
            $fileupload->addValidator($validator);

            // Doing the deed
            list($files, $headers) = $fileupload->processAll();

            // Move file to correct member image directory
            $path_parts = pathinfo(FCPATH . 'uploads/'. $files[0]->name);
            $ext = $path_parts['extension']; // get the extension of the file
            $new_name = "profile.".$ext; // set new name with dynamic extension

            $glob = glob(FCPATH .'assets/img/members/'. $this->session->userdata('username') .'/profile.{jpg,jpeg,png}', GLOB_BRACE);
            $this->_delete_profile_pictures($glob);

            $filesystem->moveUploadedFile(FCPATH . 'uploads/'. $files[0]->name, FCPATH .'assets/img/members/'. $this->session->userdata('username') .'/'. $new_name);

            // Outputting it, for example like this
            foreach($headers as $header => $value) {
                header($header . ': ' . $value);
            }

            echo json_encode(array('files' => $files));
        }else{
            echo false;
        }
    }

    public function delete_profile_picture() {
        $glob = glob(FCPATH .'assets/img/members/'. $this->session->userdata('username') .'/profile.{jpg,jpeg,png}', GLOB_BRACE);

        if ($glob) {
            $this->_delete_profile_pictures($glob);
            redirect('private/profile');
        }else{
            $this->session->set_flashdata('error', '<p>Nothing deleted.</p>');
            redirect('private/profile');
        }
    }


    private function _delete_profile_pictures($glob) {
        foreach ($glob as $img) {
            unlink($img);
        }
    }

}