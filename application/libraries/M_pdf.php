<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
include_once APPPATH.'/third_party/MPDF57/mpdf.php';
 
class M_pdf {
 
    public $param;
    public $pdf;
 
    // public function __construct($param = '"en-GB-x","A4","","",10,10,10,10,6,3')
    public function __construct($param = '"en-GB-x","A4","","",0,0,0,0,0,0')
    {
        $this->param =$param;
        $this->pdf = new mPDF($this->param);
    }

    public function new_print(){
        $this->pdf = new mPDF('utf-8', 'A4-L');
    }
}