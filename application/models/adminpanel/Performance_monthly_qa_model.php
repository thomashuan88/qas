<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Performance_monthly_qa_model extends CI_Model {

	private $table = 'monthly_qa';
    private $fields;

    public function __construct() {
        parent::__construct();
        $this->fields = $this->db->list_fields($this->table);
    }

    public function insert_multi_monthly_qa( $monthly_qa  ) {
    	$this->db->insert_batch( $this->table, $monthly_qa );
    }

    public function get_monthly_qa( $limit = 0, $offset = 0, $order_by = "import_date", $sort_order = "desc", $search_data = array() ) {

        $this->db->select($this->fields);
        $this->db->from($this->table);
        
        if(!empty($search_data)) {
	        foreach ($search_data as $searchKey => $searchValue) {
	        	$this->db->like( $searchKey, $searchValue );
	        }
        }
        
        $this->db->order_by($order_by, $sort_order);
        $this->db->limit($limit, $offset);

        $q = $this->db->get();

        if($q->num_rows() > 0) {
            return $q;
        }

        return false;
    }

    public function count_all_monthly_qa($search_data = array()) {
    	$this->db->select($this->fields);
        $this->db->from($this->table);

        if(!empty($search_data)) {
	        foreach ($search_data as $searchKey => $searchValue) {
	        	$this->db->like( $searchKey, $searchValue );
	        }
        }

        return $this->db->get()->num_rows();
    }

    public function delete_monthly_qa($id) {
    	$this->db->where('monthly_qa_id', $id);
        $this->db->delete($this->table);
    }
    
    public function edit_monthly_qa($record_id, $month, $typing_test, $monthly_assessment, $leader, $update_date, $update_by) {
        $data = array(
                'monthly_qa_id' => $record_id,
                'month' => $month,
                'typing_test' => $typing_test,
                'monthly_assessment' => $monthly_assessment,
                'leader' => $leader,
                'update_date' => $update_date,
                'update_by' => $update_by
            );

        $this->db->where('monthly_qa_id', $record_id);
        $this->db->update($this->table, $data); 
    }

}