<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Procurement_pembatalan extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->helper('url');
	}

	public function index($value='')
	{
		$this->authorization->roleCheck();
		$data['title'] = "Pembatalan Pengadaan";
        $this->layout->add_js('pages/prc_pembatalan.js');
		$this->layout->render('pembatalan', $data);
	}

	public function is_exist($ppm_id = 0) {
		$this->load->model('prc_plan_main');
		$result = $this->prc_plan_main->get(array('PPM_ID' => $ppm_id));
		echo json_encode($result == null ? false : $result['PPM_STATUS_ACTIVITY']);
	}

	public function batal()
	{
		$this->load->model('prc_plan_main');

		var_dump($_POST);
		$id = $_POST['nomor_pengadaan'];
		$where = array('PPM_ID' => $id);
		$result = $this->prc_plan_main->get($where);
		var_dump($result);

		if ($result == null) {
			echo 'false';
		} else {
			$status = $result['PPM_STATUS_ACTIVITY'] * -1;
			$this->prc_plan_main->update(array('PPM_STATUS_ACTIVITY' => array($status, 'INT')), $where);
			echo 'true';
		}
		redirect('Procurement_pembatalan');
	}

}