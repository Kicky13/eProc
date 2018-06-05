<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TesEmail extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Layout');

	}

	public function index() {
		$data['title'] = 'Testing';
		$this->layout->render('email_test',$data);
	}

		// $this->email->to('seblang_wangi@yahoo.com');
	function email_default() {

        $this->load->library('email');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);		
		// $this->email->to('seblang_wangi@yahoo.com');
		$this->email->to('gutamaarchie@gmail.com');
		// $this->email->cc('rinyoes7@gmail.com');
		$this->email->subject("Registration Confirmation for eProcurement PT. Semen Gresik (Persero) Tbk.");

		$content = $this->load->view('email/success_regist_vendor',$data,TRUE);
		$this->email->message($content);
		$this->email->send();
		

		redirect('TesEmail/index');
		
	}

	function email_vendor() {
		

        $this->load->library('email');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);		
		// $this->email->to('kamijaya.berindo@gmail.com');
		// $this->email->cc('pengadaan.semenindonesia@gmail.com');
		$this->email->to('gutamaarchie@gmail.com');
		$this->email->subject("Registration Confirmation for eProcurement PT. Semen Gresik (Persero) Tbk.");
		
		$content = $this->load->view('email/success_regist_vendor',$data,TRUE);
		$this->email->message($content);
		$this->email->send();
		

		redirect('TesEmail/index');
		
	}

	function email_php() { 
        $to      = 'gutamaarchie@gmail.com';
        // $to      = 'maulana.danang@gmail.com';
		$subject = 'Testing Email';
		$message = 'Email testing trobel';
		$headers = 'From: Semen.Indonesia@dev-app.sggrp.com' . "\r\n" .
    				'Reply-To: Semen.Indonesia@dev-app.sggrp.com' . "\r\n" .
    				'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);

		redirect('TesEmail/index');
		
	}
	

}