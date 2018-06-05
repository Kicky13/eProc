<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Snippet_ajax extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('Authorization');
	}

	/**
	 * Buat nampilin service detail buat jasa
	 */
	public function pr_doc_service($prno) {
		$this->load->model('prc_plan_doc');
		$this->load->model('prc_it_service');
		$this->load->model('prc_purchase_requisition');

		$pr = substr($prno, 0, 10);
		$data['docs'] = $this->prc_plan_doc->pr($pr);
		// $data['ppr'] = $this->prc_purchase_requisition->pr($pr);
		$data['service'] = $this->prc_it_service->ppi($prno);

		$data['user_vendor'] = $this->session->userdata('VENDOR_ID');

		$ans = $this->load->view('pr_doc_service', $data, true);
		echo ($ans);
	}

	public function history_material($ppi_id) {
		$this->load->model('prc_pr_item');
		$this->load->library('sap_handler');

		// $this->prc_pr_item->join_pr();
		$this->prc_pr_item->where_id($ppi_id);
		$item = $this->prc_pr_item->get();
		$data['item'] = $item[0];

		$matnr = $data['item']['PPI_NOMAT'];
		$plant = $data['item']['PPI_PLANT'];
		$data['history'] = $this->sap_handler->getMatConsumtion($matnr, $plant);

		$ans = $this->load->view('history_material', $data, true);
		echo ($ans);
	}

	public function tender_vendor() {
		$this->load->library('snippet');
		$ptv_id = $this->input->post('ptv');
		$show_harga = $this->input->post('show_harga') == 1 ? true : false;
		echo $this->snippet->tender_vendor($ptv_id, $show_harga);
		// die();
	}

	public function dokumen_by_pr($prno)
	{
		$this->load->library('snippet');
		echo $this->snippet->dokumen_by_pr($prno);
	}

	public function getlongtext($PPI_ID, $nomat){
		// $PPI_ID = $this->input->post('PPI_ID');
		$data['matnr'] = $nomat;
		$data['banfn'] = substr($PPI_ID, 0, 10);
		$data['bnfpo'] = sprintf("%05d", substr($PPI_ID, 10));

		$data['user_vendor'] = $this->session->userdata('VENDOR_ID');

		$this->load->library('sap_handler');
		$data['return'] = $this->sap_handler->getlongtext(array($data));
		foreach ($data['return'] as $var) {
			$data['isi'][$var['TYPE']][] = $var['TDLINE'];
		}

		echo $this->load->view('detail_material', $data, true);
	}
	public function pop_up_barang($idku) {
		//echo $idku;
		$this->load->model('prc_perencanaan_pengadaan');

		$dataku['jon']= $this->prc_perencanaan_pengadaan->datapopup($idku);		
		//$jon = $this->prc_perencanaan_pengadaan->datapopup($idku);
		//var_dump($jon);

		echo $this->load->view('pop_up_barang',$dataku, true);	
	}

}