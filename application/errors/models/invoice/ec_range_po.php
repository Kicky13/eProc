<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ec_range_po extends MY_Model {
    public $table = 'EC_RANGE_PO';
    public $primary_key = 'START_RANGE';
    public $increments = FALSE;
    protected $timestamps = FALSE;

    /*START MASTER RANGE PO*/
    function rangePOUpdate($start,$data) {
        $this->db->where('START_RANGE',$start);
        return $this->db->update($this->table, $data);
    }

    function getAllRangePO() {
        $this->db->from($this->table);
        $result = $this->db->get();
        return $result->result_array();
    }

    function getAcvtieRangePO() {
        $this->db->from($this->table);
        $this->db->where('STATUS','1');
        $result = $this->db->get();
        return $result->result_array();
    }
}
