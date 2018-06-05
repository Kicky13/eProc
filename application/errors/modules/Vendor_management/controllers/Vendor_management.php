<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_Management extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->model(array('vnd_akta', 'vnd_header'));
	}

	public function index() {
		redirect('Vendor_management/job_list');
	}

	public function job_list() {
		$this->load->model(array('tmp_vnd_header'));
		$data['title'] = "Daftar Pekerjaan";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/vnd_management_job_list.js');
		$this->layout->add_css('pages/vendor_management.css');
		$this->layout->render('form_job_list', $data);
	}

	public function fix_regis(){
		redirect('Vendor_management/job_list');
	}


	public function approve_performance($vendor_id){
		redirect('Vendor_performance_management/form_approval/'.$vendor_id);
	}

	public function approve_sanction($vendor_id){
		redirect('Vendor_sanction_management/detail_sanction/'.$vendor_id);
	}

	public function approve_regisration($vendor_id) {
		if (empty($vendor_id)) {
			redirect(site_url('Vendor_management/job_list'));
		}
		$this->load->model(array(
			'm_vnd_prefix',
			'm_vnd_suffix',
			'adm_country',
			'm_vnd_akta_type',
			'm_vnd_type',
			'm_vnd_certificate_type',
			'm_vnd_tools_category',
			'adm_curr',
			'tmp_vnd_header',
			'tmp_vnd_board',
			'tmp_vnd_product',
			'tmp_vnd_sdm',
			'tmp_vnd_add',
			'hist_vnd_header',
			'hist_vnd_board',
			'hist_vnd_product',
			'hist_vnd_sdm',
			'hist_vnd_add',
			'tmp_vnd_reg_progress',
			'adm_wilayah'
			));

		$data['prefix'] = $this->m_vnd_prefix->as_dropdown('PREFIX_NAME')->get_all();
		$data['suffix'] = $this->m_vnd_suffix->as_dropdown('SUFFIX_NAME')->get_all();
		$data['country'] = $this->adm_country->as_dropdown('COUNTRY_NAME')->get_all();
		$data['akta_type'] = $this->m_vnd_akta_type->as_dropdown('AKTA_TYPE')->get_all();
		$data['vendor_type'] = $this->m_vnd_type->as_dropdown('VENDOR_TYPE')->get_all();
		$data['currency'] = $this->adm_curr->as_dropdown('CURR_CODE')->get_all();
		$data['certificate_type'] = $this->m_vnd_certificate_type->as_dropdown('CERTIFICATE_TYPE')->get_all();
		$data['tools_category'] = $this->m_vnd_tools_category->as_dropdown('CATEGORY')->get_all();
		$vnd_temp = $this->tmp_vnd_header->get(array('VENDOR_ID'=>$vendor_id));
		if(isset($vnd_temp) && ($vnd_temp['STATUS']==1 || $vnd_temp['STATUS']==2 || $vnd_temp['STATUS']==5 || $vnd_temp['STATUS']==6 || $vnd_temp['STATUS']==7 || $vnd_temp['STATUS']==99)){
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
			->get(array("VENDOR_ID" => intval($vendor_id)));
			$data['vendor_akta'] = $vendor['akta'];
			$data['company_address'] = $vendor['address'];
			$data['vendor_board_commissioner'] = $this->tmp_vnd_board->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Commissioner"));
			$data['vendor_board_director'] = $this->tmp_vnd_board->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Director"));
			$data['vendor_fin_report'] = $vendor['fin_rpt'];
			$data['vendor_bank'] = $vendor['bank'];
			$data['goods'] = $this->tmp_vnd_product->get_all(array("VENDOR_ID" => intval($vendor_id), "PRODUCT_TYPE" => "GOODS"));
			$data['bahan'] = $this->tmp_vnd_product->get_all(array("VENDOR_ID" => intval($vendor_id), "PRODUCT_TYPE" => "BAHAN"));
			$data['services'] = $this->tmp_vnd_product->get_all(array("VENDOR_ID" => intval($vendor_id), "PRODUCT_TYPE" => "SERVICES"));
			$data['main_sdm'] = $this->tmp_vnd_sdm->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "MAIN"));
			$data['support_sdm'] = $this->tmp_vnd_sdm->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "SUPPORT"));
			$data['certifications'] = $vendor['cert'];
			$data['equipments'] = $vendor['equip'];
			$data['experiences'] = $vendor['cv'];
			$data['principals'] = $this->tmp_vnd_add->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Principal"));
			$data['subcontractors'] = $this->tmp_vnd_add->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Subcontractor"));
			$data['affiliation_companies'] = $this->tmp_vnd_add->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Affiliation Company"));
			// $data['comments'] = $this->vnd_comment->get(array("VENDOR_ID" => intval($vendor_id)));
			$data['vendor_detail'] = $vendor;

		}
		
		$vendor_progress = $this->tmp_vnd_reg_progress->get_all(array("VENDOR_ID" => intval($vendor_id)));
		if (!empty($vendor_progress)) {
			foreach ($vendor_progress as $key => $item) {
				$vendor_progress[$item['CONTAINER']]['STATUS'] = $item['STATUS'];
				$vendor_progress[$item['CONTAINER']]['REASON'] = $item['REASON'];
				unset($vendor_progress[$key]);
			}
		}
		$data['vendor_progress'] = (array) $vendor_progress;
		$data['title'] = "Daftar Vendor Baru Yang Perlu Persetujuan";
		$this->load->model(array('m_vnd_account_group', 'm_vnd_bank', 'm_vnd_reconc_acc', 'm_vnd_payment_term'));
		
		// $data['account_group'] = $this->m_vnd_account_group->get();
		// thithe nambah account group 08-11-2017
		if($this->session->userdata['EM_COMPANY']==5000){
			$company_a_g = 2000;
		} else {
			$company_a_g = $this->session->userdata['EM_COMPANY'];
		}
		$data['account_group'] = $this->m_vnd_account_group->get(array("COMPANY_ID" => intval($company_a_g)));
		// echo "<pre>";
		// echo intval($this->session->userdata['EM_COMPANY']);
		// print_r($data['account_group']);die;
		$data['bank_key'] = $this->m_vnd_bank->get();
		$data['reconc_account'] = $this->m_vnd_reconc_acc->get();
		$data['payment_term'] = $this->m_vnd_payment_term->get();

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

		$this->load->model('vendor_employe');
		$idem = $this->session->userdata['ID'];
		$data['emplo'] = $this->vendor_employe->getemplo($idem);
		
		$this->load->model('vnd_vendor_comment');
		$data['comment'] = $this->vnd_vendor_comment->where('STATUS_AKTIF','1')->order_by('ID','ASC')->get_all(array("VENDOR_ID" => intval($vendor_id)));

		$data['ven_comment'] = $this->vnd_vendor_comment->where('STATUS_AKTIF','4')->order_by('ID','ASC')->get_all(array("VENDOR_ID" => intval($vendor_id)));

		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/vnd_management_job_list.js?2');
		$this->layout->add_css('pages/vendor_management.css');
		$this->layout->render('form_approve_registration', $data);
	}

	public function approve_update_profile($vendor_id) {
		if (empty($vendor_id)) {
			redirect(site_url('Vendor_management/job_list'));
		}
		$this->load->model(array(
			'm_vnd_prefix',
			'm_vnd_suffix',
			'adm_country',
			'm_vnd_akta_type',
			'm_vnd_type',
			'm_vnd_certificate_type',
			'm_vnd_tools_category',
			'adm_curr',
			'tmp_vnd_header',
			'tmp_vnd_board',
			'tmp_vnd_product',
			'tmp_vnd_sdm',
			'tmp_vnd_add',
			'tmp_vnd_reg_progress',
			'hist_vnd_header',
			'hist_vnd_board',
			'hist_vnd_product',
			'hist_vnd_sdm',
			'hist_vnd_add',
			'vnd_update_progress',
			'adm_wilayah',

			));

		$data['prefix'] = $this->m_vnd_prefix->as_dropdown('PREFIX_NAME')->get_all();
		$data['suffix'] = $this->m_vnd_suffix->as_dropdown('SUFFIX_NAME')->get_all();
		$data['country'] = $this->adm_country->as_dropdown('COUNTRY_NAME')->get_all();
		$data['akta_type'] = $this->m_vnd_akta_type->as_dropdown('AKTA_TYPE')->get_all();
		$data['vendor_type'] = $this->m_vnd_type->as_dropdown('VENDOR_TYPE')->get_all();
		$data['currency'] = $this->adm_curr->as_dropdown('CURR_CODE')->get_all();
		$data['certificate_type'] = $this->m_vnd_certificate_type->as_dropdown('CERTIFICATE_TYPE')->get_all();
		$data['tools_category'] = $this->m_vnd_tools_category->as_dropdown('CATEGORY')->get_all();

		// Data Baru
		$vendor = $this->hist_vnd_header
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
		->get(array("VENDOR_ID" => intval($vendor_id), "VND_TRAIL_ID"=>3));
		$data['vendor_akta'] = $vendor['akta'];
		$data['company_address'] = $vendor['address'];
		$data['vendor_board_commissioner'] = $this->hist_vnd_board->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Commissioner", "VND_TRAIL_ID"=>3));
		$data['vendor_board_director'] = $this->hist_vnd_board->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Director", "VND_TRAIL_ID"=>3));
		$data['vendor_fin_report'] = $vendor['fin_rpt'];
		$data['vendor_bank'] = $vendor['bank'];
		$data['goods'] = $this->hist_vnd_product->get_all(array("VENDOR_ID" => intval($vendor_id), "PRODUCT_TYPE" => "GOODS", "VND_TRAIL_ID"=>3));
		$data['bahan'] = $this->hist_vnd_product->get_all(array("VENDOR_ID" => intval($vendor_id), "PRODUCT_TYPE" => "BAHAN", "VND_TRAIL_ID"=>3));
		$data['services'] = $this->hist_vnd_product->get_all(array("VENDOR_ID" => intval($vendor_id), "PRODUCT_TYPE" => "SERVICES", "VND_TRAIL_ID"=>3));
		$data['main_sdm'] = $this->hist_vnd_sdm->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "MAIN", "VND_TRAIL_ID"=>3));
		$data['support_sdm'] = $this->hist_vnd_sdm->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "SUPPORT", "VND_TRAIL_ID"=>3));
		$data['certifications'] = $vendor['cert'];
		$data['equipments'] = $vendor['equip'];
		$data['experiences'] = $vendor['cv'];
		$data['principals'] = $this->hist_vnd_add->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Principal", "VND_TRAIL_ID"=>3));
		$data['subcontractors'] = $this->hist_vnd_add->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Subcontractor", "VND_TRAIL_ID"=>3));
		$data['affiliation_companies'] = $this->hist_vnd_add->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Affiliation Company", "VND_TRAIL_ID"=>3));		
		$data['vendor_detail'] = $vendor;

		// Data Lama
		$this->load->model(array(	'vnd_board',
			'vnd_product',
			'vnd_sdm',
			'vnd_add'
			));
		$vendor_old = $this->vnd_header
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
		->get(array("VENDOR_ID" => intval($vendor_id)));
		$data['vendor_akta_old'] = $vendor_old['akta'];
		$data['company_address_old'] = $vendor_old['address'];
		$data['vendor_board_commissioner_old'] = $this->vnd_board->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Commissioner"));
		$data['vendor_board_director_old'] = $this->vnd_board->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Director"));
		$data['vendor_fin_report_old'] = $vendor_old['fin_rpt'];
		$data['vendor_bank_old'] = $vendor_old['bank'];
		$data['goods_old'] = $this->vnd_product->get_all(array("VENDOR_ID" => intval($vendor_id), "PRODUCT_TYPE" => "GOODS"));
		$data['bahan_old'] = $this->vnd_product->get_all(array("VENDOR_ID" => intval($vendor_id), "PRODUCT_TYPE" => "BAHAN"));
		$data['services_old'] = $this->vnd_product->get_all(array("VENDOR_ID" => intval($vendor_id), "PRODUCT_TYPE" => "SERVICES"));
		$data['main_sdm_old'] = $this->vnd_sdm->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "MAIN"));
		$data['support_sdm_old'] = $this->vnd_sdm->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "SUPPORT"));
		$data['certifications_old'] = $vendor_old['cert'];
		$data['equipments_old'] = $vendor_old['equip'];
		$data['experiences_old'] = $vendor_old['cv'];
		$data['principals_old'] = $this->vnd_add->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Principal"));
		$data['subcontractors_old'] = $this->vnd_add->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Subcontractor"));
		$data['affiliation_companies_old'] = $this->vnd_add->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Affiliation Company"));		
		$data['vendor_detail_old'] = $vendor_old;

		$vendor_progress = $this->vnd_update_progress->get_all(array("VENDOR_ID" => intval($vendor_id)));
		if (!empty($vendor_progress)) {
			foreach ($vendor_progress as $key => $item) {
				$vendor_progress[$item['CONTAINER']]['STATUS'] = $item['STATUS'];
				$vendor_progress[$item['CONTAINER']]['REASON'] = $item['REASON'];
				unset($vendor_progress[$key]);
			}
		}

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

		$this->load->model('vendor_employe');
		$idem = $this->session->userdata['ID'];
		$data['emplo'] = $this->vendor_employe->getemplo($idem);

		$this->load->model('vnd_vendor_comment');
		$data['comment'] = $this->vnd_vendor_comment->where('STATUS_AKTIF','1')->order_by('ID','ASC')->get_all(array("VENDOR_ID" => intval($vendor_id)));

		$data['ven_comment'] = $this->vnd_vendor_comment->where('STATUS_AKTIF','2')->order_by('ID','ASC')->get_all(array("VENDOR_ID" => intval($vendor_id)));

		$data['vendor_progress'] = (array) $vendor_progress;
		$data['title'] = "Daftar Vendor Baru Yang Perlu Persetujuan";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/vnd_management_job_list.js');
		$this->layout->add_css('pages/vendor_management.css');
		$this->layout->render('form_approve_update_profile', $data);
	}


