<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Administrative_Document extends CI_Controller {

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
		$this->general_data();
	}

	public function general_data() {
		$data['progress_status'] = $this->prog_status;
		$this->load->model('adm_country');
		$this->load->model(array('adm_wilayah', 'm_vnd_type'));
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_address');
			$vendor = $this->hist_vnd_header->with('address')->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "VND_TRAIL_ID" => 3));
			$data['vendor_detail'] = $vendor;
			$tmp_company_address = $vendor['address'];
			$company_address = array();
			foreach ((array)$tmp_company_address as $key => $val) {
				if($val['VND_TRAIL_ID'] == 3){
					array_push($company_address,$val);
				}
			}
			$data['company_address'] = $company_address;
		}
		else {
			$this->load->model('tmp_vnd_address');
			$vendor = $this->tmp_vnd_header->with('address')->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID"))));
			$data['vendor_detail'] = $vendor;
			$data['company_address'] = $vendor['address'];
		}
		$data['title'] = "Data Umum";
		$data['prefix'] = create_standard($this->m_vnd_prefix->get_all(),'Prefix');
		$data['suffix'] = create_standard($this->m_vnd_suffix->get_all(),'Suffix');
		$data['country'] = create_standard($this->adm_country->get_all(),'Country');
		$data['country_list'] = $this->adm_country->as_dropdown('COUNTRY_NAME')->get_all();
		$data['province'] = create_standard($this->adm_wilayah->fields('ID,NAMA')->get_all(array('JENIS'=>'PROVINSI')), 'Province');
		$data['city_select'] = create_standard($this->adm_wilayah->fields('ID,NAMA')->get_all(array('JENIS'=>'KOTA')),'City');
		$data['city_list'] = $this->adm_wilayah->as_dropdown('NAMA')->get_all();
		$data['vnd_type'] = $this->m_vnd_type->as_dropdown('VENDOR_TYPE')->get_all();
		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
		$this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
		$this->layout->add_js('plugins/jquery.maskedinput.js');
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js(base_url().'Assets/Administrative_document/assets/administrative_document.js', TRUE);
		$this->layout->render('form_general_data', $data);
	}

	function do_update_general_data() {
		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Update general data)','EDIT',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$prefix = NULL;
		$company_name = NULL;
		$suffix = NULL;
		$contact_name = NULL;
		$contact_pos = NULL;
		$contact_phone_no = NULL;
		$contact_phone_hp = NULL;
		$contact_email = NULL;
		if ($this->input->post('prefix')) {
			$prefix = $this->input->post('prefix');
		}
		if ($this->input->post('company_name')) {
			$company_name = $this->input->post('company_name');
		}
		if ($this->input->post('suffix')) {
			$suffix = $this->input->post('suffix');
		}

		if ($this->input->post('vendor_type')) {
			$vendor_type = $this->input->post('vendor_type');
		}

		if ($this->input->post('contact_name')) {
			$contact_name = $this->input->post('contact_name');
		}
		if ($this->input->post('contact_pos')) {
			$contact_pos = $this->input->post('contact_pos');
		}
		if ($this->input->post('contact_phone_no')) {
			$contact_phone_no = $this->input->post('contact_phone_no');
		}
		if ($this->input->post('contact_phone_hp')) {
			$contact_phone_hp = $this->input->post('contact_phone_hp');
		}
		if ($this->input->post('contact_email')) {
			$contact_email = $this->input->post('contact_email');
		}

		$data_update = array(
				"VENDOR_TYPE" => $vendor_type,
				"PREFIX" => $prefix,
				"SUFFIX" => $suffix,
				"VENDOR_NAME" => $company_name,
				"CONTACT_NAME" => $contact_name,
				"CONTACT_POS" => $contact_pos,
				"CONTACT_PHONE_NO" => $contact_phone_no,
				"CONTACT_PHONE_HP" => $contact_phone_hp,
				"CONTACT_EMAIL" => $contact_email,
			);
		if ($this->session->userdata('STATUS') == "3") {
			$where = array("VENDOR_ID" => $vendor_id, "VND_TRAIL_ID" => 3);
			$this->hist_vnd_header->update( $data_update , $where);
		}
		else {
			$where = array("VENDOR_ID" => $vendor_id);
			
			$this->tmp_vnd_header->update($data_update,$where);

			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Administrative_document/do_update_general_data','hist_vnd_header','update',$data_update,$where);
			//--END LOG DETAIL--//
		}
		echo json_encode('OK');
	}

	public function legal_data() {
		$data['progress_status'] = $this->prog_status;
		$this->load->model('m_vnd_akta_type');
		$this->load->model('adm_country');
		$this->load->model('m_vnd_type');
		$this->load->model(array('adm_wilayah'));
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_akta');
			$vendor = $this->hist_vnd_header->with('akta')->where(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "VND_TRAIL_ID" => 3))->get();
			$data['vendor_detail'] = $vendor;
			$vendor_akta = array();
			if (!empty($data['vendor_detail'])) {
				foreach ((array)$vendor['akta'] as $key => $val) {
					if($val['VND_TRAIL_ID'] == '3' ){
						array_push($vendor_akta, $val);
					}
				}
			}
			
			$data['vendor_akta'] = $vendor_akta; 
		} else {
			$this->load->model('tmp_vnd_akta');
			$vendor = $this->tmp_vnd_header->with('akta')->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID"))));
			$data['vendor_detail'] = $vendor;
			$data['vendor_akta'] = $vendor['akta'];
		}
		$data['title'] = "Data Legal";
		$data['akta_type'] = $this->m_vnd_akta_type->get_all();
		$data['country'] = create_standard($this->adm_country->get_all(),'Country');
		$data['province'] = create_standard($this->adm_wilayah->fields('ID,NAMA')->get_all(array('JENIS'=>'PROVINSI')), 'Province');
		$data['city_list'] = create_standard($this->adm_wilayah->fields('ID,NAMA')->get_all(array('JENIS'=>'KOTA', 'FK_PROVINSI_ID'=>$vendor['ADDRES_PROP'])),'City');

		$data['city_list_npwp'] = create_standard($this->adm_wilayah->fields('ID,NAMA')->get_all(array('JENIS'=>'KOTA', 'FK_PROVINSI_ID'=>$vendor['NPWP_PROP'])),'City');
		
		$data['vendor_type'] = $this->m_vnd_type->get_all();
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
		$this->layout->add_js(base_url().'Assets/Administrative_document/assets/administrative_document.js', TRUE);
		$this->layout->render('form_legal_data', $data);
	}

	public function company_board() {
		$data['progress_status'] = $this->prog_status;
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_board');
			$vendor = $this->hist_vnd_header->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "VND_TRAIL_ID" => 3));
			$data['vendor_detail'] = $vendor;
			$data['vendor_board_commissioner'] = $this->hist_vnd_board->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Commissioner", "VND_TRAIL_ID" => 3));
			$data['vendor_board_director'] = $this->hist_vnd_board->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Director", "VND_TRAIL_ID" => 3));
		} else {
			$this->load->model('tmp_vnd_board');
			$vendor = $this->tmp_vnd_header->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID"))));
			$data['vendor_detail'] = $vendor;
			$data['vendor_board_commissioner'] = $this->tmp_vnd_board->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Commissioner"));
			$data['vendor_board_director'] = $this->tmp_vnd_board->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Director"));
		}
		$data['title'] = "Company Board";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
		$this->layout->add_js('plugins/jquery.maskedinput.js');
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js(base_url().'Assets/Administrative_document/assets/administrative_document.js', TRUE);
		$this->layout->render('form_company_board', $data);
	}

	public function bank_and_financial_data() {
		$data['progress_status'] = $this->prog_status;
		$this->load->model('adm_curr');
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_bank');
			$this->load->model('hist_vnd_fin_rpt');
			$vendor = $this->hist_vnd_header->with('fin_rpt')->with('bank')->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "VND_TRAIL_ID" => 3));
			$data['vendor_detail'] = $vendor;
			
			$vendor_bank = array();
			foreach ((array)$vendor['bank'] as $key => $value) {
				if($value['VND_TRAIL_ID'] == 3){
					array_push($vendor_bank, $value);	
				}
				
			}
			$data['vendor_bank'] = $vendor_bank;
			$vendor_fin_report = array();
			foreach ((array)$vendor['fin_rpt'] as $key => $value) {
				if($value['VND_TRAIL_ID'] == 3){
					array_push($vendor_fin_report, $value);
				}
			}
			$data['vendor_fin_report'] = $vendor_fin_report;
		}
		else {
			$this->load->model('tmp_vnd_bank');
			$this->load->model('tmp_vnd_fin_rpt');
			$vendor = $this->tmp_vnd_header->with('fin_rpt')->with('bank')->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID"))));
			$data['vendor_detail'] = $vendor;
			$data['vendor_fin_report'] = $vendor['fin_rpt'];
			$data['vendor_bank'] = $vendor['bank'];
		}
		$data['title'] = "Bank and Financial Data";
		$data['currency'] = $this->adm_curr->as_dropdown('CURR_NAME')->get_all();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
		$this->layout->add_js('plugins/jquery.maskedinput.js');
		$this->layout->add_js('plugins/autoNumeric.js');
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js(base_url().'Assets/Administrative_document/assets/administrative_document.js', TRUE);
		$this->layout->render('form_bank_and_financial_data', $data);
	}

	function do_update_general_address() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_address');
		}
		else {
			$this->load->model('tmp_vnd_address');
		}
		if ($this->input->post('address_id')) {
			$address_id = $this->input->post('address_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Update general address)','EDIT',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$alamat = NULL;
		$city = NULL;
		$postcode = NULL;
		$country = NULL;
		$province = NULL;
		$cabang = NULL;
		$telp1 = NULL;
		$telp2 = NULL;
		$fax = NULL;
		$website = NULL;
		if ($this->input->post('alamat')) {
			$alamat = $this->input->post('alamat');
		}
		if ($this->input->post('city')) {
			$city = $this->input->post('city');
		}
		if ($this->input->post('postcode')) {
			$postcode = $this->input->post('postcode');
		}
		if ($this->input->post('country')) {
			$country = $this->input->post('country');
		}
		if ($this->input->post('province') && $country=='ID') {
			$province = $this->input->post('province');
		}
		if ($this->input->post('cabang')) {
			$cabang = $this->input->post('cabang');
		}
		if ($this->input->post('telp1')) {
			$telp1 = $this->input->post('telp1');
		}
		if ($this->input->post('telp2')) {
			$telp2 = $this->input->post('telp2');
		}
		if ($this->input->post('fax')) {
			$fax = $this->input->post('fax');
		}
		if ($this->input->post('website')) {
			$website = $this->input->post('website');
		}
		$data = array(
				'TYPE' => $cabang,
				'ADDRESS' => $alamat,
				'CITY' => $city,
				'PROVINCE'=> $province,
				'COUNTRY' => $country,
				'POST_CODE' => $postcode,
				'TELEPHONE1_NO' => $telp1,
				'TELEPHONE2_NO' => $telp2,
				'FAX' => $fax,
				'WEBSITE' => $website,
			);
		if ($this->session->userdata('STATUS') == "3") {
			$this->hist_vnd_address->update($data,array("ADDRESS_ID" => $address_id, "VND_TRAIL_ID" => 3));
			echo "OK";
		}
		else {
			$this->tmp_vnd_address->update($data,array("ADDRESS_ID" => $address_id));
			//--LOG DETAIL--//
				$where = array("ADDRESS_ID" => $address_id);
				$this->log_data->detail($LM_ID,'Administrative_document/do_update_general_address','tmp_vnd_address','update',$data,$where);
			//--END LOG DETAIL--//
			echo "OK";
		}
	}

	function do_update_legal_data() {
		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		} else {
			echo json_encode('vendor_id tidak ada');
			return;
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Update legal data)','EDIT',$this->input->ip_address());
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
			if($this->input->post('address_domisili_date'))
				$data_update['ADDRESS_DOMISILI_DATE'] = vendortodate($address_domisili_date);
			else
				$data_update['ADDRESS_DOMISILI_DATE'] = '';
		
			$address_domisili_exp_date = $this->input->post('address_domisili_exp_date');
			if($this->input->post('address_domisili_exp_date'))
				$data_update['ADDRESS_DOMISILI_EXP_DATE'] = vendortodate($address_domisili_exp_date);
			else
				$data_update['ADDRESS_DOMISILI_EXP_DATE'] = '';
		
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
			if($this->input->post('siup_from'))
				$data_update['SIUP_FROM'] = vendortodate($siup_from);
			else 
				$data_update['SIUP_FROM'] = '';
		
			$siup_to = $this->input->post('siup_to');
			if($this->input->post('siup_to'))
				$data_update['SIUP_TO'] = vendortodate($siup_to);
			else 
				$data_update['SIUP_TO'] = '';
		
			$tdp_issued_by = $this->input->post('tdp_issued_by');
			$data_update['TDP_ISSUED_BY'] = $tdp_issued_by;
		
			$tdp_no = $this->input->post('tdp_no');
			$data_update['TDP_NO'] = $tdp_no;
		
			$tdp_from = $this->input->post('tdp_from');
			if($this->input->post('tdp_from'))
				$data_update['TDP_FROM'] = vendortodate($tdp_from);
			else 
				$data_update['TDP_FROM'] = '';
		
			$tdp_to = $this->input->post('tdp_to');
			if($this->input->post('tdp_to'))
				$data_update['TDP_TO'] = vendortodate($tdp_to);
			else 
				$data_update['TDP_TO'] = '';
		

		$api_issued_by = $this->input->post('api_issued_by');
		$data_update['API_ISSUED_BY'] = $api_issued_by;

		
			$api_no = $this->input->post('api_no');
			$data_update['API_NO'] = $api_no;
		
			$api_from = $this->input->post('api_from');
			if($this->input->post('api_from'))
				$data_update['API_FROM'] = vendortodate($api_from);
			else 
				$data_update['API_FROM'] = '';
		
			$api_to = $this->input->post('api_to');
			if($this->input->post('api_to'))
				$data_update['API_TO'] = vendortodate($api_to);
			else 
				$data_update['API_TO'] = '';
		
			$akta_no = $this->input->post('akta_no');
			$data_update["AKTA_NO"] = $akta_no;
		
			$akta_type = $this->input->post('akta_type');
			$data_update["AKTA_TYPE"] = $akta_type;
		
			$date_creation = $this->input->post('date_creation');
			if($this->input->post('date_creation'))
				$data_update['DATE_CREATION'] = vendortodate($date_creation);
			else 
				$data_update['DATE_CREATION'] = '';
		
			$notaris_name = $this->input->post('notaris_name');
			$data_update["NOTARIS_NAME"] = $notaris_name;
		
			$notaris_address = $this->input->post('notaris_address');
			$data_update["NOTARIS_ADDRESS"] = $notaris_address;
		
			$pengesahan_hakim = $this->input->post('pengesahan_hakim');
			if($this->input->post('pengesahan_hakim'))
				$data_update['PENGESAHAN_HAKIM'] = vendortodate($pengesahan_hakim);
			else 
				$data_update['PENGESAHAN_HAKIM'] = '';
		
			$berita_acara_ngr = $this->input->post('berita_acara_ngr');
			if($this->input->post('date_creation'))
				$data_update['DATE_CREATION'] = vendortodate($date_creation);
			else 
				$data_update['DATE_CREATION'] = '';

			$data_update["BERITA_ACARA_NGR"] = vendortodate($berita_acara_ngr);
		
			$akta_no_doc = $this->input->post('akta_no_doc');
			$data_update["AKTA_NO_DOC"] = $akta_no_doc;
		
			$pengesahan_hakim_doc = $this->input->post('pengesahan_hakim_doc');
			$data_update["PENGESAHAN_HAKIM_DOC"] = $pengesahan_hakim_doc;
		
			$berita_acara_ngr_doc = $this->input->post('berita_acara_ngr_doc');
			$data_update["BERITA_ACARA_NGR_DOC"] = $berita_acara_ngr_doc;

			// die(var_dump($data_update));

		if ($this->session->userdata('STATUS') == "3") {
			$where = array("VENDOR_ID" => $vendor_id, "VND_TRAIL_ID" => 3);
			echo json_encode($this->hist_vnd_header->update($data_update,$where));
		}
		else {
			$where = array("VENDOR_ID" => $vendor_id);
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Administrative_document/do_update_legal_data','tmp_vnd_header','update',$data_update,$where);
			//--END LOG DETAIL--//
			echo json_encode($this->tmp_vnd_header->update($data_update,$where));
		}
	}

	function do_update_akta_data() {
		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		} else {
			echo json_encode('vendor_id tidak ada');
			return;
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Update akta)','EDIT',$this->input->ip_address());
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
		}
		if($this->input->post('berita_acara_ngr')) {
			$berita_acara_ngr = $this->input->post('berita_acara_ngr');
			$data_update["BERITA_ACARA_NGR"] = vendortodate($berita_acara_ngr);
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
		if ($this->session->userdata('STATUS') == "3") {
			$where = array("VENDOR_ID" => $vendor_id, "VND_TRAIL_ID" => 3, 'AKTA_ID' => $this->input->post('akta_id'));
			echo json_encode($this->hist_vnd_akta->update($data_update,$where));
		}
		else {
			$where = array("VENDOR_ID" => $vendor_id, 'AKTA_ID' => $this->input->post('akta_id'));
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Administrative_document/do_update_akta_data','tmp_vnd_akta','update',$data_update,$where);
			//--END LOG DETAIL--//
			echo json_encode($this->tmp_vnd_akta->update($data_update,$where));
		}
	}

	function do_update_financial_data() {
		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Update Financial)','EDIT',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$fin_akta_mdl_dsr_curr = NULL;
		$fin_akta_mdl_dsr = NULL;
		$fin_akta_mdl_str_curr = NULL;
		$fin_akta_mdl_str = NULL;
		$fin_class = NULL;
		if ($this->input->post('fin_akta_mdl_dsr_curr')) {
			$fin_akta_mdl_dsr_curr = $this->input->post('fin_akta_mdl_dsr_curr');
		} else {
			$fin_akta_mdl_dsr_curr = "";
		}
		if ($this->input->post('fin_akta_mdl_dsr')) {
			$fin_akta_mdl_dsr = $this->input->post('fin_akta_mdl_dsr');
			if(preg_match("/^[0-9,]+$/", $fin_akta_mdl_dsr)) 
				$fin_akta_mdl_dsr = str_replace(",", "", $fin_akta_mdl_dsr);
			
		} else {
			$fin_akta_mdl_dsr = "";
		}
		if ($this->input->post('fin_akta_mdl_str_curr')) {
			$fin_akta_mdl_str_curr = $this->input->post('fin_akta_mdl_str_curr');
		} else {
			$fin_akta_mdl_str_curr ='';
		}
		if ($this->input->post('fin_akta_mdl_str')) {
			$fin_akta_mdl_str = $this->input->post('fin_akta_mdl_str');
			if(preg_match("/^[0-9,]+$/", $fin_akta_mdl_str)) 
				$fin_akta_mdl_str = str_replace(",", "", $fin_akta_mdl_str);
		} else {
			$fin_akta_mdl_str ='';	
		}

		if ($this->input->post('fin_class')) {
			$fin_class = $this->input->post('fin_class');
		} else {
			$fin_class = '';
		}

		$data_update = array(
				'FIN_AKTA_MDL_DSR_CURR' => $fin_akta_mdl_dsr_curr,
				'FIN_AKTA_MDL_DSR' => $fin_akta_mdl_dsr,
				'FIN_AKTA_MDL_STR_CURR' => $fin_akta_mdl_str_curr,
				'FIN_AKTA_MDL_STR' => $fin_akta_mdl_str,
				'FIN_CLASS' => $fin_class
			);
		if ($this->session->userdata('STATUS') == "3") {
			$where = array("VENDOR_ID" => $vendor_id, "VND_TRAIL_ID" => 3);
			echo json_encode($this->hist_vnd_header->update($data_update,$where)); 
		}
		else {
			$where = array("VENDOR_ID" => $vendor_id);
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Administrative_document/do_update_financial_data','tmp_vnd_header','update',$data_update,$where);
			//--END LOG DETAIL--//
			echo json_encode($this->tmp_vnd_header->update($data_update,$where));
		}
	}

	function do_insert_general_address() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_address');
		} else {
			$this->load->model('tmp_vnd_address');
		}

		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Input general address)','SAVE',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$alamat = NULL;
		$city = NULL;
		$postcode = NULL;
		$country = NULL;
		$province = NULL;
		$cabang = NULL;
		$telp1 = NULL;
		$telp2 = NULL;
		$fax = NULL;
		$website = NULL;
		if ($this->input->post('cabang')) {
			$cabang = $this->input->post('cabang');
		}
		if ($this->input->post('alamat')) {
			$alamat = $this->input->post('alamat');
		}
		if ($this->input->post('country')) {
			$country = $this->input->post('country');
		}
		if ($this->input->post('province') && $country=='ID') {
			$province = $this->input->post('province');
		}
		if ($this->input->post('city') != null) {
			$city = $this->input->post('city');
		} else if ($this->input->post('city_select')  != null) {
			$city = $this->input->post('city_select');
		}
		if ($this->input->post('postcode')) {
			$postcode = $this->input->post('postcode');
		}
		if ($this->input->post('telp1')) {
			$telp1 = $this->input->post('telp1');
		}
		if ($this->input->post('telp2')) {
			$telp2 = $this->input->post('telp2');
		}
		if ($this->input->post('fax')) {
			$fax = $this->input->post('fax');
		}
		if ($this->input->post('website')) {
			$website = $this->input->post('website');
		}
		$data = array(
				// 'ADDRESS_ID' => $address_id,
				'VENDOR_ID' => $vendor_id,
				'TYPE' => $cabang,
				'ADDRESS' => $alamat,
				'CITY' => $city,
				'PROVINCE' => $province,
				'COUNTRY' => $country,
				'POST_CODE' => $postcode,
				'TELEPHONE1_NO' => $telp1,
				'TELEPHONE2_NO' => $telp2,
				'FAX' => $fax,
				'WEBSITE' => $website,
			);

		// die(var_dump($data));

		if ($this->session->userdata('STATUS') == "3") {
			$data['VND_TRAIL_ID'] = 3;

			$this->hist_vnd_address->insert($data); 
		}
		else {
			$this->tmp_vnd_address->insert($data);
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Administrative_document/do_insert_general_address','tmp_vnd_address','insert',$data);
			//--END LOG DETAIL--//
		}
		unset($data['VENDOR_ID']);

		redirect('Administrative_document/general_data');
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
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Input akta)','SAVE',$this->input->ip_address());
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
			echo json_encode($this->hist_vnd_akta->insert($data));
		}
		else {
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Administrative_document/do_insert_akta_pendirian','tmp_vnd_akta','insert',$data);
			//--END LOG DETAIL--//
			echo json_encode($this->tmp_vnd_akta->insert($data));
		}
	}

	public function do_update_company_board() {
		$this->load->model('tmp_vnd_board');

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Update company board)','EDIT',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$data = array();

		if ($this->input->post('komisaris_id') != '') {
			$dewan = $this->input->post('komisaris_id');
		} else {
			$dewan = $this->input->post('direksi_id');
		}
		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		}
		if ($this->input->post('type')) {
			$data['TYPE'] = $this->input->post('type');
		}
		if ($this->input->post('name')) {
			$data['NAME'] = $this->input->post('name');
		}
		if ($this->input->post('pos')) {
			$data['POS'] = $this->input->post('pos');
		}
		if ($this->input->post('telephone_no')) {
			$data['TELEPHONE_NO'] = $this->input->post('telephone_no');
		}
		if ($this->input->post('email_address')) {
			$data['EMAIL_ADDRESS'] = $this->input->post('email_address');
		}
		if ($this->input->post('ktp_no')) {
			$data['KTP_NO'] = $this->input->post('ktp_no');
		}
		if ($this->input->post('npwp_no')) {
			$data['NPWP_NO'] = $this->input->post('npwp_no');
		}
		if ($this->input->post('ktp_expired_date')) {
			$data['KTP_EXPIRED_DATE'] = vendortodate($this->input->post('ktp_expired_date'));
		}
		if ($this->input->post('ktp_doc')) {
			$data['KTP_FILE'] = $this->input->post('ktp_doc');
		}

		$where = array("VENDOR_ID" => $vendor_id, 'BOARD_ID' => $dewan);
		
		//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Administrative_document/do_update_company_board','tmp_vnd_board','update',$data,$where);
		//--END LOG DETAIL--//
		echo json_encode($this->tmp_vnd_board->update($data,$where));
	}

	function do_insert_company_board() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_board');
		}
		else {
			$this->load->model('tmp_vnd_board');
		}
		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Input company board)','SAVE',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$type = NULL;
		$name = NULL;
		$pos = NULL;
		$telephone_no = NULL;
		$email_address = NULL;
		$ktp_no = NULL;
		$npwp_no = NULL;
		$ktp_expired_date = NULL;
		if ($this->input->post('type')) {
			$type = $this->input->post('type');
		}
		if ($this->input->post('name')) {
			$name = $this->input->post('name');
		}
		if ($this->input->post('pos')) {
			$pos = $this->input->post('pos');
		}
		if ($this->input->post('telephone_no')) {
			$telephone_no = $this->input->post('telephone_no');
		}
		if ($this->input->post('email_address')) {
			$email_address = $this->input->post('email_address');
		}
		if ($this->input->post('ktp_no')) {
			$ktp_no = $this->input->post('ktp_no');
		}
		if ($this->input->post('npwp_no')) {
			$npwp_no = $this->input->post('npwp_no');
		}
		if ($this->input->post('ktp_expired_date')) {
			$ktp_expired_date = $this->input->post('ktp_expired_date');
		}
		if ($this->input->post('ktp_doc')) {
			$ktp_doc = $this->input->post('ktp_doc');
		}
		$data = array(
				'VENDOR_ID' => $vendor_id,
				'TYPE' => $type,
				'NAME' => $name,
				'POS' => $pos,
				'TELEPHONE_NO' => $telephone_no,
				'EMAIL_ADDRESS' => $email_address,
				'KTP_NO' => $ktp_no,
				'NPWP_NO' => $npwp_no,
				'KTP_EXPIRED_DATE' => vendortodate($ktp_expired_date),
				'KTP_FILE' => $ktp_doc
			);
		if ($this->session->userdata('STATUS') == "3") {
			$data['VND_TRAIL_ID'] = 3;
			$this->hist_vnd_board->insert($data);
		}
		else {
			$this->tmp_vnd_board->insert($data);
			
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Administrative_document/do_insert_company_board','tmp_vnd_board','insert',$data);
			//--END LOG DETAIL--//
		}
		echo json_encode('OK');
	}

	function do_update_bank_financial(){
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_bank');
		}
		else {
			$this->load->model('tmp_vnd_bank');
		}
		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Update bank)','EDIT',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

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
		if ($this->session->userdata('STATUS') == "3") {
			$where = array("VENDOR_ID" => $vendor_id, "VND_TRAIL_ID" => 3,'BANK_ID' => $bank_id);
			$this->hist_vnd_bank->update($data,$where);
		}
		else {
			$where = array("VENDOR_ID" => $vendor_id,'BANK_ID' => $bank_id);
			$this->tmp_vnd_bank->update($data,$where);
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Administrative_document/do_update_bank_financial','tmp_vnd_bank','update',$data,$where);
			//--END LOG DETAIL--//
		}
		echo json_encode('OK');
	}

	function do_insert_bank_data() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_bank');
		}
		else {
			$this->load->model('tmp_vnd_bank');
		}
		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Input bank)','SAVE',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

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
		if ($this->session->userdata('STATUS') == "3") {
			$data['VND_TRAIL_ID'] = 3;
			$this->hist_vnd_bank->insert($data);
		} else {
			$this->tmp_vnd_bank->insert($data);
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Administrative_document/do_insert_bank_data','tmp_vnd_bank','insert',$data);
			//--END LOG DETAIL--//
		}
		echo json_encode('OK');
	}

	function do_insert_financial_report() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_fin_rpt');
		}
		else {
			$this->load->model('tmp_vnd_fin_rpt');
		}
		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Input Financial)','SAVE',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$fin_rpt_currency = NULL;
		$fin_rpt_year = NULL;
		$fin_rpt_type = NULL;
		$fin_rpt_asset_value = NULL;
		$fin_rpt_hutang = NULL;
		$fin_rpt_revenue = NULL;
		$fin_rpt_netincome = NULL;
		if($this->input->post('fin_rpt_currency')) {
			$fin_rpt_currency = $this->input->post('fin_rpt_currency');
		}
		if($this->input->post('fin_rpt_year')) {
			$fin_rpt_year = $this->input->post('fin_rpt_year');
		}
		if($this->input->post('fin_rpt_type')) {
			$fin_rpt_type = $this->input->post('fin_rpt_type');
		}
		if($this->input->post('fin_rpt_asset_value')) {
			$fin_rpt_asset_value = $this->input->post('fin_rpt_asset_value');
			if(preg_match("/^[0-9,]+$/", $fin_rpt_asset_value)) 
				$fin_rpt_asset_value = str_replace(",", "", $fin_rpt_asset_value);
		}
		if($this->input->post('fin_rpt_hutang')) {
			$fin_rpt_hutang = $this->input->post('fin_rpt_hutang');
			if(preg_match("/^[0-9,]+$/", $fin_rpt_hutang)) 
				$fin_rpt_hutang = str_replace(",", "", $fin_rpt_hutang);
		}
		if($this->input->post('fin_rpt_revenue')) {
			$fin_rpt_revenue = $this->input->post('fin_rpt_revenue');
			if(preg_match("/^[0-9,]+$/", $fin_rpt_revenue)) 
				$fin_rpt_revenue = str_replace(",", "", $fin_rpt_revenue);
		}
		if($this->input->post('fin_rpt_netincome')) {
			$fin_rpt_netincome = $this->input->post('fin_rpt_netincome');
			if(preg_match("/^[0-9,]+$/", $fin_rpt_netincome)) 
				$fin_rpt_netincome = str_replace(",", "", $fin_rpt_netincome);
		}
		$data = array(
				'VENDOR_ID' => $vendor_id,
				'FIN_RPT_CURRENCY' => $fin_rpt_currency,
				'FIN_RPT_YEAR' => $fin_rpt_year,
				'FIN_RPT_TYPE' => $fin_rpt_type,
				'FIN_RPT_ASSET_VALUE' => $fin_rpt_asset_value,
				'FIN_RPT_HUTANG' => $fin_rpt_hutang,
				'FIN_RPT_REVENUE' => $fin_rpt_revenue,
				'FIN_RPT_NETINCOME' => $fin_rpt_netincome
			);
		if ($this->session->userdata('STATUS') == "3") {
			$data['VND_TRAIL_ID'] = 3;
			$this->hist_vnd_fin_rpt->insert($data); 
		}
		else {
			$this->tmp_vnd_fin_rpt->insert($data);
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Administrative_document/do_insert_financial_report','tmp_vnd_fin_rpt','insert',$data);
			//--END LOG DETAIL--//
		}
		echo json_encode('OK');
	}

	function do_remove_general_address($address_id) {
		$this->load->model(array('tmp_vnd_address', 'hist_vnd_address'));
		$deleted = false;
		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Delete general address)','Delete',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		if ($this->session->userdata('STATUS') == "3"){
			$deleted = $this->hist_vnd_address->delete(array("ADDRESS_ID"=>$address_id, "VND_TRAIL_ID"=>3)); 
		} else {
			$deleted = $this->tmp_vnd_address->delete(array("ADDRESS_ID" => $address_id));
			//--LOG DETAIL--//
				$where = array("ADDRESS_ID" => $address_id);
				$this->log_data->detail($LM_ID,'Administrative_document/do_remove_general_address','tmp_vnd_address','delete',null,$where);
			//--END LOG DETAIL--//
		}

		if($deleted){
			redirect('Administrative_document/general_data');
		}
		
	}

	function do_remove_legal_akta($akta_id) {
		$this->load->model(array('tmp_vnd_akta', 'hist_vnd_akta'));
		$deleted = false;

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Delete akta)','Delete',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		if ($this->session->userdata('STATUS') == "3"){
			$deleted = $this->hist_vnd_akta->delete(array("AKTA_ID" => $akta_id, "VND_TRAIL_ID"=>3)); 
		} else {
			$deleted = $this->tmp_vnd_akta->delete(array("AKTA_ID" => $akta_id));
			//--LOG DETAIL--//
				$where = array("AKTA_ID" => $akta_id);
				$this->log_data->detail($LM_ID,'Administrative_document/do_remove_legal_akta','tmp_vnd_akta','delete',null,$where);
			//--END LOG DETAIL--//
		}

		if ($deleted) {
			redirect('Administrative_document/legal_data');
		}
	}

	function do_remove_company_board($board_id) {
		$this->load->model(array('tmp_vnd_board', 'hist_vnd_board'));
		$deleted = false;
		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Delete company board)','Delete',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		if ($this->session->userdata('STATUS') == "3"){
			$deleted = $this->hist_vnd_board->delete(array("BOARD_ID" => $board_id, "VND_TRAIL_ID"=>3)); 
		} else {
			$deleted = $this->tmp_vnd_board->delete(array("BOARD_ID" => $board_id));
			//--LOG DETAIL--//
				$where = array("BOARD_ID" => $board_id);
				$this->log_data->detail($LM_ID,'Administrative_document/do_remove_company_board','tmp_vnd_board','delete',null,$where);
			//--END LOG DETAIL--//
		}

		if ($deleted) {
			redirect('Administrative_document/company_board');
		}
	}

	function do_remove_vendor_bank($bank_id) {
		$this->load->model(array('tmp_vnd_bank','hist_vnd_bank'));
		$deleted = false;

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Delete bank)','Delete',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		if ($this->session->userdata('STATUS') == "3"){
			$deleted = $this->hist_vnd_bank->delete(array("BANK_ID" => $bank_id, "VND_TRAIL_ID"=>3));
		} else {
			$deleted = $this->tmp_vnd_bank->delete(array("BANK_ID" => $bank_id));
			//--LOG DETAIL--//
				$where = array("BANK_ID" => $bank_id);
				$this->log_data->detail($LM_ID,'Administrative_document/do_remove_vendor_bank','tmp_vnd_bank','delete',null,$where);
			//--END LOG DETAIL--//
		}

		if ($deleted) {
			redirect('Administrative_document/bank_and_financial_data');
		}
	}

	function do_remove_fin_report($tmp_vnd_fin_rpt) {
		$this->load->model(array('tmp_vnd_fin_rpt', 'hist_vnd_fin_rpt'));
		$deleted = false;

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Delete fin rpt)','Delete',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		if ($this->session->userdata('STATUS') == "3"){
			$deleted = $this->hist_vnd_fin_rpt->delete(array("FIN_RPT_ID" => $tmp_vnd_fin_rpt, "VND_TRAIL_ID"=>3)); 
		} else {
			$deleted = $this->tmp_vnd_fin_rpt->delete(array("FIN_RPT_ID" => $tmp_vnd_fin_rpt));
			//--LOG DETAIL--//
				$where = array("FIN_RPT_ID" => $tmp_vnd_fin_rpt);
				$this->log_data->detail($LM_ID,'Administrative_document/do_remove_fin_report','tmp_vnd_fin_rpt','delete',null,$where);
			//--END LOG DETAIL--//
		}
		if ($deleted) {
			redirect('Administrative_document/bank_and_financial_data');
		}
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

	function get_address_edit(){
		$id_addr = $this->input->post('id_addr');
		$post = $this->input->post();
		if(!empty($id_addr)) {
			$this->load->model(array('hist_vnd_address','tmp_vnd_address'));
			if ($this->session->userdata('STATUS') == "3"){
				$addr_data = $this->hist_vnd_address->get_all(array('ADDRESS_ID'=>$id_addr, 'VND_TRAIL_ID'=>3));
			} else if ($this->session->userdata('STATUS') == "99"){
				$addr_data = $this->hist_vnd_address->get_all(array('ADDRESS_ID'=>$id_addr, 'VND_TRAIL_ID'=>2));
			} else {
				$addr_data = $this->tmp_vnd_address->get_all(array('ADDRESS_ID'=>$id_addr));
			}
			$retval = $addr_data;
		} else {
			$retval = array('ADDRESS_ID'=>'empty');
		}	
		echo json_encode(compact('post', 'retval'));
	}

	function get_bank_edit(){
		$bank_id = $this->input->post('bank_id');
		if(!empty($bank_id)){
			$this->load->model(array('tmp_vnd_bank', 'hist_vnd_bank'));
			if ($this->session->userdata('STATUS') == "3"){
				$bank_data = $this->hist_vnd_bank->get_all(array('BANK_ID'=>$bank_id, 'VND_TRAIL_ID'=>3));
			} else if ($this->session->userdata('STATUS') == "99"){
				$bank_data = $this->hist_vnd_bank->get_all(array('BANK_ID'=>$bank_id, 'VND_TRAIL_ID'=>2));
			} else {
				$bank_data = $this->tmp_vnd_bank->get_all(array('BANK_ID'=>$bank_id));
			}
		} else {

		}

		echo json_encode($bank_data);
	}

	function do_update_laporan_keuangan(){
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_fin_rpt');
		}
		else {
			$this->load->model('tmp_vnd_fin_rpt');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Update fin rpt header)','EDIT',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
		
		$vendor_id = $this->input->post('vendor_id');

		$fin_rpt_id = $this->input->post('fin_rpt_id');

		$fin_rpt_currency = NULL;
		$fin_rpt_year = NULL;
		$fin_rpt_type = NULL;
		$fin_rpt_asset_value = NULL;
		$fin_rpt_hutang = NULL;
		$fin_rpt_revenue = NULL;
		$fin_rpt_netincome = NULL;
		if($this->input->post('fin_rpt_currency')) {
			$fin_rpt_currency = $this->input->post('fin_rpt_currency');
		}
		if($this->input->post('fin_rpt_year')) {
			$fin_rpt_year = $this->input->post('fin_rpt_year');
		}
		if($this->input->post('fin_rpt_type')) {
			$fin_rpt_type = $this->input->post('fin_rpt_type');
		}
		if($this->input->post('fin_rpt_asset_value')) {
			$fin_rpt_asset_value = $this->input->post('fin_rpt_asset_value');
			if(preg_match("/^[0-9,]+$/", $fin_rpt_asset_value)) 
				$fin_rpt_asset_value = str_replace(",", "", $fin_rpt_asset_value);
		}
		if($this->input->post('fin_rpt_hutang')) {
			$fin_rpt_hutang = $this->input->post('fin_rpt_hutang');
			if(preg_match("/^[0-9,]+$/", $fin_rpt_hutang)) 
				$fin_rpt_hutang = str_replace(",", "", $fin_rpt_hutang);
		}
		if($this->input->post('fin_rpt_revenue')) {
			$fin_rpt_revenue = $this->input->post('fin_rpt_revenue');
			if(preg_match("/^[0-9,]+$/", $fin_rpt_revenue)) 
				$fin_rpt_revenue = str_replace(",", "", $fin_rpt_revenue);
		}
		if($this->input->post('fin_rpt_netincome')) {
			$fin_rpt_netincome = $this->input->post('fin_rpt_netincome');
			if(preg_match("/^[0-9,]+$/", $fin_rpt_netincome)) 
				$fin_rpt_netincome = str_replace(",", "", $fin_rpt_netincome);
		}
		$data = array(
				'VENDOR_ID' => $vendor_id,
				'FIN_RPT_CURRENCY' => $fin_rpt_currency,
				'FIN_RPT_YEAR' => $fin_rpt_year,
				'FIN_RPT_TYPE' => $fin_rpt_type,
				'FIN_RPT_ASSET_VALUE' => $fin_rpt_asset_value,
				'FIN_RPT_HUTANG' => $fin_rpt_hutang,
				'FIN_RPT_REVENUE' => $fin_rpt_revenue,
				'FIN_RPT_NETINCOME' => $fin_rpt_netincome
			);
		if ($this->session->userdata('STATUS') == "3") {
			$where = array("VENDOR_ID" => $vendor_id, "VND_TRAIL_ID" => 3,'FIN_RPT_ID' => $fin_rpt_id);
			$this->hist_vnd_fin_rpt->update($data,$where);
		}
		else {
			$where = array("VENDOR_ID" => $vendor_id,'FIN_RPT_ID' => $fin_rpt_id);
			$this->tmp_vnd_fin_rpt->update($data,$where);
			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Administrative_document/do_update_laporan_keuangan','tmp_vnd_fin_rpt','update',$data,$where);
		//--END LOG DETAIL--//
		}
		echo json_encode('OK');
	}

	function get_fin_rpt_edit(){
		$fin_rpt_id = $this->input->post('fin_rpt_id');
		if(!empty($fin_rpt_id)){
			$this->load->model(array('tmp_vnd_fin_rpt', 'hist_vnd_fin_rpt'));
			if ($this->session->userdata('STATUS') == "3"){
				$fin_rpt_data = $this->hist_vnd_fin_rpt->get_all(array('FIN_RPT_ID'=>$fin_rpt_id, 'VND_TRAIL_ID'=>3));
			// } else if ($this->session->userdata('STATUS') == "99"){
			// 	$fin_rpt_data = $this->hist_vnd_fin_rpt->get_all(array('FIN_RPT_ID'=>$fin_rpt_id, 'VND_TRAIL_ID'=>2));
			} else {
				$fin_rpt_data = $this->tmp_vnd_fin_rpt->get_all(array('FIN_RPT_ID'=>$fin_rpt_id));
			}
		} else {
			
		}

		echo json_encode($fin_rpt_data);
	}

	public function viewDok($id = null){
		$url = str_replace("int-","", base_url());
		$this->load->helper('file');
		$image_path = base_url(UPLOAD_PATH).'/vendor/'.$id;	

		if (strpos($url, 'semenindonesia.com') !== false) { //server production
		$user_id=url_encode($this->session->userdata['VENDOR_ID']);
			if(empty($id)){
				die('tidak ada attachment.');
			}
			if(file_exists(BASEPATH.'../upload/vendor/'.$id)){				
				$this->output->set_content_type(get_mime_by_extension($image_path));
				return $this->output->set_output(file_get_contents($image_path));
			}else{
				$url = str_replace("http","https", $url);
				redirect($url.'View_document_procurement/viewDokPpmDok/'.$id.'/'.$user_id);
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
