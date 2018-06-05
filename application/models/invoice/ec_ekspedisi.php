<?php defined('BASEPATH') OR exit('No direct script access allowed');
class ec_ekspedisi extends MY_Model {
        public $table = 'EC_EKSPEDISI';
        protected $timestamps = FALSE;
    public function insert($data){
        return $this->db->insert($this->table,$data);
    }

    public function update($no,$data){
		$this->db->where('NO_EKSPEDISI', $no);
		$this->db->update($this->table, $data);
    }
}