/* CATATAN
status registrasi "STATUS"
	1,2 New Registrasi
	-1 Registrasi Ditolak (perencanaan)
	 7 New Registrasi Ditolak (kasi kabiro)
	99 Dikembalikan ke Vendor
	 3 Registrasi Disetujui
	 5 Approve Registrasi Kasi Perencanaan
	 6 Approve Registrasi Kabiro Perencanaan

 status perubahan "STATU_PERUBAHAN"
	 0 Vendor Telah Diupdate
	 4 Approve update profil kasi
	 5 Approve update profil kabiro
	 8 Persetujuan Update Profil
	 9 Update Data Ditolak
*/
	 function get_new_vendor_need_approval(){

	 	$this->load->model('vendor_employe');
	 	$id = $this->session->userdata['ID'];
	 	$opco = $this->session->userdata['EM_COMPANY'];
	 	$kl_opco = $this->session->userdata['KEL_PRGRP'];
	 	$data_emp = $this->vendor_employe->getemplo($id);

	 	if ($opco == '7000' || $opco == '2000' || $opco == '5000') {
	 		$whereopco = array(7000,2000,5000);
	 	} else {
	 		$whereopco = $opco;
	 	}

	 	if (!empty($data_emp)) {

	 		foreach ($data_emp as $emp) {
	 		}

		if ($emp['LEVEL'] == 1) { //supervisor
			$this->load->model(array('tmp_vnd_header', 'vnd_header','vnd_perf_tmp'));
			$data_vendor = array();
			$datatable_reg = cleanDateinArray($this->tmp_vnd_header->with_regcode()->where("STATUS",array(1, 2, 7))->where("COMPANYID",$whereopco)->get_all());
			// 99 = fix registration hide
			if(!empty($datatable_reg)){
				foreach ($datatable_reg as $key => $val) {
					array_push($data_vendor, array("VENDOR_ID"=>$val['VENDOR_ID'], "VENDOR_NAME"=>$val['VENDOR_NAME'], "STATUS"=>$val['STATUS'], "PRODUCT_TYPE_PROC"=>$val['PRODUCT_TYPE_PROC'],"UPDATED_AT"=>$val['UPDATED_AT']));
				}
			}

			$datatable_update = cleanDateinArray($this->vnd_header->where(array("STATUS"=>3))->where("STATUS_PERUBAHAN",array(2,8,9))->where("COMPANYID",$whereopco)->get_all());
			if(!empty($datatable_update)){
				foreach ($datatable_update as $key => $val) {
					array_push($data_vendor, array("VENDOR_ID"=>$val['VENDOR_ID'], "VENDOR_NAME"=>$val['VENDOR_NAME'], "STATUS"=>$val['STATUS'], "PRODUCT_TYPE_PROC"=>$val['PRODUCT_TYPE_PROC'], "UPDATED_AT"=>$val['MODIFIED_DATE']));
				}
			}

			$urutan = 1 ;
			$datatable_perf_tmp = cleanDateinArray($this->vnd_perf_tmp->list_perencanaan($urutan,$kl_opco));
			if(!empty($datatable_perf_tmp)){
				foreach ($datatable_perf_tmp as $key => $val) {
					array_push($data_vendor, array("VENDOR_ID"=>$val['VENDOR_ID'], "VENDOR_NAME"=>$val['VENDOR_NAME'], "STATUS"=>$val['STATUS_APRV'], "UPDATED_AT"=>$val['APPROVED_DATE']));
				}
			}

		}

		if ($emp['LEVEL'] == 2) { //manager
			$this->load->model(array('tmp_vnd_header', 'vnd_header','vnd_perf_tmp','vnd_perf_sanction_approve'));
			$data_vendor = array();
			$datatable_reg = cleanDateinArray($this->tmp_vnd_header->with_regcode()->where("STATUS",array(5))->where("COMPANYID", $whereopco)->get_all());

			if(!empty($datatable_reg)){
				foreach ($datatable_reg as $key => $val) {
					array_push($data_vendor, array("VENDOR_ID"=>$val['VENDOR_ID'], "VENDOR_NAME"=>$val['VENDOR_NAME'], "STATUS"=>$val['STATUS'], "PRODUCT_TYPE_PROC"=>$val['PRODUCT_TYPE_PROC'], "UPDATED_AT"=>$val['UPDATED_AT']));
				}
			}

			$datatable_update = cleanDateinArray($this->vnd_header->where(array("STATUS"=>3 ,"STATUS_PERUBAHAN"=>4))->where("COMPANYID",$whereopco)->get_all());
			if(!empty($datatable_update)){
				foreach ($datatable_update as $key => $val) {
					array_push($data_vendor, array("VENDOR_ID"=>$val['VENDOR_ID'], "VENDOR_NAME"=>$val['VENDOR_NAME'], "STATUS"=>$val['STATUS'],"PRODUCT_TYPE_PROC"=>$val['PRODUCT_TYPE_PROC'], "UPDATED_AT"=>$val['MODIFIED_DATE']));
				}
			}

			$urutan = 2 ;
			$datatable_perf_tmp = cleanDateinArray($this->vnd_perf_tmp->list_perencanaan($urutan,$kl_opco));
			if(!empty($datatable_perf_tmp)){
				foreach ($datatable_perf_tmp as $key => $val) {
					array_push($data_vendor, array("VENDOR_ID"=>$val['VENDOR_ID'], "VENDOR_NAME"=>$val['VENDOR_NAME'], "STATUS"=>$val['STATUS_APRV'], "UPDATED_AT"=>$val['APPROVED_DATE']));
				}
			}

			$datatable_perf_sanction = cleanDateinArray($this->vnd_perf_sanction_approve->list_sanction_approve($urutan,$opco));
			if(!empty($datatable_perf_sanction)){
				foreach ($datatable_perf_sanction as $key => $val) {
					array_push($data_vendor, array("VENDOR_ID"=>$val['VENDOR_NO'], "VENDOR_NAME"=>$val['VENDOR_NAME'], "STATUS"=>$val['STATUS'], "UPDATED_AT"=>$val['APPROVED_DATE']));
				}
			}
		}

		if ($emp['LEVEL'] == 3) { //senior manager
			$this->load->model(array('tmp_vnd_header', 'vnd_header','vnd_perf_tmp','vnd_perf_sanction_approve'));
			$data_vendor = array();
			$datatable_reg = cleanDateinArray($this->tmp_vnd_header->with_regcode()->where("STATUS",array(6))->where("COMPANYID",$whereopco)->get_all());

			if(!empty($datatable_reg)){
				foreach ($datatable_reg as $key => $val) {
					array_push($data_vendor, array("VENDOR_ID"=>$val['VENDOR_ID'], "VENDOR_NAME"=>$val['VENDOR_NAME'], "STATUS"=>$val['STATUS'], "PRODUCT_TYPE_PROC"=>$val['PRODUCT_TYPE_PROC'], "UPDATED_AT"=>$val['UPDATED_AT']));
				}
			}

			$datatable_update = cleanDateinArray($this->vnd_header->where(array("STATUS"=>3 ,"STATUS_PERUBAHAN"=>5))->where("COMPANYID",$whereopco)->get_all());
			if(!empty($datatable_update)){
				foreach ($datatable_update as $key => $val) {
					array_push($data_vendor, array("VENDOR_ID"=>$val['VENDOR_ID'], "VENDOR_NAME"=>$val['VENDOR_NAME'], "STATUS"=>$val['STATUS'],"PRODUCT_TYPE_PROC"=>$val['PRODUCT_TYPE_PROC'], "UPDATED_AT"=>$val['MODIFIED_DATE']));
				}
			}

			$urutan = 3;
			$datatable_perf_tmp = cleanDateinArray($this->vnd_perf_tmp->list_perencanaan($urutan,$kl_opco));
			if(!empty($datatable_perf_tmp)){
				foreach ($datatable_perf_tmp as $key => $val) {
					array_push($data_vendor, array("VENDOR_ID"=>$val['VENDOR_ID'], "VENDOR_NAME"=>$val['VENDOR_NAME'], "STATUS"=>$val['STATUS_APRV'], "UPDATED_AT"=>$val['APPROVED_DATE']));
				}
			}

			$datatable_perf_sanction = cleanDateinArray($this->vnd_perf_sanction_approve->list_sanction_approve($urutan,$opco));
			if(!empty($datatable_perf_sanction)){
				foreach ($datatable_perf_sanction as $key => $val) {
					array_push($data_vendor, array("VENDOR_ID"=>$val['VENDOR_NO'], "VENDOR_NAME"=>$val['VENDOR_NAME'], "STATUS"=>$val['STATUS'], "UPDATED_AT"=>$val['APPROVED_DATE']));
				}
			}
		}

		$data = array('data' => $data_vendor); 
		echo json_encode($data);

	} else {

		$data = array('data' => '');
		echo json_encode($data);

	}


}

