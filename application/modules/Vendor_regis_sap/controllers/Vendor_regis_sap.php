<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_regis_sap extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->model(array('m_vnd_prefix','m_vnd_suffix','tmp_vnd_header','hist_vnd_header','tmp_vnd_akta','hist_vnd_akta', 'tmp_vnd_reg_progress', 'vnd_update_progress'));
		$this->prog_status = array();
		if (intval($this->session->userdata("VENDOR_ID")) > 0) {
			if($this->session->userdata('vendor_table')=='VND'){
				$temp = $this->vnd_update_progress->get_all_status(intval($this->session->userdata("VENDOR_ID")));
				if (!empty($temp)) {
					foreach ((array)$temp as $val) {
						$this->prog_status[$val['CONTAINER']] = $val;
					}
				}
			} else{
				$temp = $this->tmp_vnd_reg_progress->get_all_status(intval($this->session->userdata("VENDOR_ID")));
				if (!empty($temp)) {
					foreach ((array)$temp as $val) {
						$this->prog_status[$val['CONTAINER']] = $val;
					}
				}
			}
			
		}
	}

	public function index() {
		$this->registration_bypass();
	}

	public function registration_bypass(){

		$this->load->model('m_vnd_prefix');
		$this->load->model('m_vnd_suffix');

		$data['opco'] = $this->session->userdata['EM_COMPANY'];
		$data['company_name'] = $this->session->userdata['COMPANYNAME'];

		$data['prefix'] = create_standard($this->m_vnd_prefix->get_all(), 'Prefix');
		$data['suffix'] = create_standard($this->m_vnd_suffix->get_all(), 'Suffix');
		$data['title'] = 'Pembuatan Akun Vendor';
		 
		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/registration_bypass.js'); 
		$this->layout->render('form_create_user',$data);
	}

	function do_create_vendor() {
		$this->load->model(array('vnd_header','hist_vnd_header','vendor_employe','adm_company'));
		$opco = $this->session->userdata['EM_COMPANY'];

		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Registration SAP (Create VENDOR)','CREATE',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$prefix = $this->input->post('prefix') == 0 ? null : $this->input->post('prefix');
		$suffix = $this->input->post('suffix') == 0 ? null : $this->input->post('suffix');
		$company_name = $this->input->post('company_name');
		$username = $this->input->post('username');
		$vnd_no = $this->input->post('vendorno');
		$vendorno = str_pad($vnd_no,10,"0",STR_PAD_LEFT);
		$email = $this->input->post('email');
		$password = $this->input->post('password'); 
		$vendor_type = $this->input->post('vendor_type'); 
		$data = array( 
			"VENDOR_NAME" => $company_name,
			"VENDOR_NO" => $vendorno,
			"LOGIN_ID" => $username,
			"PASSWORD" => md5($password),
			"EMAIL_ADDRESS" => $email,
			"PREFIX" => $prefix,
			"SUFFIX" => $suffix,
			"VENDOR_TYPE" => $vendor_type,
			"STATUS" => "3",
			"REG_ISACTIVATE" => "1",
			"COMPANYID" => $opco
		);

		$vendor_id = $this->vnd_header->get_last_id();
		$vendor_id = $vendor_id + 1;
		$data["VENDOR_ID"] = $vendor_id;

		$this->vnd_header->insert($data);

		//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_regis_bypass/do_create_vendor','vnd_header','insert',$data);
		//--END LOG DETAIL--//

		$data["VND_TRAIL_ID"] = 3;
		$this->hist_vnd_header->insert($data);

		//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_regis_bypass/do_create_vendor','hist_vnd_header','insert',$data);
		//--END LOG DETAIL--//

		$this->load->library('email');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		$this->email->cc('pengadaan.semenindonesia@gmail.com');				
		$this->email->to($email);
		$data['vendorno'] = $vendorno;
		$data['username'] = $username;
		$data['password'] = $password;
		$data['vendorname'] = $company_name;
		$data['email'] = $email;

		$data_company = $this->vendor_employe->join_company_header($opco,$vendor_id);
		$this->email->subject("Registration Confirmation for eProcurement ".$data_company[0]['COMPANYNAME']." ");


		$content = $this->load->view('email/success_approve_vendor_sap',$data,TRUE);
		$this->email->message($content);
		$this->email->send();

		$msg = 'Create Vendor '.$company_name;
		$this->session->set_flashdata('success',$msg);
 		redirect('Vendor_regis_sap');
		
		
	}

	function checkUsernameHasTaken($companyid) {
		$this->load->model(array('tmp_vnd_header', 'vnd_header'));
		$username = $this->input->post('username');
		$flag[0] = $this->vnd_header->get(array('LOGIN_ID' => $username, 'COMPANYID' => $companyid));
		$flag[1] = $this->tmp_vnd_header->get(array('LOGIN_ID' => $username, 'COMPANYID' => $companyid));
		$return = array('valid' => FALSE);
		if ($flag[0] || $flag[1]) {
			$return['message'] = 'username sudah digunakan';
		}
		else {
			$return['valid'] = TRUE;
		}
		echo json_encode($return);
	}

	function check_vendor($companyid) {
		$this->load->model(array('vnd_header', 'hist_vnd_header'));
		$vendorno = $this->input->post('vendorno');
		$flag[0] = $this->vnd_header->get(array('VENDOR_NO' => $vendorno));
		$flag[1] = $this->hist_vnd_header->get(array('VENDOR_NO' => $vendorno));
		$return = array('valid' => FALSE);
		if ($flag[0] || $flag[1]) {
			$return['message'] = 'Vendor Nomor sudah digunakan';
		}
		else {
			$return['valid'] = TRUE;
		}
		echo json_encode($return);
	}

	function checkEmailHasTaken($companyid) {
		$this->load->model(array('tmp_vnd_header', 'vnd_header'));
		$email = $this->input->post('email');
		$flag[0] = $this->vnd_header->get(array('EMAIL_ADDRESS' => $email, 'COMPANYID' => $companyid));
		$flag[1] = $this->tmp_vnd_header->get(array('EMAIL_ADDRESS' => $email, 'COMPANYID' => $companyid));
		$return = array('valid' => FALSE);
		if ($flag[0] || $flag[1]) {
			$return['message'] = 'Email sudah digunakan';
		}
		else {
			$return['valid'] = TRUE;
		}
		echo json_encode($return);
	}

}
