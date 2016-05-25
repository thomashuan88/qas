<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Performance_daily_qa_model extends CI_Model {

	private $table = 'daily_qa';
    private $fields;

    public function __construct() {
        parent::__construct();
        $this->fields = $this->db->list_fields($this->table);
    }

    public function insert_multi_daily_qa( $daily_qa  ) {
    	$this->db->insert_batch( $this->table, $daily_qa );
    }

    public function get_daily_qa( $limit = 0, $offset = 0, $order_by = "import_date", $sort_order = "desc", $search_data = array() , $status = 1) {

        $this->db->select( array( 'daily_qa_id', 'username', 'yes', 'no', 'csi', 'art', 'aht', 'quantity', 'import_date', 'import_by' ) );
        $this->db->from($this->table);
        
        if(!empty($search_data)) {
	        foreach ($search_data as $searchKey => $searchValue) {
	        	$this->db->like( $searchKey, $searchValue );
	        }
        }
        
        $this->db->order_by($order_by, $sort_order);
        $this->db->limit($limit, $offset);
        $this->db->where('status', $status);

        $q = $this->db->get();

        if($q->num_rows() > 0) {
            return $q;
        }

        return false;
    }

    public function count_confirm_daily_qa($search_data = array()) {
        $this->db->select($this->fields);
        $this->db->from($this->table);

        if(!empty($search_data)) {
            foreach ($search_data as $searchKey => $searchValue) {
                $this->db->like( $searchKey, $searchValue );
            }
        }
        $this->db->where('status', 1);

        return $this->db->get()->num_rows();
    }

    public function count_pending_daily_qa($search_data = array()) {
        $this->db->select($this->fields);
        $this->db->from($this->table);

        if(!empty($search_data)) {
            foreach ($search_data as $searchKey => $searchValue) {
                $this->db->like( $searchKey, $searchValue );
            }
        }

        $this->db->where('status', 0);

        return $this->db->get()->num_rows();
    }
    public function count_not_current_upload($search_data = array()) {
        $this->db->select($this->fields);
        $this->db->from($this->table);

        if(!empty($search_data)) {
            foreach ($search_data as $searchKey => $searchValue) {
                $this->db->where( $searchKey, $searchValue );
            }
        }

        $this->db->where('status', 0);

        $date = new DateTime();
        $this->db->not_like( 'import_date', $date->format('Y-m-d H:i') );

        return $this->db->get()->num_rows();
    }

    public function delete_daily_qa($id) {
        $this->db->where('daily_qa_id', $id);
        $this->db->delete($this->table);
    }
    
    public function delete_pending_daily_qa($import_by) {
        $this->db->where('import_by', $import_by);
        $this->db->where('status', 0);
        $this->db->delete($this->table);
    }
    public function edit_daily_qa($record_id, $yes, $no, $csi, $art, $aht, $quantity, $update_date, $update_by) {
        $data = array(
               'yes' => $yes,
               'no' => $no,
               'csi' => $csi,
               'art' => $art,
               'aht' => $aht,
               'quantity' => $quantity,
               'update_date' => $update_date,
               'update_by' => $update_by
            );

        $this->db->where('daily_qa_id', $record_id);
        $this->db->update($this->table, $data); 
    }

    public function pending_list() {

        $this->db->select(array('import_date', 'import_by'));
        $this->db->from($this->table);
        $this->db->where('status', 0);
        $this->db->group_by('import_by');

        $q = $this->db->get();

        if($q->num_rows() > 0) {
            return $q;
        }

        return false;
    }

    public function confirm_dailyqa_import($update_by) {
        $data = array(
               'status' => 1
            );

        $this->db->where('import_by' , $update_by);
        $this->db->update($this->table, $data); 
    }

}