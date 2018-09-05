<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_report_publish_m extends CI_Model
{

    protected $table = 'EC_REPORT_VENDOR_ASSIGN', $material = 'EC_M_STRATEGIC_MATERIAL', $vnd = 'VND_HEADER', $employee = 'ADM_EMPLOYEE', $konfig = 'EC_PL_KONFIGURASI_ASSIGN';

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    function getReport_approval()
    {
        $select = 'MATNO, VENDORNO, KODE_UPDATE, MEINS, VENDOR_NAME, MAKTX';
        $from = '(SELECT * FROM '.$this->table.' ORDER BY LOG_DATE DESC) RVA';
        $this->db->select($select);
        $this->db->from($from);
        $this->db->join($this->vnd, $this->vnd.'.VENDOR_NO = RVA.VENDORNO');
        $this->db->join($this->material, $this->material.'.MATNR = RVA.MATNO');
        $this->db->group_by($select);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function getDetail_approval($matno, $vnd)
    {
        $select = $this->table.'.ID, '.$this->table.'.LOG_DATE, '.$this->table.'.LOG_ACTIVITY, '.$this->table.'.APPROVE_LEVEL, '.$this->employee.'.FULLNAME';
        $this->db->select($select);
        $this->db->from($this->table);
        $this->db->join($this->employee, $this->employee.'.ID = '.$this->table.'.USERID', 'left');
        $this->db->where('MATNO', $matno);
        $this->db->where('VENDORNO', $vnd);
        $this->db->group_by($select);
        $this->db->order_by('APPROVE_LEVEL');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function getStatus($matno, $vendorno)
    {
        $this->db->from($this->table);
        $this->db->join($this->konfig, $this->table.'.USERID = '.$this->konfig.'.USER_ID');
        $this->db->where('MATNO', $matno);
        $this->db->where('VENDORNO', $vendorno);
        $this->db->order_by('LEVEL', 'desc');
        $result = $this->db->get();
        return (array)$result->row_array();
    }
}
