<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_report_pen_harga extends CI_Model
{
    protected $table = 'EC_T_CONTRACT', $tableTrackingPO = 'EC_TRACKING_PO', $tableApproval = 'EC_PL_APPROVAL', $tableCC = 'EC_M_COSTCENTER', $tableCart = 'EC_T_CHART', $tableVendor = 'VND_HEADER', $tablePrincipal = 'EC_PRINCIPAL_MANUFACTURER', $tableEC_R1 = 'EC_R1', $tableStrategic = 'EC_M_STRATEGIC_MATERIAL', $tableCompare = 'EC_T_PERBANDINGAN', $tableFeedback = 'EC_FEEDBACK', $tableAssign = 'EC_PL_ASSIGN', $tablePenawaran = 'EC_PL_PENAWARAN', $tableShipment = 'EC_T_SHIPMENT', $tableDetailShipment = 'EC_T_DETAIL_SHIPMENT', $tablePlant = 'EC_M_PLANT';

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    public function getPOReport(){
        $this->db->select('TC.*, APV.VENDORNO, APV.DOC_DATE, TO_CHAR (APV.DOC_DATE, \'dd-mm-yyyy\' ) DOCUMENT_DATE, APV.PROGRESS_APP, APV.MAX_APPROVE,
                    CASE
                        WHEN APV.PROGRESS_APP = (APV.MAX_APPROVE+1)
                        THEN \'Approved\'
                        WHEN APV.PROGRESS_APP = 1
                        THEN \'Commited\'
                    END AS STATUS_APPROVAL, TS.KODE_SHIPMENT, TS.STATUS AS STATUS_PO_SHIPMENT, DS.KODE_DETAIL_SHIPMENT, DS.STATUS, DS.QTY AS QTY_SHIPMENT, DS.ALASAN_REJECT,
                    DS.GR_NO, DS.IN_DATE_GR, DS.SEND_DATE, TO_CHAR (DS.SEND_DATE, \'dd-mm-yyyy\' ) DATE_SEND, DS.NO_SHIPMENT, MAT.MAKTX, MAT.MEINS, VEN.VENDOR_NAME, PEN.PLANT, PEN.DELIVERY_TIME, PEN.PRICE, PEN.CURRENCY,
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
        // return $result;
    }

    public function getMaterial(){
        $this->db->select('MATNR,MAKTX')->from($this->tableStrategic)->where(array('PUBLISHED_LANGSUNG' => '1'));
        $query = $this->db->get();
        return (array)$query->result_array();
    }

    public function getPlant(){
        $this->db->from($this->tablePlant);
        $query = $this->db->get(); 
        return (array)$query->result_array();
    }

    public function getPenawaran()
    {
        $SQL = "SELECT
                TB2.MATNO,
                SM.MAKTX,
                SM.MEINS,
                SM.MATKL,
                TB2.STOK,
                TB2.VENDORNO,
                TB2.STOK_COMMIT,
                DT3.PLANT,
                PLN.NAMA_PLANT,
                DT3.KODE_DETAIL_PENAWARAN,
                DT3.DELIVERY_TIME,
                DT3.INDATE,
                DT3.PRICE,
                DT3.CURRENCY,
                VEN.VENDOR_NAME,
                TO_CHAR (DT3.INDATE, 'dd-mm-yyyy' ) LAST_UPDATE
            FROM
                (
                    SELECT
                        PEN.VENDORNO,
                        PEN.MATNO,
                        MAX (PEN.INDATE) AS DATE1
                    FROM
                        EC_PL_PENAWARAN PEN
                    WHERE
                        MATNO IN (SELECT MAT.MATNR FROM EC_M_STRATEGIC_MATERIAL MAT WHERE MAT.PUBLISHED_LANGSUNG='1')
                    GROUP BY
                        PEN.VENDORNO,
                        PEN.MATNO
                ) TB1
            INNER JOIN EC_PL_PENAWARAN TB2 ON TB1.VENDORNO = TB2.VENDORNO
            AND TB1.MATNO = TB2.MATNO
            AND TB1.DATE1 = TB2.INDATE 
            LEFT JOIN (
                SELECT
                    DT2.*
                FROM
                    (
                        SELECT
                            PEN.VENDORNO,
                            PEN.MATNO,
                            PEN.PLANT,
                            MAX (PEN.INDATE) AS DATE1
                        FROM
                            EC_T_DETAIL_PENAWARAN PEN
                        WHERE
                            MATNO IN (SELECT MAT.MATNR FROM EC_M_STRATEGIC_MATERIAL MAT WHERE MAT.PUBLISHED_LANGSUNG='1')
                        AND PLANT IN (SELECT PLN.PLANT FROM EC_M_PLANT PLN)
                        GROUP BY
                            PEN.VENDORNO,
                            PEN.MATNO,
                            PEN.PLANT
                    ) DT1
                INNER JOIN EC_T_DETAIL_PENAWARAN DT2 ON DT1.VENDORNO = DT2.VENDORNO
                AND DT1.MATNO = DT2.MATNO
                AND DT1.DATE1 = DT2.INDATE
                WHERE
                    DT2.MATNO IN (SELECT MAT.MATNR FROM EC_M_STRATEGIC_MATERIAL MAT WHERE MAT.PUBLISHED_LANGSUNG='1')
                AND DT2.PLANT IN (SELECT PLN.PLANT FROM EC_M_PLANT PLN)
            ) DT3 ON DT3.MATNO = TB2.MATNO
            AND DT3.VENDORNO = TB2.VENDORNO
            INNER JOIN EC_M_STRATEGIC_MATERIAL SM ON TB1.MATNO=SM.MATNR
            INNER JOIN (SELECT PLANT,\"DESC\" NAMA_PLANT FROM EC_M_PLANT) PLN ON PLN.PLANT = DT3.PLANT
            INNER JOIN VND_HEADER VEN ON VEN.VENDOR_NO=TB2.VENDORNO
            WHERE
                TB2.MATNO IN (SELECT MAT.MATNR FROM EC_M_STRATEGIC_MATERIAL MAT WHERE MAT.PUBLISHED_LANGSUNG='1') 
                AND TB2.STOK > 0 AND DT3.PRICE != 0
            ORDER BY
                DT3.INDATE DESC";
        $result = $this->db->query($SQL);
        return (array)$result->result_array();
    }
}
