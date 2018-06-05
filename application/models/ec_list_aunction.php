<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_list_aunction extends CI_Model {
	protected $table_aunction = 'EC_AUCTION_HEADER';
	public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	}

	public function get_list_auction() {
		// $this -> db -> from($this -> table_aunction);
		// $this -> db -> where("IS_ACTIVE", '1', TRUE);
		$SQL = "SELECT
					H .*, TO_CHAR (
						H .TGL_BUKA,
						'DD/MM/YYYY HH24:MI:SS'
					) AS pembukaan,
					TO_CHAR (
						H .TGL_TUTUP,
						'DD/MM/YYYY HH24:MI:SS'
					) AS penutupan
				FROM
					EC_AUCTION_HEADER H
				WHERE
					H .IS_ACTIVE = '1'
				ORDER BY h.NO_TENDER DESC,,,";
                echo $SQL;exit;
		// '" . $ptm . "'
		$result = $this -> db -> query($SQL);
		//$result = $this -> db -> get();
		return (array)$result -> result_array();
	}
}
