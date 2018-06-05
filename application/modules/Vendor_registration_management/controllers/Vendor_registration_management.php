<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_registration_management extends CI_Controller {


	public function __construct()
	{

		parent::__construct();
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->model(array('vnd_reg_announcement','adm_company','adm_vendor_registration_news'));
	}

	public function index()
	{
		redirect(base_url());
	}

	/**
	 * Start Vendor Registration Manajemen
	 */

	public function registration_date($companyid = NULL)
	{
		// $this->authorization->roleCheck();
		$data['title'] = "Vendor Registration Master Data";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/vendor_registraion_management.js');
		// $this->layout->add_js(base_url().'Assets/Vendor_registration_management/assets/vendor_registraion_management.js', TRUE);
		$this->layout->render('registration_date_list',$data);
	}

	public function update_registration_date($companyid = NULL)
	{
		if ($companyid) {
			$data['title'] = "Update Current Vendor Registration";
			$registration_date = $this->vnd_reg_announcement->with('company')->as_array()->get(array("COMPANYID" => $companyid));
			$data['registration_date']  = $registration_date;
			$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
			$this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
			$this->layout->add_js('pages/vendor_registraion_management.js');
			// $this->layout->add_js(base_url().'Assets/Vendor_registration_management/assets/vendor_registraion_management.js', TRUE);
			$this->layout->render('registration_date_form',$data);
		}
		else {
			redirect(site_url('Vendor_registration_management/registration_date'));
		}
	}

	public function delete_registration_date($companyid = NULL)
	{
		if ($companyid) {
			$registration_dates = $this->vnd_reg_announcement->get(array("ID" => $companyid));
			$new_registration_date  = $registration_dates[0];
			$this->vnd_reg_announcement->delete(array("ID" => $companyid));
			$this->session->set_flashdata('success', "Vendor Registration <strong>".$new_registration_date["registration_date_NAME"]."</strong> deleted");
		}
		redirect(site_url('Vendor_registration_management/del_point'));
	}

	function get_registration_date()
	{
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$opco = $this->session->userdata['EM_COMPANY'];

		if ($opco == '7000' || $opco == '2000' || $opco == '5000') {
			$whereopco = array(7000,2000,5000);
		} else {
			$whereopco = $opco;
		}


		$datatable = $this->vnd_reg_announcement->with('company')->as_array()->where("COMPANYID",$whereopco)->get_all('',$limit,$offset);
		$recordsFiltered = $this->vnd_reg_announcement->count();
		$get_total_data_without_filter = $this->vnd_reg_announcement->count();
		$data = array('data' => $datatable, "recordsTotal"=> $recordsFiltered, "recordsFiltered"=> $get_total_data_without_filter);
		echo json_encode($data);
	}

	function do_update_registration_date($companyid = NULL)
	{
		if ($companyid) {
			$new_registration_date = array('OPEN_REG' => vendortodate($this->input->post('OPEN_REG')), 'CLOSE_REG' => vendortodate($this->input->post('CLOSE_REG')));
			if ($this->vnd_reg_announcement->update($new_registration_date,array("COMPANYID" => $companyid))) {
				$this->session->set_flashdata('success', "Vendor Registration Date updated");
				redirect(site_url("Vendor_registration_management/update_registration_date/$companyid"));
			}
			else {
				redirect(site_url("Vendor_registration_management/update_registration_date/$companyid"));
			}
		}
		else {
			redirect(site_url('Vendor_registration_management/create_registration_date'));
		}
	}

	public function vendor_registration_news()
	{
		$data['title'] = "Vendor Registration News";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/vendor_registraion_management.js');
		// $this->layout->add_js(base_url().'Assets/Vendor_registration_management/assets/vendor_registraion_management.js', TRUE);
		$this->layout->render('vendor_registration_news_list',$data);
	}

	public function create_vendor_registration_news()
	{
		$this->load->model('adm_district');
		$data['title'] = "Create New Vendor News";
		$this->layout->add_css('plugins/trumbowyg/trumbowyg.css');
		$this->layout->add_js('plugins/trumbowyg/trumbowyg.js');
		$this->layout->add_js('pages/vendor_registraion_management.js');
		// $this->layout->add_js(base_url().'Assets/Vendor_registration_management/assets/vendor_registraion_management.js', TRUE);
		$this->layout->render('vendor_news_form',$data);
	}

	function get_vendor_registration_news()
	{
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$datatable = $this->adm_vendor_registration_news->get('',$limit,$offset);
		$recordsFiltered = $this->adm_vendor_registration_news->get_total_data();
		$get_total_data_without_filter = $this->adm_vendor_registration_news->get_total_data();
		$data = array('data' => $datatable, "recordsTotal"=> $recordsFiltered, "recordsFiltered"=> $get_total_data_without_filter);
		echo json_encode($data);
	}

	function do_create_vendor_news()
	{
		$new_vendor_registration_news = $this->input->post();
		$new_vendor_registration_news['ADM_NEWS_ID'] = $this->adm_vendor_registration_news->get_id();
		if ($this->adm_vendor_registration_news->insert_custom($new_vendor_registration_news)) {
			$this->session->set_flashdata('success', "Vendor Registration News <strong>".$new_vendor_registration_news["NEWS_TITLE"]."</strong> created");
			redirect(site_url('Vendor_registration_management/create_vendor_registration_news'));
		}
		else {
			redirect(site_url('Vendor_registration_management/create_vendor_registration_news'));
		}
	}

	function do_update_vendor_registration_news($companyid = NULL)
	{
		if ($companyid) {
			$new_vendor_registration_news = $this->input->post();
			if ($this->adm_vendor_registration_news->update($new_vendor_registration_news,array("COMPANYID" => $companyid))) {
				$this->session->set_flashdata('success', "Vendor Registration Date <strong>".$new_vendor_registration_news["vendor_registration_news_NAME"]."</strong> updated");
				redirect(site_url("Vendor_registration_management/update_vendor_registration_news/$companyid"));
			}
			else {
				redirect(site_url("Vendor_registration_management/update_vendor_registration_news/$companyid"));
			}
		}
		else {
			redirect(site_url('Vendor_registration_management/create_vendor_registration_news'));
		}
	}
}