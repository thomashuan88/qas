<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_Controller extends MY_Controller
{
    public static $permissions = array();
    public static $roles = array();
    public static $page;
    public static $method;

    public function __construct()
    {
        parent::__construct();
        // set page name
        self::$page = $this->router->fetch_class();
        self::$method = $this->router->fetch_method();
         $this->load->model('adminpanel/role_permission_model');
    }


    public static function check_roles($role_id) {
        foreach (self::$roles as $role) {
            if (is_array($role_id)) {
                if (in_array ($role->role_id, $role_id)) {
                    return true;
                }
            }elseif ($role->role_id == $role_id) {
                return true;
            }
        }
        return false;
    }

    public static function check_permissions($permission_id) {
        foreach (self::$permissions as $permission) {
            if (is_array($permission_id)) {
                if (in_array ($permission->permission_id, $permission_id)) {
                    return true;
                }
            }elseif ($permission->permission_id == $permission_id) {
                if($permission->view == "yes"){
                    return true;
                }
            }
        }
        return false;
    }

    public static function check_action($permission_id) {
         foreach (self::$roles as $role) {
            $ci =& get_instance();
            return $ci->role_permission_model->select_action($role->role_id,$permission_id);  
        }
        return false;
    }

}
/* End of file Site_Controller.php */
/* Location: ./application/core/Site_Controller.php */ 