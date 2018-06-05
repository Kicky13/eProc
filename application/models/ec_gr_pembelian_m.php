<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_gr_pembelian_m extends CI_Model
{
    protected $table = 'EC_T_CONTRACT', $tableTrackingPO = 'EC_TRACKING_PO', $tableApproval = 'EC_PL_APPROVAL', $tableCC = 'EC_M_COSTCENTER', $tableCart = 'EC_T_CHART', $tableVendor = 'VND_HEADER', $tablePrincipal = 'EC_PRINCIPAL_MANUFACTURER', $tableEC_R1 = 'EC_R1', $tableStrategic = 'EC_M_STRATEGIC_MATERIAL', $tableCompare = 'EC_T_PERBANDINGAN', $tableFeedback = 'EC_FEEDBACK', $tableAssign = 'EC_PL_ASSIGN', $tablePenawaran = 'EC_PL_PENAWARAN', $tableShipment = 'EC_T_SHIPMENT', $tableDetailShipment = 'EC_T_DETAIL_SHIPMENT';

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }


    public function getItemShipment($USERID){
        $this->db->select('TC.MATNO, TC.DATE_BUY, TC.PO_NO, BT.KODE_SHIPMENT, BT.VENDORNO, TO_CHAR (BT.IN_DATE, \'dd-mm-yyyy hh24:mi:ss\') APPROVE_DATE, BT.STOCK_COMMIT, BT.QTY_SHIPMENT, BT.STATUS, VEN.VENDOR_NAME',
            false);
        $this->db->from('EC_T_CHART TC');
        //$this->db->from($this->tableShipment);
        $this->db->join('EC_T_SHIPMENT BT', 'BT.PO_NO=TC.PO_NO', 'INNER');
		$this->db->join('VND_HEADER VEN','BT.VENDORNO=VEN.VENDOR_NO','INNER');
        // $this->db->join('EC_T_DETAIL_PENAWARAN DP', 'DP.KODE_DETAIL_PENAWARAN = EC_T_CHART.KODE_PENAWARAN', 'inner');
        // $this->db->join('ADM_PLANT PL', 'PL.PLANT_CODE = DP.PLANT', 'left');
        $this->db->where("TC.ID_USER", $USERID, TRUE);
        $this->db->where("TC.STATUS_CHART", '1', TRUE);
        $this->db->where("TC.CONTRACT_NO", 'PL2017', TRUE);
        $this->db->where("TC.PO_NO IS NOT NULL");
        //$this->db->order_by('BT.STATUS ASC');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function countShipment($USERID){ 
        $this->db->select('COUNT(*)',
            false);
        $this->db->from('EC_T_CHART TC');
        //$this->db->from($this->tableShipment);
        $this->db->join('(SELECT TS.* FROM EC_T_SHIPMENT TS WHERE TS.STATUS=\'2\') BT', 'BT.PO_NO=TC.PO_NO', 'inner');
		
        $this->db->join('(SELECT * FROM EC_T_SHIPMENT WHERE STATUS=\'2\') DTS', 'DTS.KODE_SHIPMENT=BT.KODE_SHIPMENT', 'inner');
        // $this->db->join('EC_T_DETAIL_PENAWARAN DP', 'DP.KODE_DETAIL_PENAWARAN = EC_T_CHART.KODE_PENAWARAN', 'inner');
        // $this->db->join('ADM_PLANT PL', 'PL.PLANT_CODE = DP.PLANT', 'left');
        $this->db->where("TC.ID_USER", $USERID, TRUE);
        $this->db->where("TC.STATUS_CHART", '1', TRUE);
        $this->db->where("TC.CONTRACT_NO", 'PL2017', TRUE);
        $this->db->where("TC.PO_NO IS NOT NULL");
        $result = $this->db->get();
        $count = $result->row_array();
        return $count['COUNT(*)'];
        //return (array)$result->result_array();
    }

    public function getPORelease($VENDORNO){
        $this->db->select('SH.KODE_SHIPMENT, SH.PO_NO, SH.MATNO, SH.STATUS, TO_CHAR (SH.IN_DATE, \'dd-mm-yyyy hh24:mi:ss\') RELEASE_DATE, SH.ALASAN_REJECT, SH.GR_NO, TO_CHAR (SH.SEND_DATE, \'dd-mm-yyyy hh24:mi:ss\') DATE_SEND,  TO_CHAR (SH.IN_DATE_GR, \'dd-mm-yyyy hh24:mi:ss\') GR_DATE',
            false);
        $this->db->from('EC_T_SHIPMENT SH');
        //$this->db->from($this->tableShipment);
        // $this->db->join('EC_M_STRATEGIC_MATERIAL SM', 'SM.MATNR = EC_T_CHART.MATNO', 'left');
        // $this->db->join('EC_T_DETAIL_PENAWARAN DP', 'DP.KODE_DETAIL_PENAWARAN = EC_T_CHART.KODE_PENAWARAN', 'inner');
        // $this->db->join('ADM_PLANT PL', 'PL.PLANT_CODE = DP.PLANT', 'left');
        $this->db->where("SH.VENDORNO", $VENDORNO, TRUE);
        $result = $this->db->get();
        return (array)$result->result_array();
    }

