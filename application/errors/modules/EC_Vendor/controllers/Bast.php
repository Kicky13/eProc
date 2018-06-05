<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bast extends CI_Controller {

    private $user;
    private $user_email;
    private $vendor_no;
    public function __construct() {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->load->model("invoice/ec_e_nova",'nova');
        $this->user = $this->session->userdata('FULLNAME');
        $this->vendor_no = $this->session->userdata('VENDOR_NO');
        $this->user_email = $this->session->userdata('EMAIL');
    }

    public function index() {
      $this->load->library('M_pdf');
      $mpdf = new M_pdf();
      $remotePath = 'https://int-eprocurement.semenindonesia.com/upload/EC_invoice/';
      $localPath = APPPATH.'/upload/EC_invoice/';


      $source = array(
        '3aef8f955d39e9828065914f93a1be43.pdf',
      /*  '2a339b62204b17c9d8cee201d5d3737f.png',
        '3b0a5ecc98acecff4d90e884e2e3db98.jpg',
        '9a19dd764ca267ae9a97e5a8b366b5a4.pdf',
        '1891f4bef26eb3ed547c2024ba0d0e09.jpg',
        '148964cbec051884f63d21bdb7f96a85.jpg',
        '4a1bc851aa7d996e99a6bc8492250e54.jpg',
        '5eafec76fed01de318f0c8698b78074a.PNG',
        'f5771b5242fd8f4465c9ace5a2e1df6a.jpg',
        '374fd01a2a67a2477efe947d34f42506.png',*/
        //'5b78e1175297ddaeb57c2f8eb2d7f5a0.PNG'
      );
      $mpdf->pdf->SetImportUse();
      $pdfExt = array('pdf');
      foreach($source as $s){
        $file = $remotePath.$s;
        $newfile = $localPath.$s;
        if ( copy($file, $newfile) ) {
            echo "Copy success!";
        }else{
            echo "Copy failed.";
        }
        /*
        $mpdf->pdf->AddPage();

        $f = 'upload/EC_invoice/'.$s;
        $ext = pathinfo($f, PATHINFO_EXTENSION);
        if(in_array(strtolower($ext),$pdfExt)){
          $pagecount = $mpdf->pdf->SetSourceFile($f);
          $tplId = $mpdf->pdf->ImportPage($pagecount);
          $mpdf->pdf->UseTemplate($tplId);
        }else{
          $html = '<img src="'.$f.'" />';
          $mpdf->pdf->WriteHTML($html);
        }
        */
      }


      // $mpdf->pdf->Output();
    }



}
