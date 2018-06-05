<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pomut extends MX_Controller {
  private $user;
  private $user_email;
  public function __construct() {
    parent::__construct();
    $this -> load -> helper('url');
    $this -> load -> library('Layout');
    $this -> load -> helper("security");
    $this->vendor_no = $this->session->userdata('VENDOR_NO');
    $this->load->model('invoice/ec_pomut','pm');
  }

  public function index(){
      $this -> load -> library('Authorization');
      $data['title'] = "Approval BA Analisa Mutu";
      $this->layout->set_table_js();
      $this->layout->set_table_cs();
      $this->layout->set_validate_css();
      $this->layout->set_validate_js();

      $this->layout->add_css('pages/EC_miniTable.css');
      $this->layout->add_css('pages/invoice/common.css');

    $this->layout->add_js('bootbox.js');
    $this->layout->add_js('pages/invoice/EC_common.js');
      $this->layout->add_js('pages/invoice/ec_vendor_pomut.js');
      $this->layout->render('EC_Vendor/pomut/list',$data);
    }

  public function detail(){
    $data['title'] = "Detail BERITA ACARA Analisa Mutu";
    $this->layout->set_table_js();
    $this->layout->set_table_cs();
    $this->layout->add_js('pages/invoice/EC_common.js');
    $this->layout->add_js('bootbox.js');
    $this->layout->add_js('pages/invoice/ec_vendor_pomut_detail.js');


    $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
    $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');

    $data['ba_no'] = $this->input->post('ba_no');
    $data['po_no'] = $this->input->post('po_no');
    $data['material'] = $this->input->post('material');
    $data['vendor'] = $this->input->post('vendor');
        
    $act= $this->input->post('act');

    $data['act'] = $act;

    $data['header'] = $this->pm->getSingleHeader($data['ba_no']); 
    $data['detail'] = $this->pm->getDataDetail($data['ba_no']);
        
    $data['url'] = base_url('EC_Vendor/Pomut/approvalBA');

        //var_dump($data);die();
    $this->layout->render('EC_Vendor/pomut/detail',$data);
  }

  public function data($status = 2){
    $data = $this->pm->getDataReport($status,$this->vendor_no);
    //echo $this->db->last_query();
    //var_dump($data);die();
    echo json_encode(array('data'=>$data));
  }

  public function approvalBA(){
    $data_update = $this->input->post();
    $no_ba = $this->input->post('NO_BA');
    unset($data_update['TGL_BA']);

    $data_update['VENDOR_APPROVED'] = $this->vendor_no;
    $data_update['STATUS'] = 3;

    $this->db->set('VENDOR_APPROVED_AT','SYSDATE',FALSE);
    $act = $this->db->where('NO_BA',$no_ba)->update('EC_POMUT_HEADER_SAP',$data_update);

    if($act){
      $pesan = 'Approval Berita Acara No.'.$no_ba.' BERHASIL';
      $this->session->set_flashdata('message', $pesan);
      redirect('EC_Vendor/Pomut');
    }else{
      die('GAGAL');
    }
  }
}
