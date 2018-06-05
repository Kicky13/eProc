<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ec_posting_invoice_pajak extends MY_Model {	
        public $table = 'EC_POSTING_INVOICE_PAJAK';
      //  public $primary_key = 'ID_JENIS';	                                                
      //  protected $timestamps = FALSE;
       public function insert($data){
           return $this->db->insert($this->table,$data);
       } 
}
