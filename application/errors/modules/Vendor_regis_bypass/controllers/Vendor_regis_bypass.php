<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_regis_bypass extends CI_Controller {

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
		$this->load->model('adm_company');

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
		$this->load->model('tmp_vnd_header');
		$this->load->model('adm_company');
		$this->load->model('vendor_employe');

		$opco = $this->session->userdata['EM_COMPANY'];

		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Registration Bypass (Create Account)','CREATE',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$prefix = $this->input->post('prefix') == 0 ? null : $this->input->post('prefix');
		$suffix = $this->input->post('suffix') == 0 ? null : $this->input->post('suffix');
		$company_name = $this->input->post('company_name');
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$password = $this->input->post('password'); 
		$vendor_type = $this->input->post('vendor_type');
		$reg_sessionid = $this->session->userdata("session_id");
		$data = array(
			"VENDOR_EDIT_ID" => "1",
			"VENDOR_NAME" => $company_name,
			"LOGIN_ID" => $username,
			"PASSWORD" => md5($password),
			"EMAIL_ADDRESS" => $email,
			"PREFIX" => $prefix,
			"SUFFIX" => $suffix,
			"VENDOR_TYPE" => $vendor_type,
			"STATUS" => "0",
			"REG_ISACTIVATE" => "1",
			"COMPANYID" => $opco
		);

		$cek = $this->input->post('regis');

		$this->tmp_vnd_header->insert($data);
		$vendor_id =  $this->tmp_vnd_header->get_last_id();
		
		//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_regis_bypass/do_create_vendor','tmp_vnd_header','insert',$data);
		//--END LOG DETAIL--//

		$this->load->library('email');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		$this->email->cc('pengadaan.semenindonesia@gmail.com');				
		$this->email->to($email);

		$data_company = $this->vendor_employe->join_company($opco,$vendor_id);
		$this->email->subject("Registration Confirmation for eProcurement ".$data_company[0]['COMPANYNAME']." ");
		
		$data['selected_company'] = $opco;
		$data['company'] = $this->adm_company->get(array('ISACTIVE' => 1));
		$data['email'] = $email;
		$data['username'] = $username;
		$data['password'] = $password;
		$content = $this->load->view('email/success_create_vendor',$data,TRUE);
		$this->email->message($content);
		$this->email->send();

		if ($cek == 1) {
			echo $vendor_id;
		}else {
			echo 'OK';
			// $msg = 'Create Account Vendor '.$company_name;
			// $this->session->set_flashdata('success',$msg);
 		// 	redirect('Vendor_regis_bypass');
		}
		
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

	public function vendor_regis($vendor_id) {  
		$this->load->model(array('adm_wilayah','m_vnd_akta_type','adm_country','m_vnd_type','adm_curr','tmp_vnd_bank','tmp_vnd_fin_rpt'));

		$this->load->model('tmp_vnd_akta');
		$vendor = $this->tmp_vnd_header->with('akta')->get(array("VENDOR_ID" => $vendor_id));
		$data['vendor_detail'] = $vendor;
		$data['vendor_akta'] = $vendor['akta'];

		$data['title'] = "Regitrastion Vendor";
		$data['akta_type'] = $this->m_vnd_akta_type->get_all();
		$data['country'] = create_standard($this->adm_country->get_all(),'Country');
		$data['province'] = create_standard($this->adm_wilayah->fields('ID,NAMA')->get_all(array('JENIS'=>'PROVINSI')), 'Province');
		$data['city_list'] = create_standard($this->adm_wilayah->fields('ID,NAMA')->get_all(array('JENIS'=>'KOTA', 'FK_PROVINSI_ID'=>$vendor['ADDRES_PROP'])),'City');

		$data['city_list_npwp'] = create_standard($this->adm_wilayah->fields('ID,NAMA')->get_all(array('JENIS'=>'KOTA', 'FK_PROVINSI_ID'=>$vendor['NPWP_PROP'])),'City');
		$data['vendor_type'] = $this->m_vnd_type->get_all();

		
		$vendor = $this->tmp_vnd_header->with('fin_rpt')->with('bank')->get(array("VENDOR_ID" => $vendor_id));
		$data['vendor_fin_report'] = $vendor['fin_rpt'];
		$data['vendor_bank'] = $vendor['bank'];
		$data['currency'] = $this->adm_curr->as_dropdown('CURR_NAME')->get_all();


		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
		$this->layout->add_js('plugins/jquery.maskedinput.js');
		$this->layout->add_js('plugins/SimpleAjaxUploader.js');
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/regis_by_pas.js');
		$this->layout->render('form_regis', $data);
	}

	function do_update_legal_data() {
		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		} else {
			echo json_encode('vendor_id tidak ada');
			return;
		}

		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Registration Bypass (Input Legal Data)','SAVE',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$data_update = array();

			$domisili_no_doc = $this->input->post('domisili_no_doc');
			$data_update['DOMISILI_NO_DOC'] = $domisili_no_doc;

			$npwp_no_doc = $this->input->post('npwp_no_doc');
			$data_update['NPWP_NO_DOC'] = $npwp_no_doc;
		
			$pkp_no_doc = $this->input->post('pkp_no_doc');
			$data_update['PKP_NO_DOC'] = $pkp_no_doc;
		
			$siup_no_doc = $this->input->post('siup_no_doc');
			$data_update['SIUP_NO_DOC'] = $siup_no_doc;
		
			$tdp_no_doc = $this->input->post('tdp_no_doc');
			$data_update['TDP_NO_DOC'] = $tdp_no_doc;
		
			$address_domisili_no = $this->input->post('address_domisili_no');
			$data_update['ADDRESS_DOMISILI_NO'] = $address_domisili_no;
		
			$address_domisili_date = $this->input->post('address_domisili_date');
			if($this->input->post('address_domisili_date')){
				$data_update['ADDRESS_DOMISILI_DATE'] = vendortodate($address_domisili_date);
			} else {
				$data_update['ADDRESS_DOMISILI_DATE'] = '';
			}
		
			$address_domisili_exp_date = $this->input->post('address_domisili_exp_date');
			if($this->input->post('address_domisili_exp_date')){
				$data_update['ADDRESS_DOMISILI_EXP_DATE'] = vendortodate($address_domisili_exp_date);
			} else {
				$data_update['ADDRESS_DOMISILI_EXP_DATE'] = '';
			}
		
			$address_street = $this->input->post('address_street');
			$data_update['ADDRESS_STREET'] = $address_street;
		
			$addres_prop = $this->input->post('addres_prop');
			$data_update['ADDRES_PROP'] = $addres_prop;
		
			$address_postcode = $this->input->post('address_postcode');
			$data_update['ADDRESS_POSTCODE'] = $address_postcode;
		
			$address_country = $this->input->post('address_country');
			$data_update['ADDRESS_COUNTRY'] = $address_country;
			if($address_country == "ID"){
					$address_city = $this->input->post('city_select');
					$data_update['ADDRESS_CITY'] = $address_city;
			} else if($address_country){ 
				if($this->input->post('address_city')) {
					$address_city = $this->input->post('address_city');
					$data_update['ADDRESS_CITY'] = $address_city;
				}
			} else {
				$data_update['ADDRESS_CITY'] = '';
				$data_update['ADDRES_PROP'] = '';
			}
		
			$address_phone_no = $this->input->post('address_phone_no');
			$data_update['ADDRESS_PHONE_NO'] = $address_phone_no;
		
			$npwp_no = $this->input->post('npwp_no');
			$data_update['NPWP_NO'] = $npwp_no;
		
			$npwp_address = $this->input->post('npwp_address');
			$data_update['NPWP_ADDRESS'] = $npwp_address;
		
			$npwp_city = $this->input->post('npwp_city');
			$data_update['NPWP_CITY'] = $npwp_city;
		
			$npwp_prop = $this->input->post('npwp_prop');
			$data_update['NPWP_PROP'] = $npwp_prop;
		
			$npwp_postcode = $this->input->post('npwp_postcode');
			$data_update['NPWP_POSTCODE'] = $npwp_postcode;
		
			$npwp_pkp = $this->input->post('npwp_pkp');
			$data_update['NPWP_PKP'] = $npwp_pkp;
		
			$npwp_pkp_no = $this->input->post('npwp_pkp_no');

			if ($this->input->post('npwp_pkp_no')) {
				$data_update['NPWP_PKP_NO'] = $npwp_pkp_no; 
			} else {
				$data_update['NPWP_PKP_NO'] = ''; 
			}
		
			$siup_issued_by = $this->input->post('siup_issued_by');
			$data_update['SIUP_ISSUED_BY'] = $siup_issued_by;
		
			$siup_no = $this->input->post('siup_no');
			$data_update['SIUP_NO'] = $siup_no;
		
			$siup_type = $this->input->post('siup_type');
			$data_update['SIUP_TYPE'] = $siup_type;
		
			$siup_from = $this->input->post('siup_from');
			if($this->input->post('siup_from')) {
				$data_update['SIUP_FROM'] = vendortodate($siup_from);
			} else {
				$data_update['SIUP_FROM'] = '';
			}
		
			$siup_to = $this->input->post('siup_to');
			if($this->input->post('siup_to')){
				$data_update['SIUP_TO'] = vendortodate($siup_to);
			} else {
				$data_update['SIUP_TO'] = '';
			}
		
			$tdp_issued_by = $this->input->post('tdp_issued_by');
			$data_update['TDP_ISSUED_BY'] = $tdp_issued_by;
		
			$tdp_no = $this->input->post('tdp_no');
			$data_update['TDP_NO'] = $tdp_no;
		
			$tdp_from = $this->input->post('tdp_from');
			if($this->input->post('tdp_from')){
				$data_update['TDP_FROM'] = vendortodate($tdp_from);
			} else {
				$data_update['TDP_FROM'] = '';
			}
		
			$tdp_to = $this->input->post('tdp_to');
			if($this->input->post('tdp_to')){
				$data_update['TDP_TO'] = vendortodate($tdp_to);
			} else {
				$data_update['TDP_TO'] = '';
			}

			$where = array("VENDOR_ID" => $vendor_id);
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_regis_bypass/do_update_legal_data','tmp_vnd_header','update',$data_update,$where);
			//--END LOG DETAIL--//

			echo json_encode($this->tmp_vnd_header->update($data_update,$where)); 


	}

	function do_update_akta_data() {
		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		} else {
			echo json_encode('vendor_id tidak ada');
			return;
		}

		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Registration Bypass (Update Akta)','EDIT',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$data_update = array();
		if($this->input->post('akta_no')) {
			$akta_no = $this->input->post('akta_no');
			$data_update["AKTA_NO"] = $akta_no;
		}
		if($this->input->post('akta_type')) {
			$akta_type = $this->input->post('akta_type');
			$data_update["AKTA_TYPE"] = $akta_type;
		}
		if($this->input->post('date_creation')) {
			$date_creation = $this->input->post('date_creation');
			$data_update["DATE_CREATION"] = vendortodate($date_creation);
		} else {
			$data_update["DATE_CREATION"] = '';
		}
		if($this->input->post('notaris_name')) {
			$notaris_name = $this->input->post('notaris_name');
			$data_update["NOTARIS_NAME"] = $notaris_name;
		}
		if($this->input->post('notaris_address')) {
			$notaris_address = $this->input->post('notaris_address');
			$data_update["NOTARIS_ADDRESS"] = $notaris_address;
		}
		if($this->input->post('pengesahan_hakim')) {
			$pengesahan_hakim = $this->input->post('pengesahan_hakim');
			$data_update["PENGESAHAN_HAKIM"] = vendortodate($pengesahan_hakim);
		} else {
			$data_update["PENGESAHAN_HAKIM"] = '';
		}
		if($this->input->post('berita_acara_ngr')) {
			$berita_acara_ngr = $this->input->post('berita_acara_ngr');
			$data_update["BERITA_ACARA_NGR"] = vendortodate($berita_acara_ngr);
		} else {
			$data_update["BERITA_ACARA_NGR"] = '';
		}
		if($this->input->post('akta_no_doc')) {
			$akta_no_doc = $this->input->post('akta_no_doc');
			$data_update["AKTA_NO_DOC"] = $akta_no_doc;
		}
		if($this->input->post('pengesahan_hakim_doc')) {
			$pengesahan_hakim_doc = $this->input->post('pengesahan_hakim_doc');
			$data_update["PENGESAHAN_HAKIM_DOC"] = $pengesahan_hakim_doc;
		}
		if($this->input->post('berita_acara_ngr_doc')) {
			$berita_acara_ngr_doc = $this->input->post('berita_acara_ngr_doc');
			$data_update["BERITA_ACARA_NGR_DOC"] = $berita_acara_ngr_doc;
		}

		$where = array("VENDOR_ID" => $vendor_id, 'AKTA_ID' => $this->input->post('akta_id'));

		//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_regis_bypass/do_update_akta_data','tmp_vnd_akta','update',$data_update,$where);
		//--END LOG DETAIL--//
		echo json_encode($this->tmp_vnd_akta->update($data_update,$where));
	}

	function do_insert_akta_pendirian() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_akta');
		}
		else {
			$this->load->model('tmp_vnd_akta');
		}
		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Registration Bypass (Input Akta)','SAVE',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$akta_no = NULL;
		$akta_type = NULL;
		$date_creation = NULL;
		$notaris_name = NULL;
		$notaris_address = NULL;
		$pengesahan_hakim = NULL;
		$berita_acara_ngr = NULL;
		$akta_no_doc = NULL;
		$pengesahan_hakim_doc = NULL;
		$berita_acara_ngr_doc = NULL;
		$data = array(
					"VENDOR_ID" => $vendor_id
					);
		if($this->input->post('akta_no')) {
			$akta_no = $this->input->post('akta_no');
			$data["AKTA_NO"] = $akta_no;
		}
		if($this->input->post('akta_type')) {
			$akta_type = $this->input->post('akta_type');
			$data["AKTA_TYPE"] = $akta_type;
		}
		if($this->input->post('date_creation')) {
			$date_creation = $this->input->post('date_creation');
			$data["DATE_CREATION"] = vendortodate($date_creation);
		}
		if($this->input->post('notaris_name')) {
			$notaris_name = $this->input->post('notaris_name');
			$data["NOTARIS_NAME"] = $notaris_name;
		}
		if($this->input->post('notaris_address')) {
			$notaris_address = $this->input->post('notaris_address');
			$data["NOTARIS_ADDRESS"] = $notaris_address;
		}
		if($this->input->post('pengesahan_hakim')) {
			$pengesahan_hakim = $this->input->post('pengesahan_hakim');
			$data["PENGESAHAN_HAKIM"] = vendortodate($pengesahan_hakim);
		}
		if($this->input->post('berita_acara_ngr')) {
			$berita_acara_ngr = $this->input->post('berita_acara_ngr');
			$data["BERITA_ACARA_NGR"] = vendortodate($berita_acara_ngr);
		}
		if($this->input->post('akta_no_doc')) {
			$akta_no_doc = $this->input->post('akta_no_doc');
			$data["AKTA_NO_DOC"] = $akta_no_doc;
		}
		if($this->input->post('pengesahan_hakim_doc')) {
			$pengesahan_hakim_doc = $this->input->post('pengesahan_hakim_doc');
			$data["PENGESAHAN_HAKIM_DOC"] = $pengesahan_hakim_doc;
		}
		if($this->input->post('berita_acara_ngr_doc')) {
			$berita_acara_ngr_doc = $this->input->post('berita_acara_ngr_doc');
			$data["BERITA_ACARA_NGR_DOC"] = $berita_acara_ngr_doc;
		}
		if ($this->session->userdata('STATUS') == "3") {
			$data["VND_TRAIL_ID"] = "3";

			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_regis_bypass/do_insert_akta_pendirian','hist_vnd_akta','insert',$data);
			//--END LOG DETAIL--//

			echo json_encode($this->hist_vnd_akta->insert($data));
		}
		else {
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_regis_bypass/do_insert_akta_pendirian','tmp_vnd_akta','insert',$data);
			//--END LOG DETAIL--//
			
			echo json_encode($this->tmp_vnd_akta->insert($data));
		}
	}

	function do_remove_legal_akta() {
		$this->load->model('tmp_vnd_akta');

		$akta = $this->input->post('akta');
		// die(var_dump($bank));

		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Registration Bypass (Delete Akta)','Delete',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
		
		$this->tmp_vnd_akta->delete(array("AKTA_ID" => $akta)); 

		//--LOG DETAIL--//
			$where['AKTA_ID'] = $akta;
			$this->log_data->detail($LM_ID,'Vendor_regis_bypass/do_remove_legal_akta','tmp_vnd_akta','delete',null,$where);
		//--END LOG DETAIL--//
		
		echo json_encode('OK');
		
	}

	function do_insert_bank_data() {
		
		$this->load->model('tmp_vnd_bank');

		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Registration Bypass (Insert Bank)','SAVE',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
		
		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		}
		
		$account_no = NULL;
		$account_name = NULL;
		$bank_name = NULL;
		$bank_branch = NULL;
		$swift_code = NULL;
		$address = NULL;
		$bank_postal_code = NULL;
		$currency = NULL;
		if ($this->input->post('account_no')) {
			$account_no = $this->input->post('account_no');
		}
		if ($this->input->post('account_name')) {
			$account_name = $this->input->post('account_name');
		}
		if ($this->input->post('bank_name')) {
			$bank_name = $this->input->post('bank_name');
		}
		if ($this->input->post('bank_branch')) {
			$bank_branch = $this->input->post('bank_branch');
		}
		if ($this->input->post('swift_code')) {
			$swift_code = $this->input->post('swift_code');
		}
		if ($this->input->post('address')) {
			$address = $this->input->post('address');
		}
		if ($this->input->post('bank_postal_code')) {
			$bank_postal_code = $this->input->post('bank_postal_code');
		}
		if ($this->input->post('currency')) {
			$currency = $this->input->post('currency');
		}
		if ($this->input->post('reference_bank')) {
			$reference = $this->input->post('reference_bank');
		}
		if ($this->input->post('file_bank')) {
			$file_bank = $this->input->post('file_bank');
		}
		$data = array(
				'VENDOR_ID' => $vendor_id,
				'ACCOUNT_NO' => $account_no,
				'ACCOUNT_NAME' => $account_name,
				'BANK_NAME' => $bank_name,
				'BANK_BRANCH' => $bank_branch,
				'SWIFT_CODE' => $swift_code,
				'ADDRESS' => $address,
				'BANK_POSTAL_CODE' => $bank_postal_code,
				'CURRENCY' => $currency,
				'REFERENCE_BANK' =>$reference,
				'REFERENCE_FILE' =>$file_bank
			);
			$this->tmp_vnd_bank->insert($data); 

			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_regis_bypass/do_insert_bank_data','tmp_vnd_bank','insert',$data);
			//--END LOG DETAIL--//
		echo json_encode('OK');
	}

	function do_update_bank_financial(){
		
		$this->load->model('tmp_vnd_bank'); 

		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Registration Bypass (Update Bank)','EDIT',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
		
		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		}

		$bank_id = $this->input->post('bank_id');

		$account_no = NULL;
		$account_name = NULL;
		$bank_name = NULL;
		$bank_branch = NULL;
		$swift_code = NULL;
		$address = NULL;
		$bank_postal_code = NULL;
		$currency = NULL;
		if ($this->input->post('account_no')) {
			$account_no = $this->input->post('account_no');
		}
		if ($this->input->post('account_name')) {
			$account_name = $this->input->post('account_name');
		}
		if ($this->input->post('bank_name')) {
			$bank_name = $this->input->post('bank_name');
		}
		if ($this->input->post('bank_branch')) {
			$bank_branch = $this->input->post('bank_branch');
		}
		if ($this->input->post('swift_code')) {
			$swift_code = $this->input->post('swift_code');
		}
		if ($this->input->post('address')) {
			$address = $this->input->post('address');
		}
		if ($this->input->post('bank_postal_code')) {
			$bank_postal_code = $this->input->post('bank_postal_code');
		}
		if ($this->input->post('currency')) {
			$currency = $this->input->post('currency');
		}
		if ($this->input->post('reference_bank')) {
			$reference = $this->input->post('reference_bank');
		}
		if ($this->input->post('file_bank')) {
			$file_bank = $this->input->post('file_bank');
		}
		$data = array(
				'VENDOR_ID' => $vendor_id,
				'ACCOUNT_NO' => $account_no,
				'ACCOUNT_NAME' => $account_name,
				'BANK_NAME' => $bank_name,
				'BANK_BRANCH' => $bank_branch,
				'SWIFT_CODE' => $swift_code,
				'ADDRESS' => $address,
				'BANK_POSTAL_CODE' => $bank_postal_code,
				'CURRENCY' => $currency,
				'REFERENCE_BANK' => $reference,
				'REFERENCE_FILE' => $file_bank
			);
		
			$where = array("VENDOR_ID" => $vendor_id,'BANK_ID' => $bank_id);
			$this->tmp_vnd_bank->update($data,$where); 

		//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_regis_bypass/do_update_bank_financial','tmp_vnd_bank','update',$data,$where);
		//--END LOG DETAIL--//

		echo json_encode('OK');
	}

	function get_bank_edit(){
		$bank_id = $this->input->post('bank_id');
		if(!empty($bank_id)){
			$this->load->model('tmp_vnd_bank');
			$bank_data = $this->tmp_vnd_bank->get_all(array('BANK_ID'=>$bank_id));
		} else {

		}

		echo json_encode($bank_data);
	}

	function do_finish_register() {
		$this->load->model('vnd_header');
		$vendor_id = $this->input->post('vendor_id');
		// die(var_dump($vendor_id));

		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Registration Bypass (Finish)','SUBMIT',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
		
		$whereopco = $this->vnd_header->where(array("VENDOR_ID"=>$vendor_id))->get_all();

		$data_update = array();

		$where = array("VENDOR_ID" => $vendor_id);
		$data_update['NEXT_PAGE'] = "Persetujuan New Registrasi";
		$data_update['STATUS'] = 1;

		$this->tmp_vnd_header->update($data_update,$where);

		//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_regis_bypass/do_finish_register','tmp_vnd_header','update',$data_update,$where);
		//--END LOG DETAIL--//

		$msg = 'Create Account and Registration Vendor ';
		$this->session->set_flashdata('success',$msg);
		redirect('Vendor_regis_bypass');
		
	}

	function do_remove_vendor_bank(){
		$this->load->model('tmp_vnd_bank');

		$bank = $this->input->post('bank');
		// die(var_dump($bank));

		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Registration Bypass (Delete Bank)','Delete',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
		
		$this->tmp_vnd_bank->delete(array("BANK_ID" => $bank));

		//--LOG DETAIL--//
			$where['BANK_ID'] = $bank;
			$this->log_data->detail($LM_ID,'Vendor_regis_bypass/do_remove_vendor_bank','tmp_vnd_bank','delete',null,$where);
		//--END LOG DETAIL--//
		
		echo json_encode('OK');
	}

	function uploadAttachment() {
		$this->load->library('encrypt');
		$server_dir = str_replace("\\", "/", FCPATH);
		$upload_dir = UPLOAD_PATH."vendor/";
		$this->load->library('file_operation');
		$this->file_operation->create_dir($upload_dir);
		$this->load->library('FileUpload');
		$uploader = new FileUpload('uploadfile');
		$ext = $uploader->getExtension(); // Get the extension of the uploaded file
		mt_srand();
		$filename = md5(uniqid(mt_rand())).".".$ext;
		$uploader->newFileName = $filename;
		$result = $uploader->handleUpload($server_dir.$upload_dir);
		if (!$result) {
			exit(json_encode(array('success' => false, 'msg' => $uploader->getErrorMsg(), 'path' => $upload_dir)));
		}
		echo json_encode(array('success' => true, 'newFileName' => $filename, 'upload_dir' => $upload_dir));
	}

	function get_kota(){
		$id_prov = $this->input->post('prov');
		//var_dump($id_prov);
		if(!empty($id_prov)){
			$this->load->model('adm_wilayah');
			$list_kota = $this->adm_wilayah->fields('ID,NAMA')->get_all(array('JENIS'=>'KOTA', 'FK_PROVINSI_ID'=>$id_prov));
			echo json_encode($list_kota);
		} else {
			echo json_encode(array('ID'=>'empty', 'NAMA'=>'empty'));
		}			
	}

	public function viewDok($id = null){
		$url = str_replace("int-","", base_url());
		$this->load->helper('file');
		$image_path = base_url(UPLOAD_PATH).'/vendor/'.$id;	

		if (strpos($url, 'semenindonesia.com') !== false) { //server production
		$user_id=url_encode($this->session->userdata['ID']);
			if(empty($id)){
				die('tidak ada attachment.');
			}
			if(file_exists(BASEPATH.'../upload/vendor/'.$id)){				
				$this->output->set_content_type(get_mime_by_extension($image_path));
				return $this->output->set_output(file_get_contents($image_path));
			}else{
				if (strpos($url, 'https')) {
					$url = $url;
				} else {
					$url = str_replace("http","https", $url);					
				}
				
				redirect($url.'View_document_vendor/viewDok/'.$file.'/'.$user_id);
			}

		}else{ //server development
			if(empty($id) || !file_exists(BASEPATH.'../upload/vendor/'.$id)){
				die('tidak ada attachment.');
			}
			
			$this->output->set_content_type(get_mime_by_extension($image_path));
			return $this->output->set_output(file_get_contents($image_path));
		}
	}

	public function deleteFile_all(){
		$fileUpload = $this->input->post('filename');
		
		$this->load->helper("url");

		$path = './upload/vendor/'.$fileUpload;
	    if(file_exists(BASEPATH.'../upload/vendor/'.$fileUpload)){
	        unlink($path);
	    }
	}

}
