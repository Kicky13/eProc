<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Forget extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model(array('user_model','user_vendor_model','vnd_header','tmp_vnd_header'));
		$this->load->library('Layout');
		$this->load->helper(array('captcha'));
	}

	public function index() {
		$this->loadLoginVendor();
	}

	function loadLoginVendor() {
		$data['title'] = 'Lupa Password e-Procurement';
		$img_url = base_url()."static/images/captcha/";
		$vals = array(
			'img_path' => './static/images/captcha/',
			'img_url' => $img_url,
			'img_width' => '150',
			'img_height' => 40,
			'expiration' => 3600
			);
		$data['captcha'] = create_captcha($vals);
		$this->load->model('adm_company');
		$data['company'] = $this->adm_company->get_all(array('ISACTIVE' => 1));
		$this->session->set_userdata('captchaWord', $data['captcha']['word']);
		$this->layout->add_js('plugins/jquery.capslockstate.js');
		$this->layout->add_js('pages/login.js');
		$this->layout->render('auth/forget',$data);
	}

	function getNewPassword() {
		$captcha = $this->input->post('captcha');
		if ($captcha == $this->session->userdata('captchaWord')) {
			$email = $this->input->post('email');
			$companyid = $this->input->post('companyid');
			$resetStatusQuery = $this->user_vendor_model->getNewPassword($email, $companyid);
			$resetStatus = $resetStatusQuery[0];
			// echo '<pre>'; var_dump($resetStatus); echo '</pre>';die;
			
			//var_dump($this->fRand(8));die;
			
			if (count($resetStatus)>0) {
				$password_new=$this->fRand(8);

				if (!empty($resetStatus->VENDOR_NO)) { 
					$username=$resetStatus->LOGIN_ID; 
					$vendorno=$resetStatus->VENDOR_NO;
					$email=$resetStatus->EMAIL_ADDRESS;
					$data=array(
						'PASSWORD'=>md5($password_new)
						);
					$where=array(
						'VENDOR_ID'=>$resetStatus->VENDOR_ID
						);
					$this->vnd_header->update($data,$where);
					$this->emailNotification($email,$username,$password_new,$vendorno);
					$this->successRequest();
				} else { 
					$username=$resetStatus->LOGIN_ID; 
					$vendorno='';
					$email=$resetStatus->EMAIL_ADDRESS;
					$data=array(
						'PASSWORD'=>md5($password_new)
						);
					$where=array(
						'VENDOR_ID'=>$resetStatus->VENDOR_ID
						);
					$this->tmp_vnd_header->update($data,$where);
					$this->emailNotification($email,$username,$password_new,$vendorno);
					$this->successRequest();
				}

			}
			else { 
				$this->session->set_flashdata('error','error');
				redirect(site_url('Forget'),'refresh');
			}
		}
		else {
			redirect(site_url('Forget'),'refresh');
		}
	}

	function successRequest() {		
		$data['title'] = 'Forget Password e-Procurement';
		// $this->layout->add_js('plugins/jquery.capslockstate.js');
		// $this->layout->add_js('pages/login.js');
		$this->layout->render('auth/success',$data);
	}

	function fRand($len) {
		$str = '';
		$a = "abcdefghijklmnopqrstuvwxyz";
		$number = "0123456789";
		$b = str_split($a.$number.strtoupper($a));
		for ($i=1; $i <= $len ; $i++) { 
			$str .= $b[rand(0,strlen($a)-1)];
		}
		return $str;
	}

	function emailNotification($email,$username,$password,$vendorno){
		$this->load->library('email');
		$this->load->model('adm_company');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		// print_r($semenindonesia);die;
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		$this->email->to($email);
		$this->email->subject("Password Request for eProcurement PT. Semen Indonesia (Persero) Tbk.");
		$data['vendorno'] = $vendorno;
		$data['company'] = $this->adm_company->get(array('ISACTIVE' => 1));
		$data['session_id'] = $this->session->userdata("session_id");
		$data['username'] = $username;
		$data['password'] = $password;
		// echo "<pre>";
		// print_r($data);
		// die;
		$content = $this->load->view('email/success_password_vendor',$data,TRUE);
		$this->email->message($content);
		$this->email->send();
	}
}
