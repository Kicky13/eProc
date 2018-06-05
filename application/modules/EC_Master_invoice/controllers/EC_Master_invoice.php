<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Master_invoice extends CI_Controller {

	private $USER;

	public function __construct() {
		parent::__construct();
		$this -> load -> library('Authorization');
		$this -> load -> helper('url');
		$this -> load -> library('Layout');
		$this -> load -> helper("security");
		$this -> USER = explode("@", $this -> session -> userdata['EMAIL']);
	}

	public function index($cheat = false) {
		$data['title'] = "Master Invoice";
		$data['cheat'] = $cheat;
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this->layout->add_css('plugins/select2/select2.min.css');

		$this->layout->add_js('select2.min.js');
    $this -> layout ->add_js('bootbox.js');
		$this -> layout -> add_js('pages/EC_master_inv.js');
		$this -> load -> model('ec_master_inv');
		$this -> load -> model('invoice/ec_invoice_plant','eip');
		$this -> load -> model('invoice/ec_prchgrp','prc');
		$this -> load -> model('invoice/ec_range_po','rpo');

		$data['pajak'] = $this -> ec_master_inv -> getPajak();
		$data['denda'] = $this -> ec_master_inv -> getDenda();
		$data['doc'] = $this -> ec_master_inv -> getDoc();
		$data['doctype'] = $this -> ec_master_inv -> getDocType();
        $data['payblock'] = $this -> ec_master_inv -> getPayblock();
        $data['paymeth'] = $this -> ec_master_inv -> getPaymeth();
        $data['userrole'] = $this -> ec_master_inv -> getRoleUser();
        $data['usermapping'] = $this -> ec_master_inv -> getAllMapping();
        $data['mrole'] = $this -> ec_master_inv -> getMRole();
		$data['invoicePlant'] = $this->eip->as_array()->get_all();
		$data['purchasingGroup'] = $this->prc->as_array()->get_all();
		$data['rangePO'] = $this->rpo->getAllRangePO();
		$data['roleGR'] = $this->getDataRoleGR();
                $data['tambahPlant'] = $this->ec_master_inv->getAllPlant();                

		$this -> layout -> render('list2', $data);
	}

	public function baru($id_parent) {
		$this -> load -> model('ec_master_category_m');
		$data = array("KODE_PARENT" => $id_parent, "DESC" => $this -> input -> post("desc"), "KODE_USER" => $this -> input -> post("kode_user"), "LEVEL" => $this -> input -> post("level"));
		$this -> ec_master_category_m -> insertBaru($data);
	}

	public function pajakBaru() {
		$this -> load -> model('ec_master_inv');
		$data = array("STATUS" => "1", "JENIS" => $this -> input -> post("jenis"));
		$this -> ec_master_inv -> pajakBaru($data);
		redirect("EC_Master_invoice");
	}

	public function dendaBaru() {
		$this -> load -> model('ec_master_inv');
		//var_dump($this -> input -> post("glacc"));
		$data = array("STATUS" => "1", "ID_JENIS" => "1", "JENIS" => $this -> input -> post("jenis"), "GL_ACCOUNT" => $this -> input -> post("glacc"), "DIRECT_ACTION" => isset($_POST['direct']) ? "1" : "0");
		$this -> ec_master_inv -> dendaBaru($data);
		redirect("EC_Master_invoice");
	}

	public function UserRoleBaru(){
		$this -> load -> model('ec_master_inv');
		$status = 0;

		if($this->input->post('status') != NULL){
				$status = 1;
		}

		$data =  array(
				"USERNAME" => $this->input->post('username'),
				"ROLE_AS" => $this->input->post('role'),
				"STATUS" => $status
			);

		//var_dump($this->input->post('status'));
		$this->ec_master_inv->userRoleBaru($data);
		redirect("EC_Master_invoice");
	}

	/*MAPPING USER*/
	public function UserMappingBaru(){
		$this -> load -> model('ec_master_inv');
		$data =  array(
				"EMAIL1" => strtoupper($this->input->post('email')),
				"EMPLOYEE" => strtoupper($this->input->post('nama')),
				"ID_SAP" => strtoupper($this->input->post('id_sap'))
			);

		//var_dump($data);
		$this->ec_master_inv->UserMappingBaru($data);
		redirect("EC_Master_invoice");
	}

	public function UserMappingUpdate(){
		$this -> load -> model('ec_master_inv');

		$data =  array(
				"EMAIL1" => strtoupper($this->input->post('email')),
				"EMPLOYEE" => strtoupper($this->input->post('nama')),
				"ID_SAP" => strtoupper($this->input->post('id_sap'))
			);

		//var_dump($data);
		$this->ec_master_inv->userMappingUpdate($data);
		redirect("EC_Master_invoice");
	}

	public function deleteMapping(){
		$this -> load -> model('ec_master_inv');
		$email = $this->input->get('email');
		$data = array();

		$data ['status'] = $this->ec_master_inv->deleteMapping($email);
		echo json_encode($data);
		//redirect("EC_Master_invoice");
	}

	public function CheckEmail(){

		$this -> load -> model('ec_master_inv');
		$email = strtoupper($this->input->get('email'));
		$val = $this->ec_master_inv->getMappingUser($email);

		$result = array();
		$result['status'] = 1;
		if(!empty($val)){
			$result['status'] = 0;
		}
		echo json_encode($result);
	}

	public function UserRoleUpdate(){
		$this -> load -> model('ec_master_inv');
		$status = 0;

		if($this->input->post('status') != NULL){
				$status = 1;
		}
		$ID = $this->input->post('id');
		$data =  array(
				"USERNAME" => $this->input->post('username'),
				"ROLE_AS" => $this->input->post('role'),
				"STATUS" => $status
			);

		$this->ec_master_inv->userRoleUpdate($ID,$data);
		redirect("EC_Master_invoice");
	}

	public function UserRoleDelete($ID){
		$this -> load -> model('ec_master_inv');
		$Data = array("ID" => $ID);
		$this->ec_master_inv->userRoleDelete($Data);
		redirect("EC_Master_invoice");
	}

	public function updatePublish($ID_JENIS) {
		$this -> load -> model('ec_master_inv');
                $status = $this->input->post('status_publish');
                $tabel = $this->input->post('tabel');
		//var_dump($this -> input -> post("glacc"));
		//$data = array("STATUS" => "1", "ID_JENIS" => "1", "JENIS" => $this -> input -> post("jenis"), "GL_ACCOUNT" => $this -> input -> post("glacc"), "DIRECT_ACTION" => isset($_POST['direct']) ? "1" : "0");
		// $this -> ec_master_inv -> updatePublish($ID_JENIS, $this -> input -> post("status_publish"), $this -> input -> post("tabel"));
		//redirect("EC_Master_invoice");

                switch($tabel){
                    case 'EC_M_DOC_TYPE':
                        $key = 'ID_DOCTYPE';
                        break;
                    case 'EC_M_PAY_BLOCK':
                        $key = 'ID_PB';
                        break;
                    case 'EC_M_PAY_METHOD':
                        $key = 'ID_PM';
                        break;
                    case 'EC_M_PAY_TERM':
                        $key = 'ID_PT';
                        break;
                    default:
                        $key = 'ID_JENIS';
                }

                $r = $this->db->where(array($key => $ID_JENIS))->update($tabel,array('STATUS' => $status));
                $result = array('status' => 0, 'message' => 'Data gagal diupdate');
                if($r){
                    $result['status'] = 1;
                    $result['message'] = 'Data berhasil diupdate';
                }
                echo json_encode($result);
	}

	public function EditdendaBaru() {
		$this -> load -> model('ec_master_inv');
		//var_dump($this -> input -> post("glacc"));
		$data = array("ID_JENIS" => $this -> input -> post("ID_JENIS"), "JENIS" => $this -> input -> post("jenis"), "GL_ACCOUNT" => $this -> input -> post("glacc"), "DIRECT_ACTION" => isset($_POST['direct']) ? "1" : "0");
		$r = $this -> ec_master_inv -> updateDenda($data);
                $result = array('message' => 'Data gagal diupdate', 'status'=> 0);
                if($r){
                    $result['status'] = 1;
                    $result['message'] = 'Data berhasil diupdate';
                }
                echo json_encode($result);


	}

	public function docBaru() {
		$this -> load -> model('ec_master_inv');
		$data = array("STATUS" => "1", "ID_JENIS" => "1", "JENIS" => $this -> input -> post("jenis"));
		$this -> ec_master_inv -> docBaru($data);
		redirect("EC_Master_invoice");
	}

	public function EditdocBaru() {
		$this -> load -> model('ec_master_inv');
		$data = array("ID_JENIS" => $this -> input -> post("ID_DOC"), "JENIS" => $this -> input -> post("jenis"));
		$this -> ec_master_inv -> updateDoc($data);
		redirect("EC_Master_invoice");
	}

	public function hapus($id_parent) {
		$this -> load -> model('ec_master_category_m');
		$data = array("ID_CAT" => $id_parent, "KODE_USER" => $this -> input -> post("kodeEdit"));
		$this -> ec_master_category_m -> hapus($data);
	}

	public function sapDoctype(){
		$this->load->model('ec_master_inv');
		$this->load->library('sap_handler');
		$invoice = $this->sap_handler->getDoctype();
		// print_r($invoice['T_DATA']);
		$inv = array();
		foreach($invoice['T_DATA'] as $value){
			$inv=array(
				"DOC_LANG"=>$value['SPRAS'],
				"DOC_TYPE"=>$value['BLART'],
				"DOC_DESC"=>$value['LTEXT'],
				"STATUS"=>0
					     );
			$this->ec_master_inv->insertDoctype($inv);
			//exit;
		}
			redirect("EC_Master_invoice");
	}

	public function sapTax(){
		$this->load->model('ec_master_inv');
		$this->load->library('sap_handler');
		$invoice = $this->sap_handler->getTax();
		//print_r($invoice['T_DATA']);
		$inv = array();
		foreach($invoice['T_DATA'] as $value){
			$inv=array(
				"JENIS"=>$value['TEXT1'],
				"ID_JENIS"=>$value['MWSKZ'],
				"SPRAS"=>$value['SPRAS'],
				"KALSM"=>$value['KALSM'],
				"STATUS"=>0
					     );
			$this->ec_master_inv->insertTax($inv);
			//exit;
		}
			redirect("EC_Master_invoice");
	}

	public function sapPayblock(){
		$this->load->model('ec_master_inv');
		$this->load->library('sap_handler');
		$invoice = $this->sap_handler->getPayblock();
		//print_r($invoice['T_DATA']);
		$inv = array();
		foreach($invoice['T_DATA'] as $value){
			$pb = $value['ZAHLS'];
			if ($pb == null || $pb == '')
				$pb = '-';
			$inv=array(
				"PB_LANG"=>$value['SPRAS'],
				"PB_TYPE"=>$pb,
				"PB_DESC"=>$value['TEXTL'],
				"STATUS"=>0
					     );
			$this->ec_master_inv->insertPayblock($inv);

		}
			redirect("EC_Master_invoice");
	}

	public function sapPaymeth(){
		$this->load->model('ec_master_inv');
		$this->load->library('sap_handler');
		$invoice = $this->sap_handler->getPaymeth();
		//print_r($invoice['T_DATA']);
		$inv = array();
		foreach($invoice['T_DATA'] as $value){
			$inv=array(
				"PM_LANG"=>$value['LAND1'],
				"PM_TYPE"=>$value['ZLSCH'],
				"PM_DESC"=>$value['TEXT1']
					     );
			$this->ec_master_inv->insertPaymeth($inv);
			//exit;
		}
			redirect("EC_Master_invoice");
	}

	public function simpanPlant(){
		$plant = $this->input->post('plant');
		$status = $this->input->post('status');
		$result = array('status' => 0, 'message' => 'Data plant gagal disimpan ', 'data' => array());
		$this->load->model('invoice/ec_invoice_plant','eip');
		/* jika apakah sudah ada atau belum */
		$ada = $this->eip->get(array('PLANT' => $plant));
		$data = array(
			'PLANT' => $plant,
			'STATUS' => $status
		);
		if(empty($ada)){
			$data['CREATE_BY'] = strtoupper($this->USER[0]);
			if($this->eip->insert($data)){
					$result['status'] = 1;
					$result['message'] = ' Data plant invoice berhasil disimpan ';
					$result['data'] = array(
						'action' => 'insert',
						'plant' => $plant,
						'status' => $status,
						'create_date' => strtoupper(date('d-M-Y')),
						'create_by' => strtoupper($this->USER[0]),
					);
			}
		}else{
			$data['UPDATE_BY'] = strtoupper($this->USER[0]);
			if($this->eip->update($data,array('PLANT' => $plant))){
				$result['status'] = 1;
				$result['message'] = ' Data plant invoice berhasil diupdate ';
				$result['data'] = array(
					'action' => 'update',
					'plant' => $plant,
					'status' => $status
				);
			}
		}
		echo json_encode($result);
	}

	public function deleteInvoicePlant(){
		$plant = $this->input->post('plant');
		$result = array('status' => 0, 'message' => 'Data plant gagal dihapus ');
		$this->load->model('invoice/ec_invoice_plant','eip');
		if($this->eip->delete($plant)){
			$result['status'] = 1;
			$result['message'] = 'Data berhasil dihapus';
		}
		echo json_encode($result);
	}


	public function simpanPurchasing(){
		$prchgrp = $this->input->post('prchgrp');
		$desc = $this->input->post('desc');
		$result = array('status' => 0, 'message' => 'Data purchasing group gagal disimpan ', 'data' => array());
		$this->load->model('invoice/ec_prchgrp','prc');
		/* jika apakah sudah ada atau belum */
		$ada = $this->prc->get(array('PRCHGRP' => $prchgrp));
		$data = array(
			'PRCHGRP' => $prchgrp,
			'DESCRIPTION' => $desc
		);
		if(empty($ada)){

			if($this->prc->insert($data)){
					$result['status'] = 1;
					$result['message'] = ' Data purchasing group berhasil disimpan ';
					$result['data'] = array(
						'action' => 'insert',
						'prchgrp' => $prchgrp
					);
			}
		}else{

			if($this->prc->update($data,array('PRCHGRP' => $prchgrp))){
				$result['status'] = 1;
				$result['message'] = ' Data purchasing group berhasil diupdate ';
				$result['data'] = array(
					'action' => 'update',
					'prchgrp' => $prchgrp
				);
			}
		}
		echo json_encode($result);
	}

	public function deletePurchasingGroup(){
		$prchgrp = $this->input->post('prchgrp');
		$result = array('status' => 0, 'message' => 'Data purchasing group gagal dihapus ');
		$this->load->model('invoice/ec_prchgrp','prc');
		if($this->prc->delete(array('PRCHGRP' => $prchgrp))){
			$result['status'] = 1;
			$result['message'] = 'Data berhasil dihapus';
		}
		echo json_encode($result);
	}

	public function getListPurchasingGroup(){
		$this->load->library('sap_invoice');
		$input = array(
			'EXPORT_PARAM_SINGLE' => array(
			//	'I_EKGRP' => 'G*'
			)
		);
		$output = array(
			'EXPORT_PARAM_TABLE' => array('T_RESULT')
		);
		$t = $this->sap_invoice->callFunction('Z_ZCPH_RFC_SHPURCHGROUP',$input,$output);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($t['EXPORT_PARAM_TABLE']['T_RESULT']));
	}

	public function simpanRangePO(){
		$this->load->model('invoice/ec_range_po','rpo');
		$ret = array();
		$start = $this->input->post('START_RANGE');
		$end = $this->input->post('END_RANGE');
		$data = array(
			'START_RANGE' => $start,
			'END_RANGE' => $end,
			'STATUS' => $this->input->post('STATUS'),
		);

		if($this->input->post('AKSI') == 'TAMBAH'){
			$res = $this->rpo->getAllRangePO();
			$valid = true;
			for ($i=0; $i < count($res) ; $i++) {
				if (($res[$i]['START_RANGE'] <= $start)&&($res[$i]['END_RANGE'] >= $start)){
					$valid = false;
				}
				if (($res[$i]['START_RANGE'] <= $end)&&($res[$i]['END_RANGE'] >= $end)){
					$valid = false;
				}
			}
			if($valid){
				if($this->rpo->insert($data)){
					$ret['status'] = 1;
					$ret['msg'] = "Berhasil Menambah Data";
					$ret['aksi'] = "tambah";
				}else{
					$ret['status'] = 0;
					$ret['msg'] = "Gagal Menambah Data";
				}
			}else{
				$ret['status'] = 0;
				$ret['msg'] = "Range yang Anda Masukan Crash dengan Range yang Sudah Tersedia";
			}
		}else{
			$start = $this->input->post('AKSI');
			if($this->rpo->rangePOUpdate($start,$data)){
				$ret['status'] = 1;
				$ret['msg'] = "Berhasil Mengubah Data";
				$ret['aksi'] = "ubah";
			}else{
				$ret['status'] = 0;
				$ret['msg'] = "Gagal Mengubah Data";
			}
		}
		//echo $this->input->post('AKSI');
		//var_dump($data);
		echo json_encode($ret);
	}

	public function simpanRoleGR(){
		$this->load->model('invoice/ec_range_po','rpo');
		$ret = array();
		$username = $this->input->post('USERNAME');
		$access = $this->input->post('ACCESS');
		$data = array(
			'USERNAME' => $username,
			'ACCESS' => $access,
			'STATUS' => $this->input->post('STATUS'),
		);

		if($this->input->post('AKSI') == 'TAMBAH'){
			$valid = true;
			$temp = $this->db->where(array('USERNAME'=>$username,'ACCESS'=>$access))->get('EC_M_ROLE_APPROVAL_GR')->result_array();
			
			if(!empty($temp)){
				$valid = false;
			}

			if($valid){
				if($this->db->insert('EC_M_ROLE_APPROVAL_GR',$data)){
					$ret['status'] = 1;
					$ret['msg'] = "Berhasil Menambah Data";
					$ret['aksi'] = "tambah";
				}else{
					$ret['status'] = 0;
					$ret['msg'] = "Gagal Menambah Data";
				}
			}else{
				$ret['status'] = 0;
				$ret['msg'] = "Role tersebut sudah ada";
			}
		}else{

			if($this->db->where(array('USERNAME'=>$username,'ACCESS'=>$access))->update('EC_M_ROLE_APPROVAL_GR',$data)){
				$ret['status'] = 1;
				$ret['msg'] = "Berhasil Mengubah Data";
				$ret['aksi'] = "ubah";
			}else{
				$ret['status'] = 0;
				$ret['msg'] = "Gagal Mengubah Data";
			}
		}
		//echo $this->input->post('AKSI');
		//var_dump($data);
		echo json_encode($ret);
	}


	public function deleteRPO(){
		$this->load->model('invoice/ec_range_po','rpo');
		$data = array();
		$rpo = $this->input->post('rpo');
		if($this->rpo->delete(array('START_RANGE' => $rpo))){
			$data['status'] = 1;
			$data['msg'] = "Data Berhasil Dihapus";
		}else{
			$data['status'] = 0;
			$data['msg'] = "Data Gagal Dihapus";
		}
		echo json_encode($data);
	}

	public function getDataRoleGR(){
		return $this->db->order_by('USERNAME','ASC')->get('EC_M_ROLE_APPROVAL_GR')->result_array();
	}

	public function deleteRoleGR(){
		

		$username = $this->input->post('username');
		$access = $this->input->post('access');
		$data = array();

		if($this->db->where(array('USERNAME'=>$username,'ACCESS'=>$access))->delete('EC_M_ROLE_APPROVAL_GR')){
			$data['status'] = 1;
			$data['msg'] = "Data Berhasil Dihapus";
		}else{
			$data['status'] = 0;
			$data['msg'] = "Data Gagal Dihapus";
		}
		echo json_encode($data);
	}

	public function Test(){
		var_dump($this->session->userdata);
	}
        public function EditPlantBaru() {
		$this -> load -> model('ec_master_inv');
		$data = array("ROLE_AS" => $this -> input -> post("ROLE_AS"), "VALUE" => $this -> input -> post("VALUE"));
		$this -> ec_master_inv -> updatePlant($data);
		redirect("EC_Master_invoice");
	}
}
