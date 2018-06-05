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

    public function getQtyInvoiced($gr_no,$gr_line){
      $query = "
            SELECT GR_NO,GR_ITEM_NO,SUM(GR_ITEM_QTY) AS QTY 
            FROM EC_GR 
            WHERE GR_NO = '$gr_no' AND GR_ITEM_NO = $gr_line 
            GROUP BY GR_NO,GR_ITEM_NO
      ";

      $result = $this->db->query($query)->result_array();
      if($result){
        return $result[0]['QTY'];
      }else{
        return 0;
      }
    }
}
