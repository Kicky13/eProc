<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ec_shipment_m extends CI_Model
{
    protected $table = 'EC_T_CONTRACT', $tableTrackingPO = 'EC_TRACKING_PO', $tableApproval = 'EC_PL_APPROVAL', $tableCC = 'EC_M_COSTCENTER', $tableCart = 'EC_T_CHART', $tableVendor = 'VND_HEADER', $tablePrincipal = 'EC_PRINCIPAL_MANUFACTURER', $tableEC_R1 = 'EC_R1', $tableStrategic = 'EC_M_STRATEGIC_MATERIAL', $tableCompare = 'EC_T_PERBANDINGAN', $tableFeedback = 'EC_FEEDBACK', $tableAssign = 'EC_PL_ASSIGN', $tablePenawaran = 'EC_PL_PENAWARAN', $tableShipment = 'EC_T_SHIPMENT', $tableDetailShipment = 'EC_T_DETAIL_SHIPMENT', $tableEmployee = 'ADM_EMPLOYEE', $tableHeaderGr = 'EC_GR_MATERIAL';

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    public function getPORelease($VENDORNO){
        $this->db->select('EC_T_SHIPMENT.*, EC_PL_APPROVAL.*,TO_CHAR (EC_T_SHIPMENT.IN_DATE, \'dd-mm-yyyy\' ) APPROVE_DATE', 
            false);
        $this->db->from($this->tableShipment);
        $this->db->join('EC_PL_APPROVAL', 'EC_T_SHIPMENT.PO_NO=EC_PL_APPROVAL.PO_NO', 'inner');
        $this->db->where("EC_T_SHIPMENT.VENDORNO", $VENDORNO, TRUE);
        $this->db->order_by("EC_T_SHIPMENT.PO_NO DESC");
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getPOorder($VENDORNO){
        $this->db->select('PL.*, TC.*, DP.PRICE, DP.PLANT, PLN."DESC" AS PLANT_NAME, (TC.QTY*DP.PRICE) AS VALUE_ITEM, MAT.MAKTX, MAT.MEINS, TO_CHAR (PL.DOC_DATE, \'DD-MM-YYYY\') AS DATE_ORDER', 
            false);
        $this->db->from('EC_PL_APPROVAL PL');
        $this->db->join('EC_T_CHART TC', 'PL.PO_NO=TC.PO_NO', 'left');
        $this->db->join('EC_T_DETAIL_PENAWARAN DP', 'TC.KODE_PENAWARAN=DP.KODE_DETAIL_PENAWARAN', 'inner');
        $this->db->join('EC_M_STRATEGIC_MATERIAL MAT', 'TC.MATNO=MAT.MATNR', 'inner');
        $this->db->join('EC_M_PLANT PLN', 'DP.PLANT=PLN.PLANT', 'inner');
        $this->db->join('EC_T_SHIPMENT ETS', 'TC.PO_NO=ETS.PO_NO','LEFT');
        $this->db->where("PL.VENDORNO", $VENDORNO, TRUE);
        $this->db->where("PL.PROGRESS_APP <= PL.MAX_APPROVE");
        $this->db->where("PL.STATUS", '1', TRUE);
        $this->db->where("TC.PO_NO !=", 'null', TRUE);  
        $this->db->where('ETS.PO_NO IS NULL', NULL, false);
        $this->db->order_by("PL.PO_NO DESC, TC.LINE_ITEM ASC"); 
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    /*public function getPODetail($PO)
    {
        $this->db->select('EC_T_CHART.MATNO,SM.MAKTX,EC_T_CHART.QTY,SM.MEINS, EC_T_CHART.LINE_ITEM, DP.PRICE,(EC_T_CHART.QTY*DP.PRICE) TOTAL,DP.CURRENCY,DP.PLANT,PL.PLANT_NAME,DP.DELIVERY_TIME',
            false);
        $this->db->from($this->tableCart);
        $this->db->join('EC_M_STRATEGIC_MATERIALc SM', 'SM.MATNR = EC_T_CHART.MATNO', 'left');
        $this->db->join('EC_T_DETAIL_PENAWARAN DP', 'DP.KODE_DETAIL_PENAWARAN = EC_T_CHART.KODE_PENAWARAN', 'inner');
        $this->db->join('ADM_PLANT PL', 'PL.PLANT_CODE = DP.PLANT', 'left');
        $this->db->where("EC_T_CHART.PO_NO", $PO, TRUE);
        $this->db->order_by("EC_T_CHART.LINE_ITEM ASC");
        $result = $this->db->get();
        return (array)$result->result_array();
    }*/

    public function getPODetail($PO){
        $this->db->select('TS.*, TC.*, DP.PLANT, DP.DELIVERY_TIME, DP.PRICE, DP.CURRENCY, PLN."DESC" AS PLANT_NAME, MAT.MAKTX, MAT.MEINS, (TC.QTY*DP.PRICE) TOTAL,
            TO_CHAR (TS.IN_DATE, \'dd-mm-yyyy\' ) APPROVE_DATE,
            TO_CHAR ((TO_DATE(TO_CHAR (TS.IN_DATE, \'dd-mm-yyyy hh24:mi:ss\'), \'dd-mm-yyyy hh24:mi:ss\')+TO_NUMBER(DP.DELIVERY_TIME)), \'dd-mm-yyyy\' ) EXPIRED_DATE, GM.QTY_SHIPMENT AS QTY_RECEIPT', 
            false);
        $this->db->from('EC_T_SHIPMENT TS');
        $this->db->join('EC_T_CHART TC', 'TC.PO_NO=TS.PO_NO', 'left');
        $this->db->join('EC_T_DETAIL_PENAWARAN DP', 'TC.KODE_PENAWARAN=DP.KODE_DETAIL_PENAWARAN', 'inner');
        $this->db->join('EC_M_PLANT PLN', 'DP.PLANT=PLN.PLANT', 'inner');
        $this->db->join('EC_M_STRATEGIC_MATERIAL MAT', 'TC.MATNO=MAT.MATNR', 'inner');
        $this->db->join('EC_GR_MATERIAL GM', 'GM.PO_NO=TS.PO_NO AND GM.MATNO=TC.MATNO AND GM.LINE_ITEM=TC.LINE_ITEM', 'INNER');
        $this->db->where("TC.PO_NO", $PO, TRUE);
        $this->db->order_by("TC.PO_NO DESC, TC.LINE_ITEM ASC");
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getQtyIntransit($ID_CHART){
        $SQL = "SELECT (SUM(TB1.QTY)-(SUM(TB1.QTY_RECEIPT)+SUM(TB1.QTY_REJECT))) AS QTY_INTRANSIT
                FROM (SELECT DS.* FROM EC_T_DETAIL_SHIPMENT DS WHERE DS.ID_CHART='" . $ID_CHART . "' AND DS.STATUS!=0) TB1";
        $result = $this->db->query($SQL);

        return $result->row_array();
    }

    public function getQtyReject($ID_CHART){
        $SQL = "SELECT SUM(TB1.QTY_REJECT) AS QTY_REJECT
                FROM (SELECT DS.* FROM EC_T_DETAIL_SHIPMENT DS WHERE DS.ID_CHART='" . $ID_CHART . "') TB1";
        $result = $this->db->query($SQL);

        return $result->row_array();
    }

    public function detailHistory($PO){
        $this->db->select('TS.PO_NO, TS.STOCK_COMMIT, TS.QTY_SHIPMENT, DS.*, TC.MATNO, TC.STOK_COMMIT, TC.LINE_ITEM, TC.KODE_PENAWARAN, MAT.MAKTX, MAT.MEINS, 
        PEN.PLANT, PLN."DESC" AS PLANT_NAME, TO_CHAR (DS.SEND_DATE, \'dd-mm-yyyy\' ) DATE_SEND', 
            false);
        $this->db->from('EC_T_SHIPMENT TS');
        $this->db->join('EC_T_DETAIL_SHIPMENT DS', 'DS.KODE_SHIPMENT=TS.KODE_SHIPMENT', 'left');
        $this->db->join('EC_T_CHART TC', 'TC.ID_CHART= DS.ID_CHART', 'inner');
        $this->db->join('EC_M_STRATEGIC_MATERIAL MAT', 'TC.MATNO=MAT.MATNR', 'inner');
        $this->db->join('EC_T_DETAIL_PENAWARAN PEN', 'TC.KODE_PENAWARAN=PEN.KODE_DETAIL_PENAWARAN', 'inner');
        $this->db->join('EC_M_PLANT PLN', 'PEN.PLANT=PLN.PLANT', 'inner');
        
        // $this->db->join('ADM_PLANT PL', 'PL.PLANT_CODE = DP.PLANT', 'left');
        $this->db->where("TS.PO_NO", $PO, TRUE);
        $this->db->order_by("TC.LINE_ITEM ASC");
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function detailIntransit($VENDORNO){
        $this->db->select('TS.PO_NO, TS.VENDORNO,TB1.*, TC.MATNO, TC.QTY AS QTY_ORDER, MAT.MAKTX, MAT.MEINS, TC.LINE_ITEM, PEN.PLANT, PEN.DELIVERY_TIME, PEN.PRICE, PEN.CURRENCY, (TC.QTY*PEN.PRICE) AS VALUE_ITEM,
    PLN."DESC" AS PLANT_NAME, TO_CHAR (TS.IN_DATE, \'dd-mm-yyyy\') AS DATE_ORDER,
    TO_CHAR ((TO_DATE(TO_CHAR (TS.IN_DATE, \'dd-mm-yyyy hh24:mi:ss\'), \'dd-mm-yyyy hh24:mi:ss\')+TO_NUMBER(PEN.DELIVERY_TIME)), \'dd-mm-yyyy\') EXPIRED_DATE', 
            false);
        $this->db->from('EC_T_SHIPMENT TS');
        $this->db->join('(SELECT DS.* FROM EC_T_DETAIL_SHIPMENT DS WHERE DS.STATUS != 0) TB1', 'TB1.KODE_SHIPMENT=TS.KODE_SHIPMENT', 'inner');
        $this->db->join('EC_T_CHART TC', 'TC.ID_CHART= TB1.ID_CHART', 'inner');
        $this->db->join('EC_M_STRATEGIC_MATERIAL MAT', 'TC.MATNO=MAT.MATNR', 'inner');
        $this->db->join('EC_T_DETAIL_PENAWARAN PEN', 'TC.KODE_PENAWARAN=PEN.KODE_DETAIL_PENAWARAN', 'inner');
        $this->db->join('EC_M_PLANT PLN', 'PEN.PLANT=PLN.PLANT', 'inner');
        
        // $this->db->join('ADM_PLANT PL', 'PL.PLANT_CODE = DP.PLANT', 'left');
        $this->db->where("TS.VENDORNO", $VENDORNO, TRUE);
        $this->db->order_by("TB1.IN_DATE DESC, TC.LINE_ITEM ASC");        
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function detailIntransitOld(){
        $this->db->select('TS.PO_NO, TS.STOCK_COMMIT, TS.IN_DATE, TS.QTY_SHIPMENT, DS.*, TC.MATNO, TC.STOK_COMMIT, TC.LINE_ITEM, TC.KODE_PENAWARAN, MAT.MAKTX, MAT.MEINS, PEN.PRICE, (TC.STOK_COMMIT*PEN.PRICE) AS VALUE_ITEM, PEN.CURRENCY,
        PEN.PLANT, PLN."DESC" AS PLANT_NAME, TO_CHAR (DS.SEND_DATE, \'dd-mm-yyyy\' ) DATE_SEND, TO_CHAR ((TO_DATE(TO_CHAR (TS.IN_DATE, \'dd-mm-yyyy hh24:mi:ss\'), \'dd-mm-yyyy hh24:mi:ss\')+TO_NUMBER(PEN.DELIVERY_TIME)), \'dd-mm-yyyy\' ) EXPIRED_DATE, TO_CHAR (TS.IN_DATE, \'DD-MM-YYYY\') AS DATE_ORDER', 
            false);
        $this->db->from('EC_T_SHIPMENT TS');
        $this->db->join('EC_T_DETAIL_SHIPMENT DS', 'DS.KODE_SHIPMENT=TS.KODE_SHIPMENT', 'left');
        $this->db->join('EC_T_CHART TC', 'TC.ID_CHART= DS.ID_CHART', 'inner');
        $this->db->join('EC_M_STRATEGIC_MATERIAL MAT', 'TC.MATNO=MAT.MATNR', 'inner');
        $this->db->join('EC_T_DETAIL_PENAWARAN PEN', 'TC.KODE_PENAWARAN=PEN.KODE_DETAIL_PENAWARAN', 'inner');
        $this->db->join('EC_M_PLANT PLN', 'PEN.PLANT=PLN.PLANT', 'inner');
        
        // $this->db->join('ADM_PLANT PL', 'PL.PLANT_CODE = DP.PLANT', 'left');
        // $this->db->where("TS.PO_NO", $PO, TRUE);
        $this->db->order_by("DS.NO_SHIPMENT ASC, TC.LINE_ITEM ASC");
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getPORelease_old2($VENDORNO){
        $this->db->select('TS.*, TC.*, DP.PLANT, DP.DELIVERY_TIME, DP.PRICE, DP.CURRENCY, PLN."DESC", MAT.MAKTX, MAT.MEINS,
            TO_CHAR (TS.IN_DATE, \'dd-mm-yyyy\' ) APPROVE_DATE,
            TO_CHAR ((TO_DATE(TS.IN_DATE, \'dd-mm-yyyy hh
            24:mi:ss\')+TO_NUMBER(DP.DELIVERY_TIME)), \'dd-mm-yyyy\' ) EXPIRED_DATE',
            false);
        $this->db->from('EC_T_SHIPMENT TS');
        $this->db->join('EC_T_CHART TC', 'TC.PO_NO=TS.PO_NO', 'left');
        $this->db->join('EC_T_DETAIL_PENAWARAN DP', 'TC.KODE_PENAWARAN=DP.KODE_DETAIL_PENAWARAN', 'inner');
        $this->db->join('EC_M_PLANT PLN', 'DP.PLANT=PLN.PLANT', 'inner');
        $this->db->join('EC_M_STRATEGIC_MATERIAL MAT', 'TC.MATNO=MAT.MATNR', 'inner');
        // $this->db->join('ADM_PLANT PL', 'PL.PLANT_CODE = DP.PLANT', 'left');
        $this->db->where("TS.VENDORNO", $VENDORNO, TRUE);
        $this->db->order_by("TC.PO_NO DESC, TC.LINE_ITEM ASC");
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    public function getPORelease_old($VENDORNO){
        $this->db->select('SH.KODE_SHIPMENT, SH.PO_NO, SH.MATNO, SH.STATUS, TO_CHAR (SH.IN_DATE, \'dd-mm-yyyy hh24:mi:ss\') RELEASE_DATE, SH.ALASAN_REJECT, SH.GR_NO, TO_CHAR (SH.SEND_DATE, \'dd-mm-yyyy hh24:mi:ss\') DATE_SEND,  TO_CHAR (SH.IN_DATE_GR, \'dd-mm-yyyy hh24:mi:ss\') GR_DATE,SH.STOCK_COMMIT,SH.QTY_SHIPMENT', 
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

    public function updateStatus($kode_shipment){
        $this->db->trans_start();

        $this->db->where("KODE_SHIPMENT", $kode_shipment, TRUE);
        $this->db->set('STATUS', '2', FALSE);
        $this->db->set('SEND_DATE', "to_date('" . date("Y-m-d H:i:s") . "','yyyy-mm-dd hh24:mi:ss')", FALSE);
        $this->db->update($this->tableShipment);
					 
		
        $this->db->trans_complete();
    }

    public function cekQty($kode_shipment){
        //$this->db->trans_start();

        $this->db->select('SUM(DT.QTY) AS TOTAL', false);
        $this->db->from('EC_T_DETAIL_SHIPMENT DT');
        $this->db->where("DT.KODE_SHIPMENT", $kode_shipment, TRUE);
        $result = $this->db->get();
        return (array)$result->result_array();    
        
        //$this->db->trans_complete();
    }
	
	public function updateStatus_qty($qtyShipment,$tglShipment,$kodeShipment){
        $this->db->trans_start();

		$SQL = "INSERT INTO  EPROC . EC_T_DETAIL_SHIPMENT  (
				 KODE_SHIPMENT,
				 STATUS,
				 QTY,
				 QTY_PO_COMMIT,
				 ALASAN_REJECT,
				 GR_NO,
				 IN_DATE,
				 IN_DATE_GR,
				 SEND_DATE
			) VALUES ( 
						'".$kodeShipment."','1','".$qtyShipment."','0','','', TO_DATE('" . date("Y-m-d H:i:s") . "', 'yyyy-mm-dd hh24:mi:ss'),'',TO_DATE('".$tglShipment."','DD-MM-YY'))";
        $this->db->query($SQL);

				
        // $this->db->where("KODE_SHIPMENT", $kodeShipment, TRUE);
        // $this->db->set('STATUS', '2', FALSE);
        // $this->db->set('SEND_DATE', "to_date('" . date("Y-m-d H:i:s") . "','yyyy-mm-dd hh24:mi:ss')", FALSE);
        // $this->db->update($this->tableShipment);
		
		
		 
		
        $this->db->trans_complete();
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

    function approveVendor($po)
    {
        $this->db->where("PO_NO", $po);
        $this->db->update($this->tableApproval, array('VENDOR_APP' => '0'));
        $this->recordApprovalVnd($po);
        return true;
    }

    function reject($PO)
    {
        $this->db->where("PO_NO", $PO, TRUE);
        $this->db->update($this->tableApproval, array('STATUS' => '0'));

        $SQL = "INSERT INTO EC_TRACKING_PO VALUES ( 
            '" . $PO . "', TO_DATE('" . date("Y-m-d H:i:s") . "', 'yyyy-mm-dd hh24:mi:ss'), 1,null,'" . $this->session->userdata['ID'] . "', '" .
            $this->session->userdata['FULLNAME'] . "')";
        $this->db->query($SQL);
    }

    function rejectVendor($po)
    {
        $this->db->where("PO_NO", $po);
        $this->db->update($this->tableApproval, array('VENDOR_APP' => '2'));
        $this->recordApprovalVnd($po);
        return true;
    }

    function getPOHistory($po)
    {
        $this->db->select($this->tableTrackingPO.'.*, '.$this->tableEmployee.'.EMAIL');
        $this->db->from($this->tableTrackingPO);
        $this->db->join($this->tableEmployee, $this->tableTrackingPO.'.USERID = '.$this->tableEmployee.'.ID');
        $this->db->where('PO_NO', $po);
        $this->db->order_by('INDATE', 'ASC');
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function recordApprovalVnd($PO)
    {
        $prev = $this->prevApprove($PO);
        $status = $prev['STATUS_PO'] + 1;
        if ($prev['NAMA_USER'] == $this->session->userdata['FULLNAME']){
            return true;
        } else {
            $SQL = "INSERT INTO EC_TRACKING_PO VALUES ( 
                '" . $PO . "', TO_DATE('" . date("Y-m-d H:i:s") . "', 'yyyy-mm-dd hh24:mi:ss'), '" . $status . "', 1,'" . $this->session->userdata['ID'] . "', '" .
                $this->session->userdata['FULLNAME'] . "')";
            $this->db->query($SQL);
            return true;
        }
    }

    function getVendorInfo($po)
    {
        $this->db->select('APR.*, VEN.VENDOR_NAME, VEN.EMAIL_ADDRESS');
        $this->db->from('EC_PL_APPROVAL APR');
        $this->db->join('VND_HEADER VEN', 'APR.VENDORNO = VEN.VENDOR_NO');
        $this->db->where('APR.PO_NO', $po);
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function prevApprove($po)
    {
        $this->db->from($this->tableTrackingPO);
        $this->db->where('PO_NO', $po);
        $this->db->order_by('STATUS_PO', 'DESC');
        $result = $this->db->get();
        return (array)$result->row_array();
    }

    function detail($kdshipment)
    {
        $this->db->select('TS.PO_NO,TS.MATNO,TS.VENDORNO,DS.KODE_DETAIL_SHIPMENT,DS.KODE_SHIPMENT,DS.STATUS,DS.QTY,DS.QTY_PO_COMMIT,DS.ALASAN_REJECT,DS.GR_NO,DS.IN_DATE,DS.IN_DATE_GR,DS.SEND_DATE',
            false);
        $this->db->from('EC_T_SHIPMENT TS');
       $this->db->join('EC_T_DETAIL_SHIPMENT DS', 'TS.KODE_SHIPMENT = DS.KODE_SHIPMENT', 'INNER');
        //$this->db->join('EC_T_DETAIL_PENAWARAN DP', 'DP.KODE_DETAIL_PENAWARAN = EC_T_CHART.KODE_PENAWARAN', 'inner');
        //$this->db->join('ADM_PLANT PL', 'PL.PLANT_CODE = DP.PLANT', 'left');
        $this->db->where("DS.KODE_SHIPMENT", $kdshipment, TRUE);
		$this->db->where("DS.STATUS <>", '5', TRUE);
		
        
        $result = $this->db->get();
        return (array)$result->result_array();
    }

    function getDetailPO($userid, $po)
    {
        $this->db->select('CT.PO_NO NOMERPO,TO_CHAR ((TO_DATE(CT.DATE_BUY, \'dd-mm-yyyy hh24:mi:ss\')+7), \'dd-mm-yyyy hh24:mi:ss\' ) COMMIT_DATE, CT.DATE_BUY,EC_PL_APPROVAL.CURR, VND_HEADER.VENDOR_NAME,  EC_PL_APPROVAL."VALUE",TDP.STOK_COMMIT, EC_PL_APPROVAL.VENDORNO,  EC_TRACKING_PO.*,TDP.DELIVERY_TIME',
            false);
        $this->db->from('(SELECT  PO_NO,  DATE_BUY FROM EC_T_CHART  WHERE CONTRACT_NO =  \'PL2018\' AND PO_NO IS NOT NULL GROUP BY  PO_NO, DATE_BUY ) CT');
        $this->db->join('(SELECT P1.* FROM EC_TRACKING_PO P1 INNER JOIN (SELECT PO_NO,MAX(INDATE) DATE1 FROM EC_TRACKING_PO GROUP BY PO_NO) P2 ON P1.PO_NO=P2.PO_NO AND P1.INDATE=P2.DATE1 )EC_TRACKING_PO',
            'EC_TRACKING_PO.PO_NO = CT.PO_NO', 'left');
        $this->db->join('EC_PL_APPROVAL', 'CT.PO_NO = EC_PL_APPROVAL.PO_NO', 'inner');
        $this->db->join('VND_HEADER', 'VND_HEADER.VENDOR_NO = EC_PL_APPROVAL.VENDORNO', 'left');
        $this->db->join('EC_PL_CONFIG_APPROVAL', 'EC_PL_APPROVAL.PROGRESS_APP = EC_PL_CONFIG_APPROVAL.PROGRESS_CNF AND EC_PL_APPROVAL.COSCENTER = EC_PL_CONFIG_APPROVAL.UK_CODE', 'inner');
        $this->db->join('(SELECT SUM(PRICE) PRICE,SUM(STOK_COMMIT) STOK_COMMIT,PO_NO,DELIVERY_TIME FROM EC_T_DETAIL_PENAWARAN 
                            INNER JOIN EC_T_CHART CT ON CT.KODE_PENAWARAN = EC_T_DETAIL_PENAWARAN.KODE_DETAIL_PENAWARAN 
                            GROUP BY PO_NO,DELIVERY_TIME) TDP ', 'CT.PO_NO = TDP.PO_NO', 'inner');
        $this->db->where('EC_PL_CONFIG_APPROVAL.USERID', $userid, TRUE);
        $this->db->where('CT.PO_NO', $po, TRUE);
        //        $this->db->where('EC_PL_CONFIG_APPROVAL.UK_CODE', $userid, TRUE);
        $this->db->where('EC_PL_APPROVAL.STATUS', '1', TRUE);
        $this->db->where('EC_PL_APPROVAL.PROGRESS_APP_GUDANG', '0', TRUE);
        // $this->db->where('EC_PL_APPROVAL.PROGRESS_APP<=', 'EC_PL_APPROVAL.MAX_APPROVE', false);
        $this->db->where('(TO_DATE(CT.DATE_BUY, \'dd-mm-yyyy hh24:mi:ss\')+7) >=', '(SELECT SYSDATE FROM DUAL)', false);
        $this->db->order_by('CT.PO_NO DESC');
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
	
	function insertToShipment_qty($data, $PO)
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
	
	
	public function insertDetailShipment($noShipment, $tglShipment, $qty, $kodeShipment, $idchart){
        $this->db->trans_start();

        $SQL = "INSERT INTO  EPROC . EC_T_DETAIL_SHIPMENT  (
                 KODE_SHIPMENT,
                 STATUS,
                 QTY,
                 QTY_PO_COMMIT,                 
                 IN_DATE,                 
                 SEND_DATE,
                 ID_CHART,
                 NO_SHIPMENT                 
            ) VALUES ( 
                        '".$kodeShipment."','1','".$qty."','0', TO_DATE('" . date("Y-m-d H:i:s") . "', 'yyyy-mm-dd hh24:mi:ss'),TO_DATE('".$tglShipment."','DD-MM-YYYY'), '".$idchart."', '".$noShipment."')";
        $this->db->query($SQL);

                
        // $this->db->where("KODE_SHIPMENT", $kodeShipment, TRUE);
        // $this->db->set('STATUS', '2', FALSE);
        // $this->db->set('SEND_DATE', "to_date('" . date("Y-m-d H:i:s") . "','yyyy-mm-dd hh24:mi:ss')", FALSE);
        // $this->db->update($this->tableShipment);
        
        
         
        
        $this->db->trans_complete();
        return $this->db->affected_rows();
    }

    public function deleteShipment($kodeShipment)
    {
        $this->db->where("KODE_DETAIL_SHIPMENT", $kodeShipment, TRUE);
        $this->db->delete($this->tableDetailShipment);
    }

    public function updateGRmaterial($idchart)
    {
        $this->db->where("ID_CHART", $idchart, TRUE);
        $this->db->set('STATUS', '3', FALSE);
        $this->db->update($this->tableHeaderGr);
    }
    
    public function get_vendor_detail($VENDORNO){
        $this->db->select('ADDRESS_STREET, ADDRESS_CITY, CONTACT_PHONE_NO, EMAIL_ADDRESS, VENDOR_NAME, VENDOR_NO', 
            false);
        $this->db->from('VND_HEADER');        
        $this->db->where("VENDOR_NO", $VENDORNO, TRUE);        
        $result = $this->db->get();
        return (array)$result->result_array();
    }  
    
    public function get_order($PO){
        $this->db->select('EC_T_CHART.PO_NO, DATE_BUY, FULLNAME, EM_COMPANY, NO_SHIPMENT, PLN.DESC, PLN.PLANT');
        $this->db->from('EC_T_CHART');  
        $this->db->join('EC_T_DETAIL_PENAWARAN DP', 'EC_T_CHART.KODE_PENAWARAN=DP.KODE_DETAIL_PENAWARAN', 'inner');
        $this->db->join('EC_M_PLANT PLN', 'DP.PLANT=PLN.PLANT', 'inner');
        $this->db->join('ADM_EMPLOYEE', 'ADM_EMPLOYEE.ID=EC_T_CHART.ID_USER');                
        $this->db->join('EC_T_SHIPMENT', 'EC_T_SHIPMENT.PO_NO=EC_T_CHART.PO_NO');
        $this->db->join('EC_T_DETAIL_SHIPMENT', 'EC_T_DETAIL_SHIPMENT.KODE_SHIPMENT=EC_T_SHIPMENT.KODE_SHIPMENT');
        $this->db->where("EC_T_SHIPMENT.PO_NO", $PO, TRUE);        
        $this->db->where('ROWNUM', 1, false);
        $this->db->group_by("EC_T_CHART.PO_NO, DATE_BUY, FULLNAME, EM_COMPANY, NO_SHIPMENT, PLN.DESC, PLN.PLANT");        
        $result = $this->db->get();
        return (array)$result->result_array();
    }
    
    public function get_shipment($PO, $shipment){
        $this->db->select('EC_T_CHART.PO_NO, DATE_BUY, EC_T_DETAIL_SHIPMENT.SEND_DATE, EC_T_DETAIL_SHIPMENT.GR_NO, FULLNAME, EM_COMPANY, NO_SHIPMENT, PLN.DESC, PLN.PLANT');
        $this->db->from('EC_T_CHART');  
        $this->db->join('EC_T_DETAIL_PENAWARAN DP', 'EC_T_CHART.KODE_PENAWARAN=DP.KODE_DETAIL_PENAWARAN', 'inner');
        $this->db->join('EC_M_PLANT PLN', 'DP.PLANT=PLN.PLANT', 'inner');
        $this->db->join('ADM_EMPLOYEE', 'ADM_EMPLOYEE.ID=EC_T_CHART.ID_USER');                
        $this->db->join('EC_T_SHIPMENT', 'EC_T_SHIPMENT.PO_NO=EC_T_CHART.PO_NO');
        $this->db->join('EC_T_DETAIL_SHIPMENT', 'EC_T_DETAIL_SHIPMENT.KODE_SHIPMENT=EC_T_SHIPMENT.KODE_SHIPMENT');
        $this->db->where("EC_T_SHIPMENT.PO_NO", $PO, TRUE);
        $this->db->where('NO_SHIPMENT', $shipment, TRUE);
        $this->db->where('ROWNUM', 1, false);
        $this->db->group_by("EC_T_CHART.PO_NO, DATE_BUY, EC_T_DETAIL_SHIPMENT.SEND_DATE, EC_T_DETAIL_SHIPMENT.GR_NO, FULLNAME, EM_COMPANY, NO_SHIPMENT, PLN.DESC, PLN.PLANT");        
        $result = $this->db->get();
        return (array)$result->result_array();
    }
    
    public function get_shipment_detail($PO,$shipment,$vendor){
        $this->db->select('TS.PO_NO, TB1.*, TC.MATNO, TC.QTY AS QTY_ORDER, MAT.MAKTX, MAT.MEINS, TC.LINE_ITEM, PEN.PLANT, PEN.DELIVERY_TIME, PEN.PRICE, PEN.CURRENCY, (TC.QTY*PEN.PRICE) AS VALUE_ITEM,
    PLN."DESC" AS PLANT_NAME, TO_CHAR (TS.IN_DATE, \'dd-mm-yyyy\') AS DATE_ORDER,
    TO_CHAR ((TO_DATE(TO_CHAR (TS.IN_DATE, \'dd-mm-yyyy hh24:mi:ss\'), \'dd-mm-yyyy hh24:mi:ss\')+TO_NUMBER(PEN.DELIVERY_TIME)), \'dd-mm-yyyy\') EXPIRED_DATE', 
            false);
        $this->db->from('EC_T_SHIPMENT TS');
        $this->db->join('(SELECT DS.* FROM EC_T_DETAIL_SHIPMENT DS WHERE DS.STATUS != 0) TB1', 'TB1.KODE_SHIPMENT=TS.KODE_SHIPMENT', 'inner');
        $this->db->join('EC_T_CHART TC', 'TC.ID_CHART= TB1.ID_CHART', 'inner');
        $this->db->join('EC_M_STRATEGIC_MATERIAL MAT', 'TC.MATNO=MAT.MATNR', 'inner');
        $this->db->join('EC_T_DETAIL_PENAWARAN PEN', 'TC.KODE_PENAWARAN=PEN.KODE_DETAIL_PENAWARAN', 'inner');
        $this->db->join('EC_M_PLANT PLN', 'PEN.PLANT=PLN.PLANT', 'inner');        
        $this->db->where('TB1.NO_SHIPMENT', $shipment, TRUE);
        $this->db->where("TC.PO_NO", $PO, TRUE);     
        $this->db->where("TS.VENDORNO", $vendor, TRUE);
        $this->db->order_by("TB1.IN_DATE DESC, TC.LINE_ITEM ASC");        
        $result = $this->db->get();
        return (array)$result->result_array();                   
    }    
    
     public function get_po_detail($PO,$vendor){
        $this->db->select('TS.PO_NO, ,TB1.NO_SHIPMENT, TB1.*, EGP.DOC_DATE, TC.MATNO, TC.QTY AS QTY_ORDER, MAT.MAKTX, MAT.MEINS, TC.LINE_ITEM, PEN.PLANT, PEN.DELIVERY_TIME, PEN.PRICE, PEN.CURRENCY, (TC.QTY*PEN.PRICE) AS VALUE_ITEM,
    PLN."DESC" AS PLANT_NAME, TO_CHAR (TS.IN_DATE, \'dd-mm-yyyy\') AS DATE_ORDER,
    TO_CHAR ((TO_DATE(TO_CHAR (TS.IN_DATE, \'dd-mm-yyyy hh24:mi:ss\'), \'dd-mm-yyyy hh24:mi:ss\')+TO_NUMBER(PEN.DELIVERY_TIME)), \'dd-mm-yyyy\') EXPIRED_DATE', 
            false);
        $this->db->from('EC_T_SHIPMENT TS');
        $this->db->join('(SELECT DS.* FROM EC_T_DETAIL_SHIPMENT DS) TB1', 'TB1.KODE_SHIPMENT=TS.KODE_SHIPMENT', 'inner');
        $this->db->join('EC_GR_DETAIL_PL EGP', 'TB1.GR_NO=EGP.GR_NO', 'inner');
        $this->db->join('EC_T_CHART TC', 'TC.ID_CHART= TB1.ID_CHART', 'inner');
        $this->db->join('EC_M_STRATEGIC_MATERIAL MAT', 'TC.MATNO=MAT.MATNR', 'inner');
        $this->db->join('EC_T_DETAIL_PENAWARAN PEN', 'TC.KODE_PENAWARAN=PEN.KODE_DETAIL_PENAWARAN', 'inner');
        $this->db->join('EC_M_PLANT PLN', 'PEN.PLANT=PLN.PLANT', 'inner');                
        $this->db->where("TC.PO_NO", $PO, TRUE);     
        $this->db->where("TS.VENDORNO", $vendor, TRUE);
        $this->db->order_by("TB1.IN_DATE DESC, TC.LINE_ITEM ASC");        
//        $this->db->get();
//        echo $this->db->last_query();die();
        $result = $this->db->get();
        return (array)$result->result_array();                   
    } 
}
