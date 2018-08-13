<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login_vendor extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user_agent');
		$this->load->model(array('user_model','user_vendor_model'));
		$this->load->library('Layout');
		$this->load->helper(array('captcha'));
	}

	public function index() {
		if($this->agent->browser()=='Internet Explorer'){
			$this->load->view('brec');
		}else{
			$this->loadLoginVendor();
		}
		
	}

	function loadLoginVendor() {
		$data['title'] = 'Halaman Login e-Procurement';
		$img_url = base_url()."static/images/captcha/";
		$vals = array(
			'img_path' => './static/images/captcha/',
			'img_url' => $img_url,
			'img_width' => '150',
			'img_height' => 40,
			'expiration' => 3600,
			'word_length'   => 6
		);
		$data['captcha'] = create_captcha($vals);
		$this->load->model('adm_company');
		$data['company_name'] = $this->adm_company->get_all(array('ISACTIVE' => 1));
		// echo "<pre>";
		// print_r($data['company_name']);die;
		$this->session->set_userdata('captchaWord', $data['captcha']['word']);
		$this->layout->add_js('plugins/jquery.capslockstate.js');
		$this->layout->add_js('pages/login.js');
		$this->layout->render('auth/login_vendor',$data);

		// var_dump($this->session->userdata);
	}

	function doLoginVendor() {
		$captcha = $this->input->post('captcha');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$companyid = $this->input->post('companyid');
		// if ($this->input->server('REQUEST_METHOD')=="POST" && $captcha == $this->session->userdata('captchaWord')) {
		if ($username != '' && $password != '' && $companyid != '' && $captcha == $this->session->userdata('captchaWord')) {
			$loginStatusQuery = $this->user_vendor_model->getUser($username, $password, $companyid);
			$loginStatus = $loginStatusQuery[0];
			//var_dump($loginStatusQuery);exit();
			if ($loginStatus) {
				// if ($loginStatus->STATUS == '4') {
					$this->session->set_userdata('loadVendorDashboard', TRUE);
					foreach ($loginStatus as $key => $value) {
							$this->session->set_userdata($key, $value);
						}
						$this->session->set_userdata('logged_in', TRUE);
						$this->session->set_userdata('is_vendor', TRUE);
						$this->session->set_userdata('vendor_table', 'VND');
						$this->session->set_userdata('FULLNAME', $loginStatus->VENDOR_NAME);
					redirect(base_url());
				// }
			}
			else {
				$loginStatusQuery = $this->user_vendor_model->getTempUser($username, $password, $companyid);
				$loginStatus = $loginStatusQuery[0];
				// var_dump("masuk");
				// var_dump($loginStatusQuery);
				// die();
				if ($loginStatus) {
					if ($loginStatus->STATUS == '1' or $loginStatus->STATUS == '2') {
						$data['title'] = 'Halaman Login e-Procurement';
						$data['status_vnd'] = $loginStatus->STATUS;
						$this->layout->render('auth/vendor_reveiwed',$data);
					} else if($loginStatus->STATUS == '-1'){
						redirect(base_url());
					} else {
						if ($loginStatus->STATUS == '99') {
							$this->session->set_userdata('update_vendor_data',TRUE);
						}
						foreach ($loginStatus as $key => $value) {
							$this->session->set_userdata($key, $value);
						}
						$this->session->set_userdata('logged_in', TRUE);
						$this->session->set_userdata('is_vendor', TRUE);
						$this->session->set_userdata('vendor_table', 'TMP');
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
			redirect(site_url('Login_vendor/loadLoginVendor'), 'refresh');
		}
		else {
			$this->session->sess_destroy();
			redirect(site_url('Login_vendor'),'refresh');
		}
	}
}
