<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tender_cleaner extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Layout');
		$this->load->library('Authorization');
		$this->load->helper('url');
		$this->load->library('comment');
	}

	public function method($a,$b) {
		return ($a["PPI_PRITEM"] > $b["PPI_PRITEM"]);
	}

	public function detail_item_ptm($id,$po_id) {
		$this->load->model('prc_tender_item');
		$this->load->model('po_header');

		$data['po_id'] = $po_id;
		$ans = '';
		$data = array();
		
		if (empty($po_id)) {
			$this->prc_tender_item->join_pr();
			$this->prc_tender_item->where_status_not('999');
			$data['tit_new'] = $this->prc_tender_item->ptm($id);
			usort($data['tit_new'], array($this, "method"));
		} else {
			$this->po_header->join_po_detail();
			$this->po_header->join_tit($id);
			$this->po_header->join_ppi();
			$data['tit_new'] = $this->po_header->get(array("PO_HEADER.PO_ID" => $po_id));

			$this->po_header->join_po_detail();
			$data['cek_lp3'] = $this->po_header->get(array("PO_HEADER.PO_ID" => $po_id));
		}

		$ans .= $this->load->view('snippets/detail_item_ptm', $data, true);

		return $ans;
	}

	public function retender($ptm, $proses, $po_id = false)
	{
		$this->load->model('prc_tender_item');
		$this->load->library('snippet');

		$data['title'] = "Retender";

		$data['ptm'] = $ptm;
		$data['proses'] = $proses;
		$data['po_id'] = $po_id;

		$this->layout->set_table_js();
		$this->layout->set_table_cs();

		$data['detail_item_ptm'] = $this->detail_item_ptm($ptm,$po_id);

		$data['detailptm'] = $this->snippet->detail_ptm($ptm,true,false,false);
		$this->layout->add_js('pages/retender.js');
		$this->layout->add_js("swal.js");
		$this->layout->add_js("sweetalert2.min.js");
		$this->layout->render('retender', $data);
	}

	public function save(){
		$this->load->library('retender');
		$this->load->library('sap_handler');
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_quo_item');
		$this->load->model('retender_quo_item');
		$this->load->model('retender_item');
		$this->load->model('prc_tender_prep');
		$this->load->model('prc_process_holder');
		$this->load->model('po_header');

		$noptm = $this->input->post("ptm");
		$tit_id = $this->input->post("item");
		$prss = $this->input->post("proses");
		$po_id = $this->input->post("po_id");
		$proses = str_replace("%20", " ", $prss);
		
		if (!isset($tit_id) || empty($tit_id)) { //RETENDER
			redirect('Tender_cleaner/retender/' . $noptm .'/'.$this->input->post('proses'));
		}

		$ptm = $this->prc_tender_main->ptm($noptm);
		$ptm = $ptm[0];
		$stat = (intval($ptm['PTM_STATUS']) * -1);

		if ($ptm['IS_JASA'] == 1) {
			$this->prc_tender_item->join_pr(true);
		} else {
			$this->prc_tender_item->join_pr();
		}
		$item = $this->prc_tender_item->ptm($noptm);

		$ptp = $this->prc_tender_prep->ptm($noptm);
		$is_itemize = $ptp['PTP_IS_ITEMIZE'];

		if($is_itemize==1){
			if(count($tit_id) > 0 ){
				$items=array();
				foreach ($tit_id as $key => $value) {
					foreach ($item as $k => $val) {
						if($val['TIT_ID']==$value){
							$items[] = $val;
						}
					}
					
				}
			}
			$return_retender = $this->sap_handler->retenderItemize($items);

			$is_rfc_error=false;
			$hasil_rfc = array();
			if ($return_retender != null) {
				// var_dump($return_retender['FT_RETURN']);
				foreach ($return_retender['FT_RETURN'] as $ft) {
					if ($ft['TYPE'] == 'E') {
						$hasil_rfc[] = $ft;
						$is_rfc_error = true;
					}
				}
			}
			
			if ($is_rfc_error) {
				$this->session->set_flashdata('rfc_ft_return', $hasil_rfc[0]['MESSAGE']);
				if (empty($po_id)) {
					redirect('Tender_cleaner/retender/'.$noptm.'/'.$proses);
				} else {
					redirect('Tender_cleaner/retender/'.$noptm.'/'.$proses.'/'.$po_id);
				}
			}

				//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
					$this->authorization->getCurrentRole(),$proses,'RETENDER',$this->input->ip_address()
				);
			$LM_ID = $this->log_data->last_id();
				//--END LOG MAIN--//

			if(count($items) > 0 ){
				foreach ($items as $key => $value) {
					$this->retender->throw_item($value['TIT_ID'], $stat, $LM_ID);
				}
			}
			
			$this->prc_tender_item->where_status_not('999');
			$item = $this->prc_tender_item->ptm($noptm);
			// die(var_dump(count($item)));
			if(count($item) == 0){
				$this->prc_tender_main->updateByPtm($noptm,array('PTM_STATUS' => $stat));
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Tender_cleaner/save','prc_tender_main','update',array('PTM_STATUS' => $stat),array('PTM_NUMBER' => $noptm));
					//--END LOG DETAIL--//
			}
		}else{
				//--LOG MAIN--//
			$this->log_data->main($this->session->userdata['ID'],$this->session->userdata['FULLNAME'],
					$this->authorization->getCurrentRole(),$proses,'RETENDER',$this->input->ip_address()
				);
			$LM_ID = $this->log_data->last_id();
				//--END LOG MAIN--//

			$return_retender = $this->sap_handler->retenderPaket($ptm['PTM_PRATENDER']);
			if(count($tit_id) > 0 ){
				foreach ($tit_id as $key => $value) {					
					$this->retender->throw_item($value, $stat, $LM_ID);
				}
			}
			
			$this->prc_tender_item->where_status_not('999');
			$item = $this->prc_tender_item->ptm($noptm);
			if(count($item) == 0){
				$this->prc_tender_main->updateByPtm($noptm,array('PTM_STATUS' => $stat));
					//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Tender_cleaner/save','prc_tender_main','update',array('PTM_STATUS' => $stat),array('PTM_NUMBER' => $noptm));
					//--END LOG DETAIL--//
			}
		}

		if(!empty($po_id)) {
			$this->po_header->update(array('IS_APPROVE'=>4),array('PO_ID'=>$po_id));
			//--LOG DETAIL--//
				$this->log_data->detail($LM_ID,'Tender_cleaner/save','po_header','update',array('IS_APPROVE' => 4,'PTM_NUMBER'=>$noptm),array('PO_ID'=>$po_id));
			//--END LOG DETAIL--//
		}


		$comment_id = $this->comment->get_new_id(); 
		// $this->file_operation->upload(UPLOAD_PATH.'comment_attachment/'.$id."_".$comment_id, $_FILES);
		$dataComment = array(
			"PTC_ID" => $comment_id,
			"PTM_NUMBER" => $noptm,
			"PTC_COMMENT" => "'".str_replace("'", "''", $this->input->post('ptc_comment'))."'",
			"PTC_POSITION" => "'".$this->authorization->getCurrentRole()."'",
			"PTC_NAME" => "'".str_replace("'", "''", $this->authorization->getCurrentName())."'",
			"PTC_ACTIVITY" => "'".$proses."'",
			// "PTC_ATTACHMENT" => '\''.$_FILES["ptc_attachment"]["name"].'\''
			);

		$this->comment->insert_comment_tender($dataComment);
			//--LOG DETAIL--//
		$this->log_data->detail($LM_ID,'Tender_cleaner/save','prc_tender_comment','insert',$dataComment);
			//--END LOG DETAIL--//

		$holder = true;
		foreach ($item as $val) {
			if($val['TIT_STATUS']!='9' && $val['TIT_STATUS']!='10' && $val['TIT_STATUS']!='999'){
				$holder = false;
			}				
		}
		if($holder){
			$s['EMP_ID']=null;
			$w['PTM_NUMBER']=$noptm;
			$this->prc_process_holder->update($s,$w);
				//--LOG DETAIL--//
			$this->log_data->detail($LM_ID,'Tender_cleaner/save','prc_process_holder','update',$s,$w);
				//--END LOG DETAIL--//
		}
		
		// $this->session->set_flashdata('retender', $return_retender); 
		$this->session->set_flashdata('retender', 'retender'); 
		redirect('Job_list');
	}
}