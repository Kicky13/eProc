<?php
class com_jasa_group extends MY_Model
{
	public $primary_key = 'ID';
	public $table = 'COM_JASA_GROUP';

	public function __construct()
	{
		$this->return_as = 'array';
		$this->timestamps = FALSE;
		$this->soft_deletes = FALSE;
		parent::__construct();
	}

	public function get_list(){
		$this->db->order_by('KATEGORI, ID','ASC');
		$gj = $this->db->get($this->table);
		if ($gj->num_rows()>0) {
			return $gj->result_array();
		}
	
	}

	public function get_jasa(){
		$this->db->where(array('KATEGORI' => 1));
		$this->db->order_by('ID','ASC');
		$gj = $this->db->get($this->table);
		if ($gj->num_rows()>0) {
			return $gj->result_array();
		}
	}

	public function get_child($id){
		$this->db->where('FK_JASA_GROUP_ID',$id);
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

	public function get_sub_klasifikasi($id){
		$this->db->where('FK_JASA_GROUP_ID',$id);
		$this->db->order_by('NAMA','ASC');
		$dtl = $this->db->get($this->table);
		if ($dtl->num_rows()>0) {
			return $dtl->result_array();
		}
	}

	public function get_id($id){
		$this->db->where('ID',$id);
		$data = $this->db->get($this->table);
		if ($data->num_rows()>0) {
			return $data->result_array();
		}
	}

	public function mapTree($arr) {
		$q = $this->db->query($arr);
		$data=array();
		foreach($q->result_array() as $line){
			$data_tbl=array();
			$data_tbl['id']=$line['ID']; 
			$data_tbl['title']=$line['TITLE'];
			$data_tbl['parent_id']=$line['PARENT_ID'];
			$data_tbl['nama']=$line['NAMA'];
			$data_tbl['kategori']=$line['KATEGORI'];
			
			$data[]=$data_tbl;
		}
		
		return $data;
	}

}
?>