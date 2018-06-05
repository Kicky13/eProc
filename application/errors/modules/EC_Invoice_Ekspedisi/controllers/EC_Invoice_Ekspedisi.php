<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Invoice_Ekspedisi extends MX_Controller {

    private $user;
    private $user_email;
    public function __construct() {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->user = $this->session->userdata('FULLNAME');
        $this->user_email = $this->session->userdata('EMAIL');
    }

    public function index($cheat = false) {
        $data['title'] = "Ekspedisi Bendahara";
        $data['cheat'] = $cheat;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('pages/invoice/EC_Invoice_Ekspedisi.js');

        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');
        $this->layout->add_css('pages/invoice/common.css');

        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');
        $this->layout->add_js('bootbox.js');

        $data['reject'] = $this->countInvoiceReject();

        $this->layout->render('list', $data);
    }

    function Get_all_invoice($status_approval = ''){
        header('Content-Type: application/json');
        $this->load->model('invoice/ec_approval_invoice');
        $dt = array();
        $roleVerifikasi = $this->getCurrentRoleVerifikasi(2);
        $item_cat = $this->roleAccess($roleVerifikasi,'ITEM_CAT');
        $company_code = $this->roleAccess($roleVerifikasi,'COMPANY_CODE');
        $str_item_cat = !empty($item_cat) ? ' AND ITEM_CAT in ('.$item_cat.') AND COMPANY_CODE in ('.$company_code.')': '';

        $filter_approval = " WHERE AI.STATUS = '3'";

        if($status_approval=='0'){
          $filter_approval = " WHERE AI.STATUS IN ('2','1','0')";
        }else if($status_approval == '4'){
          $filter_approval = " WHERE AI.STATUS = '4'";
        }

         $dataa = $this->ec_approval_invoice->get_Invoice($filter_approval.$str_item_cat," ORDER BY EIH.CHDATE DESC");

        $kirim = array();
        for ($i = 0; $i < sizeof($dataa); $i++) {
            $dt['NO'] = $i + 1;
            $dt['INVOICE_DATE'] = $dataa[$i]['INVOICE_DATE2'];
            $dt['NO_INVOICE'] = $dataa[$i]['NO_INVOICE'];
            $dt['VEND_NAME'] = $dataa[$i]['VEND_NAME'];
            $dt['NO_SP_PO'] = $dataa[$i]['NO_SP_PO'];
            $dt['TOTAL_AMOUNT'] = $dataa[$i]['TOTAL_AMOUNT'];
            $dt['CHDATE'] = $dataa[$i]['CHDATE2'];
            $dt['STATUS_HEADER'] = $dataa[$i]['STATUS_HEADER'];
            $dt['INVOICE_PIC'] = $dataa[$i]['INVOICE_PIC'];
            $dt['ID_INVOICE'] = $dataa[$i]['ID_INVOICE'];
            $dt['CURRENCY'] = $dataa[$i]['CURRENCY'];
            $dt['INVOICE_SAP'] = $dataa[$i]['INVOICE_SAP'];
            $dt['FISCALYEAR_SAP'] = $dataa[$i]['FISCALYEAR_SAP'];
            $dt['FI_NUMBER_SAP'] = $dataa[$i]['FI_NUMBER_SAP'];
            $dt['FI_YEAR'] = $dataa[$i]['FI_YEAR'];
            $dt['COMPANY_CODE'] = $dataa[$i]['COMPANY_CODE'];
            $dt['STATUS_APPROVAL'] = $dataa[$i]['STATUS_APPROVAL'];
            $dt['TGL_APPROVAL'] = $dataa[$i]['TGL_APPROVAL'];
            $dt['APPROVAL'] = $dataa[$i]['APPROVAL'];
            $kirim[] = $dt;
        }
        $json_data = array('data' => $kirim);
        echo json_encode($json_data);
    }

    public function setApprovedInvoice(){
        $this->load->model('invoice/ec_approval_invoice');
        $dt = array();
        $roleVerifikasi = $this->getCurrentRoleVerifikasi(2);
        $item_cat = $this->roleAccess($roleVerifikasi,'ITEM_CAT');
        $company_code = $this->roleAccess($roleVerifikasi,'COMPANY_CODE');
        //$company_code = '2000,5000,7000';
        $str_item_cat = !empty($item_cat) ? ' AND ITEM_CAT in ('.$item_cat.') AND COMPANY_CODE in ('.$company_code.')': '';

        $filter_approval = "AND AI.STATUS IS NULL";

        $dataa = $this->ec_approval_invoice->get_Invoice("WHERE STATUS_HEADER = 5 AND POSISI = 'VERIFIKASI' AND STATUS_DOC = 'BELUM KIRIM'".$str_item_cat.$filter_approval." ORDER BY EIH.CHDATE DESC");

        //echo count($dataa);
        //var_dump($dataa);die();

        for ($i=0; $i < count($dataa); $i++) {
          $test = $this->db->from('EC_APPROVAL_INVOICE')->where(array('ID_INVOICE'=>$dataa[$i]['ID_INVOICE']))->get()->result_array();

            $data = array('ID_INVOICE'=>$dataa[$i]['ID_INVOICE'],'STATUS'=>'3','TOTAL_PAYMENT'=>0);
          if($test){
            $this->db->where(array('ID_INVOICE'=>$dataa[$i]['ID_INVOICE']));
            $this->db->update('EC_APPROVAL_INVOICE',$data);
          }else{
            $this->db->insert('EC_APPROVAL_INVOICE',$data);
          }
        }
    }

    public function setReverseInvoice(){
      $idinvoice = $this->input->post('id_invoice');

      $data = $this->db->select('*')->from('EC_INVOICE_HEADER IH',false)->join('EC_APPROVAL_INVOICE AI', 'AI.ID_INVOICE = IH.ID_INVOICE',false)->where(array('IH.ID_INVOICE'=>$idinvoice))->get()->result_array();
      echo json_encode($data);
    }

    public function reRequestApproval($idinvoice){
      $this->load->model('invoice/ec_approval_invoice','ai');

      $a = $this->ai->update(array('STATUS'=>'0'),$idinvoice);
      if($a) $this->session->set_flashdata('message','Re-Request Approval Berhasil');
      else $this->session->set_flashdata('message','Re-Request Approval Gagal');
      redirect('EC_Invoice_Ekspedisi');
    }

    public function countInvoiceReject(){
        $this->load->model('invoice/ec_approval_invoice');

        $roleVerifikasi = $this->getCurrentRoleVerifikasi(2);
        $item_cat = $this->roleAccess($roleVerifikasi,'ITEM_CAT');
        $company_code = $this->roleAccess($roleVerifikasi,'COMPANY_CODE');
        $str_item_cat = !empty($item_cat) ? ' AND ITEM_CAT in ('.$item_cat.') AND COMPANY_CODE in ('.$company_code.')': '';
        $filter_approval = " WHERE AI.STATUS = '4'";

        $data = $this->ec_approval_invoice->get_Invoice($filter_approval.$str_item_cat," ORDER BY EIH.CHDATE DESC");

        return count($data);
    }

    public function dataDokumen($invoice){
        $this->load->model('invoice/ec_t_denda_inv','etdi');
        $this->load->model('invoice/ec_t_doc_inv','etdo');
        $this->load->model('invoice/ec_invoice_header','eih');
        $this->load->model('invoice/ec_m_doc_inv','mdoc');
        $this->load->model('invoice/ec_m_denda_inv','mdenda');

        $listDoc = array();
        $_mdenda = $this->mdenda->get_all();
        $mdenda = array();
        foreach($_mdenda as $_md){
            $mdenda[$_md->ID_JENIS] = $_md->JENIS;
        }

        $_mdoc = $this->mdoc->get_all();
        $mdoc = array();
        foreach($_mdoc as $_md){
            $mdoc[$_md->ID_JENIS] = $_md->JENIS;
        }
        $masterDokumen = array(
            'INVOICE_PIC' => 'Dokument Invoice',
            'BAPP_PIC' => 'Dokument BAPP',
            'BAST_PIC' => 'Dokument BAST / PP',
            'KWITANSI_PIC' => 'Kwitansi',
            'FAKPJK_PIC' => 'Faktur Pajak',
            'POTMUT_PIC' => 'Dokument Potongan Mutu',
            'SPMHONBYR_PIC' => 'Surat Permohonan Bayar',
            'AMOUNT_PIC' => 'Dokument Amount',
            'K3_PIC' => 'Dokument K3',
            'PO_PIC' => 'Dokument PO'
        );
        $nilaiDokumen = array(
            'INVOICE_PIC' => 'NO_INVOICE',
            'BAPP_PIC' => 'NO_BAPP',
            'BAST_PIC' => 'NO_BAST',
            'KWITANSI_PIC' => 'NO_KWITANSI',
            'FAKPJK_PIC' => 'FAKTUR_PJK',
            'POTMUT_PIC' => 'POT_MUTU',
            'SPMHONBYR_PIC' => 'SURAT_PRMHONAN_BYR',
            'AMOUNT_PIC' => 'TOTAL_AMOUNT',
            'K3_PIC' => 'K3',
            'PO_PIC' => 'NO_SP_PO'
        );
        $keyMasterDokumen = array_keys($masterDokumen);
        foreach($invoice as $in){
          $header = $this->eih->as_array()->get(array('ID_INVOICE' => $in));
          $denda = $this->etdi->get_all(array('ID_INV' => $in));
          $doc = $this->etdo->get_all(array('ID_INV' => $in));

          foreach($header as $key => $val){
              if(in_array($key,$keyMasterDokumen)){
                  if(!empty($val)){
                      $kolomData = $nilaiDokumen[$key];
                      if(!empty($header[$kolomData])){
                          $listDoc[$in][$masterDokumen[$key]] = $header[$kolomData];
                      }
                  }
              }
          }
          if(!empty($denda)){
              foreach($denda as $_d){
                  $listDoc[$in][$mdenda[$_d->ID_DENDA]] = $_d->NOMINAL;
              }
          }
          if(!empty($doc)){
              foreach($doc as $_d){
                  $listDoc[$in][$mdoc[$_d->ID_DOC]] = $_d->NO_DOC;
              }
          }
          //$listDoc[$in] = $in;
        }

        //var_dump($listDoc);
        return $listDoc;
    }
    public function listDokumen(){
        $list_id = $this->input->post('id');
        $listDoc = $this->dataDokumen($list_id);
        $data['lists'] = $listDoc;
        //$data['proses'] = $proses;
        $data['list_id'] = json_encode($list_id);
        $this->load->view('EC_Invoice_Ekspedisi/listDokumen',$data);
    }

    public function updatePosisiDokumen(){
        $invoice = $this->input->post('invoice');
        $proses = '';

        /* cari status dokumen terakhir */
        $this->load->model('invoice/ec_tracking_invoice','eti');
        $this->load->model('invoice/ec_invoice_header','eih');
        $idinvoice = implode(',',$invoice);
        $dataInvoice = $this->db->where_in('ID_INVOICE',$invoice)->get('EC_INVOICE_HEADER')->result();
        /* set id  */

        $tmpInvoice = array();
        foreach($dataInvoice as $_dInvoice){
          $tmpInvoice[$_dInvoice->ID_INVOICE] = $_dInvoice;
        }

        $data_tracking = array();
        $bisaKirim = array('BELUM KIRIM','RETUR','TERIMA'); // TERIMA setelah diretur oleh verifikasi
        $pesan = 'Dokumen berhasil dikirim';
        $kirimDokumen = array('status' => 0, 'message' => '');
        $dokumenSAP = array();
        foreach($invoice as $idinvoice){
          $tracking = $this->eti->order_by('DATE','DESC')->get(array('ID_INVOICE'=>$idinvoice));
          switch($tracking->POSISI){
              case 'VERIFIKASI':
                  if(in_array($tracking->STATUS_DOC,$bisaKirim)){
                    $data_tracking[$idinvoice] = array(
                        'ID_INVOICE' => $idinvoice,
                        'DESC' => 'EDIT',
                        'USER' => $this->user,
                        'STATUS_DOC' => 'KIRIM',
                        'STATUS_TRACK' => $tracking->STATUS_TRACK,
                        'POSISI' => 'VERIFIKASI',
                    );
                    $dokumenSAP[$idinvoice] = $tmpInvoice[$idinvoice];
                    //  $kirimDokumen = $this->kirimDokumenSAP($dataInvoice);
                  }
                  break;
                  default:
          }
        }
        $this->db->trans_begin();
        $kirimDokumen = $this->kirimDokumenSAP($dokumenSAP);
        /* update di database */
        $result = array('status' => 0, 'message' => 'Dokumen gagal dikirim');
        if($kirimDokumen['status']){
          $pesan = $kirimDokumen['message'];
          foreach($data_tracking as $_data_tracking){
            $this->eti->insert($_data_tracking);
          }
        }else{
          $result['message'] = $kirimDokumen['message'] ;
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $result['status'] = 1;
            $result['message'] = $pesan ;
            $result['urlcetak'] = $kirimDokumen['urlcetak'];
            $result['id'] = $kirimDokumen['id'];
        }
        $result['proses'] = $proses ;
        echo json_encode($result);
    }

    public function kirimDokumenSAP($dataInvoices){
      $this->load->library('sap_invoice');
      $this->load->model('invoice/ec_gr_sap','gr_sap');
      $this->load->model('invoice/ec_gr','gr');
      $this->load->model('invoice/ec_posting_invoice','epi');
      $this->load->model('invoice/ec_ekspedisi','ee');
      $header = array();
      $updateEkspedisi = array();
      $item = array();
      $nourut = 1;
      foreach($dataInvoices as $idinovice => $dataInvoice){
        /* cari company dan plant */
        $company = $dataInvoice->COMPANY_CODE;
        $tglInvoice = new DateTime($dataInvoice->INVOICE_DATE);
        /* cari tanggal posting invoice */
        $_tposting = $this->epi->order_by('CREATE_DATE','DESC')->get(array('ID_INVOICE' => $idinovice));
        $tglPosting = new DateTime($_tposting->POSTING_DATE);
        $header[$nourut] = array(
          'company' => $company,
          'username' => $this->getIdSAP($this->session->userdata['EMAIL']),
          'invoice_date' => $tglInvoice->format('Ymd'),
          'posting_date' => $tglPosting->format('Ymd')
        );
        /* cari nilai yang dibayarkan ke vendor */
        $amountVendor = $this->getAmountVendor($dataInvoice->COMPANY_CODE,$dataInvoice->FI_NUMBER_SAP,$dataInvoice->FI_YEAR);

        $grItem = $this->gr->get_all(array('INV_NO' => $idinovice,'STATUS' => 1));
        $itemInvoice = $dataInvoice->FI_NUMBER_SAP;
        $item[$nourut] = array();
        foreach($grItem as $_t){
          /* ambil nomer ekspedisi */
          $no_ekspedisi = $this->db->where(array('ID_INVOICE' => $idinovice))->order_by('CREATE_DATE','desc')->get('EC_EKSPEDISI')->row_array();
        //  echo $this->db->last_query();die();
        // print_r($no_ekspedisi);die();
          array_push($item[$nourut],array(
            'idinvoice' => $idinovice,
            'invoice' => $itemInvoice,
            'currency' => $amountVendor['WAERS'],
            // 'amount' =>  $dataInvoice->CURRENCY == 'IDR' ? $dataInvoice->TOTAL_AMOUNT / 100 : $dataInvoice->TOTAL_AMOUNT,
            'amount' => $amountVendor['WRBTR'],
            'amount_local' => $amountVendor['DMBTR'],
            'payment_block' => '#',
            'po' => $_t->PO_NO,
            'item_po' => $_t->PO_ITEM_NO,
            'no_ekspedisi' => !empty($no_ekspedisi) ? $no_ekspedisi['NO_EKSPEDISI'] : ''
            )
          );
        }
        $nourut++;
      }
      $t = $this->sap_invoice->kirimDokumenVerifikasi($header,$updateEkspedisi,$item);
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
        foreach($item as $idinvoice => $it){
          //foreach($it as $_t){
            $_t = $it[0];
            $this->ee->insert(array('ID_INVOICE' => $_t['idinvoice'],'NO_EKSPEDISI' => $nomerDokumen[0],'TAHUN' => date('Y'),'ACCOUNTING_INVOICE'=> $_t['invoice'],'COMPANY' => $company,'PAYMENT_BLOCK' => '#'));
          //}
        }
        // if(){
        $result['status'] = 1;
        $result['message'] = 'Dokumen berhasil dikirim dengan nomer ekspedisi '.$nomerDokumen[0];
        $result['urlcetak'] = site_url('EC_Invoice_Report/Ekspedisi/cetakDokumen/');
        $result['id'] = $nomerDokumen[0].'#'.date('Y').'#'.$company;
        $this->notifikasiKirimDokumen($item);
        // }
      }else{
        $result['message'] = $t[0]['MESSAGE'];
      }

      return $result;
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

    public function getRoleVerifikasi($level = NULL){
        $this->load->model('invoice/ec_role','er');
        $roleLevel = empty($level) ? 'VERIFIKASI%' : 'VERIFIKASI '.$level.'%';
        $roles = $this->db->where('ROLE_AS like \''.$roleLevel.'\'')->get('EC_M_ROLE')->result();
        $tmp = array();
        foreach($roles as $r){
            array_push($tmp,$r->ROLE_AS);
        }
        return $tmp;
    }

    public function roleAccess($roles,$object_as){
      $this->load->model('invoice/ec_role_access','era');
      $result = array();
      $role = array();
      $era = $this->db->where('OBJECT_AS = \''.$object_as.'\' AND ROLE_AS in (\''.implode('\',\'',$roles).'\')')->get('EC_ROLE_ACCESS')->result_array();
      if(!empty($era)){
        foreach($era as $e){
          $t = array($e['VALUE']);
          $result = array_merge($t,$result);
        }
      }

      /* jadikan satu array */
      return implode(',',array_unique($result));

    }

    public function getCurrentRoleVerifikasi($level = NULL){
      $this->load->model('invoice/ec_role_user', 'role_user');
      $email_login = explode('@', $this->user_email);
      $current_roles = array();
      $_tmp = $this->role_user->get_all(array('USERNAME' => $email_login[0], 'STATUS' => 1));
      if(!empty($_tmp)){
        foreach($_tmp as $_t){
            if(!empty($level)){
              if(strpos($_t->ROLE_AS, strval($level)) !== false){
                  array_push($current_roles,$_t->ROLE_AS);
              }
            }else{
              array_push($current_roles,$_t->ROLE_AS);
            }
        }
      }

      return $current_roles;
    }

    public function notifikasiKirimDokumen($listIdInvoice){
      $this->load->model(array('vnd_header'));
      $this->load->model('invoice/ec_invoice_header', 'eih');

      foreach($listIdInvoice as $index => $it){
        foreach($it as $_t){
          $idinvoice = $_t['idinvoice'];
          $dataInvoice = $this->eih->as_array()->get($idinvoice);
          $_data = $this->eih->as_array()->get($idinvoice);
          $data_vendor = $this->vnd_header->get(array('VENDOR_NO'=>$_data['VENDOR_NO']));
          $data = array(
            'content' => '
                Dokumen sent on '.date('d M Y H:i:s').'<br>
                Nomor PO        : '.$dataInvoice['NO_SP_PO'].'<br>
                Nomor Invoice   : '.$dataInvoice['NO_INVOICE'].'<br>
                Tanggal Invoice : '.$dataInvoice['INVOICE_DATE'].'<br>',
            'title' => 'Invoice '.$dataInvoice['NO_INVOICE'].' Sent to Treasurer',
            'title_header' => 'Invoice '.$dataInvoice['NO_INVOICE'].' Sent to Treasurer',
          );
    			$message = $this->load->view('EC_Notifikasi/approveInvoice',$data,TRUE);
          $_to = $data_vendor['EMAIL_ADDRESS'];
        //  $_to = 'ahmad.afandi85@gmail.com';
          $subject = 'Invoice '.$dataInvoice['NO_INVOICE'].' Sent to Treasurer  [E-Invoice Semen Indonesia]';
          Modules::run('EC_Notifikasi/Email/invoiceNotifikasi',$_to,$message,$subject);
        }
      }
    }
    /* dapatkan jumlah yang diterima oleh vendor */
    private function getAmountVendor($company,$noDocument,$tahun){
      $this->load->library('sap_invoice');
      $param = array();
      $param['I_BUKRS'] = $company;
      $param['I_BELNR_FROM'] = $noDocument;
      $param['I_GJAHR'] = $tahun;
      $t = $this->sap_invoice->getListAccountingDocument($param);
      /* ambil baris pertama saja */
      return !empty($t) ? $t[0] : array();
    }


    public function repaireByDate($date='000000'){
      $sql = "SELECT a.ID_INVOICE,a.FI_NUMBER_SAP,a.FI_YEAR,a.TGL_POSTING,a.COMPANY_CODE FROM (
                SELECT DISTINCT EIH.*, TO_CHAR(ETI.\"DATE\",'ddmmyy') AS TGL_POSTING FROM EC_INVOICE_HEADER EIH
                JOIN EC_TRACKING_INVOICE ETI
                  ON EIH.ID_INVOICE = ETI.ID_INVOICE AND STATUS_TRACK = 5
              )a WHERE a.TGL_POSTING = '$date'";
      $invoice = $this->db->query($sql)->result_array();
      var_dump($invoice);
      
      for ($i=0; $i < count($invoice); $i++) { 
        $this->insertApprovalInvoice($invoice[0]);
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

    public function getIDInvoice(){
      $no_doc = $this->input->post('no_doc');
      $tahun_doc = $this->input->post('tahun_doc');

      $data = $this->db->select('ID_INVOICE')->where(array('FI_NUMBER_SAP'=>$no_doc,'FI_YEAR'=>$tahun_doc))->get('EC_INVOICE_HEADER')->row_array();
      
      $status = 1;
      $msg = '';
      
      if(!empty($data)){
        $valid = $this->db->where(array('ID_INVOICE'=>$data['ID_INVOICE'],'STATUS'=>3))->get('EC_APPROVAL_INVOICE')->result_array();
        if(empty($valid)){
          $status = 0;
          $msg = 'Invoice dengan No Dokumen ('.$no_doc.') Tahun ('.$tahun_doc.') Belum Dapat Dilakukan Cetak Melalui E-Invoice';
        }
      }else{
        $status = 0;
        $msg = 'Invoice dengan No Dokumen ('.$no_doc.') Tahun ('.$tahun_doc.') Tidak Ditemukan';
      }
      
      echo json_encode(array('status'=>$status,'id'=>$data['ID_INVOICE'],'msg'=>$msg));
    }

    public function Test(){
      var_dump($this->session->userdata);
    }
}
