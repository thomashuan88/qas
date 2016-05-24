<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Default_page extends Private_Controller {

    public function __construct()
    {
        parent::__construct();
        redirect('adminpanel/list_members');
    }

    public function index() {
        // set content data
        // $content_data['welcome'] = "Welcome, ". $this->session->userdata('username') ."!";
        // $content_data['explanation'] = "This page is the default page where members will arrive when logging in though this
        // can be easily changed via the site settings section.";
        // $content_data['features_list'] = array(
        //     "highly secure password algorithm with salt and key in a 128-long encrypted variable",
        //     "separate password and username retrieval",
        //     "resend activation link",
        //     "jQuery as well as PHP field validation",
        //     "3 ways to configure mail setup",
        //     "database sessions and site settings",
        //     "cookies that remember login",
        //     "members can edit their profile",
        //     "ACL: roles anc permissions",
        //     "theming",
        //     "export members list to e-mail in delimited text file",
        //     "backup database to e-mail in sql file",
        //     "clear session data option",
        //     "highly configurable site options",
        //     "focus is on easy to understand, quick and clean coding"
        // );

        // $this->template->set_metadata('description', 'Default page meta description can be set through controller.');
        // // More examples below:
        // // $this->template->prepend_metadata('<link href="">');
        // // $this->template->append_metadata('<script type=""></script>');
        // // $this->template->set_js('[choose name]', base_url() .'assets/js/vendor/[filename]');
        // // $this->template->set_css('[choose name]', base_url() .'assets/css/[filename]');

        //     $this->quick_page_setup(Settings_model::$db_config['adminpanel_theme'], 'adminpanel', 'Default page', 'private/default_page', 'header', 'footer', Settings_model::$db_config['active_theme'], $content_data);
    }

}

/* End of file Default_page.php */
/* Location: ./application/controllers/private/Default_page.php */