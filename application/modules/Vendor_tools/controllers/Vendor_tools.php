<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_Tools extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->model(array('vnd_header','vnd_reg_announcement'));
	}

	public function index() {
		redirect('Vendor_tools/activate_vendor');
	}

	public function activate_vendor($vendor_id = NULL) {
		$this->load->model(array());
		$data['title'] = "Aktivasi Vendor";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/vnd_tools.js'); 
		// $this->layout->add_js(base_url().'Assets/Vendor_tools/assets/vnd_tools.js', TRUE);
		$this->layout->add_css('pages/vendor_management.css');
		if (empty($vendor_id)) {
			$vendors = $this->vnd_header->get();
			$data['vendor_detail'] = $vendors;
			$this->layout->render('form_activate_vendor', $data);
		}
		else {
			$vendors = $this->vnd_header->get(array("VENDOR_ID" => $vendor_id));
			$data['vendor_detail'] = $vendors[0];
			$this->layout->render('form_detail_activate_vendor', $data);
		}
	}

	public function approve_regisration($vendor_id) {
		if (empty($vendor_id)) {
			redirect(site_url('Vendor_management/job_list'));
		}
		$this->load->model(array(
									'm_vnd_prefix',
									'm_vnd_suffix',
									'm_vnd_company_type',
									'm_vnd_country',
									'vnd_address',
									'vnd_company_type',
									'm_vnd_akta_type',
									'm_vnd_type',
									'vnd_akta',
									'vnd_board',
									'currency_model',
									'vnd_bank',
									'vnd_fin_rpt',
									'vnd_product',
									'vnd_sdm',
									'vnd_cert',
									'vnd_equip',
									'vnd_cv',
									'vnd_add',
									'vnd_doc',
									'vnd_ref_doc'
								));

		$data['prefix'] = $this->m_vnd_prefix->get();
		$data['suffix'] = $this->m_vnd_suffix->get();
		$data['company_type'] = $this->m_vnd_company_type->get();
		$data['country'] = $this->m_vnd_country->get();
		$data['akta_type'] = $this->m_vnd_akta_type->get();
		$data['vendor_type'] = $this->m_vnd_type->get();
		$data['currency'] = $this->currency_model->get_all_distinct();
		$data['ref_doc'] = $this->vnd_ref_doc->get_with_answer();

		$data['vendor_akta'] = $this->vnd_akta->get(array("VENDOR_ID" => intval($vendor_id)));
		$data['company_address'] = $this->vnd_address->get(array("VENDOR_ID" => intval($vendor_id)));
		$data['vendor_board_commissioner'] = $this->vnd_board->get(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Commissioner"));
		$data['vendor_board_director'] = $this->vnd_board->get(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Director"));
		$data['vendor_fin_report'] = $this->vnd_fin_rpt->get(array("VENDOR_ID" => intval($vendor_id)));
		$data['vendor_bank'] = $this->vnd_bank->get(array("VENDOR_ID" => intval($vendor_id)));
		$data['goods'] = $this->vnd_product->get(array("VENDOR_ID" => intval($vendor_id), "PRODUCT_TYPE" => "GOODS"));
		$data['main_sdm'] = $this->vnd_sdm->get(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "MAIN"));
		$data['support_sdm'] = $this->vnd_sdm->get(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "SUPPORT"));
		$data['certifications'] = $this->vnd_cert->get(array("VENDOR_ID" => intval($vendor_id)));
		$data['equipments'] = $this->vnd_equip->get(array("VENDOR_ID" => intval($vendor_id)));
		$data['experiences'] = $this->vnd_cv->get(array("VENDOR_ID" => intval($vendor_id)));
		$data['principals'] = $this->vnd_add->get(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Principal"));
		$data['subcontractors'] = $this->vnd_add->get(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Subcontractor"));
		$data['affiliation_companies'] = $this->vnd_add->get(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Affiliation Company"));
		$data['vnd_doc'] = $this->vnd_doc->get(array("VENDOR_ID" => intval($vendor_id)));
		$vendors = $this->vnd_header->get(array("VENDOR_ID" => intval($vendor_id)));
		$vendor_company_type = $this->vnd_company_type->get(array("VENDOR_ID" => intval($vendor_id)));

		$data['vendor_detail'] = $vendors[0];
		$this->load->model(array());
		$data['title'] = "Daftar Vendor Baru Yang Perlu Persetujuan";
		$vendors = $this->vnd_header->get(array("VENDOR_ID" => $vendor_id));
		$data['vendor_detail'] = $vendors[0];
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/vnd_tool_management_job_list.js');
		// $this->layout->add_js(base_url().'Assets/Vendor_tools/assets/vnd_management_job_list.js', TRUE);
		$this->layout->add_css('pages/vendor_management.css');
		$this->layout->render('form_approve_registration', $data);
	}

	function get_vendor_tool()
	{
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$datatable = $this->vnd_header->get('VENDOR_NO','VENDOR_NAME','CREATION_DATE','REG_ISACTIVATE',$limit,$offset);
		$recordsFiltered = $this->vnd_header->get_total_data();
		$get_total_data_without_filter = $this->vnd_header->get_total_data();

		// $datatable = $vendors = $this->vnd_header->order_by('VENDOR_ID','DESC')->fields(array('VENDOR_NO','VENDOR_NAME','CREATION_DATE','REG_ISACTIVATE'))->get_all(array('REG_ISACTIVATE' => 0));
		$data = array('data' => $datatable);
		echo json_encode($data);
	}

	function do_update_activation_data() {
		$vendor_id = $this->input->post('vendor_id');
		$reg_isactivate = $this->input->post('reg_isactivate');
		$data_update = array("REG_ISACTIVATE" => $reg_isactivate);
		$where = array("VENDOR_ID" => intval($vendor_id));
		$this->vnd_header->update($data_update, $where);
		redirect(site_url('Vendor_tools/activate_vendor'));
	}

	function save_checklist_document() {
		foreach ($this->input->post('doc_id') as $key => $value) {
			$batch_data[$key]['doc_id'] = $value;
			$batch_data[$key]['status'] = NULL;
		}
		foreach ($this->input->post('notes') as $key => $value) {
			$batch_data[$key]['notes'] = $value;
		}
		foreach ($this->input->post('status') as $key => $value) {
			$batch_data[$key]['status'] = $value;
		}
		$vendor_id = $this->input->post('vendor_id');
		$this->load->model('vnd_doc');
		$this->vnd_doc->delete(array("VENDOR_ID" => intval($vendor_id)));
		foreach ($batch_data as $key => $value) {
			$vnd_doc_id = $this->vnd_doc->get_id();
			$this->vnd_doc->insert($vnd_doc_id, $vendor_id, $value['doc_id'], $value['status'], '', $value['notes']);
		}
		echo json_encode('OK');
	}

	public function update_vendor_registration_date($company_id = NULL)
	{
		// $this->authorization->roleCheck();
		$data['title'] = "Update Vendor Registration Date";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/vnd_tools.js');
		// $this->layout->add_js(base_url().'Assets/Vendor_tools/assets/vnd_tools.js', TRUE);
		$this->layout->render('vendor_registration_date_list',$data);
	}

	function get_vendor_registration_date()
	{
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$datatable = $this->vnd_reg_announcement->get('',$limit,$offset);
		$recordsFiltered = $this->vnd_reg_announcement->get_total_data();
		$get_total_data_without_filter = $this->vnd_reg_announcement->get_total_data();
		$data = array('data' => $datatable, "recordsTotal"=> $recordsFiltered, "recordsFiltered"=> $get_total_data_without_filter);
		echo json_encode($data);
	}

}