<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ec_bapp_item extends MY_Model {
    public $table = 'EC_BAPP_ITEM';
    public $primary_key = 'EC_BAPP';
    protected $timestamps = FALSE;
    public $increments = FALSE;
    public function get_all_by($where){
      $this->db->where($where);
      return parent::get_all();
    }
}
