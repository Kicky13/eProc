<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee_pg extends CI_Controller {

	public function __construct() {
		parent::__construct();

		//$this->db = $this->load->database('default', TRUE);
		$this->load->helper("security" ); 
		$this->load->library(array('form_validation','session'));
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->model('m_global');
		

	}

	function index(){
		$data['title'] = "Mapping Purchasing Group";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_validate_css();
		$this->layout->set_tree_css();
		$this->layout->set_tree_js();
		$this->layout->set_validate_js();
		$this->layout->add_js('pages/purchasing_group.js');
		$data["company_name"]=$this->m_global->getcombo("SELECT COMPANYID ID, COMPANYNAME NAMA FROM ADM_COMPANY WHERE COMPANYID NOT IN('1000') AND ISACTIVE = 1");
		$data["nama_pg"]=$this->m_global->getcombo("SELECT PURCH_GRP_CODE ID,PURCH_GRP_CODE||' '||PURCH_GRP_NAME NAMA,COMPANY_ID FROM ADM_PURCH_GRP ");
		
		$this->layout->render('vakses_mp', $data);
	}
	
	function get_purch_grp(){

		$data_post=$this->input->post();
		echo $this->m_global->ajax_combo("SELECT PURCH_GRP_CODE ID,PURCH_GRP_CODE||' '||PURCH_GRP_NAME NAMA,COMPANY_ID FROM ADM_PURCH_GRP WHERE ADM_PURCH_GRP.COMPANY_ID='".$data_post['idcompany']."'",'');
		
	}
	function load_data_unit($idcom_){
		$dataku['nilai']=$idcom_;
		$this->load->view('v_unit_tree',$dataku);
	}
	function akses_proccess($nid,$ncomp){
		
		
		$data['title'] = "Akses Master Proccess";
		$data['idpros'] = $nid;
		$data['idcom']=$ncomp;
		//$this->layout->set_table_js();
		//$this->layout->set_table_cs();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		//$this->layout->set_table_selected_css();
		$this->layout->set_validate_css();
		$this->layout->set_tree_css();
		$this->layout->set_tree_js();
		$this->layout->set_validate_js();
		$this->layout->add_js('pages/master_proccess_detil.js');
		$this->layout->render('vakses_mp', $data);


	}  
	function load_data_tree(){
		
		$this->load->view('v_menu_tree');
	}
	
	function getTree_lazy(){
		$this->load->model('m_global');
		$data_post=$this->input->get();
		$da="SELECT ADM_DEPT.DEPT_ID ID, DEP_CODE||' '|| DEPT_NAME||' '||DEPT_LEVEL TITLE,DEPT_KODE_PARENT PARENT_ID,DEPT_NAME NAMA, DEPT_COMPANY,DEP_CODE KODE FROM ADM_DEPT
		WHERE DEPT_KODE_PARENT='".$data_post['key']."'";

		$data['dataTree'] = $this->m_global->mapTree_unit($da);

		$dtree = $this->m_global->buildTree($data['dataTree'],$data_post['key']);
		echo json_encode($dtree);

	}
	
	function getTree($ndata){
		
		//$data_post=$this->security->xss_clean($_REQUEST);
		$da="SELECT DEPT_ID ID, DEP_CODE||' '|| DEPT_NAME||' '||DEPT_LEVEL  TITLE,DEPT_KODE_PARENT PARENT_ID,DEPT_NAME NAMA, DEPT_COMPANY,DEP_CODE KODE FROM ADM_DEPT WHERE DEPT_KODE_PARENT=0 AND ADM_DEPT.DEPT_COMPANY='".$ndata."'";// WHERE COMPANY=2000";
		//$da="SELECT m1.ID_MENU ID,m1.KODE_MENU||' ' ||m1.NAMA_MENU AS TITLE,m1.CONTROLLER_PATH AS URL,m1.MENU_PARENT PARENT_ID,m1.NAMA_MENU NAMA,
		//m1.KODE_MENU KODE, m2.KODE_MENU AS PARENT_KODE,m1.aktif_menu AKTIF 	FROM APP_MENU m1 LEFT JOIN APP_MENU m2 ON m2.ID_MENU =m1.MENU_PARENT  ORDER BY m2.KODE_MENU ASC";
		$data['dataTree'] = $this->m_global->mapTree_unit($da);

		$dtree = $this->m_global->buildTree($data['dataTree']);
		echo json_encode($dtree);
		
	}

	function crud(){
		$data_post=$this->input->post();
		switch ($data_post['action']) {
			case 'Simpan':
			$arr_insr_['APP_GRP_MENU_ID']=$data_post['fk_ms_group_id'];
			$arr_insr_['APP_MENU_ID']=$data_post['fk_ms_menu_id'];
				//$arr_insr_['AKTIF']=1;
				//$sql_q[0]= $this->db->insert_string('k_ms_group_akses', $arr_insr_); 


			if($this->m_global->insert_custom('APP_GRP_AKSES_MENU',$arr_insr_)){
					//echo json_encode(array('ket'=>"Penambahan Data Berhasil",'dt'=>$data)) ;

			} else {
				echo json_encode(array('ket'=>"Gagal Insert")) ;
			}


			break;
			case 'Hapus':
			$this->db->where('APP_GRP_MENU_ID', $data_post['fk_ms_group_id']);
			$this->db->where('APP_MENU_ID', $data_post['fk_ms_menu_id']);
			$this->db->delete('APP_GRP_AKSES_MENU');

				// echo json_encode(array('ket'=>"Hapus Data Berhasil")) ;
			break;
		}
	}



	function get_datatable_ub(){
		$this->load->model('m_global');
		$data_post=$this->security->xss_clean($_POST);
		//$panjang=10; $mulai=0; $akhir=0;
		//if(isset($data_post['length']) && $data_post['length']!='' && $data_post['length']!='0'){
			//$panjang=$data_post['length'];
			//}
		//if(isset($data_post['start']) && $data_post['start']!='' ){
			//$mulai=$data_post['start'];
			//}
		//$akhir=$panjang+$mulai;
		$filter_data='';
		//if($data_post['company']!='') $filter_data.=" and UPPER(APP_PROCESS.COMPANYID) = '". str_replace("'", "''", strtoupper($data_post['company']))."' "; 
		//if($data_post['sampul']!='') $filter_data.=" and UPPER(APP_PROCESS.TIPE_SAMPUL) = '".str_replace("'", "''", strtoupper($data_post['sampul']))."' "; 
		//if($data_post['caridata3']!='') $filter_data.=" and UPPER(ADM_DEPT.DISTRICT_NAME) like '%".str_replace("'", "''", strtoupper($data_post['caridata3']))."%' "; 

		$i=0;
		$no=0;

		//$colom=array('PROCESS_ID','PROCESS_MASTER_ID','CURRENT_PROCESS','NAMA_BARU','ASSIGNMENT','COMPANYNAME','APP_PROCESS.COMPANYID','TIPE_SAMPUL','PRC_SAMPUL_NAME');

		//$sql="SELECT ".implode(', ', $colom).",ROW_NUMBER() OVER (ORDER BY ".$colom[$data_post ['order'][0]['column']]." ".$data_post ['order'][0]['dir'].") BARIS FROM APP_PROCESS,ADM_COMPANY,PRC_TENDER_SAMPUL WHERE
		//APP_PROCESS.COMPANYID=ADM_COMPANY.COMPANYID AND APP_PROCESS.TIPE_SAMPUL=PRC_TENDER_SAMPUL.PRC_SAMPUL_ID ". $filter_data;

		$colom=array('ADM_POS.POS_ID','ADM_DEPT.DEPT_NAME','ADM_POS.POS_NAME','EM_SUB_GROUP','ADM_EMPLOYEE.FULLNAME','ADM_EMPLOYEE.ID','COMPANYNAME','ADM_EMPLOYEE_PUCH_GRP.PURC_COMPANY_ID','ADM_EMPLOYEE_PUCH_GRP.PURC_GRP_ID');

		$sql="SELECT DISTINCT ".implode(', ', $colom)." FROM ADM_DEPT,ADM_POS,ADM_EMPLOYEE,ADM_EMPLOYEE_PUCH_GRP,ADM_COMPANY  WHERE ADM_DEPT.DEPT_ID =ADM_POS.DEPT_ID AND ADM_POS.POS_ID=ADM_EMPLOYEE.ADM_POS_ID 
		AND ADM_EMPLOYEE_PUCH_GRP.PURC_COMPANY_ID=ADM_COMPANY.COMPANYID AND ADM_EMPLOYEE.ID=ADM_EMPLOYEE_PUCH_GRP.EMPLOYEE_ID AND ADM_DEPT.DEPT_COMPANY='".$data_post['idpros']."'  AND ADM_EMPLOYEE.STATUS='Active' ORDER BY EM_SUB_GROUP ASC ". $filter_data;

		//echo $sql; exit();
		//$totalData =$this->m_global->total_row($sql);
		//$totalFiltered = $totalData;
		//$sql= " SELECT * FROM (".$sql.") WHERE BARIS BETWEEN ".$mulai." AND ".$akhir ;
		//echo $sql; exit();
		$data1 = $this->m_global->grid_view($sql)->result_array();

		$data=array();
		foreach($data1 as $line){
			$data_tbl=array();
			//$data_tbl['BARIS']=$line['BARIS']; 
			$data_tbl['DEPT_NAME']=$line['DEPT_NAME']; 
			$data_tbl['POS_NAME']=$line['POS_NAME'];
			$data_tbl['FULLNAME']=$line['FULLNAME'];
			$data_tbl['COMPANYNAME']=$line['COMPANYNAME'];
			$data_tbl['PURC_COMPANY_ID']=$line['PURC_COMPANY_ID'];
			$data_tbl['PURC_GRP_ID']=$line['PURC_GRP_ID'];
			$data_tbl['ID']=$line['ID'];

			$data[]=$data_tbl;
			$i++;
			$no++;
		}
		$json_data = array(
			//"draw"			=> intval( $data_post['draw'] ),
			//"recordsTotal"	=> intval( $totalData ),  // total number of records
			//"recordsFiltered" => intval( $totalFiltered ),
			"data"			=> $data   // total data array
			);

		echo json_encode($json_data);


	}


	function get_datatable_ub_(){
		$this->load->model('m_global');
		$data_post=$this->security->xss_clean($_POST);
		$panjang=10; $mulai=0; $akhir=0;
		if(isset($data_post['length']) && $data_post['length']!='' && $data_post['length']!='0'){
			$panjang=$data_post['length'];
		}
		if(isset($data_post['start']) && $data_post['start']!='' ){
			$mulai=$data_post['start'];
		}
		$akhir=$panjang+$mulai;
		$filter_data='';
		//if($data_post['company']!='') $filter_data.=" and UPPER(APP_PROCESS.COMPANYID) = '". str_replace("'", "''", strtoupper($data_post['company']))."' "; 
		//if($data_post['sampul']!='') $filter_data.=" and UPPER(APP_PROCESS.TIPE_SAMPUL) = '".str_replace("'", "''", strtoupper($data_post['sampul']))."' "; 
		//if($data_post['caridata3']!='') $filter_data.=" and UPPER(ADM_DEPT.DISTRICT_NAME) like '%".str_replace("'", "''", strtoupper($data_post['caridata3']))."%' "; 

		$i=0;
		$no=0;

		$colom=array('ADM_DEPT.DEPT_NAME','ADM_POS.POS_NAME' ,'PROCESS_ROLE_ID','ROLE','PROCESS_ID','ADM_DEPT.DEPT_COMPANY');

		$sql="SELECT ".implode(', ', $colom).",ROW_NUMBER() OVER (ORDER BY ".$colom[$data_post ['order'][0]['column']]." ".$data_post ['order'][0]['dir'].") BARIS FROM APP_PROCESS_ROLE,ADM_DEPT,ADM_POS WHERE ADM_DEPT.DEPT_ID =ADM_POS.DEPT_ID AND ADM_POS.POS_ID=APP_PROCESS_ROLE.ROLE AND APP_PROCESS_ROLE.PROCESS_ID='".$data_post['idpros']."'". $filter_data;

		$totalData =$this->m_global->total_row($sql);
		$totalFiltered = $totalData;
		$sql= " SELECT * FROM (".$sql.") WHERE BARIS BETWEEN ".$mulai." AND ".$akhir ;
		//echo $sql; exit();
		$data1 = $this->m_global->grid_view($sql)->result_array();

		$data=array();
		foreach($data1 as $line){
			$data_tbl=array();
			$data_tbl['BARIS']=$line['BARIS']; 
			$data_tbl['DEPT_NAME']=$line['DEPT_NAME']; 
			$data_tbl['POS_NAME']=$line['POS_NAME'];
			$data_tbl['PROCESS_ROLE_ID']=$line['PROCESS_ROLE_ID'];
			$data_tbl['ROLE']=$line['ROLE'];
			$data_tbl['PROCESS_ID']=$line['PROCESS_ID'];
			$data_tbl['DEPT_COMPANY']=$line['DEPT_COMPANY'];

			$data[]=$data_tbl;
			$i++;
			$no++;
		}
		$json_data = array(
			"draw"			=> intval( $data_post['draw'] ),
			"recordsTotal"	=> intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ),
			"data"			=> $data   // total data array
			);

		echo json_encode($json_data);


	}

	function get_datatable_ub_tmp(){
		$this->load->model('m_global');
		$data_post=$this->security->xss_clean($_POST);
		//$panjang=10; $mulai=0; $akhir=0;
		//if(isset($data_post['length']) && $data_post['length']!='' && $data_post['length']!='0'){
			//$panjang=$data_post['length'];
			//}
		//if(isset($data_post['start']) && $data_post['start']!='' ){
			//$mulai=$data_post['start'];
			//}
		//$akhir=$panjang+$mulai;
		$filter_data='';
		//if($data_post['company']!='') $filter_data.=" and UPPER(APP_PROCESS.COMPANYID) = '". str_replace("'", "''", strtoupper($data_post['company']))."' "; 
		//if($data_post['sampul']!='') $filter_data.=" and UPPER(APP_PROCESS.TIPE_SAMPUL) = '".str_replace("'", "''", strtoupper($data_post['sampul']))."' "; 
		//if($data_post['caridata3']!='') $filter_data.=" and UPPER(ADM_DEPT.DISTRICT_NAME) like '%".str_replace("'", "''", strtoupper($data_post['caridata3']))."%' "; 

		$i=0;
		$no=0;


		$colom=array('ADM_POS.POS_ID','ADM_DEPT.DEPT_NAME','ADM_POS.POS_NAME','EM_SUB_GROUP','ADM_EMPLOYEE.FULLNAME','ADM_EMPLOYEE.ID');

		$sql="SELECT DISTINCT ".implode(', ', $colom)." FROM ADM_DEPT,ADM_POS,ADM_EMPLOYEE  WHERE ADM_DEPT.DEPT_ID =ADM_POS.DEPT_ID AND ADM_POS.POS_ID=ADM_EMPLOYEE.ADM_POS_ID 
		AND ADM_DEPT.DEPT_COMPANY='".$data_post['idcom']."' AND ADM_EMPLOYEE.DEPT_KODE='".$data_post['kode_unit']."' AND ADM_EMPLOYEE.STATUS='Active' ORDER BY EM_SUB_GROUP ASC ". $filter_data;

		//$totalData =$this->m_global->total_row($sql);
		//$totalFiltered = $totalData;
		//$sql= " SELECT * FROM (".$sql.") WHERE BARIS BETWEEN ".$mulai." AND ".$akhir ;
		//echo $sql; exit();
		$data1 = $this->m_global->grid_view($sql)->result_array();

		$data=array();
		foreach($data1 as $line){
			$data_tbl=array();
			$data_tbl['DEPT_NAME']=$line['DEPT_NAME']; 
			$data_tbl['POS_NAME']=$line['POS_NAME'];
			$data_tbl['FULLNAME']=$line['FULLNAME'];
			$data_tbl['POS_ID']=$line['POS_ID'];
			$data_tbl['ID']=$line['ID'];
			$data_tbl['EM_SUB_GROUP']=$line['EM_SUB_GROUP'];

			$data[]=$data_tbl;
			$i++;
			$no++;
		}
		$json_data = array(
			//"draw"			=> intval( $data_post['draw'] ),
			//"recordsTotal"	=> intval( $totalData ),  // total number of records
			//"recordsFiltered" => intval( $totalFiltered ),
			"data"			=> $data   // total data array
			);

		echo json_encode($json_data);


	}

	function simdata() {

		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		$data_post=$this->input->post();
		$this->form_validation->set_rules('nama_proccess', 'Nama Proccess', 'required');
		$this->form_validation->set_rules('urutan', 'Masukkan Angka', 'required|numeric');

	//	$data['title'] = "Master Menu";
		if ($this->form_validation->run() == FALSE) {

			if(form_error('nama_proccess')){

				$data['inputerror'][] = 'nama_proccess';
				$data['error_string'][] = 'Name Proccess is required';
				$data['status'] = FALSE;

			}
			if(form_error('urutan')){

				$data['inputerror'][] = 'urutan';
				$data['error_string'][] = 'Urutan is required and Numeric';
				$data['status'] = FALSE;

			}


			echo json_encode(array('dt'=>$data));
			exit();

		}

		$new_menu=array();
		$new_menu['NAMA_BARU'] = $data_post['nama_proccess'];
		$new_menu['CURRENT_PROCESS'] = $data_post['urutan'];
		$new_menu['TIPE_SAMPUL'] = $data_post['sampul'];
		$new_menu['COMPANYID'] = $data_post['company'];
		$new_menu['PROCESS_MASTER_ID'] = $data_post['link_url'];
		$new_menu['PROCESS_MASTER_ID'] = $data_post['link_url'];

		switch ($data_post['act']) {

			case 'Simpan':

				//$new_menu['NAMA_GRP'] = $this->m_global->get_id('NAMA_GRP');

			if($this->m_global->insert_custom('APP_PROCESS',$new_menu)){
				echo json_encode(array('ket'=>"Penambahan Data Berhasil",'dt'=>$data)) ;

			}else{
				echo json_encode(array('ket'=>"Gagal Insert",'dt'=>$data)) ;
			}

			break;
			case 'Ubah':
			$where=array();
			$where['PROCESS_ID']=$data_post['app_id'];
			if($this->m_global->update('APP_PROCESS',$new_menu,$where)){
				echo json_encode(array('ket'=>"Update Data Berhasil",'dt'=>$data)) ;
			}
			else{
				echo json_encode(array('ket'=>"Gagal Update",'dt'=>$data)) ;
			}


			break;
			case 'Hapus':
			$sql=array();
			$sql[]="DELETE FROM APP_PROCESS WHERE PROCESS_ID='".$data_post['app_id']."'";
			$sql[]="DELETE FROM APP_PROCESS_ROLE WHERE PROCESS_ID='".$data_post['app_id']."'";
				//$sql[]="DELETE FROM APP_MENU WHERE MENU_PARENT='".$data_post['id31']."'";

			if($this->m_global->delete($sql)){
				echo json_encode(array('ket'=>"Hapus Data Berhasil",'dt'=>$data)) ;
			}
			else{
				echo json_encode(array('ket'=>"Batal Hapus",'dt'=>$data)) ;
			}
			//echo json_encode(array('ket'=>"Hapus Data Berhasil",'dt'=>$data)) ;

			break;
		}
	} 

	function hapus_detil_proccess($iddel,$iddel1,$iddel2){

		$this->load->model('m_global');
		$data_post=$this->security->xss_clean($_POST);
		$sql[]="DELETE FROM ADM_EMPLOYEE_PUCH_GRP WHERE PURC_GRP_ID='".$iddel1."' AND EMPLOYEE_ID='".$iddel."' AND PURC_COMPANY_ID='".$iddel2."'";
		$this->m_global->delete($sql);
		redirect(base_url('Employee_pg'));
	}

	function simpan_detil_proccess(){

		$this->load->model('m_global');
		$data_post=$this->security->xss_clean($_POST);

		$tampil=explode(',',$data_post['tampil']);
		$new_menu=array();
		$new_menu["PURC_GRP_ID"]=$data_post['nama_pg'];
		$new_menu["PURC_COMPANY_ID"]=$data_post['company'];
		for($i=0; $i<count($tampil); $i++){
			$sql="SELECT * FROM ADM_EMPLOYEE_PUCH_GRP WHERE PURC_GRP_ID='".$data_post['nama_pg']."' AND EMPLOYEE_ID='".$tampil[$i]."' AND PURC_COMPANY_ID='".$data_post['company']."'";
			$totalData =$this->m_global->total_row($sql);

			if($totalData==0){
				if($tampil[$i]!=''){
					$new_menu["EMPLOYEE_ID"]=$tampil[$i];
					$this->m_global->insert_custom('ADM_EMPLOYEE_PUCH_GRP',$new_menu);
				}
			}


		}

		redirect(base_url('Employee_pg'));

	}

}