function submit_approval_action(){
	$this->load->model(array('tmp_vnd_reg_progress')); 


	if($this->input->post()) {
		$data = array();
		if ($this->input->post('index') == '0') {
			$data['STATUS'] = 'Approved';
		}
		else {
			$data['STATUS'] = 'Rejected';
			$data['REASON'] = $this->input->post('reason');
		}

		$pnl_cont = $this->input->post('container');
		$status_submit = $data['STATUS']; 
			//--LOG MAIN--//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Registration ( Panel '.$pnl_cont.' )',$status_submit,$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//
		
		if (!$this->tmp_vnd_reg_progress->get(array('VENDOR_ID' => $this->input->post('vendor_id'), 'CONTAINER' => $this->input->post('container')))) {
			$data['CONTAINER'] = $this->input->post('container');
			$data['VENDOR_ID'] = $this->input->post('vendor_id');

			$this->tmp_vnd_reg_progress->insert($data);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_management/submit_approval_action','tmp_vnd_reg_progress','insert',$data);
				//--END LOG DETAIL--//
		}
		else {
			$where = array();
			$where['CONTAINER'] = $this->input->post('container');
			$where['VENDOR_ID'] = $this->input->post('vendor_id');
			$this->tmp_vnd_reg_progress->update($data, $where);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_management/submit_approval_action','tmp_vnd_reg_progress','update',$data,$where);
				//--END LOG DETAIL--//
		} 
	}
	echo json_encode($this->input->post());
}

function submit_approval_update(){
	$this->load->model(array('vnd_update_progress'));
	if($this->input->post()) {
		$data = array();
		if ($this->input->post('index') == '0') {
			$data['STATUS'] = 'Approved';
		}
		else {
			$data['STATUS'] = 'Rejected';
			$data['REASON'] = $this->input->post('reason');
		}

		$pnl_cont = $this->input->post('container');
		$status_submit = $data['STATUS']; 
			//--LOG MAIN NYO --//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Update Profil ( Panel '.$pnl_cont.' )',$status_submit,$this->input->ip_address()
			);
		$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//

		if (!$this->vnd_update_progress->get(array('VENDOR_ID' => $this->input->post('vendor_id'), 'CONTAINER' => $this->input->post('container')))) {
			$data['CONTAINER'] = $this->input->post('container');
			$data['VENDOR_ID'] = $this->input->post('vendor_id');
			$this->vnd_update_progress->insert($data);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_management/submit_approval_update','vnd_reg_progress','insert',$data);
				//--END LOG DETAIL--//
		}
		else {
			$where = array();
			$where['CONTAINER'] = $this->input->post('container');
			$where['VENDOR_ID'] = $this->input->post('vendor_id');
			$this->vnd_update_progress->update($data, $where);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_management/submit_approval_update','vnd_reg_progress','update',$data,$where);
				//--END LOG DETAIL--//
		}
			// echo json_encode($this->input->post('vendor_id'));
	}
	echo json_encode($this->input->post());
}

