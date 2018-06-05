<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring_po_import_vendor extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library('email');
		$this -> load -> library('form_validation');
		$this -> load -> library("file_operation");
		$this -> load -> library('Layout');
		$this -> load -> library('Authorization');
		$this -> load -> helper('url');
		$this->kolom_xl = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	}

	function index()
	{
		// echo $this->session->userdata['COMPANYID'];
		// echo "<pre>";
		// print_r($this->session->userdata);
		// die;
		$data['title'] = 'Transaksi PO';
		$this->load->model('monitoring_po_import_m');
		//inco = tod
		$data['tod'] = $this->monitoring_po_import_m->getInco1();
		$data['country'] = $this->monitoring_po_import_m->getCountry();
		$data['COMPANYID'] = $this->session->userdata['COMPANYID'];

		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> add_js('pages/monitoring_po_transaksi_vendor.js');
		$this -> layout -> add_js('pages/EC_auction_only_number_format.js');
		$this -> layout -> add_js('jquery.maskedinput.js');
		$this -> layout -> render('transaksi_po', $data);

	}

	function viewPO($NO_PO)
	{
		$data['title'] = 'Transaksi PO '.$NO_PO;
		$this->load->model('monitoring_po_import_m');
		$data['tod'] = $this->monitoring_po_import_m->getInco1();
		$data['country'] = $this->monitoring_po_import_m->getCountry();
		$data['VenCus'] = $this->monitoring_po_import_m->getDetailVenCus($NO_PO);
		$data['VenBiaya'] = $this->monitoring_po_import_m->getDetailVenBiaya($NO_PO);
		$data['COMPANYID'] = $this->session->userdata['COMPANYID'];

		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> add_js('pages/view_monitoring_po_transaksi_vendor.js');
		$this -> layout -> add_js('pages/EC_auction_only_number_format.js');
		$this -> layout -> add_js('jquery.maskedinput.js');
		$this -> layout -> render('view_transaksi_po', $data);

	}

	function getPoImportDB()
	{
		$company = $this->input->post('company');
		$this->load->model('monitoring_po_import_m');
		$vendor_no = $this->session->userdata['VENDOR_NO'];
		
		$tampil = '';
		$i=0;

		$dataSAP = $this->monitoring_po_import_m->getPOHeader($company);
		foreach ($dataSAP as $value1){
			$dataSAPitem = $this->monitoring_po_import_m->getTranslist2Vendor($value1['NO_PO'], $vendor_no);
			$c=0;
			foreach ($dataSAPitem as $value){
				$tombol = '<td> </td>';
				$tombol2 = '<td> </td>';
				if($c==0){
					$tombol = '
					<td> <input type="checkbox" name="no_po[]" value="'.$value['NO_PO'].'">'.++$i.'</td>
					';

					$tombol2 = '
					<td>
						<a class="btn btn-warning btn-sm" href="'.site_url('Monitoring_po_import_vendor/viewPO').'/'.$value['NO_PO'].'">Edit</a>
					</td>
					';
				}
				$tampil.='
				<tr>
					'.$tombol.'
					<td> '.$value['NO_PO'].'</td>
					<td> '.$value['NO_ITEM'].'</td>
					<td> '.$value['DESC'].'</td>
					<td> '.$value['VENDOR_NAME'].'</td>
					<td> '.$value['QTY'].'</td>
					<td> '.$value['NILAI_PO'].'</td>
					<td> '.$value['STAT_APPROVAL'].'</td>
					<td> '.$value['SATUAN'].'</td>
					<td> '.$value['TOD'].'</td>
					'.$tombol2.'
				</tr>
				';
				$c++;
			}												
		}
		echo $tampil;
	}

	function getDetailPoImportDB()
	{
		$company = $this->input->post('company');
		$this->load->model('monitoring_po_import_m');
		$vendor_no = $this->session->userdata['VENDOR_NO'];
		
		$tampil = '';
		$i=0;

		$dataSAP = $this->monitoring_po_import_m->getPOHeader($company);
		foreach ($dataSAP as $value1){
			$dataSAPitem = $this->monitoring_po_import_m->getTranslist2Vendor($value1['NO_PO'], $vendor_no);
			$c=0;
			foreach ($dataSAPitem as $value){
				$tombol = '<td> </td>';
				$tombol2 = '<td> </td>';
				if($c==0){
					$tombol = '
					<td> <input type="checkbox" name="no_po[]" value="'.$value['NO_PO'].'">'.++$i.'</td>
					';

					$tombol2 = '
					<td>
						<a class="btn btn-warning btn-sm btn-edit" no_po="'.$value['NO_PO'].'">Edit</a>
					</td>
					';
				}
				$tampil.='
				<tr>
					'.$tombol.'
					<td> '.$value['NO_PO'].'</td>
					<td> '.$value['NO_ITEM'].'</td>
					<td> '.$value['DESC'].'</td>
					<td> '.$value['VENDOR_NAME'].'</td>
					<td> '.$value['QTY'].'</td>
					<td> '.$value['NILAI_PO'].'</td>
					<td> '.$value['STAT_APPROVAL'].'</td>
					<td> '.$value['SATUAN'].'</td>
					<td> '.$value['TOD'].'</td>
					'.$tombol2.'
				</tr>
				';
				$c++;
			}												
		}
		echo $tampil;
	}

	function detailPo()
	{
		$no_po = $this->input->post('no_po');
		$vendor_no = $this->session->userdata['VENDOR_NO'];
		$this->load->model('monitoring_po_import_m');
		$data = $this->monitoring_po_import_m->getDetailVenCus($no_po);
		$data['VenBiaya'] = $this->monitoring_po_import_m->getDetailVenBiaya($no_po);

		$data['NEW_TGL'] = date('Y-m-d', strtotime($data['TGL']));
		$data['NEW_TGL_SPPB'] = date('Y-m-d', strtotime($data['TGL_SPPB']));
		$data['NEW_TGL_PIB'] = date('Y-m-d', strtotime($data['TGL_PIB']));
		$data['NEW_TGL_DO'] = date('Y-m-d', strtotime($data['TGL_DO']));
		$data['NEW_TGL_MAN'] = date('Y-m-d', strtotime($data['TGL_MAN']));
		$data['NEW_TGL_TA'] = date('Y-m-d', strtotime($data['TGL_TA']));
		$data['NEW_NILAI_LS'] = number_format($data['NILAI_LS'],0,".",".");
		

		$data['NEW_TOT_TAGIHAN_KONTRAK'] = number_format($data['VenBiaya']['TOT_TAGIHAN_KONTRAK'],0,".",".");
		$data['NEW_NILAI_ONGKOS_ANGKUT'] = number_format($data['VenBiaya']['NILAI_ONGKOS_ANGKUT'],0,".",".");
		$data['NEW_NILAI_LAIN_KONTRAK'] = number_format($data['VenBiaya']['NILAI_LAIN_KONTRAK'],0,".",".");
		$data['NEW_TOTAL_TAGIHAN_COST'] = number_format($data['VenBiaya']['TOTAL_TAGIHAN_COST'],0,".",".");
		$data['NEW_STORAGE'] = number_format($data['VenBiaya']['STORAGE'],0,".",".");
		$data['NEW_OTHER'] = number_format($data['VenBiaya']['OTHER'],0,".",".");
		$data['NEW_NILAI_LAIN'] = number_format($data['VenBiaya']['NILAI_LAIN'],0,".",".");
		$data['NEW_FEE'] = number_format($data['VenBiaya']['FEE'],0,".",".");


		
		echo json_encode($data);
	}

	function updateDetailPo()
	{
		// echo $this->session->userdata['VENDOR_ID'];
		// echo "<pre>";
		// print_r($this->session->userdata);
		// die;
		
		$iduser = $this->session->userdata['VENDOR_ID'];
		$this->load->model('monitoring_po_import_m');

		// echo "<pre>";
		// echo $_FILES['DOC_PO']['tmp_name'];
		// print_r($_FILES);die();

		$DOC_PPL 			= $_FILES['DOC_PPL']['tmp_name'];
		$DOC_BILLING 		= $_FILES['DOC_BILLING']['tmp_name'];
		$DOC_BPN 			= $_FILES['DOC_BPN']['tmp_name'];
		$DOC_MANIFEST 		= $_FILES['DOC_MANIFEST']['tmp_name'];
		$DOC_LS 			= $_FILES['DOC_LS']['tmp_name'];
		$DOC_INSURANCE 		= $_FILES['DOC_INSURANCE']['tmp_name'];
		$DOC_SPPB 			= $_FILES['DOC_SPPB']['tmp_name'];
		$DOC_SPTNP 			= $_FILES['DOC_SPTNP']['tmp_name'];
		
		$DOC_PPL1 			= $_FILES['DOC_PPL1']['tmp_name'];
		$DOC_INVOICE1 		= $_FILES['DOC_INVOICE1']['tmp_name'];
		
		$tes 				= dirname(__FILE__);
		$pet_pat 			= str_replace('application/modules/Monitoring_po_import_vendor/controllers', '', $tes);

		//echo $pet_pat;die;
		$where_edit['NO_PO'] 	= $this->input->post('NO_PO');

		if (isset($_FILES) && !empty($_FILES['DOC_PPL']['name'])) {
			$type = explode('.', $_FILES['DOC_PPL']['name']);
			if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_PPL".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_PPL, $this->_path)) {
                	$set_edit1['DOC_PPL'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateVenCus($set_edit1, $where_edit);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['DOC_BILLING']['name'])) {
        	$type = explode('.', $_FILES['DOC_BILLING']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_BILLING".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_BILLING, $this->_path)) {
                	$set_edit2['DOC_BILLING'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateVenCus($set_edit2, $where_edit);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['DOC_BPN']['name'])) {
        	$type = explode('.', $_FILES['DOC_BPN']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_BPN".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_BPN, $this->_path)) {
                	$set_edit3['DOC_BPN'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateVenCus($set_edit3, $where_edit);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['DOC_MANIFEST']['name'])) {
        	$type = explode('.', $_FILES['DOC_MANIFEST']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_MANIFEST".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_MANIFEST, $this->_path)) {
                	$set_edit4['DOC_MANIFEST'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateVenCus($set_edit4, $where_edit);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['DOC_LS']['name'])) {
        	$type = explode('.', $_FILES['DOC_LS']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_LS".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_LS, $this->_path)) {
                	$set_edit7['DOC_LS'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateVenCus($set_edit7, $where_edit);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['DOC_INSURANCE']['name'])) {
        	$type = explode('.', $_FILES['DOC_INSURANCE']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_INSURANCE".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_INSURANCE, $this->_path)) {
                	$set_edit8['DOC_INSURANCE'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateVenCus($set_edit8, $where_edit);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['DOC_SPPB']['name'])) {
        	$type = explode('.', $_FILES['DOC_SPPB']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_SPPB".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_SPPB, $this->_path)) {
                	$set_edit9['DOC_SPPB'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateVenCus($set_edit9, $where_edit);
                }
            }
        }

        if (isset($_FILES) && !empty($_FILES['DOC_SPTNP']['name'])) {
        	$type = explode('.', $_FILES['DOC_SPTNP']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_SPTNP".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_SPTNP, $this->_path)) {
                	$set_edit10['DOC_SPTNP'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateVenCus($set_edit10, $where_edit);
                }
            }
        }
        
        $set_edit['NO_LS'] 			= $this->input->post('NO_LS');
        $set_edit['NO_CERT'] 		= $this->input->post('NO_CERT');
        $set_edit['HS_CODE'] 		= $this->input->post('HS_CODE');
        $set_edit['NILAI_LS'] 		= str_replace('.', '', $this->input->post('NILAI_LS'));
        $this->monitoring_po_import_m->updateVenCus($set_edit, $where_edit);

        $data['NO_PO'] 		= $this->input->post('NO_PO');
        $data['TGL_MAN'] 	= $this->input->post('TGL_MAN');
        $data['TGL_TA'] 	= $this->input->post('TGL_TA');
        $data['TGL'] 		= $this->input->post('TGL');
        $data['TGL_SPPB'] 	= $this->input->post('TGL_SPPB');
        $data['TGL_PIB'] 	= $this->input->post('TGL_PIB');
        $data['TGL_DO'] 	= $this->input->post('TGL_DO');
        $this->monitoring_po_import_m->updateVenCus2($data);

        if (isset($_FILES) && !empty($_FILES['DOC_PPL1']['name'])) {
        	$type = explode('.', $_FILES['DOC_PPL1']['name']);
        	if(end($type)=="doc" || end($type)=="docx" || end($type)=="pdf"){
                $this->_myFile = "DOC_PPL1".$iduser . date('YmdHms') . "." . end($type);//get terakhir
                $this->_path = $pet_pat . 'upload/monitoring_trans_po/' . $this->_myFile;
                if (move_uploaded_file($DOC_PPL1, $this->_path)) {
                	$set_edit5['DOC_PPL1'] 	= $this->_myFile;
                	$this->monitoring_po_import_m->updateVenBiaya($set_edit5, $where_edit);
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
                	$this->monitoring_po_import_m->updateVenBiaya($set_edit6, $where_edit);
                }
            }
        }


        $set_edit11['KET'] 					= $this->input->post('KET');
        $set_edit11['TOT_TAGIHAN_KONTRAK'] 	= str_replace('.', '', $this->input->post('TOT_TAGIHAN_KONTRAK'));
        $set_edit11['NILAI_ONGKOS_ANGKUT'] 	= str_replace('.', '', $this->input->post('NILAI_ONGKOS_ANGKUT'));
        $set_edit11['NILAI_LAIN_KONTRAK'] 	= str_replace('.', '', $this->input->post('NILAI_LAIN_KONTRAK'));
        $set_edit11['TOTAL_TAGIHAN_COST'] 	= str_replace('.', '', $this->input->post('TOTAL_TAGIHAN_COST'));
        $set_edit11['STORAGE'] 				= str_replace('.', '', $this->input->post('STORAGE'));
        $set_edit11['OTHER'] 				= str_replace('.', '', $this->input->post('OTHER'));
        $set_edit11['NILAI_LAIN'] 			= str_replace('.', '', $this->input->post('NILAI_LAIN'));
        $set_edit11['FEE'] 					= str_replace('.', '', $this->input->post('FEE'));
        $this->monitoring_po_import_m->updateVenBiaya($set_edit11, $where_edit);

        if($this->input->post('NO_PO')!=""){
        	redirect('Monitoring_po_import_vendor/viewPO/'.$this->input->post('NO_PO'));
        } else {
        	redirect('Monitoring_po_import_vendor/');
        }
    }
}