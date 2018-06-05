<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ET_Procurement_template extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->model('prc_evaluation_template');
		$this->load->model('prc_preq_template_detail');
		$this->load->model('prc_preq_template_uraian');
		$this->load->helper('url');
	}

	public function index($value='') {
        // $this->authorization->roleCheck();
		$data['title'] = 'List Template Evaluasi Pengadaan';
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/ET_procurement_template_index.js');
		$this->layout->render('procurement_template_index', $data);
	}

	public function get_evaluation_template() {
		$datatable = $this->prc_evaluation_template->get();
		$data = array('data' => $datatable);
		echo json_encode($data);
	}

	public function create($id=null) {
		$this->authorization->roleCheck();
		$this->load->helper(array('form', 'url'));

		$this->form_validation->set_rules('evt_type', 'Tipe Evaluasi', 'required');
		$this->form_validation->set_rules('evt_name', 'Nama Evaluasi', 'required');
		$this->form_validation->set_rules('evt_passing_grade', 'Passing grade evaluasi', 'required|is_natural');
		$this->form_validation->set_rules('evt_tech_weight', 'Bobot Teknis', 'required|is_natural');
		$this->form_validation->set_rules('evt_price_weight', 'Bobot Harga', 'required|is_natural');

		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Pembuatan Template Evaluasi Pengadaan';
			$cpny = " SELECT COMPANYID, COMPANYNAME FROM ADM_COMPANY WHERE COMPANYID = '".$this->session->userdata['COMPANYID']."' ";
    		$dataq = $this->db->query($cpny);
			$data['company'] = $dataq->result_array();

			$this->layout->set_table_js();
			$this->layout->set_table_cs();
			$this->layout->add_js('pages/EC_autocomplete.js');
        	$this->layout->add_css('pages/EC_autocomplete.css');
			$this->layout->add_js('pages/ET_Procurement_template.js');
			$this->layout->render('create_procurement_template',$data);

		} else {	
			$urai = $this->input->post('evt_detail');
			$pptu_weight = $this->input->post('pptu_weight');
			$pptu_type = $this->input->post('pptu_type');

			if(isset($pptu_weight)){
				foreach ($this->input->post('evt_teknis') as $key => $value) {
					$weight_parent = $value['weight'];
					if($value['mode'] == 1){
						$weight_pptu=0; $urut=0;
						foreach ($urai[$key] as $child) {
							$weight_pptu += $pptu_weight[$key][$urut];
							$urut++;
						}
						if ($weight_parent != $weight_pptu) {
							die('weight_pptu');
						}
					}
					
					
				}
			}

			$evt_id = $this->prc_evaluation_template->get_id();

			$evt['EVT_ID'] = $evt_id;
			$evt['EVT_TYPE'] = $this->input->post('evt_type');
			$evt['EVT_NAME'] = $this->input->post('evt_name');
			$evt['COMPANY'] = $this->input->post('evt_company');
			$evt['EVT_PASSING_GRADE'] = $this->input->post('evt_passing_grade');
			$evt['EVT_TECH_WEIGHT'] = $this->input->post('evt_tech_weight');
 			$evt['EVT_PRICE_WEIGHT'] = $this->input->post('evt_price_weight');
			$this->prc_evaluation_template->insert($evt);

			$det['PPT_ID'] = $evt_id;
			foreach ($this->input->post('evt_teknis') as $key => $value) {
				$det['PPD_ID'] = $this->prc_preq_template_detail->get_id();
				$det['PPD_ITEM'] = $value['name'];
				$det['PPD_WEIGHT'] = $value['weight'];
				$det['PPD_MODE'] = $value['mode'];
				$det['PPD_USER'] = $value['user'];
				$det['PRASYARAT'] = $value['prasyarat'];
				// var_dump($det);
				$this->prc_preq_template_detail->insert($det);
					
				$pptu['PPD_ID'] = $det['PPD_ID'];
				$urut=0;
				foreach ($urai[$key] as $child) {
					
					$pptu['PPTU_ID'] = $this->prc_preq_template_uraian->get_id();
					$pptu['PPTU_ITEM'] = $child;
					if($value['prasyarat'] == 1){
						$pptu['PPTU_WEIGHT'] = 0;
						$pptu['PPTU_TYPE'] = $pptu_type[$key][$urut];
					}else{
						$pptu['PPTU_TYPE'] = 0;
						$pptu['PPTU_WEIGHT'] = $pptu_weight[$key][$urut];						
					}
					$this->prc_preq_template_uraian->insert($pptu);
				
					$urut++;
				}
			}
			echo "OK";
			//redirect('ET_Procurement_template/index');
		}
	}

	public function weight_check($weight) {
		if($weight != '100') {
			$this->form_validation->set_message('weight_check','Jumlah bobot harus 100');
			return false;
		} else {
			return true;
		}
	}

	public function show($evt_id) {
		$result = $this->prc_evaluation_template->get_w_type(array('EVT_ID' => $evt_id));
		$data['eval'] = count($result) <= 0 ? null : $result[0];

		$result = $this->prc_preq_template_detail->get(array('PPT_ID' => $evt_id));
		$data['detail'] = count($result) <= 0 ? null : $result;

		foreach ((array)$data['detail'] as $key => $val) {
			$uraian = $this->prc_preq_template_uraian->get(array('PPD_ID' => $val['PPD_ID']));
			$data['detail'][$key]['uraian'] = $uraian;
		}

		// var_dump($data);exit();
		$data['title'] = 'Detail Template Evaluasi Pengadaan';
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/ET_procurement_template_index.js');
		$this->layout->render('procurement_template_show', $data);
        // var_dump($data);
	}

	public function get_template_detail($id='') {
		//$data = $this->prc_preq_template_detail->get(array('PPT_ID' => $id));
		$result = $this->prc_evaluation_template->get_w_type(array('EVT_ID' => $id));
		$data['eval'] = count($result) <= 0 ? null : $result[0];

		$result = $this->prc_preq_template_detail->get(array('PPT_ID' => $id));
		$data['detail'] = count($result) <= 0 ? null : $result;

		foreach ((array)$data['detail'] as $key => $val) {
			$uraian = $this->prc_preq_template_uraian->get(array('PPD_ID' => $val['PPD_ID']));
			$data['detail'][$key]['uraian'] = $uraian;
		}

		echo json_encode($data);
	}

	public function search_nama()
  	{
    	// tangkap variabel keyword dari URL
    	$keyword = $this->uri->segment(3);
    	$keyword = str_replace('%20', ' ', $keyword);
    	// var_dump(strtoupper($keyword));
    	// cari di database
    	$data = $this->db->query("SELECT EMP.* FROM ADM_EMPLOYEE EMP where EMP.FULLNAME like '%".strtoupper($keyword)."%'");
    	// $data = $this->db->query("SELECT EMP.* FROM ADM_EMPLOYEE EMP where EMP.FULLNAME like '%%'");
    	// var_dump($data);
    	// var_dump('tes num : '.$data->num_rows);
    	// format keluaran di dalam array
    	if($data->num_rows > 0){
    		foreach($data->result() as $row)
    		{
    		  $arr['query'] = $keyword;
    		  $arr['suggestions'][] = array(
    		    'value' =>$row->FULLNAME,
    		    'ID_USER' =>$row->ID
    		  );
    		}	
    	}
    	
    	// minimal PHP 5.2
    	echo json_encode($arr);
  	}
}