<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_strategic_material_approval_m extends CI_Model
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
        $this->db->where('COMPANY', $company);
        $this->db->where('LEVEL', 0);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function approve($kode)
    {
        if ($this->verifyApp($this->currentLvl())){
            return $this->statusChange($kode, true);
        } else {
            return $this->statusChange($kode, false);
        }
    }

    function reject($kode)
    {
        $this->db->where('KODE_PROPOSE', $kode);
        $this->db->update($this->table, array('STATUS_APP' => 2));
        return true;
    }

    function currentLvl()
    {
        $this->db->from($this->tableConf);
        $this->db->where('USER_ID', $this->session->userdata['ID']);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function statusChange($kode, $status)
    {
        $data = $this->currentLvl();
        if ($status){
            $this->db->where('KODE_PROPOSE', $kode);
            $this->db->update($this->table, array('LEVEL_APP' => $data['LEVEL'] + 1, 'STATUS_APP' => 1));
        } else {
            $this->db->where('KODE_PROPOSE', $kode);
            $this->db->update($this->table, array('LEVEL_APP' => 0, 'STATUS_APP' => 0));
        }
        return true;
    }

    function verifyApp($data)
    {
        if ($this->findNext($data['LEVEL']) > 0){
            return true;
        } else {
            return false;
        }
    }

    function findNext($lvl)
    {
        $company = $this->session->userdata['COMPANYID'];
        $this->db->from($this->tableConf);
        $this->db->where('COMPANY', $company);
        $this->db->where('"LEVEL"', $lvl+1);
        $result = $this->db->get();
        return count((array)$result->result_array());
    }
}
