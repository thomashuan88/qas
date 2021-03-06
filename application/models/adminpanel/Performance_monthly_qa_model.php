<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Performance_monthly_qa_model extends CI_Model {

    private $table = 'monthly_qa';
    private $fields;

    public function __construct() {
        parent::__construct();
        $this->load->library('MY_Permission');
        $this->fields = $this->db->list_fields($this->table);
    }

    public function insert_multi_records( $records  ) {
        $this->db->insert_batch( $this->table, $records );
    }
    public function get_single_record($id) {
        return $this->db->get_where($this->table, array('monthly_qa_id' => $id ) );
    }

    public function get_records( $limit = 0, $offset = 0, $order_by = "import_date", $sort_order = "desc", $search_data = array() , $status = 1, $users = array() ) {

        $this->db->select( array( 'monthly_qa_id', 'month', 'username', 'typing_test', 'monthly_assessment', 'leader', 'import_by', 'import_date' ) );
        $this->db->from($this->table);

        if ( $status == 0 ) {
            $this->db->where_in('import_by', $this->my_permission->find_permission());
        }

        if ($status == 1) {
            if( !empty( $users ) ) {
                $this->db->where_in('username', $users);
            }
        }

        if( !empty( $search_data ) ) {
            foreach ($search_data as $searchKey => $searchValue) {
                if ($searchValue != 'null') {
                    $this->db->like( $searchKey, $searchValue );
                }
            }
        }

        $this->db->order_by($order_by, $sort_order);
        $this->db->limit($limit, $offset);
        $this->db->where('status', $status);

        $q = $this->db->get();

        if( $q->num_rows() > 0 ) {
            return $q;
        }

        return false;
    }

    public function count_confirm_records($search_data = array(), $users = array() ) {
        $this->db->select($this->fields);
        $this->db->from($this->table);

        if( !empty( $users ) ) {
            $this->db->where_in( 'username', $users );
        }

        if( !empty( $search_data ) ) {
            foreach ( $search_data as $searchKey => $searchValue ) {
                if ($searchValue != 'null') {
                    $this->db->like( $searchKey, $searchValue );
                }
            }
        }
        $this->db->where( 'status', 1 );

        return $this->db->get()->num_rows();
    }

    public function count_pending_records() {
        $this->db->select($this->fields);
        $this->db->from($this->table);
        $this->db->where('status', 0);
        $this->db->where_in('import_by', $this->my_permission->find_permission());


        return $this->db->get()->num_rows();
    }

    public function count_not_my_pending() {
        $this->db->select( $this->fields );
        $this->db->from( $this->table );
        $this->db->where( 'status', 0 );
        $this->db->where( 'import_by !=', $this->session->userdata('username') );

        return $this->db->get()->num_rows();
    }

    public function get_pending_import_by() {
        $this->db->select( $this->fields );
        $this->db->from( $this->table );
        $this->db->where( 'status', 0 );

        $q = $this->db->get();

        if( $q->num_rows() > 0 ) {
            return $q->result('array');
        }

        return false;
    }

    public function count_not_current_upload() {
        $this->db->select( $this->fields );
        $this->db->from( $this->table );
        $this->db->where( 'status', 0);

        $date = new DateTime();
        $this->db->not_like( 'import_date', $date->format('Y-m-d H:i') );

        return $this->db->get()->num_rows();
    }

    public function delete_record($id) {
        $this->db->where('monthly_qa_id', $id);
        $this->db->delete($this->table);
    }

    public function delete_pending_records() {
        $this->db->where('status', 0);
        $this->db->delete($this->table);
    }

    public function confirm_records_import() {
        $data = array(
               'status' => 1
            );

        $this->db->update($this->table, $data);
    }

    
}
