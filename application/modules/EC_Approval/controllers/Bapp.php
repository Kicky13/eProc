<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bapp extends MX_Controller {
	private $user;
	private $user_email;
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('url');
		$this -> load -> library('Layout');
		$this -> load -> helper("security");
		$this->user = $this->session->userdata('FULLNAME');
		$this->user_email = $this->session->userdata('EMAIL'); // login pakai email tanpa semen indonesia.com
	}

	public function index(){
    $this -> load -> library('Authorization');
    $data['title'] = "Approval BAPP";
    $this->layout->set_table_js();
    $this->layout->set_table_cs();
    $this->layout->set_validate_css();
    $this->layout->set_validate_js();

    $this->layout->add_css('pages/EC_miniTable.css');
    $this->layout->add_css('pages/invoice/common.css');

    $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('bootbox.js');
		$this->layout->add_js('pages/invoice/EC_common.js');
    $this->layout->add_js('pages/invoice/Approval_bapp.js');
    $this->layout->render('EC_Approval/bapp/list',$data);
  }

	public function detail(){
		$data['title'] = "Detail BAPP";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_css('plugins/trumbowyg/trumbowyg.css');
		$this->layout->add_css('pages/invoice/common.css');
		$this->layout->add_css('plugins/select2/select2.min.css');
		$this->layout->add_js('plugins/trumbowyg/trumbowyg.js');
		$this->layout->add_js('bootbox.js');
		$this->layout->add_js('pages/invoice/EC_common.js');
		$this->layout->add_js('jquery.priceFormat.min.js');
		$this->layout->add_js('select2.min.js');
		$this->layout->add_js('pages/invoice/EC_bapp_form.js');

		$id = $this->input->post('id');
			$bisaEdit = 1;
			$data = array();
			$data['bappDoc'] = array();
			$data['id'] = $id;
			$this->load->model('invoice/ec_bapp','bapp');
			$this->load->model('invoice/ec_bapp_doc','bappDoc');
			$this->load->model('invoice/ec_bapp_item','bappItem');
			$data['bappDoc'] = $this->bappDoc->as_array()->get_all(array('ID_BAPP' => $id));
			$data['title'] = "Approval BAPP";
			$data['dataBapp'] = $this->bapp->as_array()->get(array('ID' => $id));
			$data['bappItem'] = $this->bappItem->as_array()->get_all(array('EC_BAPP' => $id));
			$data['bisaEdit'] = $bisaEdit;
			$mtrl_group = $data['dataBapp']['MTRL_GROUP'];
			/* dapatkan daftar service dari sap */
			$data['listService'] = $this->_getService($mtrl_group);

		$data['approve_reject'] = 1;
		$data['urlAction'] = site_url('EC_Approval/Bapp/approveReject/'.$id);
	//	$data['detail'] = $this->egs->detailGrNotApprove($item);
		$this->layout->render('EC_Approval/bapp/form',$data);
	}

	public function approveReject($id){
		/* jika 1 approve dan 0 untuk reject */
		$nextAction = $this->input->post('next_action');
		if($nextAction){
			$this->approve($id);
		}else{
			$this->reject($id);
		}
	}

	public function reject($id){
		$this->load->model('invoice/ec_bapp','bapp');
		$this->load->model('invoice/ec_bapp_tracking','bappTracking');
		$this->db->trans_begin();
		$dataTracking = array(
			'ID_BAPP' => $id,
			'STATUS' => 4,
			'UPDATE_BY' => $this->user
		);
		$alasan_reject = $this->input->post('ALASAN_REJECT');
		$this->bappTracking->insert($dataTracking);
		$this->bapp->update(array('STATUS' => 4, 'ALASAN_REJECT' => $alasan_reject),array('ID' => $id, 'STATUS' => 2));

		$dataBapp = $this->bapp->as_array()->get($id);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$pesan = 'Reject BAPP gagal dilakukan';
				$this->session->set_flashdata('message', $pesan);
		} else {
				$this->db->trans_commit();
				/* Kirim notifikasi sudah diapprove */
				$this->notifikasiBAPP($dataBapp,'reject');
				$pesan = 'Reject BAPP PO '.$dataBapp['NO_PO'].' berhasil dilakukan';
				$this->session->set_flashdata('message', $pesan);
		}
		redirect('EC_Approval/Bapp');
	}

	public function approve($id){
		$this->load->model('invoice/ec_bapp','bapp');
		$this->load->model('invoice/ec_bapp_tracking','bappTracking');
		$this->load->model('invoice/ec_bapp_item','bappItem');
		$this->db->trans_begin();
		$dataTracking = array(
			'ID_BAPP' => $id,
			'STATUS' => 3,
			'UPDATE_BY' => $this->user
		);
		/* create entrysheet di SAP terlebih dahulu */
		if($this->entrySheet()){
			/* hapus dulu itemnya lalu isi lagi */
			$this->bappItem->delete(array('EC_BAPP' => $id));
			$this->bappTracking->insert($dataTracking);
			// dapatkan nomer bapp
			$nomerBapp = $this->generateNumber();
			$this->bapp->update(array('STATUS' => 3,'NO_BAPP' => $nomerBapp),array('ID' => $id, 'STATUS' => 2));
			$qtys = $this->input->post('QTY');
			/* seharusnya nanti GR_NO, FR_YEAR dan GR_ITEM_NO didapatkan dari SAP */
			foreach($qtys as $q){
				$this->bappItem->insert(array('EC_BAPP' => $id, 'QTY' => $this->getNumeric($q)));
			}
		}
		$dataBapp = $this->bapp->as_array()->get($id);
		$dataBapp['GR_NO'] = ''; /* sementara diset kosong dulu */
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$pesan = 'Approval BAPP gagal dilakukan';
				$this->session->set_flashdata('message', $pesan);
		} else {
				$this->db->trans_commit();
				/* Kirim notifikasi sudah diapprove */
				$this->notifikasiBAPP($dataBapp,'approve');
				$pesan = 'Approval BAPP dengan nomer '.$dataBapp['NO_BAPP'].' berhasil dilakukan';
				$this->session->set_flashdata('message', $pesan);
		}
		redirect('EC_Approval/Bapp');
	}
	/* create entrysheet di SAP */
	private function entrySheet(){
		return 1;
	}

	public function data(){
		$_result = $this->_data();
		$this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(array('data' => $_result)));
	}
	/* ambil semua gr bahan / spare part yang belum diapprove */
	private function _data(){
		$email = $this->user_email = $this->session->userdata('EMAIL');
		$email = 'LAKSMINDRA.SATYAWATI@SEMENINDONESIA.COM';
		$this->load->model('invoice/ec_bapp','bapp');
		return $this->bapp->fields('EC_BAPP.ID,NO_PO,PO_ITEM,SHORT_TEXT,CREATE_AT,VND_HEADER.VENDOR_NAME')->as_array()->get_all_with_vendor(array('EC_BAPP.EMAIL' => $email , 'EC_BAPP.STATUS' => '2'));
	}

	public function preview(){

		$this->load->model('invoice/ec_bapp','eb');
		$this->load->model('invoice/ec_bapp_tracking','ebt');
		$kirim = array();
		$kirim['data'] = $this->input->post('data');
		$kirim['NO_VENDOR'] = $kirim['data']['NO_VENDOR'];
    $kirim['approve'] = array('UPDATE_AT' => date('d-M-y'));
		$this->cetakBapp($kirim);
	}

	public function cetakBapp($kirim = array()){
		$this->load->library('M_pdf');
		$mpdf = new M_pdf();
		$this->load->model(array('vnd_header'));
		$vendor_no =  $kirim['NO_VENDOR'] ;
		$data_vendor = $this->vnd_header->get(array('VENDOR_NO'=> $vendor_no));
		$this->load->config('ec');
    $company_data = $this->config->item('company_data');

    $kirim['company_data'] = $company_data[$kirim['data']['COMPANY']];
		$kirim['vendor'] = $data_vendor;
		$html = $this->load->view('EC_Vendor/bapp/cetakBapp',$kirim,TRUE);
		$mpdf->pdf->writeHTML($html);
		//echo $html;
		$mpdf->pdf->output();
	}

	public function notifikasiBAPP($dataBapp = NULL, $action = NULL){
		/*$dataBapp = array(
			'NO_PO' => 'rerwrwerwer234',
			'PO_ITEM' => '10',
			'GR_NO' => '234324324324',
			'SHORT_TEXT' => 'PERcobaan',
			'NO_BAPP' => '1222332/43242342/'
		);*/
		$action = 'approve';
		$this->load->model(array('vnd_header'));
		$data_vendor = $this->vnd_header->get(array('VENDOR_NO'=>$dataBapp['NO_VENDOR']));
		$note = 'Note : <div>Faktur pajak dengan kode 030 agar diproses ke dalam E-Invoice paling lambat tanggal 5 bulan berikutnya setelah masa <br>
						Kode Faktur Pajak selain 030 agar diproses kedalam E-Invoice paling lambat 3 bulan setelah masa Faktur Pajak dibuat<br>
						Apabila terlambat potensi denda ditanggung rekanan</div>';
		if($action == 'approve'){
			$data = array(
				'content' => '
						Dokumen BAPP Approved on '.date('d M Y H:i:s').'<br>
						Nomor PO        : '.$dataBapp['NO_PO'].'<br>
						PO Item         : '.$dataBapp['PO_ITEM'].'<br>
						Nomor GR        : '.$dataBapp['GR_NO'].'<br>
						Deskripsi       : '.$dataBapp['SHORT_TEXT'].'<br><br><hr><br>'.$note,
				'title' => 'Dokumen BAPP '.$dataBapp['NO_BAPP'].' Approved',
				'title_header' => 'Dokumen BAPP '.$dataBapp['NO_BAPP'].' Approved',
			);
			$message = $this->load->view('EC_Notifikasi/approveInvoice',$data,TRUE);
			$subject = 'Dokumen PO '.$dataBapp['NO_PO'].' BAPP '.$dataBapp['NO_BAPP'].' Approved [E-Invoice Semen Indonesia]';
		}else{
			$data = array(
				'content' => '
						Dokumen BAPP Rejected on '.date('d M Y H:i:s').'<br>
						Nomor PO        : '.$dataBapp['NO_PO'].'<br>
						PO Item         : '.$dataBapp['PO_ITEM'].'<br>
						Deskripsi       : '.$dataBapp['SHORT_TEXT'].'<br><br><hr><br>'.$note,
				'title' => 'Dokumen BAPP  PO '.$dataBapp['NO_PO'].' Rejected',
				'title_header' => 'Dokumen PO '.$dataBapp['NO_PO'].' Rejected',
			);
			$message = $this->load->view('EC_Notifikasi/rejectInvoice',$data,TRUE);
			$subject = 'Dokumen PO '.$dataBapp['NO_PO'].' Rejected [E-Invoice Semen Indonesia]';
		}

		$_to = $data_vendor['EMAIL_ADDRESS'];
		Modules::run('EC_Notifikasi/Email/invoiceNotifikasi',$_to,$message,$subject);
	}

	public function cetak($id){
		$this->load->library('M_pdf');
		$mpdf = new M_pdf();
		$this->load->model('invoice/ec_bapp','eb');
		$this->load->model('invoice/ec_bapp_tracking','ebt');
		$kirim = array();
		$data = $this->eb->as_array()->get($id);
		$approve = $this->ebt->as_array()->get(array('ID_BAPP' => $id,'STATUS' => 2));
		$this->load->config('ec');
    $company_data = $this->config->item('company_data');

    $kirim['company_data'] = $company_data[$data['COMPANY']];
		$kirim['data'] = $data;
		$kirim['approve'] = $approve;
		$html = $this->load->view('EC_Approval/bapp/cetakBapp',$kirim,TRUE);
		$mpdf->pdf->writeHTML($html);
		//echo $html;
		$mpdf->pdf->output();
	}

	private function _getService($mtrl_group){
		$this->load->library('sap_invoice');
		$input = array(
			'EXPORT_PARAM_TABLE' => array(
				'SRVGROUPSELECTION' => array(
					array('SIGN' => 'I', 'OPTION' => 'EQ','MATL_GROUP_LOW' => $mtrl_group)
				)
			)
		);

		$output = array(
			'EXPORT_PARAM_TABLE' => array('SERVICELIST')
	//    'EXPORT_PARAM_TABLE' => array('PO_ITEMS','PO_ITEM_HISTORY')
		);

		$t = $this->sap_invoice->callFunction('BAPI_SERVICE_GET_LIST',$input,$output);

		return $t['EXPORT_PARAM_TABLE']['SERVICELIST'];
	}

	public function generateNumber(){
		$this->load->model('invoice/ec_bapp','eb');
		$unitKerja = '00000000';
		$email = $this->user_email;
		$tmp = $this->db->select('DEPT_KODE')->where(array('EMAIL' => $email ))->get('ADM_EMPLOYEE')->row_array();
		if(!empty($tmp)){
			$unitKerja = $tmp['DEPT_KODE'];
		}
		$jenis = 'BAPP';
		return $this->eb->generateNumber($unitKerja,$jenis);
	}

	private function getNumeric($strNominee){
	  return floatval(str_replace(',', '.', str_replace('.', '', $strNominee)));
	}
}
