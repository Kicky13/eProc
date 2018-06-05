<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Additional_Document extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->model(array('tmp_vnd_header','hist_vnd_header', 'tmp_vnd_reg_progress','vnd_update_progress'));
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
		$data['progress_status'] = $this->prog_status;
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model(array('hist_vnd_add'));
			$vendor = $this->hist_vnd_header->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "VND_TRAIL_ID" => 3));
			$data['vendor_detail'] = $vendor;
			$data['principals'] = $this->hist_vnd_add->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Principal", "VND_TRAIL_ID" => 3));
			$data['subcontractors'] = $this->hist_vnd_add->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Subcontractor", "VND_TRAIL_ID" => 3));
			$data['affiliation_companies'] = $this->hist_vnd_add->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Affiliation Company", "VND_TRAIL_ID" => 3));
		}
		else {
			$this->load->model(array('tmp_vnd_add'));
			$vendor = $this->tmp_vnd_header->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID"))));
			$data['vendor_detail'] = $vendor;
			$data['principals'] = $this->tmp_vnd_add->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Principal"));
			$data['subcontractors'] = $this->tmp_vnd_add->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Subcontractor"));
			$data['affiliation_companies'] = $this->tmp_vnd_add->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Affiliation Company"));
		}
		$data['title'] = "Dokumen Tambahan";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
		$this->layout->add_js(base_url().'Assets/Additional_document/assets/additional_document.js', TRUE);
		$this->layout->render('form_additional_document', $data);
	}

	public function input_summary() {
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
										'tmp_vnd_address',
										'tmp_vnd_akta',
										'tmp_vnd_board',
										'tmp_vnd_bank',
										'tmp_vnd_fin_rpt',
										'tmp_vnd_product',
										'tmp_vnd_sdm',
										'tmp_vnd_cert',
										'tmp_vnd_equip',
										'tmp_vnd_cv',
										'tmp_vnd_add'
									));
		
		$data['title'] = "Review Input";
		
		$data['prefix'] = $this->m_vnd_prefix->as_dropdown('PREFIX_NAME')->get_all();
		$data['suffix'] = $this->m_vnd_suffix->as_dropdown('SUFFIX_NAME')->get_all();
		$data['country'] = $this->adm_country->as_dropdown('COUNTRY_NAME')->get_all();
		$data['akta_type'] = $this->m_vnd_akta_type->as_dropdown('AKTA_TYPE')->get_all();
		$data['vendor_type'] = $this->m_vnd_type->as_dropdown('VENDOR_TYPE')->get_all();
		$data['currency'] = $this->adm_curr->as_dropdown('CURR_CODE')->get_all();
		$data['certificate_type'] = $this->m_vnd_certificate_type->as_dropdown('CERTIFICATE_TYPE')->get_all();
		$data['tools_category'] = $this->m_vnd_tools_category->as_dropdown('CATEGORY')->get_all();

		$vendor = $this->tmp_vnd_header
						->with('add')
						->with('akta')
						->with('address')
						->with('bank')
						->with('board')
						->with('cert')
						->with('cv')
						->with('equip')
						->with('fin_rpt')
						->with('product')
						->with('sdm')
						->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID"))));
		$data['vendor_akta'] = $vendor['akta'];
		$data['company_address'] = $vendor['address'];
		$data['vendor_board_commissioner'] = $this->tmp_vnd_board->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Commissioner"));
		$data['vendor_board_director'] = $this->tmp_vnd_board->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Director"));
		$data['vendor_fin_report'] = $vendor['fin_rpt'];
		$data['vendor_bank'] = $vendor['bank'];
		$data['goods'] = $this->tmp_vnd_product->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "PRODUCT_TYPE" => "GOODS"));
		$data['bahan'] = $this->tmp_vnd_product->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "PRODUCT_TYPE" => "BAHAN"));
		$data['services'] = $this->tmp_vnd_product->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "PRODUCT_TYPE" => "SERVICES"));
		$data['main_sdm'] = $this->tmp_vnd_sdm->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "MAIN"));
		$data['support_sdm'] = $this->tmp_vnd_sdm->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "SUPPORT"));
		$data['certifications'] = $vendor['cert'];
		$data['equipments'] = $vendor['equip'];
		$data['experiences'] = $vendor['cv'];
		$data['principals'] = $this->tmp_vnd_add->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Principal"));
		$data['subcontractors'] = $this->tmp_vnd_add->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Subcontractor"));
		$data['affiliation_companies'] = $this->tmp_vnd_add->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "Affiliation Company"));
		
		$province = create_standard($this->adm_wilayah->fields('ID,NAMA')->get_all(array('JENIS'=>'PROVINSI')));
		$city = create_standard($this->adm_wilayah->fields('ID,NAMA')->get_all(array('JENIS'=>'KOTA')));
		// $city = create_standard($this->adm_wilayah->fields('KODE,NAMA')->get_all(array('JENIS'=>'KOTA')));
		
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

		$venid = $this->session->userdata['VENDOR_ID'];

		$this->load->model('vnd_vendor_comment');
		$data['ven_comment'] = $this->vnd_vendor_comment->where('STATUS_AKTIF','4')->order_by('ID','ASC')->get_all(array("VENDOR_ID" => intval($venid)));

		$data['vendor_detail'] = $vendor;
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		// $this->layout->add_js(base_url().'Assets/Additional_document/assets/additional_document.js', TRUE);
		$this->layout->render('form_review_input', $data);
	}

	function do_update_principal() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_add');
		}
		else {
			$this->load->model('tmp_vnd_add');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}
		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Update principal)','EDIT',$this->input->ip_address());
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
			$data['VND_TRAIL_ID'] = "3";
			$where = array('VENDOR_ID' => $vendor_id, 'ADD_ID' => $add_id);
			echo json_encode($this->hist_vnd_add->update($data,$where)); 
		}
		else {
			$where = array('VENDOR_ID' => $vendor_id, 'ADD_ID' => $add_id);
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Additional_document/do_update_principal','tmp_vnd_add','update',$data,$where);
			//--END LOG DETAIL--//
			echo json_encode($this->tmp_vnd_add->update($data,$where));
		}
	}

	function do_insert_principal() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_add');
		}
		else {
			$this->load->model('tmp_vnd_add');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}
		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Input principal)','SAVE',$this->input->ip_address());
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
			$data['VND_TRAIL_ID'] = "3";
			echo json_encode($this->hist_vnd_add->insert($data)); 
		}
		else {
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Additional_document/do_insert_principal','tmp_vnd_add','insert',$data);
			//--END LOG DETAIL--//
			echo json_encode($this->tmp_vnd_add->insert($data));
		}
	}

	function do_update_subkontraktor() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_add');
		}
		else {
			$this->load->model('tmp_vnd_add');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}
		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Update Subcontractor)','EDIT',$this->input->ip_address());
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
			$data['VND_TRAIL_ID'] = "3";
			$where = array('VENDOR_ID' => $vendor_id, 'ADD_ID' => $add_id);
			echo json_encode($this->hist_vnd_add->update($data,$where)); 
		}
		else {
			$where = array('VENDOR_ID' => $vendor_id, 'ADD_ID' => $add_id);
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Additional_document/do_update_subkontraktor','tmp_vnd_add','update',$data,$where);
			//--END LOG DETAIL--//
			echo json_encode($this->tmp_vnd_add->update($data,$where));
		}
	}

	function do_insert_subcontractor() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_add');
		}
		else {
			$this->load->model('tmp_vnd_add');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Input Subcontractor)','SAVE',$this->input->ip_address());
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
			$data['VND_TRAIL_ID'] = "3";
			echo json_encode($this->hist_vnd_add->insert($data));
		}
		else {
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Additional_document/do_insert_subcontractor','tmp_vnd_add','insert',$data);
			//--END LOG DETAIL--//
			echo json_encode($this->tmp_vnd_add->insert($data));
		}
	}

	function do_update_affiliasi() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_add');
		}
		else {
			$this->load->model('tmp_vnd_add');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}
		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Update affiliation company)','EDIT',$this->input->ip_address());
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
			$data['VND_TRAIL_ID'] = "3";
			$where = array('VENDOR_ID' => $vendor_id, 'ADD_ID' => $add_id);
			echo json_encode($this->hist_vnd_add->update($data,$where));
		}
		else {
			$where = array('VENDOR_ID' => $vendor_id, 'ADD_ID' => $add_id);
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Additional_document/do_update_affiliasi','tmp_vnd_add','update',$data,$where);
			//--END LOG DETAIL--//
			echo json_encode($this->tmp_vnd_add->update($data,$where));
		}
	}

	function do_insert_affiliation_company() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_add');
		}
		else {
			$this->load->model('tmp_vnd_add');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Input affiliation company)','SAVE',$this->input->ip_address());
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
			$data['VND_TRAIL_ID'] = "3";
			echo json_encode($this->hist_vnd_add->insert($data));
		}
		else {
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Additional_document/do_insert_affiliation_company','tmp_vnd_add','insert',$data);
			//--END LOG DETAIL--//
			echo json_encode($this->tmp_vnd_add->insert($data));
		}
	}

	function do_finish_register() {
		$temp = $this->input->post('vendor_id');
		$this->load->model('tmp_vnd_header');
		$this->load->model('vnd_vendor_comment');
		$this->load->model('tmp_vnd_product');

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Finish)','SUBMIT',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		} else {
			$vendor_id = $this->session->userdata('VENDOR_ID');
		}
		
		$product = $this->tmp_vnd_product->fields("PRODUCT_TYPE")->where("VENDOR_ID",$vendor_id)->order_by('PRODUCT_TYPE','ASC')->get_all();
		$data_pdt = array();
		foreach ($product as $key => $value) {
				$data_pdt[] = $value['PRODUCT_TYPE'];
		}
		$new_product = implode(",", array_unique($data_pdt));

		$where = array("VENDOR_ID" => $vendor_id);

		if ($new_product == 'GOODS') {
			$data_product['PRODUCT_TYPE_PROC'] = '1';
			$this->tmp_vnd_header->update($data_product,$where);

		} elseif ($new_product == 'SERVICES') {
			$data_product['PRODUCT_TYPE_PROC'] = '2';
			$this->tmp_vnd_header->update($data_product,$where);

		} elseif ($new_product == 'BAHAN') {
			$data_product['PRODUCT_TYPE_PROC'] = '3';
			$this->tmp_vnd_header->update($data_product,$where);

		} elseif ($new_product == 'GOODS,SERVICES') {
			$data_product['PRODUCT_TYPE_PROC'] = '4';
			$this->tmp_vnd_header->update($data_product,$where);

		} elseif ($new_product == 'BAHAN,GOODS') {
			$data_product['PRODUCT_TYPE_PROC'] = '5';
			$this->tmp_vnd_header->update($data_product,$where);

		} elseif ($new_product == 'BAHAN,SERVICES') {
			$data_product['PRODUCT_TYPE_PROC'] = '6';
			$this->tmp_vnd_header->update($data_product,$where);

		} elseif ($new_product == 'BAHAN,GOODS,SERVICES') {
			$data_product['PRODUCT_TYPE_PROC'] = '7';
			$this->tmp_vnd_header->update($data_product,$where);
		}

		// die(var_dump($new_product));

		$vendor = $this->tmp_vnd_header->where(array("VENDOR_ID"=>$vendor_id))->get_all();
		$data = $vendor[0]['STATUS'];

		$data_update = array();

		$data_update['NEXT_PAGE'] = "Persetujuan New Registrasi";
		$data_update['STATUS'] = 1;

		$comen = $this->input->post('comment');
		$cmt["VENDOR_ID"] = $vendor_id;
		$cmt["EMP_NAMA"] = 'VENDOR';
		$cmt["COMMENT"] = $comen;
		$cmt["STATUS_AKTIF"] = '4';
		$cmt["STATUS_ACTIVITY"] = "Vendor Comment";
		$this->vnd_vendor_comment->insert($cmt);

		if ($this->tmp_vnd_header->update($data_update,$where) && $this->session->userdata('STATUS') != "3") {

			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Additional_document/do_finish_register','tmp_vnd_header','update',$data_update,$where);
			//--END LOG DETAIL--//

			echo $data;
		} else {
			redirect(base_url());
		}
	}

	public function do_remove_vendor_add($add_id)
	{

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Delete vendor add)','Delete',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$this->load->model(array('tmp_vnd_add', 'hist_vnd_add'));
		$deleted = false;
		if ($this->session->userdata('STATUS') == "3"){
			$deleted = $this->hist_vnd_add->delete(array("ADD_ID" => $add_id, "VND_TRAIL_ID"=>3));
		} else {
			$deleted = $this->tmp_vnd_add->delete(array("ADD_ID" => $add_id));
			//--LOG DETAIL--//
				$where = array("ADD_ID" => $add_id);
				$this->log_data->detail($LM_ID,'Additional_document/do_remove_vendor_add','tmp_vnd_add','delete',null,$where);
			//--END LOG DETAIL--//
		}

		if ($deleted) {
			redirect('Additional_document');
		}
	}

	function get_add_document_edit()
	{
		$add_id = $this->input->post('add_id');
		$add_document_data = array();
		if(!empty($add_id)){
			$this->load->model(array('hist_vnd_add','tmp_vnd_add'));
				$add_document_data = $this->tmp_vnd_add->get_all(array('ADD_ID'=>$add_id));
		} else {

		}

		echo json_encode($add_document_data);
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

	public function finish_view($status){
		// die(var_dump($status));
		$this->load->model('tmp_vnd_header');
		$vendor_id = $this->session->userdata('VENDOR_ID');
		$vendor_tmp = $this->tmp_vnd_header->where(array("VENDOR_ID"=>$vendor_id))->get_all();
		$opco = $vendor_tmp[0]['COMPANYID'];

		if ($opco == '7000' || $opco == '2000' || $opco == '5000') {
			$opco_kirim = '2000';
		} else{ 
			$opco_kirim = $opco;
		}
		
		$this->session->sess_destroy();
		$data['status'] = $status;
		$data['title'] = "Finish Registration";
		$data['opco'] = $opco_kirim;
		$respon =  $this->layout->render('finish_registration',$data);
	}

}