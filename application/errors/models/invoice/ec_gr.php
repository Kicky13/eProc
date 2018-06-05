<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ec_gr extends MY_Model {
        public $table = 'EC_GR';
        protected $timestamps = FALSE;
    public function insert($data){
        return $this->db->insert($this->table,$data);
    }
    public function getGRWithRR($invoice){
      $sql = <<<SQL
      select EG.*,coalesce((select BELNR from EC_GR_SAP where LFBNR = EG.GR_NO and LFGJA = EG.GR_YEAR and LFPOS = EG.GR_ITEM_NO and BWART = 105 and rownum < 2 ),EG.GR_NO) RR_NO
      from EC_GR EG where INV_NO = '{$invoice}'
SQL;
      return $this->db->query($sql)->result_array();
    }
}
