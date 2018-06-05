<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_update_profile extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->model(array('hist_vnd_header','vnd_update_progress','tmp_vnd_reg_progress'));
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
		redirect('Vendor_update_profile/data_vendor');
	}

	public function data_vendor() {
		$this->layout->add_css('pages/vendor_update_profile.css');
		$data['progress_status'] = $this->prog_status;
		$this->load->model(array(
			'm_vnd_prefix',
			'm_vnd_suffix',
			'adm_country',
			'm_vnd_akta_type',
			'm_vnd_type',
			'm_vnd_certificate_type',
			'm_vnd_tools_category',
			'adm_curr',
			'adm_wilayah'
			));
		$this->load->model(array(
			'hist_vnd_address',
			'hist_vnd_akta',
			'hist_vnd_board',
			'hist_vnd_bank',
			'hist_vnd_fin_rpt',
			'hist_vnd_product',
			'hist_vnd_sdm',
			'hist_vnd_cert',
			'hist_vnd_equip',
			'hist_vnd_cv',
			'hist_vnd_add'
			));
		
		$data['title'] = "Detail Profile";
		
		$data['prefix'] = $this->m_vnd_prefix->as_dropdown('PREFIX_NAME')->get_all();
		$data['suffix'] = $this->m_vnd_suffix->as_dropdown('SUFFIX_NAME')->get_all();
		$data['country'] = $this->adm_country->as_dropdown('COUNTRY_NAME')->get_all();
		$data['akta_type'] = $this->m_vnd_akta_type->as_dropdown('AKTA_TYPE')->get_all();
		$data['vendor_type'] = $this->m_vnd_type->as_dropdown('VENDOR_TYPE')->get_all();
		$data['currency'] = $this->adm_curr->as_dropdown('CURR_CODE')->get_all();
		$data['certificate_type'] = $this->m_vnd_certificate_type->as_dropdown('CERTIFICATE_TYPE')->get_all();
		$data['tools_category'] = $this->m_vnd_tools_category->as_dropdown('CATEGORY')->get_all();

		$vendor = $this->hist_vnd_header
		->with_add(('where:VND_TRAIL_ID=\'3\''))
		->with_akta(('where:VND_TRAIL_ID=\'3\''))
		->with_address(('where:VND_TRAIL_ID=\'3\''))
		->with_bank(('where:VND_TRAIL_ID=\'3\''))
		->with_board(('where:VND_TRAIL_ID=\'3\''))
		->with_cert(('where:VND_TRAIL_ID=\'3\''))
		->with_cv(('where:VND_TRAIL_ID=\'3\''))
		->with_equip(('where:VND_TRAIL_ID=\'3\''))
		->with_fin_rpt(('where:VND_TRAIL_ID=\'3\''))
		->with_product(('where:VND_TRAIL_ID=\'3\''))
		->with_sdm(('where:VND_TRAIL_ID=\'3\''))
		->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "VND_TRAIL_ID" => 3));

		$data['vendor_akta'] = $vendor['akta'];
		$data['company_address'] = $vendor['address'];
		$data['vendor_board_commissioner'] = $this->hist_vnd_board->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Commissioner", "VND_TRAIL_ID" => 3));
		$data['vendor_board_director'] = $this->hist_vnd_board->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Director", "VND_TRAIL_ID" => 3));
		$data['vendor_fin_report'] = $vendor['fin_rpt'];
		$data['vendor_bank'] = $vendor['bank'];
		$data['goods'] = $this->hist_vnd_product->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "PRODUCT_TYPE" => "GOODS", "VND_TRAIL_ID" => 3));
		$data['bahan'] = $this->hist_vnd_product->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "PRODUCT_TYPE" => "BAHAN", "VND_TRAIL_ID" => 3));
		$data['services'] = $this->hist_vnd_product->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "PRODUCT_TYPE" => "SERVICES", "VND_TRAIL_ID" => 3));
		$data['main_sdm'] = $this->hist_vnd_sdm->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "MAIN", "VND_TRAIL_ID" => 3));
		$data['support_sdm'] = $this->hist_vnd_sdm->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "SUPPORT", "VND_TRAIL_ID" => 3));
		$data['certifications'] = $vendor['cert'];
		$data['equipments'] = $vendor['equip'];
		$data['experiences'] = $vendor['cv'];
		$data['principals'] = $this->hist_vnd_add->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Principal", "VND_TRAIL_ID" => 3));
		$data['subcontractors'] = $this->hist_vnd_add->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Subcontractor", "VND_TRAIL_ID" => 3));
		$data['affiliation_companies'] = $this->hist_vnd_add->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Affiliation Company", "VND_TRAIL_ID" => 3));

		$province = create_standard($this->adm_wilayah->fields('ID,NAMA')->get_all(array('JENIS'=>'PROVINSI')));
		$city = create_standard($this->adm_wilayah->fields('ID,NAMA')->get_all(array('JENIS'=>'KOTA')));

		
		$city_list = array();
		foreach ($city as $key => $value) {
			$city_list[$key] = $value;
		}
		$data['city_list'] = $city_list;
		
		$province_list = array();
		foreach ($province as $key => $value) {
			$province_list[$key] = $value;
		}
		$data['province_list'] = $province_list;

		$data['vendor_detail'] = $vendor;

		$venid = $this->session->userdata['VENDOR_ID'];

		$this->load->model('vnd_vendor_comment');
		$data['ven_comment'] = $this->vnd_vendor_comment->where('STATUS_AKTIF','2')->order_by('ID','ASC')->get_all(array("VENDOR_ID" => intval($venid)));

		/*cek untuk data jika sudah dikirim*/
		$this->load->model('vendor_employe');
		$data['cek_vend'] = $this->vendor_employe->cekvendor($venid);
		// var_dump($data['cek_vend']);

		$this->layout->render('form_review_input', $data);
	}

	public function general_data() {
		$data['progress_status'] = $this->prog_status;
		$this->load->model('adm_country');
		// $this->load->model('adm_city');
		$this->load->model(array('adm_wilayah', 'm_vnd_type','m_vnd_prefix','m_vnd_suffix'));

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
		// echo "<pre>";
		// print_r($vendor);die;

		$data['title'] = "Data Umum";
		$data['prefix'] = $this->m_vnd_prefix->as_dropdown('PREFIX_NAME')->get_all();
		$data['suffix'] = create_standard($this->m_vnd_suffix->get_all(),'Suffix');
		$data['country'] = create_standard($this->adm_country->get_all(),'Country');
		$data['country_list'] = $this->adm_country->as_dropdown('COUNTRY_NAME')->get_all();
		$data['city_list'] = $this->adm_wilayah->as_dropdown('NAMA')->get_all();
		$data['province'] = create_standard($this->adm_wilayah->fields('ID,NAMA')->get_all(array('JENIS'=>'PROVINSI')), 'Province');
		// $data['city'] = create_standard($this->adm_city->get_all(),'City');
		$data['city_select'] = create_standard($this->adm_wilayah->fields('ID,NAMA')->get_all(array('JENIS'=>'KOTA')),'City');

		// echo "<pre>";
		// print_r();die;

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
		$this->layout->add_js(base_url().'Assets/Vendor_update_profile/assets/administrative_document.js', TRUE);
		$this->layout->render('form_general_data', $data);
	}

	public function legal_data() {
		$data['progress_status'] = $this->prog_status;
		$this->load->model('m_vnd_akta_type');
		$this->load->model('adm_country');
		$this->load->model('m_vnd_type');
		$this->load->model(array('adm_wilayah'));
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
		$this->layout->add_js(base_url().'Assets/Vendor_update_profile/assets/administrative_document.js', TRUE);
		$this->layout->render('form_legal_data', $data);
	}

	public function company_board() {
		$data['progress_status'] = $this->prog_status;
		$this->load->model('hist_vnd_board');
		$vendor = $this->hist_vnd_header->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "VND_TRAIL_ID" => 3));
		$data['vendor_detail'] = $vendor;
		$data['vendor_board_commissioner'] = $this->hist_vnd_board->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Commissioner", "VND_TRAIL_ID" => 3));
		$data['vendor_board_director'] = $this->hist_vnd_board->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Director", "VND_TRAIL_ID" => 3));
		$data['title'] = "Company Board";
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
		$this->layout->add_js(base_url().'Assets/Vendor_update_profile/assets/administrative_document.js', TRUE);
		$this->layout->render('form_company_board', $data);
	}

	public function bank_and_financial_data() {
		$data['progress_status'] = $this->prog_status;
		$this->load->model('adm_curr');
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
		$data['title'] = "Bank and Financial Data";
		$data['currency'] = $this->adm_curr->as_dropdown('CURR_NAME')->get_all();
		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
		$this->layout->add_js('plugins/jquery.maskedinput.js');
		$this->layout->add_js('plugins/autoNumeric.js');
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js(base_url().'Assets/Vendor_update_profile/assets/administrative_document.js', TRUE);
		$this->layout->render('form_bank_and_financial_data', $data);
	}

	public function good_and_service_data() {
		$this->load->model('m_material_group');
		$this->load->model('m_sub_material_group');
		$this->load->model('vnd_header');
		$this->load->model('com_jasa_group');
		$this->load->model('com_jasa_kualifikasi');
		$data['progress_status'] = $this->prog_status;
		
		$this->load->model(array('m_vnd_material','m_vnd_svc','hist_vnd_product'));
		$vendor = $this->vnd_header->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID"))));
		$data['vendor_detail'] = $vendor;
		
		$data['goods'] = $this->hist_vnd_product->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "PRODUCT_TYPE" => "GOODS", "VND_TRAIL_ID" => 3));
		$data['bahan'] = $this->hist_vnd_product->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "PRODUCT_TYPE" => "BAHAN", "VND_TRAIL_ID" => 3));
		$data['services'] = $this->hist_vnd_product->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "PRODUCT_TYPE" => "SERVICES", "VND_TRAIL_ID" => 3));
		
		$data['title'] = "Data Barang dan Jasa";
		$data['svc'] = $this->m_material_group->order_by('DESCRIPTION','ASC')->get_all(array('IS_JASA' => 1));
		$data['subsvc'] = $this->m_sub_material_group->order_by('DESCRIPTION','ASC')->get_all(array('IS_JASA' => 1));

		// $data['material'] = $this->m_material_group->order_by('DESCRIPTION','ASC')->get_all(array('IS_JASA' => 0));
		// $data['submaterial'] = $this->m_sub_material_group->order_by('DESCRIPTION','ASC')->get_all(array('IS_JASA' => 0));

		$data['material'] = $this->m_material_group->get_material();
		$data['submaterial'] = $this->m_sub_material_group->get_sub_material();

		$data['group_jasa']=$this->com_jasa_group->get_jasa();
		$data['kualifikasi_jasa']=$this->com_jasa_kualifikasi->get_jasa();

		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
		$this->layout->add_js('plugins/autoNumeric.js');
		$this->layout->add_js('plugins/jquery.maskedinput.js');
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');

		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js(base_url().'Assets/Vendor_update_profile/assets/technical_document.js', TRUE);
		$this->layout->render('form_good_and_service_data', $data);
	}

	public function human_resources_data() {
		$data['progress_status'] = $this->prog_status;
		$this->load->model(array('hist_vnd_sdm','m_vnd_sdm_type_kwn','m_vnd_sdm_type_work'));
		$vendor = $this->hist_vnd_header->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "VND_TRAIL_ID" => 3));
		$data['vendor_detail'] = $vendor;
		$data['main_sdm'] = $this->hist_vnd_sdm->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "MAIN", "VND_TRAIL_ID" => 3));
		$data['support_sdm'] = $this->hist_vnd_sdm->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "SUPPORT", "VND_TRAIL_ID" => 3));
		
		$data['title'] = "Data SDM";
		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
		$this->layout->add_js('plugins/autoNumeric.js');
		$this->layout->add_js('plugins/jquery.maskedinput.js');
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$data['type_kwn'] = $this->m_vnd_sdm_type_kwn->get();
		$data['type_work'] = $this->m_vnd_sdm_type_work->get();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('jquery-ui.js');
		$this->layout->add_js(base_url().'Assets/Vendor_update_profile/assets/technical_document.js', TRUE);
		$this->layout->render('form_human_resources_data', $data);
	}

	public function certification_data() {
		$data['progress_status'] = $this->prog_status;
		$this->load->model(array('hist_vnd_cert','m_vnd_certificate_type'));
		$vendor = $this->hist_vnd_header->with('cert')->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "VND_TRAIL_ID" => 3));
		$data['vendor_detail'] = $vendor;
		$certifications = array();
		foreach ((array)$vendor['cert'] as $key => $value) {
			if($value['VND_TRAIL_ID']==3){
				array_push($certifications, $value);
			}
		}
		$data['certifications'] = $certifications;
		$data['title'] = "Data Sertifikasi";
		$data['certificate_type'] = $this->m_vnd_certificate_type->as_dropdown('CERTIFICATE_TYPE')->get_all();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
		$this->layout->add_js('plugins/jquery.maskedinput.js');
		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
		$this->layout->add_js('plugins/SimpleAjaxUploader.js');
		$this->layout->add_js(base_url().'Assets/Vendor_update_profile/assets/technical_document.js', TRUE);
		$this->layout->render('form_certification_data', $data);
	}

	public function facility_and_equipment() {
		$data['progress_status'] = $this->prog_status;
		
		$this->load->model(array('hist_vnd_equip','m_vnd_tools_category'));
		$vendor = $this->hist_vnd_header->with('equip')->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "VND_TRAIL_ID" => 3));
		//var_dump($vendor);exit();
		$data['vendor_detail'] = $vendor;
		//var_dump($vendor['equip']);exit();
		$equip = array();
		if(!empty($vendor['equip'])){
			foreach ($vendor['equip'] as $key => $value) {
				if($value['VND_TRAIL_ID'] == 3){
					array_push($equip, $value);
				}
			}	
		}
		
		$data['equipments'] = $equip;
		$data['title'] = "Fasilitas & Peralatan";
		$data['tools_category'] = $this->m_vnd_tools_category->as_dropdown('CATEGORY')->get_all();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
		$this->layout->add_js(base_url().'Assets/Vendor_update_profile/assets/technical_document.js', TRUE);
		$this->layout->render('form_facility_and_equipment', $data);
	}

	public function company_experience() {
		$data['progress_status'] = $this->prog_status;
		$this->load->model(array('hist_vnd_cv','adm_curr'));
		$vendor = $this->hist_vnd_header->with('cv')->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "VND_TRAIL_ID" => 3));
		$data['vendor_detail'] = $vendor;
		// var_dump($vendor);exit();
		$experiences = array();
		if (!empty($vendor['cv'])) {
			foreach ($vendor['cv'] as $key => $value) {
				if($value['VND_TRAIL_ID']==3){
					array_push($experiences, $value);
				}
			}
		}
		$data['experiences'] = $experiences;
		$data['title'] = "Pengalaman Perusahaan";
		$data['currency'] = $this->adm_curr->as_dropdown('CURR_NAME')->get_all();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
		$this->layout->add_js('plugins/SimpleAjaxUploader.js');
		$this->layout->add_js('plugins/autoNumeric.js');		
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js(base_url().'Assets/Vendor_update_profile/assets/technical_document.js', TRUE);
		$this->layout->render('form_company_experience', $data);
	}

	public function additional_document() {
		$data['progress_status'] = $this->prog_status;
		$this->load->model(array('hist_vnd_add'));
		$vendor = $this->hist_vnd_header->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "VND_TRAIL_ID" => 3));
		$data['vendor_detail'] = $vendor;
		$data['principals'] = $this->hist_vnd_add->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Principal", "VND_TRAIL_ID" => 3));
		$data['subcontractors'] = $this->hist_vnd_add->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Subcontractor", "VND_TRAIL_ID" => 3));
		$data['affiliation_companies'] = $this->hist_vnd_add->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Affiliation Company", "VND_TRAIL_ID" => 3));
		$data['title'] = "Dokumen Tambahan";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
		$this->layout->add_js(base_url().'Assets/Vendor_update_profile/assets/additional_document.js', TRUE);
		$this->layout->render('form_additional_document', $data);
	}

	/* Start General Data */
	function do_update_general_address() {
		$this->load->model('hist_vnd_address'); 

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Update general address)','EDIT',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		if ($this->input->post('address_id')) {
			$address_id = $this->input->post('address_id');
		}else{
			echo json_encode('address_id tidak ada');
			return;
		}

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

		$this->do_insert_panel($LM_ID);

		//--LOG DETAIL--//
		$where['ADDRESS_ID'] = $address_id;
		$where['VND_TRAIL_ID'] = '3';
		$this->log_data->detail($LM_ID,'Vendor_update_profile/do_update_general_address','hist_vnd_address','update',$data,$where);
		//--END LOG DETAIL--//
		
		if ($this->session->userdata('STATUS') == "3") {
			echo json_encode($this->hist_vnd_address->update($data,array("ADDRESS_ID" => $address_id, "VND_TRAIL_ID" => 3)));
		}
	}

	function do_insert_general_address() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_address');
		}

		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Input general address)','SAVE',$this->input->ip_address()
			);
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

		$city1 = $this->input->post('city_select');
		$city2 = $this->input->post('city'); 

		if ($this->session->userdata('STATUS') == "3") {
			$data['VND_TRAIL_ID'] = 3;
			$this->hist_vnd_address->insert($data);

			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_insert_general_address','hist_vnd_address','insert',$data);
			//--END LOG DETAIL--//
		}
		unset($data['VENDOR_ID']);

		$this->do_insert_panel($LM_ID);

		redirect('Vendor_update_profile/general_data');
	}

	function do_update_general_data() {
		$this->load->model('hist_vnd_header');

		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Update general data)','EDIT',$this->input->ip_address()
			);
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

			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_update_general_data','hist_vnd_address','update',$data_update,$where);
			//--END LOG DETAIL--// 
		}
		echo json_encode('OK');
	}

	function get_address_edit(){
		$id_addr = $this->input->post('id_addr');
		$post = $this->input->post();
		if(!empty($id_addr)) {
			$this->load->model('hist_vnd_address');
			$addr_data = $this->hist_vnd_address->get_all(array('ADDRESS_ID'=>$id_addr, 'VND_TRAIL_ID'=>3));
			$retval = $addr_data;
		} else {
			$retval = array('ADDRESS_ID'=>'empty');
		}	
		echo json_encode(compact('post', 'retval'));
	}

	function do_remove_general_address($address_id) {
		$this->load->model('hist_vnd_address');
		
		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Delete general address)','Delete',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$deleted = false;
		if ($this->session->userdata('STATUS') == "3"){
			$deleted = $this->hist_vnd_address->delete(array("ADDRESS_ID"=>$address_id, "VND_TRAIL_ID"=>3));
		}
		//--LOG DETAIL--//
		$where = array("ADDRESS_ID"=>$address_id, "VND_TRAIL_ID"=>3);
		$this->log_data->detail($LM_ID,'Vendor_update_profile/do_remove_general_address','hist_vnd_address','delete',null,$where);
		//--END LOG DETAIL--//

		if($deleted){
			redirect('Vendor_update_profile/general_data');
		}
	}
	/* End General Data */

	/* Start Legal Data */
	function do_update_legal_data() {
		$this->load->model('hist_vnd_header');

		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		} else {
			echo json_encode('vendor_id tidak ada');
			return;
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Update legal data)','EDIT',$this->input->ip_address()
			);
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

		$api_no_doc = $this->input->post('api_no_doc');
		$data_update['API_NO_DOC'] = $api_no_doc;
		
		$address_domisili_no = $this->input->post('address_domisili_no');
		$data_update['ADDRESS_DOMISILI_NO'] = $address_domisili_no;
		
		$address_domisili_date = $this->input->post('address_domisili_date');
		if($this->input->post('address_domisili_date')){
			$data_update['ADDRESS_DOMISILI_DATE'] = vendortodate($address_domisili_date);
		} else{
			$data_update['ADDRESS_DOMISILI_DATE'] = '';
		}
		
		$address_domisili_exp_date = $this->input->post('address_domisili_exp_date');
		if($this->input->post('address_domisili_exp_date')) {
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
		if($this->input->post('siup_from')){
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
		

		$api_issued_by = $this->input->post('api_issued_by');
		$data_update['API_ISSUED_BY'] = $api_issued_by;

		
		$api_no = $this->input->post('api_no');
		$data_update['API_NO'] = $api_no;
		
		$api_from = $this->input->post('api_from');
		if($this->input->post('api_from')){
			$data_update['API_FROM'] = vendortodate($api_from);
		} else {
			$data_update['API_FROM'] = '';
		}
		
		$api_to = $this->input->post('api_to');
		if($this->input->post('api_to')){
			$data_update['API_TO'] = vendortodate($api_to);
		} else {
			$data_update['API_TO'] = '';
		}
		

		//--LOG DETAIL--//
		$where = array("VENDOR_ID" => $vendor_id, "VND_TRAIL_ID" => 3);
		$this->log_data->detail($LM_ID,'Vendor_update_profile/do_update_legal_data','hist_vnd_header','update',$data_update,$where);
		//--END LOG DETAIL--//

		if ($this->session->userdata('STATUS') == "3") {
			$where = array("VENDOR_ID" => $vendor_id, "VND_TRAIL_ID" => 3);
			echo json_encode($this->hist_vnd_header->update($data_update,$where)); 
		}
	}

	function do_update_akta_data() {
		$this->load->model('hist_vnd_akta'); 

		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		} else {
			echo json_encode('vendor_id tidak ada');
			return;
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Update akta)','EDIT',$this->input->ip_address()
			);
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
		if($this->input->post('pengesahan_hakim_edit')) {
			$pengesahan_hakim = $this->input->post('pengesahan_hakim_edit');
			$data_update["PENGESAHAN_HAKIM"] = vendortodate($pengesahan_hakim);
		} else {
			$data_update["PENGESAHAN_HAKIM"] = '';
		}
		if($this->input->post('berita_acara_ngr_edit')) {
			$berita_acara_ngr = $this->input->post('berita_acara_ngr_edit');
			$data_update["BERITA_ACARA_NGR"] = vendortodate($berita_acara_ngr);
		} else {
			$data_update["BERITA_ACARA_NGR"] = '';
		}

		$akta = $this->input->post('file1');
		if (!empty($akta)) {
			$data_update['AKTA_NO_DOC']=$akta;
		}

		$hakim = $this->input->post('file2');
		if (!empty($hakim)){
			$data_update['PENGESAHAN_HAKIM_DOC'] = $hakim;
		}
		
		$berita = $this->input->post('file3');
		if (!empty($berita)) {
			$data_update['BERITA_ACARA_NGR_DOC'] = $berita;
		}

		if ($this->session->userdata('STATUS') == "3") {
			
			$this->do_insert_panel($LM_ID);
			$where = array("VENDOR_ID" => $vendor_id, "VND_TRAIL_ID" => 3, 'AKTA_ID' => $this->input->post('akta_id'));

			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_update_akta_data','hist_vnd_akta','update',$data_update,$where);
			//--END LOG DETAIL--//

			echo json_encode($this->hist_vnd_akta->update($data_update,$where));
		}
	}

	function do_insert_akta_pendirian() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_akta');
		}
		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Input Akta)','SAVE',$this->input->ip_address()
			);
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
		
		$data["AKTA_NO_DOC"] = $this->input->post('file1');
		
		$data["PENGESAHAN_HAKIM_DOC"] = $this->input->post('file2');
		
		$data["BERITA_ACARA_NGR_DOC"] = $this->input->post('file3');
		
		if ($this->session->userdata('STATUS') == "3") {
			$data["VND_TRAIL_ID"] = "3";

			$this->do_insert_panel($LM_ID);

			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_insert_akta_pendirian','hist_vnd_akta','insert',$data);
			//--END LOG DETAIL--//
			
			echo json_encode($this->hist_vnd_akta->insert($data));
		}
		else {
			echo json_encode("Gagal Insert");
		}
	}

	function do_remove_legal_akta($akta_id) {
		$this->load->model('hist_vnd_akta');

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Delete akta)','Delete',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$deleted = false;
		if ($this->session->userdata('STATUS') == "3"){
			$deleted = $this->hist_vnd_akta->delete(array("AKTA_ID" => $akta_id, "VND_TRAIL_ID"=>3));

			//--LOG DETAIL--//
			$where = array("AKTA_ID" => $akta_id, "VND_TRAIL_ID"=>3);
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_remove_legal_akta','hist_vnd_akta','delete',null,$where);
			//--END LOG DETAIL--//
		} 
		if ($deleted) {
			redirect('Vendor_update_profile/legal_data');
		}
	}
	/* End Legal Data */

	/* Start Company Board */
	function do_update_company_board() {
		$this->load->model('hist_vnd_board');

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Update company board)','EDIT',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
		
		$data = array();
		// var_dump($this->input->post());
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
		} else {
			$data['KTP_EXPIRED_DATE'] = '';
		}
		if ($this->input->post('file_upload')) {
			$data['KTP_FILE'] = $this->input->post('file_upload');
		}
		
		if ($this->session->userdata('STATUS') == "3") {

			$this->do_insert_panel($LM_ID);

			$where = array("VENDOR_ID" => $vendor_id, "VND_TRAIL_ID" => 3, 'BOARD_ID' => $dewan);

			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_update_company_board','hist_vnd_board','update',$data,$where);
			//--END LOG DETAIL--//
			echo json_encode($this->hist_vnd_board->update($data,$where));
		}
	}

	function do_insert_company_board() {

		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_board');
		}
		if ($this->input->post('vendor_id')) {
			$data['VENDOR_ID'] = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Input company board)','SAVE',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

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
		if ($this->input->post('file_upload')) {
			$data['KTP_FILE'] = $this->input->post('file_upload');
		}

		if ($this->session->userdata('STATUS') == "3") {
			$data['VND_TRAIL_ID'] = 3;
			$this->hist_vnd_board->insert($data);

			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_insert_company_board','hist_vnd_board','insert',$data);
			//--END LOG DETAIL--//

			$this->do_insert_panel($LM_ID);

			echo json_encode('OK');
		}
		else {
			echo json_encode('Gagal Add Data!');
		}
	}

	function do_remove_company_board($board_id) {
		$this->load->model('hist_vnd_board');

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Delete company board)','Delete',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$deleted = false;
		if ($this->session->userdata('STATUS') == "3"){
			$deleted = $this->hist_vnd_board->delete(array("BOARD_ID" => $board_id, "VND_TRAIL_ID"=>3));

			//--LOG DETAIL--//
			$where = array("BOARD_ID" => $board_id, "VND_TRAIL_ID"=>3);
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_remove_company_board','hist_vnd_board','delete',null,$where);
			//--END LOG DETAIL--//
		}

		if ($deleted) {
			redirect('Vendor_update_profile/company_board');
		}
	}
	/* End Company Board */

	/* Start Bank Financial */
	function do_update_bank_financial(){
		$this->load->model('hist_vnd_bank');

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Update bank)','EDIT',$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$bank_id = $this->input->post('bank_id');


		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		}
		if ($this->input->post('vendor_id')) {
			$data['VENDOR_ID'] = $this->input->post('vendor_id');
		}
		if ($this->input->post('account_no')) {
			$data['ACCOUNT_NO'] = $this->input->post('account_no');
		}
		if ($this->input->post('account_name')) {
			$data['ACCOUNT_NAME'] = $this->input->post('account_name');
		}
		if ($this->input->post('bank_name')) {
			$data['BANK_NAME'] = $this->input->post('bank_name');
		}
		if ($this->input->post('bank_branch')) {
			$data['BANK_BRANCH'] = $this->input->post('bank_branch');
		}
		if ($this->input->post('swift_code')) {
			$data['SWIFT_CODE'] = $this->input->post('swift_code');
		}
		if ($this->input->post('address')) {
			$data['ADDRESS'] = $this->input->post('address');
		}
		if ($this->input->post('bank_postal_code')) {
			$data['BANK_POSTAL_CODE'] = $this->input->post('bank_postal_code');
		}
		if ($this->input->post('currency')) {
			$data['CURRENCY'] = $this->input->post('currency');
		}
		if ($this->input->post('reference_bank')) {
			$data['REFERENCE_BANK'] = $this->input->post('reference_bank');
		}

		$new = $this->input->post('file_upload');
		$old = $this->input->post('file_upload_lama');
		if (!empty($new)) {
			$data['REFERENCE_FILE'] = $new;
			$path = './upload/vendor/'.$old;
			if(file_exists(BASEPATH.'../upload/vendor/'.$old)){
				unlink($path);
			}
		} else {
			$data['REFERENCE_FILE'] = $old;
		}

		$where = array("VENDOR_ID" => $vendor_id, "VND_TRAIL_ID" => 3,'BANK_ID' => $bank_id);
		$this->hist_vnd_bank->update($data,$where);

			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Vendor_update_profile/do_update_bank_financial','hist_vnd_bank','update',$data,$where);
			//--END LOG DETAIL--//

		$this->do_insert_panel($LM_ID);
		
		echo "OK";
	}

	function do_update_laporan_keuangan(){
		$this->load->model('hist_vnd_fin_rpt');
		
		$data['VENDOR_ID'] = $this->input->post('vendor_id');

		$fin_rpt_id = $this->input->post('fin_rpt_id');

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Update fin rpt)','EDIT',$this->input->ip_address()
			);
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
			$data['FIN_RPT_CURRENCY'] = $this->input->post('fin_rpt_currency');
		}
		if($this->input->post('fin_rpt_year')) {
			$data['FIN_RPT_YEAR'] = $this->input->post('fin_rpt_year');
		}
		if($this->input->post('fin_rpt_type')) {
			$data['FIN_RPT_TYPE'] = $this->input->post('fin_rpt_type');
		}
		if($this->input->post('fin_rpt_asset_value')) {
			$fin_rpt_asset_value = $this->input->post('fin_rpt_asset_value');
			if(preg_match("/^[0-9,]+$/", $fin_rpt_asset_value)) 
				$data['FIN_RPT_ASSET_VALUE'] = str_replace(",", "", $fin_rpt_asset_value);
		}
		if($this->input->post('fin_rpt_hutang')) {
			$fin_rpt_hutang = $this->input->post('fin_rpt_hutang');
			if(preg_match("/^[0-9,]+$/", $fin_rpt_hutang)) 
				$data['FIN_RPT_HUTANG'] = str_replace(",", "", $fin_rpt_hutang);
		}
		if($this->input->post('fin_rpt_revenue')) {
			$fin_rpt_revenue = $this->input->post('fin_rpt_revenue');
			if(preg_match("/^[0-9,]+$/", $fin_rpt_revenue)) 
				$data['FIN_RPT_REVENUE'] = str_replace(",", "", $fin_rpt_revenue);
		}
		if($this->input->post('fin_rpt_netincome')) {
			$fin_rpt_netincome = $this->input->post('fin_rpt_netincome');
			if(preg_match("/^[0-9,]+$/", $fin_rpt_netincome)) 
				$data['FIN_RPT_NETINCOME'] = str_replace(",", "", $fin_rpt_netincome);
		}

		$new = $this->input->post('file_upload');
		$old = $this->input->post('file_lama_rpt');

		if(!empty($new)){
			$data['FILE_UPLOAD'] = $new;
			$path = './upload/vendor/'.$old;
			if(file_exists(BASEPATH.'../upload/vendor/'.$old)){
				unlink($path);
			}
		} else {
			$data['FILE_UPLOAD'] = $old;
		}

		$where = array("VENDOR_ID" => $data['VENDOR_ID'], "VND_TRAIL_ID" => 3,'FIN_RPT_ID' => $fin_rpt_id);
		$this->hist_vnd_fin_rpt->update($data,$where);
		$this->do_insert_panel($LM_ID);

			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Vendor_update_profile/do_update_laporan_keuangan','hist_vnd_fin_rpt','update',$data,$where);
			//--END LOG DETAIL--//

		echo "OK";
	}

	function do_update_financial_data() {
		$this->load->model('hist_vnd_fin_rpt');

		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Update fin rpt header)','EDIT',$this->input->ip_address()
			);
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
			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_update_financial_data','hist_vnd_header','update',$data_update,$where);
			//--END LOG DETAIL--//

			echo json_encode($this->hist_vnd_header->update($data_update,$where));
		}else{
			echo json_encode("Gagal Update");
		}
	}

	function do_insert_bank_data() {
		$this->load->model('hist_vnd_bank');

		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Input bank)','SAVE',$this->input->ip_address());
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

		if ($this->input->post('file_upload')) {
			$file_bank = $this->input->post('file_upload');
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

		$data['VND_TRAIL_ID'] = 3;
		$this->hist_vnd_bank->insert($data);

		$this->do_insert_panel($LM_ID);

			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Vendor_update_profile/do_insert_bank_data','hist_vnd_bank','insert',$data);
			//--END LOG DETAIL--//

		echo "OK";
	}

	function do_remove_vendor_bank($bank_id) {
		$this->load->model(array('tmp_vnd_bank','hist_vnd_bank'));

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Delete bank)','Delete',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$deleted = false;
		if ($this->session->userdata('STATUS') == "3"){
			$deleted = $this->hist_vnd_bank->delete(array("BANK_ID" => $bank_id, "VND_TRAIL_ID"=>3));
			//--LOG DETAIL--//
			$where = array("BANK_ID" => $bank_id, "VND_TRAIL_ID"=>3);
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_remove_vendor_bank','hist_vnd_bank','delete',null,$where);
			//--END LOG DETAIL--//
		}

		if ($deleted) {
			redirect('Vendor_update_profile/bank_and_financial_data');
		}
	}

	function do_insert_financial_report() {
		$this->load->model('hist_vnd_fin_rpt');
		
		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Input fin rpt)','SAVE',$this->input->ip_address());
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
		if($this->input->post('file_upload')) {
			$file_rpt = $this->input->post('file_upload');
		} else {
			$file_rpt = "";
		}
		$data = array(
			'VENDOR_ID' => $vendor_id,
			'FIN_RPT_CURRENCY' => $fin_rpt_currency,
			'FIN_RPT_YEAR' => $fin_rpt_year,
			'FIN_RPT_TYPE' => $fin_rpt_type,
			'FIN_RPT_ASSET_VALUE' => $fin_rpt_asset_value,
			'FIN_RPT_HUTANG' => $fin_rpt_hutang,
			'FIN_RPT_REVENUE' => $fin_rpt_revenue,
			'FIN_RPT_NETINCOME' => $fin_rpt_netincome,
			'FILE_UPLOAD' => $file_rpt
			);

		$data['VND_TRAIL_ID'] = 3;
		$this->hist_vnd_fin_rpt->insert($data);

		$this->do_insert_panel($LM_ID);
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Vendor_update_profile/do_insert_financial_report','hist_vnd_fin_rpt','insert',$data);
			//--END LOG DETAIL--//
		
		echo "OK";
	}

	function do_remove_fin_report($tmp_vnd_fin_rpt) {
		$this->load->model(array('tmp_vnd_fin_rpt', 'hist_vnd_fin_rpt'));
		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Delete fin rpt)','Delete',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$deleted = false;
		if ($this->session->userdata('STATUS') == "3"){
			$deleted = $this->hist_vnd_fin_rpt->delete(array("FIN_RPT_ID" => $tmp_vnd_fin_rpt, "VND_TRAIL_ID"=>3));

			//--LOG DETAIL--//
			$where = array("FIN_RPT_ID" => $tmp_vnd_fin_rpt, "VND_TRAIL_ID"=>3);
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_remove_fin_report','hist_vnd_fin_rpt','delete',null,$where);
			//--END LOG DETAIL--//
		}
		if ($deleted) {
			redirect('Vendor_update_profile/bank_and_financial_data');
		}
	}
	/* End Bank Financial */

	/* Start Good And Services */
	function do_get_material() {
		$this->load->model('m_material');

		$submaterial = $this->input->post('submaterial_code');
		$material = $this->input->post('material_code');

		$this->load->library('sap_handler');
		$mat = $this->sap_handler->getMaterial($material, $submaterial);

		echo json_encode($mat);
	}

	function do_insert_good() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_product');
		}
		$temp = $this->input->post('vendor_id');
		$tempty = empty($temp);
		if (!$tempty) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Input Good)','SAVE',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$material = NULL;
		$material_code = NULL;
		$submaterial = NULL;
		$submaterial_code = NULL;
		$product_description = NULL;
		$brand = NULL;
		$source = NULL;
		$type = NULL;
		$issued_by = NULL;
		$no = NULL;
		$issued_date = NULL;
		$expired_date = NULL;
		$data = array(
			"VENDOR_ID" => $vendor_id,
			"PRODUCT_TYPE" => "GOODS"
			);
		$temp = $this->input->post('material');
		$tempty = empty($temp);
		if(!$tempty) {
			$material = $this->input->post('material');
			$data['PRODUCT_NAME'] = $material;
		}
		$temp = $this->input->post('material_code');
		$tempty = empty($temp);
		if(!$tempty) {
			$material_code = $this->input->post('material_code');
			$data['PRODUCT_CODE'] = $material_code;
		}
		$temp = $this->input->post('submaterial');
		$tempty = empty($temp);
		if(!$tempty) {
			$submaterial = $this->input->post('submaterial');
			$data['PRODUCT_SUBGROUP_NAME'] = $submaterial;
		}
		$temp = $this->input->post('submaterial_code');
		$tempty = empty($temp);
		if(!$tempty) {
			$submaterial_code = $this->input->post('submaterial_code');
			$data['PRODUCT_SUBGROUP_CODE'] = $submaterial_code;
		}

		$temp = $this->input->post('brand');
		$tempty = empty($temp);
		if(!$tempty) {
			$brand = $this->input->post('brand');
			$data['BRAND'] = $brand;
		}
		$temp = $this->input->post('source');
		$tempty = empty($temp);
		if(!$tempty) {
			$source = $this->input->post('source');
			$data['SOURCE'] = $source;
		}
		$temp = $this->input->post('type');
		$tempty = empty($temp);
		if(!$tempty) {
			$type = $this->input->post('type');
			$data['TYPE'] = $type;
		}
		$temp = $this->input->post('issued_by');
		$tempty = empty($temp);
		if(!$tempty) {
			$issued_by = $this->input->post('issued_by');
			$data['ISSUED_BY'] = $issued_by;
		}
		$temp = $this->input->post('no');
		$tempty = empty($temp);
		if(!$tempty) {
			$no = $this->input->post('no');
			$data['NO'] = $no;
		}
		$temp = $this->input->post('issued_date');
		$tempty = empty($temp);
		if(!$tempty) {
			$issued_date = $this->input->post('issued_date');
			$data['ISSUED_DATE'] = vendortodate($issued_date);
		}
		$temp = $this->input->post('expired_date');
		$tempty = empty($temp);
		if(!$tempty) {
			$expired_date = $this->input->post('expired_date');
			$data['EXPIRED_DATE'] = vendortodate($expired_date);
		}
		$data['FILE_UPLOAD']=$this->input->post('file_upload');

		$temp = $this->input->post('product_description');
		$tempty = empty($temp);
		if(!$tempty) {
			$produk_material = $this->input->post('product_description');
			$data['PRODUCT_DESCRIPTION'] = $produk_material;
		}

		if ($this->session->userdata('STATUS') == "3") {
			$data['VND_TRAIL_ID'] = "3";
			$this->hist_vnd_product->insert($data);

			$this->do_insert_panel($LM_ID);

			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_insert_good','hist_vnd_product','insert',$data);
			//--END LOG DETAIL--//
		} else {
			echo json_encode('Gagal');
		}

		// insert jika menggunakan data material yang diambil dari SAP
		// $temp = $this->input->post('product_description');
		// $tempty = empty($temp);
		// if(!$tempty) {
		// 	foreach ($temp as $key => $value) {
		// 		$product = explode('####', $value);
		// 		$data['PRODUCT_DESCRIPTION_CODE'] = $product[0];
		// 		$data['PRODUCT_DESCRIPTION'] = $product[1];
		// 		if ($this->session->userdata('STATUS') == "3") {
		// 			$data['VND_TRAIL_ID'] = "3";
		// 			$this->hist_vnd_product->insert($data);

		// 			$this->do_insert_panel($LM_ID);
		// 		}
		// 		else {
		// 			echo json_encode('Gagal');
		// 		}
		// 	}
		// }

		echo json_encode('OK');
	}

	function do_update_good() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_product');
		}

		$temp = $this->input->post('vendor_id');
		$tempty = empty($temp);

		if (!$tempty) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Update Good)','EDIT',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$good_id = $this->input->post('good_id');

		$material = NULL;
		$material_code = NULL;
		$submaterial = NULL;
		$submaterial_code = NULL;
		$product_description = NULL;
		$brand = NULL;
		$source = NULL;
		$type = NULL;
		$issued_by = NULL;
		$no = NULL;
		$issued_date = NULL;
		$expired_date = NULL;
		$data = array(
			"VENDOR_ID" => $vendor_id,
			"PRODUCT_TYPE" => "GOODS"
			);
		$temp = $this->input->post('material_edit');
		$tempty = empty($temp);
		if(!$tempty) {
			$material = $this->input->post('material_edit');
			$data['PRODUCT_NAME'] = $material;
		}
		$temp = $this->input->post('material_code_edit');
		$tempty = empty($temp);
		if(!$tempty) {
			$material_code = $this->input->post('material_code_edit');
			$data['PRODUCT_CODE'] = $material_code;
		}
		$temp = $this->input->post('submaterial_edit');
		$tempty = empty($temp);
		if(!$tempty) {
			$submaterial = $this->input->post('submaterial_edit');
			$data['PRODUCT_SUBGROUP_NAME'] = $submaterial;
		}
		$temp = $this->input->post('submaterial_code_edit');
		$tempty = empty($temp);
		if(!$tempty) {
			$submaterial_code = $this->input->post('submaterial_code_edit');
			$data['PRODUCT_SUBGROUP_CODE'] = $submaterial_code;
		}

		$temp = $this->input->post('product_description_edit');
		$tempty = empty($temp);
		if(!$tempty) {
			$product_description = $this->input->post('product_description_edit');  
			$data['PRODUCT_DESCRIPTION'] = $product_description;
		}

		/* Update barang jika menggunakan metode ambil data dari SAP 
		$temp = $this->input->post('product_description');
		$tempty = empty($temp);
		if(!$tempty) {
			$product_description = $this->input->post('product_description');
			$product = explode('####', $product_description);
			$data['PRODUCT_DESCRIPTION_CODE'] = $product[0];
			$data['PRODUCT_DESCRIPTION'] = $product[1];
		}
		*/ 

		$temp = $this->input->post('brand_edit');
		$tempty = empty($temp);
		if(!$tempty) {
			$brand = $this->input->post('brand_edit');
			$data['BRAND'] = $brand;
		}
		$temp = $this->input->post('source_edit');
		$tempty = empty($temp);
		if(!$tempty) {
			$source = $this->input->post('source_edit');
			$data['SOURCE'] = $source;
		}
		$temp = $this->input->post('type_edit');
		$tempty = empty($temp);
		if(!$tempty) {
			$type = $this->input->post('type_edit');
			$data['TYPE'] = $type;
		}
		$temp = $this->input->post('issued_by_edit');
		$tempty = empty($temp);
		if(!$tempty) {
			$issued_by = $this->input->post('issued_by_edit');
			$data['ISSUED_BY'] = $issued_by;
		}
		$temp = $this->input->post('no_edit');
		$tempty = empty($temp);
		if(!$tempty) {
			$no = $this->input->post('no_edit');
			$data['NO'] = $no;
		}
		$temp = $this->input->post('issued_date_edit');
		$tempty = empty($temp);
		if(!$tempty) {
			$issued_date = $this->input->post('issued_date_edit');
			$data['ISSUED_DATE'] = vendortodate($issued_date);
		} else {
			$data['ISSUED_DATE'] = '';
		}
		$temp = $this->input->post('expired_date_edit');
		$tempty = empty($temp);
		if(!$tempty) {
			$expired_date = $this->input->post('expired_date_edit');
			$data['EXPIRED_DATE'] = vendortodate($expired_date);
		} else {
			$data['EXPIRED_DATE'] = '';
		}
		$temp = $this->input->post('file_upload');
		$tempty = empty($temp);
		if(!$tempty) {
			$data['FILE_UPLOAD']=$this->input->post('file_upload');
		}
		
		if ($this->session->userdata('STATUS') == "3") {
			$data['VND_TRAIL_ID'] = "3";
			$where = array('VENDOR_ID' => $vendor_id,'VND_TRAIL_ID' => 3, 'PRODUCT_ID' => $good_id);
			$this->hist_vnd_product->update($data,$where);
			$this->do_insert_panel($LM_ID);

			//--LOG DETAIL--//
			$where = array("VENDOR_ID" => $vendor_id, "VND_TRAIL_ID" => 3);
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_update_good','hist_vnd_product','update',$data,$where);
			//--END LOG DETAIL--//
			echo "OK";
		}
		else {

			echo "gagal";
		}
	}

	function do_insert_bahan() {
		$this->load->model('hist_vnd_product');

		//--LOG MAIN--//
		$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Input bahan)','SAVE',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$temp = $this->input->post('vendor_id');
		$tempty = empty($temp);
		if (!$tempty) {
			$vendor_id = $this->input->post('vendor_id');
		}
		$material = NULL;
		$material_code = NULL;
		$submaterial = NULL;
		$submaterial_code = NULL;
		$product_description = NULL;
		$brand = NULL;
		$source = NULL;
		$type = NULL;
		$type_dokumen = NULL;
		$issued_by = NULL;
		$no = NULL;
		$issued_date = NULL;
		$expired_date = NULL;
		$data = array(
			"VENDOR_ID" => $vendor_id,
			"PRODUCT_TYPE" => "BAHAN"
			);
		$temp = $this->input->post('material_bahan');
		$tempty = empty($temp);
		if(!$tempty) {
			$material = $this->input->post('material_bahan');
			$data['PRODUCT_NAME'] = $material;
		}
		$temp = $this->input->post('material_code_bahan');
		$tempty = empty($temp);
		if(!$tempty) {
			$material_code = $this->input->post('material_code_bahan');
			$data['PRODUCT_CODE'] = $material_code;
		}
		$temp = $this->input->post('submaterial_bahan');
		$tempty = empty($temp);
		if(!$tempty) {
			$submaterial = $this->input->post('submaterial_bahan');
			$data['PRODUCT_SUBGROUP_NAME'] = $submaterial;
		}
		$temp = $this->input->post('submaterial_code_bahan');
		$tempty = empty($temp);
		if(!$tempty) {
			$submaterial_code = $this->input->post('submaterial_code_bahan');
			$data['PRODUCT_SUBGROUP_CODE'] = $submaterial_code;
		}
		$temp = $this->input->post('bahan_source');
		$tempty = empty($temp);
		if(!$tempty) {
			$source = $this->input->post('bahan_source');
			$data['SOURCE'] = $source;
		}
		$temp = $this->input->post('type_bahan');
		$tempty = empty($temp);
		if(!$tempty) {
			$type = $this->input->post('type_bahan');
			$data['TYPE'] = $type;
		}
		$temp = $this->input->post('type_dokumen');
		$tempty = empty($temp);
		if(!$tempty) {
			$type_dokumen = $this->input->post('type_dokumen');
			$data['KLASIFIKASI_NAME'] = $type_dokumen;
		}
		$temp = $this->input->post('issued_by_bahan');
		$tempty = empty($temp);
		if(!$tempty) {
			$issued_by = $this->input->post('issued_by_bahan');
			$data['ISSUED_BY'] = $issued_by;
		}
		$temp = $this->input->post('no_dokumen');
		$tempty = empty($temp);
		if(!$tempty) {
			$no = $this->input->post('no_dokumen');
			$data['NO'] = $no;
		}
		$temp = $this->input->post('issued_date_bahan');
		$tempty = empty($temp);
		if(!$tempty) {
			$issued_date = $this->input->post('issued_date_bahan');
			$data['ISSUED_DATE'] = vendortodate($issued_date);
		}
		$temp = $this->input->post('expired_date_bahan');
		$tempty = empty($temp);
		if(!$tempty) {
			$expired_date = $this->input->post('expired_date_bahan');
			$data['EXPIRED_DATE'] = vendortodate($expired_date);
		}
		$data['FILE_UPLOAD']=$this->input->post('file_upload');

		$temp = $this->input->post('bahan_description');
		$tempty = empty($temp);
		if(!$tempty) {
			$produk_material = $this->input->post('bahan_description');
			$data['PRODUCT_DESCRIPTION'] = $produk_material;
		}

		$data['VND_TRAIL_ID'] = 3;

		$this->hist_vnd_product->insert($data);

		$this->do_insert_panel($LM_ID);
		//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Technical_document/do_insert_bahan','hist_vnd_product','insert',$data);
		//--END LOG DETAIL--//

		echo "OK";
	}

	function do_update_bahan() {
		$this->load->model('hist_vnd_product');
		$temp = $this->input->post('vendor_id');
		$tempty = empty($temp);
		if (!$tempty) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Update good)','EDIT',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$bahan_id = $this->input->post('bahan_id');

		$material = NULL;
		$material_code = NULL;
		$submaterial = NULL;
		$submaterial_code = NULL;
		$product_description = NULL;
		$source = NULL;
		$type = NULL;
		$type_dokumen = NULL;
		$issued_by = NULL;
		$no = NULL;
		$issued_date = NULL;
		$expired_date = NULL;
		$data = array(
			"VENDOR_ID" => $vendor_id,
			"PRODUCT_TYPE" => "BAHAN"
			);
		$temp = $this->input->post('material_edit_bahan');
		$tempty = empty($temp);
		if(!$tempty) {
			$material = $this->input->post('material_edit_bahan');
			$data['PRODUCT_NAME'] = $material;
		}
		$temp = $this->input->post('material_code_edit_bahan');
		$tempty = empty($temp);
		if(!$tempty) {
			$material_code = $this->input->post('material_code_edit_bahan');
			$data['PRODUCT_CODE'] = $material_code;
		}
		$temp = $this->input->post('submaterial_edit_bahan');
		$tempty = empty($temp);
		if(!$tempty) {
			$submaterial = $this->input->post('submaterial_edit_bahan');
			$data['PRODUCT_SUBGROUP_NAME'] = $submaterial;
		}
		$temp = $this->input->post('submaterial_code_edit_bahan');
		$tempty = empty($temp);
		if(!$tempty) {
			$submaterial_code = $this->input->post('submaterial_code_edit_bahan');
			$data['PRODUCT_SUBGROUP_CODE'] = $submaterial_code;
		}
		
		$temp = $this->input->post('product_description_edit_bahan');
		$tempty = empty($temp);
		if(!$tempty) {
			$product_description = $this->input->post('product_description_edit_bahan'); 
			$data['PRODUCT_DESCRIPTION'] = $product_description;
		}

		$temp = $this->input->post('source_edit_bahan');
		$tempty = empty($temp);
		if(!$tempty) {
			$source = $this->input->post('source_edit_bahan');
			$data['SOURCE'] = $source;
		}
		$temp = $this->input->post('type_bahan_edit');
		$tempty = empty($temp);
		if(!$tempty) {
			$type = $this->input->post('type_bahan_edit');
			$data['TYPE'] = $type;
		}
		$temp = $this->input->post('type_dokumen_edit');
		$tempty = empty($temp);
		if(!$tempty) {
			$type_dokumen = $this->input->post('type_dokumen_edit');
			$data['KLASIFIKASI_NAME'] = $type_dokumen;
		}
		$temp = $this->input->post('issued_by_edit_bahan');
		$tempty = empty($temp);
		if(!$tempty) {
			$issued_by = $this->input->post('issued_by_edit_bahan');
			$data['ISSUED_BY'] = $issued_by;
		}
		$temp = $this->input->post('no_edit_bahan');
		$tempty = empty($temp);
		if(!$tempty) {
			$no = $this->input->post('no_edit_bahan');
			$data['NO'] = $no;
		}
		$temp = $this->input->post('issued_date_edit_bahan');
		$tempty = empty($temp);
		if(!$tempty) {
			$issued_date = $this->input->post('issued_date_edit_bahan');
			$data['ISSUED_DATE'] = vendortodate($issued_date);
		} else {
			$data['ISSUED_DATE'] = '';
		}
		$temp = $this->input->post('expired_date_edit_bahan');
		$tempty = empty($temp);
		if(!$tempty) {
			$expired_date = $this->input->post('expired_date_edit_bahan');
			$data['EXPIRED_DATE'] = vendortodate($expired_date);
		} else {
			$data['EXPIRED_DATE'] = '';
		}
		$old = $this->input->post('file_upload_lama_ba_bahan');
		$new = $this->input->post('file_upload');
		if (!empty($new)) {
			$data['FILE_UPLOAD']=$new;
		} else {
			$data['FILE_UPLOAD']=$old;
		}
		
		$data['VND_TRAIL_ID'] = "3";
		$where = array('VENDOR_ID' => $vendor_id,'VND_TRAIL_ID' => 3, 'PRODUCT_ID' => $bahan_id);
		$this->hist_vnd_product->update($data,$where);
		$this->do_insert_panel($LM_ID);
		//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Technical_document/do_update_good','hist_vnd_product','update',$data,$where);
		//--END LOG DETAIL--//
		echo "OK";
	}

	function get_product_edit(){
		$product_id = $this->input->post('product_id');
		$product_data = array();
		if(!empty($product_id)){
			$this->load->model('hist_vnd_product');
			if ($this->session->userdata('STATUS') == "3"){
				$product_data = $this->hist_vnd_product->get_all(array('PRODUCT_ID'=>$product_id, 'VND_TRAIL_ID'=>3));
			} else {
				echo json_encode('Gagal edit');
			}
		} else {

		}

		echo json_encode($product_data);
	}

	function get_akta_edit(){
		$akta_id = $this->input->post('akta');
		$akta_data = array();
		if(!empty($akta_id)){
			$this->load->model('hist_vnd_akta');
			if ($this->session->userdata('STATUS') == "3"){
				$akta_data = $this->hist_vnd_akta->get_all(array('AKTA_ID'=>$akta_id, 'VND_TRAIL_ID'=>3));
			} else {
				echo json_encode('Gagal edit');
			}
		} else {

		}

		echo json_encode($akta_data);
	}

	function get_board_edit(){
		$board_id = $this->input->post('id');
		$board_data = array();
		if(!empty($board_id)){
			$this->load->model('hist_vnd_board');
			if ($this->session->userdata('STATUS') == "3"){
				$board_data = $this->hist_vnd_board->get_all(array('BOARD_ID'=>$board_id, 'VND_TRAIL_ID'=>3));
			} else {
				echo json_encode('Gagal edit');
			}
		} else {

		}

		echo json_encode($board_data);
	}

	public function do_remove_vendor_product($product_id){
		
		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Delete product)','Delete',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_product');
		}
		else {
			echo json_encode('Gagal Hapus');
		}
		if ($this->hist_vnd_product->delete(array("PRODUCT_ID" => $product_id))) {
			//--LOG DETAIL--//
			$where = array("PRODUCT_ID" => $product_id);
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_remove_vendor_product','hist_vnd_product','delete',null,$where);
			//--END LOG DETAIL--//
			redirect('Vendor_update_profile/good_and_service_data');
		}
	}

	function do_insert_service() {
		$this->load->model('com_jasa_group');

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Input Service)','SAVE',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_product');
		} 
		$temp = $this->input->post('vendor_id');
		$tempty = empty($temp);
		if (!$tempty) {
			$vendor_id = $this->input->post('vendor_id');
		}
		$svc = NULL;
		$svc_code = NULL;
		$subsvc = NULL;
		$subsvc_code = NULL;
		$product_description = NULL;
		$brand = NULL;
		$klasifikasi_id = NULL;
		$klasf = null;
		$issued_by = NULL;
		$no = NULL;
		$issued_date = NULL;
		$expired_date = NULL;
		$data = array(
			"VENDOR_ID" => $vendor_id,
			"PRODUCT_TYPE" => "SERVICES"
			);
		$temp = $this->input->post('svc');
		$tempty = empty($temp);
		if(!$tempty) {
			$svc = $this->input->post('svc');
			$data['PRODUCT_NAME'] = $svc;
		}
		$temp = $this->input->post('group_jasa_id');
		$tempty = empty($temp);
		if(!$tempty) {
			$svc_code = $this->input->post('group_jasa_id');
			$data['PRODUCT_CODE'] = $svc_code;
		}
		$temp = $this->input->post('subsvc');
		$tempty = empty($temp);
		if(!$tempty) {
			$subsvc = $this->input->post('subsvc');
			$data['PRODUCT_SUBGROUP_NAME'] = $subsvc;
		}
		$temp = $this->input->post('subGroup_jasa_id');
		$tempty = empty($temp);
		if(!$tempty) {
			$subsvc_code = $this->input->post('subGroup_jasa_id');
			$data['PRODUCT_SUBGROUP_CODE'] = $subsvc_code;
		}
		$temp = $this->input->post('issued_by');
		$tempty = empty($temp);
		if(!$tempty) {
			$issued_by = $this->input->post('issued_by');
			$data['ISSUED_BY'] = $issued_by;
		}
		$temp = $this->input->post('no');
		$tempty = empty($temp);
		if(!$tempty) {
			$no = $this->input->post('no');
			$data['NO'] = $no;
		}
		$temp = $this->input->post('issued_date');
		$tempty = empty($temp);
		if(!$tempty) {
			$issued_date = $this->input->post('issued_date');
			$data['ISSUED_DATE'] = vendortodate($issued_date);
		}
		$temp = $this->input->post('expired_date');
		$tempty = empty($temp);
		if(!$tempty) {
			$expired_date = $this->input->post('expired_date');
			$data['EXPIRED_DATE'] = vendortodate($expired_date);
		}

		$temp = $this->input->post('klasifikasi_jasa_id');
		$tempty = empty($temp);
		if(!$tempty) {
			$klasifikasi_id = $this->input->post('klasifikasi_jasa_id');
			$data['KLASIFIKASI_ID'] = $klasifikasi_id;
		}
		$temp = $this->input->post('klasf');
		$tempty = empty($temp);
		if(!$tempty) {
			$klasf = $this->input->post('klasf');
			$data['KLASIFIKASI_NAME'] = $klasf;
		}
		$subKlaId = null;
		$subKlaName = null;
		$subKlasiId = $this->input->post('subKlasifikasi_jasa_id');
		if(!empty($subKlasiId)){
			$va = json_encode($subKlasiId);
			$a=explode('[', $va);
			$e=explode(']', $a[1]);
			$p=str_replace('"', '', $e[0]);
			$subKlaId=$p;

			$sbkl = explode(',', $subKlaId);
			$subKlasName=array();
			foreach ($sbkl as $val) {
				$dat = $this->com_jasa_group->get_id($val);
				$subKlasName[]= $dat[0]['NAMA'];
			}
			$na = json_encode($subKlasName);
			$n=explode('[', $na);
			$m=explode(']', $n[1]);
			$me=str_replace('"', '', $m[0]);
			$subKlaName=$me;
		}
		
		$data['SUBKLASIFIKASI_ID'] = $subKlaId;		
		$data['SUBKLASIFIKASI_NAME'] = $subKlaName;

		$temp = $this->input->post('kualifikasi_jasa_id');
		$tempty = empty($temp);
		if(!$tempty) {
			$kualifi_id = $this->input->post('kualifikasi_jasa_id');
			$data['KUALIFIKASI_ID'] = $kualifi_id;
		}

		$temp = $this->input->post('kualifi');
		$tempty = empty($temp);
		if(!$tempty) {
			$kualifi = $this->input->post('kualifi');
			$data['KUALIFIKASI_NAME'] = $kualifi;
		}

		$temp = $this->input->post('subKualifikasi_jasa_id');
		$tempty = empty($temp);
		if(!$tempty) {
			$subKualifi_id = $this->input->post('subKualifikasi_jasa_id');
			$data['SUBKUALIFIKASI_ID'] = $subKualifi_id;
		}

		$temp = $this->input->post('subKualifi');
		$tempty = empty($temp);
		if(!$tempty) {
			$subKualifi = $this->input->post('subKualifi');
			$data['SUBKUALIFIKASI_NAME'] = $subKualifi;
		}
		$data['FILE_UPLOAD']=$this->input->post('file_upload');
		
		if ($this->session->userdata('STATUS') == "3") {
			$data['VND_TRAIL_ID'] = "3";
			$this->hist_vnd_product->insert($data);
			$this->do_insert_panel($LM_ID);
			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_insert_service','hist_vnd_product','insert',$data);
			//--END LOG DETAIL--//
			echo 'OK';
		}
		else {
			echo 'Gagal Insert';
		}
	}

	function do_update_service() {
		$this->load->model('com_jasa_group');
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_product');
		} 
		$temp = $this->input->post('vendor_id');
		$service_id = $this->input->post('service_id');
		$tempty = empty($temp);
		if (!$tempty) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Update Service)','EDIT',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$svc = NULL;
		$svc_code = NULL;
		$subsvc = NULL;
		$subsvc_code = NULL;
		$product_description = NULL;
		$brand = NULL;
		$klasifikasi_id = NULL;
		$klasf = null;
		$issued_by = NULL;
		$no = NULL;
		$issued_date = NULL;
		$expired_date = NULL;
		$data = array(
			"VENDOR_ID" => $vendor_id,
			"PRODUCT_TYPE" => "SERVICES"
			);
		$temp = $this->input->post('svc');
		$tempty = empty($temp);
		if(!$tempty) {
			$svc = $this->input->post('svc');
			$data['PRODUCT_NAME'] = $svc;
		}
		$temp = $this->input->post('group_jasa_id');
		$tempty = empty($temp);
		if(!$tempty) {
			$svc_code = $this->input->post('group_jasa_id');
			$data['PRODUCT_CODE'] = $svc_code;
		}
		$temp = $this->input->post('subsvc');
		$tempty = empty($temp);
		if(!$tempty) {
			$subsvc = $this->input->post('subsvc');
			$data['PRODUCT_SUBGROUP_NAME'] = $subsvc;
		}
		$temp = $this->input->post('subGroup_jasa_id');
		$tempty = empty($temp);
		if(!$tempty) {
			$subsvc_code = $this->input->post('subGroup_jasa_id');
			$data['PRODUCT_SUBGROUP_CODE'] = $subsvc_code;
		}
		$temp = $this->input->post('issued_by');
		$tempty = empty($temp);
		if(!$tempty) {
			$issued_by = $this->input->post('issued_by');
			$data['ISSUED_BY'] = $issued_by;
		}
		$temp = $this->input->post('no');
		$tempty = empty($temp);
		if(!$tempty) {
			$no = $this->input->post('no');
			$data['NO'] = $no;
		}
		$temp = $this->input->post('issued_date');
		$tempty = empty($temp);
		if(!$tempty) {
			$issued_date = $this->input->post('issued_date');
			$data['ISSUED_DATE'] = vendortodate($issued_date);
		} else {
			$data['ISSUED_DATE'] = '';
		}
		$temp = $this->input->post('expired_date');
		$tempty = empty($temp);
		if(!$tempty) {
			$expired_date = $this->input->post('expired_date');
			$data['EXPIRED_DATE'] = vendortodate($expired_date);
		} else {
			$data['EXPIRED_DATE'] = '';
		}

		$temp = $this->input->post('klasifikasi_jasa_id');
		$tempty = empty($temp);
		if(!$tempty) {
			$klasifikasi_id = $this->input->post('klasifikasi_jasa_id');
			$data['KLASIFIKASI_ID'] = $klasifikasi_id;
		}
		$temp = $this->input->post('klasf');
		$tempty = empty($temp);
		if(!$tempty) {
			$klasf = $this->input->post('klasf');
			$data['KLASIFIKASI_NAME'] = $klasf;
		}
		$subKlaId = null;
		$subKlaName = null;
		$subKlasiId = $this->input->post('subKlasifikasi_jasa_id');
		if(!empty($subKlasiId)){
			$va = json_encode($subKlasiId);
			$a=explode('[', $va);
			$e=explode(']', $a[1]);
			$p=str_replace('"', '', $e[0]);
			$subKlaId=$p;

			$sbkl = explode(',', $subKlaId);
			$subKlasName=array();
			foreach ($sbkl as $val) {
				$dat = $this->com_jasa_group->get_id($val);
				$subKlasName[]= $dat[0]['NAMA'];
			}
			$na = json_encode($subKlasName);
			$n=explode('[', $na);
			$m=explode(']', $n[1]);
			$me=str_replace('"', '', $m[0]);
			$subKlaName=$me;

		}
		$data['SUBKLASIFIKASI_ID'] = $subKlaId;		
		$data['SUBKLASIFIKASI_NAME'] = $subKlaName;

		$temp = $this->input->post('kualifikasi_jasa_id');
		$tempty = empty($temp);
		if(!$tempty) {
			$kualifi_id = $this->input->post('kualifikasi_jasa_id');
			$data['KUALIFIKASI_ID'] = $kualifi_id;
		}

		$temp = $this->input->post('kualifi');
		$tempty = empty($temp);
		if(!$tempty) {
			$kualifi = $this->input->post('kualifi');
			$data['KUALIFIKASI_NAME'] = $kualifi;
		}

		$temp = $this->input->post('subKualifikasi_jasa_id');
		$tempty = empty($temp);
		if(!$tempty) {
			$subKualifi_id = $this->input->post('subKualifikasi_jasa_id');
			$data['SUBKUALIFIKASI_ID'] = $subKualifi_id;
		}

		$temp = $this->input->post('subKualifi');
		$tempty = empty($temp);
		if(!$tempty) {
			$subKualifi = $this->input->post('subKualifi');
			$data['SUBKUALIFIKASI_NAME'] = $subKualifi;
		}

		$temp = $this->input->post('file_upload');
		$tempty = empty($temp);
		if(!$tempty) {
			$data['FILE_UPLOAD']=$this->input->post('file_upload');
			$temp = $this->input->post('file_upload_lama');
			$tempty_r = empty($temp);
			if(!$tempty_r) {
				if(file_exists(BASEPATH.'../upload/vendor/'.$temp)){
					unlink($path);
				}
			}
		}

		if ($this->session->userdata('STATUS') == "3") {
			$data['VND_TRAIL_ID'] = "3";
			$where = array('VENDOR_ID' => $vendor_id, 'PRODUCT_ID' => $service_id);
			$this->hist_vnd_product->update($data,$where);
			$this->do_insert_panel($LM_ID);

			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_update_service','hist_vnd_product','update',$data,$where);
			//--END LOG DETAIL--//

			echo 'OK';
		}
		else {
			echo 'gagal';
		}
	}
	/* END Good And Services */

	/* Start SDM */
	function do_insert_main_sdm() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_sdm');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Input sdm)','SAVE',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
		$name = NULL;
		$last_education = NULL;
		$main_skill = NULL;
		$year_exp = NULL;
		$emp_status = NULL;
		$emp_type = NULL;
		$data = array(
			"VENDOR_ID" => $vendor_id,
			"TYPE" => "MAIN"
			);
		$temp = $this->input->post('name');
		if(!empty($temp)) {
			$name = $this->input->post('name');
			$data['NAME'] = $name;
		}
		$temp = $this->input->post('last_education');
		if(!empty($temp)) {
			$last_education = $this->input->post('last_education');
			$data['LAST_EDUCATION'] = $last_education;
		}
		$temp = $this->input->post('main_skill');
		if(!empty($temp)) {
			$main_skill = $this->input->post('main_skill');
			$data['MAIN_SKILL'] = $main_skill;
		}
		$temp = $this->input->post('year_exp');
		if(!empty($temp)) {
			$year_exp = $this->input->post('year_exp');
			$data['YEAR_EXP'] = $year_exp;
		}
		$temp = $this->input->post('emp_status');
		if(!empty($temp)) {
			$emp_status = $this->input->post('emp_status');
			$data['EMP_STATUS'] = $emp_status;
		}
		$temp = $this->input->post('emp_type');
		if(!empty($temp)) {
			$emp_type = $this->input->post('emp_type');
			$data['EMP_TYPE'] = $emp_type;
		}
		if ($this->session->userdata('STATUS') == "3") {
			$this->do_insert_panel($LM_ID);
			$data['VND_TRAIL_ID'] = "3";
			
			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_insert_main_sdm','hist_vnd_sdm','insert',$data);
			//--END LOG DETAIL--//
			echo json_encode($this->hist_vnd_sdm->insert($data)); 
		}
		else {
			echo json_encode('Gagal insert data');
		}
	}

	function do_update_main_sdm() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_sdm');
		} 
		$temp = $this->input->post('vendor_id');
		$sdm_id = $this->input->post('sdm_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Update sdm)','EDIT',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$name = NULL;
		$last_education = NULL;
		$main_skill = NULL;
		$year_exp = NULL;
		$emp_status = NULL;
		$emp_type = NULL;
		$data = array(
			"VENDOR_ID" => $vendor_id,
			"TYPE" => "MAIN"
			);
		$temp = $this->input->post('name');
		if(!empty($temp)) {
			$name = $this->input->post('name');
			$data['NAME'] = $name;
		}
		$temp = $this->input->post('last_education');
		if(!empty($temp)) {
			$last_education = $this->input->post('last_education');
			$data['LAST_EDUCATION'] = $last_education;
		}
		$temp = $this->input->post('main_skill');
		if(!empty($temp)) {
			$main_skill = $this->input->post('main_skill');
			$data['MAIN_SKILL'] = $main_skill;
		}
		$temp = $this->input->post('year_exp');
		if(!empty($temp)) {
			$year_exp = $this->input->post('year_exp');
			$data['YEAR_EXP'] = $year_exp;
		}
		$temp = $this->input->post('emp_status');
		if(!empty($temp)) {
			$emp_status = $this->input->post('emp_status');
			$data['EMP_STATUS'] = $emp_status;
		}
		$temp = $this->input->post('emp_type');
		if(!empty($temp)) {
			$emp_type = $this->input->post('emp_type');
			$data['EMP_TYPE'] = $emp_type;
		}
		if ($this->session->userdata('STATUS') == "3") {
			$this->do_insert_panel($LM_ID);
			$data['VND_TRAIL_ID'] = "3";
			$where = array('VENDOR_ID' =>$vendor_id, 'SDM_ID' => $sdm_id);

			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_update_main_sdm','hist_vnd_sdm','update',$data,$where);
			//--END LOG DETAIL--//

			echo json_encode($this->hist_vnd_sdm->update($data,$where));
		}
		else {
			echo json_encode('Gagal updeting data');
		}
	}

	public function do_remove_vendor_sdm($sdm_id){
		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Delete sdm)','Delete',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_sdm');
		}

		//--LOG DETAIL--//
		$where = array("SDM_ID" => $sdm_id);
		$this->log_data->detail($LM_ID,'Vendor_update_profile/do_remove_vendor_sdm','hist_vnd_sdm','delete',null,$where);
		//--END LOG DETAIL--//

		if ($this->hist_vnd_sdm->delete(array("SDM_ID" => $sdm_id))) {

			redirect('Vendor_update_profile/human_resources_data');
		}
	}

	function do_insert_support_sdm() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_sdm');
		} 
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Input support sdm)','SAVE',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$name = NULL;
		$last_education = NULL;
		$main_skill = NULL;
		$year_exp = NULL;
		$emp_status = NULL;
		$emp_type = NULL;
		$data = array(
			"VENDOR_ID" => $vendor_id,
			"TYPE" => "SUPPORT"
			);
		$temp = $this->input->post('name');
		if(!empty($temp)) {
			$name = $this->input->post('name');
			$data['NAME'] = $name;
		}
		$temp = $this->input->post('last_education');
		if(!empty($temp)) {
			$last_education = $this->input->post('last_education');
			$data['LAST_EDUCATION'] = $last_education;
		}
		$temp = $this->input->post('main_skill');
		if(!empty($temp)) {
			$main_skill = $this->input->post('main_skill');
			$data['MAIN_SKILL'] = $main_skill;
		}
		$temp = $this->input->post('year_exp');
		if(!empty($temp)) {
			$year_exp = $this->input->post('year_exp');
			$data['YEAR_EXP'] = $year_exp;
		}
		$temp = $this->input->post('emp_status');
		if(!empty($temp)) {
			$emp_status = $this->input->post('emp_status');
			$data['EMP_STATUS'] = $emp_status;
		}
		$temp = $this->input->post('emp_type');
		if(!empty($temp)) {
			$emp_type = $this->input->post('emp_type');
			$data['EMP_TYPE'] = $emp_type;
		}
		if ($this->session->userdata('STATUS') == "3") {
			$this->do_insert_panel($LM_ID);
			$data['VND_TRAIL_ID'] = "3";

			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_insert_support_sdm','hist_vnd_sdm','insert',$data);
			//--END LOG DETAIL--//

			echo json_encode($this->hist_vnd_sdm->insert($data));
		}
		else {
			echo json_encode('Gagal inserting data');
		}
	}

	function do_update_support_sdm() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_sdm');
		} 
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Update support sdm)','EDIT',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$sdm_id = $this->input->post('sdm_id');
		$name = NULL;
		$last_education = NULL;
		$main_skill = NULL;
		$year_exp = NULL;
		$emp_status = NULL;
		$emp_type = NULL;
		$data = array(
			"VENDOR_ID" => $vendor_id,
			"TYPE" => "SUPPORT"
			);
		$temp = $this->input->post('name');
		if(!empty($temp)) {
			$name = $this->input->post('name');
			$data['NAME'] = $name;
		}
		$temp = $this->input->post('last_education');
		if(!empty($temp)) {
			$last_education = $this->input->post('last_education');
			$data['LAST_EDUCATION'] = $last_education;
		}
		$temp = $this->input->post('main_skill');
		if(!empty($temp)) {
			$main_skill = $this->input->post('main_skill');
			$data['MAIN_SKILL'] = $main_skill;
		}
		$temp = $this->input->post('year_exp');
		if(!empty($temp)) {
			$year_exp = $this->input->post('year_exp');
			$data['YEAR_EXP'] = $year_exp;
		}
		$temp = $this->input->post('emp_status');
		if(!empty($temp)) {
			$emp_status = $this->input->post('emp_status');
			$data['EMP_STATUS'] = $emp_status;
		}
		$temp = $this->input->post('emp_type');
		if(!empty($temp)) {
			$emp_type = $this->input->post('emp_type');
			$data['EMP_TYPE'] = $emp_type;
		}
		if ($this->session->userdata('STATUS') == "3") {
			$this->do_insert_panel($LM_ID);
			$data['VND_TRAIL_ID'] = "3";
			$where = array('VENDOR_ID' =>$vendor_id, 'SDM_ID' => $sdm_id);

			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_update_support_sdm','hist_vnd_sdm','update',$data,$where);
			//--END LOG DETAIL--//

			echo json_encode($this->hist_vnd_sdm->update($data,$where)); 
		}
		else {
			echo json_encode('Gagal updating data');
		}
	}
	/* End SDM*/

	/* Start Certification */
	function do_insert_certifications() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_cert');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Input certifications)','SAVE',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$cert_name = NULL;
		$issued_by = NULL;
		$type = NULL;
		$type_other = NULL;
		$valid_from = NULL;
		$valid_to = NULL;
		$cert_no = NULL;
		$cert_no_doc = NULL;
		$data = array(
			"VENDOR_ID" => $vendor_id
			);
		$temp = $this->input->post('cert_name');
		if(!empty($temp)) {
			$cert_name = $this->input->post('cert_name');
			$data['CERT_NAME'] = $cert_name;
		}
		$temp = $this->input->post('issued_by');
		if(!empty($temp)) {
			$issued_by = $this->input->post('issued_by');
			$data['ISSUED_BY'] = $issued_by;
		}
		$temp = $this->input->post('type');
		if(!empty($temp)) {
			$type = $this->input->post('type');
			$data['TYPE'] = $type;
		}
		$temp = $this->input->post('type_other');
		if(!empty($temp)) {
			$type_other = $this->input->post('type_other');
			$data['TYPE_OTHER'] = $type_other;
		}
		$temp = $this->input->post('valid_from');
		if(!empty($temp)) {
			$valid_from = $this->input->post('valid_from');
			$data['VALID_FROM'] = vendortodate($valid_from);
		}
		$temp = $this->input->post('valid_to');
		if(!empty($temp)) {
			$valid_to = $this->input->post('valid_to');
			$data['VALID_TO'] = vendortodate($valid_to);
		}
		$temp = $this->input->post('cert_no');
		if(!empty($temp)) {
			$cert_no = $this->input->post('cert_no');
			$data['CERT_NO'] = $cert_no;
		}
		$temp = $this->input->post('cert_no_doc');
		if(!empty($temp)) {
			$cert_no_doc = $this->input->post('cert_no_doc');
			$data['CERT_NO_DOC'] = $cert_no_doc;
		}
		if ($this->session->userdata('STATUS') == "3") {
			$this->do_insert_panel($LM_ID);
			$data['VND_TRAIL_ID'] = "3";

			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_insert_certifications','hist_vnd_cert','insert',$data);
			//--END LOG DETAIL--//
			
			echo json_encode($this->hist_vnd_cert->insert($data));
		} else {
			echo json_encode('Gagal Inserting data!');
		}
	}

	function do_update_certifications() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_cert');
		} 
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Update certifications)','EDIT',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
		
		$cert_id = $this->input->post('cert_id');

		$cert_name = NULL;
		$issued_by = NULL;
		$type = NULL;
		$type_other = NULL;
		$valid_from = NULL;
		$valid_to = NULL;
		$cert_no = NULL;
		$cert_no_doc = NULL;
		$data = array(
			"VENDOR_ID" => $vendor_id
			);
		$temp = $this->input->post('cert_name');
		if(!empty($temp)) {
			$cert_name = $this->input->post('cert_name');
			$data['CERT_NAME'] = $cert_name;
		}
		$temp = $this->input->post('issued_by');
		if(!empty($temp)) {
			$issued_by = $this->input->post('issued_by');
			$data['ISSUED_BY'] = $issued_by;
		}
		$temp = $this->input->post('type');
		if(!empty($temp)) {
			$type = $this->input->post('type');
			$data['TYPE'] = $type;
		}
		$temp = $this->input->post('type_other');
		if(!empty($temp)) {
			$type_other = $this->input->post('type_other');
			$data['TYPE_OTHER'] = $type_other;
		}
		$temp = $this->input->post('valid_from');
		if(!empty($temp)) {
			$valid_from = $this->input->post('valid_from');
			$data['VALID_FROM'] = vendortodate($valid_from);
		} else {
			$data['VALID_FROM'] = '';
		}
		$temp = $this->input->post('valid_to');
		if(!empty($temp)) {
			$valid_to = $this->input->post('valid_to');
			$data['VALID_TO'] = vendortodate($valid_to);
		} else {
			$data['VALID_TO'] = '';
		}
		$temp = $this->input->post('cert_no');
		if(!empty($temp)) {
			$cert_no = $this->input->post('cert_no');
			$data['CERT_NO'] = $cert_no;
		}
		$temp = $this->input->post('cert_no_doc');
		if(!empty($temp)) {
			$cert_no_doc = $this->input->post('cert_no_doc');
			$data['CERT_NO_DOC'] = $cert_no_doc;
		}
		if ($this->session->userdata('STATUS') == "3") {
			$this->do_insert_panel($LM_ID);
			$data['VND_TRAIL_ID'] = "3";
			$where = array('VENDOR_ID' => $vendor_id, 'CERT_ID' => $cert_id);

			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_update_certifications','hist_vnd_cert','update',$data,$where);
			//--END LOG DETAIL--//

			echo json_encode($this->hist_vnd_cert->update($data,$where));
		}
		else {
			echo json_encode('Gagal Updating data');
		}
	}

	function get_certification_edit(){
		$cert_id = $this->input->post('cert_id');
		$cert_data = array();
		if(!empty($cert_id)){
			$this->load->model('hist_vnd_cert');
			if ($this->session->userdata('STATUS') == "3"){
				$cert_data = $this->hist_vnd_cert->get_all(array('CERT_ID'=>$cert_id, 'VND_TRAIL_ID'=>3));
			} 
		} else {
		}

		echo json_encode($cert_data);
	}

	public function do_remove_vendor_certifications($cert_id){
		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Delete certifications)','Delete',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		//--LOG DETAIL--//
		$where = array("CERT_ID" => $cert_id);
		$this->log_data->detail($LM_ID,'Vendor_update_profile/do_remove_vendor_certifications','hist_vnd_cert','delete',null,$where);
		//--END LOG DETAIL--//
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_cert');
		} 
		if ($this->hist_vnd_cert->delete(array("CERT_ID" => $cert_id))) {
			redirect(site_url('Vendor_update_profile/certification_data'));
		}
	}
	/* End Certification */

	/* Start Fasilitas / equipment */
	function do_insert_equipments() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_equip');
		} 
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Input equipment)','SAVE',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$category = NULL;
		$equip_name = NULL;
		$spec = NULL;
		$year_made = NULL;
		$quantity = NULL;
		$data = array(
			"VENDOR_ID" => (int)$vendor_id
			);
		$temp = $this->input->post('category');
		if(!empty($temp)) {
			$category = $this->input->post('category');
			$data['CATEGORY'] = $category;
		}
		$temp = $this->input->post('equip_name');
		if(!empty($temp)) {
			$equip_name = $this->input->post('equip_name');
			$data['EQUIP_NAME'] = $equip_name;
		}
		$temp = $this->input->post('spec');
		if(!empty($temp)) {
			$spec = $this->input->post('spec');
			$data['SPEC'] = $spec;
		}
		$temp = $this->input->post('year_made');
		if(!empty($temp)) {
			$year_made = date("Y", strtotime($this->input->post('year_made')));
			$data['YEAR_MADE'] = (int)$year_made;
		}
		$temp = $this->input->post('quantity');
		if(!empty($temp)) {
			$quantity = $this->input->post('quantity');
			$data['QUANTITY'] = (int)$quantity;
		}

		if ($this->session->userdata('STATUS') == "3") {
			$this->do_insert_panel($LM_ID);
			$data['VND_TRAIL_ID'] = "3";
			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_insert_equipments','hist_vnd_equip','insert',$data);
			//--END LOG DETAIL--//
			echo json_encode($this->hist_vnd_equip->insert($data));
		}
		else {
			echo json_encode('Gagal inserting data!');
		}
	}

	function do_update_equipments() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_equip');
		} 
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Update equipment)','EDIT',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$equip_id = $this->input->post('equip_id');

		$category = NULL;
		$equip_name = NULL;
		$spec = NULL;
		$year_made = NULL;
		$quantity = NULL;
		$data = array("VENDOR_ID" => $vendor_id);
		$temp = $this->input->post('category');
		if(!empty($temp)) {
			$category = $this->input->post('category');
			$data['CATEGORY'] = $category;
		}
		$temp = $this->input->post('equip_name');
		if(!empty($temp)) {
			$equip_name = $this->input->post('equip_name');
			$data['EQUIP_NAME'] = $equip_name;
		}
		$temp = $this->input->post('spec');
		if(!empty($temp)) {
			$spec = $this->input->post('spec');
			$data['SPEC'] = $spec;
		}
		$temp = $this->input->post('year_made');
		if(!empty($temp)) {
			// $year_made = $this->input->post('year_made');
			// $data['YEAR_MADE'] = $year_made;

			$year_made = date("Y", strtotime($this->input->post('year_made')));
			$data['YEAR_MADE'] = (int)$year_made;
		}
		$temp = $this->input->post('quantity');
		if(!empty($temp)) {
			$quantity = $this->input->post('quantity');
			$data['QUANTITY'] = $quantity;
		}
		if ($this->session->userdata('STATUS') == "3") {
			$this->do_insert_panel($LM_ID);
			$data['VND_TRAIL_ID'] = "3";
			$where = array('VENDOR_ID' => $vendor_id, 'EQUIP_ID' => $equip_id);
			
			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_update_equipments','hist_vnd_equip','update',$data,$where);
			//--END LOG DETAIL--//

			echo json_encode($this->hist_vnd_equip->update($data,$where));
		}
		else { 
			echo json_encode('Gagal updating data');
		}
	}

	public function do_remove_vendor_equipments($equip_id){
		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Delete equipment)','Delete',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		
		$where = array("EQUIP_ID" => $equip_id);
		$this->log_data->detail($LM_ID,'Vendor_update_profile/do_remove_vendor_equipments','hist_vnd_equip','delete',null,$where);
		//--END LOG DETAIL--//

		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_equip');
		} 
		if ($this->hist_vnd_equip->delete(array("EQUIP_ID" => $equip_id))) {
			redirect('Vendor_update_profile/facility_and_equipment');
		}
	}
	/* End Fasilitas / equipment */

	/* Start Company Experience */
	function do_insert_experiences() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_cv');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Input experiences)','SAVE',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$client_name = NULL;
		$project_name = NULL;
		$currency = NULL;
		$amount = NULL;
		$contact_person = NULL;
		$contact_no = NULL;
		$contract_no = NULL;
		$description = NULL;
		$start_date = NULL;
		$end_date = NULL;
		$client_name_doc = NULL;
		$data = array(
			"VENDOR_ID" => $vendor_id
			);
		$temp = $this->input->post('client_name');
		if(!empty($temp)) {
			$client_name = $this->input->post('client_name');
			$data['CLIENT_NAME'] = $client_name;
		}
		$temp = $this->input->post('project_name');
		if(!empty($temp)) {
			$project_name = $this->input->post('project_name');
			$data['PROJECT_NAME'] = $project_name;
		}
		$temp = $this->input->post('currency');
		if(!empty($temp)) {
			$currency = $this->input->post('currency');
			$data['CURRENCY'] = $currency;
		}
		$temp = $this->input->post('amount');
		if(!empty($temp)) {
			$amount = $this->input->post('amount');
			if(preg_match("/^[0-9,]+$/", $amount)) 
				$amount = str_replace(",", "", $amount);
			$data['AMOUNT'] = $amount;
		}
		$temp = $this->input->post('contact_person');
		if(!empty($temp)) {
			$contact_person = $this->input->post('contact_person');
			$data['CONTACT_PERSON'] = $contact_person;
		}
		$temp = $this->input->post('contact_no');
		if(!empty($temp)) {
			$contact_no = $this->input->post('contact_no');
			$data['CONTACT_NO'] = $contact_no;
		}
		$temp = $this->input->post('contract_no');
		if(!empty($temp)) {
			$contract_no = $this->input->post('contract_no');
			$data['CONTRACT_NO'] = $contract_no;
		}
		$temp = $this->input->post('description');
		if(!empty($temp)) {
			$description = $this->input->post('description');
			$data['DESCRIPTION'] = $description;
		}
		$temp = $this->input->post('start_date');
		if(!empty($temp)) {
			$start_date = $this->input->post('start_date');
			$data['START_DATE'] = vendortodate($start_date);
		}
		$temp = $this->input->post('end_date');
		if(!empty($temp)) {
			$end_date = $this->input->post('end_date');
			$data['END_DATE'] = vendortodate($end_date);
		}
		$temp = $this->input->post('client_name_doc');
		if(!empty($temp)) {
			$client_name_doc = $this->input->post('client_name_doc');
			$data['CLIENT_NAME_DOC'] = $client_name_doc;
		}
		if ($this->session->userdata('STATUS') == "3") {
			$this->do_insert_panel($LM_ID);
			$data['VND_TRAIL_ID'] = "3";
			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_insert_experiences','hist_vnd_cv','insert',$data);
			//--END LOG DETAIL--//
			echo json_encode($this->hist_vnd_cv->insert($data)); 
		}
		else {
			echo json_encode('Gagal inserting data');
		}
	}

	function do_update_experiences() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_cv');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Update experiences)','EDIT',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$cv_id = $this->input->post('cv_id');

		$client_name = NULL;
		$project_name = NULL;
		$currency = NULL;
		$amount = NULL;
		$contact_person = NULL;
		$contact_no = NULL;
		$contract_no = NULL;
		$description = NULL;
		$start_date = NULL;
		$end_date = NULL;
		$client_name_doc = NULL;
		$data = array(
			"VENDOR_ID" => $vendor_id
			);
		$temp = $this->input->post('client_name');
		if(!empty($temp)) {
			$client_name = $this->input->post('client_name');
			$data['CLIENT_NAME'] = $client_name;
		}
		$temp = $this->input->post('project_name');
		if(!empty($temp)) {
			$project_name = $this->input->post('project_name');
			$data['PROJECT_NAME'] = $project_name;
		}
		$temp = $this->input->post('currency');
		if(!empty($temp)) {
			$currency = $this->input->post('currency');
			$data['CURRENCY'] = $currency;
		}
		$temp = $this->input->post('amount');
		if(!empty($temp)) {
			$amount = $this->input->post('amount');
			if(preg_match("/^[0-9,]+$/", $amount)) 
				$amount = str_replace(",", "", $amount);
			$data['AMOUNT'] = $amount;
		}
		$temp = $this->input->post('contact_person');
		if(!empty($temp)) {
			$contact_person = $this->input->post('contact_person');
			$data['CONTACT_PERSON'] = $contact_person;
		}
		$temp = $this->input->post('contact_no');
		if(!empty($temp)) {
			$contact_no = $this->input->post('contact_no');
			$data['CONTACT_NO'] = $contact_no;
		}
		$temp = $this->input->post('contract_no');
		if(!empty($temp)) {
			$contract_no = $this->input->post('contract_no');
			$data['CONTRACT_NO'] = $contract_no;
		}
		$temp = $this->input->post('description');
		if(!empty($temp)) {
			$description = $this->input->post('description');
			$data['DESCRIPTION'] = $description;
		}
		$temp = $this->input->post('start_date');
		if(!empty($temp)) {
			$start_date = $this->input->post('start_date');
			$data['START_DATE'] = vendortodate($start_date);
		}
		$temp = $this->input->post('end_date');
		if(!empty($temp)) {
			$end_date = $this->input->post('end_date');
			$data['END_DATE'] = vendortodate($end_date);
		}
		$temp = $this->input->post('client_name_doc');
		if(!empty($temp)) {
			$client_name_doc = $this->input->post('client_name_doc');
			$data['CLIENT_NAME_DOC'] = $client_name_doc;
		}
		if ($this->session->userdata('STATUS') == "3") {
			$this->do_insert_panel($LM_ID);
			$data['VND_TRAIL_ID'] = "3";
			$where = array('VENDOR_ID' => $vendor_id, 'CV_ID' => $cv_id);
			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_update_experiences','hist_vnd_cv','update',$data,$where);
			//--END LOG DETAIL--//
			echo json_encode($this->hist_vnd_cv->update($data,$where)); 
		}
		else { 
			echo json_encode('Gagal updating data');
		}
	}

	public function do_remove_vendor_experiences($cv_id){

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Delete experiences)','Delete',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//


		//--LOG DETAIL--//
		$where = array("CV_ID" => $cv_id);
		$this->log_data->detail($LM_ID,'Vendor_update_profile/do_remove_vendor_experiences','hist_vnd_cv','delete',null,$where);
		//--END LOG DETAIL--//
		
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_cv');
		}
		if ($this->hist_vnd_cv->delete(array("CV_ID" => $cv_id))) {
			redirect('Vendor_update_profile/company_experience');
		}
	}
	/* End Company Experience */

	/* Start Additional document */
	function do_insert_principal() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_add');
		} 
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Input principal)','SAVE',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$name = NULL;
		$address = NULL;
		$city = NULL;
		$country = NULL;
		$post_code = NULL;
		$qualification = NULL;
		$relationship = NULL;
		$data = array(
			"VENDOR_ID" => $vendor_id,
			"TYPE" => "Principal"
			);
		$temp = $this->input->post('name');
		if(!empty($temp)) {
			$name = $this->input->post('name');
			$data['NAME'] = $name;
		}
		$temp = $this->input->post('address');
		if(!empty($temp)) {
			$address = $this->input->post('address');
			$data['ADDRESS'] = $address;
		}
		$temp = $this->input->post('city');
		if(!empty($temp)) {
			$city = $this->input->post('city');
			$data['CITY'] = $city;
		}
		$temp = $this->input->post('country');
		if(!empty($temp)) {
			$country = $this->input->post('country');
			$data['COUNTRY'] = $country;
		}
		$temp = $this->input->post('post_code');
		if(!empty($temp)) {
			$post_code = $this->input->post('post_code');
			$data['POST_CODE'] = $post_code;
		}
		$temp = $this->input->post('qualification');
		if(!empty($temp)) {
			$qualification = $this->input->post('qualification');
			$data['QUALIFICATION'] = $qualification;
		}
		$temp = $this->input->post('relationship');
		if(!empty($temp)) {
			$relationship = $this->input->post('relationship');
			$data['RELATIONSHIP'] = $relationship;
		}
		if ($this->session->userdata('STATUS') == "3") {
			$this->do_insert_panel($LM_ID);
			$data['VND_TRAIL_ID'] = "3";
			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_insert_principal','hist_vnd_add','insert',$data);
			//--END LOG DETAIL--//
			echo json_encode($this->hist_vnd_add->insert($data));
		}
		else {
			echo json_encode('Gagal inserting data');
		}
	}

	function do_insert_subcontractor() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_add');
		} 
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Input Subcontractor)','SAVE',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$name = NULL;
		$address = NULL;
		$city = NULL;
		$country = NULL;
		$post_code = NULL;
		$qualification = NULL;
		$relationship = NULL;
		$data = array(
			"VENDOR_ID" => $vendor_id,
			"TYPE" => "Subcontractor"
			);
		$temp = $this->input->post('name');
		if(!empty($temp)) {
			$name = $this->input->post('name');
			$data['NAME'] = $name;
		}
		$temp = $this->input->post('address');
		if(!empty($temp)) {
			$address = $this->input->post('address');
			$data['ADDRESS'] = $address;
		}
		$temp = $this->input->post('city');
		if(!empty($temp)) {
			$city = $this->input->post('city');
			$data['CITY'] = $city;
		}
		$temp = $this->input->post('country');
		if(!empty($temp)) {
			$country = $this->input->post('country');
			$data['COUNTRY'] = $country;
		}
		$temp = $this->input->post('post_code');
		if(!empty($temp)) {
			$post_code = $this->input->post('post_code');
			$data['POST_CODE'] = $post_code;
		}
		$temp = $this->input->post('qualification');
		if(!empty($temp)) {
			$qualification = $this->input->post('qualification');
			$data['QUALIFICATION'] = $qualification;
		}
		$temp = $this->input->post('relationship');
		if(!empty($temp)) {
			$relationship = $this->input->post('relationship');
			$data['RELATIONSHIP'] = $relationship;
		}
		if ($this->session->userdata('STATUS') == "3") {
			$this->do_insert_panel($LM_ID);
			$data['VND_TRAIL_ID'] = "3";
			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_insert_subcontractor','hist_vnd_add','insert',$data);
			//--END LOG DETAIL--//
			echo json_encode($this->hist_vnd_add->insert($data)); 
		}
		else {
			echo json_encode('Gagal Inserting data');
		}
	}

	function do_insert_affiliation_company() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_add');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Input affiliation company)','SAVE',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$name = NULL;
		$address = NULL;
		$city = NULL;
		$country = NULL;
		$post_code = NULL;
		$qualification = NULL;
		$relationship = NULL;
		$data = array(
			"VENDOR_ID" => $vendor_id,
			"TYPE" => "Affiliation Company"
			);
		$temp = $this->input->post('name');
		if(!empty($temp)) {
			$name = $this->input->post('name');
			$data['NAME'] = $name;
		}
		$temp = $this->input->post('address');
		if(!empty($temp)) {
			$address = $this->input->post('address');
			$data['ADDRESS'] = $address;
		}
		$temp = $this->input->post('city');
		if(!empty($temp)) {
			$city = $this->input->post('city');
			$data['CITY'] = $city;
		}
		$temp = $this->input->post('country');
		if(!empty($temp)) {
			$country = $this->input->post('country');
			$data['COUNTRY'] = $country;
		}
		$temp = $this->input->post('post_code');
		if(!empty($temp)) {
			$post_code = $this->input->post('post_code');
			$data['POST_CODE'] = $post_code;
		}
		$temp = $this->input->post('qualification');
		if(!empty($temp)) {
			$qualification = $this->input->post('qualification');
			$data['QUALIFICATION'] = $qualification;
		}
		$temp = $this->input->post('relationship');
		if(!empty($temp)) {
			$relationship = $this->input->post('relationship');
			$data['RELATIONSHIP'] = $relationship;
		}
		if ($this->session->userdata('STATUS') == "3") {
			$this->do_insert_panel($LM_ID);
			$data['VND_TRAIL_ID'] = "3";
			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_insert_affiliation_company','hist_vnd_add','insert',$data);
			//--END LOG DETAIL--//
			echo json_encode($this->hist_vnd_add->insert($data));
		}
		else {
			echo json_encode('Gagal Inserting data');
		}
	}

	function do_update_principal() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_add');
		} 
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}
		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Update principal)','EDIT',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$add_id = $this->input->post('add_id');

		$name = NULL;
		$address = NULL;
		$city = NULL;
		$country = NULL;
		$post_code = NULL;
		$qualification = NULL;
		$relationship = NULL;
		$data = array(
			"VENDOR_ID" => $vendor_id,
			"TYPE" => "Principal"
			);
		$temp = $this->input->post('name');
		if(!empty($temp)) {
			$name = $this->input->post('name');
			$data['NAME'] = $name;
		}
		$temp = $this->input->post('address');
		if(!empty($temp)) {
			$address = $this->input->post('address');
			$data['ADDRESS'] = $address;
		}
		$temp = $this->input->post('city');
		if(!empty($temp)) {
			$city = $this->input->post('city');
			$data['CITY'] = $city;
		}
		$temp = $this->input->post('country');
		if(!empty($temp)) {
			$country = $this->input->post('country');
			$data['COUNTRY'] = $country;
		}
		$temp = $this->input->post('post_code');
		if(!empty($temp)) {
			$post_code = $this->input->post('post_code');
			$data['POST_CODE'] = $post_code;
		}
		$temp = $this->input->post('qualification');
		if(!empty($temp)) {
			$qualification = $this->input->post('qualification');
			$data['QUALIFICATION'] = $qualification;
		}
		$temp = $this->input->post('relationship');
		if(!empty($temp)) {
			$relationship = $this->input->post('relationship');
			$data['RELATIONSHIP'] = $relationship;
		}
		if ($this->session->userdata('STATUS') == "3") {
			$this->do_insert_panel($LM_ID);
			$data['VND_TRAIL_ID'] = "3";
			$where = array('VENDOR_ID' => $vendor_id, 'ADD_ID' => $add_id);
			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_update_principal','hist_vnd_add','update',$data,$where);
			//--END LOG DETAIL--//
			echo json_encode($this->hist_vnd_add->update($data,$where)); 
		}
		else {
			echo json_encode('Gagal updating data');
		}
	}

	function do_update_subkontraktor() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_add');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}
		
		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Update Subcontractor)','EDIT',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
		
		$add_id = $this->input->post('add_id');

		$name = NULL;
		$address = NULL;
		$city = NULL;
		$country = NULL;
		$post_code = NULL;
		$qualification = NULL;
		$relationship = NULL;
		$data = array(
			"VENDOR_ID" => $vendor_id,
			"TYPE" => "Subcontractor"
			);
		$temp = $this->input->post('name');
		if(!empty($temp)) {
			$name = $this->input->post('name');
			$data['NAME'] = $name;
		}
		$temp = $this->input->post('address');
		if(!empty($temp)) {
			$address = $this->input->post('address');
			$data['ADDRESS'] = $address;
		}
		$temp = $this->input->post('city');
		if(!empty($temp)) {
			$city = $this->input->post('city');
			$data['CITY'] = $city;
		}
		$temp = $this->input->post('country');
		if(!empty($temp)) {
			$country = $this->input->post('country');
			$data['COUNTRY'] = $country;
		}
		$temp = $this->input->post('post_code');
		if(!empty($temp)) {
			$post_code = $this->input->post('post_code');
			$data['POST_CODE'] = $post_code;
		}
		$temp = $this->input->post('qualification');
		if(!empty($temp)) {
			$qualification = $this->input->post('qualification');
			$data['QUALIFICATION'] = $qualification;
		}
		$temp = $this->input->post('relationship');
		if(!empty($temp)) {
			$relationship = $this->input->post('relationship');
			$data['RELATIONSHIP'] = $relationship;
		}
		if ($this->session->userdata('STATUS') == "3") {
			$this->do_insert_panel($LM_ID);
			$data['VND_TRAIL_ID'] = "3";
			$where = array('VENDOR_ID' => $vendor_id, 'ADD_ID' => $add_id);
			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_update_subkontraktor','hist_vnd_add','update',$data,$where);
			//--END LOG DETAIL--//

			echo json_encode($this->hist_vnd_add->update($data,$where)); 
		}
		else {
			echo json_encode('Gagal Updating data');
		}
	}

	function do_update_affiliasi() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_add');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}
		
		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Update affiliation company)','EDIT',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
		
		$add_id = $this->input->post('add_id');

		$name = NULL;
		$address = NULL;
		$city = NULL;
		$country = NULL;
		$post_code = NULL;
		$qualification = NULL;
		$relationship = NULL;
		$data = array(
			"VENDOR_ID" => $vendor_id,
			"TYPE" => "Affiliation Company"
			);
		$temp = $this->input->post('name');
		if(!empty($temp)) {
			$name = $this->input->post('name');
			$data['NAME'] = $name;
		}
		$temp = $this->input->post('address');
		if(!empty($temp)) {
			$address = $this->input->post('address');
			$data['ADDRESS'] = $address;
		}
		$temp = $this->input->post('city');
		if(!empty($temp)) {
			$city = $this->input->post('city');
			$data['CITY'] = $city;
		}
		$temp = $this->input->post('country');
		if(!empty($temp)) {
			$country = $this->input->post('country');
			$data['COUNTRY'] = $country;
		}
		$temp = $this->input->post('post_code');
		if(!empty($temp)) {
			$post_code = $this->input->post('post_code');
			$data['POST_CODE'] = $post_code;
		}
		$temp = $this->input->post('qualification');
		if(!empty($temp)) {
			$qualification = $this->input->post('qualification');
			$data['QUALIFICATION'] = $qualification;
		}
		$temp = $this->input->post('relationship');
		if(!empty($temp)) {
			$relationship = $this->input->post('relationship');
			$data['RELATIONSHIP'] = $relationship;
		}
		if ($this->session->userdata('STATUS') == "3") {
			$this->do_insert_panel($LM_ID);
			$data['VND_TRAIL_ID'] = "3";
			$where = array('VENDOR_ID' => $vendor_id, 'ADD_ID' => $add_id);
			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_update_affiliasi','hist_vnd_add','update',$data,$where);
			//--END LOG DETAIL--//
			echo json_encode($this->hist_vnd_add->update($data,$where));
		}
		else { 
			echo json_encode('Gagal updating data');
		}
	}
	public function do_remove_vendor_add($add_id){
		$this->load->model('hist_vnd_add');
		$deleted = false; 

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Delete vnd add)','Delete',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//


		//--LOG DETAIL--//
		$where = array("ADD_ID" => $add_id, "VND_TRAIL_ID"=>3);
		$this->log_data->detail($LM_ID,'Vendor_update_profile/do_remove_vendor_add','hist_vnd_add','delete',null,$where);
		//--END LOG DETAIL--//

		if ($this->session->userdata('STATUS') == "3"){
			$deleted = $this->hist_vnd_add->delete(array("ADD_ID" => $add_id, "VND_TRAIL_ID"=>3));
		}
		if ($deleted) {
			redirect('Vendor_update_profile/additional_document');
		}
	}
	/* End Additional document */

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

	public function cek_panel_reject(){
		$this->load->model('vnd_update_progress');

		$vendor_id = $this->input->post('vendor_id');
		$status = 'Rejected';
		$cek_panel = $this -> vnd_update_progress -> get_cek_panel($vendor_id,$status);
		echo json_encode(count($cek_panel));	
		// echo "<pre>";
		// print_r($cek_panel);die;	
	}

	function do_finish_register() {
		$temp = $this->input->post('vendor_id');
		$this->load->model('vnd_header');
		$this->load->model('vnd_vendor_comment');

		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (FINISH)','SUBMIT',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}
		else {
			$vendor_id = $this->session->userdata('VENDOR_ID');
		}

		$whereopco = $this->vnd_header->where(array("VENDOR_ID"=>$vendor_id))->get_all();

		if ($this->session->userdata('STATUS') == "3") {
			$where = array("VENDOR_ID" => $vendor_id);
			$this->vnd_header->update(array('STATUS_PERUBAHAN' => 8), $where);

			//--LOG DETAIL--//
			$datanyo['STATUS_PERUBAHAN'] = '8'; 
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_finish_register','vnd_header','update',$datanyo,$where);
			//--END LOG DETAIL--//
			
			
			$comen = $this->input->post('comment');
			$cmt["VENDOR_ID"] = $vendor_id;
			$cmt["EMP_NAMA"] = 'VENDOR';
			$cmt["COMMENT"] = $comen;
			$cmt["STATUS_AKTIF"] = '2';
			$cmt["STATUS_ACTIVITY"] = "Vendor Comment";

			$this->vnd_vendor_comment->insert($cmt);
			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_finish_register','vnd_vendor_comment','insert',$cmt);
			//--END LOG DETAIL--//

			$data['title'] = "Ubah Data Profil Selesai";
			$data['nama_company'] = $this->session->userdata['COMPANYNAME'];
			$data['email'] = $this->session->userdata['EMAIL_COMPANY'];
			
			$this->layout->render('finish_registration',$data);
		} else {
			echo json_encode('Data kosong');
		}

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
				die('could not be found.');
			}
			
			$this->output->set_content_type(get_mime_by_extension($image_path));
			return $this->output->set_output(file_get_contents($image_path));
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

	function pilih_child(){
		$id = $this->input->post('id');
		$this->load->model('com_jasa_group');

		$data=$this->com_jasa_group->get_child($id);

		echo form_dropdown("data",$data,'','');
	}

	function pilih_sub_klasifikasi() {
		$id = $this->input->post('id');
		$this->load->model('com_jasa_group');

		$data=$this->com_jasa_group->get_sub_klasifikasi($id);

		echo json_encode($data);
	}

	function pilih_child_kualifikasi(){
		$id = $this->input->post('id');
		$this->load->model('com_jasa_kualifikasi');

		$data=$this->com_jasa_kualifikasi->get_child($id);

		echo form_dropdown("data",$data,'','');
	}

	function pilih_child_material(){
		$id = $this->input->post('id');
		$this->load->model('m_sub_material_group');
		$data = $this->m_sub_material_group->get_child($id);

		echo form_dropdown("data",$data,'','');
		
		// Material jika mengambil dari SAP
		// $this->load->model('m_material');
		// $submaterial = $this->input->post('submaterial_code');
		// $material = $this->input->post('id');
		// $this->load->library('sap_handler');
		// $mat = $this->sap_handler->getMaterial($material, $submaterial);
		// echo json_encode(array('subgroup'=>$data,'mat'=>$mat));
	}

	public function deleteFile(){
		$id = $this->input->post('id');
		$fileUpload = $this->input->post('filename');
		$this->load->model('hist_vnd_product');
		
		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Delete file upload)','Delete',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$this->load->helper("url");

		$path = './upload/vendor/'.$fileUpload;
		if(file_exists(BASEPATH.'../upload/vendor/'.$fileUpload)){
			unlink($path);
		}
		
		if(!empty($id)){
			$data['FILE_UPLOAD'] = null;
			$where = array('PRODUCT_ID' => $id);
			$this->hist_vnd_product->update($data,$where);	

			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/deleteFile','hist_vnd_product','update',$data,$where);
			//--END LOG DETAIL--//
		}
	}

	public function deleteFile_akta(){
		$id = $this->input->post('id');
		$cek = $this->input->post('chek');
		$fileUpload = $this->input->post('filename');
		$this->load->model('hist_vnd_akta');
		
		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Delete file upload)','Delete',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$this->load->helper("url");

		$path = './upload/vendor/'.$fileUpload;
		if(file_exists(BASEPATH.'../upload/vendor/'.$fileUpload)){
			unlink($path);
		}
		
		if(!empty($id)){
			if ($cek == 'e_del_akta') {
				$data['AKTA_NO_DOC'] = null;
			} else if ($cek == 'e_del_hakim') {
				$data['PENGESAHAN_HAKIM_DOC'] = null;
			} else if ($cek == 'e_del_negara') {
				$data['BERITA_ACARA_NGR_DOC'] = null;
			}

			$where = array('AKTA_ID' => $id);
			$this->hist_vnd_akta->update($data,$where);	

			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/deleteFile_akta','hist_vnd_akta','update',$data,$where);
			//--END LOG DETAIL--//
		}
	}

	public function deleteFile_ba(){
		$fileUpload = $this->input->post('filename');
		//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['VENDOR_NO'],$this->session->userdata['VENDOR_NAME'],
			'VENDOR','Update Profile (Delete file upload)','Delete',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$this->load->helper("url");

		$path = './upload/vendor/'.$fileUpload;
		if(file_exists(BASEPATH.'../upload/vendor/'.$fileUpload)){
			unlink($path);
		}
		
		$data = $fileUpload ;
		$where = $fileUpload;

		//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Vendor_update_profile/deleteFile_ba','../upload/vendor/','Delete',$data,$where);
		//--END LOG DETAIL--//
	}

	/* INSERT PANEL */
	public function do_insert_panel($LM_ID){
		$this->load->model('vnd_update_progress');

		$vendor_id = $this->input->post('vendor_id');
		$container = $this->input->post('container');

		$cek  = $this->vnd_update_progress->get_cek($vendor_id,$container);
		if (count($cek) != '') { 

			$where = array();
			$data['STATUS'] = 'Edited';
			$where['CONTAINER'] = $this->input->post('container');
			$where['VENDOR_ID'] = $this->input->post('vendor_id');
			$this->vnd_update_progress->update($data, $where);
			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_insert_panel','vnd_update_progress','update',$data,$where);
			//--END LOG DETAIL--//

		} else { 
			
			$data['STATUS'] = 'Edited';
			$data['REASON'] = '';
			$data['CONTAINER'] = $container;
			$data['VENDOR_ID'] = $vendor_id;
			$this->vnd_update_progress->insert($data);

			//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_update_profile/do_insert_panel','vnd_update_progress','insert',$data);
			//--END LOG DETAIL--//
		}
	}

}