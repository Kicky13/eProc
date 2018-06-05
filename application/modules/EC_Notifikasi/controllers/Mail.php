<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Mail extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		// $this->load->library('Authorization');
		$this->load->model(array('vnd_header'));
	}

  public function send(){
	
	$from 	= "muhammad.ramzi20@gmail.com";
	$to 	= "m.ramzi@sisi.id";
	$subject= "Coba mail";
	$cc 	= "muhammad.ramzi20@gmail.com";
	$bcc 	= "evilstar7@gmail.com";
	$message= "Nyoba email buat VMI bro";
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
    $bcc = 'nur.syamsu@sisi.id,ahmad.afandi@sisi.id';
	  //$bcc = '';
		$cc = NULL;
		$to = 'smi.einvoice@gmail.com';
    return $this->send($to,$message,$subject,$from,$cc,$bcc,$attachment);
  }

	public function test(){
		return 'fiso';
	}
}
