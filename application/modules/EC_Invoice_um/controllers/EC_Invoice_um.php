<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Invoice_um extends MX_Controller {

	private $user;

	public function __construct() {
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->helper('url');
		$this->load->library('Layout');
		$this->load->helper("security");
		$this->user = $this->session->userdata('FULLNAME');
		$_nomerVendor = $this->session->userdata('VENDOR_NO');
		if (strlen($_nomerVendor) < 10) {
			$this->session->set_userdata('VENDOR_NO', str_pad($_nomerVendor, 10, '0', STR_PAD_LEFT));
		}
	}

	public function index($cheat = false) {
		$data['title'] = "Uang Muka Management";
		$data['cheat'] = $cheat;
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_validate_css();
		$this->layout->set_validate_js();
		$this->layout->add_js('pages/invoice/EC_common.js');
		$this->layout->add_js('pages/EC_inv_um.js?1');
		$this->layout->add_js('pages/EC_bootstrap-switch.min.js');
		$this->layout->add_js('jquery.priceFormat.min.js');

		$this->layout->add_css('pages/EC_strategic_material.css');
		$this->layout->add_css('pages/EC_bootstrap-switch.min.css');
		$this->layout->add_css('pages/EC_miniTable.css');
		$this->layout->add_css('pages/EC_jasny-bootstrap.min.css');
		$this->layout->add_css('pages/invoice/common.css');

		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
		$this->layout->add_js('pages/EC_jasny-bootstrap.min.js');
		$this->layout->add_js('jquery.alphanum.js');
		$this->layout->add_js('bootbox.js');

		$this->load->model('ec_master_inv');
		$this->load->model('invoice/ec_m_pajak_inv', 'pajak');
		$this->load->model('invoice/ec_m_denda_inv', 'denda');
		$this->load->model('invoice/ec_m_doc_inv', 'doc');
		$wherePajak = "ID_JENIS IN ('VZ', 'VN') AND STATUS = 1";
		$data['pajak'] = $this->db->where($wherePajak)->get('EC_M_PAJAK_INV')->result_array();
		$data['denda'] = $this->denda->as_array()->get_all(array('STATUS' => 1));
		$data['doc'] = $this->doc->as_array()->get_all(array('STATUS' => 1));
        // $data['denda'] = $this->ec_master_inv->getDenda();
        // $data['doc'] = $this->ec_master_inv->getDoc();
		/* dapatkan daftar bank dari vendor */
		$venno = $this->session->userdata['VENDOR_NO'];
		$data['listBank'] = $this->listBankVendor($venno);
		$data['defaultPajak'] = 'VZ';
		$sudahTampil = $this->session->userdata('sudahTampil');
		$data['sudahTampil'] = empty($sudahTampil) ? 0 : 1;

		if (empty($sudahTampil)) {
			$this->session->set_userdata('sudahTampil', 1);
		}

		$this->layout->render('list', $data);
	}

	private function listBankVendor($venno) {
		$this->load->library('sap_handler');
		return $this->sap_handler->getListBankVendor($venno);
	}

	public function detail($noinvoice = '1234567890') {
		$data['title'] = "Detail Invoice";
		$data['status'] = $this->uri->segment(4);
		$data['noinvoice'] = $noinvoice;
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_css('pages/EC_strategic_material.css');
		$this->layout->add_css('pages/EC_bootstrap-switch.min.css');
		$this->layout->add_css('pages/EC_miniTable.css');
		$this->layout->add_css('pages/EC_jasny-bootstrap.min.css');
		$this->layout->add_css('pages/EC_checkout.css');
		$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('jquery.priceFormat.min.js');

		$this->layout->add_js('pages/invoice/EC_common.js');
		$this->layout->add_js('pages/EC_inv_mngement_detail.js');
		$this->layout->add_js('pages/EC_bootstrap-switch.min.js');
		$this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
		$this->layout->add_js('pages/EC_jasny-bootstrap.min.js');
		$this->layout->add_js('jquery.alphanum.js');
		$this->layout->add_js('bootbox.js');

		$this->load->model('ec_master_inv');
        /*
          $data['pajak'] = $this->ec_master_inv->getPajak();
          $data['denda'] = $this->ec_master_inv->getDenda();
          $data['doc'] = $this->ec_master_inv->getDoc();
         */

          $this->load->model('invoice/ec_m_pajak_inv', 'pajak');
          $this->load->model('invoice/ec_m_denda_inv', 'denda');
          $this->load->model('invoice/ec_m_doc_inv', 'doc');

          $wherePajak = "ID_JENIS IN ('VZ', 'VN') AND STATUS = 1";
          $data['pajak'] = $this->db->where($wherePajak)->get('EC_M_PAJAK_INV')->result_array();
          $data['denda'] = $this->denda->as_array()->get_all(array('STATUS' => 1));
          $data['doc'] = $this->doc->as_array()->get_all(array('STATUS' => 1));

          $venno = $this->session->userdata['VENDOR_NO'];
          $this->load->model('invoice/ec_gr', 'gr');
          $this->load->model('ec_open_inv');
          $this->load->model('invoice/ec_invoice_header', 'e_header');

          /* dapatkan no_po untuk memperoleh list gr */
          $data['GR'] = $this->gr->as_array()->get_all(array('INV_NO' => $noinvoice));
          $data['invoice'] = $this->ec_open_inv->getIvoice($noinvoice);
          $data['Tdoc'] = $this->ec_open_inv->getDoc($noinvoice);
          $data['Tdenda'] = $this->ec_open_inv->getDenda($noinvoice);

          $data['queue'] = $this->e_header->get_queue_number($noinvoice, $data['invoice'][0]['STATUS_HEADER']);

          $venno = $this->session->userdata['VENDOR_NO'];
          $data['listBank'] = $this->listBankVendor($venno);

          $status_header = $data['invoice'][0]['STATUS_HEADER'];
          $data['accountingDocument'] = '';

          if ($status_header >= 5) {
          	$noDocument = $data['invoice'][0]['FI_NUMBER_SAP'];
          	$tahun = $data['invoice'][0]['FI_YEAR'];
          	$company = $data['invoice'][0]['COMPANY_CODE'];
          	$t = $this->getListAccountingDocument($noDocument, $tahun, $company);
          	$data['accountingDocument'] = $this->load->view('accountingDocument', array('list' => $t), TRUE);
          }

          $data['parcial'] = $this->checkParcial2($noinvoice);
          $data['lot'] = $this->checkLot($noinvoice);
          $data['pomut'] = $this->checkPomut($data['invoice'][0]['POTMUT_PIC']);
        //var_dump($data);die();
          $this->layout->render('detail', $data);
      }

      public function get_data_detail($noinvoice = '1234567890') {
      	$data['title'] = "Detail Management";
      	$status = $this->uri->segment(4);
      	$venno = $this->session->userdata['VENDOR_NO'];
        // $venno = "0000410000";
      	$this->load->model('invoice/ec_gr', 'gr');
      	$this->load->model('ec_open_inv');
      	/* dapatkan no_po untuk memperoleh list gr */
        // $gr = $this->gr->as_array()->get_all(array('INV_NO' => $noinvoice));
      	$gr = $this->gr->getGRWithRR($noinvoice);
      	$dataa = array();
      	if (!empty($gr)) {
            // $dataa = $this->ec_open_inv->getGREdit($gr->PO_NO);
      	}

      	$json_data = array('data' => $gr);
      	echo json_encode($json_data);
      }

      public function get_data() {
        //header('Content-Type: application/json');
      	$this->load->model('ec_uang_muka');
      	$venno = $this->session->userdata['VENDOR_NO'];
        //	$venno = "0000112709";
      	$_dataa = $this->ec_uang_muka->getManUm($venno);

      	// if (!empty($_dataa)) {
      	// 	$dataa = $this->filterGRUnbilled($_dataa);
      	// } else {
      	// 	$dataa = $_dataa;
      	// }
      	$dataa = $_dataa;
      	$json_data = array('data' => $dataa);
      	echo json_encode($json_data);
      }

      public function get_data_invoice() {
      	header('Content-Type: application/json');
      	$this->load->model('ec_uang_muka');
      	$venno = $this->session->userdata['VENDOR_NO'];
        //$venno = "0000112709";
      	$dataa = $this->ec_uang_muka->get_Invoice(" where EIH.VENDOR_NO =  " .$venno. " AND EGS.BWART='103'", ' order by EIH.CHDATE DESC');
      	$kirim = array();
      	for ($i = 0; $i < sizeof($dataa); $i++) {
      		$dt['NO'] = $i + 1;
      		$dt['INVOICE_DATE'] = $dataa[$i]['INVOICE_DATE2'];
      		$dt['NO_INVOICE'] = $dataa[$i]['NO_INVOICE'];
      		$dt['NO_KWITANSI'] = $dataa[$i]['NO_KWITANSI'];
      		$dt['FAKTUR_PJK'] = $dataa[$i]['FAKTUR_PJK'];
      		$dt['CURRENCY'] = $dataa[$i]['CURRENCY'];
      		$dt['TOTAL_AMOUNT'] = $dataa[$i]['TOTAL_AMOUNT'];
      		$dt['CHDATE'] = $dataa[$i]['CHDATE2'];
            // $dt['INVOICE_DATE'] = $dataa[$i]['INVOICE_DATE'];
      		$dt['STATUS_HEADER'] = $dataa[$i]['STATUS_HEADER'];
      		$dt['ID_INVOICE'] = $dataa[$i]['ID_INVOICE'];
      		$dt['NO_SP_PO'] = $dataa[$i]['NO_SP_PO'];
      		$dt['STATUS_DOC'] = $dataa[$i]['STATUS_DOC'];
      		$dt['POSISI'] = $dataa[$i]['POSISI'];
      		$dt['BASE_AMOUNT'] = $dataa[$i]['BASE_AMOUNT'];
      		$dt['FI_NUMBER_SAP'] = $dataa[$i]['FI_NUMBER_SAP'];
      		$kirim[] = $dt;
      	}
      	$json_data = array('data' => $kirim);
      	echo json_encode($json_data);
      }

      public function get_data_um() {
      	header('Content-Type: application/json');
      	$this->load->model('um_sap_header');
      	$venno = $this->session->userdata['VENDOR_NO'];
        //$venno = "0000112709";
      	// $dataa = $this->um_sap_header->get();
      	$dataa = $this->um_sap_header->get(array('LIFNR' => $venno));
      	$json_data = array('data' => $dataa);
      	echo json_encode($json_data);
      }

      function getALL($dataa = '') {
      	$i = 1;
      	$data_tabel = array();
      	foreach ($dataa as $value) {
      		$data[0] = $i++;
      		$data[1] = $value['INVOICE_NO'] != null ? $value['INVOICE_NO'] : "";
      		$data[2] = $value['INVOICE_DATE'] != null ? $value['INVOICE_DATE'] : "";
      		$data[3] = $value['FAKTUR'] != null ? $value['FAKTUR'] : "";
      		$data[4] = $value['CURRENCY'] != null ? $value['CURRENCY'] : "";
      		$data[5] = $value['TOTAL_AMOUNT'] != null ? $value['TOTAL_AMOUNT'] : "";
      		$data[6] = $value['INV_PIC'] != null ? $value['INV_PIC'] : "";
      		$data[7] = $value['FAKTUR_PIC'] != null ? $value['FAKTUR_PIC'] : "";
      		$data[8] = $value['ALASAN_REJECT'] != null ? $value['ALASAN_REJECT'] : "";
      		$data_tabel[] = $data;
      	}
      	return $data_tabel;
      }

      public function get_invoiceDetail($INVOICE_NO) {
      	$this->load->model('ec_open_inv');
      	$data = $this->ec_open_inv->get_InvoinceDetail($INVOICE_NO);

      	$json_data = array('data' => $this->getALLDetail($data));
      	echo json_encode($json_data);
      }

      function getALLDetail($dataa = '') {
      	$i = 1;
      	$data_tabel = array();
      	foreach ($dataa as $value) {
      		$data[0] = $i++;
      		$data[1] = $value['GR_AMOUNT_IN_DOC'] != null ? $value['GR_AMOUNT_IN_DOC'] : "-";
      		$data[2] = $value['GR_ITEM_QTY'] != null ? $value['GR_ITEM_QTY'] : "-";
      		$data[3] = $value['PO_NO'] != null ? $value['PO_NO'] : "-";
      		$data[4] = $value['PO_ITEM_NO'] != null ? $value['PO_ITEM_NO'] : "-";
      		$data[5] = $value['GR_NO'] != null ? $value['GR_NO'] : "-";
      		$data[6] = $value['GR_ITEM_NO'] != null ? $value['GR_ITEM_NO'] : "-";
      		$data[7] = $value['FAKTUR'] != null ? $value['FAKTUR'] : "-";

      		$data_tabel[] = $data;
      	}
      	return $data_tabel;
      }

      public function createInvoice() {
      	$mat = $this->input->post('arrgr');
      	$grArr = explode('&@', $mat);
        //var_dump($grArr);die();
      	$itemCat = $this->input->post('itemCat');
      	$this->load->model('ec_open_inv');
      	$this->load->model('invoice/ec_um_header', 'eh');
      	$this->load->library("file_operation");
      	$this->load->helper('file');
      	$this->load->helper(array('form', 'url'));
        // echo "<pre>";
        // print_r($_FILES);
        // die;
      	$uploaded = $this->file_operation->uploadL(UPLOAD_PATH . 'EC_um', $_FILES);
      	$denda = array();
      	$doc = array();

      	$PARTNER_BANK = $this->input->post('partner_bank');
      	$PAJAK = $this->input->post('pajak');
      	$INVOICE_DATE = $this->input->post('invoice_date');
      	$FAKTUR_PJK_DATE = $this->input->post('FakturDate');
      	$NO_SP_PO = $this->input->post('sppo_no');
      	$NO_KWITANSI = $this->input->post('kwitansi_no');
      	$FAKTUR_PJK = $this->input->post('faktur_no');
      	$TOTAL_AMOUNT = $this->input->post('total');
      	$DP_REQ_AMOUNT = $this->input->post('dp_req_amount');
      	$CURRENCY = $this->input->post('curr');
      	$NO_LPB = $this->input->post('K3');
      	$BASE_AMOUNT = $this->input->post('base_amount');
      	$VENDOR_NO = $this->session->userdata['VENDOR_NO'];

      	$this->db->trans_begin();

      	/* cari company code dari po */
      	$where_po = 'EBELN = ' . $NO_SP_PO . ' and WERKS is not null';
      	$_companyCode = $this->db->select(array('WERKS'))->where($where_po)->limit(2)->get('EC_GR_SAP')->row_array();
      	$companyCode = substr($_companyCode['WERKS'], 0, 1) . '000';

      	if (!empty($uploaded) && $this->input->post('invoice_date') != "") {
      		$header_insert = array(
      			"INVOICE_DATE" => $INVOICE_DATE,
      			"FAKTUR_PJK_DATE" => $FAKTUR_PJK_DATE,
      			"NO_SP_PO" => $NO_SP_PO,
      			"NO_KWITANSI" => $NO_KWITANSI,
      			"FAKTUR_PJK" => $FAKTUR_PJK,
      			"TOTAL_AMOUNT" => $TOTAL_AMOUNT,
      			"BASE_AMOUNT" => $BASE_AMOUNT,
      			"DP_REQ_AMOUNT" => $DP_REQ_AMOUNT,
      			"CURRENCY" => $CURRENCY,
      			"VENDOR_NO" => $VENDOR_NO,
      			"PAJAK" => $PAJAK,
      			"LPB" => $NO_LPB,
      			// "ITEM_CAT" => $itemCat,
      			"NO_TAX" => '0',
      			"PARTNER_BANK" => $PARTNER_BANK,
      			"COMPANY_CODE" => $companyCode
      		);

      		if (!empty($uploaded)) {
      			if (isset($uploaded['filePO'])) {
      				$header_insert['PO_PIC'] = $uploaded['filePO']['file_name'];
      			}
      			if (isset($uploaded['fileKwitansi'])) {
      				$header_insert['KWITANSI_PIC'] = $uploaded['fileKwitansi']['file_name'];
      			}
      			if (isset($uploaded['fileK3'])) {
      				$header_insert['LPB_PIC'] = $uploaded['fileK3']['file_name'];
      			}
      			if (isset($uploaded['fileFaktur'])) {
      				$header_insert['FAKPJK_PIC'] = $uploaded['fileFaktur']['file_name'];
      			}
      		}

      		$ID_INVOICE = $this->eh->insert($header_insert);
            // $this->load->model('invoice/ec_gr', 'gr');
            // $this->load->model('invoice/ec_gr_sap', 'gr_sap');
      		$this->load->model('invoice/ec_tracking_um', 'eti');


            // insert ke table GR
            // foreach ($grArr as $_gr) {
            //     $_tmpgr = explode('#', $_gr);
            //     no_gr#gr_item_no#tahun#po#po_item_no#curr#amount#uom#item_qty
            //     $_grOracle = array(
            //         "GR_NO" => $_tmpgr[0],
            //         "GR_ITEM_NO" => $_tmpgr[1],
            //         "GR_YEAR" => $_tmpgr[2],
            //         "PO_NO" => $_tmpgr[3],
            //         "PO_ITEM_NO" => $_tmpgr[4],
            //         "GR_CURR" => $_tmpgr[5],
            //         "GR_AMOUNT_IN_DOC" => $_tmpgr[6],
            //         "GR_ITEM_UNIT" => $_tmpgr[7],
            //         "GR_ITEM_QTY" => $_tmpgr[8],
            //         "GRDATE" => $_tmpgr[9],
            //         "GRPOSTING" => $_tmpgr[10],
            //         "DESCRIPTION" => $_tmpgr[11],
            //         "GR_DOC_CURR" => $_tmpgr[5],
            //         "COMPANY_CODE" => $companyCode,
            //         "STATUS" => 1,
            //         "INV_NO" => $ID_INVOICE
            //     );
            //     $this->gr->insert($_grOracle);
            // }

            // Diubah ketika fitur Approval Invoice Digunakan
            // $i = 0;
            // foreach ($grArr as $_gr) {
            //     $_tmpgr = explode('#', $_gr);

            //     /* Data Untuk Update EC_GR_SAP */
            //     $update_gr = array('STATUS' => $_tmpgr[12]);
            //     if ($_tmpgr[13]) {
            //         $update_gr['INV_NO'] = $ID_INVOICE;
            //     }

            //     //array('STATUS'=>$_tmpgr[12],'INV_NO' => $ID_INVOICE)
            //     if ($itemCat != '9') {
            //         $this->gr_sap->update($update_gr, array('BELNR' => $_tmpgr[0], 'BUZEI' => $_tmpgr[1], 'GJAHR' => $_tmpgr[2], 'STATUS' => 0));
            //     } else {
            //         $this->gr_sap->update($update_gr, array('LFBNR' => $_tmpgr[0], 'LFPOS' => $_tmpgr[1], 'LFGJA' => $_tmpgr[2], 'STATUS' => 0));
            //     }
            //     $i++;
            // }


      		/* insert ke tracking */
      		$data_tracking = array(
      			'ID_UM' => $ID_INVOICE,
      			'DESC' => 'BARU',
      			'STATUS_DOC' => 'BELUM KIRIM',
      			'STATUS_TRACK' => 1,
      			'POSISI' => 'VENDOR',
      			'USER' => $this->user
      		);
      		$this->eti->insert($data_tracking);

      	} else {
      		$pesan = 'Pembuatan Uang Muka Gagal';
      		$this->session->set_flashdata('message', $pesan);
      		redirect("EC_Invoice_um");
      	}

      	$this->db->trans_complete();
      	if ($this->db->trans_status() === FALSE) {
      		$this->db->trans_rollback();
      		$pesan = 'Create Uang Muka Gagal';
      		$this->session->set_flashdata('message', $pesan);
      		redirect("EC_Invoice_um");
      	} else {
      		$this->db->trans_commit();
      		$pesan = "Uang muka " . $ID_INVOICE . ", PO " . $NO_SP_PO . " created";
      		$this->session->set_flashdata('message', $pesan);
      		redirect("EC_Invoice_um");
      	}
      }

      public function editInvoice() {
      	$mat = $this->input->post('arrgr');
      	$xpl = explode(',', $mat[0]);

      	$this->load->model('ec_open_inv');
      	$this->load->library("file_operation");
      	$this->load->helper('file');
      	$this->load->helper(array('form', 'url'));
      	$this->load->model('invoice/ec_invoice_header', 'eh');
      	$uploaded = $this->file_operation->uploadL(UPLOAD_PATH . 'EC_invoice', $_FILES);
      	$denda = array();
      	$doc = array();

      	$ID_INVOICE = $this->input->post('id_invoice');
      	$NO_INVOICE = $this->input->post('invoice_no');
      	$PARTNER_BANK = $this->input->post('partner_bank');
      	$PAJAK = $this->input->post('pajak');
      	$INVOICE_DATE = $this->input->post('invoice_date');
      	$FAKTUR_PJK_DATE = $this->input->post('FakturDate');
      	$NO_SP_PO = $this->input->post('sppo_no');
      	$NO_BAPP = $this->input->post('bapp_no');
      	$NO_BAST = $this->input->post('bast_no');
      	$NO_KWITANSI = $this->input->post('kwitansi_no');
      	$FAKTUR_PJK = $this->input->post('faktur_no');
      	$POT_MUTU = $this->input->post('potmut_no');
      	$SURAT_PRMHONAN_BYR = $this->input->post('spbyr_no');
      	$TOTAL_AMOUNT = $this->input->post('totalAmount');
      	$TOTAL_AMOUNT = str_replace('.', '', $TOTAL_AMOUNT);

      	$NOTE = $this->input->post('note');
      	$K3 = $this->input->post('K3');
      	$VENDOR_NO = $this->session->userdata['VENDOR_NO'];
      	$header_update = array("NO_INVOICE" => $NO_INVOICE,
      		"INVOICE_DATE" => $INVOICE_DATE,
      		"FAKTUR_PJK_DATE" => $FAKTUR_PJK_DATE,
      		"NO_SP_PO" => $NO_SP_PO,
      		"NO_BAPP" => $NO_BAPP,
      		"NO_BAST" => $NO_BAST,
      		"NO_KWITANSI" => $NO_KWITANSI,
      		"FAKTUR_PJK" => $FAKTUR_PJK,
      		"POT_MUTU" => $POT_MUTU,
      		"SURAT_PRMHONAN_BYR" => $SURAT_PRMHONAN_BYR,
      		"TOTAL_AMOUNT" => $TOTAL_AMOUNT,
      		"NOTE" => $NOTE,
      		"PAJAK" => $PAJAK,
      		"K3" => $K3,
      		"PARTNER_BANK" => $PARTNER_BANK,
      		"STATUS_HEADER" => 1
      	);

      	if (!empty($uploaded)) {
      		if (isset($uploaded['filePotMutu'])) {
      			$header_update['POTMUT_PIC'] = $uploaded['filePotMutu']['file_name'];
      		}
      		if (isset($uploaded['fileInv'])) {
      			$header_update['INVOICE_PIC'] = $uploaded['fileInv']['file_name'];
      		}
      		if (isset($uploaded['fileBapp'])) {
      			$header_update['BAPP_PIC'] = $uploaded['fileBapp']['file_name'];
      		}
      		if (isset($uploaded['filePO'])) {
      			$header_update['PO_PIC'] = $uploaded['filePO']['file_name'];
      		}
      		if (isset($uploaded['fileBast'])) {
      			$header_update['BAST_PIC'] = $uploaded['fileBast']['file_name'];
      		}
      		if (isset($uploaded['fileKwitansi'])) {
      			$header_update['KWITANSI_PIC'] = $uploaded['fileKwitansi']['file_name'];
      		}
      		if (isset($uploaded['filespbyr'])) {
      			$header_update['SPMHONBYR_PIC'] = $uploaded['filespbyr']['file_name'];
      		}
      		if (isset($uploaded['fileK3'])) {
      			$header_update['K3_PIC'] = $uploaded['fileK3']['file_name'];
      		}
      		if (isset($uploaded['fileFaktur'])) {
      			$header_update['FAKPJK_PIC'] = $uploaded['fileFaktur']['file_name'];
      		}
      	}
      	$this->db->trans_begin();

      	$this->eh->update($header_update, array('ID_INVOICE' => $ID_INVOICE));
      	$this->load->model('invoice/ec_tracking_invoice', 'eti');
      	/* insert ke tracking */
      	$data_tracking = array(
      		'ID_INVOICE' => $ID_INVOICE,
      		'DESC' => 'EDIT',
      		'STATUS_DOC' => 'BELUM KIRIM',
      		'STATUS_TRACK' => 1,
      		'POSISI' => 'VENDOR',
      		'USER' => $this->user
      	);
      	$this->eti->insert($data_tracking);

        // remove t_denda_inv dan t_doc_inv
      	$this->load->model('invoice/ec_t_denda_inv', 'denda');
      	$this->load->model('invoice/ec_t_doc_inv', 'doc');
      	$this->denda->delete(array('ID_INV' => $ID_INVOICE));
      	$this->doc->delete(array('ID_INV' => $ID_INVOICE));

      	$denda_tambahan = isset($_POST["idDenda"]) ? $_POST["idDenda"] : array();
      	$keyFileDenda = array();
      	$keyFileDoc = array();
      	if (count($_FILES) > 0) {
      		foreach ($_FILES as $key => $value) {
      			$_keyFileDenda = substr($key, 0, 9);
      			$_keyFileDoc = substr($key, 0, 7);
                //  echo 'key '.$key.'<br >';
                //  echo 'substr '.$_keyFileDenda.'<br >';
      			if ($_keyFileDenda == 'fileDenda') {
      				/* ambil angkanya saja */
      				array_push($keyFileDenda, substr($key, 9));
      			}
      			if ($_keyFileDoc == 'fileDoc') {
      				array_push($keyFileDoc, substr($key, 7));
      			}
      		}
      	}

      	$denda_tambahan = isset($_POST["idDenda"]) ? $_POST["idDenda"] : array();
      	$i = 0;
      	if (!empty($keyFileDenda)) {
      		foreach ($keyFileDenda as $_key) {
      			$this->ec_open_inv->insertTDenda(array(
      				"ID_INV" => $ID_INVOICE, "ID_DENDA" => $_POST["idDenda"][$i], "NOMINAL" => $_POST["Nominal"][$i],
      				"PIC" => $_FILES['fileDenda' . $_key]['name'] == "" ? $_POST["oldFileDenda" . $_key] : $uploaded['fileDenda' . $_key]['file_name']));
      			$i++;
      		}
      	}
      	$data = array();
      	$doc_tambahan = isset($_POST["idDoc"]) ? $_POST["idDoc"] : array();
      	if (!empty($keyFileDoc)) {
      		$i = 0;
      		foreach ($keyFileDoc as $_key) {
      			$this->ec_open_inv->insertTDoc(array(
      				"ID_INV" => $ID_INVOICE, "ID_DOC" => $_POST["idDoc"][$i], "NO_DOC" => $_POST["noDoc"][$i],
      				"PIC" => $_FILES['fileDoc' . $_key]['name'] == "" ? $_POST["oldFileDoc" . $_key] : $uploaded['fileDoc' . $_key]['file_name']));
      			$i++;
      		}
      	}

      	$this->db->trans_complete();
      	if ($this->db->trans_status() === FALSE) {
      		$this->db->trans_rollback();
      		$pesan = 'Edit Invoice Gagal';
      		$this->session->set_flashdata('message', $pesan);
      		redirect(site_url('EC_Invoice_Management'));
      	} else {
      		$this->db->trans_commit();
            //$pesan = "Data PO ".$NO_SP_PO." no invoice ".$NO_INVOICE." berhasil diupdate";
      		$pesan = "Invoice " . $NO_INVOICE . ", PO " . $NO_SP_PO . " updated";
      		$this->session->set_flashdata('message', $pesan);
      		redirect("EC_Invoice_Management");
      	}
      }

      public function update_invoice($ID_INVOICE) {
      	header('Content-Type: application/json');
      	$this->load->model('ec_open_um');
        //$venno = $this -> session -> userdata['VENDOR_NO'];
        //$venno = "0000112709";
      	$this->ec_open_um->setStatus_Invoice($ID_INVOICE, $this->uri->segment(4), $this->session->userdata['VENDOR_NAME']);
      	$this->load->model('invoice/ec_um_header', 'eh');
      	$dataInv = $this->eh->get(array('ID_INVOICE' => $ID_INVOICE));
      	$pesan = "Uang Muka " . $ID_INVOICE . ", PO " . $dataInv->NO_SP_PO . " Submitted";
      	$this->session->set_flashdata('message', $pesan);
        //$json_data = array('data' => $dataa);
      	echo json_encode('Sukses');
      }

      public function delete_invoice($ID_INVOICE) {
      	header('Content-Type: application/json');
        //$this->ec_open_inv->delete_Invoice($ID_INVOICE, $this->session->userdata['VENDOR_NAME']);
        //$json_data = array('data' => $dataa);
      	$this->load->model('invoice/ec_invoice_header', 'eih');
      	$this->load->model('invoice/ec_gr', 'gr');
      	$this->load->model('invoice/ec_gr_sap', 'gr_sap');
      	$this->db->trans_begin();

      	$dataInv = $this->eih->get(array('ID_INVOICE' => $ID_INVOICE));
        /* update data pada ec_gr_sap 
        $this->gr_sap->update(array('STATUS'=>0,'INV_NO' => 0),array('INV_NO' => $ID_INVOICE)); */

        /* update data pada ec_gr_sap ketika fitur Invoice Parcial Diaktifkan */

        $dataGR = $this->gr->as_array()->get_all(array('INV_NO' => $ID_INVOICE));


        for ($i = 0; $i < count($dataGR); $i++) {
        	if ($dataInv->ITEM_CAT != '9') {
        		$this->gr_sap->update(array('STATUS' => 0, 'INV_NO' => 0), array('BELNR' => $dataGR[$i]['GR_NO'], 'BUZEI' => $dataGR[$i]['GR_ITEM_NO'], 'GJAHR' => $dataGR[$i]['GR_YEAR']));
        	} else {
        		$this->gr_sap->update(array('STATUS' => 0, 'INV_NO' => 0), array('LFBNR' => $dataGR[$i]['GR_NO'], 'LFPOS' => $dataGR[$i]['GR_ITEM_NO'], 'LFGJA' => $dataGR[$i]['GR_YEAR']));
        	}
        }

        /* delete data pada ec_gr */
        $this->gr->delete(array('INV_NO' => $ID_INVOICE));

        /* delete data ec_invoice_header */
        $this->eih->delete(array('ID_INVOICE' => $ID_INVOICE));

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
        	$this->db->trans_rollback();
        	echo json_encode('Gagal');
        } else {
        	$this->db->trans_commit();
        	$pesan = "Invoice " . $dataInv->NO_INVOICE . ", PO " . $dataInv->NO_SP_PO . " deleted";
        	$this->session->set_flashdata('message', $pesan);
        	echo json_encode('Sukses');
        }
    }

    public function tracking($ID_INVOICE = '') {
    	header('Content-Type: application/json');
    	$this->load->model('ec_open_um');
    	$datainvoice = $this->ec_open_um->tracking($ID_INVOICE);
    	echo json_encode($datainvoice);
    }

    public function dataDokumen($invoice) {
    	$this->load->model('invoice/ec_t_denda_inv', 'etdi');
    	$this->load->model('invoice/ec_t_doc_inv', 'etdo');
    	$this->load->model('invoice/ec_invoice_header', 'eih');
    	$this->load->model('invoice/ec_m_doc_inv', 'mdoc');
    	$this->load->model('invoice/ec_m_denda_inv', 'mdenda');

    	$_mdenda = $this->mdenda->get_all();
    	$mdenda = array();
    	foreach ($_mdenda as $_md) {
    		$mdenda[$_md->ID_JENIS] = $_md->JENIS;
    	}
    	$_mdoc = $this->mdoc->get_all();
    	$mdoc = array();
    	foreach ($_mdoc as $_md) {
    		$mdoc[$_md->ID_JENIS] = $_md->JENIS;
    	}
    	$header = $this->eih->as_array()->get(array('ID_INVOICE' => $invoice));
    	$denda = $this->etdi->get_all(array('ID_INV' => $invoice));
    	$doc = $this->etdo->get_all(array('ID_INV' => $invoice));
    	$masterDokumen = array(
    		'INVOICE_PIC' => 'Dokument Invoice',
    		'BAPP_PIC' => 'Dokument BAPP',
    		'BAST_PIC' => 'Dokument BAST / PP / RR',
    		'KWITANSI_PIC' => 'Kwitansi',
    		'FAKPJK_PIC' => 'Faktur Pajak',
    		'POTMUT_PIC' => 'Dokument Potongan Mutu',
    		'SPMHONBYR_PIC' => 'Surat Permohonan Bayar',
    		'AMOUNT_PIC' => 'Dokument Amount',
    		'K3_PIC' => 'Dokument K3',
    		'PO_PIC' => 'Dokument PO'
    	);
    	$nilaiDokumen = array(
    		'INVOICE_PIC' => 'NO_INVOICE',
    		'BAPP_PIC' => 'NO_BAPP',
    		'BAST_PIC' => 'NO_BAST',
    		'KWITANSI_PIC' => 'NO_KWITANSI',
    		'FAKPJK_PIC' => 'FAKTUR_PJK',
    		'POTMUT_PIC' => 'POT_MUTU',
    		'SPMHONBYR_PIC' => 'SURAT_PRMHONAN_BYR',
    		'AMOUNT_PIC' => 'TOTAL_AMOUNT',
    		'K3_PIC' => 'K3',
    		'PO_PIC' => 'NO_SP_PO'
    	);

    	/* Inject Data Faktur Pajak Ketika Invoice Parcial */
    	$temp = $this->checkParcial($invoice);

    	if ($temp) {
    		$header['FAKPJK_PIC'] = $temp['FAKPJK_PIC'];
    		$header['FAKTUR_PJK'] = $temp['FAKTUR_PJK'];
    		$masterDokumen['FAKPJK_PIC'] = 'Referensi Faktur Pajak';
    	}

    	$listDoc = array();
    	$keyMasterDokumen = array_keys($masterDokumen);
    	foreach ($header as $key => $val) {
    		if (in_array($key, $keyMasterDokumen)) {
    			if (!empty($val)) {
    				$kolomData = $nilaiDokumen[$key];
    				if (!empty($header[$kolomData])) {
    					$listDoc[$masterDokumen[$key]] = $header[$kolomData];
    				}
    			}
    		}
    	}
    	if (!empty($denda)) {
    		foreach ($denda as $_d) {
    			$listDoc[$mdenda[$_d->ID_DENDA]] = $_d->NOMINAL;
    		}
    	}
    	if (!empty($doc)) {
    		foreach ($doc as $_d) {
    			$listDoc[$mdoc[$_d->ID_DOC]] = $_d->NO_DOC;
    		}
    	}
    	return $listDoc;
    }

    public function listDokumen() {

    	$invoice = $this->input->get('invoice');
    	$proses = $this->input->get('proses');
    	$status = $this->input->get('status');
    	$listDoc = $this->dataDokumen($invoice);
    	$data['alasan_reject'] = '';
    	$this->load->model('invoice/ec_ekspedisi', 'ee');
    	$ekspedisi = $this->ee->order_by('CREATE_DATE', 'DESC')->get(array('ID_INVOICE' => $invoice));
    	if (!empty($ekspedisi)) {
    		$data['alasan_reject'] = $ekspedisi->ALASAN_REJECT_DOCUMENT;
    		$data['catatan_vendor'] = $ekspedisi->CATATAN_VENDOR;
    	}

    	$data['listDoc'] = $listDoc;
    	$data['invoice'] = $invoice;
    	if ($proses == 'terima') {
    		$data['tombol'] = '<div><span data-invoice="' . $invoice . '" class="btn btn-primary" onclick="SubmitDokumen(this)">Submit</span> &nbsp;<span data-proses="reject" data-invoice="' . $invoice . '" class="btn btn-danger" onclick="RejectDokumen(this)">Reject</span></div>';
    	} else if ($proses == 'terima_retur') {
    		$data['tombol'] = '<span data-invoice="' . $invoice . '" data-proses="terima_retur" class="btn btn-primary" onclick="SubmitDokumen(this)">Terima</span>';
    	} else {
    		$data['tombol'] = '<span data-invoice="' . $invoice . '" class="btn btn-primary" onclick="SubmitDokumen(this)">Submit</span>';
    	}

    	if (!empty($status)) {
    		$data['tombol'] = '<span data-invoice="' . $invoice . '" class="btn btn-primary" onclick="kirimDokumenReject(this)">Submit</span>';
    	}

    	$data['proses'] = $proses;
    	$data['status'] = $status;
    	$this->load->view('EC_Invoice_Management/listDokumen', $data);
    }

    public function updatePosisiDokumen() {

    	$invoice = $this->input->post('invoice');
    	$proses = $this->input->post('proses');
    	$reject = $this->input->post('reject') || 0;
    	$alasan_reject = $this->input->post('alasan_reject');
        $cat = $this->input->post('catatan_vendor'); // Kondisi Ketika Vendor Kirim Ulang Dokumen
        $catatan_vendor = empty($cat) ? "" : $cat;

        /* cari status dokumen terakhir */
        $this->load->model('invoice/ec_tracking_invoice', 'eti');
        $this->load->model('invoice/ec_invoice_header', 'eih');

        $dataInvoice = $this->eih->get(array('ID_INVOICE' => $invoice));
        $tracking = $this->eti->order_by('DATE', 'DESC')->get(array('ID_INVOICE' => $invoice));
        $data_tracking = array(
        	'ID_INVOICE' => $invoice,
        	'DESC' => 'EDIT',
        	'USER' => $this->user,
        	'STATUS_DOC' => '',
        	'STATUS_TRACK' => $tracking->STATUS_TRACK,
        	'POSISI' => ''
        );

        $bisaKirim = array('BELUM KIRIM', 'RETUR', 'TERIMA'); // TERIMA setelah diretur oleh verifikasi
        $pesan = 'Dokumen berhasil dikirim';
        $kirimDokumen = array('status' => 1, 'message' => '');
        switch ($tracking->POSISI) {
        	case 'VENDOR':
                if (in_array($tracking->STATUS_DOC, $bisaKirim)) { // Vendor kirim pertama
                	$data_tracking['STATUS_DOC'] = 'KIRIM';
                	$data_tracking['POSISI'] = 'EKSPEDISI';
                	/* kirim dokumen oleh ekspedisi */
                	$kirimDokumen = $this->kirimDokumenSAP($dataInvoice, $catatan_vendor);
                }
                break;
                case 'EKSPEDISI':
                if ($reject) {
                	$data_tracking['STATUS_DOC'] = 'RETUR';
                	$data_tracking['POSISI'] = 'EKSPEDISI';
                	/* terima dulu */
                	$kirimDokumen = $this->verifikasiTerimaDokumenSAP($invoice);

                	/* lalu direject */
                	if ($kirimDokumen['status']) {
                		$kirimDokumen = $this->verifikasiRejectDokumenSAP($invoice, $alasan_reject);
                	}
                	$pesan = 'Dokumen berhasil direject';
                	/* notifikasi dokumen telah direject */
                	$this->notifikasiRejectDokumen($dataInvoice, $alasan_reject);
                } else if ($proses == 'terima_retur') {
                	$data_tracking['STATUS_DOC'] = 'TERIMA';
                	$data_tracking['POSISI'] = 'VENDOR';
                	$kirimDokumen['message'] = 'Dokumen berhasil diterima';
                } else {
                	$data_tracking['STATUS_DOC'] = 'TERIMA';
                	$data_tracking['POSISI'] = 'VERIFIKASI';
                	$kirimDokumen = $this->verifikasiTerimaDokumenSAP($invoice);
                	$pesan = 'Dokumen berhasil diterima';
                	/* notifikasi dokumen telah diterima */
                	$this->notifikasiApproveDokumen($dataInvoice);
                }
                break;
            }

            /* update di database */
            $result = array('status' => 0, 'message' => 'Dokumen gagal dikirim');
            if ($kirimDokumen['status']) {
            	$pesan = $kirimDokumen['message'];
            	if ($this->eti->insert($data_tracking)) {
            		$result['status'] = 1;
            		$result['message'] = $pesan;
            	}
            } else {
            	$result['message'] = $kirimDokumen['message'];
            }
            $result['proses'] = $proses;
            echo json_encode($result);
        }

        public function cetakDokumenEkspedisi($invoice) {
        	$this->load->library('M_pdf');
        	$mpdf = new M_pdf();
        	$this->load->model('ec_open_inv');
        	$this->load->model('invoice/ec_ekspedisi', 'ee');
        	$dataa = $this->ec_open_inv->get_Invoice(' where EIH.ID_INVOICE = \'' . $invoice . '\'');
        	$data['po'] = $dataa[0]['NO_SP_PO'];
        	$data['vendorName'] = $dataa[0]['VEND_NAME'];
        	$data['mir7'] = $dataa[0]['INVOICE_SAP'];
        	$data['listDoc'] = $this->dataDokumen($invoice);
        	/* cari nomer dokumen ekspedisi */
        	$ekspedisi = $this->ee->order_by('CREATE_DATE', 'DESC')->get(array('ID_INVOICE' => $invoice));
        	$data['no_ekspedisi'] = $ekspedisi->NO_EKSPEDISI;
        	$data['catatan_vendor'] = $ekspedisi->CATATAN_VENDOR;
        	$data['tahun'] = $ekspedisi->TAHUN;
        	$data['company'] = $ekspedisi->COMPANY;
        	$data['accounting_invoice'] = $ekspedisi->ACCOUNTING_INVOICE;
        	$data['id_invoice'] = $ekspedisi->ID_INVOICE;
        	$tgl = new DateTime($ekspedisi->CREATE_DATE);
        	$data['tgl_ekspedisi'] = $tgl->format('d/m/Y');
        	$html = $this->load->view('cetakDokumenEkspedisi', $data, TRUE);
        	$mpdf->pdf->writeHTML($html);
        	$mpdf->pdf->output();
        }

        public function getAccountingInvoice($invoicepark, $tahun) {
        	$this->load->library('sap_handler');
        	if (empty($tahun)) {
        		$tahun = date('Y');
        	}
        	$t = $this->sap_handler->getAccountingInvoice($invoicepark, $tahun);
        	return $t[0]['REC_KEY'];
        }

        public function kirimDokumenSAP($dataInvoice, $catatan_vendor) {
        	$this->load->library('sap_handler');
        	$this->load->model('invoice/ec_gr_sap', 'gr_sap');
        	$this->load->model('invoice/ec_gr', 'gr');
        	$this->load->model('invoice/ec_posting_invoice', 'epi');
        	/* cari company dan plant */
        	$idinovice = $dataInvoice->ID_INVOICE;
        //  $_dinvoice = $this->gr_sap->fields(array('WERKS'))->get(array('INV_NO'=>$idinovice, 'STATUS'=>1));
        //  $kodeAwalCompany = substr($_dinvoice->WERKS,0,1);
        //  $company = $kodeAwalCompany.'000';
        	$company = $dataInvoice->COMPANY_CODE;
        	$tglInvoice = new DateTime($dataInvoice->INVOICE_DATE);
        	/* cari tanggal posting invoice */
        	$_tposting = $this->epi->get(array('ID_INVOICE' => $idinovice));
        	$tglPosting = new DateTime($_tposting->POSTING_DATE);
        	$header = array(
        		'company' => $company,
        		'vendor' => $dataInvoice->VENDOR_NO,
        		'invoice_date' => $tglInvoice->format('Ymd'),
        		'posting_date' => $tglPosting->format('Ymd')
        	);
        	$grItem = $this->gr->get_all(array('INV_NO' => $idinovice, 'STATUS' => 1));
        	$itemInvoice = $dataInvoice->FI_NUMBER_SAP;
        	if (empty($itemInvoice)) {
        		$itemInvoice = $this->getAccountingInvoice($dataInvoice->INVOICE_SAP, $dataInvoice->FISCALYEAR_SAP);
        	}
        //  $itemInvoice = $dataInvoice->FI_NUMBER_SAP;
        	$item = array();
        	foreach ($grItem as $_t) {
        		array_push($item, array(
        			'invoice' => $itemInvoice,
        			'currency' => $dataInvoice->CURRENCY,
        			'amount' => $dataInvoice->CURRENCY == 'IDR' ? $dataInvoice->TOTAL_AMOUNT / 100 : $dataInvoice->TOTAL_AMOUNT,
        			'payment_block' => 3,
        			'po' => $_t->PO_NO,
        			'item_po' => $_t->PO_ITEM_NO
        		)
        	);
        	}


        	$t = $this->sap_handler->kirimDokumenEkspedisi($header, $item);
        	$nomerDokumen = 0;
        	$result = array(
        		'status' => 0,
        		'message' => ''
        	);
        	if ($t[0]['TYPE'] == 'S') {
        		$str = $t[0]['MESSAGE'];
        		preg_match_all('!\d+!', $str, $matches);
        		$nomerDokumen = $matches[0];
        		/* simmpan ke database */
        		$this->load->model('invoice/ec_ekspedisi', 'ee');
        		if ($this->ee->insert(array('ID_INVOICE' => $dataInvoice->ID_INVOICE, 'NO_EKSPEDISI' => $nomerDokumen[0], 'TAHUN' => date('Y'), 'ACCOUNTING_INVOICE' => $itemInvoice, 'COMPANY' => $company, 'CATATAN_VENDOR' => $catatan_vendor))) {
        			$result['status'] = 1;
        			$result['message'] = 'Dokumen berhasil dikirim dengan nomer ekspedisi ' . $nomerDokumen[0];
        		}
        	} else {
        		$result['message'] = $t[0]['MESSAGE'];
        	}
        	return $result;
        }

        public function verifikasiTerimaDokumenSAP($invoice) {
        	$this->load->library('sap_handler');
        	$this->load->model('invoice/ec_ekspedisi', 'ee');
        	$this->load->model('ec_master_inv');

        //$mapping = $this->ec_master_inv->getMappingUser();

        	$ekspedisi = $this->ee->order_by('CREATE_DATE', 'DESC')->get(array('ID_INVOICE' => $invoice));
        	$header = array();
        	$header['company'] = $ekspedisi->COMPANY;
        	$header['no_ekspedisi'] = $ekspedisi->NO_EKSPEDISI;
        	$header['tahun'] = $ekspedisi->TAHUN;
        	$header['accounting_invoice'] = $ekspedisi->ACCOUNTING_INVOICE;
        	$header['username'] = $this->getIdSAP($this->session->userdata['EMAIL']);

        	$t = $this->sap_handler->verifikasiTerimaDokumenSAP($header);
        	$result = array(
        		'status' => 0,
        		'message' => ''
        	);
        	if ($t[0]['TYPE'] == 'S') {
        		$result['status'] = 1;
        		$result['message'] = $t[0]['MESSAGE'];
        	} else {
        		$result['message'] = $t[0]['MESSAGE'];
        	}
        	return $result;
        }

        public function verifikasiRejectDokumenSAP($invoice, $alasan_reject) {
        	$this->load->library('sap_handler');
        	$this->load->model('invoice/ec_ekspedisi', 'ee');
        	$ekspedisi = $this->ee->order_by('CREATE_DATE', 'DESC')->get(array('ID_INVOICE' => $invoice));

        	$update_eks = array('ALASAN_REJECT_DOCUMENT' => $alasan_reject);
        	$this->ee->update($ekspedisi->NO_EKSPEDISI, $update_eks);
        //print_r($this->db->last_query());
        //die();
        	$header = array();
        	$header['company'] = $ekspedisi->COMPANY;
        	$header['no_ekspedisi'] = $ekspedisi->NO_EKSPEDISI;
        	$header['tahun'] = $ekspedisi->TAHUN;
        	$header['accounting_invoice'] = $ekspedisi->ACCOUNTING_INVOICE;
        	$header['username'] = $this->session->userdata('FULLNAME');
        	$t = $this->sap_handler->verifikasiRejectDokumenSAP($header);
        	$result = array(
        		'status' => 0,
        		'message' => ''
        	);
        	if ($t[0]['TYPE'] == 'S') {
        		$result['status'] = 1;
        		$result['message'] = $t[0]['MESSAGE'];
        	} else {
        		$result['message'] = $t[0]['MESSAGE'];
        	}
        	return $result;
        }

        private function getRangeFakturNo($t, $invoiceDate) {
        	$this->load->library('sap_invoice');
        	$l = $this->sap_invoice->getRangeFakturNo($t);
        // print_r($l);die();
        	$validRange = array();
        	if (!empty($l)) {
        		foreach ($l as $k) {
        			if (empty($k['FLAG'])) {
        				$awalPeriode = $k['BEGDA'];
        				$akhirPeriode = $k['ENNDA'];
        				if ($this->validRangeDate($awalPeriode, $akhirPeriode, $invoiceDate)) {
        					$tmp = array('awal' => $k['FPNUML'], 'akhir' => $k['FPNUMH']);
        					array_push($validRange, $tmp);
        				}
        			}
        		}
        	}
        	return $validRange;
        }

        public function validRangeDate($awalSap, $akhirSap, $currentDate = NULL) {

        	$awal = saptotime($awalSap);
        	$akhir = saptotime($akhirSap);
        //  $currentDate = '2017-06-01';
        	$current = empty($currentDate) ? time() : strtotime($currentDate);
        	$result = 0;
        	if ($current >= $awal && $current <= $akhir) {
        		$result = 1;
        	}
        // echo 'awal ='.$awal.' current = '.$current.' akhir = '.$akhir.' hasilnya = '.$result.'<br />';

        	return $result;
        }

        public function validFakturPajak() {
        	$nofaktur = $this->input->get('no_faktur');
        	$no_po = $this->input->get('no_po');
        	$id_invoice = $this->input->get('id_invoice');
        	$invoice_date = $this->input->get('invoice_date');

        	$venno = $this->session->userdata['VENDOR_NO'];
        	$bypassVendor = $this->vendorNonWapu($venno);
        	if ($bypassVendor) {
        		$result = array('status' => 1, 'message' => 'Tanpa Cek Faktur Pajak ');
        		echo json_encode($result);
        		exit;
        	}



        //$vendor_no = $this->input->get('vendor_no');
        	/* format yang dkirim bentuknya d-m-Y atau d/m/Y */
        	$tmpDate = str_replace('-', '', $invoice_date);
        	if (strlen($tmpDate) != 8) {
        		$tmpDate = str_replace('/', '', $invoice_date);
        	}
        	list($day, $month, $year) = sscanf($tmpDate, '%02d%02d%04d');
        	$invoiceDate = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);

        	/* pastikan nomer faktur belum ada di tabel ec_invoice_header */
        	$nofakturOracle = formatPajak($nofaktur);
        	$cekFaktur = $this->db->select(array('ID_INVOICE'))->where(array('FAKTUR_PJK' => $nofakturOracle))->get('EC_INVOICE_HEADER')->row();
        	if (!empty($cekFaktur)) {
        		if (!empty($id_invoice)) {
        			if ($cekFaktur->ID_INVOICE != $id_invoice) {
        				$result = array('status' => 0, 'message' => 'No Faktur Pajak Sudah Dipakai ');
        				echo json_encode($result);
        				exit;
        			}
        		} else {
        			$result = array('status' => 0, 'message' => 'No Faktur Pajak Sudah Dipakai ');
        			echo json_encode($result);
        			exit;
        		}
        	}

        	/* pastikan no_faktur belum digunakan di SAP */

        	/* cari company code dari po */
        	$where_po = 'EBELN = ' . $no_po . ' and WERKS is not null';
        	$_companyCode = $this->db->select(array('WERKS', 'LIFNR'))->where($where_po)->limit(2)->get('EC_GR_SAP')->row_array();
        	$companyCode = substr($_companyCode['WERKS'], 0, 1) . '000';
        	$vendor_no = $_companyCode['LIFNR'];

        	$t = array('COMPANY_CODE' => $companyCode, 'VENDOR_NO' => $vendor_no);
        	$l = $this->getRangeFakturNo($t, $invoiceDate);
        // print_r($l);die();
        //  $l = array();
        	/* sementara hardcode dulu range yang bisa digunakan, nanti ambil dari SAP dengan parameter vendor_no dan tahun */
        	$notValid = 1;
        	$message = 'Untuk pendaftaran E-Nova klik "<a href=' . site_url('EC_Vendor/Form_Enofa') . '> Daftar </a>" atau Hubungi Seksi Pajak pswt 8266 <br >Anda belum memiliki nomer faktur pajak yang terdaftar di Semen Indonesia';
        	$valid = 0;
        	$mulai = 0;
        	$tmp_message = array();
        	while ($notValid && $mulai < count($l)) {
        		$range = $l[$mulai];
        		$_current_faktur = substr($nofaktur, 3);
        		$range['current'] = str_pad($_current_faktur, 16, '0', STR_PAD_LEFT);
        		$cekPajak = $this->isValidFaktur($range);
        		if ($cekPajak['status']) {
        			$notValid = 0;
        			$valid = 1;
        			$message = '';
        		} else {
        			array_push($tmp_message, $cekPajak['message']);
        		}
        		$mulai++;
        	}
        	$range['current'] = $nofaktur;
        	if (!empty($tmp_message)) {
        		array_push($tmp_message, 'Untuk pendaftaran E-Nova klik "<a href=' . site_url('EC_Vendor/Form_Enofa') . '> Daftar </a>"');
        		$message = implode(' <br > ', $tmp_message);
        	}
        	$result = array('status' => $valid, 'message' => $message);
        	echo json_encode($result);
        }

        private function isValidFaktur($range) {
        	$_range = array();
        	$len = 8;
        	foreach ($range as $k => $v) {
        		$v = str_pad($v, 16, '0', STR_PAD_LEFT);
        		$_range[$k] = $this->pecahInteger($v, $len);
        	}

        	$valid = 1;
        	$mulai = 0;
        	$message = 'Anda belum memiliki nomer faktur pajak';
        	$jmlUlang = count($_range['awal']);

        	while (($mulai < $jmlUlang) && $valid) {
        		$_awal = intval($_range['awal'][$mulai]);
        		$_akhir = intval($_range['akhir'][$mulai]);
        		$_current = intval($_range['current'][$mulai]);

        		if ($_current > $_akhir or $_current < $_awal) {
        			$valid = 0;
        			$message = 'Nomer faktur pajak yang valid antara ' . $range['awal'] . ' sd ' . $range['akhir'];
        		}
        		$mulai++;
        	}
        	return array('status' => $valid, 'message' => $message);
        }

        private function pecahInteger($int, $len) {
        	$jmlStr = strlen($int);
        	$ulang = ceil($jmlStr / $len);
        	$result = array();
        	$start = 0;
        	for ($i = 0; $i < $ulang; $i++) {
        		array_push($result, substr($int, $start, $len));
        		$start += $len;
        	}
        	return $result;
        }

        public function getListAccountingDocument($noDocument, $tahun, $company) {
        	$this->load->library('sap_invoice');
        	$param = array();
        	$param['I_BUKRS'] = $company;
        	$param['I_BELNR_FROM'] = $noDocument;
        	$param['I_GJAHR'] = $tahun;
        	$t = $this->sap_invoice->getListAccountingDocument($param);
        	$result = array();
        	foreach ($t as $_t) {
        		$sign = $_t['SHKZG'] == 'H' ? 'minus' : 'plus';
        		$desc = '';
        		if ($_t['KOART'] != 'K') {
        			$desc = $this->getGlDesc($_t['BUKRS'], $_t['HKONT']);
        		} else {
        			$desc = array('LONG_TEXT' => $this->getVendorName($_t['LIFNR']));
        		}
        		$tmp = array(
        			'DEBET/KREDIT' => $_t['SHKZG'],
        			'ITEM' => $_t['BUZEI'],
        			'PK' => $_t['BSCHL'],
        			'ACCOUNT' => $_t['KOART'] == 'K' ? $_t['LIFNR'] : $_t['HKONT'],
        			'DESCRIPTION' => $desc['LONG_TEXT'],
        			'CURRENCY' => $_t['WAERS'],
        			'AMOUNT_IN_LOCAL' => $_t['WAERS'] == 'IDR' ? accountingFormat($_t['DMBTR'] * 100, $sign) : accountingFormat($_t['DMBTR'], $sign),
        			'AMOUNT' => $_t['WAERS'] == 'IDR' ? accountingFormat($_t['WRBTR'] * 100, $sign) : accountingFormat($_t['WRBTR'], $sign),
        			'TAX_CODE' => $_t['MWSKZ']
        		);
        		array_push($result, $tmp);
        	}
        	return $result;
        }

        public function viewAccountingDocument() {
        	$noDocument = $this->input->get('noDocument');
        	$tahun = $this->input->get('tahun');
        	$company = $this->input->get('company');
        	$param = array();

        	$t = $this->getListAccountingDocument($noDocument, $tahun, $company);
        	$this->load->view('accountingDocument', array('list' => $t));
        }

        public function getGlDesc($comp, $gl) {
        	$this->load->library('sap_invoice');
        	$t = $this->sap_invoice->getGlDesc($comp, $gl);
        	return $t;
        }

        public function getVendorName($vendor_no) {
        	$t = $this->db->select(array('NAME1'))->where(array('LIFNR' => $vendor_no))->limit(2)->get('EC_GR_SAP')->row_array();
        	return $t['NAME1'];
        }

        public function Info() {
        	$t = '05-12-2017';
        	$y = '05/12/2017';
        	echo str_replace('-', '', $t) . '<br />';
        	echo str_replace('/', '', $y) . '<br />';
        	echo strtotime('01-05-2017');
        	echo ' sama dengan ' . strtotime('05/01/2017');
        	echo ' sama dengan ' . strtotime('2017-05-01');
        // phpinfo();
        //echo ini_get('upload_max_filesize').'<br/>';
        //ini_set("upload_max_filesize","300M");
        //echo ini_get("upload_max_filesize");
        // $this->db->query('delete ec_tracking_invoice where posisi is null');
        // $t = $this->db->query('update ec_invoice_header set company_code = 7000');
        /*
          echo '<pre>';
          $t = $this->db->query(' select * from ec_ekspedisi');
          print_r($t->result_array());

          $t = 99999999;
          echo $t;
          echo strlen($t);
          echo ceil(1.2);
          echo '<hr >';
          print_r($this->pecahInteger($t,1));
         */
      }

      public function getIdSAP($email) {
      	$this->load->model('ec_master_inv');
      	$mapping = $this->ec_master_inv->getMappingUser($email);

      	$result = $email;

      	if (!empty($mapping)) {
      		$result = $mapping['ID_SAP'];
      	}
      	return $result;
      }

      public function notifikasiApproveDokumen($dataInvoice) {
      	$this->load->model(array('vnd_header'));
        //  $this->load->model('invoice/ec_invoice_header', 'eih');
        //  $dataInvoice = $this->eih->as_array()->get('212');
      	$_data = $this->eih->as_array()->get($dataInvoice->ID_INVOICE);
      	$data_vendor = $this->vnd_header->get(array('VENDOR_NO' => $_data['VENDOR_NO']));
      	$data = array(
      		'content' => '
      		Dokumen received on ' . date('d M Y H:i:s') . '<br>
      		Nomor PO        : ' . $dataInvoice->NO_SP_PO . '<br>
      		Nomor Invoice   : ' . $dataInvoice->NO_INVOICE . '<br>
      		Tanggal Invoice : ' . $dataInvoice->INVOICE_DATE . '<br>',
      		'title' => 'Invoice ' . $dataInvoice->NO_INVOICE . ' Received',
      		'title_header' => 'Invoice ' . $dataInvoice->NO_INVOICE . ' Received',
      	);
      	$message = $this->load->view('EC_Notifikasi/approveInvoice', $data, TRUE);
      	$_to = $data_vendor['EMAIL_ADDRESS'];
        //  $_to = 'ahmad.afandi85@gmail.com';
      	$subject = 'Invoice ' . $dataInvoice->NO_INVOICE . ' Received  [E-Invoice Semen Indonesia]';
      	Modules::run('EC_Notifikasi/Email/invoiceNotifikasi', $_to, $message, $subject);
      }

      public function notifikasiRejectDokumen($dataInvoice, $alasan_reject) {
      	$this->load->model(array('vnd_header'));
      	$_data = $this->eih->as_array()->get($dataInvoice->ID_INVOICE);
      	$data_vendor = $this->vnd_header->get(array('VENDOR_NO' => $_data['VENDOR_NO']));
      	$data = array(
      		'content' => '
      		Dokumen rejected on ' . date('d M Y H:i:s') . '<br>
      		Nomor PO        : ' . $dataInvoice->NO_SP_PO . '<br>
      		Nomor Invoice   : ' . $dataInvoice->NO_INVOICE . '<br>
      		Tanggal Invoice : ' . $dataInvoice->INVOICE_DATE . '<br>
      		Alasan Reject   : ' . $alasan_reject,
      		'title' => 'Invoice ' . $dataInvoice->NO_INVOICE . ' Rejected',
      		'title_header' => 'Invoice Reject' . $dataInvoice->NO_INVOICE . ' Rejected',
      	);
      	$message = $this->load->view('EC_Notifikasi/rejectInvoice', $data, TRUE);
      	$_to = $data_vendor['EMAIL_ADDRESS'];
        //    $_to = 'ahmad.afandi85@gmail.com';
      	$subject = 'Invoice ' . $dataInvoice->NO_INVOICE . ' Rejected  [E-Invoice Semen Indonesia]';
      	Modules::run('EC_Notifikasi/Email/invoiceNotifikasi', $_to, $message, $subject);
      }

      public function denda($data) {
//        var_dump($data);die();
      	$tgl_gr_year = substr($data['TGL_GR'], 0, 4);
      	$tgl_gr_month = substr($data['TGL_GR'], 4, 2);
      	$tgl_gr_days = substr($data['TGL_GR'], 6, 2);
      	$tgl_gr = mktime(0, 0, 0, $tgl_gr_month, $tgl_gr_days, $tgl_gr_year);


      	$tgl_batas_po_year = substr($data['TGL_BATAS_PO'], 0, 4);
      	$tgl_batas_po_month = substr($data['TGL_BATAS_PO'], 4, 2);
      	$tgl_batas_po_days = substr($data['TGL_BATAS_PO'], 6, 2);
      	$tgl_batas_po = mktime(0, 0, 0, $tgl_batas_po_month, $tgl_batas_po_days, $tgl_batas_po_year);

      	$dt['selisih'] = round((int)($tgl_gr - $tgl_batas_po) / (3600 * 24));

      	if($dt['selisih'] > 0){
      		$denda1 = (15 / 10000) * $dt['selisih'] * $data['TOTAL_GR'];
      		$denda2 = (5 / 100) * $data['TOTAL_GR'];
      		if ($denda1 < $denda2) {
      			$dt['denda'] = $denda1;
      		} else {
      			$dt['denda'] = $denda2;
      		}
      	}else{ $dt['denda'] = 0; }

      	return $dt;
      }

      public function cek() {
      	$data['TGL_GR'] = "20171208";
      	$data['TGL_BATAS_PO'] = "20171209";
      	$data['TOTAL_GR'] = 100000;
      	echo "<pre>";
      	echo print_r($this->denda($data));
      	echo "</pre>";
      }

      public function showDocument() {
        // echo "<pre>";
        // print_r($this->input->post());die;
      	$this->load->config('ec');
      	$id = $this->input->post('id');
      	$tipe = $this->input->post('tipe');
      	$nopo = $this->input->post('nopo');

      	$this->load->library('sap_invoice');
      	$kirim['ambil_uk_peminta'] = $this->sap_invoice->getUKPeminta($nopo);

      	$this->load->model('invoice/ec_gr_lot', 'egl');
      	$kirim['ambil_approval'] = $this->egl->getlot($id);
        // print_r($kirim['ambil_approval']);die;
        // print_r($kirim['ambil_uk_peminta']);die;
      	$print_type = strtoupper($this->input->post('print_type'));
      	$viewDoc = $tipe == 'RR' ? 'cetakRR' : 'cetakBAST';
      	$this->load->library('M_pdf');
      	$mpdf = new M_pdf();

      	/* ambil data PO untuk dijadikan parameter pencarian pada RFC */

      	$company_data = $this->config->item('company_data');
      	$kirim['data'] = $this->getDataDocument($id, $nopo, $tipe, $print_type);
      	$kirim['jenis_id'] = $print_type;    
      	if($kirim['data']['poHeader']['CO_CODE']=='7000' && $kirim['data']['detailRR']['0']['GR_YEAR']=='2017'){
      		$kirim['company_data'] = $company_data['7kso'];
      	}else{
      		$kirim['company_data'] = $company_data[$kirim['data']['poHeader']['CO_CODE']];
      	}
      	$kirim['print_type'] = $print_type;
      	$kirim['id'] = $id;

      	$kirim['ambil_jabatan'] = $this->db->where(array('COMPANY' => $kirim['data']['poHeader']['CO_CODE']))->where('PERIODE_AWAL <=', $kirim['ambil_approval']['CREATED_AT'])->where('PERIODE_AKHIR >=', $kirim['ambil_approval']['CREATED_AT'])->get('EC_GR_JABATAN')->row_array();

//        $kirim['data']['detailRR']['GR_YEAR'];
//        var_dump($kirim['company_data']);die();
        // echo "<pre>";
        // print_r($kirim);
        // echo "</pre>";exit;

//        var_dump($kirim['data']);die(); 

      	$html = $this->load->view('EC_Invoice_Management/' . $viewDoc, $kirim, TRUE);

      	$mpdf->pdf->writeHTML($html);
      	$footer_rr = $this->load->view('EC_Invoice_Management/cetakRRFooter', $kirim, TRUE);

      	if ($tipe == 'RR') {
      		$mpdf->pdf->SetHTMLFooter($footer_rr);
      	} 
      	$mpdf->pdf->output('Receiving Report No. ' . $id . '.pdf', 'I');
      }

      private function getDataDocument($id, $nopo, $tipe, $print_type = null) {
      	$this->load->model('invoice/ec_gr_status', 'egs');
      	$this->load->model('invoice/ec_landed_cost', 'elc');
      	$this->load->library('sap_invoice');

      	$detailRR = array();
      	$landed_cost = array();

      	$this->load->model('invoice/ec_gr_status', 'egs');
        // $po_rr = $this->egs->as_array()->order_by('GR_NO,GR_ITEM_NO')->get_all(array('LOT_NUMBER' => $id));
      	$po_rr = $this->egs->getGRbyLot($id);

      	foreach ($po_rr as $val) {
      		switch ($val['JENISPO']) {
      			case 'BAHAN':
      			$barang = $this->egs->detailGrBahan($val['GR_NO'], $val['PO_NO'], $val['PO_ITEM_NO']);
      			foreach ($barang as $value) {
      				$detailRR[] = $value;
      			}
      			break;
      			default:
      			$no = $this->db->where(array('LFBNR' => $val['GR_NO'], 'BWART' => '105', 'LFGJA' => $val['GR_YEAR']))->order_by('BUDAT','DESC')->get('EC_GR_SAP')->row_array();
      			$sparepart = $this->egs->detailGrSparepart($no['BELNR'], $val['PO_NO'], $val['PO_ITEM_NO']);

      			foreach ($sparepart as $value) {
      				$detailRR[] = $value;
      			}
      			break;
      		}
      	}
//        var_dump($detailRR);die();
      	foreach ($detailRR as $val) {
      		$temp = $this->elc->getDataLanded($val['GR_NO'], $val['PO_ITEM_NO'], $val['GR_YEAR']);
      		foreach ($temp as $value) {
      			$landed_cost[$value['BELNR']][$value['EBELP']][] = $value;
      		}
      	}

      	/* ambil data di RFC */
      	$poDetail = $this->getPODetail($nopo);
      	$poHeader = array();
      	$poAddress = array();
      	$poSchedules = array();
      	if (!empty($poDetail['EXPORT_PARAM_ARRAY'])) {
      		if (!empty($poDetail['EXPORT_PARAM_ARRAY']['PO_HEADER'])) {
      			$poHeader = $poDetail['EXPORT_PARAM_ARRAY']['PO_HEADER'];
      		}
      		if (!empty($poDetail['EXPORT_PARAM_ARRAY']['PO_ADDRESS'])) {
      			$poAddress = $poDetail['EXPORT_PARAM_ARRAY']['PO_ADDRESS'];
      		}
      	}

      	if (!empty($poDetail['EXPORT_PARAM_TABLE'])) {
      		foreach ($poDetail['EXPORT_PARAM_TABLE'] as $value) {
      			$poSchedules = $value;
      		}
      	}

      	for ($i=0; $i < count($detailRR); $i++) { 
      		$array = array(
      			'TGL_GR' => $detailRR[$i]['GR_DATE'],
      			'TOTAL_GR' => $detailRR[$i]['GR_AMOUNT_IN_DOC']
      		);

      		$po_item = $detailRR[$i]['PO_ITEM_NO'];

      		$po_date = '';

      		foreach ($poSchedules as $value) {
      			if($value['PO_ITEM'] == $po_item){ 
      				$array['TGL_BATAS_PO'] = $value['DELIV_DATE'];
      				break;
      			}
      		}
      		$detailRR[$i]['KETERLAMBATAN'] = $this->denda($array);

            // tambah long text
      		$ambil_long_text = $this->sap_invoice->getLongText($detailRR[$i]['MATERIAL_NO']);
      		$gabung_long_text = "";
      		foreach ($ambil_long_text as $alt) {
      			$gabung_long_text .= $alt['TDLINE']."<br>";
      		}
      		$detailRR[$i]['LONG_TEXT_MAT'] = $gabung_long_text;
            // tambah long text
      	}

      	$lot = $this->db->where(array('LOT_NUMBER' => $id))->get('EC_GR_LOT')->row_array();

      	$barcode = array(
      		'kasi' => 'Approve by ' . $lot['APPROVED1_BY'] . ' at ' . $lot['APPROVED1_AT'],
      		'kabiro' => 'Approve by ' . $lot['APPROVED2_BY'] . ' at ' . $lot['APPROVED2_AT']
      	);
      	return array('poHeader' => $poHeader, 'poSchedules' => $poSchedules, 'poAddress' => $poAddress, 'detailRR' => $detailRR, 'barcode' => $barcode, 'landed_cost' => $landed_cost);
      }

      private function getPODetail($nopo) {
      	/* dapatkan no_po dan tahun gr sebagai parameter untuk RFC ZCFI_PO_HISTORY */
      	$this->load->library('sap_invoice');
      	$input = array(
      		'EXPORT_PARAM_SINGLE' => array(
      			'PURCHASEORDER' => $nopo,
      			'ITEMS' => 'X',
      			'SCHEDULES' => 'X',
      			'HISTORY' => ''
      		)
      	);

      	$output = array(
      		'EXPORT_PARAM_ARRAY' => array('PO_HEADER', 'PO_ADDRESS'),
      		'EXPORT_PARAM_TABLE' => array('PO_ITEM_SCHEDULES')
      	);

      	$t = $this->sap_invoice->callFunction('BAPI_PO_GETDETAIL', $input, $output);
      	return $t;
      }

      /* key untuk */

      private function getKeyGRInvoice($arr) {
      	$_nopo = array();
      	$_gjahr = array();

      	foreach ($arr as $r) {
      		array_push($_nopo, $r['PO_NO']);
      		array_push($_gjahr, $r['GR_YEAR']);
      	}

      	return array('R_EBELN' => array_unique($_nopo), 'R_GJAHR' => array_unique($_gjahr));
      }

      private function getGRInvoice($keyInvoice) {
      	/* dapatkan no_po dan tahun gr sebagai parameter untuk RFC ZCFI_PO_HISTORY */
      	$this->load->library('sap_invoice');
      	$_vgabe = array(
      		array(
      			'SIGN' => 'I',
      			'OPTION' => 'EQ',
      			'LOW' => '2'
      		), array(
      			'SIGN' => 'I',
      			'OPTION' => 'EQ',
      			'LOW' => 'P'
      		)
      	);
      	$input = array(
      		'EXPORT_PARAM_TABLE' => array(
      			'R_VGABE' => $_vgabe
      		)
      	);
      	foreach ($keyInvoice as $k => $val) {
      		if (!isset($input['EXPORT_PARAM_TABLE'][$k])) {
      			$input['EXPORT_PARAM_TABLE'][$k] = array();
      		}
      		foreach ($val as $_v) {
      			$_tmp = array(
      				'SIGN' => 'I',
      				'OPTION' => 'EQ',
      				'LOW' => $_v
      			);
      		}

      		array_push($input['EXPORT_PARAM_TABLE'][$k], $_tmp);
      	}
      	$output = array(
      		'EXPORT_PARAM_TABLE' => array('T_DATA')
      	);

      	$t = $this->sap_invoice->callFunction('ZCFI_PO_HISTORY', $input, $output);
      	return $t;
      }

      private function filterGRUnbilled($arr) {
      	$keyInvoice = $this->getKeyGRInvoice($arr);
      	$invoice = $this->getGRInvoice($keyInvoice);
      	$this->load->model('invoice/ec_gr_sap', 'gr_sap');
      	$hasilRFC = $invoice['EXPORT_PARAM_TABLE']['T_DATA'];
      	$result = array();
      	$_tmpArrKey = array();
      	if (!empty($hasilRFC)) {
      		foreach ($hasilRFC as $i) {
      			$_key = $this->createUniqueKeyGR($i, array('LFBNR', 'LFGJA', 'LFPOS'));
      			$_tmpArrKey[$_key] = 1;
      		}
      	}
      	/* filter gr yang unbilled, jika ditemukan di $_tmpArrKey maka abaikan saja */
      	foreach ($arr as $r) {
      		$_key = $this->createUniqueKeyGR($r, array('GR_NO', 'GR_YEAR', 'GR_ITEM_NO'));
      		if (!isset($_tmpArrKey[$_key])) {
      			array_push($result, $r);
      		} else {
      			$itemCat = $r['TYPE_TRANSAKSI'];

      			if ($r['STATUS_SEBAGIAN'] == 'COMPLETE') {
      				if ($itemCat != '9') {
      					$this->db->where('INV_NO is NULL');
      					$this->gr_sap->update(array('STATUS' => 1), array('BELNR' => $r['GR_NO'], 'BUZEI' => $r['GR_ITEM_NO'], 'GJAHR' => $r['GR_YEAR'], 'STATUS' => 0));
      				} else {
      					$this->db->where('INV_NO is NULL');
      					$this->gr_sap->update(array('STATUS' => 1), array('LFBNR' => $r['GR_NO'], 'LFPOS' => $r['GR_ITEM_NO'], 'LFGJA' => $r['GR_YEAR'], 'STATUS' => 0));
      				}
      			} else {
      				array_push($result, $r);
      			}
      		}
      	}
      	return $result;
      }

      private function createUniqueKeyGR($row, $key = array()) {
      	$result = array();
      	foreach ($key as $r) {
      		array_push($result, $row[$r]);
      	}
      	return implode('', $result);
      }

      public function cariBapp() {
      	$listgr = $this->input->post('listgr');
      	$this->load->model('invoice/ec_bast', 'ebs');
      	$this->load->model('invoice/ec_bapp', 'ebp');
      	$bast = $this->ebs->getBast($listgr);
      	$bapp = $this->ebp->getBapp($listgr);
      	echo json_encode(array('bapp' => $bapp, 'bast' => $bast));
      }

      public function vendorNonWapu($venno) {
      	$this->load->model('invoice/ec_vendor_non_wapu', 'ewapu');
      	$_tmp = $this->ewapu->fields('VENDOR_NO')->as_array()->get(array('VENDOR_NO' => $venno));
      	$result = empty($_tmp) ? 0 : 1;
      	return $result;
      }

      public function getRefFP() {
      	$gr = $this->input->post('datagr');
      	$ar_gr = explode(',', $gr);
      	$data = $this->db->select('EIH.FAKTUR_PJK,EIH.FAKPJK_PIC')
      	->from('EC_GR EG', false)
      	->join('EC_INVOICE_HEADER EIH', 'EG.INV_NO = EIH.ID_INVOICE', false)
      	->where_in('EG.GR_NO', $ar_gr)
      	->order_by('EIH.INVOICE_DATE')
      	->get()
      	->row_array();
      	$ret = array();
      	if ($data) {
      		$ret['status'] = 1;
      		$ret['ref_fp'] = $data['FAKTUR_PJK'];
      		$url = base_url() . 'upload/EC_invoice/' . $data['FAKPJK_PIC'];
      		$ret['url_fp'] = "<a href='$url'>ATTACHMENT FILE</a>";
      	} else {
      		$ret['status'] = 0;
      	}
      	echo json_encode($ret);
      }

      public function checkParcial($idinvoice) {
      	$sql = '
      	SELECT A.INV_NO FROM (
      	SELECT ROWNUM NOMER ,D.* FROM (
      	SELECT * FROM EC_GR GR WHERE GR_NO IN (
      	SELECT GR_NO FROM EC_INVOICE_HEADER EIH
      	JOIN EC_GR EG
      	ON EG.INV_NO = EIH.id_invoice
      	WHERE ID_INVOICE = ' . $idinvoice . '
      	) ORDER BY INV_NO
      	)D
      )A WHERE NOMER = 1';
      $res = $this->db->query($sql, false)->row_array();

      if ($res['INV_NO'] == $idinvoice) {
      	return false;
      } else {
      	$ref_fp = $this->db->select('FAKTUR_PJK,FAKPJK_PIC')->where('ID_INVOICE', $res['INV_NO'])->get('EC_INVOICE_HEADER')->row_array();
      	return $ref_fp;
      }
  }

  public function checkParcial2($idinvoice) {
  	$sql = '
  	SELECT A.INV_NO FROM (
  	SELECT ROWNUM NOMER ,D.* FROM (
  	SELECT * FROM EC_GR GR WHERE GR_NO IN (
  	SELECT GR_NO FROM EC_INVOICE_HEADER EIH
  	JOIN EC_GR EG
  	ON EG.INV_NO = EIH.id_invoice
  	WHERE ID_INVOICE = ' . $idinvoice . '
  	) ORDER BY INV_NO
  	)D
  )A WHERE NOMER = 1';
  $res = $this->db->query($sql, false)->row_array();

  $ref_fp = $this->db->select('ID_INVOICE,FAKTUR_PJK,FAKPJK_PIC')->where('ID_INVOICE', $res['INV_NO'])->get('EC_INVOICE_HEADER')->row_array();

  $data['status'] = $idinvoice == $res['INV_NO'] ? 0 : 1;
  $data['ref_fp'] = $ref_fp['FAKTUR_PJK'];
  $data['ref_fp_pic'] = $ref_fp['FAKPJK_PIC'];
  return $data;
}

