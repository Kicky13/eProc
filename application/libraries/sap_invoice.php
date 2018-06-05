<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * Bikin koneksi ke SAP. coba perhatikan fungsi getVendor.
 * Input dan return dari sap bisa macemmacem, bisa cuma satu
 * data, bisa tabel, bisa banyak tabel, gabungan keduanya, dll.
 */
require_once('sap_handler.php');
class sap_invoice extends sap_handler{

    public function __construct() {
        parent::__construct();
    }
    public function getListAccount($data){
      $this->openFunction('BAPI_GL_ACC_GETLIST');
      $this->fce->LANGUAGE = $data['LANGUAGE'];
      $this->fce->COMPANYCODE = $data['COMPANYCODE'];
      @$this->fce->call();
      $i = 0;
      $itTampung = array();
      if ($this->fce->GetStatus() == SAPRFC_OK) {
          $this->fce->ACCOUNT_LIST->Reset();
          while ($this->fce->ACCOUNT_LIST->Next()) {
              $itTampung[] = $this->fce->ACCOUNT_LIST->row;
          }
      }
      return $itTampung;
    }

    public function getDetailInvoice($data) {
        $this->openFunction('BAPI_INCOMINGINVOICE_GETDETAIL');
        $this->fce->INVOICEDOCNUMBER = $data['INVOICEDOCNUMBER'];
        $this->fce->FISCALYEAR = $data['FISCALYEAR'];
        $this->fce->call();
        $i = 0;
        $itTampung = array('HEADERDATA' => array() ,'GLACCOUNTDATA' => array(), 'ITEMDATA' => array(), 'ACCOUNTINGDATA' => array(), 'WITHTAXDATA' => array(), 'TAXDATA' => array());
        if ($this->fce->GetStatus() == SAPRFC_OK) {
            $itTampung['HEADERDATA'] = $this->fce->HEADERDATA;
            $this->fce->GLACCOUNTDATA->Reset();
            while ($this->fce->GLACCOUNTDATA->Next()) {
                $itTampung['GLACCOUNTDATA'][] = $this->fce->GLACCOUNTDATA->row;
            }
            $this->fce->ITEMDATA->Reset();
            while ($this->fce->ITEMDATA->Next()) {
                $itTampung['ITEMDATA'][] = $this->fce->ITEMDATA->row;
            }

            $this->fce->ACCOUNTINGDATA->Reset();
            while ($this->fce->ACCOUNTINGDATA->Next()) {
                $itTampung['ACCOUNTINGDATA'][] = $this->fce->ACCOUNTINGDATA->row;
            }

            $this->fce->WITHTAXDATA->Reset();
            while ($this->fce->WITHTAXDATA->Next()) {
                $itTampung['WITHTAXDATA'][] = $this->fce->WITHTAXDATA->row;
            }

            $this->fce->TAXDATA->Reset();
            while ($this->fce->TAXDATA->Next()) {
                $itTampung['TAXDATA'][] = $this->fce->TAXDATA->row;
            }
        }
        return $itTampung;
    }

    /*Mendaftarkan E-Nofa (Memasukan E-Nofa Vendor Ke SAP)*/
    public function setEnofa($data){
      $this->openFunction('Z_ZCFI_INPUT_FAKTUR_PAJAK');
      $this->fce->I_BUKRS = $data['BUKRS']; // Company
      $this->fce->I_LIFNR = $data['LIFNR']; // Vendor No
      $this->fce->I_FPNUML = $data['FPNUML']; // Start No E-Nofa
      $this->fce->I_FPNUMH = $data['FPNUMH']; // End Number E-Nofa No E-Nofa
      $this->fce->I_BEGDA = $data['BEGDA']; // Begin Date
      $this->fce->I_ENDDA = $data['ENDDA']; // End Date
      //$this->fce->I_JABAT1 = 'Uji Coba';
      $this->fce->I_UNAME = $data['UNAME'];

      $this->fce->call();
      $i = 0;
      $itTampung = array();
      if ($this->fce->GetStatus() == SAPRFC_OK) {
        $itTampung[0]=$this->fce->RETURN;
      }
      return $itTampung;
    }

    /* cari range no faktur yang valid, parameternya company dan no_vendor */
    public function getRangeFakturNo($data = ''){
      $this->openFunction('Z_RANGE_FAKTURPAJAK');
      if($data != ''){
          $this->fce->R_LIFNR->row['SIGN'] = 'I';
          $this->fce->R_LIFNR->row['OPTION'] = 'EQ';
          $this->fce->R_LIFNR->row['LOW'] = $data['VENDOR_NO'];
          $this->fce->R_LIFNR->Append($this->fce->R_LIFNR->row);
      }
      $this->fce->call();
      $i = 0;
      $itTampung = array();
      if ($this->fce->GetStatus() == SAPRFC_OK) {
          $this->fce->T_DATA->Reset();
          while ($this->fce->T_DATA->Next()) {
              $itTampung[] = $this->fce->T_DATA->row;
          }
      }
      return $itTampung;
    }

    /* cari nomer fi accounting invoice */
    public function getFINumber($data){
      $this->openFunction('BKK_RFC_GL_GET_DOCNO_BY_AWKEY');
      $this->fce->I_AWSYS = ' ';
      $this->fce->I_AWTYP = 'RMRP';
      $this->fce->I_AWKEY = $data['AWKEY'];

      $this->fce->call();
      $i = 0;
      $itTampung = array();
      if ($this->fce->GetStatus() == SAPRFC_OK) {
          $itTampung = array('COMPANY_CODE' => $this->fce->E_BUKRS, 'FI_NUMBER' => $this->fce->E_BELNR, 'FI_YEAR' => $this->fce->E_GJAHR);
      }
      return $itTampung;
    }
    /* tampilkan data document accounting invoice yang akan dibayarkan ke vendor */
    public function getListAccountingDocument($data){
      $this->openFunction('ZFM_BKPF_BSEG');
      $this->fce->I_BUKRS = $data['I_BUKRS'];
      $this->fce->I_BELNR_FROM = $data['I_BELNR_FROM'];
      $this->fce->I_GJAHR = $data['I_GJAHR'];

      $this->fce->call();
      $i = 0;
      $itTampung = array();
      if ($this->fce->GetStatus() == SAPRFC_OK) {
        $this->fce->T_BSEG->Reset();
        while ($this->fce->T_BSEG->Next()) {
            $itTampung[] = $this->fce->T_BSEG->row;
        }
      }
      return $itTampung;
    }

