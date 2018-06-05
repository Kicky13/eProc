<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ec_landed_cost extends MY_Model {	
    public $table = 'EC_GR_LANDED_COST';
    public $primary_key = 'BELNR';	                                                
    
    public function insert($data){
        return $this->db->insert($this->table,$data);
    }

    public function delete($cpudt){
        return $this->db->where('CPUDT',$cpudt)->delete($this->table);
    }

    public function getDataLanded($belnr,$ebelp,$mjahr){ // benlr = NO RR, ebelp = PO Item No, $mjahr = Doc Year
    	$this->db->select('KSCHL,VTEXT,LIFNR,NAME1,WAERS,DMBTR,EBELP,BELNR');
    	$this->db->where(array('BELNR'=>$belnr,'EBELP'=>$ebelp,'MJAHR'=>$mjahr));
    	$this->db->group_by('KSCHL,VTEXT,LIFNR,NAME1,WAERS,DMBTR,EBELP,BELNR');
    	return $this->db->get($this->table)->result_array();
    }
}
