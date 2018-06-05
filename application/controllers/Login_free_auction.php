<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login_free_auction extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user_agent');
		$this->load->model(array('user_vendor_model_simpel'));
		$this->load->library('Layout');
		$this->load->helper(array('captcha'));
	}

	public function index() {
		if($this->agent->browser()=='Internet Explorer'){
			$this->load->view('brec');
		}else{
			$this->loadLoginVendor_simpel();
		}
		
	}

	function loadLoginVendor_simpel() {
		$data['title'] = 'Halaman Login e-Procurement';
		$this->layout->add_js('plugins/jquery.capslockstate.js');
		$this->layout->add_js('pages/login.js');
		$this->layout->render('auth/login_vendor_simpel',$data);
	}

	function doLoginVendor_simpel() {
		$captcha = $this->input->post('captcha');
		if ($captcha == $this->session->userdata('captchaWord')) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$loginStatusQuery = $this->user_vendor_model_simpel->getUser($username, $password);
			$loginStatus = $loginStatusQuery[0];
			if ($loginStatus) {
					$this->session->set_userdata('EC_Auction_negotiation', TRUE);                                        
					foreach ($loginStatus as $key => $value) {
							$this->session->set_userdata($key, $value);
						}
						$this->session->set_userdata('logged_in', TRUE);
						$this->session->set_userdata('is_vendor', TRUE);
						$this->session->set_userdata('vendor_table', 'VND');
						$this->session->set_userdata('VENDOR_NAME', $loginStatus->NAMA_VENDOR);
						redirect(site_url('EC_Auction_negotiation'));
			}
			else {
                                $this->loadLoginVendor_simpel();                                }
		}
		else {
			$this->loadLoginVendor_simpel();
		}
	}

	function doLogout_simpel() {
		if ($this->session->userdata('is_vendor')) {
			$this->session->sess_destroy();
			redirect(site_url('Login_free_auction/loadLoginVendor_simpel'), 'refresh');
		}
		else {
			$this->session->sess_destroy();
			redirect(site_url('Login_free_auction'),'refresh');
		}
	}
}
