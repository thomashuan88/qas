<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function save_setting($data)
    {
        $this->db->insert('system_setting', $data);
        return $this->db->affected_rows();

    }

    public function get_shift()
    {
    	$this->db->select('sid, type, key, value');
    	$this->db->from('system_setting');
    	$this->db->where('type', 'shift');
    	$query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        }
        return false;
    }

    public function get_product()
    {
    	$this->db->select('sid, type, key, value');
    	$this->db->from('system_setting');
    	$this->db->where('type', 'product');
    	$query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        }
        return false;
    }

    public function get_one_record($key)
    {
    	$this->db->select('sid, type, key, value');
        $this->db->from('system_setting');
        $this->db->where('sid', $key);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }


    public function edit_shift($data) {
        if ($this->is_exist($data['id'])) {
            $new_data = array(
            	'type' => 'shift',
                'key' => $data['shift'],
                'value' => $data['hour'],
            );
            $this->db->where('sid', $data['id']);
            $this->db->update('system_setting', $new_data);
            return true;
        } else {
            return false;
        }
    }

    public function edit_product($data) {
        if ($this->is_exist($data['id'])) {
            $new_data = array(
            	'type' => 'product',
                'key' => $data['product'],
                'value' => $data['product'],
            );
            $this->db->where('sid', $data['id']);
            $this->db->update('system_setting', $new_data);
            return true;
        } else {
            return false;
        }
    }

    private function is_exist($key) {
        $this->db->select('sid, type, key, value');
        $this->db->from('system_setting');
        $this->db->where('sid', $key);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }


    public function save_system_settings($data)
    {
        $this->db->update('settings', $data);
        if($this->db->affected_rows() == 1) {
            return true;
        }
        return false;
    }

}
