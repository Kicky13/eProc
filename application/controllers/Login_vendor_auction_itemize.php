<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login_vendor_auction_itemize extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user_agent');
		#$this->load->model(array('user_model','user_vendor_model_simpel'));
		$this->load->model(array('user_vendor_auction_itemize'));
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
		$img_url = base_url()."static/images/captcha/";
		$vals = array(
			'img_path' => './static/images/captcha/',
			'img_url' => $img_url,
			'img_width' => '150',
			'img_height' => 40,
			'expiration' => 3600
		);
		$data['captcha'] = create_captcha($vals);
		#$this->load->model('adm_company');
		#$data['company'] = $this->adm_company->get_all(array('ISACTIVE' => 1));
		$this->session->set_userdata('captchaWord', $data['captcha']['word']);
		$this->layout->add_js('plugins/jquery.capslockstate.js');
		$this->layout->add_js('pages/login.js');
		$this->layout->render('auth/login_vendor_auction_itemize',$data);
	}

	function doLoginVendor_simpel() {
		$captcha = $this->input->post('captcha');
		if ($captcha == $this->session->userdata('captchaWord')) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			#$companyid = $this->input->post('companyid');
			#$loginStatusQuery = $this->user_vendor_model_simpel->getUser($username, $password, $companyid);
			$loginStatusQuery = $this-> user_vendor_auction_itemize -> getUser($username, $password);
			$loginStatus = $loginStatusQuery[0];
			// var_dump($loginStatusQuery);exit();
			if ($loginStatus) {
				// if ($loginStatus->STATUS == '4') {
                                        #echo "SIP";
					#$this->session->set_userdata('loadVendorDashboard', TRUE);
					$this->session->set_userdata('EC_Auction_itemize_negotiation', TRUE);                                        
					foreach ($loginStatus as $key => $value) {
							$this->session->set_userdata($key, $value);
						}
						$this->session->set_userdata('logged_in', TRUE);
						$this->session->set_userdata('is_vendor', TRUE);
						$this->session->set_userdata('vendor_table', 'VND');
						$this->session->set_userdata('VENDOR_NAME', $loginStatus->NAMA_VENDOR);

						//NEW
						$this->session->set_userdata('USERNAME', $loginStatus->NAMA_VENDOR);						

						// echo "<pre>";
						// print_r($this->session->userdata); 
						// die();
						//$this->session->set_userdata('USERNAME');						
					#redirect(base_url());
                                        #redirect(base_url(EC_Auction_negotiation));
                                        #$this->session->set_userdata('FULLNAME', $loginStatus->NAMA_VENDOR);    
                                        #redirect(site_url('EC_Auction_negotiation'),'refresh');
                                        redirect(site_url('EC_Auction_itemize_negotiation'));
                                        // echo "<pre>";
                                        // print_r($this->session->userdata); 

				// }
			}
			else {
                                $this->loadLoginVendor_simpel();                                
                                /*echo "SALAH";
                                die();
				#$loginStatusQuery = $this->user_vendor_model_simpel->getTempUser($username, $password, $companyid);
                                #$loginStatusQuery = $this->user_vendor_model_simpel->getTempUser($username, $password);
				#$loginStatus = $loginStatusQuery[0];
				// var_dump("masuk");
				// var_dump($loginStatusQuery);
				// die();
				if ($loginStatus) {
					if ($loginStatus->STATUS == '1' or $loginStatus->STATUS == '2') {
						$data['title'] = 'Halaman Login e-Procurement Simpel';
						$data['status_vnd'] = $loginStatus->STATUS;
                                                $this->layout->render('auth/vendor_reveiwed',$data);
                                                echo "sukses";
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
						$this->session->set_userdata('vendor_table', 'TMP');
						$this->session->set_userdata('FULLNAME', $loginStatus->NAMA_VENDOR);
						$this->session->set_userdata('ROLE', 3);
						redirect(base_url());
                                                echo "TES";
					}
				}
				else {
					$this->loadLoginVendor_simpel();
                                        echo "LOGIN SALAH";
				}
			*/}
		}
		else {
			$this->loadLoginVendor_simpel();
		}
	}

	function doLogout_simpel() {
		if ($this->session->userdata('is_vendor')) {
			$this->session->sess_destroy();
			redirect(site_url('Login_vendor_auction_itemize/loadLoginVendor_simpel'), 'refresh');
		}
		else {
			$this->session->sess_destroy();
			redirect(site_url('Login_vendor_auction_itemize'),'refresh');
		}
	}
}