    /* update status dokumen ekspedisi */
    public function getDokumenStatusEkspedisi($data){
      $this->openFunction('ZCFIFM_DISPLAY_APPROVE');
      $this->fce->P_BUKRS = $data['P_BUKRS'];
      $this->fce->P_GJAHR = $data['P_GJAHR'];
      $this->fce->X_GET_PARK_DOC = 'X';
      $this->fce->X_GET_CLEAR_DAT = 'X';

      $this->fce->R_BELNR->row['SIGN'] = 'I';
      $this->fce->R_BELNR->row['OPTION'] = 'EQ';
      $this->fce->R_BELNR->row['LOW'] = $data['FI_NUMBER'];
      $this->fce->R_BELNR->Append($this->fce->R_BELNR->row);

      $this->fce->call();
      $i = 0;
      $itTampung = array();
      if ($this->fce->GetStatus() == SAPRFC_OK) {
        $this->fce->T_OUT->Reset();
        while ($this->fce->T_OUT->Next()) {
            $itTampung[] = $this->fce->T_OUT->row;
        }
      }
      return $itTampung;
    }


    /* TEST GET USER DETAIL */
    public function getUserDetail(){
      $this->openFunction('BAPI_USER_GETLIST');
      //$this->fce->USERNAME = $id;
      //$this->fce->CACHE_RESULT = 'X';
      $this->fce->call();

      $itTampung = array();
      if ($this->fce->GetStatus() == SAPRFC_OK) {

        $this->fce->USERLIST->Reset();
        while ($this->fce->USERLIST->Next()) {
            $itTampung[] = $this->fce->USERLIST->row;
        }

      }
      return $itTampung;
    }

    public function kirimDokumenVerifikasi($header,$updateEkspedisi,$item){
      $this->openFunction('ZCFI_DOC_EXPEDITION');
      $this->fce->P_EXPDS_TYPE = 	4;

      foreach($header as $index => $_h){
        $this->fce->T_EXPDS_HEADER->row['INDEX'] = $index;
        $this->fce->T_EXPDS_HEADER->row['BUKRS'] = $_h['company'];
        $this->fce->T_EXPDS_HEADER->row['GJAHR'] = date('Y');
        $this->fce->T_EXPDS_HEADER->row['STATUS'] = 3;
        $this->fce->T_EXPDS_HEADER->row['CPUDT'] = date('Ymd');
      //	$this->fce->T_EXPDS_HEADER['USNAM'] = $header['vendor'];
        $this->fce->T_EXPDS_HEADER->row['USNAM'] = $_h['username'];
        $this->fce->T_EXPDS_HEADER->Append($this->fce->T_EXPDS_HEADER->row);
      }

      foreach($item as $index => $it){
        foreach($it as $_t){
          $this->fce->T_EXPDS_ITEM->row['INDEX'] = $index;
          $this->fce->T_EXPDS_ITEM->row['BUKRS'] = $header[$index]['company'];
        	$this->fce->T_EXPDS_ITEM->row['GJAHR'] = date('Y');
        	$this->fce->T_EXPDS_ITEM->row['BELNR'] = $_t['invoice'];
        	$this->fce->T_EXPDS_ITEM->row['CPUDT'] = date('Ymd');
          $this->fce->T_EXPDS_ITEM->row['NO_EKSPEDISI'] =$_t['no_ekspedisi'];
        	$this->fce->T_EXPDS_ITEM->row['BUDAT'] = $header[$index]['posting_date']; // posting date
        	$this->fce->T_EXPDS_ITEM->row['BLDAT'] = $header[$index]['invoice_date']; // invoice date
        	$this->fce->T_EXPDS_ITEM->row['WAERS'] = $_t['currency'];
        	$this->fce->T_EXPDS_ITEM->row['USNAM'] = $header[$index]['username'];
        	$this->fce->T_EXPDS_ITEM->row['WRBTR'] = $_t['amount'];
        	$this->fce->T_EXPDS_ITEM->row['ZLSPR'] = $_t['payment_block'];
        	$this->fce->T_EXPDS_ITEM->row['DMBTR'] = $_t['amount_local'];
        	$this->fce->T_EXPDS_ITEM->row['EBELN'] = $_t['po'];
        	$this->fce->T_EXPDS_ITEM->row['EBELP'] = $_t['item_po'];
          $this->fce->T_EXPDS_ITEM->Append($this->fce->T_EXPDS_ITEM->row);
        }
      }

      $this->fce->call();
      $itTampung = array();
      if ($this->fce->GetStatus() == SAPRFC_OK){
        $this->fce->T_RETURN->Reset();
        while ($this->fce->T_RETURN->Next()) {
            $itTampung[] = $this->fce->T_RETURN->row;
        //    print_r($this->fce->T_RETURN->row);
        }

      }
      $this->openFunction('BAPI_TRANSACTION_COMMIT');
      $this->fce->call();
      return $itTampung;
    }

