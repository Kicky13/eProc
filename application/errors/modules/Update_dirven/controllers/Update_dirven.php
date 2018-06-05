<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Update_dirven extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
	}

	public function index($cheat = false) {
		$data['title'] = "Update Dirven";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_validate_css();
		$this->layout->set_validate_js();
		$this->layout->add_js('pages/update_dirven_table.js');
		$this->layout->render('list', $data);
	}

	public function detail($id){
		$this->load->model('com_jasa_group');
		$this->load->model('com_jasa_kualifikasi');
		$this->load->model('vnd_product');
		$this->load->model('vnd_header');

		$data['title'] = "Update Dirven";
		$data['group_jasa']=$this->com_jasa_group->get_jasa();
		$data['kualifikasi_jasa']=$this->com_jasa_kualifikasi->get_jasa();
		$data['vendor_id']=$id;
		$data['services'] = $this->vnd_product->order_by('PRODUCT_ID')->get_all(array("VENDOR_ID" => $id, "PRODUCT_TYPE" => "SERVICES"));
		$data['panel_header'] =$this->vnd_header->get_all(array("VENDOR_ID" => $id));

		$this->layout->set_datetimepicker();
		$this->layout->add_js('pages/mydatetimepicker.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();		
		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('plugins/select2/select2.js');
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('pages/update_dirven.js');
		$this->layout->render('detail',$data);
	}

	public function get_datatable() {
		$this->load->model('vnd_header');
		$start=$this->input->post('start');
		$length=$this->input->post('length');
		$draw=$this->input->post('draw');
		$data = array();
		$datatable = $this->vnd_header->get_partial($start,$length,$draw);
		
		echo json_encode($datatable);
	}

	function get_vendor()
	{
		$this->load->model('vnd_header');
		$this->load->model('adm_wilayah');
		$opco = $this->session->userdata['EM_COMPANY'];

		if ($opco == '7000' || $opco == '2000' || $opco == '5000') {
			$whereopco = array(7000,2000,5000);
		} else {
			$whereopco = $opco;
		}

		$datatable = $this->vnd_header->where(array("STATUS"=>3))->where("COMPANYID",$whereopco)->fields(array('VENDOR_ID','VENDOR_TYPE','VENDOR_NAME','ADDRESS_CITY','VENDOR_NO','ADDRESS_STREET','ADDRES_PROP','ADDRESS_PHONE_NO'))->get_all();

		$city = create_standard($this->adm_wilayah->fields('ID,NAMA')->get_all(array('JENIS'=>'KOTA')));
		$city_list = array();
		foreach ($city as $key => $value) {
			$city_list[$key] = $value;
		}
		$data['city_list'] = $city_list;

		// die(var_dump($city_list));

		foreach ($datatable as $key => $value) {
			if(!is_null($value['ADDRESS_CITY']))
				if(is_numeric($value['ADDRESS_CITY']))
					if(array_key_exists($value['ADDRESS_CITY'],$city_list)){
							$datatable[$key]['ADDRESS_CITY'] = $city_list[$value['ADDRESS_CITY']];
					}
			
		}
		$data = array('data' => $datatable);
		echo json_encode($data);
	}

	function pilih_child(){
		$id = $this->input->post('id');
		$this->load->model('com_jasa_group');

		$data=$this->com_jasa_group->get_child($id);

		echo form_dropdown("data",$data,'','');
	}

	function pilih_sub_klasifikasi() {
		$id = $this->input->post('id');
		$this->load->model('com_jasa_group');

		$data=$this->com_jasa_group->get_sub_klasifikasi($id);

		echo json_encode($data);
	}

	function pilih_child_kualifikasi(){
		$id = $this->input->post('id');
		$this->load->model('com_jasa_kualifikasi');

		$data=$this->com_jasa_kualifikasi->get_child($id);

		echo form_dropdown("data",$data,'','');
	}

	function do_insert_service() {
		$this->load->model('com_jasa_group');
		$this->load->model('vnd_product');
		$this->load->model('hist_vnd_product');

		$temp = $this->input->post('vendor_id');
		$tempty = empty($temp);
		if (!$tempty) {
			$vendor_id = $this->input->post('vendor_id');
		}
		$svc = NULL;
		$svc_code = NULL;
		$subsvc = NULL;
		$subsvc_code = NULL;
		$product_description = NULL;
		$brand = NULL;
		$klasifikasi_id = NULL;
		$klasf = null;
		$issued_by = NULL;
		$no = NULL;
		$issued_date = NULL;
		$expired_date = NULL;
		$data = array(
					"VENDOR_ID" => $vendor_id,
					"PRODUCT_TYPE" => "SERVICES"
					);
		$temp = $this->input->post('svc');
		$tempty = empty($temp);
		if(!$tempty) {
			$svc = $this->input->post('svc');
			$data['PRODUCT_NAME'] = $svc;
		}
		$temp = $this->input->post('group_jasa_id');
		$tempty = empty($temp);
		if(!$tempty) {
			$svc_code = $this->input->post('group_jasa_id');
			$data['PRODUCT_CODE'] = $svc_code;
		}
		$temp = $this->input->post('subsvc');
		$tempty = empty($temp);
		if(!$tempty) {
			$subsvc = $this->input->post('subsvc');
			$data['PRODUCT_SUBGROUP_NAME'] = $subsvc;
		}
		$temp = $this->input->post('subGroup_jasa_id');
		$tempty = empty($temp);
		if(!$tempty) {
			$subsvc_code = $this->input->post('subGroup_jasa_id');
			$data['PRODUCT_SUBGROUP_CODE'] = $subsvc_code;
		}
		$temp = $this->input->post('issued_by');
		$tempty = empty($temp);
		if(!$tempty) {
			$issued_by = $this->input->post('issued_by');
			$data['ISSUED_BY'] = $issued_by;
		}
		$temp = $this->input->post('no');
		$tempty = empty($temp);
		if(!$tempty) {
			$no = $this->input->post('no');
			$data['NO'] = $no;
		}
		$temp = $this->input->post('issued_date');
		$tempty = empty($temp);
		if(!$tempty) {
			$issued_date = $this->input->post('issued_date');
			$data['ISSUED_DATE'] = vendortodate($issued_date);
		}
		$temp = $this->input->post('expired_date');
		$tempty = empty($temp);
		if(!$tempty) {
			$expired_date = $this->input->post('expired_date');
			$data['EXPIRED_DATE'] = vendortodate($expired_date);
		}

		$temp = $this->input->post('klasifikasi_jasa_id');
		$tempty = empty($temp);
		if(!$tempty) {
			$klasifikasi_id = $this->input->post('klasifikasi_jasa_id');
			$data['KLASIFIKASI_ID'] = $klasifikasi_id;
		}
		$temp = $this->input->post('klasf');
		$tempty = empty($temp);
		if(!$tempty) {
			$klasf = $this->input->post('klasf');
			$data['KLASIFIKASI_NAME'] = $klasf;
		}
		$subKlaId = null;
		$subKlaName = null;
		$subKlasiId = $this->input->post('subKlasifikasi_jasa_id');
		if(isset($subKlasiId)){
			$va = json_encode($subKlasiId);
			$a=explode('[', $va);
			$e=explode(']', $a[1]);
			$p=str_replace('"', '', $e[0]);
			$subKlaId=$p;

			$sbkl = explode(',', $subKlaId);
			$subKlasName=array();
			foreach ($sbkl as $val) {
				$dat = $this->com_jasa_group->get_id($val);
				$subKlasName[]= $dat[0]['NAMA'];
			}
			$na = json_encode($subKlasName);
			$n=explode('[', $na);
			$m=explode(']', $n[1]);
			$me=str_replace('"', '', $m[0]);
			$subKlaName=$me;

		}
		$data['SUBKLASIFIKASI_ID'] = $subKlaId;		
		$data['SUBKLASIFIKASI_NAME'] = $subKlaName;

		$temp = $this->input->post('kualifikasi_jasa_id');
		$tempty = empty($temp);
		if(!$tempty) {
			$kualifi_id = $this->input->post('kualifikasi_jasa_id');
			$data['KUALIFIKASI_ID'] = $kualifi_id;
		}

		$temp = $this->input->post('kualifi');
		$tempty = empty($temp);
		if(!$tempty) {
			$kualifi = $this->input->post('kualifi');
			$data['KUALIFIKASI_NAME'] = $kualifi;
		}

		$temp = $this->input->post('subKualifikasi_jasa_id');
		$tempty = empty($temp);
		if(!$tempty) {
			$subKualifi_id = $this->input->post('subKualifikasi_jasa_id');
			$data['SUBKUALIFIKASI_ID'] = $subKualifi_id;
		}

		$temp = $this->input->post('subKualifi');
		$tempty = empty($temp);
		if(!$tempty) {
			$subKualifi = $this->input->post('subKualifi');
			$data['SUBKUALIFIKASI_NAME'] = $subKualifi;
		}
		$data['FILE_UPLOAD']=$this->input->post('file_upload');
		
		if (isset($data)) {
			$data['VND_TRAIL_ID'] = "3";
			$this->hist_vnd_product->insert($data);
			$data['ISLISTED'] = $this->hist_vnd_product->get_last_id();
			$this->vnd_product->insert($data);
			echo 'OK';
		}
		else {
			echo json_encode('Gagal Insert');
		}
	}

	public function viewDok($id = null){
		$url = str_replace("int-","", base_url());
		$this->load->helper('file');
		$image_path = base_url(UPLOAD_PATH).'/vendor/'.$id;	

		if (strpos($url, 'semenindonesia.com') !== false) { //server production
		$user_id=url_encode($this->session->userdata['ID']);
			if(empty($id)){
				die('tidak ada attachment.');
			}
			if(file_exists(BASEPATH.'../upload/vendor/'.$id)){				
				$this->output->set_content_type(get_mime_by_extension($image_path));
				return $this->output->set_output(file_get_contents($image_path));
			}else{
				$url = str_replace("http","https", $url);
				redirect($url.'View_document_vendor/viewDok/'.$id.'/'.$user_id);
			}

		}else{ //server development
			if(empty($id) || !file_exists(BASEPATH.'../upload/vendor/'.$id)){
				die('could not be found.');
			}
			
			$this->output->set_content_type(get_mime_by_extension($image_path));
			return $this->output->set_output(file_get_contents($image_path));
		}
	}

	function uploadAttachment() {
		$this->load->library('encrypt');
		$server_dir = str_replace("\\", "/", FCPATH);
		$upload_dir = UPLOAD_PATH."vendor/";
		$this->load->library('file_operation');
		$this->file_operation->create_dir($upload_dir);
		$this->load->library('FileUpload');
		$uploader = new FileUpload('uploadfile');
		$ext = $uploader->getExtension(); // Get the extension of the uploaded file
		mt_srand();
		$filename = md5(uniqid(mt_rand())).".".$ext;
		$uploader->newFileName = $filename;
		$result = $uploader->handleUpload($server_dir.$upload_dir);
		if (!$result) {
			exit(json_encode(array('success' => false, 'msg' => $uploader->getErrorMsg(), 'path' => $upload_dir)));
		}
		echo json_encode(array('success' => true, 'newFileName' => $filename, 'upload_dir' => $upload_dir));
	}

	public function deleteFile(){
		$id = $this->input->post('id');
		$fileUpload = $this->input->post('filename');
		$this->load->model('hist_vnd_product');
		$this->load->model('vnd_product');		
		$this->load->helper("url");

		$path = './upload/vendor/'.$fileUpload;
	    if(file_exists(BASEPATH.'../upload/vendor/'.$fileUpload)){
	        unlink($path);
	    }
	}

	public function delete(){
		$this->load->model('hist_vnd_product');
		$this->load->model('vnd_product');
		$id = $this->input->post('id');

		$data = $this->vnd_product->order_by('PRODUCT_ID')->get_all(array("PRODUCT_ID" => $id));
		
		if($this->hist_vnd_product->delete(array("PRODUCT_ID" => $data[0]['ISLISTED']))) {
			if($this->vnd_product->delete(array("PRODUCT_ID" => $id))) {
				$fileUpload=$data[0]['ISLISTED'];
				if(!empty($fileUpload)){
					$path = './upload/vendor/'.$fileUpload;
				    if(file_exists(BASEPATH.'../upload/vendor/'.$fileUpload)){
				        unlink($path);
				    }
				}
				echo 'OK';
			}
		}
	}


}