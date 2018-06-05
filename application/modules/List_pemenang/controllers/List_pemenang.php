<?php defined('BASEPATH') OR exit('No direct script access allowed');

class List_pemenang extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->load->library('Authorization');
		$this->load->library('Layout');
	}

	public function index() {
		redirect('List_pemenang/view');
	}

	public function view() {
		// $this->authorization->roleCheck();
		$data['title'] = "Penetapan Pemenang";
		$this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_js('pages/list_pemenang.js');
		$this->layout->render('list_pemenang', $data);
	}

	public function get_datatable() {
		$this->load->model('m_global');
		$sql="SELECT * FROM (SELECT ID_PEMENANG,PTM_NUMBER,RFQ,KODE_VENDOR,HARGA_TERAKHIR,	'' NAMA_VENDOR,STATUS_PEMENANG,STATUS_WINER,TGL_ACT_PEMENANG
		,ROW_NUMBER() OVER (ORDER BY TGL_ACT_PEMENANG DESC) BARIS FROM PRC_TENDER_PEMENANG WHERE STATUS_PEMENANG=1)";
        $datatable = $this->m_global->array_view($sql);
        $data = array('data' => $datatable);
        echo json_encode($data);
	}
	
	public function update_status() {
		$this->load->model('m_global');
		$data_post=$this->input->post();
		
		$sql="UPDATE PRC_TENDER_PEMENANG SET STATUS_PEMENANG=2,TGL_ACT_PEMENANG=SYSDATE,PETUGAS_ID_PEMENANG='".$this->session->userdata('ID')."' WHERE ID_PEMENANG='".$data_post['id_pemenang']."'";
		$this->m_global->grid_view($sql);
		redirect(base_url('List_pemenang'));
	}
	
	public function get_data(){
		$posdata=$this->input->post();
		$sql="SELECT * FROM (SELECT ID_DETAIL_PEMENANG,PEMENANG_ID,NO_ITEM_NOMAT,HARGA_ITEM,ROW_NUMBER() OVER (ORDER BY HARGA_ITEM DESC) BARIS  FROM PRC_TENDER_PEMENANG_ITEM)
		WHERE PEMENANG_ID=".$posdata['id_pemenang'];
        $datatable = $this->m_global->array_view($sql);
        $data = array('data' => $datatable);
        echo json_encode($data);
		
		}
	
	public function ver_pemenang($n1) {
		// $this->authorization->roleCheck();
		$data['title'] = "Penetapan Pemenang";
		$this->layout->set_table_js();
        $this->layout->set_table_cs();
       $this->layout->add_js('pages/penetapan_pemenang.js');
	   $this->load->model('m_global');
		$sql="SELECT ID_PEMENANG,PTM_NUMBER,RFQ,KODE_VENDOR,HARGA_TERAKHIR,	'' NAMA_VENDOR,STATUS_PEMENANG,STATUS_WINER,TGL_ACT_PEMENANG
		FROM PRC_TENDER_PEMENANG WHERE STATUS_PEMENANG=1 AND ID_PEMENANG=".$n1;
		$data['data']=$this->m_global->array_view($sql);
		//print_r($data['data']); exit();
		$this->layout->render('ver_pemenang', $data);
	}

	public function data_detil($ptm_number) {
		
		
		redirect('List_pemenang/ver_pemenang/'.$ptm_number);
	}

	public function show($id) {
		$this->load->model('prc_tender_main');
		$data['ppm'] = $this->prc_tender_main->prc_tender_main->ptm($id);
		$data['ptm'] = $this->prc_tender_main->get(array('PTM_NUMBER' => $id));

		print_r($data);
		exit();

		$this->layout->render('show', $data);
	}

}
