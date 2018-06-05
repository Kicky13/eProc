<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ubah_no_vnd extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->helper('url');
		$this->load->library('Layout');
		$this->load->helper("security" );
		
	}

	public function index()
	{
		$data['title'] ='Ubah_no_vnd';
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/ubah_no.js');
		$this->layout->render('form_ubah', $data);
	}

	public function get_data_vnd() 
	{
		$this->load->model('ubah_vendor');
		$opco = $this->session->userdata['EM_COMPANY'];
		$dataa = $this->ubah_vendor->get($opco);
		$i = 1;
		//print_r($dataa);
		$data_tabel = array();
		foreach ($dataa as $value) {
			$data[0] = $i++;
			$data[1] = $value['VENDOR_NO'] = !null ? $value['VENDOR_NO'] : "";
			$data[2] = $value['VENDOR_NAME'] = !null ? $value['VENDOR_NAME'] : "";
			$data[3] = $value['ADDRESS_CITY'] = !null ? $value['ADDRESS_CITY'] : "";
			$data[4] = $value['VENDOR_TYPE'] = !null ? $value['VENDOR_TYPE'] : "";
			$data[5] = $value['EMAIL_ADDRESS'] = !null ? $value['EMAIL_ADDRESS'] : "";
			$data[6] = $value['VENDOR_ID'];
			$data_tabel[] = $data;
		}
		$json_data = /*$data_tabel;*/
		array('data' => $data_tabel);
		echo json_encode($json_data);
	}

	public function getDetail($VENDOR_ID) 
	{
		$this->load->model('ubah_vendor');
		$data['VENDOR_ID'] = $this->ubah_vendor-> getDetail($VENDOR_ID);
		//substr($MATNR, 1));
		echo json_encode($data);
	}

	public function updateNo() 
	{
		$this->load->model('ubah_vendor');
		$this->load->model('hist_vnd_header');

		$where_edit['VENDOR_ID'] = $this->input->post('VENDOR_ID');

		$set_edit['VENDOR_NO'] = $this->input->post('VENDOR_NO');

		//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
			$this->authorization->getCurrentRole(),'Update Nomor Vendor','SAVE',$this->input->ip_address());
			$LM_ID = $this->log_data->last_id();
		//--END LOG MAIN--//

		$this->ubah_vendor->updateNo($set_edit, $where_edit);
		$this->hist_vnd_header->update($set_edit,$where_edit);

		//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Ubah_no_vnd/updateNo','vnd_header','update',$set_edit, $where_edit);
		//--END LOG DETAIL--//

		//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Ubah_no_vnd/updateNo','hist_vnd_header','update',$set_edit, $where_edit);
		//--END LOG DETAIL--//
		$data['status'] = 'success';
		$data['post'] = $this->input->post();
		//echo json_encode($data);

		redirect('Ubah_no_vnd/');
	}
}

/* End of file Ubah_email_vnd */
/* Location: ./application/modules/Ubah_email_vnd/controllers/Ubah_email_vnd */