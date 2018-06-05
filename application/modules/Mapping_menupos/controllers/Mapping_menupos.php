<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		
        class Mapping_menupos extends CI_Controller {

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
		$this->layout->add_js('pages/group_akses_map_pos.js');
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
		//if($data_post['nama_posisi_f']!='') $filter_data.=" and UPPER(ADM_POS.JOB_TITLE) like '%".str_replace("'", "''", strtoupper($data_post['nama_posisi_f']))."%' "; 
		if($data_post['group_menu_f']!='') $filter_data.=" and UPPER(APP_GRP_MENU.NAMA_GRP) like '%".str_replace("'", "''", strtoupper($data_post['group_menu_f']))."%' "; 
		if($data_post['fullname_f']!='') $filter_data.=" and UPPER(ADM_EMPLOYEE.FULLNAME) like '%".str_replace("'", "''", strtoupper($data_post['fullname_f']))."%' ";
		if($data_post['email_f']!='') $filter_data.=" and UPPER(ADM_EMPLOYEE.EMAIL) like '%".str_replace("'", "''", strtoupper($data_post['email_f']))."%' "; 
		$i=0;
		$no=0;
		
		
		$colom=array('ADM_COMPANY.COMPANYNAME','ADM_DEPT.DEPT_NAME','ADM_POS.POS_NAME','ADM_POS.JOB_TITLE','APP_GRP_MENU.NAMA_GRP','ADM_POS.POS_ID','ADM_POS.GROUP_MENU','ADM_EMPLOYEE.FULLNAME', 'ADM_EMPLOYEE.EMAIL');
		
		$sql="SELECT ".implode(', ', $colom).",ROW_NUMBER() OVER (ORDER BY ".$colom[$data_post ['order'][0]['column']]." ".$data_post ['order'][0]['dir'].") BARIS FROM
	ADM_POS INNER JOIN ADM_DEPT ON ADM_POS.DEPT_ID=ADM_DEPT.DEPT_ID INNER JOIN ADM_COMPANY ON ADM_DEPT.DEPT_COMPANY=ADM_COMPANY.COMPANYID
	LEFT JOIN APP_GRP_MENU ON ADM_POS.GROUP_MENU=APP_GRP_MENU.APP_GRP_ID INNER JOIN ADM_EMPLOYEE ON ADM_POS.POS_ID=ADM_EMPLOYEE.ADM_POS_ID  WHERE POS_AKTIF=1 AND EM_STATUS=3 ".$filter_data; //$filter_data
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
			$data_tbl['COMPANYNAME']=$line['COMPANYNAME']; 
			$data_tbl['DEPT_NAME']=$line['DEPT_NAME'];
			$data_tbl['POS_NAME']=$line['POS_NAME'];
			$data_tbl['FULLNAME']=$line['FULLNAME'];
			$data_tbl['EMAIL']=$line['EMAIL'];
			
			$data_tbl['JOB_TITLE']=$line['JOB_TITLE'];
			$data_tbl['NAMA_GRP']=$line['NAMA_GRP'];
			$data_tbl['POS_ID']=$line['POS_ID'];
			$data_tbl['GROUP_MENU']=$line['GROUP_MENU'];
			
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
	
	
	
		}