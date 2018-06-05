<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Invoice_ver extends MX_Controller {
    private $user;
    private $user_email;
    private $roles_user;
    private $current_roles;
    public function __construct() {
        parent::__construct();
        //error_reporting(0);
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->user_email = $this->session->userdata('EMAIL'); // login pakai email tanpa semen indonesia.com
        $this->user = $this->session->userdata('FULLNAME');
        /* dapatkan role untuk fitur verifikasi ini */
        $this->roles_user = $this->getRoleVerifikasi();
        $this->load->model('invoice/ec_role_user', 'role_user');
        $email_login = explode('@', $this->user_email);
        $this->current_roles = array();
        $_tmp = $this->role_user->get_all(array('USERNAME' => $email_login[0], 'STATUS' => 1));
        if(!empty($_tmp)){
          foreach($_tmp as $_t){
              array_push($this->current_roles,$_t->ROLE_AS);
          }
        }
    }

    public function index($kode = '-') {
        $data['title'] = "Invoice Verification";
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_css('pages/EC_bootstrap-slider.min.css');
        $this->layout->add_js('pages/EC_bootstrap-slider.min.js');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_invoice_head.js');
        $this->layout->add_css('pages/EC_style_ecatalog.css');
        $this->layout->render('list', $data);
    }

    public function getRoleVerifikasi(){
        $this->load->model('invoice/ec_role','er');
        $roles = $this->er->get_all('where ROLE_AS like \'VERIFIKASI%\'');
        $tmp = array();
        foreach($roles as $r){
            array_push($tmp,$r->ROLE_AS);
        }
        return $tmp;
    }

    /* Create invoice di SAP */
    public function approve($idinovice, $dataPosting, $pajakPosting,$taxData,$debug = false) {
        // $this->load->library('sap_handler');
        $this->load->library('sap_invoice');
        $this->load->model('ec_invoice_m', 'inc');
        $this->load->model('invoice/ec_gr','gr');
        $this->load->model('invoice/ec_gr_sap','gr_sap');
        $this->load->model('ec_open_inv');
        $this->load->model('invoice/ec_m_denda_inv','mdenda');
        $this->load->model('invoice/ec_t_denda_inv','tdenda');
        //	$noinvoice = $this -> input -> post("desc");
        /* cari denda yang memiliki glaccount */
        $mDendaGl = $this->db->where('STATUS = 1 and DIRECT_ACTION = 0 and GL_ACCOUNT is not null')->get('EC_M_DENDA_INV')->result();

        $_tmpDendaGl = array();
        if(!empty($mDendaGl)){
            foreach($mDendaGl as $_md){
                $_tmpDendaGl[$_md->ID_JENIS] = $_md->GL_ACCOUNT;
            }
        }

        $profit_ctr = '';

        $dendaGL = 0;

        $GLAccount = array();
        /* tambahkan glaccount khusus */
        $glaccountTambahan = $this->input->post('noglaccount');
        $glaccountPajak = $this->input->post('pajakGL');
        $glaccountNominal = $this->input->post('nilai_glaccount');
        $glaccountDebetKredit = $this->input->post('fileGL');
        $glaccountCostCenter = $this->input->post('costcenter');
        $glaccountProfitCenter = $this->input->post('profit_ctr');
        $glaccountText = $this->input->post('textline');
        if(!empty($glaccountTambahan)){
          foreach($glaccountTambahan as $i => $glt){
              $_profitcenterSAP = !empty($glaccountProfitCenter[$i]) && $glaccountProfitCenter[$i] != 'DUMMY' ? str_pad($glaccountProfitCenter[$i],10,0,STR_PAD_LEFT) : $glaccountProfitCenter[$i];
              $GLAccount[] = array('AMOUNT' => $glaccountNominal[$i],'PROFIT_CTR' => $_profitcenterSAP,'COSTCENTER' => $glaccountCostCenter[$i],'GLACCOUNT' => $glt,'DB_CR_IND' => $glaccountDebetKredit[$i],'TAX_CODE' => $glaccountPajak[$i],'ITEM_TEXT' => $glaccountText[$i]);
          }
        }
        /* tinggal parsing GLAccountnya */
        $result = $this->inc->getINV($idinovice);
        $tmp = new DateTime($result[0]['INVOICE_DATE']);
        $result[0]['INVOICE_DATE'] = $tmp->format('Ymd');
        $dataINV = array("TGL_INV" => $result[0]['INVOICE_DATE'], "BLINE_DATE" => $dataPosting['baseline_date'], "HEADER_TXT" => $result[0]['NO_INVOICE'], "FAKTUR_PJK" => clean($result[0]['FAKTUR_PJK']), "CURR" => $result[0]['CURRENCY'], "TOTAL_AMOUNT" => ($result[0]['TOTAL_AMOUNT'] + $dendaGL), "INV_NO" => $result[0]['NO_INVOICE'], "NOTE_VERI" => $result[0]['NOTE'], "TAX_CODE" => $result[0]['PAJAK'], 'ITEM_CAT' => $result[0]['ITEM_CAT'], 'PARTNER_BK' => $result[0]['PARTNER_BANK']);

        $dataINV['INVOICE_IND'] = "X";
        $dataINV['DOC_TYPE'] = "RE";
        $dataINV['TGL_POST'] = $dataPosting['posting_date'];
        $dataINV['COMP_CODE'] = $result[0]['COMPANY_CODE'];
        $CALC_TAX = $this->input->post('calc_tax');
        $CALC_TAX = empty($CALC_TAX) ? '' : 'X';
        $dataINV['CALC_TAX_IND'] = $CALC_TAX;
        $dataINV['PMNTTRMS'] = 'ZG45';
        $dataINV['PMNT_BLOCK'] = 3 ; //$dataPosting['payment_block']; //3;
        $dataINV['PYMT_METH'] = $dataPosting['payment_method']; // 'T';

        $dataa = $this->gr->as_array()->get_all(array('INV_NO' => $idinovice));
     //   $this->load->model('invoice/ec_m_po_detail','pod');

        $pajakGr = $this->input->post('pajak_gr');
        $amountSAP = $this->input->post('amountSAP');

        foreach ($dataa as $value) {
           $grKeyItem = $value['GR_NO'].'-'.$value['GR_ITEM_NO'];
           $_refDoc = $value['GR_NO'].'-'.$value['GR_ITEM_NO'];
           $jmlAmountSAP = str_replace('.', '', $amountSAP[$grKeyItem]);
           $dataGR[] = array("PO_NO" => $value['PO_NO'], "PO_ITEM_NO" => $value['PO_ITEM_NO'], "GR_NO" => $value['GR_NO'], "GR_YEAR" => $value['GR_YEAR'], "GR_ITEM_NO" => $value['GR_ITEM_NO'], "GR_AMOUNT_IN_DOC" => $jmlAmountSAP, "GR_ITEM_QTY" => $value['GR_ITEM_QTY'], "UOM" => $value['GR_ITEM_UNIT'], "TAX_CODE" => $pajakGr[$grKeyItem]);
        }

        return $this->sap_invoice->createInvEC($dataINV, $dataGR,$pajakPosting,$GLAccount,$taxData, $debug);
    }

    public function changePosting($idinovice, $dataPosting, $pajakPosting, $debug = false) {
        $this->load->library('sap_invoice');
        $this->load->model('ec_invoice_m', 'inc');

        /* tinggal parsing GLAccountnya */
        $result = $this->inc->getINV($idinovice);

        $this->load->model('invoice/ec_gr_sap','gr_sap');
        $this->load->model('invoice/ec_m_denda_inv','mdenda');
        $this->load->model('invoice/ec_t_denda_inv','tdenda');

        $GLAccount = array();
        /* tambahkan glaccount khusus */
        $glaccountTambahan = $this->input->post('noglaccount');
        $glaccountPajak = $this->input->post('pajakGL');
        $glaccountNominal = $this->input->post('nilai_glaccount');
        $glaccountDebetKredit = $this->input->post('fileGL');
        $glaccountCostCenter = $this->input->post('costcenter');
        $glaccountProfitCenter = $this->input->post('profit_ctr');
        $glaccountText = $this->input->post('textline');
        if(!empty($glaccountTambahan)){
          foreach($glaccountTambahan as $i => $glt){
              $_profitcenterSAP = !empty($glaccountProfitCenter[$i]) && $glaccountProfitCenter[$i] != 'DUMMY' ? str_pad($glaccountProfitCenter[$i],10,0,STR_PAD_LEFT) : $glaccountProfitCenter[$i];
              $GLAccount[] = array('AMOUNT' => $glaccountNominal[$i],'PROFIT_CTR' => $_profitcenterSAP,'COSTCENTER' => $glaccountCostCenter[$i],'GLACCOUNT' => $glt,'DB_CR_IND' => $glaccountDebetKredit[$i],'TAX_CODE' => $glaccountPajak[$i],'ITEM_TEXT' => $glaccountText[$i]);
          }
        }

        $CALC_TAX = $this->input->post('calc_tax');
        $CALC_TAX = !empty($CALC_TAX) ? 1 : 0;

        /* jika bernilai 0 maka harus isi tax amount secara manual */
        $taxData = array();
        if(!$CALC_TAX){
          $taxBaseAmountSAP = $this->input->post('taxBaseAmountSAP');
          $taxAmountSAP = $this->input->post('taxAmountSAP');
          $pajak_grSAP = $this->input->post('pajak_gr');
          foreach($taxBaseAmountSAP as $i => $_tax){
            $_taxAmount = str_replace('.','',$taxAmountSAP[$i]);
            $_taxBaseAmount = str_replace('.','',$_tax);
            $tmp = array('TAX_CODE' => $pajak_grSAP[$i],'TAX_AMOUNT' => $_taxAmount, 'TAX_BASE_AMOUNT' => $_taxBaseAmount);
            array_push($taxData,$tmp);
          }
        }

        $dataINV = array('ITEM_CAT' => $result[0]['ITEM_CAT'],'INVOICE_SAP' => $result[0]['INVOICE_SAP'],'FISCALYEAR_SAP' => $result[0]['FISCALYEAR_SAP'], 'TOTAL_AMOUNT' => $result[0]['TOTAL_AMOUNT']);
        $dataINV['TGL_POST'] = $dataPosting['posting_date'];
        $dataINV['PMNT_BLOCK'] = '#'; //$dataPosting['payment_block']; //3;
        $dataINV['PYMT_METH'] = $dataPosting['payment_method']; // 'T';
        $dataINV['COMP_CODE'] = $result[0]['COMPANY_CODE'];
        $dataINV['CALC_TAX_IND'] = $CALC_TAX ? 'X' : '';

        /* update item data */
        $pajakGr = $this->input->post('pajak_gr');
        $amountSAP = $this->input->post('amountSAP');
        $invoicedocnumber = $result[0]['INVOICE_SAP'];
        $fiscalyear = $result[0]['FISCALYEAR_SAP'];

        $_detailInvoiceSAP = $this->getDetailInvoice(array('INVOICEDOCNUMBER' => $invoicedocnumber, 'FISCALYEAR' => $fiscalyear));

        $dataGR = array();
        foreach ($_detailInvoiceSAP['ITEMDATA'] as $value) {
            $_refDoc = !empty($value['REF_DOC']) ? $value['REF_DOC'] : $value['SHEET_NO'];
            $grKeyItem = $value['KEY_ITEM'];
            $value["TAX_CODE"] = $pajakGr[$grKeyItem];
            $jmlAmountSAP = str_replace('.', '', $amountSAP[$grKeyItem]);
            $value["ITEM_AMOUNT"] = !empty($jmlAmountSAP) ? $jmlAmountSAP : $value["ITEM_AMOUNT"];
            array_push($dataGR,$value);
            // $dataGR[] = array("PO_NO" => $value['PO_NO'], "PO_ITEM_NO" => $value['PO_ITEM_NO'], "GR_NO" => $value['GR_NO'], "GR_YEAR" => $value['GR_YEAR'], "GR_ITEM_NO" => $value['GR_ITEM_NO'], "GR_AMOUNT_IN_DOC" => $value['GR_AMOUNT_IN_DOC'], "GR_ITEM_QTY" => $value['GR_ITEM_QTY'], "UOM" => $value['GR_ITEM_UNIT'], );
        }
      //  echo '<pre>';
      //  print_r($pajakPosting);die();
        // $debug = TRUE;

        $result = $this->sap_invoice->changeParkInvoice($dataINV,$dataGR,$GLAccount, $pajakPosting, $taxData, $debug);
        return $result;
    }

    public function postingInvoiceSAP($id_invoice){
        $this->load->library('sap_invoice');
        $this->load->model('ec_invoice_m', 'em');
        $this->load->model('invoice/ec_tracking_invoice', 'et');
        $this->load->model('invoice/ec_invoice_header', 'eih');

        $dataInvoice = $this->eih->as_array()->get(array('ID_INVOICE' => $id_invoice));
        $invoicesap = $dataInvoice['INVOICE_SAP'];
        $tahunfiscal = $dataInvoice['FISCALYEAR_SAP'];



        $data_tracking = array(
            'ID_INVOICE' => $id_invoice,
            'DESC' => 'EDIT',
            'STATUS_DOC' => 'BELUM KIRIM',
            'POSISI' => 'VERIFIKASI',
            'USER' => $this->user,
            'STATUS_TRACK' => 5
        );

        $invoiceSAP = $this->sap_invoice->postingInvoice($invoicesap,$tahunfiscal);
        //$this->insertApprovalInvoice($dataInvoice);
        if($invoiceSAP['status']){
          $this->et->insert($data_tracking);
          $this->em->updateInvoice($id_invoice,array('STATUS_HEADER' => 5));
          $pesan = !empty($invoiceSAP['data']) ? $invoiceSAP['data'] : 'Posting sukses ' ;
          $this->session->set_flashdata('message',$pesan);

          /* Kirim notifikasi sudah posting */
          $this->notifikasiPosting($id_invoice);

          $this->insertApprovalInvoice($dataInvoice);

          redirect(site_url('EC_Invoice_ver/'));
        }else{
          $pesan = $this->buildMessageErrorSAP($invoiceSAP);
          $this->session->set_flashdata('message', 'Error <hr />'.implode('<hr />',$pesan));
          redirect(site_url('EC_Invoice_ver/detail/'.$id_invoice));
        }
    }

    public function insertApprovalInvoice($dataInvoice){
          $this->load->model('invoice/ec_approval_invoice', 'api');

          $fi_no = $dataInvoice['FI_NUMBER_SAP'];
          $fi_year = $dataInvoice['FI_YEAR'];
          $company = $dataInvoice['COMPANY_CODE'];
          $id_invoice = $dataInvoice['ID_INVOICE'];

          $amountVendor = $this->getAmountVendor($company,$fi_no,$fi_year);
          $maxLoop = 1000;
          $tmpLoop = 0;
          while(empty($amountVendor) && ($tmpLoop < $maxLoop)){
            $amountVendor = $this->getAmountVendor($company,$fi_no,$fi_year);
            $tmpLoop++;
          }

          $data_approval = array(
                'ID_INVOICE' => $id_invoice,
                'TOTAL_PAYMENT' => strtoupper($amountVendor['WAERS']) == 'IDR' ?  $amountVendor['WRBTR']*100 : $amountVendor['WRBTR'],
                'STATUS' => 0
            );

          $dis_company = array(2000);
          $dis_category = array(0,2,5);

          /*ketika Data Dari SI Maka Secara Otomatis Langsung dianggap Approve*/
          if(in_array($dataInvoice['COMPANY_CODE'], $dis_company)){
            $data_approval['STATUS'] = 3;
          }

          /*
            ITEM_CAT BARANG = 0,2,5
            ITEM_CAT JASA = 3,9
          */
          if(in_array($dataInvoice['ITEM_CAT'], $dis_category)){
            $data_approval['STATUS'] = 3;
          }


          $data = $this->api->as_array()->get_all(array('ID_INVOICE' => $id_invoice));

          if($data) $this->api->update($data_approval,$id_invoice);
          else $this->api->insert($data_approval);
    }

    public function get_currency() {
        $this->load->model('EC_pricelist_m');
        $dataa = $this->EC_pricelist_m->get_MasterCurrency();
        echo json_encode($dataa);
    }

    public function get_invoiceDetail($INVOICE_NO) {
        $this->load->model('ec_invoice_m');
        $data = $this->ec_invoice_m->get_InvoinceDetail($INVOICE_NO);

        $json_data = array('data' => $this->getALLDetail($data));
        echo json_encode($json_data);
    }

    function getALLDetail($dataa = '') {
        $i = 1;
        $data_tabel = array();
        foreach ($dataa as $value) {
            $data[0] = $i++;
            $data[1] = $value['GR_AMOUNT_IN_DOC'] != null ? $value['GR_AMOUNT_IN_DOC'] : "-";
            $data[2] = $value['GR_ITEM_QTY'] != null ? $value['GR_ITEM_QTY'] : "-";
            $data[3] = $value['PO_NO'] != null ? $value['PO_NO'] : "-";
            $data[4] = $value['PO_ITEM_NO'] != null ? $value['PO_ITEM_NO'] : "-";
            $data[5] = $value['GR_NO'] != null ? $value['GR_NO'] : "-";
            $data[6] = $value['GR_ITEM_NO'] != null ? $value['GR_ITEM_NO'] : "-";
            $data[7] = $value['FAKTUR'] != null ? $value['FAKTUR'] : "-";

            $data_tabel[] = $data;
        }
        return $data_tabel;
    }

    public function get_data() {
        $this->load->model('ec_invoice_m');
        $datainvoice = $this->ec_invoice_m->get_Invoince();

        $this->load->model('EC_pricelist_m');
        $dataa = $this->EC_pricelist_m->get($this->input->post('limitMin'), $this->input->post('limitMax'));
        $json_data = array('page' => 10, 'data' => $this->getALL($datainvoice));
        echo json_encode($json_data);
    }

    public function get_invoice_lanjut(){
        $this->load->model('ec_open_inv','eo');
        $this->load->model('invoice/ec_role_access','era');
        $role = array();
        $era = $this->db->where('ROLE_AS in (\''.implode('\',\'',$this->current_roles).'\') and ROLE_AS like \'VERIFIKASI%\'')->get('EC_ROLE_ACCESS')->result_array();

        $era_group = $this->groupingByColumn($era, 'ROLE_AS');
        $datainvoice = array();

        foreach($era_group as $eg){
           $where_str = array();
           foreach($eg as $val){
               if($val['OBJECT_AS'] == 'ITEM_CAT'){
                $where_str[] = $val['OBJECT_AS'] .' in ('.$val['VALUE'].')';
               }else{
                $where_str[] = $val['OBJECT_AS'] .' in (\''.$val['VALUE'].'\')';
               }
           }
      //     $where_str  = array('ITEM_CAT in (0,2,3,4,5,6,7,8,9)');
           $order = ' order by EIH.CHDATE desc';
           $_tmp = $this->eo->get_Invoice('where '.implode(' AND ',$where_str).' AND EIH.ID_INVOICE NOT IN ( SELECT ID_INVOICE FROM EC_LOG_INVOICE_CANCEL WHERE STATUS_REINVOICE = 0 and STATUS_DOCUMENT = 5 ) ',$order);
           if(!empty($_tmp)){
               foreach($_tmp as $t){
                   array_push($datainvoice,$t);
               }
           }
        }
        $json_data = array('page' => 25, 'data' => $datainvoice);
        echo json_encode($json_data);
    }

    public function get_invoice_terima_dokumen(){
        $this->load->model('ec_open_inv','op');
        /* untuk memisahkan jasa dan barang */
        $era = $this->db->select(array('ROLE_AS','VALUE','OBJECT_AS'))->where('(OBJECT_AS = \'ITEM_CAT\' OR OBJECT_AS = \'COMPANY_CODE\') AND ROLE_AS in (\''.implode('\',\'',$this->current_roles).'\') AND ROLE_AS LIKE \'VERIFIKASI 2%\'')->get('EC_ROLE_ACCESS')->result_array();
        $era_group = $this->groupingByColumn($era, 'ROLE_AS');
        $datainvoice = array();
        foreach($era_group as $eg){
          $_filterItemCat = array();
          $_filterCompany = array();
           foreach($eg as $val){
             if($val['OBJECT_AS'] == 'ITEM_CAT'){
               $_tmp = explode(',',$val['VALUE']);
               foreach($_tmp as $_t){
                 array_push($_filterItemCat,$_t);
               }
             }
             if($val['OBJECT_AS'] == 'COMPANY_CODE'){
               $_tmp = explode(',',$val['VALUE']);
               foreach($_tmp as $_t){
                 array_push($_filterCompany,$_t);
               }
             }
           }
           $_filterItemCat = implode(',',array_unique($_filterItemCat));
           $_filterCompany = implode(',',array_unique($_filterCompany));
           $whereStr = ' where STATUS_DOC = \'KIRIM\' and POSISI = \'EKSPEDISI\' AND ITEM_CAT in ('.$_filterItemCat.')  AND COMPANY_CODE in ('.$_filterCompany.') ';
          //$whereStr = ' where STATUS_DOC = \'KIRIM\' and POSISI = \'EKSPEDISI\'  AND COMPANY_CODE in ('.$_filterCompany.') ';
           $_tmp = $this->op->get_InvoiceTerimaDokumen($whereStr);
           //echo '<pre>'.$this->db->last_query();
           if(!empty($_tmp)){
               foreach($_tmp as $t){
                   array_push($datainvoice,$t);
               }
           }

        }


        $json_data = array('page' => 25, 'data' => $datainvoice);
        //echo $this->db->last_query();
        echo json_encode($json_data);
    }

    public function get_data_submitted() {
        $this->load->model('ec_invoice_m');
        $datainvoice = $this->ec_invoice_m->get_Invoince(2);
        $json_data = array('page' => 25, 'data' => $datainvoice);
        echo json_encode($json_data);
    }

    function getALL($dataa = '') {
        $i = 1;
        $data_tabel = array();
        foreach ($dataa as $value) {
            $data[0] = $i++;
            $data[1] = $value['INVOICE_NO'] != null ? $value['INVOICE_NO'] : "";
            $data[2] = $value['INVOICE_DATE'] != null ? $value['INVOICE_DATE'] : "";
            $data[3] = $value['FAKTUR'] != null ? $value['FAKTUR'] : "";
            $data[4] = $value['CURRENCY'] != null ? $value['CURRENCY'] : "";
            $data[5] = $value['TOTAL_AMOUNT'] != null ? $value['TOTAL_AMOUNT'] : "";
            $data[6] = $value['INV_PIC'] != null ? $value['INV_PIC'] : "";
            $data[7] = $value['FAKTUR_PIC'] != null ? $value['FAKTUR_PIC'] : "";
            $data_tabel[] = $data;
        }
        return $data_tabel;
    }
/*
    public function insertOffer() {
        $venno = $this->session->userdata['VENDOR_NO'];
        $harga = $this->input->post('harga');
        $curr = $this->input->post('curr');
        $matno = $this->input->post('matno');
        $start_date = $this->input->post('startdate');
        $end_date = $this->input->post('enddate');
        $status = $this->input->post('status');
        $this->load->model('EC_pricelist_m');
        $this->EC_pricelist_m->insertData($venno, $matno, $harga, $curr, $start_date, $end_date, $status);
        //echo json_encode('deleted');
    }

    public function getDetail($MATNR) {
        header('Content-Type: application/json');
        $this->load->model('EC_strategic_material_m');
        $data['MATNR'] = $this->EC_strategic_material_m->getDetail($MATNR);
        //substr($MATNR, 1));
        echo json_encode($data);
    }
*/
    public function detail($noinvoice = '1234567890',$status = '') {
        $roles_user = $this->roles_user;
        $action_forms = array(
            2 => 'approveInvoice',
            3 => 'postingInvoice'
        );

        $readonly_forms = array(
            'VERIFIKASI1' => array(3,5,6),
            'VERIFIKASI2' => array(5,6),
        );

        $defaultDocType = 'RE';
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_css('plugins/select2/select2.min.css');
        $this->layout->add_css('pages/invoice/common.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');
        $this->layout->add_js('select2.min.js');
        $this->layout->add_js('jquery.alphanum.js');
        $this->layout->add_js('jquery.priceFormat.min.js');
        $this->layout->add_js('bootbox.js');

        $data['title'] = "Detail Invoice";
        $data['noinvoice'] = $noinvoice;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();

        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('pages/EC_invoice_detail.js');
        $this->load->model('ec_open_inv');
        $this->load->model('ec_invoice_m');
        $this->load->model('ec_open_inv');
        $this->load->model('invoice/ec_m_pajak_inv', 'pajak');
        $this->load->model('invoice/ec_t_denda_inv', 'denda');
        $this->load->model('invoice/ec_t_doc_inv', 'doc');
        $this->load->model('invoice/ec_m_doc_type', 'doc_type');
        $this->load->model('invoice/ec_m_pay_block', 'pay_block');
        $this->load->model('invoice/ec_m_pay_method', 'pay_method');
        $this->load->model('invoice/ec_m_pay_term', 'pay_term');
        $this->load->model('invoice/ec_m_withholding_tax', 'pph_inv');
        $this->load->model('invoice/ec_m_denda_inv', 'mdenda');
        $this->load->model('invoice/ec_gr','gr');
        $this->load->model('invoice/ec_gr_sap','gr_sap');

        /* cek role dari user yang login */
        $punya_role = array_intersect($roles_user,$this->current_roles);
        if (empty($punya_role)) {
            die('Anda tidak memiliki role Verifikasi');
        }
        $data['tombolPosting'] = '';
        $data['tombolSimulate'] = '';

        $data['invoice'] = $this->ec_open_inv->get_Invoice(' where EIH.ID_INVOICE = \''.$noinvoice.'\'');
        $data['GR'] =  $this->gr->as_array()->get_all(array('INV_NO' => $noinvoice));
        $companyCode = $data['GR'][0]['COMPANY_CODE'];
        $wherePajak = "ID_JENIS IN ('VQ', 'VZ','V5','VN', 'VT', 'WN', 'WT') AND STATUS = 1";
        $data['pajak'] = $this->db->where($wherePajak)->get('EC_M_PAJAK_INV')->result_array();
        //$data['pajak'] = $this->pajak->as_dropdown('JENIS')->get_all(array('STATUS'=>1));
        $_denda = $this->denda->as_array()->get_all(array('ID_INV' => $noinvoice));
        $_mdenda = $this->mdenda->as_array()->get_all(array('STATUS' => 1));

        $mdenda = array();
        foreach($_mdenda as $_md){
            $mdenda[$_md['ID_JENIS']] = $_md;
        }
        $data['mdenda'] = $mdenda;
        /* tambahkan nama denda dan nomer glaccount */
        //$mDendaGl = $this->db->where('STATUS = 1 and DIRECT_ACTION = 0 and GL_ACCOUNT is not null')->get('EC_M_DENDA_INV')->result();
        $data['denda'] = array();
        $data['dendaGLAccount'] = array();
        if(!empty($_denda)){
          foreach ($_denda as $_d) {
            $_d['JENIS'] = $mdenda[$_d['ID_DENDA']]['JENIS'];
            $_d['GL_ACCOUNT'] = '';


            if(!$mdenda[$_d['ID_DENDA']]['DIRECT_ACTION'] && !empty($mdenda[$_d['ID_DENDA']]['GL_ACCOUNT'])){
                $_d['GL_ACCOUNT'] = $mdenda[$_d['ID_DENDA']]['GL_ACCOUNT'];
                /* tambahkan dulu untuk mendapatkan GL_ACCOUNT */
                array_push($data['denda'],$_d);
                $_d['PROFIT_CTR'] = '';
                $_d['COSTCENTER'] = '';
                $_d['TAX_CODE'] = '';
                $_d['DB_CR_IND'] = 'H';
                $_d['ITEM_TEXT'] = $mdenda[$_d['ID_DENDA']]['JENIS'];
                array_push($data['dendaGLAccount'],$_d);
            }else{
                array_push($data['denda'],$_d);
            }


          }
        }

        // $data['mdenda'] = $mdenda;
        $status = strtolower($status);
        $data['reverse'] = $status;

        $status_invoice = $data['invoice'][0]['STATUS_HEADER'];
        if($status == 'create'){
          $status_invoice = 2;
        }

        $data['doc'] = $this->doc->get_all(array('ID_INV' => $noinvoice));
        $data['form_submit'] = $action_forms[$status_invoice];
        $data['approve_reject'] = $action_forms[$status_invoice] == 'approveInvoice' ? 1 : 0;
        $venno = $data['invoice'][0]['VENDOR_NO'];
        $data['listBank'] = $this->listBankVendor($venno);
        /* 2 sebagai verifikasi2 */
        $posting_invoice = array();
        $data_approve['default_doc_type'] = $defaultDocType;
        $status_show_pajak = array(3,5,6);
        $data['tombolProfitCenter'] = 1 ;
/*
        $_dinvoice = $this->gr_sap->fields(array('WERKS'))->get(array('INV_NO'=>$noinvoice, 'STATUS'=>1));
        $kodeAwalCompany = substr($_dinvoice->WERKS,0,1);
        $company = $kodeAwalCompany.'000';
        */
        $data['companyCode'] = $companyCode;
        $data['itemData'] = array();
        $data['referenceGL'] = array();
        $data_approve['withtaxdata'] = array();
        $param_gl = array('LANGUAGE' => 'EN', 'COMPANYCODE' => $companyCode);
        $data['allgl'] = $this->getListAccount($param_gl);
        $data['keyGl'] = $this->keyGlArray($data['allgl']);
        $data['taxdata'] = array();
        if ( $this->isVerifikasi(2) && in_array($status_invoice,$status_show_pajak)){
            /* jika statusnya 3, cek posisi dokumen, harusnya sudah berada di verifikasi dengan status terima */
            if($status_invoice == 3){

              /* pastikan fi_number sudah terisi */
              if(empty($data['invoice'][0]['FI_NUMBER_SAP'])){
                  $awkey = $data['invoice'][0]['INVOICE_SAP'].$data['invoice'][0]['FISCALYEAR_SAP'];
                  $fiNumber = $this->getFINumber(array('AWKEY' => $awkey));
                  // update di oracle
                  $this->load->model('ec_invoice_m', 'em');
                  if(!empty($fiNumber['FI_NUMBER'])){
                    $_updateHeader = array();
                    $_updateHeader['FI_NUMBER_SAP'] = $fiNumber['FI_NUMBER'];
                    $_updateHeader['FI_YEAR'] = $fiNumber['FI_YEAR'];
                    $_updateHeader['COMPANY_CODE'] = $fiNumber['COMPANY_CODE'];
                    $this->em->updateInvoice($noinvoice, $_updateHeader);
                  }
                }

                $this->load->model('invoice/ec_tracking_invoice','eti');
                $tracking_doc = $this->eti->order_by('DATE','DESC')->get(array('ID_INVOICE'=>$noinvoice));
                $lanjut = 0;
                $headerData = array();
                if($tracking_doc->POSISI == 'VERIFIKASI' && $tracking_doc->STATUS_DOC == 'TERIMA'){
                    $lanjut = 1;
                    /* ambil dari SAP */
                    $invoicedocnumber = $data['invoice'][0]['INVOICE_SAP'];
                    $fiscalyear = $data['invoice'][0]['FISCALYEAR_SAP'];
                    $_detailInvoiceSAP = $this->getDetailInvoice(array('INVOICEDOCNUMBER' => $invoicedocnumber, 'FISCALYEAR' => $fiscalyear));
                    $data['taxdata'] = $_detailInvoiceSAP['TAXDATA'];
                    $data['dendaGLAccount'] = $_detailInvoiceSAP['GLACCOUNTDATA'];
                    $headerData = $_detailInvoiceSAP['HEADERDATA'];
                    $data['itemData'] = array();
                    $glRef = array();
            //        print_r($headerData);
                    /* override data header dari oracle */
                    $data['invoice'][0]['INVOICE_DATE2'] = date('d/m/Y',saptotime($headerData['DOC_DATE']));
                    $data['invoice'][0]['NO_INVOICE'] = $headerData['HEADER_TXT'];
                    $data['invoice'][0]['PARTNER_BANK'] = $headerData['PARTNER_BK'];
                    $data['invoice'][0]['FAKTUR_PJK'] = formatPajak($headerData['REF_DOC_NO']);
                    $data['invoice'][0]['CALC_TAX'] = empty($headerData['CALC_TAX_IND']) ? 0 : 1;
                    // saptotime
                    if(!empty($_detailInvoiceSAP['ITEMDATA'])){
                      foreach($_detailInvoiceSAP['ITEMDATA'] as $_item){
                          $_noref = $_item['KEY_ITEM'];
                          $data['itemData'][$_noref] = $_item;
                          $glRef[$_item['INVOICE_DOC_ITEM']] = $_noref;
                      }
                    }

                    if(!empty($_detailInvoiceSAP['ACCOUNTINGDATA'])){
                      foreach($_detailInvoiceSAP['ACCOUNTINGDATA'] as $_item){
                          $data['referenceGL'][$glRef[$_item['INVOICE_DOC_ITEM']]] = $_item['GL_ACCOUNT'];
                      }
                    }

                    if(!empty($_detailInvoiceSAP['WITHTAXDATA'])){
                      foreach($_detailInvoiceSAP['WITHTAXDATA'] as $_item){
                          $data_approve['withtaxdata'][$_item['WI_TAX_TYPE']] = $_item;
                      }
                    }

                    $data['tombolPosting'] = '<span class="btn btn-info posting_btn" onclick="Invoice.addElmPosting(this)" id="postingButton">Posting</span>';
                    $data['tombolSimulate'] = '<span class="btn btn-warning posting_btn" onclick="Invoice.viewSimulate(this)">Simulate</span>';
                }
                if(!$lanjut){
                   $pesan  = 'Dokumen invoice nomer '.$data['invoice'][0]['NO_INVOICE'].' nomer po '.$data['invoice'][0]['NO_SP_PO'].' belum diterima oleh verifikasi';
                   $this->session->set_flashdata('message', $pesan);
                   redirect(site_url('EC_Invoice_ver'));
                }
            }
            /* ambil data dari ec_posting_invoice */
            $this->load->model('invoice/ec_posting_invoice', 'posting_invoice');
            $this->load->model('invoice/ec_m_withholding_detail', 'mwd');

            $posting_invoice = $this->posting_invoice->as_array()->order_by('CREATE_DATE', 'DESC')->get(array('ID_INVOICE' => $noinvoice));
            $posting_invoice['POSTING_DATE'] = $this->tglOracleToPHP($posting_invoice['POSTING_DATE'], 'd/m/Y');
            $posting_invoice['BASELINE_DATE'] = $this->tglOracleToPHP($posting_invoice['BASELINE_DATE'], 'd/m/Y');

            if(!empty($headerData)){
              $posting_invoice['POSTING_DATE'] = date('d/m/Y',saptotime($headerData['PSTNG_DATE']));
              $posting_invoice['BASELINE_DATE'] = date('d/m/Y',saptotime($headerData['BLINE_DATE']));
            }

          //  $tax_type = $this->pph_inv->get_all(array('STATUS' => 1));
            $tax_type = $this->listTaxVendor($venno,$companyCode);
            $data_approve['pph_inv'] = $tax_type;
            $list_tax_type = array();
            $list_group_wi = array();
            if(!empty($tax_type)){
              foreach($tax_type as $_tt){
                  $list_group_wi[$_tt['WITHT']] = $this->getVendorWitholdingTax($_tt['WITHT']);
              }
            }

            $data_approve['list_child_tax'] = $list_group_wi;
            $data_approve['default_doc_type'] = $posting_invoice['DOC_TYPE'];
        }


        $data_approve['posting_date'] = empty($posting_invoice) ? date('d/m/Y') : $posting_invoice['POSTING_DATE'];
        $data_approve['baseline_date'] = empty($posting_invoice) ? $data['invoice'][0]['INVOICE_DATE2'] : $posting_invoice['BASELINE_DATE'];
        $data_approve['doc_type'] = $this->doc_type->as_dropdown('DOC_DESC')->get_all(array('STATUS' => 1));
        $data_approve['pay_block'] = $this->pay_block->as_dropdown('PB_DESC')->get_all(array('STATUS' => 1));
        $data_approve['pay_method'] = $this->pay_method->as_dropdown('PM_DESC')->get_all(array('STATUS' => 1));
        $data_approve['GR'] = $data['GR'];
        // $data_approve['pay_term'] = $this->pay_term->as_dropdown('PT_DESC')->get_all(array('STATUS' => 1));

        $data['form_approve'] = $this->load->view('form_approve', $data_approve, TRUE);
        $data['pesan'] = $this->input->get('pesan');
        $data['parcial'] = $this->checkParcial($noinvoice);
        $data['lot'] = $this->checkLot($noinvoice);
        $data['pomut'] = $this->checkPomut($data['invoice'][0]['POTMUT_PIC']);
        $this->layout->render('detail', $data);
    }

    /*
      [user_data] => [MKCCTR] => 2002023000 [ID] => 10164 [FIRSTNAME] => ICUK HERTANTO, S.Kom. [LASTNAME] => ICUK HERTANTO, S.Kom. [FULLNAME] => ICUK HERTANTO, S.Kom. [EMAIL] => ICUK.HERTANTO@SEMENINDONESIA.COM [POS_ID] => 57510 [POS_NAME] => SM of Group Demand Mgmt & Bus. Process [JOB_TITLE] => Senior Manager [DEPT_ID] => 13841 [DEPT_NAME] => Bureau of Group Demand Mgmt & Bus. Procs [COMPANYID] => 2000 [COMPANYNAME] => PT. Semen Indonesia (Tbk) [GROUP_MENU] => 22 [EM_COMPANY] => 2000 [PRGRP] => 'G01','K02','G04','G02' [KEL_PRGRP] => 2 [logged_in] => 1 [is_vendor] => [USERNAME] => icuk.hertanto@semenindonesia.com [GRPAKSES] => 22 )
     */

     private function listBankVendor($venno){
       $this->load->library('sap_handler');
       return $this->sap_handler->getListBankVendor($venno);
     }

     public function getCostCenter($company){
       $this->load->library('sap_invoice');
       $data['COMPANYCODE_FROM'] = $company;
       $result = $this->sap_invoice->getCostCenter($data);
       echo json_encode(array('status' => 1, 'data' => $result));
     }

     public function getListAccount($data){
       $this->load->library('sap_invoice');
       $t = $this->sap_invoice->getListAccount($data);
       return $t;
       // return ;
     }

     public function listTaxVendor($venno,$company){
       $this->load->library('sap_handler');
       $result = $this->sap_handler->getListTaxVendor($venno,$company);

       return $result;
     }
     public function getVendorWitholdingTax($tax){
       $this->load->library('sap_handler');
       $result = $this->sap_handler->getVendorWitholdingTax($tax);
       return $result;
     }


    public function approveInvoice() {
        $this->load->model('ec_invoice_m', 'em');
        $this->load->model('invoice/ec_tracking_invoice', 'et');
        $this->load->model('invoice/ec_posting_invoice', 'ep');
        $this->load->model('invoice/ec_posting_withholding_tax', 'epp');
        $this->load->model('invoice/ec_log_invoice_cancel', 'ilic');
        $id_invoice = $this->input->post('ID_INVOICE');
        $action = $this->input->post('next_action');
        $alasan_reject = $this->input->post('alasan_reject');
        $pesan = '';

        $not_reverse = $this->input->post('REVERSE')=='create' ? 0 : 1;
        $data_tracking = array(
            'ID_INVOICE' => $id_invoice,
            'DESC' => 'EDIT',
            'STATUS_DOC' => 'BELUM KIRIM',
            'POSISI' => 'VENDOR',
            'USER' => $this->user
        );
        /* 1 untuk approve, 0 untuk reject */
        if ($action){
            $editInvoice = $this->editInvoice($id_invoice);
            if($editInvoice['status']){
              $data = array('STATUS_HEADER' => 3);
              $this->db->trans_begin();
              $dataPosting = array();
              $dataPosting['posting_date'] = $this->input->post('posting_date');
              $dataPosting['baseline_date'] = $this->input->post('baseline_date');
              $dataPosting['doc_type'] = $this->input->post('doc_type');
              $dataPosting['payment_block'] = $this->input->post('payment_block');
              $dataPosting['payment_method'] = $this->input->post('payment_method');
              $dataPosting['payment_term'] = $this->input->post('payment_term');
              $dataPostingOracle = array();
              foreach ($dataPosting as $key => $val) {
                  if (!empty($val)) {
                      $dataPostingOracle[strtoupper($key)] = $val;
                  }
              }
              $dataPostingOracle['CREATE_BY'] = $this->user;
              $dataPostingOracle['ID_INVOICE'] = $id_invoice;
              if (!empty($dataPosting['posting_date'])) {
                  $_tmp = explode('/', $dataPosting['posting_date']);
                  $dataPosting['posting_date'] = implode('', array_reverse($_tmp));
                  $dataPostingOracle['POSTING_DATE'] = implode('-', array_reverse($_tmp));
              } else {
                  $dataPosting['posting_date'] = date('Ymd');
              }

              if (!empty($dataPosting['baseline_date'])) {
                  $_tmp = explode('/', $dataPosting['baseline_date']);
                  $dataPosting['baseline_date'] = implode('', array_reverse($_tmp));
                  $dataPostingOracle['BASELINE_DATE'] = implode('-', array_reverse($_tmp));
              } else {
                  $dataPosting['baseline_date'] = date('Ymd');
              }

              $dataPajak = $this->input->post('WTAX_CODE');
              $taxType = $this->input->post('WTAX_TYPE');
              $taxAmount = $this->input->post('WTAX_AMOUNT');

              $pajakPosting = array();
              if(!empty($dataPajak)){
                  foreach($dataPajak as $i => $dpk){
                      if(!empty($dpk)){
                          array_push($pajakPosting,array('TAX_CODE' => $dpk,'ID_INVOICE' => $id_invoice,'WTAX_TYPE' => $taxType[$i], 'AMOUNT' => $taxAmount[$i],'CREATE_BY' => $this->user));
                      }
                  }
              }

              $CALC_TAX = $this->input->post('calc_tax');
              $CALC_TAX = !empty($CALC_TAX) ? 1 : 0;
              /* jika bernilai 0 maka harus isi tax amount secara manual */
              $taxData = array();

              if(!$CALC_TAX){
                $taxBaseAmountSAP = $this->input->post('taxBaseAmountSAP');
                $taxAmountSAP = $this->input->post('taxAmountSAP');
                $pajak_grSAP = $this->input->post('pajak_gr');
                foreach($taxBaseAmountSAP as $i => $_tax){
                  $_taxAmount = str_replace('.','',$taxAmountSAP[$i]);
                  $_taxBaseAmount = str_replace('.','',$_tax);
                  $tmp = array('TAX_CODE' => $pajak_grSAP[$i],'TAX_AMOUNT' => $_taxAmount, 'TAX_BASE_AMOUNT' => $_taxBaseAmount);
                  array_push($taxData,$tmp);
                }
              }

              $invoiceSAP = $this->approve($id_invoice, $dataPosting,$pajakPosting,$taxData,FALSE);
              // print_r($invoiceSAP);
              //    $invoiceSAP['status'] = 1;
              if ($invoiceSAP['status']) {
                  $data['INVOICE_SAP'] = $invoiceSAP['data']['invoicenumber'];
                  $data['FISCALYEAR_SAP'] = $invoiceSAP['data']['fiscalyear'];
                  /* dapatkan nomer fi invoice */
                  $awkey = $data['INVOICE_SAP'].$data['FISCALYEAR_SAP'];
                  $fiNumber = $this->getFINumber(array('AWKEY' => $awkey));
                  $maxLoop = 50;
                  $_loop = 1;
                  while(empty($fiNumber) && $_loop < $maxLoop){
                    $fiNumber = $this->getFINumber(array('AWKEY' => $awkey));
                    $_loop++;
                  }

                  if(!empty($fiNumber['FI_NUMBER'])){
                    $data['FI_NUMBER_SAP'] = $fiNumber['FI_NUMBER'];
                    $data['FI_YEAR'] = $fiNumber['FI_YEAR'];
                    $data['COMPANY_CODE'] = $fiNumber['COMPANY_CODE'];
                  }

 
                  $this->em->updateInvoice($id_invoice, $data);
                  $data_tracking['STATUS_TRACK'] = 3;
                  if($not_reverse) {
                    $this->et->insert($data_tracking);
                  }else{
                    $this->reEkspedisi($id_invoice);
                    $this->ilic->update(array('STATUS_REINVOICE'=>'1'),array('ID_INVOICE' => $id_invoice));
                  }

                  $this->ep->insert($dataPostingOracle);
                  if(!empty($pajakPosting)){
                      foreach($pajakPosting as $_pp){
                          $this->epp->insert($_pp);
                      }
                  }
              }

              $this->db->trans_complete();
              if ($this->db->trans_status() === FALSE || !$invoiceSAP['status']) {
                  $this->db->trans_rollback();
                  $pesan = $this->buildMessageErrorSAP($invoiceSAP);
                  $this->session->set_flashdata('message', 'Error <hr />'.implode('<hr />',$pesan));
                  $nextUrlRedirect = $not_reverse ? site_url('EC_Invoice_ver/detail/'.$id_invoice) : site_url('EC_Invoice_ver/detail/'.$id_invoice.'/create');
                  redirect($nextUrlRedirect);
              } else {
                  $this->db->trans_commit();
                  /* Kirim notifikasi approve jika bukan invoice ulang */
                  if($not_reverse) $this->notifikasiApprove($id_invoice);

                  $pesan = 'Nomer Mir SAP ' . $invoiceSAP['data']['invoicenumber'] . ' tahun ' . $invoiceSAP['data']['fiscalyear'];
                  $this->session->set_flashdata('message', $pesan);
                  redirect(site_url('EC_Invoice_ver'));
              }
            }
        } else {
            /* jika reject harus mengisi alasannya */
            if (empty($alasan_reject)) {
                $pesan = 'Proses reject gagal, alasan reject harus diisi';
                redirect(site_url('EC_Invoice_ver/detail/' . $id_invoice . '?pesan=' . $pesan));
            } else {
                $data = array('STATUS_HEADER' => 4, 'ALASAN_REJECT' => $alasan_reject);
                $this->db->trans_begin();
                $this->em->updateInvoice($id_invoice, $data);
                $data_tracking['STATUS_TRACK'] = 4;
                $this->et->insert($data_tracking);
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $pesan = 'Proses reject gagal';
                    redirect(site_url('EC_Invoice_ver/detail/' . $id_invoice . '?pesan=' . $pesan));
                } else {
                    $this->db->trans_commit();
                    /* Kirim notifikasi alasana reject */
                    $this->notifikasiReject($id_invoice,$alasan_reject);
                    redirect(site_url('EC_Invoice_ver'));
                }
            }
        }
    }

    public function reEkspedisi($idinvoice){
      $this->load->library('sap_invoice');
      $this->load->model('invoice/ec_gr_sap','gr_sap');
      $this->load->model('invoice/ec_gr','gr');
      $this->load->model('invoice/ec_invoice_header','eih');
      $this->load->model('invoice/ec_posting_invoice','epi');
      /* cari data header */
      $dataInvoice = $this->eih->get(array('ID_INVOICE' => $idinvoice));
      $company = $dataInvoice->COMPANY_CODE;
      $tglInvoice = new DateTime($dataInvoice->INVOICE_DATE);
      /* cari tanggal posting invoice */
      $_tposting = $this->epi->get(array('ID_INVOICE' => $idinvoice));
      $tglPosting = new DateTime($_tposting->POSTING_DATE);

      /*Cari kode user*/
      $code_user = $this->getIdSAP($this->user_email);

      $header = array(
        'company' => $company,
        'vendor' => $dataInvoice->VENDOR_NO,
        'invoice_date' => $tglInvoice->format('Ymd'),
        'posting_date' => $tglPosting->format('Ymd'),
        'username' => $code_user
      );

      /*Cari data item*/
      $grItem = $this->gr->as_array()->get_all(array('INV_NO' => $idinvoice,'STATUS' => 1));

      $itemInvoice = $dataInvoice->FI_NUMBER_SAP;
    //  $itemInvoice = $dataInvoice->FI_NUMBER_SAP;
      $item = array();
      foreach($grItem as $_t){
        array_push($item,array(
          'invoice' => $itemInvoice,
          'currency' => $dataInvoice->CURRENCY,
          'amount' =>  $dataInvoice->CURRENCY == 'IDR' ? $dataInvoice->TOTAL_AMOUNT / 100 : $dataInvoice->TOTAL_AMOUNT,
          'payment_block' => 3,
          'po' => $_t['PO_NO'],
          'item_po' => $_t['PO_ITEM_NO']
          )
        );
      }

      $t = $this->sap_invoice->kirimterimaDokumenEkspedisi($header,$item);
      $nomerDokumen = 0;

      $result = array(
        'status' => 0,
        'message' => ''
      );

      if($t[0]['TYPE'] == 'S'){
        $str = $t[0]['MESSAGE'];
        preg_match_all('!\d+!', $str, $matches);
        $nomerDokumen = $matches[0];
        /* simmpan ke database */
        $this->load->model('invoice/ec_ekspedisi','ee');
        if($this->ee->insert(array('ID_INVOICE' => $dataInvoice->ID_INVOICE,'NO_EKSPEDISI' => $nomerDokumen[0],'TAHUN' => date('Y'),'ACCOUNTING_INVOICE'=> $itemInvoice,'COMPANY' => $company, 'CATATAN_VENDOR' => ''))){
            $result['status'] = 1;
            $result['message'] = 'Dokumen berhasil dikirim dengan nomer ekspedisi '.$nomerDokumen[0];
        }
      }else{
        $result['message'] = $t[0]['MESSAGE'];
      }
    }

    public function postingInvoice() {
        $this->load->model('ec_invoice_m', 'em');
        $this->load->model('invoice/ec_tracking_invoice', 'et');
        $this->load->model('invoice/ec_posting_invoice', 'ep');
        $this->load->model('invoice/ec_posting_withholding_tax', 'epp');
        $id_invoice = $this->input->post('ID_INVOICE');
        $pesan = '';
        $dataPajak = $this->input->post('WTAX_CODE');
        $taxType = $this->input->post('WTAX_TYPE');
        $taxAmount = $this->input->post('WTAX_AMOUNT');
        $pajakPosting = array();
        if(!empty($taxAmount)){
            foreach($taxAmount as $i => $dpk){
              //  if(!empty($dpk)){
                    $dpk = str_replace('.', '', $dpk);
                    array_push($pajakPosting,array('TAX_CODE' => isset($dataPajak[$i]) ? $dataPajak[$i] : $i,'ID_INVOICE' => $id_invoice,'WTAX_TYPE' => $taxType[$i], 'AMOUNT' => $dpk,'CREATE_BY' => $this->user));
              //  }
            }
        }
        /* 5 untuk posting */
        $editInvoice = $this->editInvoice($id_invoice);
        if($editInvoice['status']){
          $this->db->trans_begin();
          $dataPosting = array();
          $dataPosting['posting_date'] = $this->input->post('posting_date');
          $dataPosting['baseline_date'] = $this->input->post('baseline_date');
          $dataPosting['doc_type'] = $this->input->post('doc_type');
          $dataPosting['payment_block'] = $this->input->post('payment_block');
          $dataPosting['payment_method'] = $this->input->post('payment_method');
          $dataPosting['payment_term'] = $this->input->post('payment_term');
          $dataPostingOracle = array();
          foreach ($dataPosting as $key => $val) {
              if (!empty($val)) {
                  $dataPostingOracle[strtoupper($key)] = $val;
              }
          }
          $dataPostingOracle['CREATE_BY'] = $this->user;
          $dataPostingOracle['ID_INVOICE'] = $id_invoice;
          if (!empty($dataPosting['posting_date'])) {
              $_tmp = explode('/', $dataPosting['posting_date']);
              $dataPosting['posting_date'] = implode('', array_reverse($_tmp));
              $dataPostingOracle['POSTING_DATE'] = implode('-', array_reverse($_tmp));
          } else {
              $dataPosting['posting_date'] = date('Ymd');
          }

          if (!empty($dataPosting['baseline_date'])) {
              $_tmp = explode('/', $dataPosting['baseline_date']);
              $dataPosting['baseline_date'] = implode('', array_reverse($_tmp));
              $dataPostingOracle['BASELINE_DATE'] = implode('-', array_reverse($_tmp));
          } else {
              $dataPosting['baseline_date'] = date('Ymd');
          }
          /* tambahkan dataPosting untuk costcenter dan profit center */
           $dataPosting['costcenter'] = $this->input->post('cost_center');
           $dataPosting['profit_ctr'] = $this->input->post('profit_ctr');
           $invoiceSAP = $this->changePosting($id_invoice, $dataPosting,$pajakPosting); // nanti diganti
          // $invoiceSAP['status'] = 1;
          if ($invoiceSAP['status']) {
              $this->epp->delete(array('ID_INVOICE' => $id_invoice));
              $this->ep->insert($dataPostingOracle);
              if(!empty($pajakPosting)){
                  foreach($pajakPosting as $_pp){
                      $this->epp->insert($_pp);
                  }
              }
          }else{
            $pesan = $this->buildMessageErrorSAP($invoiceSAP);
            $this->session->set_flashdata('message', 'Error <hr />'.implode('<hr />',$pesan));
            redirect(site_url('EC_Invoice_ver/detail/'.$id_invoice));
          }

          $this->db->trans_complete();
          if ($this->db->trans_status() === FALSE || !$invoiceSAP['status']) {
              $this->db->trans_rollback();
              $pesan = 'Proses posting invoice gagal'. $t;
              redirect(site_url('EC_Invoice_ver/detail/' . $id_invoice . '?pesan=' . $pesan));
          } else {
              $this->db->trans_commit();
              $postingInvoice = $this->input->post('postingInvoice');

              if(!empty($postingInvoice)){
                $this->postingInvoiceSAP($id_invoice);
              }else{
                $pesan = !empty($invoiceSAP['data']) ? $invoiceSAP['data'] : 'Posting sukses ' ;
                $this->session->set_flashdata('message', $pesan);
                redirect(site_url('EC_Invoice_ver'));
              }
          }
        }else{
            $pesan = 'Gagal update invoice ';
            $this->session->set_flashdata('message', $pesan);
            redirect(site_url('EC_Invoice_ver'));
        }

    }

    public function reject() {
        //print_r($id_parent);
        $this->load->model('ec_invoice_m');
        $data = array("INVOICE_NO" => $this->input->post("InvoiceNo"), "ALASAN_REJECT" => $this->input->post("reject"));
        $this->ec_invoice_m->updateData($data);
        redirect('EC_Invoice_ver/');
    }

    /*public function ApproveInv($debug = false) {
        //print_r($id_parent);
        $this->load->library('sap_handler');
        $this->load->model('ec_invoice_m');
        $this->load->model('ec_open_inv');
        $noinvoice = $this->input->post("InvoiceNoApp");
        $data = array("INVOICE_NO" => $this->input->post("InvoiceNoApp"), "DOC_DATE" => $this->input->post("DocumentDate"), "POST_DATE" => $this->input->post("PostingDate"), "PAYMENT_BLOCK" => $this->input->post("PaymentBlock"), "NOTE_APPROVE" => $this->input->post("Note"));
        $this->ec_invoice_m->updateHeader($data);
        $result = $this->ec_invoice_m->getINV($noinvoice);
        $dataINV = array("TGL_INV" => substr($result[0]['INVOICE_DATE'], 6, 4) . substr($result[0]['INVOICE_DATE'], 3, 2) . substr($result[0]['INVOICE_DATE'], 0, 2), "TGL_POST" => substr($result[0]['POST_DATE'], 6, 4) . substr($result[0]['POST_DATE'], 3, 2) . substr($result[0]['POST_DATE'], 0, 2), "FAKTUR_PJK" => $result[0]['FAKTUR'], "CURR" => $result[0]['CURRENCY'], "TOTAL_AMOUNT" => $result[0]['TOTAL_AMOUNT'], "INV_NO" => $result[0]['INVOICE_NO'], "PAYMENT" => $result[0]['PAYMENT_BLOCK'], "NOTE_VERI" => $result[0]['NOTE_APPROVE']);
        $dataa = $this->ec_open_inv->getGR($noinvoice);
        foreach ($dataa as $value) {
            $dataGR[] = array("PO_NO" => $value['PO_NO'], "PO_ITEM_NO" => $value['PO_ITEM_NO'], "GR_NO" => $value['GR_NO'], "GR_YEAR" => $value['GR_YEAR'], "GR_ITEM_NO" => $value['GR_ITEM_NO'], "GR_AMOUNT_IN_DOC" => $value['GR_AMOUNT_IN_DOC'], "GR_ITEM_QTY" => $value['GR_ITEM_QTY'], "UOM" => $value['MEINS']);
        }
        // if($debug)
        // var_dump($dataGR);

        $invoice = $this->sap_handler->createInvEC($dataINV, $dataGR, true);

        $data = array("INVOICE_NO_SAP" => $invoice, "INVOICE_NO" => $this->input->post("InvoiceNoApp"));
        if ($invoice != "") {
            $this->ec_invoice_m->updateHeaderSukses($data);
        }
        redirect('EC_Invoice_ver/');
    }*/

    public function listTerimaDokumen(){
        $data['title'] = "Document Invoice";
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_css('pages/EC_bootstrap-slider.min.css');
        $this->layout->add_js('pages/EC_bootstrap-slider.min.js');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('bootbox.js');
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('pages/invoice/EC_terima_dokumen.js');

        $this->layout->add_css('pages/EC_style_ecatalog.css');
        $this->layout->render('listTerimaDokumen', $data);
    }

    private function tglOracleToPHP($tgl, $format) {
        $t = new DateTime($tgl);
        return $t->format($format);
    }

    private function groupingByColumn($arr, $colum){
        $result = array();
        foreach($arr as $r){
            if(!isset($result[$r[$colum]])){
                $result[$r[$colum]] = array();
            }
            array_push($result[$r[$colum]],$r);
        }
        return $result;
    }

    private function buildMessageErrorSAP($error){
      $pesan = array();
      foreach($error['data'] as $ps){
        $tmp = array();
        foreach($ps as $k => $p){
          array_push($tmp,$k.' => '.$p);
        }
        array_push($pesan,implode('<br />',$tmp));
      }
      return $pesan;
    }

    public function editInvoice($ID_INVOICE) {
        $this->load->model('ec_open_inv');
        $this->load->library("file_operation");
        $this->load->helper('file');
        $this->load->helper(array('form', 'url'));
        $this->load->model('invoice/ec_invoice_header','eh');
        $uploaded = $this->file_operation->uploadI(UPLOAD_PATH . 'EC_invoice', $_FILES);
        $denda = array();
        $doc = array();

    //    $ID_INVOICE = $this->input->post('id_invoice');
        $NO_INVOICE = $this->input->post('invoice_no');
        $PARTNER_BANK = $this->input->post('partner_bank');
        $PAJAK = $this->input->post('pajak');
        $INVOICE_DATE = $this->input->post('invoice_date');
        $FAKTUR_PJK_DATE = $this->input->post('FakturDate');
        $NO_SP_PO = $this->input->post('sppo_no');
        $NO_BAPP = $this->input->post('bapp_no');
        $NO_BAST = $this->input->post('bast_no');
        $NO_KWITANSI = $this->input->post('kwitansi_no');
        $FAKTUR_PJK = $this->input->post('faktur_no');
        $POT_MUTU = $this->input->post('potmut_no');
        $SURAT_PRMHONAN_BYR = $this->input->post('spbyr_no');
        $TOTAL_AMOUNT = $this->input->post('totalAmount');
        $TOTAL_AMOUNT = str_replace('.', '', $TOTAL_AMOUNT);

        $CALC_TAX = $this->input->post('calc_tax');
        $CALC_TAX = !empty($CALC_TAX) ? 1 : 0;
        $NOTE = $this->input->post('note');
        $K3 = $this->input->post('K3');
        $header_update = array("NO_INVOICE" => $NO_INVOICE,
                "INVOICE_DATE" => $INVOICE_DATE,
                "FAKTUR_PJK_DATE" => $FAKTUR_PJK_DATE,
                "NO_SP_PO" => $NO_SP_PO,
                "NO_BAPP" => $NO_BAPP,
                "NO_BAST" => $NO_BAST,
                "NO_KWITANSI" => $NO_KWITANSI,
                "FAKTUR_PJK" => $FAKTUR_PJK,
                "POT_MUTU" => $POT_MUTU,
                "SURAT_PRMHONAN_BYR" => $SURAT_PRMHONAN_BYR,
                "TOTAL_AMOUNT" => $TOTAL_AMOUNT,
                "NOTE" => $NOTE,
                "PAJAK" => $PAJAK,
                "K3" => $K3,
                "PARTNER_BANK" => $PARTNER_BANK,
                "CALC_TAX" => $CALC_TAX
            );

            if(!empty($uploaded)){
                if(isset($uploaded['filePotMutu'])){
                $header_update['POTMUT_PIC'] = $uploaded['filePotMutu']['file_name'];
                }
                if(isset($uploaded['fileInv'])){
                    $header_update['INVOICE_PIC'] = $uploaded['fileInv']['file_name'];
                }
                if(isset($uploaded['fileBapp'])){
                    $header_update['BAPP_PIC'] = $uploaded['fileBapp']['file_name'];
                }
                if(isset($uploaded['fileBast'])){
                    $header_update['BAST_PIC'] = $uploaded['fileBast']['file_name'];
                }
                if(isset($uploaded['fileKwitansi'])){
                    $header_update['KWITANSI_PIC'] = $uploaded['fileKwitansi']['file_name'];
                }
                if(isset($uploaded['filespbyr'])){
                    $header_update['SPMHONBYR_PIC'] = $uploaded['filespbyr']['file_name'];
                }
                if(isset($uploaded['fileK3'])){
                    $header_update['K3_PIC'] = $uploaded['fileK3']['file_name'];
                }
                if(isset($uploaded['fileFaktur'])){
                    $header_update['FAKPJK_PIC'] = $uploaded['fileFaktur']['file_name'];
                }
            }

            $this->db->trans_begin();

            $this->eh->update($header_update,array('ID_INVOICE' => $ID_INVOICE));
            //echo $this->db->last_query(); die();
            // remove t_denda_inv dan t_doc_inv
            $this->load->model('invoice/ec_t_denda_inv','denda');
            $this->load->model('invoice/ec_t_doc_inv','doc');
            $this->denda->delete(array('ID_INV' => $ID_INVOICE));
        //    $this->doc->delete(array('ID_INV' => $ID_INVOICE));

            // $denda_tambahan = isset($_POST["idDenda"]) ? $_POST["idDenda"] : array();
            $keyFileDenda = array();
            $keyFileDoc = array();
            $oldFileDenda = array();
            $oldFileDoc = array();
            if(count($_FILES) > 0){
                foreach($_FILES as $key => $value){
                  $_keyFileDenda = substr($key,0,9);
                  $_keyFileDoc = substr($key,0,7);

                  if($_keyFileDenda == 'fileDenda'){
                    /* ambil angkanya saja */
                    array_push($keyFileDenda,substr($key,9));
                  }
                  if($_keyFileDoc == 'fileDoc'){
                    array_push($keyFileDoc,substr($key,7));
                  }
                }
            }

            // $denda_tambahan = isset($_POST["idDenda"]) ? $_POST["idDenda"] : array();
            $i = 0;

            if(!empty($keyFileDenda)){
              foreach ($keyFileDenda as $_key){
                $_pic = $_POST["oldFileDenda" . $_key];
                if(!isset($_FILES['fileDenda' . $_key]['name'])){
                  if($_FILES['fileDenda' . $_key]['size'] > 0){
                    $_pic = $uploaded['fileDenda' . $_key]['file_name'];
                  }
                }
                  $this->ec_open_inv->insertTDenda(array(
                      "ID_INV" => $ID_INVOICE, "ID_DENDA" => $_POST["idDenda"][$i], "NOMINAL" => $_POST["Nominal"][$i],"PIC" => $_pic));
                      $i++;
              }
            }

            $data = array();

            $result = array('status' => 0);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                $result['status'] = 1;
            }
          return $result;
    }

    private function getDetailInvoice($data){
      $this->load->library('sap_invoice');
      $hasil = array('HEADERDATA' => array(),'GLACCOUNTDATA' => array(), 'ITEMDATA' => array(), 'ACCOUNTINGDATA' => array(), 'WITHTAXDATA' => array(), 'TAXDATA' => array());
      $result = $this->sap_invoice->getDetailInvoice($data);
      $hasil['HEADERDATA'] = $result['HEADERDATA'];
      if(!empty($result['GLACCOUNTDATA'])){
        foreach($result['GLACCOUNTDATA'] as $r){
          $tmp = array();
          $tmp['GL_ACCOUNT'] = str_pad($r['GL_ACCOUNT'],10,'0',STR_PAD_LEFT);
          $tmp['NOMINAL'] = $r['ITEM_AMOUNT'];
          $tmp['DB_CR_IND'] = $r['DB_CR_IND'];
          $tmp['COMP_CODE'] = $r['COMP_CODE'];
          $tmp['PROFIT_CTR'] = $r['PROFIT_CTR'];
          $tmp['COSTCENTER'] = $r['COSTCENTER'];
          $tmp['TAX_CODE'] = $r['TAX_CODE'];
          $tmp['ITEM_TEXT'] = $r['ITEM_TEXT'];
          array_push($hasil['GLACCOUNTDATA'],$tmp);
        }
      }
      $_refDocGR = array();
      $_pajakNolPersen = array('VZ');
      if(!empty($result['ITEMDATA'])){
        foreach($result['ITEMDATA'] as $r){
          $grKeyItem = $r['REF_DOC'].'-'.intval($r['REF_DOC_IT']);
          /* jika pajak adalah 0% maka abaikan */
          if(!in_array($r['TAX_CODE'],$_pajakNolPersen)){
            array_push($_refDocGR,$grKeyItem);
          }
          $tmp = array();
          // $tmp['REF_DOC'] = $r['REF_DOC'];
          $tmp['TAX_CODE'] = $r['TAX_CODE'];
          $tmp['INVOICE_DOC_ITEM'] = $r['INVOICE_DOC_ITEM'];
          $tmp['PO_NUMBER'] = $r['PO_NUMBER'];
          $tmp['PO_ITEM'] = $r['PO_ITEM'];

          $tmp['SHEET_NO'] = substr($r['REF_DOC'],0,1) == '1' ? $r['REF_DOC'] : '';
          $tmp['SHEET_ITEM'] = substr($r['REF_DOC'],0,1) == '1' ? str_pad($r['REF_DOC_IT'] * 10, 10, '0', STR_PAD_LEFT) : '';
          $tmp['PO_UNIT'] = $r['PO_UNIT'];

          $tmp['REF_DOC'] = substr($r['REF_DOC'],0,1) != '1' ? $r['REF_DOC'] : '';
          $tmp['REF_DOC_YEAR'] = substr($r['REF_DOC'],0,1) != '1' ? $r['REF_DOC_YEAR'] : '';
          $tmp['REF_DOC_IT'] = substr($r['REF_DOC'],0,1) != '1' ? $r['REF_DOC_IT'] : '';
          $tmp['TAX_CODE'] = $r['TAX_CODE'];
          $tmp['ITEM_AMOUNT'] = $r['ITEM_AMOUNT'];
          $tmp['QUANTITY'] = $r['QUANTITY'];
          $tmp['KEY_ITEM'] = $grKeyItem;

          array_push($hasil['ITEMDATA'],$tmp);
        }
      }

      if(!empty($result['ACCOUNTINGDATA'])){
        foreach($result['ACCOUNTINGDATA'] as $r){
          $tmp = array();
          $tmp['GL_ACCOUNT'] = $r['GL_ACCOUNT'];
          $tmp['INVOICE_DOC_ITEM'] = $r['INVOICE_DOC_ITEM'];

          array_push($hasil['ACCOUNTINGDATA'],$tmp);
        }
      }

      if(!empty($result['WITHTAXDATA'])){
        foreach($result['WITHTAXDATA'] as $r){
          $tmp = array();
          $tmp['WI_TAX_TYPE'] = $r['WI_TAX_TYPE'];
          $tmp['WI_TAX_CODE'] = $r['WI_TAX_CODE'];
          $tmp['WI_TAX_BASE'] = ribuan($r['WI_TAX_BASE']);
          array_push($hasil['WITHTAXDATA'],$tmp);
        }
      }

      if(!empty($result['TAXDATA']) && !empty($_refDocGR)){
        foreach($result['TAXDATA'] as $i => $r){
          if(isset($_refDocGR[$i])){
              $hasil['TAXDATA'][$_refDocGR[$i]] = $r;
          }
        }
      }
      return $hasil;
    }

    private function keyGlArray($allgl){
      $result = array();
      if(!empty($allgl)){
        foreach($allgl as $gl){
          $result[$gl['GL_ACCOUNT']] = $gl['LONG_TEXT'];
        }
      }
      return $result;
    }

    private function isVerifikasi($level){
      $roles = $this->current_roles;
      $result = 0;
      if(!empty($roles)){
        $cari = 'VERIFIKASI '.$level;
        foreach($roles as $r){
          if (strpos($r, $cari) !== false) {
              $result = 1;
          }
        }
      }
      return $result;
    }

    public function getFINumber($data){
      $this->load->library('sap_invoice');
      $y = $this->sap_invoice->getFINumber($data);
      return $y;
    }

    public function notifikasiApprove($id_invoice){
      $this->load->model('invoice/ec_invoice_header', 'eih');
      $this->load->model(array('vnd_header'));
      $_data = $this->eih->as_array()->get($id_invoice);
      $data_vendor = $this->vnd_header->get(array('VENDOR_NO'=>$_data['VENDOR_NO']));
      $data = array(
        'content' => '
            Dokumen approved on '.date('d M Y H:i:s').'<br>
            Nomor PO        : '.$_data['NO_SP_PO'].'<br>
            Nomor Invoice   : '.$_data['NO_INVOICE'].'<br>
            Tanggal Invoice : '.$_data['INVOICE_DATE'].'<br>',
        'title' => 'Invoice '.$_data['NO_INVOICE'].' Approved',
        'title_header' => 'Invoice '.$_data['NO_INVOICE'].' Approved',
      );
			$message = $this->load->view('EC_Notifikasi/approveInvoice',$data,TRUE);
      $_to = $data_vendor['EMAIL_ADDRESS'];
  //    $_to = 'ahmad.afandi85@gmail.com';
      $subject = 'Invoice '.$_data['NO_INVOICE'].' Approved  [E-Invoice Semen Indonesia]';
      Modules::run('EC_Notifikasi/Email/invoiceNotifikasi',$_to,$message,$subject);
    }

    public function notifikasiReject($id_invoice,$alasan_reject = NULL){
      $this->load->model('invoice/ec_invoice_header', 'eih');
      $this->load->model(array('vnd_header'));
      $_data = $this->eih->as_array()->get($id_invoice);
      $data_vendor = $this->vnd_header->get(array('VENDOR_NO'=>$_data['VENDOR_NO']));
      $data = array(
        'content' => '
            Dokumen rejected on '.date('d M Y H:i:s').'<br>
            Nomor PO        : '.$_data['NO_SP_PO'].'<br>
            Nomor Invoice   : '.$_data['NO_INVOICE'].'<br>
            Tanggal Invoice : '.$_data['INVOICE_DATE'].'<br>
            Alasan Reject   : '.$alasan_reject,
        'title' => 'Invoice '.$_data['NO_INVOICE'].' Rejected',
        'title_header' => 'Invoice '.$_data['NO_INVOICE'].' Rejected',
      );
			$message = $this->load->view('EC_Notifikasi/rejectInvoice',$data,TRUE);
      $_to = $data_vendor['EMAIL_ADDRESS'];
//      $_to = 'ahmad.afandi85@gmail.com';
      $subject = 'Invoice '.$_data['NO_INVOICE'].' Rejected  [E-Invoice Semen Indonesia]';
      Modules::run('EC_Notifikasi/Email/invoiceNotifikasi',$_to,$message,$subject);
    }

    public function notifikasiPosting($id_invoice){
      $this->load->model('invoice/ec_invoice_header', 'eih');
      $this->load->model(array('vnd_header'));
      $_data = $this->eih->as_array()->get($id_invoice);
      $data_vendor = $this->vnd_header->get(array('VENDOR_NO'=>$_data['VENDOR_NO']));
      $data = array(
        'content' => '
            Dokumen posted on '.date('d M Y H:i:s').'<br>
            Nomor PO        : '.$_data['NO_SP_PO'].'<br>
            Nomor Invoice   : '.$_data['NO_INVOICE'].'<br>
            Tanggal Invoice : '.$_data['INVOICE_DATE'].'<br>',
        'title' => 'Invoice '.$_data['NO_INVOICE'].' Posted',
        'title_header' => 'Invoice '.$_data['NO_INVOICE'].' Posted',
      );
			$message = $this->load->view('EC_Notifikasi/approveInvoice',$data,TRUE);
      $_to = $data_vendor['EMAIL_ADDRESS'];
  //    $_to = 'ahmad.afandi85@gmail.com';
      $subject = 'Invoice '.$_data['NO_INVOICE'].' Posted  [E-Invoice Semen Indonesia]';
      Modules::run('EC_Notifikasi/Email/invoiceNotifikasi',$_to,$message,$subject);
    }

    public function test(){
      /*$to = array(
        'ahmad.afandi85@gmail.com'
      );
      $_to = implode(',',$to);
      $message = '<b>percobaan</b>';
      $subject = 'judulnya';
      Modules::run('EC_Notifikasi/Email/invoiceNotifikasi',$_to,$message,$subject);*/
    }
    public function scan_faktur(){
      $path = $this->input->get('path');
      $href = $this->input->get('href');
      $nofaktur = $this->input->get('nofaktur');
      // $ext = pathinfo($path, PATHINFO_EXTENSION);
      $data = array('path' => $path, 'href' => $href, 'nofaktur' => $nofaktur);
      $this->load->view('EC_Invoice_ver/scan_faktur',$data);
    }

    public function checkPajak(){
      $result = array('status' => 0, 'message' => 'Faktur pajak belum diverifikasi');
      $this->load->model('invoice/ec_xml_pajak','exp');
      $nofaktur = $this->input->get('no_faktur');
      $ada = $this->exp->get(array('NO_FAKTUR' => $nofaktur));
      //print_r($ada);
      if(!empty($ada)){
        $result['status'] = 1;
      }else{
        /* dapatkan novendor sebagai parameter, apakah termasuk vendor non wapu atau tidak */
        $this->load->model('invoice/ec_invoice_header', 'eih');
        $_venno =  $this->eih->as_array()->get(array('FAKTUR_PJK'=>$nofaktur));
        if(!empty($_venno)){
          $bypassVendor = $this->vendorNonWapu($_venno['VENDOR_NO']);
          if($bypassVendor){
            $result['status'] = 1;
          }
        }
      }
    //  $result['status'] = 1;
      echo json_encode($result);
    }

    public function saveXmlPajak(){
      $this->load->model('invoice/ec_xml_pajak','exp');
      $no_faktur = $this->input->post('NO_FAKTUR');
      $url_faktur = $this->input->post('URL_FAKTUR');
      $xml_faktur = $this->input->post('XML_FAKTUR');
      $_error = 0;
      $maxStr = 3999;
      $panjangXml = strlen($xml_faktur);
      $data = array(
        'NO_FAKTUR' => $no_faktur,
        'URL_FAKTUR' => $url_faktur,
        'XML_FAKTUR' => $xml_faktur
      );
      if($panjangXml > $maxStr){
        $data['XML_FAKTUR'] = substr($xml_faktur,0,$maxStr);
        $data['XML_FAKTUR2'] = substr($xml_faktur,$maxStr,$maxStr);
      }
      $hasil = array('status' => 0, 'message' => 'gagal insert');
      if(empty($xml_faktur)){
          $hasil['message'] = 'xml faktur masih kosong, jika sudah terisi klik simpan lagi';
          $_error++;
      }
      $ada = $this->exp->get(array('NO_FAKTUR' =>$no_faktur));
      if(!$_error){
        if(empty($ada)){
          if($this->exp->insert($data)){
            @$this->saveXmlPajakSAP($xml_faktur);
            $hasil['status'] = 1;
            $hasil['message'] = 'berhasil insert';
          }
        }else{
            $hasil['message'] = 'sudah diisi';
        }
      }

      echo json_encode($hasil);
    }

    public function getXmlPajak(){
      $url = $this->input->get('url');
     //  echo $url;
      echo file_get_contents($url);
      //echo file_get_contents('http://svc.efaktur.pajak.go.id/validasi/faktur/017924655043000/0171753354463/93b390cabba8a550b9916b92c79bdcd70fbba9c0894887eb393fd0f9fb84a3bb');

    }

    public function saveXmlPajakSAP($_xml){
       $this->load->library('sap_invoice');
       $xml = simplexml_load_string($_xml);
       $_mapping = array(
           'nomorFaktur' => 'XBLNR',
           'tanggalFaktur' => 'BLDAT',
           'npwpPenjual' => 'STCD1',
           'namaPenjual' => 'NAME1',
           'alamatPenjual' => 'ALAMAT',
           'npwpLawanTransaksi' => 'NPWPLAWAN',
           'namaLawanTransaksi' => 'NAMALAWAN',
           'jumlahDpp' => 'HWBAS',
           'jumlahPpn' => 'HWSTE',
           'jumlahPpnBm' => 'PPNBN',
           'statusApproval' => 'STATAPP',
           'statusFaktur' => 'STATFAKTUR'
       );
       $_tambahanMap = array(
           'kdJenisTransaksi' => 'jenis',
           'fgPengganti' => 'pengganti'
       );
       $_per100 = array(
           'jumlahDpp',
           'jumlahPpn',
           'jumlahPpnBm'
       );
       $tambahan = array();
       $result = array('HWAER' => 'IDR');
       foreach($xml as $_a => $_x){
           $index = isset($_mapping[$_a]) ? $_mapping[$_a] : '';
           if(!empty($index)){
               $nilainya = $_x->__toString();
               if($index == 'BLDAT'){
                 $tglnya = explode('/',$_x->__toString());
                 $nilainya = implode('',array_reverse($tglnya));
               }
               if(in_array($_a,$_per100)){
                   $nilainya = !empty($nilainya) ? $nilainya / 100 : $nilainya;
               }
               $result[$index] = $nilainya;
           }
           $indextambahan = isset($_tambahanMap[$_a]) ? $_tambahanMap[$_a] : '';
           if(!empty($indextambahan)){
               $tambahan[$indextambahan] = $_x->__toString();
           }
       }
       $result['XBLNR'] = $tambahan['jenis'].$tambahan['pengganti'].$result['XBLNR'];

       $input = array(
                 'EXPORT_PARAM_ARRAY' => array('T_INPUT' => $result)
       );
       $output = array(
                 'EXPORT_PARAM_ARRAY' => array('T_INPUT')
       );
       $this->sap_invoice->callFunction('ZCFISAVE_TAXQRCODE',$input,$output);
     }

    public function dataSimulate(){
        $this->load->model('ec_invoice_m', 'inc');
        $this->load->model('invoice/ec_gr','gr');
        $this->load->model('invoice/ec_gr_sap','gr_sap');
        $this->load->model('ec_open_inv');
        $this->load->model('invoice/ec_m_denda_inv','mdenda');
        $this->load->model('invoice/ec_t_denda_inv','tdenda');

        /*Menyiapkan data Header*/
        $header = $this->input->post('header'); // Get header data
        $data = $this->inc->getINV($header['ID_INVOICE']);
        foreach($data as $val){
            $header['INVOICE_IND'] = 'X';
            $header['COMP_CODE'] = $val['COMPANY_CODE'];
            $header['CURRENCY'] = $val['CURRENCY'];
            $header['HEADER_TXT'] = $val['NOTE'];
            $header['ITEM_CAT'] = $val['ITEM_CAT'];
            $header['PMNTTRMS'] = 'ZG45';
            $header['PSTNG_DATE'] = implode('',array_reverse(explode('/',$header['PSTNG_DATE'])));
            $header['BLINE_DATE'] = implode('',array_reverse(explode('/',$header['BLINE_DATE'])));
            $header['DOC_DATE'] = implode('',array_reverse(explode('/',$header['DOC_DATE'])));
            $header['REF_DOC_NO'] = clean($header['REF_DOC_NO']);

            $amount = clean($header['GROSS_AMOUNT']);
            $header['GROSS_AMOUNT'] = $amount;
        }

        /*Menyiapkan data Item GR*/
        $gr = $this->gr->as_array()->get_all(array('INV_NO' => $header['ID_INVOICE']));
        $pajakGr = $this->input->post('pajak_gr');
        $amountSAP = $this->input->post('amountSAP');

        foreach ($gr as $value) {
           $grKeyItem = $value['GR_NO'].'-'.$value['GR_ITEM_NO'];
           $_refDoc = $value['GR_NO'].'-'.$value['GR_ITEM_NO'];
           $jmlAmountSAP = str_replace('.', '', $amountSAP[$grKeyItem]);
           $dataGR[] = array("PO_NO" => $value['PO_NO'], "PO_ITEM_NO" => $value['PO_ITEM_NO'], "GR_NO" => $value['GR_NO'], "GR_YEAR" => $value['GR_YEAR'], "GR_ITEM_NO" => $value['GR_ITEM_NO'], "GR_AMOUNT_IN_DOC" => $jmlAmountSAP, "GR_ITEM_QTY" => $value['GR_ITEM_QTY'], "UOM" => $value['GR_ITEM_UNIT'], "TAX_CODE" => $pajakGr[$grKeyItem]);
        }
        //var_dump($dataGR);die();

        /*menyiapkan data WTAX Holding*/
        $dataPajak = $this->input->post('WTAX_CODE');
        $taxType = $this->input->post('WTAX_TYPE');
        $taxAmount = $this->input->post('WTAX_AMOUNT');

        $pajakPosting = array();
        if(!empty($dataPajak)){
            foreach($dataPajak as $i => $dpk){
                if(!empty($dpk)){
                    array_push($pajakPosting,array('TAX_CODE' => $dpk,'WTAX_TYPE' => $taxType[$i], 'AMOUNT' => clean($taxAmount[$i])));
                }
            }
        }
        //var_dump($pajakPosting);die();

        /*menyiapkan data GL Account*/
        $GLAccount = array();
        $glaccountTambahan = $this->input->post('noglaccount');
        $glaccountPajak = $this->input->post('pajakGL');
        $glaccountNominal = $this->input->post('nilai_glaccount');
        $glaccountDebetKredit = $this->input->post('fileGL');
        $glaccountCostCenter = $this->input->post('costcenter');
        $glaccountProfitCenter = $this->input->post('profit_ctr');
        if(!empty($glaccountTambahan)){
          foreach($glaccountTambahan as $i => $glt){
              $_profitcenterSAP = !empty($glaccountProfitCenter[$i]) && $glaccountProfitCenter[$i] != 'DUMMY' ? str_pad($glaccountProfitCenter[$i],10,0,STR_PAD_LEFT) : $glaccountProfitCenter[$i];
              $GLAccount[] = array('AMOUNT' => $glaccountNominal[$i],'PROFIT_CTR' => $_profitcenterSAP,'COSTCENTER' => $glaccountCostCenter[$i],'GLACCOUNT' => $glt,'DB_CR_IND' => $glaccountDebetKredit[$i],'TAX_CODE' => $glaccountPajak[$i]);
          }
        }
        //var_dump($GLAccount);die();

        /*Tax data ketika calculate tax secara manual*/
        $taxData = array();
        if($header['CALC_TAX_IND'] == ''){
          $taxBaseAmountSAP = $this->input->post('taxBaseAmountSAP');
          $taxAmountSAP = $this->input->post('taxAmountSAP');
          $pajak_grSAP = $this->input->post('pajak_gr');

          foreach($taxBaseAmountSAP as $i => $_tax){
            $_taxAmount = str_replace('.','',$taxAmountSAP[$i]);
            $_taxBaseAmount = str_replace('.','',$_tax);
            $tmp = array('TAX_CODE' => $pajak_grSAP[$i],'TAX_AMOUNT' => $_taxAmount, 'TAX_BASE_AMOUNT' => $_taxBaseAmount);
            array_push($taxData,$tmp);
          }
        }

        //var_dump($taxData);

        $this->load->library('sap_invoice');
        $data = $this->sap_invoice->getSimulateData($header,$dataGR,$pajakPosting,$GLAccount,$taxData,true);
        //var_dump($data);

        $acccit = isset($data['FT_ACCIT']) ? $data['FT_ACCIT'] : null;
        $gla_list = isset($data['FT_GLA_LIST']) ? $data['FT_GLA_LIST'] : null;
        $status = isset($data['STATUS']) ? $data['STATUS'] : null;

        $gr_sap = $this->gr_sap->as_array()->get_all(array('BELNR' => $gr[0]['GR_NO']));
        $vendor = $gr_sap[0]['LIFNR'].' - '.$gr_sap[0]['NAME1'];

        $hasil = array(array('STATUS' => 1));
        $debit = 0;
        $kredit = 0;
        //var_dump($status);die();

        if($status == null){
            $gl = array();
            $ref = array();
            for ($i=0; $i < count($acccit); $i++) {
                for ($l=0; $l < count($gla_list); $l++) {
                    /*SPRAS = E = B. Inggris,SPRAS = i = B. Indoneisa*/
                    if($acccit[$i]['HKONT'] == $gla_list[$l]['SAKNR'] AND $gla_list[$l]['SPRAS'] == 'E'){
                        //Mengumpulkan data GL
                        $gl[] = $acccit[$i]['HKONT'];
                        $ref[] = $acccit[$i]['XREF3'];

                        $hasil[$i+1]['GL'] = $gla_list[$l]['SAKNR'];
                        $hasil[$i+1]['ACCC_TYPE'] = $acccit[$i]['KOART'];
                        $hasil[$i+1]['DESC'] = $acccit[$i]['KOART'] == 'K' ? $vendor : $gla_list[$l]['TXT50'];
                        $temp = str_replace('-','',$acccit[$i]['PSWBT']);
                        $hasil[$i+1]['AMOUNT'] = ribuan($temp*100);
                        $hasil[$i+1]['CURRENCY'] = $acccit[$i]['PSWSL'];
                        $hasil[$i+1]['TAX_CODE'] = $acccit[$i]['MWSKZ'];
                        $hasil[$i+1]['DC'] = $acccit[$i]['SHKZG'];

                        if($hasil[$i+1]['DC'] == 'S'){
                            $debit += $temp*100;
                        }else if($hasil[$i+1]['DC'] == 'H'){
                            $kredit += $temp*100;
                        }
                        break;
                    }
                }
            }
            $hasil[0]['DEBIT'] = ribuan($debit);
            $hasil[0]['KREDIT'] = ribuan($kredit);
            $hasil[0]['BL'] = 1;

            $hitungGL = array_count_values($gl);
            $jumlahRef = count(array_filter($ref));

            //var_dump($hitungGL);die();
            if($jumlahRef != count($dataGR)){
                $hasil[0]['BL'] = 0;
            }

            if($hitungGL['0021290001'] != count($dataGR)){
                $hasil[0]['BL'] = 0;
            }

        }else{
            $hasil[0]['STATUS'] = 0;
            $hasil[0]['ERROR'] = '
                <thead>
                    <tr>
                        <th class="text-center">Type</th>
                        <th class="text-center">ID</th>
                        <th class="text-center">Number</th>
                        <th class="text-center">Message</th>
                    </tr>
                </thead>
                <tbody>
                ';
            for ($i=0; $i < count($status); $i++) {
                $hasil[0]['ERROR'] .= '<tr>
                        <td>'.$status[$i]['TYPE'].'</td>
                        <td>'.$status[$i]['ID'].'</td>
                        <td>'.$status[$i]['NUMBER'].'</td>
                        <td>'.$status[$i]['MESSAGE'].'</td>
                    </tr>';
            }
            $hasil[0]['ERROR'] .= '</tbody>';
        }
        echo json_encode($hasil);
    }

    public function cancelInvoice(){
      $this->load->model('invoice/ec_invoice_header', 'eih');
      $this->load->model('invoice/ec_log_invoice_cancel', 'elc');
      $nomerMir = $this->input->post('mir');
      $tahun = $this->input->post('tahun');
      $alasan = $this->input->post('alasan_reject');

      $this->db->trans_begin();
      $invoice = $this->eih->get(array('INVOICE_SAP' => $nomerMir,'FISCALYEAR_SAP' => $tahun));
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
      redirect("EC_Invoice_ver/formCancelInvoice");
    }

    public function formCancelInvoice(){
      $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
      $this->layout->add_css('plugins/select2/select2.min.css');
      $this->layout->add_css('pages/invoice/common.css');
      $this->layout->add_js('select2.min.js');
      $this->layout->add_js('jquery.alphanum.js');

      $data['title'] = "Cancel Invoice Park";
      $this->layout->render('cancelFormInvoice',$data);
    }

    public function vendorNonWapu($venno){
      $this->load->model('invoice/ec_vendor_non_wapu','ewapu');
      $_tmp = $this->ewapu->fields('VENDOR_NO')->as_array()->get(array('VENDOR_NO' => $venno));
      $result = empty($_tmp) ? 0 : 1;
      return $result;
    }

    public function getAmountVendor($company,$noDocument,$tahun){
      $this->load->library('sap_invoice');
      $param = array();
      $param['I_BUKRS'] = $company;
      $param['I_BELNR_FROM'] = $noDocument;
      $param['I_GJAHR'] = $tahun;
      $t = $this->sap_invoice->getListAccountingDocument($param);
      /* ambil baris pertama saja */
      return !empty($t) ? $t[0] : array();
    }

    public function getIdSAP($email){
        $this->load->model('ec_master_inv');
        $mapping = $this->ec_master_inv->getMappingUser($email);

        $result =  $email;

        if(!empty($mapping)){
            $result = $mapping['ID_SAP'];
        }
        return $result;
    }

    public function checkParcial($idinvoice){
      $sql = '
        SELECT A.INV_NO FROM (
          SELECT ROWNUM NOMER ,D.* FROM (
            SELECT * FROM EC_GR GR WHERE GR_NO IN (
              SELECT GR_NO FROM EC_INVOICE_HEADER EIH
                JOIN EC_GR EG
                ON EG.INV_NO = EIH.id_invoice
              WHERE ID_INVOICE = '.$idinvoice.'
            ) ORDER BY INV_NO
          )D
        )A WHERE NOMER = 1';
      $res = $this->db->query($sql,false)->row_array();
      
      $ref_fp = $this->db->select('ID_INVOICE,FAKTUR_PJK,FAKPJK_PIC')->where('ID_INVOICE',$res['INV_NO'])->get('EC_INVOICE_HEADER')->row_array();

      $data['status'] = $idinvoice == $res['INV_NO'] ? 0 : 1;
      $data['ref_fp'] = $ref_fp['FAKTUR_PJK'];
      $data['ref_fp_pic'] = $ref_fp['FAKPJK_PIC'];
      return $data;
    }

    private function checkPomut($no_ba){
        $arr_ba = explode(',', $no_ba);
        $arr_ba = array_unique($arr_ba);
        return $this->db->where_in('NO_BA',$arr_ba)->get('EC_POMUT_HEADER_SAP')->result_array();
    }

    private function checkLot($idinvoice){
        $sql = "
        SELECT DISTINCT * FROM ( 
            SELECT EGL.LOT_NUMBER,PRINT_TYPE FROM EC_GR EG
            JOIN EC_GR_STATUS EGS 
                ON EG.GR_NO = EGS.GR_NO
            JOIN EC_GR_LOT EGL 
                ON EGS.LOT_NUMBER = EGL.LOT_NUMBER
            WHERE INV_NO = $idinvoice
        )";
        return $this->db->query($sql,false)->result_array();
    }
}
