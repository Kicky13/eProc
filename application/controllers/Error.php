<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Error extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		redirect('Error/browser');
	}

	public function browser() {
		$this->load->view('plain/browser_error');
	}

}