<?php
class prc_perencanaan_pengadaan extends CI_Model {

    
    protected $table = 'PRC_PR_ITEM';
    // protected $join_item_status = false;


    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        // $this->join_item_status = false;
        
        
    }
    public function datapopup($idku){
        // $query = $this->db->query($q);
        $query = $this->db->query("SELECT
        PRC_PR_ITEM.PPI_ID,
        PRC_PR_ITEM.PPI_PRNO,
        PRC_PR_ITEM.PPI_NOMAT,
        PRC_PR_ITEM.PPI_PRITEM,
        PRC_PR_ITEM.PPI_DECMAT,
        PRC_PR_ITEM.PPI_MRPC,
        PRC_PR_ITEM.PPI_PLANT,
        ADM_PLANT.PLANT_CODE,
        ADM_PLANT.PLANT_NAME,
        PRC_PR_ITEM.PPI_MATGROUP,
        COM_MAT_GROUP.MAT_GROUP_CODE,
        COM_MAT_GROUP.MAT_GROUP_NAME
        FROM
        PRC_PR_ITEM
        INNER JOIN ADM_PLANT ON PRC_PR_ITEM.PPI_PLANT = ADM_PLANT.PLANT_CODE
        INNER JOIN COM_MAT_GROUP ON PRC_PR_ITEM.PPI_MATGROUP =  COM_MAT_GROUP.MAT_GROUP_CODE
        WHERE PRC_PR_ITEM.PPI_ID ='".$idku."'");
        $result = $query->result_array();
        return $result;
        // return $this->get(array('PRC_TENDER_ITEM.PPI_ID' => $idku));
    }
}