<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Technical_Document extends CI_Controller {

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
		$this->good_and_service_data();
	}

	public function good_and_service_data() {
		$this->load->model('m_material_group');
		$this->load->model('m_sub_material_group');
		$this->load->model('vnd_header');
		$this->load->model('com_jasa_group');
		$this->load->model('com_jasa_kualifikasi');

		$data['progress_status'] = $this->prog_status;
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model(array('m_vnd_material','m_vnd_svc','hist_vnd_product'));
			$vendor = $this->vnd_header->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID"))));
			$data['vendor_detail'] = $vendor;
			
			$data['goods'] = $this->hist_vnd_product->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "PRODUCT_TYPE" => "GOODS", "VND_TRAIL_ID" => 3));
			$data['bahan'] = $this->hist_vnd_product->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "PRODUCT_TYPE" => "BAHAN", "VND_TRAIL_ID" => 3));
			$data['services'] = $this->hist_vnd_product->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "PRODUCT_TYPE" => "SERVICES", "VND_TRAIL_ID" => 3));
		} else {
			$this->load->model(array('m_vnd_material','m_vnd_svc','tmp_vnd_product'));
			$vendor = $this->tmp_vnd_header->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID"))));
			$data['vendor_detail'] = $vendor;
			$data['goods'] = $this->tmp_vnd_product->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "PRODUCT_TYPE" => "GOODS"));
			$data['bahan'] = $this->tmp_vnd_product->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "PRODUCT_TYPE" => "BAHAN"));
			$data['services'] = $this->tmp_vnd_product->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "PRODUCT_TYPE" => "SERVICES"));
		}
		$data['title'] = "Data Barang dan Jasa";
		$data['svc'] = $this->m_material_group->order_by('DESCRIPTION','ASC')->get_all(array('IS_JASA' => 1));
		$data['subsvc'] = $this->m_sub_material_group->order_by('DESCRIPTION','ASC')->get_all(array('IS_JASA' => 1));

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
		$this->layout->set_table_js();
		$this->layout->set_table_cs();

		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
		$this->layout->add_js(base_url().'Assets/Technical_document/assets/technical_document.js', TRUE);
		$this->layout->render('form_good_and_service_data', $data);
	}

	public function human_resources_data() {
		$data['progress_status'] = $this->prog_status;
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model(array('hist_vnd_sdm','m_vnd_sdm_type_kwn','m_vnd_sdm_type_work'));
			$vendor = $this->hist_vnd_header->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "VND_TRAIL_ID" => 3));
			$data['vendor_detail'] = $vendor;
			$data['main_sdm'] = $this->hist_vnd_sdm->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "MAIN", "VND_TRAIL_ID" => 3));
			$data['support_sdm'] = $this->hist_vnd_sdm->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "SUPPORT", "VND_TRAIL_ID" => 3)); 
		}
		else {
			$this->load->model(array('tmp_vnd_sdm','m_vnd_sdm_type_kwn','m_vnd_sdm_type_work'));
			$vendor = $this->tmp_vnd_header->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID"))));
			$data['vendor_detail'] = $vendor;
			$data['main_sdm'] = $this->tmp_vnd_sdm->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "MAIN"));
			$data['support_sdm'] = $this->tmp_vnd_sdm->get_all(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "TYPE" => "SUPPORT"));
		}
		$data['type_kwn'] = $this->m_vnd_sdm_type_kwn->get();
		$data['type_work'] = $this->m_vnd_sdm_type_work->get();
		
		$data['title'] = "Data SDM";
		
		$this->layout->set_table_js();
		$this->layout->set_table_cs();

		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');

		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
		$this->layout->add_js('plugins/autoNumeric.js');
		$this->layout->add_js('plugins/jquery.maskedinput.js');
		
		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
		$this->layout->add_js(base_url().'Assets/Technical_document/assets/technical_document.js', TRUE);
		$this->layout->render('form_human_resources_data', $data);
	}

	public function certification_data() {
		$data['progress_status'] = $this->prog_status;
		if ($this->session->userdata('STATUS') == "3") {
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
		} else {
			$this->load->model(array('tmp_vnd_cert','m_vnd_certificate_type'));
			$vendor = $this->tmp_vnd_header->with('cert')->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID"))));
			$data['vendor_detail'] = $vendor;
			$data['certifications'] = $vendor['cert'];
		}
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
		$this->layout->add_js(base_url().'Assets/Technical_document/assets/technical_document.js', TRUE);
		$this->layout->render('form_certification_data', $data);
	}

	public function facility_and_equipment() {
		$data['progress_status'] = $this->prog_status;
		if ($this->session->userdata('STATUS') == "3") {
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
		}
		else {
			$this->load->model(array('tmp_vnd_equip','m_vnd_tools_category'));
			$vendor = $this->tmp_vnd_header->with('equip')->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID"))));
			$data['vendor_detail'] = $vendor;
			$data['equipments'] = $vendor['equip'];
		}
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
		$this->layout->add_js(base_url().'Assets/Technical_document/assets/technical_document.js', TRUE);
		$this->layout->render('form_facility_and_equipment', $data);
	}

	public function company_experience() {
		$data['progress_status'] = $this->prog_status;
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model(array('hist_vnd_cv','adm_curr'));
			$vendor = $this->hist_vnd_header->with('cv')->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID")), "VND_TRAIL_ID" => 3));
			$data['vendor_detail'] = $vendor;
			//var_dump($vendor);exit();
			$experiences = array();
			foreach ($vendor['cv'] as $key => $value) {
				if($value['VND_TRAIL_ID']==3){
					array_push($experiences, $value);
				}
			}
			$data['experiences'] = $experiences;
		}
		else {
			$this->load->model(array('tmp_vnd_cv','adm_curr'));
			$vendor = $this->tmp_vnd_header->with('cv')->get(array("VENDOR_ID" => intval($this->session->userdata("VENDOR_ID"))));
			$data['vendor_detail'] = $vendor;
			$data['experiences'] = $vendor['cv'];
		}
		$data['title'] = "Pengalaman Perusahaan";
		$data['currency'] = $this->adm_curr->as_dropdown('CURR_NAME')->get_all();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();

		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		
		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
		$this->layout->add_js('plugins/SimpleAjaxUploader.js');
		$this->layout->add_js('plugins/autoNumeric.js');
		$this->layout->add_js(base_url().'Assets/Technical_document/assets/technical_document.js', TRUE);
		$this->layout->render('form_company_experience', $data);
	}

	function do_get_material() {
		$this->load->model('m_material');

		$submaterial = $this->input->post('submaterial_code');
		$material = $this->input->post('material_code');

		$this->load->library('sap_handler');
		$mat = $this->sap_handler->getMaterial($material, $submaterial);

		// die(var_dump($mat));

		echo json_encode($mat);
	}

	function do_update_good() {
		$this->load->model('tmp_vnd_product');
		$temp = $this->input->post('vendor_id');
		$tempty = empty($temp);
		if (!$tempty) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Update good)','EDIT',$this->input->ip_address());
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
		/* Jika data material dari SAP
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
		
		$where = array('VENDOR_ID' => $vendor_id, 'PRODUCT_ID' => $good_id);
		$this->tmp_vnd_product->update($data,$where);
		//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Technical_document/do_update_good','tmp_vnd_product','update',$data,$where);
		//--END LOG DETAIL--//
		echo "OK";
	}

	function do_insert_good() {
		$this->load->model('tmp_vnd_product');

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Input good)','SAVE',$this->input->ip_address());
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

		$this->tmp_vnd_product->insert($data);
		//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Technical_document/do_insert_good','tmp_vnd_product','insert',$data);
		//--END LOG DETAIL--//

		echo json_encode('OK');
/* Jika Menggunakan data material dari SAP 
		$temp = $this->input->post('product_description');
		$tempty = empty($temp);
		if(!$tempty) {
			foreach ($temp as $key => $value) {
				$product = explode('####', $value);
				$data['PRODUCT_DESCRIPTION_CODE'] = $product[0];
				$data['PRODUCT_DESCRIPTION'] = $product[1];
				if ($this->session->userdata('STATUS') == "3") {
					$data['VND_TRAIL_ID'] = "3";
					$this->hist_vnd_product->insert($data); 
				}
				else {
					$this->tmp_vnd_product->insert($data);
				}
			}
		}
*/ 
	}

	function do_insert_bahan() {
		$this->load->model('tmp_vnd_product');

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

		$this->tmp_vnd_product->insert($data);
		//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Technical_document/do_insert_bahan','tmp_vnd_product','insert',$data);
		//--END LOG DETAIL--//

		echo "OK";
	}

	function do_update_bahan() {
		$this->load->model('tmp_vnd_product');
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
		}
		$temp = $this->input->post('expired_date_edit_bahan');
		$tempty = empty($temp);
		if(!$tempty) {
			$expired_date = $this->input->post('expired_date_edit_bahan');
			$data['EXPIRED_DATE'] = vendortodate($expired_date);
		}
		$old = $this->input->post('file_upload_lama_ba_bahan');
		$new = $this->input->post('file_upload');
		if (!empty($new)) {
			$data['FILE_UPLOAD']=$new;
		} else {
			$data['FILE_UPLOAD']=$old;
		}
		
		$where = array('VENDOR_ID' => $vendor_id, 'PRODUCT_ID' => $bahan_id);
		$this->tmp_vnd_product->update($data,$where);
		//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Technical_document/do_update_good','tmp_vnd_product','update',$data,$where);
		//--END LOG DETAIL--//
		echo "OK";
	}

	function do_update_service() {
		$this->load->model('com_jasa_group'); 
		$this->load->model('tmp_vnd_product'); 
		
		$temp = $this->input->post('vendor_id');
		$service_id = $this->input->post('service_id');
		$tempty = empty($temp);
		if (!$tempty) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Update service)','EDIT',$this->input->ip_address());
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
				$path = './upload/vendor/'.$temp;
				if(file_exists(BASEPATH.'../upload/vendor/'.$temp)){
			        unlink($path);
			    }
			}
		}
		// die(var_dump($data));
		$where = array('VENDOR_ID' => $vendor_id, 'PRODUCT_ID' => $service_id);
		$this->tmp_vnd_product->update($data,$where);
		//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Technical_document/do_update_service','tmp_vnd_product','update',$data,$where);
		//--END LOG DETAIL--//
		echo 'OK';
		
	}

	function do_insert_service() {
		$this->load->model('com_jasa_group');

		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_product');
		}
		else {
			$this->load->model('tmp_vnd_product');
		}
		$temp = $this->input->post('vendor_id');
		$tempty = empty($temp);
		if (!$tempty) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Input service)','SAVE',$this->input->ip_address());
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
			echo "OK";
		}
		else {
			$this->tmp_vnd_product->insert($data);
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Technical_document/do_insert_service','tmp_vnd_product','insert',$data);
			//--END LOG DETAIL--//
			echo "OK";
		}

	}

	function do_update_main_sdm() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_sdm');
		}
		else {
			$this->load->model('tmp_vnd_sdm');
		}
		$temp = $this->input->post('vendor_id');
		$sdm_id = $this->input->post('sdm_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Update sdm)','EDIT',$this->input->ip_address());
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
			$data['VND_TRAIL_ID'] = "3";
			$where = array('VENDOR_ID' =>$vendor_id, 'SDM_ID' => $sdm_id);
			echo json_encode($this->hist_vnd_sdm->update($data,$where));
		}
		else {
			$where = array('VENDOR_ID' =>$vendor_id, 'SDM_ID' => $sdm_id);
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Technical_document/do_update_main_sdm','tmp_vnd_sdm','update',$data,$where);
			//--END LOG DETAIL--//
			echo json_encode($this->tmp_vnd_sdm->update($data,$where));
		}
	}

	function do_insert_main_sdm() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_sdm');
		}
		else {
			$this->load->model('tmp_vnd_sdm');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}
		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Input sdm)','SAVE',$this->input->ip_address());
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
			$data['VND_TRAIL_ID'] = "3";
			echo json_encode($this->hist_vnd_sdm->insert($data));
		}
		else {
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Technical_document/do_insert_main_sdm','tmp_vnd_sdm','insert',$data);
			//--END LOG DETAIL--//
			echo json_encode($this->tmp_vnd_sdm->insert($data));
		}
	}

	function do_update_support_sdm() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_sdm');
		}
		else {
			$this->load->model('tmp_vnd_sdm');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Update support sdm)','EDIT',$this->input->ip_address());
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
			$data['VND_TRAIL_ID'] = "3";
			$where = array('VENDOR_ID' =>$vendor_id, 'SDM_ID' => $sdm_id);
			echo json_encode($this->hist_vnd_sdm->update($data,$where)); 
		}
		else {
			$where = array('VENDOR_ID' =>$vendor_id, 'SDM_ID' => $sdm_id);
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Technical_document/do_update_support_sdm','tmp_vnd_sdm','update',$data,$where);
			//--END LOG DETAIL--//
			echo json_encode($this->tmp_vnd_sdm->update($data,$where));
		}
	}

	function do_insert_support_sdm() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_sdm');
		}
		else {
			$this->load->model('tmp_vnd_sdm');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Input support sdm)','SAVE',$this->input->ip_address());
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
			$data['VND_TRAIL_ID'] = "3";
			echo json_encode($this->hist_vnd_sdm->insert($data)); 
		}
		else {
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Technical_document/do_insert_support_sdm','tmp_vnd_sdm','insert',$data);
			//--END LOG DETAIL--//
			echo json_encode($this->tmp_vnd_sdm->insert($data));
		}
	}

	function do_insert_certifications() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_cert');
		}
		else {
			$this->load->model('tmp_vnd_cert');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Input certifications)','SAVE',$this->input->ip_address());
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
			$data['VND_TRAIL_ID'] = "3";
			echo json_encode($this->hist_vnd_cert->insert($data));
		}
		else {
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Technical_document/do_insert_certifications','tmp_vnd_cert','insert',$data);
			//--END LOG DETAIL--//
			echo json_encode($this->tmp_vnd_cert->insert($data));
		}
	}

	function do_update_certifications() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_cert');
		}
		else {
			$this->load->model('tmp_vnd_cert');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Update certifications)','EDIT',$this->input->ip_address());
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
			$data['VND_TRAIL_ID'] = "3";
			$where = array('VENDOR_ID' => $vendor_id, 'CERT_ID' => $cert_id);
			echo json_encode($this->hist_vnd_cert->update($data,$where));
		}
		else {
			$where = array('VENDOR_ID' => $vendor_id, 'CERT_ID' => $cert_id);
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Technical_document/do_update_certifications','tmp_vnd_cert','update',$data,$where);
			//--END LOG DETAIL--//
			echo json_encode($this->tmp_vnd_cert->update($data,$where));
		}
	}

	function do_update_equipments() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_equip');
		}
		else {
			$this->load->model('tmp_vnd_equip');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Update equipment)','EDIT',$this->input->ip_address());
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
			$year_made = $this->input->post('year_made');
			$data['YEAR_MADE'] = $year_made;
		}
		$temp = $this->input->post('quantity');
		if(!empty($temp)) {
			$quantity = $this->input->post('quantity');
			$data['QUANTITY'] = $quantity;
		}
		if ($this->session->userdata('STATUS') == "3") {
			$data['VND_TRAIL_ID'] = "3";
			$where = array('VENDOR_ID' => $vendor_id, 'EQUIP_ID' => $equip_id);
			echo json_encode($this->hist_vnd_equip->update($data,$where)); 
		}
		else {
			$where = array('VENDOR_ID' => $vendor_id, 'EQUIP_ID' => $equip_id);
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Technical_document/do_update_equipments','tmp_vnd_equip','update',$data,$where);
			//--END LOG DETAIL--//
			echo json_encode($this->tmp_vnd_equip->update($data,$where));
		}
	}

	function do_insert_equipments() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_equip');
		}
		else {
			$this->load->model('tmp_vnd_equip');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Input equipment)','SAVE',$this->input->ip_address());
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
		// $temp = $this->input->post('category');
		// if(!empty($temp)) {
			$category = $this->input->post('category');
			$data['CATEGORY'] = $category;
		// }
		// $temp = $this->input->post('equip_name');
		// if(!empty($temp)) {
			$equip_name = $this->input->post('equip_name');
			$data['EQUIP_NAME'] = $equip_name;
		// }
		// $temp = $this->input->post('spec');
		// if(!empty($temp)) {
			$spec = $this->input->post('spec');
			$data['SPEC'] = $spec;
		// }
		// $temp = $this->input->post('year_made');
		// if(!empty($temp)) {
			$year_made = $this->input->post('year_made');
			$data['YEAR_MADE'] = (int)$year_made;
		// }
		// $temp = $this->input->post('quantity');
		// if(!empty($temp)) {
			$quantity = $this->input->post('quantity');
			$data['QUANTITY'] = (int)$quantity;
		// }

		if ($this->session->userdata('STATUS') == "3") {
			$data['VND_TRAIL_ID'] = "3";
			echo json_encode($this->hist_vnd_equip->insert($data)); 
		}
		else {
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Technical_document/do_insert_equipments','tmp_vnd_equip','insert',$data);
			//--END LOG DETAIL--//
			echo json_encode($this->tmp_vnd_equip->insert($data));
		}
	}

	function do_update_experiences() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_cv');
		}
		else {
			$this->load->model('tmp_vnd_cv');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Update experiences)','EDIT',$this->input->ip_address());
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
			$data['VND_TRAIL_ID'] = "3";
			$where = array('VENDOR_ID' => $vendor_id, 'CV_ID' => $cv_id);
			echo json_encode($this->hist_vnd_cv->update($data,$where)); 
		}
		else {
			$where = array('VENDOR_ID' => $vendor_id, 'CV_ID' => $cv_id);
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Technical_document/do_update_experiences','tmp_vnd_cv','update',$data,$where);
			//--END LOG DETAIL--//
			echo json_encode($this->tmp_vnd_cv->update($data,$where));
		}
	}

	function do_insert_experiences() {
		if ($this->session->userdata('STATUS') == "3") {
			$this->load->model('hist_vnd_cv');
		}
		else {
			$this->load->model('tmp_vnd_cv');
		}
		$temp = $this->input->post('vendor_id');
		if (!empty($temp)) {
			$vendor_id = $this->input->post('vendor_id');
		}

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Input experiences)','SAVE',$this->input->ip_address());
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
			$data['VND_TRAIL_ID'] = "3";
			echo json_encode($this->hist_vnd_cv->insert($data)); 
		}
		else {
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Technical_document/do_insert_experiences','tmp_vnd_cv','insert',$data);
			//--END LOG DETAIL--//
			echo json_encode($this->tmp_vnd_cv->insert($data));
		}
	}

	public function do_remove_vendor_certifications($cert_id)
	{
		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Delete certifications)','Delete',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
		$this->load->model('tmp_vnd_cert');

		if ($this->tmp_vnd_cert->delete(array("CERT_ID" => $cert_id))) {
			//--LOG DETAIL--//
				$where = array("CERT_ID" => $cert_id);
				$this->log_data->detail($LM_ID,'Technical_document/do_remove_vendor_certifications','tmp_vnd_cert','delete',null,$where);
			//--END LOG DETAIL--//
			redirect(site_url('Technical_document/certification_data'));
		}
	}

	public function do_remove_vendor_product($product_id)
	{
		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Delete product)','Delete',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//
		$this->load->model('tmp_vnd_product');
		
		if ($this->tmp_vnd_product->delete(array("PRODUCT_ID" => $product_id))) {
			//--LOG DETAIL--//
				$where = array("PRODUCT_ID" => $product_id);
				$this->log_data->detail($LM_ID,'Technical_document/do_remove_vendor_product','tmp_vnd_product','delete',null,$where);
			//--END LOG DETAIL--//
			redirect('Technical_document/good_and_service_data');
		}
	}

	public function do_remove_vendor_sdm($sdm_id)
	{
		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Delete sdm)','Delete',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$this->load->model('tmp_vnd_sdm');
		
		if ($this->tmp_vnd_sdm->delete(array("SDM_ID" => $sdm_id))) {
			//--LOG DETAIL--//
				$where = array("SDM_ID" => $sdm_id);
				$this->log_data->detail($LM_ID,'Technical_document/do_remove_vendor_sdm','tmp_vnd_sdm','delete',null,$where);
			//--END LOG DETAIL--//
			redirect('Technical_document/Human_resources_data');
		}
	}

	public function do_remove_vendor_equipments($equip_id)
	{
		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Delete equipment)','Delete',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$this->load->model('tmp_vnd_equip');
		
		if ($this->tmp_vnd_equip->delete(array("EQUIP_ID" => $equip_id))) {
			//--LOG DETAIL--//
				$where = array("CERT_ID" => $cert_id);
				$this->log_data->detail($LM_ID,'Technical_document/do_remove_vendor_equipments','tmp_vnd_equip','delete',null,$where);
			//--END LOG DETAIL--//
			redirect('Technical_document/Facility_and_equipment');
		}
	}

	public function do_remove_vendor_experiences($cv_id)
	{
		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Delete experiences)','Delete',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$this->load->model('tmp_vnd_cv');
		
		if ($this->tmp_vnd_cv->delete(array("CV_ID" => $cv_id))) {
			//--LOG DETAIL--//
				$where = array("CERT_ID" => $cert_id);
				$this->log_data->detail($LM_ID,'Technical_document/do_remove_vendor_experiences','tmp_vnd_cv','delete',null,$where);
			//--END LOG DETAIL--//
			redirect('Technical_document/Company_experience');
		}
	}

	function get_product_edit(){
		$product_id = $this->input->post('product_id');
		$product_data = array();
		if(!empty($product_id)){
			$this->load->model('tmp_vnd_product');
			$product_data = $this->tmp_vnd_product->get_all(array('PRODUCT_ID'=>$product_id));
		}

		echo json_encode($product_data);

		// die(var_dump($product_data));
	}

	function get_sdm_edit(){
		$sdm_id = $this->input->post('sdm_id');
		$sdm_data = array();
		if(!empty($sdm_id)){
			$this->load->model(array('hist_vnd_sdm','tmp_vnd_sdm'));
			if ($this->session->userdata('STATUS') == "3"){
				$sdm_data = $this->hist_vnd_sdm->get_all(array('SDM_ID'=>$sdm_id, 'VND_TRAIL_ID'=>3));
			// } else if ($this->session->userdata('STATUS') == "99"){
			// 	$sdm_data = $this->hist_vnd_sdm->get_all(array('SDM_ID'=>$sdm_id, 'VND_TRAIL_ID'=>2));
			} else {
				$sdm_data = $this->tmp_vnd_sdm->get_all(array('SDM_ID'=>$sdm_id));
			}
		} else {

		}

		echo json_encode($sdm_data);
	}

	function get_certification_edit(){
		$cert_id = $this->input->post('cert_id');
		$cert_data = array();
		if(!empty($cert_id)){
			$this->load->model(array('hist_vnd_cert','tmp_vnd_cert'));
			if ($this->session->userdata('STATUS') == "3"){
				$cert_data = $this->hist_vnd_cert->get_all(array('CERT_ID'=>$cert_id, 'VND_TRAIL_ID'=>3));
			// } else if ($this->session->userdata('STATUS') == "99"){
			// 	$cert_data = $this->hist_vnd_cert->get_all(array('CERT_ID'=>$cert_id, 'VND_TRAIL_ID'=>2));
			} else {
				$cert_data = $this->tmp_vnd_cert->get_all(array('CERT_ID'=>$cert_id));
			}
		} else {
		}

		echo json_encode($cert_data);
	}

	function get_equipment_edit(){
		$equip_id = $this->input->post('equip_id');
		$equipment_data = array();
		if(!empty($equip_id)){
			$this->load->model(array('hist_vnd_equip','tmp_vnd_equip'));
			if ($this->session->userdata('STATUS') == "3"){
				$equipment_data = $this->hist_vnd_equip->get_all(array('EQUIP_ID'=>$equip_id, 'VND_TRAIL_ID'=>3));
			// } else if ($this->session->userdata('STATUS') == "99"){
			// 	$equipment_data = $this->hist_vnd_equip->get_all(array('EQUIP_ID'=>$equip_id, 'VND_TRAIL_ID'=>2));
			} else {
				$equipment_data = $this->tmp_vnd_equip->get_all(array('EQUIP_ID'=>$equip_id));
			}
		} else {

		}

		echo json_encode($equipment_data);
	}

	function get_experience_edit(){
		$cv_id = $this->input->post('cv_id');
		$experience_data = array();
		if(!empty($cv_id)){
			$this->load->model(array('hist_vnd_cv','tmp_vnd_cv'));
			if ($this->session->userdata('STATUS') == "3"){
				$experience_data = $this->hist_vnd_cv->get_all(array('CV_ID'=>$cv_id, 'VND_TRAIL_ID'=>3));
			// } else if ($this->session->userdata('STATUS') == "99"){
			// 	$experience_data = $this->hist_vnd_cv->get_all(array('CV_ID'=>$cv_id, 'VND_TRAIL_ID'=>2));
			} else {
				$experience_data = $this->tmp_vnd_cv->get_all(array('CV_ID'=>$cv_id));
			}
		} else {

		}

		echo json_encode($experience_data);
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
			exit(json_encode(array('success' => false, 'msg' => $uploader->getErrorMsg())));
		}
		echo json_encode(array('success' => true, 'newFileName' => $filename, 'upload_dir' => $upload_dir));
	}

	public function deleteFile(){
		$id = $this->input->post('id');
		$fileUpload = $this->input->post('filename');
		$this->load->model('hist_vnd_product');
		$this->load->model('tmp_vnd_product');

		//--LOG MAIN--//
			$this->log_data->main(NULL,$this->session->userdata['VENDOR_NAME'],'VENDOR','Registration (Delete file)','Delete',$this->input->ip_address());
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
			if ($this->session->userdata('STATUS') == "3") {
				$this->hist_vnd_product->update($data,$where);
			}
			else {
				$this->tmp_vnd_product->update($data,$where);
				//--LOG DETAIL--//
					$this->log_data->detail($LM_ID,'Technical_document/deleteFile','tmp_vnd_product','update',$data,$where);
				//--END LOG DETAIL--//
			}
				
		}
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

		$data=$this->m_sub_material_group->get_child($id);

		echo form_dropdown("data",$data,'','');
	}
/* Jika ambil data material dari SAP
	function pilih_child_material(){
		$id = $this->input->post('id');
		$this->load->model('m_sub_material_group');
		$data=$this->m_sub_material_group->get_child($id);
		
		$this->load->model('m_material');
		$submaterial = $this->input->post('submaterial_code');
		$material = $this->input->post('id');
		$this->load->library('sap_handler');
		$mat = $this->sap_handler->getMaterial($material, $submaterial);
		$mat_new=array();
		foreach ($mat['T_DATA'] as $val) { 
			if(ctype_upper($val['MAKTX'])) {
			    $mat_new['T_DATA'][] = $val;
			}
		} 
		echo json_encode(array('subgroup'=>$data,'mat'=>$mat_new));
	}
*/ 

} ?>