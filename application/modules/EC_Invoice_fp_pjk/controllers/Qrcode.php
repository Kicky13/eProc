<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Qrcode extends MX_Controller {
  public function __construct() {
      parent::__construct();
  }
  public function cetak(){

      $this->load->library('M_pdf');
      $mpdf = new M_pdf();
      $data = array(
        'kodebarcode' => 'WM#7702#W201#702#AA121212'
      );
      $html = $this->load->view('cetakQrcode',$data,TRUE);

      $mpdf->pdf->writeHTML($html);
      $mpdf->pdf->output();
  }
}
