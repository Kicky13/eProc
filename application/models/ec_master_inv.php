<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ec_master_inv extends CI_Model {

    protected $table = 'EC_M_PAJAK_INV', $tableDenda = 'EC_M_DENDA_INV', $tableDoc = 'EC_M_DOC_INV', $tableDocType = 'EC_M_DOC_TYPE', $tablePB = 'EC_M_PAY_BLOCK', $tablePM = 'EC_M_PAY_METHOD', $tablePT = 'EC_M_PAY_TERM', $tableMRole = 'EC_M_ROLE', $tableRoleUser = 'EC_ROLE_USER', $tableMappingUser = 'EC_USER_SAP_MAPPING', $TableLogCJ = "EC_LOG_CRON_JOB", $tableRPO = 'EC_RANGE_PO', $tablePlant='EC_ROLE_ACCESS';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    function insertBaru($data) {
        $this->db->insert($this->table, $data);
    }

    function pajakBaru($data) {
        $this->db->insert($this->table, $data);
    }

    function dendaBaru($data) {
        $this->db->insert($this->tableDenda, $data);
    }

    function docBaru($data) {
        $this->db->insert($this->tableDoc, $data);
    }

    /*START LOG CRON JOB*/
    function logCronjobBaru($data) {
        return $this->db->insert($this->TableLogCJ, $data);
    }

    function getLogCronjob() {
        $d = '"DATE"';
        $this->db->select("C.*, TO_CHAR ($d,'DD-MM-YYYY hh24:mi:ss') AS DATE2", false);
        $this->db->from("$this->TableLogCJ C");
        $this->db->order_by('DATE DESC');
        $this->db->limit(100);
        return $this->db->get()->result_array();
    }
    /*END LOG CRON JOB*/

    /*START USER MAPPING*/
    function UserMappingBaru($data) {
        $this->db->insert($this->tableMappingUser, $data);
    }

    function userMappingUpdate($data) {
       // var_dump($data);
        $this->db->where('EMAIL1',$data['EMAIL1']);
        $this->db->update($this->tableMappingUser, $data);
    }

    function deleteMapping($email){
        $this->db->where('EMAIL1',$email);
        return $this->db->delete($this->tableMappingUser);
    }

    function getMappingUser($email) {
        $this->db->from($this->tableMappingUser);
        //$this->db->order_by('STATUS DESC');
        //$this -> db -> where("STATUS", "1", TRUE);
        $this->db->where('EMAIL1',$email);
        $result = $this->db->get();
        return $result->row_array();
    }

    function getAllMapping() {
        $this->db->from($this->tableMappingUser);
        //$this->db->order_by('STATUS DESC');
        //$this -> db -> where("STATUS", "1", TRUE);
        $result = $this->db->get();
        return (array) $result->result_array();
    }
    /*END USER MAPPING*/

    /*START USER ROLE*/
    function userRoleBaru($data) {
        $this->db->insert($this->tableRoleUser, $data);
    }

    function userRoleUpdate($ID,$data) {
        $this->db->where('ID',$ID);
        $this->db->update($this->tableRoleUser, $data);
    }

    function userRoleDelete($ID){
        $this->db->delete($this->tableRoleUser,$ID);
    }

    function getRoleUser() {
        $this->db->from($this->tableRoleUser);
        $this->db->order_by('USERNAME')->order_by('ROLE_AS');
        //$this -> db -> where("STATUS", "1", TRUE);
        $result = $this->db->get();
        return (array) $result->result_array();
    }
    /*END USER ROLE*/

    function updateDenda($data) {
        $this->db->where("ID_JENIS", $data['ID_JENIS'], TRUE);
        if ($data['DIRECT_ACTION']) {
            $this->db->set('GL_ACCOUNT', 'NULL', FALSE);
            unset($data['GL_ACCOUNT']);
        }
        return $this->db->update($this->tableDenda, $data);
    }

    function insertDoctype($data) {
        $ada = $this->db->where($data)->get($this->tableDocType)->row();
        if (!empty($ada)) {
            $this->db->where("ID_DOCTYPE", $ada->ID_DOCTYPE);
            $this->db->update($this->tableDocType, $data);
        }
        $this->db->insert($this->tableDocType, $data);
    }

    function insertTax($data) {
        $ada = $this->db->where($data)->get($this->table)->row();
        if (!empty($ada)) {
            $this->db->where("ID_JENIS", $ada->ID_JENIS);
            $this->db->update($this->table, $data);
        }
        $this->db->insert($this->table, $data);
    }

    function insertPayblock($data) {
        $ada = $this->db->where($data)->get($this->tablePB)->row();
        if (!empty($ada)) {
            $this->db->where("ID_PB", $ada->ID_PB);
            $this->db->update($this->tablePB, $data);
        }
        $this->db->insert($this->tablePB, $data);
    }

    function insertPaymeth($data) {
        $ada = $this->db->get($this->tablePM)->row();
        if (!empty($ada)) {
            $this->db->where("ID_PM", $ada->ID_PM);
            $this->db->update($this->tablePM, $data);
        } else {
            $this->db->insert($this->tablePM, $data);
        }
    }

    function insertPayTerm($data) {
        $ada = $this->db->get($this->tablePT)->row();
        if (!empty($ada)) {
            $this->db->where("ID_PT", $ada->ID_PT);
            $this->db->update($this->tablePT, $data);
        } else {
            $this->db->insert($this->tablePT, $data);
        }
    }

    function updatePublish($ID_JENIS, $STATUS, $table) {
        if ($table == 'EC_M_DOC_TYPE') {
            $this->db->where("ID_DOCTYPE", $ID_JENIS, TRUE);
        } elseif ($table == 'EC_M_PAY_BLOCK ') {
            $this->db->where("ID_PB", $ID_JENIS, TRUE);
        } elseif ($table == 'EC_M_PAY_METHOD') {
            $this->db->where("ID_PM", $ID_JENIS, TRUE);
        } elseif ($table == 'EC_M_PAY_TERM') {
            $this->db->where("ID_PT", $ID_JENIS, TRUE);
        } else {
            $this->db->where("ID_JENIS", $ID_JENIS, TRUE);
        }
        $this->db->update($table, array('STATUS' => $STATUS));
    }

    function updateDoc($data) {
        $this->db->where("ID_JENIS", $data['ID_JENIS'], TRUE);
        $this->db->update($this->tableDoc, $data);
    }
       
    public function getPajak() {
        $this->db->from($this->table);
        //$this -> db -> where("STATUS", "1", TRUE);
        $result = $this->db->get();
        return (array) $result->result_array();
    }

    public function getDenda() {
        $this->db->from($this->tableDenda);
        $this->db->order_by('STATUS DESC');
        //$this -> db -> where("STATUS", "1", TRUE);
        $result = $this->db->get();
        return (array) $result->result_array();
    }

    public function getDOc() {
        $this->db->from($this->tableDoc);
        $this->db->order_by('STATUS DESC');
        //$this -> db -> where("STATUS", "1", TRUE);
        $result = $this->db->get();
        return (array) $result->result_array();
    }

    public function getDocType() {
        $this->db->from($this->tableDocType);
        $this->db->order_by('STATUS DESC');
        //$this -> db -> where("STATUS", "1", TRUE);
        $result = $this->db->get();
        return (array) $result->result_array();
    }

    public function getMRole() {
        $this->db->from($this->tableMRole);
        //$this->db->order_by('STATUS DESC');
        //$this -> db -> where("STATUS", "1", TRUE);
        $result = $this->db->get();
        return (array) $result->result_array();
    }

    public function getPayblock() {
        $this->db->from($this->tablePB);
        $this->db->order_by('STATUS DESC');
        //$this -> db -> where("STATUS", "1", TRUE);
        $result = $this->db->get();
        return (array) $result->result_array();
    }

    public function getPaymeth() {
        $this->db->from($this->tablePM);
        $this->db->order_by('STATUS DESC');
        //$this -> db -> where("STATUS", "1", TRUE);
        $result = $this->db->get();
        return (array) $result->result_array();
    }

    public function get() {
        $this->db->from($this->table);
        $this->db->order_by('KODE_USER ASC');
        $result = $this->db->get();
        return (array) $result->result_array();
    }

    function ubah($data) {
        $this->db->where("ID_CAT", $data['ID_CAT'], TRUE);
        $this->db->update($this->table, array('DESC' => $data['DESC']));
    }

    function hapus($data) {//MASIH ERORRRRRRRRRRRRRRRRRRRR? masihh
        $SQL = 'DELETE FROM EC_M_CATEGORY EC WHERE ID_CAT=' . $data['ID_CAT'] . ' or KODE_USER like \'' . $data['KODE_USER'] . '%	\'';
        $this->db->query($SQL);
        if (strlen($data['KODE_USER']) == 1) {
            $this->ec_master_category_m->updateKodeUser('', 'lvl0');
        } else
            $this->updateKodeUser(substr($data['KODE_USER'], 0, 1), 'lvl1');
    }

    function updateKodeUser($kode_del = '', $lvl, $parentBaru = "", $pertama = true) {
        $result = array();
        $parentBaru = $parentBaru == "" ? $kode_del . "-" : $parentBaru;
        $parentBaru = $kode_del == "" ? $kode_del : $parentBaru;
        $this->db->from($this->table);
        $this->db->where('KODE_USER like \'' . $kode_del . '%\'');
        $this->db->where('LEVEL = \'' . $lvl . '\'');
        $this->db->order_by('KODE_USER');
        $query = $this->db->get();
        $result = (array) $query->result_array();
        for ($i = 0; $i < sizeof($result); $i++) {
            $this->db->from($this->table);
            $this->db->like('KODE_USER ', $result[$i]['KODE_USER'] . '-', 'after');
            $this->db->where('LEVEL', 'lvl' . (substr($lvl, 3) + 1), true);
            $this->db->order_by('KODE_USER');
            $query = $this->db->get();
            $result2 = (array) $query->result_array();
            if ($pertama) {
                // var_dump("parent:  " . $result[$i]['KODE_USER'] . " => " . $parentBaru . ($i + 1));
                $par = $parentBaru . ($i + 1);
            } else {
                // var_dump("parent:  " . $result[$i]['KODE_USER'] . " => " . $parentBaru);
                $par = $parentBaru;
            }
            $this->db->where("ID_CAT", $result[$i]['ID_CAT'], TRUE);
            $this->db->update($this->table, array('KODE_USER' => $par));
            if (sizeof($result2) > 0) {
                for ($j = 0; $j < sizeof($result2); $j++) {
                    $this->updateKodeUser($result2[$j]['KODE_USER'], $result2[$j]['LEVEL'], $par . "-" . ($j + 1), false);
                }
            }
        }
    }        

    function getAllPlant() {
        $this->db->from($this->tablePlant);        
        $this->db->where('OBJECT_AS', 'PLANT');
        $result = $this->db->get();
        return (array) $result->result_array();
    }
    
    function updatePlant($data) {
        $this->db->where("ROLE_AS", $data['ROLE_AS'], TRUE);
        $this->db->update($this->tablePlant, $data);
    }

    // $pjg2 = strlen($result[$i]['KODE_USER']);
}
