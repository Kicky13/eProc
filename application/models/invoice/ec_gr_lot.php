<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ec_gr_lot extends MY_Model {
    public $table = 'EC_GR_LOT';
    public $primary_key = 'LOT_NUMBER';

    public function getlot($id) {
        $this->db->where("LOT_NUMBER", $id, true);
        $max = $this->db->get($this->table)->row_array();
        return $max;
    }

    public function insert($data){
        if($this->db->insert($this->table,$data)){
            return $this->get_last_id();
        };
    }

    public function get_last_id() {
        $this->db->select_max($this->primary_key, 'MAX');
        $max = $this->db->get($this->table)->row_array();
        return $max['MAX'];
    }

    public function update($data = NULL, $where = NULL){

      if($data['STATUS'] == 2){
          $this->db->set('APPROVED1_AT','sysdate',FALSE);
      }
      if($data['STATUS'] == 3){
          $this->db->set('APPROVED2_AT','sysdate',FALSE);
      }
      if($data['STATUS'] == 4){
          $this->db->set('REJECTED_AT','sysdate',FALSE);
      }

      $this->db->where($where);
      return $this->db->update($this->table,$data);
    }

}