private function checkPomut($no_ba) {
	$arr_ba = explode(',', $no_ba);
	$arr_ba = array_unique($arr_ba);
	return $this->db->where_in('NO_BA', $arr_ba)->get('EC_POMUT_HEADER_SAP')->result_array();
}

private function checkLot($idinvoice) {
	$sql = "
	SELECT DISTINCT * FROM ( 
	SELECT EGL.LOT_NUMBER,PRINT_TYPE FROM EC_GR EG
	JOIN EC_GR_STATUS EGS 
	ON EG.GR_NO = EGS.GR_NO
	JOIN EC_GR_LOT EGL 
	ON EGS.LOT_NUMBER = EGL.LOT_NUMBER
	WHERE INV_NO = $idinvoice
)";
return $this->db->query($sql, false)->result_array();
}


function refreshPO() {
	error_reporting(E_ALL);
		// print_r($this->session->userdata);die;
	$no_po = $this->input->post('no_po');
	$this->load->library('sap_invoice');
	$this->load->model('um_sap_header');

	$check_po_db = $this->um_sap_header->get(array('EBELN'=>$no_po));
	if(count($check_po_db)>0){
		$aksi = 'update';
	} else {
		$aksi = 'insert';
	}
	$ambil_data = $this->sap_invoice->getPOUm($this->session->userdata('COMPANYID'), $this->session->userdata('VENDOR_NO'), $no_po);
	// echo "<pre>";
	// echo $aksi;
	// print_r($ambil_data);die;
	$count = 0;
	$data = array();
	foreach ($ambil_data as $ad) {
		if($aksi == 'update'){
			$where1['EBELN'] = $ad['EBELN'];
			$set1 = $ad;
			$this->um_sap_header->update($set1, $where1);
		} else if($aksi == 'insert'){
			$ID = $this->um_sap_header->get_id();
			$data = $ad;
			$data['ID'] = $ID;
			$this->um_sap_header->insert($data);
		}

	}

		// echo "<pre>";
		// print_r($data);die;
	redirect('EC_Invoice_um');

}

}
