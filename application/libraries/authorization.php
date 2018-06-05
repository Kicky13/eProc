<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authorization
{
	private $menu_role;

	function __construct() {
		$this->ci = &get_instance();
		$this->ci->load->model(array('user_model'));
		$this->isLoggedIn();
		$this->setMenuRole();
	}

	function setMenuRole() {
		$this->ci->load->model('menu_model');
		if ($this->ci->session->userdata('is_vendor')) {
			$this->menu_role = $this->ci->menu_model->getAllMenuByPage($this->ci->session->userdata('STATUS'),1);
		}
		else {
			$this->menu_role = $this->ci->menu_model->getAllMenuByPage($this->ci->session->userdata('GROUP_MENU'),0);
		}
	}

	function isLoggedIn() {
		if (!$this->ci->session->userdata('logged_in')) {
			$url = base_url()."Login";
			redirect($url);
		}
	}

	function userValid($username, $password) {
		$result = $this->ci->user->getUser($username, $password);
		if (!empty($result)) {
			return $result[0];
		}
		else {
			return FALSE;
		}
	}

	function roleCheck() {
		$current_uri = $this->ci->uri->slash_segment(1).$this->ci->uri->segment(2);
		// print_r($this->menu_role); exit();
		$found = FALSE;
		foreach ($this->menu_role as $key => $value) {
			if (array_search($current_uri,$value)) {
				$found = TRUE;
			}
		}
		if (!$found) {
			redirect(base_url());
		}
	}

	function getCurrentRole() {
		return $this->ci->session->userdata('POS_NAME');
	}

	function getCurrentPosition()
	{
		$result = $this->ci->user_model->getPositionById($this->ci->session->userdata('ID'));
		foreach ($result as $key => $value) {
			$role[] = intval($value['POS_ID']);
		}
		return $role;
	}

	public function getCompanyId()
	{
		return $this->ci->session->userdata('COMPANYID');
	}

	public function getDistrictId()
	{
		return $this->ci->session->userdata('DISTRICT_ID');
	}

	public function getPositionId()
	{
		return $this->ci->session->userdata('POS_ID');
	}

	public function getCurrentName() {
		return $this->ci->session->userdata('FULLNAME');
	}

	public function getEmployeeId() {
		return $this->ci->session->userdata('ID');
	}

	public function getVendorId()
	{
		return $this->ci->session->userdata('VENDOR_ID');
	}
}
