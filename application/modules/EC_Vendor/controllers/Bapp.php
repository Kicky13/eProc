<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bapp extends MX_Controller {

    private $user;
    private $user_email;
    private $vendor_no;
    public function __construct() {
        parent::__construct();
        $this->load->library('Authorization');
        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper("security");
        $this->load->model("invoice/ec_bapp",'bapp');
        $this->user = $this->session->userdata('FULLNAME');
        $this->vendor_no = $this->session->userdata('VENDOR_NO');
        $this->user_email = $this->session->userdata('EMAIL');
    }

    public function index($cheat = false) {
        $data['title'] = "Management BAPP";
        $data['cheat'] = $cheat;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();

        $this->layout->add_js('bootbox.js');
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('pages/invoice/EC_bapp.js');

        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/invoice/common.css');

        $this->layout->render('bapp/bapp', $data);
    }
    /* status bapp
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
      $this->layout->add_js('pages/invoice/EC_bapp_form.js');
      $this->layout->add_css('plugins/trumbowyg/trumbowyg.css');
      $this->layout->add_css('pages/invoice/common.css');

        $bisaEdit = 0;
        $data = array();
        $data['dataBapp'] = array(
          'NO_PO' => '',
          'PO_ITEM' => '',
          'NO_BAPP' => '',
          'QTY' => '',
          'DESCRIPTION' => '',
          'SHORT_TEXT' => '',
          'PENGAWAS' => '',
          'JABATAN' => '',
          'EMAIL' => '',
          'COMPANY' => '',
          'STATUS' => '',
          'MTRL_GROUP' => '',
          'SERVICE' => '',
          'SERVICE_DESC' => '',
        );
        $data['bappDoc'] = array();
        $data['id'] = $id;
        if (empty($id)) {
            $data['title'] = "Create BAPP";
            $bisaEdit = 1;
        }else{
            $this->load->model('invoice/ec_bapp_doc','bappDoc');
            $this->load->model('invoice/ec_bapp_item','bappItem');
            $data['bappDoc'] = $this->bappDoc->as_array()->get_all(array('ID_BAPP' => $id));
            $data['title'] = "Update BAPP";
            $qty = $this->bappItem->as_array()->get(array('EC_BAPP' => $id));

            $data['dataBapp'] = $this->bapp->as_array()->get(array('ID' => $id));
            $data['dataBapp']['QTY'] = ribuan($qty['QTY'],2);
            $data['dataBapp']['SERVICE'] = $qty['SERVICE'];
            $data['dataBapp']['SERVICE_DESC'] = $qty['SERVICE_DESC'];
            $data['dataBapp']['PEKERJAAN'] = '';
            if($data['dataBapp']['STATUS'] != 3){
              /* periksa bisa edit atau gak */
              if(!empty($this->vendor_no)){
                  if($data['dataBapp']['STATUS'] != 2){
                    $bisaEdit = 1;
                  }
              }else{
                if($data['dataBapp']['STATUS'] == 2){
                  $bisaEdit = 1;
                }
              }
            }
        }
        $data['bisaEdit'] = $bisaEdit;
        $data['urlAction'] = site_url('EC_Vendor/Bapp/simpan/'.$id);

        $this->layout->render('bapp/form', $data);
    }

    public function submitBapp($id){
      if($this->bapp->update(array('STATUS' => 2),array('ID' => $id, 'STATUS' => 1))){
        $pesan = "BAPP berhasil disubmit";
        $this->session->set_flashdata('message', $pesan);

        $this->load->model('invoice/ec_bapp_tracking','bappTracking');
        $dataTracking = array(
          'ID_BAPP' => $id,
          'STATUS' => 2,
          'UPDATE_BY' => $this->user
        );

        $this->bappTracking->insert($dataTracking);
        /* notifikasi email ke user SI */
        $dataBapp = $this->bapp->as_array()->get(array('ID' => $id));
        $this->notifikasiBAPP($dataBapp);

      }
      redirect('EC_Vendor/Bapp');
    }

    public function simpan($id = ''){
      $this->load->library('file_operation');
      $this->load->helper('file');
      $this->load->helper(array('form', 'url'));
      $data_bapp = array(
        'NO_VENDOR' => $this->vendor_no,
        'COMPANY' => $this->input->post('COMPANY'),
        'NO_PO' => $this->input->post('NO_PO'),
    //    'QTY' => $this->getNumeric($this->input->post('QTY')),
    //    'NO_BAPP' => $this->input->post('NO_BAPP'),
        'DESCRIPTION' => $this->input->post('DESCRIPTION'),
        'PO_ITEM' => $this->input->post('PO_ITEM'),
        'SHORT_TEXT' => $this->input->post('SHORT_TEXT'),
        'PENGAWAS' => $this->input->post('PENGAWAS'),
        'JABATAN' => $this->input->post('JABATAN'),
        'EMAIL' => $this->input->post('EMAIL'),
        'MTRL_GROUP' => $this->input->post('MTRL_GROUP')
      );
      $qty = $this->getNumeric($this->input->post('QTY'));
      $service = $this->input->post('SERVICE');
      $service_desc = $this->input->post('SERVICE_DESC');
      $pesan = "BAPP untuk PO ".$data_bapp['NO_PO']. " created";
      $uploaded = $this->file_operation->uploadL(UPLOAD_PATH . 'EC_invoice', $_FILES);
      // print_r($uploaded);die();
      /* simpan bapp */
      $this->load->model('invoice/ec_bapp_doc','bappDoc');
      $this->load->model('invoice/ec_bapp_item','bappItem');
      $this->db->trans_begin();
      if(empty($id)){
        $idbapp = $this->bapp->insert($data_bapp);
        /* insert ke bapp_item */
        $this->bappItem->insert(array('EC_BAPP' => $idbapp, 'QTY' => $qty, 'SERVICE' => $service, 'SERVICE_DESC' => $service_desc));
      }else{
        $data_bapp['STATUS'] = 1;
        $this->bapp->update($data_bapp,array('ID' => $id));
        $this->bappItem->update(array('QTY' => $qty),array('EC_BAPP' => $id));
        $this->bappDoc->delete(array('ID_BAPP' => $id));
        $idbapp = $id;
        $pesan = "BAPP untuk PO ".$data_bapp['NO_PO']. " updated";
      }

      /* insert ke lampiran bapp */
      $lampiranBapp = $this->input->post('lampiranBapp');
      if(!empty($uploaded) or !empty($lampiranBapp)){
        $_u = 0;
        $oldFileLampiranBapp = $this->input->post('oldFileLampiranBapp');

        foreach($lampiranBapp as $i => $name){
          $idFile = 'fileLampiranBapp_'.$i;

          $bappDoc = array(
            'ID_BAPP' => $idbapp,
            'PIC' => isset($uploaded[$idFile]) ? $uploaded[$idFile]['file_name'] : $oldFileLampiranBapp[$i],
            'DESCRIPTION' => $name,
          );
          $this->bappDoc->insert($bappDoc);
        }
      }
      $this->load->model('invoice/ec_bapp_tracking','bappTracking');
      $dataTracking = array(
        'ID_BAPP' => $idbapp,
        'STATUS' => 1,
        'UPDATE_BY' => $this->user
      );
      $this->bappTracking->insert($dataTracking);

      $this->db->trans_complete();
      if ($this->db->trans_status() === FALSE) {
          $this->db->trans_rollback();
          $pesan = 'Create BAPP failed';
          $this->session->set_flashdata('message', $pesan);
          redirect("EC_Vendor/Bapp");
      } else {
          $this->db->trans_commit();
          $this->session->set_flashdata('message', $pesan);
          redirect("EC_Vendor/Bapp");
      }
    }

    public function delete($id){
      $this->load->model('invoice/ec_bapp','bapp');
      $this->load->model('invoice/ec_bapp_tracking','bappTracking');
      $this->load->model('invoice/ec_bapp_doc','bappDoc');
      $this->load->model('invoice/ec_bapp_item','bappItem');
      $data_bapp = $this->bapp->as_array()->get($id);
      $this->db->trans_begin();
      if($data_bapp['STATUS'] == 1){
        $this->bapp->delete(array('ID' => $id , 'STATUS' => '1'));
        $this->bappDoc->delete(array('ID_BAPP' => $id));
        $this->bappTracking->delete(array('ID_BAPP' => $id));
        $this->bappItem->delete(array('EC_BAPP' => $id));
      }
      $this->db->trans_complete();
      if ($this->db->trans_status() === FALSE) {
          $this->db->trans_rollback();
          $pesan = 'Delete BAPP failed';
          $this->session->set_flashdata('message', $pesan);
          redirect("EC_Vendor/Bapp");
      } else {
          $this->db->trans_commit();
          $pesan = "BAPP PO ".$data_bapp['NO_PO']. " deleted";
          $this->session->set_flashdata('message', $pesan);
          redirect("EC_Vendor/Bapp");
        }
    }

    public function openPOJasa(){
      $this->load->library('sap_invoice');
      $input = array(
        'EXPORT_PARAM_SINGLE' => array(
  				'VENDOR' => $this->vendor_no,
          'ITEM_CAT' => '9',
          'WITH_PO_HEADERS' => 'X',
      //    'ITEMS_OPEN_FOR_RECEIPT' => 'X' /* cari yang open saja, gak bisa ternyata */
  			)
      );
      $output = array(
        'EXPORT_PARAM_TABLE' => array('PO_ITEMS','PO_HEADERS'),
      );
      $t = $this->sap_invoice->callFunction('BAPI_PO_GETITEMS',$input,$output);

      $this->load->view('EC_Vendor/bapp/list_po',array('data' => $t));
    }

    public function getService(){
  		$this->load->library('sap_invoice');
      $mtrl_group = $this->input->post('mtrl_group');
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

  		echo json_encode($t['EXPORT_PARAM_TABLE']['SERVICELIST']);
  	}
    /* cari no_po yang memiliki bapp belum approve */
    public function bappBelumApprove(){
        $po = $this->bapp->get_all_by('NO_VENDOR = \''.$this->vendor_no.'\' and STATUS != 3');
        return $po;
    }
    /* cari yang belum di approve saja */
    public function getAllBapp($status){
        if($status == 'approved'){
            $res = $this->bapp->order_by('CREATE_AT')->get_all_by('NO_VENDOR = '.$this->vendor_no.' and STATUS = 3');
        }else{
          $res = $this->bapp->order_by('CREATE_AT')->get_all_by('NO_VENDOR = '.$this->vendor_no.' and STATUS != 3');
        }

        $json_data = array('data' => $res);
        echo json_encode($json_data);
    }

    public function kofirmasiVendor(){
      $text = "Dengan ini kami menyatakan bahwa apa yang kami isikan pada aplikasi ini adalah benar dan mewakili vendor";
      echo $text;
    }

    public function history(){
      $id = $this->input->get('id');
      $this->load->model('invoice/ec_bapp_tracking','ebt');
      $r = $this->ebt->history($id);
      $this->load->view('bapp/history',array('data' => $r));
    }

    public function listPegawai(){
      $search = $this->input->get('search');
      $search = strtoupper($search);
      $sql = <<<SQL
      select ae.FULLNAME,hj.MJAB_NAMA,ae.EMAIL from adm_employee ae
            join HRIS_V_JABATAN hj
            on ae.em_jab_kode = hj.mjab_kode and ae.em_company = hj.company
            where  ae.status = 'Active' and ae.FULLNAME like '%{$search}%'
SQL;

      $result = $this->db->query($sql)->result_array();
      $this->load->view('EC_Vendor/bapp/list_pegawai',array('rows' => $result));
    }
