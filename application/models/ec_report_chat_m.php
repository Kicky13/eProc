<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_report_chat_m extends CI_Model
{
    private $table = 'EC_PL_CHAT', $nego = 'EC_PL_NEGOSIASI', $employee = 'ADM_EMPLOYEE', $vendor = 'VND_HEADER', $material = 'EC_M_STRATEGIC_MATERIAL', $plant = 'EC_PLANT';

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    function dataNego()
    {
        $user = $this->session->userdata['ID'];
        $select = $this->nego.'.*, '.$this->material.'.MAKTX, '.$this->plant.'.PLANT_NAME, '.$this->vendor.'.VENDOR_NAME';
        $this->db->select($select);
        $this->db->from($this->nego);
        $this->db->join($this->vendor, $this->vendor.'.VENDOR_NO = '.$this->nego.'.VENDORNO');
        $this->db->join($this->material, $this->material.'.MATNR = '.$this->nego.'.MATNO');
        $this->db->join($this->plant, $this->plant.'.PLANT = '.$this->nego.'.PLANT');
        $this->db->where($this->nego.'.USER_ID', $user);
        $this->db->where($this->nego.'.STATUS_NEGO', 0);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function dataChatByNegoID($id)
    {
        $this->db->from($this->table);
        $this->db->where('NEGO_ID', $id);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function addLastChat($data)
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
        $this->db->from($this->table);
        $this->db->where('NEGO_ID', $id);
        $this->db->order_by('ID', 'desc');
        $result = $this->db->get();
        return (array)$result->row_array();
    }
}