    public function getSimulateData($header,$item,$pajakPosting,$GLAccount,$taxData,$debug){
      $this->openFunction('Z_ZCMM_INVOICE_CREATE');

      $this->fce->FI_SIMULATE = 'X';

      $this->fce->FI_HEADER_DATA['INVOICE_IND'] = $header['INVOICE_IND']; // 'X'
      $this->fce->FI_HEADER_DATA['DOC_TYPE'] = $header['DOC_TYPE']; //
      $this->fce->FI_HEADER_DATA['DOC_DATE'] = $header['DOC_DATE']; //
      $this->fce->FI_HEADER_DATA['PSTNG_DATE'] = $header['PSTNG_DATE'];
      $this->fce->FI_HEADER_DATA['REF_DOC_NO'] = $header['REF_DOC_NO'];
      $this->fce->FI_HEADER_DATA['COMP_CODE'] = $header['COMP_CODE'];
      $this->fce->FI_HEADER_DATA['CURRENCY'] = $header['CURRENCY'];
      $this->fce->FI_HEADER_DATA['GROSS_AMOUNT'] = $header['GROSS_AMOUNT'];
      $this->fce->FI_HEADER_DATA['CALC_TAX_IND'] = $header['CALC_TAX_IND'];
      $this->fce->FI_HEADER_DATA['PMNTTRMS'] = $header['PMNTTRMS'];
      $this->fce->FI_HEADER_DATA['BLINE_DATE'] = $header['BLINE_DATE'];
      $this->fce->FI_HEADER_DATA['HEADER_TXT'] = $header['HEADER_TXT'];
      $this->fce->FI_HEADER_DATA['PMNT_BLOCK'] = $header['PMNT_BLOCK'];
      $this->fce->FI_HEADER_DATA['PYMT_METH'] = $header['PYMT_METH'];
      $this->fce->FI_HEADER_DATA['PARTNER_BK'] = $header['PARTNER_BK'];

      for ($i = 0; $i < count($item); $i++) {
            $this->fce->FT_ITEMDATA->row['INVOICE_DOC_ITEM'] = $i + 1;
            $this->fce->FT_ITEMDATA->row['PO_NUMBER'] = $item[$i]['PO_NO'];
            $this->fce->FT_ITEMDATA->row['PO_ITEM'] = $item[$i]['PO_ITEM_NO'];
            if($header['ITEM_CAT'] == '9'){
                $this->fce->FT_ITEMDATA->row['SHEET_NO'] = $item[$i]['GR_NO'];
                $this->fce->FT_ITEMDATA->row['SHEET_ITEM'] = str_pad($item[$i]['GR_ITEM_NO'] * 10, 10, '0', STR_PAD_LEFT);
                $this->fce->FT_ITEMDATA->row['PO_UNIT'] = !empty($item[$i]['UOM']) ? $item[$i]['UOM'] : 'AU';
            }else{
                $this->fce->FT_ITEMDATA->row['REF_DOC'] = $item[$i]['GR_NO'];
                $this->fce->FT_ITEMDATA->row['REF_DOC_YEAR'] = empty($item[$i]['GR_YEAR']) ? date('Y') : $item[$i]['GR_YEAR'];
                $this->fce->FT_ITEMDATA->row['REF_DOC_IT'] = str_pad($item[$i]['GR_ITEM_NO'], 4, '0', STR_PAD_LEFT);
                $this->fce->FT_ITEMDATA->row['PO_UNIT'] = !empty($item[$i]['UOM']) ? $item[$i]['UOM'] : 'TO';
            }

            $this->fce->FT_ITEMDATA->row['TAX_CODE'] = $item[$i]['TAX_CODE'];
            $this->fce->FT_ITEMDATA->row['ITEM_AMOUNT'] = $item[$i]['GR_AMOUNT_IN_DOC'];
            $this->fce->FT_ITEMDATA->row['QUANTITY'] = $item[$i]['GR_ITEM_QTY'];

            $this->fce->FT_ITEMDATA->Append($this->fce->FT_ITEMDATA->row);
      }

      if (!empty($pajakPosting)) {
        foreach ($pajakPosting as $pp) {
          $this->fce->FT_WITHTAXDATA->row['SPLIT_KEY'] = '000001';
          $this->fce->FT_WITHTAXDATA->row['WI_TAX_TYPE'] = $pp['WTAX_TYPE'];
          $this->fce->FT_WITHTAXDATA->row['WI_TAX_CODE'] = '';
          $this->fce->FT_WITHTAXDATA->row['WI_TAX_BASE'] = '';
          if(!empty($pp['AMOUNT'])){
            $this->fce->FT_WITHTAXDATA->row['WI_TAX_CODE'] = $pp['TAX_CODE'];
            $this->fce->FT_WITHTAXDATA->row['WI_TAX_BASE'] = $pp['AMOUNT'];
          }
          $this->fce->FT_WITHTAXDATA->Append($this->fce->FT_WITHTAXDATA->row);
        }
      }

      if (!empty($GLAccount)) {
        $i = 1;
        foreach ($GLAccount as $kodegl => $gl) {
          $this->fce->FT_GLACCOUNTDATA->row['INVOICE_DOC_ITEM'] = $i++;
          $this->fce->FT_GLACCOUNTDATA->row['GL_ACCOUNT'] = $gl['GLACCOUNT'];
          $this->fce->FT_GLACCOUNTDATA->row['ITEM_AMOUNT'] = $gl['AMOUNT'];
          $this->fce->FT_GLACCOUNTDATA->row['DB_CR_IND'] = $gl['DB_CR_IND'];
          $this->fce->FT_GLACCOUNTDATA->row['COMP_CODE'] = $header['COMP_CODE'];
          $this->fce->FT_GLACCOUNTDATA->row['TAX_CODE'] = $gl['TAX_CODE'];
          $this->fce->FT_GLACCOUNTDATA->row['PROFIT_CTR'] = $gl['PROFIT_CTR'];
          $this->fce->FT_GLACCOUNTDATA->Append($this->fce->FT_GLACCOUNTDATA->row);
        }
      }

      if (!empty($taxData)) {
        $i = 1;
        foreach ($taxData as $tax ) {
          $this->fce->FT_TAXDATA->row['TAX_CODE'] = $tax['TAX_CODE'];
          $this->fce->FT_TAXDATA->row['TAX_AMOUNT'] = $tax['TAX_AMOUNT'];
          $this->fce->FT_TAXDATA->row['TAX_BASE_AMOUNT'] = $tax['TAX_BASE_AMOUNT'];
          $this->fce->FT_TAXDATA->Append($this->fce->FT_TAXDATA->row);
        }
      }
      $this->fce->call();

      $ret = array();
      $error = array();
      if ($this->fce->GetStatus() == SAPRFC_OK) {
        $this->fce->FT_RETURN->Reset();
        while ($this->fce->FT_RETURN->Next()) {
          $error[] = $this->fce->FT_RETURN->row;
        }

        if(empty($error)){

          $this->fce->FT_ACCIT->Reset();
          while ($this->fce->FT_ACCIT->Next()) {
            $ret['FT_ACCIT'][] = $this->fce->FT_ACCIT->row;
          }

          $this->fce->FT_GLA_LIST->Reset();
          while ($this->fce->FT_GLA_LIST->Next()) {
            $ret['FT_GLA_LIST'][] = $this->fce->FT_GLA_LIST->row;
          }
        }else{
          $ret['STATUS'] = $error;
        }
      }
      return $ret;
    }

