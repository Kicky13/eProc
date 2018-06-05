<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('user_agent');
		$this->load->model(array('user_model','user_vendor_model'));
		$this->load->library('Layout');
		$this->load->helper(array('captcha'));
		$this->load->library('active_directory');
		
		
	}

	public function index() {
		
		if($this->agent->browser()=='Internet Explorer'){
			$this->load->view('brec');
		}else{
			$this->loadLoginForm();
		}
	}
	
	

	public function loadLoginForm($channel='ldap',$msg = null) {
		$data['channel'] = $channel;	
		$data['msg'] = $msg;	
		$data['title'] = 'Halaman Login e-Procurement';
		$this->layout->render('auth/login',$data);
	}

	function loadLoginVendor() {
		redirect('Login_vendor');
	}

	function loadLoginPrincipal() {
		redirect('Login_principal');
	}

	function doLogin() {				
		$user = $this->input->post('username');
		$password = $this->input->post('password');
		$channel = $this->input->post('channel');
		$current_url=(base_url().ltrim($_SERVER['REQUEST_URI'], '/'));
		if(strpos($current_url,'dev') !== false){
			$channel = 'eproc';
		}

		$pos = strstr($user,'@');/*cek apakah username yg dimasukkan lengkap dengan domain @semenindonesia.com*/		
		if($pos == "@semenindonesia.com"){			
			$username = $user;
		}else{
			$cekemail = strpos($user,'@');
			if($cekemail === false){/*cek jika tidak menggunakan domain sama sekali*/
				$username = $user."@semenindonesia.com";/*maka ditambahkan dengan domain @semenindonesia.com*/
			}else{/*jika menggunakan domain selain @semenindonesia.com tetap dibiarkan seperti apa adanya*/
				$username = $user;
			}
		}
		$Status=false;

		////////////////////////// cek user dari server LDAP
		// var_dump($channel);
		if($channel=='ldap'){
			$loginldap = $this->active_directory->test($username, $password);
			if($loginldap===false){			
				$msg='Email tidak terdaftar di LDAP<br> Silahkan Login lagi sebagai user eproc';
				redirect('Login/loadLoginForm/eproc/'.$msg);
				//die('Tidak punya user LDAP');
			}else{

				$loginStatusQuery = $this->user_model->getUserByEmail($username);
				if($loginStatusQuery){
					$Status=true;
				}else{
					$msg='Email tidak terdaftar di EPROC';
					redirect('Login/loadLoginForm/ldap/'.$msg);
					$Status=false;
				}
			}
		}else if($channel=='eproc'){
			// var_dump('tes');
			$loginStatusQuery = $this->user_model->getUser($username,$password);
			if($loginStatusQuery){
				$Status=true;
			}else{
				$msg='Email tidak terdaftar di EPROC';
				redirect('Login/loadLoginForm/ldap/'.$msg);
				$Status=false;
			}
		}
		////////////////////////*/
		// var_dump($Status);
		// var_dump($loginStatusQuery); exit();
		if ($Status) {
			$loginStatus = $loginStatusQuery[0];
			foreach ($loginStatus as $key => $value) {
				$this->session->set_userdata($key, $value);
			}
			$data_user=$this->user_model->prog($this->session->userdata('ID'));
			$this->session->set_userdata('PRGRP', $data_user);

			$this->load->model('adm_purch_grp');
			$opco = $loginStatus->EM_COMPANY;
			$admpgrp = $this->adm_purch_grp->get_by_opco($opco);
            $grpakses = $this->adm_purch_grp->get_grp_akses($this->session->userdata('ID'));
			// var_dump($opco);
			// var_dump($admpgrp);
			// die();
			// $kelprgrp=$this->user_model->kelprgrp($data_user);
			$this->session->set_userdata('KEL_PRGRP', $admpgrp[0]['KEL_PURCH_GRP']);
			
			$name = $loginStatus->FULLNAME;

			$this->session->set_userdata('logged_in', TRUE);
			$this->session->set_userdata('is_vendor', FALSE);
			$this->session->set_userdata('FULLNAME', $name);
			$this->session->set_userdata('USERNAME', $username);
            $this->session->set_userdata('GRPAKSES', $grpakses);
			redirect(base_url());
		}
		else {
			$this->loadLoginForm();
		}
	}

	function doLoginVendor() {
		$captcha = $this->input->post('captcha');
		if ($captcha == $this->session->userdata('captchaWord')) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$companyid = $this->input->post('companyid');
			$loginStatusQuery = $this->user_vendor_model->getUser($username, $password, $companyid);
			$loginStatus = $loginStatusQuery[0];
			if ($loginStatus) {
				// if ($loginStatus->STATUS == '4') {
					$this->session->set_userdata('loadVendorDashboard', TRUE);
					foreach ($loginStatus as $key => $value) {
							$this->session->set_userdata($key, $value);
						}
						$this->session->set_userdata('logged_in', TRUE);
						$this->session->set_userdata('is_vendor', TRUE);
						$this->session->set_userdata('FULLNAME', $loginStatus->VENDOR_NAME);
					redirect(base_url());
				// }
			}
			else {
				$loginStatusQuery = $this->user_vendor_model->getTempUser($username, $password, $companyid);
				$loginStatus = $loginStatusQuery[0];
				if ($loginStatus) {
					if ($loginStatus->STATUS == '1' or $loginStatus->STATUS == '2') {
						$data['title'] = 'Halaman Login e-Procurement';
						$this->layout->render('auth/vendor_reveiwed',$data);
					}
					else {
						if ($loginStatus->STATUS == '99') {
							$this->session->set_userdata('update_vendor_data',TRUE);
						}
						foreach ($loginStatus as $key => $value) {
							$this->session->set_userdata($key, $value);
						}
						$this->session->set_userdata('logged_in', TRUE);
						$this->session->set_userdata('is_vendor', TRUE);
						$this->session->set_userdata('FULLNAME', $loginStatus->VENDOR_NAME);
						$this->session->set_userdata('ROLE', 3);
						redirect(base_url());
					}
				}
				else {
					$this->loadLoginVendor();
				}
			}
		}
		else {
			$this->loadLoginVendor();
		}
	}

	function doLogout() {
		if ($this->session->userdata('is_vendor')) {
			$this->session->sess_destroy();
			redirect(site_url('Login/loadLoginVendor'),'refresh');
		}else if ($this->session->userdata('is_principal')) {
			$this->session->sess_destroy();
			redirect(site_url('Login/loadLoginPrincipal'),'refresh');
		}
		else {
			$this->session->sess_destroy();
			redirect(site_url('Login'),'refresh');
		}
	}

	function doLogout2() {
			$this->session->sess_destroy();
			redirect(site_url('Login_vendor_simpel'),'refresh');
	}
}
