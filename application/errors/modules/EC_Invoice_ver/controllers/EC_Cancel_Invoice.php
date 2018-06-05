<?php defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Cancel_Invoice extends MX_Controller {
    private $user;
    private $user_email;
    public function __construct() {
        parent::__construct();
        //error_reporting(0);
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->user_email = $this->session->userdata('EMAIL'); // login pakai email tanpa semen indonesia.com
        $this->user = $this->session->userdata('FULLNAME');
    }
    public function index(){
      $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
      $this->layout->add_css('plugins/select2/select2.min.css');
      $this->layout->add_css('pages/invoice/common.css');
      $this->layout->add_js('select2.min.js');
      $this->layout->add_js('jquery.alphanum.js');

      $data['title'] = "Cancel Invoice Park";
      $this->layout->render('cancelFormInvoice',$data);
    }

    public function cancelInvoice(){
      $this->load->model('invoice/ec_invoice_header', 'eih');
      $this->load->model('invoice/ec_log_invoice_cancel', 'elc');
      $nomerMir = $this->input->post('mir');
      $tahun = $this->input->post('tahun');
      $alasan = $this->input->post('alasan_reject');
      $po_number = $this->input->post('po_number');

      $this->db->trans_begin();
      $invoice = $this->eih->get(array('INVOICE_SAP' => $nomerMir,'FISCALYEAR_SAP' => $tahun, 'NO_SP_PO' => $po_number));
      $statusInvoice = '';
      /* yang dihapus statusnya harus 3 ==> approve */
      if(!empty($invoice)){
        $statusInvoice = $invoice->STATUS_HEADER;
        if($statusInvoice == '3'){
        $sqlUpdate = <<<SQL
          update EC_INVOICE_HEADER SET STATUS_HEADER = 2, INVOICE_SAP = NULL, FISCALYEAR_SAP = NULL, FI_NUMBER_SAP = NULL, FI_YEAR = NULL, CHDATE = sysdate WHERE ID_INVOICE = '{$invoice->ID_INVOICE}'
SQL;
        $sqlDelete = <<<SQL
          delete FROM EC_TRACKING_INVOICE WHERE STATUS_TRACK IN (3,4,5) AND ID_INVOICE = '{$invoice->ID_INVOICE}'
SQL;
        $this->db->query($sqlUpdate);
        $this->db->query($sqlDelete);
        /* insert datanya ke tabel log */
        $dataLog = array(
          'ID_INVOICE' => $invoice->ID_INVOICE,
          'DOCUMENT' => $nomerMir,
  	      'TAHUN' => $tahun,
  	      'STATUS_DOCUMENT' => $statusInvoice,
  	      'ALASAN' => $alasan,
          'PO_NUMBER' => $po_number,
  	      'USERNAME' => $this->user
        );
        $this->elc->insert($dataLog);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $pesan = "Invoice ".$nomerMir.", tahun ".$tahun. " fail deleted";
        } else {
            $this->db->trans_commit();
            $pesan = "Invoice ".$nomerMir.", tahun ".$tahun. " deleted";
        }
      }else{
        $pesan = 'Invoice dengan nomer mir '.$nomerMir. ' tahun '.$tahun.'  statusnya harus approved (3) invoice ini statusnya bukan approved ('.$statusInvoice.')';
      }
    }else{
      $pesan = 'Invoice dengan nomer mir '.$nomerMir. ' tahun '.$tahun.'  tidak ditemukan';
    }
      $this->session->set_flashdata('message', $pesan);
      redirect("EC_Invoice_ver/EC_Cancel_Invoice");
    }
}