    /*Background Job*/
    public function getALLGR($op,$low,$high,$range_po, $debug = false) {
        $this->openFunction('ZCFI_PO_HISTORY');

        for ($i=0; $i < count($range_po); $i++) {
            $this->fce->R_EBELN->row['SIGN'] = 'I';
            $this->fce->R_EBELN->row['OPTION'] = 'BT';
            $this->fce->R_EBELN->row['LOW'] = $range_po[$i]['START_RANGE'];
            $this->fce->R_EBELN->row['HIGH'] = $range_po[$i]['END_RANGE'];
            $this->fce->R_EBELN->Append($this->fce->R_EBELN->row);
        }

        $this->fce->R_CPUDT->row['SIGN'] = 'I';
        $this->fce->R_CPUDT->row['OPTION'] = $op;
        $this->fce->R_CPUDT->row['LOW'] = $low;
        $this->fce->R_CPUDT->row['HIGH'] = $high;
        $this->fce->R_CPUDT->Append($this->fce->R_CPUDT->row);

        $jenisOP = array(1,2,3,4,5,7,9,'A','C','Q','R','P','V');
        foreach($jenisOP as $p){
            $this->fce->R_VGABE->row['SIGN'] = 'I';
            $this->fce->R_VGABE->row['OPTION'] = 'EQ';
            $this->fce->R_VGABE->row['LOW'] = $p;
            $this->fce->R_VGABE->Append($this->fce->R_VGABE->row);
        }


        $this->fce->call();
        $i = 0;
        $itTampung = array();

        if ($this->fce->GetStatus() == SAPRFC_OK) {
            $this->fce->T_DATA->Reset();
            while ($this->fce->T_DATA->Next()) {
//                print_r($this->fce->T_DATA->row);
                $itTampung[] = $this->fce->T_DATA->row;
            }
        }
//         var_dump($itTampung);
        return $itTampung;
    }

    /* contoh $input = array(
      'EXPORT_PARAM_SINGLE' => array(
        'key' => 'nilainya',
        'key2' => 'nilainya2',
      ),
      'EXPORT_PARAM_ARRAY' => array(
        'key' => array(
          'key2' => 'nilainya2',
          'key3' => 'nilainya3',
        ),
        'key2' => array(
          'key2' => 'nilainya2',
          'key3' => 'nilainya3',
        ),
      ),
      'EXPORT_PARAM_TABLE' => array(
        'key' => array(
          'key2' => array( ==> baris
            'key3' => 'nilainya3',
            'key4' => 'nilainya4',
          ),
        ),
        'key2' => array(
          'key2' => array( ==> baris
            'key3' => 'nilainya3',
            'key4' => 'nilainya4',
          ),
        ),
      ),
    )

    */
    public function callFunction($functionName, $input = array(),$output = array(), $isCommit = 0){
      $result = array();
      $this->openFunction($functionName);
      foreach($input as $tipe => $val){
        switch($tipe){
          case 'EXPORT_PARAM_SINGLE':
            $this->_setParamSingle($val);
            break;
          case 'EXPORT_PARAM_ARRAY':
            $this->_setParamArray($val);
            break;
          case 'EXPORT_PARAM_TABLE':
            $this->_setParamTable($val);
            break;
        }
      }

      $this->fce->call();
      //echo '<pre>';
      //print_r($this->fce);
      foreach($output as $tipe => $val){
        switch($tipe){
          case 'EXPORT_PARAM_SINGLE':
            $_r = $this->_getParamSingle($val);
            $result['EXPORT_PARAM_SINGLE'] = $_r;
            break;
          case 'EXPORT_PARAM_ARRAY':
            $_r = $this->_getParamArray($val);
            $result['EXPORT_PARAM_ARRAY'] = $_r;
            break;
          case 'EXPORT_PARAM_TABLE':
            $_r = $this->_getParamTable($val);
            $result['EXPORT_PARAM_TABLE'] = $_r;
            break;
        }
      }
      if($isCommit){
        $this->openFunction('BAPI_TRANSACTION_COMMIT');
        $this->fce->call();
      }
      return $result;
    }

    private function _setParamSingle($val){
      foreach($val as $_k => $_v){
        $this->fce->$_k = $_v;
      }
    }

    private function _setParamArray($val){
      foreach($val as $_k => $_v){
        $this->fce->$_k = $_v;
      }
    }

    private function _setParamTable($val){
      foreach($val as $k => $v){
        foreach($v as $_k => $_v){
          $this->fce->$k->Append($_v);
        }
      }
    }

    private function _getParamSingle($val){
      $result = array();
      foreach($val as $v){
        if(isset($this->fce->$v)){
          $result[$v] = $this->fce->$v;
        }
      }
      return $result;
    }

    private function _getParamArray($val){
      $result = array();
      foreach($val as $v){
        if(isset($this->fce->$v)){
          $result[$v] = $this->fce->$v;
        }
      }
      return $result;
    }

