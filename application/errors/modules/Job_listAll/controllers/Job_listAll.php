<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Job_listAll extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Layout');
	}

	public function index() {
		$this->load->model('prc_tender_main');
		$this->load->model('adm_employee');

		$this->prc_tender_main->join_latest_activity('email_cronJob');
		$data = $this->prc_tender_main->orderName();

		foreach ($data as $val) {
			$data2[$val['ID']][] = $val;
		}

		foreach ($data2 as $key => $value) {
			$cek = $this->adm_employee->get(array('ID'=>$key));
			if(isset($cek) && $cek[0]['STATUS']=='Active'){
				$data_email['EMAIL_ADDRESS']=$value[0]['EMAIL'];
				$data_email['data']['detail']=$value;
				$this->kirim_email($data_email);
			}
		}
		
		
	}

	public function kirim_email($data_email){
		$this->load->library('email');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		$this->email->to($data_email['EMAIL_ADDRESS']);
		$this->email->cc('pengadaan.semenindonesia@gmail.com');
		$this->email->subject("Daftar Pekerjaan dari eProcurement PT. Semen Indonesia (Persero) Tbk.");
		$content = $this->load->view('email_daftar_pekerjaan',$data_email['data'],TRUE);
		$this->email->message($content);
		$this->email->send();
	}

}
