<?php defined('BASEPATH') OR exit('No direct script access allowed');

class List_po extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Layout');
		$this->load->helper(array('captcha'));
	}

	public function index() {
		$this->load->model(array('adm_company', 'm_vnd_type'));
		
		$data['title'] = 'Mulai Pembuatan Akun Vendor';
		$data['company'] = $this->adm_company->as_dropdown('COMPANYNAME')->get_all(array('ISACTIVE' => 1));
		
		$this->layout->add_js('pages/registration.js');
		$this->layout->render('vmi/list_po',$data);
	}

	public function ListPO(){
		$this->load->model('M_vmi_list_po');
		
	}

	// public function getRegistrationDateStatus() {
	// 	$this->load->model('vnd_reg_announcement');
	// 	$date = $this->vnd_reg_announcement->with('company')->get(array('COMPANYID' => $this->input->post('company')));
	// 	$companyname = $date["company"]["COMPANYNAME"];
	// 	$startRegist = $date["OPEN_REG"];
	// 	$endRegist = $date["CLOSE_REG"];
	// 	$today = date('d F Y');
	// 	$startDate = date('d F Y', strtotime(substr($date['OPEN_REG'],0,9)));
	// 	$endDate = date('d F Y', strtotime(substr($date['CLOSE_REG'],0,9)));
	// 	if ((strtotime($today) - strtotime($startDate)) >= 0 and (strtotime($today) - strtotime($endDate)) >= 0) {
	// 		$data['message'] = "Mohon maaf, untuk sementara waktu $companyname belum menerima pendaftaran Vendor";
	// 		$data['flag'] = -1;
	// 	}
	// 	elseif ((strtotime($today) - strtotime($startDate)) >= 0 and (strtotime($today) - strtotime($endDate)) <= 0) {
	// 		$data['flag'] = 1;
	// 	}
	// 	elseif ((strtotime($today) - strtotime($startDate)) <= 0 and (strtotime($today) - strtotime($endDate)) <= 0) {
	// 		$data['message'] = "Pendaftaran Vendor di $companyname dibuka mulai tanggal $startRegist sampai $endRegist";
	// 		$data['flag'] = 99;
	// 	}
	// 	echo json_encode($data);
	// }

	public function initialize()
	{
		$companyid = $this->input->post('Company');
		$this->load->model(array('vnd_reg_announcement', 'm_vnd_type'));
		$date = $this->vnd_reg_announcement->with('company')->get(array('COMPANYID' => $companyid));
		$companyname = $date["company"]["COMPANYNAME"];
		$startRegist = $date["OPEN_REG"];
		$endRegist = $date["CLOSE_REG"];
		$today = date('d F Y');
		$startDate = date('d F Y', strtotime($date['OPEN_REG']));
		$endDate = date('d F Y', strtotime($date['CLOSE_REG']));
		if ((strtotime($today) - strtotime($startDate)) >= 0 and (strtotime($today) - strtotime($endDate)) <= 0) {
			$this->load->model('m_vnd_prefix');
			$this->load->model('m_vnd_suffix');
			$this->load->model('adm_company');
			$data['selected_company'] = $companyid;
			$data['prefix'] = create_standard($this->m_vnd_prefix->get_all(), 'Prefix');
			$data['suffix'] = create_standard($this->m_vnd_suffix->get_all(), 'Suffix');
			$data['company'] = $this->adm_company->get_all();
			$data['title'] = 'Pembuatan Akun Vendor';
			$img_url = base_url()."static/images/captcha/";
			$vals = array(
				'img_path' => './static/images/captcha/',
				'img_url' => $img_url,
				'img_width' => '150',
				'img_height' => 40,
				'expiration' => 3600
			);
			$data['captcha'] = create_captcha($vals);
			$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
			$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
			$this->layout->add_js('pages/registration.js');
			$this->session->set_userdata('captchaWord', $data['captcha']['word']);
			$this->layout->render('vmi/form_create_user',$data);
		}
		else {
			redirect(base_url(),'refresh');
		}
	}

	// function do_create_vendor() {
	// 	$this->load->model('tmp_vnd_header');
	// 	$this->load->model('adm_company');
	// 	$prefix = $this->input->post('prefix') == 0 ? null : $this->input->post('prefix');
	// 	$company_name = $this->input->post('company_name');
	// 	$suffix = $this->input->post('suffix') == 0 ? null : $this->input->post('suffix');
	// 	$username = $this->input->post('username');
	// 	$email = $this->input->post('email');
	// 	$password = $this->input->post('password');
	// 	$password2 = $this->input->post('password2');
	// 	$captcha = $this->input->post('captcha');
	// 	$companyid = $this->input->post('companyid');
	// 	$vendor_type = $this->input->post('vendor_type');
	// 	$reg_sessionid = $this->session->userdata("session_id");
	// 	$data = array(
	// 		"VENDOR_EDIT_ID" => "1",
	// 		"VENDOR_NAME" => $company_name,
	// 		"LOGIN_ID" => $username,
	// 		"PASSWORD" => md5($password),
	// 		"EMAIL_ADDRESS" => $email,
	// 		"PREFIX" => $prefix,
	// 		"SUFFIX" => $suffix,
	// 		"VENDOR_TYPE" => $vendor_type,
	// 		"STATUS" => "0",
	// 		"REG_ISACTIVATE" => "0",
	// 		"REG_SESSIONID" => $reg_sessionid,
	// 		"COMPANYID" => $companyid
	// 	);
	// 	$this->tmp_vnd_header->insert($data);

	// 	//--LOG MAIN--//
	// 		$this->log_data->main(NULL,$company_name,'VENDOR','Registration','OK',$this->input->ip_address());
	// 		$LM_ID = $this->log_data->last_id();
	// 	//--END LOG MAIN--//

	// 	//--LOG DETAIL--//
	// 		$this->log_data->detail($LM_ID,'Register/do_create_vendor','tmp_vnd_header','insert',$data);
	// 	//--END LOG DETAIL--//


		
	// 	$this->load->library('email');
	// 	$config['protocol']    = 'smtp';
	// 	$config['smtp_host']    = 'ssl://smtp.gmail.com';
	// 	$config['smtp_port']    = '465';
	// 	$config['smtp_timeout'] = '7';
	// 	$config['smtp_user']    = 'royyan.bachtiar@gmail.com';
	// 	$config['smtp_pass']    = '02121994';
	// 	$config['charset']    = 'utf-8';
	// 	$config['newline']    = "\r\n";
	// 	$config['mailtype'] = 'html'; // or html
	// 	$config['validation'] = TRUE; // bool whether to validate email or not      

	// 	$this->email->initialize($config);


	// 	$this->email->from('royyan.bachtiar@gmail.com', 'Royyan Bachtiar');
	// 	$this->email->to($email); 

	// 	$this->email->subject('Registration Confirmation for eProcurement PT. Semen Gresik (Persero) Tbk.');
	// 	$this->email->message('<html><body>[Testing]<br>Silahkan Klik Link di bawah ini:<br> <a href="'.site_url('register/activate/'.$this->session->userdata("session_id")).'"></a></body></html>'); 
 //        // Set to, from, message, etc.

 //        $result = $this->email->send();
 //        $this->load->library('email');
	// 	$this->config->load('email'); 
	// 	$semenindonesia = $this->config->item('semenindonesia'); 
	// 	$this->email->initialize($semenindonesia['conf']);
	// 	$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
	// 	$this->email->cc('pengadaan.semenindonesia@gmail.com');				
	// 	$this->email->to($email);
	// 	if ($companyid == '7000' || $companyid == '5000' || $companyid == '2000') {
	// 		$this->email->subject("Registration Confirmation for eProcurement PT. Semen Indonesia (Persero) Tbk.");
	// 	} else if ($companyid == '3000') {
	// 		$this->email->subject("Registration Confirmation for eProcurement PT. Semen Padang.");
	// 	} else if ($companyid == '4000') {
	// 		$this->email->subject("Registration Confirmation for eProcurement PT. Semen Tonasa.");
	// 	}
		
	// 	$data['selected_company'] = $companyid;
	// 	$data['company'] = $this->adm_company->get(array('ISACTIVE' => 1));
	// 	$data['session_id'] = $this->session->userdata("session_id");
	// 	$data['account'] = array('username'=>$username, 'password'=>$password);
	// 	$content = $this->load->view('email/success_regist_vendor',$data,TRUE);
	// 	$this->email->message($content);
	// 	$this->email->send();
	// 	$data['title'] = 'Berhasil Membuat Akun Vendor';
	// 	$this->layout->render('registration/success_create_user',$data);
		
	// }
	
	// function activate($session_id) {
	// 	$this->load->model('tmp_vnd_header');
	// 	$where = array('REG_ISACTIVATE' => '0', 'REG_SESSIONID' => $session_id);
	// 	$vendor = $this->tmp_vnd_header->get($where);
	// 	// var_dump($vendor); var_dump(count($vendor)); exit();

	// 	//--LOG MAIN--//
	// 		$this->log_data->main(NULL,$vendor['VENDOR_NAME'],'VENDOR','Registration (Aktivate)','AKTIVASI',$this->input->ip_address());
	// 		$LM_ID = $this->log_data->last_id();
	// 	//--END LOG MAIN--//

	// 	$data['title'] = 'Aktivasi Akun Vendor';
	// 	if ($vendor == false) {
	// 		$this->layout->render('registration/fail_activate_user', $data);
	// 	} else {
	// 		$data['session_id'] = $session_id;
	// 		$this->layout->render('registration/success_activate_user', $data);
	// 	}
	// 	$this->tmp_vnd_header->update(array('REG_ISACTIVATE' => '1'), $where);
	// 	//--LOG DETAIL--//
	// 		$aktivate = array('REG_ISACTIVATE' => '1');
	// 		$this->log_data->detail($LM_ID,'Register/activate','tmp_vnd_header','update',$aktivate,$where);
	// 	//--END LOG DETAIL--//

	// }

	// function finalize($session_id) {
	// 	$this->load->model('tmp_vnd_header');
	// 	$vendor = $this->tmp_vnd_header->get(array("REG_SESSIONID" => $session_id));
	// 	if ($vendor == false) {
	// 		redirect('Register/activate/'.$session_id);
	// 	}
	// 	$sess = array(
	// 		'VENDOR_ID' => $vendor["VENDOR_ID"],
	// 		'VENDOR_NAME' => $vendor["VENDOR_NAME"],
	// 		'LOGIN_ID' => $vendor["LOGIN_ID"],
	// 		'PASSWORD' => $vendor["PASSWORD"],
	// 		'VENDOR_NO' => $vendor["VENDOR_NO"],
	// 		'STATUS' => $vendor["STATUS"],
	// 		'REG_STATUS_ID' => $vendor["REG_STATUS_ID"],
	// 		'REG_ISACTIVATE' => $vendor["REG_ISACTIVATE"],
	// 		'COMPANYID' => $vendor["COMPANYID"],
	// 		'logged_in' => TRUE,
	// 		'is_vendor' => TRUE
	// 	);
	// 	$this->session->set_userdata($sess);
	// 	redirect('Administrative_document/general_data');
	// }

	// function checkEmailHasTaken($companyid) {
	// 	$this->load->model(array('tmp_vnd_header', 'vnd_header'));
	// 	$email = $this->input->post('email');
	// 	$flag[0] = $this->vnd_header->get(array('EMAIL_ADDRESS' => $email, 'COMPANYID' => $companyid));
	// 	$flag[1] = $this->tmp_vnd_header->get(array('EMAIL_ADDRESS' => $email, 'COMPANYID' => $companyid));
	// 	$return = array('valid' => FALSE);
	// 	if ($flag[0] || $flag[1]) {
	// 		$return['message'] = 'Email sudah digunakan';
	// 	}
	// 	else {
	// 		$return['valid'] = TRUE;
	// 	}
	// 	echo json_encode($return);
	// }

	// function checkUsernameHasTaken($companyid) {
	// 	$this->load->model(array('tmp_vnd_header', 'vnd_header'));
	// 	$username = $this->input->post('username');
	// 	$flag[0] = $this->vnd_header->get(array('LOGIN_ID' => $username, 'COMPANYID' => $companyid));
	// 	$flag[1] = $this->tmp_vnd_header->get(array('LOGIN_ID' => $username, 'COMPANYID' => $companyid));
	// 	$return = array('valid' => FALSE);
	// 	if ($flag[0] || $flag[1]) {
	// 		$return['message'] = 'username sudah digunakan';
	// 	}
	// 	else {
	// 		$return['valid'] = TRUE;
	// 	}
	// 	echo json_encode($return);
	// }

	// function coba() {
	// 	$this->load->model('adm_company');
	// 	$data['title'] = 'Mulai Pembuatan Akun Vendor';
	// 	$data['company'] = $this->adm_company->as_dropdown('COMPANYNAME')->get_all(array('ISACTIVE' => 1));
	// 	$this->layout->add_js('pages/registration.js');

 //        $this->load->library('email');
	// 	$this->config->load('email'); // email ini nama file di folder config
	// 	$conf_yahoo = $this->config->item('semenindonesia'); // yahoo ini nama index array di file config email, siapa tahu ada lebih dari 1 akun email
	// 	$this->email->initialize($conf_yahoo['conf']);
	// 	$this->email->from($conf_yahoo['credential'][0],$conf_yahoo['credential'][1]);
	// 	$this->email->to('contact.widodo@gmail.com');
	// 	$this->email->subject("Registration Confirmation for eProcurement PT. Semen Gresik (Persero) Tbk.");
	// 	$data['selected_company'] = "Semen Indonesia";
	// 	$data['company'] = "Semen Indonesia";
	// 	$data['session_id'] = $this->session->userdata("session_id");
	// 	$content = $this->layout->render('registration/form_start_registration',$data,true);
	// 	$this->email->message($content);
	// 	$this->email->send();
	// 	var_dump("nice");
	// }
}