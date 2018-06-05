<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_reject extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->model(array('vnd_header'));
	}

	public function index() {
		$data['title'] = "List Vendor Rejected";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_validate_css();
		$this->layout->set_validate_js();
		$this->layout->add_js('pages/vnd_reject.js');
		$this->layout->render('list_vendor', $data);
	}

	function get_vendor()
	{
		$this->load->model('tmp_vnd_header');
		$this->load->model('adm_wilayah');
		$opco = $this->session->userdata['EM_COMPANY'];

		if ($opco == '7000' || $opco == '2000' || $opco == '5000') {
			$whereopco = array(7000,2000,5000);
		} else {
			$whereopco = $opco;
		}

		$datatable = $vendors = $this->tmp_vnd_header->order_by('VENDOR_ID','DESC')->fields(array('VENDOR_ID','VENDOR_TYPE','VENDOR_NAME','ADDRESS_CITY','VENDOR_NO','COMPANYID'))->where("COMPANYID",$whereopco)->get_all(array('STATUS' => '-1'));
		$city = create_standard($this->adm_wilayah->fields('KODE,NAMA')->get_all(array('JENIS'=>'KOTA')));
		$city_list = array();
		foreach ($city as $key => $value) {
			$city_list[$key] = $value;
		}
		$data['city_list'] = $city_list;
		if (!empty($datatable)) {
			foreach ($datatable as $key => $value) {
				if(!is_null($value['ADDRESS_CITY']))
					if(is_numeric($value['ADDRESS_CITY']))
						if(array_key_exists($value['ADDRESS_CITY'],$city_list)){
								$datatable[$key]['ADDRESS_CITY'] = $city_list[$value['ADDRESS_CITY']];
						}
				
			}
		}
		$data = array('data' => $datatable);
		echo json_encode($data);
	}

	function do_update_activation_data() {
		$this->load->model('tmp_vnd_header');
		$vendor_id = $this->input->post('vendor_id');
		$data_update['STATUS'] = 1;
		$data_update['NEXT_PAGE'] = 'Persetujuan New Registrasi';
		$where = $vendor_id;
		$this->tmp_vnd_header->update($data_update, $where);

		//--LOG MAIN NYO --//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Activate vendor','ACTIVATE',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Vendor_reject/do_update_activation_data','tmp_vnd_header','update',$data_update,$where);
		//--END LOG DETAIL--//
		echo json_encode('OK');
	}

	function detail($id){

		$this->load->model(array('vendor_detail_tmp','adm_wilayah','adm_country','m_vnd_tools_category','m_vnd_certificate_type'));

		$dat = $this->vendor_detail_tmp->info_perusahaan($id);
		foreach ($dat as $row) {} 
		$data['ven'] = $row;

		if (is_numeric($row['PREFIX']) == true) {
			$presuf = $this->vendor_detail_tmp->prefix_sufix($id);
		}else{
			$presuf = $this->vendor_detail_tmp->prefix_sufix_vnd($id);
		}
		foreach ($presuf as $rg) {} 
		$data['presuf'] = $rg;

		$data['company_address'] = $this->vendor_detail_tmp->alamat_perusahaan($id);

		$data['akta'] = $this->vendor_detail_tmp->akta_pendirian($id);
		
		$dom = $this->vendor_detail_tmp->domisili_perusahaan($id);
		
		foreach ($dom as $key) {}
		$data['domisili'] = $key;

		if (is_numeric($row['NPWP_PROP']) == true) {
			$np = $this->vendor_detail_tmp->npwp($id);
		}else{
			$np = $this->vendor_detail_tmp->npwp_ven($id);
		}

		foreach ($np as $wp) {}
		$data['npwp'] = $wp;

		$val = $this->vendor_detail_tmp->val_ven($id);
		foreach ($val as $ven) {}
		$data['valven'] = $ven;

		$data['country'] = $this->adm_country->as_dropdown('COUNTRY_NAME')->get_all();

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
		$data['vendor_id'] = $id;

		$this->load->model('vnd_vendor_comment');
		$data['comment'] = $this->vnd_vendor_comment->where('STATUS_AKTIF','1')->order_by('ID','ASC')->get_all(array("VENDOR_ID" => $id));

		$data['info_komisaris'] = $this->vendor_detail_tmp->info_komisaris($id);
		$data['info_director'] = $this->vendor_detail_tmp->info_director($id);
		$data['bank_vendor'] = $this->vendor_detail_tmp->info_bank($id);
		$data['fin'] = $this->vendor_detail_tmp->fin($id);
		$data['product'] = $this->vendor_detail_tmp->produk($id);
		$data['jasa'] = $this->vendor_detail_tmp->produk_jasa($id);
		$data['main_sdm'] = $this->vendor_detail_tmp->sdm($id);
		$data['sdm_support'] = $this->vendor_detail_tmp->sdm_sp($id);
		$data['certifications'] = $this->vendor_detail_tmp->certifications($id);
		$data['equipments'] = $this->vendor_detail_tmp->equipment($id);
		$data['experience'] = $this->vendor_detail_tmp->experience($id);
		$data['pricipal'] = $this->vendor_detail_tmp->pricipal($id);
		$data['subcontractors'] = $this->vendor_detail_tmp->subcontractor($id);
		$data['affiliation'] = $this->vendor_detail_tmp->affiliation($id);
		$data['certificate_type'] = $this->m_vnd_certificate_type->as_dropdown('CERTIFICATE_TYPE')->get_all();
		$data['tools_category'] = $this->m_vnd_tools_category->as_dropdown('CATEGORY')->get_all();

		$data['title'] = "Detail Ringkasan Vendor";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/vnd_reject.js');
		$this->layout->render('detail_vendor', $data);
	}

}