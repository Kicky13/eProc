<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_approval_material_assign_m extends CI_Model
{
    protected $table = 'EC_M_APPROVAL_STRATEGIC_M', $tableConf = 'EC_M_KONFIGURASI_MATERIAL', $employee = 'ADM_EMPLOYEE', $vnd = 'VND_HEADER', $material = 'EC_M_STRATEGIC_MATERIAL', $category = 'EC_M_CATEGORY';

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    function getMaterial_approval()
    {
        return $this->getDataMaterial($this->getLevelConfig(), $this->getAssignerData());
    }

    function getLevelConfig()
    {
        $userid = $this->session->userdata['ID'];
        $this->db->from($this->tableConf);
        $this->db->where('USER_ID', $userid);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function getDataMaterial($cnf, $assigner)
    {
        $select = $this->table.'.*, '.$this->category.'.DESC, '.$this->material.'.MAKTX, ';
        $this->db->select($select);
        $this->db->from($this->table);
        $this->db->join($this->tableConf, $this->table.'.USER_ID = '.$this->tableConf.'.USER_ID');
        $this->db->join($this->material, $this->table.'.MATNO = '.$this->material.'.MATNR');
        $this->db->join($this->category, $this->table.'.ID_CAT_PROPOSE = '.$this->category.'.ID_CAT');
        $this->db->where($this->table.'.USER_ID', $assigner['USER_ID']);
        $this->db->where($this->table.'.PROGRESS_APP', $cnf['CONF_LEVEL']);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function getAssignerData()
    {
        $company = $this->session->userdata['COMPANYID'];
        $this->db->from($this->tableConf);
        $this->db->where('COMPANY', $company);
        $this->db->where('CONF_LEVEL', 0);
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
        $this->db->where('ID', $kode);
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
            $this->db->where('ID', $kode);
            $this->db->update($this->table, array('PROGRESS_APP' => $data['LEVEL'] + 1, 'STATUS_APP' => 1));
        } else {
            $this->assignMaterial($kode);
            $this->db->where('ID', $kode);
            $this->db->delete($this->table);
        }
        return true;
    }

    function verifyApp($data)
    {
        if ($this->findNext($data['CONF_LEVEL']) > 0){
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
        $this->db->where('CONF_LEVEL', $lvl+1);
        $result = $this->db->get();
        return count((array)$result->result_array());
    }

    function assignMaterial($kode)
    {
        $this->db->from($this->table);
        $this->db->where('ID', $kode);
        $query = $this->db->get();
        $result = (array)$query->row_array();
        $this->db->where("MATNR", $result['MATNO'], TRUE);
        $this->db->update($this->table, array('ID_CAT' => $result['ID_CAT']));
    }

    function test($kode)
    {
        $this->db->from($this->table);
        $this->db->where('ID', $kode);
        $query = $this->db->get();
        return (array)$query->row_array();
    }
}
