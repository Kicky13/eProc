<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ec_pomut extends MY_Model {	
    public $table = 'EC_POMUT_DETAIL_SAP';
    public $primary_key = 'NO_BA';	                                                

    private function _mainQuery(){

        $sql = "
        SELECT PH.EBELN
                ,PH.EBELP
                ,PH.NO_BA
                ,PH.PERIOD
                ,PH.LIFNR 
                ,PH.NAME1
                ,PH.MATNR
                ,PH.MAKTX
                ,PH.CREATED_BY
                ,PH.CREATED_AT
                ,PH.APPROVED_BY
                ,PH.APPROVED_AT 
                ,PH.VENDOR_APPROVED
                ,PH.VENDOR_APPROVED_AT
                ,PH.STATUS
                ,PH.POT_PPH
                ,PH.KETR1
                ,PH.WERKS
                ,PH.TAHAP
            FROM EC_POMUT_HEADER_SAP PH
            JOIN EC_POMUT_DETAIL_SAP PD
                ON PH.NO_BA = PD.NO_BA
            JOIN EC_GR_SAP GS 
                ON PD.PRUEFLOS = GS.PRUEFLOS
        GROUP BY PH.EBELN 
                ,PH.EBELP 
                ,PH.NO_BA
                ,PH.PERIOD
                ,PH.LIFNR 
                ,PH.NAME1
                ,PH.MATNR
                ,PH.MAKTX 
                ,PH.CREATED_BY
                ,PH.CREATED_AT
                ,PH.APPROVED_BY
                ,PH.APPROVED_AT 
                ,PH.VENDOR_APPROVED
                ,PH.VENDOR_APPROVED_AT
                ,PH.STATUS
                ,PH.POT_PPH
                ,PH.KETR1
                ,PH.WERKS
                ,PH.TAHAP";

        return $sql;
    }

    public function getDataHeader($plant,$level){
        $filter = "WHERE PH.WERKS IN('$plant') AND PH.STATUS IN('$level')";

        $sql = "
            SELECT PH. EBELN PO_NO
                ,PH. EBELP PO_ITEM_NO
                ,PH.NO_BA
                ,SUBSTR(PERIOD,5,2) || '-' || SUBSTR(PERIOD,0,4) AS PERIODE
                ,PH.LIFNR NO_VENDOR
                ,PH.NAME1 VENDOR
                ,PH.MATNR MATERIAL_NO
                ,PH.MAKTX MATERIAL
                ,PH.CREATED_BY
                ,TO_CHAR(PH.CREATED_AT,'DD/MM/YYYY') CREATED_AT
                ,PH.APPROVED_BY
                ,TO_CHAR(PH.APPROVED_AT,'DD/MM/YYYY') APPROVED_AT 
                ,PH.VENDOR_APPROVED
                ,TO_CHAR(PH.VENDOR_APPROVED_AT ,'DD/MM/YYYY') VENDOR_APPROVED_AT  
                ,PH.STATUS
                ,PH.POT_PPH
                ,PH.KETR1
                ,PH.TAHAP
            FROM (
        ";

        $sql .= $this->_mainQuery();
        $sql .= ")PH ".$filter;
        return $this->db->query($sql,false)->result_array();
    }

    public function getDataReport($status,$no_vendor = null){
        $filter = "WHERE PH.STATUS IN ('".$status."')";
        $filter .= $no_vendor == null ? '' : " AND LIFNR = '$no_vendor'";
        $sql = "
            SELECT PH. EBELN PO_NO
                ,PH. EBELP PO_ITEM_NO
                ,PH.NO_BA
                ,SUBSTR(PERIOD,5,2) || '-' || SUBSTR(PERIOD,0,4) AS PERIODE
                ,PH.LIFNR NO_VENDOR
                ,PH.NAME1 VENDOR
                ,PH.MATNR MATERIAL_NO
                ,PH.MAKTX MATERIAL
                ,PH.CREATED_BY
                ,TO_CHAR(PH.CREATED_AT,'DD/MM/YYYY') CREATED_AT
                ,PH.APPROVED_BY
                ,TO_CHAR(PH.APPROVED_AT,'DD/MM/YYYY') APPROVED_AT 
                ,PH.STATUS
                ,PH.POT_PPH
                ,PH.KETR1
                ,PH.TAHAP
            FROM (
        ";

        $sql .= $this->_mainQuery();
        $sql .= ")PH ".$filter;
        return $this->db->query($sql,false)->result_array();
    }

    public function getDataDetail($ba_no){
        return $this->db->where('NO_BA',$ba_no)->get('EC_POMUT_DETAIL_SAP')->result_array();
    }

    public function getSingleHeader($ba_no){
        $sql = "
            SELECT A.*
                ,TO_CHAR(TGL_BA,'dd-mm-yyyy') TGL_BA2
                ,TO_CHAR(APPROVED_AT,'dd-mm-yyyy hh24:mi:ss') APPROVED_AT2
                ,TO_CHAR(VENDOR_APPROVED_AT,'dd-mm-yyyy hh24:mi:ss') VENDOR_APPROVED_AT2
                 FROM (
                SELECT * FROM EC_POMUT_HEADER_SAP
                WHERE NO_BA = '$ba_no'
            )A";
        return $this->db->query($sql,false)->row_array();

        //return $this->db->where('NO_BA',$ba_no)->get('EC_POMUT_HEADER_SAP')->row_array();
    }
}
