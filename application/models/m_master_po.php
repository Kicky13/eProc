<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_master_po extends CI_Model {
	protected $tableHeader = 'MON_PO_TRANS_MASTER';

	public function __construct() {
		parent::__construct();
		$this -> db = $this -> load -> database('default', TRUE);
	}

	public function tampil_data(){
		$this->db->select('CODE, "DESC", ROWNUM AS "URUT", "ID"',FALSE);
		$this->db->order_by('ID', 'ASC');
		$query = $this->db->get('MON_PO_TRANS_MASTER');
		if($query->num_rows()>0){
			return $query;
		}else{
			return false;
		}
	}

	public function edit_data($where,$table){		
		return $this->db->get_where($table,$where);
	}


	public function update_data($where,$data,$table){
		$this->db->where($where);
		$query = $this->db->update($table,$data);
		if($query>0){
			return $query;
		}else{
			return false;
		}
	}

	public function input_data($data,$table){
		$this->db->insert($table,$data);
	}

	public  function hapus_data($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}
	// public function resetPesertaSelected($data = '', $id_user) {
	// 	$SQL = '
	// 	DELETE from "EC_AUCTION_ITEMIZE_PRICE" 
	// 	where ID_USER=\'' . $data . '\'
	// 	AND ID_PESERTA =\'' . $id_user . '\'
	// 	AND ID_HEADER is null
	// 	';
	// 	$this -> db -> query($SQL);
	// }

	// public function resetBatch($data = '') {
	// 	$SQL = '
	// 	DELETE from "EC_AUCTION_ITEMIZE_BATCH" where ID_USER=\'' . $data . '\'
	// 	AND ID_HEADER is null
	// 	';
	// 	$this -> db -> query($SQL);
		
	// }

	// public function save($data, $user) {
	// 	$SQL = "
	// 	INSERT INTO EC_AUCTION_ITEMIZE_HEADER  
	// 	values
	// 	('" . $data['NO_TENDER'] . "',
	// 	'" . $data['DESC'] . "', 
	// 	'" . $data['LOCATION'] . "', 
	// 	TO_DATE('" . $data['TGL_BUKA'] . "', 'dd/mm/yyyy hh24:mi:ss'),
	// 	TO_DATE('" . $data['TGL_TUTUP'] . "', 'dd/mm/yyyy hh24:mi:ss'), 
	// 	0,
	// 	1,
	// 	'" . $data['NO_REF'] . "',
	// 	'" . $data['NOTE'] . "',
	// 	" . $data['COMPANYID'] . "
	// 	)
	// 	";
	// 	$this -> db -> query($SQL);

	// 	$SQL = 'UPDATE EC_AUCTION_ITEMIZE_BATCH
	// 	SET ID_HEADER = '.$data['NO_TENDER'].'
	// 	WHERE ID_USER = '.$user.'
	// 	AND ID_HEADER is null
	// 	';
	// 	$this -> db -> query($SQL);

	// 	$SQL = 'UPDATE EC_AUCTION_ITEMIZE_PRICE
	// 	SET ID_HEADER = '.$data['NO_TENDER'].'
	// 	WHERE ID_USER = '.$user.'
	// 	AND ID_HEADER is null
	// 	';
	// 	$this -> db -> query($SQL);

	// 	// $this -> db -> insert($this -> tableHeader, $data);

	// 	$SQL = 'INSERT INTO EC_AUCTION_ITEMIZE_ITEM
	// 	SELECT *
	// 	FROM "EC_AUCTION_ITEMIZE_ITEM_temp"
	// 	where ID_USER=\'' . $user . '\'';
	// 	$this -> db -> query($SQL);

	// 	$SQL = 'DELETE from "EC_AUCTION_ITEMIZE_ITEM_temp" where ID_USER=\'' . $user . '\'';
	// 	$this -> db -> query($SQL);
	// 	$this -> db -> set('ID_HEADER', $data['NO_TENDER'], FALSE);
	// 	$this -> db -> where('ID_HEADER', $user);
	// 	$this -> db -> update('EC_AUCTION_ITEMIZE_ITEM');

	// 	$SQL = 'INSERT INTO EC_AUCTION_ITEMIZE_PESERTA
	// 	SELECT *
	// 	FROM "EC_AUCTION_ITEMIZE_P_temp"
	// 	where ID_USER=\'' . $user . '\'';
	// 	$this -> db -> query($SQL);

	// 	$SQL = 'DELETE from "EC_AUCTION_ITEMIZE_P_temp" where ID_USER=\'' . $user . '\'';
	// 	$this -> db -> query($SQL);
	// 	$this -> db -> set('ID_HEADER', $data['NO_TENDER'], FALSE);
	// 	$this -> db -> where('ID_HEADER', $user);
	// 	$this -> db -> update('EC_AUCTION_ITEMIZE_PESERTA');


	// 	$this -> db -> from($this -> tablePeserta) -> where("ID_HEADER",$data['NO_TENDER'], TRUE); 
	// 	$result = $this -> db -> get();
	// 	$dataa =  (array)$result -> result_array();

	// 	for ($i=0; $i < sizeof($dataa); $i++) { 
	// 		$SQL = "INSERT INTO EC_AUCTION_ITEMIZE_LOG   
	// 		values
	// 		('" . $dataa[$i]['KODE_VENDOR'] . "',TO_DATE('" . date('d/m/Y h:i:s') . "', 'dd/mm/yyyy hh24:mi:ss'),'" . $dataa[$i]['HARGAAWAL'] . "', 0, '0', 
	// 		'" . $data['NO_TENDER']  . "', '')";
	// 		$this -> db -> query($SQL);
	// 	} 
	// }

	// public function addPeserta($data) {
	// 	$this -> db -> insert($this -> tablePesertaTemp, $data);
	// }
}
