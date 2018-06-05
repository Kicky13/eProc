<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bast extends MX_Controller {
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
    $data['title'] = "Approval BAST";
    $this->layout->set_table_js();
    $this->layout->set_table_cs();
    $this->layout->set_validate_css();
    $this->layout->set_validate_js();

    $this->layout->add_css('pages/EC_miniTable.css');
    $this->layout->add_css('pages/invoice/common.css');

    $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
		$this->layout->add_js('bootbox.js');
		$this->layout->add_js('pages/invoice/EC_common.js');
    $this->layout->add_js('pages/invoice/Approval_bast.js');
    $this->layout->render('EC_Approval/bast/list',$data);
  }

	public function detail(){
		$data['title'] = "Detail BAST";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('plugins/trumbowyg/trumbowyg.js');
		$this->layout->add_js('bootbox.js');
		$this->layout->add_js('pages/invoice/EC_common.js');
		$this->layout->add_js('jquery.priceFormat.min.js');
		$this->layout->add_js('pages/invoice/EC_bast_form.js');
		$this->layout->add_css('plugins/trumbowyg/trumbowyg.css');
		$this->layout->add_css('pages/invoice/common.css');
		$id = $this->input->post('id');
			$bisaEdit = 1;
			$data = array();
			$data['bastDoc'] = array();
			$data['id'] = $id;
			$this->load->model('invoice/ec_bast','bast');
			$this->load->model('invoice/ec_bast_doc','bastDoc');
			$data['bastDoc'] = $this->bastDoc->as_array()->get_all(array('ID_BAST' => $id));
			$data['title'] = "Approval BAST";
			$data['dataBast'] = $this->bast->as_array()->get(array('ID' => $id));
			$data['bisaEdit'] = $bisaEdit;


		$data['approve_reject'] = 1;
		$data['urlAction'] = site_url('EC_Approval/Bast/approveReject/'.$id);
	//	$data['detail'] = $this->egs->detailGrNotApprove($item);
		$this->layout->render('EC_Approval/bast/form',$data);
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
		$this->load->model('invoice/ec_bast','bast');
		$this->load->model('invoice/ec_bast_tracking','bastTracking');
		$this->db->trans_begin();
		$dataTracking = array(
			'ID_BAST' => $id,
			'STATUS' => 4,
			'UPDATE_BY' => $this->user
		);
		$alasan_reject = $this->input->post('ALASAN_REJECT');
		$this->bastTracking->insert($dataTracking);
		$this->bast->update(array('STATUS' => 4, 'ALASAN_REJECT' => $alasan_reject),array('ID' => $id, 'STATUS' => 2));

		$dataBast = $this->bast->as_array()->get($id);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$pesan = 'Reject BAST gagal dilakukan';
				$this->session->set_flashdata('message', $pesan);
		} else {
				$this->db->trans_commit();
				/* Kirim notifikasi sudah diapprove */
				$this->notifikasiBAST($dataBast,'reject');
				$pesan = 'Reject BAST PO '.$dataBast['NO_PO'].' berhasil dilakukan';
				$this->session->set_flashdata('message', $pesan);
		}
		redirect('EC_Approval/Bast');
	}

	public function approve($id){
		$this->load->model('invoice/ec_bast','bast');
		$this->load->model('invoice/ec_bast_tracking','bastTracking');
		$this->db->trans_begin();
		$dataTracking = array(
			'ID_BAST' => $id,
			'STATUS' => 3,
			'UPDATE_BY' => $this->user
		);

			$this->bastTracking->insert($dataTracking);
			// dapatkan nomer bast
			$nomerBast = $this->generateNumber();
			$this->bast->update(array('STATUS' => 3,'NO_BAST' => $nomerBast),array('ID' => $id, 'STATUS' => 2));

		$dataBast = $this->bast->as_array()->get($id);

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$pesan = 'Approval BAST gagal dilakukan';
				$this->session->set_flashdata('message', $pesan);
		} else {
				$this->db->trans_commit();
				/* Kirim notifikasi sudah diapprove */
				$this->notifikasiBAST($dataBast,'approve');
				$pesan = 'Approval BAST dengan nomer '.$dataBast['NO_BAST'].' berhasil dilakukan';
				$this->session->set_flashdata('message', $pesan);
		}
		redirect('EC_Approval/Bast');
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
		$this->load->model('invoice/ec_bast','bast');
		return $this->bast->fields('EC_BAST.ID,NO_PO,PO_ITEM,SHORT_TEXT,CREATE_AT,VND_HEADER.VENDOR_NAME')->as_array()->get_all_with_vendor(array('EC_BAST.EMAIL' => $email , 'EC_BAST.STATUS' => '2'));
	}

	public function preview(){

		$this->load->model('invoice/ec_bast','eb');
		$this->load->model('invoice/ec_bast_tracking','ebt');
		$kirim = array();
		$kirim['data'] = $this->input->post('data');
		$kirim['NO_VENDOR'] = $kirim['data']['NO_VENDOR'];
    $kirim['approve'] = array('UPDATE_AT' => date('d-M-y'));
		$this->cetakBast($kirim);
	}

	public function cetakBast($kirim = array()){
		$this->load->library('M_pdf');
		$mpdf = new M_pdf();
		$this->load->model(array('vnd_header'));
		$vendor_no =  $kirim['NO_VENDOR'] ;
		$data_vendor = $this->vnd_header->get(array('VENDOR_NO'=> $vendor_no));
		$this->load->config('ec');
    $company_data = $this->config->item('company_data');

    $kirim['company_data'] = $company_data[$kirim['data']['COMPANY']];
		$kirim['vendor'] = $data_vendor;
		$html = $this->load->view('EC_Vendor/bast/cetakBast',$kirim,TRUE);
		$mpdf->pdf->writeHTML($html);
		//echo $html;
		$mpdf->pdf->output();
	}

	public function notifikasiBAST($dataBast = NULL, $action = NULL){
		/*$dataBast = array(
			'NO_PO' => 'rerwrwerwer234',
			'PO_ITEM' => '10',
			'GR_NO' => '234324324324',
			'SHORT_TEXT' => 'PERcobaan',
			'NO_BAST' => '1222332/43242342/'
		);*/
		$action = 'approve';
		$this->load->model(array('vnd_header'));
		$data_vendor = $this->vnd_header->get(array('VENDOR_NO'=>$dataBast['NO_VENDOR']));
		$note = 'Note : <div>Faktur pajak dengan kode 030 agar diproses ke dalam E-Invoice paling lambat tanggal 5 bulan berikutnya setelah masa <br>
						Kode Faktur Pajak selain 030 agar diproses kedalam E-Invoice paling lambat 3 bulan setelah masa Faktur Pajak dibuat<br>
						Apabila terlambat potensi denda ditanggung rekanan</div>';
		if($action == 'approve'){
			$data = array(
				'content' => '
						Dokumen BAST Approved on '.date('d M Y H:i:s').'<br>
						Nomor PO        : '.$dataBast['NO_PO'].'<br>
						PO Item         : '.$dataBast['PO_ITEM'].'<br>
						Deskripsi       : '.$dataBast['SHORT_TEXT'].'<br><br><hr><br>'.$note,
				'title' => 'Dokumen BAST '.$dataBast['NO_BAST'].' Approved',
				'title_header' => 'Dokumen BAST '.$dataBast['NO_BAST'].' Approved',
			);
			$message = $this->load->view('EC_Notifikasi/approveInvoice',$data,TRUE);
			$subject = 'Dokumen PO '.$dataBast['NO_PO'].' BAST '.$dataBast['NO_BAST'].' Approved [E-Invoice Semen Indonesia]';
		}else{
			$data = array(
				'content' => '
						Dokumen BAST Rejected on '.date('d M Y H:i:s').'<br>
						Nomor PO        : '.$dataBast['NO_PO'].'<br>
						PO Item         : '.$dataBast['PO_ITEM'].'<br>
						Deskripsi       : '.$dataBast['SHORT_TEXT'].'<br><br><hr><br>'.$note,
				'title' => 'Dokumen BAST  PO '.$dataBast['NO_PO'].' Rejected',
				'title_header' => 'Dokumen PO '.$dataBast['NO_PO'].' Rejected',
			);
			$message = $this->load->view('EC_Notifikasi/rejectInvoice',$data,TRUE);
			$subject = 'Dokumen PO '.$dataBast['NO_PO'].' Rejected [E-Invoice Semen Indonesia]';
		}

		$_to = $data_vendor['EMAIL_ADDRESS'];
		Modules::run('EC_Notifikasi/Email/invoiceNotifikasi',$_to,$message,$subject);
	}

	public function cetak($id){
		$this->load->library('M_pdf');
		$mpdf = new M_pdf();
		$this->load->model('invoice/ec_bast','eb');
		$this->load->model('invoice/ec_bast_tracking','ebt');
		$kirim = array();
		$data = $this->eb->as_array()->get($id);
		$approve = $this->ebt->as_array()->get(array('ID_BAST' => $id,'STATUS' => 2));
		$this->load->config('ec');
    $company_data = $this->config->item('company_data');

    $kirim['company_data'] = $company_data[$data['COMPANY']];
		$kirim['data'] = $data;
		$kirim['approve'] = $approve;
		$html = $this->load->view('EC_Approval/bast/cetakBast',$kirim,TRUE);
		$mpdf->pdf->writeHTML($html);
		//echo $html;
		$mpdf->pdf->output();
	}

	public function generateNumber(){
		$this->load->model('invoice/ec_bast','eb');
		$unitKerja = '00000000';
		$email = $this->user_email;
		$tmp = $this->db->select('DEPT_KODE')->where(array('EMAIL' => $email ))->get('ADM_EMPLOYEE')->row_array();
		if(!empty($tmp)){
			$unitKerja = $tmp['DEPT_KODE'];
		}
		$jenis = 'BAST';
		return $this->eb->generateNumber($unitKerja,$jenis);
	}

	private function getNumeric($strNominee){
	  return floatval(str_replace(',', '.', str_replace('.', '', $strNominee)));
	}
}
