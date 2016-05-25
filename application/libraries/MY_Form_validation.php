<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

    public function __construct()
    {
        parent::__construct();
    }

    public function error_array() {
        return $this->_error_array;
    }


    // public function is_valid_password($password) {
    //     if(preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/',$password)){
    //         return true;
    //     }
    //     return false;
    // }

    /**
     *
     * is_valid_email: verify validity of e-mail addresses - is also used for AJAX calls
     *
     * @param string $email the e-mail address to be validated
     * @return boolean
     *
     */

    public function is_valid_email($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
            $domain = explode("@", $email);
            if(checkdnsrr(array_pop($domain), "MX") != false) {
                return true;
            }
        }
        return false;
    }

    /**
     *
     * is_valid_password: verify whether password is strict enough
     *
     * @param string $password the password to be validated
     * @return boolean
     *
     */

    public function is_valid_password($password) {
        if(preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=.\-_*])([a-zA-Z0-9@#$%^&+=*.\-_]){6,20}$/',$password)){

            return true;
        }
        return false;
    }

    public function is_valid_phone($phone) {
        if(preg_match('/^((((\\+[\\d\\-.]{1,5})?[ \\-.]?\\d{3})|(\\+[\\d\\-.]{1,5})?[ \\-.]?\\((\\d{3}\\)))?[ \\-.]?\\d{3}[ \\-.]?\\d{4}\\s?(e?x?t?\\.?\\s?\\d{1,7})?)?$/',$phone)){

            return true;
        }
        return false;
    }

    /**
     *
     * is_valid_username: verify validity of username against regular expression: a-z, A-Z, 0-9, _, - are allowed
     *
     * @param string $username the username to be validated
     * @return boolean
     *
     */

    public function is_valid_username($username) {
        if (preg_match("/^[a-zA-Z0-9._-]+$/", $username)) {
            return true;
        }
        return false;
    }

    /**
     *
     * is_db_cell_available: check for the existence of a unique field within a database table column
     *
     * @param string $value
     * @param string $info a string
     * @return boolean
     *
     */

    public function is_db_cell_available($value, $info) {

        list($table, $column) = explode('.', $info, 2);

        $this->CI->db->select($column);
        $this->CI->db->from($table);
        $this->CI->db->where($column, $value);
        $this->CI->db->limit(1);

        $query = $this->CI->db->get();

        if($query->num_rows() == 0) {
            return true;
        }
        return false;
    }

    /**
     *
     * is_db_cell_available_by_id: check for the existence of a unique field within a database table column EXCEPMTING
     *                                 the row for which the ID is passed
     *
     * @param string $value
     * @param string $info a string
     * @return boolean
     *
     */

    public function is_db_cell_available_by_id($value, $info) { // do not use for table user (id is user_id)

        list($table, $column, $id, $id_column) = explode('.', $info, 4);

        if ($id != strval(intval($id))) {return false;}

        $this->CI->db->select($column);
        $this->CI->db->from($table);
        $this->CI->db->where($column, strtolower($value));
        $this->CI->db->where($id_column .' !=', $id);
        $this->CI->db->limit(1);

        $query = $this->CI->db->get();

        if($query->num_rows() == 0) {
            return true;
        }
        return false;
    }

    /**
     *
     * check_captcha: verify the reCaptcha answer
     *
     * @param string $val the input to be validated
     * @return boolean
     *
     */

    function check_captcha($val) {
        return $this->CI->recaptchav2->verifyResponse($val); // this is the v2 code, the v1 code is commented out
        /*if ($this->CI->recaptcha->check_answer($this->CI->input->ip_address(), $this->CI->input->post('recaptcha_challenge_field'), $val)) {
            return true;
        }
        return false;*/
	}

    /**
     *
     * is_member_password: check for the existence of a unique field within a database table column
     *
     * @param string $password the password to be checked
     * @return boolean
     *
     */

    public function is_member_password($password) {

        $this->CI->db->select('nonce, password');
        $this->CI->db->from('users');
        $this->CI->db->where('username', $this->CI->session->userdata('username'));
        $this->CI->db->limit(1);

        $query = $this->CI->db->get();

        if($query->num_rows() == 1) {
            $this->CI->load->helper('password');
            $row = $query->row();

            if (hash_password($password, $row->nonce) == $row->password) {
                return true;
            }
        }
        return false;
    }

    public function is_value_exists($value, $info) {

        list($table, $column) = explode('.', $info, 2);

        $this->CI->db->select($column);
        $this->CI->db->from($table);
        $this->CI->db->where($column, $value);
        $this->CI->db->limit(1);

        $query = $this->CI->db->get();

        if($query->num_rows() > 0) {
            return true;
        }
        return false;
    }


    public function is_valid_both_password($new_password) {
        $this->CI->db->select('password, nonce');
        $this->CI->db->from('users');
        $this->CI->db->where('username', $this->CI->session->userdata('username'));
        $this->CI->db->limit(1);

        $query = $this->CI->db->get();

        if($query->num_rows() == 1) {
            $this->CI->load->helper('password');
            $row = $query->row();

            if(hash_password($new_password, $row->nonce) != $row->password) {
                return true;
            }
        }
        return false;
    }

    public function is_valid_new_password($password) {

        if(preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=.\-_*])([a-zA-Z0-9@#$%^&+=*.\-_]){6,20}$/',$password)){
            return true;
        }
        return false;
    }

    public function is_valid_confirm_password($password) {

        if(preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=.\-_*])([a-zA-Z0-9@#$%^&+=*.\-_]){6,20}$/',$password)){
            return true;
        }
        return false;
    }

    public function is_valid_time($time){

        if(preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/',$time)){
            return true;
        }
        return false;
    }

}
