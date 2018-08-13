<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ec_faktur_ekspedisi extends MY_Model {

    // public function get($where = NULL) {
    //     $this->db->select('FAKTUR_KEMBALI.*');
    //     if (!empty($where)) {
    //         $this->db->where($where);
    //     }
    //     $this->db->from('FAKTUR_KEMBALI');
    //     $result = $this->db->get();
    //     // echo $this->db->last_query();
    //     return $result->result_array();
    // }

    // public function get_id() {
    //     $this->db->select_max('ID','MAX');
    //     $max = $this->db->get('FAKTUR_KEMBALI')->row_array();
    //     return $max['MAX']+1;
    // }

    public function insert($data) {
        $this->db->insert('FAKTUR_KEMBALI', $data);
    }

    public function getData($vendorno){        
        $sql = $this->db->from('EC_FAKTUR_EAEA')->where('VENDORNO', $vendorno)->order_by('TGL_EKSPEDISI','desc')->get();     
        
        return $sql->result_array();
    }

    public function getDataEkspedisi($no_ekspedisi = null){        
        $sql = $this->db->from('EC_FAKTUR_EAEA')->where('NO_EKSPEDISI', $no_ekspedisi)->order_by('TGL_EKSPEDISI','desc')->get();     
        
        return $sql->result_array();
    }
    
    public function getFaktur($no_ekspedisi = null){        
        $sql = $this->db->where('NO_EKSPEDISI', $no_ekspedisi)->order_by('TGL_FAKTUR','asc')->get('EC_FAKTUR_DETAILS');     
        
        return $sql->result_array();
    }

    public function getFakturByFaktur($NO_FAKTUR = null){        
        $sql = $this->db->where('NO_FAKTUR', $NO_FAKTUR)->order_by('TGL_FAKTUR','asc')->get('EC_FAKTUR_DETAILS');     
        
        return $sql->result_array();
    }
}
