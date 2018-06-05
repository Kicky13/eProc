<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Po extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
	}

	public function index() {
		$data['title'] = "PO";
		$this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_js('pages/po_list.js');
		$this->layout->render('list_po', $data);
	}

	public function get_datatable() {
		$this->load->model('po_header');
		$datatable = $this->po_header->get();
        $data = array('data' => $datatable);
        echo json_encode($data);
	}

	public function show($id){
		$po_id = $id;
		$this->load->model('po_detail');
		$this->load->model('po_header');

		$this->po_header->where_po($po_id);
		$po = $this->po_header->get();

		$this->po_detail->where_po($po_id);
		$pod = $this->po_detail->get();

		$data['po'] = $po[0];
		$data['pod'] = $pod;
		// var_dump($pod);
		// exit();
		$data['title'] = "Detail PO";
		$this->layout->set_table_js();
        $this->layout->set_table_cs();
		$this->layout->add_js('pages/detail_po.js');
		$this->layout->render('show', $data);
	}

/////////////////////////////////////////////////////////////////

	public function submit($id = null,$ppr_plant = null) {
		$this->load->model('po_detail');
		$this->load->model('po_header');
		$this->load->model('prc_tender_winner');
		$winner = $this->input->post('winner');
		$satu = 0;
		foreach ($winner as $key => $each_winner) {
			$data = $this->prc_tender_winner->get($each_winner);
			if($satu == 0){
				$po_id = $this->po_header->get_id();
				$po = array(
					'PO_ID' => $po_id,
					'PO_CREATED_BY' => $this->authorization->getEmployeeId(),
					'PO_CREATED_AT' => date('d-M-Y g.i.s A'),
					'VND_CODE' => $data[0]['PTV_VENDOR_CODE'],
					'VND_NAME' => $data[0]['VENDOR_NAME']
					);
				$this->po_header->insert($po);
				$satu++;
			}

			$pod_id = $this->po_detail->get_id();
			$pod = array(
				'POD_ID' => $pod_id,
				'PO_ID' => $po_id,
				'POD_DECMAT' => $data[0]['PPI_DECMAT'],
				'POD_NOMAT' => $data[0]['PPI_NOMAT'],
				'POD_QTY' => $data[0]['TIT_QUANTITY'],
				'POD_PRICE' => $data[0]['PQI_PRICE'],
				'PPI_ID' => $data[0]['PPI_ID'],
				'PPR_PRNO' => $data[0]['PPR_PRNO'],
				);
			$this->po_detail->insert($pod);
		}
		redirect('Tender_winner/');
	}

	public function delete(){
		$this->load->model('prc_tender_winner');
		$id = $this->input->post('submit');
		$this->prc_tender_winner->delete($id);
		redirect('Tender_winner/');
	}

	public function view() {
		// $this->authorization->roleCheck();
		$data['title'] = "Pembuatan PO";
		$this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->add_js('pages/list_po.js');
		$this->layout->render('list_po', $data);
	}

	
	
	public function update_status() {
		$this->load->model('m_global');
		$data_post=$this->input->post();
		
		$sql="UPDATE PRC_TENDER_PEMENANG SET STATUS_PEMENANG=3,TGL_ACTION_PO=SYSDATE,PETUGAS_ID_P0='".$this->session->userdata('ID')."' WHERE ID_PEMENANG='".$data_post['id_pemenang']."'";
		$this->m_global->grid_view($sql);
		redirect(base_url('Create_po'));
	}
	
	public function get_data(){
		$posdata1=$this->input->post();
		$sql="SELECT * FROM (SELECT ID_DETAIL_PEMENANG,PEMENANG_ID,NO_ITEM_NOMAT,HARGA_ITEM,ROW_NUMBER() OVER (ORDER BY HARGA_ITEM DESC) BARIS  FROM PRC_TENDER_PEMENANG_ITEM)
		WHERE PEMENANG_ID='".$posdata1['id_pemenang']."'";
        $datatable = $this->m_global->array_view($sql);
        $data = array('data' => $datatable);
        echo json_encode($data);
		
		}
	
	public function ver_pemenang($n1) {
		// $this->authorization->roleCheck();
		$data['title'] = "Ceate PO";
		$this->layout->set_table_js();
        $this->layout->set_table_cs();
       $this->layout->add_js('pages/create_po.js');
	   $this->load->model('m_global');
		$sql="SELECT ID_PEMENANG,PTM_NUMBER,RFQ,KODE_VENDOR,HARGA_TERAKHIR,	'' NAMA_VENDOR,STATUS_PEMENANG,STATUS_WINER,TGL_ACT_PEMENANG
		FROM PRC_TENDER_PEMENANG WHERE STATUS_PEMENANG=2 AND ID_PEMENANG=".$n1;
		$data['data']=$this->m_global->array_view($sql);
		//print_r($data['data']); exit();
		$this->layout->render('ver_po', $data);
	}

	public function data_detil($ptm_number) {
		
		
		redirect('Create_po/ver_pemenang/'.$ptm_number);
	}
}
