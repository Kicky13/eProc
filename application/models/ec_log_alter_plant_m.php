<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_log_alter_plant_m extends CI_Model
{
    protected $table = 'EC_LOG_PLANT_CHANGE', $plant = 'EC_M_PLANT', $employee = 'ADM_EMPLOYEE';

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    function getReport()
    {
        $select = $this->table.'.*, '.$this->plant.'.COMPANY, '.$this->plant.'.DESC, '.$this->employee.'.*';
        $this->db->select($select);
        $this->db->from($this->table);
        $this->db->join($this->plant, $this->plant.'.PLANT = '.$this->table.'.PLANT');
        $this->db->join($this->employee, $this->employee.'.ID = '.$this->table.'.USER_ID');
        $this->db->order_by($this->table.'.LOG_DATE', 'DESC');
        $result = $this->db->get();
        return (array)$result->result_array();
    }
}
