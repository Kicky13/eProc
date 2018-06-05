<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ec_log_invoice_cancel extends MY_Model {
    public $table = 'EC_LOG_INVOICE_CANCEL';
    protected $timestamps = FALSE;
    public $increments = FALSE;
    public $primary_key = 'ID_INVOICE';

    public function getInvoiceCanceled($company,$status_task,$status_reinvoice){
    	$this->db->select("TO_CHAR (IC.CREATE_DATE,'DD-MM-YYYY') AS CREATE_DATE2,IC.DOCUMENT,IH.*,VH.VENDOR_NAME",false);
    	$this->db->from($this->table.' IC');
    	$this->db->join('EC_INVOICE_HEADER IH', 'IH.ID_INVOICE = IC.ID_INVOICE');
    	$this->db->join('VND_HEADER VH','VH.VENDOR_NO = IH.VENDOR_NO');
    	$where = array(
    			'IC.STATUS_DOCUMENT' => '5', // 3 = Cancel Approve, 5 = Cancel Posting
    			'IC.STATUS_REINVOICE' => $status_reinvoice, // 0 = belum reinvoice, 1 = sudah reinvoice
    			'IC.COMPLETED_TASK' => $status_task // 0 = Cancel proses belum 100% berhasil, 1 Berhasil
    		);
    	$this->db->where($where);
      $this->db->where('IC.DOCUMENT_ID IS NOT NULL');
    	$this->db->where_in('IH.COMPANY_CODE',$company);

    	//$a = $status=='0' ? array('IC.CREATE_DATE','ASC') : array('IC.CREATE_DATE','DESC');
    	//var_dump($a);die();
    	$this->db->order_by('IC.CREATE_DATE','ASC');

    	return $this->db->get()->result_array();
    }

}
