<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ekspedisi extends MX_Controller {

    private $user;

    public function __construct() {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->user = $this->session->userdata('FULLNAME');
    }

    public function index() {
        $data['title'] = "Invoice Report Ekspedisi";
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('pages/invoice/Ekspedisi_report.js');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/invoice/common.css');
        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->render('EC_Invoice_Report/ekspedisi/list', $data);
    }

    public function datatable(){
        $this->load->library('Datatables');
        $companyCode = $this->getCompanyCodeVerifikasi(2);
        $dt = new Datatables();
        $actionBtn = '<button class="btn btn-sm btn-success btn-rowedit" data-idekspedisi="$1" data-url="'.site_url('EC_Invoice_Report/Ekspedisi/cetakDokumen').'">
                          <i class="fa fa-edit"></i> Cetak
                      </button>';
        /* tambahkan filter untuk pencarian */
        $_columns = array(
          'NO_EKSPEDISI','CREATE_DATE','TAHUN','ACCOUNTING_INVOICE','COMPANY'
        );
        $_filterCustom = array();
        foreach($_columns as $_c){
          $_tmp = $this->input->post($_c);
          if(!empty($_tmp)){
            $_filterCustom[$_c] = $_tmp;
          }
        }

        if(!empty($_filterCustom)){
          foreach ($_filterCustom as $key => $value) {
            $dt->like($key,$value);
          }
        }

        $_tabel = 'EC_EKSPEDISI EE';
        $dataOutput = $dt->distinct('NO_EKSPEDISI,EE.CREATE_DATE,EE.ACCOUNTING_INVOICE,EE.TAHUN,EE.COMPANY')->select('EE.PAYMENT_BLOCK,EE.NO_EKSPEDISI,EE.CREATE_DATE,EE.ACCOUNTING_INVOICE,EE.TAHUN,EE.COMPANY')
            ->from($_tabel)
            ->join('EC_INVOICE_HEADER EH','EE.ID_INVOICE = EH.ID_INVOICE and EH.STATUS_HEADER = 5')
          //  ->join('EC_TRACKING_INVOICE ETI','ETI.ID_INVOICE = EE.ID_INVOICE and ETI.STATUS_TRACK = 5 and ETI.STATUS_DOC = \'KIRIM\' and ETI.POSISI = \'VERIFIKASI\'')
            ->where(array('PAYMENT_BLOCK' => '#'))
            ->where_in('COMPANY',$companyCode)
            ->add_column('actions',$actionBtn,'setEkspedisiTahun(NO_EKSPEDISI,CREATE_DATE,COMPANY)')
//            ->add_column('memberofgroup','$1','convertMember(memberofgroup,mg)')
            ->generate();

        $this->output
          ->set_content_type('application/json')
          ->set_output($dataOutput);
    }

    public function cetakDokumen(){

        $this->load->library('M_pdf');
        $this->load->library('sap_invoice');
        $mpdf = new M_pdf();
        $this->load->config('ec');
        $company_data = $this->config->item('company_data');
        $id = $this->input->post('data');
        $tmp = explode('#',$id);
        $data['kodebarcode'] = $id;
        $data['no_ekspedisi'] = $tmp[0];
        $data['tgl_ekspedisi'] = $tmp[1];
        $data['company_code'] = $tmp[2];
        $data['company'] = $company_data[$tmp[2]];


        $this->load->model('invoice/ec_ekspedisi','ee');
        $tahun = new DateTime($tmp[1]);
        $listEkspedisi = $this->db->distinct()->order_by('ACCOUNTING_INVOICE','asc')->where(array('NO_EKSPEDISI' => $tmp[0],'TAHUN'=> $tahun->format('Y'),'COMPANY' => $tmp[2]))->get('EC_EKSPEDISI')->result_array();

        $listDocument = array();
        foreach($listEkspedisi as $ld){
            $_dataKirim = array('I_BUKRS' => $ld['COMPANY'],'I_BELNR_FROM' => $ld['ACCOUNTING_INVOICE'],'I_GJAHR' => $ld['TAHUN']);
            $tmp = $this->sap_invoice->getListAccountingDocument($_dataKirim);
            $_tmp = $tmp[0];
            array_push($listDocument,array(
                'ACCOUNTING_INVOICE' => $ld['ACCOUNTING_INVOICE'],
                'VENDOR' => $_tmp['LIFNR'],
                'VENDOR_NAME' => $this->getVendorName($_tmp['LIFNR']),
                'CURR' => $_tmp['WAERS'],
                'JUMLAH' => $_tmp['WAERS'] == 'IDR' ? $_tmp['DMBTR'] * 100 : $_tmp['DMBTR'],
            )
          );
        }

        $data['listEkspedisi'] = $listDocument;
        $html = $this->load->view('EC_Invoice_Report/ekspedisi/cetakDokumen',$data,TRUE);

        $mpdf->pdf->writeHTML($html);
        $mpdf->pdf->output();
    }

    public function dataDokumen($idinvoice){
      return Modules::run('EC_Invoice_Ekspedisi/dataDokumen',$idinvoice);
    }
    /* get company code yang dimiliki verifikasi */
    public function getCompanyCodeVerifikasi($level){
      $roles_user = $this->getRoleUser();
      $this->load->model('invoice/ec_role_access', 'role_access');
      $company = array();
      if(!empty($roles_user)){
        $cari = 'VERIFIKASI '.$level;
        foreach($roles_user as $r){
          $result = 0;
          if (strpos($r, $cari) !== false) {
              $result = 1;
          }
          if($result){
            $_company = $this->role_access->as_array()->get(array('OBJECT_AS' => 'COMPANY_CODE','ROLE_AS' => $r));
            if(!empty($_company)){
              array_push($company,$_company['VALUE']);
            }
          }
        }
      }
      return $company;
    }

    public function getRoleUser(){
      $this->load->model('invoice/ec_role_user', 'role_user');
      $user_email = $this->session->userdata('EMAIL');
      $email_login = explode('@', $user_email);
      $current_roles = array();
      $_tmp = $this->role_user->get_all(array('USERNAME' => $email_login[0], 'STATUS' => 1));
      if(!empty($_tmp)){
        foreach($_tmp as $_t){
            array_push($current_roles,$_t->ROLE_AS);
        }
      }
      return $current_roles;
    }

    public function isVerifikasi($level,$roles){
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

    public function getVendorName($vendor_no){
      $t = $this->db->select(array('NAME1'))->where(array('LIFNR'=>$vendor_no))->limit(2)->get('EC_GR_SAP')->row_array();
      return $t['NAME1'];
    }
}