    private function _getParamTable($val){
      $r = array();
      foreach($val as $v){
        $_tmp = array();
        if(isset($this->fce->$v)){
          $this->fce->$v->Reset();
          while ($this->fce->$v->Next()) {
              array_push($_tmp,$this->fce->$v->row);
          }
          $r[$v] =  $_tmp;
        }
      }

      return $r;
    }
    public function createInvEC($dataINV, $item, $pajakPosting, $GLAccount,$taxData, $debug = false) {
        $this->openFunction('BAPI_INCOMINGINVOICE_PARK');

        $this->fce->HEADERDATA['INVOICE_IND'] = $dataINV['INVOICE_IND']; //"X";
        $this->fce->HEADERDATA['DOC_TYPE'] = $dataINV['DOC_TYPE']; //"RE";
        $this->fce->HEADERDATA['DOC_DATE'] = $dataINV['TGL_INV']; //inputan default tgl inv
        $this->fce->HEADERDATA['PSTNG_DATE'] = $dataINV['TGL_POST']; //inputan default skrg
        $this->fce->HEADERDATA['REF_DOC_NO'] = $dataINV['FAKTUR_PJK']; // $dataINV['']
        $this->fce->HEADERDATA['COMP_CODE'] = $dataINV['COMP_CODE']; //'7000';//sementara harcode
        $this->fce->HEADERDATA['CURRENCY'] = $dataINV['CURR'];
        $this->fce->HEADERDATA['GROSS_AMOUNT'] = $dataINV['TOTAL_AMOUNT'];
        $this->fce->HEADERDATA['CALC_TAX_IND'] = $dataINV['CALC_TAX_IND']; //"X";
        $this->fce->HEADERDATA['PMNTTRMS'] = $dataINV['PMNTTRMS']; //"X";
        $this->fce->HEADERDATA['BLINE_DATE'] = $dataINV['BLINE_DATE']; //"X";
        $this->fce->HEADERDATA['PARTNER_BK'] = $dataINV['PARTNER_BK']; //"X";

        $this->fce->HEADERDATA['HEADER_TXT'] = $dataINV['INV_NO'];
        $this->fce->HEADERDATA['PMNT_BLOCK'] = $dataINV['PMNT_BLOCK']; // 3;//$dataINV['PAYMENT'];//default 3
        $this->fce->HEADERDATA['PYMT_METH'] = $dataINV['PYMT_METH']; //"T";
        //	$this->fce->HEADERDATA['PARTNER_BK']= "IDR1";
        $this->fce->HEADERDATA['ITEM_TEXT'] = $dataINV['NOTE_VERI']; //inputan

        for ($i = 0; $i < count($item); $i++) {
            $this->fce->ITEMDATA->row['INVOICE_DOC_ITEM'] = $i + 1;
            $this->fce->ITEMDATA->row['PO_NUMBER'] = $item[$i]['PO_NO'];
            $this->fce->ITEMDATA->row['PO_ITEM'] = $item[$i]['PO_ITEM_NO'];
            if($dataINV['ITEM_CAT'] == '9'){
                $this->fce->ITEMDATA->row['SHEET_NO'] = $item[$i]['GR_NO'];
                $this->fce->ITEMDATA->row['SHEET_ITEM'] = str_pad($item[$i]['GR_ITEM_NO'] * 10, 10, '0', STR_PAD_LEFT);
                $this->fce->ITEMDATA->row['PO_UNIT'] = !empty($item[$i]['UOM']) ? $item[$i]['UOM'] : 'AU';
                //$this->fce->ITEMDATA->row['PO_UNIT'] = 'EA';
            }else{
                $this->fce->ITEMDATA->row['REF_DOC'] = $item[$i]['GR_NO'];
                $this->fce->ITEMDATA->row['REF_DOC_YEAR'] = empty($item[$i]['GR_YEAR']) ? date('Y') : $item[$i]['GR_YEAR'];
                $this->fce->ITEMDATA->row['REF_DOC_IT'] = str_pad($item[$i]['GR_ITEM_NO'], 4, '0', STR_PAD_LEFT);
                $this->fce->ITEMDATA->row['PO_UNIT'] = !empty($item[$i]['UOM']) ? $item[$i]['UOM'] : 'TO';
            }

            $this->fce->ITEMDATA->row['TAX_CODE'] = $item[$i]['TAX_CODE']; //$dataINV['TAX_CODE']; //'VZ';
            $this->fce->ITEMDATA->row['ITEM_AMOUNT'] = $item[$i]['GR_AMOUNT_IN_DOC'];
            $this->fce->ITEMDATA->row['QUANTITY'] = $item[$i]['GR_ITEM_QTY'];

            $this->fce->ITEMDATA->Append($this->fce->ITEMDATA->row);
        }
        if (!empty($pajakPosting)) {
            foreach ($pajakPosting as $pp) {
                $this->fce->WITHTAXDATA->row['WI_TAX_CODE'] = $pp['TAX_CODE'];
                $this->fce->WITHTAXDATA->row['WI_TAX_TYPE'] = $pp['WTAX_TYPE'];
                $this->fce->WITHTAXDATA->row['WI_TAX_BASE'] = $pp['AMOUNT'];
                $this->fce->WITHTAXDATA->Append($this->fce->WITHTAXDATA->row);
            }
        }

        if (!empty($GLAccount)) {
            $i = 1;
            foreach ($GLAccount as $kodegl => $gl) {
                $this->fce->GLACCOUNTDATA->row['INVOICE_DOC_ITEM'] = $i++;
                $this->fce->GLACCOUNTDATA->row['GL_ACCOUNT'] = $gl['GLACCOUNT'];
                $this->fce->GLACCOUNTDATA->row['ITEM_AMOUNT'] = $gl['AMOUNT'];
                $this->fce->GLACCOUNTDATA->row['DB_CR_IND'] = $gl['DB_CR_IND'];
                $this->fce->GLACCOUNTDATA->row['COMP_CODE'] = $dataINV['COMP_CODE'];
                  $this->fce->GLACCOUNTDATA->row['TAX_CODE'] = $gl['TAX_CODE'];
                $this->fce->GLACCOUNTDATA->row['PROFIT_CTR'] = $gl['PROFIT_CTR'];
                $this->fce->GLACCOUNTDATA->row['ITEM_TEXT'] = $gl['ITEM_TEXT'];
                $this->fce->GLACCOUNTDATA->Append($this->fce->GLACCOUNTDATA->row);
            }
        }

        if (!empty($taxData)) {
            $i = 1;
            foreach ($taxData as $tax ) {
                $this->fce->TAXDATA->row['TAX_CODE'] = $tax['TAX_CODE'];
                $this->fce->TAXDATA->row['TAX_AMOUNT'] = $tax['TAX_AMOUNT'];
                $this->fce->TAXDATA->row['TAX_BASE_AMOUNT'] = $tax['TAX_BASE_AMOUNT'];
                $this->fce->TAXDATA->Append($this->fce->TAXDATA->row);
            }
        }

        $this->fce->call();

        if ($debug) {
            header('Content-Type: application/json');
            var_dump($this->fce->HEADERDATA);
            //var_dump($this->fce->ITEMDATA);
            var_dump($this->fce->GLACCOUNTDATA);
            //var_dump($this->fce->WITHTAXDATA);
            $this->fce->RETURN->Reset();
            while ($this->fce->ITEMDATA->Next()) {
                var_dump($this->fce->ITEMDATA->row);
            }
            $this->fce->RETURN->Reset();
            while ($this->fce->RETURN->Next()) {
                var_dump($this->fce->RETURN->row);
            }

            $this->fce->TAXDATA->Reset();
            while ($this->fce->TAXDATA->Next()) {
                var_dump($this->fce->TAXDATA->row);
            }
        }

        $invoicenumber = $this->fce->INVOICEDOCNUMBER;
        $fiscalyear = $this->fce->FISCALYEAR;

        $error = array();
        $this->fce->RETURN->Reset();
        while($this->fce->RETURN->next()){
            array_push($error,$this->fce->RETURN->row);
        }
        $this->openFunction('BAPI_TRANSACTION_COMMIT');
        $this->fce->call();
        if(!empty($invoicenumber)){
            return array(
                'data' => array('invoicenumber' => $invoicenumber, 'fiscalyear' => $fiscalyear),
                'status' => 1,
            );
        } else {
            return array(
                'data' => $error,
                'status' => 0,
            );
        }
    }

