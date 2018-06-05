<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ec_tracking_invoice extends CI_Model {
	protected $table = 'EC_TRACKING_INVOICE';
	public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	}

        public function insert($data){                        
            $this->db-> set('DATE', "sysdate", FALSE);		
            return $this->db->insert($this->table,$data);
        }
                
	
}
