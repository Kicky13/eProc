<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EC_Cronjob extends MX_Controller {

    private $USER;

    public function __construct() {
        parent::__construct();

        $this->load->model('ec_master_inv', 'me');
        $this->load->helper('url');
        $this->load->library('Layout');
        $this->load->helper("security");
        // $this -> USER = explode("@", $this -> session -> userdata['USERNAME']);
    }

    public function index() {
        $this->load->library('Authorization');
        $data['title'] = "Log Background Job";
        //$data['cheat'] = $cheat;
        $this->layout->set_table_js();
        $this->layout->set_table_cs();
        $this->layout->set_validate_css();
        $this->layout->set_validate_js();
        $this->layout->add_js('pages/invoice/EC_common.js');
        $this->layout->add_js('pages/invoice/EC_List_Cronjob.js');

        $this->layout->add_js('pages/EC_bootstrap-switch.min.js');
        $this->layout->add_css('pages/EC_strategic_material.css');
        $this->layout->add_css('pages/EC_bootstrap-switch.min.css');
        $this->layout->add_css('pages/EC_miniTable.css');
        $this->layout->add_css('pages/EC_jasny-bootstrap.min.css');
        $this->layout->add_css('pages/invoice/common.css');

        $this->layout->add_css('plugins/bootstrap-datepicker/datepicker.css');
        $this->layout->add_js('pages/EC-bootstrap-datepicker.min.js');
        $this->layout->add_js('bootbox.js');
        $this->layout->add_js('pages/EC_jasny-bootstrap.min.js');

        $this->layout->render('list', $data);
    }

    public function getAllLogCronJob() {
        $res = $this->me->getLogCronjob();
        $json_data = array('data' => $res);
        //  echo $this->db->last_query();
        echo json_encode($json_data);
    }

    public function setLog($data, $url = 'EC_Cronjob') {
        $redirect = 0;
        if ($this->session->userdata('FULLNAME')) {
            $data['DONE_BY'] = $this->session->userdata('FULLNAME');
            $redirect = 1;
        } else {
            $data['DONE_BY'] = "SYSTEM";
        }
        if ($this->me->logCronjobBaru($data)) {
            if ($redirect) {
                redirect('./'.$url);
            } else {
                echo 1;
            }
        };
    }
    
    
    
    public function refrshGR_landed($tglGr = NULL){
        $this->refreshGR($tglGr, null);
        $this->setDataLanded($tglGr, 'EC_Approval/Gr');
    }

    public function refreshGR($tglGr = NULL, $url = 'EC_Cronjob') {
        $this->load->library('sap_invoice');
        //	$venno = $this -> session -> userdata['VENDOR_NO'];
        /* ambil 1 untuk barang dan 9 untuk jasa */
        $this->load->model('invoice/ec_gr_sap', 'gr_sap');
        $arrInsert = array();
        $arrJasa = array();
        $arrBarang = array();
        // $jenisPo = 9;
        $sekarang = date('Ymd');
        $kemarin = new DateTime();
        $kemarin->modify('-1 day');

        $tglGrCari = !empty($tglGr) ? $tglGr : $kemarin->format('Ymd');


        //get data range PO;
        $this->load->model('invoice/ec_range_po', 'rpo');
        $range_po = $this->rpo->getAcvtieRangePO();
        //var_dump($range_po);die();

        $arrJasa = $this->sap_invoice->getALLGR('EQ', $tglGrCari, $tglGrCari, $range_po);

        $quanType = array(
            'MENGE', 'BPMNG', 'WESBS', 'BPWES', 'BAMNG', 'MENGE_POP', 'BPMNG_POP', 'BPWEB', 'WESBB'
        );
        $kali100 = array('DMBTR', 'WRBTR');
        //echo '<pre>';
        //print_r($arrJasa);die();
        foreach ($arrJasa as $j) {
            foreach ($quanType as $qq) {
                $j[$qq] = $this->convertQuan($j[$qq]);
            }
            if ($j['WAERS'] == 'IDR') {
                foreach ($kali100 as $_k) {
                    $j[$_k] = $j[$_k] * 100;
                }
            }
            /* periksa di database dulu apakah sudah ada atau belum */
            $uniqueKey = array('GJAHR' => $j['GJAHR'], 'BELNR' => $j['BELNR'], 'BUZEI' => $j['BUZEI']);
            $ada = $this->gr_sap->get($uniqueKey);

            if (!empty($ada)) {
                //echo 'update '.$this->gr_sap->update($j,$uniqueKey).'<br >';
                $this->gr_sap->update($j, $uniqueKey);
                //echo $this->db->last_query().'<br >';
            } else {

                $this->gr_sap->insert($j);
            }
        }

        $cutOff = '20171121'; // Tanggal Cut Off Live Fitur Approval GR dan BA Analisa Mutu

        if ($tglGrCari >= $cutOff) {
            /* daftarkan GR yang belum masuk ke list gr_status untuk mengetahui apakah gr sudah approve atau belum */
            $this->getGRNonApprove($cutOff);

            $this->clearNotNeedApprovalGR();
            /* Kirim Notofikasi ke User Approval GR */
            //$this->notifikasiPendingGR();
        } else {
            /* Set PRUEFLOS (Inspection Lot) menjadi 0 karena per tanggal $tglGrCari belum masuk ke fitur Approval BA Analisa Mutu */
            $this->db->where('CPUDT', $tglGrCari)->update('EC_GR_SAP', array('PRUEFLOS' => 0));
        }

        /* Tamhankan data Log */
        $data = array('ACTION' => 'REFRESH GOOD RECEIPT (GR)', 'DATE_TRANSACTION' => $tglGrCari);
        if ($url != null) {
            $this->setLog($data, $url);
        }
    }

    public function setDataLanded($tglGrCari, $url = 'EC_Cronjob') {
        $this->load->model('invoice/ec_landed_cost', 'elc');
        $this->load->library('sap_invoice');

        /* LANDED COST */
        $datapo = $this->getPOCompany($tglGrCari);
        //var_dump($datapo);die();
        // GROUPING BY COMPANY
        $group_po = array();
        foreach ($datapo as $value) {
            $group_po[$value['WERKS']][] = $value;
        }
        //var_dump($group_po);die();

        /* GET DATA LANDED COST from SAP */
        $data_landed = array();
        foreach ($group_po as $company => $value) {
            $data_landed_sap = $this->sap_invoice->getDataLandedCost($company, $value);
            if (!empty($data_landed_sap)) {
                foreach ($data_landed_sap as $val) {
                    $data_landed[] = $val;
                }
            }
        }
        //var_dump($data_landed);die();

        /* Clear Data pada Tanggal Tertentu Di Table EC_GR_LANDED_COST */
        $this->elc->delete($tgl);

        /* INSERT Data Di Table EC_GR_LANDED_COST */
        foreach ($data_landed as $value) {
            $this->elc->insert($value);
        }
        $data = array('ACTION' => 'REFRESH LANDED COST', 'DATE_TRANSACTION' => $tglGrCari);
        if ($url != null) {
            $this->setLog($data, $url);
        }
    }

    public function setStatusDokumenEkspedisi() {
        // $this->setStatusDokumenEkspedisiVerifikasi();
        $this->setStatusDokumenEkspedisiBendahara();
        $this->setStatusDokumenBendaharaPaid();
        $data = array('ACTION' => 'SET STATUS DOKUMEN EKSPEDISI');
        $this->setLog($data);
    }

    /* status verifikasi belum kirim */

    public function setStatusDokumenBendaharaPaid() {
        $sql = 'SELECT EIH.ID_INVOICE
	      		,EIH.FI_NUMBER_SAP
	      		,EIH.COMPANY_CODE
	      		,EIH.FI_YEAR
	      		,ETI.STATUS_DOC
	      		,ETI.POSISI
	      FROM EC_INVOICE_HEADER EIH
	      JOIN (SELECT max("DATE") LAST_UPDATE,ID_INVOICE FROM EC_TRACKING_INVOICE GROUP BY ID_INVOICE) TT
	            ON TT.ID_INVOICE = EIH.ID_INVOICE
	      JOIN EC_TRACKING_INVOICE ETI ON ETI.ID_INVOICE = TT.ID_INVOICE AND ETI."DATE" = TT.LAST_UPDATE AND ETI.STATUS_DOC = \'TERIMA\' AND ETI.POSISI = \'BENDAHARA\'
	      WHERE STATUS_HEADER = \'5\' AND FI_NUMBER_SAP IS NOT NULL
	      ';
        $listUpdateDok = $this->db->query($sql)->result_array();
        if (!empty($listUpdateDok)) {
            foreach ($listUpdateDok as $ld) {
                $data = array(
                    'P_BUKRS' => $ld['COMPANY_CODE'],
                    'P_GJAHR' => $ld['FI_YEAR'],
                    'FI_NUMBER' => $ld['FI_NUMBER_SAP'],
                );

                $idinvoice = $ld['ID_INVOICE'];
                $this->updateStatusPaid($idinvoice, $data);
            }
        }
        $data = array('ACTION' => 'SET STATUS DOKUMEN EKSPEDISI PAID');
        $this->setLog($data);
    }

    /* status verifikasi sudah kirim */

    public function setStatusDokumenEkspedisiBendahara() {
        $sql = 'SELECT EIH.ID_INVOICE
      		,EIH.FI_NUMBER_SAP
      		,EIH.COMPANY_CODE
      		,EIH.FI_YEAR
      		,ETI.STATUS_DOC
      		,ETI.POSISI
      FROM EC_INVOICE_HEADER EIH
      JOIN (SELECT max("DATE") LAST_UPDATE,ID_INVOICE FROM EC_TRACKING_INVOICE GROUP BY ID_INVOICE) TT
            ON TT.ID_INVOICE = EIH.ID_INVOICE
      JOIN EC_TRACKING_INVOICE ETI ON ETI.ID_INVOICE = TT.ID_INVOICE AND ETI."DATE" = TT.LAST_UPDATE AND ETI.STATUS_DOC = \'KIRIM\' AND ETI.POSISI = \'VERIFIKASI\'
      WHERE STATUS_HEADER = \'5\' AND FI_NUMBER_SAP IS NOT NULL
      ';
        $listUpdateDok = $this->db->query($sql)->result_array();
        if (!empty($listUpdateDok)) {
            foreach ($listUpdateDok as $ld) {
                $data = array(
                    'P_BUKRS' => $ld['COMPANY_CODE'],
                    'P_GJAHR' => $ld['FI_YEAR'],
                    'FI_NUMBER' => $ld['FI_NUMBER_SAP'],
                );
                $idinvoice = $ld['ID_INVOICE'];
                $this->updateSingleDokumenBendahara($idinvoice, $data);
            }
        }
        $data = array('ACTION' => 'SET STATUS DOKUMEN EKSPEDISI');
        $this->setLog($data);
    }

    public function updateStatusPaid($idinvoice, $data) {
        $this->load->library('sap_invoice');
        $result = $this->sap_invoice->getDokumenStatusEkspedisi($data);
        $hasil = $result[0];
        $status = trim($hasil['STATUS']);
        if ($status == 'PAID') {
            $this->load->model('invoice/ec_tracking_invoice', 'eti');
            $this->load->model('invoice/ec_invoice_header', 'eih');
            //  echo $idinvoice.' insert kirim verifikasi '.$this->eti->insert($data_tracking).' FI_NUMBER '.$data['FI_NUMBER'];
            $data_tracking = array(
                'ID_INVOICE' => $idinvoice,
                'DESC' => 'EDIT',
                'STATUS_DOC' => 'TERIMA',
                'STATUS_TRACK' => 6,
                'POSISI' => 'BENDAHARA',
                'USER' => 'SYSTEM',
                'DATE' => 'sysdate + 10/86400'
            );
            $this->eti->insert($data_tracking);
            $this->eih->update(array('STATUS_HEADER' => 6), array('ID_INVOICE' => $idinvoice));
        }
    }

    public function updateSingleDokumenBendahara($idinvoice, $data) {
        $this->load->library('sap_invoice');
        $result = $this->sap_invoice->getDokumenStatusEkspedisi($data);
        $hasil = $result[0];
        $tglkirimver = intval($hasil['TGL_KIRVER']);
        if (!empty($tglkirimver)) {
            $this->load->model('invoice/ec_tracking_invoice', 'eti');
            $tglben = intval($hasil['TGL_BEND']);
            if (!empty($tglben)) {
                $data_tracking = array(
                    'ID_INVOICE' => $idinvoice,
                    'DESC' => 'EDIT',
                    'STATUS_DOC' => 'TERIMA',
                    'STATUS_TRACK' => 5,
                    'POSISI' => 'BENDAHARA',
                    'USER' => 'SYSTEM',
                    'DATE' => 'sysdate + 10/86400'
                );
                $this->eti->insert($data_tracking);
                //  echo $idinvoice.' insert terima bendahara '.$this->eti->insert($data_tracking).' FI_NUMBER '.$data['FI_NUMBER'];;
            }
        }
    }

    private function convertQuan($val) {
        $minus = substr($val, -1);
        if ($minus == '-') {
            $tmp = substr($val, 0, strlen($minus) - 2);
            $val = (float) $tmp * -1;
        } else {
            $val = (float) $val;
        }
        return $val;
    }

    public function getIdUserSAP($email) {
        $this->load->model('ec_master_inv');
        $mapping = $this->ec_master_inv->getMappingUser($email);
        $result = $email;
        if (!empty($mapping)) {
            $result = $mapping['ID_SAP'];
        }
        return $result;
    }

    public function getRoleVerifikasi() {
        $this->load->model('invoice/ec_role', 'er');
        //	$roles = $this->er->get_all('where ROLE_AS like \'VERIFIKASI%\'');
        $roles = $this->db->get('ec_role')->result();
        $tmp = array();
        foreach ($roles as $r) {
            array_push($tmp, $r->ROLE_AS);
        }

        return $tmp;
    }

    private function logCronJob($nama) {
        return true;
    }

    /* hanya untuk bahan dan spare part saja */

    public function getGRNonApprove($cutOff) {
        $sql = <<<SQL
		insert into EC_GR_STATUS (PO_NO,PO_ITEM_NO,COMPANY_CODE,GR_NO,GR_ITEM_NO,GR_YEAR,JENISPO,GR_ITEM_QTY,GR_AMOUNT_IN_DOC,PLANT)
		SELECT PO_NO,to_char(PO_ITEM_NO),substr(WERKS,0,1) || '000' COMPANY_CODE,GR_NO,GR_ITEM_NO,GR_YEAR,JENISPO,GR_ITEM_QTY,GR_AMOUNT_IN_DOC,WERKS FROM(
			SELECT
			XX.PO_NO,
			XX.GR_YEAR,
			XX.GR_NO,
			TO_CHAR( XX.GR_ITEM_NO ) GR_ITEM_NO,
			XX.MATERIAL_NO,
			XX.PO_ITEM_NO,
			XX.GR_ITEM_QTY,
			XX.GR_DATE,
			XX.GR_AMOUNT_IN_DOC,
			XX.GR_CURR,
			XX.GR_ITEM_UNIT,
			XX.GR_AMOUNT_LOCAL,
			XX.MOVE_TYPE,
			XX.DEBET_KREDIT,
			XX.TYPE_TRANSAKSI,
			XX.CREATE_ON,
			XX.DESCRIPTION,
			XX.YEAR_REF,
			XX.DOC_GR_REF,
			XX.GR_ITEM_REF,
			XX.WERKS,
			'BAHAN' JENISPO
			FROM (
			SELECT GR.PO_NO
			        ,GR.GR_YEAR
			        ,GR.GR_NO
			,GR.GR_ITEM_NO
			        ,GR.MATERIAL_NO
			,GR.PO_ITEM_NO
			,GR.GR_ITEM_QTY - NVL(GR_BATAL.GR_ITEM_QTY,0) GR_ITEM_QTY
			,GR.GR_DATE
			,GR.GR_AMOUNT_IN_DOC - NVL(GR_BATAL.GR_AMOUNT_IN_DOC,0) GR_AMOUNT_IN_DOC
			,GR.GR_CURR
			,GR.GR_ITEM_UNIT
			,GR.GR_AMOUNT_LOCAL - NVL(GR_BATAL.GR_AMOUNT_LOCAL,0) GR_AMOUNT_LOCAL
			,GR.MOVE_TYPE
			,GR.DEBET_KREDIT
			        ,GR.TYPE_TRANSAKSI
			        ,GR.CREATE_ON
			        ,GR.DESCRIPTION
			        ,GR.YEAR_REF
			        ,GR.DOC_GR_REF
			        ,GR.GR_ITEM_REF
			        ,GR.WERKS
			from
			(
			SELECT EBELN PO_NO
			        ,GJAHR GR_YEAR
			        ,BELNR GR_NO
			,BUZEI GR_ITEM_NO
			        ,MATNR MATERIAL_NO
			,EBELP PO_ITEM_NO
			,MENGE GR_ITEM_QTY
			,CPUDT GR_DATE
			,WRBTR GR_AMOUNT_IN_DOC
			,WAERS GR_CURR
			,MEINS GR_ITEM_UNIT
			,DMBTR GR_AMOUNT_LOCAL
			,BWART MOVE_TYPE
			,SHKZG DEBET_KREDIT
			,PSTYP TYPE_TRANSAKSI
			        ,CPUDT CREATE_ON
			        ,TXZ01 DESCRIPTION
			        ,LFGJA YEAR_REF
			        ,LFBNR DOC_GR_REF
			        ,LFPOS GR_ITEM_REF
			        ,WERKS
			       FROM EC_GR_SAP
			       WHERE STATUS = 0

			          AND SHKZG = 'S'
			          AND VGABE IN ('1')
			          AND PSTYP = '0'
			          AND BWART NOT IN ('105','106')
			          AND EKGRP in (select PRCHGRP from EC_INVOICE_PRCHGRP)
			          AND CPUDT >= '{$cutOff}'
			)GR
			LEFT JOIN (
			SELECT EBELN PO_NO
			        ,GJAHR GR_YEAR
			        ,BELNR GR_NO
			,BUZEI GR_ITEM_NO
			        ,MATNR MATERIAL_NO
			,EBELP PO_ITEM_NO
			,MENGE GR_ITEM_QTY
			,CPUDT GR_DATE
			,WRBTR GR_AMOUNT_IN_DOC
			,WAERS GR_CURR
			,MEINS GR_ITEM_UNIT
			,DMBTR GR_AMOUNT_LOCAL
			,BWART MOVE_TYPE
			,SHKZG DEBET_KREDIT
			,PSTYP TYPE_TRANSAKSI
			        ,CPUDT CREATE_ON
			        ,TXZ01 DESCRIPTION
			        ,LFGJA YEAR_REF
			        ,LFBNR DOC_GR_REF
			        ,LFPOS GR_ITEM_REF
			       FROM EC_GR_SAP
			       WHERE STATUS = 0
			          AND SHKZG = 'H'
			          AND VGABE IN ('1')
			          AND PSTYP = '0'
			          AND BWART NOT IN ('105','106')
			)GR_BATAL ON GR_BATAL.YEAR_REF = GR.GR_YEAR AND GR_BATAL.DOC_GR_REF = GR.GR_NO  AND GR_BATAL.GR_ITEM_REF = GR.GR_ITEM_NO
			)XX WHERE XX.GR_ITEM_QTY > 0
			-- awal mencari unbilled spare part
			union all
			SELECT
			AA.EBELN PO_NO,
			AA.GJAHR GR_YEAR,
			AA.BELNR GR_NO,
			AA.BUZEI GR_ITEM_NO,
			AA.MATNR MATERIAL_NO,
			AA.EBELP PO_ITEM_NO,
			BB.N_MENGE GR_ITEM_QTY,
			AA.CPUDT GR_DATE,
			BB.N_WRBTR GR_AMOUNT_IN_DOC,
			AA.WAERS GR_CURR,
			AA.MEINS GR_ITEM_UNIT,
			BB.N_DMBTR GR_AMOUNT_LOCAL,
			AA.BWART MOVE_TYPE,
			AA.SHKZG DEBET_KREDIT,
			AA.PSTYP TYPE_TRANSAKSI,
			AA.CPUDT CREATE_ON,
			AA.TXZ01 DESCRIPTION,
			AA.LFGJA YEAR_REF,
			AA.LFBNR DOC_GR_REF,
			AA.LFPOS GR_ITEM_REF,
			AA.WERKS,
			'SPARE_PART' JENISPO
			FROM
			EC_GR_SAP AA
			JOIN(
			SELECT
			C.*,
			NVL( D.MENGE, 0 )- NVL( E.MENGE, 0 ) AS N_MENGE,
			NVL( D.WRBTR, 0 )- NVL( E.WRBTR, 0 ) AS N_WRBTR,
			NVL( D.DMBTR, 0 )- NVL( E.DMBTR, 0 ) AS N_DMBTR
			FROM
			(
			SELECT
			  A.GJAHR,
			  A.BELNR,
			  A.BUZEI,
			  NVL( A.WESBS, 0 )- NVL( B.WESBS, 0 ) N_WESBS
			FROM
			  (
			    SELECT
			      GJAHR,
			      BELNR,
			      BUZEI,
			      WESBS
			    FROM
			      EC_GR_SAP
			    WHERE
			      SHKZG = 'S'
			      AND STATUS = 0
			      AND CPUDT >= '{$cutOff}'
			      AND PSTYP != '9'
			      AND EKGRP in (select PRCHGRP from EC_INVOICE_PRCHGRP)
			  ) A
			LEFT JOIN(
			    SELECT
			      LFGJA,
			      LFBNR,
			      LFPOS,
			      WESBS
			    FROM
			      EC_GR_SAP
			    WHERE
			      SHKZG = 'H'
			      AND STATUS = 0
			      AND PSTYP != '9'
			  ) B ON
			  A.GJAHR = B.LFGJA
			  AND A.BELNR = B.LFBNR
			  AND A.BUZEI = B.LFPOS
			WHERE
			  NVL( A.WESBS, 0 )- NVL( B.WESBS, 0 )> 0
			) C
			INNER JOIN(
			SELECT
			  SUM( MENGE ) MENGE,
			  SUM( WRBTR ) WRBTR,
			  SUM( DMBTR ) DMBTR,
			  LFGJA,
			  LFBNR,
			  LFPOS
			FROM
			  EC_GR_SAP
			WHERE
			  SHKZG = 'S'
			  AND STATUS = 0
			  AND PSTYP != '9'
			GROUP BY
			  LFGJA,
			  LFBNR,
			  LFPOS
			) D ON
			D.LFGJA = C.GJAHR
			AND D.LFBNR = C.BELNR
			AND D.LFPOS = C.BUZEI
			LEFT JOIN(
			SELECT
			  SUM( MENGE ) MENGE,
			  SUM( WRBTR ) WRBTR,
			  SUM( DMBTR ) DMBTR,
			  LFGJA,
			  LFBNR,
			  LFPOS
			FROM
			  EC_GR_SAP
			WHERE
			  SHKZG = 'H'
			  AND STATUS = 0
			  AND PSTYP != '9'
			GROUP BY
			  LFGJA,
			  LFBNR,
			  LFPOS
			) E ON
			E.LFGJA = C.GJAHR
			AND E.LFBNR = C.BELNR
			AND E.LFPOS = C.BUZEI
			) BB ON	AA.BELNR = BB.BELNR
				AND AA.GJAHR = BB.GJAHR
				AND AA.BUZEI = BB.BUZEI
				AND BB.N_MENGE > 0
			WHERE	AA.STATUS = 0	AND PSTYP != '9'
		)TMP WHERE TMP.WERKS IN (SELECT PLANT FROM EC_INVOICE_PLANT WHERE STATUS = 1)
		minus
		select PO_NO,PO_ITEM_NO,COMPANY_CODE,GR_NO,GR_ITEM_NO,GR_YEAR,JENISPO,GR_ITEM_QTY,GR_AMOUNT_IN_DOC,PLANT from EC_GR_STATUS
SQL;
        //echo $sql;die();
        $this->db->query($sql);
    }

    /* notifikasi kepada kasie mengenai rekap gr yang perlu diapprove */

    public function notifikasiPendingGR() {
        $users = $this->userPenerimaEmailGR();

        if (!empty($users)) {
            foreach ($users as $_email => $us) {
                $listPendingGR = $this->listPendingGR($us['PLANT']);
                if (!empty($listPendingGR)) {
                    $tableGR = $this->buildTable($listPendingGR);
                    $data = array(
                        'content' => '
								List Pending GR <br>' . $tableGR,
                        'title' => 'List Pending GR',
                        'title_header' => 'List Pending GR',
                        'url' => 'https://int-' . str_replace('http://', '', str_replace('https://', '', base_url()))
                    );
                    $message = $this->load->view('EC_Notifikasi/approveInvoice', $data, TRUE);
                    $_to = $_email;
                    //    $_to = 'ahmad.afandi85@gmail.com';
                    $subject = 'List Pending GR [E-Invoice Semen Indonesia]';
                    Modules::run('EC_Notifikasi/Email/invoiceNotifikasi', $_to, $message, $subject);
                }
            }
        }
    }

    private function buildTable($listGR) {
        $tableGR = array(
            '<table border=1 width="650" style="font-size:10px">'
        );
        $thead = '<thead>
								<tr>
										<th class="text-center">NO</th>
										<th class="text-center">PO NO</th>
										<th class="text-center">PO ITEM NO</th>
										<th class="text-center">NO RR</th>
										<th class="text-center">GR YEAR</th>
										<th class="text-center">MATERIAL</th>
										<th class="text-center">VENDOR</th>
								</tr>
						</thead>
				';
        $tbody = array();
        $no = 1;
        foreach ($listGR as $gr) {
            $_tr = '<tr>
					<td>' . $no++ . '</td>
					<td>' . $gr['PO_NO'] . '</td>
					<td>' . $gr['PO_ITEM_NO'] . '</td>
					<td>' . $gr['NO_RR'] . '</td>
					<td>' . $gr['GR_YEAR'] . '</td>
					<td>' . $gr['TXZ01'] . '</td>
					<td>' . $gr['NAME1'] . '</td>
			</tr>';
            array_push($tbody, $_tr);
        }
        array_push($tableGR, $thead);
        array_push($tableGR, implode(' ', $tbody));
        array_push($tableGR, '</table>');
        return implode(' ', $tableGR);
    }

    private function listPendingGR($listPlant) {
        $_lp = implode('\',\'', $listPlant);
        $sql = <<<SQL
		select EGS.PO_NO
			,EGS.PO_ITEM_NO
			,EGS.GR_NO
			,EGS.GR_ITEM_NO
			,EGS.GR_YEAR
			,EGS.JENISPO
			,EG.TXZ01
			,EG.NAME1
			,EG.LFBNR NO_RR
			,EGS.JENISPO
			from EC_GR_STATUS EGS
			join EC_GR_SAP EG
			on EG.EBELN = EGS.PO_NO
			   AND EG.EBELP = EGS.PO_ITEM_NO
			   AND EG.BELNR = EGS.GR_NO
			   AND EG.BUZEI = EGS.GR_ITEM_NO
			   AND EG.GJAHR = EGS.GR_YEAR
			where EGS.JENISPO = 'BAHAN' and EGS.PLANT in ('{$_lp}') and EGS.STATUS = 0
			union
			select EGS.PO_NO
				,EGS.PO_ITEM_NO
				,EGS.GR_NO
				,EGS.GR_ITEM_NO
				,EGS.GR_YEAR
				,EGS.JENISPO
				,EG.TXZ01
				,EG.NAME1
				,(select max(BELNR) BELNR from EC_GR_SAP where LFBNR = EGS.GR_NO and LFPOS = EGS.GR_ITEM_NO and LFGJA = EGS.GR_YEAR AND BWART = 105) NO_RR
				,EGS.JENISPO
			from EC_GR_STATUS EGS
			join EC_GR_SAP EG
			on EG.EBELN = EGS.PO_NO
			   AND EG.EBELP = EGS.PO_ITEM_NO
			   AND EG.BELNR = EGS.GR_NO
			   AND EG.BUZEI = EGS.GR_ITEM_NO
			   AND EG.GJAHR = EGS.GR_YEAR
			where EGS.JENISPO = 'SPARE_PART' and EGS.PLANT in ('{$_lp}')  and EGS.STATUS = 0
SQL;

        return $this->db->query($sql)->result_array();
    }

    /* daftar user yang menerima email notifikasi GR Pending */

    private function userPenerimaEmailGR() {
        $users = array();
        $sql = <<<SQL
		SELECT ERU.USERNAME,ERA.OBJECT_AS,ERA.VALUE,1 NO_URUT
		FROM EC_ROLE_ACCESS ERA
		JOIN EC_ROLE_USER ERU
		ON ERA.ROLE_AS = ERU.ROLE_AS AND ERU.STATUS = 1
		WHERE ERA.ROLE_AS = 'APPROVAL GR LVL 1'
		UNION ALL
		SELECT ERU.USERNAME,ERA.OBJECT_AS,ERA.VALUE,2 NO_URUT
		FROM EC_ROLE_ACCESS ERA
		JOIN EC_ROLE_USER ERU
		ON ERA.ROLE_AS = ERU.ROLE_AS AND ERU.STATUS = 1
		WHERE ERA.ROLE_AS LIKE 'GUDANG%' AND ERA.OBJECT_AS = 'PLANT'
		ORDER BY NO_URUT
SQL;
        $r = $this->db->query($sql)->result_array();
        if (!empty($r)) {
            /* groupinng berdasarkan username */
            foreach ($r as $_r) {
                $email = $_r['USERNAME'] . '@SEMENINDONESIA.COM';
                if ($_r['OBJECT_AS'] == 'LEVEL') {
                    if (!isset($users[$email])) {
                        $users[$email] = array(
                            'LEVEL' => $_r['VALUE'],
                            'PLANT' => array()
                        );
                    }
                }

                if ($_r['OBJECT_AS'] == 'PLANT') {
                    if (isset($users[$email])) {
                        $_tmpArr = explode(',', $_r['VALUE']);
                        foreach ($_tmpArr as $_v) {
                            array_push($users[$email]['PLANT'], $_v);
                        }
                    }
                }
            }
        }
        return $users;
    }

    public function getPOCompany($date) {
        $sql = "
		SELECT EBELN,CPUDT,
			CASE 
				WHEN WERKS IS NULL THEN '-'
			ELSE substr(WERKS,1,1)||'000' END WERKS
		FROM EC_GR_SAP 
		where CPUDT = '$date'
		AND PSTYP != 9 
		AND WERKS IS NOT NULL 
		GROUP BY EBELN,CPUDT,WERKS 
		ORDER BY WERKS
		";
        return $this->db->query($sql)->result_array();
    }

    public function clearNotNeedApprovalGR(){
        $sql = "
            DELETE FROM EC_GR_STATUS WHERE GR_NO IN(
            SELECT EGS.GR_NO FROM EC_GR_SAP EGA
            JOIN EC_GR_STATUS EGS ON EGA.LFBNR = EGS.GR_NO
            WHERE BUDAT < '20171121' 
                AND CPUDT > '20171120'
                AND LOT_NUMBER IS NULL
            )
        ";
        $this->db->query($sql);
    }

}
