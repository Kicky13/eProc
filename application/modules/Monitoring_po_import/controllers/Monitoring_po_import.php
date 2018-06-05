<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring_po_import extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('email');
		$this->load->library('form_validation');
		$this->load->library("file_operation");
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->helper('url');
		$this->kolom_xl = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	}

	function index()
	{
		$data['title'] = 'Transaksi PO';
		$this->load->model('monitoring_po_import_m');
		//inco = tod
		$data['tod'] = $this->monitoring_po_import_m->getInco1();
		$data['country'] = $this->monitoring_po_import_m->getCountry();

		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/monitoring_po_transaksi.js');
		$this->layout->add_js('pages/EC_auction_only_number_format.js');
		$this->layout->add_js('jquery.maskedinput.js');
		$this->layout->render('transaksi_po', $data);

	}

	function detailIndexPo($NO_PO)
	{
		$data['title'] = 'Transaksi PO'.$NO_PO;
		$data['NO_PO'] = $NO_PO;
		$this->load->model('monitoring_po_import_m');
		
		//inco = tod
		$data['tod'] = $this->monitoring_po_import_m->getInco1();
		$data['country'] = $this->monitoring_po_import_m->getCountry();
		
		$this->layout->set_table_js();
		$this->layout->set_table_cs();

		$this->layout->set_datetimepicker();
		$this->layout->add_js("strTodatetime.js");
		// $this->layout->add_js('pages/mydatetimepicker.js');

		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');

		$this->layout->add_js('pages/monitoring_po_transaksi_detail.js');
		$this->layout->add_js('pages/EC_auction_only_number_format.js');
		$this->layout->add_js('jquery.maskedinput.js');
		// echo "<pre>";
		// print_r($data);die;
		$this->layout->render('transaksi_po_detail', $data);

	}



	function updatePoImportSap()
	{
		$company = 2000;
		$this->doUpdatePoImportSap($company);
		$company1 = 5000;
		$this->doUpdatePoImportSap($company1);

		$data['success'] = true;
		echo json_encode($data);
	}

	function doUpdatePoImportSap($company)
	{
		$iduser = $this->session->userdata['ID'];
		//$company = 2000;
		$this->load->model('monitoring_po_import_m');
		$this->load->library('sap_handler');
		$invoice = $this->sap_handler->getPoImport($company);
		// echo "<pre>";
		// print_r($invoice);
		// echo count($invoice);die;
		if(count($invoice) > 0){
			foreach($invoice['T_EKKO'] as $value){
				$checkPoSap = $this->monitoring_po_import_m->checkPOSAP($value['EBELN']);
				$checkPo = $this->monitoring_po_import_m->checkPO($value['EBELN']);
				$checkPoHeaderSap = $this->monitoring_po_import_m->checkPOHeaderSAP($value['EBELN']);
				$nopo1 = $value['EBELN'];
				if(count($checkPoHeaderSap)==0){
					$data['NO_PO'] = $value['EBELN'];
					$data['STAT_APPROVAL'] = $value['PROCSTAT'];
					$data['TOD'] = $value['INCO1'];
					$data['ID_USER'] = $iduser;
					$data['COMPANY'] = $company;
				}
				foreach($invoice['T_EKPO'] as $value){
					// $checkPoSap = $this->monitoring_po_import_m->checkPOSAP($value['EBELN']);
					// $checkPo = $this->monitoring_po_import_m->checkPO($value['EBELN']);
					// if(count($checkPoSap)>1 && count($checkPo)==0){
						// $where_edit['NO_PO'] 	= $value['EBELN'];
						// $set_edit['DESC'] 	= $value['TXZ01'];
						// $set_edit['QTY'] 	= $value['EBELP'];
						// $set_edit['NILAI_PO'] 	= $value['NETWR'];
						// $set_edit['SATUAN'] 	= $value['MEINS'];
						// $set_edit['NO_ITEM'] 	= $value['MATNR'];
						// $set_edit['VENDOR'] 	= $invoice['T_DATA'][$i]['NAME1'];
						// $this->monitoring_po_import_m->updatePO($set_edit, $where_edit);
					// } else {
					$nopo2 = $value['EBELN'];
					
					if($nopo1 == $nopo2){
						if(count($checkPoHeaderSap)==0){
							$data1['DESC'] 		= $value['TXZ01'];
							$data1['QTY'] 		= $value['EBELP'];
							$data1['NILAI_PO'] 	= $value['NETWR'];
							$data1['SATUAN'] 	= $value['MEINS'];
							$data1['NO_ITEM'] 	= $value['MATNR'];
							$data1['NO_PO'] 	= $value['EBELN'];
							$this->monitoring_po_import_m->addItemSap($data1);
						}
					}
					// }
				}
				if(count($checkPoHeaderSap)==0){	
					$this->monitoring_po_import_m->addItemSapHeader($data);
				}
			}

			foreach($invoice['T_DATA'] as $value){
				$checkPoSap = $this->monitoring_po_import_m->checkPOSAP($value['EBELN']);
				$checkPo = $this->monitoring_po_import_m->checkPO($value['EBELN']);
				if(count($checkPoSap)>1 && count($checkPo)==0){
					$where_edit['NO_PO'] 	= $value['EBELN'];
					$set_edit['VENDOR'] 	= $value['LIFNR'];

					$this->monitoring_po_import_m->updatePO($set_edit, $where_edit);
				}
			}

			if (array_key_exists("T_HISTORY",$invoice)){
				foreach($invoice['T_HISTORY'] as $value){
					$checkPoSap = $this->monitoring_po_import_m->checkPOSAP($value['EBELN']);
					$checkPo = $this->monitoring_po_import_m->checkPO($value['EBELN']);
					if(count($checkPoSap)>1 && count($checkPo)==0){
						if($value['VGABE']==2 || $value['VGABE']=="2"){
							$where_edit['NO_PO'] 	= $value['EBELN'];
							$set_edit['VGABE'] 		= $value['VGABE'];
							$set_edit['NO_PPL'] 		= $value['BELNR'];
							$this->monitoring_po_import_m->updatePO($set_edit, $where_edit);
						}
					}
				}
			}
		}
	}	

	function getPoImportSap()
	{
		$iduser = $this->session->userdata['ID'];
		//$company = 2000;
		$company = $this->input->post('company');
		$this->load->model('monitoring_po_import_m');

		$tampil = '';
		$i=0;

		$dataSAP = $this->monitoring_po_import_m->getPOHeaderSAP($company);
		foreach ($dataSAP as $value1){
			$dataSAPitem = $this->monitoring_po_import_m->getTranslistSAP2($value1['NO_PO']);
			$c=0;
			foreach ($dataSAPitem as $value){
				$tombol = '';
				if($c==0){
					$tombol = '
					<input type="checkbox" name="no_po[]" value="'.$value['NO_PO'].'">'.++$i.'
					';
				}
				// $tampil.='
				// <tr>
				// 	'.$tombol.'
				// 	<td> '.$value['NO_PO'].'</td>
				// 	<td> '.$value['NO_ITEM'].'</td>
				// 	<td> '.$value['DESC'].'</td>
				// 	<td> '.$value['VENDOR_NAME'].'</td>
				// 	<td> '.$value['QTY'].'</td>
				// 	<td> '.$value['NILAI_PO'].'</td>
				// 	<td> '.$value['STAT_APPROVAL'].'</td>
				// 	<td> '.$value['SATUAN'].'</td>
				// 	<td> '.$value['TOD'].'</td>
				// </tr>
				// ';

				$DT = array();
				$DT['TOMBOL1'] = $tombol;
				$DT['NO_PO'] = $value['NO_PO'];
				$DT['NO_ITEM'] = $value['NO_ITEM'];
				$DT['DESC'] = $value['DESC'];
				$DT['VENDOR_NAME'] = $value['VENDOR_NAME'];
				$DT['QTY'] = $value['QTY'];
				$DT['NILAI_PO'] = $value['NILAI_PO'];
				$DT['STAT_APPROVAL'] = $value['STAT_APPROVAL'];
				$DT['SATUAN'] = $value['SATUAN'];
				$DT['TOD'] = $value['TOD'];
				$datatable[] = $DT;

				$c++;
			}												
		}
		// echo $tampil;
		$data = array('data' => isset($datatable)?$datatable:'');
		echo json_encode($data);
	}

	function getPoImportDB()
	{
		$company = $this->input->post('company');
		$this->load->model('monitoring_po_import_m');
		$iduser = $this->session->userdata['ID'];
		
		$tampil = '';
		$i=0;

		$dataSAP = $this->monitoring_po_import_m->getPOHeader($company);
		foreach ($dataSAP as $value1){
			$dataSAPitem = $this->monitoring_po_import_m->getTranslist2($value1['NO_PO']);
			$c=0;
			foreach ($dataSAPitem as $value){
				// SEBELUMNYA ADA <TD></TD>
				$tombol = '';
				$tombol2 = '';
				if($c==0){
					$tombol = '
					<input type="checkbox" name="no_po[]" value="'.$value['NO_PO'].'">'.++$i.'
					';

					$tombol2 = '
					<a href="'.base_url().'Monitoring_po_import/detailIndexPo/'.$value['NO_PO'].'" class="btn btn-warning btn-sm btn-edit-ganti" target="_blank" no_po="'.$value['NO_PO'].'">
						Edit
					</a>
					';
				}
				// $tampil.='
				// <tr>
				// 	'.$tombol.'
				// 	<td> '.$value['NO_PO'].'</td>
				// 	<td> '.$value['NO_ITEM'].'</td>
				// 	<td> '.$value['DESC'].'</td>
				// 	<td> '.$value['VENDOR_NAME'].'</td>
				// 	<td> '.$value['QTY'].'</td>
				// 	<td> '.$value['NILAI_PO'].'</td>
				// 	<td> '.$value['STAT_APPROVAL'].'</td>
				// 	<td> '.$value['SATUAN'].'</td>
				// 	<td> '.$value['TOD'].'</td>
				// 	'.$tombol2.'
				// </tr>
				// ';

				$DT = array();
				$DT['TOMBOL1'] = $tombol;
				$DT['NO_PO'] = $value['NO_PO'];
				$DT['NO_ITEM'] = $value['NO_ITEM'];
				$DT['DESC'] = $value['DESC'];
				$DT['VENDOR_NAME'] = $value['VENDOR_NAME'];
				$DT['QTY'] = $value['QTY'];
				$DT['NILAI_PO'] = $value['NILAI_PO'];
				$DT['STAT_APPROVAL'] = $value['STAT_APPROVAL'];
				$DT['SATUAN'] = $value['SATUAN'];
				$DT['TOD'] = $value['TOD'];
				$DT['TOMBOL2'] = $tombol2;
				$datatable[] = $DT;

				$c++;
			}												
		}
		// echo $tampil;
		$data = array('data' => isset($datatable)?$datatable:'');
		echo json_encode($data);
	}


	function saveSelected()
	{
		$this->load->model('monitoring_po_import_m');
		$no_po = $this->input->post('no_po');
		// echo count($no_po);
		// print_r($no_po);
		// die;
		
		if($no_po==""){
		} else {

			$getLastID = $this->monitoring_po_import_m->getMasterPOTrans();
			if(count($getLastID)==0){
				$ID = 1;
			} else {
				$ID = $getLastID['ID']+1;
			}

			for($i=0;$i<count($no_po);$i++){
				$dt = $this->monitoring_po_import_m->saveSelected($no_po[$i]);
				$data1['ID'] 		= $ID;
				$data1['NO_PO'] 	= $no_po[$i];
				$this->monitoring_po_import_m->save($data1);
				// $this->monitoring_po_import_m->saveVenCus($data1);
				// $this->monitoring_po_import_m->saveDocShip($data1);
				// $this->monitoring_po_import_m->saveVenBiaya($data1);
				$ID=$ID+1;
			}
		}

		redirect('Monitoring_po_import/');
	}

	function saveAll()
	{
		$iduser = $this->session->userdata['ID'];
		$this->load->model('monitoring_po_import_m');
		
		$getLastID = $this->monitoring_po_import_m->getMasterPOTrans();
		if(count($getLastID)==0){
			$ID = 1;
		} else {
			$ID = $getLastID['ID']+1;
		}
		
		$data = $this->monitoring_po_import_m->beforeSave($iduser);
		if(count($data)>0){
			foreach ($data as $dt) {
				$data1['ID'] 		= $ID;
				$data1['NO_PO'] 	= $dt['NO_PO'];
				$this->monitoring_po_import_m->save($data1);
			}
		}
		redirect('Monitoring_po_import/');
	}

	function detailPo()
	{
		$no_po = $this->input->post('no_po');
		$iduser = $this->session->userdata['ID'];
		$this->load->model('monitoring_po_import_m');
		
		$data = $this->monitoring_po_import_m->getDetailPo($no_po);
		$data2 = $this->monitoring_po_import_m->checkPO($no_po);
		$data['NEW_DELIVERY_DATE'] = date('Y-m-d', strtotime($data['DELIVERY_DATE']));
		$data['NEW_TGL_RELEASE'] = date('Y-m-d', strtotime($data['TGL_RELEASE']));
		$data['NEW_TGL_AMEND'] = date('Y-m-d', strtotime($data['TGL_AMEND']));
		$data['NEW_TGL_NEGO'] = date('Y-m-d', strtotime($data['TGL_NEGO']));
		$data['NEW_AKHIR_NEGO'] = date('Y-m-d', strtotime($data['AKHIR_NEGO']));
		$data['NEW_NILAI'] = number_format($data['NILAI'],0,".",".");
		$data['NO_PPL'] = $data2['NO_PPL'];
		// print_r($data);

		echo json_encode($data);
	}

	function detailDocShip()
	{
		$id = $this->input->post('id');
		$iduser = $this->session->userdata['ID'];
		$this->load->model('monitoring_po_import_m');
		
		$data['DOC_SHIP'] = $this->monitoring_po_import_m->getDetailDocShip3($id);
		$data['NEW_TGL_BL'] = date('Y-m-d', strtotime($data['DOC_SHIP']['TGL_BL']));
		$data['NEW_TGL_ETA'] = date('Y-m-d', strtotime($data['DOC_SHIP']['TGL_ETA']));
		$data['NEW_NILAI_INV'] = number_format($data['DOC_SHIP']['NILAI_INV'],0,".",".");
		$data['NEW_KUANTITAS_BL'] = number_format($data['DOC_SHIP']['KUANTITAS_BL'],0,".",".");
		$data['NEW_JML_CONTAINER'] = number_format($data['DOC_SHIP']['JML_CONTAINER'],0,".",".");

		echo json_encode($data);
	}

	function detailCustom()
	{
		$id = $this->input->post('id');
		$iduser = $this->session->userdata['ID'];
		$this->load->model('monitoring_po_import_m');
		
		$data['DOC_CUSTOM'] = $this->monitoring_po_import_m->getDetailCustom($id);


		$data['NEW_TGL_BAYAR'] 		= date('Y-m-d', strtotime($data['DOC_CUSTOM']['TGL_BAYAR']));
		$data['NEW_TGL_BERLAKU'] 	= date('Y-m-d', strtotime($data['DOC_CUSTOM']['TGL_BERLAKU']));
		$data['NEW_TGL_SPTNP'] 		= date('Y-m-d', strtotime($data['DOC_CUSTOM']['TGL_SPTNP']));
		$data['NEW_TGL_MANIFEST'] 	= date('Y-m-d', strtotime($data['DOC_CUSTOM']['TGL_MANIFEST']));
		$data['NEW_TGL_TA'] 		= date('Y-m-d', strtotime($data['DOC_CUSTOM']['TGL_TA']));
		
		$data['NEW_TGL_BERLAKU_LS'] = date('Y-m-d', strtotime($data['DOC_CUSTOM']['TGL_BERLAKU_LS']));
		$data['NEW_TGL_SPPB'] 		= date('Y-m-d', strtotime($data['DOC_CUSTOM']['TGL_SPPB']));
		$data['NEW_TGL_CERT'] 		= date('Y-m-d', strtotime($data['DOC_CUSTOM']['TGL_CERT']));
		$data['NEW_TGL_PIB'] 		= date('Y-m-d', strtotime($data['DOC_CUSTOM']['TGL_PIB']));
		$data['NEW_TGL_DO'] 		= date('Y-m-d', strtotime($data['DOC_CUSTOM']['TGL_DO']));


		$data['NEW_OTHER'] 			= number_format($data['DOC_CUSTOM']['OTHER'],0,".",".");
		$data['NEW_KUOTA_LARTAS'] 	= number_format($data['DOC_CUSTOM']['KUOTA_LARTAS'],0,".",".");
		$data['NEW_SISA_KUOTA'] 	= number_format($data['DOC_CUSTOM']['SISA_KUOTA'],0,".",".");
		$data['NEW_NILAI_LS'] 		= number_format($data['DOC_CUSTOM']['NILAI_LS'],0,".",".");

		echo json_encode($data);
	}

	function detailBiaya()
	{
		$id = $this->input->post('id');
		$iduser = $this->session->userdata['ID'];
		$this->load->model('monitoring_po_import_m');
		
		$data['DOC_BIAYA'] = $this->monitoring_po_import_m->getDetailVenBiaya($id);
		// echo "<pre>";
		// print_r($data['DOC_BIAYA']);die;
		$data['KET'] 		= $data['DOC_BIAYA']['KET'];
		$data['OTHER'] 		= $data['DOC_BIAYA']['OTHER'];
		$data['NEW_TOT_TAGIHAN_KONTRAK'] = number_format($data['DOC_BIAYA']['TOT_TAGIHAN_KONTRAK'],0,".",".");
		$data['NEW_NILAI_ONGKOS_ANGKUT'] = number_format($data['DOC_BIAYA']['NILAI_ONGKOS_ANGKUT'],0,".",".");
		$data['NEW_NILAI_LAIN_KONTRAK'] = number_format($data['DOC_BIAYA']['NILAI_LAIN_KONTRAK'],0,".",".");
		$data['NEW_TOTAL_TAGIHAN_COST'] = number_format($data['DOC_BIAYA']['TOTAL_TAGIHAN_COST'],0,".",".");
		$data['NEW_STORAGE'] = number_format($data['DOC_BIAYA']['STORAGE'],0,".",".");
		$data['NEW_NILAI_LAIN'] = number_format($data['DOC_BIAYA']['NILAI_LAIN'],0,".",".");
		$data['NEW_FEE'] = number_format($data['DOC_BIAYA']['FEE'],0,".",".");
		$data['NEW_BIAYA_FREIGHT'] = number_format($data['DOC_BIAYA']['BIAYA_FREIGHT'],0,".",".");

		echo json_encode($data);
	}


	function updateDetailPo()
	{
		$iduser = $this->session->userdata['ID'];
		$this->load->model('monitoring_po_import_m');

		// echo "<pre>";
		// echo $_FILES['DOC_PO']['tmp_name'];
		// print_r($_FILES);die();

		$DOC_PO 			= $_FILES['DOC_PO']['tmp_name'];
		$DOC_LC 			= $_FILES['DOC_LC']['tmp_name'];
		$APPROVE_PEMENANG 	= $_FILES['APPROVE_PEMENANG']['tmp_name'];
		$DOC_OK 			= $_FILES['DOC_OK']['tmp_name'];
		// $DOC_PPL 			= $_FILES['DOC_PPL']['tmp_name'];
		// $DOC_SHIPPING 		= $_FILES['DOC_SHIPPING']['tmp_name'];
		
		$tes 				= dirname(__FILE__);
		$pet_pat 			= str_replace('application/modules/Monitoring_po_import/controllers', '', $tes);

		//echo $pet_pat;die;
		$where_edit['NO_PO'] 	= $this->input->post('NO_PO');

		if (isset($_FILES) && !empty($_FILES['DOC_PO']['name'])) {
			$type = explode('.', $_FILES['DOC_PO']['name']);
			if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_PO".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_PO, $this->_path)) {
                	$set_edit1['DOC_PO'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateDetailPO($set_edit1, $where_edit);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['DOC_LC']['name'])) {
        	$type = explode('.', $_FILES['DOC_LC']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_LC".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_LC, $this->_path)) {
                	$set_edit2['DOC_LC'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateDetailPO($set_edit2, $where_edit);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['APPROVE_PEMENANG']['name'])) {
        	$type = explode('.', $_FILES['APPROVE_PEMENANG']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "APPROVE_PEMENANG".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($APPROVE_PEMENANG, $this->_path)) {
                	$set_edit3['APPROVE_PEMENANG'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateDetailPO($set_edit3, $where_edit);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['DOC_OK']['name'])) {
        	$type = explode('.', $_FILES['DOC_OK']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_OK".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_OK, $this->_path)) {
                	$set_edit4['DOC_OK'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateDetailPO($set_edit4, $where_edit);
                }
            }
        }

        $set_edit['TOP'] 		= $this->input->post('TOP');
        $set_edit['TOD'] 		= $this->input->post('TOD');
        $set_edit['NILAI_TOLERANSI'] = $this->input->post('NILAI_TOLERANSI');
        $set_edit['NO_LC'] 		= $this->input->post('NO_LC');
        $set_edit['LSD'] 		= $this->input->post('LSD');
        $set_edit['EXPIRY'] 	= $this->input->post('EXPIRY');
        $set_edit['KET'] 		= $this->input->post('KET');
        $set_edit['NILAI'] 		= str_replace('.', '', $this->input->post('NILAI'));
        $set_edit['FORWARDER'] 	= $this->input->post('FORWARDER');
        $this->monitoring_po_import_m->updateDetailPO($set_edit, $where_edit);

        $data['NO_PO'] 			= $this->input->post('NO_PO');
        $data['DELIVERY_DATE'] 	= $this->input->post('DELIVERY_DATE');
        $data['TGL_RELEASE'] 	= $this->input->post('TGL_RELEASE');
        $data['TGL_AMEND'] 		= $this->input->post('TGL_AMEND');
        $data['TGL_NEGO'] 		= $this->input->post('TGL_NEGO');
        $data['AKHIR_NEGO'] 	= $this->input->post('AKHIR_NEGO');
        $this->monitoring_po_import_m->updatePO2($data);

        // if (isset($_FILES) && !empty($_FILES['DOC_PPL']['name'])) {
        // 	$type = explode('.', $_FILES['DOC_PPL']['name']);
        // 	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
        //         $this->_myFile = "DOC_PPL".$iduser . date('YmdHms') . "." . end($type);//get terakhir
        //         $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
        //         if (move_uploaded_file($DOC_PPL, $this->_path)) {
        //         	$set_edit5['DOC_PPL'] 	= $this->_myFile;
        //         	$this->monitoring_po_import_m->updateDocShip($set_edit5, $where_edit);
        //         }
        //     }
        // }

        // if (isset($_FILES) && !empty($_FILES['DOC_SHIPPING']['name'])) {
        // 	$type = explode('.', $_FILES['DOC_SHIPPING']['name']);
        // 	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
        //         $this->_myFile = "DOC_SHIPPING".$iduser . date('YmdHms') . "." . end($type);//get terakhir
        //         $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
        //         if (move_uploaded_file($DOC_SHIPPING, $this->_path)) {
        //         	$set_edit6['DOC_SHIPPING'] 	= $this->_myFile;
        //         	$this->monitoring_po_import_m->updateDocShip($set_edit6, $where_edit);
        //         }
        //     }
        // }


        // $set_edit7['NO_BL'] 		= $this->input->post('NO_BL');
        // $set_edit7['NAMA_ANGKUT'] 	= $this->input->post('NAMA_ANGKUT');
        // $set_edit7['POL'] 			= $this->input->post('POL');
        // $set_edit7['POD'] 			= $this->input->post('POD');
        // $set_edit7['NEGARA_ASAL'] 	= $this->input->post('NEGARA_ASAL');
        // $set_edit7['NO_PPL_BARANG'] = $this->input->post('NO_PPL_BARANG');
        // $set_edit7['JENIS_KEMASAN'] = $this->input->post('JENIS_KEMASAN');
        // $set_edit7['SATUAN'] 		= $this->input->post('SATUAN');
        // $set_edit7['NILAI_INV'] 	= str_replace('.', '', $this->input->post('NILAI_INV'));
        // $set_edit7['KUANTITAS_BL'] 	= str_replace('.', '', $this->input->post('KUANTITAS_BL'));
        // $set_edit7['JML_CONTAINER'] = str_replace('.', '', $this->input->post('JML_CONTAINER'));
        // $this->monitoring_po_import_m->updateDocShip($set_edit7, $where_edit);


        // $data1['NO_PO'] 		= $this->input->post('NO_PO');
        // $data1['TGL_BL'] 	= $this->input->post('TGL_BL');
        // $data1['TGL_ETA'] 	= $this->input->post('TGL_ETA');
        // $this->monitoring_po_import_m->updateDocShip2($data1);
        $NO_PO = $this->input->post('NO_PO');
        redirect('Monitoring_po_import/detailIndexPo/'.$NO_PO);
    }

    function getListDocShip()
    {
    	$this->load->model('monitoring_po_import_m');
    	$iduser = $this->session->userdata['ID'];

    	$tampil = '';
    	$i=0;
    	$NO_PO 	= $this->input->post('no_po');
    	// $dataDocShip = $this->monitoring_po_import_m->getlistDocShip($NO_PO);
    	// echo $NO_PO."aaa";
    	// echo count($dataDocShip);
    	// print_r($dataDocShip);
    	// foreach ($dataDocShip as $value){
    	// 	$i++;
    	// 	$tampil.='
    	// 	<tr>
    	// 		<td> '.$i.'</td>
    	// 		<td> '.$value['NO_PO'].'</td>
    	// 		<td> '.$value['NILAI_INV'].'</td>
    	// 		<td> '.$value['NEGARA_ASAL'].'</td>
    	// 		<td> '.date('d F Y', strtotime($value['TGL_BL'])).'</td>
    	// 		<td> '.date('d F Y', strtotime($value['TGL_ETA'])).'</td>
    	// 		<td> <a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_PPL'].'">'.$value['DOC_PPL'].'</a></td>
    	// 		<td> <a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_SHIPPING'].'">'.$value['DOC_SHIPPING'].'</a></td>
    	// 		<td> 
    	// 			<a class="btn btn-warning btn-sm btn-edit-doc-ship" id="'.$value['ID'].'">
    	// 				Edit
    	// 			</a>
    	// 			<a class="btn btn-danger btn-sm btn-delete-doc-ship" id="'.$value['ID'].'">
    	// 				Delete
    	// 			</a>
    	// 		</td>

    	// 	</tr>
    	// 	';
    	// }												
    	// echo $tampil;


    	$dataDocShip = $this->monitoring_po_import_m->getlistDocShip($NO_PO);
    	$negara = $this->monitoring_po_import_m->getCountry();
    	$negara_list = array();
    	foreach ($negara as $key => $value) {
    		$negara_list[$value['COUNTRY_CODE']] = $value['COUNTRY_NAME'];
    	}
    	// echo "<pre>";
    	// print_r($negara_list);die;
    	foreach ($dataDocShip as $value){
    		$DT = array();
    		$i++;
    		$DT['NO'] = $i;
    		$DT['NO_PO'] = $value['NO_PO'];
    		$DT['NILAI_INV'] = $value['NILAI_INV'];
    		$DT['NEGARA_ASAL'] = $negara_list[$value['NEGARA_ASAL']];
    		$DT['TGL_BL'] = date('d F Y', strtotime($value['TGL_BL']));
    		$DT['TGL_ETA'] = date('d F Y', strtotime($value['TGL_ETA']));
    		$DT['DOC_PPL'] = '<a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_PPL'].'">'.$value['DOC_PPL'].'</a>';
    		$DT['DOC_SHIPPING'] = '<a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_SHIPPING'].'">'.$value['DOC_SHIPPING'].'</a>';
    		$DT['TOMBOL'] = '
    		<a title="Edit" class="btn btn-warning btn-sm btn-edit-doc-ship glyphicon glyphicon-pencil" id="'.$value['ID'].'">
    		</a>
    		<a title="Hapus" class="btn btn-danger btn-sm btn-delete-doc-ship glyphicon glyphicon-trash" id="'.$value['ID'].'">
    		</a>';
    		$datatable[] = $DT;
    	}
    	$data = array('data' => isset($datatable)?$datatable:'');
    	echo json_encode($data);
    }

    function saveDetailPo()
    {
    	$iduser = $this->session->userdata['ID'];
    	$this->load->model('monitoring_po_import_m');

    	$DOC_PPL 			= $_FILES['DOC_PPL']['tmp_name'];
    	$DOC_SHIPPING 		= $_FILES['DOC_SHIPPING']['tmp_name'];

    	$tes 				= dirname(__FILE__);
    	$pet_pat 			= str_replace('application/modules/Monitoring_po_import/controllers', '', $tes);


    	$ID = $this->input->post('ID');
    	if($ID==""){
    		$getLastID = $this->monitoring_po_import_m->getMasterDocShip();
    		if(count($getLastID)==0){
    			$ID = 1;
    		} else {
    			$ID = $getLastID['ID']+1;
    		}
    		$set_edit7['ID'] 			= $ID;
    		$set_edit7['NO_PO'] 		= $this->input->post('NO_PO');
    		$set_edit7['NO_BL'] 		= $this->input->post('NO_BL');
    		$set_edit7['NAMA_ANGKUT'] 	= $this->input->post('NAMA_ANGKUT');
    		$set_edit7['POL'] 			= $this->input->post('POL');
    		$set_edit7['POD'] 			= $this->input->post('POD');
    		$set_edit7['NEGARA_ASAL'] 	= $this->input->post('NEGARA_ASAL');
    		$set_edit7['NO_PPL_BARANG'] = $this->input->post('NO_PPL_BARANG');
    		$set_edit7['JENIS_KEMASAN'] = $this->input->post('JENIS_KEMASAN');
    		$set_edit7['SATUAN'] 		= $this->input->post('SATUAN');
    		$set_edit7['NILAI_INV'] 	= str_replace('.', '', $this->input->post('NILAI_INV'));
    		$set_edit7['KUANTITAS_BL'] 	= str_replace('.', '', $this->input->post('KUANTITAS_BL'));
    		$set_edit7['JML_CONTAINER'] = str_replace('.', '', $this->input->post('JML_CONTAINER'));
    		$this->monitoring_po_import_m->saveDocShip($set_edit7);
    	} else {
    		$where_edit['ID'] 	= $ID;

    		$set_edit7['NO_BL'] 		= $this->input->post('NO_BL');
    		$set_edit7['NAMA_ANGKUT'] 	= $this->input->post('NAMA_ANGKUT');
    		$set_edit7['POL'] 			= $this->input->post('POL');
    		$set_edit7['POD'] 			= $this->input->post('POD');
    		$set_edit7['NEGARA_ASAL'] 	= $this->input->post('NEGARA_ASAL');
    		$set_edit7['NO_PPL_BARANG'] = $this->input->post('NO_PPL_BARANG');
    		$set_edit7['JENIS_KEMASAN'] = $this->input->post('JENIS_KEMASAN');
    		$set_edit7['SATUAN'] 		= $this->input->post('SATUAN');
    		$set_edit7['NILAI_INV'] 	= str_replace('.', '', $this->input->post('NILAI_INV'));
    		$set_edit7['KUANTITAS_BL'] 	= str_replace('.', '', $this->input->post('KUANTITAS_BL'));
    		$set_edit7['JML_CONTAINER'] = str_replace('.', '', $this->input->post('JML_CONTAINER'));
    		$this->monitoring_po_import_m->updateDocShip($set_edit7, $where_edit);
    	}
    	
		//echo $pet_pat;die;
    	$where_edit['ID'] 	= $ID;

    	if (isset($_FILES) && !empty($_FILES['DOC_PPL']['name'])) {
    		$type = explode('.', $_FILES['DOC_PPL']['name']);
    		if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_PPL".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_PPL, $this->_path)) {
                	$set_edit5['DOC_PPL'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateDocShip($set_edit5, $where_edit);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['DOC_SHIPPING']['name'])) {
        	$type = explode('.', $_FILES['DOC_SHIPPING']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_SHIPPING".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_SHIPPING, $this->_path)) {
                	$set_edit6['DOC_SHIPPING'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateDocShip($set_edit6, $where_edit);
                }
            }
        }

        $data1['ID'] 		= $ID;
        $data1['TGL_BL'] 	= $this->input->post('TGL_BL');
        $data1['TGL_ETA'] 	= $this->input->post('TGL_ETA');
        $this->monitoring_po_import_m->updateDocShip3($data1);

        $NO_PO = $this->input->post('NO_PO');
        redirect('Monitoring_po_import/detailIndexPo/'.$NO_PO);
    }


    function saveBiaya()
    {
    	$iduser = $this->session->userdata['ID'];
    	$this->load->model('monitoring_po_import_m');

    	$DOC_PPL1 			= $_FILES['DOC_PPL1']['tmp_name'];
    	$DOC_INVOICE1 		= $_FILES['DOC_INVOICE1']['tmp_name'];

    	$tes 				= dirname(__FILE__);
    	$pet_pat 			= str_replace('application/modules/Monitoring_po_import/controllers', '', $tes);


    	$ID = $this->input->post('IDBIAYA');
    	//echo $ID;
    	if($ID==""){
    		//echo "if";die;
    		$getLastID = $this->monitoring_po_import_m->getMasterBiaya();
    		if(count($getLastID)==0){
    			$ID = 1;
    		} else {
    			$ID = $getLastID['ID']+1;
    		}

    		$set_edit7['ID'] 			= $ID;
    		$set_edit7['NO_PO'] 		= $this->input->post('NO_PO');
    		$set_edit7['KET'] 		= $this->input->post('KET_BIAYA');
    		$set_edit7['OTHER'] 		= $this->input->post('OTHER');
    		$set_edit7['TOT_TAGIHAN_KONTRAK'] = str_replace('.', '', $this->input->post('TOT_TAGIHAN_KONTRAK'));
    		$set_edit7['NILAI_ONGKOS_ANGKUT'] = str_replace('.', '', $this->input->post('NILAI_ONGKOS_ANGKUT'));
    		$set_edit7['NILAI_LAIN_KONTRAK'] = str_replace('.', '', $this->input->post('NILAI_LAIN_KONTRAK'));
    		$set_edit7['TOTAL_TAGIHAN_COST'] = str_replace('.', '', $this->input->post('TOTAL_TAGIHAN_COST'));
    		$set_edit7['STORAGE'] = str_replace('.', '', $this->input->post('STORAGE'));
    		$set_edit7['NILAI_LAIN'] = str_replace('.', '', $this->input->post('NILAI_LAIN'));
    		$set_edit7['FEE'] = str_replace('.', '', $this->input->post('FEE'));
    		$set_edit7['BIAYA_FREIGHT'] = str_replace('.', '', $this->input->post('BIAYA_FREIGHT'));

    		$this->monitoring_po_import_m->saveVenBiaya($set_edit7);
    	} else {
    		//echo "else";die;
    		$where_edit['ID'] 	= $ID;

    		$set_edit7['KET'] 		= $this->input->post('KET_BIAYA');
    		$set_edit7['OTHER'] 		= $this->input->post('OTHER');
    		$set_edit7['TOT_TAGIHAN_KONTRAK'] = str_replace('.', '', $this->input->post('TOT_TAGIHAN_KONTRAK'));
    		$set_edit7['NILAI_ONGKOS_ANGKUT'] = str_replace('.', '', $this->input->post('NILAI_ONGKOS_ANGKUT'));
    		$set_edit7['NILAI_LAIN_KONTRAK'] = str_replace('.', '', $this->input->post('NILAI_LAIN_KONTRAK'));
    		$set_edit7['TOTAL_TAGIHAN_COST'] = str_replace('.', '', $this->input->post('TOTAL_TAGIHAN_COST'));
    		$set_edit7['STORAGE'] = str_replace('.', '', $this->input->post('STORAGE'));
    		$set_edit7['NILAI_LAIN'] = str_replace('.', '', $this->input->post('NILAI_LAIN'));
    		$set_edit7['FEE'] = str_replace('.', '', $this->input->post('FEE'));
    		$set_edit7['BIAYA_FREIGHT'] = str_replace('.', '', $this->input->post('BIAYA_FREIGHT'));
    		$this->monitoring_po_import_m->updateVenBiaya($set_edit7, $where_edit);
    	}
    	
		//echo $pet_pat;die;
    	$where_edit['ID'] 	= $ID;

    	if (isset($_FILES) && !empty($_FILES['DOC_PPL1']['name'])) {
    		$type = explode('.', $_FILES['DOC_PPL1']['name']);
    		if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_PPL1".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_PPL1, $this->_path)) {
                	$set_edit5['DOC_PPL1'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateDocBiaya($set_edit5, $where_edit);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['DOC_INVOICE1']['name'])) {
        	$type = explode('.', $_FILES['DOC_INVOICE1']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_INVOICE1".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_INVOICE1, $this->_path)) {
                	$set_edit6['DOC_INVOICE1'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateDocBiaya($set_edit6, $where_edit);
                }
            }
        }

        $NO_PO = $this->input->post('NO_PO');
        redirect('Monitoring_po_import/detailIndexPo/'.$NO_PO);
    }


    function deleteDetailPo()
    {
    	$iduser = $this->session->userdata['ID'];
    	$this->load->model('monitoring_po_import_m');
    	$ID = $this->input->post('id');
    	$where_edit['ID'] 			= $ID;
    	$set_edit7['DEL_FLAG'] 		= '1';
    	$check = $this->monitoring_po_import_m->updateDocShip($set_edit7, $where_edit);
    	if($check){
    		$status = "ok";
    	} else {
    		$status = "tidak";
    	}
    	echo json_encode($status);
    	//redirect('Monitoring_po_import/');
    }

    function getListCustom()
    {
    	$this->load->model('monitoring_po_import_m');
    	$iduser = $this->session->userdata['ID'];

    	$tampil = '';
    	$i=0;
    	$NO_PO 	= $this->input->post('no_po');
    	// $dataDocShip = $this->monitoring_po_import_m->getListCustom($NO_PO);
    	// echo $NO_PO."aaa";
    	// echo count($dataDocShip);
    	// print_r($dataDocShip);
    	// foreach ($dataDocShip as $value){
    	// 	$i++;
    	// 	$tampil.='
    	// 	<tr>
    	// 		<td> '.$i.'</td>
    	// 		<td> '.$value['NO_PO'].'</td>
    	// 		<td> '.$value['HS_CODE'].'</td>
    	// 		<td> '.date('d F Y', strtotime($value['TGL_DO'])).'</td>
    	// 		<td> <a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_PPL'].'">'.$value['DOC_PPL'].'</a></td>
    	// 		<td> <a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_BILLING'].'">'.$value['DOC_BILLING'].'</a></td>
    	// 		<td> <a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_BPN'].'">'.$value['DOC_BPN'].'</a></td>
    	// 		<td> <a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_MANIFEST'].'">'.$value['DOC_MANIFEST'].'</a></td>
    	// 		<td> <a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_LS'].'">'.$value['DOC_LS'].'</a></td>
    	// 		<td> <a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_INSURANCE'].'">'.$value['DOC_INSURANCE'].'</a></td>
    	// 		<td> <a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_SPPB'].'">'.$value['DOC_SPPB'].'</a></td>
    	// 		<td> <a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_SPTNP'].'">'.$value['DOC_SPTNP'].'</a></td>
    	// 		<td> 
    	// 			<a class="btn btn-warning btn-sm btn-edit-custom" id="'.$value['ID'].'">
    	// 				Edit
    	// 			</a>
    	// 			<a class="btn btn-danger btn-sm btn-delete-custom" id="'.$value['ID'].'">
    	// 				Delete
    	// 			</a>
    	// 		</td>

    	// 	</tr>
    	// 	';
    	// }												
    	// echo $tampil;


    	$dataDocCustom = $this->monitoring_po_import_m->getListCustom($NO_PO);
    	foreach ($dataDocCustom as $value){
    		$DT = array();
    		$i++;
    		$DT['NO'] = $i;
    		$DT['NO_PO'] = $value['NO_PO'];
    		$DT['HS_CODE'] = $value['HS_CODE'];
    		$DT['TGL_DO'] = date('d F Y', strtotime($value['TGL_DO']));
    		$DT['DOC_PPL'] = '<a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_PPL'].'">'.$value['DOC_PPL'].'</a>';
    		$DT['DOC_BILLING'] = '<a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_BILLING'].'">'.$value['DOC_BILLING'].'</a>';
    		$DT['DOC_BPN'] = '<a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_BPN'].'">'.$value['DOC_BPN'].'</a>';
    		$DT['DOC_MANIFEST'] = '<a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_MANIFEST'].'">'.$value['DOC_MANIFEST'].'</a>';
    		$DT['DOC_LS'] = '<a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_LS'].'">'.$value['DOC_LS'].'</a>';
    		$DT['DOC_INSURANCE'] = '<a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_INSURANCE'].'">'.$value['DOC_INSURANCE'].'</a>';
    		$DT['DOC_SPPB'] = '<a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_SPPB'].'">'.$value['DOC_SPPB'].'</a>';
    		$DT['DOC_SPTNP'] = '<a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_SPTNP'].'">'.$value['DOC_SPTNP'].'</a>';
    		$DT['TOMBOL'] = '
    		<a title="Edit" class="btn btn-warning btn-sm btn-edit-custom glyphicon glyphicon-pencil" id="'.$value['ID'].'">
    		</a>
    		<a title="Hapus" class="btn btn-danger btn-sm btn-delete-custom glyphicon glyphicon-trash" id="'.$value['ID'].'">
    		</a>';
    		$datatable[] = $DT;
    	}
    	$data = array('data' => isset($datatable)?$datatable:'');
    	echo json_encode($data);
    }

    function getListBiaya()
    {
    	$this->load->model('monitoring_po_import_m');
    	$iduser = $this->session->userdata['ID'];

    	$tampil = '';
    	$i=0;
    	$NO_PO 	= $this->input->post('no_po');
    	
    	//$dataDocBiaya = $this->monitoring_po_import_m->getListVenBiaya($NO_PO);
    	// foreach ($dataDocBiaya as $value){
    	// 	$i++;
    	// 	$tampil.='
    	// 	<tr>
    	// 		<td> '.$i.'</td>
    	// 		<td> '.$value['NO_PO'].'</td>
    	// 		<td> '.$value['TOT_TAGIHAN_KONTRAK'].'</td>
    	// 		<td> '.$value['NILAI_ONGKOS_ANGKUT'].'</td>
    	// 		<td> '.$value['NILAI_LAIN_KONTRAK'].'</td>
    	// 		<td> '.$value['TOTAL_TAGIHAN_COST'].'</td>
    	// 		<td> '.$value['NILAI_LAIN'].'</td>
    	// 		<td> '.$value['STORAGE'].'</td>
    	// 		<td> '.$value['FEE'].'</td>
    	// 		<td> '.$value['OTHER'].'</td>
    	// 		<td> '.$value['KET'].'</td>
    	// 		<td> <a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_PPL1'].'">'.$value['DOC_PPL1'].'</a></td>
    	// 		<td> <a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_INVOICE1'].'">'.$value['DOC_INVOICE1'].'</a></td>
    	// 		<td> 
    	// 			<a class="btn btn-warning btn-sm btn-edit-biaya" id="'.$value['ID'].'">
    	// 				Edit
    	// 			</a>
    	// 			<a class="btn btn-danger btn-sm btn-delete-biaya" id="'.$value['ID'].'">
    	// 				Delete
    	// 			</a>
    	// 		</td>

    	// 	</tr>
    	// 	';
    	// }												
    	// echo $tampil;

    	$dataDocBiaya = $this->monitoring_po_import_m->getListVenBiaya($NO_PO);
    	foreach ($dataDocBiaya as $value){
    		$DT = array();
    		$i++;
    		$DT['NO'] = $i;
    		$DT['NO_PO'] = $value['NO_PO'];
    		$DT['TOT_TAGIHAN_KONTRAK'] = number_format($value['TOT_TAGIHAN_KONTRAK'],0,".",".");
    		$DT['NILAI_ONGKOS_ANGKUT'] = number_format($value['NILAI_ONGKOS_ANGKUT'],0,".",".");
    		$DT['NILAI_LAIN_KONTRAK'] = number_format($value['NILAI_LAIN_KONTRAK'],0,".",".");
    		$DT['TOTAL_TAGIHAN_COST'] = number_format($value['TOTAL_TAGIHAN_COST'],0,".",".");
    		$DT['NILAI_LAIN'] = number_format($value['NILAI_LAIN'],0,".",".");
    		$DT['STORAGE'] = $value['STORAGE'];
    		$DT['FEE'] = number_format($value['FEE'],0,".",".");
    		$DT['OTHER'] = $value['OTHER'];
    		$DT['KET'] = $value['KET'];
    		$DT['DOC_PPL1'] = '<a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_PPL1'].'">'.$value['DOC_PPL1'].'</a>';
    		$DT['DOC_INVOICE1'] = '<a target="_blank" href="'.base_url().'upload/monitoring_trans_po/'.$value['DOC_INVOICE1'].'">'.$value['DOC_INVOICE1'].'</a>';
    		$DT['TOMBOL'] = '
    		<a title="Edit" class="btn btn-warning btn-sm btn-edit-biaya glyphicon glyphicon-pencil" id="'.$value['ID'].'">
    		</a>
    		<a title="Hapus" class="btn btn-danger btn-sm btn-delete-biaya glyphicon glyphicon-trash" id="'.$value['ID'].'">
    		</a>';
    		$datatable[] = $DT;
    	}
    	$data = array('data' => isset($datatable)?$datatable:'');
    	echo json_encode($data);

    	// echo $NO_PO."aaa<pre>";
    	// echo count($dataDocBiaya);
    	// print_r($dataDocBiaya);die;
    }

    function saveCustom()
    {
    	$iduser = $this->session->userdata['ID'];
    	$this->load->model('monitoring_po_import_m');

    	$DOC_PPL2 			= $_FILES['DOC_PPL2']['tmp_name'];
    	$DOC_BILLING 		= $_FILES['DOC_BILLING']['tmp_name'];
    	$DOC_BPN 			= $_FILES['DOC_BPN']['tmp_name'];
    	$DOC_MANIFEST 		= $_FILES['DOC_MANIFEST']['tmp_name'];
    	$DOC_LS 			= $_FILES['DOC_LS']['tmp_name'];
    	$DOC_INSURANCE 		= $_FILES['DOC_INSURANCE']['tmp_name'];
    	$DOC_SPPB 			= $_FILES['DOC_SPPB']['tmp_name'];
    	$DOC_SPTNP 			= $_FILES['DOC_SPTNP']['tmp_name'];

    	$tes 				= dirname(__FILE__);
    	$pet_pat 			= str_replace('application/modules/Monitoring_po_import/controllers', '', $tes);

    	$ID = $this->input->post('IDC');
    	if($ID==""){
    		$getLastID = $this->monitoring_po_import_m->getMasterCustom();
    		if(count($getLastID)==0){
    			$ID = 1;
    		} else {
    			$ID = $getLastID['ID']+1;
    		}
    		$set_edit7['ID'] 			= $ID;
    		$set_edit7['NO_PO'] 		= $this->input->post('NO_PO');
    		$set_edit7['HS_CODE'] 		= $this->input->post('HS_CODE');
    		$set_edit7['NO_PPL_BM'] 	= $this->input->post('NO_PPL_BM');
    		$set_edit7['NO_PPL_PDRI'] 	= $this->input->post('NO_PPL_PDRI');
    		$set_edit7['NO_PI_IP'] 		= $this->input->post('NO_PI_IP');
    		$set_edit7['NO_SPTNP'] 		= $this->input->post('NO_SPTNP');
    		$set_edit7['NO_LS'] 		= $this->input->post('NO_LS');
    		$set_edit7['NO_CERT'] 		= $this->input->post('NO_CERT');
    		$set_edit7['NO_PIB'] 		= $this->input->post('NO_PIB');

    		$set_edit7['OTHER'] 		= str_replace('.', '', $this->input->post('OTHER'));
    		$set_edit7['KUOTA_LARTAS'] 	= str_replace('.', '', $this->input->post('KUOTA_LARTAS'));
    		$set_edit7['SISA_KUOTA'] 	= str_replace('.', '', $this->input->post('SISA_KUOTA'));
    		$set_edit7['NILAI_LS'] 		= str_replace('.', '', $this->input->post('NILAI_LS'));
    		$this->monitoring_po_import_m->saveCustom($set_edit7);
    	} else {
    		$where_edit['ID'] 	= $ID;

    		$set_edit7['NO_PO'] 		= $this->input->post('NO_PO');
    		$set_edit7['HS_CODE'] 		= $this->input->post('HS_CODE');
    		$set_edit7['NO_PPL_BM'] 	= $this->input->post('NO_PPL_BM');
    		$set_edit7['NO_PPL_PDRI'] 	= $this->input->post('NO_PPL_PDRI');
    		$set_edit7['NO_PI_IP'] 		= $this->input->post('NO_PI_IP');
    		$set_edit7['NO_SPTNP'] 		= $this->input->post('NO_SPTNP');
    		$set_edit7['NO_LS'] 		= $this->input->post('NO_LS');
    		$set_edit7['NO_CERT'] 		= $this->input->post('NO_CERT');
    		$set_edit7['NO_PIB'] 		= $this->input->post('NO_PIB');

    		$set_edit7['OTHER'] 		= str_replace('.', '', $this->input->post('OTHER'));
    		$set_edit7['KUOTA_LARTAS'] 	= str_replace('.', '', $this->input->post('KUOTA_LARTAS'));
    		$set_edit7['SISA_KUOTA'] 	= str_replace('.', '', $this->input->post('SISA_KUOTA'));
    		$set_edit7['NILAI_LS'] 		= str_replace('.', '', $this->input->post('NILAI_LS'));

    		$this->monitoring_po_import_m->updateCustom($set_edit7, $where_edit);
    	}

		//echo $pet_pat;die;
    	$where_edit['ID'] 	= $ID;

    	if (isset($_FILES) && !empty($_FILES['DOC_PPL2']['name'])) {
    		$type = explode('.', $_FILES['DOC_PPL2']['name']);
    		if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_PPL2".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_PPL2, $this->_path)) {
                	$set_edit5['DOC_PPL'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateCustom($set_edit5, $where_edit);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['DOC_BILLING']['name'])) {
        	$type = explode('.', $_FILES['DOC_BILLING']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_BILLING".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_BILLING, $this->_path)) {
                	$set_edit6['DOC_BILLING'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateCustom($set_edit6, $where_edit);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['DOC_BPN']['name'])) {
        	$type = explode('.', $_FILES['DOC_BPN']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_BPN".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_BPN, $this->_path)) {
                	$set_edit8['DOC_BPN'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateCustom($set_edit8, $where_edit);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['DOC_MANIFEST']['name'])) {
        	$type = explode('.', $_FILES['DOC_MANIFEST']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_MANIFEST".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_MANIFEST, $this->_path)) {
                	$set_edit9['DOC_MANIFEST'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateCustom($set_edit9, $where_edit);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['DOC_LS']['name'])) {
        	$type = explode('.', $_FILES['DOC_LS']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_LS".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_LS, $this->_path)) {
                	$set_edit10['DOC_LS'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateCustom($set_edit10, $where_edit);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['DOC_INSURANCE']['name'])) {
        	$type = explode('.', $_FILES['DOC_INSURANCE']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_INSURANCE".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_INSURANCE, $this->_path)) {
                	$set_edit11['DOC_INSURANCE'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateCustom($set_edit11, $where_edit);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['DOC_SPPB']['name'])) {
        	$type = explode('.', $_FILES['DOC_SPPB']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_SPPB".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_SPPB, $this->_path)) {
                	$set_edit12['DOC_SPPB'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateCustom($set_edit12, $where_edit);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['DOC_SPTNP']['name'])) {
        	$type = explode('.', $_FILES['DOC_SPTNP']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_SPTNP".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_SPTNP, $this->_path)) {
                	$set_edit13['DOC_SPTNP'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateCustom($set_edit13, $where_edit);
                }
            }
        }

        $data1['ID'] 			= $ID;
        $data1['TGL_BAYAR'] 	= $this->input->post('TGL_BAYAR');
        $data1['TGL_BERLAKU'] 	= $this->input->post('TGL_BERLAKU');
        $data1['TGL_SPTNP'] 	= $this->input->post('TGL_SPTNP');
        $data1['TGL_MANIFEST'] 	= $this->input->post('TGL_MANIFEST');
        $data1['TGL_TA'] 		= $this->input->post('TGL_TA');
        
        $data1['TGL_BERLAKU_LS'] 	= $this->input->post('TGL_BERLAKU_LS');
        $data1['TGL_SPPB'] 			= $this->input->post('TGL_SPPB');
        $data1['TGL_CERT'] 			= $this->input->post('TGL_CERT');
        $data1['TGL_PIB'] 			= $this->input->post('TGL_PIB');
        $data1['TGL_DO'] 			= $this->input->post('TGL_DO');
        $this->monitoring_po_import_m->updateCustom2($data1);

        $NO_PO = $this->input->post('NO_PO');
        redirect('Monitoring_po_import/detailIndexPo/'.$NO_PO);
    }

    function deleteCustom()
    {
    	$iduser = $this->session->userdata['ID'];
    	$this->load->model('monitoring_po_import_m');
    	$ID = $this->input->post('id');
    	$where_edit['ID'] 			= $ID;
    	$set_edit7['DEL_FLAG'] 		= '1';
    	$check = $this->monitoring_po_import_m->updateCustom($set_edit7, $where_edit);
    	if($check){
    		$status = "ok";
    	} else {
    		$status = "tidak";
    	}
    	echo json_encode($status);
    	//redirect('Monitoring_po_import/');
    }

    function deleteBiaya()
    {
    	$iduser = $this->session->userdata['ID'];
    	$this->load->model('monitoring_po_import_m');
    	$ID = $this->input->post('id');
    	$where_edit['ID'] 			= $ID;
    	$set_edit7['DEL_FLAG'] 		= '1';
    	$check = $this->monitoring_po_import_m->updateDocBiaya($set_edit7, $where_edit);
    	if($check){
    		$status = "ok";
    	} else {
    		$status = "tidak";
    	}
    	echo json_encode($status);
    	//redirect('Monitoring_po_import/');
    }

}