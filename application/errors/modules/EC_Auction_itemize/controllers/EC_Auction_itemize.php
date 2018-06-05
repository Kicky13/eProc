<?php defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Auction_itemize extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library('email');
		$this -> load -> library('form_validation');
		$this -> load -> library("file_operation");
		$this -> load -> library('Layout');
		$this -> load -> library('Authorization');
		$this -> load -> helper('url');
		$this->kolom_xl = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	}

	/* nampilin list */
	function index($status = null) {
		$this -> load -> model('ec_list_auction_itemize');
		$data['aunction'] = $this -> ec_list_auction_itemize -> get_list_auction_user();
		// echo "<pre>";
		// print_r($data['aunction']);die;
		$data['title'] = 'Daftar Auction';
		$data['status'] = $status;

		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		if ($status == null) {
			$this -> layout -> add_js('plugins/select2/select2.js');
			$this -> layout -> add_css('plugins/select2/select2.css');
			$this -> layout -> add_css('plugins/select2/select2-bootstrap.css');
			$this -> layout -> add_js('pages/EC_auction_list_stat_null.js');
			$this -> layout -> render('auction_list_stat_null', $data);
		} else {
			$this -> layout -> add_js('pages/EC_auction_itemize_index.js');
			$this -> layout -> render('auction_list', $data);
		}
	}

	function setBatch($notender) {
		$this -> load -> model('ec_auction_itemize_m');
		$this -> load -> model('ec_list_auction_itemize');

		$data['notender'] = $notender;
		$data['items'] = $this -> ec_auction_itemize_m -> get_itemset($notender);
		$data['aunction'] = $this -> ec_list_auction_itemize -> get_list_auction_user();
		// echo "<pre>";
		// print_r($data['aunction']);die;
		$data['title'] = 'Set Auction Batch';
		// echo "<pre>";
		// print_r($data['notender']);die;
		$data['batch'] = $this -> ec_auction_itemize_m -> getBatchSet($this -> session -> userdata['ID'],$notender);
		$data['itemBatch'] = $this -> ec_auction_itemize_m -> sumAllItemBatchSet($this -> session -> userdata['ID'],$notender);
		// echo "<pre>";
		// print_r($data['itemBatch']);die;

		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> add_js('plugins/select2/select2.js');
		$this -> layout -> add_css('plugins/select2/select2.css');
		$this -> layout -> add_css('plugins/select2/select2-bootstrap.css');
		$this -> layout -> add_js('pages/EC_auction_list_stat_null.js');

		//$this -> layout -> add_js('pages/auction_list_stat_null.js');
		$this -> layout -> render('auction_setbatch', $data);

	}

	function indexBatch($notender) {
		$this -> load -> model('ec_auction_itemize_m');
		$data['batch'] = $this -> ec_auction_itemize_m -> getBatch($notender);
		$data['title'] = 'Daftar Auction Batch';
		$data['notender'] = $notender;

		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();

		//$this -> layout -> add_js('pages/auction_list_stat_null.js');
		$this -> layout -> render('auction_list_batch', $data);

	}

	function open($notender) {
		$this -> load -> model('ec_auction_itemize_m');

		$where_edit['NO_TENDER'] = $notender;
		$set_edit['IS_ACTIVE'] = 2;

		$this -> ec_auction_itemize_m -> updateStatus($set_edit, $where_edit);
		$data['status'] = 'success';
		$data['post'] = $this -> input -> post();
		//echo json_encode($data);

		redirect('EC_Auction_itemize/');
	}

	function batal($notender) {
		$this -> load -> model('ec_auction_itemize_m');

		$where_edit['NO_TENDER'] = $notender;
		$set_edit['IS_ACTIVE'] = 3;
		// echo "<pre>";
		// print_r($where_edit['NO_TENDER']);die;
		$this -> ec_auction_itemize_m -> updateStatus($set_edit, $where_edit);
		$data['status'] = 'success';
		$data['post'] = $this -> input -> post();
		//echo json_encode($data);

		redirect('EC_Auction_itemize/');
	}

	/* create auction by ptm */
	function create() {
		$this->sync_curr();
		$data['title'] = 'Konfigurasi Auction';
		$this -> load -> model('EC_pricelist_m');
		$this -> load -> model('ec_auction_itemize_m');
		$this -> load -> model('vnd_header');

		$dt = $this -> ec_auction_itemize_m -> get_no_tender();
		$dt['NO_TENDER']++;
		$data['vendor_data'] = $this -> vnd_header -> where(array("STATUS"=>3)) -> get_all();
		// echo "<pre>";
		// print_r($data['vendor_data']);die;
		$data['NO_TENDER'] = $dt['NO_TENDER'];
		$data['ID_HEADER'] = $dt['NO_TENDER'];
		$data['curr'] = $this -> EC_pricelist_m -> get_MasterCurrency();
		$data['items'] = $this -> ec_auction_itemize_m -> get_items_temp($this -> session -> userdata['ID']);
		$data['batch'] = $this -> ec_auction_itemize_m -> getBatchCreate($this -> session -> userdata['ID']);
		$data['itemBatch'] = $this -> ec_auction_itemize_m -> sumAllItemBatch($this -> session -> userdata['ID']);
		$data['peserta'] = $this -> ec_auction_itemize_m -> get_peserta_temp($this -> session -> userdata['ID']);
		$data['HPS'] = $this -> ec_auction_itemize_m -> get_hps($this -> session -> userdata['ID']);
		$data['company'] = $this -> ec_auction_itemize_m -> getCompany();
		$data['currency'] = $this -> ec_auction_itemize_m -> getAllCurrency();
		$data['tanggal'] = date("d-m-Y h:i:s");
		$data['userid'] = "SMI" . str_pad($this -> getUSERID(), 6, "0", STR_PAD_LEFT);
		$this -> layout -> set_datetimepicker();
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this->layout->add_js('plugins/jquery.maskedinput.js');
		$this -> layout ->add_css('plugins/selectize/selectize.css');
		$this -> layout ->add_js('plugins/selectize/selectize.js');
		$this -> layout ->add_js('plugins/select2/select2.js');
		$this -> layout ->add_css('plugins/select2/select2.css');
		$this -> layout ->add_css('plugins/select2/select2-bootstrap.css');
		// $this -> layout -> add_js('pages/EC_detail_auction_itemize.js');
		$this -> layout -> add_js('pages/EC_auction_itemize_create.js');
		$this -> layout -> render('auction_create', $data);
	}

	function editData($notender) {
		$this->sync_curr();
		$data['title'] = 'Konfigurasi Auction';
		$this -> load -> model('EC_pricelist_m');
		$this -> load -> model('ec_auction_itemize_m');
		$this -> load -> model('vnd_header');

		$dt = $this -> ec_auction_itemize_m -> get_no_tender();
		$dt['NO_TENDER'] = $notender;
		$data['vendor_data'] = $this -> vnd_header -> where(array("STATUS"=>3)) -> get_all();
		// echo "<pre>";
		// print_r($data['vendor_data']);die;
		$data['NO_TENDER'] = $dt['NO_TENDER'];
		$data['ID_HEADER'] = $dt['NO_TENDER'];
		$data['header'] = $this -> ec_auction_itemize_m -> get_Header($notender);
		// echo "<pre>";
		// print_r($data['header']);die;
		$data['curr'] = $this -> EC_pricelist_m -> get_MasterCurrency();
		$data['items'] = $this -> ec_auction_itemize_m -> get_items($notender);
		$data['batch'] = $this -> ec_auction_itemize_m -> getBatchSet($this -> session -> userdata['ID'], $notender);
		$data['itemBatch'] = $this -> ec_auction_itemize_m -> sumAllItemBatchSet($this -> session -> userdata['ID'], $notender);
		$data['peserta'] = $this -> ec_auction_itemize_m -> get_peserta($notender);
		$data['HPS'] = $this -> ec_auction_itemize_m -> get_hps($this -> session -> userdata['ID']);
		$data['company'] = $this -> ec_auction_itemize_m -> getCompany();
		$data['currency'] = $this -> ec_auction_itemize_m -> getAllCurrency();
		$data['tanggal'] = date("d-m-Y h:i:s");
		$data['userid'] = "SMI" . str_pad($this -> getUSERID(), 6, "0", STR_PAD_LEFT);
		$this -> layout -> set_datetimepicker();
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this->layout->add_js('plugins/jquery.maskedinput.js');
		$this -> layout ->add_css('plugins/selectize/selectize.css');
		$this -> layout ->add_js('plugins/selectize/selectize.js');
		$this -> layout ->add_js('plugins/select2/select2.js');
		$this -> layout ->add_css('plugins/select2/select2.css');
		$this -> layout ->add_css('plugins/select2/select2-bootstrap.css');
		// $this -> layout -> add_js('pages/EC_detail_auction_itemize.js');
		$this -> layout -> add_js('pages/EC_auction_itemize_edit.js');
		$this -> layout -> add_js('pages/EC_auction_list_stat_null.js');
		$this -> layout -> render('auction_edit', $data);
	}

	public function getvendorname() 
	{
		$this -> load -> model('vnd_header');
		$veno = $this -> input -> post('veno');
		$vendor_data = $this -> vnd_header -> where(array("VENDOR_NO"=>$veno)) -> get_all();
		$data = $vendor_data[0];
		// echo "<pre>";
		// print_r($data['vendor_data']);die;
		echo json_encode($data);
	}

	public function getDetailItem($ID_ITEM) 
	{
		$this -> load -> model('ec_auction_itemize_m');
		$data['ID_ITEM'] = $this -> ec_auction_itemize_m -> getDetailItem($ID_ITEM);
		echo json_encode($data);
	}

	public function updateItem() 
	{
		$this->load->model('ec_auction_itemize_m');
		$where_edit['ID_ITEM'] = $this -> input -> post('ID_ITEM');
		$set_edit['KODE_BARANG'] = $this -> input -> post('KODE_BARANG');
		$set_edit['NAMA_BARANG'] = $this -> input -> post('NAMA_BARANG');
		$set_edit['JUMLAH'] = str_replace(".", "", $this -> input -> post('JUMLAH'));
		$set_edit['UNIT'] = $this -> input -> post('UNIT');
		$set_edit['PRICE'] = str_replace(".", "", $this -> input -> post('PRICE'));

		$this -> ec_auction_itemize_m -> updateItem($set_edit, $where_edit);
		$data['status'] = 'success';
		$data['post'] = $this -> input -> post();
		//echo json_encode($data);

		redirect('EC_Auction_itemize/create/');
	}

	public function getDetailUser($KODE_VENDOR) 
	{
		$this -> load -> model('ec_auction_itemize_m');
		$data['KODE_VENDOR'] = $this -> ec_auction_itemize_m -> getDetailUser($KODE_VENDOR);
		echo json_encode($data);
	}

	public function updateUser() 
	{
		$this->load->model('ec_auction_itemize_m');
		$where_edit['KODE_VENDOR'] = $this -> input -> post('KODE_VENDOR');
		$set_edit['HARGAAWAL'] = str_replace(".", "", $this -> input -> post('HARGA'));
		$set_edit['HARGATERKINI'] = str_replace(".", "", $this -> input -> post('HARGA'));

		$this -> ec_auction_itemize_m -> updateUser($set_edit, $where_edit);
		$data['status'] = 'success';
		$data['post'] = $this -> input -> post();
		//echo json_encode($data);

		redirect('EC_Auction_itemize/create/');
	}

	public function resetItem($value = '') {
		$this -> load -> model('ec_auction_itemize_m');
		$dt = $this -> ec_auction_itemize_m -> resetItem($this -> session -> userdata['ID']);
		redirect('EC_Auction_itemize/create');
	}

	public function resetItemEdit($value = '') {
		// echo "<pre>";
		// print_r($value);die;
		$this -> load -> model('ec_auction_itemize_m');
		$dt = $this -> ec_auction_itemize_m -> resetItemEdit($value);
		redirect('EC_Auction_itemize/editData/'.$value);
	}

	public function resetPeserta1($notender,$value = '') {
		$this -> load -> model('ec_auction_itemize_m');
		$kd_ven = $this -> input -> get('kd_ven');
		// echo count($kd_ven);
		// print_r($kd_ven);die;
		if($kd_ven==""){
			//echo "kosong";
			$dt = $this -> ec_auction_itemize_m -> resetPesertaEdit($notender);
		} else {
			for($i=0;$i<count($kd_ven);$i++){
				$dt = $this -> ec_auction_itemize_m -> resetPesertaSelectedEdit($notender, $kd_ven[$i]);
			}
			//echo "tidak kosong";
		}
		// die;
		redirect('EC_Auction_itemize/editData/'.$notender);
	}

	public function resetPeserta($value = '') {
		$this -> load -> model('ec_auction_itemize_m');
		$kd_ven = $this -> input -> get('kd_ven');
		// echo count($kd_ven);
		// print_r($kd_ven);
		if($kd_ven==""){
			//echo "kosong";
			$dt = $this -> ec_auction_itemize_m -> resetPeserta($this -> session -> userdata['ID']);
		} else {
			for($i=0;$i<count($kd_ven);$i++){
				$dt = $this -> ec_auction_itemize_m -> resetPesertaSelected($this -> session -> userdata['ID'], $kd_ven[$i]);
			}
			//echo "tidak kosong";
		}
		// die;
		redirect('EC_Auction_itemize/create');
	}

	public function resetBatch($value = '') {
		$this -> load -> model('ec_auction_itemize_m');
		$dt = $this -> ec_auction_itemize_m -> resetBatch($this -> session -> userdata['ID']);

		$where_edit['ID_USER'] = $this -> session -> userdata['ID'];
		$set_edit['STATUS'] = NULL;

		$this -> ec_auction_itemize_m -> updateItem($set_edit, $where_edit);
		
		redirect('EC_Auction_itemize/create');
	}

	public function resetBatch1($notender,$value = '') {
		$this -> load -> model('ec_auction_itemize_m');
		$data['notender'] = $notender;
		// echo "<pre>";
		// print_r($data['notender']);die;
		$dt = $this -> ec_auction_itemize_m -> resetBatch1($this -> session -> userdata['ID'],$notender);

		$where_edit['ID_HEADER'] = $notender;
		$set_edit['STATUS'] = NULL;

		$this -> ec_auction_itemize_m -> updateItembatch($set_edit, $where_edit);
		
		redirect('EC_Auction_itemize/editData/'.$notender);
	}

	public function getUSERID($value = '') {
		$this -> load -> model('ec_auction_itemize_m');
		$dt = $this -> ec_auction_itemize_m -> get_useridAll();
		return ($dt['MAKS']);
	}

	/* create auction by ptm */
	function show_detail($notender, $nobatch) {
		$data['title'] = 'Detail Auction';
		$data['nobatch'] = $nobatch;
		$this -> load -> model('ec_auction_itemize_m');
		$data['Detail_Auction'] = $this -> ec_auction_itemize_m -> get_Auction($notender, $nobatch);
		$data['ketBatch'] = $this -> ec_auction_itemize_m -> getBatchDetail($notender, $nobatch);
		//$item = explode(",",$data['ketBatch'][0]['ITEM']);
		$data['itemBatch'] = $this -> ec_auction_itemize_m -> getBatchDetailItem($notender, $data['ketBatch'][0]['ITEM']);

		// echo "<pre>";
		// print_r($data['ketBatch']);
		// print_r($item);
		// print_r($data['itemBatch']);
		// print_r($data['Detail_Auction']);
		// die;
		
		//echo "<pre>";
		//print_r($data['itemBatch']);
		//print_r(explode(",",$data['itemBatch'][0]['ITEM']));
		//die;

		$data['tanggal'] = date("Y/m/d H:i:s");
		$data['tanggal2'] = date("d/m/Y H:i:s");
		$this -> layout -> set_datetimepicker();
		$this -> layout -> add_js('plugins/ckeditor/ckeditor.js');
		$this -> layout -> add_js('pages/EC_flipclock.min.js');
		$this -> layout -> add_css('pages/EC_flipclock.css');
		$this -> layout -> add_js('pages/EC_auction_itemize_detail.js');
		$this -> layout -> render('auction_show_detail', $data);

	}

	public function get_item($NO_TENDER,$NO_BATCH) {
		$this -> load -> model('ec_auction_itemize_m');
		// $dataitem = $this -> ec_auction_itemize_m -> get_Itemlist($NO_TENDER);

		$ketBatch = $this -> ec_auction_itemize_m -> getBatchDetail($NO_TENDER, $NO_BATCH);
		$itemBatch = $this -> ec_auction_itemize_m -> getBatchDetailItem($NO_TENDER, $ketBatch[0]['ITEM']);
		// $json_data['id'] = $ketBatch[0]['ITEM'];
		$json_data = array('data' => $this -> getALLitem($itemBatch));
		// $json_data['query'] = $itemBatch;
		echo json_encode($json_data);
	}

	function getALLitem($dataa = '') {
		$i = 1;
		$data_tabel = array();
		foreach ($dataa as $value) {
			$data[0] = $i++;
			$data[1] = $value['ID_ITEM'] != null ? $value['ID_ITEM'] : "";
			$data[2] = $value['KODE_BARANG'] != null ? $value['KODE_BARANG'] : "";
			$data[3] = $value['NAMA_BARANG'] != null ? $value['NAMA_BARANG'] : "";
			$data[4] = $value['JUMLAH'] != null ? $value['JUMLAH'] : "";
			$data[5] = $value['UNIT'] != null ? $value['UNIT'] : "";
			$data[6] = $value['PRICE'] != null ? $value['PRICE'] : "";
			$data[7] = $value['HPS'] != null ? $value['HPS'] : "";
			$data[8] = $value['CURR'] != null ? $value['CURR'] : "";
			$data[9] = $value['TIPE'] == "s" ? "Satuan" : "Total";
			$data_tabel[] = $data;
		}
		return $data_tabel;
	}

	public function getListpeserta($NO_TENDER) {
		$this -> load -> model('ec_auction_itemize_m');
		// $dataitem = $this -> ec_auction_itemize_m -> get_Itemlist($NO_TENDER);

		$ketPeserta = $this -> ec_auction_itemize_m -> getAllPeserta($NO_TENDER);

		$json_data = array('data' => $this -> getPeserta($ketPeserta));
		echo json_encode($json_data);
	}

	function getPeserta($dataa = '') {
		$i = 1;
		$data_tabel = array();
		foreach ($dataa as $value) {
			$data[0] = $i++;
			$data[1] = $value['KODE_VENDOR'] != null ? $value['KODE_VENDOR'] : "";
			$data[2] = $value['NAMA_VENDOR'] != null ? $value['NAMA_VENDOR'] : "";
			$data[3] = $value['INITIAL'] != null ? $value['INITIAL'] : "";
			$data[4] = $value['CURRENCY'] != null ? $value['CURRENCY'] : "";
			// $data[5] = $value['BEA_MASUK'] != null ? $value['BEA_MASUK'] : "";
			$data[6] = $value['KONVERSI'] != null ? $value['KONVERSI'] : "";
			$data_tabel[] = $data;
		}
		return $data_tabel;
	}

	public function get_Peserta($NO_TENDER) {
		$this -> load -> model('ec_auction_itemize_m');
		$dataitem = $this -> ec_auction_itemize_m -> get_list_Peserta($NO_TENDER);
		// if (sizeof($dataitem)==0) 
		// 	$dataitem = $this -> ec_auction_itemize_m -> get_list_Peserta0($NO_TENDER);
		$datas = $this -> getALLPeserta($dataitem);				
		echo json_encode( array('data' => $datas ));
	}

	public function getLog($NO_TENDER,$NO_ITEM) {
		$this -> load -> model('ec_auction_itemize_m');
		$data = $this -> ec_auction_itemize_m -> getLog($NO_TENDER, $NO_ITEM);
		echo json_encode($data);
	}

	function getALLPeserta($dataa = '') {
		$i = 1;
		$data_tabel = array();
		foreach ($dataa as $value) {
			$data[0] = $i++;
			$data[1] = $value['KODE_VENDOR'] != null ? $value['KODE_VENDOR'] : "";
			$data[2] = $value['NAMA_VENDOR'] != null ? $value['NAMA_VENDOR'] : "";
			$data[3] = $value['INITIAL'] != null ? $value['INITIAL'] : "";
			// $data[3] = $value['HARGAAWAL'] != null ? $value['HARGAAWAL'] : "";
			// $data[4] = $value['HARGATERKINI'] != null ? $value['HARGATERKINI'] : "";
			$data_tabel[] = $data;
		}
		return $data_tabel;
	}

	/* save create auction */
	function addPeserta() {
		// echo "<pre>";
		// print_r($this -> input -> post());die;
		$this -> load -> model('ec_auction_itemize_m');
		$data['KODE_VENDOR'] = $this -> input -> post('kd_vnd');
		$data['NAMA_VENDOR'] = $this -> input -> post('nama_vnd');
		$data['INITIAL'] = $this -> input -> post('init_vnd');
		// $data['HARGAAWAL'] = str_replace(".", "", $this -> input -> post('Harga'));
		// $data['HARGATERKINI'] = str_replace(".", "", $this -> input -> post('Harga'));
		$data['HARGAAWAL'] = 0;
		$data['HARGATERKINI'] = 0;
		$data['USERID'] = $this -> input -> post('user');
		$data['PASS'] = $this -> input -> post('passw');
		$data['ID_USER'] = $this -> session -> userdata['ID'];
		$data['CURRENCY'] = $this -> input -> post('currency');
		//$data['BEA_MASUK'] = $this -> input -> post('bea_masuk') != null ? $this -> input -> post('bea_masuk') : 0;
		$data['USERID'] = "SMI" . str_pad($this -> getUSERID(), 6, "0", STR_PAD_LEFT);
		$data = $this -> ec_auction_itemize_m -> addPeserta($data);
		redirect('EC_Auction_itemize/create');
	}

	function addPesertaEdit($notender) {
		// echo "<pre>";
		// print_r($this -> input -> post());die;
		$this -> load -> model('ec_auction_itemize_m');
		$data['ID_HEADER'] = $notender;
		$data['KODE_VENDOR'] = $this -> input -> post('kd_vnd');
		$data['NAMA_VENDOR'] = $this -> input -> post('nama_vnd');
		$data['INITIAL'] = $this -> input -> post('init_vnd');
		// $data['HARGAAWAL'] = str_replace(".", "", $this -> input -> post('Harga'));
		// $data['HARGATERKINI'] = str_replace(".", "", $this -> input -> post('Harga'));
		$data['HARGAAWAL'] = 0;
		$data['HARGATERKINI'] = 0;
		$data['USERID'] = $this -> input -> post('user');
		$data['PASS'] = $this -> input -> post('passw');
		// $data['ID_USER'] = $this -> session -> userdata['ID'];
		$data['CURRENCY'] = $this -> input -> post('currency');
		//$data['BEA_MASUK'] = $this -> input -> post('bea_masuk') != null ? $this -> input -> post('bea_masuk') : 0;
		$data['USERID'] = "SMI" . str_pad($this -> getUSERID(), 6, "0", STR_PAD_LEFT);

		$dataa['VENDOR_NO'] = $this -> input -> post('kd_vnd');
		$dataa['CREATED_AT'] = date('d/m/Y h:i:s');
		$dataa['PRICE'] = 0;
		$dataa['ITER'] = 0;
		$dataa['PAQH_ID'] = 0; 
		$dataa['NO_TENDER'] = $notender;
		$dataa['ID_ITEM'] = '';

		$data = $this -> ec_auction_itemize_m -> addPesertaEdit($data);
		$data = $this -> ec_auction_itemize_m -> addLogEdit($dataa);
		redirect('EC_Auction_itemize/editData/'.$notender);
	}

	/* save create auction  */
	function addItems() {
		$this -> load -> model('ec_auction_itemize_m');
		$data['ID_ITEM'] = $this -> input -> post('kd_itm');
		$data['KODE_BARANG'] = $this -> input -> post('kd_itm');
		$data['NAMA_BARANG'] = $this -> input -> post('desc_itm');
		$data['JUMLAH'] = str_replace(".", "", $this -> input -> post('qty'));
		$data['UNIT'] = $this -> input -> post('uom');
		$data['PRICE'] = str_replace(".", "", $this -> input -> post('ece'));
		$data['ID_USER'] = $this -> session -> userdata['ID'];
		$data = $this -> ec_auction_itemize_m -> addItems($data);
		redirect('EC_Auction_itemize/create');
	}

	/* save create auction */
	function save() {
		$this -> load -> model('ec_auction_itemize_m');
		$dt 				= $this -> ec_auction_itemize_m -> get_no_tender();
		$dt['NO_TENDER']++;
		$data['NO_TENDER'] 	= $dt['NO_TENDER'];
		$data['DESC'] 		= $this -> input -> post('DESC');
		$data['LOCATION'] 	= $this -> input -> post('LOCATION');
		// $data['TGL_BUKA'] 	= $this -> input -> post('TGL_BUKA');
		// $data['TGL_TUTUP'] 	= $this -> input -> post('TGL_TUTUP');
		$data['COMPANYID'] 	= $this -> input -> post('opco');
		$data['TGL_CREATE'] = date('d-m-y h:m:s');
		// print_r($data['TGL_CREATED']);die;
		//$data['NILAI_PENGURANGAN'] = str_replace(".", "", $this -> input -> post('NILAI_PENGURANGAN'));
		// $data['CURR'] = $this -> input -> post('CURR');
		// $data['TIPE'] = $this -> input -> post('TIPE');
		$data['NOTE'] = "";
		// $data['HPS'] = str_replace(".", "", $this -> input -> post('HPS'));
		$data['NO_REF'] = $this -> input -> post('NO_REF');
		$data = $this -> ec_auction_itemize_m -> save($data, $this -> session -> userdata['ID']);
		redirect('EC_Auction_itemize/index');
	}

	function edit() {
		$this -> load -> model('ec_auction_itemize_m');
		$data['NO_TENDER'] = $this -> input -> post('NO_TENDER');
		$data['NO_BATCH'] = $this -> input -> post('NO_BATCH');
		$data['TGL_BUKA'] = $this -> input -> post('TGL_BUKA');
		$data['TGL_TUTUP'] = $this -> input -> post('TGL_TUTUP');
		//$data = $this -> ec_auction_itemize_m -> edit($data, $this -> session -> userdata['ID']);
		$data = $this -> ec_auction_itemize_m -> editBatch($data, $this -> session -> userdata['ID']);
		$link = 'EC_Auction_itemize/show_detail/' . $this -> input -> post('NO_TENDER').'/'.$this -> input -> post('NO_BATCH');
		redirect($link);
	}

	function close() {
		
		$this -> load -> model('ec_auction_itemize_m');
		$data['NO_TENDER'] = $this -> input -> post('NO_TENDER');
		$data['NO_BATCH'] = $this -> input -> post('NO_BATCH');
		// print_r($data);
		$closeBatch = $this -> ec_auction_itemize_m -> closebBatch($data, $this -> session -> userdata['ID']);
		$check = $this -> ec_auction_itemize_m -> getBatchDetailClose($this -> input -> post('NO_TENDER'), $this -> input -> post('NO_BATCH'));
		// echo count($check);die;
		if(count($check)==0){
			$closeHeader = $this -> ec_auction_itemize_m -> close($data, $this -> session -> userdata['ID']);
		}
		
		$link = 'EC_Auction_itemize/show_detail/' . $this -> input -> post('NO_TENDER').'/'.$this -> input -> post('NO_BATCH');
		redirect($link);
	}

	function test($value = '') {
		$this -> load -> model('ec_auction_itemize_m');
		$this -> load -> model('EC_pricelist_m');
		$data = $this -> ec_auction_itemize_m -> get_no_tender();
		$data['NO_TENDER']++;
		$data['curr'] = $this -> EC_pricelist_m -> get_MasterCurrency();
		$this -> vardum($this -> session -> userdata);
	}

	function vardum($value = true) {
		if ($value)
			header('Content-Type: application/json');
		var_dump($value);
	}

	public function save_note($notender, $nobatch) {
		$NOTE = $this -> input -> post('NOTE');
		$this -> load -> model('ec_auction_itemize_m');
		$this -> ec_auction_itemize_m -> update_note_batch($notender, $nobatch, $NOTE);
	}

	public function print_e_auction($notender,$nobatch) {
		// $data = $this->monitor($paqh, $print=true);
		
		$this -> load -> model('ec_auction_itemize_m');
		$data['title'] = 'Berita Acara e-Auction';
		$data['nobatch'] = $nobatch;
		$data['Detail_Auction'] = $this -> ec_auction_itemize_m -> get_Auction($notender,$nobatch);
		$data['Itemlist'] = $this -> ec_auction_itemize_m -> get_Itemlist($notender);
		$data['Peserta'] = $this -> ec_auction_itemize_m -> get_list_Peserta($notender);
		$data['undurdiri'] = $this -> ec_auction_itemize_m -> get_list_Peserta_Undur_Diri($notender);
		$data['det_batch'] = $this -> ec_auction_itemize_m -> getBatchDetail($notender,$nobatch);



		//awal reportolehranking
		$ketBatch = $this -> ec_auction_itemize_m -> getBatchDetail($notender, $nobatch);
		$dataItem = $this -> ec_auction_itemize_m -> getBatchDetailItem($notender, $ketBatch[0]['ITEM']);
		$dataPeserta = $this -> ec_auction_itemize_m -> get_list_Peserta($notender);

    	// echo "<pre>";
    	// print_r($ketBatch);
    	// print_r($dataPeserta);
    	// print_r($dataItem);
    	// die;
		$tampilRanking1 = "";
		for ($i=0; $i < count($dataPeserta); $i++) { 
			$tampilRanking1 .= "<th>".($i+1)."</th>";
		}
		$tampil = "";

		$tampil.='
		<table border="1" class="table table-hover">
			<thead>
				<th class="col-md-1">No</th>
				<th>Inisial</th>
				'.$tampilRanking1.'
			</thead>
			<tbody>
				';
				$no=0;
				foreach ($dataPeserta as $value){
					$initialR = "";

					for ($i=0; $i < count($dataPeserta); $i++) { 
						$ambilRank = $this->ec_auction_itemize_m->getReportItemRanking2($this -> session -> userdata['ID'], $value['KODE_VENDOR'], $notender, ($i+1), $nobatch, $ketBatch[0]['ITEM']);    					
						$initialR .= '
						<td>
							'.count($ambilRank).'
						</td>
						';
					}

					$tampil.='
					<tr>
						<td> '.++$no.'</td>
						<td> '.$value['INITIAL'].'</td>
						'.$initialR.'
					</tr>
					';												
				}
				$tampil.='
			</tbody>
		</table>
		';

		$data['tampil'] = $tampil;
		//echo $tampil;
		//akhir reportolehranking


		//echo $data['det_batch'][0]['NOTE'];
		//print_r($data['det_batch']);
		// $data['undurdiri']=array();
		// echo "<pre>";
		// print_r($data);
		$data['tanggal'] = date("d-M-Y H:i:s");
		$this -> load -> helper(array('dompdf', 'file'));
		$html = $this -> load -> view('ec_cetak_auction', $data, true);
		$filename = 'Auction';
		$paper = 'A4';
		$orientation = 'potrait';
		pdf_create($html, $filename, $paper, $orientation, false);

	}


	public function print_e_auction2($notender,$nobatch) {
		// $data = $this->monitor($paqh, $print=true);
		
		$this -> load -> model('ec_auction_itemize_m');
		$data['title'] = 'Berita Acara e-Auction';
		$data['nobatch'] = $nobatch;
		$data['Detail_Auction'] = $this -> ec_auction_itemize_m -> get_Auction($notender,$nobatch);
		$data['Itemlist'] = $this -> ec_auction_itemize_m -> get_Itemlist($notender);
		$data['Peserta'] = $this -> ec_auction_itemize_m -> getAllPeserta($notender);
		$data['undurdiri'] = $this -> ec_auction_itemize_m -> get_list_Peserta_Undur_Diri($notender);
		$data['det_batch'] = $this -> ec_auction_itemize_m -> getBatchDetail($notender,$nobatch);


		//awal reportolehranking
		$ketBatch = $this -> ec_auction_itemize_m -> getBatchDetail($notender, $nobatch);
		$dataItem = $this -> ec_auction_itemize_m -> getBatchDetailItem($notender, $ketBatch[0]['ITEM']);
		$dataPeserta = $this -> ec_auction_itemize_m -> get_list_Peserta($notender);
		$data['tanggal'] = date("d-M-Y H:i:s");
		$date = date("d F Y", strtotime($data['tanggal']));

    	// echo "<pre>";
    	// print_r($ketBatch);
    	// print_r($dataPeserta);
    	// print_r($dataItem);
    	// die;
		$tampilRanking1 = "";
		for ($i=0; $i < count($dataPeserta); $i++) { 
			$tampilRanking1 .= '<th class="Kiri Bawah Atas Kanan">'.($i+1).'</th>';
		}
		$tampil = "";

		$tampil.='
		<style type="text/css">
			.Kanan{
				border-right:1px solid black;
			}
			.Kiri{
				border-left: 1px solid black;
			}
			.Bawah{
				border-bottom:1px solid black;
			}
			.Atas{
				border-top:1px solid black;
			}
		</style>
		<table>
			<tr>
				<th colspan="2" align="justify">
					<u>
						<h3><b>LAMPIRAN 1</b></u></h3>
					</th>
				</tr>
				<tr>
					<td style="padding-top:10px" align="justify">Total Item per Ranking Nominasi Calon Penyedia Barang / Jasa :</td>
				</tr>
			</table>
			<table width="100%" border="" class="table table-hover" cellspacing="0">
				<thead>
					<tr>
						<th rowspan="2" class="col-md-1 Kiri Bawah Atas Kanan" width="75px">No</th>
						<th rowspan="2" class="Kiri Bawah Atas Kanan">Nama Perusahaan</th>
						<th colspan="'.count($dataPeserta).'" class="Kiri Bawah Atas Kanan">Ranking</th>
					</tr>
					<tr>
						'.$tampilRanking1.'
					</tr>
				</thead>
				<tbody>
					';
					$no=0;
					foreach ($dataPeserta as $value){
						$initialR = "";

						for ($i=0; $i < count($dataPeserta); $i++) { 
							$ambilRank = $this->ec_auction_itemize_m->getReportItemRanking2($this -> session -> userdata['ID'], $value['KODE_VENDOR'], $notender, ($i+1), $nobatch, $ketBatch[0]['ITEM']);    					
							$initialR .= '
							<td class="Kiri Bawah Atas Kanan" align="center">
								'.count($ambilRank).'
							</td>
							';
						}

						$tampil.='
						<tr class="Kiri Bawah Atas Kanan">
							<td class="Kiri Bawah Atas Kanan" align="center"> '.++$no.'</td>
							<td class="Kiri Bawah Atas Kanan"> '.$value['NAMA_VENDOR'].'</td>
							'.$initialR.'
						</tr>
						';												
					}
					$tampil.='
				</tbody>
			</table>
			';

			$data['tampil'] = $tampil;
		//echo $tampil;
		//akhir reportolehranking

		//resultolehranking
			$tampilRanking12 = "";
			for ($i=0; $i < count($dataPeserta); $i++) { 
				$tampilRanking12 .= '<th class="Kiri Bawah Atas Kanan">'.($i+1).'</th>';
			}
			$tampil2 = "";

			$tandatangan = "";
			$no = 1; foreach ($data['Peserta'] as $vnd) { 
				$tandatangan .=	'
				<tr >
					<td align="center" class="Kiri Bawah Atas Kanan">'.$no.'</td>
					<td class="Kiri Bawah Atas Kanan"></td>
					<td class="Kiri Bawah Atas Kanan">&nbsp;&nbsp;<b> '.$vnd['NAMA_VENDOR'].'</b></td>
					<td height="30px" class="Kiri Bawah Atas Kanan"></td>
				</tr>'; $no++;
			}

			$tampil2.='
			<style type="text/css">
				.Kanan{
					border-right:1px solid black;
				}
				.Kiri{
					border-left: 1px solid black;
				}
				.Bawah{
					border-bottom:1px solid black;
				}
				.Atas{
					border-top:1px solid black;
				}
			</style>
			<table>
				<tr>
					<td style="padding-top:10px" align="justify">Ranking Nominasi Calon Penyedia Barang / Jasa :</td>
				</tr>
			</table>
			<table class="table table-hover" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th rowspan="2" class="col-md-1 Kiri Bawah Atas Kanan" width="75px">No</th>
						<th rowspan="2" class="Kiri Bawah Atas Kanan">Nomor<br>Item</th>
						<th rowspan="2" class="Kiri Bawah Atas Kanan" width="50px">Unit</th>
						<th rowspan="2" class="Kiri Bawah Atas Kanan" width="100px">Currency</th>
						<th rowspan="2" class="Kiri Bawah Atas Kanan">Harga<br>Ranking<br>1</th>
						<th colspan="'.count($dataPeserta).'" class="Kiri Bawah Atas Kanan">Ranking</th>
					</tr>
					<tr>
						'.$tampilRanking12.'
					</tr>
				</thead>
				<tbody>
					';
					$i=0;
					foreach ($dataItem as $value){
						$initialR = "";
						$peringkat = 1;
						$urutkanRanking = $this -> ec_auction_itemize_m -> urutkanRanking($notender, $value['ID_ITEM']);
    				// echo "<pre>";
    				// print_r($urutkanRanking);
    				// die;
						$harga 		= "";
						$CURRENCY 	= "";
						foreach ($urutkanRanking as $UR) {
							$tooltip = "
							Nama Vendor = ".$UR['NAMA_VENDOR']."
							Harga Awal 	= ".$UR['HARGA']."
							Harga Awal 	= ".$UR['HARGATERKINI']."
							";

							if($harga==""){
								$harga 		= number_format($UR['HARGATERKINI'],0,".",".");
								$CURRENCY 	= $UR['CURRENCY'];
							}

							if($UR['HARGA']){ //jika tidak lolos
								$initialR .= '
								<td class="Kiri Bawah Atas Kanan" align="center">
									'.$UR['INITIAL'].'
								</td>
								';
							} else {
								$initialR .= '
								<td class="Kiri Bawah Atas Kanan">
								</td>
								';
							}
							
						}

						$tampil2.='
						<tr>
							<td class="Kiri Bawah Atas Kanan" align="center"> '.++$i.'</td>
							<td class="Kiri Bawah Atas Kanan"> '.$value['ID_ITEM'].'</td>
							<td class="Kiri Bawah Atas Kanan" align="center"> '.$value['UNIT'].'</td>
							<td class="Kiri Bawah Atas Kanan" align="center"> '.$CURRENCY.'</td>
							<td class="Kiri Bawah Atas Kanan" align="right"> '.$harga.'</td>
							'.$initialR.'
						</tr>
						';	
						$harga = 0;											
					}

					$tampil2.='
				</tbody>
			</table>
			';
		//resultolehranking


		//halaman3
			$tampil3 = "";
		// echo "<pre>";
		// echo $this -> session -> userdata['ID'];
		// print_r($dataPeserta);
			$checkPage = 1;
			foreach ($dataPeserta as $dp) {
				if($checkPage<count($dataPeserta)){
					$pagebreak = '<div style="width:700px;" class="pagebreak"></div>';
				} else {
					$pagebreak = "";
				}
				$checkPage=$checkPage+1;
				$ambilData1 = $this -> ec_auction_itemize_m -> getItemPeserta($this -> session -> userdata['ID'],$dp['KODE_VENDOR'],$notender, $ketBatch[0]['ITEM']);
			//print_r($ambilData1);die;
				$subtampil3 = '
				<style type="text/css">
					.Kanan{
						border-right:1px solid black;
					}
					.Kiri{
						border-left: 1px solid black;
					}
					.Bawah{
						border-bottom:1px solid black;
					}
					.Atas{
						border-top:1px solid black;
					}
					.pagebreak{
						page-break-before: always;
					}
				</style>
				';
				$no = 1;
				foreach ($ambilData1 as $ad1) {
					$subtampil3 .= '
					<tr>
						<td class="Kiri Bawah Atas Kanan" align="center">'.$no.'</td>
						<td class="Kiri Bawah Atas Kanan">'.$ad1['ID_ITEM'].'</td>
						<td class="Kiri Bawah Atas Kanan">'.$ad1['NAMA_BARANG'].'</td>
						<td class="Kiri Bawah Atas Kanan" align="center">'.$ad1['CURRENCY'].'</td>
						<td class="Kiri Bawah Atas Kanan" align="right">'.number_format($ad1['HARGATERKINI'],0,".",".").'</td>
						<td class="Kiri Bawah Atas Kanan" align="center">'.$ad1['BEA_MASUK'].'%</td>
						<td class="Kiri Bawah Atas Kanan" align="center">'.$ad1['RANKING'].'</td>
					</tr>
					';
					$no++;
				}
				$tampil3.='
				<table cellspacing="0" width="100%">
					<tr>
						<th colspan="2" align="justify">
							<u>
								<h3><b>LAMPIRAN 2</b></h3>
							</u>
						</th>
					</tr>
					<tr>
						<td colspan="2" style="padding-top:10px" align="justify">Daftar Harga Hasil E - Auction oleh <b>'.$dp['NAMA_VENDOR'].'</b></td>
					</tr>
				</table>
				<table cellspacing="0" width="100%">
					<tr>
						<th class="Kiri Bawah Atas Kanan" width="75px">No</th>
						<th class="Kiri Bawah Atas Kanan">Nomor Item</th>
						<th class="Kiri Bawah Atas Kanan">Deskripsi Item</th>
						<th class="Kiri Bawah Atas Kanan">Currency</th>
						<th class="Kiri Bawah Atas Kanan">Harga</th>
						<th class="Kiri Bawah Atas Kanan">Bea Masuk</th>
						<th class="Kiri Bawah Atas Kanan">Ranking</th>
					</tr>
					'.$subtampil3.'
				</table>
				<br>
				<table align="right">
					<tr>
						<td></td>
						<td align="center">'.$date.'</td>
					</tr>
					<tr>
						<td></td>
						<td align="center"><br><br><br><br><br>(____________________)</td>
					</tr>
				</table>
				'.$pagebreak;
			}
		//halaman3


		//echo $data['det_batch'][0]['NOTE'];
		//print_r($data['det_batch']);
		// $data['undurdiri']=array();
		// echo "<pre>";
		// print_r($data);

						// $this -> load -> helper(array('dompdf', 'file'));
						// $html = $this -> load -> view('ec_cetak_auction', $data, true);
						// $filename = 'Auction';
						// $paper = 'A4';
						// $orientation = 'potrait';

			include_once APPPATH.'helpers/dompdf/dompdf_config.inc.php';
			$id_admin = $this -> session -> userdata['ID'];
			$msg = $this->load->view('ec_cetak_auction', $data, true);
			$html = mb_convert_encoding($msg, 'HTML-ENTITIES', 'UTF-8');
			$target_file = './upload/temp/';

			$dompdf = new DOMPDF();
			$dompdf->set_paper('A4', 'potrait');
			$font = Font_Metrics::get_font("helvetica", "italic");
			$dompdf->load_html($html);
			$dompdf->render();

			$canvas = $dompdf->get_canvas();
			$font = Font_Metrics::get_font("helvetica", "italic");
			$canvas->page_text(30, 795, "___________________________________________________________________________________________________________", $font, 9, array(0,0,0));
			$canvas->page_text(530, 810, "{PAGE_NUM} dari {PAGE_COUNT}", $font, 9, array(0,0,0));
						//$canvas->page_text(10, 750, "Coba Gan", $font, 9, array(0,0,0));

			$output = $dompdf->output();
			file_put_contents($target_file.'pdf1-'.$id_admin.'.pdf', $output);
			unset($dompdf);

			$dompdf = new DOMPDF();
			$dompdf->set_paper('A4', 'landscape');
			$dompdf->load_html($tampil."<br>".$tampil2);
			$dompdf->render();

			$canvas = $dompdf->get_canvas();
			$font = Font_Metrics::get_font("helvetica", "italic");
			$font1 = Font_Metrics::get_font("helvetica", "bold");
			$canvas->page_text(30, 555, "___________________________________________________________________________________________________________________________________________________________", $font, 9, array(0,0,0));
			$canvas->page_text(770, 570, "{PAGE_NUM} dari {PAGE_COUNT}", $font, 9, array(0,0,0));
			$canvas->page_text(30, 570, "LAMPIRAN 1", $font1, 9, array(0,0,0));
			$canvas->page_text(89, 570, "| Lampiran ini merupakan dokumen yang tidak terpisahkan dengan dokumen BA e-Auction nomor BA". str_pad($data['Detail_Auction']['NO_TENDER'], 8, "0", STR_PAD_LEFT) ."/"."B". str_pad($nobatch, 3, "0", STR_PAD_LEFT), $font, 9, array(0,0,0));

			$output = $dompdf->output();
			file_put_contents($target_file.'pdf2-'.$id_admin.'.pdf', $output);
			unset($dompdf);

			$dompdf = new DOMPDF();
			$dompdf->set_paper('A4', 'potrait');
			$dompdf->load_html($tampil3);
			$dompdf->render();

			$canvas = $dompdf->get_canvas();
			$font = Font_Metrics::get_font("helvetica", "italic");
			$font1 = Font_Metrics::get_font("helvetica", "bold");
						//$canvas->line(30,740,570,740,array(0,0,0),1); // dari kiri, dari atas(garis kiri), dari kanan, dari atas(garis kanan), warna, ketebalan
			$canvas->page_text(10, 795, "__________________________________________________________________________________________________________________", $font, 9, array(0,0,0));
			$canvas->page_text(550, 810, "{PAGE_NUM} dari {PAGE_COUNT}", $font, 9, array(0,0,0));
			$canvas->page_text(10, 810, "LAMPIRAN 2", $font1, 9, array(0,0,0));
			$canvas->page_text(69, 810, "| Lampiran ini merupakan dokumen yang tidak terpisahkan dengan dokumen BA e-Auction nomor BA". str_pad($data['Detail_Auction']['NO_TENDER'], 8, "0", STR_PAD_LEFT) ."/"."B". str_pad($nobatch, 3, "0", STR_PAD_LEFT), $font, 9, array(0,0,0));

			$output = $dompdf->output();
			file_put_contents($target_file.'pdf3-'.$id_admin.'.pdf', $output);

			include_once APPPATH.'helpers/PDFMerger/PDFMerger.php';
			$pdf = new PDFMerger;

			$pdf->addPDF($target_file.'pdf1-'.$id_admin.'.pdf', 'all');
			$pdf->addPDF($target_file.'pdf2-'.$id_admin.'.pdf', 'all');
			$pdf->addPDF($target_file.'pdf3-'.$id_admin.'.pdf', 'all');

		//$pdf->merge('file', $target_file.'test.pdf'); // generate the file
		$pdf->merge('auction-'.$id_admin.'.pdf'); // force download
	}

	public function print_e_auction_log($NO_TENDER, $nobatch, $iditem) {
		// $data = $this->monitor($paqh, $print=true);
		
		$this -> load -> model('ec_auction_itemize_m');
		$data['title'] = 'LOG AUCTION';
		$data['curr'] = $this -> ec_auction_itemize_m -> get_Auction($NO_TENDER, $nobatch);
		$data['Detail_Auction'] = $this -> ec_auction_itemize_m -> getLog($NO_TENDER, $iditem);
		$data['tanggal'] = date("d-M-Y H:i:s");
		$this -> load -> helper(array('dompdf', 'file'));
		$html = $this -> load -> view('ec_cetak_log', $data, true);
		$filename = 'Auction';
		$paper = 'A4';
		$orientation = 'potrait';
		pdf_create($html, $filename, $paper, $orientation, false);

	}

	public function print_e_auction_peserta($notender) {
		// $data = $this->monitor($paqh, $print=true);
		$this -> load -> model('ec_auction_itemize_m');
		$data['title'] = 'Print Peserta Auction';
		$data['Detail_Auction'] = $this -> ec_auction_itemize_m -> get_Auction($notender);
		$data['Itemlist'] = $this -> ec_auction_itemize_m -> get_Itemlist($notender);
		$data['Peserta'] = $this -> ec_auction_itemize_m -> get_list_Peserta($notender);
		$data['tanggal'] = date("d-M-Y H:i:s");
		$this -> load -> helper(array('dompdf', 'file'));
		$html = $this -> load -> view('ec_cetak_peserta', $data, true);
		$filename = 'Auction';
		$paper = 'A4';
		$orientation = 'potrait';
		// $canvas->page_text(16, 800, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0,0,0));
		pdf_create($html, $filename, $paper, $orientation, false);
	}

	public function print_e_auction_peserta_temp() {
		// $data = $this->monitor($paqh, $print=true);
		$this -> load -> model('ec_auction_itemize_m');
		//$data['Detail_Auction'] = $this -> ec_auction_itemize_m -> get_Auction($notender);
		//$data['Itemlist'] = $this -> ec_auction_itemize_m -> get_Itemlist($notender);
		$data['title'] = 'Print Peserta Auction';
		$data['Peserta'] = $this -> ec_auction_itemize_m -> get_list_Peserta_temp($this -> session -> userdata['ID']);
		$data['tanggal'] = date("d-M-Y H:i:s");
		$this -> load -> helper(array('dompdf', 'file'));
		$html = $this -> load -> view('ec_cetak_peserta', $data, true);
		$filename = 'Auction';
		$paper = 'A4';
		$orientation = 'potrait';
		pdf_create($html, $filename, $paper, $orientation, false);
	}

	public function print_e_auction_peserta_edit($notender) {
		// $data = $this->monitor($paqh, $print=true);
		$this -> load -> model('ec_auction_itemize_m');
		//$data['Detail_Auction'] = $this -> ec_auction_itemize_m -> get_Auction($notender);
		//$data['Itemlist'] = $this -> ec_auction_itemize_m -> get_Itemlist($notender);
		$data['title'] = 'Print Peserta Auction';
		$data['Peserta'] = $this -> ec_auction_itemize_m -> get_list_PesertaEdit($notender);
		$data['tanggal'] = date("d-M-Y H:i:s");
		$this -> load -> helper(array('dompdf', 'file'));
		$html = $this -> load -> view('ec_cetak_peserta', $data, true);
		$filename = 'Auction';
		$paper = 'A4';
		$orientation = 'potrait';
		pdf_create($html, $filename, $paper, $orientation, false);
	}

	public function print_e_auction_peserta_detail($notender) {
		// $data = $this->monitor($paqh, $print=true);
		$this -> load -> model('ec_auction_itemize_m');
		//$data['Detail_Auction'] = $this -> ec_auction_itemize_m -> get_Auction($notender);
		//$data['Itemlist'] = $this -> ec_auction_itemize_m -> get_Itemlist($notender);
		$data['title'] = 'Print Peserta Auction';
		$data['Peserta'] = $this -> ec_auction_itemize_m -> get_list_Peserta($notender);
		// echo "<pre>";
		// print_r($data['Peserta']);die;
		$data['tanggal'] = date("d-M-Y H:i:s");
		$this -> load -> helper(array('dompdf', 'file'));
		$html = $this -> load -> view('ec_cetak_peserta', $data, true);
		$filename = 'Auction';
		$paper = 'A4';
		$orientation = 'potrait';
		pdf_create($html, $filename, $paper, $orientation, false);
	}

	public function getUSERID_old($value = '') {
		$dt = $this -> ec_auction_itemize_m -> get_no_tender();
		$dt = $this -> ec_auction_itemize_m -> get_useridTemp();
		if ($dt['USERID'] == 'null')
			$dt['USERID'] = 1;
		else
			$dt['USERID']++;
		$dt2 = $this -> ec_auction_itemize_m -> get_userid();
		if ($dt2['USERID'] == 'null')
			$dt2['USERID'] = 0;
		else
			$dt2['USERID']++;
		if ($dt2['USERID'] == 1 && $dt['USERID'] == 1)
			return "1";
		else if ($dt2['USERID'] == 1)
			return $dt['USERID'];
		else if ($dt['USERID'] == 1)
			return $dt2['USERID'];
		else
			return ($dt['USERID'] + $dt2['USERID']);
	}

	public function importExcelEdit($notender)
	{
		$p = $this->input->post();
		$iduser = $this -> session -> userdata['ID'];
		$idx_baris_mulai = 3;
		$idx_baris_selesai = 106;
		$this -> load -> model('ec_auction_itemize_m');
		$target_file = './upload/temp/';
		$buat_folder_temp = !is_dir($target_file) ? @mkdir("./upload/temp/") : false;

		move_uploaded_file($_FILES["import_excel"]["tmp_name"], $target_file.$_FILES['import_excel']['name']);

		$file   = explode('.',$_FILES['import_excel']['name']);
		$length = count($file);

		if($file[$length -1] == 'xlsx' || $file[$length -1] == 'xls') {

			$tmp    = './upload/temp/'.$_FILES['import_excel']['name'];
            //Baca dari tmp folder jadi file ga perlu jadi sampah di server

            $this->load->library('excel');//Load library excelnya
            $read   = PHPExcel_IOFactory::createReaderForFile($tmp);
            $read->setReadDataOnly(true);
            $excel  = $read->load($tmp);

            $_sheet = $excel->setActiveSheetIndexByName('data');
            
            $data = array();
            for ($j = $idx_baris_mulai; $j <= $idx_baris_selesai; $j++) {
            	$KODE_BARANG = $_sheet->getCell("A".$j)->getCalculatedValue();
            	$NAMA_BARANG = $_sheet->getCell("B".$j)->getCalculatedValue();
            	$JUMLAH 	 = $_sheet->getCell("C".$j)->getCalculatedValue();
            	$UNIT 		 = $_sheet->getCell("D".$j)->getCalculatedValue();
            	$PRICE 		 = str_replace(',', '', $_sheet->getCell("E".$j)->getCalculatedValue());
            	$TIPE 		 = $_sheet->getCell("F".$j)->getCalculatedValue();
            	$CURR 		 = $_sheet->getCell("G".$j)->getCalculatedValue();

            	if($TIPE=="s" || $TIPE=="S") $HPS = $PRICE;
            	else $HPS = $PRICE*$JUMLAH;
            	
            	if ($KODE_BARANG != "") {

            		$checkAdaTidak = $this -> ec_auction_itemize_m -> getDetailItem3($KODE_BARANG.$j, $notender);
            		if(count($checkAdaTidak)>0){
            			$where_edit['ID_ITEM'] = $KODE_BARANG.$j;
            			$where_edit['ID_HEADER'] = $notender;
            			$set_edit['KODE_BARANG'] = $KODE_BARANG;
            			$set_edit['NAMA_BARANG'] = $NAMA_BARANG;
            			$set_edit['JUMLAH'] = $JUMLAH;
            			$set_edit['UNIT'] = $UNIT;
            			$set_edit['PRICE'] = $PRICE;
            			$set_edit['TIPE'] = $TIPE;
            			$set_edit['CURR'] = $CURR;
            			$set_edit['HPS'] = $HPS;
            			$result = $this -> ec_auction_itemize_m -> updateItembatch($set_edit, $where_edit);
            		} else {
            			$data['ID_ITEM'] = $KODE_BARANG.$j;
            			$data['KODE_BARANG'] = $KODE_BARANG;
            			$data['NAMA_BARANG'] = $NAMA_BARANG;
            			$data['JUMLAH'] = $JUMLAH;
            			$data['UNIT'] = $UNIT;
            			$data['PRICE'] = $PRICE;
            			$data['ID_HEADER'] = $notender;
            			$data['TIPE'] = $TIPE;
            			$data['CURR'] = $CURR;
            			$data['HPS'] = $HPS;
            			$result = $this -> ec_auction_itemize_m -> addItemsEdit($data);
            		}
            	}
            }
            // echo "<pre>";
            // print_r($data);            
            // die;
        } else {
            exit('Bukan File Excel...');//pesan error tipe file tidak tepat
        }

        //jika dibutuhkan hapus file
        // $path = $_SERVER['DOCUMENT_ROOT'].'/dev/sisirecruitment/upload/temp/';
        // $files = glob($path.'*'); // get all file names
        // foreach($files as $file){ // iterate files
        //     if(is_file($file)){
        //         unlink($file);
        //         //echo $file.'file deleted';
        //     } else {
        //         die;
        //     }
        // }

        $data['status'] = 'success';
        $data['post'] = $this -> input -> post();
        redirect('EC_Auction_itemize/editData/'.$notender);
    }

	public function importExcel()
	{
		$p = $this->input->post();
		$iduser = $this -> session -> userdata['ID'];
		$idx_baris_mulai = 3;
		$idx_baris_selesai = 106;
		$this -> load -> model('ec_auction_itemize_m');
		$target_file = './upload/temp/';
		$buat_folder_temp = !is_dir($target_file) ? @mkdir("./upload/temp/") : false;

		move_uploaded_file($_FILES["import_excel"]["tmp_name"], $target_file.$_FILES['import_excel']['name']);

		$file   = explode('.',$_FILES['import_excel']['name']);
		$length = count($file);

		if($file[$length -1] == 'xlsx' || $file[$length -1] == 'xls') {

			$tmp    = './upload/temp/'.$_FILES['import_excel']['name'];
            //Baca dari tmp folder jadi file ga perlu jadi sampah di server

            $this->load->library('excel');//Load library excelnya
            $read   = PHPExcel_IOFactory::createReaderForFile($tmp);
            $read->setReadDataOnly(true);
            $excel  = $read->load($tmp);

            $_sheet = $excel->setActiveSheetIndexByName('data');
            
            $data = array();
            for ($j = $idx_baris_mulai; $j <= $idx_baris_selesai; $j++) {
            	$KODE_BARANG = $_sheet->getCell("A".$j)->getCalculatedValue();
            	$NAMA_BARANG = $_sheet->getCell("B".$j)->getCalculatedValue();
            	$JUMLAH 	 = $_sheet->getCell("C".$j)->getCalculatedValue();
            	$UNIT 		 = $_sheet->getCell("D".$j)->getCalculatedValue();
            	$PRICE 		 = str_replace(',', '', $_sheet->getCell("E".$j)->getCalculatedValue());
            	$TIPE 		 = $_sheet->getCell("F".$j)->getCalculatedValue();
            	$CURR 		 = $_sheet->getCell("G".$j)->getCalculatedValue();

            	if($TIPE=="s" || $TIPE=="S") $HPS = $PRICE;
            	else $HPS = $PRICE*$JUMLAH;
            	
            	if ($KODE_BARANG != "") {

            		$checkAdaTidak = $this -> ec_auction_itemize_m -> getDetailItem2($KODE_BARANG.$j, $iduser);
            		if(count($checkAdaTidak)>0){
            			$where_edit['ID_ITEM'] = $KODE_BARANG.$j;
            			$where_edit['ID_USER'] = $iduser;
            			$set_edit['KODE_BARANG'] = $KODE_BARANG;
            			$set_edit['NAMA_BARANG'] = $NAMA_BARANG;
            			$set_edit['JUMLAH'] = $JUMLAH;
            			$set_edit['UNIT'] = $UNIT;
            			$set_edit['PRICE'] = $PRICE;
            			$set_edit['TIPE'] = $TIPE;
            			$set_edit['CURR'] = $CURR;
            			$set_edit['HPS'] = $HPS;
            			$result = $this -> ec_auction_itemize_m -> updateItem($set_edit, $where_edit);
            		} else {
            			$data['ID_ITEM'] = $KODE_BARANG.$j;
            			$data['KODE_BARANG'] = $KODE_BARANG;
            			$data['NAMA_BARANG'] = $NAMA_BARANG;
            			$data['JUMLAH'] = $JUMLAH;
            			$data['UNIT'] = $UNIT;
            			$data['PRICE'] = $PRICE;
            			$data['ID_USER'] = $iduser;
            			$data['TIPE'] = $TIPE;
            			$data['CURR'] = $CURR;
            			$data['HPS'] = $HPS;
            			$result = $this -> ec_auction_itemize_m -> addItems($data);
            		}
            	}
            }
            // echo "<pre>";
            // print_r($data);            
            // die;
        } else {
            exit('Bukan File Excel...');//pesan error tipe file tidak tepat
        }

        //jika dibutuhkan hapus file
        // $path = $_SERVER['DOCUMENT_ROOT'].'/dev/sisirecruitment/upload/temp/';
        // $files = glob($path.'*'); // get all file names
        // foreach($files as $file){ // iterate files
        //     if(is_file($file)){
        //         unlink($file);
        //         //echo $file.'file deleted';
        //     } else {
        //         die;
        //     }
        // }

        $data['status'] = 'success';
        $data['post'] = $this -> input -> post();
        redirect('EC_Auction_itemize/create/');
    }

    public function importExcelHarga()
    {
    	$p = $this->input->post();
    	//print_r($p);
    	//die;
    	$iduser = $this -> session -> userdata['ID'];
    	$idx_baris_mulai = 3;
    	$idx_baris_selesai = 106;
    	$this -> load -> model('ec_auction_itemize_m');
    	$target_file = './upload/temp/';
    	$buat_folder_temp = !is_dir($target_file) ? @mkdir("./upload/temp/") : false;

    	move_uploaded_file($_FILES["import_excel"]["tmp_name"], $target_file.$_FILES['import_excel']['name']);

    	$file   = explode('.',$_FILES['import_excel']['name']);
    	$length = count($file);

    	if($file[$length -1] == 'xlsx' || $file[$length -1] == 'xls') {

    		$tmp    = './upload/temp/'.$_FILES['import_excel']['name'];
            //Baca dari tmp folder jadi file ga perlu jadi sampah di server

            $this->load->library('excel');//Load library excelnya
            $read   = PHPExcel_IOFactory::createReaderForFile($tmp);
            $read->setReadDataOnly(true);
            $excel  = $read->load($tmp);

            $_sheet = $excel->setActiveSheetIndexByName('data');
            
            $data = array();
            for ($j = $idx_baris_mulai; $j <= $idx_baris_selesai; $j++) {
            	$KODE_BARANG 	= $_sheet->getCell("B".$j)->getCalculatedValue();
            	$HARGA_BARANG 	= $_sheet->getCell("G".$j)->getCalculatedValue();

            	if ($KODE_BARANG != "") {
            		$checkAdaTidak = $this -> ec_auction_itemize_m -> getDetailItemPrice($KODE_BARANG);
            		if(count($checkAdaTidak)>0){
            			$where_edit['ID_ITEM'] 		= $KODE_BARANG;
            			$where_edit['ID_PESERTA'] 	= $p['KODE_VENDOR'];
            			$where_edit['ID_USER'] 		= $iduser;
            			$set_edit['HARGA'] 			= $HARGA_BARANG;
            			$set_edit['HARGATERKINI'] 	= $HARGA_BARANG;
            			$result 					= $this -> ec_auction_itemize_m -> updateItemPrice($set_edit, $where_edit);
            		} else {		
            			$data['ID_PESERTA'] = $p['KODE_VENDOR'];
            			$data['ID_ITEM'] 	= $KODE_BARANG;
            			$data['HARGA'] 		= $HARGA_BARANG;
            			$data['HARGATERKINI']= $HARGA_BARANG;
            			$data['ID_USER'] 	= $iduser;
            			$result 			= $this -> ec_auction_itemize_m -> addItemsPrice($data);
            		}
            	}
            }
            // echo "<pre>";
            // print_r($data);            
            // die;
        } else {
            exit('Bukan File Excel...');//pesan error tipe file tidak tepat
        }

        //jika dibutuhkan hapus file
        // $path = $_SERVER['DOCUMENT_ROOT'].'/dev/sisirecruitment/upload/temp/';
        // $files = glob($path.'*'); // get all file names
        // foreach($files as $file){ // iterate files
        //     if(is_file($file)){
        //         unlink($file);
        //         //echo $file.'file deleted';
        //     } else {
        //         die;
        //     }
        // }

        $data['status'] = 'success';
        $data['post'] = $this -> input -> post();
        redirect('EC_Auction_itemize/create/');
    }

    public function getHargaawal() 
    {
    	$this -> load -> model('ec_auction_itemize_m');
    	$p = $this->input->post();
    	$iduser = $this -> session -> userdata['ID'];
    	$kd_peserta = $this ->input->post('id_peserta');
    	$kd_itm = $this ->input->post('kd_itm');
    	$harga_awal = $this ->input->post('harga_awal');
    	$result = $this -> ec_auction_itemize_m -> get_items_temp($this -> session -> userdata['ID']);

    	$json_data = array('data' => $this -> getALLitem2($result, $kd_peserta));
    	echo json_encode($json_data);
    }

    function getALLitem2($dataa = '', $kd_peserta) {
    	$i = 1;
    	$data_tabel = array();
    	$this -> load -> model('ec_auction_itemize_m');
    	foreach ($dataa as $value) {
    		$ambilQty = $this->ec_auction_itemize_m->getDetailItemPriceQty($this -> session -> userdata['ID'], $value['KODE_BARANG'], $kd_peserta);
    		$harga_awal = 0;
    		if(count($ambilQty)>0){
    			$harga_awal = $ambilQty[0]['HARGA'];
    		}
    		$data[0] = $i++;
    		$data[1] = $value['KODE_BARANG'] != null ? $value['KODE_BARANG'] : "";
    		$data[2] = $value['NAMA_BARANG'] != null ? $value['NAMA_BARANG'] : "";
    		$data[3] = $harga_awal != null ? $harga_awal : "";
    		$data_tabel[] = $data;
    	}
    	return $data_tabel;
    }

    public function formHargaAwal1()
    {
    	$this -> load -> model('ec_auction_itemize_m');
    	$p = $this->input->post();
    	$iduser = $this -> session -> userdata['ID'];
    	$kd_peserta = $this ->input->post('id_peserta');
    	$id_header = $this ->input->post('id_header');
    	// echo "<pre>";
    	// print_r($id_header);die;
    	$kd_itm = $this ->input->post('kd_itm');
    	$harga_awal = $this ->input->post('harga_awal');
    	$result = $this -> ec_auction_itemize_m -> get_items($id_header);
    	$resultPT = $this -> ec_auction_itemize_m -> get_list_Peserta_id($id_header, $kd_peserta);
    	//print_r($resultPT);
    	$tampil = '
    	<script type="text/javascript" src="http://10.15.5.150/dev/eproc/static/js/pages/EC_auction_only_number_format.js"></script>
    	';

    	$tampil.='
    	<form class="form-horizontal" action="'.base_url().'EC_Auction_itemize/editData/'.$id_header.'" method="POST">
    		<input type="hidden" class="form-control" name="kd_peserta" id="kd_peserta" required="" value="'.$kd_peserta.'">
    		<table class="table table-hover">
    			<thead>
    				<th class="col-md-1">No</th>
    				<th>Kode Item</th>
    				<th>Deskripsi</th>
    				<th>Merk</th>
    				<th>Currency</th>
    				<th>Harga Awal</th>
    				<th>Harga Akhir</th>
    				<th>Bea Masuk</th>
    			</thead>
    			<tbody>
    				';
    				$i=0;
    				foreach ($result as $value){
    					// SEBELUM
    					//$ambilQty = $this->ec_auction_itemize_m->getDetailItemPriceQty($this -> session -> userdata['ID'], $value['KODE_BARANG'], $kd_peserta);
    					// SESUDAH
    					$ambilQty = $this->ec_auction_itemize_m->getDetailItemPriceQty1($id_header, $value['ID_ITEM'], $kd_peserta);

    					//print_r($ambilQty);
    					$harga_awal = 0;
    					$harga_akhir = 0;
    					$bea_masuk = 0;
    					$CURR = 'IDR';
    					$MERK = '';
    					$warna = '';
    					if(count($ambilQty)>0){
    						$harga_awal = $ambilQty[0]['HARGA'];
    						$bea_masuk = $ambilQty[0]['BEA_MASUK'];
    						$CURR = $ambilQty[0]['CURRENCY'];
    						$MERK = $ambilQty[0]['MERK'];
    						$harga_akhir = $ambilQty[0]['KONVERSI_IDR_UBAH'];
    					}
    					$checkMerkSama = $this->ec_auction_itemize_m->checkMerkSama3($MERK, $kd_peserta, $this -> session -> userdata['ID'], $id_header);
    					// echo count($checkMerkSama);print_r($checkMerkSama);die;
    					if(count($checkMerkSama)>1){
    						// if(strlen($harga_akhir)>5){
    						// 	$warna = $harga_akhir;
    						// } else {
    						// 	$warna = substr($harga_akhir, 0, 3);
    						// }
    						$warna = "#42f49e";
    					} else {
    						$warna = "";
    					}
    					if ($harga_awal != 0) {
    						$tampil.='
    						<tr>
    							<td> '.++$i.'</td>
    							<td> '.$value['KODE_BARANG'].'</td>
    							<td style="background-color:'.$warna.';"> '.$value['NAMA_BARANG'].'</td>
    							<td> '.$MERK.'</td>
    							<td> '.$resultPT[0]['CURRENCY'].'</td>
    							<td>
    								<input type="hidden" class="form-control" name="kd_itm[]" id="kd_itm[]" required="" value="'.$value['ID_ITEM'].'">
    								<input type="hidden" class="form-control" name="currency[]" id="currency[]" required="" value="'.$resultPT[0]['CURRENCY'].'">
    								'.number_format($harga_awal,0,".",".").'
    							</td>
    							<td> '.number_format($harga_akhir,0,".",".").'</td>
    							<td>
    								'.number_format($bea_masuk,0,".",".").'
    							</td>
    						</tr>
    						';
    					}

    				}

    				$tampil.='
    			</tbody>
    		</table>

    		<div class="form-group">
    			<div class="col-sm-offset-3 col-sm-10">
    				<button type="submit" class="btn btn-info">Kembali</button>
    			</div>
    		</div>
    	</form>
    	';
    	echo $tampil;

    }

    public function formHargaAwal()
    {
    	$this -> load -> model('ec_auction_itemize_m');
    	$p = $this->input->post();
    	$iduser = $this -> session -> userdata['ID'];
    	$kd_peserta = $this ->input->post('id_peserta');
    	$kd_itm = $this ->input->post('kd_itm');
    	$harga_awal = $this ->input->post('harga_awal');
    	$result = $this -> ec_auction_itemize_m -> get_items_temp($this -> session -> userdata['ID']);
    	$resultPT = $this -> ec_auction_itemize_m -> get_list_Peserta_temp_id($this -> session -> userdata['ID'], $kd_peserta);
    	//print_r($resultPT);
    	$tampil = '
    	<script type="text/javascript" src="http://10.15.5.150/dev/eproc/static/js/pages/EC_auction_only_number_format.js"></script>
    	';

    	$tampil.='
    	<form class="form-horizontal" action="'.base_url().'EC_Auction_itemize/create" method="POST">
    		<input type="hidden" class="form-control" name="kd_peserta" id="kd_peserta" required="" value="'.$kd_peserta.'">
    		<table class="table table-hover">
    			<thead>
    				<th class="col-md-1">No</th>
    				<th>Kode Item</th>
    				<th>Deskripsi</th>
    				<th>Merk</th>
    				<th>Currency</th>
    				<th>Harga Awal</th>
    				<th>Harga Akhir</th>
    				<th>Bea Masuk</th>
    			</thead>
    			<tbody>
    				';
    				$i=0;
    				foreach ($result as $value){
    					// SEBELUM
    					//$ambilQty = $this->ec_auction_itemize_m->getDetailItemPriceQty($this -> session -> userdata['ID'], $value['KODE_BARANG'], $kd_peserta);
    					// SESUDAH
    					$ambilQty = $this->ec_auction_itemize_m->getDetailItemPriceQty($this -> session -> userdata['ID'], $value['ID_ITEM'], $kd_peserta);

    					//print_r($ambilQty);
    					$harga_awal = 0;
    					$harga_akhir = 0;
    					$bea_masuk = 0;
    					$CURR = 'IDR';
    					$MERK = '';
    					$warna = '';
    					if(count($ambilQty)>0){
    						$harga_awal = $ambilQty[0]['HARGA'];
    						$bea_masuk = $ambilQty[0]['BEA_MASUK'];
    						$CURR = $ambilQty[0]['CURRENCY'];
    						$MERK = $ambilQty[0]['MERK'];
    						$harga_akhir = $ambilQty[0]['KONVERSI_IDR_UBAH'];
    					}
    					$checkMerkSama = $this->ec_auction_itemize_m->checkMerkSama2($MERK, $kd_peserta, $this -> session -> userdata['ID']);
    					// echo count($checkMerkSama);print_r($checkMerkSama);die;
    					if(count($checkMerkSama)>1){
    						// if(strlen($harga_akhir)>5){
    						// 	$warna = $harga_akhir;
    						// } else {
    						// 	$warna = substr($harga_akhir, 0, 3);
    						// }
    						$warna = "#42f49e";
    					} else {
    						$warna = "";
    					}
    					if ($harga_awal != 0) {
    						$tampil.='
    						<tr>
    							<td> '.++$i.'</td>
    							<td> '.$value['KODE_BARANG'].'</td>
    							<td style="background-color:'.$warna.';"> '.$value['NAMA_BARANG'].'</td>
    							<td> '.$MERK.'</td>
    							<td> '.$resultPT[0]['CURRENCY'].'</td>
    							<td>
    								<input type="hidden" class="form-control" name="kd_itm[]" id="kd_itm[]" required="" value="'.$value['ID_ITEM'].'">
    								<input type="hidden" class="form-control" name="currency[]" id="currency[]" required="" value="'.$resultPT[0]['CURRENCY'].'">
    								'.number_format($harga_awal,0,".",".").'
    							</td>
    							<td> '.number_format($harga_akhir,0,".",".").'</td>
    							<td>
    								'.number_format($bea_masuk,0,".",".").'
    							</td>
    						</tr>
    						';
    					}

    				}

    				$tampil.='
    			</tbody>
    		</table>

    		<div class="form-group">
    			<div class="col-sm-offset-3 col-sm-10">
    				<button type="submit" class="btn btn-info">Kembali</button>
    			</div>
    		</div>
    	</form>
    	';
    	echo $tampil;

    }


    public function resultOlehRanking()
    {
    	$this -> load -> model('ec_auction_itemize_m');
    	$p = $this->input->post();
    	$iduser = $this -> session -> userdata['ID'];
    	
    	$NO_TENDER = $this ->input->post('NO_TENDER');
    	$NO_BATCH = $this ->input->post('NO_BATCH');
    	// echo "<pre>";
    	// print_r($this -> ec_auction_itemize_m -> get_list_Peserta($NO_TENDER));
    	// die;	
    	$ketBatch = $this -> ec_auction_itemize_m -> getBatchDetail($NO_TENDER, $NO_BATCH);
    	$dataItem = $this -> ec_auction_itemize_m -> getBatchDetailItem($NO_TENDER, $ketBatch[0]['ITEM']);
    	$dataPeserta = $this -> ec_auction_itemize_m -> get_list_Peserta($NO_TENDER);
    	// $this -> layout -> add_js('pages/EC_auction_itemize_detail.js');
    	// $this -> layout -> add_css('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
    	// $this -> layout -> add_js('https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js');
    	// $this -> layout -> add_js('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
    	
    	

    	$tampilRanking1 = "";
    	for ($i=0; $i < count($dataPeserta); $i++) { 
    		$tampilRanking1 .= "<th>".($i+1)."</th>";
    	}
    	$tampil = "";

    	$tampil.='
    	<style>
    		.tooltip1 {
    			position: relative;
    			display: inline-block;
    			border-bottom: 1px dotted black;
    		}

    		.tooltip1 .tooltiptext {
    			visibility: hidden;
    			width: 300px;
    			background-color: #555;
    			color: #fff;
    			text-align: center;
    			border-radius: 6px;
    			padding: 5px 0;
    			position: absolute;
    			z-index: 1;
    			bottom: 125%;
    			left: 50%;
    			margin-left: -150px;
    		}

    		.tooltip1 .tooltiptext::after {
    			content: "";
    			position: absolute;
    			top: 100%;
    			left: 50%;
    			margin-left: -5px;
    			border-width: 5px;
    			border-style: solid;
    			border-color: #555 transparent transparent transparent;
    		}

    		.tooltip1:hover .tooltiptext {
    			visibility: visible;
    		}
    		.label{
    			color: black;
    		}
    		.label-merah{
    			background-color: #ff4545;
    			color: white;
    			/font-size: 12px;/
    		}
    		.label-kuning{
    			background-color: #fef536;
    			/font-size: 12px;/
    		}
    		.label-hijau{
    			background-color: #49ff56;
    			/font-size: 12px;/
    		}
    	</style>

    	<table class="table table-hover">
    		<thead>
    			<tr>
    				<th rowspan="2" class="col-md-1">No</th>
    				<th rowspan="2">Kode Item</th>
    				<th rowspan="2">Merk</th>
    				<th rowspan="2">HPS</th>
    				<th rowspan="2">Harga Ranking 1</th>
    				<th rowspan="2">Prosentase</th>
    				<th colspan="'.count($dataPeserta).'"><center>Ranking</center></th>
    			</tr>
    			<tr>
    				'.$tampilRanking1.'
    			</tr>
    		</thead>
    		<tbody>
    			';
    			$i=0;
    			foreach ($dataItem as $value){
    				$ambilQty = $this -> ec_auction_itemize_m -> get_list_Peserta2($NO_TENDER, $value['ID_ITEM']);
    				//$ambilQty = $this->ec_auction_itemize_m->getDetailItemRanking($this -> session -> userdata['ID'], $value['ID_ITEM'], $NO_TENDER);
    				// echo "<pre>";
    				// print_r($ambilQty);
    				// $tooltip = "";
    				$initialR = "";
    				$peringkat = 1;
    				foreach ($ambilQty as $aq) {
    					if($aq['HARGAAWAL']==0 || $aq['HARGAAWAL']=='0'){
    						$where_edit['ID_ITEM'] 		= $value['ID_ITEM'];
    						$where_edit['ID_PESERTA'] 	= $aq['ID_PESERTA'];
    						$where_edit['ID_HEADER'] 	= $NO_TENDER;
    						$where_edit['ID_USER'] 		= $this -> session -> userdata['ID'];
    						$set_edit['RANKING'] 		= count($dataPeserta);
    						$result 					= $this->ec_auction_itemize_m->updateItemPrice($set_edit, $where_edit);
    					} else {
    						$where_edit['ID_ITEM'] 		= $value['ID_ITEM'];
    						$where_edit['ID_PESERTA'] 	= $aq['ID_PESERTA'];
    						$where_edit['ID_HEADER'] 	= $NO_TENDER;
    						$where_edit['ID_USER'] 		= $this -> session -> userdata['ID'];
    						$set_edit['RANKING'] 		= $peringkat;
    						$result 					= $this->ec_auction_itemize_m->updateItemPrice($set_edit, $where_edit);
    						$peringkat++;
    					}
    				}

    				$urutkanRanking = $this -> ec_auction_itemize_m -> urutkanRanking($NO_TENDER, $value['ID_ITEM']);
    				// echo "<pre>";
    				// print_r($urutkanRanking);
    				// die;
    				$harga = "";
    				$MERK = "";
    				foreach ($urutkanRanking as $UR) {
    					$tooltip = "
    					Nama Vendor = ".$UR['NAMA_VENDOR']."<br>
    					Harga Awal 	= ".$UR['CURRENCY']." ".number_format($UR['HARGA'],0,".",".")."<br>
    					Harga Akhir 	= ".$UR['CURRENCY']." ".number_format($UR['HARGATERKINI'],0,".",".")."<br>
    					";
    					
    					if($harga==""){
    						$MERK = $UR['MERK'];
    						$harga = $UR['CURRENCY']." ".number_format($UR['HARGATERKINI'],0,".",".");
    						$persen = ($UR['BM_HB']/$value['HPS'])*100;
    					}
    					if($UR['HARGA']){ //jika tidak lolos
    						$initialR .= '
    						<td>
    							<div class="tooltip1">'.$UR['INITIAL'].'
    								<span class="tooltiptext">'.$tooltip.'</span>
    							</div>

    						</td>
    						';
    					} else {
    						$initialR .= '
    						<td>
    						</td>
    						';
    					}
    				}
    				
    				$tombol = '
    				<button type="button" class="btn btn-success btn-sm btn-Log" data-id="'.$value['ID_ITEM'].'" data-tender="'.$NO_TENDER.'">
    					Log <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span>
    				</button>
    				';
    				if($persen>100){
    					$label = '<span class="label label-merah">'.number_format($persen,1,",",".").' %</span>';
    				} else {
    					$label = '<span class="label label-hijau">'.number_format($persen,1,",",".").' %</span>';
    				}
    				$tampil.='
    				<tr>
    					<td> '.++$i.'</td>
    					<td> '.$value['ID_ITEM'].$tombol.'</td>
    					<td> '.$MERK.'</td>
    					<td> '.$value['CURR']." ".number_format($value['HPS'],0,".",".").'</td>
    					<td> '.$harga.'</td>
    					<td> '.$label.'</td>
    					'.$initialR.'
    				</tr>
    				';	
    				$harga = 0;											
    			}

    			$tampil.='
    		</tbody>
    	</table>
    	';
    	echo $tampil;
    }

    public function reportOlehRanking()
    {
    	$this -> load -> model('ec_auction_itemize_m');
    	$p = $this->input->post();
    	$iduser = $this -> session -> userdata['ID'];
    	
    	$NO_TENDER = $this ->input->post('NO_TENDER');
    	$NO_BATCH = $this ->input->post('NO_BATCH');
    	
    	$ketBatch = $this -> ec_auction_itemize_m -> getBatchDetail($NO_TENDER, $NO_BATCH);
    	$dataItem = $this -> ec_auction_itemize_m -> getBatchDetailItem($NO_TENDER, $ketBatch[0]['ITEM']);
    	$dataPeserta = $this -> ec_auction_itemize_m -> get_list_Peserta($NO_TENDER);
    	
    	// echo "<pre>";
    	// print_r($ketBatch);
    	// print_r($dataPeserta);
    	// print_r($dataItem);
    	// die;
    	$tampilRanking1 = "";
    	for ($i=0; $i < count($dataPeserta); $i++) { 
    		$tampilRanking1 .= "<th>".($i+1)."</th>";
    	}
    	$tampil = "";

    	$tampil.='
    	<table class="table table-hover">
    		<thead>
    			<tr>
    				<th rowspan="2" class="col-md-1">No</th>
    				<th rowspan="2" >Inisial</th>
    				<th colspan="'.count($dataPeserta).'"><center>Ranking</center></th>
    			</tr>
    			<tr>
    				'.$tampilRanking1.'
    			</tr>
    		</thead>
    		<tbody>
    			';
    			$no=0;
    			foreach ($dataPeserta as $value){
    				$initialR = "";

    				for ($i=0; $i < count($dataPeserta); $i++) { 
    					$ambilRank = $this->ec_auction_itemize_m->getReportItemRanking2($this -> session -> userdata['ID'], $value['KODE_VENDOR'], $NO_TENDER, ($i+1), $NO_BATCH, $ketBatch[0]['ITEM']);    					
    					$initialR .= '
    					<td>
    						'.count($ambilRank).'
    					</td>
    					';
    				}

    				$tampil.='
    				<tr>
    					<td> '.++$no.'</td>
    					<td> '.$value['INITIAL'].'</td>
    					'.$initialR.'
    				</tr>
    				';												
    			}
    			$tampil.='
    		</tbody>
    	</table>
    	';
    	echo $tampil;
    }

    public function addHargaAwal()
    {
    	$this -> load -> model('ec_auction_itemize_m');
    	$p 			= $this->input->post();
    	$iduser 	= $this -> session -> userdata['ID'];
    	$kd_peserta = $this ->input->post('kd_peserta');
    	$kd_itm 	= $this ->input->post('kd_itm');
    	$harga_awal = $this ->input->post('harga_awal');
    	$bea_masuk 	= $this ->input->post('bea_masuk') != null ? str_replace('.', '', $this ->input->post('bea_masuk')) : 0;
    	$currency 	= $this ->input->post('currency');
    	// echo $kd_peserta;
    	// echo "<pre>";
    	// print_r($kd_itm);
    	// echo "<br>";
    	// print_r($harga_awal);
    	// die;

    	for ($j = 0; $j < count($kd_itm); $j++) {
    		if ($harga_awal[$j] != "") {
    			$checkAdaTidak = $this->ec_auction_itemize_m->getDetailItemPriceHarga($kd_itm[$j], $kd_peserta, $iduser);
    			$HARGA_BARANG = str_replace('.', '', $harga_awal[$j]);
    			if($currency[$j] == "IDR"){
    				$KONVERSI = 1;
    				$KEIDR = $HARGA_BARANG;
    				$BM_HB = $HARGA_BARANG;
    			} else {
    				$checkCurr = $this->ec_auction_itemize_m->getCurrency($currency[$j], 'IDR');
    				$KONVERSI = $checkCurr[0]['KONVERSI'];
    				$KEIDR = $HARGA_BARANG * $KONVERSI;
    				$BM_HB = (($bea_masuk[$j] / 100) * $KEIDR) + $KEIDR;
    			}

    			if(count($checkAdaTidak)>0){
    				$where_edit['ID_ITEM'] 		= $kd_itm[$j];
    				$where_edit['ID_PESERTA'] 	= $kd_peserta;
    				$set_edit['HARGA'] 			= $HARGA_BARANG;
    				$set_edit['HARGATERKINI'] 	= $HARGA_BARANG;
    				$set_edit['KONVERSI_IDR'] 	= $KEIDR;
    				$set_edit['KONVERSI_IDR_UBAH'] 	= $KEIDR;
    				$set_edit['BEA_MASUK'] 		= $bea_masuk[$j];
    				$set_edit['BM_HB'] 			= $BM_HB;
    				$result 					= $this->ec_auction_itemize_m->updateItemPrice($set_edit, $where_edit);
    			} else {		
    				$data['ID_PESERTA'] 	= $kd_peserta;
    				$data['ID_ITEM'] 		= $kd_itm[$j];
    				$data['HARGA'] 			= $HARGA_BARANG;
    				$data['HARGATERKINI']	= $HARGA_BARANG;
    				$data['KONVERSI_IDR']	= $KEIDR;
    				$data['KONVERSI_IDR_UBAH']	= $KEIDR;
    				$data['BEA_MASUK']		= $bea_masuk[$j];
    				$data['BM_HB']			= $BM_HB;
    				$data['ID_USER'] 		= $iduser;
    				$result 				= $this->ec_auction_itemize_m->addItemsPrice($data);
    			}
    		}
    	}


    	$data['status'] = 'success';
    	$data['post'] = $this -> input -> post();
    	redirect('EC_Auction_itemize/create/');
    }

    function addBatch1()
    {
    	$this -> load -> model('ec_auction_itemize_m');
    	$data['NAME'] = $this -> input -> post('nama_batch');
    	$data['QTY_ITEM'] = $this -> input -> post('qty_batch');
    	$data['IS_ACTIVE'] = '1';
    	$data['ID_USER'] = $this -> session -> userdata['ID'];
    	$check = $this -> ec_auction_itemize_m -> getAllItem($data['ID_USER'], $data['QTY_ITEM']);
    	// echo $data['ID_USER'].','.$data['QTY_ITEM'];
    	// echo count($check);
    	// echo "<pre>";
    	// print_r($check);
    	// die;
    	$txt = "";
    	for($i=0; $i<count($check); $i++){
    		if($i==count($check)-1){
    			$txt .= "'".$check[$i]['ID_ITEM']."'";
    		} else {
    			$txt .= "'".$check[$i]['ID_ITEM']."',";
    		}
    		$where_edit['ID_ITEM'] = $check[$i]['ID_ITEM'];
    		$set_edit['STATUS'] = '1';
    		$this -> ec_auction_itemize_m -> updateItem($set_edit, $where_edit);

    	}
    	$data['ITEM'] = $txt;
    	// echo $txt;
    	// die;
    	if($txt!=""){
    		$this -> ec_auction_itemize_m -> addItemsBatch($data);
    	}
    	redirect('EC_Auction_itemize/create');
    }

    function addBatch($notender)
    {
    	$this -> load -> model('ec_auction_itemize_m');
    	$data['ID_HEADER'] = $notender;
    	$data['NAME'] = $this -> input -> post('nama_batch');
    	$data['QTY_ITEM'] = $this -> input -> post('qty_batch');
    	$data['IS_ACTIVE'] = '1';
    	$data['ID_USER'] = $this -> session -> userdata['ID'];
    	$check = $this -> ec_auction_itemize_m -> getAllItembatch($data['ID_HEADER'], $data['QTY_ITEM']);
    	// echo $data['ID_USER'].','.$data['QTY_ITEM'];
    	// echo count($check);
    	// echo "<pre>";
    	// print_r($check);
    	// die;
    	$txt = "";
    	for($i=0; $i<count($check); $i++){
    		if($i==count($check)-1){
    			$txt .= "'".$check[$i]['ID_ITEM']."'";
    		} else {
    			$txt .= "'".$check[$i]['ID_ITEM']."',";
    		}
    		$where_edit['ID_ITEM'] = $check[$i]['ID_ITEM'];
    		$set_edit['STATUS'] = '1';
    		$this -> ec_auction_itemize_m -> updateItembatch($set_edit, $where_edit);

    	}
    	$data['ITEM'] = $txt;
    	// echo $txt;
    	// die;
    	if($txt!=""){
    		$this -> ec_auction_itemize_m -> addItemsBatch($data);
    	}
    	// redirect('EC_Auction_itemize/');
    	redirect('EC_Auction_itemize/editData/'.$notender);
    }

    public function downloadExcel()
    {
    	$this -> load -> model('ec_auction_itemize_m');
    	$p = $this->input->post();
    	$iduser = $this -> session -> userdata['ID'];
    	
    	header("Content-type: application/octet-stream");
    	header("Content-Disposition: attachment; filename=template_vendor.xls");
    	header("Pragma: no-cache");
    	header("Expires: 0");

    	$data_vendor = array();

    	$datatable_vnd = $this -> ec_auction_itemize_m -> exportDetailItem($iduser);
    	// echo "<pre>";
    	// print_r($datatable_vnd);die;

    	
    	$data['data_vendor'] = $datatable_vnd;
    	$this->load->view('excel', $data);
    }


    public function export(){ 
        //membuat objek
    	$this->load->library('excel');//Load library excelnya
    	$this -> load -> model('ec_auction_itemize_m');
    	$iduser = $this -> session -> userdata['ID'];
    	$KODE_VENDOR = $this -> input -> get('KODE_VENDOR');
    	$objPHPExcel = new PHPExcel();
        // Nama Field Baris Pertama
    	$ambilCurrPeserta = $this -> ec_auction_itemize_m -> get_list_Peserta_temp_id($iduser, $KODE_VENDOR);
    	$fields = $this -> ec_auction_itemize_m -> exportDetailItem($iduser);
    	// echo "<pre>";
    	// print_r($fields);
    	// die;

    	//SET AUTO WIDTH
    	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);

    	$col = 0;
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "No");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, "Kode_Item");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, "Kode_barang");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, "Deskripsi_Item");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, "Kuantiti");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, "Uom");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, "Tipe Auction");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, "Currency");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, "Harga_Awal");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 1, "Bea_masuk");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, 1, "Delivery_Time");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, 1, "Merk");
    	// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, 1, "");
    	// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow1(11, 1, "Keterangan Currency");
    	// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, 1, "");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, 1, "Informasi");
    	
    	// Mengambil Data
    	$row = 2;
    	$i = 1;
    	foreach ($fields as $hs){
    		//$objPHPExcel->getActiveSheet()->getStyle('H'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    		$objPHPExcel->getActiveSheet()->getStyle('H'.$row)->getNumberFormat()->setFormatCode('#,##0');
    		$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->getNumberFormat()->setFormatCode('#,##0');

    		if($hs['TIPE']=="t") $tipe = "Harga Total";
    		else $tipe = "Harga Satuan";
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, ($i));
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $hs['ID_ITEM']);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $hs['KODE_BARANG']);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $hs['NAMA_BARANG']);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $hs['JUMLAH']);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $hs['UNIT']);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $tipe);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $ambilCurrPeserta[0]['CURRENCY']);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, '');
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, '');
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, '');
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, '');
    		$i++;
    		$row++;
    	}
    	
    	// Mengambil Data currency
    	// $row = 2;
    	// $i = 1;
    	// foreach ($fieldsCurr as $fc){
    	// 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, '');
    	// 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $fc['CURR_CODE']);
    	// 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $fc['CURR_NAME']);
    	// 	$i++;
    	// 	$row++;
    	// }

    	// Informasi
    	$fieldsCurr = $this -> ec_auction_itemize_m -> getCurrencyExcelID($ambilCurrPeserta[0]['CURRENCY']);
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, 2, 'Delivery_Time = Satuan Hari');
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, 3, 'Bea_masuk = Dalam bentuk prosentase dan ditulis tanpa %(Angkanya saja)');
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, 4, 'Currency = '.$fieldsCurr[0]['CURR_CODE'].'('.$fieldsCurr[0]['CURR_NAME'].')');

    	$objPHPExcel->setActiveSheetIndex(0);

    	//protect cell
    	$objPHPExcel->getActiveSheet()
    	->getProtection()->setSheet(true);
    	$objPHPExcel->getActiveSheet()->getStyle('I2:I'.($row-1))
    	->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

    	$objPHPExcel->getActiveSheet()
    	->getProtection()->setSheet(true);
    	$objPHPExcel->getActiveSheet()->getStyle('J2:J'.($row-1))
    	->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

    	$objPHPExcel->getActiveSheet()
    	->getProtection()->setSheet(true);
    	$objPHPExcel->getActiveSheet()->getStyle('K2:K'.($row-1))
    	->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

    	$objPHPExcel->getActiveSheet()
    	->getProtection()->setSheet(true);
    	$objPHPExcel->getActiveSheet()->getStyle('L2:L'.($row-1))
    	->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

    	//dikek i password cek gak iso di unprotect
    	$objPHPExcel->getActiveSheet()->getProtection()->setPassword('eproc2017');

        //Set Title
    	$objPHPExcel->getActiveSheet()->setTitle('Data Harga Vendor');

        //Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
    	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        //Header
    	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    	header("Cache-Control: no-store, no-cache, must-revalidate");
    	header("Cache-Control: post-check=0, pre-check=0", false);
    	header("Pragma: no-cache");
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        //Nama File
    	header('Content-Disposition: attachment;filename="format_vendor.xlsx"');

        //Download
    	$objWriter->save("php://output");

    }

    public function exportEdit(){ 
        //membuat objek
    	$this->load->library('excel');//Load library excelnya
    	$this -> load -> model('ec_auction_itemize_m');
    	$iduser = $this -> session -> userdata['ID'];
    	$KODE_VENDOR = $this -> input -> get('KODE_VENDOR');
    	$NO_TENDER = $this -> input -> get('NOTENDER');
    	// echo "<pre>";
    	// print_r($KODE_VENDOR);die;
    	$objPHPExcel = new PHPExcel();
        // Nama Field Baris Pertama
    	$ambilCurrPeserta = $this -> ec_auction_itemize_m -> get_list_Peserta_id($NO_TENDER, $KODE_VENDOR);
    	$fields = $this -> ec_auction_itemize_m -> exportDetailItemEdit($NO_TENDER);
    	// echo "<pre>";
    	// print_r($ambilCurrPeserta);
    	// die;

    	//SET AUTO WIDTH
    	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);

    	$col = 0;
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "No");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, "Kode_Item");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, "Kode_barang");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, "Deskripsi_Item");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, "Kuantiti");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, "Uom");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, "Tipe Auction");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, "Currency");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, "Harga_Awal");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 1, "Bea_masuk");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, 1, "Delivery_Time");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, 1, "Merk");
    	// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, 1, "");
    	// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow1(11, 1, "Keterangan Currency");
    	// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, 1, "");
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, 1, "Informasi");
    	
    	// Mengambil Data
    	$row = 2;
    	$i = 1;
    	foreach ($fields as $hs){
    		//$objPHPExcel->getActiveSheet()->getStyle('H'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    		$objPHPExcel->getActiveSheet()->getStyle('H'.$row)->getNumberFormat()->setFormatCode('#,##0');
    		$objPHPExcel->getActiveSheet()->getStyle('I'.$row)->getNumberFormat()->setFormatCode('#,##0');

    		if($hs['TIPE']=="t") $tipe = "Harga Total";
    		else $tipe = "Harga Satuan";
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, ($i));
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $hs['ID_ITEM']);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $hs['KODE_BARANG']);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $hs['NAMA_BARANG']);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $hs['JUMLAH']);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $hs['UNIT']);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $tipe);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $ambilCurrPeserta[0]['CURRENCY']);
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, '');
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, '');
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, '');
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, '');
    		$i++;
    		$row++;
    	}
    	
    	// Mengambil Data currency
    	// $row = 2;
    	// $i = 1;
    	// foreach ($fieldsCurr as $fc){
    	// 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, '');
    	// 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $fc['CURR_CODE']);
    	// 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $fc['CURR_NAME']);
    	// 	$i++;
    	// 	$row++;
    	// }

    	// Informasi
    	$fieldsCurr = $this -> ec_auction_itemize_m -> getCurrencyExcelID($ambilCurrPeserta[0]['CURRENCY']);
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, 2, 'Delivery_Time = Satuan Hari');
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, 3, 'Bea_masuk = Dalam bentuk prosentase dan ditulis tanpa %(Angkanya saja)');
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, 4, 'Currency = '.$fieldsCurr[0]['CURR_CODE'].'('.$fieldsCurr[0]['CURR_NAME'].')');

    	$objPHPExcel->setActiveSheetIndex(0);

    	//protect cell
    	$objPHPExcel->getActiveSheet()
    	->getProtection()->setSheet(true);
    	$objPHPExcel->getActiveSheet()->getStyle('I2:I'.($row-1))
    	->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

    	$objPHPExcel->getActiveSheet()
    	->getProtection()->setSheet(true);
    	$objPHPExcel->getActiveSheet()->getStyle('J2:J'.($row-1))
    	->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

    	$objPHPExcel->getActiveSheet()
    	->getProtection()->setSheet(true);
    	$objPHPExcel->getActiveSheet()->getStyle('K2:K'.($row-1))
    	->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

    	$objPHPExcel->getActiveSheet()
    	->getProtection()->setSheet(true);
    	$objPHPExcel->getActiveSheet()->getStyle('L2:L'.($row-1))
    	->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

    	//dikek i password cek gak iso di unprotect
    	$objPHPExcel->getActiveSheet()->getProtection()->setPassword('eproc2017');

        //Set Title
    	$objPHPExcel->getActiveSheet()->setTitle('Data Harga Vendor');

        //Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
    	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        //Header
    	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    	header("Cache-Control: no-store, no-cache, must-revalidate");
    	header("Cache-Control: post-check=0, pre-check=0", false);
    	header("Pragma: no-cache");
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        //Nama File
    	header('Content-Disposition: attachment;filename="format_vendor.xlsx"');

        //Download
    	$objWriter->save("php://output");

    }


    public function do_upload(){
    	$config['upload_path'] = './assets/uploads/';
    	$config['allowed_types'] = 'xlsx|xls';
    	$p = $this->input->post();
    	$iduser = $this -> session -> userdata['ID'];
    	
    	$this->load->library('upload', $config);
    	$this -> load -> model('ec_auction_itemize_m');

    	$data = array('upload_data' => $this->upload->data());
        $upload_data = $this->upload->data(); //Mengambil detail data yang di upload
        $filename = $upload_data['file_name'];//Nama File
        $this -> ec_auction_itemize_m ->upload_data($filename, $p['KODE_VENDOR'], $iduser);
        redirect('EC_Auction_itemize/create/');
    }

    public function do_uploadEdit($notender){
    	$config['upload_path'] = './assets/uploads/';
    	$config['allowed_types'] = 'xlsx|xls';
    	$p = $this->input->post();
    	$iduser = $this -> session -> userdata['ID'];
    	$NO_TENDER = $notender;
    	
    	$this->load->library('upload', $config);
    	$this -> load -> model('ec_auction_itemize_m');

    	$data = array('upload_data' => $this->upload->data());
        $upload_data = $this->upload->data(); //Mengambil detail data yang di upload
        $filename = $upload_data['file_name'];//Nama File
        $this -> ec_auction_itemize_m ->upload_dataEdit($filename, $p['KODE_VENDOR'], $iduser, $NO_TENDER);
        redirect('EC_Auction_itemize/editData/'.$notender);
    }

    public function sync_curr(){
    	$this->load->model('ec_auction_itemize_m');
    	$this->load->library('sap_handler');
    	$invoice = $this->sap_handler->getCurrencyConversion();
    	// echo "<pre>";
    	// print_r($invoice['EXCH_RATE_LIST']); die;
    	$inv = array();
    	foreach($invoice['EXCH_RATE_LIST'] as $value){
    		$cekAdaTidak = $this -> ec_auction_itemize_m -> getCurrency($value['FROM_CURR'], $value['TO_CURRNCY']);
    		if(count($cekAdaTidak)>0){
    			$where_edit['FROM_CURR'] 	= $value['FROM_CURR'];
    			$where_edit['TO_CURRNCY'] 	= $value['TO_CURRNCY'];
    			$set_edit['EXCH_RATE'] 		= $value['EXCH_RATE'];
    			$set_edit['FROM_FACTOR'] 	= $value['FROM_FACTOR'];
    			$set_edit['TO_FACTOR'] 		= $value['TO_FACTOR'];
    			$set_edit['SAP_DATE'] 	= $value['VALID_FROM'];
    			$set_edit['KONVERSI'] 		= ($value['EXCH_RATE'] * $value['TO_FACTOR'])/$value['FROM_FACTOR'];
    			//$set_edit['UPDATED_AT'] 	= date("d-m-Y h:i:s");
    			$result = $this -> ec_auction_itemize_m -> updateCurrency($set_edit, $where_edit);
    		} else {
    			$data['FROM_CURR'] 	= $value['FROM_CURR'];
    			$data['TO_CURRNCY'] = $value['TO_CURRNCY'];
    			$data['EXCH_RATE'] 	= $value['EXCH_RATE'];
    			$data['FROM_FACTOR']= $value['FROM_FACTOR'];
    			$data['TO_FACTOR'] 	= $value['TO_FACTOR'];
    			$data['SAP_DATE'] = $value['VALID_FROM'];
    			$data['KONVERSI'] 	= ($value['EXCH_RATE'] * $value['TO_FACTOR'])/$value['FROM_FACTOR'];
    			//$data['CREATED_AT'] = date("Y-m-d h:i:s");
    			//$data['UPDATED_AT'] = date("Y-m-d h:i:s");
    			$result = $this -> ec_auction_itemize_m -> addCurrency($data);
    		}
			//exit;
    	}

    }

}
