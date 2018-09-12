<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_pl_monitoring_penawaran_m extends CI_Model
{

    protected $table = 'EC_T_DETAIL_PENAWARAN', $vnd = 'VND_HEADER';

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    function getData_vendor()
    {
        $select = $this->table.'.VENDORNO, '.$this->vnd.'.VENDOR_NAME, '.$this->vnd.'.CONTACT_PHONE_NO';
        $this->db->select($select);
        $this->db->from($this->table);
        $this->db->join($this->vnd, $this->vnd.'.VENDOR_NO = '.$this->table.'.VENDORNO');
        $this->db->group_by($select);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function getVendor_info($vnd)
    {
        $this->db->from($this->vnd);
        $this->db->where('VENDOR_NO', $vnd);
        $result = $this->db->get();
        return (array)$result->row_array();
    }
}
