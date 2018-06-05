<?php
class Menu_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->table = 'APP_MENU';
	}

	public function getMenuByRole($role,$is_vendor)
	{
		$this->db->select_max('MENU_PARENT');
		$this->db->where('MENU_VENDOR',$is_vendor);
		$temp = $this->db->get($this->table)->row();
		$max = intval($temp->MENU_PARENT);
		$menuBar = NULL;
		$parent = $this->getChildMenu(0, $role, $is_vendor);
		foreach ($parent as $value) {
			$menuBar[$value['ID_MENU']] = $value;
			$child = $this->getChildMenu(intval($value['ID_MENU']),$role, $is_vendor);
			if (!empty($child)) {
				$menuBar[$value['ID_MENU']]['child'] = $child;
				foreach ($child as $key => $child2) {
					$child = $this->getChildMenu(intval($child2['ID_MENU']),$role, $is_vendor);
					if (!empty($child)) {
						$menuBar[$value['ID_MENU']]['child'][$key]['child'] = $child;
					}
				}
			}
		}
		return $menuBar;
	}

	function getChildMenu($id_menu, $role,$is_vendor) {
		$this->db->select("$this->table.ID_MENU, NAMA_MENU, MENU_PARENT, CONTROLLER_PATH");
		$this->db->from($this->table);
		if ($is_vendor == 1) {
			$this->db->join('APP_MENU_ROLE_VENDOR', "$this->table.ID_MENU = APP_MENU_ROLE_VENDOR.ID_MENU");
			$this->db->where("STATUS_VENDOR",$role);
		}
		else {
			$this->db->join('APP_MENU_ROLE', "$this->table.ID_MENU = APP_MENU_ROLE.ID_MENU");
			$this->db->where("ID_ROLE",$role);
		}
		$this->db->where("MENU_PARENT",$id_menu);
		$this->db->where('MENU_VENDOR',$is_vendor);
		$this->db->order_by("$this->table.SHOW_ORDER", "ASC");
		$this->db->order_by("$this->table.NAMA_MENU", "ASC");
		return $this->db->get()->result_array();
	}
	
	function getAllMenuByPage($ID_ROLE,$IS_VENDOR) {
		$this->db->select("$this->table.ID_MENU, NAMA_MENU, CONTROLLER_PATH");
		$this->db->from($this->table);
		$this->db->join('APP_GRP_AKSES_MENU', "$this->table.ID_MENU = APP_GRP_AKSES_MENU.APP_MENU_ID");
		$this->db->where("APP_GRP_AKSES_MENU.APP_GRP_MENU_ID",$ID_ROLE);
		$this->db->where('APP_MENU.MENU_VENDOR',$IS_VENDOR);
		return $this->db->get()->result_array();
	}

}
