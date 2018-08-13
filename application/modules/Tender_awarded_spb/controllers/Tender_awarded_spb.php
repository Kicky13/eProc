<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tender_awarded_spb extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->library('encrypt');
		$this->load->model(array('po_header_spb','spb','po_detail_spb'));
	}

	function index() {
		$data['title'] = "List PO";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/tender_awarded_spb.js?2');
		$this->layout->add_js('plugins/dataTables.rowsGroup.js');
		$this->layout->render('tender_awarded_list',$data);
	}

	function formSPB($id, $id_item, $id_spb = null) {
		$data['title'] = "Form SPB";
		$data['id'] = $id;
		$data['id_item'] = $id_item;
		$data['ID_SPB'] = $id_spb;

		$data['VENDOR_NO'] = $this->session->userdata('VENDOR_NO');
		$id=url_decode($id);
		$id_item=url_decode($id_item);
		$id_spb=url_decode($id_spb);

		$po_detail = $this->spb->getPoDetail(array('PO_ID'=>$id, 'POD_ID'=>$id_item));
		$data['po_detail'] = $po_detail[0];
		$qty_spb = $this->spb->total_qty_spb(array('VND_CODE'=>$this->session->userdata('VENDOR_NO'), 'SPB.POD_ID'=>$id_item));
		$SISA_QTY = $data['po_detail']['QTY_PO'] - ($data['po_detail']['TOTAL_MENGE']+$data['po_detail']['QUAN_TIMBANG']+$qty_spb[0]['QTY']);
		$data['SISA_QTY'] = $SISA_QTY;

		
		if($id_spb!=null){
			$spb_detail = $this->spb->get(array('SPB.ID'=>$id_spb));
			$data['spb_detail'] = $spb_detail[0];
		}
		
		$this->layout->render('spb_form',$data);
	}

	function insertSPB() {
		$ID_SPB = url_decode($this->input->post('ID_SPB'));

		$PLAT = strtoupper($this->input->post('PLAT'));
		$DRIVER = strtoupper($this->input->post('DRIVER'));
		$TUJUAN = strtoupper($this->input->post('TUJUAN'));
		$PO_ID_ENCODE = $this->input->post('PO_ID');
		$PO_ID = url_decode($PO_ID_ENCODE);
		$VND_CODE = $this->input->post('VND_CODE');
		$QTY = str_replace(',', '', $this->input->post('QTY'));
		$POD_ID = url_decode($this->input->post('POD_ID'));

		if($ID_SPB!=null || $ID_SPB!=""){
			$where['ID'] = $ID_SPB;

			$set['PLAT'] = $PLAT;
			$set['DRIVER'] = $DRIVER;
			$set['TUJUAN'] = $TUJUAN;
			$set['PO_ID'] = $PO_ID;
			$set['POD_ID'] = $POD_ID;
			$set['VND_CODE'] = $VND_CODE;
			$set['QTY'] = $QTY;
			$this->spb->update($set, $where);
			$pesan = "Sukses Mengubah SPB";
		} else {
			$po = array(
				'ID' => $this->spb->get_id(),
				'PLAT' => $PLAT,
				'DRIVER' => $DRIVER,
				'TUJUAN' => $TUJUAN,
				'PO_ID' => $PO_ID,
				'POD_ID' => $POD_ID,
				'VND_CODE' => $VND_CODE,
				'QTY' => $QTY,
				'CREATED_AT' => date('d-M-Y g.i.s A'),
			);
			$this->spb->insert($po);
			$pesan = "Sukses Menambahkan SPB";
		}
		$this->session->set_flashdata('success',$pesan);
		redirect('Tender_awarded_spb/indexSPB/'.$PO_ID_ENCODE);
	}

	function deleteSPB($id, $id_item, $id_spb = null) {
		$PO_ID_ENCODE = $id;
		$id=url_decode($PO_ID_ENCODE);
		$id_item=url_decode($id_item);
		$id_spb=url_decode($id_spb);

		$this->spb->delete($id_spb);

		$pesan = "Sukses Menghapus SPB";
		$this->session->set_flashdata('success',$pesan);
		redirect('Tender_awarded_spb/indexSPB/'.$PO_ID_ENCODE);
	}

	function cetak_spb($id) {
		// error_reporting(E_ALL);
		$id=url_decode($id);
		// $this->load->helper(array('tcpdf'));
		$this->load->library('M_pdf');
		$this->load->library('encrypt');

		$data['title'] = "SPB";

		$this->spb->join_vnd();
		$this->spb->join_po_header();
		$this->spb->join_po_detail2();
		$po = $this->spb->get(array('SPB.VND_CODE'=>$this->session->userdata('VENDOR_NO'),'SPB.ID'=>$id));
		$data['po'] = $po[0];
		// echo "<pre>";
		// print_r($data['po']);die;


		$key = 'SuperSecretKey';
		// $string = "PO_NUMBER=".$data['po']['PO_NUMBER']."&PLAT=".$data['po']['PLAT']."&DRIVER=".$data['po']['DRIVER']."&QTY=".$data['po']['QTY']."&VENDOR_NO=".$data['po']['VENDOR_NO']."&VENDOR_NAME=".$data['po']['VENDOR_NAME']."&POD_NOMAT=".$data['po']['MATNR'];
		$string = "PO_NUMBER=".$data['po']['PO_NUMBER']."&PLAT=".$data['po']['PLAT']."&ID=".$data['po']['ID'];

		//To Encrypt:
		$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));

		//To Decrypt:
		$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");

		// echo $encrypted;
		// echo "<br>";
		// echo "<br>";
		// echo $decrypted;
		// die;
		
		// QR
		$filename = $this->generateRandomString(20);
		$this->load->library('ci_qr_code');
		$params['data'] = $encrypted;
		$params['level'] = 'H';
		$params['size'] = 2;
		$params['savename'] = FCPATH . 'static/images/captcha/'.$filename.".png";
		$a = $this->ci_qr_code->generate($params);
		$data['qrpath'] = base_url().'static/images/captcha/'.$filename.".png";
		// QR

		$html = $this->load->view('po_barang_si', $data, true);      
		$this->m_pdf->pdf->WriteHTML($html);
		$this->m_pdf->pdf->setTitle($data['title']);

		// $footer = $this->load->view('po_footer_barang_si', $data, true);      
		// $this->m_pdf->pdf->SetHTMLFooter($footer);

		$this->m_pdf->pdf->Output($data['title'].".pdf",'I'); 
	}

	function indexSPB($id) {
		$data['title'] = "SPB List";
		$data['id'] = $id;
		$id=url_decode($id);
		$this->load->library('encrypt');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/spb.js?12');
		$this->layout->render('spb_list',$data);
	}

	function get_spb_list($id)
	{
		$id=url_decode($id);
		$this->spb->join_vnd();
		$this->spb->join_po_detail2();
		$this->spb->join_po_header();
		$po = $this->spb->get(array('SPB.VND_CODE'=>$this->session->userdata('VENDOR_NO'),'SPB.PO_ID'=>$id));
		$count = 0;
		$data = array();
		foreach ((array) $po as $key => $value) {	
			$data[$count] = $po[$key];

			$urlspb = base_url().'Tender_awarded_spb/cetak_spb/'.url_encode($value['ID']);                    
			
			$button = "";
			$button .= '<a title="Cetak SPB" href="'.$urlspb.'" target="_blank" class="btn btn-default btn-sm glyphicon glyphicon-print"></a> ';                    
			if($value['STATUS']==""){
				$update_spb = base_url().'Tender_awarded_spb/formSPB/'.url_encode($value['PO_ID']).'/'.url_encode($value['POD_ID']).'/'.url_encode($value['ID']);                    
				$button .= '<a title="Edit SPB" href="'.$update_spb.'" target="_blank" class="btn btn-default btn-sm glyphicon glyphicon-pencil"></a> ';

				$delete_spb = base_url().'Tender_awarded_spb/deleteSPB/'.url_encode($value['PO_ID']).'/'.url_encode($value['POD_ID']).'/'.url_encode($value['ID']);                    
				$button .= '<a title="Delete SPB" href="'.$delete_spb.'" class="btn btn-default btn-sm glyphicon glyphicon-trash"></a> ';                    
			}

			$data[$count]['FORM'] = $button;
			
			$data[$count]['ECT_PO_ID'] = url_encode($value['PO_ID']);
			$data[$count]['ECT_ID'] = url_encode($value['ID']);
			$data[$count]['PLAT'] = $value['PLAT'];
			$data[$count]['DRIVER'] = $value['DRIVER'];
			$data[$count]['VENDOR_NO'] = $value['VENDOR_NO'];
			$data[$count]['VENDOR_NAME'] = $value['VENDOR_NAME'];
			$data[$count]['QTY'] = $value['QTY'];
			$data[$count]['CREATED_AT'] = betteroracledate(oraclestrtotime($value['CREATED_AT']));
			$data[$count]['EBELP'] = $value['EBELP'];
			$data[$count]['NO_MAT'] = $value['MATNR'];
			$data[$count]['DET_MAT'] = $value['MAKTX'];
			$data[$count]['STATUS'] = $value['STATUS'];
			
			$count++;
		}
		echo json_encode(array('data' => $data));
	}

	function get_tender_awarded_list()
	{
		// error_reporting(E_ALL);
		$this->po_header_spb->join_vnd();
		$po = $this->po_header_spb->get(array('VENDOR_NO'=>$this->session->userdata('VENDOR_NO')));
		$count = 0;
		$data = array();
		foreach ((array) $po as $key => $value) {	
			$this->po_detail_spb->where_po($value['PO_ID']);
			$pod = $this->po_detail_spb->get();
			
			$data[$count] = $po[$key];
			$urlspb = base_url().'Tender_awarded_spb/indexSPB/'.url_encode($value['PO_ID']);                    
			$button = '<a title="SPB" href="'.$urlspb.'" target="_blank" class="btn btn-default btn-sm glyphicon glyphicon-th-list"></a> ';                    

			$data[$count]['FORM'] = $button;
			$data[$count]['ECT_PO_ID'] = url_encode($value['PO_ID']);
			$data[$count]['VENDOR_NO'] = $value['VENDOR'];
			$data[$count]['PO_NUMBER'] = $value['PO_NUMBER'];
			$data[$count]['EBELP'] = $pod[0]['EBELP'];
			$data[$count]['BSART'] = $pod[0]['BSART'];
			$data[$count]['STATU'] = $pod[0]['STATU'];
			$data[$count]['AEDAT'] = $pod[0]['AEDAT'];
			$data[$count]['LIFNR'] = $pod[0]['LIFNR'];
			$data[$count]['EKORG'] = $pod[0]['EKORG'];
			$data[$count]['EKGRP'] = $pod[0]['EKGRP'];
			$data[$count]['WKURS'] = $pod[0]['WKURS'];
			$data[$count]['WAERS'] = $pod[0]['WAERS'];
			$data[$count]['INCO1'] = $pod[0]['INCO1'];
			$data[$count]['INCO2'] = $pod[0]['INCO2'];
			$data[$count]['MEINS'] = $pod[0]['MEINS'];
			$data[$count]['TOTAL_MENGE'] = $pod[0]['TOTAL_MENGE'];
			$data[$count]['QUAN_TIMBANG'] = $pod[0]['QUAN_TIMBANG'];
			$data[$count]['BURKS'] = $pod[0]['BURKS'];
			$count++;
			// }
		}
		echo json_encode(array('data' => $data));
	}

	function get_tender_awarded_detail($id)
	{
		$id=url_decode($id);
		
		$this->po_detail_spb->where_po($id);
		$pod = $this->po_detail_spb->get();

		$count = 0;
		$data = array();
		foreach ((array) $pod as $key => $value) {

			$qty_spb = $this->spb->total_qty_spb(array('VND_CODE'=>$this->session->userdata('VENDOR_NO'), 'SPB.POD_ID'=>$value['POD_ID']));
			$SISA_QTY = $value['QTY_PO'] - ($value['TOTAL_MENGE']+$value['QUAN_TIMBANG']+$qty_spb[0]['QTY']);

			$data[$count] = $po[$key];
			$data[$count]['FORM'] = '<a href="'.base_url().'Tender_awarded_spb/formSPB/'.url_encode($value['PO_ID']).'/'.url_encode($value['POD_ID']).'" class="btn btn-info pull-left">Buat SPB</a>';
			$data[$count]['NO_MAT'] = $value['MATNR'];
			$data[$count]['DET_MAT'] = $value['MAKTX'];
			$data[$count]['PO_NUMBER'] = $value['PO_NUMBER'];
			$data[$count]['EBELP'] = $value['EBELP'];
			$data[$count]['BSART'] = $value['BSART'];
			$data[$count]['STATU'] = $value['STATU'];
			$data[$count]['AEDAT'] = $value['AEDAT'];
			$data[$count]['LIFNR'] = $value['LIFNR'];
			$data[$count]['EKORG'] = $value['EKORG'];
			$data[$count]['EKGRP'] = $value['EKGRP'];
			$data[$count]['WKURS'] = $value['WKURS'];
			$data[$count]['WAERS'] = $value['WAERS'];
			$data[$count]['INCO1'] = $value['INCO1'];
			$data[$count]['INCO2'] = $value['INCO2'];
			$data[$count]['MEINS'] = $value['MEINS'];
			$data[$count]['TOTAL_MENGE'] = $value['TOTAL_MENGE'];
			$data[$count]['QUAN_TIMBANG'] = $value['QUAN_TIMBANG'];
			$data[$count]['QTY_PO'] = $value['QTY_PO'];
			$data[$count]['QTY_SPB'] = $qty_spb[0]['QTY'];
			$data[$count]['SISA_QTY'] = $SISA_QTY;
			$data[$count]['BURKS'] = $value['BURKS'];
			
			$count++;
		}
		echo json_encode(array('data' => $data));
	}

	function refreshPO() {
		// error_reporting(E_ALL);
		// print_r($this->session->userdata);die;
		$no_po = $this->input->post('no_po');
		$this->load->library('sap_handler');
		
		$check_po_db = $this->po_header_spb->get(array('PO_NUMBER'=>$no_po));
		if(count($check_po_db)>0){
			$aksi = 'update';
		} else {
			$aksi = 'insert';
			$PO_ID = $this->po_header_spb->get_id();
		}
		$ambil_data = $this->sap_handler->getPOSpb($this->session->userdata('COMPANYID'), $this->session->userdata('VENDOR_NO'), $no_po);
		// echo "<pre>";
		// print_r($ambil_data);die;
		$count = 0;
		$data = array();
		foreach ($ambil_data as $ad) {

			if($ad['EBELN']==$no_po){
				// header
				if($aksi == 'update' && $count == 0){
					$where['PO_NUMBER'] = $ad['EBELN'];
					$set['VENDOR'] = $this->session->userdata('VENDOR_NO');
					$this->po_header_spb->update($set, $where);
				} else if($aksi == 'insert' && $count == 0){
					$header['PO_ID'] = $PO_ID;
					$header['PO_NUMBER'] = $ad['EBELN'];
					$header['VENDOR'] = $this->session->userdata('VENDOR_NO');
					$this->po_header_spb->insert($header);
				}
				// header

				//detail
				$check_po_item_db = $this->po_detail_spb->get_check_update(array('EBELN'=>$ad['EBELN'], 'EBELP'=>$ad['EBELP']));
				if(count($check_po_item_db)>0){
					$aksi_item = 'update';
				} else {
					$aksi_item = 'insert';
				}

				if($aksi_item == 'update'){
					$where1['EBELN'] = $ad['EBELN'];
					$where1['EBELP'] = $ad['EBELP'];

					$set1['BSART'] = $ad['BSART'];
					$set1['STATU'] = $ad['STATU'];
					$set1['AEDAT'] = $ad['AEDAT'];
					$set1['LIFNR'] = $ad['LIFNR'];
					$set1['EKORG'] = $ad['EKORG'];
					$set1['EKGRP'] = $ad['EKGRP'];
					$set1['WKURS'] = $ad['WKURS'];
					$set1['WAERS'] = $ad['WAERS'];
					$set1['INCO1'] = $ad['INCO1'];
					$set1['INCO2'] = $ad['INCO2'];
					$set1['MEINS'] = $ad['MEINS'];
					$set1['TOTAL_MENGE'] = $ad['TOTAL_MENGE'];
					$set1['QUAN_TIMBANG'] = $ad['QUAN_TIMBANG'];
					$set1['BURKS'] = $ad['BUKRS'];
					$set1['MATNR'] = $ad['MATNR'];
					$set1['MAKTX'] = $ad['MAKTX'];

					$set1['QTY_PO'] = $ad['QUAN_PO'];
					$set1['CODE_PLANT'] = $ad['WERKS'];
					$set1['PLANT'] = $ad['NAME_PLANT'];

					$this->po_detail_spb->update($set1, $where1);
				} else if($aksi_item == 'insert'){
					$data['POD_ID'] = $this->po_detail_spb->get_id();
					$data['PO_ID'] = $PO_ID;

					$data['EBELP'] = $ad['EBELP'];
					$data['BSART'] = $ad['BSART'];
					$data['STATU'] = $ad['STATU'];
					$data['AEDAT'] = $ad['AEDAT'];
					$data['LIFNR'] = $ad['LIFNR'];
					$data['EKORG'] = $ad['EKORG'];
					$data['EKGRP'] = $ad['EKGRP'];
					$data['WKURS'] = $ad['WKURS'];
					$data['WAERS'] = $ad['WAERS'];
					$data['INCO1'] = $ad['INCO1'];
					$data['INCO2'] = $ad['INCO2'];
					$data['MEINS'] = $ad['MEINS'];
					$data['TOTAL_MENGE'] = $ad['TOTAL_MENGE'];
					$data['QUAN_TIMBANG'] = $ad['QUAN_TIMBANG'];
					$data['BURKS'] = $ad['BUKRS'];
					$data['MATNR'] = $ad['MATNR'];
					$data['MAKTX'] = $ad['MAKTX'];
					$data['EBELN'] = $ad['EBELN'];

					$data['QTY_PO'] = $ad['QUAN_PO'];
					$data['CODE_PLANT'] = $ad['WERKS'];
					$data['PLANT'] = $ad['NAME_PLANT'];

					$this->po_detail_spb->insert($data);
				}
				
				$count++;
				//detail
			}

		}

		// echo "<pre>";
		// print_r($data);die;
		redirect('Tender_awarded_spb');

	}

	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}