    public function changeParkInvoice($dataINV,$item,$GLAccount,$pajakPosting,$taxData, $debug){
        $this->openFunction('BAPI_INCOMINGINVOICE_CHANGE');
        $this->fce->INVOICEDOCNUMBER = $dataINV['INVOICE_SAP'];
        $this->fce->FISCALYEAR = $dataINV['FISCALYEAR_SAP'];
        $this->fce->TABLE_CHANGE['WITHTAXDATA'] = 'X';
        $this->fce->TABLE_CHANGE['ITEMDATA'] = 'X';
        $this->fce->TABLE_CHANGE['GLACCOUNTDATA'] = 'X';

        if(!empty($taxData)){
            // $this->fce->TABLE_CHANGE['TAXDATA'] = 'X';
        }
        $this->fce->HEADERDATA_CHANGE['PSTNG_DATE'] = $dataINV['TGL_POST'];
        $this->fce->HEADERDATA_CHANGE['PMNT_BLOCK'] = $dataINV['PMNT_BLOCK'];
        $this->fce->HEADERDATA_CHANGE['GROSS_AMOUNT'] = $dataINV['TOTAL_AMOUNT'];
        $this->fce->HEADERDATA_CHANGE['CALC_TAX_IND'] = $dataINV['CALC_TAX_IND'];

        $this->fce->HEADERDATA_CHANGEX['PSTNG_DATE'] = 'X';
        $this->fce->HEADERDATA_CHANGEX['PMNT_BLOCK'] = 'X';
        $this->fce->HEADERDATA_CHANGEX['GROSS_AMOUNT'] = 'X';
        $this->fce->HEADERDATA_CHANGEX['CALC_TAX_IND'] = 'X';

        for ($i = 0; $i < count($item); $i++) {
            $this->fce->ITEMDATA->row['INVOICE_DOC_ITEM'] = $item[$i]['INVOICE_DOC_ITEM'];
            $this->fce->ITEMDATA->row['PO_NUMBER'] = $item[$i]['PO_NUMBER'];
            $this->fce->ITEMDATA->row['PO_ITEM'] = $item[$i]['PO_ITEM'];

            $this->fce->ITEMDATA->row['SHEET_NO'] = $item[$i]['SHEET_NO'];
            $this->fce->ITEMDATA->row['SHEET_ITEM'] = $item[$i]['SHEET_ITEM'];
            $this->fce->ITEMDATA->row['PO_UNIT'] = $item[$i]['PO_UNIT'];

            $this->fce->ITEMDATA->row['REF_DOC'] = $item[$i]['REF_DOC'];
            $this->fce->ITEMDATA->row['REF_DOC_YEAR'] = $item[$i]['REF_DOC_YEAR'];
            $this->fce->ITEMDATA->row['REF_DOC_IT'] = $item[$i]['REF_DOC_IT'];

            $this->fce->ITEMDATA->row['TAX_CODE'] = $item[$i]['TAX_CODE']; //$dataINV['TAX_CODE']; //'VZ';
            $this->fce->ITEMDATA->row['ITEM_AMOUNT'] = $item[$i]['ITEM_AMOUNT'];
            $this->fce->ITEMDATA->row['QUANTITY'] = $item[$i]['QUANTITY'];

            $this->fce->ITEMDATA->Append($this->fce->ITEMDATA->row);
        }

        if (!empty($pajakPosting)) {
            foreach ($pajakPosting as $pp) {
              $this->fce->WITHTAXDATA->row['SPLIT_KEY'] = '000001';
              $this->fce->WITHTAXDATA->row['WI_TAX_TYPE'] = $pp['WTAX_TYPE'];
              $this->fce->WITHTAXDATA->row['WI_TAX_CODE'] = '';
              $this->fce->WITHTAXDATA->row['WI_TAX_BASE'] = '';
              if(!empty($pp['AMOUNT'])){
                $this->fce->WITHTAXDATA->row['WI_TAX_CODE'] = $pp['TAX_CODE'];
                $this->fce->WITHTAXDATA->row['WI_TAX_BASE'] = $pp['AMOUNT'];
              }
              $this->fce->WITHTAXDATA->Append($this->fce->WITHTAXDATA->row);
            }
        }


        if (!empty($GLAccount)) {
            $i = 1;
            foreach ($GLAccount as $kodegl => $gl) {
                $this->fce->GLACCOUNTDATA->row['INVOICE_DOC_ITEM'] = $i++;
                $this->fce->GLACCOUNTDATA->row['GL_ACCOUNT'] = $gl['GLACCOUNT'];
                $this->fce->GLACCOUNTDATA->row['ITEM_AMOUNT'] = $gl['AMOUNT'];
                $this->fce->GLACCOUNTDATA->row['DB_CR_IND'] = $gl['DB_CR_IND'];
                $this->fce->GLACCOUNTDATA->row['COMP_CODE'] = $dataINV['COMP_CODE'];
                $this->fce->GLACCOUNTDATA->row['PROFIT_CTR'] = $gl['PROFIT_CTR'];
                $this->fce->GLACCOUNTDATA->row['ITEM_TEXT'] = $gl['ITEM_TEXT'];
                $this->fce->GLACCOUNTDATA->row['TAX_CODE'] = $gl['TAX_CODE'];
                $this->fce->GLACCOUNTDATA->row['COSTCENTER'] = $gl['COSTCENTER'];
                $this->fce->GLACCOUNTDATA->Append($this->fce->GLACCOUNTDATA->row);
            }
        }

        if (!empty($taxData)) {
            $i = 1;
            foreach ($taxData as $tax ) {
                $this->fce->TAXDATA->row['TAX_CODE'] = $tax['TAX_CODE'];
                $this->fce->TAXDATA->row['TAX_AMOUNT'] = $tax['TAX_AMOUNT'];
                $this->fce->TAXDATA->row['TAX_BASE_AMOUNT'] = $tax['TAX_BASE_AMOUNT'];
                $this->fce->TAXDATA->Append($this->fce->TAXDATA->row);
            }
        }

        $this->fce->call();
        if ($debug) {
            header('Content-Type: application/json');
            echo 'headerdata_change';
            var_dump($this->fce->HEADERDATA_CHANGE);
            echo 'table_change';
            var_dump($this->fce->TABLE_CHANGE);
            var_dump($this->fce->GLACCOUNTDATA);
            var_dump($this->fce->HEADERDATA_CHANGEX);
            // var_dump($this->fce->WITHTAXDATA);
            $this->fce->WITHTAXDATA->Reset();
            while ($this->fce->WITHTAXDATA->Next()) {
                var_dump($this->fce->WITHTAXDATA->row);
            }
            $this->fce->RETURN->Reset();
            while ($this->fce->ITEMDATA->Next()) {
                var_dump($this->fce->ITEMDATA->row);
            }
            $this->fce->RETURN->Reset();
            while ($this->fce->RETURN->Next()) {
                var_dump($this->fce->RETURN->row);
            }

            $this->fce->TAXDATA->Reset();
            while ($this->fce->TAXDATA->Next()) {
                var_dump($this->fce->TAXDATA->row);
            }

        }
        $error = array();
        $this->fce->RETURN->Reset();
        $gagal = 0;
        while($this->fce->RETURN->next()){
            array_push($error,$this->fce->RETURN->row);
            if($this->fce->RETURN->row['TYPE'] == 'E'){
              $gagal++;
            }
        }
        $this->openFunction('BAPI_TRANSACTION_COMMIT');
        $this->fce->call();

        $pesan = '';
        if(!$gagal){
          $noinvoice = $dataINV['INVOICE_SAP'];
          $tahun = $dataINV['FISCALYEAR_SAP'];
            return array(
                'data' => 'Nomer mir '.$noinvoice.' tahun '.$tahun.' changed',
                'status' => 1,
            );
        }else{
            return array(
                'data' => $error,
                'status' => 0,
            );
        }

    }

