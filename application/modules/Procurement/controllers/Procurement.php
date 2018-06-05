<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Procurement extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('Authorization');
	}

	public function assign() {
		echo json_encode($this->input->post());
	}

}