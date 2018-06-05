<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ec_gr_sap extends MY_Model {	
        public $table = 'EC_GR_SAP';
        protected $timestamps = FALSE;
    public function insert($data){
        return $this->db->insert($this->table,$data);
    }   
}
