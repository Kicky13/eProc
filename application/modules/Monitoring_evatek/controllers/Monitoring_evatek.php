<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring_evatek extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->model('m_global');
	}

	public function index($cheat = false) {
		$data['title'] = "Monitoring Evatek";
		$data['cheat'] = $cheat;
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->set_validate_css();
		$this->layout->set_validate_js();
		$this->layout->add_js('pages/monitor_evatek.js');		
		$this->layout->add_js("strTodatetime.js");
		$this->layout->render('list', $data);
	}

	public function detail($id){
		$this->load->model('adm_dept');
		$this->load->model('adm_employee');
		$this->load->model('app_process_master');
		$this->load->model('prc_do_evatek_uraian');
		$this->load->model('prc_eval_file');
		$this->load->model('prc_evaluasi_teknis');
		$this->load->model('prc_evaluasi_uraian');
		$this->load->model('prc_add_item_evaluasi');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('prc_tender_quo_main');
		$this->load->model('prc_tender_vendor');
		$this->load->model('prc_chat');

		$this->load->library('snippet');

		$data['title'] = 'Monitoring Evatek';
		$data['evaluator'] = $this->snippet->evaluator($id);
		$data['evaluasi'] = $this->snippet->evaluasi($id, false, false);
		$data['vendor_ptm'] = $this->snippet->vendor_ptm($id, true);

		$this->prc_add_item_evaluasi->where_ptm($id);
		$data['dokumentambahan'] = $this->prc_add_item_evaluasi->get();

		$ptm = $this->prc_tender_main->prc_tender_main->ptm($id);
		$ptm = $ptm[0];

		$this->load->model('prc_evaluator');
		$counter = $this->prc_evaluator->get_max_counter($id, $ptm['PTM_COUNT_RETENDER']);

		$this->prc_evaluator->where_status('0');
		$this->counter = $this->prc_evaluator->get_max_counter($id, $ptm['PTM_COUNT_RETENDER']);

		if ($this->counter == $counter) {
			$data['bisaevaluasi'] = true;
		} else {
			$data['bisaevaluasi'] = false;
		}

		/********************************************************************/
		$data['tit'] = $this->prc_tender_item->ptm($id);

		$this->prc_tender_vendor->where_active();
		$data['ptv'] = $this->prc_tender_vendor->ptm($id);
		foreach ((array)$data['ptv'] as $key => $val) {
			$this->prc_eval_file->where_ptm_ptv($id, $val['PTV_VENDOR_CODE']);
			$ef = $this->prc_eval_file->get();
			if(!empty($ef[0]['EF_FILE'])){
				$data['pef'][$val['PTV_VENDOR_CODE']] = $ef[0]['EF_FILE'];
			}
		}

		/* Ngambil PQI */
		foreach ($data['ptv'] as $vnd) {
			/* Ngisi tabel buat pilih pemenang */
			foreach ($data['tit'] as $tit) {
				$this->prc_tender_quo_item->where_tit($tit['TIT_ID']);
				$pqi = $this->prc_tender_quo_item->ptm_ptv($id, $vnd['PTV_VENDOR_CODE']);
				// $data['pqis'][] = $pqi;
				if ($pqi != null) {
					$pqi = $pqi[0];
					$data['pqi'][$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']] = $pqi;
				}
			}
		}

		$this->prc_evaluasi_teknis->where_ptm($id);
		$ppd = $this->prc_evaluasi_teknis->get();
		foreach ($ppd as $val) {
			$p = $this->prc_evaluasi_uraian->get(array('ET_ID' => $val['ET_ID']));
			foreach ($p as $pe2) {
				$peuu[$pe2['ET_ID']][$pe2['TIT_ID']][$pe2['EU_NAME']]=$pe2;
				$data['peu2'][$val['ET_ID']][$pe2['TIT_ID']][$pe2['EU_NAME']][]=$pe2;
			}
		}

		foreach ($ppd as $val) {
			$pe = $this->prc_evaluasi_uraian->get(array('ET_ID' => $val['ET_ID']));
			$data['ppd2'][$pe[0]['TIT_ID']][]=$val;
			
			$pee = $this->prc_evaluasi_uraian->get_dist(array('ET_ID' => $val['ET_ID']));
			foreach ($pee as $value) {
				$eu_id = '';
				$eu_weight = '';
				if(isset($peuu[$val['ET_ID']][$pe[0]['TIT_ID']][$value['EU_NAME']])){
					$eu_id = $peuu[$val['ET_ID']][$pe[0]['TIT_ID']][$value['EU_NAME']]['EU_ID'];
					$eu_weight = $peuu[$val['ET_ID']][$pe[0]['TIT_ID']][$value['EU_NAME']]['EU_WEIGHT'];
				}
				$data['peu'][$val['ET_ID']][$pe[0]['TIT_ID']][] = array(
																		'EU_ID' => $eu_id,
																		'EU_NAME' => $value['EU_NAME'],
																		'EU_WEIGHT' => $eu_weight,
																	);
			}
		}

		$this->prc_do_evatek_uraian->where_ptm($id);
		$deu = $this->prc_do_evatek_uraian->get();
		foreach ($deu as $val) {
			$data['det'][$val['TIT_ID']][$val['ET_ID']][$val['PTV_VENDOR_CODE']] = $val;
			$data['deu'][$val['TIT_ID']][$val['ET_ID']][$val['PTV_VENDOR_CODE']][$val['EU_ID']] = $val;
			
		}

		$data['vendor_data'] = $this->prc_tender_quo_main->get_join(array('PRC_TENDER_QUO_MAIN.PTM_NUMBER' => $id));
		// var_dump($data); exit();
		/********************************************************************/

		$this->prc_chat->order_tgl();
		$this->prc_chat->join_employee_vendor();
		$this->prc_chat->status_process_master_id(array(9,10));
		$ps['pesan'] = $this->prc_chat->get(array('PRC_CHAT.PTM_NUMBER'=>$id));
		$ps['balas'] = false;

		$data['pesan'] = $this->load->view('Evaluasi_penawaran/history_pesan', $ps, true);;
		$data['ptm_comment'] = $this->snippet->ptm_comment($id, array(9,10));
		
		$this->layout->render('detail',$data);
	}

	public function get_datatable() {
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_item');
		$this->prc_tender_main->join_latest_activity();
		
		$this->prc_tender_main->join_prep();
		$this->prc_tender_main->master_id(9);
		$this->prc_tender_main->status_ptm(-11);
		$this->prc_tender_main->join_evaluator();
		$this->prc_tender_main->where_evaluator($this->session->userdata('ID'));
		$data = array();

		$datatable = $this->prc_tender_main->get(null, false, null, true);
		foreach ((array)$datatable as $key => $val) {
			if($val['MASTER_ID']==15){
				$rg=array();
				$pti = $this->prc_tender_item->ptm($val['PTM_NUMBER']);
				foreach ($pti as $value) {
					$rg[]=$value['TIT_STATUS'];				
				}
				$datatable[$key]['TIT_STATUS_GROUP']=$rg;
			}
		}		
		
		$data = array('data' => isset($datatable)?$datatable:'');
		echo json_encode($data);
	}

}