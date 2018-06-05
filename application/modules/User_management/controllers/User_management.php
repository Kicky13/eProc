<?php defined('BASEPATH') OR exit('No direct script access allowed');

// from last commit by me f692a0c
class User_management extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->model(array('adm_employee','app_process','adm_company'));
	}

	public function index() {
		redirect(base_url());
	}

	/**
	 * Start Employee Manajemen
	 */
	public function employee($employee_id = NULL) {
		// $this->authorization->roleCheck();
		$data['title'] = "Employee Master Data";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/user_management.js');
		$this->layout->render('employee_list',$data);
	}

	public function create_employee() {
		$this->load->model(array('adm_employee_type','adm_salutation','adm_country','adm_dept'));
		$data['title'] = "Create New Employee";
		$data['employee'] = NULL;
		$data['employee_type'] = $this->adm_employee_type->get();
		$data['salutation'] = $this->adm_salutation->get();
		$data['country'] = $this->adm_country->get();
		$data['dept'] = $this->adm_dept->get(array('DISTRICT_ID' => $this->authorization->getDistrictId()));
		$this->layout->add_css('flat-toggle.css');
		$this->layout->add_js('pages/user_management.js');
		$this->layout->render('employee_form',$data);
	}

	public function update_employee($employee_id = NULL) {
		if ($employee_id) {
			$this->load->model(array('adm_employee_type','adm_salutation','adm_country','adm_dept','adm_employee_pos'));
			$data['title'] = "Update Current Employee";
			$data['employee_type'] = $this->adm_employee_type->get();
			$data['salutation'] = $this->adm_salutation->get();
			$data['country'] = $this->adm_country->get();
			$data['dept'] = $this->adm_dept->get();
			$employees = $this->adm_employee->get(array("ID" => $employee_id));
			$data['employee']  = $employees[0];
			$data['employee_pos'] = $this->adm_employee_pos->get(array("POS_ID" => $data['employee']["ADM_POS_ID"]));
			$this->layout->add_css('flat-toggle.css');
			$this->layout->add_js('pages/user_management.js');
			$this->layout->render('employee_form',$data);
		}
		else {
			redirect(site_url('User_management/employee'));
		}
	}

	public function delete_employee($employee_id = NULL) {
		if ($employee_id) {
			$employees = $this->adm_employee->get(array("ID" => $employee_id));
			$new_employee  = $employees[0];
			$this->adm_employee->delete(array("ID" => $employee_id));
			$this->session->set_flashdata('success', "Employee <strong>".$new_employee["EMPLOYEE_NAME"]."</strong> deleted");
		}
		redirect(site_url('User_management/del_point'));
	}

	public function get_employee() {
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$datatable = $this->adm_employee->get('',$limit,$offset);
		$recordsFiltered = $this->adm_employee->get_total_data();
		$get_total_data_without_filter = $this->adm_employee->get_total_data();
		$data = array('data' => $datatable, "recordsTotal"=> $recordsFiltered, "recordsFiltered"=> $get_total_data_without_filter);
		echo json_encode($data);
	}

	public function do_update_employee($employee_id = NULL) {
		if ($employee_id) {
			$new_employee = $this->input->post();
			$district = explode("-", $new_employee['DISTRICT']);
			$new_employee['DISTRICT_ID'] = $district[0];
			$new_employee['DISTRICT_NAME'] = $district[1];
			unset($new_employee['DISTRICT']);
			if ($this->adm_employee->update($new_employee,array("ID" => $employee_id))) {
				$this->session->set_flashdata('success', "Employee <strong>".$new_employee["EMPLOYEE_NAME"]."</strong> updated");
				redirect(site_url("User_management/update_employee/$employee_id"));
			}
			else {
				redirect(site_url("User_management/update_employee/$employee_id"));
			}
		}
		else {
			redirect(site_url('User_management/create_employee'));
		}
	}

	public function do_create_employee() {
		$new_employee = $this->input->post();
		$new_employee['ID'] = $this->adm_employee->get_id();
		unset($new_employee['DEPT']);
		if ($this->adm_employee->insert_custom($new_employee)) {
			$this->session->set_flashdata('success', "Employee <strong>".$new_employee["FULLNAME"]."</strong> created");
			redirect(site_url('User_management/create_employee'));
		}
		else {
			redirect(site_url('User_management/create_employee'));
		}
	}

	public function do_get_position() {
		$this->load->model('adm_pos');
		$dept = explode("-",$this->input->post('DEPT'));
		$where = array('DEPT_ID' => $dept[0]);
		$position = $this->adm_pos->get($where);
		echo json_encode($position);
	}

	public function approval_setting($company_id = NULL) {
		// $this->authorization->roleCheck();
		$data['title'] = "Pengaturan Approval Pratender";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->add_js('pages/user_management.js');
		$this->layout->render('approval_setting_list',$data);
	}

	public function update_approval_setting($company_id = NULL) {
		if ($company_id) {
			$this->load->model(array('adm_company','adm_dept'));
			$data['title'] = "Update Current Approval Setting";
			$data['dept'] = $this->adm_dept->getByCompanyId($company_id);
			$company = $this->adm_company->get(array('COMPANYID' => $company_id));
			$data['approval_setting'] = $company[0];
			$this->layout->set_table_js();
			$this->layout->add_js('pages/user_management.js');
			$this->layout->render('approval_setting_form',$data);
		}
		else {
			redirect(site_url('User_management/approval_setting'));
		}
	}

	public function get_approval_setting() {
		$datatable = $this->app_process->getApprovalSetting();
		$data = array('data' => $datatable);
		echo json_encode($data);
	}

	public function get_approval_setting_detail() {
		$data = $this->app_process->getApprovalSettingDetail();
		echo json_encode($data);
	}

	public function do_update_approval_setting($company_id = NULL) {
		if ($company_id) {
			$company_id = intval($company_id);
			$company_process1 = $this->app_process->get(array("COMPANYID" => $this->input->post('COMPANYID'),"PROCESS_MASTER_ID" => 2));
			$max_company_process1_id = intval(count($company_process1)) - 1;
			$next_process = $company_process1[$max_company_process1_id]["NEXT_PROCESS"];
			$new_role = $this->input->post("ROLE");
			$this->app_process->delete(array("PROCESS_MASTER_ID" => 3));
			foreach ($new_role as $key => $value) {
				$new_id = $this->app_process->get_id();
				$this->app_process->insert($new_id,'',3,$value,$next_process+1,$next_process-1,$next_process,$company_id);
				$next_process++;
			}
			$company_process2 = $this->app_process->get(array("COMPANYID" => $this->input->post('COMPANYID'),"PROCESS_MASTER_ID >" => 3));
			foreach ($company_process2 as $key => $value) {
				$this->app_process->update(array("NEXT_PROCESS" => $next_process+1, "PREVIOUS_PROCESS" => $next_process-1, "CURRENT_PROCESS" => $next_process), array("PROCESS_ID" => $value["PROCESS_ID"]));
				if ($key != intval(count($company_process1)) and $company_process2[$key+1]["PROCESS_MASTER_ID"] != $company_process2[$key]["PROCESS_MASTER_ID"]) {
					$next_process++;
				}
			}
			$company_details = $this->adm_company->get(array("COMPANYID" => $company_id));
			$company_detail = $company_details[0];
			$this->session->set_flashdata('success', "Approval Setting <strong>".$company_detail["COMPANYNAME"]."</strong> updated");
			redirect(site_url("User_management/update_approval_setting/$company_id"));
		}
		else {
			redirect(site_url('User_management/approval_setting'));
		}

	}
}