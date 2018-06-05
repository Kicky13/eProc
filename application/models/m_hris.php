<?php defined('BASEPATH') OR exit('No direct script access allowed');

class m_hris extends CI_Model {

	public $db = null;

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('hris_prod', TRUE);
	}

}