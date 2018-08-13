<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ec_tracking_um extends MY_Model {
	public $table = 'EC_TRACKING_UM';
        public function insert($data){
					  if(isset($data['DATE'])){
							$this->db-> set('DATE',$data['DATE'], FALSE);			
							unset($data['DATE']);
						}else{
							$this->db-> set('DATE', "sysdate", FALSE);
						}
            return $this->db->insert($this->table,$data);
        }
}
