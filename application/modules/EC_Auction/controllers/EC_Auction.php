<?php defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Auction extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library('email');
		$this -> load -> library('form_validation');
		$this -> load -> library("file_operation");
		$this -> load -> library('Layout');
		$this -> load -> library('Authorization');
		$this -> load -> helper('url');
	}

	/* nampilin list */
	function index($status = null) {
		$this -> load -> model('ec_list_auction');
		$data['aunction'] = $this -> ec_list_auction -> get_list_auction_user();
		$data['title'] = 'Daftar Auction';
		$data['status'] = $status;

		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		if ($status == null) {
			$this -> layout -> add_js('pages/auction_list_stat_null.js');
			$this -> layout -> render('auction_list_stat_null', $data);
		} else {
			$this -> layout -> add_js('pages/EC_auction_index.js');
			$this -> layout -> render('auction_list', $data);
		}
	}

	/* create auction by ptm */
	function create() {
		$data['title'] = 'Konfigurasi Free Auction';
		$this -> load -> model('EC_pricelist_m');
		$this -> load -> model('ec_auction_m');

		$dt = $this -> ec_auction_m -> get_no_tender();
		$dt['NO_TENDER']++;
		$data['NO_TENDER'] = $dt['NO_TENDER'];
		$data['ID_HEADER'] = $dt['NO_TENDER'];
		$data['curr'] = $this -> EC_pricelist_m -> get_MasterCurrency();
		$data['items'] = $this -> ec_auction_m -> get_items_temp($this -> session -> userdata['ID']);
		$data['peserta'] = $this -> ec_auction_m -> get_peserta_temp($this -> session -> userdata['ID']);
		$data['HPS'] = $this -> ec_auction_m -> get_hps($this -> session -> userdata['ID']);
		$data['tanggal'] = date("d-m-Y h:i:s");
		$data['userid'] = "SMI" . str_pad($this -> getUSERID(), 6, "0", STR_PAD_LEFT);
		$this -> layout -> set_datetimepicker();
		$this -> layout -> add_js('pages/EC_auction_create.js');
		$this -> layout -> render('auction_create', $data);

	}

	public function getDetailItem($ID_ITEM) 
	{
		$this -> load -> model('ec_auction_m');
		$data['ID_ITEM'] = $this -> ec_auction_m -> getDetailItem($ID_ITEM);
		echo json_encode($data);
	}

	public function updateItem() 
	{
		$this->load->model('ec_auction_m');
		$where_edit['ID_ITEM'] = $this -> input -> post('ID_ITEM');
		$set_edit['KODE_BARANG'] = $this -> input -> post('KODE_BARANG');
		$set_edit['NAMA_BARANG'] = $this -> input -> post('NAMA_BARANG');
		$set_edit['JUMLAH'] = str_replace(".", "", $this -> input -> post('JUMLAH'));
		$set_edit['UNIT'] = $this -> input -> post('UNIT');
		$set_edit['PRICE'] = str_replace(".", "", $this -> input -> post('PRICE'));

		$this -> ec_auction_m -> updateItem($set_edit, $where_edit);
		$data['status'] = 'success';
		$data['post'] = $this -> input -> post();
		//echo json_encode($data);

		redirect('EC_Auction/create/');
	}

	public function getDetailUser($KODE_VENDOR) 
	{
		$this -> load -> model('ec_auction_m');
		$data['KODE_VENDOR'] = $this -> ec_auction_m -> getDetailUser($KODE_VENDOR);
		echo json_encode($data);
	}

	public function updateUser() 
	{
		$this->load->model('ec_auction_m');
		$where_edit['KODE_VENDOR'] = $this -> input -> post('KODE_VENDOR');
		$set_edit['HARGAAWAL'] = str_replace(".", "", $this -> input -> post('HARGA'));
		$set_edit['HARGATERKINI'] = str_replace(".", "", $this -> input -> post('HARGA'));

		$this -> ec_auction_m -> updateUser($set_edit, $where_edit);
		$data['status'] = 'success';
		$data['post'] = $this -> input -> post();
		//echo json_encode($data);

		redirect('EC_Auction/create/');
	}

	public function resetItem($value = '') {
		$this -> load -> model('ec_auction_m');
		$dt = $this -> ec_auction_m -> resetItem($this -> session -> userdata['ID']);
		redirect('EC_Auction/create');
	}

	public function resetPeserta($value = '') {
		$this -> load -> model('ec_auction_m');
		$dt = $this -> ec_auction_m -> resetPeserta($this -> session -> userdata['ID']);
		redirect('EC_Auction/create');
	}

	public function getUSERID($value = '') {
		$this -> load -> model('ec_auction_m');
		$dt = $this -> ec_auction_m -> get_useridAll();
		return ($dt['MAKS']);
	}

	/* create auction by ptm */
	function show_detail($notender) {
		$data['title'] = 'Detail Auction';
		$this -> load -> model('ec_auction_m');
		$data['Detail_Auction'] = $this -> ec_auction_m -> get_Auction($notender);
		$data['tanggal'] = date("Y/m/d H:i:s");
		$data['tanggal2'] = date("d/m/Y H:i:s");
		$this -> layout -> set_datetimepicker();
		$this -> layout -> add_js('pages/EC_flipclock.min.js');
		$this -> layout -> add_css('pages/EC_flipclock.css');
		$this -> layout -> add_js('pages/EC_auction_detail.js');
		$this -> layout -> render('auction_show_detail', $data);

	}

	public function get_item($NO_TENDER) {
		$this -> load -> model('ec_auction_m');
		$dataitem = $this -> ec_auction_m -> get_Itemlist($NO_TENDER);

		$json_data = array('data' => $this -> getALLitem($dataitem));
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
			$data[7] = $data[4] * $data[6];
			$data_tabel[] = $data;
		}
		return $data_tabel;
	}

	public function get_Peserta($NO_TENDER) {
		$this -> load -> model('ec_auction_m');
		$dataitem = $this -> ec_auction_m -> get_list_Peserta($NO_TENDER);
		// if (sizeof($dataitem)==0) 
		// 	$dataitem = $this -> ec_auction_m -> get_list_Peserta0($NO_TENDER);
		$datas = $this -> getALLPeserta($dataitem);				
		echo json_encode( array('data' => $datas ));
	}

	public function getLog($NO_TENDER) {
		$this -> load -> model('ec_auction_m');
		$data = $this -> ec_auction_m -> getLog($NO_TENDER);
		echo json_encode($data);
	}

	function getALLPeserta($dataa = '') {
		$i = 1;
		$data_tabel = array();
		foreach ($dataa as $value) {
			$data[0] = $i++;
			$data[1] = $value['KODE_VENDOR'] != null ? $value['KODE_VENDOR'] : "";
			$data[2] = $value['NAMA_VENDOR'] != null ? $value['NAMA_VENDOR'] : "";
			$data[3] = $value['HARGAAWAL'] != null ? $value['HARGAAWAL'] : "";
			$data[4] = $value['HARGATERKINI'] != null ? $value['HARGATERKINI'] : "";
			$data_tabel[] = $data;
		}
		return $data_tabel;
	}

	/* save create auction */
	function addPeserta() {
		$this -> load -> model('ec_auction_m');
		$data['KODE_VENDOR'] = $this -> input -> post('kd_vnd');
		$data['NAMA_VENDOR'] = $this -> input -> post('nama_vnd');
		$data['HARGAAWAL'] = str_replace(".", "", $this -> input -> post('Harga'));
		$data['HARGATERKINI'] = str_replace(".", "", $this -> input -> post('Harga'));
		$data['USERID'] = $this -> input -> post('user');
		$data['PASS'] = $this -> input -> post('passw');
		$data['ID_USER'] = $this -> session -> userdata['ID'];
		$data['USERID'] = "SMI" . str_pad($this -> getUSERID(), 6, "0", STR_PAD_LEFT);
		$data = $this -> ec_auction_m -> addPeserta($data);
		redirect('EC_Auction/create');
	}

	/* save create auction  */
	function addItems() {
		$this -> load -> model('ec_auction_m');
		$data['ID_ITEM'] = $this -> input -> post('kd_itm');
		$data['KODE_BARANG'] = $this -> input -> post('kd_itm');
		$data['NAMA_BARANG'] = $this -> input -> post('desc_itm');
		$data['JUMLAH'] = str_replace(".", "", $this -> input -> post('qty'));
		$data['UNIT'] = $this -> input -> post('uom');
		$data['PRICE'] = str_replace(".", "", $this -> input -> post('ece'));
		$data['ID_USER'] = $this -> session -> userdata['ID'];
		$data = $this -> ec_auction_m -> addItems($data);
		redirect('EC_Auction/create');
	}

	/* save create auction */
	function save() {
		$this -> load -> model('ec_auction_m');
		$dt = $this -> ec_auction_m -> get_no_tender();
		$dt['NO_TENDER']++;
		$data['NO_TENDER'] = $dt['NO_TENDER'];
		$data['DESC'] = $this -> input -> post('DESC');
		$data['LOCATION'] = $this -> input -> post('LOCATION');
		$data['TGL_BUKA'] = $this -> input -> post('TGL_BUKA');
		$data['TGL_TUTUP'] = $this -> input -> post('TGL_TUTUP');
		$data['NILAI_PENGURANGAN'] = str_replace(".", "", $this -> input -> post('NILAI_PENGURANGAN'));
		$data['CURR'] = $this -> input -> post('CURR');
		$data['TIPE'] = $this -> input -> post('TIPE');
		$data['NOTE'] = "";
		$data['HPS'] = str_replace(".", "", $this -> input -> post('HPS'));
		$data['NO_REF'] = $this -> input -> post('NO_REF');
		$data = $this -> ec_auction_m -> save($data, $this -> session -> userdata['ID']);
		redirect('EC_Auction/index');
	}

	function edit() {
		$this -> load -> model('ec_auction_m');
		$data['NO_TENDER'] = $this -> input -> post('NO_TENDER');
		$data['TGL_BUKA'] = $this -> input -> post('TGL_BUKA');
		$data['TGL_TUTUP'] = $this -> input -> post('TGL_TUTUP');
		$data = $this -> ec_auction_m -> edit($data, $this -> session -> userdata['ID']);
		$link = 'EC_Auction/show_detail/' . $this -> input -> post('NO_TENDER');
		redirect($link);
	}

	function close() {
		$this -> load -> model('ec_auction_m');
		$data['NO_TENDER'] = $this -> input -> post('NO_TENDER');
		$data = $this -> ec_auction_m -> close($data, $this -> session -> userdata['ID']);
		$link = 'EC_Auction/show_detail/' . $this -> input -> post('NO_TENDER');
		redirect($link);
	}

	function test($value = '') {
		$this -> load -> model('ec_auction_m');
		$this -> load -> model('EC_pricelist_m');
		$data = $this -> ec_auction_m -> get_no_tender();
		$data['NO_TENDER']++;
		$data['curr'] = $this -> EC_pricelist_m -> get_MasterCurrency();
		$this -> vardum($this -> session -> userdata);
	}

	function vardum($value = true) {
		if ($value)
			header('Content-Type: application/json');
		var_dump($value);
	}

	public function save_note($notender) {
		$NOTE = $this -> input -> post('NOTE');
		$this -> load -> model('ec_auction_m');
		$this -> ec_auction_m -> update_note($notender, $NOTE);
	}

	public function print_e_auction($notender) {
		// $data = $this->monitor($paqh, $print=true);
		
		$this -> load -> model('ec_auction_m');
		$data['title'] = 'Berita Acara e-Auction';
		$data['Detail_Auction'] = $this -> ec_auction_m -> get_Auction($notender);
		$data['Itemlist'] = $this -> ec_auction_m -> get_Itemlist($notender);
		$data['Peserta'] = $this -> ec_auction_m -> get_list_Peserta($notender);
		$data['undurdiri'] = $this -> ec_auction_m -> get_list_Peserta_Undur_Diri($notender);
		$data['tanggal'] = date("d-M-Y H:i:s");
		$this -> load -> helper(array('dompdf', 'file'));
		$html = $this -> load -> view('ec_cetak_auction', $data, true);
		$filename = 'Auction';
		$paper = 'A4';
		$orientation = 'potrait';
		pdf_create($html, $filename, $paper, $orientation, false);

	}

	public function print_e_auction_log($NO_TENDER) {
		// $data = $this->monitor($paqh, $print=true);
		
		$this -> load -> model('ec_auction_m');
		$data['title'] = 'LOG AUCTION';
		$data['curr'] = $this -> ec_auction_m -> get_Auction($NO_TENDER);
		$data['Detail_Auction'] = $this -> ec_auction_m -> getLog($NO_TENDER);
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
		$this -> load -> model('ec_auction_m');
		$data['title'] = 'Print Peserta Auction';
		$data['Detail_Auction'] = $this -> ec_auction_m -> get_Auction($notender);
		$data['Itemlist'] = $this -> ec_auction_m -> get_Itemlist($notender);
		$data['Peserta'] = $this -> ec_auction_m -> get_list_Peserta($notender);
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
		$this -> load -> model('ec_auction_m');
		//$data['Detail_Auction'] = $this -> ec_auction_m -> get_Auction($notender);
		//$data['Itemlist'] = $this -> ec_auction_m -> get_Itemlist($notender);
		$data['title'] = 'Print Peserta Auction';
		$data['Peserta'] = $this -> ec_auction_m -> get_list_Peserta_temp($this -> session -> userdata['ID']);
		$data['tanggal'] = date("d-M-Y H:i:s");
		$this -> load -> helper(array('dompdf', 'file'));
		$html = $this -> load -> view('ec_cetak_peserta', $data, true);
		$filename = 'Auction';
		$paper = 'A4';
		$orientation = 'potrait';
		pdf_create($html, $filename, $paper, $orientation, false);
	}

	public function getUSERID_old($value = '') {
		$dt = $this -> ec_auction_m -> get_no_tender();
		$dt = $this -> ec_auction_m -> get_useridTemp();
		if ($dt['USERID'] == 'null')
			$dt['USERID'] = 1;
		else
			$dt['USERID']++;
		$dt2 = $this -> ec_auction_m -> get_userid();
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

}
