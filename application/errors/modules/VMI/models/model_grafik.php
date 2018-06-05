<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_grafik extends CI_Model {

		public function get_list()
		{
			$variabel 	= $this->uri->segment(4);
			$sqlread 	= "SELECT kode_material 
							from VMI_MASTER
							where id_list = '$variabel'";
			$kodemat 	= $this->db->query($sqlread)->row_array();
			$data 		= $this->db->query("SELECT quantity, TANGGAL_AWAL, TANGGAL_AKHIR, KODE_MATERIAL, plant, UNIT from VMI_M_PROGNOSE where kode_material = '".$kodemat['KODE_MATERIAL']."' ORDER BY ID_PROGNOSE ASC");
			// echo "SELECT quantity, TANGGAL_AWAL from VMI_M_PROGNOSE where kode_material = '".$kodemat['KODE_MATERIAL']."' ORDER BY ID_PROGNOSE ASC";
			return $data;
		}
		public function get_gi()
		{
			$variabel 	= $this->uri->segment(4);
			$sqlread 	= "SELECT kode_material 
							from VMI_MASTER 
							where id_list='$variabel'";
			$kodemat 	= $this->db->query($sqlread)->row_array();
			$data 		= $this->db->query("select realisasi from VMI_M_PROGNOSE
											WHERE KODE_MATERIAL = '".$kodemat['KODE_MATERIAL']."'");
			// echo "SELECT quantity, TANGGAL_AWAL from VMI_M_PROGNOSE where kode_material = '".$kodemat['KODE_MATERIAL']."' ORDER BY ID_PROGNOSE ASC";
			return $data;
		}
		public function get_prognose()
		{
			$variabel 	= $this->uri->segment(4);
			$sqlread 	= "SELECT kode_material from VMI_MASTER where id_list='$variabel'";
			$kodemat 	= $this->db->query($sqlread)->row_array();
			$data 		= $this->db->query("SELECT a.kode_material, a.min, a.max, a.unit, a.tanggal_awal, a.tanggal_akhir, a.plant, a.quantity, b.nama_material from VMI_M_PROGNOSE a, VMI_MASTER b where a.kode_material = '".$kodemat['KODE_MATERIAL']."' and a.kode_material=b.kode_material ORDER BY ID_PROGNOSE ASC");
			// echo "SELECT quantity, TANGGAL_AWAL from VMI_M_PROGNOSE where kode_material = '".$kodemat['KODE_MATERIAL']."' ORDER BY ID_PROGNOSE ASC";
			return $data;
		}
		// public function get_gr()
		// {
			// $variabel = $this->uri->segment(4);
			// return $this->db->query("select * from vmi_gr_gi where id_list = $variabel order by id_gr desc");
		// }
		// public function get_deliv()
		// {
			// $variabel = $this->uri->segment(4);
			// return $this->db->query("select * from vmi_delivery where id_list = $variabel order by id_pengiriman desc");
		// }
}