//-- Approve Vendor Regitrasion (CREATE VENDOR) --//
function update_approve_staff() {
	// echo "<pre>";
	// print_r($this->input->post());die;
	$this->load->model(array('tmp_vnd_header', 'adm_district', 'm_vnd_prefix', 'm_vnd_reconc_acc', 'm_vnd_account_group'));

	$vendor_id = $this->input->post('vendor_id');
	$term = $this->input->post('term');
	$comen = $this->input->post('comen');
	$account_group = $this->input->post('account_group');


	$data_insert = array();

		$data_vendor['BUKRS'] = NULL;	//Company Code  (done) contoh:2000 //disimpan di _VND_HEADER
		$data_vendor['EKORG'] = NULL;	//Purchasing Organization => query ke ADM_DISTRICT	(done) contoh: SG01 //disimpan di _VND_HEADER sebagai COMPANY_ID
		$data_vendor['KTOKK'] = NULL;	//Vendor account group //contoh: 1100 //ada di tabel M_VND_ACCOUNT_GROUP
		$data_vendor['ANRED'] = NULL;	//Title  => query ke M_VND_PREFIX	(done) contoh:PT //disimpan di _VND_HEADER sebagai primary key M_VND_PREFIX
		$data_vendor['NAME1'] = NULL;	//Name 1   (done) contoh: Majujaya (Nama Vendor) // disimpan di _VND_HEADER
		$data_vendor['STRAS'] = NULL;	//House number and street   (done) contoh:JL.SUDIRMAN // disimpan di _VND_HEADER
		$data_vendor['ORT01'] = NULL;	//City    (done) contoh:GRESIK _VND_HEADER
		$data_vendor['PSTLZ'] = NULL;	//Postal Code   (done) contoh: 61123 //disimpan _VND_HEADER
		$data_vendor['PFORT'] = NULL;	//PO Box city //contoh di SAP kosong
		$data_vendor['LAND1'] = NULL;	//Country Key  (done) contoh: ID (disimpan di tabel _VND_HEADER)
		$data_vendor['TELF1'] = NULL;	//First telephone number  (done) contoh: 86785655455	//disimpan di _VND_ADDRESS
		$data_vendor['STCD1'] = NULL;	//Tax Number 1 (NPWP tanpa pemisah)
		$data_vendor['STCEG'] = NULL;	//VAT Registration Number (NPWP dengan pemisah)
		$data_vendor['BANKS'] = NULL;	//Bank country key ()
		$data_vendor['BANKL'] = NULL;	//Bank Keys //swift_code 	(done) contoh:HSBC12920C06 // disimpan _VND_BANK jika bank luar negeri
		$data_vendor['BANKN'] = NULL;	//Bank account number   (done) contoh: 944748747874 // disimpan _VND_BANK
		$data_vendor['KOINH'] = NULL;	//Account Holder Name   (done) // disimpan _VND_BANK
		$data_vendor['BVTYP'] = NULL;	//Partner Bank Type // belum tau
		$data_vendor['AKONT'] = NULL;	//Reconciliation Account in General Ledger (ada master) // di tabel M_VND_RECONC_ACC
		$data_vendor['ZTERM'] = NULL;	//Terms of Payment Key (diisi pengadaan) //ada di tabel 
		$data_vendor['QLAND'] = NULL;	//Withholding Tax Country Key (ID) >> PPH contoh: ID 
		$data_vendor['WAERS'] = NULL;	//Purchase order currency //contoh: IDR //

		$data_vendor['TELF2'] = NULL;	//No Hp Tambahan dari tonasa
		$data_vendor['SMTP_ADDR'] = NULL;	//Email Vendor

		$data_vendor['QLAND'] = 'ID';
		$data_vendor['BVTYP'] = 'IDR1';	
		$data_vendor['BANKS'] = 'ID';
		$data_vendor['BANKL'] = 'HSBC12920C06'; //$this->input->post('bank_key');
		$data_vendor['ZTERM'] = $term;

		$tmp_vendor = $this->tmp_vnd_header->where(array('VENDOR_ID'=>intval($vendor_id)))->get();
		$vnd_id = null;
		// if ($tmp_vendor['STATUS'] == 1) {
		$this->load->model(array(
			'tmp_vnd_header',
			'm_vnd_prefix',
			'm_vnd_suffix',
			'm_vnd_country',
			'm_vnd_akta_type',
			'm_vnd_type',
			'currency_model',
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
			'tmp_vnd_add',
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
			'hist_vnd_add',
			'hist_vnd_header',
			'vnd_comment',
			'vnd_akta',
			'vnd_address',
			'vnd_board',
			'vnd_fin_rpt',
			'vnd_bank',
			'vnd_product',
			'vnd_sdm',
			'vnd_cert',
			'vnd_equip',
			'vnd_cv',
			'vnd_add',
			'vnd_header',
			'adm_wilayah'
			));

		// CREATE VENDOR NO
		$vendors = $this->tmp_vnd_header->get_all(array("VENDOR_ID" => intval($vendor_id)));
		foreach ((array)$vendors as $key => $vendor) {
			$vendor_type = $vendor["VENDOR_TYPE"];
			$data_vendor['BUKRS'] = $vendor["COMPANYID"];
			$data_vendor['STRAS'] = $vendor["ADDRESS_STREET"];
			// $data_vendor['ORT01'] = $vendor["ADDRESS_CITY"];
			$data_vendor['PSTLZ'] = $vendor["ADDRESS_POSTCODE"];
			$data_vendor['LAND1'] = $vendor["ADDRESS_COUNTRY"];
			$data_vendor['TELF2'] = $vendor["CONTACT_PHONE_HP"]; //uat tonasa
			$data_vendor['STCEG'] = $vendor["NPWP_NO"];
			$data_vendor['SMTP_ADDR'] = $vendor["EMAIL_ADDRESS"]; //uat tonasa
			$tampung_npwp = $vendor["NPWP_NO"];
			$npwp_number = preg_split('/[-.;]+/', $tampung_npwp);
			$data_vendor['STCD1'] = implode('', $npwp_number);
			$tmp_prefix = $this->m_vnd_prefix->get_all(array("PREFIX_ID"=>$vendor["PREFIX"]));
			$data_vendor['NAME1'] = $vendor["VENDOR_NAME"].".".$tmp_prefix[0]["PREFIX_NAME"];
			if ($vendor["PREFIX"] == 1 || $vendor["PREFIX"] == 2 || $vendor["PREFIX"] == 0) {
				$n_prefix = 'Company';
			} else {
				$n_prefix = $tmp_prefix[0]["PREFIX_NAME"];
			}
			$data_vendor['ANRED'] = $n_prefix;
			
			$tmp_district = $this->adm_district->get(array("COMPANY_ID"=>$vendor["COMPANYID"]));
			$data_vendor['EKORG'] = $tmp_district[0]['DISTRICT_CODE'];

			if (is_numeric($vendor["ADDRESS_CITY"])) {
				$city = $this->adm_wilayah->get(array("ID" => $vendor["ADDRESS_CITY"]));
				$nama_city = $city["NAMA"];
			} else {
				$nama_city = $vendor["ADDRESS_CITY"];
			}

			$data_vendor['ORT01'] = $nama_city;
		}


		$vendor_bank = $this->tmp_vnd_bank->get_all(array("VENDOR_ID" => intval($vendor_id)));
		foreach ((array)$vendor_bank as $key => $bank) {
			$bank['VENDOR_ID'] = $vnd_id;
			$data_vendor["BANKN"] = $bank["ACCOUNT_NO"];
			$data_vendor["KOINH"] = $bank["ACCOUNT_NAME"]; 
			$data_vendor['WAERS'] = $bank['CURRENCY']; 
		}

		$company_address = $this->tmp_vnd_address->get_all(array("VENDOR_ID" => intval($vendor_id)));
		foreach ((array)$company_address as $key => $address) {
			$data_vendor['TELF1'] = $address["TELEPHONE1_NO"];
			$data_vendor['TELFX'] = $address["FAX"]; //uat tonasa

		}

		$where_m_vnd_account_group = array('COMPANY_ID'=>$data_vendor['BUKRS'], 'VENDOR_TYPE'=>$vendor_type);
		$tmp_accgroup = $this->m_vnd_account_group->get($where_m_vnd_account_group);
		// $data_vendor['KTOKK'] = $tmp_accgroup[0]['GROUP'];
		$data_vendor['KTOKK'] = $account_group;

		$tmp_reconc = $this->m_vnd_reconc_acc->get(array('VENDOR_TYPE'=>$vendor_type));
		$data_vendor['AKONT'] = $tmp_reconc[0]['GL_ACCOUNT'];

		// var_dump($data_vendor);
		$this->load->library('sap_handler');
		$param_sap = $data_vendor;
		$return_sap = $this->sap_handler->createVendor($data_vendor);
		// echo "<pre>";
		// print_r($return_sap);
		// die(var_dump($return_sap));
		
		$vendor_data = array('VENDOR_NO'=>$return_sap['MESSTAB'][0]['MSGV1']);
		$insert_success = false;

		if (is_numeric($return_sap['MESSTAB'][0]['MSGV1'])) {
			$vendor_data['VENDOR_NO'] = $return_sap['MESSTAB'][0]['MSGV1'];

				// Insert Vendor
			$vendors = $this->tmp_vnd_header->get_all(array("VENDOR_ID" => intval($vendor_id)));
			foreach ((array)$vendors as $key => $vendor) {
				$vendor_type = $vendor["VENDOR_TYPE"];

				unset($vendor["VENDOR_EDIT_ID"]);
				unset($vendor["VENDOR_ID"]);
				foreach ($vendor as $key => $value) {
					if (empty($value)) {
						unset($vendor[$key]);
					}
				}
				$vnd_id = $this->vnd_header->get_last_id();
				$vnd_id = $vnd_id + 1;
				$vendor["VENDOR_ID"] = $vnd_id;
				$this->vnd_header->insert($vendor);
				$vendor["VND_TRAIL_ID"] = 3;
				$this->hist_vnd_header->insert($vendor);

				$this->vnd_header->update(array("STATUS" => '3', "NEXT_PAGE" => "Registrasi Disetujui"),array("VENDOR_ID" => intval($vnd_id)));
				$this->hist_vnd_header->update(array("STATUS" => '3', "NEXT_PAGE" => "Registrasi Disetujui"),array("VENDOR_ID" => intval($vnd_id)));
			}

				//--LOG MAIN NYO --//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Registration ( Approve Kabiro ) Create Vendor','APPROVE',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
				//--END LOG MAIN--//


				//--LOG DETAIL--//
			$dt_vn['VENDOR_ID'] = $vnd_id;
			$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','vnd_header','insert',$dt_vn);
			$dt_vn["VND_TRAIL_ID"] = 3;

			$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','hist_vnd_header','insert',$dt_vn);

			$data['STATUS'] = '3';
			$data['NEXT_PAGE'] = 'Registrasi Disetujui';
			$where['VENDOR_ID'] = intval($vnd_id);
			$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','vnd_header','update',$data,$where);
			$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','hist_vnd_header','update',$data,$where);
				//--END LOG DETAIL--//

				// Insert Akta
			$vendor_akta = $this->tmp_vnd_akta->get_all(array("VENDOR_ID" => intval($vendor_id)));
			foreach ((array)$vendor_akta as $key => $akta) {
				unset($akta["AKTA_ID"]);
				unset($akta["STATUS"]);
				$akta['VENDOR_ID'] = $vnd_id;
				$this->vnd_akta->insert($akta);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','vnd_akta','insert',$akta);
					//--END LOG DETAIL--//
				$akta["VND_TRAIL_ID"] = 3;
				$this->hist_vnd_akta->insert($akta);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','hist_vnd_akta','insert',$akta);
					//--END LOG DETAIL--//
			}
				// Insert Address
			$company_address = $this->tmp_vnd_address->get_all(array("VENDOR_ID" => intval($vendor_id)));
			foreach ((array)$company_address as $key => $address) {
				$address['TELF1'] = $address["TELEPHONE1_NO"];
				$address['VENDOR_ID'] = $vnd_id;
				unset($address["STATUS"]);
				unset($address["ADDRESS_ID"]);
				$this->vnd_address->insert($address);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','vnd_address','insert',$address);
					//--END LOG DETAIL--//
				$address['VND_TRAIL_ID'] = 3;
				$this->hist_vnd_address->insert($address);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','hist_vnd_address','insert',$address);
					//--END LOG DETAIL--//
			}
				// Insert Commissioner|
			$vendor_board_commissioner = $this->tmp_vnd_board->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Commissioner"));
			foreach ((array)$vendor_board_commissioner as $key => $board) {
				$board['VENDOR_ID'] = $vnd_id;
				unset($board["STATUS"]);
				unset($board["BOARD_ID"]);
				$this->vnd_board->insert($board);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','vnd_board','insert',$board);
					//--END LOG DETAIL--//
				$board['VND_TRAIL_ID'] = 3;
				$this->hist_vnd_board->insert($board);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','hist_vnd_board','insert',$board);
					//--END LOG DETAIL--//
			}
				// Insert Director
			$vendor_board_director = $this->tmp_vnd_board->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Director"));
			foreach ((array)$vendor_board_director as $key => $board) {
				$board['VENDOR_ID'] = $vnd_id;
				unset($board["STATUS"]);
				unset($board["BOARD_ID"]);
				$this->vnd_board->insert($board);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','vnd_board','insert',$board);
					//--END LOG DETAIL--//
				$board['VND_TRAIL_ID'] = 3;
				$this->hist_vnd_board->insert($board);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','hist_vnd_board','insert',$board);
					//--END LOG DETAIL--//
			}
				// Insert Financial Report
			$vendor_fin_report = $this->tmp_vnd_fin_rpt->get_all(array("VENDOR_ID" => intval($vendor_id)));
			foreach ((array)$vendor_fin_report as $key => $report) {
				$report['VENDOR_ID'] = $vnd_id;
				unset($report["STATUS"]);
				unset($report["FIN_RPT_ID"]);
				$this->vnd_fin_rpt->insert($report);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','vnd_fin_rpt','insert',$report);
					//--END LOG DETAIL--//
				$report['VND_TRAIL_ID'] = 3;
				$this->hist_vnd_fin_rpt->insert($report);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','hist_vnd_fin_rpt','insert',$report);
					//--END LOG DETAIL--//
			}
				// Insert Bank
			$vendor_bank = $this->tmp_vnd_bank->get_all(array("VENDOR_ID" => intval($vendor_id)));
			foreach ((array)$vendor_bank as $key => $bank) {
				$bank['VENDOR_ID'] = $vnd_id;
					// $data_vendor["BANKN"] = $bank["ACCOUNT_NO"];
					// $data_vendor["KOINH"] = $bank["ACCOUNT_NAME"]; 
					// $data_vendor['WAERS'] = $bank['CURRENCY'];
				unset($bank["STATUS"]);
				unset($bank["BANK_ID"]);
				$this->vnd_bank->insert($bank);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','vnd_bank','insert',$bank);
					//--END LOG DETAIL--//
				$bank['VND_TRAIL_ID'] = 3;
				$this->hist_vnd_bank->insert($bank);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','hist_vnd_bank','insert',$bank);
					//--END LOG DETAIL--//
			}
				// Insert Goods
			$goods = $this->tmp_vnd_product->get_all(array("VENDOR_ID" => intval($vendor_id), "PRODUCT_TYPE" => "GOODS"));
			foreach ((array)$goods as $key => $good) {
				unset($good["STATUS"]);
				unset($good["PRODUCT_ID"]);
				$good['VENDOR_ID'] = $vnd_id;
				$this->vnd_product->insert($good);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','vnd_product','insert',$good);
					//--END LOG DETAIL--//
				$good['VND_TRAIL_ID'] = 3;
				$this->hist_vnd_product->insert($good);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','hist_vnd_product','insert',$good);
					//--END LOG DETAIL--//
			}
				// Insert Services
			$services = $this->tmp_vnd_product->get_all(array("VENDOR_ID" => intval($vendor_id), "PRODUCT_TYPE" => "SERVICES"));
			foreach ((array)$services as $key => $service) {
				unset($service["STATUS"]);
				unset($service["PRODUCT_ID"]);
				$service['VENDOR_ID'] = $vnd_id;
				$this->vnd_product->insert($service);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','vnd_product','insert',$service);
					//--END LOG DETAIL--//
				$service['VND_TRAIL_ID'] = 3;
				$this->hist_vnd_product->insert($service);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','hist_vnd_product','insert',$service);
					//--END LOG DETAIL--//
			}
				// Insert SDM
			$main_sdm = $this->tmp_vnd_sdm->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "MAIN"));
			foreach ((array)$main_sdm as $key => $sdm) {
				$sdm['VENDOR_ID'] = $vnd_id;
				unset($sdm["STATUS"]);
				unset($sdm["SDM_ID"]);
				$this->vnd_sdm->insert($sdm);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','vnd_sdm','insert',$sdm);
					//--END LOG DETAIL--//
				$sdm['VND_TRAIL_ID'] = 3;
				$this->hist_vnd_sdm->insert($sdm);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','hist_vnd_sdm','insert',$sdm);
					//--END LOG DETAIL--//
			}
			$main_sdm = $this->tmp_vnd_sdm->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "SUPPORT"));
			foreach ((array)$main_sdm as $key => $sdm) {
				$sdm['VENDOR_ID'] = $vnd_id;
				unset($sdm["STATUS"]);
				unset($sdm["SDM_ID"]);
				$this->vnd_sdm->insert($sdm);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','vnd_sdm','insert',$sdm);
					//--END LOG DETAIL--//
				$sdm['VND_TRAIL_ID'] = 3;
				$this->hist_vnd_sdm->insert($sdm);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','hist_vnd_sdm','insert',$sdm);
					//--END LOG DETAIL--//
			}
				// Insert Certifications
			$certifications = $this->tmp_vnd_cert->get_all(array("VENDOR_ID" => intval($vendor_id)));
			foreach ((array)$certifications as $key => $certification) {
				unset($certification["STATUS"]);
				unset($certification["CERT_ID"]);
				$certification['VENDOR_ID'] = $vnd_id;
				$this->vnd_cert->insert($certification);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','vnd_cert','insert',$certification);
					//--END LOG DETAIL--//
				$certification['VND_TRAIL_ID'] = 3;
				$this->hist_vnd_cert->insert($certification);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','hist_vnd_cert','insert',$certification);
					//--END LOG DETAIL--//
			}
				// Insert Equipment
			$equipments = $this->tmp_vnd_equip->get_all(array("VENDOR_ID" => intval($vendor_id)));
			foreach ((array)$equipments as $key => $equipment) {
				$equipment['VENDOR_ID'] = $vnd_id;
				unset($equipment["STATUS"]);
				unset($equipment["EQUIP_ID"]);
				$this->vnd_equip->insert($equipment);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','vnd_equip','insert',$equipment);
					//--END LOG DETAIL--//
				$equipment['VND_TRAIL_ID'] = 3;
				$this->hist_vnd_equip->insert($equipment);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','hist_vnd_equip','insert',$equipment);
					//--END LOG DETAIL--//
			}
				// Insert Experiences
			$experiences = $this->tmp_vnd_cv->get_all(array("VENDOR_ID" => intval($vendor_id)));
			foreach ((array)$experiences as $key => $experience) {
				unset($experience["STATUS"]);
				unset($experience["CV_ID"]);
				$experience['VENDOR_ID'] = $vnd_id;
				$this->vnd_cv->insert($experience);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','vnd_cv','insert',$experience);
					//--END LOG DETAIL--//
				$experience['VND_TRAIL_ID'] = 3;
				$this->hist_vnd_cv->insert($experience);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','hist_vnd_cv','insert',$experience);
					//--END LOG DETAIL--//
			}
				// Insert Principal
			$principals = $this->tmp_vnd_add->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Principal"));
			foreach ((array)$principals as $key => $principal) {
				$principal['VENDOR_ID'] = $vnd_id;
				unset($principal["STATUS"]);
				unset($principal["ADD_ID"]);
				$this->vnd_add->insert($principal);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','vnd_add','insert',$principal);
					//--END LOG DETAIL--//
				$principal['VND_TRAIL_ID'] = 3;
				$this->hist_vnd_add->insert($principal);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','hist_vnd_add','insert',$principal);
					//--END LOG DETAIL--//
			}
				// Insert Subcontractor
			$subcontractors = $this->tmp_vnd_add->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Subcontractor"));
			foreach ((array)$subcontractors as $key => $subcontractor) {
				$subcontractor['VENDOR_ID'] = $vnd_id;
				unset($subcontractor["STATUS"]);
				unset($subcontractor["ADD_ID"]);
				$this->vnd_add->insert($subcontractor);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','vnd_add','insert',$subcontractor);
					//--END LOG DETAIL--//
				$subcontractor['VND_TRAIL_ID'] = 3;
				$this->hist_vnd_add->insert($subcontractor);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','hist_vnd_add','insert',$subcontractor);
					//--END LOG DETAIL--//
			}
				// Insert Affiliation Company
			$affiliation_companies = $this->tmp_vnd_add->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Affiliation Company"));
			foreach ((array)$affiliation_companies as $key => $affiliation_company) {
				$affiliation_company['VENDOR_ID'] = $vnd_id;
				unset($affiliation_company["STATUS"]);
				unset($affiliation_company["ADD_ID"]);
				$this->vnd_add->insert($affiliation_company);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','vnd_add','insert',$affiliation_company);
					//--END LOG DETAIL--//
				$affiliation_company['VND_TRAIL_ID'] = 3;
				$this->hist_vnd_add->insert($affiliation_company);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','hist_vnd_add','insert',$affiliation_company);
					//--END LOG DETAIL--//
			} 

			$this->vnd_header->update($vendor_data, array('VENDOR_ID'=>$vnd_id)); // insert vendor no KE VND_HEADER
			$this->hist_vnd_header->update($vendor_data, array('VENDOR_ID'=>$vnd_id)); // insert vendor no KE HIS_VND_HEADER
			//--LOG DETAIL--//
			$where['VENDOR_ID'] = $vnd_id;
			$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','vnd_header','update',$vendor_data,$where);
			$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','hist_vnd_header','update',$vendor_data,$where);
			//--END LOG DETAIL--//

			$insert_success = true;
			$data_vnd_header = $this->vnd_header->get(array('VENDOR_ID'=>$vnd_id));
			$data_vnd_bank = $this->vnd_bank->get(array('VENDOR_ID'=>$vnd_id));
			
			$this->load->library('email');
			$this->config->load('email');
			$semenindonesia = $this->config->item('semenindonesia'); 
			$this->email->initialize($semenindonesia['conf']);
			$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
			$this->email->to($data_vnd_header['EMAIL_ADDRESS']);
			$this->email->cc('pengadaan.semenindonesia@gmail.com');				
			$data['vendorno'] = $return_sap['MESSTAB'][0]['MSGV1'];
			$data['username'] = $data_vnd_header['LOGIN_ID'];
			$data['vendorname'] = $data_vnd_header['VENDOR_NAME'];
			$data['email'] = $data_vnd_header['EMAIL_ADDRESS'];
			$data['akutansi'] = false;
			$opco = $data_vnd_header['COMPANYID'];

			$this->email->subject("Registration Approved for eProcurement ".$this->session->userdata['COMPANYNAME']."");

			$content = $this->load->view('email/success_approve_vendor',$data,TRUE);
			$this->email->message($content);
			$this->email->send();

			/* Email Untuk Pihak Akutansi */
			$this->email->initialize($semenindonesia['conf']);
			$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
			$this->email->to($this->session->userdata['EMAIL_COMPANY']);

			$data['vendorno'] = $return_sap['MESSTAB'][0]['MSGV1'];
			$data['vendorname'] = $data_vnd_header['VENDOR_NAME'];
			$data['email'] = $data_vnd_header['EMAIL_ADDRESS'];
			$data['company'] = $data_vnd_header['COMPANYID'];
			$data['street'] = $data_vnd_header['ADDRESS_STREET'];
			$data['city'] = $data_vnd_header['ADDRESS_CITY'];
			$data['country'] = $data_vnd_header['ADDRESS_COUNTRY'];
			$data['postcode'] = $data_vnd_header['ADDRESS_POSTCODE'];
			$data['npwp'] = $data_vnd_header['NPWP_NO'];
			$data['account_name'] = $data_vnd_bank[0]['ACCOUNT_NAME'];
			$data['account_no'] = $data_vnd_bank[0]['ACCOUNT_NO'];
			$data['currency'] = $data_vnd_bank[0]['CURRENCY'];
			$data['telp'] = $data_vnd_header['CONTACT_PHONE_NO'];
			$data['no_hp'] = $data_vnd_header['CONTACT_PHONE_HP'];
			$data['akutansi'] = true;

			$this->email->subject("Registration Approved for eProcurement ".$this->session->userdata['COMPANYNAME']." ");

			$content = $this->load->view('email/success_approve_vendor',$data,TRUE);
			$this->email->message($content);
			$this->email->send();
			/* End Email */ 

			if ($insert_success) {
				$this->tmp_vnd_address->delete(array("VENDOR_ID" => intval($vendor_id)));
				$this->tmp_vnd_akta->delete(array("VENDOR_ID" => intval($vendor_id)));
				$this->tmp_vnd_board->delete(array("VENDOR_ID" => intval($vendor_id)));
				$this->tmp_vnd_bank->delete(array("VENDOR_ID" => intval($vendor_id)));
				$this->tmp_vnd_fin_rpt->delete(array("VENDOR_ID" => intval($vendor_id)));
				$this->tmp_vnd_product->delete(array("VENDOR_ID" => intval($vendor_id)));
				$this->tmp_vnd_sdm->delete(array("VENDOR_ID" => intval($vendor_id)));
				$this->tmp_vnd_cert->delete(array("VENDOR_ID" => intval($vendor_id)));
				$this->tmp_vnd_equip->delete(array("VENDOR_ID" => intval($vendor_id)));
				$this->tmp_vnd_cv->delete(array("VENDOR_ID" => intval($vendor_id)));
				$this->tmp_vnd_add->delete(array("VENDOR_ID" => intval($vendor_id)));
				$this->tmp_vnd_header->delete(array("VENDOR_ID" => intval($vendor_id)));

				//--LOG DETAIL--//
				$where['VENDOR_ID'] = intval($vendor_id);
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','tmp_vnd_address','delete',null,$where);
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','tmp_vnd_akta','delete',null,$where);
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','tmp_vnd_board','delete',null,$where);
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','tmp_vnd_bank','delete',null,$where);
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','tmp_vnd_fin_rpt','delete',null,$where);
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','tmp_vnd_product','delete',null,$where);
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','tmp_vnd_sdm','delete',null,$where);
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','tmp_vnd_cert','delete',null,$where);
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','tmp_vnd_equip','delete',null,$where);
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','tmp_vnd_cv','delete',null,$where);
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','tmp_vnd_add','delete',null,$where);
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','tmp_vnd_header','delete',null,$where);
				//--END LOG DETAIL--//

				$this->load->model('vnd_vendor_comment');
				$this->vnd_vendor_comment->update(array('STATUS_AKTIF' => 0),array('STATUS_AKTIF' => '1', 'VENDOR_ID' => intval($vendor_id)));
				$this->vnd_vendor_comment->update(array('STATUS_AKTIF' => 5),array('STATUS_AKTIF' => '4', 'VENDOR_ID' => intval($vendor_id)));

				//--LOG DETAIL--//
				$where['VENDOR_ID'] = intval($vendor_id);
				$where['STATUS_AKTIF'] = '1';
				$set['STATUS_AKTIF'] = '0';
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','vnd_vendor_comment','update',$set,$where);
				$where1['VENDOR_ID'] = intval($vendor_id);
				$where1['STATUS_AKTIF'] = '4';
				$set1['STATUS_AKTIF'] = '5';
				$this->log_data->detail($LM_ID,'Vendor_management/update_approve_staff','vnd_vendor_comment','update',$set1,$where1);
				//--END LOG DETAIL--//
			}
			echo json_encode('OK');
		} else {
			var_dump($return_sap['MESSTAB'][0]['MSGV1']);die;
		}

	}