private function getNumeric($strNominee){
  return floatval(str_replace(',', '.', str_replace('.', '', $strNominee)));
}

  public function sisaQty(){
    $qty = $this->input->post('qty');
    $po = $this->input->post('po_no');
    $po_item = $this->input->post('item_no');
    $this->load->model('invoice/ec_bapp','bapp');
    $this->load->model('invoice/ec_bapp_item','bapp_item');
    $id = $this->input->post('id');
    $_total = 0;
    $bapp = $this->bapp->as_array()->fields('ID,CREATE_AT')->get_all(array('PO_ITEM' => $po_item, 'NO_PO' => $po));
    if(!empty($bapp)){
      $_tmpId = array();
      foreach($bapp as $_b){
        array_push($_tmpId,$_b['ID']);
      }
      $bapp_item = $this->bapp_item->as_array()->fields('EC_BAPP,QTY')->get_all_by('EC_BAPP in ('.implode(',',$_tmpId).')');
      /* mungkin nanti perlu juga untuk ambil data dari SAP, bisa saja sudah pernah dilakukan bapp sebelum adanya einvoice ini */
      if(!empty($bapp_item)){
        foreach($bapp_item as $s){
          if($id != $s['EC_BAPP']){
              $_total += $s['QTY'];
          }
        }
      }
    }
    $sisa = $qty - $_total;
    echo json_encode(array('status' => 1, 'maxqty' => ribuan($sisa,2)));
  }

  public function checkQty(){
    $qty = $this->getNumeric($this->input->post('qty'));
    $po = $this->input->post('po_no');
    $po_item = $this->input->post('po_item');
    $id = $this->input->post('id');
    $this->load->model('invoice/ec_bapp','bapp');
    $this->load->model('invoice/ec_bapp_item','bapp_item');
    $_total = 0;
    $bapp = $this->bapp->as_array()->fields('ID,CREATE_AT')->get_all(array('PO_ITEM' => $po_item, 'NO_PO' => $po));
    if(!empty($bapp)){
      $_tmpId = array();
      foreach($bapp as $_b){
        array_push($_tmpId,$_b['ID']);
      }
      $bapp_item = $this->bapp_item->as_array()->fields('EC_BAPP,QTY')->get_all_by('EC_BAPP in ('.implode(',',$_tmpId).')');
      /* mungkin nanti perlu juga untuk ambil data dari SAP, bisa saja sudah pernah dilakukan bapp sebelum adanya einvoice ini */
      if(!empty($bapp_item)){
        foreach($bapp_item as $s){
          if($id != $s['EC_BAPP']){
              $_total += $s['QTY'];
          }
        }
      }
    }
    $qtyPo = $this->quantityPO($po,$po_item,$qty);
    $maxqty = $qtyPo['maxqty'];
    $result = array('status' => 0, 'message' => '');
    $sisa = $maxqty - $_total;
    if($sisa >= $qty){
      $result['status'] = 1;
      // $result['message'] = 'sisa '.$sisa.' max '.$maxqty.' total '.$_total;
    }else{
      $result['message'] = ' Maksimal yang bisa diinput adalah '.ribuan($sisa,2);
    }
    echo json_encode($result);
  }

  private function quantityPO($po,$item_no,$qty){
    $this->load->library('sap_invoice');
    $input = array(
      'EXPORT_PARAM_SINGLE' => array(
        'PURCHASEORDER' => $po,
        'ITEMS' => 'X'
      )
    );
    $output = array(
      'EXPORT_PARAM_TABLE' => array('PO_ITEMS'),
    );
    $t = $this->sap_invoice->callFunction('BAPI_PO_GETDETAIL',$input,$output);
    $result = $t['EXPORT_PARAM_TABLE']['PO_ITEMS'];
    $max_qty = 0;

    foreach($result as $r){
      if($r['PO_ITEM'] == $item_no){
        if(empty($r['DELETE_IND'])){
          $max_qty = $r['QUANTITY'];
          break;
        }
      }
    }
    return array('status' => 0, 'maxqty' => $max_qty);
  }
  /* ambil data dari inputan user */
  public function preview(){
    $this->load->library('M_pdf');
    $mpdf = new M_pdf();
    $this->load->model('invoice/ec_bapp','eb');
    $this->load->model('invoice/ec_bapp_tracking','ebt');
    $kirim = array();

    $kirim['data'] = $this->input->post('data');
    $kirim['approve'] = array('UPDATE_AT' => date('d-M-y'));
    $this->cetakBapp($kirim);
  }

  public function cetakBapp($kirim = array()){
    $this->load->library('M_pdf');
		$mpdf = new M_pdf();
    $this->load->model(array('vnd_header'));
    $vendor_no =  !empty($this->vendor_no) ? $this->vendor_no : $kirim['data']['NO_VENDOR'];
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
  public function cetak($id){
		$this->load->model('invoice/ec_bapp','eb');
		$this->load->model('invoice/ec_bapp_tracking','ebt');
		$kirim = array();

		$data = $this->eb->as_array()->get($id);
		$approve = $this->ebt->as_array()->get(array('ID_BAPP' => $id,'STATUS' => 2));

		$kirim['data'] = $data;
		$kirim['approve'] = !empty($approve) ? $approve : array('UPDATE_AT' => date('d-M-y'));
    $this->cetakBapp($kirim);
	}

  public function notifikasiBAPP($dataBapp = NULL){
			$data = array(
				'content' => '
						Dokumen BAPP on '.date('d M Y H:i:s').'<br>
						Nomor PO        : '.$dataBapp['NO_PO'].'<br>
						PO Item         : '.$dataBapp['PO_ITEM'].'<br>
						Deskripsi       : '.$dataBapp['SHORT_TEXT'].'<br>',
				'title' => 'Mohon Approval Dokumen BAPP PO '.$dataBapp['NO_PO'],
				'title_header' => 'Mohon Approval Dokumen BAPP PO '.$dataBapp['NO_PO'],
        'url' => 'https://int-'.str_replace('http://','',str_replace('https://', '', base_url()))
			);
			$message = $this->load->view('EC_Notifikasi/approveInvoice',$data,TRUE);
			$subject = 'Mohon Approval Dokumen BAPP PO '.$dataBapp['NO_PO'].' [E-Invoice Semen Indonesia]';

		$_to = $dataBapp['EMAIL'];
		Modules::run('EC_Notifikasi/Email/invoiceNotifikasi',$_to,$message,$subject);
	}

  public function showDocument(){
    $noBapp = $this->input->get('bapp');
    $this->load->model('invoice/ec_bapp','eb');
    $id = $this->eb->as_array()->get(array('NO_BAPP' => $noBapp));
    $this->cetak($id['ID']);
  }
}
