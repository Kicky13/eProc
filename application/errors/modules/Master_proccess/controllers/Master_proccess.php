<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_proccess extends CI_Controller {

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
		$data['title'] = "Master Proccess";
		//$this->layout->set_table_js();
		//$this->layout->set_table_cs();
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		//$this->layout->set_table_selected_css();
		$this->layout->set_validate_css();
		//$this->layout->set_tree_css();
		//$this->layout->set_tree_js();
		$this->layout->set_validate_js();
		$this->layout->add_js('pages/master_proccess_data.js');
		//$data["fk_ms_group_id03"]=$this->m_global->getcombo("SELECT APP_GRP_ID ID, NAMA_GRP NAMA FROM APP_GRP_MENU");
		$data["nama_company"]=$this->m_global->getcombo("SELECT ADM_KEL_PRCGRP.KEL_PRCHGRP_ID ID,ADM_KEL_PRCGRP.NAMA_KEL_PRCHGRP NAMA  FROM ADM_KEL_PRCGRP ");
		$data["company"]=$this->m_global->getcombo("SELECT ADM_COMPANY.COMPANYID ID,ADM_COMPANY.COMPANYNAME NAMA FROM ADM_COMPANY WHERE COMPANYID IN(SELECT ADM_PURCH_GRP.COMPANY_ID FROM ADM_PURCH_GRP WHERE ADM_PURCH_GRP.KEL_PURCH_GRP = 2 GROUP BY ADM_PURCH_GRP.COMPANY_ID ) ORDER BY ADM_COMPANY.COMPANYID DESC");
		$data["link_url"]=$this->m_global->getcombo("SELECT APP_URL ID,	PROCESS_MASTER_ID||'. '||PROCESS_NAME NAMA FROM APP_PROCESS_MASTER ORDER BY PROCESS_MASTER_ID");
		$data["sampul"]=$this->m_global->getcombo("SELECT 	PRC_SAMPUL_ID ID, 	PRC_SAMPUL_NAME NAMA FROM PRC_TENDER_SAMPUL");
		$data["identitas_proccess"]=$this->m_global->getcombo("SELECT APP_IDENTIFICATION_ID ID, NAME_IDENTIFICATION NAMA FROM APP_PROCCESS_IDENTITI","all");
		
		//;
		
		$this->layout->render('v_ms_menu', $data);
        //$this->load->view('v_adm_plant',$data);

	}  
	
	function load_data_unit($idcom_){
		$dataku['nilai']=$idcom_;
		$this->load->view('v_unit_tree',$dataku);
	}
	function get_company(){
		//$this->load->model('m_global');
		$data_post=$this->input->post();
		echo $this->m_global->ajax_combo("SELECT ADM_COMPANY.COMPANYID ID,ADM_COMPANY.COMPANYNAME NAMA FROM ADM_COMPANY WHERE COMPANYID IN(SELECT ADM_PURCH_GRP.COMPANY_ID FROM ADM_PURCH_GRP WHERE ADM_PURCH_GRP.KEL_PURCH_GRP='".$data_post['id']."'  GROUP BY  ADM_PURCH_GRP.COMPANY_ID) ORDER BY ADM_COMPANY.COMPANYID DESC",'');
		
	}
	function akses_proccess($nid,$ncomp) {
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
		//$data["fk_ms_group_id03"]=$this->m_global->getcombo("SELECT APP_GRP_ID ID, NAMA_GRP NAMA FROM APP_GRP_MENU");
		//$data["company"]=$this->m_global->getcombo("SELECT COMPANYID ID, COMPANYNAME NAMA FROM ADM_COMPANY WHERE ISACTIVE=1");
		//$data["link_url"]=$this->m_global->getcombo("SELECT APP_URL ID,	PROCESS_NAME NAMA FROM APP_PROCESS_MASTER");
		//$data["sampul"]=$this->m_global->getcombo("SELECT 	PRC_SAMPUL_ID ID, 	PRC_SAMPUL_NAME NAMA FROM PRC_TENDER_SAMPUL");
		
		//;
		
		$this->layout->render('vakses_mp', $data);
        //$this->load->view('v_adm_plant',$data);

	}  
	function load_data_tree(){
		
		$this->load->view('v_menu_tree');
	}
	
	function getTree_lazy(){
		$this->load->model('m_global');
		$data_post=$this->input->get();
		$da="SELECT ADM_DEPT.DEPT_ID ID, DEP_CODE||' '|| DEPT_NAME||' '||DEPT_LEVEL TITLE,DEPT_KODE_PARENT PARENT_ID,DEPT_NAME NAMA, DEPT_COMPANY,DEP_CODE KODE,DEPT_ENDDA FROM ADM_DEPT
		WHERE  ADM_DEPT.DEPT_ENDDA = '9999-12-31' AND DEPT_KODE_PARENT='".$data_post['key']."'";

		$data['dataTree'] = $this->m_global->mapTree_unit($da);

		$dtree = $this->m_global->buildTree($data['dataTree'],$data_post['key']);
		echo json_encode($dtree);

	}
	
	function getTree($ndata){
		
		    	//$data_post=$this->security->xss_clean($_REQUEST);
		$ndata_=$this->m_global->company_group($ndata);

				$da="SELECT DEPT_ID ID, DEP_CODE||' '|| DEPT_NAME||' '||DEPT_LEVEL  TITLE,DEPT_KODE_PARENT PARENT_ID,DEPT_NAME NAMA, DEPT_COMPANY,DEP_CODE KODE,DEPT_ENDDA FROM ADM_DEPT WHERE DEPT_KODE_PARENT=0 AND ADM_DEPT.DEPT_ENDDA = '9999-12-31' AND ADM_DEPT.DEPT_COMPANY IN(".$ndata_.")";// WHERE COMPANY=2000";
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

					}else{
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
				$panjang=10; $mulai=0; $akhir=0;
				if(isset($data_post['length']) && $data_post['length']!='' && $data_post['length']!='0'){
					$panjang=$data_post['length'];
				}
				if(isset($data_post['start']) && $data_post['start']!='' ){
					$mulai=$data_post['start'];
				}
				$akhir=$panjang+$mulai;
				$filter_data='';
				if($data_post['nama_company']!='')
					$filter_data.=" and UPPER(APP_PROCESS.KEL_PLANT_PRO) = '". str_replace("'", "''", strtoupper($data_post['nama_company']))."' ";
				if($data_post['sampul']!='')
					$filter_data.=" and UPPER(APP_PROCESS.TIPE_SAMPUL) = '".str_replace("'", "''", strtoupper($data_post['sampul']))."' ";
				if($data_post['just']!='')
					$filter_data.=" and APP_PROCESS.JUSTIFICATION = ".$data_post['just']." ";
		//if($data_post['caridata3']!='') $filter_data.=" and UPPER(ADM_DEPT.DISTRICT_NAME) like '%".str_replace("'", "''", strtoupper($data_post['caridata3']))."%' "; 

				$i=0;
				$no=0;

				$colom=array('CURRENT_PROCESS','PROCESS_MASTER_ID','PROCESS_ID','NAMA_BARU','ASSIGNMENT','NAMA_KEL_PRCHGRP COMPANYNAME','APP_PROCESS.COMPANYID','IS_ASSIGN','TIPE_SAMPUL','PRC_SAMPUL_NAME','IDENTITAS_PROCCESS','KEL_PLANT_PRO');

				$sql="SELECT ".implode(', ', $colom).",ROW_NUMBER() OVER (ORDER BY ".$colom[$data_post ['order'][0]['column']]." ".$data_post ['order'][0]['dir'].") BARIS FROM APP_PROCESS,ADM_KEL_PRCGRP,PRC_TENDER_SAMPUL WHERE
				APP_PROCESS.KEL_PLANT_PRO=ADM_KEL_PRCGRP.KEL_PRCHGRP_ID AND APP_PROCESS.TIPE_SAMPUL=PRC_TENDER_SAMPUL.PRC_SAMPUL_ID ". $filter_data;

				$totalData =$this->m_global->total_row($sql);
				$totalFiltered = $totalData;
				$sql= " SELECT * FROM (".$sql.") WHERE BARIS BETWEEN ".$mulai." AND ".$akhir ;
		
				$sql .= " ORDER BY CURRENT_PROCESS ASC";
				$data1 = $this->m_global->grid_view($sql)->result_array();
				//echo $sql; exit();
				$data=array();
				foreach($data1 as $line){
					$data_tbl=array();
					$data_tbl['BARIS']=$line['BARIS']; 
					$data_tbl['CURRENT_PROCESS']=$line['CURRENT_PROCESS']; 
					$data_tbl['NAMA_BARU']=$line['NAMA_BARU'];
					$data_tbl['COMPANYNAME']=$line['COMPANYNAME'];
					$data_tbl['PRC_SAMPUL_NAME']=$line['PRC_SAMPUL_NAME'];
					$data_tbl['PROCESS_MASTER_ID']=$line['PROCESS_MASTER_ID'];
					$data_tbl['ASSIGNMENT']=$line['ASSIGNMENT'];
					$data_tbl['COMPANYID']=$line['COMPANYID'];
					$data_tbl['TIPE_SAMPUL']=$line['TIPE_SAMPUL'];
					$data_tbl['PROCESS_ID']=$line['PROCESS_ID'];
					$data_tbl['IDENTITAS_PROCCESS']=$line['IDENTITAS_PROCCESS'];
					$data_tbl['KEL_PLANT_PRO']=$line['KEL_PLANT_PRO'];
					$data_tbl['IS_ASSIGN']=$line['IS_ASSIGN'];


					$data[]=$data_tbl;
					$i++;
					$no++;
				}
				$json_data = array(
					"draw"            => intval( $data_post['draw'] ),
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ),
			"data"            => $data   // total data array
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

				$colom=array('ADM_DEPT.DEPT_NAME','ADM_POS.POS_NAME' ,'PROCESS_ROLE_ID','ROLE','APP_PROCESS_ROLE.PROCESS_ID','ADM_DEPT.DEPT_COMPANY','KEL_PLANT_PRO','FULLNAME','STATUS');

				$sql="SELECT ".implode(', ', $colom).",ROW_NUMBER() OVER (ORDER BY ".$colom[$data_post ['order'][0]['column']]." ".$data_post ['order'][0]['dir'].") BARIS FROM APP_PROCESS_ROLE,ADM_DEPT,ADM_POS,APP_PROCESS,ADM_EMPLOYEE WHERE APP_PROCESS.PROCESS_ID=APP_PROCESS_ROLE.PROCESS_ID AND ADM_DEPT.DEPT_ID =ADM_POS.DEPT_ID AND ADM_POS.POS_ID=APP_PROCESS_ROLE.ROLE AND ADM_POS.POS_ID=ADM_EMPLOYEE.ADM_POS_ID AND APP_PROCESS_ROLE.PROCESS_ID='".$data_post['idpros']."'". $filter_data;

				$totalData =$this->m_global->total_row($sql);
				$totalFiltered = $totalData;
				$sql= " SELECT * FROM (".$sql.") WHERE STATUS = 'Active' AND BARIS BETWEEN ".$mulai." AND ".$akhir ;
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
					$data_tbl['KEL_PLANT_PRO']=$line['KEL_PLANT_PRO'];
					$data_tbl['FULLNAME']=$line['FULLNAME'];


					$data[]=$data_tbl;
					$i++;
					$no++;
				}
				$json_data = array(
					"draw"            => intval( $data_post['draw'] ),
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ),
			"data"            => $data   // total data array
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


				$colom=array('ADM_POS.POS_ID','ADM_DEPT.DEPT_NAME','ADM_POS.POS_NAME','EM_SUB_GROUP','ADM_EMPLOYEE.FULLNAME');

				$sql="SELECT DISTINCT ".implode(', ', $colom)." FROM ADM_DEPT,ADM_POS,ADM_EMPLOYEE  WHERE ADM_DEPT.DEPT_ID =ADM_POS.DEPT_ID AND ADM_POS.POS_ID=ADM_EMPLOYEE.ADM_POS_ID 
				AND ADM_EMPLOYEE.DEPT_KODE='".$data_post['kode_unit']."' AND ADM_EMPLOYEE.STATUS='Active' ORDER BY EM_SUB_GROUP ASC ". $filter_data;

		//$totalData =$this->m_global->total_row($sql);
		//$totalFiltered = $totalData;
		//$sql= " SELECT * FROM (".$sql.") WHERE BARIS BETWEEN ".$mulai." AND ".$akhir ;
		// echo $sql; exit();
				$data1 = $this->m_global->grid_view($sql)->result_array();

				$data=array();
				foreach($data1 as $line){
					$data_tbl=array();
					$data_tbl['DEPT_NAME']=$line['DEPT_NAME']; 
					$data_tbl['POS_NAME']=$line['POS_NAME'];
					$data_tbl['FULLNAME']=$line['FULLNAME'];
					$data_tbl['POS_ID']=$line['POS_ID'];
					$data_tbl['EM_SUB_GROUP']=$line['EM_SUB_GROUP'];

					$data[]=$data_tbl;
					$i++;
					$no++;
				}
				$json_data = array(
			//"draw"            => intval( $data_post['draw'] ),
			//"recordsTotal"    => intval( $totalData ),  // total number of records
			//"recordsFiltered" => intval( $totalFiltered ),
			"data"            => $data   // total data array
			);
				echo json_encode($json_data);
			}

	function simdata() {
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		$data_post = $this->input->post();
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
		$new_menu['ASSIGNMENT'] = $data_post['assignment_'];
		$new_menu['IDENTITAS_PROCCESS'] = $data_post['identitas_proccess'];
		$new_menu['KEL_PLANT_PRO'] = $data_post['nama_company'];
		$new_menu['IS_ASSIGN'] = $data_post['assign_to'];
		$new_menu['JUSTIFICATION'] = $data_post['just'];

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

	function hapus_detil_proccess($iddel,$pro,$com){

		$this->load->model('m_global');
		$data_post=$this->security->xss_clean($_POST);
		$sql[]="DELETE FROM APP_PROCESS_ROLE WHERE PROCESS_ROLE_ID='".$iddel."'";
		$this->m_global->delete($sql);
		redirect(base_url('Master_proccess/akses_proccess/'.$pro.'/'.$com));
	}

	function simpan_detil_proccess(){

		$this->load->model('m_global');
		$data_post=$this->security->xss_clean($_POST);

		$tampil=explode(',',$data_post['tampil']);
		$new_menu=array();
		$new_menu["PROCESS_ID"]=$data_post['idpros'];
		for($i=0; $i<count($tampil); $i++){
			$sql="SELECT PROCESS_ROLE_ID,PROCESS_ID,ROLE FROM APP_PROCESS_ROLE WHERE PROCESS_ID='".$data_post['idpros']."' AND ROLE='".$tampil[$i]."'";
			$totalData =$this->m_global->total_row($sql);

			if($totalData==0){
				$new_menu["ROLE"]=$tampil[$i];
				$this->m_global->insert_custom('APP_PROCESS_ROLE',$new_menu);

			}


		}

		redirect(base_url('Master_proccess/akses_proccess/'.$data_post["idpros"].'/'.$data_post["idcom"]));

	}
	
	function generate_data(){
		$tdku=$this->input->post();
		
		if($tdku['sampul']=='1'||$tdku['sampul']=='2'){
		$sql="SELECT CURRENT_PROCESS, PROCESS_MASTER_ID, PROCESS_ID, NAMA_BARU, ASSIGNMENT, NAMA_KEL_PRCHGRP
 COMPANYNAME, APP_PROCESS.COMPANYID, IS_ASSIGN, TIPE_SAMPUL, PRC_SAMPUL_NAME, IDENTITAS_PROCCESS, KEL_PLANT_PRO
,ROW_NUMBER() OVER (ORDER BY CURRENT_PROCESS asc) BARIS FROM APP_PROCESS,ADM_KEL_PRCGRP,PRC_TENDER_SAMPUL
 WHERE APP_PROCESS.KEL_PLANT_PRO=ADM_KEL_PRCGRP.KEL_PRCHGRP_ID AND APP_PROCESS.TIPE_SAMPUL=PRC_TENDER_SAMPUL
.PRC_SAMPUL_ID  and UPPER(APP_PROCESS.KEL_PLANT_PRO) = '2'  and UPPER(APP_PROCESS.TIPE_SAMPUL) = '1'
  and APP_PROCESS.JUSTIFICATION = '1' AND COMPANYID='7000'" ;
		}else{
			$sql="SELECT CURRENT_PROCESS, PROCESS_MASTER_ID, PROCESS_ID, NAMA_BARU, ASSIGNMENT, NAMA_KEL_PRCHGRP
 COMPANYNAME, APP_PROCESS.COMPANYID, IS_ASSIGN, TIPE_SAMPUL, PRC_SAMPUL_NAME, IDENTITAS_PROCCESS, KEL_PLANT_PRO
,ROW_NUMBER() OVER (ORDER BY CURRENT_PROCESS asc) BARIS FROM APP_PROCESS,ADM_KEL_PRCGRP,PRC_TENDER_SAMPUL
 WHERE
				APP_PROCESS.KEL_PLANT_PRO=ADM_KEL_PRCGRP.KEL_PRCHGRP_ID AND APP_PROCESS.TIPE_SAMPUL=PRC_TENDER_SAMPUL
.PRC_SAMPUL_ID  and UPPER(APP_PROCESS.KEL_PLANT_PRO) = '2'  and UPPER(APP_PROCESS.TIPE_SAMPUL) = '3'
  and APP_PROCESS.JUSTIFICATION = 1  AND COMPANYID='7000'";
			
			}
  		$data1 = $this->m_global->grid_view($sql)->result_array();

				
				foreach($data1 as $line){
					
					$sql1="SELECT CURRENT_PROCESS, PROCESS_MASTER_ID, PROCESS_ID, NAMA_BARU, ASSIGNMENT, NAMA_KEL_PRCHGRP
 COMPANYNAME, APP_PROCESS.COMPANYID, IS_ASSIGN, TIPE_SAMPUL, PRC_SAMPUL_NAME, IDENTITAS_PROCCESS, KEL_PLANT_PRO
,ROW_NUMBER() OVER (ORDER BY CURRENT_PROCESS asc) BARIS FROM APP_PROCESS,ADM_KEL_PRCGRP,PRC_TENDER_SAMPUL
 WHERE APP_PROCESS.KEL_PLANT_PRO=ADM_KEL_PRCGRP.KEL_PRCHGRP_ID AND APP_PROCESS.TIPE_SAMPUL=PRC_TENDER_SAMPUL
.PRC_SAMPUL_ID  and UPPER(APP_PROCESS.KEL_PLANT_PRO) = '".$tdku['nama_company']."'  and UPPER(APP_PROCESS.TIPE_SAMPUL) = '".$tdku['sampul']."'
  and APP_PROCESS.JUSTIFICATION = '".$tdku['just']."'  AND COMPANYID='".$tdku['company']."' and CURRENT_PROCESS='".$line['CURRENT_PROCESS']."'";
  
  							
							$totalData =$this->m_global->total_row($sql1);
							
							if($totalData==0){
								
									$new_menu=array();
									$new_menu['NAMA_BARU'] = $line['NAMA_BARU'];
									$new_menu['CURRENT_PROCESS'] = $line['CURRENT_PROCESS'];
									$new_menu['TIPE_SAMPUL'] = $tdku['sampul'];
									$new_menu['COMPANYID'] = $tdku['company'];
									$new_menu['PROCESS_MASTER_ID'] = $line['PROCESS_MASTER_ID'];
									$new_menu['ASSIGNMENT'] = $line['ASSIGNMENT'];
									$new_menu['IDENTITAS_PROCCESS'] = $line['IDENTITAS_PROCCESS'];
									$new_menu['KEL_PLANT_PRO'] = $tdku['nama_company'];
									$new_menu['IS_ASSIGN'] = $line['IS_ASSIGN'];
									$new_menu['JUSTIFICATION'] = $tdku['just'];
									
									$this->m_global->insert_custom('APP_PROCESS',$new_menu);
									$maxid_app_proccess=$this->m_global->get_id('PROCESS_ID','APP_PROCESS');
									$maxid_app_proccess=$maxid_app_proccess-1;
									if($maxid_app_proccess<0){
										$maxid_app_proccess=1;
										}
									//$process_user="INSERT INTO APP_PROCESS_ROLE (PROCESS_ID,ROLE) SELECT ".$maxid_app_proccess.",APP_PROCESS_ROLE.ROLE FROM APP_PROCESS_ROLE WHERE APP_PROCESS_ROLE.PROCESS_ID='".$line['PROCESS_ID']."'";
									//$this->m_global->grid_view($process_user);
									
									
									
							
								}
					
				}
				
				echo json_encode(array('ket'=>"Generate Berhasil")) ;
  		
		}

}