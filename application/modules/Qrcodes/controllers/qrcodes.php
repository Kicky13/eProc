<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Qrcodes extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
	}

	public function index() {
		$this->load->library('ci_qr_code');

		$params['data'] = 'http://www.semenindonesia.com';
		$params['level'] = 'H';
		$params['size'] = 10;
		$params['savename'] = FCPATH . 'static/images/captcha/tes.png';
		$this->ci_qr_code->generate($params);
		echo '<img src="'.base_url().'static/images/captcha/tes.png" />';
	}

}