<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_pl_negosiasi_m extends CI_Model
{
    protected $table = 'EC_PL_NEGOSIASI', $chat = 'EC_PL_CHAT', $employee = 'ADM_EMPLOYEE', $vendor = 'VND_HEADER';

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

    function closeNego($id)
    {
        $this->db->where('ID', $id);
        $this->db->update($this->table, array('STATUS_NEGO' => 0));
    }

    function readChat($reader, $id)
    {

    }

    function getChat($id)
    {
        $this->db->from($this->chat);
        $this->db->where('NEGO_ID', $id);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function sendChat($sender, $comment, $id)
    {
        $now = date("Y-m-d H:i:s");
        $this->db->insert($this->chat, array(
            'NEGO_ID' => $id,
            'SEND_DATE' => $now,
            'COMMENT' => $comment,
            'SENDER_CODE' => $sender,
            'MESSAGE_STATUS' => 1
        ));
    }
}