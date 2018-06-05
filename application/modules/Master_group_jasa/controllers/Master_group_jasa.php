<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Master_group_jasa extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->model('com_jasa_group');
		$this->load->model('m_global');
	}

	public function index() {
		$data['title'] = "Master Group Jasa";
		$this->layout->add_js('plugins/bootstrap-validator/bootstrapValidator.js');
		$this->layout->add_js('plugins/bootstrap-validator/language/id_ID.js');
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_tree_css();
		$this->layout->set_tree_js();

		$this->layout->add_js('pages/ms_group_jasa.js');
		$this->layout->render('master_group_jasa',$data);
	}

	function load_data_tree(){		
		$this->load->view('jasa_tree');
	}

	function getTree(){		
		$da = " SELECT ID, NAMA AS TITLE, FK_JASA_GROUP_ID PARENT_ID, NAMA, KATEGORI
				FROM COM_JASA_GROUP 
				ORDER BY ID";
    	$data['dataTree'] = $this->com_jasa_group->mapTree($da);
 				
		$dtree = $this->m_global->buildTree($data['dataTree']);
		echo json_encode($dtree);
	}

	public function get_list() {
		$this->load->model('com_jasa_group');

		$datatable = $this->com_jasa_group->get_list();
		$data = array('data' => $datatable);
		echo json_encode($data);
	}

	public function edit(){
		$id = $this->input->post('id');
		$da = " SELECT j1.ID, j1.NAMA As nama, j2.ID AS parent_id, j2.NAMA AS parent_name,  j1.KATEGORI, j1.DESCRIPTION
				FROM COM_JASA_GROUP j1 
				LEFT JOIN COM_JASA_GROUP j2 ON j1.FK_JASA_GROUP_ID=j2.ID
				WHERE j1.ID = {$id} ";

		$data = $this->db->query($da);
		$data = $data->result_array();

		echo json_encode($data[0]);
	}

	public function delete(){
		$id = $this->input->post('id');
		if ($this->com_jasa_group->delete(array("ID" => $id))) {
			echo 'ok';
		}
	}

	public function save(){
		$parent_id = $this->input->post('parent_id');
		if(!empty($parent_id)) {
			$data['FK_JASA_GROUP_ID'] = $parent_id;
		}

		$data['NAMA'] = $this->input->post('nama');
		$data['KATEGORI'] = $this->input->post('kategori_id');

		$description = $this->input->post('description');
		if(!empty($description)) {
			$data['DESCRIPTION'] = $description;
		}

		$jasa_id = $this->input->post('jasa_id');
		if(empty($jasa_id)) {
			if ($this->com_jasa_group->insert($data)) {
				echo 'ok';
			}
		}else {
			$where = array('ID' => $jasa_id);
			if ($this->com_jasa_group->update($data,$where)) {
				echo 'ok';
			}
		}

	}

}

?>