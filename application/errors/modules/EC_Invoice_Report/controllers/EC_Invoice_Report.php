<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Invoice_Report extends CI_Controller {

    private $user;

    public function __construct() {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->user = $this->session->userdata('FULLNAME');
        $this->load->model('invoice/ec_role_user', 'role_user');
        $email_login = explode('@', $this->session->userdata('EMAIL'));
        $this->current_roles = array();
        $_tmp = $this->role_user->get_all(array('USERNAME' => $email_login[0], 'STATUS' => 1));
        if(!empty($_tmp)){
          foreach($_tmp as $_t){
              array_push($this->current_roles,$_t->ROLE_AS);
          }
        }
    }

    public function index($cheat = false) {
        $data['title'] = "Invoice Report";
        $data['cheat'] = $cheat;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('pages/invoice/EC_Invoice_Report.js');

        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');
        $this->layout->add_css('pages/invoice/common.css');

        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');
        $this->layout->add_js('excellentexport.min.js');


        $this->load->model('ec_master_inv');
        $this->load->model('invoice/ec_m_pajak_inv', 'pajak');
        $this->load->model('invoice/ec_m_denda_inv', 'denda');
        $this->load->model('invoice/ec_m_doc_inv', 'doc');
        $wherePajak = "ID_JENIS IN ('VQ', 'VZ','V5', 'VN', 'VT', 'WN', 'WT')";
        $data['pajak'] = $this->db->where($wherePajak)->get('EC_M_PAJAK_INV')->result_array();
        $data['denda'] = $this->denda->as_array()->get_all();
        $data['doc'] = $this->doc->as_array()->get_all();
        // $data['denda'] = $this->ec_master_inv->getDenda();
        // $data['doc'] = $this->ec_master_inv->getDoc();
        /* dapatkan daftar bank dari vendor */
        $data['defaultPajak'] = 'VZ';

        $this->layout->render('list', $data);
    }

    function Get_all_invoice(){
        header('Content-Type: application/json');
        $this->load->model('ec_open_inv');
        $dt = array();
        $era = $this->db->select(array('ROLE_AS','VALUE','OBJECT_AS'))->where('OBJECT_AS = \'COMPANY_CODE\' AND ROLE_AS in (\''.implode('\',\'',$this->current_roles).'\') AND ROLE_AS LIKE \'COMPANY CODE%\'')->get('EC_ROLE_ACCESS')->result_array();
        $company_code = array();
        foreach($era as $e){
          array_push($company_code,$e['VALUE']);
        }
        $whereStr = 'where COMPANY_CODE in ('.implode(',',$company_code).')';
        $dataa = $this->ec_open_inv->get_Invoice($whereStr,'ORDER BY EIH.CHDATE DESC');

        $kirim = array();
        for ($i = 0; $i < sizeof($dataa); $i++) {
            $dt['NO'] = $i + 1;
            $dt['INVOICE_DATE'] = $dataa[$i]['INVOICE_DATE2'];
            $dt['NO_INVOICE'] = $dataa[$i]['NO_INVOICE'];
            $dt['VEND_NAME'] = $dataa[$i]['VEND_NAME'];
            $dt['NO_SP_PO'] = $dataa[$i]['NO_SP_PO'];
            //$dt['FAKTUR_PJK'] = $dataa[$i]['FAKTUR_PJK'];
            $dt['TOTAL_AMOUNT'] = $dataa[$i]['TOTAL_AMOUNT'];
            $dt['CHDATE'] = $dataa[$i]['CHDATE2'];
            $dt['STATUS_HEADER'] = $dataa[$i]['STATUS_HEADER'];
            $dt['INVOICE_PIC'] = $dataa[$i]['INVOICE_PIC'];
            //$dt['FAKPJK_PIC'] = $dataa[$i]['FAKPJK_PIC'];
            $dt['ID_INVOICE'] = $dataa[$i]['ID_INVOICE'];
            $dt['CURRENCY'] = $dataa[$i]['CURRENCY'];
            $dt['INVOICE_SAP'] = $dataa[$i]['INVOICE_SAP'];
            $dt['FISCALYEAR_SAP'] = $dataa[$i]['FISCALYEAR_SAP'];
            $dt['STATUS_DOC'] = $dataa[$i]['STATUS_DOC'];
            $dt['POSISI'] = $dataa[$i]['POSISI'];
            $dt['FI_NUMBER_SAP'] = $dataa[$i]['FI_NUMBER_SAP'];
            $kirim[] = $dt;
        }
        $json_data = array('data' => $kirim);
        echo json_encode($json_data);
        //var_dump($dataa);
        //var_dump($json_data);
    }

    public function detail($noinvoice = '1234567890') {
        $data['title'] = "Detail Invoice";
        $data['status'] = $this->uri->segment(4);
        $data['noinvoice'] = $noinvoice;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');
        $this->layout->add_css('pages/EC_checkout.css');
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');

        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('pages/invoice/EC_Detail_Report.js');
        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');
        $this->layout->add_js('bootbox.js');

        $this->load->model('ec_master_inv');
        /*
        $data['pajak'] = $this->ec_master_inv->getPajak();
        $data['denda'] = $this->ec_master_inv->getDenda();
        $data['doc'] = $this->ec_master_inv->getDoc();
        */

        $this->load->model('invoice/ec_m_pajak_inv', 'pajak');
        $this->load->model('invoice/ec_m_denda_inv', 'denda');
        $this->load->model('invoice/ec_m_doc_inv', 'doc');

        $wherePajak = "ID_JENIS IN ('VQ', 'VZ', 'V5', 'VN', 'VT', 'WN', 'WT') AND STATUS = 1";
        $data['pajak'] = $this->db->where($wherePajak)->get('EC_M_PAJAK_INV')->result_array();
        $data['denda'] = $this->denda->as_array()->get_all(array('STATUS' => 1));
        $data['doc'] = $this->doc->as_array()->get_all(array('STATUS' => 1));

        $this->load->model('invoice/ec_gr','gr');
        $this->load->model('ec_open_inv');
        $this->load->model('invoice/ec_invoice_header','e_header');

        /* dapatkan no_po untuk memperoleh list gr */
        $data['GR'] = $this->gr->as_array()->get_all(array('INV_NO' => $noinvoice));
        $data['invoice'] = $this->ec_open_inv->getIvoice($noinvoice);
        $data['Tdoc'] = $this->ec_open_inv->getDoc($noinvoice);
        $data['Tdenda'] = $this->ec_open_inv->getDenda($noinvoice);

        $venno = $data['invoice'][0]['VENDOR_NO'];
        $status_header = $data['invoice'][0]['STATUS_HEADER'];
        $data['accountingDocument'] = '';
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

        if($status_header >= 5 ){
//          echo "<pre>";
//          print_r($data);
//          echo "</pre>";exit;
          $noDocument = $data['invoice'][0]['FI_NUMBER_SAP'];
          $tahun = $data['invoice'][0]['FI_YEAR'];
          $company = $data['invoice'][0]['COMPANY_CODE'];
          $t = $this->getListAccountingDocument($noDocument,$tahun,$company);
          $data['accountingDocument'] = $this->load->view('accountingDocument',array('list' => $t),TRUE);
        }
        $data['listBank'] = $this->listBankVendor($venno);
        //var_dump($data);

        /*Approval Invoice*/
        $data['status_approval'] = $this->input->post('status_approval');
        $data['total_payment'] = $this->input->post('total_payment');

        /*Note Reject*/
        $this->load->model('invoice/ec_approval_invoice','eai');
        $data['approval'] = $this->eai->as_array()->get_all(array('ID_INVOICE' => $noinvoice));
        $data['parcial'] = $this->checkParcial($noinvoice);
        $data['lot'] = $this->checkLot($noinvoice);
        $data['pomut'] = $this->checkPomut($data['invoice'][0]['POT_MUTU']);
        $this->layout->render('detail', $data);
    }

    private function listBankVendor($venno){
      $this->load->library('sap_handler');
      return $this->sap_handler->getListBankVendor($venno);
    }

    public function get_data() {
        header('Content-Type: application/json');
        $this->load->model('ec_open_inv');
        $venno = $this->session->userdata['VENDOR_NO'];
        //  $venno = "0000112709";
        $dataa = $this->ec_open_inv->getMan($venno);
        $json_data = array('data' => $dataa);
        echo json_encode($json_data);
    }

    /* Kurang No_Nomer*/
     public function get_data_detail($noinvoice = '1234567890',$venno = '000') {
        $data['title'] = "Detail Management";
        $status = $this->uri->segment(5);

        // $venno = "0000410000";
        $this->load->model('invoice/ec_gr','gr');
        $this->load->model('ec_open_inv');
        /* dapatkan no_po untuk memperoleh list gr */
        $gr = $this->gr->as_array()->get_all(array('INV_NO' => $noinvoice));
        $dataa = array();
        if(!empty($gr)){
           // $dataa = $this->ec_open_inv->getGREdit($gr->PO_NO);
        }

        $json_data = array('data' => $gr);
        echo json_encode($json_data);
    }

    public function getListAccountingDocument($noDocument,$tahun,$company){
      $this->load->library('sap_invoice');
      $param = array();
      $param['I_BUKRS'] = $company;
      $param['I_BELNR_FROM'] = $noDocument;
      $param['I_GJAHR'] = $tahun;
      $t = $this->sap_invoice->getListAccountingDocument($param);
      $result = array();
      foreach($t as $_t){
        $sign = $_t['SHKZG'] == 'H' ? 'minus' : 'plus';
        $desc = '';
        if($_t['KOART'] != 'K'){
          $desc = $this->getGlDesc($_t['BUKRS'],$_t['HKONT']);
        }else{
          $desc = array('LONG_TEXT' => $this->getVendorName($_t['LIFNR']));
        }
        $tmp = array(
          'DEBET/KREDIT' => $_t['SHKZG'],
      //    'PROFIT_CENTER' => $_t['PRCTR'],
          'ITEM' => $_t['BUZEI'],
          'PK' => $_t['BSCHL'],
          'ACCOUNT' => $_t['KOART'] == 'K' ? $_t['LIFNR'] : $_t['HKONT'],
          'DESCRIPTION' => $desc['LONG_TEXT'],
          'CURRENCY' => $_t['WAERS'],
          'AMOUNT' => $_t['WAERS'] == 'IDR' ? accountingFormat($_t['WRBTR'] * 100, $sign) : accountingFormat($_t['WRBTR'], $sign),
          'AMOUNT_IN_LOCAL' => $_t['WAERS'] == 'IDR' ? accountingFormat($_t['DMBTR'] * 100, $sign) : accountingFormat($_t['DMBTR'], $sign),
          'TAX_CODE' => $_t['MWSKZ']
        //  'TAX_HOLDING' => $_t['KOART'] == 'K' ? '' : $_t['QSSKZ']
          // 'TEXT' => $_t['SGTXT']
        );
        array_push($result,$tmp);
      }
      return $result;
    }

    public function viewAccountingDocument(){
      $noDocument = $this->input->get('noDocument');
      $tahun = $this->input->get('tahun');
      $company = $this->input->get('company');
      $param = array();

      $t = $this->getListAccountingDocument($noDocument,$tahun,$company);
      $this->load->view('accountingDocument',array('list' => $t));
    }

    public function getGlDesc($comp,$gl){
      $this->load->library('sap_invoice');
      $t = $this->sap_invoice->getGlDesc($comp,$gl);
      return $t;
    }

    public function getVendorName($vendor_no){
      $t = $this->db->select(array('NAME1'))->where(array('LIFNR'=>$vendor_no))->limit(2)->get('EC_GR_SAP')->row_array();
      return $t['NAME1'];
    }

    public function getFINumber($data){
      $this->load->library('sap_invoice');
      $y = $this->sap_invoice->getFINumber($data);
      return $y;
    }


    /*FUNGSI TAMBAHAN UNTUK REPORT JUMLAH GR DAN */
    public function otherReport(){
        $defaultCompany = 7;
        $l = $this->input->post('company');
        $company = empty($l) ?  7 : implode(',',$l);
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('chart.min.js');
        $this->layout->add_js('pages/invoice/EC_Other_Report.js');

        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');
        $this->layout->add_css('pages/invoice/common.css');

        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');


        $data['listCompany'] = array(
          '2' => 'Semen Indonesia',
          '5' => 'Semen Gresik',
          '7' => 'KSO'
        );
        $arrCompany = explode(',',$company);
        $data['company'] = $arrCompany;
        $data['Chart'] = $this->dataGB($company);
        $data['Inv'] = $this->dataInvoice($company);
        $data['Cou'] = $this->countInvoice($company);
        $data['Stat'] = $this->countInvByStatus($company);
        $namaCompany = array();
        foreach($arrCompany as $rc){
          array_push($namaCompany,$data['listCompany'][$rc]);
        }
        $data['title'] = "Report ".implode(' , ',$namaCompany);
        $this->layout->render('other', $data);
    }

   public function dataOtherReport(){
      $_company = $this->input->post('company');
      $company = array();
      foreach($_company as $c){
        array_push($company,$c['value']);
      }
      $company = implode(',',$company);
      $query = "
        SELECT NAME1
          ,SUM(J) AS JUM_GR
          ,SUM(J_I) AS JUM_INV
          ,JENIS
        FROM(
          SELECT NAME1
          ,CASE
            WHEN JENIS = '66' THEN 'JASA'
          ELSE 'BARANG' END JENIS
          ,J
          ,J_I
          FROM(
            SELECT NAME1
              ,COUNT(EBELN) AS J
              ,COUNT(INV_NO) AS J_I
              ,SUBSTR(EBELN,0,2) AS JENIS
            FROM EC_GR_SAP
            WHERE VGABE = '1'
              AND
                WERKS IN (
                  SELECT PLANT FROM EC_INVOICE_PLANT WHERE STATUS = 1 AND substr(PLANT,1,1) in (".$company.")
                )
              AND
                EKGRP IN (
                  SELECT PRCHGRP FROM EC_INVOICE_PRCHGRP
                )
            GROUP BY NAME1,SUBSTR(EBELN,0,2)
          )
        )GROUP BY NAME1,JENIS ORDER BY NAME1
      ";

      $result = array('data'=> $this->db->query($query)->result_array());

      echo json_encode($result);
    }

    public function dataGB($company){
      $query = "
        SELECT JENIS, SUM(JUM) AS TOTAL FROM(
          SELECT NAME1, SUM(JUMLAH) AS JUM, JENIS FROM(
            SELECT NAME1
              ,CASE
                WHEN JENIS = '66' THEN 'JASA'
              ELSE 'BARANG' END JENIS
              ,JUMLAH
            FROM(
              SELECT NAME1,COUNT(EBELN) AS JUMLAH,SUBSTR(EBELN,0,2) AS JENIS
              FROM EC_GR_SAP
              WHERE VGABE = '1'
                AND
                WERKS IN (
                  SELECT PLANT FROM EC_INVOICE_PLANT WHERE STATUS = 1 AND substr(PLANT,1,1) in (".$company.")
                )
              AND
                EKGRP IN (
                  SELECT PRCHGRP FROM EC_INVOICE_PRCHGRP
                )
              GROUP BY NAME1,SUBSTR(EBELN,0,2)
            )
          )GROUP BY NAME1,JENIS ORDER BY NAME1
        )GROUP BY JENIS ORDER BY JENIS";

      return $this->db->query($query)->result_array();
    }

    public function dataInvoice($company){
      $query = "
        SELECT EBELN AS JENIS, COUNT(EBELN) AS JUMLAH
        FROM(
          SELECT
            CASE
              WHEN SUBSTR(EBELN,0,2) = '66' THEN 'JASA'
            ELSE 'BARANG' END EBELN
          FROM(
              SELECT * FROM EC_GR_SAP
              WHERE INV_NO IS NOT NULL
                AND VGABE = '1'
                AND
                  WERKS IN (
                    SELECT PLANT FROM EC_INVOICE_PLANT WHERE STATUS = 1 AND substr(PLANT,1,1) in (".$company.")
                  )
                AND
                  EKGRP IN (
                    SELECT PRCHGRP FROM EC_INVOICE_PRCHGRP
                  )
          )
        ) GROUP BY EBELN ORDER BY EBELN";

      return $this->db->query($query)->result_array();
    }

    public function countInvoice($company){
      $query = "
        SELECT NO_SP_PO AS JENIS, COUNT(NO_SP_PO) AS JUMLAH
          FROM(
            SELECT
              CASE
                WHEN SUBSTR(NO_SP_PO,0,2) = '66' THEN 'JASA'
              ELSE 'BARANG' END NO_SP_PO
            FROM(
              SELECT * FROM EC_INVOICE_HEADER WHERE substr(COMPANY_CODE,1,1) in (".$company.")
          )
        )GROUP BY NO_SP_PO ORDER BY JENIS
      ";
      return $this->db->query($query)->result_array();
    }

    public function countInvByStatus($company){
      $query = "
        SELECT STATUS_HEADER, COUNT(STATUS_HEADER) JUMLAH,
          CASE
            WHEN STATUS_HEADER = '1' THEN 'DRAFT'
            WHEN STATUS_HEADER = '2' THEN 'SUBMIT'
            WHEN STATUS_HEADER = '3' THEN 'APPROVE'
            WHEN STATUS_HEADER = '4' THEN 'REJECT'
            WHEN STATUS_HEADER = '5' THEN 'POSTED'
            WHEN STATUS_HEADER = '6' THEN 'PAID'
          END STATUS
        FROM
          EC_INVOICE_HEADER WHERE substr(COMPANY_CODE,1,1) in (".$company.")
        GROUP BY STATUS_HEADER
        ORDER BY STATUS_HEADER
      ";
      return $this->db->query($query)->result_array();
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