    public function postingInvoice($noinvoice,$tahun){
      /* posting data sekarang */
      $this->openFunction('BAPI_INCOMINGINVOICE_POST');
      $this->fce->INVOICEDOCNUMBER = $noinvoice;
      $this->fce->FISCALYEAR = $tahun;
      $this->fce->call();
      $error = array();
      $gagal = 0;
      $this->fce->RETURN->Reset();
      while($this->fce->RETURN->next()){
          array_push($error,$this->fce->RETURN->row);
          if($this->fce->RETURN->row['TYPE'] == 'E'){
            $gagal++;
          }
      }

      $this->openFunction('BAPI_TRANSACTION_COMMIT');
      $this->fce->call();
      if(!$gagal){
          $pesan = 'Nomer mir '.$noinvoice.' tahun '.$tahun.' posted';
          return array(
              'data' => $pesan,
              'status' => 1,
          );
      }else{
          return array(
              'data' => $error,
              'status' => 0,
          );
      }
    }

    public function kirimterimaDokumenEkspedisi($header,$item){
      $this->openFunction('ZCFI_DOC_EXPEDITION_2');
      $this->fce->P_EXPDS_TYPE =  1;
      $this->fce->T_EXPDS_HEADER->row['BUKRS'] = $header['company'];
      $this->fce->T_EXPDS_HEADER->row['GJAHR'] = date('Y');
      $this->fce->T_EXPDS_HEADER->row['STATUS'] = 2;
      $this->fce->T_EXPDS_HEADER->row['CPUDT'] = date('Ymd');
      $this->fce->T_EXPDS_HEADER->row['USNAM'] = $header['vendor'];
      $this->fce->T_EXPDS_HEADER->Append($this->fce->T_EXPDS_HEADER->row);

      foreach($item as $_t){
        $this->fce->T_EXPDS_ITEM->row['BUKRS'] = $header['company'];
        $this->fce->T_EXPDS_ITEM->row['GJAHR'] = date('Y');
        $this->fce->T_EXPDS_ITEM->row['BELNR'] = $_t['invoice'];
        $this->fce->T_EXPDS_ITEM->row['CPUDT'] = date('Ymd');
        $this->fce->T_EXPDS_ITEM->row['BUDAT'] = $header['posting_date']; // posting date
        $this->fce->T_EXPDS_ITEM->row['BLDAT'] = $header['invoice_date']; // invoice date
        $this->fce->T_EXPDS_ITEM->row['WAERS'] = $_t['currency'];
        $this->fce->T_EXPDS_ITEM->row['USNAM'] = $header['vendor'];
        $this->fce->T_EXPDS_ITEM->row['WRBTR'] = $_t['amount'];
        $this->fce->T_EXPDS_ITEM->row['ZLSPR'] = $_t['payment_block'];
        $this->fce->T_EXPDS_ITEM->row['DMBTR'] = $_t['amount'];
        $this->fce->T_EXPDS_ITEM->row['EBELN'] = $_t['po'];
        $this->fce->T_EXPDS_ITEM->row['EBELP'] = $_t['item_po'];
        $this->fce->T_EXPDS_ITEM->row['TGL_VER'] = date('Ymd');
        $this->fce->T_EXPDS_ITEM->row['USER_VER'] = substr($header['username'],0,10);
        $this->fce->T_EXPDS_ITEM->Append($this->fce->T_EXPDS_ITEM->row);
      }

      $this->fce->call();
      $itTampung = array();
      if ($this->fce->GetStatus() == SAPRFC_OK) {
        $this->fce->T_RETURN->Reset();
        while ($this->fce->T_RETURN->Next()) {
          //  print_r($this->fce->T_DATA->row);
            $itTampung[] = $this->fce->T_RETURN->row;
        }

      }
      $this->openFunction('BAPI_TRANSACTION_COMMIT');
      $this->fce->call();
      return $itTampung;
    }

