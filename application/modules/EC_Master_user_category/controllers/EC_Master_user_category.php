<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Master_user_category extends CI_Controller {

	private $USER;

	public function __construct() {
		parent::__construct();
		$this -> load -> library('Authorization');
		$this -> load -> helper('url');
		$this -> load -> library('Layout');
		$this -> load -> helper("security");
		$this -> USER = explode("@", $this -> session -> userdata['EMAIL']);
		$this->load->model('ec_master_user_category_m');
	}

	public function index($cheat = false) {
		$data['title'] = "Master User Akses Category";
		$data['cheat'] = $cheat;
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout ->set_tree_css();
		$this -> layout ->set_tree_js();
		$this -> layout -> set_validate_css();
		$this -> layout -> set_validate_js();
		$this -> layout -> add_js('pages/EC_autocomplete.js');
		$this -> layout -> add_css('pages/EC_autocomplete.css');
		$this -> layout -> add_js('pages/EC_master_category.js');
		$this -> layout -> add_css('pages/EC_strategic_material.css');
		$this -> layout -> add_js('pages/EC_nav_tree.js');
		$this -> layout -> add_css('pages/EC_nav_tree.css');
		$this -> layout -> render('list', $data);
	}

	function getTree(){
    	$data_post=$this->input->post();
	   	$data['dataTree'] = $this->ec_master_user_category_m->map_tree_map("SELECT CAT.ID_CAT AS ID, CAT.*, UCAT.*
FROM EC_M_CATEGORY CAT
LEFT JOIN EC_USER_CATEGORY UCAT ON UCAT.ID_CAT=CAT.ID_CAT AND UCAT.ID_USER='".$data_post['user_id']."'
ORDER BY CAT.KODE_USER ASC");
		
		//print_r($data['dataTree']); exit();
		$dtree = $this->ec_master_user_category_m->buildTree($data['dataTree'],0,true);
		
		echo json_encode($dtree);

    }

    function crud(){
    	$data_post=$this->input->post();
	    switch ($data_post['action']) {
	    	case 'Simpan':
	    		$arr_insr_['ID_USER']=$data_post['id_user'];
				$arr_insr_['ID_CAT']=$data_post['id_cat'];
				$arr_insr_['SELECTED']=1;
				//$arr_insr_['AKTIF']=1;
				//$sql_q[0]= $this->db->insert_string('k_ms_group_akses', $arr_insr_); 
				 
			 	$this->m_global->insert_custom('EC_USER_CATEGORY',$arr_insr_);

				// if($this->m_global->insert_custom('APP_GRP_AKSES_MENU',$arr_insr_)){
					//echo json_encode(array('ket'=>"Penambahan Data Berhasil",'dt'=>$data)) ;
					
				// }else{
					// echo json_encode(array('ket'=>"Gagal Insert")) ;
				// }
				
			 	
	    	break;
	    	case 'Hapus':
	    		$this->db->where('ID_USER', $data_post['id_user']);
	    		$this->db->where('ID_CAT', $data_post['id_cat']);
				$this->db->delete('EC_USER_CATEGORY');
				 
				// echo json_encode(array('ket'=>"Hapus Data Berhasil")) ;
	    	break;
	    }
	    echo json_encode(array('done'=>"Updated")) ;
    }

    public function search_nama()
  {
    // tangkap variabel keyword dari URL
    $keyword = $this->uri->segment(3);

    // cari di database
    $data = $this->db->query("SELECT EMP.*
                          FROM ADM_EMPLOYEE EMP where EMP.FULLNAME like '%".strtoupper($keyword)."%'");

    // format keluaran di dalam array
    foreach($data->result() as $row)
    {
      $arr['query'] = $keyword;
      $arr['suggestions'][] = array(
        'value' =>$row->FULLNAME,
        'ID_USER' =>$row->ID
      );
    }
    // minimal PHP 5.2
    echo json_encode($arr);
  }

	public function get_data() {
		header('Content-Type: application/json');
		$this -> load -> model('ec_master_category_m');
		$dataa = $this -> ec_master_category_m -> get();
		$i = 1;
		$data_tabel = array();
		// foreach ($dataa as $value) {
		// $data[0] = $i++;
		// $data[1] = $value['DOC_ID'];
		// $data[2] = $value['CATEGORY'] = !null ? $value['CATEGORY'] : "";
		// $data[3] = $value['TYPE'] = !null ? $value['TYPE'] : "";
		// $data[4] = $value['STATUS'];
		// $data_tabel[] = $data;
		// }
		$json_data = $dataa;
		// array('data' => $data_tabel);
		echo json_encode($json_data);
	}

	public function baru($id_parent) {
		print_r($id_parent);
		$this -> load -> model('ec_master_category_m');
		$data = array("KODE_PARENT" => $id_parent, "DESC" => $this -> input -> post("desc"), "KODE_USER" => $this -> input -> post("kode_user"), "LEVEL" => $this -> input -> post("level"));
		$this -> ec_master_category_m -> insertBaru($data);
		// $json_data = array('data' => 'sukses kah');
		// echo json_encode($json_data);
	}

	public function ubah($id_parent) {
		// print_r($id_parent);
		$this -> load -> model('ec_master_category_m');
		$data = array("ID_CAT" => $id_parent, "DESC" => $this -> input -> post("desc"));
		$this -> ec_master_category_m -> ubah($data);
	}

	public function hapus($id_parent) {
		// print_r($id_parent);
		$this -> load -> model('ec_master_category_m');
		$data = array("ID_CAT" => $id_parent, "KODE_USER" => $this -> input -> post("kodeEdit"));
		$this -> ec_master_category_m -> hapus($data);
	}

	function testM($value = '') {
		header('Content-Type: application/json');
		$this -> load -> model('ec_master_category_m');
		// $data = array("ID_CAT" => $id_parent, "KODE_USER" => $this -> input -> post("kodeEdit"));
		$this -> ec_master_category_m -> updateKodeUser('', 'lvl0');
	}

}
