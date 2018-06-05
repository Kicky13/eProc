<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ec_posting_invoice extends MY_Model {	
    public $table = 'EC_POSTING_INVOICE';
    //  public $primary_key = 'ID_JENIS';	                                                
    public function insert($data){        
        $this->db->set('POSTING_DATE','TO_DATE(\''.$data['POSTING_DATE'].'\',\'YYYY-MM-DD\')',FALSE);
        $this->db->set('BASELINE_DATE','TO_DATE(\''.$data['BASELINE_DATE'].'\',\'YYYY-MM-DD\')',FALSE);
        unset($data['POSTING_DATE']);
        unset($data['BASELINE_DATE']);
                
        return $this->db->insert($this->table,$data);
    }    
}   

