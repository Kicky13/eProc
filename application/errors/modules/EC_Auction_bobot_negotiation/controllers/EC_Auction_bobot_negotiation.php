<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class EC_Auction_bobot_negotiation extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library('Layout');
		$this -> load -> library('Authorization');
	}

	function index() {
		$this -> load -> model('ec_list_auction_bobot');
		$data['auction'] = $this -> ec_list_auction_bobot -> get_list_auction($this -> session -> userdata['USERID']);
		//print_r($data);exit;
		//print_r($this -> session -> userdata['KODE_VENDOR']);exit;
//        var_dump($this -> session -> userdata);
		$data['title'] = "Auction List";
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> add_js('pages/EC_auction_bobot_list.js');
		$this -> layout -> render2('list_auction', $data);
	}

	public function setuju() {
		$this -> load -> model('ec_list_auction_bobot');
		$setuju = $this -> input -> post('setuju');
		$notender = $this -> input -> post('notender');
		$this -> ec_list_auction_bobot -> setuju($notender, $setuju, $this -> session -> userdata['KODE_VENDOR']);
		if ($setuju == 1)
			redirect('EC_Auction_bobot_negotiation/detail_auction/'.$notender);
		else
			$this -> index();
	}

	function detail_auction($no_tender = '') {
		$this -> load -> model('ec_list_auction_bobot');
		$data['auction'] = $this -> ec_list_auction_bobot -> get_detail_auction($no_tender);
		$data['item'] = $this -> ec_list_auction_bobot -> get_Itemlist($no_tender);
		$data['vendor'] = $this -> ec_list_auction_bobot -> get_vendor($no_tender, $this -> session -> userdata['KODE_VENDOR']);
		$data['title'] = "Auction Negotiation Detail";
		$data['tanggal'] = date("Y/m/d H:i:s");
		$data['tanggal2'] = date("d/m/Y H:i:s");
		$this -> layout -> set_table_js();
		$this -> layout -> set_table_cs();
		$this -> layout -> add_js('pages/EC_flipclock.min.js');
		$this -> layout -> add_css('pages/EC_flipclock.css');
		$this -> layout -> add_js('pages/EC_detail_auction_bobot.js');
		$this -> layout -> render('detail_auction', $data);
	}

	public function getTimeServer() {
		echo json_encode(date("Y/m/d H:i:s"));
	}

	function piala($no_tender = '') {
		$this -> load -> model('ec_list_auction_bobot');
		$data = $this -> ec_list_auction_bobot -> get_min_bid($no_tender);
		// var_dump($this -> session -> userdata);
		if ($data['KODE_VENDOR'] == $this -> session -> userdata['KODE_VENDOR']) {
			echo json_encode(TRUE);
		} else
		echo json_encode(FALSE);
	}

	// $d1 = new DateTime('2008-08-03 14:52:10');
	// $d2 = new DateTime('2008-01-03 11:11:10');
	// var_dump($d1 == $d2);
	// var_dump($d1 > $d2);
	// var_dump($d1 < $d2);
	function bid($no_tender = '') {
		$this -> load -> model('ec_list_auction_bobot');
		$auction = $this -> ec_list_auction_bobot -> get_detail_auction($no_tender);
		$dateserver = date("Y-m-d H:i:s");
		$dateauction = $auction['DATEPENUTUPAN'];
		$dateauction2 = $auction['DATEPEMBUKAAN'];

		// $data['NO_TENDER'] = $dt['NO_TENDER'];
		// echo "<pre>";
		// print_r($vendor['HARGATERKINI']);die;
		$d1 = new DateTime($dateserver);
		$d2 = new DateTime($dateauction);
		$d3 = new DateTime($dateauction2);

		if ($d1 < $d2 && $d1 > $d3) {

			$data = $this -> ec_list_auction_bobot -> bid($this -> session -> userdata['KODE_VENDOR'], $no_tender, $this -> uri -> segment(4));

			$min_harga = $this -> ec_list_auction_bobot -> get_min_harga($no_tender);
			$allvendor = $this -> ec_list_auction_bobot -> get_Allvendor($no_tender);

			// echo "<pre>";
			// print_r($allvendor);die;
			foreach ($allvendor as $value) {
				$bobot_teknis = $value['NILAI_TEKNIS'] * $auction['BOBOT_TEKNIS'] / 100;
				$bobot_harga = $min_harga['MINHARGA'] / $value['HARGATERKINI'] * $auction['BOBOT_HARGA'];
				$nilai_gabung = $bobot_teknis + $bobot_harga;
				$data['NILAI_GABUNG'] = $nilai_gabung;
				// echo "<pre>";
				// var_dump($data);
				$data1 = $this -> ec_list_auction_bobot -> updateNilaigabung($data, $no_tender, $value);
			}
			

			echo json_encode($data);
		}
		// echo $this -> uri -> segment();
	}

	function test($value = '') {
		$this -> load -> model('ec_list_auction_bobot');
		$data = $this -> ec_list_auction_bobot -> test();
		var_dump($data);
	}

}
