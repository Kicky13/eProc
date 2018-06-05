<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class buat nangani Job di procurement.
 */
class Procurement_job {

	/* Load all dependencies */
	function __construct() {
		$this->ci = &get_instance();
		$this->ci->load->model('adm_employee');
		$this->ci->load->model('prc_pr_item');
		$this->ci->load->model('prc_process_holder');
		$this->ci->load->model('prc_tender_item');
		$this->ci->load->model('prc_tender_main');
		$this->ci->load->model('retender_item');
		$this->ci->load->model('retender_quo_item');
	}

	/**
	 * Buat
	 */
	public function allow_once() {
		$flash = array('allow' => true);
		$this->ci->session->set_flashdata('procurement_job', $flash);
	}

	/**
	 * Buat
	 */
	public function is_allowed() {
		$procjob = $this->ci->session->flashdata('procurement_job');
		// var_dump(compact('procjob'));
		if (isset($procjob)) {
			if ($procjob['allow']) {
				// echo 'allowed'; exit();
				return true;
			}
		}
		// echo 'not allowed'; exit();

		return false;
	}

	public function check_authorization($ptm_number = null) {
		return null;
		if ($ptm_number == null) {
			$ptm_number = $this->ci->uri->segment($this->ci->uri->total_segments());
		}
		if ($this->is_allowed()) {
			return $ptm_number;
		}
		redirect('Job_list/next_process/' . $ptm_number);
	}

}