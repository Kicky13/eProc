<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Procurement_po extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization');
		$this->load->library('Layout');
		$this->load->library('comment');
	}

	public function index() {
		$this->load->model('prc_pr_item');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('evt_id', 'Template evaluasi', 'required');
		$this->form_validation->set_rules('item', 'Item', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = "Pembuatan Sub Pratender";
			$this->prc_pr_item->where_verified();
			// $data['items'] = $this->prc_pr_item->get();
			$data['next_process'] = array();

			$this->layout->set_table_js();
			$this->layout->set_table_cs();
			$this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
			$this->layout->add_js('plugins/bootstrap-datepicker/bootstrap-datepicker.js');
			$this->layout->add_js('pages/mydatepicker.js');
			$this->layout->add_js('pages/procurement_po.js');
			$this->layout->add_js('plugins/numeral/numeral.js');
			$this->layout->add_js('plugins/numeral/languages/id.js');
			$this->layout->render('detail_po', $data);
		} else {
			$this->update();
			// var_dump($_POST);
		}
	}

	public function update() {
		$this->load->library("file_operation");
		$this->load->model('prc_tender_item');
		$this->load->model('prc_tender_main');
		$this->load->model('prc_tender_prep');

		/* Create PTM */
		$ptm_number = $this->prc_tender_main->get_id();
		$ptm = array(
			'PTM_NUMBER' => $ptm_number,
			'PTM_REQUESTER_NAME' => $this->session->userdata['FULLNAME'],
			'PTM_SUBJECT_OF_WORK' => $_POST['subject'],
			'PTM_CREATED_DATE' => date('d-M-Y g.i.s A'),
			'PTM_STATUS' => 3, // panduannya lihat tabel APP_PROCESS
			'PTM_DEPT_NAME' => $this->session->userdata['POS_NAME'],
		);
		$this->prc_tender_main->insert_single($ptm);

		/* INSERT TITS */
		$newTits = array();
		$temp['TIT_ID'] = $this->prc_tender_item->get_id();
		for ($i=0; $i < count($_POST['item']); $i++) {
			$penam = explode(':', $_POST['item'][$i]);

			$temp['TIT_PR_NO'] = $penam[0];
			$temp['TIT_PR_ITEM_NO'] = $penam[1];
			$temp['TIT_PRICE'] = $penam[2];

			$temp['TIT_QUANTITY'] = $_POST['qty'][$i];
			$temp['PTM_NUMBER'] = $ptm_number;
			$newTits[] = $temp;
			$temp['TIT_ID']++;
		}
		$this->prc_tender_item->insert_batch($newTits);

		// insert and upload comment attachment
		$comment_id = $this->comment->get_new_id();
		$dataComment = array(
				"PTC_ID" => $comment_id,
				"PTM_NUMBER" => $ptm_number,
				"PTC_COMMENT" => '\''.$this->input->post('comment').'\'',
				"PTC_POSITION" => '\''.$this->authorization->getCurrentRole().'\'',
				"PTC_NAME" => '\''.$this->authorization->getCurrentName().'\'',
				"PTC_ACTIVITY" => '\''."Pembuatan Pratender".'\'',
				"PTC_ATTACHMENT" => '\''.$_FILES["attachment"]["name"].'\''
			);
		$this->comment->insert_comment_tender($dataComment);

		$this->session->set_flashdata('success', 'success'); redirect('Job_list');
	}

	public function get_datatable() {
		$this->load->model('prc_pr_item');
		$this->prc_pr_item->join_pr();
		$this->prc_pr_item->where_verified();
		$data['data'] = $this->prc_pr_item->get(null, '*', 1);
		echo json_encode($data);
	}

	public function get_all_template() {
		$this->load->model('prc_evaluation_template');
		$data = array('data' => $this->prc_evaluation_template->get_w_type());
		echo json_encode($data);
		// var_dump($this->prc_evaluation_template->get_w_type());
	}

}
