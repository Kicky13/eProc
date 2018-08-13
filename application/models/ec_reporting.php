<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_reporting extends CI_Model
{
    protected $table = 'EC_T_CONTRACT', $tableTrackingPO = 'EC_TRACKING_PO', $tableApproval = 'EC_PL_APPROVAL', $tableCC = 'EC_M_COSTCENTER', $tableCart = 'EC_T_CHART', $tableVendor = 'VND_HEADER', $tablePrincipal = 'EC_PRINCIPAL_MANUFACTURER', $tableEC_R1 = 'EC_R1', $tableStrategic = 'EC_M_STRATEGIC_MATERIAL', $tableCompare = 'EC_T_PERBANDINGAN', $tableFeedback = 'EC_FEEDBACK', $tableAssign = 'EC_PL_ASSIGN', $tablePenawaran = 'EC_PL_PENAWARAN', $tableShipment = 'EC_T_SHIPMENT', $tableDetailShipment = 'EC_T_DETAIL_SHIPMENT';

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    public function getPOReport(){
        $data = array();
        $PO_NO = 0;
        $this->db->select('GM.*, MAT.MAKTX, MAT.MEINS, TC.KODE_PENAWARAN, VEN.VENDOR_NAME, PEN.PLANT, PEN.PRICE, PEN.DELIVERY_TIME, PEN.CURRENCY, (GM.QTY_ORDER*PEN.PRICE) AS VALUE_ITEM, 
    TO_CHAR ((TO_DATE(TO_CHAR (GM.INDATE, \'dd-mm-yyyy hh24:mi:ss\'), \'dd-mm-yyyy hh24:mi:ss\')+TO_NUMBER(PEN.DELIVERY_TIME)), \'dd-mm-yyyy\' ) EXPIRED_DATE,
    TO_CHAR (GM.INDATE, \'dd-mm-yyyy\' ) DOC_DATE, PLN."DESC" AS PLANT_NAME', 
            false);
        $this->db->from('EC_GR_MATERIAL GM');
        $this->db->join('EC_M_STRATEGIC_MATERIAL MAT', 'MAT.MATNR=GM.MATNO', 'inner');
        $this->db->join('EC_T_CHART TC', 'TC.ID_CHART=GM.ID_CHART', 'inner');
        $this->db->join('EC_T_DETAIL_PENAWARAN PEN', 'PEN.KODE_DETAIL_PENAWARAN=TC.KODE_PENAWARAN', 'inner');
        $this->db->join('EC_M_PLANT PLN', 'PLN.PLANT=PEN.PLANT', 'inner');
        $this->db->join('VND_HEADER VEN', 'VEN.VENDOR_NO=PEN.VENDORNO', 'inner');
        $this->db->where("GM.STATUS !=", '0', TRUE);
        $this->db->order_by("GM.PO_NO DESC, GM.LINE_ITEM ASC");
        $sql = $this->db->get();
        $result = $sql->result_array();
        for ($i = 0; $i < count($result); $i++){
            if ($PO_NO != $result[$i]['PO_NO']){
                array_push($data, $result[$i]);
            }
            $PO_NO = $result[$i]['PO_NO'];
        }
        return $data;
    }

    public function getPODetail($po){
        $data = array();
        $PO_NO = $po;
        $this->db->select('GM.*, MAT.MAKTX, MAT.MEINS, TC.KODE_PENAWARAN, VEN.VENDOR_NAME, PEN.PLANT, PEN.PRICE, PEN.DELIVERY_TIME, PEN.CURRENCY, (GM.QTY_ORDER*PEN.PRICE) AS VALUE_ITEM, 
    TO_CHAR(GM.CHDATE,\'YYYY-MM-DD HH24:MI:SS\') EXPIRED_DATE,
    TO_CHAR (GM.INDATE, \'dd-mm-yyyy\' ) DOC_DATE, PLN."DESC" AS PLANT_NAME, PEN.VENDORNO',
            false);
        $this->db->from('EC_GR_MATERIAL GM');
        $this->db->join('EC_M_STRATEGIC_MATERIAL MAT', 'MAT.MATNR=GM.MATNO', 'inner');
        $this->db->join('EC_T_CHART TC', 'TC.ID_CHART=GM.ID_CHART', 'inner');
        $this->db->join('EC_T_DETAIL_PENAWARAN PEN', 'PEN.KODE_DETAIL_PENAWARAN = TC.KODE_PENAWARAN', 'inner');
        $this->db->join('EC_M_PLANT PLN', 'PLN.PLANT=PEN.PLANT', 'inner');
        $this->db->join('VND_HEADER VEN', 'VEN.VENDOR_NO=PEN.VENDORNO', 'inner');
        $this->db->where("GM.STATUS !=", '0', TRUE);
        $this->db->order_by("GM.PO_NO DESC, GM.LINE_ITEM ASC");
        $sql = $this->db->get();
        $result = $sql->result_array();
        for ($i = 0; $i < count($result); $i++){
            if ($PO_NO == $result[$i]['PO_NO']){
                array_push($data, $result[$i]);
            }
        }
        return $data;
    }

    public function getPOReportOld(){
        $this->db->select('TC.*, APV.VENDORNO, APV.DOC_DATE, TO_CHAR (APV.DOC_DATE, \'dd-mm-yyyy\' ) DOCUMENT_DATE, APV.PROGRESS_APP, APV.MAX_APPROVE,
                    CASE
                        WHEN APV.PROGRESS_APP = (APV.MAX_APPROVE+1)
                        THEN \'Approved\'
                        WHEN APV.PROGRESS_APP = 1
                        THEN \'Commited\'
                    END AS STATUS_APPROVAL, TS.KODE_SHIPMENT, TS.STATUS AS STATUS_PO_SHIPMENT, DS.KODE_DETAIL_SHIPMENT, DS.STATUS, DS.QTY AS QTY_SHIPMENT, DS.ALASAN_REJECT,
                    DS.GR_NO, DS.SEND_DATE, TO_CHAR (DS.SEND_DATE, \'dd-mm-yyyy\' ) DATE_SEND, DS.NO_SHIPMENT, MAT.MAKTX, MAT.MEINS, VEN.VENDOR_NAME, PEN.PLANT, PEN.DELIVERY_TIME, PEN.PRICE, PEN.CURRENCY,
                    (TC.QTY*PEN.PRICE) AS VALUE_ITEM, PLN."DESC" AS PLANT_NAME,
                    TO_CHAR ((TO_DATE(TO_CHAR (APV.DOC_DATE, \'dd-mm-yyyy hh24:mi:ss\'), \'dd-mm-yyyy hh24:mi:ss\')+TO_NUMBER(PEN.DELIVERY_TIME)), \'dd-mm-yyyy\' ) EXPIRED_DATE', 
            false);
        $this->db->from('EC_T_CHART TC');
        $this->db->join('EC_PL_APPROVAL APV', 'APV.PO_NO=TC.PO_NO', 'left');
        $this->db->join('EC_T_SHIPMENT TS', 'TS.PO_NO=TC.PO_NO', 'left');
        $this->db->join('EC_T_DETAIL_SHIPMENT DS', 'DS.ID_CHART=TC.ID_CHART', 'left');
        $this->db->join('EC_M_STRATEGIC_MATERIAL MAT', 'MAT.MATNR=TC.MATNO', 'inner');
        $this->db->join('VND_HEADER VEN', 'VEN.VENDOR_NO=APV.VENDORNO', 'inner');
        $this->db->join('EC_T_DETAIL_PENAWARAN PEN', 'PEN.KODE_DETAIL_PENAWARAN=TC.KODE_PENAWARAN', 'inner');
        $this->db->join('EC_M_PLANT PLN', 'PLN.PLANT=PEN.PLANT', 'inner');
        $this->db->where("TC.CONTRACT_NO", 'PL2017', TRUE);
        $this->db->where("TC.STATUS_CHART", '1', TRUE);
        $this->db->order_by("TC.PO_NO ASC, TC.LINE_ITEM ASC");
        $result = $this->db->get();
        return (array)$result->result_array();
    }
    
    public function getQtyIntransit($ID_CHART){
        $SQL = "SELECT (TO_NUMBER(QTY_SHIPMENT)-(TO_NUMBER(QTY_RECEIPT)+TO_NUMBER(QTY_REJECT))) AS QTY_INTRANSIT
                FROM (SELECT SUM(DS.QTY) AS QTY_SHIPMENT, SUM(DS.QTY_RECEIPT) AS QTY_RECEIPT, SUM(DS.QTY_REJECT) AS QTY_REJECT
                FROM EC_T_DETAIL_SHIPMENT DS
                WHERE DS.ID_CHART='" . $ID_CHART . "' AND DS.STATUS='1')";
        $result = $this->db->query($SQL);

        return $result->row_array();
    }
}
