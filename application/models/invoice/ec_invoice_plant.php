<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ec_invoice_plant extends MY_Model {
        public $table = 'EC_INVOICE_PLANT';
        public $primary_key = 'PLANT';
        public $increments = FALSE;
        protected $timestamps = FALSE;

        public function update($data,$where){
            $this->db->set('UPDATE_DATE','sysdate',FALSE);                        
            return $this->db->update($this->table,$data,$where);
        }
}
