<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_global extends CI_Model {
	private $tree;
	private $ub='';
	private $bahasa=array();
	
	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function total_row($q) {
		$query = $this->db->query($q);
		return $query->num_rows(); 
	}

	public function grid_view($q) {
		//$this->db->query($q);
		return $this->db->query($q);
	}
	
	public function ajax_combo($sq,$uk) {
		$hasil='';
		if($sq!=''){
			$query = $this->db->query($sq);

			if ($query->num_rows()> 0){
				if(isset($uk) && $uk=='a') 
				{
					$hasil="<option value=''>-Semua-</option>";
				} elseif(isset($uk) && $uk=='p') {
					$hasil="<option value=''>-Pilih-</option>";
				} else {
					$hasil="";
				}

				foreach($query->result_array() as $row) {
					$hasil.="<option value='".$row['ID']."'>".$row['NAMA']."</option>";
				}

			} else {
				$hasil="<option value=''>-Semua-</option>";
			}
		} else {
			$hasil="<option value=''>-Semua-</option>";
		}
		$query->free_result();
		return $hasil;
	}
	 
	public function get_id($id,$tbl) {
		$this->db->select_max($id,'MAX');
		$max = $this->db->get($tbl)->row_array();
		return $max['MAX']+1;
	}
	
	public function insert_custom($nama_tbl,$data) {
		if($this->db->insert($nama_tbl, $data)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
	
	public function update($nama_tbl,$data, $where) {
		foreach ($where as $key => $value) {
			$this->db->where($key, $value);
		}
		if($this->db->update($nama_tbl, $data)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
	
	public function delete($data) {
		$this->db->trans_start();
		foreach ($data as  $value) {
			$this->db->query($value);
		}
		$this->db->trans_complete();
		
		if($this->db->trans_status() === TRUE) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	public function getcombo($sq,$p='el') {
		$data=array();
		if($sq!=''){
			$query = $this->db->query($sq);

			if ($query->num_rows()> 0){
				if($p=='all'){
					$data['0'] = '- ALL -';
				}
				foreach ($query->result_array() as $row)
				{
					$data[$row['ID']] = $row['NAMA'];
				}
			} else {
				$data[]='';
			}
		} else {
			$data[]='';
		}
		return $data;
	}

	public function tglSQL($tgl){
		$t=explode(" ",$tgl);
		$t=explode("-",$t[0]);
		$t=$t[2].'-'.$t[1].'-'.$t[0];
		return $t;
	}

	public function map_tree_map($arr) {
		//param yang harus ada [title sebagai teks child]
		$q = $this->db->query($arr);
		$data=array();
		foreach($q->result_array() as $line){
			$data_tbl=array();
			$data_tbl['id']=$line['ID']; 
			$data_tbl['title']=$line['TITLE'];
			$data_tbl['url']=$line['URL'];
			$data_tbl['nama']=$line['NAMA'];
			$data_tbl['parent_id']=$line['PARENT_ID'];
			//$data_tbl['parent_kode']=$line['PARENT_KODE'];
			$data_tbl['kode']=$line['KODE'];
			$data_tbl['expand']=true;
			$data_tbl['select']=$line['SLC'];
			$data_tbl['aktif']=$line['AKTIF'];
			
			$data[]=$data_tbl;
		}
		//return $this->db->last_query();
		return $data;
	}

	public function mapTree($arr) {
		//param yang harus ada [title sebagai teks child]
		$q = $this->db->query($arr);
		$data=array();
		foreach($q->result_array() as $line){
			$data_tbl=array();
			$data_tbl['id']=$line['ID']; 
			$data_tbl['title']=$line['TITLE'];
			$data_tbl['url']=$line['URL'];
			$data_tbl['nama']=$line['NAMA'];
			$data_tbl['parent_id']=$line['PARENT_ID'];
			$data_tbl['parent_kode']=$line['PARENT_KODE'];
			$data_tbl['kode']=$line['KODE'];
			//$data_tbl['expand']=true;
			$data_tbl['aktif']=$line['AKTIF'];
			
			$data[]=$data_tbl;
		}
		//return $this->db->last_query();
		return $data;
	}

	public function mapTree_unit($arr) {
			//param yang harus ada [title sebagai teks child]
		$q = $this->db->query($arr);
		$data=array();
		foreach($q->result_array() as $line){
			$data_tbl=array();
			$data_tbl['id']=$line['ID']; 
			$data_tbl['title']=$line['TITLE'];
			//$data_tbl['url']=$line['URL'];
			$data_tbl['nama']=$line['NAMA'];
			$data_tbl['parent_id']=$line['PARENT_ID'];
			$data_tbl['isFolder']=true;
			$data_tbl['kode']=$line['KODE'];
			
			$data_tbl['isLazy']=true;
			
			$data[]=$data_tbl;
		}
		return $data;
	}

	public function buildTree(array $elements, $parentId = 0,$checkbox=false) {
		$branch = array();
		foreach ($elements as $element) {

			if($checkbox==true){
				if($element['select']==1){
					$element['select']=true;
				}else{
					$element['select']=false;
				}
			}
			if ($element['parent_id'] == $parentId) {
				$children = $this->buildTree($elements, $element['id'],$checkbox);
				if ($children) {
					$element['children'] = $children;
				}
				$branch[] = $element;
			}
		}
		
		return $branch;
	}

	public function array_view($q) {
		return $this->db->query($q)->result_array();
	}

	public function tampil_header($bhs){
		$this->bahasa=$bhs;
		if (!$this->session->userdata('is_vendor')) {
			$q="SELECT m1.ID_MENU ID,m1.CONTROLLER_PATH AS URL,m1.MENU_PARENT PARENT_ID,m1.NAMA_MENU NAMA,
			m1.KODE_MENU KODE, m1.aktif_menu AKTIF 	FROM APP_MENU m1 INNER JOIN APP_GRP_AKSES_MENU ON  m1.ID_MENU=APP_GRP_AKSES_MENU.APP_MENU_ID
			WHERE  APP_GRP_AKSES_MENU.APP_GRP_MENU_ID='". $this->session->userdata('GROUP_MENU')."' ORDER BY m1.KODE_MENU ASC ";
		}
		else {
			$q="SELECT m1.ID_MENU ID,m1.CONTROLLER_PATH AS URL,m1.MENU_PARENT PARENT_ID,m1.NAMA_MENU NAMA,
			m1.KODE_MENU KODE, m1.aktif_menu AKTIF 	FROM APP_MENU m1 INNER JOIN APP_MENU_ROLE_VENDOR ON  m1.ID_MENU=APP_MENU_ROLE_VENDOR.ID_MENU
			WHERE m1.aktif_menu = 1 AND APP_MENU_ROLE_VENDOR.STATUS_VENDOR='". $this->session->userdata('STATUS')."' ORDER BY m1.SHOW_ORDER ASC, m1.NAMA_MENU ASC ";
		}

		$q1= $this->array_view($q);
		$q2= $this->map_menu($q1);
		// var_dump($this->session->all_userdata());;
		return $this->display_tree_menu($q2);
	}

	public function map_menu(array $elements, $parentId = 0) {
		$tree = array();
		foreach ($elements as $element) {
			if ($element['PARENT_ID'] == $parentId) {
				$children = $this->map_menu($elements, $element['ID']);
				if ($children) {
					$element['CHILDREN'] = $children;
				}
				$tree[] = $element;
			}
		}
		return $tree;
	}

	public function display_tree_menu($nodes, $indent=1) {
		//if ($indent >= 20) return;	// Stop at 20 sub levels
		if($indent==0){
			$this->ub.= "<ul >";
		}
		foreach ($nodes as $node) {

			if (isset($node['CHILDREN'])){
				//if($indent==0){
				$this->ub.= "<li class='normal_menu'>";
				$this->ub.= "<a href='#!' ><span>".$this->bahasa[$node['NAMA']]."</span></a>";
				$this->display_tree_menu($node['CHILDREN'],0);
			} else {
				$this->ub.= "<li class='normal_menu'>";
				$this->ub.= "<a href=".site_url($node['URL'])."><span>".$this->bahasa[$node['NAMA']]."</span></a>";
				$this->ub.= "</li>";
			}
		}
		if($indent==0){
			$this->ub.= "</ul>";
		}

		return  $this->ub; 
	}

	public function company_group($em_id) {
		$sql="SELECT ADM_COMPANY.COMPANYID,ADM_COMPANY.COMPANYNAME FROM ADM_COMPANY WHERE COMPANYID IN(SELECT ADM_PURCH_GRP.COMPANY_ID FROM ADM_PURCH_GRP WHERE ADM_PURCH_GRP.KEL_PURCH_GRP='".$em_id."' GROUP BY ADM_PURCH_GRP.COMPANY_ID) ORDER BY ADM_COMPANY.COMPANYID DESC";
		$result = $this->db->query($sql);
		$jml=$result->num_rows();
		$ii=1;
		if ($jml > 0) {
			$hasil = '';
			foreach($result->result_array() as $ub){
				if($ii==$jml){
					$hasil.="'".$ub['COMPANYID']."'";	
				}else{
					$hasil.="'".$ub['COMPANYID']."',";	
				}
				$ii++;
			}
		} else {
			$hasil="''";
		}
		return $hasil;
	}

}