//--Reject Vendor Registrasi Perencanaan--//
	function reject_vendor() {
		$this->load->model('tmp_vnd_header');
		$this->load->model('vendor_employe');
		$this->load->model('vnd_vendor_comment');
		$vendor_id = $this->input->post('vendor_id');

		$comen = $this->input->post('comment');
		$idem = $this->session->userdata['ID'];
		$employ = $this->vendor_employe->getemplo($idem);
		$nama_emp = $this->vendor_employe->get_nama_emplo($employ[0]['EMP_ID']);

		$opco = $this->session->userdata['EM_COMPANY'];
		if ($opco == '7000' || $opco == '2000' || $opco == '5000') {
			$whereopco = '7000,2000,5000';
		} else {
			$whereopco = $opco;
		}

		$atasan = $this->vendor_employe->get_all($whereopco);

		$data_email = array();
		foreach ($atasan as $key => $value) {
			if ($value['LEVEL'] != 1) {
				$data_email[] = $value['EMAIL'];
			}
		}
		$email_proc = implode(",", $data_email);

		$this->tmp_vnd_header->update(array("STATUS" => '-1', "NEXT_PAGE" => "Registrasi Ditolak"),array("VENDOR_ID" => intval($vendor_id)));

		$cmt["VENDOR_ID"] = $vendor_id;
		$cmt["COMMENT"] = $comen;
		$cmt["EMP_ID"] = $employ[0]['EMP_ID'];
		$cmt["EMP_NAMA"] = $nama_emp[0]['FULLNAME'];
		$cmt["STATUS_AKTIF"] = '-1';
		$this->vnd_vendor_comment->insert($cmt);

		$tmp_header = $this->tmp_vnd_header->get(array('VENDOR_ID'=>intval($vendor_id)));

		$this->load->library('email');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		
		$subjek = "Reject Registration Vendor eProcurement ".$this->session->userdata['COMPANYNAME']."";

		$data['vendorname'] = $tmp_header['VENDOR_NAME'];
		$data['email'] = $tmp_header['EMAIL_ADDRESS'];
		$data['note'] = $comen;

		/* Kirim email ke vendor */
		$this->email->to($tmp_header['EMAIL_ADDRESS']);
		$this->email->cc('pengadaan.semenindonesia@gmail.com');
		$this->email->subject($subjek);
		$content = $this->load->view('email/reject_registration_vendor',$data,TRUE);
		$this->email->message($content);
		$this->email->send();

		/* Kirim email ke kasi dan kabiro */
		$this->email->to($email_proc);
		$this->email->cc('pengadaan.semenindonesia@gmail.com');
		$this->email->subject($subjek);
		$content = $this->load->view('email/reject_registration_vendor',$data,TRUE);
		$this->email->message($content);
		$this->email->send();

		//--LOG MAIN NYO --//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Registration Rejected','REJECT',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		//--LOG DETAIL--//
		$where['VENDOR_ID'] = $vendor_id;
		$data['STATUS'] = '-1';
		$data['NEXT_PAGE'] = 'Registrasi Ditolak';
		$this->log_data->detail($LM_ID,'Vendor_management/reject_vendor','tmp_vnd_header','update',$data,$where);
			//--END LOG DETAIL--//
		echo json_encode('OK');
	}

