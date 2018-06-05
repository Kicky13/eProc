<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Procurement_management extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->model(array());
	}

	public function index() {
		$this->to_do_list();
	}

	public function general_data() {
	}

	function do_update_general_data() {
		if ($this->session->userdata('STATUS') == "99") {
			$this->load->model('hist_vnd_company_type');
		}
		else {
			$this->load->model('tmp_vnd_company_type');
		}
		if ($this->input->post('vendor_id')) {
			$vendor_id = $this->input->post('vendor_id');
		}
		$prefix = NULL;
		$company_name = NULL;
		$suffix = NULL;
		$contact_name = NULL;
		$contact_pos = NULL;
		$contact_phone_no = NULL;
		$contact_email = NULL;
		$company_type = NULL;
		if ($this->input->post('prefix')) {
			$prefix = $this->input->post('prefix');
		}
		if ($this->input->post('company_name')) {
			$company_name = $this->input->post('company_name');
		}
		if ($this->input->post('suffix')) {
			$suffix = $this->input->post('suffix');
		}
		if ($this->input->post('contact_name')) {
			$contact_name = $this->input->post('contact_name');
		}
		if ($this->input->post('contact_pos')) {
			$contact_pos = $this->input->post('contact_pos');
		}
		if ($this->input->post('contact_phone_no')) {
			$contact_phone_no = $this->input->post('contact_phone_no');
		}
		if ($this->input->post('contact_email')) {
			$contact_email = $this->input->post('contact_email');
		}
		if ($this->input->post('company_type')) {
			$company_type = $this->input->post('company_type');
		}
		$data_update = array(
				"PREFIX" => $prefix,
				"SUFFIX" => $suffix,
				"VENDOR_NAME" => $company_name,
				"CONTACT_NAME" => $contact_name,
				"CONTACT_POS" => $contact_pos,
				"CONTACT_PHONE_NO" => $contact_phone_no,
				"CONTACT_EMAIL" => $contact_email,
			);
		if ($this->session->userdata('STATUS') == "99") {
			$where = array("VENDOR_ID" => $vendor_id, "VND_TRAIL_ID" => 2);
			$this->hist_vnd_header->update($data_update,$where);
		}
		else {
			$where = array("VENDOR_ID" => $vendor_id);
			$this->tmp_vnd_header->update($data_update,$where);
		}
		if ($company_type) {
			if ($this->session->userdata('STATUS') == "99") {
				$this->hist_vnd_company_type->delete($where);
			}
			else {
				$this->tmp_vnd_company_type->delete($where);
			}
			foreach ($company_type as $key => $value) {
				if ($this->session->userdata('STATUS') == "99") {
					$this->hist_vnd_company_type->insert($vendor_id,$value,2);
				}
				else {
					$this->tmp_vnd_company_type->insert($vendor_id,$value);
				}
			}
		}
		echo json_encode('OK');
	}


	function do_remove_general_address($address_id) {
		$this->load->model('tmp_vnd_address');
		if ($this->tmp_vnd_address->delete(array("ADDRESS_ID" => $address_id))) {
			redirect(site_url('Administrative_document/general_data'));
		}
	}

	function do_remove_legal_akta($akta_id) {
		$this->load->model('tmp_vnd_akta');
		if ($this->tmp_vnd_akta->delete(array("AKTA_ID" => $akta_id))) {
			redirect(site_url('Administrative_document/legal_data'));
		}
	}
}
