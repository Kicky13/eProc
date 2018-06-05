<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Master_sanction extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->helper('url');
	}

	public function index() {
		$this->load->model('vnd_perf_mst_category');
		$data['title'] = "Master Performance Category Vendor";
		$data['perf'] = $this->vnd_perf_mst_category->order_by('START_POINT','DESC')->get_all();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_css('plugins/selectize/selectize.css');
		$this->layout->add_js('plugins/selectize/selectize.js');
		$this->layout->add_js('plugins/autoNumeric.js');
		$this->layout->render('show_master_sanction',$data);
	}

	public function add() {
		// echo json_encode($this->input->post());
		$this->load->model('vnd_perf_mst_category');
		$data['CATEGORY_NAME'] = $this->input->post('category_name');
		$data['START_POINT'] = $this->input->post('start_point');
		$data['END_POINT'] = $this->input->post('end_point');
		$data['DURATION'] = $this->input->post('duration');
		if($this->input->post('invited') == 'Yes'){
			$data['CAN_BE_INVITED'] = 'Y';
		} else {
			$data['CAN_BE_INVITED'] = 'N';
		}
		if($this->input->post('priority') == 'Yes'){
			$data['IS_PRIORITY'] = 'Y';
		} else {
			$data['IS_PRIORITY'] = 'N';
		}

		$this->vnd_perf_mst_category->insert($data);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		echo json_encode($data);
	}

	public function edit() {
		$this->load->model('vnd_perf_mst_category');
		$where['ID_CATEGORY'] = $this->input->post('category_id');
		
		$data['CATEGORY_NAME'] = $this->input->post('category_name');
		$data['START_POINT'] = $this->input->post('start_point');
		$data['END_POINT'] = $this->input->post('end_point');
		$data['DURATION'] = $this->input->post('duration');
		if($this->input->post('invited') == 'Yes'){
			$data['CAN_BE_INVITED'] = 'Y';
		} else {
			$data['CAN_BE_INVITED'] = 'N';
		}
		if($this->input->post('priority') == 'Yes'){
			$data['IS_PRIORITY'] = 'Y';
		} else {
			$data['IS_PRIORITY'] = 'N';
		}

		$this->vnd_perf_mst_category->update($data,$where);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		echo json_encode($data);
	}

	public function delete() {
		// echo json_encode($this->input->post()); exit();
		$this->load->model('vnd_perf_mst_category');
		$where_hapus['ID_CATEGORY'] = $this->input->post('hapus_id');
		$this->vnd_perf_mst_category->delete($where_hapus);
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		echo json_encode($data);
	}

}