//730
    public function getPo_pl_approval($userid)
    {
        $this->db->select('CT.PO_NO NOMERPO,TO_CHAR ((TO_DATE(CT.DATE_BUY, \'dd-mm-yyyy hh24:mi:ss\')+7), \'dd-mm-yyyy hh24:mi:ss\' ) COMMIT_DATE, CT.DATE_BUY,EC_PL_APPROVAL.CURR, VND_HEADER.VENDOR_NAME,  TDP.PRICE,TDP.STOK_COMMIT, EC_PL_APPROVAL.VENDORNO,  EC_TRACKING_PO.*',
            false);
        $this->db->from('(SELECT  PO_NO,  DATE_BUY FROM EC_T_CHART  WHERE CONTRACT_NO =  \'PL2017\' AND PO_NO IS NOT NULL GROUP BY  PO_NO, DATE_BUY ) CT');
        $this->db->join('(SELECT P1.* FROM EC_TRACKING_PO P1 INNER JOIN (SELECT PO_NO,MAX(INDATE) DATE1 FROM EC_TRACKING_PO GROUP BY PO_NO) P2 ON P1.PO_NO=P2.PO_NO AND P1.INDATE=P2.DATE1 )EC_TRACKING_PO',
            'EC_TRACKING_PO.PO_NO = CT.PO_NO', 'left');
        $this->db->join('EC_PL_APPROVAL', 'CT.PO_NO = EC_PL_APPROVAL.PO_NO', 'inner');
        $this->db->join('VND_HEADER', 'VND_HEADER.VENDOR_NO = EC_PL_APPROVAL.VENDORNO', 'left');
        $this->db->join('EC_PL_CONFIG_APPROVAL', 'EC_PL_APPROVAL.PROGRESS_APP = EC_PL_CONFIG_APPROVAL.PROGRESS_CNF AND EC_PL_APPROVAL.COSCENTER = EC_PL_CONFIG_APPROVAL.UK_CODE', 'inner');
        $this->db->join('(SELECT SUM(PRICE) PRICE,SUM(STOK_COMMIT) STOK_COMMIT,PO_NO FROM EC_T_DETAIL_PENAWARAN 
						INNER JOIN EC_T_CHART CT ON CT.KODE_PENAWARAN = EC_T_DETAIL_PENAWARAN.KODE_DETAIL_PENAWARAN 
						GROUP BY PO_NO) TDP ', 'CT.PO_NO = TDP.PO_NO', 'inner');
        $this->db->where('EC_PL_CONFIG_APPROVAL.USERID', $userid, TRUE);
//        $this->db->where('EC_PL_CONFIG_APPROVAL.UK_CODE', $userid, TRUE);
        $this->db->where('EC_PL_APPROVAL.STATUS', '1', TRUE);
        $this->db->where('EC_PL_APPROVAL.PROGRESS_APP<=', 'EC_PL_APPROVAL.MAX_APPROVE', false);
        $this->db->where('(TO_DATE(CT.DATE_BUY, \'dd-mm-yyyy hh24:mi:ss\')+7) >=', '(SELECT SYSDATE FROM DUAL)', false);
        //$this->db->order_by('CT.PO_NO DESC');
        $this->db->order_by('CT.DATE_BUY DESC');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function approve($PO)
    {
        $this->db->trans_start();

        $this->db->where("PO_NO", $PO, TRUE);
        $this->db->set('PROGRESS_APP', 'PROGRESS_APP+1', FALSE);
        $this->db->update($this->tableApproval);

        $this->db->select('PROGRESS_APP,MAX_APPROVE')->from($this->tableApproval);
        $this->db->where("PO_NO", $PO, TRUE);
        $query = $this->db->get();
        $result = $query->row_array();
        $PROGRESS_APP = $result['PROGRESS_APP'];
        $MAX_APPROVE = $result['MAX_APPROVE'];

        if ($PROGRESS_APP == $MAX_APPROVE + 1)
            $SQL = "INSERT INTO EC_TRACKING_PO VALUES ( 
            '" . $PO . "', TO_DATE('" . date("Y-m-d H:i:s") . "', 'yyyy-mm-dd hh24:mi:ss'), 2,1,'" . $this->session->userdata['ID'] . "', '" .
                $this->session->userdata['FULLNAME'] . "')";
        else
            $SQL = "INSERT INTO EC_TRACKING_PO VALUES ( 
            '" . $PO . "', TO_DATE('" . date("Y-m-d H:i:s") . "', 'yyyy-mm-dd hh24:mi:ss'), 1,null,'" . $this->session->userdata['ID'] . "', '" .
                $this->session->userdata['FULLNAME'] . "')";
        $this->db->query($SQL);

        $this->db->trans_complete();

        return $PROGRESS_APP == $MAX_APPROVE + 1;
    }

    function reject($KODE_DETAIL_SHIPMENT)
    {
        $this->db->where("KODE_DETAIL_SHIPMENT", $KODE_DETAIL_SHIPMENT, TRUE);
        $this->db->update($this->tableDetailShipment, array('STATUS' => '5'));

        /*$SQL = "INSERT INTO EC_TRACKING_PO VALUES ( 
            '" . $PO . "', TO_DATE('" . date("Y-m-d H:i:s") . "', 'yyyy-mm-dd hh24:mi:ss'), 1,null,'" . $this->session->userdata['ID'] . "', '" .
            $this->session->userdata['FULLNAME'] . "')";*/
        //$this->db->query($SQL);
    }


    function detail($kode_shipment)
    {
        $this->db->select('DS.*, TO_CHAR (DS.SEND_DATE, \'dd-mm-yyyy\') DATE_SEND, TS.PO_NO, MAT.MAKTX, MAT.MEINS, TC.KODE_PENAWARAN, PEN.PRICE, PEN.CURRENCY', false);
        $this->db->from('EC_T_DETAIL_SHIPMENT DS');
        $this->db->join('EC_T_SHIPMENT TS', 'TS.KODE_SHIPMENT=DS.KODE_SHIPMENT', 'inner');
        $this->db->join('EC_T_CHART TC', 'TS.PO_NO=TC.PO_NO', 'INNER');
        $this->db->join('EC_M_STRATEGIC_MATERIAL MAT', 'TC.MATNO=MAT.MATNR', 'inner');        
        $this->db->join('EC_T_DETAIL_PENAWARAN PEN', 'PEN.KODE_DETAIL_PENAWARAN=TC.KODE_PENAWARAN', 'INNER');
        $this->db->where("DS.KODE_SHIPMENT", $kode_shipment, TRUE);
        $result = $this->db->get();
        return (array)$result->result_array();
    }


    function detailCart($PO)
    {
        $this->db->select(' CT.MATNO,DT.VENDORNO,
                            DT.PLANT,
                            DT.DELIVERY_TIME,
                            TO_CHAR(TP.APPROVED , \'DD.MM.YYYY\' ) AS APPROVED	,
                            TO_CHAR((TP.APPROVED+DT.DELIVERY_TIME) , \'DD.MM.YYYY\' ) AS EST_DELIV',
            false);
        $this->db->from('EC_T_CHART CT');
        $this->db->join('EC_T_DETAIL_PENAWARAN DT', 'DT.KODE_DETAIL_PENAWARAN = CT.KODE_PENAWARAN', 'inner');
        $this->db->join('(SELECT MAX(INDATE) APPROVED,PO_NO FROM EC_TRACKING_PO GROUP BY PO_NO) TP',
            'TP.PO_NO = CT.PO_NO', 'inner');
        $this->db->where("CT.PO_NO", $PO, TRUE);
        $result = $this->db->get();
        return (array)$result->result_array();
    }


    function history($PO)
    {
        $this->db->select('TO_CHAR(INDATE , \'DD/MM/YYYY hh24:mi:ss\' ) AS TANGGAL,EC_TRACKING_PO.*', false);
        $this->db->from($this->tableTrackingPO);
        $this->db->where("PO_NO", $PO, TRUE);
        $this->db->order_by('INDATE ASC');
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function insertToShipment($data, $PO)
    {
        $this->db->trans_start();
        $this->db->select(' CT.MATNO,DT.VENDORNO,
                            DT.PLANT,
                            DT.DELIVERY_TIME,
                            TO_CHAR(TP.APPROVED , \'DD.MM.YYYY\' ) AS APPROVED  ,
                            TO_CHAR((TP.APPROVED+DT.DELIVERY_TIME) , \'DD.MM.YYYY\' ) AS EST_DELIV',
            false);
        $this->db->from('EC_T_CHART CT');
        $this->db->join('EC_T_DETAIL_PENAWARAN DT', 'DT.KODE_DETAIL_PENAWARAN = CT.KODE_PENAWARAN', 'inner');
        $this->db->join('(SELECT MAX(INDATE) APPROVED,PO_NO FROM EC_TRACKING_PO GROUP BY PO_NO) TP',
            'TP.PO_NO = CT.PO_NO', 'inner');
        $this->db->where("CT.PO_NO", $PO, TRUE);
        $query = $this->db->get();
        $result = $query->row_array();

        $SQL = "INSERT INTO EC_T_SHIPMENT VALUES ( 
            '','" . $PO . "','" . $result['MATNO'] . "','" . $result['VENDORNO'] . "','1','','', TO_DATE('" . date("Y-m-d H:i:s") . "', 'yyyy-mm-dd hh24:mi:ss'),'','')";
        $this->db->query($SQL);

        $this->db->trans_complete();
    }

    public function getItemShipment_sap($KODE_DETAIL_SHIPMENT){
        $this->db->select('TC.MATNO, TC.DATE_BUY, TC.PO_NO, BT.KODE_SHIPMENT, DTS.STATUS, TO_CHAR (DTS.SEND_DATE, \'dd-mm-yyyy hh24:mi:ss\') DATE_SEND, DTS.GR_NO, TO_CHAR (BT.IN_DATE_GR, \'dd-mm-yyyy hh24:mi:ss\') DATE_GR,DTS.KODE_DETAIL_SHIPMENT,DTS.QTY',
            false);
        $this->db->from('EC_T_CHART TC');
        //$this->db->from($this->tableShipment);
        $this->db->join('(SELECT TS.* FROM EC_T_SHIPMENT TS WHERE TS.STATUS!=\'1\') BT', 'BT.PO_NO=TC.PO_NO', 'left');
        $this->db->join('(SELECT * FROM EC_T_DETAIL_SHIPMENT WHERE STATUS!=1) DTS','BT.KODE_SHIPMENT=DTS.KODE_SHIPMENT','INNER');
        // $this->db->join('EC_T_DETAIL_PENAWARAN DP', 'DP.KODE_DETAIL_PENAWARAN = EC_T_CHART.KODE_PENAWARAN', 'inner');
        // $this->db->join('ADM_PLANT PL', 'PL.PLANT_CODE = DP.PLANT', 'left');
        $this->db->where("DTS.KODE_DETAIL_SHIPMENT", $KODE_DETAIL_SHIPMENT, TRUE);
        $this->db->where("TC.STATUS_CHART", '1', TRUE);
        $this->db->where("TC.CONTRACT_NO", 'PL2017', TRUE);
        $this->db->where("TC.PO_NO IS NOT NULL");
        $this->db->order_by('BT.STATUS ASC');
        $result = $this->db->get();
        return (array)$result->result_array();
        //return $result->row_array();
    }

    public function getDetailItemShipment($KODE_DETAIL_SHIPMENT){
        $this->db->select('DT.*, SIP.PO_NO, SIP.MATNO, SIP.VENDORNO, TO_CHAR (SIP.IN_DATE, \'yyyymmdd\') DATE_APPROVE', false);
        $this->db->from('EC_T_DETAIL_SHIPMENT DT');
        $this->db->join('EC_T_SHIPMENT SIP','DT.KODE_SHIPMENT=SIP.KODE_SHIPMENT','INNER');
        $this->db->where("DT.KODE_DETAIL_SHIPMENT", $KODE_DETAIL_SHIPMENT, TRUE);
        $result = $this->db->get();
        //return (array)$result->result_array();
        return $result->row_array();
    }

    public function updateStatus($kode_detail_shipment, $gr_no, $gr_year, $kode_shipment, $QTY){
        //$this->db->trans_start();

        $this->db->where("KODE_DETAIL_SHIPMENT", $kode_detail_shipment, TRUE);
        $this->db->set('STATUS', '2', FALSE);
        $this->db->set('GR_NO', $gr_no, FALSE);
        //$this->db->set('IN_DATE_GR', "to_date('" . date("Y-m-d H:i:s") . "','yyyy-mm-dd hh24:mi:ss')", FALSE);
        $this->db->set('IN_DATE_GR', $gr_year, FALSE);
        $this->db->update($this->tableDetailShipment);
        //$this->db->trans_complete();

        $this->db->select('SIP.QTY_SHIPMENT', false);
        $this->db->from('EC_T_SHIPMENT SIP');
        //$this->db->join('EC_T_SHIPMENT SIP','DT.KODE_SHIPMENT=SIP.KODE_SHIPMENT','INNER');
        $this->db->where("SIP.KODE_SHIPMENT", $kode_shipment, TRUE);
        $result = $this->db->get();
        //return (array)$result->result_array();
        $TEMPQTY = $result->row_array();
        //var_dump(($TEMPQTY['QTY_SHIPMENT']+$QTY));
        $this->db->where("KODE_SHIPMENT", $kode_shipment, TRUE);
        $this->db->set('QTY_SHIPMENT', ($TEMPQTY['QTY_SHIPMENT']+$QTY), FALSE);
        //$this->db->set('GR_NO', $gr_no, FALSE);
        //$this->db->set('IN_DATE_GR', "to_date('" . date("Y-m-d H:i:s") . "','yyyy-mm-dd hh24:mi:ss')", FALSE);
        //$this->db->set('IN_DATE_GR', $gr_year, FALSE);
        $this->db->update($this->tableShipment);
    }
	
}
