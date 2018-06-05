<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		
        class Emp extends CI_Controller {

        public function __construct() {
                parent::__construct();
               
        $this->db = $this->load->database('default', TRUE);
        $this->load->helper("security" ); 
		$this->load->library(array('form_validation','session'));
        $this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->model('m_global');
		
            
        }

		function index(){
		
		
		$data['title'] = "Master Menu";
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		
		//$this->layout->set_table_selected_css();
		$this->layout->set_validate_css();
		//$this->layout->set_tree_css();
		//$this->layout->set_tree_js();
		$this->layout->set_validate_js();
		
		//
		$data["fk_ms_group_id03"]=$this->m_global->getcombo("SELECT APP_GRP_ID ID, NAMA_GRP NAMA FROM APP_GRP_MENU");
		$this->layout->add_js('pages/m_employee.js');
		$this->layout->render('v_ms_menu', $data);
        //$this->load->view('v_adm_plant',$data);
        
    }  
	function load_data_tree(){
		
		$this->load->view('v_unit_tree');
		}
		
	
	
	function getTree(){
		
		    	
				$da="SELECT MUK_KODE ID, MUK_KODE||' '|| MUK_NAMA||' '||MUK_LEVEL  TITLE,MUK_PARENT PARENT_ID,MUK_NAMA NAMA, COMPANY,MUK_KODE KODE FROM M_UB_UNIT_KERJA WHERE MUK_PARENT=0";// WHERE COMPANY=2000";
				$data['dataTree'] = $this->m_global->mapTree_unit($da);
		 		
				$dtree = $this->m_global->buildTree($data['dataTree']);
				echo json_encode($dtree);
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
		if($data_post['nama_company_f']!='') $filter_data.=" and UPPER(ADM_COMPANY.COMPANYNAME) like '%". str_replace("'", "''", strtoupper($data_post['nama_company_f']))."%' "; 
		if($data_post['nama_unit_f']!='') $filter_data.=" and UPPER(ADM_DEPT.DEPT_NAME) like '%".str_replace("'", "''", strtoupper($data_post['nama_unit_f']))."%' "; 
		if($data_post['nama_jabatan_f']!='') $filter_data.=" and UPPER(ADM_POS.POS_NAME) like '%".str_replace("'", "''", strtoupper($data_post['nama_jabatan_f']))."%' "; 
		if($data_post['kode_mkcctr']!='') $filter_data.=" and UPPER(ADM_EMPLOYEE.MKCCTR) like '%".str_replace("'", "''", strtoupper($data_post['kode_mkcctr']))."%' "; 
		//if($data_post['group_menu_f']!='') $filter_data.=" and UPPER(ADM_EMPLOYEE.EMAIL) like '%".str_replace("'", "''", strtoupper($data_post['group_menu_f']))."%' "; 
		if($data_post['fullname_f']!='') $filter_data.=" and UPPER(ADM_EMPLOYEE.FULLNAME) like '%".str_replace("'", "''", strtoupper($data_post['fullname_f']))."%' "; 
		$i=0;
		$no=0;
		
		
		$colom=array('ADM_COMPANY.COMPANYNAME','ADM_DEPT.DEPT_NAME','ADM_POS.POS_NAME','ADM_POS.JOB_TITLE','ADM_EMPLOYEE.ID','ADM_EMPLOYEE.EMAIL','ADM_POS.POS_ID','ADM_POS.GROUP_MENU','ADM_EMPLOYEE.FULLNAME','ADM_EMPLOYEE.MKCCTR');
		
		$sql="SELECT ".implode(', ', $colom).",ROW_NUMBER() OVER (ORDER BY ".$colom[$data_post ['order'][0]['column']]." ".$data_post ['order'][0]['dir'].") BARIS FROM
	ADM_POS INNER JOIN ADM_DEPT ON ADM_POS.DEPT_ID=ADM_DEPT.DEPT_ID INNER JOIN ADM_COMPANY ON ADM_DEPT.DEPT_COMPANY=ADM_COMPANY.COMPANYID
	 INNER JOIN ADM_EMPLOYEE ON ADM_POS.POS_ID=ADM_EMPLOYEE.ADM_POS_ID  WHERE POS_AKTIF=1 AND EM_STATUS=3 ".$filter_data; //$filter_data
	//INNER JOIN ADM_EMPLOYEE ON ADM_POS.POS_ID=ADM_EMPLOYEE.ADM_POS_ID 
		//echo $sql; exit();
		$totalData =$this->m_global->total_row($sql);
		$totalFiltered = $totalData;
		$sql= " SELECT * FROM (".$sql.") WHERE BARIS BETWEEN ".$mulai." AND ".$akhir ;
		//echo $sql; exit();
		$data1 = $this->m_global->grid_view($sql)->result_array();
		
		$data=array();
		foreach($data1 as $line){
			$data_tbl=array();
			$data_tbl['BARIS']=$line['BARIS'];
			$data_tbl['ID']=$line['ID']; 
			$data_tbl['COMPANYNAME']=$line['COMPANYNAME']; 
			$data_tbl['DEPT_NAME']=$line['DEPT_NAME'];
			$data_tbl['POS_NAME']=$line['POS_NAME'];
			$data_tbl['FULLNAME']=$line['FULLNAME'];
			$data_tbl['MKCCTR']=$line['MKCCTR'];
			
			$data_tbl['JOB_TITLE']=$line['JOB_TITLE'];
			$data_tbl['POS_ID']=$line['POS_ID'];
			$data_tbl['EMAIL']=$line['EMAIL'];
			$data_tbl['ID']=$line['ID'];
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
	
	
	function simdata() {
			
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		
	    $data_post=$this->input->post();
		$this->form_validation->set_rules('nama_unit', 'Nama Unit', 'required');
		$this->form_validation->set_rules('nama_jabatan', 'Nama Jabatan', 'required');
		$this->form_validation->set_rules('fk_ms_group_id03', 'Group Akses', 'required');
		
	//	$data['title'] = "Master Menu";
		if ($this->form_validation->run() == FALSE) {
			
			if(form_error('nama_unit')){
				
				$data['inputerror'][] = 'nama_unit';
				$data['error_string'][] = 'Unit name is required';
				$data['status'] = FALSE;
				
				}
			if(form_error('nama_jabatan')){
				
				$data['inputerror'][] = 'nama_jabatan';
				$data['error_string'][] = 'Jabatan name is required';
				$data['status'] = FALSE;
				
				}
			if(form_error('fk_ms_group_id03')){
				
				$data['inputerror'][] = 'fk_ms_group_id03';
				$data['error_string'][] = 'Group name is required';
				$data['status'] = FALSE;
				
				}
			
				
			echo json_encode(array('dt'=>$data));
			exit();
			
		}
		
		$new_menu=array();
		//$new_menu['NAMA_GRP'] = $data_post['pos_id'];
		
		
	    switch ($data_post['act']) {
			
	      /*  case 'Simpan':
			
				//$new_menu['NAMA_GRP'] = $this->m_global->get_id('NAMA_GRP');
				
				if($this->m_global->insert_custom('APP_GRP_MENU',$new_menu)){
					echo json_encode(array('ket'=>"Penambahan Data Berhasil",'dt'=>$data)) ;
					
					}else{
						echo json_encode(array('ket'=>"Gagal Insert",'dt'=>$data)) ;
						}
				
				break;*/
	        case 'Ubah':
				$new_menu['GROUP_MENU'] = $data_post['fk_ms_group_id03'];
				$where=array();
				$where['POS_ID']=$data_post['pos_id'];
				if($this->m_global->update('ADM_POS',$new_menu,$where)){
				echo json_encode(array('ket'=>"Update Data Berhasil",'dt'=>$data)) ;
				}
				else{
					echo json_encode(array('ket'=>"Gagal Update",'dt'=>$data)) ;
				}
			 
	          
	            break;
	        case 'Hapus':
				$new_menu['GROUP_MENU'] = 0;
				$where=array();
				$where['POS_ID']=$data_post['pos_id'];
				if($this->m_global->update('ADM_POS',$new_menu,$where)){
				echo json_encode(array('ket'=>"Update Data Berhasil",'dt'=>$data)) ;
				}
				else{
					echo json_encode(array('ket'=>"Gagal Update",'dt'=>$data)) ;
				}
	           
	        break;
		}
	}

	public function update(){
		$btn = $this->input->post('btn');
		$CI = &get_instance();
		$db2 = $CI->load->database('hris_prod', TRUE);
		
		if($btn=='Departemen'){
			$this->db->empty_table('HRIS_V_UNIT_KERJA');

			$slc_dept = $db2->select('company AS COMPANY,muk_begda AS MUK_BEGDA,muk_cctr AS MUK_CCTR,muk_endda AS MUK_ENDDA,
				muk_kode AS MUK_KODE,muk_level AS MUK_LEVEL,muk_nama AS MUK_NAMA,muk_parent AS MUK_PARENT,muk_short AS MUK_SHORT')->get('v_unit_kerja');
			$numrows = $slc_dept->num_rows(); 
			if($numrows > 0){
			  	$this->db->insert_batch('HRIS_V_UNIT_KERJA', $slc_dept->result_array());
			}

		}else if($btn=='Jabatan'){
			$this->db->empty_table('HRIS_V_JABATAN');

			$slc_jab = $db2->select('mjab_kode AS MJAB_KODE,mjab_nama AS MJAB_NAMA,company AS COMPANY,muk_kode AS MUK_KODE,
				mjab_emp_subgroup AS MJAB_EMP_SUBGROUP,mjab_emp_subgroup_txt AS MJAB_EMP_SUBGROUP_TXT,mjab_begda AS MJAB_BEGDA,
				mjab_endda AS MJAB_ENDDA,is_chief AS IS_CHIEF')->get('v_jabatan');
			$numrows = $slc_jab->num_rows(); 
			if($numrows > 0){
			  	$this->db->insert_batch('HRIS_V_JABATAN', $slc_jab->result_array());
			}
		}else if($btn=='Employee'){
			$this->db->empty_table('HRIS_V_KARYAWAN');

			$slc_emp = $db2->select('mk_nopeg AS MK_NOPEG,mk_nama AS MK_NAMA,mcomp_kode AS MCOMP_KODE,mdir_kode AS MDIR_KODE,
				mdept_kode AS MDEPT_KODE,mbiro_kode AS MBIRO_KODE,msect_kode AS MSECT_KODE, mgrp_kode AS MGRP_KODE,muk_kode AS MUK_KODE,
				mk_unit AS MK_UNIT,mjab_kode AS MJAB_KODE,mjk_kode AS MJK_KODE,mjf_kode AS MJF_KODE,mjg_kode AS MJG_KODE, mk_cctr AS MK_CCTR,
				mk_cctr_txt AS MK_CCTR_TXT,mk_cctr_text AS MK_CCTR_TEXT,mk_emp_group AS MK_EMP_GROUP,mk_emp_group_text AS MK_EMP_GROUP_TEXT,
				mk_emp_subgroup AS MK_EMP_SUBGROUP,mk_emp_subgroup_text AS MK_EMP_SUBGROUP_TEXT,company AS COMPANY,company_text AS COMPANY_TEXT,
				persarea AS PERSAREA,persarea_text AS PERSAREA_TEXT,cp_kode AS CP_KODE,mk_nopeg_lama AS MK_NOPEG_LAMA,mk_nama2 AS MK_NAMA2,
				mk_tgl_lahir AS MK_TGL_LAHIR,mk_jenis_kel_code AS MK_JENIS_KEL_CODE,mk_jenis_kel AS MK_JENIS_KEL,mk_perkawinan AS MK_PERKAWINAN,
				mk_tgl_masuk AS MK_TGL_MASUK, mk_tgl_pensiun AS MK_TGL_PENSIUN,mk_tgl_meninggal AS MK_TGL_MENINGGAL,mk_eselon_code AS MK_ESELON_CODE,
				mk_eselon AS MK_ESELON,mk_kontrak AS MK_KONTRAK,mk_kontrak_desc AS MK_KONTRAK_DESC,mk_status AS MK_STATUS,mk_action AS MK_ACTION,
				mk_action_text AS MK_ACTION_TEXT,mk_stat2 AS MK_STAT2,mk_stat2_text AS MK_STAT2_TEXT,mk_py_area AS MK_PY_AREA,mk_py_area_text AS MK_PY_AREA_TEXT,
				sap_user AS SAP_USER,lokasi_code AS LOKASI_CODE,lokasi AS LOKASI,mk_email AS MK_EMAIL,mk_tipe AS MK_TIPE,mk_changed_on AS MK_CHANGED_ON,batchId AS BATCHID
			')->get('v_karyawan');
			$numrows = $slc_emp->num_rows();
			if($numrows > 0){
			  	$this->db->insert_batch('HRIS_V_KARYAWAN', $slc_emp->result_array());
			}
		}else if($btn=='Atasan'){
			$this->db->empty_table('HRIS_V_ATASAN');

			$slc_ats = $db2->select('mk_nopeg AS MK_NOPEG,mk_unit AS MK_UNIT,muk_kode AS MUK_KODE,mjab_kode AS MJAB_KODE,company AS COMPANY,
				atasan1_level AS ATASAN1_LEVEL,atasan1_unit AS ATASAN1_UNIT,atasan1_jabat AS ATASAN1_JABAT,atasan1_nopeg AS ATASAN1_NOPEG,
				atasan1_pgs AS ATASAN1_PGS,atasan2_level AS ATASAN2_LEVEL,atasan2_unit AS ATASAN2_JABAT,atasan2_nopeg AS ATASAN2_NOPEG,
				atasan2_pgs AS ATASAN2_PGS,changed_on AS CHANGED_ON,batchId AS BATCHID
			')->get('v_atasan');
			$numrows = $slc_ats->num_rows(); 
			if($numrows > 0){
			  	$this->db->insert_batch('HRIS_V_ATASAN', $slc_ats->result_array());
			}
		}else{
			die('error');
		}

		echo 'ok';
	} 
	
	
	
}