<?php
class com_jasa_kualifikasi extends MY_Model
{
	public $primary_key = 'ID';
	public $table = 'COM_JASA_KUALIFIKASI';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		$this->soft_deletes = FALSE;
		parent::__construct();
	}

	public function get_jasa(){
		$this->db->where(array('KATEGORI' => 1));
		$this->db->order_by('NAMA','ASC');
		$gj = $this->db->get($this->table);
		if ($gj->num_rows()>0) {
			return $gj->result_array();
		}
	}

	public function get_child($id){
		$this->db->where('FK_KUALIFIKASI_ID',$id);
		$this->db->order_by('NAMA','ASC');
		$gsj = $this->db->get($this->table);
		if ($gsj->num_rows()>0) {
			$result[]= '- Pilih Data -';
			foreach ($gsj->result_array() as $row){
	            $result[$row['ID']]= $row['NAMA'];
			} 
		} else {
		   $result[]= '- Belum Ada -';
		}
        return $result;
	}

}
?>