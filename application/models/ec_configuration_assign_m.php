<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_configuration_assign_m extends CI_Model {
    protected $table = 'EC_PL_KONFIGURASI_ASSIGN', $employee = 'ADM_EMPLOYEE';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    function getMaster_assign()
    {
        $this->db->select($this->table.'.*, '.$this->employee.'.FULLNAME');
        $this->db->from($this->table);
        $this->db->join($this->employee, $this->table.'.USER_ID = '.$this->employee.'.ID');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function updateData($data)
    {
        $this->db->from($this->table);
        $this->db->where('USER_ID', $data['USER_ID']);
        $query = $this->db->get();
        if (count($query->result_array()) > 1){
            return false;
        } else {
            return $this->alter($data);
        }
    }

    function simpanData($data)
    {
        $this->db->from($this->table);
        $this->db->where('USER_ID', $data['USER_ID']);
        $query = $this->db->get();
        if (count($query->result_array()) > 0){
            return false;
        } else {
            return $this->insert($data);
        }
    }

    function insert($data)
    {
        $date = date('d-m-Y h:i:sa');
        $this->db->insert($this->table, array('USER_ID' => $data['USER_ID'], 'LEVEL' => $data['LEVEL'], 'DATEIN' => $date));
        return true;
    }

    function alter($data)
    {
        $this->db->where('ID', $data['ID']);
        $this->db->update($this->table, array('USER_ID' => $data['USER_ID'], 'LEVEL' => $data['LEVEL']));
        return true;
    }

    function delete($ID)
    {
        $this->db->where('ID', $ID);
        $this->db->delete($this->table);
        return true;
    }
}