//--Reject Vendor Registrasi dari Kasi atau Kabiro--//
	/* Setelah direject kasi atau kabiro, data vendor dikembalikan ke bagian perencanaan */
	function reject_vendor_registrasi() {
		$this->load->model('tmp_vnd_header');
		$this->load->model('vendor_employe');
		$this->load->model('vnd_vendor_comment');
		$vendor_id = $this->input->post('vendor_id');

		$comen = $this->input->post('comment');
		$idem = $this->session->userdata['ID'];
		$employ = $this->vendor_employe->getemplo($idem);
		$nama_emp = $this->vendor_employe->get_nama_emplo($employ[0]['EMP_ID']);

		if (!empty($vendor_id)) {
			$ven = $vendor_id;

		//--LOG MAIN NYO --//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Registration ( Reject Vendor )','REJECT',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//


			$this->tmp_vnd_header->update(array("STATUS" => '7', "NEXT_PAGE" => "New Registrasi Ditolak"),array("VENDOR_ID" => intval($ven)));	

				//--LOG DETAIL--//
			$where['VENDOR_ID'] = $ven;
			$data['STATUS'] = '7';
			$data['NEXT_PAGE'] = 'New Registrasi Ditolak';
			$this->log_data->detail($LM_ID,'Vendor_management/reject_vendor_registrasi','tmp_vnd_header','update',$data,$where);
				//--END LOG DETAIL--//

			$cmt["VENDOR_ID"] = intval($ven);
			$cmt["COMMENT"] = $comen;
			$cmt["EMP_ID"] = $employ[0]['EMP_ID'];
			$cmt["EMP_NAMA"] = $nama_emp[0]['FULLNAME'];
			$cmt["STATUS_AKTIF"] = '1';
			if ($employ[0]['LEVEL'] == 2) {
				$cmt["STATUS_ACTIVITY"] = "Registrasi Approval Kasi";
			}elseif ($employ[0]['LEVEL'] == 3) { 
				$cmt["STATUS_ACTIVITY"] = "Registrasi Approval Kabiro";
			}

			$this->vnd_vendor_comment->insert($cmt);

					//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_management/reject_vendor_registrasi','vnd_vendor_comment','insert',$cmt);
					//--END LOG DETAIL--//
		}
		echo json_encode('OK');	
	}

//-- Route To Vendor ( Data dikembalikan ke vendor untuk dilakukan revisi ) --//
	function route_to_vendor() {
		$this->load->model('tmp_vnd_header');
		$this->load->model('vendor_employe');
		$this->load->model('vnd_vendor_comment');

		$vendor_id = $this->input->post('vendor_id');

		$tmp_header = $this->tmp_vnd_header->get(array('VENDOR_ID'=>$vendor_id));

		$this->load->library('email');
		$this->config->load('email'); 
		$semenindonesia = $this->config->item('semenindonesia'); 
		$this->email->initialize($semenindonesia['conf']);
		$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
		$this->email->to($tmp_header['EMAIL_ADDRESS']);
		$this->email->cc('pengadaan.semenindonesia@gmail.com');

		$this->email->subject("Revisi Registrasi Vendor eProcurement ".$this->session->userdata['COMPANYNAME']."");

		$content = $this->load->view('email/route-to-vendor',array(),TRUE);
		$this->email->message($content);
		$this->email->send();

		//--LOG MAIN NYO --//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Registration ( Route To Vendor )','ROUTE TO VENDOR',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$this->tmp_vnd_header->update(array("STATUS" => '99', "NEXT_PAGE" => "Dikembalikan ke Vendor"),array("VENDOR_ID" => intval($vendor_id)));

		//--LOG DETAIL--//
		$where['VENDOR_ID'] = $vendor_id;
		$data['STATUS'] = '99';
		$data['NEXT_PAGE'] = 'Dikembalikan ke Vendor';
		$this->log_data->detail($LM_ID,'Vendor_management/route_to_vendor','tmp_vnd_header','update',$data,$where);
		//--END LOG DETAIL--//

		$comen = $this->input->post('comment');
		$idem = $this->session->userdata['ID'];
		$employ = $this->vendor_employe->getemplo($idem);
		$nama_emp = $this->vendor_employe->get_nama_emplo($employ[0]['EMP_ID']);

		$cmt["VENDOR_ID"] = intval($vendor_id);
		$cmt["COMMENT"] = $comen;
		$cmt["EMP_ID"] = $employ[0]['EMP_ID'];
		$cmt["EMP_NAMA"] = $nama_emp[0]['FULLNAME'];
		$cmt["STATUS_AKTIF"] = '1'; 
		$cmt["STATUS_ACTIVITY"] = "Road To Vendor Registrasi"; 

		$this->vnd_vendor_comment->insert($cmt);
		//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Vendor_management/route_to_vendor','vnd_vendor_comment','insert',$cmt);
		//--END LOG DETAIL--//

		$vendor_comen = $this->input->post('vendor');
		$cmmt["VENDOR_ID"] = intval($vendor_id);
		$cmmt["COMMENT"] = $vendor_comen;
		$cmmt["EMP_ID"] = $employ[0]['EMP_ID'];
		$cmmt["EMP_NAMA"] = $nama_emp[0]['FULLNAME'];
		$cmmt["STATUS_AKTIF"] = '4'; 
		$cmmt["STATUS_ACTIVITY"] = "Procurement Comment"; 

		$this->vnd_vendor_comment->insert($cmmt);

		//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Vendor_management/route_to_vendor','vnd_vendor_comment','insert',$cmmt);
		//--END LOG DETAIL--//

		echo json_encode('OK');
	}

	function route_to_vendor_update() {
		$this->load->model('vnd_header');
		$this->load->model('vendor_employe');
		$vendor_id = $this->input->post('vendor_id');

		$vnd_header = $this->vnd_header->get(array('VENDOR_ID'=>$vendor_id));

		if ($vnd_header != '') {
			$this->load->library('email');
			$this->config->load('email'); 
			$semenindonesia = $this->config->item('semenindonesia'); 
			$this->email->initialize($semenindonesia['conf']);
			$this->email->from($semenindonesia['credential'][0],$semenindonesia['credential'][1]);
			$this->email->to($vnd_header['EMAIL_ADDRESS']);
			$this->email->cc('pengadaan.semenindonesia@gmail.com');
			
			$this->email->subject("Revisi Update Vendor eProcurement ".$this->session->userdata['COMPANYNAME']." ");		
			$content = $this->load->view('email/route-to-vendor-update',array(),TRUE);
			$this->email->message($content);
			$this->email->send();
		}

		//--LOG MAIN NYO --//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Update Profile ( Route To Vendor )','ROUTE TO VENDOR',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$this->vnd_header->update(array('STATUS_PERUBAHAN' => 10), array('VENDOR_ID' => $vendor_id));

		//--LOG DETAIL--//
		$where['VENDOR_ID'] = $vendor_id;
		$data['STATUS_PERUBAHAN'] = '10';
		$this->log_data->detail($LM_ID,'Vendor_management/route_to_vendor_update','vnd_header','update',$data,$where);
		//--END LOG DETAIL--//

		$this->load->model('vnd_vendor_comment');
		$comen = $this->input->post('comment');
		$idem = $this->session->userdata['ID'];
		$employ = $this->vendor_employe->getemplo($idem);
		$nama_emp = $this->vendor_employe->get_nama_emplo($employ[0]['EMP_ID']);

		$cmt["VENDOR_ID"] = $vendor_id;
		$cmt["COMMENT"] = $comen;
		$cmt["EMP_ID"] = $employ[0]['EMP_ID'];
		$cmt["EMP_NAMA"] = $nama_emp[0]['FULLNAME'];
		$cmt["STATUS_AKTIF"] = '1'; 
		$cmt["STATUS_ACTIVITY"] = "Road To Vendor Update"; 

		$this->vnd_vendor_comment->insert($cmt);
		//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Vendor_management/route_to_vendor_update','vnd_vendor_comment','insert',$cmt);
		//--END LOG DETAIL--//

		$vendor_comen = $this->input->post('vendor');
		$cmmt["VENDOR_ID"] = $vendor_id;
		$cmmt["COMMENT"] = $vendor_comen;
		$cmmt["EMP_ID"] = $employ[0]['EMP_ID'];
		$cmmt["EMP_NAMA"] = $nama_emp[0]['FULLNAME'];
		$cmmt["STATUS_AKTIF"] = '2'; 
		$cmmt["STATUS_ACTIVITY"] = "Procurement Comment"; 

		$this->vnd_vendor_comment->insert($cmmt);
		//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Vendor_management/route_to_vendor_update','vnd_vendor_comment','insert',$cmmt);
		//--END LOG DETAIL--//

		echo json_encode('OK');
	}