    public function getDetailVendor($noVendor) {
        $this->openFunction('Z_ZCMM_VENDOR_DETAIL');
        $this->fce->FI_VENDOR_NO = $noVendor;
        $this->fce->call();
        $i = 0;
        $itTampung = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
            $this->fce->FT_VENDOR->Reset();
            while ($this->fce->FT_VENDOR->Next()) {
              //  print_r($this->fce->T_DATA->row);
                $itTampung[] = $this->fce->FT_VENDOR->row;
            }
        }
        return $itTampung;
    }

    public function getDataLandedCost($company,$data){
      $this->openFunction('ZCMM_DELIVERY_COST_ANL');

      $this->fce->P_BUKRS = $company;

      foreach ($variable as $value) {
        $this->fce->R_EBELN->row['SIGN'] = 'I';
        $this->fce->R_EBELN->row['OPTION'] = 'EQ';
        $this->fce->R_EBELN->row['LOW'] = $value['EBELN'];
        $this->fce->R_EBELN->Append($this->fce->R_EBELN->row);
      }

      $this->fce->R_CPUDT->row['SIGN'] = 'I';
      $this->fce->R_CPUDT->row['OPTION'] = 'EQ';
      $this->fce->R_CPUDT->row['LOW'] = $data[0]['CPUDT'];
      $this->fce->R_CPUDT->Append($this->fce->R_CPUDT->row);

      //var_dump($this->fce->P_BUKRS);die();

      $this->fce->call();
        $i = 0;
        $itTampung = array();

        if ($this->fce->GetStatus() == SAPRFC_OK) {
            $this->fce->T_DATA->Reset();
            while ($this->fce->T_DATA->Next()) {
        //        print_r($this->fce->T_DATA->row);
                $itTampung[] = $this->fce->T_DATA->row;
            }
        }
        // var_dump($itTampung);
        return $itTampung;

    }

    public function getDataPomut($tglUD,$period,$company) {
        $this->openFunction('ZCQM_ANALISA_MUTU');

        $this->fce->P_BUKRS = $company;//'7000';//
        $this->fce->T_OTHER = 'X';
        $this->fce->T_ALL = 'X';

        $this->fce->R_PERIOD->row['SIGN'] = 'I';
        $this->fce->R_PERIOD->row['OPTION'] = 'EQ';
        $this->fce->R_PERIOD->row['LOW'] = $period; //'201710';//YYYYMM
        $this->fce->R_PERIOD->Append($this->fce->R_PERIOD->row);

        $this->fce->R_TGL_UD->row['SIGN'] = 'I';
        $this->fce->R_TGL_UD->row['OPTION'] = 'EQ';
        $this->fce->R_TGL_UD->row['LOW'] = $tglUD;//'20171011';//
        $this->fce->R_TGL_UD->Append($this->fce->R_TGL_UD->row);

        $this->fce->call();

        $i = 0;
        $itTampung = array();
        if ($this->fce->GetStatus() == SAPRFC_OK) {
            $this->fce->T_DATA_HEADER_1->Reset();
            while ($this->fce->T_DATA_HEADER_1->Next()) {
                $itTampung['HEADER1'][] = $this->fce->T_DATA_HEADER_1->row;
            }
            $this->fce->T_DATA_HEADER_2->Reset();
            while ($this->fce->T_DATA_HEADER_2->Next()) {
                $itTampung['HEADER2'][] = $this->fce->T_DATA_HEADER_2->row;
            }
            $this->fce->T_DATA_DETAIL_2->Reset();
            while ($this->fce->T_DATA_DETAIL_2->Next()) {
                $itTampung['DETAIL'][] = $this->fce->T_DATA_DETAIL_2->row;
            }
            $this->fce->T_FORMULA_1->Reset();
            while ($this->fce->T_FORMULA_1->Next()) {
                $itTampung['FORMULA'][] = $this->fce->T_FORMULA_1->row;
            }
        }
        return $itTampung;
    }
    
    public function setEkspedisiFaktur($input_param,$input){
      $this->openFunction('Z_ZCFI3049_EKSP_FP');              
      $this->fce->I_BUKRS = $input_param['BUKRS'];
      $this->fce->I_LIFNR = $input_param['LIFNR'];
      $this->fce->I_EMAIL = $input_param['EMAIL']; 
      $this->fce->I_PERSON = $input_param['PERSON']; 
      foreach($input as $ip){
        $this->fce->T_INPUT->row['XBLNR'] = $ip['XBLNR'];
        $this->fce->T_INPUT->row['BLDAT'] = $ip['BLDAT'];   
        $this->fce->T_INPUT->row['BEDAT'] = $ip['BEDAT'];
        $this->fce->T_INPUT->row['HWBAS'] = $ip['HWBAS'];
        $this->fce->T_INPUT->row['EBELN'] = $ip['EBELN'];
        $this->fce->T_INPUT->Append($this->fce->T_INPUT->row);
      }      
      $this->fce->call();      
      $itTampung = array();       
      if ($this->fce->GetStatus() == SAPRFC_OK) {        
        $itTampung['pesan']=$this->fce->E_MESSAGE;
        $itTampung['noeks']=$this->fce->E_EKSPNO;
        $this->fce->T_OUTPUT->Reset();
        while ($this->fce->T_OUTPUT->Next()) {
//            print_r($this->fce->T_OUTPUT->row);
            $itTampung['output'][] = $this->fce->T_OUTPUT->row;
        }                
      }
      return $itTampung;
    }
    
    public function setPrintBA($no_ba){
      $this->openFunction('z_zcqm_set_print_ba');              
      $this->fce->ZSET = 'X';         
      $this->fce->Z_DATA->row['NO_BA'] = $no_ba;
      $this->fce->Z_DATA->row['ZPRINT'] = 'X';           
      $this->fce->Z_DATA->Append($this->fce->Z_DATA->row);
      $this->fce->call();      
      $itTampung = array();       
      if ($this->fce->GetStatus() == SAPRFC_OK) {                
        $itTampung['pesan']=$this->fce->RETURN['TYPE'];        
      }
      return $itTampung;
    }
}
