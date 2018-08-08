<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_approval_material_assign_m extends CI_Model
{
    protected $table = 'EC_M_APPROVAL_STRATEGIC_M', $tableReport = 'EC_REPORT_APPROVAL_STRATEGIC_M', $tableConf = 'EC_M_KONFIGURASI_MATERIAL', $employee = 'ADM_EMPLOYEE', $vnd = 'VND_HEADER', $material = 'EC_M_STRATEGIC_MATERIAL', $category = 'EC_M_CATEGORY';

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
        $this->db->order_by($this->table.'.ID', 'DESC');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function getMatGroup()
    {
        $matgrp = array();
        $userid = $this->session->userdata['ID'];
        $this->db->from($this->tableConf);
        $this->db->where('USER_ID', $userid);
        $query = $this->db->get();
        $result = (array)$query->row_array();
        foreach ($result as $item){
            array_push($matgrp, $item['MATGROUP']);
        }
        return $matgrp;
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
            $this->db->update($this->table, array('PROGRESS_APP' => $data['CONF_LEVEL'] + 1, 'STATUS_APP' => 1));
            $this->insertLog($this->getDetailApproval($kode), $this->getNext($this->currentLvl()));
            $this->updateLog($this->getDetailApproval($kode), $this->currentLvl());
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

    function getNext($prev)
    {
        $this->db->from($this->tableConf);
        $this->db->where('MATGROUP', $prev['MATGROUP']);
        $this->db->where('COMPANY', $prev['COMPANY']);
        $this->db->where('CONF_LEVEL', $prev['CONF_LEVEL'] + 1);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function notificationGateway($kode, $activity)
    {
        $now = date('Y-m-d H:i:s');
        $dataApp = $this->getDetailApproval($kode);
        $material = $this->getMaterial($dataApp['MATNO']);
        $category = $this->getCategory($dataApp['ID_CAT_PROPOSE']);
        if ($activity == 1) {
            $curr = $this->currentLvl();
            if ($this->findNext($curr['LEVEL']) > 0) {
                $data['ACTIVITY'] = 1;
                $userdata = $this->getEmail($this->getNext($this->currentLvl()));
            } else {
                $data['ACTIVITY'] = 2;
                $userdata = $this->getEmail($this->getAssignerData());
            }
        } else {
            $data['ACTIVITY'] = 3;
            $userdata = $this->getEmail($this->getAssignerData());
        }

        $data['DATA']['MATNO'] = $material['MATNR'];
        $data['DATA']['MAKTX'] = $material['MAKTX'];
        $data['DATA']['ID_CAT'] = $category['ID_CAT'];
        $data['DATA']['DESC'] = $category['DESCRIPTION'];
        $data['FULLNAME'] = $userdata['FULLNAME'];
        $data['EMAIL'] = $userdata['EMAIL'];
        $data['DATA']['DATE'] = $now;

        return $data;
    }

    function getEmail($user)
    {
        $this->db->from($this->employee);
        $this->db->where('ID', $user['USER_ID']);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function getMaterial($mat)
    {
        $this->db->from($this->material);
        $this->db->where('MATNR', $mat);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function getCategory($cat)
    {
        $this->db->from($this->category);
        $this->db->where('ID_CAT', $cat);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function getDetailApproval($kode)
    {
        $this->db->from($this->table);
        $this->db->where('ID', $kode);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function assignMaterial($kode)
    {
        $this->db->from($this->table);
        $this->db->where('ID', $kode);
        $query = $this->db->get();
        $result = (array)$query->row_array();
        $this->db->where("MATNR", $result['MATNO'], TRUE);
        $this->db->update($this->material, array('ID_CAT' => $result['ID_CAT_PROPOSE']));
    }

    function insertLog($app, $userdata)
    {
        $now = date('Y-m-d H:i:s');
        $this->db->where('USER_ID', $userdata['USER_ID']);
        $this->db->where('MATNO', $app['MATNO']);
        $this->db->where('CAT_ID', $app['ID_CAT_PROPOSE']);
        $this->db->delete($this->tableReport);

        $this->db->insert($this->tableReport, array('USER_ID' => $userdata['USER_ID'], 'MATNO' => $app['MATNO'], 'CAT_ID' => $app['ID_CAT_PROPOSE'], 'LOG_ACTIVITY' => 1, 'LOG_DATE' => $now));
        return true;
    }

    function updateLog($app, $userdata)
    {
        $this->db->where('USER_ID', $userdata['USER_ID']);
        $this->db->where('MATNO', $app['MATNO']);
        $this->db->where('CAT_ID', $app['ID_CAT_PROPOSE']);
        $this->db->update($this->tableReport, array('LOG_ACTIVITY' => 2));
    }
}