//-- Approve update profile vendor oleh kabiro --//
	function accept_vendor_update() {
		$this->load->model(array(
			'tmp_vnd_header',
			'm_vnd_prefix',
			'm_vnd_suffix',
			'm_vnd_country',
			'm_vnd_akta_type',
			'm_vnd_type',
			'currency_model',
			'vnd_comment',
			'hist_vnd_akta',
			'hist_vnd_address',
			'hist_vnd_board',
			'hist_vnd_fin_rpt',
			'hist_vnd_bank',
			'hist_vnd_product',
			'hist_vnd_sdm',
			'hist_vnd_cert',
			'hist_vnd_equip',
			'hist_vnd_cv',
			'hist_vnd_add',
			'hist_vnd_header',
			'vnd_update_progress',
			'vnd_akta',
			'vnd_address',
			'vnd_board',
			'vnd_fin_rpt',
			'vnd_bank',
			'vnd_product',
			'vnd_sdm',
			'vnd_cert',
			'vnd_equip',
			'vnd_cv',
			'vnd_add',
			'vnd_header',
			));
		$vendor_id = $this->input->post('vendor_id');

	//--LOG MAIN NYO --//
		$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Update Profile ( Approve Kabiro ) Update Vendor','APPROVE',$this->input->ip_address());
		$LM_ID = $this->log_data->last_id();
	//--END LOG MAIN--//

		if (!empty($vendor_id)) {
			$hist_vnd_header = $this->hist_vnd_header->get(array('VENDOR_ID' => intval($vendor_id), 'VND_TRAIL_ID' => 3));
			unset($hist_vnd_header['VND_HEADER_ID']);
			unset($hist_vnd_header['VND_TRAIL_ID']);
			unset($hist_vnd_header['VENDOR_ID']);
			$this->vnd_header->update($hist_vnd_header, array('VENDOR_ID' => $vendor_id));

				//--LOG DETAIL--//
			$where = array('VENDOR_ID' => $vendor_id);
			$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_header','update',$hist_vnd_header,$where);
				//--END LOG DETAIL--//
		}

		// Insert Akta
		$vendor_akta = $this->hist_vnd_akta->get_all(array("VENDOR_ID" => intval($vendor_id), "VND_TRAIL_ID" => 3));
		if ($vendor_akta) {
			$this->vnd_akta->delete(array('VENDOR_ID' => $vendor_id));
				//--LOG DETAIL--//
			$where = array('VENDOR_ID' => $vendor_id);
			$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_akta','delete',null,$where);
				//--END LOG DETAIL--//
			foreach ((array)$vendor_akta as $key => $akta) {

				unset($akta["VND_TRAIL_ID"]);
				unset($akta["AKTA_ID"]);
				$this->vnd_akta->insert($akta);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_akta','insert',$akta);
					//--END LOG DETAIL--//
			}
		}

		// Insert Address
		$company_address = $this->hist_vnd_address->get_all(array("VENDOR_ID" => intval($vendor_id), "VND_TRAIL_ID" => 3));
		if ($company_address) {
			$this->vnd_address->delete(array('VENDOR_ID' => $vendor_id));
				//--LOG DETAIL--//
			$where['VENDOR_ID'] = $vendor_id;
			$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_address','delete',null,$where);
				//--END LOG DETAIL--//
			foreach ((array)$company_address as $key => $address) {
				unset($address["VND_TRAIL_ID"]);
				unset($address["ADDRESS_ID"]);
				$this->vnd_address->insert($address);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_address','insert',$address);
					//--END LOG DETAIL--//
			}
		}
		// Insert Commissioner
		$vendor_board_commissioner = $this->hist_vnd_board->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Commissioner", "VND_TRAIL_ID" => 3));
		if ($vendor_board_commissioner) {
			$this->vnd_board->delete(array('VENDOR_ID' => $vendor_id,"TYPE" => "Commissioner"));
				//--LOG DETAIL--//
			$where['VENDOR_ID'] = $vendor_id;
			$where['TYPE'] = 'Commissioner';
			$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_board','delete',null,$where);
				//--END LOG DETAIL--//
			foreach ((array)$vendor_board_commissioner as $key => $board) {
				unset($board["VND_TRAIL_ID"]);
				unset($board["BOARD_ID"]);
				$this->vnd_board->insert($board);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_board','insert',$board);
					//--END LOG DETAIL--//
			}
		}
		// Insert Director
		$vendor_board_director = $this->hist_vnd_board->get_all(array("VENDOR_ID" => intval($vendor_id), "TYPE" => "Director", "VND_TRAIL_ID" => 3));
		if ($vendor_board_director) {
			$this->vnd_board->delete(array('VENDOR_ID' => $vendor_id,"TYPE" => "Director"));
				//--LOG DETAIL--//
			$where['VENDOR_ID'] = $vendor_id;
			$where['TYPE'] = 'Director';
			$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_board','delete',null,$where);
				//--END LOG DETAIL--//
			foreach ((array)$vendor_board_director as $key => $board) {
				unset($board["VND_TRAIL_ID"]);
				unset($board["BOARD_ID"]);
				$this->vnd_board->insert($board);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_board','insert',$board);
					//--END LOG DETAIL--//
			}
		}

		// Insert Financial Report
		$vendor_fin_report = $this->hist_vnd_fin_rpt->get_all(array("VENDOR_ID" => intval($vendor_id), "VND_TRAIL_ID" => 3));
		if ($vendor_fin_report) {
			$this->vnd_fin_rpt->delete(array('VENDOR_ID' => $vendor_id));
				//--LOG DETAIL--//
			$where['VENDOR_ID'] = $vendor_id;
			$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_fin_rpt','delete',null,$where);
				//--END LOG DETAIL--//
			foreach ((array)$vendor_fin_report as $key => $report) {
				unset($report["VND_TRAIL_ID"]);
				unset($report["FIN_RPT_ID"]);
				$this->vnd_fin_rpt->insert($report);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_fin_rpt','insert',$report);
					//--END LOG DETAIL--//
			}
		}

		// Insert Bank
		$vendor_bank = $this->hist_vnd_bank->get_all(array("VENDOR_ID" => intval($vendor_id), "VND_TRAIL_ID" => 3));
		if ($vendor_bank) {
			$this->vnd_bank->delete(array('VENDOR_ID' => $vendor_id));
				//--LOG DETAIL--//
			$where['VENDOR_ID'] = $vendor_id;
			$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_bank','delete',null,$where);
				//--END LOG DETAIL--//
			foreach ((array)$vendor_bank as $key => $bank) {
				unset($bank["VND_TRAIL_ID"]);
				unset($bank["BANK_ID"]);
				$this->vnd_bank->insert($bank);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_fin_rpt','insert',$bank);
					//--END LOG DETAIL--//
			}
		}

		// Insert Product (good,service,bahan)
		$goods = $this->hist_vnd_product->get_all(array("VENDOR_ID" => intval($vendor_id), "VND_TRAIL_ID" => 3));
		if ($goods) {
			$this->vnd_product->delete(array('VENDOR_ID' => $vendor_id));
				//--LOG DETAIL--//
			$where['VENDOR_ID'] = $vendor_id;
			$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_product','delete',null,$where);
				//--END LOG DETAIL--//
			foreach ((array)$goods as $key => $good) {
				unset($good["VND_TRAIL_ID"]);
				unset($good["PRODUCT_ID"]);
				$this->vnd_product->insert($good);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_product','insert',$good);
					//--END LOG DETAIL--//
			}
		}
		// Insert SDM
		$main_sdm = $this->hist_vnd_sdm->get_all(array("VENDOR_ID" => intval($vendor_id), "VND_TRAIL_ID" => 3));
		if ($main_sdm) {
			$this->vnd_sdm->delete(array('VENDOR_ID' => $vendor_id));
				//--LOG DETAIL--//
			$where['VENDOR_ID'] = $vendor_id;
			$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_sdm','delete',null,$where);
				//--END LOG DETAIL--//
			foreach ((array)$main_sdm as $key => $sdm) {
				unset($sdm["VND_TRAIL_ID"]);
				unset($sdm["SDM_ID"]);
				$this->vnd_sdm->insert($sdm);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_sdm','insert',$sdm);
					//--END LOG DETAIL--//
			}
		}
		// Insert Certifications
		$certifications = $this->hist_vnd_cert->get_all(array("VENDOR_ID" => intval($vendor_id), "VND_TRAIL_ID" => 3));
		if ($certifications) {
			$this->vnd_cert->delete(array('VENDOR_ID' => $vendor_id));
				//--LOG DETAIL--//
			$where['VENDOR_ID'] = $vendor_id;
			$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_cert','delete',null,$where);
				//--END LOG DETAIL--//
			foreach ((array)$certifications as $key => $certification) {
				unset($certification["VND_TRAIL_ID"]);
				unset($certification["CERT_ID"]);
				$this->vnd_cert->insert($certification);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_cert','insert',$certification);
					//--END LOG DETAIL--//
			}
		}

		// Insert Equipment
		$equipments = $this->hist_vnd_equip->get_all(array("VENDOR_ID" => intval($vendor_id), "VND_TRAIL_ID" => 3));
		if ($equipments) {
			$this->vnd_equip->delete(array('VENDOR_ID' => $vendor_id));
				//--LOG DETAIL--//
			$where['VENDOR_ID'] = $vendor_id;
			$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_equip','delete',null,$where);
				//--END LOG DETAIL--//
			foreach ((array)$equipments as $key => $equipment) {
				unset($equipment["VND_TRAIL_ID"]);
				unset($equipment["EQUIP_ID"]);
				$this->vnd_equip->insert($equipment);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_equip','insert',$equipment);
					//--END LOG DETAIL--//
			}
		}

		// Insert Experiences
		$experiences = $this->hist_vnd_cv->get_all(array("VENDOR_ID" => intval($vendor_id), "VND_TRAIL_ID" => 3));
		if ($experiences) {
			$this->vnd_cv->delete(array('VENDOR_ID' => $vendor_id));
				//--LOG DETAIL--//
			$where['VENDOR_ID'] = $vendor_id;
			$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_cv','delete',null,$where);
				//--END LOG DETAIL--//
			foreach ((array)$experiences as $key => $experience) {
				unset($experience["VND_TRAIL_ID"]);
				unset($experience["CV_ID"]);
				$this->vnd_cv->insert($experience);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_cv','insert',$experience);
					//--END LOG DETAIL--//
			}
		}

		// Insert Principal & Affiliation Company
		$adds = $this->hist_vnd_add->get_all(array("VENDOR_ID" => intval($vendor_id), "VND_TRAIL_ID" => 3));
		if ($adds) {
			$this->vnd_add->delete(array('VENDOR_ID' => $vendor_id));
				//--LOG DETAIL--//
			$where['VENDOR_ID'] = $vendor_id;
			$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_add','delete',null,$where);
				//--END LOG DETAIL--//
			foreach ((array)$adds as $key => $add) {
				unset($add["VND_TRAIL_ID"]);
				unset($add["ADD_ID"]);
				$this->vnd_add->insert($add);
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_add','insert',$add);
					//--END LOG DETAIL--//
			}
		}
		
		$this->vnd_header->update(array("STATUS" => '3','STATUS_PERUBAHAN' => 0, "NEXT_PAGE" => "Vendor Telah Diupdate"),array("VENDOR_ID" => intval($vendor_id)));

		//--LOG DETAIL--//
		$data['STATUS'] = '3';
		$data['STATUS_PERUBAHAN'] = '0';
		$data['NEXT_PAGE'] = 'Vendor Telah Diupdate';
		$where['VENDOR_ID'] = intval($vendor_id);
		$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_header','update',$data,$where);
		//--END LOG DETAIL--//
		
		$this->vnd_update_progress->delete(array("VENDOR_ID" => intval($vendor_id)));

		//--LOG DETAIL--//
		$where['VENDOR_ID'] = $vendor_id;
		$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_update_progress','delete',null,$where);
		//--END LOG DETAIL--// 

		$this->load->model('vendor_employe');
		$this->load->model('vnd_vendor_comment');
		$comen = $this->input->post('comment');
		$idem = $this->session->userdata['ID'];
		$employ = $this->vendor_employe->getemplo($idem);
		$nama_emp = $this->vendor_employe->get_nama_emplo($employ[0]['EMP_ID']);	

		$cmt["VENDOR_ID"] = $vendor_id;
		$cmt["COMMENT"] = $comen;
		$cmt["EMP_ID"] = $employ[0]['EMP_ID'];
		$cmt["EMP_NAMA"] = $nama_emp[0]['FULLNAME'];
		$cmt["STATUS_AKTIF"] = '1';
		$cmt["STATUS_ACTIVITY"] = "Update Approval Kabiro";
		
		$this->vnd_vendor_comment->insert($cmt);
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_vendor_comment','insert',$cmt);
			//--END LOG DETAIL--//

		$this->vnd_vendor_comment->update(array('STATUS_AKTIF' => 0),array('STATUS_AKTIF' => '1', 'VENDOR_ID' => intval($vendor_id)));

		//--LOG DETAIL--//
		$data['STATUS_AKTIF'] = '0';
		$where['STATUS_AKTIF'] = '1';
		$where['VENDOR_ID'] = intval($vendor_id);
		$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_header','update',$data,$where);
		//--END LOG DETAIL--//

		$this->vnd_vendor_comment->update(array('STATUS_AKTIF' => 3),array('STATUS_AKTIF' => '2', 'VENDOR_ID' => intval($vendor_id)));

		//--LOG DETAIL--//
		$data1['STATUS_AKTIF'] = '3';
		$where1['STATUS_AKTIF'] = '2';
		$where1['VENDOR_ID'] = intval($vendor_id);
		$this->log_data->detail($LM_ID,'Vendor_management/accept_vendor_update','vnd_header','update',$data1,$where1);
		//--END LOG DETAIL--//

		$this->session->set_flashdata('success', 'Success Updating Data');
		echo json_encode('OK');
	}
	

