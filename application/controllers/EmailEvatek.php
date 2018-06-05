<?php defined('BASEPATH') OR exit('No direct script access allowed');

class EmailEvatek extends CI_Controller {

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

	public function get_datatable() {
		// error_reporting(E_ALL);
		$this->load->model('prc_tender_main');
		$this->load->model('adm_employee_atasan');
		$this->load->model('log_scheduler');

		$MKCCTR = $this->session->userdata('MKCCTR');
		$pgrp = $this->session->userdata('PRGRP');
		$kd_user = $this->session->userdata('GRPAKSES');
		$this->prc_tender_main->join_latest_activity();
		$this->prc_tender_main->join_prep();
		$this->prc_tender_main->kondisi_evatek();
		$this->prc_tender_main->orderNameEvatek();
		$datatable = $this->prc_tender_main->get();

		// PTM_COMPANY_ID
		// PTC_END_DATE
		// echo "<pre>";
		// print_r($datatable);die;
		foreach ($datatable as $dt) {
			// ambil atasan
			$hasil_atasan1 = $this->adm_employee_atasan->get_atasan_baru_evatek($dt['ID'], null, 'SECT');
			$hasil_atasan2 = $this->adm_employee_atasan->get_atasan_baru_evatek($dt['ID'], null, 'BIRO');
			$hasil_atasan3 = $this->adm_employee_atasan->get_atasan_baru_evatek($dt['ID'], null, 'DEPT');
			$email1 = "";
			$email2 = "";
			$email3 = "";
			$subject = "";
			
			if(count($hasil_atasan1)>0){
				// $email1 = $hasil_atasan1[0]['email_atasan'];
				$email1 = 'tithe.j@sisi.id';
			}
			if(count($hasil_atasan2)>0){
				// $email2 = $hasil_atasan2[0]['email_atasan'];
				$email2 = 'amin.erfandy@sisi.id';
			} 
			if(count($hasil_atasan3)>0){
				// $email3 = $hasil_atasan3[0]['email_atasan'];
				$email3 = 'archie.putra@sisi.id';
			}

			if($dt['SELISIH']==4){
				// 3
				$gabung = "";
				if($email1!=""){
					$gabung.=$email1;
				}
				$subject = 'Reminder 4 hari';
				$dt['PESAN'] = 'Mohon segera di lakukan evaluasi PR/LB berikut.';
				$this->emailReminderEvatek($dt, $subject, 4, $gabung);
			} else if ($dt['SELISIH']==7) {
				// 7
				$gabung = "";
				if($email1!=""){
					$gabung.=$email1;
				}
				if($email2!=""){
					$gabung.=','.$email2;
				}
				$subject = 'Reminder 7 hari';
				$dt['PESAN'] = 'Mohon segera di lakukan evaluasi PR/LB lewat dari 7 hari PR ini tdk dapat kami proses.';
				$this->emailReminderEvatek($dt, $subject, 7, $gabung);
			} else if ($dt['SELISIH']>=10) {
				// 10
				$gabung = "";
				if($email1!=""){
					$gabung.=$email1;
				}
				if($email2!=""){
					$gabung.=','.$email2;
				}
				if($email3!=""){
					$gabung.=','.$email3;
				}
				$subject = 'Reminder 10 hari';
				$dt['PESAN'] = 'PR/LB Berikut Kami batalkan karena evaluasi teknis belum kami terima (PR/LB Kami anggap
				permintaan tidak di butuhkan).';
				$this->emailReminderEvatek($dt, $subject, 10, $gabung);
			} else {
			}

			// LOG SCHEDUL
			if(!empty($subject)){
				$data['OBJECT_KEY'] = $dt['PTM_PRATENDER'];
				// $CONTENT['SUBJECT'] = $subject;
				$CONTENT['SUBJECT'] = "Reminder Evaluasi Teknis";
				$CONTENT['TO'] = $dt['EMAIL'];
				$CONTENT['CC'] = $gabung;
				$data['CONTENT'] = json_encode($CONTENT);
				$this->log_scheduler->insert($data);
			}
			// LOG SCHEDUL
		}
		// die;
	}	

	function emailReminderEvatek($data, $subject, $hari, $gabung) {	
		$this->load->library('email');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		$this->email->to('tithe.j@sisi.id');  
    	// $this->email->to($data['EMAIL']);
		if(!empty($gabung) || $gabung!=""){
			$this->email->cc($gabung);
		}

		// $this->email->subject('['.$data['EMAIL'].']'.$subject);
		$this->email->subject("Reminder Evaluasi Teknis");
		$content = $this->load->view('email/tender_reminder',$data,TRUE);
		$this->email->message($content);
		$this->email->send();
	}

}