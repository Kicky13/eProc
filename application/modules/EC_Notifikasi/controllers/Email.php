<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Email extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		// $this->load->library('Authorization');
		$this->load->model(array('vnd_header'));
	}

  public function send($to,$message,$subject,$from,$cc = NULL, $bcc = NULL, $attachment = NULL){
    $this->load->library('email');
    $this->config->load('email');
    $semenindonesia = $this->config->item('semenindonesia');
    $this->email->initialize($semenindonesia['conf']);
    $this->email->from($from);
    $this->email->to($to);
    // $this->email->cc('pengadaan.semenindonesia@gmail.com');
    if(!empty($cc)){
       $this->email->cc($cc);
    }
    if(!empty($bcc)){
       $this->email->bcc($bcc);
    }

    if(!empty($attachment)){
      $this->email->attach($attachment);
    }

    $this->email->subject($subject);
    $this->email->message($message);
    return $this->email->send();
  }

  public function invoiceNotifikasi($to,$message,$subject,$from = NULL,$cc = NULL, $bcc = NULL,$attachment = NULL){
    $from = 'Tim E-Invoice Semen Indonesia';
    //$bcc = 'nur.syamsu@sisi.id,ahmad.afandi@sisi.id,alimutaqin@gmail.com';
	  $bcc = '';
		$cc = NULL;
//		$to = 'yuwaka33@gmail.com';
    return $this->send($to,$message,$subject,$from,$cc,$bcc,$attachment);
  }

    public function ecatalogNotifikasi($to,$message,$subject,$from = NULL,$cc = NULL, $bcc = NULL,$attachment = NULL){
        $from = 'Tim E-Invoice Semen Indonesia';
        //$bcc = 'nur.syamsu@sisi.id,ahmad.afandi@sisi.id,alimutaqin@gmail.com';
        $bcc = '';
        $cc = NULL;
//		$to = 'yuwaka33@gmail.com';
        return $this->send($to,$message,$subject,$from,$cc,$bcc,$attachment);
    }

	public function test(){
		return 'fiso';
	}
}
