<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_report_cataloging_m extends CI_Model
{
    protected $table = 'EC_REPORT_APPROVAL_STRATEGIC_M', $material = 'EC_M_STRATEGIC_MATERIAL', $vnd = 'VND_HEADER', $employee = 'ADM_EMPLOYEE', $konfig = 'EC_M_KONFIGURASI_MATERIAL', $category = 'EC_M_CATEGORY';

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    function getReport_material()
    {
        $select = $this->table.'.MATNO, '.$this->category.'.ID_CAT, MAKTX, DESC';
        $this->db->select($select);
        $this->db->from($this->table);
        $this->db->join($this->category, $this->category.'.ID_CAT = '.$this->table.'.CAT_ID');
        $this->db->join($this->material, $this->material.'.MATNR = '.$this->table.'.MATNO');
        $this->db->group_by($select);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function getDetail_material($matno, $cat)
    {
        $this->db->from($this->table);
        $this->db->join($this->konfig, $this->konfig.'.USER_ID = '.$this->table.'.USER_ID', 'left');
        $this->db->join($this->employee, $this->employee.'.ID = '.$this->table.'.USER_ID', 'left');
        $this->db->where('MATNO', $matno);
        $this->db->where('CAT_ID', $cat);
        $this->db->order_by('CONF_LEVEL');
        $result = $this->db->get();
        return (array)$result->result_array();
    }
}
