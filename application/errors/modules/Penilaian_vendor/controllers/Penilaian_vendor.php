<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian_Vendor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
	}

	public function index() {
		redirect('Penilaian_vendor/vendor_list');
	}

	public function vendor_list() {
		$data['title'] = "Penilaian Vendor";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js(base_url().'Assets/Penilaian_vendor/assets/Penilaian_vendor_list.js', TRUE);
		$this->layout->render('vendor_list', $data);
	}

	public function po_list(){
		$this->load->model(array('vnd_header'));
		$data['title'] = "Penilaian Vendor";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js(base_url().'Assets/Penilaian_vendor/assets/Penilaian_po_list.js', TRUE);
		$this->layout->render('po_list', $data);
	}

	public function detail_penilaian_vendor($vendor_code){
		if($vendor_code){
			$data['title'] = "Detail Penilaian Vendor";
			$this->load->model(array('vnd_perf_hist','vnd_header','vnd_perf_criteria'));
			$vendors = $this->vnd_header->get(array('VENDOR_NO' => $vendor_code));
			// var_dump($vendors); var_dump($vendor_code);
			$data['vendor_information'] = $vendors;
			$data['vendor_performance']  = $this->vnd_perf_hist->get(array("VENDOR_CODE" => $vendor_code));
			$data['performance_criteria'] = $this->vnd_perf_criteria->get(array('T_OR_V'=>'V', 'REQ_OR_BUYER'=>'R'));
			// var_dump($data['vendor_performance']); exit();
			$this->layout->set_table_js();
			$this->layout->set_table_cs();
			$this->layout->add_js(base_url().'Assets/Vendor_performance_management/assets/vnd_perf_management.js', TRUE);
			$this->layout->render('detail_penilaian_vendor', $data);
		} else {
			redirect('Penilaian_vendor/vendor_list');
		}
	}

	public function detail_penilaian_po($vendor_code){
		if($vendor_code){
			$data['title'] = "Detail Penilaian PO";
			$this->load->model(array('vnd_perf_hist','vnd_header','vnd_perf_criteria'));
			$vendors = $this->vnd_header->get(array('VENDOR_NO' => $vendor_code));
			// var_dump($vendors); var_dump($vendor_code);
			$data['vendor_information'] = $vendors;
			$data['vendor_performance']  = $this->vnd_perf_hist->get(array("VENDOR_CODE" => $vendor_code));
			$data['performance_criteria'] = $this->vnd_perf_criteria->get(array('T_OR_V'=>'T', 'REQ_OR_BUYER'=>'B'));
			// var_dump($data['vendor_performance']); exit();
			$this->layout->set_table_js();
			$this->layout->set_table_cs();
			$this->layout->add_js(base_url().'Assets/Vendor_performance_management/assets/vnd_perf_management.js', TRUE);
			$this->layout->render('detail_penilaian_po', $data);
		} else {
			redirect('Penilaian_vendor/po_list');
		}
	}

	public function do_insert_penilaian_vendor()
	{
		$this->load->model('vnd_perf_hist');
		$lastScore = $this->vnd_perf_hist->getLastScoreByVendorCode($this->input->post('VENDOR_NO'));
		$lastScore = isset($lastScore["POIN"]) ? intval($lastScore["POIN"]) : 0;
		$poin_added = intval($this->input->post('VALUE'));
		$vendor_no = $this->input->post('VENDOR_NO');
		switch ($this->input->post('SIGN')) {
			case '+':
				$lastScore += $poin_added;
				break;
			case '-':
				$lastScore -= $poin_added;
				$poin_added = -$poin_added;
				break;
			case '=':
				$lastScore = $poin_added;
				$this->vnd_perf_hist->update(array('IGNORED' => 1), array('VENDOR_CODE' => $vendor_no));
				break;
			default:
				$lastScore = $poin_added;
				break;
		}
		$inserting = array(
				'VENDOR_CODE' => $vendor_no, 
				// 'POIN' => $lastScore, 
				'KETERANGAN' => $this->input->post('KETERANGAN'),
				'POIN_ADDED' => $poin_added,
				'SIGN' => $this->input->post('SIGN'),
				'IGNORED' => 0,
			);
		if( $this->vnd_perf_hist->insert_custom($inserting) ) {
			$this->session->set_flashdata('success', "Performance for Vendor <strong>".$vendor_no."</strong> updated");
			redirect('Penilaian_vendor/detail_penilaian_vendor/'.$vendor_no);
		}
	}

	public function do_insert_penilaian_po()
	{
		$this->load->model('vnd_perf_hist');
		$lastScore = $this->vnd_perf_hist->getLastScoreByVendorCode($this->input->post('VENDOR_NO'));
		$lastScore = isset($lastScore["POIN"]) ? intval($lastScore["POIN"]) : 0;
		$poin_added = intval($this->input->post('VALUE'));
		$vendor_no = $this->input->post('VENDOR_NO');
		switch ($this->input->post('SIGN')) {
			case '+':
				$lastScore += $poin_added;
				break;
			case '-':
				$lastScore -= $poin_added;
				$poin_added = -$poin_added;
				break;
			case '=':
				$lastScore = $poin_added;
				$this->vnd_perf_hist->update(array('IGNORED' => 1), array('VENDOR_CODE' => $vendor_no));
				break;
			default:
				$lastScore = $poin_added;
				break;
		}
		$inserting = array(
				'VENDOR_CODE' => $vendor_no, 
				// 'POIN' => $lastScore, 
				'KETERANGAN' => $this->input->post('KETERANGAN'),
				'POIN_ADDED' => $poin_added,
				'SIGN' => $this->input->post('SIGN'),
				'IGNORED' => 0,
			);
		if( $this->vnd_perf_hist->insert_custom($inserting) ) {
			$this->session->set_flashdata('success', "Performance for Vendor <strong>".$vendor_no."</strong> updated");
			redirect('Penilaian_vendor/detail_penilaian_po/'.$vendor_no);
		}
	}

	public function do_delete_penilaian_vendor($perf_hist_id, $vendor_code) {
		$this->load->model('vnd_perf_hist');
		$status = $this->vnd_perf_hist->delete(array("PERF_HIST_ID" => $perf_hist_id));
		if ($status) {
			$this->session->set_flashdata('success', "Item Performance for Vendor <strong>".$this->input->post('VENDOR_NO')."</strong> deleted");
			$url = "Penilaian_vendor/detail_penilaian_vendor/".$vendor_code;
			redirect(site_url($url));
		};
	}

	public function do_delete_penilaian_po($perf_hist_id, $vendor_code) {
		$this->load->model('vnd_perf_hist');
		$status = $this->vnd_perf_hist->delete(array("PERF_HIST_ID" => $perf_hist_id));
		if ($status) {
			$this->session->set_flashdata('success', "Item Performance for Vendor <strong>".$this->input->post('VENDOR_NO')."</strong> deleted");
			$url = "Penilaian_vendor/detail_penilaian_po/".$vendor_code;
			redirect(site_url($url));
		};
	}

	function get_all_vendor()
	{
		$this->load->model(array('v_vnd_perf_total'));
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$search = $this->input->post('search');
		if ($search.'' != '') {
			$this->v_vnd_perf_total->search($search);
		}
		$this->v_vnd_perf_total->join_vnd_header();
		$this->v_vnd_perf_total->join_category();
		$datatable = $this->v_vnd_perf_total->get();
		$data = array(
				'data' => $datatable,
				'post' => $this->input->post(),
			);
		echo json_encode($data);
	}

	function get_all_po()
	{
		$this->load->model(array('v_vnd_perf_total'));
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$search = $this->input->post('search');
		if ($search.'' != '') {
			$this->po_header->search($search);
		}
		$this->v_vnd_perf_total->join_po_header();
		$this->v_vnd_perf_total->join_category();
		$datatable = $this->v_vnd_perf_total->get();
		$data = array(
				'data' => $datatable,
				'post' => $this->input->post(),
			);
		echo json_encode($data);

	}

}