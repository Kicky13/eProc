<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends MX_Controller {

    private $user;
    public function __construct() {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->load->model("invoice/ec_approval_invoice",'ai');
        $this->user = $this->session->userdata('FULLNAME');
    }

    public function index() {
        $data['title'] = "Approval Invoice";
        //$data['cheat'] = $cheat;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('pages/invoice/EC_List_Approval_Invoice.js');

        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');
        $this->layout->add_css('pages/invoice/common.css');

        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');

        $this->layout->render('invoice/list',$data);
    }

    public function getDataInvoice(){
        $userRole = $this->getUserRole();
        $roleAccess = $this->getRoleAccess($userRole);

        $data = $this->ai->getData($roleAccess);
        
        $hasil = array();
        for($i=0; $i < count($data); $i++) {
            $row['ID_INVOICE'] = $data[$i]['ID_INVOICE']; 
            $row['NO_INVOICE'] = $data[$i]['NO_INVOICE'];
            $row['INVOICE_DATE'] = $data[$i]['CREATE_DATE'];
            $row['FAKTUR_PJK'] = $data[$i]['FAKTUR_PJK'] != null ? $data[$i]['FAKTUR_PJK'] : "-";
            $row['CURRENCY'] = $data[$i]['CURRENCY'];
            $row['TOTAL_PAYMENT'] = $row['CURRENCY'].' '.ribuan($data[$i]['TOTAL_PAYMENT']);
            $row['PAYMENT'] = $data[$i]['TOTAL_PAYMENT'];
            $row['INVOICE_PIC'] = $data[$i]['INVOICE_PIC'] != null ? $data[$i]['INVOICE_PIC'] : "#";
            $row['FAKPJK_PIC'] = $data[$i]['FAKPJK_PIC'] != null ? $data[$i]['FAKPJK_PIC'] : "#";
            $row['VENDOR_NO'] = $data[$i]['VENDOR_NO'];
            $row['VENDOR_NAME'] = $data[$i]['VENDOR_NAME'];
            $row['STATUS'] = $data[$i]['STATUS']+1;
            $hasil[] = $row;
        }
        $result['data'] = $hasil;
        echo json_encode($result);      
    }


    public function approvalInvoice($action){
        $is_approve = $action=='approve' ? 1:0;

        $inv_no = $this->input->post('invoice_no');

        $id_invoice = $this->input->post('id_invoice');
        $status = $this->input->post('status_approval');
        $total_payment = $this->input->post('total_payment');

//        $more_1m = $total_payment >= 1000000000 ? 1:0; 
        /*
            Jika nilai invoice <1M dan approval 2 maka status langsung diubah menjadi 3 
            Karena tidak membutuhkan approval 3 (Kadep)
        */
        $new_status = 3;

//        if(!$more_1m && $status == 1){
//            $new_status = 3;
//        }else{$new_status = $status;}

        $data = array('STATUS' => $new_status,'APPROVAL' => $status);

        if($status == 1){
            $data['APPROVAL_1'] = $this->session->userdata('ID');
        }else if ($status == 2){
            $data['APPROVAL_2'] = $this->session->userdata('ID');
        }else{
            $data['APPROVAL_3'] = $this->session->userdata('ID');
        }

//        var_dump($data);
        $pesan = '';

        if($is_approve){
            $res = $this->ai->update($data,$id_invoice);
            if($res){
                $pesan = 'Invoice dengan No : '.$inv_no.' Berhasil di Approve';
            }else{
                $pesan = 'Invoice dengan No : '.$inv_no.' Gagal di Approve';
            }
        }else{
            $data['STATUS'] = 4; // REJECT
            $data['REJECT_NOTE'] = $this->input->post('msg');
            $res = $this->ai->update($data,$id_invoice);
            if($res){
                $pesan = 'Invoice dengan No : '.$inv_no.' Berhasil di Reject';
            }else{
                $pesan = 'Invoice dengan No : '.$inv_no.' Gagal di Reject';
            }
        }
        $this->session->set_flashdata('msg',$pesan);
        redirect(site_url('EC_Approval/Invoice'));
    }

    public function getUserRole(){
        $this->load->model('invoice/ec_role_user', 'role_user');
        $user_email = explode('@', $this->session->userdata('EMAIL'));
        $username = $user_email[0];
        $temp = $this->role_user->get_all(array('USERNAME' => $user_email[0], 'STATUS' => 1));
        $role_user = array();
        if(!empty($temp)){
            foreach($temp as $_t){
                array_push($role_user,$_t->ROLE_AS);
            }
        }
        return $role_user;
    }

    public function getRoleAccess($role_user = ''){
        $role_user = $this->getUserRole();
        $this->load->model('invoice/ec_role_access', 'role_access');
        $roleAccess = array();
        $i = 0;
        if(count($role_user)>0){
            $fil = 'APPROVAL INVOICE';
            foreach($role_user as $r){
                $result = 0;
                if (strpos($r, $fil) !== false) {
                    $result = 1;
                }

                if($result){
                    $_company = $this->role_access->as_array()->get(array('OBJECT_AS' => 'COMPANY','ROLE_AS' => $r));
                    $_status = $this->role_access->as_array()->get(array('OBJECT_AS' => 'STATUS','ROLE_AS' => $r));
                    if(!empty($_company)){
                        $roleAccess[$i]['COMPANY'] = $_company['VALUE'];
                        $roleAccess[$i]['STATUS'] = $_status['VALUE'];
                    }
                }
            $i++;
            }
        }
        return array_values($roleAccess);
    }

    public function cetakLembarVerifikasi($id_invoice){
        $this->load->model('invoice/ec_approval_invoice','eai');
        $this->load->model('invoice/ec_invoice_header','eih');

        $data['bulan'] = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');

        $data['invoice'] = $this->eih->as_array()->get(array('ID_INVOICE'=>$id_invoice));

        $data_invoice = $this->db->select('TO_CHAR (INVOICE_DATE,\'DD.MM.YYYY\') AS INVOICE_DATE2',false)->from('EC_INVOICE_HEADER IH')->where(array('ID_INVOICE'=>$id_invoice))->get()->result_array();
        $data['invoice']['INVOICE_DATE2'] = $data_invoice[0]['INVOICE_DATE2'];
        
        $temp_invoice = $this->db->query('
            SELECT ID_INVOICE,DOC_TYPE,PM_DESC FROM EC_POSTING_INVOICE epi 
            INNER JOIN EC_M_PAY_METHOD PM
                ON epi.PAYMENT_METHOD = pm.PM_TYPE
            WHERE ID_INVOICE = 425 ORDER BY CREATE_DATE DESC')->result_array();

        if($temp_invoice){
            $data['invoice']['DOC_TYPE'] = $temp_invoice[0]['DOC_TYPE'];
            $data['invoice']['PAYMENT_METHOD'] = $temp_invoice[0]['PM_DESC'];
        }

        $data['approval'] = $this->eai->as_array()->get(array('ID_INVOICE'=>$id_invoice));

        if ($data['approval']['APPROVAL_3'] != NULL) {
            $approval_id = array(
                'APPROVAL_2' => $data['approval']['APPROVAL_2'],
                'APPROVAL_3' => $data['approval']['APPROVAL_3']
            );
        }else{
            $approval_id = array(
                'APPROVAL_1' => $data['approval']['APPROVAL_1']
//                'APPROVAL_2' => $data['approval']['APPROVAL_2']
            );
        }

        //var_dump($approval_id);die();

        $data['approval']['detail'] = $this->eai->getDataApproval($approval_id,$id_invoice);

        $data_vendor = $this->db->from('VND_HEADER')->where(array('VENDOR_NO'=>$data['invoice']['VENDOR_NO']))->get()->result_array();
        $data['vendor'] = $data_vendor[0];
        
        $this->load->library('sap_invoice');
        $vendorDetail = $this->sap_invoice->getDetailVendor($data['invoice']['VENDOR_NO']);
        $data['vendor']['detail'] = $vendorDetail[0];

        //var_dump($data['approval']['detail']);die();


        $data_bank = $this->listBankVendor($data['invoice']['VENDOR_NO']);
        for ($i=0; $i < count($data_bank); $i++) { 
            if($data_bank[$i]['PARTNER_TYPE'] == $data['invoice']['PARTNER_BANK']){
                $data['vendor']['NO_REK'] = $data_bank[$i]['ACCOUNT_NO'];
                $data['vendor']['BANK_NAME'] = $data_bank[$i]['BANK_NAME'];
                break;
            }
        }

        $this->load->config('ec');
        
        $company_data = $this->config->item('company_data');
        $data['company_data'] = $company_data[$data['invoice']['COMPANY_CODE']];
        
        $data['accDoc'] = $this->getListAccountingDocument($data['invoice']['FI_NUMBER_SAP'],$data['invoice']['FI_YEAR'],$data['invoice']['COMPANY_CODE']);

        //var_dump($data['accDoc']);die();

        $html = $this->load->view('invoice/cetak',$data,TRUE);

        $this->load->library('M_pdf');
        $mpdf = new M_pdf();
        //$mpdf->pdf->SetTitle('Lembar Verifikasi - '.$data['invoice']['FI_NUMBER_SAP']);
        $mpdf->pdf->writeHTML($html);
        $mpdf->pdf->output('Lembar Verifikasi - '.$data['invoice']['FI_NUMBER_SAP'].'.pdf','I');
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
          'TAX_CODE' => $_t['MWSKZ'],
          'COST_CENTER' => $_t['KOSTL'],
          'NO_RR' => substr(substr($_t['XREF3'],4), 0, 10)
          // 'TEXT' => $_t['SGTXT']
        );
        array_push($result,$tmp);
      }
      return $result;
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

    private function listBankVendor($venno){
      $this->load->library('sap_handler');
      return $this->sap_handler->getListBankVendor($venno);
    }

    public function Test(){
        $data = array('','A',NULL,'123',FALSE,'OK',TRUE,'96');

        var_dump($this->session->userdata);
    }
}