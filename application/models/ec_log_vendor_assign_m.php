<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_log_vendor_assign_m extends CI_Model
{
    protected $table = 'EC_ADM_VENDOR_ASSIGN_LOG', $material = 'EC_M_STRATEGIC_MATERIAL', $vnd = 'VND_HEADER', $employee = 'ADM_EMPLOYEE', $konfig = 'EC_M_KONFIGURASI_MATERIAL', $category = 'EC_M_CATEGORY';

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    function getLog()
    {
        $this->db->from($this->table);
        $this->db->join($this->material, $this->material.'.MATNR = '.$this->table.'.MATNO');
        $this->db->join($this->vnd, $this->vnd.'.VENDOR_NO = '.$this->table.'.VENDORNO');
        $this->db->join($this->employee, $this->employee.'.ID = '.$this->table.'.USERID');
        $result = $this->db->get();
        return (array)$result->result_array();
    }
}
