<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_pl_negosiasi_m extends CI_Model
{
    protected $table = 'EC_PL_NEGOSIASI', $chat = 'EC_PL_CHAT', $employee = 'ADM_EMPLOYEE', $vendor = 'VND_HEADER', $material = 'EC_M_STRATEGIC_MATERIAL', $plant = 'EC_PLANT', $penawaran = 'EC_T_DETAIL_PENAWARAN';

//  Keterangan Penting
//  - STATUS_NEGO       :   1. Open
//                          2. Close
//  - SENDER_CODE       :   1. User
//                          2. Vendor
//  - MESSAGE_STATUS    :   1. Received
//                          2. Read

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    function requestChat($vendorno, $matno, $plant)
    {
        $nego = $this->findNego($vendorno, $matno, $plant);
        if (count($nego) > 0){
            $data = $this->getChat($nego['ID']);
        } else {
            $this->createNego($vendorno, $matno, $plant);
            $new = $this->findNego($vendorno, $matno, $plant);
            $data = $this->getChat($new['ID']);
        }
        return $data;
    }

    function getActiveNego()
    {
        $vnd = $this->session->userdata['VENDOR_NO'];
        $select = $this->table.'.*, '.$this->material.'.MAKTX, '.$this->plant.'.PLANT_NAME, '.$this->employee.'.FULLNAME';
        $this->db->select($select);
        $this->db->from($this->table);
        $this->db->join($this->employee, $this->employee.'.ID = '.$this->table.'.USER_ID');
        $this->db->join($this->material, $this->material.'.MATNR = '.$this->table.'.MATNO');
        $this->db->join($this->plant, $this->plant.'.PLANT = '.$this->table.'.PLANT');
        $this->db->where($this->table.'.VENDORNO', $vnd);
        $this->db->where($this->table.'.STATUS_NEGO', 1);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function getArchiveNego()
    {
        $vnd = $this->session->userdata['VENDOR_NO'];
        $select = $this->table.'.*, '.$this->material.'.MAKTX, '.$this->plant.'.PLANT_NAME, '.$this->employee.'.FULLNAME';
        $this->db->select($select);
        $this->db->from($this->table);
        $this->db->join($this->employee, $this->employee.'.ID = '.$this->table.'.USER_ID');
        $this->db->join($this->material, $this->material.'.MATNR = '.$this->table.'.MATNO');
        $this->db->join($this->plant, $this->plant.'.PLANT = '.$this->table.'.PLANT');
        $this->db->where($this->table.'.VENDORNO', $vnd);
        $this->db->where($this->table.'.STATUS_NEGO', 0);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function compileLastChat($data)
    {
        for ($i = 0; $i < count($data); $i++){
            $msg = '';
            $last = $this->findLastChatByNegoID($data[$i]['ID']);
            if ($last > 0){
                $msg .= $last['MESSAGE_CONTENT'];
            } else {
                $msg .= '-';
            }
            $data[$i]['MESSAGE_CONTENT'] = $msg;
        }
        return $data;
    }

    function findLastChatByNegoID($id)
    {
        $this->db->from($this->chat);
        $this->db->where('NEGO_ID', $id);
        $this->db->order_by('ID', 'desc');
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function findNego($vendorno, $matno, $plant)
    {
        $user = $this->session->userdata['ID'];
        $this->db->from($this->table);
        $this->db->where('USER_ID', $user);
        $this->db->where('VENDORNO', $vendorno);
        $this->db->where('MATNO', $matno);
        $this->db->where('PLANT', $plant);
        $this->db->where('STATUS_NEGO', 1);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function findNegoVendor($userid, $matno, $plant)
    {
        $vendorno = $this->session->userdata['ID'];
        $this->db->from($this->table);
        $this->db->where('USER_ID', $userid);
        $this->db->where('VENDORNO', $vendorno);
        $this->db->where('MATNO', $matno);
        $this->db->where('PLANT', $plant);
        $this->db->where('STATUS_NEGO', 1);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function createNego($vendorno, $matno, $plant)
    {
        $user = $this->session->userdata['ID'];
        $now = date("Y-m-d H:i:s");
        $sql = "INSERT INTO EC_PL_NEGOSIASI (OPENDATE, CLOSEDATE, USER_ID, VENDORNO, MATNO, PLANT, STATUS_NEGO) VALUES (TO_DATE('". $now ."', 'YYYY-MM-DD HH24:MI:SS'), NULL, '". $user ."', '". $vendorno ."', '". $matno ."', '". $plant ."', 1)";
        $this->db->query($sql);
    }

    function getNegoByID($id)
    {
        $this->db->from($this->table);
        $this->db->where('ID', $id);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function closeNego($nego)
    {
        $now = date("Y-m-d H:i:s");
        $sql = "UPDATE EC_PL_NEGOSIASI SET CLOSEDATE = TO_DATE('". $now ."','YYYY-MM-DD HH24:MI:SS'), STATUS_NEGO = 0 WHERE ID = ". $nego['ID'];
        $this->db->query($sql);
    }

    function readChat($reader, $id)
    {

    }

    function getChat($id)
    {
        $this->db->from($this->chat);
        $this->db->where('NEGO_ID', $id);
        $this->db->order_by('ID');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function sendChat($sender, $msg, $nego)
    {
        $now = date("Y-m-d H:i:s");
        $sql = "INSERT INTO EC_PL_CHAT (NEGO_ID, SENT_DATE, MESSAGE_CONTENT, SENDER_CODE, MESSAGE_STATUS) VALUES (". $nego['ID'] .", TO_DATE('". $now ."', 'YYYY-MM-DD HH24:MI:SS'), '". $msg ."', ". $sender .", 1)";
        $this->db->query($sql);
        return true;
    }

    function openLock($vendorno, $matno, $plant)
    {
        $this->db->where('PLANT', $plant);
        $this->db->where('VENDORNO', $vendorno);
        $this->db->where('MATNO', $matno);
        $this->db->update($this->penawaran, array('CHANGE_REQUEST' => 1));
    }
}