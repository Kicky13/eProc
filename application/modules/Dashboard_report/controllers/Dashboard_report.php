<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_report extends CI_Controller {

	private $allpgrp = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
	}

	public function PO()
	{
		$this->load->model('adm_purch_grp');
		$this->load->model('prc_purchase_requisition');
		$data['pgrp'] = $this->adm_purch_grp->get();
		$data['title'] = "Dashboard PO";
		$data['post'] = $this->input->post();
		$this->adm_purch_grp->join_ppr();
		$this->adm_purch_grp->join_opco();
		if($data['post']){
			if(isset($data['post']['pgrp'])){
				$this->adm_purch_grp->where_pgrp($data['post']['pgrp']);
			}
			if(isset($data['post']['opco'])){
				$this->adm_purch_grp->where_company_id($data['post']['opco']);
			}
		}
		$data['ppr'] = $this->adm_purch_grp->get();
		$ppr = array();
		foreach ($data['ppr'] as $key => $value) {
			$tgl = oraclestrtotime($value['PPR_DATE_RELEASE']);
			if(isset($data['post']['tahun'])){
				if(in_array(date("Y", $tgl), $data['post']['tahun'])){
					$ppr[] = $value;
				}
			} else {
				$ppr[] = $value;
			}
		}
		$data['ppr'] = $ppr;
		$ppr2 = array();
		foreach ($data['ppr'] as $key => $value) {
			$tgl = oraclestrtotime($value['PPR_DATE_RELEASE']);
			if(isset($data['post']['bulan'])){
				if(in_array(date("m", $tgl), $data['post']['bulan'])){
					$ppr2[] = $value;
				}
			} else {
				$ppr2[] = $value;
			}
		}
		$data['ppr'] = $ppr2;
		$this->layout->set_table_js();
		$this->layout->set_table_cs();
		$this->layout->render('PR',$data);
	}

	public function pr() {
		$this->load->model('adm_purch_grp');
		$data['title'] = "Dashboard PR";
		$data['post'] = $this->input->post();
		//$data = array_merge($data, $this->get_list_item($data['post']));

		$allpgrp = $this->adm_purch_grp->get();
		$this->allpgrp = array_build_key($allpgrp, 'PURCH_GRP_CODE');
		$data['pgrp'] = $this->allpgrp;

		// $this->layout->set_table_js();
		// $this->layout->set_table_cs();
		$this->layout->add_css('plugins/select2/select2.css');
		$this->layout->add_css('plugins/select2/select2-bootstrap.css');
		$this->layout->add_js('plugins/select2/select2.js');

		/*plugin untuk jqplot*/
		$this->layout->add_css('jquery.jqplot.css');
		$this->layout->add_js('plugins/jquery.jqplot.js');
		$this->layout->add_js('plugins/jqplot-plugins/jqplot.barRenderer.js');
		$this->layout->add_js('plugins/jqplot-plugins/jqplot.categoryAxisRenderer.js');
		$this->layout->add_js('plugins/jqplot-plugins/jqplot.canvasAxisTickRenderer.js');
		$this->layout->add_js('plugins/jqplot-plugins/jqplot.canvasTextRenderer.js');
		$this->layout->add_js('plugins/jqplot-plugins/jqplot.canvasOverlay.js');
		$this->layout->add_js('plugins/jqplot-plugins/jqplot.pointLabels.js');

		$this->layout->add_js('pages/dashboard_pr.js');
		$this->layout->render('PR',$data);
	}

	public function CetakDetail($data) {
		// $data = $this->monitor($paqh, $print=true);
		$filter = $this->input->post('filter');
		$length = $this->input->post('length');
		$start = $this->input->post('start');				
		$draw = $this->input->post('draw');			
		$saringan = array();
		if($filter){
			foreach($filter as $value) {
				$saringan[str_replace("[]","",$value['name'])][] = $value['value'];
			}
		}
		

		$data = $this->get_dash_list_item($saringan);	
		$recordsTotal = count($data['pritem']);
		$data = array_slice($data['pritem'],$start,$length);
		$recordsFiltered = count($data);
		$result = array(
			"length"=>$length,
			"start"=>$start,
			"draw"            => intval($draw), 
			"recordsTotal"    => intval($recordsTotal),  
			"recordsFiltered" => intval($recordsTotal),
			"data"            => $data   
			);     
		echo"<pre>";   
		print_r($result);die;

		$this -> load -> helper(array('dompdf', 'file'));
		$html = $this -> load -> view('ec_cetak_log', $result, true);
		$filename = 'Auction';
		$paper = 'A4';
		$orientation = 'potrait';
		pdf_create($html, $filename, $paper, $orientation, false);

	}

	public function get_list_item($filter = array()) {
		$this->load->model('adm_purch_grp');
		$this->load->model('po_detail');
		$this->load->model('prc_pr_item');
		$this->load->model('prc_tender_comment');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');

		$this->prc_pr_item->join_pr();
		$allpgrp = $this->adm_purch_grp->get();
		$this->allpgrp = array_build_key($allpgrp, 'PURCH_GRP_CODE');
		$kelopco = array(2 => 'Gresik', 3 => 'Padang', 4 => 'Tonasa');

		if ($filter && !empty($filter)) {
			if (isset($filter['opco']) && !empty($filter['opco'])) {
				$this->adm_purch_grp->join_opco();
				$this->adm_purch_grp->where_kel_company($filter['opco']);
				$pgrp = $this->adm_purch_grp->get();
				foreach ((array) $pgrp as $key => $value) {
					$filteropco[] = $value['PURCH_GRP_CODE'];
				}
				if (isset($filteropco) && !empty($filteropco)) {
					$this->prc_pr_item->where_pgrp_in($filteropco);
				}
			}

			if (isset($filter['pgrp']) && !empty($filter['pgrp'])) {
				$this->prc_pr_item->where_pgrp_in($filter['pgrp']);
			}

		}
		$pritem = $this->prc_pr_item->get();
		$diff = array();
		$no=1;
		foreach ($pritem as $key => $val) {
			$pritem[$key]['NO']=$no++;
			/* Filter tahun dan bulan */
			if (isset($filter['tahun']) && !empty($filter['tahun'])) {
				if($val['PPR_DATE_RELEASE'] == null || !in_array(date("Y", oraclestrtotime($val['PPR_DATE_RELEASE'])), $filter['tahun'])) {
					unset($pritem[$key]);
					continue;
				}
			}

			if (isset($filter['bulan']) && !empty($filter['bulan'])) {
				if($val['PPR_DATE_RELEASE'] == null || !in_array(date("m", oraclestrtotime($val['PPR_DATE_RELEASE'])), $filter['bulan'])) {
					unset($pritem[$key]);
					continue;
				}
			}
			//*/

			/* Generate Performance Chart Data */
			if ($pritem[$key]['DOC_UPLOAD_DATE'] != '') {
				$performance['submit'][] = $val['PPI_PRNO'];
			}
			//*/
			$pritem[$key]['COMPANY'] = $kelopco[$this->allpgrp[$val['PPR_PGRP']]['KEL_PURCH_GRP']];

			$pritem[$key]['APPROVAL'] = $val['PPR_DATE_RELEASE'];
			$pritem[$key]['SUBMIT_DOC'] = $val['DOC_UPLOAD_DATE'];
			$diff['upload'][] = $this->days_diff($val['PPR_DATE_RELEASE'], $val['DOC_UPLOAD_DATE']);
			$item = $this->prc_tender_item->get(array('PRC_TENDER_ITEM.PPI_ID' => $val['PPI_ID']));
			$pritem[$key]['SUBPRATENDER'] = '';			
			$pritem[$key]['PRATENDER'] = '';			
			$pritem[$key]['OPENING'] = '';			
			$pritem[$key]['CLOSING'] = '';	
			$pritem[$key]['RFQ_CREATED'] = '';	
			$pritem[$key]['KONFIGURASI'] = '';
			$pritem[$key]['EVATEK_APPROVE'] = '';	
			$pritem[$key]['EVATEK'] = '';	
			$pritem[$key]['WIN_AT'] = '';	
			$pritem[$key]['PO_RELASED'] = '';	
			$pritem[$key]['PO_CREATED'] = '';				
			if (count($item) > 0) {
				$ptm_number = $item[0]['PTM_NUMBER'];
				$ptm = $this->prc_tender_main->ptm($ptm_number);
				$ptm = $ptm[0];
				$ptp = $this->prc_tender_prep->ptm($ptm_number);

				$pritem[$key]['SUBPRATENDER'] = $ptm['PTM_SUBPRATENDER'];
				$pritem[$key]['PRATENDER'] = $ptm['PTM_PRATENDER'];
				if ($ptm['PTM_SUBPRATENDER'] != '') {
					$performance['subpratender'][] = $ptm['PTM_SUBPRATENDER'];
				}
				if ($ptm['PTM_PRATENDER'] != '') {
					$performance['pratender'][] = $ptm['PTM_PRATENDER'];
					$performance['quot_deadline'][] = $ptp['PTP_REG_CLOSING_DATE'];
				}

				$this->prc_tender_comment->where_activity('Konfigurasi Perencanaan');
				$comment = $this->prc_tender_comment->ptm($ptm_number);
				$pritem[$key]['KONFIGURASI'] = @$comment[0]['PTC_END_DATE'];

				$diff['konf'][] = $this->days_diff($val['DOC_UPLOAD_DATE'], $pritem[$key]['KONFIGURASI']);

				$pritem[$key]['OPENING'] = $ptp['PTP_REG_OPENING_DATE'];
				$pritem[$key]['CLOSING'] = $ptp['PTP_REG_CLOSING_DATE'];

				$pritem[$key]['RFQ_CREATED'] = '';
				$rfqbenar = '';
				if ($ptm['PTM_PRATENDER'] != '') {
					$this->prc_tender_comment->where_activity('Approval Pengadaan');
					$comment = $this->prc_tender_comment->ptm($ptm_number);
					$pritem[$key]['RFQ_CREATED'] = @$comment[0]['PTC_END_DATE'];

					if (oraclestrtotime($pritem[$key]['OPENING']) > oraclestrtotime($pritem[$key]['RFQ_CREATED'])) {
						$rfqbenar = $pritem[$key]['OPENING'];
					} else {
						$rfqbenar = $pritem[$key]['RFQ_CREATED'];
					}

					$diff['rfq'][] = $this->days_diff($pritem[$key]['KONFIGURASI'], $rfqbenar);
					$diff['rfq_closed'][] = $this->days_diff($rfqbenar, $pritem[$key]['CLOSING']);
				}

				$this->prc_tender_comment->where_activity('Approval Pengajuan Evaluasi Teknis');
				$comment = $this->prc_tender_comment->ptm($ptm_number);
				$pritem[$key]['EVATEK_APPROVE'] = @$comment[0]['PTC_END_DATE'];

				$diff['evatek_approve'][] = $this->days_diff($pritem[$key]['CLOSING'], $pritem[$key]['EVATEK_APPROVE']);
				$performance['evatek_approve'][] = $pritem[$key]['EVATEK_APPROVE'];

				$this->prc_tender_comment->where_activity('Evaluasi Teknis');
				$comment = $this->prc_tender_comment->ptm($ptm_number);
				$pritem[$key]['EVATEK'] = @$comment[0]['PTC_END_DATE'];

				$pritem[$key]['WIN_AT'] = $item[0]['WIN_AT'];

				$diff['evatek_do'][] = $this->days_diff($pritem[$key]['EVATEK_APPROVE'], $pritem[$key]['EVATEK']);
				$performance['evatek'][] = $pritem[$key]['EVATEK'];
				$diff['nego'][] = $this->days_diff($pritem[$key]['EVATEK'], $pritem[$key]['WIN_AT']);
				$performance['nego'][] = $pritem[$key]['WIN_AT'];


				$po = $this->po_detail->get(true, array('PPI_ID' => $val['PPI_ID']));
				if (count($po) > 0) {
					$po = $po[0];
					$pritem[$key]['PO_CREATED'] = $po['PO_CREATED_AT'];
					$pritem[$key]['PO_RELASED'] = $po['RELEASED_AT'];
					if ($po['PO_CREATED_AT'] != '') {
						$performance['po_created'][] = $po['PO_NUMBER'];
					}
					if ($po['RELEASED_AT'] != '') {
						$performance['po_released'][] = $po['PO_NUMBER'];
					}
					$diff['po_date'][] = $this->days_diff($pritem[$key]['WIN_AT'], $po['PO_CREATED_AT']);
					$diff['po_release'][] = $this->days_diff($po['PO_CREATED_AT'], $po['RELEASED_AT']);
					// var_dump($po['PO_CREATED_AT']);
					// var_dump($po['RELEASED_AT']);
					// var_dump($diff['po_release']);
				}
			}
		}
		// die();

		/* Generate data for chart */
		//'Doc Submit','Usulan Subpratender','Pratender','Quot Deadline','Pengiriman Evatek','Evatek','Negosiasi','PO Created','PO Released'		
		$leadtime = array('upload', 'konf', 'rfq', 'rfq_closed', 'evatek_approve', 'evatek_do', 'nego', 'po_date', 'po_release');
		foreach ($leadtime as $title) {
			$diffcount[$title] = 0;
			$realdiff[$title] = 0;
			foreach ((array) @$diff[$title] as $key => $val) {
				if ($val === null) continue;
				$realdiff[$title] += $val;
				$diffcount[$title]++;
			}
			$diffavg[$title] = $diffcount[$title] == 0 ? 0 : round($realdiff[$title] / $diffcount[$title]);
		}

		$data['pritem'] = $pritem;
		$data['diffavg'] = $diffavg;
		$data['diffcount'] = $diffcount;
		$data['realdiff'] = $realdiff;
		//*/

		//'Doc Submit','Usulan Subpratender','Pratender','Quot Deadline','Pengiriman Evatek','Evatek','Negosiasi','PO Created','PO Released'
		$performance_title = array('submit', 'subpratender', 'pratender','quot_deadline','evatek_approve','evatek','nego', 'po_created', 'po_released');
		foreach ($performance_title as $title) {
			$data['performance'][$title]['total'] = isset($performance[$title]) ? count($performance[$title]) : 0;
			$data['performance'][$title]['sub'] = isset($performance[$title]) ? count(array_unique($performance[$title])) : 0;
		}

		// echo date(bettertimeformat());
		// var_dump($data);
		return $data;
	}

	public function days_diff($date1, $date2) {
		if ($date1 != '' && $date2 != '' && $date1 != null && $date2 != null) {
			return day_difference(oraclestrtotime($date1), oraclestrtotime($date2));
		} else {
			return null;
		}
	}

	public function get_pgrp(){
		$this->load->model('adm_purch_grp');		
		$opco = $this->input->post('opco');
		if(isset($opco)&&!empty($opco)){
			$this->adm_purch_grp->where_kel_company($opco);
			$pgrp = $this->adm_purch_grp->get();
			$res = array();
			foreach ($pgrp as $value) {
				$res[]=$value['PURCH_GRP_CODE'];
			}
			echo json_encode($res);
		}
	}

	public function oracle_to_date($data_date,$format_date){
		$res_date = array();
		if(is_array($data_date)){
			foreach ($data_date as $value) {
				$res_date[]="'TO_DATE('".$value."', '".$format_date."')'";
			}
		}else{
			$res_date[]="'TO_DATE(".$data_date.", '".$format_date."')";
		}
		return $res_date;
	}

	public function get_list_item_json(){
		$filter = $this->input->post();		
		$diffavg = $this->get_dash_leadtime($filter); 
		$performance = $this->get_dash_performance($filter);
		//$data = $this->get_dash_list_item($filter); 
		$data = array_merge($diffavg,$performance);
		echo json_encode($data);
	}

	public function get_dash_leadtime($filter = array()){
		$saringan = array();
		$this->load->model('dash_leadtime');
		
		$saringan = array(
			'KEL_PURCH_GRP'=>@$filter['opco'],
			'PPR_PGRP'=>@$filter['pgrp'],
			'TO_CHAR("PPR_DATE_RELEASE",'."'YYYY'".')'=>@$filter['tahun'],
			'TO_CHAR("PPR_DATE_RELEASE",'."'MM'".')'=>@$filter['bulan'],
			);		
		
		
		$diff = $this->dash_leadtime->get_list_item($saringan);		
		$leadtime = array('upload', 'konf', 'rfq', 'rfq_closed', 'evatek_approve', 'evatek_do', 'nego', 'po_date', 'po_release');
		$table_column = array('DAY_UPLOAD', 'DAY_CONFIG', 'DAY_RFQ', 'DAY_RFQ_CLOSE', 'DAY_EVATEK_APRV', 'DAY_EVATEK', 'DAY_NEGO', 'DAY_PO', 'DAY_PO_RELEASE');
		$leadtime_column = array_combine($leadtime,$table_column);
		$diffcount = array_combine($leadtime,array(0,0,0,0,0,0,0,0,0));
		$realdiff = $diffcount;
		foreach ($diff as $key => $value) {
			foreach ($leadtime_column as $k => $v) {
				if($value[$v] === null) continue;
				$realdiff[$k]+=$value[$v];
				$diffcount[$k]++;
			}			
		}

		foreach ($leadtime as $title) {			
			$diffavg[$title] = $diffcount[$title] == 0 ? 0 : round($realdiff[$title] / $diffcount[$title]);
		}
		$data['diffavg'] = $diffavg;
		return $data;
		// die(var_dump($data));
	}

	public function get_dash_performance($filter = array()){
		$saringan = array();
		$this->load->model('dash_pr_item');
		
		$saringan = array(
			'KEL_PURCH_GRP'=>@$filter['opco'],
			'PPR_PGRP'=>@$filter['pgrp'],
			"TO_CHAR(PPR_DATE_RELEASE,'YYYY') "=>@$filter['tahun'],
			"TO_CHAR(PPR_DATE_RELEASE,'MM') "=>@$filter['bulan'],
			);		
		
		
		$performance = $this->dash_pr_item->get_performance($saringan);		
		// die($performance);
		$performance_title = array('submit', 'subpratender', 'pratender','quot_deadline','evatek_approve','evatek','nego', 'po_created', 'po_released');
		foreach ($performance_title as $title) {
			$data['performance'][$title]['total'] = isset($performance[0][strtoupper("total_".$title)]) ? intval($performance[0][strtoupper("total_".$title)]) : 0;
			$data['performance'][$title]['sub'] = isset($performance[0][strtoupper("sub_".$title)]) ? intval($performance[0][strtoupper("sub_".$title)]) : 0;
		}
		return $data;	
	}

	public function get_dash_list_item($filter = array()){
		$saringan = array();
		$this->load->model('dash_pr_item');
		
		$saringan = array(
			'KEL_PURCH_GRP'=>@$filter['opco'],
			'PPR_PGRP'=>@$filter['pgrp'],
			'TO_CHAR("PPR_DATE_RELEASE",'."'YYYY'".')'=>@$filter['tahun'],
			'TO_CHAR("PPR_DATE_RELEASE",'."'MM'".')'=>@$filter['bulan'],
			);		
		
		
		$pritem = $this->dash_pr_item->get_list_item($saringan);		
		$no=1;
		$diff = array();
		foreach ($pritem as $key => $val) {
			$pritem[$key]['NO']=$no++;
			// $diff['upload'][] = $this->days_diff($val['PPR_DATE_RELEASE'], $val['DOC_UPLOAD_DATE']);			
			// $diff['konf'][] = $this->days_diff($val['DOC_UPLOAD_DATE'], $pritem[$key]['KONFIGURASI_DATE']);
			// $rfqbenar = '';
			// if (oraclestrtotime($pritem[$key]['PTP_REG_OPENING_DATE']) > oraclestrtotime($pritem[$key]['RFQ_CREATED'])) {
			// 	$rfqbenar = $pritem[$key]['PTP_REG_OPENING_DATE'];
			// } else {
			// 	$rfqbenar = $pritem[$key]['RFQ_CREATED'];
			// }
			// $diff['rfq'][] = $this->days_diff($pritem[$key]['KONFIGURASI_DATE'], $rfqbenar);
			// $diff['rfq_closed'][] = $this->days_diff($rfqbenar, $pritem[$key]['PTP_REG_CLOSING_DATE']);
			// $diff['evatek_approve'][] = $this->days_diff($pritem[$key]['PTP_REG_CLOSING_DATE'], $pritem[$key]['EVATEK_APPROVE']);
			// $diff['evatek_do'][] = $this->days_diff($pritem[$key]['EVATEK_APPROVE'], $pritem[$key]['EVATEK']);
			// $diff['nego'][] = $this->days_diff($pritem[$key]['EVATEK'], $pritem[$key]['WIN_AT']);
			// $diff['po_date'][] = $this->days_diff($pritem[$key]['WIN_AT'], $pritem[$key]['PO_CREATED_AT']);
			// $diff['po_release'][] = $this->days_diff($pritem[$key]['PO_CREATED_AT'], $pritem[$key]['RELEASED_AT']);

			// if (isset($pritem[$key]['DOC_UPLOAD_DATE'])) {
			// 	$performance['submit'][] = $val['PPR_PRNO'];
			// }
			// if (isset($pritem[$key]['PPI_ID'])){
			// 	if(isset($pritem[$key]['PTM_SUBPRATENDER'])){
			// 		$performance['subpratender'][] = $val['PTM_SUBPRATENDER'];
			// 	}
			// 	if(isset($pritem[$key]['PTM_PRATENDER'])){					
			// 		$performance['pratender'][] = $val['PTM_PRATENDER'];
			// 		$performance['quot_deadline'][] = $val['PTP_REG_CLOSING_DATE'];
			// 	}
			// 	$performance['evatek_approve'][] = $val['EVATEK_APPROVE'];
			// 	$performance['evatek'][] = $val['EVATEK'];
			// 	$performance['nego'][] = $val['WIN_AT'];
			// 	if(isset($pritem[$key]['PO_CREATED_AT'])){
			// 		$performance['po_created'][] = $val['PO_CREATED_AT'];
			// 		$performance['po_released'][] = $val['RELEASED_AT'];
			// 	}
			// }
			
		}
		// $leadtime = array('upload', 'konf', 'rfq', 'rfq_closed', 'evatek_approve', 'evatek_do', 'nego', 'po_date', 'po_release');
		// foreach ($leadtime as $title) {
		// 	$diffcount[$title] = 0;
		// 	$realdiff[$title] = 0;
		// 	foreach ((array) @$diff[$title] as $key => $val) {
		// 		if ($val === null) continue;
		// 		$realdiff[$title] += $val;
		// 		$diffcount[$title]++;
		// 	}
		// 	$diffavg[$title] = $diffcount[$title] == 0 ? 0 : round($realdiff[$title] / $diffcount[$title]);
		// }

		$data['pritem'] = $pritem;
		// $data['diffavg'] = $diffavg;
		// $data['diffcount'] = $diffcount;
		// $data['realdiff'] = $realdiff;

		// $performance_title = array('submit', 'subpratender', 'pratender','quot_deadline','evatek_approve','evatek','nego', 'po_created', 'po_released');
		// foreach ($performance_title as $title) {
		// 	$data['performance'][$title]['total'] = isset($performance[$title]) ? count($performance[$title]) : 0;
		// 	$data['performance'][$title]['sub'] = isset($performance[$title]) ? count(array_unique($performance[$title])) : 0;
		// }
		return $data;
	}

	public function get_data_pritem_json(){
		$filter = $this->input->post('filter');
		$length = $this->input->post('length');
		$start = $this->input->post('start');				
		$draw = $this->input->post('draw');			
		$saringan = array();
		if($filter){
			foreach($filter as $value) {
				$saringan[str_replace("[]","",$value['name'])][] = $value['value'];
			}
		}
		

		$data = $this->get_dash_list_item($saringan);	
		// echo "<pre>";
		// print_r($data);die;
		$recordsTotal = count($data['pritem']);
		$data = array_slice($data['pritem'],$start,$length);
		$recordsFiltered = count($data);
		$result = array(
			"length"=>$length,
			"start"=>$start,
			"draw"            => intval($draw), 
			"recordsTotal"    => intval($recordsTotal),  
			"recordsFiltered" => intval($recordsTotal),
			"data"            => $data   
			);        
		echo json_encode($result);
	}

	public function get_data_pritem_json_excel(){
		error_reporting(E_ALL);
		ini_set("memory_limit","-1");
		
		// header("Content-type: application/octet-stream");
		// header("Content-Disposition: attachment; filename=List_user.xls");
		// header("Pragma: no-cache");
		// header("Expires: 0");
		print_r($this->input->post());
		//die;
		$filter = $this->input->post('filter');
		$length = $this->input->post('length');
		$start = $this->input->post('start');				
		$draw = $this->input->post('draw');			
		$saringan = array();
		if($filter){
			foreach($filter as $value) {
				$saringan[str_replace("[]","",$value['name'])][] = $value['value'];
			}
		}
		

		$data = $this->get_dash_list_item($saringan);	
		$recordsTotal = count($data['pritem']);
		$data = array_slice($data['pritem'],$start,$length);
		$recordsFiltered = count($data);
		$result = array(
			"length"=>$length,
			"start"=>$start,
			"draw"            => intval($draw), 
			"recordsTotal"    => intval($recordsTotal),  
			"recordsFiltered" => intval($recordsTotal),
			"data"            => $data   
			);        
		$dt = "";
		$no = 0;
		echo "<pre>";
		print_r($result);die;
		foreach ($data as $value) {
			$no++;
			$dt.="
			<tr> 
				<td>{$no}</td>
				<td>{$value['COMPANYNAME']}</td>
				<td>{$value['PPR_PGRP']}</td>
				<td>{$value['PPR_PRNO']}</td>
				<td>{$value['PPI_PRITEM']}</td>
				<td>{$value['PPI_NOMAT']}</td>
				<td>{$value['PPI_DECMAT']}</td>
				<td>{$value['PPR_DATE_RELEASE']}</td>
				<td>{$value['DOC_UPLOAD_DATE']}</td>
				<td>{$value['PTM_SUBPRATENDER']}</td>
				<td>{$value['KONFIGURASI_DATE']}</td>
				<td>{$value['PTM_PRATENDER']}</td>
				<td>{$value['PTP_REG_OPENING_DATE']}</td>
				<td>{$value['RFQ_CREATED']}</td>
				<td>{$value['PTP_REG_CLOSING_DATE']}</td>
				<td>{$value['EVATEK_APPROVE']}</td>
				<td>{$value['EVATEK']}</td>
				<td>{$value['WIN_AT']}</td>
				<td>{$value['PO_CREATED_AT']}</td>
				<td>{$value['RELEASED_AT']}</td>
			</tr>";
		}
		$data['data']=$dt;
		$this->load->view('excel',$data);
	}

	public function load_pr(){
		$this->load->model('prc_pr_item');
		$this->load->model('dash_pr_item');
		$this->load->model('dash_leadtime');
		$query = $this->prc_pr_item->get_dashboard_pr();
		try{			
			$this->dash_pr_item->empty_table();
			$this->dash_pr_item->auto_insert($query);
			$query = $this->dash_pr_item->get_leadtime();
			$this->dash_leadtime->empty_table();
			$this->dash_leadtime->auto_insert($query);
		}catch(Exception $e){
			echo 'Message: ' .$e->getMessage();
		}
	}

}
