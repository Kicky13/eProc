<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_publish_approval_m extends CI_Model
{
    protected $table = 'EC_PL_VENDOR_ASSIGN', $tableConf = 'EC_PL_KONFIGURASI_ASSIGN', $employee = 'ADM_EMPLOYEE', $vnd = 'VND_HEADER', $material = 'EC_M_STRATEGIC_MATERIAL', $report = 'EC_REPORT_VENDOR_ASSIGN';

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    function getPublish_approval()
    {
        return $this->getDataPublish($this->groupingConfig($this->getLevelConfig()), $this->getAssignerData());
    }

    function getLevelConfig()
    {
        $userid = $this->session->userdata['ID'];
        $this->db->from($this->tableConf);
        $this->db->where('USER_ID', $userid);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function groupingConfig($cnf)
    {
        $teks = '';
        for ($i = 0; $i < count($cnf); $i++){
            if ($i > 0){
                $teks .= ', '.$cnf[$i]['LEVEL'];
            } else {
                $teks .= $cnf[$i]['LEVEL'];
            }
        }
        return $teks;
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
        $this->db->where($this->table.'.LEVEL_APP IN ('.$cnf.')');
        $this->db->where($this->table.'.STATUS_APP', 1);
        $this->db->order_by($this->table.'.INDATE', 'DESC');
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
        if ($this->verifyApp($this->getPropose($kode))){
            return $this->statusChange($kode, true);
        } else {
            return $this->statusChange($kode, false);
        }
    }

    function reject($kode)
    {
        $this->db->where('KODE_PROPOSE', $kode);
        $this->db->update($this->table, array('STATUS_APP' => 2));
        $this->updateLog($this->getPropose($kode), 3);
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
        $data = $this->getPropose($kode);
        if ($status){
            $this->db->where('KODE_PROPOSE', $kode);
            $this->db->update($this->table, array('LEVEL_APP' => $data['LEVEL_APP'] + 1, 'STATUS_APP' => 1));
            $this->insertLog($this->getPropose($kode), $data['LEVEL']);
            $this->updateLog($this->getPropose($kode), 2);
        } else {
            $this->db->where('KODE_PROPOSE', $kode);
            $this->db->update($this->table, array('LEVEL_APP' => 0, 'STATUS_APP' => 0));
            $this->updateLog($this->getPropose($kode), 2);
        }
        return true;
    }

    function verifyApp($data)
    {
        if ($this->findNext($data['LEVEL_APP']) > 0){
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

    function getNext($lvl)
    {
        $company = $this->session->userdata['COMPANYID'];
        $this->db->from($this->tableConf);
        $this->db->where('COMPANY', $company);
        $this->db->where('LEVEL', $lvl+1);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function updateLog($data, $activity)
    {
        $userid = $this->session->userdata['ID'];
        $this->db->where('USERID', $userid);
        $this->db->where('MATNO', $data['MATNO']);
        $this->db->where('VENDORNO', $data['VENDORNO']);
        $this->db->update($this->report, array('LOG_ACTIVITY' => $activity));
        return true;
    }

    function insertLog($data, $lvl)
    {
        $now = date("Y-m-d H:i:s");
        $userdata = $this->getNext($lvl);
        $this->db->where('MATNO', $data['MATNO']);
        $this->db->where('VENDORNO', $data['VENDORNO']);
        $this->db->where('USERID', $userdata['USER_ID']);
        $this->db->delete($this->report);

        $this->db->insert($this->report, array('MATNO' => $data['MATNO'], 'VENDORNO' => $data['VENDORNO'], 'KODE_UPDATE' => $data['KODE_UPDATE'], 'USERID' => $userdata['USER_ID'], 'LOG_DATE' => $now, 'LOG_ACTIVITY' => 1));
        return true;
    }

    function getPropose($id)
    {
        $this->db->from($this->table);
        $this->db->join($this->vnd, $this->vnd.'.VENDOR_NO = '.$this->table.'.VENDORNO');
        $this->db->join($this->material, $this->material.'.MATNR = '.$this->table.'.MATNO');
        $this->db->where('KODE_PROPOSE', $id);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function notificationGateway($kode, $activity)
    {
        $data = array();
        $item = $this->getPropose($kode);
        if ($activity == 1) {
            $curr = $this->currentLvl();
            if ($this->findNext($curr['LEVEL']) > 0) {
                $data['ACTIVITY'] = 1;
                $userdata = $this->getEmail($this->getNext($curr['LEVEL']));
            } else {
                $data['ACTIVITY'] = 2;
                $userdata = $this->getEmail($this->getAssignerData());
            }
        } else {
            $data['ACTIVITY'] = 3;
            $userdata = $this->getEmail($this->getAssignerData());
        }
        $data['DATA']['MATNO'] = $item['MATNO'];
        $data['DATA']['MAKTX'] = $item['MAKTX'];
        $data['DATA']['VENDORNO'] = $item['VENDORNO'];
        $data['DATA']['VENDORNAME'] = $item['VENDOR_NAME'];
        $data['DATA']['KODE_UPDATE'] = $item['KODE_UPDATE'];
        $data['DATA']['DAYS_UPDATE'] = $item['DAYS_UPDATE'];
        switch ($item['KODE_UPDATE']){
            case '510':
                $data['DATA']['UPDATE'] = $item['DAYS_UPDATE'].' Hari';
                break;
            case '511':
                $data['DATA']['UPDATE'] = 'Perbulan';
                break;
            case '210':
                $data['DATA']['UPDATE'] = 'Perminggu';
                break;
            default:
                $data['DATA']['UPDATE'] = 'Null';
                break;
        }
        $data['DATA']['CURRENCY'] = $item['CURRENCY'];
        $data['DATA']['START_DATE'] = $item['START_DATE'];
        $data['DATA']['INDATE'] = $item['INDATE'];
        $data['EMAIL'] = $userdata['EMAIL'];
        $data['FULLNAME'] = $userdata['FULLNAME'];

        return $data;
    }

    function getEmail($userdata)
    {
        $this->db->from($this->employee);
        $this->db->where('ID', $userdata['USER_ID']);
        $result = $this->db->get();
        return (array)$result->row_array();
    }
}
