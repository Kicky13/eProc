<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_publish_approval extends CI_Model
{
    protected $table = 'EC_PL_VENDOR_ASSIGN', $tableConf = 'EC_PL_KONFIGURASI_ASSIGN', $employee = 'ADM_EMPLOYEE', $vnd = 'VND_HEADER', $material = 'EC_M_STRATEGIC_MATERIAL';

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    function getPublish_approval()
    {
        return $this->getDataPublish($this->getLevelConfig(), $this->getAssignerData());
    }

    function getLevelConfig()
    {
        $userid = $this->session->userdata['ID'];
        $this->db->from($this->tableConf);
        $this->db->where('USER_ID', $userid);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function getDataPublish($cnf, $assigner)
    {
        $select = $this->table.'.*, '.$this->vnd.'.VENDOR_NAME, '.$this->material.'.MAKTX, '.$this->material.'.MEINS';
        $this->db->select($select);
        $this->db->from($this->table);
        $this->db->join($this->tableConf, $this->table.'.USERID = '.$this->tableConf.'.USER_ID');
        $this->db->join($this->material, $this->table.'.MATNO = '.$this->material.'.MATNR');
        $this->db->join($this->vnd, $this->table.'.VENDORNO = '.$this->vnd.'.VENDOR_NO');
        $this->db->where($this->table.'.USERID', $assigner['USER_ID']);
        $this->db->where($this->table.'.LEVEL_APP', $cnf['LEVEL']);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function getAssignerData()
    {
        $company = $this->session->userdata['COMPANYID'];
        $this->db->from($this->tableConf);
        $this->db->where('COMPANYr', $company);
        $this->db->where('LEVEL', 0);
        $result = $this->db->get();
        return (array)$result->row_array();
    }
}
