<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bast extends MX_Controller {

    private $user;
    private $user_email;
    private $vendor_no;
    public function __construct() {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->load->model("invoice/ec_bast",'bast');
        $this->user = $this->session->userdata('FULLNAME');
        $this->vendor_no = $this->session->userdata('VENDOR_NO');
        $this->user_email = $this->session->userdata('EMAIL');
    }

    public function index() {
        $data['title'] = "Management Bast";
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();

        $this->layout->add_js('bootbox.js');
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('pages/invoice/EC_Bast.js');

        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/invoice/common.css');

        $this->layout->render('bast/bast', $data);
    }
    /* cari yang belum di approve saja */
    public function getAllBast($status){
        if($status == 'approved'){
            $res = $this->bast->order_by('CREATE_AT')->get_all_by('NO_VENDOR = '.$this->vendor_no.' and STATUS = 3');
        }else{
          $res = $this->bast->order_by('CREATE_AT')->get_all_by('NO_VENDOR = '.$this->vendor_no.' and STATUS != 3');
        }

        $json_data = array('data' => $res);
        echo json_encode($json_data);
    }
    /* status bast
       1 untuk draft
       2 untuk submit
       3 untuk approve
       4 untuk reject
    */
    public function form($id = '') {
      $this->layout->set_table_js();
      $this->layout->set_table_cs();
      $this->layout->add_js('plugins/trumbowyg/trumbowyg.js');
      $this->layout->add_js('bootbox.js');
      $this->layout->add_js('pages/invoice/EC_common.js');
      $this->layout->add_js('jquery.priceFormat.min.js');
      $this->layout->add_js('pages/invoice/EC_bast_form.js');
      $this->layout->add_css('plugins/trumbowyg/trumbowyg.css');
      $this->layout->add_css('pages/invoice/common.css');

        $bisaEdit = 0;
        $data = array();
        $data['dataBast'] = array(
          'NO_PO' => '',
          'PO_ITEM' => '',
          'NO_BAST' => '',
          'DESCRIPTION' => '',
          'SHORT_TEXT' => '',
          'PENGAWAS' => '',
          'JABATAN' => '',
          'EMAIL' => '',
          'COMPANY' => '',
          'STATUS' => ''
        );
        $data['bastDoc'] = array();
        $data['id'] = $id;
        if (empty($id)) {
            $data['title'] = "Create BAST";
            $bisaEdit = 1;
        }else{
            $this->load->model('invoice/ec_bast_doc','bastDoc');
            $data['bastDoc'] = $this->bastDoc->as_array()->get_all(array('ID_BAST' => $id));
            $data['title'] = "Update BAST";
            $data['dataBast'] = $this->bast->as_array()->get(array('ID' => $id));
            $data['dataBast']['PEKERJAAN'] = '';
            if($data['dataBast']['STATUS'] != 3){
              /* periksa bisa edit atau gak */
              if(!empty($this->vendor_no)){
                  if($data['dataBast']['STATUS'] != 2){
                    $bisaEdit = 1;
                  }
              }else{
                if($data['dataBast']['STATUS'] == 2){
                  $bisaEdit = 1;
                }
              }
            }
        }
        $data['bisaEdit'] = $bisaEdit;
        $data['urlAction'] = site_url('EC_Vendor/Bast/simpan/'.$id);

        $this->layout->render('bast/form', $data);
    }

    public function submitBast($id){
      if($this->bast->update(array('STATUS' => 2),array('ID' => $id, 'STATUS' => 1))){
        $pesan = "BAST berhasil disubmit";
        $this->session->set_flashdata('message', $pesan);

        $this->load->model('invoice/ec_bast_tracking','bastTracking');
        $dataTracking = array(
          'ID_BAST' => $id,
          'STATUS' => 2,
          'UPDATE_BY' => $this->user
        );

        $this->bastTracking->insert($dataTracking);
        /* notifikasi email ke user SI */
        $dataBast = $this->bast->as_array()->get(array('ID' => $id));
        $this->notifikasiBAST($dataBast);

      }
      redirect('EC_Vendor/Bast');
    }

    public function simpan($id = ''){
      $this->load->library('file_operation');
      $this->load->helper('file');
      $this->load->helper(array('form', 'url'));
      $data_bast = array(
        'NO_VENDOR' => $this->vendor_no,
        'COMPANY' => $this->input->post('COMPANY'),
        'NO_PO' => $this->input->post('NO_PO'),
    //    'QTY' => $this->getNumeric($this->input->post('QTY')),
    //    'NO_BAST' => $this->input->post('NO_BAST'),
        'DESCRIPTION' => $this->input->post('DESCRIPTION'),
        'PO_ITEM' => $this->input->post('PO_ITEM'),
        'SHORT_TEXT' => $this->input->post('SHORT_TEXT'),
        'PENGAWAS' => $this->input->post('PENGAWAS'),
        'JABATAN' => $this->input->post('JABATAN'),
        'EMAIL' => $this->input->post('EMAIL'),
      );

      $pesan = "BAST untuk PO ".$data_bast['NO_PO']. " created";
      $uploaded = $this->file_operation->uploadL(UPLOAD_PATH . 'EC_invoice', $_FILES);
      // print_r($uploaded);die();
      /* simpan bast */
      $this->load->model('invoice/ec_bast_doc','bastDoc');
      $this->db->trans_begin();
      if(empty($id)){
        $idbast = $this->bast->insert($data_bast);
      }else{
        $data_bast['STATUS'] = 1;
        $this->bast->update($data_bast,array('ID' => $id));
        $this->bastDoc->delete(array('ID_BAST' => $id));
        $idbast = $id;
        $pesan = "BAST untuk PO ".$data_bast['NO_PO']. " updated";
      }

      /* insert ke lampiran bast */
      $lampiranBast = $this->input->post('lampiranBast');
      if(!empty($uploaded) or !empty($lampiranBast)){
        $_u = 0;
        $oldFileLampiranBast = $this->input->post('oldFileLampiranBast');

        foreach($lampiranBast as $i => $name){
          $idFile = 'fileLampiranBast_'.$i;

          $bastDoc = array(
            'ID_BAST' => $idbast,
            'PIC' => isset($uploaded[$idFile]) ? $uploaded[$idFile]['file_name'] : $oldFileLampiranBast[$i],
            'DESCRIPTION' => $name,
          );
          $this->bastDoc->insert($bastDoc);
        }
      }
      $this->load->model('invoice/ec_bast_tracking','bastTracking');
      $dataTracking = array(
        'ID_BAST' => $idbast,
        'STATUS' => 1,
        'UPDATE_BY' => $this->user
      );
      $this->bastTracking->insert($dataTracking);

      $this->db->trans_complete();
      if ($this->db->trans_status() === FALSE) {
          $this->db->trans_rollback();
          $pesan = 'Create BAST failed';
          $this->session->set_flashdata('message', $pesan);
          redirect("EC_Vendor/Bast");
      } else {
          $this->db->trans_commit();
          $this->session->set_flashdata('message', $pesan);
          redirect("EC_Vendor/Bast");
      }
    }

    public function delete($id){
      $this->load->model('invoice/ec_bast','bast');
      $this->load->model('invoice/ec_bast_tracking','bastTracking');
      $this->load->model('invoice/ec_bast_doc','bastDoc');

      $data_bast = $this->bast->as_array()->get($id);
      $this->db->trans_begin();
      if($data_bast['STATUS'] == 1){
        $this->bast->delete(array('ID' => $id , 'STATUS' => '1'));
        $this->bastDoc->delete(array('ID_BAST' => $id));
        $this->bastTracking->delete(array('ID_BAST' => $id));
      }
      $this->db->trans_complete();
      if ($this->db->trans_status() === FALSE) {
          $this->db->trans_rollback();
          $pesan = 'Delete BAST failed';
          $this->session->set_flashdata('message', $pesan);
          redirect("EC_Vendor/Bast");
      } else {
          $this->db->trans_commit();
          $pesan = "BAST PO ".$data_bast['NO_PO']. " deleted";
          $this->session->set_flashdata('message', $pesan);
          redirect("EC_Vendor/Bast");
        }
    }
    /* ambil data dari inputan user */
    public function preview(){
      $this->load->library('M_pdf');
      $mpdf = new M_pdf();
      $this->load->model('invoice/ec_bast','eb');
      $kirim = array();

      $kirim['data'] = $this->input->post('data');
      $kirim['approve'] = array('UPDATE_AT' => date('d-M-y'));
      $this->cetakBast($kirim);
    }

    public function cetakBast($kirim = array()){
      $this->load->library('M_pdf');
  		$mpdf = new M_pdf();
      $this->load->model(array('vnd_header'));
      $vendor_no =  !empty($this->vendor_no) ? $this->vendor_no : $kirim['data']['NO_VENDOR'];
      //echo $vendor_no;
      $data_vendor = $this->vnd_header->get(array('VENDOR_NO'=> $vendor_no));
      $this->load->config('ec');
      $company_data = $this->config->item('company_data');

      $kirim['company_data'] = $company_data[$kirim['data']['COMPANY']];

      $kirim['vendor'] = $data_vendor;
  		$html = $this->load->view('EC_Vendor/bast/cetakBast',$kirim,TRUE);
  		$mpdf->pdf->writeHTML($html);
  		// echo $html;
  		$mpdf->pdf->output();
    }

    public function cetak($id){
      $this->load->model('invoice/ec_bast','eb');
      $this->load->model('invoice/ec_bast_tracking','ebt');
      $kirim = array();

      $data = $this->eb->as_array()->get($id);
      $approve = $this->ebt->as_array()->get(array('ID_BAST' => $id,'STATUS' => 2));

      $kirim['data'] = $data;
      $kirim['approve'] = !empty($approve) ? $approve : array('UPDATE_AT' => date('d-M-y'));
      $this->cetakBast($kirim);
    }

    public function history(){
      $id = $this->input->get('id');
      $this->load->model('invoice/ec_bast_tracking','ebt');
      $r = $this->ebt->history($id);
      $this->load->view('bapp/history',array('data' => $r));
    }

    public function notifikasiBAST($dataBast = NULL){
  			$data = array(
  				'content' => '
  						Dokumen BAST on '.date('d M Y H:i:s').'<br>
  						Nomor PO        : '.$dataBast['NO_PO'].'<br>
  						PO Item         : '.$dataBast['PO_ITEM'].'<br>
  						Deskripsi       : '.$dataBast['SHORT_TEXT'].'<br>',
  				'title' => 'Mohon Approval Dokumen BAST PO '.$dataBast['NO_PO'],
  				'title_header' => 'Mohon Approval Dokumen BAST PO '.$dataBast['NO_PO'],
          'url' => 'https://int-'.str_replace('http://','',str_replace('https://', '', base_url()))
  			);
  			$message = $this->load->view('EC_Notifikasi/approveInvoice',$data,TRUE);
  			$subject = 'Mohon Approval Dokumen BAST PO '.$dataBast['NO_PO'].' [E-Invoice Semen Indonesia]';

  		$_to = $dataBast['EMAIL'];
  		Modules::run('EC_Notifikasi/Email/invoiceNotifikasi',$_to,$message,$subject);
  	}

    public function showDocument(){
      $noBapp = $this->input->get('bast');
      $this->load->model('invoice/ec_bast','eb');
      $id = $this->eb->as_array()->get(array('NO_BAST' => $noBapp));
      $this->cetak($id['ID']);
    }
}
