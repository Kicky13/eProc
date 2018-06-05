<?php defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Reverse_Invoice extends MX_Controller {
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
      $this->form();
    }
    public function form($idInvoice = NULL){
      $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
      $this->layout->add_css('plugins/select2/select2.min.css');
      $this->layout->add_css('pages/invoice/common.css');
      $this->layout->add_js('select2.min.js');
      $this->layout->add_js('jquery.alphanum.js');
      $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
      $this->layout->add_js('bootbox.js');
      $this->layout->add_js('pages/invoice/reviseInvoice.js');

      $data['title'] = "Reverse Invoice Posting";
      $data['adaInvoice'] = empty($idInvoice) ? 0 : 1;
      $data['dataCancel'] = array(
        'DOCUMENT' => '',
        'TAHUN' => '',
        'PO_NUMBER' => '',
        'ALASAN' => ''
      );
      $data['urlProsess'] = array(
        '1' => site_url('EC_Invoice_ver/EC_Reverse_Invoice/cancelMr8m'),
        '2' => site_url('EC_Invoice_ver/EC_Reverse_Invoice/cancelF44'),
        '3' => site_url('EC_Invoice_ver/EC_Reverse_Invoice/rejectEkspedisi')
      );
      $data['listTask'] = array();
      if(!empty($idInvoice)){
        $this->load->model('invoice/ec_log_invoice_cancel', 'elc');
        $this->load->model('invoice/ec_log_detail_invoice_cancel', 'eldc');
        $logCancel = $this->elc->as_array()->order_by('CREATE_DATE','DESC')->get(array('ID_INVOICE' => $idInvoice));
        $data['dataCancel'] = $logCancel;
        $data['listTask'] = $this->eldc->as_array()->get_all(array('DOCUMENT_ID' => $logCancel['DOCUMENT_ID']));
      }
      $this->layout->render('reverseFormInvoice',$data);
    }
    /* statusnya dikembalikan menjadi approve posisi dokumen di vendor dan belum kirim */
    public function reverseInvoice(){

      $this->load->model('invoice/ec_invoice_header', 'eih');
      $this->load->model('invoice/ec_log_invoice_cancel', 'elc');
      $this->load->model('invoice/ec_log_detail_invoice_cancel','eldc');
      $nomerMir = $this->input->post('mir');
      $tahun = $this->input->post('tahun');
      $alasan = $this->input->post('alasan_reject');
      $po_number = $this->input->post('po_number');
      $nextPage = 'EC_Invoice_ver/EC_Reverse_Invoice/form';
      $this->db->trans_begin();
      $invoice = $this->eih->get(array('INVOICE_SAP' => $nomerMir,'FISCALYEAR_SAP' => $tahun, 'NO_SP_PO' => $po_number));

      $statusInvoice = '';
      /* yang dihapus statusnya harus 3 ==> approve */
      if(!empty($invoice)){
        $statusInvoice = $invoice->STATUS_HEADER;
        $uniqueDocumentKey = $invoice->ID_INVOICE.'_'.$invoice->INVOICE_SAP.'_'.$invoice->FISCALYEAR_SAP;
        if($statusInvoice == '5'){
        $sqlUpdate = <<<SQL
            update EC_INVOICE_HEADER SET STATUS_HEADER = 3, FI_NUMBER_SAP = NULL, FI_YEAR = NULL, CHDATE = sysdate WHERE ID_INVOICE = '{$invoice->ID_INVOICE}'
SQL;

      $sqlDelete = <<<SQL
        DELETE FROM EC_TRACKING_INVOICE WHERE ID_INVOICE = '{$invoice->ID_INVOICE}' AND STATUS_TRACK >= 5
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
  	      'USERNAME' => $this->user,
          'DOCUMENT_ID' => $uniqueDocumentKey
        );
        $dataDetailLog = array(
          array(
            'DOCUMENT_ID' => $uniqueDocumentKey,
            'TASK_ID' => 1,
            'TASK_NAME' => 'INVOICE CANCEL MR8M'
          ),
          array(
            'DOCUMENT_ID' => $uniqueDocumentKey,
            'TASK_ID' => 2,
            'TASK_NAME' => 'CLEARING DOCUMENT F-44'
          ),
          array(
            'DOCUMENT_ID' => $uniqueDocumentKey,
            'TASK_ID' => 3,
            'TASK_NAME' => 'REJECT EKSPEDISI DOCUMENT'
          )
        );
        $this->elc->insert($dataLog);
        foreach($dataDetailLog as $_dlog){
            $this->eldc->insert($_dlog);
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $pesan = "Invoice ".$nomerMir.", tahun ".$tahun. " fail deleted";
        } else {
            $this->db->trans_commit();
            $pesan = "Invoice ".$nomerMir.", tahun ".$tahun. " deleted";
        }
        $nextPage = 'EC_Invoice_ver/EC_Reverse_Invoice/form/'.$invoice->ID_INVOICE;
      }else{
        /* jika statusnya 3 maka kemungkinan melakukan proses ulang
        * cek apakah di tabel log ada, jika ada maka bisa lanjut
        */
        $adaLog = $this->elc->get(array('DOCUMENT_ID' => $uniqueDocumentKey));
        if(!empty($adaLog)){
          $nextPage = 'EC_Invoice_ver/EC_Reverse_Invoice/form/'.$invoice->ID_INVOICE;
          $pesan = '';
        }else{
          $pesan = 'Invoice dengan nomer mir '.$nomerMir. ' tahun '.$tahun.'  statusnya harus posted (5) invoice ini statusnya bukan posted ('.$statusInvoice.')';
        }
      }
    }else{
      $pesan = 'Invoice dengan nomer mir '.$nomerMir. ' tahun '.$tahun.'  tidak ditemukan';
    }
      $this->session->set_flashdata('message', $pesan);
      redirect($nextPage);
    }

    public function cancelMr8m(){
      $docid = $this->input->post('docid');
      $result = array('status' => 0, 'title' => 'Cancel Invoice Mr8M', 'content' => '','message' => '');
      $result['status'] = 1;
      $_tmp = explode('_',$docid);
      $data['invoice'] = array(
        'mir7' => $_tmp[1],
        'tahun' => $_tmp[2],
        'documentid' => $docid
      );
      $data['reason'] = array(
        '01' =>	'Reversal in current period',
        '02' =>	'Reversal in closed period',
        '03' =>	'Actual reversal in current period',
        '04' =>	'Actual reversal in closed period',
        '05' =>	'Accrual/deferral posting'
      );
      $result['content'] = $this->load->view('EC_Invoice_ver/formCancelMr8m',$data,TRUE);
      echo json_encode($result);
    }

    public function saveCancelMr8m(){
      $result = array('status' => 0, 'message' => '');
      /* panggil ke SAP*/
      $this->load->library('sap_invoice');
      // callFunction($functionName, $input = array(),$output = array(), $isCommit = 0)
      $documentid = $this->input->post('DOCUMENT_ID');
      $input = array(
        'EXPORT_PARAM_SINGLE' => array(
          'FISCALYEAR' => $this->input->post('FISCALYEAR'),
          'INVOICEDOCNUMBER' => $this->input->post('INVOICEDOCNUMBER'),
          'POSTINGDATE' => implode('',array_reverse(explode('/',$this->input->post('POSTINGDATE')))),
          'REASONREVERSAL' => $this->input->post('REASONREVERSAL')
        )
      );

      $output = array(
        'EXPORT_PARAM_SINGLE' => array(
          'INVOICEDOCNUMBER_REVERSAL',
          'FISCALYEAR_REVERSAL'
        ),
        'EXPORT_PARAM_TABLE' => array(
          'RETURN'
        )
      );
      $hasilSAP = $this->sap_invoice->callFunction('BAPI_INCOMINGINVOICE_CANCEL',$input,$output,1);

      /* cek apakah berhasil */
      $invoiceReversal = $hasilSAP['EXPORT_PARAM_SINGLE']['INVOICEDOCNUMBER_REVERSAL'];
      $fiscalReversal = $hasilSAP['EXPORT_PARAM_SINGLE']['FISCALYEAR_REVERSAL'];
      if(!empty($invoiceReversal)){
        $result['status'] = 1;
        $result['message'] = 'Invoice berhasil di reverse dengan INVOICEDOCNUMBER_REVERSAL '.$invoiceReversal.' dan FISCALYEAR_REVERSAL '.$fiscalReversal;
        /* update data di tabel detail log */
        $dataUpdate = array(
          'STATUS' => 1,
          'HASIL' => json_encode(array('INVOICEDOCNUMBER_REVERSAL' => $invoiceReversal,'FISCALYEAR_REVERSAL' => $fiscalReversal))
        );
        $this->load->model('invoice/ec_log_detail_invoice_cancel','eldc');
        $this->eldc->update($dataUpdate,array('DOCUMENT_ID' => $documentid,'TASK_ID' => 1));
      }else{
        $result['message'] = $this->buildMessageErrorSAP($hasilSAP['EXPORT_PARAM_TABLE']['RETURN']);
      }

      echo json_encode($result);
    }

    public function cancelF44(){
      $docid = $this->input->post('docid');
      $result = array('status' => 1, 'title' => 'Cancel F-44', 'content' => '','message' => '');
      $_tmp = explode('_',$docid);

      /* cari document pengancel invoice tersebut */
      $this->load->model('invoice/ec_log_detail_invoice_cancel','eldc');
      $_tmpDoc = $this->eldc->as_array()->get(array('DOCUMENT_ID' => $docid,'TASK_ID' => 1));
      $_numberDoc = json_decode($_tmpDoc['HASIL'],TRUE);
      /*  cari data invoice untuk mengambil currency dan company code */
      $this->load->model('invoice/ec_invoice_header','eih');
      $dataInvoiceLama = $this->eih->as_array()->get(array('ID_INVOICE' => $_tmp[0]));
      /* cari nomer accountingnya */
      $this->load->library('sap_invoice');
      $awkey = $_tmp[1].$_tmp[2];
      $fiNumberLama = $this->getFINumber(array('AWKEY' => $awkey));
      $awkey = $_numberDoc['INVOICEDOCNUMBER_REVERSAL'].$_numberDoc['FISCALYEAR_REVERSAL'];
      $fiNumberCancel = $this->getFINumber(array('AWKEY' => $awkey));
      $data['invoice'] = array(
        'fiNumberLama' => $fiNumberLama['FI_NUMBER'],
        'tahun' => $_tmp[2],
        'documentid' => $docid,
        'currency' => $dataInvoiceLama['CURRENCY'],
        'companyCode' => $dataInvoiceLama['COMPANY_CODE'],
        'vendorNo' => $dataInvoiceLama['VENDOR_NO']
      );
      $data['invoice']['fiNumberReversal'] = $fiNumberCancel['FI_NUMBER'];
      $result['content'] = $this->load->view('EC_Invoice_ver/formCancelF44',$data,TRUE);
      echo json_encode($result);
    }

    public function saveCancelF44(){
      /* panggil RFC di SAP */
      $result = $this->cancelF44SAP();
      $documentid = $this->input->post('DOCUMENT_ID');
      if($result['status']){
        /* update di oracle */
        $dataUpdate = array(
          'STATUS' => 1
        );
        $this->load->model('invoice/ec_log_detail_invoice_cancel','eldc');
        $this->eldc->update($dataUpdate,array('DOCUMENT_ID' => $documentid,'TASK_ID' => 2));
      }

      echo json_encode($result);
    }
    public function rejectEkspedisi(){
      $docid = $this->input->post('docid');
      $result = array('status' => 1, 'title' => 'Reject Ekspedisi', 'content' => '','message' => '');
      $_tmp = explode('_',$docid);
      $data['invoice'] = array(
        'mir7' => $_tmp[1],
        'tahun' => $_tmp[2],
        'documentid' => $docid
      );
      $result['content'] = $this->load->view('EC_Invoice_ver/formRejectEkspedisi',$data,TRUE);
      echo json_encode($result);
    }

    public function cancelF44SAP(){
      $this->load->library('sap_invoice');
      // callFunction($functionName, $input = array(),$output = array(), $isCommit = 0)
      $input = array(
        'EXPORT_PARAM_SINGLE' => array(
          'P_BUKRS' => $this->input->post('P_BUKRS'),
          'P_ACCOUNT' => $this->input->post('P_ACCOUNT'),
          'P_BUDAT' => implode('',array_reverse(explode('/',$this->input->post('P_BUDAT')))),
          'P_MONAT' => $this->input->post('P_MONAT'),
          'P_WAERS' => $this->input->post('P_WAERS'),
          'P_BELNR1' => $this->input->post('P_BELNR1'),
          'P_BELNR2' => $this->input->post('P_BELNR2')
        )
      );

      $output = array(
        'EXPORT_PARAM_ARRAY' => array(
          'RETURN'
        ),
        'EXPORT_PARAM_TABLE' => array(
          'IT_OUTPUT'
        )
      );
      $hasilSAP = $this->sap_invoice->callFunction('Z_ZCFI_CLEAR_VENDOR_INVOICE',$input,$output);
      $result = array('status' => 0, 'message' => 'Berhasil diclearing');
      if($hasilSAP['EXPORT_PARAM_ARRAY']['RETURN']['TYPE'] == 'S'){
        $result['status'] = 1;
      }else{
        $_error_message = $this->buildMessageErrorSAP(array($hasilSAP['EXPORT_PARAM_ARRAY']['RETURN']));
        $result['message'] = array_merge($_error_message,$this->buildMessageErrorSAP($hasilSAP['EXPORT_PARAM_TABLE']['IT_OUTPUT']));
      }
      return $result;
    }

    public function saveRejectEkspedisi(){
      $result = array('status' => 0, 'message' => '');
      $documentid = $this->input->post('DOCUMENT_ID');
      $_tmp = explode('_',$documentid);
      $idinvoice = $_tmp[0];
      /* panggil RFC di SAP */
      $rejectSAP = $this->verifikasiRejectDokumenSAP($idinvoice,'reject karena reverse invoice');
      if($rejectSAP['status']){
        /* update di oracle */
        $dataUpdate = array(
          'STATUS' => 1
        );
        $this->load->model('invoice/ec_log_detail_invoice_cancel','eldc');
        $this->load->model('invoice/ec_log_invoice_cancel','elc');
        $dataUpdate = array(
          'STATUS' => 1
        );
        $this->eldc->update($dataUpdate,array('DOCUMENT_ID' => $documentid,'TASK_ID' => 3));
        $this->elc->update(array('COMPLETED_TASK' => 1),array('DOCUMENT_ID' => $documentid));
        $result['message'] = 'Document berhasil di reject';
        $result['status'] = 1;
      }else{
        $result['message'] = $rejectSAP['message'];
      }
      echo json_encode($result);
    }

    public function verifikasiRejectDokumenSAP($invoice,$alasan_reject){
        $this->load->library('sap_handler');
        $this->load->model('invoice/ec_ekspedisi','ee');
        $ekspedisi = $this->ee->order_by('CREATE_DATE','DESC')->get(array('ID_INVOICE' => $invoice));

    //    $update_eks = array('ALASAN_REJECT_DOCUMENT'=> $alasan_reject);
    //    $this->ee->update($ekspedisi->NO_EKSPEDISI,$update_eks);
        //print_r($this->db->last_query());
        //die();
        $header = array();
        $header['company'] = $ekspedisi->COMPANY;
        $header['no_ekspedisi'] = $ekspedisi->NO_EKSPEDISI;
      	$header['tahun'] = $ekspedisi->TAHUN;
      	$header['accounting_invoice'] = $ekspedisi->ACCOUNTING_INVOICE;
        $header['username'] = $this->session->userdata('FULLNAME');
        $t = $this->sap_handler->verifikasiRejectDokumenSAP($header);
        $result = array(
          'status' => 0,
          'message' => ''
        );
        if($t[0]['TYPE'] == 'S'){
          $result['status'] = 1;
          $result['message'] = $t[0]['MESSAGE'];
        }else{
          $result['message'] = $t[0]['MESSAGE'];
        }
        return $result;
    }

    private function buildMessageErrorSAP($error){
      $pesan = array();
      foreach($error as $ps){
        $tmp = array();
        foreach($ps as $k => $p){
          array_push($tmp,$k.' => '.$p);
        }
        array_push($pesan,implode('<br />',$tmp));
      }
      return $pesan;
    }

    public function getFINumber($data){
      $this->load->library('sap_invoice');
      $y = $this->sap_invoice->getFINumber($data);
      return $y;
    }
}
