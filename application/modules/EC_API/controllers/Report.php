<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
    protected $_timbangan = 'TIMBANGAN';
    protected $_transaksiBlok = 'TRANSAKSI_BLOK';
    protected $_timbanganSAP = 'TIMBANGAN_SAP';

    public function __construct(){
      parent::__construct();
      $this->load->helper('url');
    }
    //public $settings = array();
    private function render($view,$data){
      $dataContent['content'] = $this->load->view($view,$data,TRUE);
      $this->load->view('EC_API/ptpn/header',$dataContent);
      $this->load->view('EC_API/ptpn/footer');
    }
    public function index()
    {
        $this->load->model('Resume_model','rm');
        $this->load->helper('url');
        $this->load->helper('ptpn');
        $numeric_fields = array(
          'QTY','QTY_SAP'
        );
        $list_data = $this->rm->resumeHarian();
        $data = array(
          'list_data' => $list_data,
          'numeric_fields' => $numeric_fields,
          'page_title' => 'Timbangan PTPN'
        );
        $this->render('EC_API/ptpn/resume',$data);
    }

    public function detail(){
      $this->load->model('Resume_model','rm');
      $plant = $this->input->get('plant');
      $wb = $this->input->get('wb');
      $jenistransaksi = $this->input->get('jenistransaksi');
      $materialno = $this->input->get('materialno');
      $tglkeluar = $this->input->get('tglkeluar');
      $where = " where plant = '".$plant."' and wb = '".$wb."' and jenistransaksi = '".$jenistransaksi."' and materialno = '".$materialno."' and tglkeluar = '".$tglkeluar."'";
      $numeric_fields = array(
        'QTY','QTY_SAP'
      );
      $data = array(
        'list_data' => $this->rm->detail($where),
        'numeric_fields' => $numeric_fields
      );
      $this->load->view('EC_API/ptpn/detail',$data);
    }

    public function listFile(){
      $data['url'] = site_url($this->input->get('url'));
      $data['mode'] = $this->input->get('mode');
      $data['location'] = $this->input->get('location');
      $data['ftp_url'] = site_url('EC_API/Timbangan/readRemoteFile');
      $location = $data['mode'] == 'archive' ? 'archive/'.$data['location'] : $data['location'];
      $data['page_title'] = 'Daftar File Pada Folder '.$location;
      $this->render('EC_API/ptpn/listFile',$data);
    }

    public function download_file(){

    }
}
