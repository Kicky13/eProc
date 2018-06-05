<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ec_bapp extends MY_Model {
    public $table = 'EC_BAPP';
    public $primary_key = 'ID';
    protected $timestamps = FALSE;
    protected $after_get = array('convertTgl');
    public function get_all_by($where){
      $this->db->where($where);
      return parent::get_all();
    }

    public function get_all_with_vendor($where){
      $this->db->distinct();
      $this->db->join('VND_HEADER','VND_HEADER.VENDOR_NO = EC_BAPP.NO_VENDOR');
      $this->db->where($where);
      return parent::get_all();
    }

    public function update($data = NULL, $column_name_where = NULL, $escape = TRUE){
        $this->db->set('UPDATE_AT','sysdate',FALSE);
        return parent::update($data,$column_name_where,$escape);
    }

    public function convertTgl($rows){
      if($this->isMultiArray($rows)){
        foreach($rows as &$row){
          $row = $this->_convertTgl($row);
        }
      }else{
        $rows = $this->_convertTgl($rows);
      }
      return $rows;
    }

    private function _convertTgl($row){
      if(is_object($row)){
        $row->CREATE_AT = $this->localDate($row->CREATE_AT,'d M Y');
      }
      if(is_array($row)){
        $row['CREATE_AT'] = $this->localDate($row['CREATE_AT'],'d M Y');
      }
      return $row;
    }

    private function isMultiArray($myarray){
      return !(count($myarray) == count($myarray, COUNT_RECURSIVE));
    }

    private function localDate($date,$format){
      return date($format,strtotime($date));
    }
    /* generate nomer bapp, reset pertahun */
    public function generateNumber($unitKerja,$jenis){
      /* nomer terakhir */
      $maxLength = 4;
      $sql = <<<SQL
      select max(substr(no_bapp,0,{$maxLength})) LASTNUMBER,TO_CHAR(SYSDATE,'MM.YYYY') MONTH from ec_bapp
      where status = '3' and to_char(update_at,'YYYY') = to_char(sysdate,'YYYY')
SQL;
      $r = $this->db->query($sql)->row_array();
      $number = empty($r['LASTNUMBER']) ? 0 : $r['LASTNUMBER'];
      $nextNumber = str_pad(intval($number) + 1,4,'0',STR_PAD_LEFT);
      $bulan = $r['MONTH'];
      $pola = array(
        $nextNumber,$jenis,$unitKerja,$bulan
      );
      return implode('/',$pola);
    }

    public function getBapp($gr = array()){
      $_tmp = array();
      $result = array();
      if(!empty($gr)){
        foreach($gr as $g){
          array_push($_tmp,' select \''.$g['gr_no'].'\' as GR_NO,\''.$g['gr_item_no'].'\' as GR_ITEM_NO,\''.$g['gr_year'].'\' as GR_YEAR  from dual');
        }
        $sql = "
          select distinct EB.ID,EB.NO_BAPP
          from EC_BAPP_ITEM EBI
          join EC_BAPP EB on EB.ID = EBI.EC_BAPP
          join (
            ".implode('union',$_tmp)."
            )x on x.GR_NO = EBI.GR_NO and x.GR_ITEM_NO = EBI.GR_ITEM_NO and x.GR_YEAR = EBI.GR_YEAR
        ";
        $result = $this->db->query($sql)->result_array();
      }
      return $result;
    }
}