//-- Approve Registrasi Vendor untuk Perencanaan dan Kasi --//
	function do_approve_regis(){
		$this->load->model('tmp_vnd_header');
		$temp = $this->input->post('vendor_id');
		// die(var_dump($temp));
		$vendor_id = NULL;
		$vendor_type = NULL;

		$this->load->model('vendor_employe');
		$this->load->model('vnd_vendor_comment');
		$idem = $this->session->userdata['ID'];
		$employ = $this->vendor_employe->getemplo($idem);

		$comen = $this->input->post('comment');
		$nama_emp = $this->vendor_employe->get_nama_emplo($employ[0]['EMP_ID']);

		if (!empty($temp)) {
			$ven= $temp;
			if ($employ[0]['LEVEL'] == 1) { 

				$this->tmp_vnd_header->update(array("STATUS" => '5', "NEXT_PAGE" => "Approve Registrasi Kasi Perencanaan"),array("VENDOR_ID" => intval($ven)));

				
				$cmt["VENDOR_ID"] = intval($ven);
				$cmt["COMMENT"] = $comen;
				$cmt["EMP_ID"] = $employ[0]['EMP_ID'];
				$cmt["EMP_NAMA"] = $nama_emp[0]['FULLNAME'];
				$cmt["STATUS_AKTIF"] = '1';
				$cmt["STATUS_ACTIVITY"] = "Verifikasi Registrasi";

				$this->vnd_vendor_comment->insert($cmt);


			//--LOG MAIN NYO --//
				$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
					$this->authorization->getCurrentRole(),'Registration ( Approve Perencanaan )','APPROVE',$this->input->ip_address());
				$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//
				$data['STATUS'] = '5';
				$data['NEXT_PAGE'] = 'Approve Registrasi Kasi Perencanaan';
				$where['VENDOR_ID'] = intval($ven);

			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/do_approve_regis','tmp_vnd_header','update',$data,$where);
			//--END LOG DETAIL--//

			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/do_approve_regis','vnd_vendor_comment','insert',$cmt);
			//--END LOG DETAIL--//

				
			}else if ($employ[0]['LEVEL'] == 2) {
				$this->tmp_vnd_header->update(array("STATUS" => '6', "NEXT_PAGE" => "Approve Registrasi Kabiro Perencanaan"),array("VENDOR_ID" => intval($ven)));

				
				$cmt["VENDOR_ID"] = intval($ven);
				$cmt["COMMENT"] = $comen;
				$cmt["EMP_ID"] = $employ[0]['EMP_ID'];
				$cmt["EMP_NAMA"] = $nama_emp[0]['FULLNAME'];
				$cmt["STATUS_AKTIF"] = '1';
				$cmt["STATUS_ACTIVITY"] = "Registrasi Approval Kasi";

				$this->vnd_vendor_comment->insert($cmt);

			//--LOG MAIN NYO --//
				$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
					$this->authorization->getCurrentRole(),'Registration ( Approve Kasi )','APPROVE',$this->input->ip_address());
				$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//
				$data['STATUS'] = '6';
				$data['NEXT_PAGE'] = 'Approve Registrasi Kabiro Perencanaan';
				$where['VENDOR_ID'] = intval($ven);

			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/do_approve_regis','tmp_vnd_header','update',$data,$where);
			//--END LOG DETAIL--//

			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/do_approve_regis','vnd_vendor_comment','insert',$cmt);
			//--END LOG DETAIL--//
				
			}
		}
		echo json_encode('OK');		
	}


//-- Approve data vendor update untuk bagian perencanaan dan kasi --//
	function do_approve_update(){
		$vendor_id = $this->input->post('vendor_id');
		$this->load->model('vendor_employe');
		$this->load->model('vnd_vendor_comment');
		$this->load->model('vnd_header');
		$this->load->model('hist_vnd_product');
		$idem = $this->session->userdata['ID'];
		$employ = $this->vendor_employe->getemplo($idem);

		$comen = $this->input->post('comment');
		$nama_emp = $this->vendor_employe->get_nama_emplo($employ[0]['EMP_ID']);


		if (!empty($vendor_id)) {
			$ven = $vendor_id;

			if ($employ[0]['LEVEL'] == 1) {

				/* INSERT PRODUCT_TYPE_PROC */ 
				$product = $this->hist_vnd_product->fields("PRODUCT_TYPE")->where("VENDOR_ID",$ven)->order_by('PRODUCT_TYPE','ASC')->get_all();
				$data_pdt = array();
				foreach ($product as $key => $value) {
					$data_pdt[] = $value['PRODUCT_TYPE'];
				}
				$new_product = implode(",", array_unique($data_pdt));

				$where = array("VENDOR_ID" => $vendor_id);

				if ($new_product == 'GOODS') {
					$data_product['PRODUCT_TYPE_PROC'] = '1';
					$this->vnd_header->update($data_product,$where);

				} elseif ($new_product == 'SERVICES') {
					$data_product['PRODUCT_TYPE_PROC'] = '2';
					$this->vnd_header->update($data_product,$where);

				} elseif ($new_product == 'BAHAN') {
					$data_product['PRODUCT_TYPE_PROC'] = '3';
					$this->vnd_header->update($data_product,$where);

				} elseif ($new_product == 'GOODS,SERVICES') {
					$data_product['PRODUCT_TYPE_PROC'] = '4';
					$this->vnd_header->update($data_product,$where);

				} elseif ($new_product == 'BAHAN,GOODS') {
					$data_product['PRODUCT_TYPE_PROC'] = '5';
					$this->vnd_header->update($data_product,$where);

				} elseif ($new_product == 'BAHAN,SERVICES') {
					$data_product['PRODUCT_TYPE_PROC'] = '6';
					$this->vnd_header->update($data_product,$where);

				} elseif ($new_product == 'BAHAN,GOODS,SERVICES') {
					$data_product['PRODUCT_TYPE_PROC'] = '7';
					$this->vnd_header->update($data_product,$where);
				}
				/* END INSERT */ 

				$this->vnd_header->update(array("STATUS" => '3','STATUS_PERUBAHAN' => 4, "NEXT_PAGE" => "Approve update profil kasi"),array("VENDOR_ID" => $ven));

				$cmt["VENDOR_ID"] = intval($ven);
				$cmt["COMMENT"] = $comen;
				$cmt["EMP_ID"] = $employ[0]['EMP_ID'];
				$cmt["EMP_NAMA"] = $nama_emp[0]['FULLNAME'];
				$cmt["STATUS_AKTIF"] = '1';
				$cmt["STATUS_ACTIVITY"] = "Verifikasi Update";

				$this->vnd_vendor_comment->insert($cmt);

			//--LOG MAIN NYO --//
				$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
					$this->authorization->getCurrentRole(),'Update Profile ( Approve Perencanaan )','APPROVE',$this->input->ip_address());
				$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//
				$data['STATUS'] = '3';
				$data['STATUS_PERUBAHAN'] = '4';
				$data['NEXT_PAGE'] = 'Approve update profil kasi';
				$where['VENDOR_ID'] = $ven;

			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/do_approve_update','vnd_header','update',$data,$where);
			//--END LOG DETAIL--//

			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/do_approve_update','vnd_vendor_comment','insert',$cmt);
			//--END LOG DETAIL--//				

			}else if ($employ[0]['LEVEL'] == 2) {
				$this->vnd_header->update(array("STATUS" => '3','STATUS_PERUBAHAN' => 5, "NEXT_PAGE" => "Approve update profil kabiro"),array("VENDOR_ID" => $ven));

				
				$cmt["VENDOR_ID"] = $ven;
				$cmt["COMMENT"] = $comen;
				$cmt["EMP_ID"] = $employ[0]['EMP_ID'];
				$cmt["EMP_NAMA"] = $nama_emp[0]['FULLNAME'];
				$cmt["STATUS_AKTIF"] = '1';
				$cmt["STATUS_ACTIVITY"] = "Update Approval Kasi";

				$this->vnd_vendor_comment->insert($cmt);

			//--LOG MAIN NYO --//
				$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
					$this->authorization->getCurrentRole(),'Update Profile ( Approve Kasi )','APPROVE',$this->input->ip_address());
				$LM_ID = $this->log_data->last_id();
			//--END LOG MAIN--//
				$data['STATUS'] = '3';
				$data['STATUS_PERUBAHAN'] = '5';
				$data['NEXT_PAGE'] = 'Approve update profil kabiro';
				$where['VENDOR_ID'] = $ven;

			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/do_approve_update','vnd_header','update',$data,$where);
			//--END LOG DETAIL--//

			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Vendor_management/do_approve_update','vnd_vendor_comment','insert',$cmt);
			//--END LOG DETAIL--//
				
			}

		}
		echo json_encode('OK');	
	}

	//reject vendor update profile
	function reject_update_profil_vendor() {
		$this->load->model('vnd_header');
		$this->load->model('vendor_employe');
		$this->load->model('vnd_vendor_comment');

		$vendor_id = $this->input->post('vendor_id');
		$comen = $this->input->post('comment');
		$idem = $this->session->userdata['ID'];
		$employ = $this->vendor_employe->getemplo($idem);
		$nama_emp = $this->vendor_employe->get_nama_emplo($employ[0]['EMP_ID']);		

		if (!empty($vendor_id)) {
		//--LOG MAIN NYO --//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
				$this->authorization->getCurrentRole(),'Update Profile ( Reject Vendor )','REJECT',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

			$this->vnd_header->update(array("STATUS" => '3','STATUS_PERUBAHAN' => 9, "NEXT_PAGE" => "Update Data Ditolak"),array("VENDOR_ID" => $vendor_id));

				//--LOG DETAIL--//
			$where['VENDOR_ID'] = $vendor_id;
			$data['STATUS'] = '3';
			$data['STATUS_PERUBAHAN'] = '9';
			$data['NEXT_PAGE'] = 'Update Data Ditolak';
			$this->log_data->detail($LM_ID,'Vendor_management/reject_update_profil_vendor','vnd_header','update',$data,$where);
				//--END LOG DETAIL--//


			$cmt["VENDOR_ID"] = $vendor_id;
			$cmt["COMMENT"] = $comen;
			$cmt["EMP_ID"] = $employ[0]['EMP_ID'];
			$cmt["EMP_NAMA"] = $nama_emp[0]['FULLNAME'];
			$cmt["STATUS_AKTIF"] = '1';
			if ($employ[0]['LEVEL'] == 2) {
				$cmt["STATUS_ACTIVITY"] = "Update Approval Kasi";
			}elseif ($employ[0]['LEVEL'] == 3) { 
				$cmt["STATUS_ACTIVITY"] = "Update Approval Kabiro";
			}

			$this->vnd_vendor_comment->insert($cmt);
					//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_management/reject_update_profil_vendor','vnd_vendor_comment','insert',$cmt);
					//--END LOG DETAIL--//
			
		}

		echo json_encode('OK');
	}

	public function viewDok($file=null){
		$url = str_replace("int-","", base_url());
		$this->load->helper('file');
		$image_path = base_url(UPLOAD_PATH).'/vendor/'.$file;

		if (strpos($url, 'semenindonesia.com') !== false) { //server production
			$user_id=url_encode($this->session->userdata['ID']);
			if(empty($file)){
				die('tidak ada attachment.');
			}
			if(file_exists(BASEPATH.'../upload/vendor/'.$file)){				
				$this->output->set_content_type(get_mime_by_extension($image_path));
				return $this->output->set_output(file_get_contents($image_path));
			}else{
				if (strpos($url, 'https')) {
					$url = $url;
				} 
				else {
					$url = str_replace("http","https", $url);					
				}
				
				redirect($url.'View_document_vendor/viewDok/'.$file.'/'.$user_id);
			}

		}else{ //server development
			if(empty($file) || !file_exists(BASEPATH.'../upload/vendor/'.$file)){
				die('tidak ada attachment.');
			}
			
			$this->output->set_content_type(get_mime_by_extension($image_path));
			return $this->output->set_output(file_get_contents($image_path));
		}
	}

	// function input_akuntansi_data(){
	// 	$data['title'] = "Vendor Approval";
	// 	$this->load->model(array('m_vnd_account_group', 'm_vnd_bank', 'm_vnd_reconc_acc', 'm_vnd_payment_term'));
	// 	$data['account_group'] = $this->m_vnd_account_group->get();
	// 	$data['bank_key'] = $this->m_vnd_bank->get();
	// 	$data['reconc_account'] = $this->m_vnd_reconc_acc->get();
	// 	$data['payment_term'] = $this->m_vnd_payment_term->get();
	// 	$this->layout->render('form_input_akuntansi', $data);
	// }

	// function save_checklist_document() {
	// 	foreach ($this->input->post('doc_id') as $key => $value) {
	// 		$batch_data[$key]['doc_id'] = $value;
	// 		$batch_data[$key]['status'] = NULL;
	// 	}
	// 	foreach ($this->input->post('notes') as $key => $value) {
	// 		$batch_data[$key]['notes'] = $value;
	// 	}
	// 	foreach ($this->input->post('status') as $key => $value) {
	// 		$batch_data[$key]['status'] = $value;
	// 	}
	// 	$vendor_id = $this->input->post('vendor_id');
	// 	foreach ($batch_data as $key => $value) {
	// 	}
	// 	echo json_encode('OK');
	// }
}