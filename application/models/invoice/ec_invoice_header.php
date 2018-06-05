<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ec_invoice_header extends MY_Model {
    public $table = 'EC_INVOICE_HEADER';
    protected $timestamp = FALSE;
    public $primary_key = 'ID_INVOICE';

    public function update($data,$where){
        $this->db->set('CHDATE','sysdate',FALSE);
        if(isset($data['INVOICE_DATE'])){
          $this->db->set('INVOICE_DATE','TO_DATE(\''.$data['INVOICE_DATE'].'\',\'DD/MM/YYYY\')',FALSE);
          unset($data['INVOICE_DATE']);
        }
        if(isset($data['FAKTUR_PJK_DATE'])){
          $this->db->set('FAKTUR_PJK_DATE','TO_DATE(\''.$data['FAKTUR_PJK_DATE'].'\',\'DD/MM/YYYY\')',FALSE);
          unset($data['FAKTUR_PJK_DATE']);
        }        
        return $this->db->update($this->table,$data,$where);
    } 

    public function insert($data){
        $this->db->set('CHDATE','sysdate',FALSE);
        $this->db->set('INDATE','sysdate',FALSE);
        $this->db->set('INVOICE_DATE','TO_DATE(\''.$data['INVOICE_DATE'].'\',\'DD/MM/YYYY\')',FALSE);
        $this->db->set('FAKTUR_PJK_DATE','TO_DATE(\''.$data['FAKTUR_PJK_DATE'].'\',\'DD/MM/YYYY\')',FALSE);
        unset($data['FAKTUR_PJK_DATE']);
        unset($data['INVOICE_DATE']);
        if($this->db->insert($this->table,$data)){
            return $this->get_last_id();
        };
    }

    public function get_last_id() {
        $this->db->select_max($this->primary_key, 'MAX');
        $max = $this->db->get($this->table)->row_array();
        return $max['MAX'];
    }

    public function get_faktur($FAKTUR_PJK) {
        $this->db->where("FAKTUR_PJK", $FAKTUR_PJK, true);
        $max = $this->db->get($this->table)->row_array();
        return $max;
    }


    // QUEUE
    public function get_queue_number($idinvoice,$statusheader){

        $sql = "
            SELECT yy.II FROM(
            SELECT a.*,ROWNUM II  FROM (
                SELECT ID_INVOICE,CHDATE  FROM EPROC.EC_INVOICE_HEADER  WHERE STATUS_HEADER=2
                ORDER BY CHDATE
            )a
        )yy WHERE yy.ID_INVOICE = ".$idinvoice;

        $query = $this->db->query($sql);
        return (array) $query->result_array();
    }
}
