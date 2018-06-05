<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_data extends CI_Controller {


	public function __construct()
	{

		parent::__construct();

		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->model(array('adm_dept','adm_del_point','adm_district','adm_curr','adm_employee_type','adm_salutation'));
	}

	public function index()
	{
		redirect(base_url());
	}

	/**
	 * Start Department Manajemen
	 */

	public function department($dept_id = NULL)
	{
		$this->authorization->roleCheck();
		$data['title'] = "Department Master Data";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/master_data.js');
		$this->layout->render('department_list',$data);
	}

	public function create_department()
	{
		$this->load->model('adm_district');
		$data['title'] = "Create New Department";
		$data['district'] = $this->adm_district->get();
		$data['department'] = NULL;
		$this->layout->render('department_form',$data);
	}

	public function update_department($dept_id = NULL)
	{
		if ($dept_id) {
			$this->load->model('adm_district');
			$data['title'] = "Update Current Department";
			$data['district'] = $this->adm_district->get();
			$departments = $this->adm_dept->get(array("DEPT_ID" => $dept_id));
			$data['department']  = $departments[0];
			$this->layout->render('department_form',$data);
		}
		else {
			redirect(site_url('Master_data/department'));
		}
	}

	public function delete_department($dept_id = NULL)
	{
		if ($dept_id) {
			$departments = $this->adm_dept->get(array("DEPT_ID" => $dept_id));
			$new_department  = $departments[0];
			$this->adm_dept->delete(array("DEPT_ID" => $dept_id));
			$this->session->set_flashdata('success', "Department <strong>".$new_department["DEPT_NAME"]."</strong> deleted");
		}
		redirect(site_url('Master_data/del_point'));
	}

	function get_department()
	{
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$datatable = $this->adm_dept->get('',$limit,$offset);
		$recordsFiltered = $this->adm_dept->get_total_data();
		$get_total_data_without_filter = $this->adm_dept->get_total_data();
		$data = array('data' => $datatable, "recordsTotal"=> $recordsFiltered, "recordsFiltered"=> $get_total_data_without_filter);
		echo json_encode($data);
	}

	function do_update_department($dept_id = NULL)
	{
		if ($dept_id) {
			$new_department = $this->input->post();
			$district = explode("-", $new_department['DISTRICT']);
			$new_department['DISTRICT_ID'] = $district[0];
			$new_department['DISTRICT_NAME'] = $district[1];
			unset($new_department['DISTRICT']);
			if ($this->adm_dept->update($new_department,array("DEPT_ID" => $dept_id))) {
				$this->session->set_flashdata('success', "Department <strong>".$new_department["DEPT_NAME"]."</strong> updated");
				redirect(site_url("Master_data/update_department/$dept_id"));
			}
			else {
				redirect(site_url("Master_data/update_department/$dept_id"));
			}
		}
		else {
			redirect(site_url('Master_data/create_department'));
		}

	}

	function do_create_department()
	{
		$new_department = $this->input->post();
		$district = explode("-", $new_department['DISTRICT']);
		$new_department['DEPT_ID'] = $this->adm_dept->get_id();
		$new_department['DISTRICT_ID'] = $district[0];
		$new_department['DISTRICT_NAME'] = $district[1];
		unset($new_department['DISTRICT']);
		if ($this->adm_dept->insert_custom($new_department)) {
			$this->session->set_flashdata('success', "Department <strong>".$new_department["DEPT_NAME"]."</strong> created");
			redirect(site_url('Master_data/create_department'));
		}
		else {
			redirect(site_url('Master_data/create_department'));
		}

	}

	/**
	 * Start Delivery Point
	 */
	
	public function del_point($del_point_id = NULL)
	{
		$this->authorization->roleCheck();
		$data['title'] = "Delivery Point Master Data";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/master_data.js');
		$this->layout->render('del_point_list',$data);
	}

	public function create_del_point()
	{
		$this->load->model('adm_plant');
		$data['title'] = "Create New Delivery Point";
		$data['plant'] = $this->adm_plant->get();
		$data['del_point'] = NULL;
		$this->layout->render('del_point_form',$data);
	}

	public function update_del_point($del_point_id = NULL)
	{
		if ($del_point_id) {
			$this->load->model('adm_plant');
			$data['title'] = "Update Current Delivery Point";
			$data['plant'] = $this->adm_plant->get();
			$del_point = $this->adm_del_point->get(array("DEL_POINT_ID" => $del_point_id));
			$data['del_point']  = $del_point[0];
			$this->layout->render('del_point_form',$data);
		}
		else {
			redirect(site_url('Master_data/del_point'));
		}
	}

	public function delete_del_point($del_point_id = NULL)
	{
		if ($del_point_id) {
			$del_points = $this->adm_del_point->get(array("DEL_POINT_ID" => $del_point_id));
			$new_del_point  = $del_points[0];
			$this->adm_del_point->delete(array("DEL_POINT_ID" => $del_point_id));
			$this->session->set_flashdata('success', "Delivery Point <strong>".$new_del_point["DEL_POINT_NAME"]."</strong> deleted");
		}
		redirect(site_url('Master_data/del_point'));
	}

	function get_del_point()
	{
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$datatable = $this->adm_del_point->get('',$limit,$offset);
		$recordsFiltered = $this->adm_del_point->get_total_data();
		$get_total_data_without_filter = $this->adm_del_point->get_total_data();
		$data = array('data' => $datatable, "recordsTotal"=> $recordsFiltered, "recordsFiltered"=> $get_total_data_without_filter);
		echo json_encode($data);
	}

	function do_update_del_point($del_point_id = NULL)
	{
		if ($del_point_id) {
			$new_del_point = $this->input->post();
			if ($this->adm_del_point->update($new_del_point,array("DEL_POINT_ID" => $del_point_id))) {
				$this->session->set_flashdata('success', "Delivery Point <strong>".$new_del_point["DEL_POINT_NAME"]."</strong> updated");
				redirect(site_url("Master_data/update_del_point/$del_point_id"));
			}
			else {
				redirect(site_url("Master_data/update_del_point/$del_point_id"));
			}
		}
		else {
			redirect(site_url('Master_data/create_del_point'));
		}

	}

	function do_create_del_point()
	{
		$new_del_point = $this->input->post();
		if ($this->adm_del_point->insert_custom($new_del_point)) {
			$this->session->set_flashdata('success', "Delivery Point <strong>".$new_del_point["DEL_POINT_NAME"]."</strong> created");
			redirect(site_url('Master_data/create_del_point'));
		}
		else {
			redirect(site_url('Master_data/create_del_point'));
		}

	}

	/**
	 * Start Kantor / District
	 */
	
	public function district($district_id = NULL)
	{
		$this->authorization->roleCheck();
		$data['title'] = "District Master Data";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/master_data.js');
		$this->layout->render('district_list',$data);
	}

	public function create_district()
	{
		$this->load->model('adm_company');
		$data['title'] = "Create New District";
		$data['company'] = $this->adm_company->get();
		$data['district'] = NULL;
		$this->layout->render('district_form',$data);
	}

	public function update_district($district_id = NULL)
	{
		if ($district_id) {
			$this->load->model('adm_company');
			$data['title'] = "Update Current District";
			$data['company'] = $this->adm_company->get();
			$district = $this->adm_district->get(array("DISTRICT_ID" => $district_id));
			$data['district']  = $district[0];
			$this->layout->render('district_form',$data);
		}
		else {
			redirect(site_url('Master_data/district'));
		}
	}

	public function delete_district($district_id = NULL)
	{
		if ($district_id) {
			$districts = $this->adm_district->get(array("DISTRICT_ID" => $district_id));
			$new_district  = $districts[0];
			$this->adm_district->delete(array("DISTRICT_ID" => $district_id));
			$this->session->set_flashdata('success', "District <strong>".$new_district["DISTRICT_NAME"]."</strong> deleted");
		}
		redirect(site_url('Master_data/district'));
	}

	function get_district()
	{
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$datatable = $this->adm_district->get('',$limit,$offset);
		$recordsFiltered = $this->adm_district->get_total_data();
		$get_total_data_without_filter = $this->adm_district->get_total_data();
		$data = array('data' => $datatable, "recordsTotal"=> $recordsFiltered, "recordsFiltered"=> $get_total_data_without_filter);
		echo json_encode($data);
	}

	function do_update_district($district_id = NULL)
	{
		if ($district_id) {
			$new_district = $this->input->post();
			if ($this->adm_district->update($new_district,array("DISTRICT_ID" => $district_id))) {
				$this->session->set_flashdata('success', "District <strong>".$new_district["DISTRICT_NAME"]."</strong> updated");
				redirect(site_url("Master_data/update_district/$district_id"));
			}
			else {
				redirect(site_url("Master_data/update_district/$district_id"));
			}
		}
		else {
			redirect(site_url('Master_data/create_district'));
		}

	}

	function do_create_district()
	{
		$new_district = $this->input->post();
		$new_district['DISTRICT_ID'] = $this->adm_district->get_id();
		if ($this->adm_district->insert_custom($new_district)) {
			$this->session->set_flashdata('success', "District <strong>".$new_district["DISTRICT_NAME"]."</strong> created");
			redirect(site_url('Master_data/create_district'));
		}
		else {
			redirect(site_url('Master_data/create_district'));
		}
	}

	/**
	 * Start Currency
	 */
	
	public function currency($currency_id = NULL)
	{
		$this->authorization->roleCheck();
		$data['title'] = "Currency Master Data";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/master_data.js');
		$this->layout->render('currency_list',$data);
	}

	public function create_currency()
	{
		$this->load->model('adm_company');
		$data['title'] = "Create New Currency";
		$data['currency'] = NULL;
		$this->layout->render('currency_form',$data);
	}

	public function update_currency($currency_id = NULL)
	{
		if ($currency_id) {
			$this->load->model('adm_company');
			$data['title'] = "Update Current Currency";
			$currency = $this->adm_curr->get(array("CURR_ID" => $currency_id));
			$data['currency']  = $currency[0];
			$this->layout->render('currency_form',$data);
		}
		else {
			redirect(site_url('Master_data/currency'));
		}
	}

	public function delete_currency($currency_id = NULL)
	{
		if ($currency_id) {
			$currencys = $this->adm_curr->get(array("CURR_ID" => $currency_id));
			$new_currency  = $currencys[0];
			$this->adm_curr->delete(array("CURR_ID" => $currency_id));
			$this->session->set_flashdata('success', "Currency <strong>".$new_currency["CURR_NAME"]."</strong> deleted");
		}
		redirect(site_url('Master_data/currency'));
	}

	function get_currency()
	{
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$datatable = $this->adm_curr->get('',$limit,$offset);
		$recordsFiltered = $this->adm_curr->get_total_data();
		$get_total_data_without_filter = $this->adm_curr->get_total_data();
		$data = array('data' => $datatable, "recordsTotal"=> $recordsFiltered, "recordsFiltered"=> $get_total_data_without_filter);
		echo json_encode($data);
	}

	function do_update_currency($currency_id = NULL)
	{
		if ($currency_id) {
			$new_currency = $this->input->post();
			if ($this->adm_curr->update($new_currency,array("CURR_ID" => $currency_id))) {
				$this->session->set_flashdata('success', "Currency <strong>".$new_currency["CURR_NAME"]."</strong> updated");
				redirect(site_url("Master_data/update_currency/$currency_id"));
			}
			else {
				redirect(site_url("Master_data/update_currency/$currency_id"));
			}
		}
		else {
			redirect(site_url('Master_data/create_currency'));
		}

	}

	function do_create_currency()
	{
		$new_currency = $this->input->post();
		$new_currency['CURR_ID'] = $this->adm_curr->get_id();
		if ($this->adm_curr->insert_custom($new_currency)) {
			$this->session->set_flashdata('success', "Currency <strong>".$new_currency["CURR_NAME"]."</strong> created");
			redirect(site_url('Master_data/create_currency'));
		}
		else {
			redirect(site_url('Master_data/create_currency'));
		}
	}

	/**
	 * Start Employee Type
	 */
	
	public function employee_type($employee_type_id = NULL)
	{
		$this->authorization->roleCheck();
		$data['title'] = "Employee Type Master Data";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/master_data.js');
		$this->layout->render('employee_type_list',$data);
	}

	public function create_employee_type()
	{
		$this->load->model('adm_company');
		$data['title'] = "Create New Employee Type";
		$data['employee_type'] = NULL;
		$this->layout->render('employee_type_form',$data);
	}

	public function update_employee_type($employee_type_id = NULL)
	{
		if ($employee_type_id) {
			$this->load->model('adm_company');
			$data['title'] = "Update Current Employee Type";
			$employee_type = $this->adm_employee_type->get(array("EMPLOYEE_TYPE_ID" => $employee_type_id));
			$data['employee_type']  = $employee_type[0];
			$this->layout->render('employee_type_form',$data);
		}
		else {
			redirect(site_url('Master_data/employee_type'));
		}
	}

	public function delete_employee_type($employee_type_id = NULL)
	{
		if ($employee_type_id) {
			$employee_types = $this->adm_employee_type->get(array("EMPLOYEE_TYPE_ID" => $employee_type_id));
			$new_employee_type  = $employee_types[0];
			$this->adm_employee_type->delete(array("EMPLOYEE_TYPE_ID" => $employee_type_id));
			$this->session->set_flashdata('success', "Employee Type <strong>".$new_employee_type["EMPLOYEE_TYPE_NAME"]."</strong> deleted");
		}
		redirect(site_url('Master_data/employee_type'));
	}

	function get_employee_type()
	{
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$datatable = $this->adm_employee_type->get('',$limit,$offset);
		$recordsFiltered = $this->adm_employee_type->get_total_data();
		$get_total_data_without_filter = $this->adm_employee_type->get_total_data();
		$data = array('data' => $datatable, "recordsTotal"=> $recordsFiltered, "recordsFiltered"=> $get_total_data_without_filter);
		echo json_encode($data);
	}

	function do_update_employee_type($employee_type_id = NULL)
	{
		if ($employee_type_id) {
			$new_employee_type = $this->input->post();
			if ($this->adm_employee_type->update($new_employee_type,array("EMPLOYEE_TYPE_ID" => $employee_type_id))) {
				$this->session->set_flashdata('success', "Employee Type <strong>".$new_employee_type["EMPLOYEE_TYPE_NAME"]."</strong> updated");
				redirect(site_url("Master_data/update_employee_type/$employee_type_id"));
			}
			else {
				redirect(site_url("Master_data/update_employee_type/$employee_type_id"));
			}
		}
		else {
			redirect(site_url('Master_data/create_employee_type'));
		}

	}

	function do_create_employee_type()
	{
		$new_employee_type = $this->input->post();
		$new_employee_type['EMPLOYEE_TYPE_ID'] = $this->adm_employee_type->get_id();
		if ($this->adm_employee_type->insert_custom($new_employee_type)) {
			$this->session->set_flashdata('success', "Employee Type <strong>".$new_employee_type["EMPLOYEE_TYPE_NAME"]."</strong> created");
			redirect(site_url('Master_data/create_employee_type'));
		}
		else {
			redirect(site_url('Master_data/create_employee_type'));
		}
	}

	/**
	 * Start Salutation
	 */
	
	public function salutation($salutation_id = NULL)
	{
		$this->authorization->roleCheck();
		$data['title'] = "Salutation Master Data";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/master_data.js');
		$this->layout->render('salutation_list',$data);
	}

	public function create_salutation()
	{
		$this->load->model('adm_company');
		$data['title'] = "Create New Salutation";
		$data['salutation'] = NULL;
		$this->layout->render('salutation_form',$data);
	}

	public function update_salutation($salutation_id = NULL)
	{
		if ($salutation_id) {
			$this->load->model('adm_company');
			$data['title'] = "Update Current Salutation";
			$salutation = $this->adm_salutation->get(array("ADM_SALUTATION_ID" => $salutation_id));
			$data['salutation']  = $salutation[0];
			$this->layout->render('salutation_form',$data);
		}
		else {
			redirect(site_url('Master_data/salutation'));
		}
	}

	public function delete_salutation($salutation_id = NULL)
	{
		if ($salutation_id) {
			$salutations = $this->adm_salutation->get(array("ADM_SALUTATION_ID" => $salutation_id));
			$new_salutation  = $salutations[0];
			$this->adm_salutation->delete(array("ADM_SALUTATION_ID" => $salutation_id));
			$this->session->set_flashdata('success', "Salutation <strong>".$new_salutation["ADM_SALUTATION_NAME"]."</strong> deleted");
		}
		redirect(site_url('Master_data/salutation'));
	}

	function get_salutation()
	{
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$datatable = $this->adm_salutation->get('',$limit,$offset);
		$recordsFiltered = $this->adm_salutation->get_total_data();
		$get_total_data_without_filter = $this->adm_salutation->get_total_data();
		$data = array('data' => $datatable, "recordsTotal"=> $recordsFiltered, "recordsFiltered"=> $get_total_data_without_filter);
		echo json_encode($data);
	}

	function do_update_salutation($salutation_id = NULL)
	{
		if ($salutation_id) {
			$new_salutation = $this->input->post();
			if ($this->adm_salutation->update($new_salutation,array("ADM_SALUTATION_ID" => $salutation_id))) {
				$this->session->set_flashdata('success', "Salutation <strong>".$new_salutation["ADM_SALUTATION_NAME"]."</strong> updated");
				redirect(site_url("Master_data/update_salutation/$salutation_id"));
			}
			else {
				redirect(site_url("Master_data/update_salutation/$salutation_id"));
			}
		}
		else {
			redirect(site_url('Master_data/create_salutation'));
		}

	}

	function do_create_salutation()
	{
		$new_salutation = $this->input->post();
		$new_salutation['ADM_SALUTATION_ID'] = $this->adm_salutation->get_id();
		if ($this->adm_salutation->insert_custom($new_salutation)) {
			$this->session->set_flashdata('success', "Salutation <strong>".$new_salutation["ADM_SALUTATION_NAME"]."</strong> created");
			redirect(site_url('Master_data/create_salutation'));
		}
		else {
			redirect(site_url('Master_data/create_salutation'));
		}
	}

}