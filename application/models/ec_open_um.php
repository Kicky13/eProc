<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ec_open_um extends CI_Model {

    protected $table = 'EC_GR', $tableHeader = 'EC_UM_HEADER', $tableDenda = "EC_T_DENDA_INV", $tableDoc = "EC_T_DOC_INV", $tableCOMPANY = 'EC_C_COMPANY', $tablePURC_ORG = 'EC_C_PURC_ORG', $tableDOC = "EC_C_DOCTYPE", $tableTracking = "EC_TRACKING_UM";

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    /*
     * status:
     * 0:default
     * 1:Draft
     * 2:Submited
     * 3:Approved
     * 4:Rejected
     * 5:Posted
     * 6:Paid
     */

    public function mainQuery($VND_NO) {
/* ini query sebelum ada fitur approval gr
        $sql = <<<SQL
  SELECT * FROM (
            SELECT
            XX.PO_NO,
            XX.GR_YEAR,
            XX.RR_NO,
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
            XX.WERKS
            FROM (
            SELECT EGS.EBELN PO_NO,
        				        EGS.GJAHR GR_YEAR,
        				        EGS.BELNR RR_NO,
        				        EGS.BELNR GR_NO,
        						EGS.BUZEI GR_ITEM_NO,
        				        EGS.MATNR MATERIAL_NO,
                               EGS.EBELP PO_ITEM_NO,
                               GR.GR_ITEM_QTY - NVL(GR_BATAL.GR_ITEM_QTY, 0) GR_ITEM_QTY,
                               EGS.BLDAT GR_DATE,
                               GR.GR_AMOUNT_IN_DOC - NVL(GR_BATAL.GR_AMOUNT_IN_DOC, 0) GR_AMOUNT_IN_DOC,
                               EGS.WAERS GR_CURR,
        						EGS.MEINS GR_ITEM_UNIT,
                               GR.GR_AMOUNT_LOCAL - NVL(GR_BATAL.GR_AMOUNT_LOCAL, 0) GR_AMOUNT_LOCAL,
                               EGS.BWART MOVE_TYPE,
        						EGS.SHKZG DEBET_KREDIT,
        						EGS.PSTYP TYPE_TRANSAKSI,
        				        EGS.BUDAT CREATE_ON,
                				EGS.TXZ01 DESCRIPTION,
                				EGS.LFGJA YEAR_REF,

                               EGS.LFBNR DOC_GR_REF,
                               EGS.LFPOS GR_ITEM_REF,
                               EGS.WERKS

                        FROM   (SELECT
                                       GJAHR GR_YEAR,
                                       BELNR GR_NO,
                                       BUZEI GR_ITEM_NO,
                                       SUM(MENGE) GR_ITEM_QTY,
                                       SUM(WRBTR) GR_AMOUNT_IN_DOC,
                                       SUM(DMBTR) GR_AMOUNT_LOCAL
                                FROM   EC_GR_SAP
                                WHERE  STATUS = 0
                                       AND LIFNR = '{$VND_NO}'
                                       AND SHKZG = 'S'
                                       AND VGABE IN ( '1' )
                                       AND PSTYP IN ('0','3')
                                       AND BWART NOT IN ( '105', '106' )
                                       AND EKGRP IN (SELECT PRCHGRP FROM EC_INVOICE_PRCHGRP)
                               	GROUP BY GJAHR,BELNR,BUZEI
                               )GR
                               JOIN EC_GR_SAP EGS ON EGS.BELNR = GR.GR_NO AND EGS.GJAHR = GR.GR_YEAR AND EGS.BUZEI = GR.GR_ITEM_NO
                               LEFT JOIN (SELECT SUM(MENGE) GR_ITEM_QTY,
                                                 SUM(WRBTR) GR_AMOUNT_IN_DOC,
                                                 SUM(DMBTR) GR_AMOUNT_LOCAL,
                                                 LFGJA YEAR_REF,
                                                 LFBNR DOC_GR_REF,
                                                 LFPOS GR_ITEM_REF
                                          FROM   EC_GR_SAP
                                          WHERE  STATUS = 0
                                                 AND LIFNR = '{$VND_NO}'
                                                 AND SHKZG = 'H'
                                                 AND VGABE IN ( '1' )
                                                 AND PSTYP IN ('0','3')
                                                 AND BWART NOT IN ( '105', '106' )
                                          GROUP BY LFGJA,
                                                 LFBNR,
                                                 LFPOS
                                     )GR_BATAL
                                      ON GR_BATAL.YEAR_REF = GR.GR_YEAR
                                         AND GR_BATAL.DOC_GR_REF = GR.GR_NO
                                         AND GR_BATAL.GR_ITEM_REF = GR.GR_ITEM_NO
        )XX WHERE XX.GR_ITEM_QTY > 0
        -- AWAL UNTUK MENCARI UNBILLED JASA
            UNION ALL
            SELECT
            YY.PO_NO,
            YY.GR_YEAR,
            YY.GR_NO RR_NO,
            YY.GR_NO,
            TO_CHAR( YY.GR_ITEM_NO ) GR_ITEM_NO,
            YY.MATERIAL_NO,
            YY.PO_ITEM_NO,
            YY.GR_ITEM_QTY,
            YY.GR_DATE,
            YY.GR_AMOUNT_IN_DOC,
            YY.GR_CURR,
            YY.GR_ITEM_UNIT,
            YY.GR_AMOUNT_LOCAL,
            YY.MOVE_TYPE,
            YY.DEBET_KREDIT,
            YY.TYPE_TRANSAKSI,
            YY.CREATE_ON,
            YY.DESCRIPTION,
            YY.YEAR_REF,
            YY.DOC_GR_REF,
            YY.GR_ITEM_REF,
            YY.WERKS
            FROM (
            SELECT  EGS.EBELN                         PO_NO,
                  EGS.LFGJA                         GR_YEAR,
                  EGS.LFBNR                         GR_NO,
                  GR.GR_ITEM_NO,
                  EGS.MATNR                         MATERIAL_NO,
                  EGS.EBELP                         PO_ITEM_NO,
                  GR.GR_ITEM_QTY - NVL(GR_BATAL.GR_ITEM_QTY, 0) GR_ITEM_QTY,
                  EGS.BLDAT                         GR_DATE,
                  GR.GR_AMOUNT_IN_DOC - NVL(GR_BATAL.GR_AMOUNT_IN_DOC, 0) GR_AMOUNT_IN_DOC,
                  EGS.WAERS                         GR_CURR,
                  GR.UOMJASA                       GR_ITEM_UNIT,
                  GR.GR_AMOUNT_LOCAL - NVL(GR_BATAL.GR_AMOUNT_LOCAL, 0) GR_AMOUNT_LOCAL,
                  EGS.BWART                         MOVE_TYPE,
                  EGS.SHKZG                         DEBET_KREDIT,
                  GR.TYPE_TRANSAKSI,
                  EGS.BUDAT                         CREATE_ON,
                  GR.DESCRIPTION,
                  EGS.LFGJA                         YEAR_REF,
                  EGS.LFBNR                         DOC_GR_REF,
                  GR.GR_ITEM_NO                      GR_ITEM_REF,
                  GR.WERKS

            FROM (
          SELECT  A.LFGJA GR_YEAR,
              A.LFBNR GR_NO,
              A.LFPOS GR_ITEM_NO,
              SUM(A.MENGE) GR_ITEM_QTY,
              SUM(A.WRBTR) GR_AMOUNT_IN_DOC,
              SUM(A.DMBTR) GR_AMOUNT_LOCAL,
              B.PSTYP TYPE_TRANSAKSI,
              COALESCE(B.TXZ01_ESSR, B.TXZ01) DESCRIPTION,
              A.WERKS,
              A.UOMJASA
          FROM EC_GR_SAP A
          JOIN (
            SELECT  * FROM EC_GR_SAP
            WHERE VGABE = '9'
              AND LIFNR = '{$VND_NO}'
              AND PSTYP = '9'
              AND STATUS = 0
            ) B
              ON A.LFBNR = B.BELNR
              AND A.LFGJA = B.LFGJA
          WHERE A.STATUS = 0
            AND A.LIFNR = '{$VND_NO}'
            AND A.SHKZG = 'S'
            AND A.VGABE IN ('1')
            AND A.PSTYP = '9'
            AND A.EKGRP IN (SELECT  PRCHGRP FROM EC_INVOICE_PRCHGRP)
        GROUP BY A.LFGJA,
               A.LFBNR,
               A.LFPOS,
               B.PSTYP,
               B.TXZ01_ESSR,
               B.TXZ01,
               A.WERKS,
               A.UOMJASA
          ) GR
          JOIN EC_GR_SAP EGS
            ON EGS.BELNR = GR.GR_NO  AND EGS.LFGJA = GR.GR_YEAR -- AND EGS.LFPOS = GR.GR_ITEM_NO
        LEFT JOIN (
          SELECT  A.LFGJA YEAR_REF,
              A.LFBNR DOC_GR_REF,
              A.LFPOS GR_ITEM_REF,
              SUM(A.MENGE) GR_ITEM_QTY,
              SUM(A.WRBTR) GR_AMOUNT_IN_DOC,
              SUM(A.DMBTR) GR_AMOUNT_LOCAL
          FROM EC_GR_SAP A
          JOIN (
            SELECT * FROM EC_GR_SAP
            WHERE VGABE = '9'
              AND LIFNR = '{$VND_NO}'
              AND PSTYP = '9'
              AND STATUS = 0
        ) B  ON A.LFBNR = B.BELNR
              AND A.LFGJA = B.LFGJA
        WHERE A.STATUS = 0
          AND A.LIFNR = '{$VND_NO}'
          AND A.SHKZG = 'H'
          AND A.VGABE IN ('1')
          AND A.PSTYP = '9'
          GROUP BY A.LFGJA,
                   A.LFBNR,
                   A.LFPOS
        ) GR_BATAL ON GR_BATAL.YEAR_REF = GR.GR_YEAR
            AND GR_BATAL.DOC_GR_REF = GR.GR_NO
            AND GR_BATAL.GR_ITEM_REF = GR.GR_ITEM_NO
        )YY WHERE YY.GR_ITEM_QTY > 0
        -- AWAL MENCARI UNBILLED SPARE PART
        UNION ALL
        SELECT
        AA.EBELN PO_NO,
        AA.GJAHR GR_YEAR,
        RR.BELNR RR_NO,
        AA.BELNR GR_NO,
        AA.BUZEI GR_ITEM_NO,
        AA.MATNR MATERIAL_NO,
        AA.EBELP PO_ITEM_NO,
        BB.N_MENGE GR_ITEM_QTY,
        --	AA.CPUDT GR_DATE,
        RR.BLDAT GR_DATE,
        BB.N_WRBTR GR_AMOUNT_IN_DOC,
        AA.WAERS GR_CURR,
        AA.MEINS GR_ITEM_UNIT,
        BB.N_DMBTR GR_AMOUNT_LOCAL,
        AA.BWART MOVE_TYPE,
        AA.SHKZG DEBET_KREDIT,
        AA.PSTYP TYPE_TRANSAKSI,
        RR.BUDAT CREATE_ON,
        AA.TXZ01 DESCRIPTION,
        AA.LFGJA YEAR_REF,
        AA.LFBNR DOC_GR_REF,
        AA.LFPOS GR_ITEM_REF,
        AA.WERKS
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
              AND LIFNR = '{$VND_NO}'
              AND PSTYP != '9'
              AND EKGRP IN (SELECT PRCHGRP FROM EC_INVOICE_PRCHGRP)
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
              AND LIFNR = '{$VND_NO}'
              AND PSTYP != '9'
          ) B ON
          A.GJAHR = B.LFGJA
          AND A.BELNR = B.LFBNR
          AND A.BUZEI = B.LFPOS
        WHERE
          NVL( A.WESBS, 0 )- NVL( B.WESBS, 0 )>= 0
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
          AND LIFNR = '{$VND_NO}'
          AND PSTYP != '9'
          AND BWART = '105'
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
          AND LIFNR = '{$VND_NO}'
          AND PSTYP != '9'
        GROUP BY
          LFGJA,
          LFBNR,
          LFPOS
        ) E ON
        E.LFGJA = C.GJAHR
        AND E.LFBNR = C.BELNR
        AND E.LFPOS = C.BUZEI
        ) BB ON
        AA.BELNR = BB.BELNR
        AND AA.GJAHR = BB.GJAHR
        AND AA.BUZEI = BB.BUZEI
        AND BB.N_MENGE > 0
        INNER JOIN (
        SELECT BELNR,
        LFGJA,
        LFBNR,
        LFPOS,
        BLDAT,
        BUDAT,
        LFGJA||'-'||LFBNR||'-'||LFPOS AS KUNCI
        FROM
        EC_GR_SAP
        WHERE BWART = 105
        AND STATUS = 0
        AND LIFNR = '{$VND_NO}'
        AND PSTYP != '9'
        AND LFBNR IS NOT NULL
        GROUP BY BELNR,
            LFGJA,
            LFBNR,
            LFPOS,
            BLDAT,
            BUDAT
        )RR ON RR.LFGJA = AA.GJAHR
        AND RR.LFBNR = AA.BELNR
        AND RR.LFPOS = AA.BUZEI
        JOIN (
            	SELECT max(BELNR) BELNR,LFGJA||'-'||LFBNR||'-'||LFPOS AS KUNCI FROM ec_gr_sap
            	WHERE BWART = 105
                  AND STATUS = 0
                  AND LIFNR = '{$VND_NO}'
                  AND PSTYP != '9'
                  AND LFBNR IS NOT NULL
				GROUP BY LFGJA,LFBNR,LFPOS
            )MAXRELEASE ON MAXRELEASE.KUNCI = RR.KUNCI AND MAXRELEASE.BELNR = RR.BELNR
        WHERE
        AA.STATUS = 0
        AND LIFNR = '{$VND_NO}'
        AND PSTYP != '9'
        )TMP WHERE TMP.WERKS IN (SELECT PLANT FROM EC_INVOICE_PLANT WHERE STATUS = 1)
SQL;



 SELECT
               XX.PO_NO,
               XX.GR_YEAR,
               XX.RR_NO,
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
               XX.WERKS
            FROM
               (
                  SELECT
                     EGS.EBELN PO_NO,
                     EGS.GJAHR GR_YEAR,
                     EGS.BELNR RR_NO,
                     EGS.BELNR GR_NO,
                     EGS.BUZEI GR_ITEM_NO,
                     EGS.MATNR MATERIAL_NO,
                     EGS.EBELP PO_ITEM_NO,
                     GR.GR_ITEM_QTY - NVL(GR_BATAL.GR_ITEM_QTY, 0) GR_ITEM_QTY,
                     EGS.BLDAT GR_DATE,
                     GR.GR_AMOUNT_IN_DOC - NVL(GR_BATAL.GR_AMOUNT_IN_DOC, 0) GR_AMOUNT_IN_DOC,
                     EGS.WAERS GR_CURR,
                     EGS.MEINS GR_ITEM_UNIT,
                     GR.GR_AMOUNT_LOCAL - NVL(GR_BATAL.GR_AMOUNT_LOCAL, 0) GR_AMOUNT_LOCAL,
                     EGS.BWART MOVE_TYPE,
                     EGS.SHKZG DEBET_KREDIT,
                     EGS.PSTYP TYPE_TRANSAKSI,
                     EGS.BUDAT CREATE_ON,
                     EGS.TXZ01 DESCRIPTION,
                     EGS.LFGJA YEAR_REF,
                     EGS.LFBNR DOC_GR_REF,
                     EGS.LFPOS GR_ITEM_REF,
                     EGS.WERKS
                  FROM
                     (
                        SELECT
                           GJAHR GR_YEAR,
                           BELNR GR_NO,
                           BUZEI GR_ITEM_NO,
                           SUM(MENGE) GR_ITEM_QTY,
                           SUM(WRBTR) GR_AMOUNT_IN_DOC,
                           SUM(DMBTR) GR_AMOUNT_LOCAL
                        FROM
                           EC_GR_SAP
                        WHERE
                           STATUS = 0
                           AND LIFNR = '{$VND_NO}'
                           AND SHKZG = 'S'
                           AND VGABE IN
                           (
                              '1'
                           )
                           AND PSTYP IN
                           (
                              '0',
                              '3'
                           )
                           AND BWART NOT IN
                           (
                              '105',
                              '106'
                           )
                           AND EKGRP IN
                           (
                              SELECT
                                 PRCHGRP
                              FROM
                                 EC_INVOICE_PRCHGRP
                           )
                        GROUP BY
                           GJAHR,
                           BELNR,
                           BUZEI
                     )
                     GR
                     JOIN
                        EC_GR_SAP EGS
                        ON EGS.BELNR = GR.GR_NO
                        AND EGS.GJAHR = GR.GR_YEAR
                        AND EGS.BUZEI = GR.GR_ITEM_NO
                     LEFT JOIN
                        (
                           SELECT
                              SUM(MENGE) GR_ITEM_QTY,
                              SUM(WRBTR) GR_AMOUNT_IN_DOC,
                              SUM(DMBTR) GR_AMOUNT_LOCAL,
                              LFGJA YEAR_REF,
                              LFBNR DOC_GR_REF,
                              LFPOS GR_ITEM_REF
                           FROM
                              EC_GR_SAP
                           WHERE
                              STATUS = 0
                              AND LIFNR = '{$VND_NO}'
                              AND SHKZG = 'H'
                              AND VGABE IN
                              (
                                 '1'
                              )
                              AND PSTYP IN
                              (
                                 '0',
                                 '3'
                              )
                              AND BWART NOT IN
                              (
                                 '105',
                                 '106'
                              )
                           GROUP BY
                              LFGJA,
                              LFBNR,
                              LFPOS
                        )
                        GR_BATAL
                        ON GR_BATAL.YEAR_REF = GR.GR_YEAR
                        AND GR_BATAL.DOC_GR_REF = GR.GR_NO
                        AND GR_BATAL.GR_ITEM_REF = GR.GR_ITEM_NO
               )
               XX
            WHERE
               XX.GR_ITEM_QTY > 0   
*/
$sql = <<<SQL
SELECT
   *
FROM
   (
      select
         CA.*,ES.LOT_NUMBER,EGLOT.PRINT_TYPE
      from
         (
            
            SELECT
               XX.PO_NO,
               XX.GR_YEAR,
               XX.RR_NO,
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
               xx.PRUEFLOS
            FROM
               (
                  SELECT
                     EGS.EBELN PO_NO,
                     EGS.GJAHR GR_YEAR,
                     EGS.BELNR RR_NO,
                     EGS.BELNR GR_NO,
                     EGS.BUZEI GR_ITEM_NO,
                     EGS.MATNR MATERIAL_NO,
                     EGS.EBELP PO_ITEM_NO,
                     GR.GR_ITEM_QTY - NVL(GR_BATAL.GR_ITEM_QTY, 0) GR_ITEM_QTY,
                     EGS.BLDAT GR_DATE,
                     GR.GR_AMOUNT_IN_DOC - NVL(GR_BATAL.GR_AMOUNT_IN_DOC, 0) GR_AMOUNT_IN_DOC,
                     EGS.WAERS GR_CURR,
                     EGS.MEINS GR_ITEM_UNIT,
                     GR.GR_AMOUNT_LOCAL - NVL(GR_BATAL.GR_AMOUNT_LOCAL, 0) GR_AMOUNT_LOCAL,
                     EGS.BWART MOVE_TYPE,
                     EGS.SHKZG DEBET_KREDIT,
                     EGS.PSTYP TYPE_TRANSAKSI,
                     EGS.BUDAT CREATE_ON,
                     EGS.TXZ01 DESCRIPTION,
                     EGS.LFGJA YEAR_REF,
                     EGS.LFBNR DOC_GR_REF,
                     EGS.LFPOS GR_ITEM_REF,
                     EGS.WERKS,
                     EGS.PRUEFLOS
                  FROM
                     (
                        SELECT
                           GJAHR GR_YEAR,
                           BELNR GR_NO,
                           BUZEI GR_ITEM_NO,
                           SUM(MENGE) GR_ITEM_QTY,
                           
                           /*AMOUNT DISESUAIKAN DENGAN POTONGAN MUTU POTONGAN MUTU*/
                       CASE
                        WHEN POMUT.NO_BA IS NULL THEN SUM(WRBTR)
                       ELSE POMUT.AMOUNT END GR_AMOUNT_IN_DOC,
                       CASE
                        WHEN POMUT.NO_BA IS NULL THEN SUM(DMBTR)
                       ELSE POMUT.AMOUNT END GR_AMOUNT_LOCAL
                           /*
                           SUM(WRBTR) GR_AMOUNT_IN_DOC,
                           SUM(DMBTR) GR_AMOUNT_LOCAL,
                           */
                           --POMUT.NO_BA,
                           --POMUT.AMOUNT,
                           --POMUT.STATUS_POMUT
                           /*CASE
                        WHEN POMUT.NO_BA IS NULL THEN '2'
                       ELSE POMUT.STATUS_POMUT END STATUS_POMUT*/
                       
                        FROM
                           EC_GR_SAP EGSS
                        LEFT JOIN( /* POTONGAN MUTU*/
                          SELECT PH.EBELN PO_NO,PH.EBELP PO_ITEM_NO,PD.MBLNR GR_NO,PH.NO_BA,PD.JML_BAYAR AMOUNT,PH.STATUS STATUS_POMUT FROM EC_POMUT_HEADER_SAP PH 
                          JOIN EC_POMUT_DETAIL_SAP PD
                            ON PH.NO_BA = PD.NO_BA 
                          )POMUT ON POMUT.PO_NO = EGSS.EBELN AND POMUT.GR_NO = EGSS.BELNR AND POMUT.PO_ITEM_NO = EGSS.EBELP
                        WHERE
                           STATUS = 0
                           AND LIFNR = '{$VND_NO}'
                           AND SHKZG = 'S'
                           AND VGABE IN
                           (
                              '1'
                           )
                           AND PSTYP IN
                           (
                              '0',
                              '3'
                           )
                           AND BWART NOT IN
                           (
                              '105',
                              '106'
                           )
                           AND EKGRP IN
                           (
                              SELECT
                                 PRCHGRP
                              FROM
                                 EC_INVOICE_PRCHGRP
                           )
                        GROUP BY
                           GJAHR,
                           BELNR,
                           BUZEI,
                           POMUT.NO_BA,
                           POMUT.AMOUNT
                     )
                     GR
                     JOIN
                        EC_GR_SAP EGS
                        ON EGS.BELNR = GR.GR_NO
                        AND EGS.GJAHR = GR.GR_YEAR
                        AND EGS.BUZEI = GR.GR_ITEM_NO
                     LEFT JOIN
                        (
                           SELECT
                              SUM(MENGE) GR_ITEM_QTY,
                              SUM(WRBTR) GR_AMOUNT_IN_DOC,
                              SUM(DMBTR) GR_AMOUNT_LOCAL,
                              LFGJA YEAR_REF,
                              LFBNR DOC_GR_REF,
                              LFPOS GR_ITEM_REF
                           FROM
                              EC_GR_SAP
                           WHERE
                              STATUS = 0
                              AND LIFNR = '{$VND_NO}'
                              AND SHKZG = 'H'
                              AND VGABE IN
                              (
                                 '1'
                              )
                              AND PSTYP IN
                              (
                                 '0',
                                 '3'
                              )
                              AND BWART NOT IN
                              (
                                 '105',
                                 '106'
                              )
                           GROUP BY
                              LFGJA,
                              LFBNR,
                              LFPOS
                        )
                        GR_BATAL
                        ON GR_BATAL.YEAR_REF = GR.GR_YEAR
                        AND GR_BATAL.DOC_GR_REF = GR.GR_NO
                        AND GR_BATAL.GR_ITEM_REF = GR.GR_ITEM_NO
               )
               XX
            WHERE
               XX.GR_ITEM_QTY > 0
           				-- AWAL MENCARI UNBILLED SPARE PART
            UNION ALL
            SELECT
               AA.EBELN PO_NO,
               AA.GJAHR GR_YEAR,
               RR.BELNR RR_NO,
               AA.BELNR GR_NO,
               AA.BUZEI GR_ITEM_NO,
               AA.MATNR MATERIAL_NO,
               AA.EBELP PO_ITEM_NO,
               BB.N_MENGE GR_ITEM_QTY,
               --	AA.CPUDT GR_DATE,
               RR.BLDAT GR_DATE,
               BB.N_WRBTR GR_AMOUNT_IN_DOC,
               AA.WAERS GR_CURR,
               AA.MEINS GR_ITEM_UNIT,
               BB.N_DMBTR GR_AMOUNT_LOCAL,
               AA.BWART MOVE_TYPE,
               AA.SHKZG DEBET_KREDIT,
               AA.PSTYP TYPE_TRANSAKSI,
               RR.BUDAT CREATE_ON,
               AA.TXZ01 DESCRIPTION,
               AA.LFGJA YEAR_REF,
               AA.LFBNR DOC_GR_REF,
               AA.LFPOS GR_ITEM_REF,
               AA.WERKS,
               NULL AS PRUEFLOS
            FROM
               EC_GR_SAP AA
               JOIN
                  (
                     SELECT
                        C.*,
                        NVL( D.MENGE, 0 ) - NVL( E.MENGE, 0 ) AS N_MENGE,
                        NVL( D.WRBTR, 0 ) - NVL( E.WRBTR, 0 ) AS N_WRBTR,
                        NVL( D.DMBTR, 0 ) - NVL( E.DMBTR, 0 ) AS N_DMBTR
                     FROM
                        (
                           SELECT
                              A.GJAHR,
                              A.BELNR,
                              A.BUZEI,
                              NVL( A.WESBS, 0 ) - NVL( B.WESBS, 0 ) N_WESBS
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
                                    AND LIFNR = '{$VND_NO}'
                                    AND PSTYP != '9'
                                    AND EKGRP IN
                                    (
                                       SELECT
                                          PRCHGRP
                                       FROM
                                          EC_INVOICE_PRCHGRP
                                    )
                              )
                              A
                              LEFT JOIN
                                 (
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
                                       AND LIFNR = '{$VND_NO}'
                                       AND PSTYP != '9'
                                 )
                                 B
                                 ON A.GJAHR = B.LFGJA
                                 AND A.BELNR = B.LFBNR
                                 AND A.BUZEI = B.LFPOS
                           WHERE
                              NVL( A.WESBS, 0 ) - NVL( B.WESBS, 0 ) >= 0
                        )
                        C
                        INNER JOIN
                           (
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
                                 AND LIFNR = '{$VND_NO}'
                                 AND PSTYP != '9'
                                 AND BWART = '105'
                              GROUP BY
                                 LFGJA,
                                 LFBNR,
                                 LFPOS
                           )
                           D
                           ON D.LFGJA = C.GJAHR
                           AND D.LFBNR = C.BELNR
                           AND D.LFPOS = C.BUZEI
                        LEFT JOIN
                           (
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
                                 AND LIFNR = '{$VND_NO}'
                                 AND PSTYP != '9'
                              GROUP BY
                                 LFGJA,
                                 LFBNR,
                                 LFPOS
                           )
                           E
                           ON E.LFGJA = C.GJAHR
                           AND E.LFBNR = C.BELNR
                           AND E.LFPOS = C.BUZEI
                  )
                  BB
                  ON AA.BELNR = BB.BELNR
                  AND AA.GJAHR = BB.GJAHR
                  AND AA.BUZEI = BB.BUZEI
                  AND BB.N_MENGE > 0
               INNER JOIN
                  (
                     SELECT
                        BELNR,
                        LFGJA,
                        LFBNR,
                        LFPOS,
                        BLDAT,
                        BUDAT,
                        LFGJA||'-'||LFBNR||'-'||LFPOS AS KUNCI
                     FROM
                        EC_GR_SAP
                     WHERE
                        BWART = 105
                        AND STATUS = 0
                        AND LIFNR = '{$VND_NO}'
                        AND PSTYP != '9'
                        AND LFBNR IS NOT NULL
                     GROUP BY
                        BELNR,
                        LFGJA,
                        LFBNR,
                        LFPOS,
                        BLDAT,
                        BUDAT
                  )
                  RR
                  ON RR.LFGJA = AA.GJAHR
                  AND RR.LFBNR = AA.BELNR
                  AND RR.LFPOS = AA.BUZEI
                JOIN (
                      	SELECT max(BELNR) BELNR,LFGJA||'-'||LFBNR||'-'||LFPOS AS KUNCI FROM EC_GR_SAP
                      	WHERE BWART = 105
                            AND STATUS = 0
                            AND LIFNR = '{$VND_NO}'
                            AND PSTYP != '9'
                            AND LFBNR IS NOT NULL
          				GROUP BY LFGJA,LFBNR,LFPOS
                      )MAXRELEASE ON MAXRELEASE.KUNCI = RR.KUNCI AND MAXRELEASE.BELNR = RR.BELNR
            WHERE
               AA.STATUS = 0
               AND LIFNR = '{$VND_NO}'
               AND PSTYP != '9'
         )
         CA
         left join
            EC_GR_STATUS ES
            on ES.PO_NO = CA.PO_NO
            and ES.GR_NO = CA.GR_NO
            and ES.GR_YEAR = CA.GR_YEAR
            and ES.GR_ITEM_NO = CA.GR_ITEM_NO
            and ES.STATUS = 3 OR ES.STATUS IS NULL
          join EC_GR_LOT EGLOT
            ON ES.LOT_NUMBER = EGLOT.LOT_NUMBER-- Level Approval
      -- AWAL UNTUK MENCARI UNBILLED JASA
         UNION ALL
         SELECT
            YY.PO_NO,
            YY.GR_YEAR,
            YY.GR_NO RR_NO,
            YY.GR_NO,
            TO_CHAR( YY.GR_ITEM_NO ) GR_ITEM_NO,
            YY.MATERIAL_NO,
            YY.PO_ITEM_NO,
            YY.GR_ITEM_QTY,
            YY.GR_DATE,
            YY.GR_AMOUNT_IN_DOC,
            YY.GR_CURR,
            YY.GR_ITEM_UNIT,
            YY.GR_AMOUNT_LOCAL,
            YY.MOVE_TYPE,
            YY.DEBET_KREDIT,
            YY.TYPE_TRANSAKSI,
            YY.CREATE_ON,
            YY.DESCRIPTION,
            YY.YEAR_REF,
            YY.DOC_GR_REF,
            YY.GR_ITEM_REF,
            YY.WERKS,
            NULL AS LOT_NUMBER,
            NULL AS PRUEFLOS,
            NULL AS PRINT_TYPE
         FROM
            (
               SELECT
                  EGS.EBELN PO_NO,
                  EGS.LFGJA GR_YEAR,
                  EGS.LFBNR GR_NO,
                  GR.GR_ITEM_NO,
                  EGS.MATNR MATERIAL_NO,
                  EGS.EBELP PO_ITEM_NO,
                  GR.GR_ITEM_QTY - NVL(GR_BATAL.GR_ITEM_QTY, 0) GR_ITEM_QTY,
                  EGS.BLDAT GR_DATE,
                  GR.GR_AMOUNT_IN_DOC - NVL(GR_BATAL.GR_AMOUNT_IN_DOC, 0) GR_AMOUNT_IN_DOC,
                  EGS.WAERS GR_CURR,
                  GR.UOMJASA GR_ITEM_UNIT,
                  GR.GR_AMOUNT_LOCAL - NVL(GR_BATAL.GR_AMOUNT_LOCAL, 0) GR_AMOUNT_LOCAL,
                  EGS.BWART MOVE_TYPE,
                  EGS.SHKZG DEBET_KREDIT,
                  GR.TYPE_TRANSAKSI,
                  EGS.BUDAT CREATE_ON,
                  GR.DESCRIPTION,
                  EGS.LFGJA YEAR_REF,
                  EGS.LFBNR DOC_GR_REF,
                  GR.GR_ITEM_NO GR_ITEM_REF,
                  GR.WERKS
               FROM
                  (
                     SELECT
                        A.LFGJA GR_YEAR,
                        A.LFBNR GR_NO,
                        A.LFPOS GR_ITEM_NO,
                        SUM(A.MENGE) GR_ITEM_QTY,
                        SUM(A.WRBTR) GR_AMOUNT_IN_DOC,
                        SUM(A.DMBTR) GR_AMOUNT_LOCAL,
                        B.PSTYP TYPE_TRANSAKSI,
                        COALESCE(B.TXZ01_ESSR, B.TXZ01) DESCRIPTION,
                        A.WERKS,
                        A.UOMJASA
                     FROM
                        EC_GR_SAP A
                        JOIN
                           (
                              SELECT
                                 *
                              FROM
                                 EC_GR_SAP
                              WHERE
                                 VGABE = '9'
                                 AND LIFNR = '{$VND_NO}'
                                 AND PSTYP = '9'
                                 AND STATUS = 0
                           )
                           B
                           ON A.LFBNR = B.BELNR
                           AND A.LFGJA = B.LFGJA
                     WHERE
                        A.STATUS = 0
                        AND A.LIFNR = '{$VND_NO}'
                        AND A.SHKZG = 'S'
                        AND A.VGABE IN
                        (
                           '1'
                        )
                        AND A.PSTYP = '9'
                        AND A.EKGRP IN
                        (
                           SELECT
                              PRCHGRP
                           FROM
                              EC_INVOICE_PRCHGRP
                        )
                     GROUP BY
                        A.LFGJA,
                        A.LFBNR,
                        A.LFPOS,
                        B.PSTYP,
                        B.TXZ01_ESSR,
                        B.TXZ01,
                        A.WERKS,
                        A.UOMJASA
                  )
                  GR
                  JOIN
                     EC_GR_SAP EGS
                     ON EGS.BELNR = GR.GR_NO
                     AND EGS.LFGJA = GR.GR_YEAR 							-- AND EGS.LFPOS = GR.GR_ITEM_NO
                  LEFT JOIN
                     (
                        SELECT
                           A.LFGJA YEAR_REF,
                           A.LFBNR DOC_GR_REF,
                           A.LFPOS GR_ITEM_REF,
                           SUM(A.MENGE) GR_ITEM_QTY,
                           SUM(A.WRBTR) GR_AMOUNT_IN_DOC,
                           SUM(A.DMBTR) GR_AMOUNT_LOCAL
                        FROM
                           EC_GR_SAP A
                           JOIN
                              (
                                 SELECT
                                    *
                                 FROM
                                    EC_GR_SAP
                                 WHERE
                                    VGABE = '9'
                                    AND LIFNR = '{$VND_NO}'
                                    AND PSTYP = '9'
                                    AND STATUS = 0
                              )
                              B
                              ON A.LFBNR = B.BELNR
                              AND A.LFGJA = B.LFGJA
                        WHERE
                           A.STATUS = 0
                           AND A.LIFNR = '{$VND_NO}'
                           AND A.SHKZG = 'H'
                           AND A.VGABE IN
                           (
                              '1'
                           )
                           AND A.PSTYP = '9'
                        GROUP BY
                           A.LFGJA,
                           A.LFBNR,
                           A.LFPOS
                     )
                     GR_BATAL
                     ON GR_BATAL.YEAR_REF = GR.GR_YEAR
                     AND GR_BATAL.DOC_GR_REF = GR.GR_NO
                     AND GR_BATAL.GR_ITEM_REF = GR.GR_ITEM_NO
            )
            YY
         WHERE
            YY.GR_ITEM_QTY > 0
   )
   TMP
WHERE
   TMP.WERKS IN
   (
      SELECT
         PLANT
      FROM
         EC_INVOICE_PLANT
      WHERE
         STATUS = 1
   )
SQL;
      //echo '<pre>'.$sql;
      //$result = $this->db->query($sql);
      //return (array) $result->result_array();
    return $sql;
    }

    public function getMan($VND_NO){
      $sql = "SELECT OPEN_GR.*,
                POMUT2.NO_BA,
                OPEN_GR.GR_ITEM_QTY - NVL(ER.GR_ITEM_QTY,0) AS AVAILABLE_QTY,
                CASE WHEN ER.GR_ITEM_QTY IS NULL THEN 'COMPLETE' ELSE 'SEBAGIAN' END STATUS_SEBAGIAN
              FROM (";
      $sql .= $this->mainQuery($VND_NO);
      $sql .= " )OPEN_GR
                LEFT JOIN (SELECT SUM(NVL(GR_ITEM_QTY,0)) AS GR_ITEM_QTY,GR_ITEM_NO,GR_NO,GR_YEAR FROM EC_GR GROUP BY GR_NO,GR_ITEM_NO,GR_YEAR) ER
                ON OPEN_GR.GR_NO = ER.GR_NO AND OPEN_GR.GR_ITEM_NO = ER.GR_ITEM_NO AND OPEN_GR.GR_YEAR = ER.GR_YEAR
                LEFT JOIN(
                  SELECT PH.EBELN PO_NO,PH.EBELP PO_ITEM_NO,PD.MBLNR GR_NO,PH.NO_BA,PD.JML_BAYAR AMOUNT,PH.STATUS STATUS_POMUT,PD.PRUEFLOS FROM EC_POMUT_HEADER_SAP PH
                  JOIN EC_POMUT_DETAIL_SAP PD
                    ON PH.NO_BA = PD.NO_BA 
                )POMUT2 ON POMUT2.PO_NO = OPEN_GR.PO_NO AND POMUT2.GR_NO = OPEN_GR.RR_NO AND POMUT2.PO_ITEM_NO = OPEN_GR.PO_ITEM_NO AND POMUT2.PRUEFLOS = OPEN_GR.PRUEFLOS
                WHERE POMUT2.STATUS_POMUT = '3' OR OPEN_GR.PRUEFLOS IS NULL OR OPEN_GR.PRUEFLOS = '0'";
      //echo $sql;die();
      return $this->db->query($sql)->result_array();
    }

    public function getGRVND($venno = '', $noinvoice = '', $status = '') {
        $this->db->select("EC_GR.*,EC_M_STRATEGIC_MATERIAL.*,EC_INVOICE_HEADER.*,
							TO_CHAR (\"EC_INVOICE_HEADER\".\"INVOICE_DATE\",'DD/MM/YYYY') AS INVOICE_DATE2,
							TO_CHAR (\"EC_INVOICE_HEADER\".\"FAKTUR_PJK_DATE\",'DD/MM/YYYY') AS FAKTUR_PJK_DATE2", false);
        $this->db->from($this->table);
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_GR.MATERIAL_NO = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        $this->db->where("EC_GR.VENDOR_NO", $venno, true);
        if ($status == '1' || $status == '4') {
            $this->db->join('EC_INVOICE_HEADER', 'EC_GR.INV_NO = EC_INVOICE_HEADER.NO_INVOICE', 'left');
            $this->db->where("(EC_INVOICE_HEADER.STATUS_HEADER = '" . $status . "' OR INV_NO = '" . $noinvoice . "' OR EC_GR.STATUS = '0' )");
        } else {
            $this->db->join('EC_INVOICE_HEADER', 'EC_GR.INV_NO = EC_INVOICE_HEADER.NO_INVOICE', 'inner');
            $this->db->where("INV_NO", $noinvoice, true);
            $this->db->where("EC_INVOICE_HEADER.STATUS_HEADER", $status, true);
        }
        $this->db->order_by("INV_NO,PO_NO");
        $result = $this->db->get();
        return (array) $result->result_array();
    }

    public function get_data_approved($VND_NO) {
        $this->db->from($this->table);
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_GR.MATERIAL_NO = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        $this->db->where("EC_GR.STATUS = 3");
        $result = $this->db->get();
        return (array) $result->result_array();
    }

    public function getIvoice($noinvoice) {
        /*
          $this->db->select("EC_INVOICE_HEADER.*,
          TO_CHAR (\"EC_INVOICE_HEADER\".\"INVOICE_DATE\",'DD/MM/YYYY') AS INVOICE_DATE2,
          TO_CHAR (\"EC_INVOICE_HEADER\".\"FAKTUR_PJK_DATE\",'DD/MM/YYYY') AS FAKTUR_PJK_DATE2", false);
          $this->db->from($this->tableHeader);
          $this->db->where("ID_INVOICE", $noinvoice, true);
          $result = $this->db->get();
         *
         */
        $sql = 'SELECT EIH.*
                ,TO_CHAR (EIH.INVOICE_DATE,\'DD/MM/YYYY\') AS INVOICE_DATE2
		,TO_CHAR (EIH.FAKTUR_PJK_DATE,\'DD/MM/YYYY\') AS FAKTUR_PJK_DATE2
		,ETI.STATUS_DOC
		,ETI.POSISI
                FROM EC_INVOICE_HEADER EIH
                JOIN (SELECT max("DATE") LAST_UPDATE,ID_INVOICE FROM EC_TRACKING_INVOICE GROUP BY ID_INVOICE) TT
                        ON TT.ID_INVOICE = EIH.ID_INVOICE
                JOIN EC_TRACKING_INVOICE ETI ON ETI.ID_INVOICE = TT.ID_INVOICE AND ETI."DATE" = TT.LAST_UPDATE
                WHERE EIH.ID_INVOICE = \'' . $noinvoice . '\'
';
        $result = $this->db->query($sql);
        return (array) $result->result_array();
    }

    public function get_data_proposal($VND_NO) {
        $this->db->from($this->table);
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_GR.MATERIAL_NO = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        $this->db->where("EC_GR.STATUS = 1");
        $result = $this->db->get();
        return (array) $result->result_array();
    }

    public function getGR($invoice) {
        $this->db->from($this->table);
        //    $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_GR.MATERIAL_NO = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        $this->db->join('EC_M_PO_DETAIL', 'EC_M_PO_DETAIL.PO_NUMBER = EC_GR.PO_NO and EC_M_PO_DETAIL.PO_ITEM = EC_GR.PO_ITEM_NO', 'inner');
        $this->db->join('EC_M_PO_HEADER', 'EC_M_PO_HEADER.PO_NUMBER = EC_M_PO_DETAIL.PO_NUMBER', 'inner');
        $this->db->where("INV_NO", $invoice, true);
        $result = $this->db->get();
        return (array) $result->result_array();
    }

    public function createINV($dataLC, $GR, $GRL) {
        // $inv_no = substr(date('YmdHsu'), 0, 14);
        $this->db->trans_start();
        $inv_no = $dataLC['INV_NO'];
        for ($i = 0; $i < sizeof($GR); $i++) {
            $this->db->where("GR_NO", $GR[$i], TRUE);
            $this->db->where("GR_ITEM_NO", $GRL[$i], TRUE);
            $this->db->update($this->table, array("STATUS" => "1", "INV_NO" => $inv_no));
        }
        $this->db->insert($this->tableHeader, array("INV_PIC" => $dataLC['INV_PIC'], "FAKTUR_PIC" => $dataLC['FAKTUR_PIC'], "TAX_CODE" => $dataLC['TAX_CODE'], "CURRENCY" => $dataLC['CURRENCY'], "INVOICE_NO" => $inv_no, "DOC_DATE" => $dataLC['INV_DATE'], "CHANGE_ON" => date('Ymd'), "INVOICE_DATE" => $dataLC['INV_DATE'], "FAKTUR" => $dataLC['FAKTUR_PJK'], "TOTAL_AMOUNT" => $dataLC['TOTAL'], "NOTE_CREATE" => $dataLC['NOTE']));
        $this->db->trans_complete();
    }

    public function createINVold($dataLC, $GR, $GRL) {
        for ($i = 0; $i < sizeof($GR); $i++) {
            $this->db->where("GR_NO", $GR[$i], TRUE);
            $this->db->where("GR_ITEM_NO", $GRL[$i], TRUE);
            $this->db->update($this->table, array("STATUS" => "1", "FAKTUR_PJK" => $dataLC['FAKTUR_PJK'], "INV_DATE" => $dataLC['INV_DATE'], "INV_NO" => $dataLC['INV_NO'], "NOTE" => $dataLC['NOTE']));
        }
    }

    public function getINV($VND_NO) {
        $this->db->select('GR_DOC_CURR,FAKTUR_PJK,INV_DATE,INV_NO,SUM(GR_AMOUNT_IN_DOC) as TOTAL');
        $this->db->from($this->table);
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_GR.MATERIAL_NO = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        $this->db->where("INV_NO", $VND_NO, true);
        $this->db->group_by("GR_DOC_CURR,FAKTUR_PJK,INV_DATE,INV_NO");
        $result = $this->db->get();
        return (array) $result->result_array();
    }

    function insert_sap($dataLC, $vnd_no) {
        $this->db->select('COUNT(*)')->from($this->table)->where("GR_NO", $dataLC['BELNR'], TRUE)->where("GR_ITEM_NO", $dataLC['BUZEI'], TRUE);
        $query = $this->db->get();
        $result = $query->row_array();
        $count = $result['COUNT(*)'];
        if ($count < 1) {
            $this->db->insert($this->table, array("VENDOR_NO" => $vnd_no, "PO_NO" => $dataLC['EBELN'], "PO_ITEM_NO" => $dataLC['EBELP'], "GR_YEAR" => $dataLC['GJAHR'], "GR_NO" => $dataLC['BELNR'], "GR_ITEM_NO" => $dataLC['BUZEI'], "MOVE_TYPE" => $dataLC['BWART'], "GR_ITEM_QTY" => $dataLC['MENGE'], "GR_AMOUNT_LOCAL" => $dataLC['DMBTR'] * 100, "GR_AMOUNT_IN_DOC" => $dataLC['WRBTR'] * 100, "GR_CURR" => $dataLC['WAERS'], "DEBET_KREDIT" => $dataLC['SHKZG'], "COMPLETE_INDICATOR" => $dataLC['ELIKZ'], "REF" => $dataLC['XBLNR'], "THN_REF" => $dataLC['LFGJA'], "REF_DOC" => $dataLC['LFBNR'], "REF_DOC_ITEM" => $dataLC['LFPOS'], "MATERIAL_NO" => $dataLC['MATNR'], "PLANT" => $dataLC['WERKS'], "DOC_DATE" => $dataLC['BLDAT'], "GR_DATE" => $dataLC['BUDAT'], "CREATE_ON" => $dataLC['CPUDT'], "CREATE_AT" => $dataLC['CPUTM'], "CREATE_BY" => $dataLC['ERNAM']));
        } else {
            $this->db->where("GR_NO", $dataLC['BELNR'], TRUE);
            $this->db->where("GR_ITEM_NO", $dataLC['BUZEI'], TRUE);
            $this->db->update($this->table, array("PO_NO" => $dataLC['EBELN'], "PO_ITEM_NO" => $dataLC['EBELP'], "GR_YEAR" => $dataLC['GJAHR'], "GR_NO" => $dataLC['BELNR'], "GR_ITEM_NO" => $dataLC['BUZEI'], "MOVE_TYPE" => $dataLC['BWART'], "GR_ITEM_QTY" => $dataLC['MENGE'], "GR_AMOUNT_LOCAL" => $dataLC['DMBTR'] * 100, "GR_AMOUNT_IN_DOC" => $dataLC['WRBTR'] * 100, "GR_CURR" => $dataLC['WAERS'], "DEBET_KREDIT" => $dataLC['SHKZG'], "COMPLETE_INDICATOR" => $dataLC['ELIKZ'], "REF" => $dataLC['XBLNR'], "THN_REF" => $dataLC['LFGJA'], "REF_DOC" => $dataLC['LFBNR'], "REF_DOC_ITEM" => $dataLC['LFPOS'], "MATERIAL_NO" => $dataLC['MATNR'], "PLANT" => $dataLC['WERKS'], "DOC_DATE" => $dataLC['BLDAT'], "GR_DATE" => $dataLC['BUDAT'], "CREATE_ON" => $dataLC['CPUDT'], "CREATE_AT" => $dataLC['CPUTM'], "CREATE_BY" => $dataLC['ERNAM']));
        }
    }

    public function get_Invoince() {
        $this->db->from($this->tableHeader);
        //$this -> db -> join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        //$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
        //$this -> db -> join('EC_PRICELIST_OFFER', 'EC_M_STRATEGIC_MATERIAL.MATNR = EC_PRICELIST_OFFER.MATNO', 'left');
        $this->db->where("STATUS_HEADER", '1', TRUE);
        //$this -> db -> where("PUBLISHED_PRICELIST", '1', TRUE);
        $result = $this->db->get();
        return (array) $result->result_array();
    }

    public function get_All_Invoice() {
        $this->db->from($this->tableHeader);
        $result = $this->db->get();
        return (array) $result->result_array();
    }

    public function get_Invoince2() {
        //if ($mins == 0) {
        //	$this -> db -> limit(11);
        //} else
        //	$this -> db -> where("ROWNUM <=", $max, false);
        // $SQL = "select SUM(g.GR_AMOUNT_IN_DOC) as AMOUNT,g.INV_NO,g.INV_DATE,g.FAKTUR_PJK,g.GR_CURR FROM EC_GR g
        // 		WHERE g.INV_NO IS NOT NULL GROUP BY g.INV_NO,g.INV_DATE,g.FAKTUR_PJK,g.GR_CURR";
        // // '" . $ptm . "'
        // $result = $this -> db -> query($SQL);

        $this->db->from($this->tableHeader);
        //$this -> db -> join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        //$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
        //$this -> db -> join('EC_PRICELIST_OFFER', 'EC_M_STRATEGIC_MATERIAL.MATNR = EC_PRICELIST_OFFER.MATNO', 'left');
        $this->db->where("STATUS_HEADER", '3', TRUE);
        //$this -> db -> where("PUBLISHED_PRICELIST", '1', TRUE);
        $result = $this->db->get();
        return (array) $result->result_array();
    }

    public function get_Rejected() {
        //if ($mins == 0) {
        //	$this -> db -> limit(11);
        //} else
        //	$this -> db -> where("ROWNUM <=", $max, false);
        // $SQL = "select SUM(g.GR_AMOUNT_IN_DOC) as AMOUNT,g.INV_NO,g.INV_DATE,g.FAKTUR_PJK,g.GR_CURR FROM EC_GR g
        // 		WHERE g.INV_NO IS NOT NULL GROUP BY g.INV_NO,g.INV_DATE,g.FAKTUR_PJK,g.GR_CURR";
        // // '" . $ptm . "'
        // $result = $this -> db -> query($SQL);

        $this->db->from($this->tableHeader);
        //$this -> db -> join('EC_M_STRATEGIC_MATERIAL', 'EC_T_CONTRACT.matno = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        //$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
        //$this -> db -> join('EC_PRICELIST_OFFER', 'EC_M_STRATEGIC_MATERIAL.MATNR = EC_PRICELIST_OFFER.MATNO', 'left');
        $this->db->where("STATUS_HEADER", '2', TRUE);
        //$this -> db -> where("PUBLISHED_PRICELIST", '1', TRUE);
        $result = $this->db->get();
        return (array) $result->result_array();
    }

    public function get_InvoinceDetail($INVOICE_NO) {
        //if ($mins == 0) {
        //	$this -> db -> limit(11);
        //} else
        //	$this -> db -> where("ROWNUM <=", $max, false);

        $this->db->from($this->tableHeader);
        $this->db->join('EC_GR', 'EC_INVOICE_HEADER.INVOICE_NO = EC_GR.INV_NO', 'left');
        //$this -> db -> join('EC_R1', 'EC_T_CONTRACT.vendorno = EC_R1.VENDOR_ID', 'left');
        //$this -> db -> join('EC_PRICELIST_OFFER', 'EC_M_STRATEGIC_MATERIAL.MATNR = EC_PRICELIST_OFFER.MATNO', 'left');
        $this->db->where("EC_INVOICE_HEADER.INVOICE_NO", $INVOICE_NO, TRUE);
        //$this -> db -> where("PUBLISHED_PRICELIST", '1', TRUE);
        $result = $this->db->get();
        return (array) $result->result_array();
    }

    public function create_Invoice($dataLC, $GR, $GRL, $NAMA) {
        //$this->db->trans_off();
        $this->db->trans_start();

        $SQL = "INSERT INTO \"EC_INVOICE_HEADER\" (\"ID_INVOICE\", \"NO_INVOICE\", \"INVOICE_DATE\", \"FAKTUR_PJK_DATE\", \"NO_SP_PO\", \"NO_BAPP\", \"NO_BAST\", \"NO_KWITANSI\", \"FAKTUR_PJK\", \"POT_MUTU\", \"SURAT_PRMHONAN_BYR\", \"TOTAL_AMOUNT\", \"NOTE\", \"ALASAN_REJECT\", \"INVOICE_PIC\", \"BAPP_PIC\", \"BAST_PIC\", \"KWITANSI_PIC\", \"FAKPJK_PIC\", \"POTMUT_PIC\", \"SPMHONBYR_PIC\", \"AMOUNT_PIC\", \"INDATE\", \"CHDATE\", \"STATUS_HEADER\", \"NO_TAX\", \"CURRENCY\", \"VENDOR_NO\", \"PAJAK\", \"K3\", \"K3_PIC\", \"ITEM_CAT\" )
		VALUES ('0','" . $dataLC['NO_INVOICE'] . "',TO_DATE('" . $dataLC['INVOICE_DATE'] . "', 'dd-mm-yyyy hh24:mi:ss'),TO_DATE('" . $dataLC['FAKTUR_PJK_DATE'] . "', 'dd-mm-yyyy hh24:mi:ss'),'" . $dataLC['NO_SP_PO'] . "','" . $dataLC['NO_BAPP'] . "','" . $dataLC['NO_BAST'] . "','" . $dataLC['NO_KWITANSI'] . "','" . $dataLC['FAKTUR_PJK'] . "','" . $dataLC['POT_MUTU'] . "','" . $dataLC['SURAT_PRMHONAN_BYR'] . "','" . $dataLC['TOTAL_AMOUNT'] . "','" . $dataLC['NOTE'] . "','','" . $dataLC['INVOICE_PIC'] . "','" . $dataLC['BAPP_PIC'] . "','" . $dataLC['BAST_PIC'] . "','" . $dataLC['KWITANSI_PIC'] . "','" . $dataLC['FAKPJK_PIC'] . "','" . $dataLC['POTMUT_PIC'] . "','" . $dataLC['SPMHONBYR_PIC'] . "','" . $dataLC['AMOUNT_PIC'] . "',TO_DATE('" . $dataLC['DATETIME'] . "', 'yyyy-mm-dd hh24:mi:ss'),TO_DATE('" . $dataLC['DATETIME'] . "', 'yyyy-mm-dd hh24:mi:ss'),'1','" . $dataLC['NO_TAX'] . "','" . $dataLC['CURRENCY'] . "','" . $dataLC['VENDOR_NO'] . "','" . $dataLC['PAJAK'] . "','" . $dataLC['K3'] . "','" . $dataLC['K3_PIC'] . "','" . $dataLC['ITEM_CAT'] . "')";
        // '" . $ptm . "'
        $this->db->query($SQL);

        $inv_no = "(SELECT MAX(ID_INVOICE) FROM EC_INVOICE_HEADER WHERE VENDOR_NO='" . $dataLC['VENDOR_NO'] . "')";
        for ($i = 0; $i < sizeof($GR); $i++) {
            $this->db->where("GR_NO", $GR[$i], TRUE);
            $this->db->where("GR_ITEM_NO", $GRL[$i], TRUE);
            $this->db->set('STATUS', '1', true);
            $this->db->set('INV_NO', $inv_no, false);
            $this->db->update($this->table);
        }

        $this->db->set('ID_INVOICE', $inv_no, FALSE);
        $this->db->set('DATE', "TO_DATE('" . date("d-m-Y H:i:s") . "', 'dd-mm-yyyy hh24:mi:ss')", FALSE);
        $this->db->set('STATUS_TRACK', 1, FALSE);
        $this->db->set('DESC', "BARU", TRUE);
        $this->db->set('STATUS_DOC', "BELUM KIRIM", TRUE);
        $this->db->set('POSISI', "VENDOR", TRUE);
        $this->db->set('USER', $NAMA, TRUE);
        $this->db->insert($this->tableTracking);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->where("EC_INVOICE_HEADER.ID_INVOICE", $inv_no, false);
            $this->db->delete($this->tableHeader);
        }

        $this->db->select('MAX(ID_INVOICE)')->from('EC_INVOICE_HEADER')->where("VENDOR_NO", $dataLC['VENDOR_NO'], TRUE);
        $query = $this->db->get();
        $result = $query->row_array();
        $max = $result['MAX(ID_INVOICE)'];
        return $result['MAX(ID_INVOICE)'];
    }

    public function edit_Invoice($dataLC, $GR, $GRL, $ID_INVOICE, $NAMA) {
        // $inv_no = substr(date('YmdHsu'), 0, 14);
        //$this->db->trans_start();
        $this->db->where("INV_NO", $ID_INVOICE, TRUE);
        $this->db->update($this->table, array("STATUS" => "0", "INV_NO" => ''));

        //$inv_no = $dataLC['NO_INVOICE'];
        for ($i = 0; $i < sizeof($GR); $i++) {
            $this->db->where("GR_NO", $GR[$i], TRUE);
            $this->db->where("GR_ITEM_NO", $GRL[$i], TRUE);
            $this->db->update($this->table, array("STATUS" => "1", "INV_NO" => $ID_INVOICE));
        }
        //\"NO_INVOICE\"='" . $dataLC['NO_INVOICE'] . "',
        $SQL = "UPDATE \"EC_INVOICE_HEADER\" SET \"NO_INVOICE\"='" . $dataLC['NO_INVOICE'] . "',\"INVOICE_DATE\"=TO_DATE('" . $dataLC['INVOICE_DATE'] . "', 'dd-mm-yyyy hh24:mi:ss'),\"FAKTUR_PJK_DATE\"=TO_DATE('" . $dataLC['FAKTUR_PJK_DATE'] . "', 'dd-mm-yyyy hh24:mi:ss'),\"NO_SP_PO\"='" . $dataLC['NO_SP_PO'] . "',\"NO_BAPP\"='" . $dataLC['NO_BAPP'] . "', \"NO_BAST\"='" . $dataLC['NO_BAST'] . "',\"NO_KWITANSI\"='" . $dataLC['NO_KWITANSI'] . "',\"FAKTUR_PJK\"='" . $dataLC['FAKTUR_PJK'] . "',\"POT_MUTU\"='" . $dataLC['POT_MUTU'] . "',\"SURAT_PRMHONAN_BYR\"='" . $dataLC['SURAT_PRMHONAN_BYR'] . "',\"TOTAL_AMOUNT\"='" . $dataLC['TOTAL_AMOUNT'] . "',\"NOTE\"='" . $dataLC['NOTE'] . "'";

        if ($dataLC['INVOICE_PIC'] != '') {
            $SQL .= ",\"INVOICE_PIC\"='" . $dataLC['INVOICE_PIC'] . "'";
        }
        if ($dataLC['BAPP_PIC'] != '') {
            $SQL .= ",\"BAPP_PIC\"='" . $dataLC['BAPP_PIC'] . "'";
        }
        if ($dataLC['BAST_PIC'] != '') {
            $SQL .= ",\"BAST_PIC\"='" . $dataLC['BAST_PIC'] . "'";
        }
        if ($dataLC['KWITANSI_PIC'] != '') {
            $SQL .= ",\"KWITANSI_PIC\"='" . $dataLC['KWITANSI_PIC'] . "'";
        }
        if ($dataLC['FAKPJK_PIC'] != '') {
            $SQL .= ",\"FAKPJK_PIC\"='" . $dataLC['FAKPJK_PIC'] . "'";
        }
        if ($dataLC['POTMUT_PIC'] != '') {
            $SQL .= ",\"POTMUT_PIC\"='" . $dataLC['POTMUT_PIC'] . "'";
        }
        if ($dataLC['SPMHONBYR_PIC'] != '') {
            $SQL .= ",\"SPMHONBYR_PIC\"='" . $dataLC['SPMHONBYR_PIC'] . "'";
        }
        if ($dataLC['AMOUNT_PIC'] != '') {
            $SQL .= ",\"AMOUNT_PIC\"='" . $dataLC['AMOUNT_PIC'] . "'";
        }
        $SQL .= ",\"INDATE\"=TO_DATE('" . $dataLC['DATETIME'] . "', 'yyyy-mm-dd hh24:mi:ss'),\"CHDATE\"=TO_DATE('" . $dataLC['DATETIME'] . "', 'yyyy-mm-dd hh24:mi:ss'), \"NO_TAX\"='" . $dataLC['NO_TAX'] . "',\"CURRENCY\"='" . $dataLC['CURRENCY'] . "',\"VENDOR_NO\"='" . $dataLC['VENDOR_NO'] . "'";
        $SQL .= " WHERE \"ID_INVOICE\"='" . $ID_INVOICE . "'";
        $this->db->query($SQL);

        $this->db->set('ID_INVOICE', $ID_INVOICE, FALSE);
        $this->db->set('DATE', "TO_DATE('" . date("d-m-Y H:i:s") . "', 'dd-mm-yyyy hh24:mi:ss')", FALSE);
        $this->db->set('STATUS_TRACK', 1, FALSE);
        $this->db->set('DESC', "EDIT", TRUE);
        $this->db->set('STATUS_DOC', "BELUM KIRIM", TRUE);
        $this->db->set('POSISI', "VENDOR", TRUE);
        $this->db->set('USER', $NAMA, TRUE);
        $this->db->insert($this->tableTracking);
    }

    public function get_Invoice($where_str = '', $order = '') {
        $sql = 'SELECT distinct EIH.*
                ,TO_CHAR (EIH.INVOICE_DATE,\'DD/MM/YYYY\') AS INVOICE_DATE2
		,TO_CHAR (EIH.FAKTUR_PJK_DATE,\'DD/MM/YYYY\') AS FAKTUR_PJK_DATE2
        ,TO_CHAR (EIH.CHDATE,\'DD/MM/YYYY\') AS CHDATE2
		,ETI.STATUS_DOC
		,ETI.POSISI
              --  ,(select name1 FROM ec_gr_sap WHERE EBELN = EIH.NO_SP_PO AND ROWNUM = 1) VEND_NAME
                ,VH.VENDOR_NAME VEND_NAME, EGS.BSART
                FROM EC_INVOICE_HEADER EIH
                JOIN VND_HEADER VH ON lpad(VH.VENDOR_NO,10,0) = EIH.VENDOR_NO
                JOIN (SELECT max("DATE") LAST_UPDATE,ID_INVOICE FROM EC_TRACKING_INVOICE GROUP BY ID_INVOICE) TT
                        ON TT.ID_INVOICE = EIH.ID_INVOICE
                JOIN EC_TRACKING_INVOICE ETI ON ETI.ID_INVOICE = TT.ID_INVOICE AND ETI."DATE" = TT.LAST_UPDATE AND ETI.STATUS_TRACK = EIH.STATUS_HEADER
                LEFT JOIN EC_GR_SAP EGS ON EGS.EBELN=EIH.NO_SP_PO
                ' . $where_str . '
                ' . $order . '
';
  //echo '<pre>'.$sql;
        $result = $this->db->query($sql);

        return (array) $result->result_array();
    }

    public function get_InvoiceTerimaDokumen($where_str = '', $order = '') {
        $sql = 'SELECT distinct EIH.*
                ,TO_CHAR (EIH.INVOICE_DATE,\'DD/MM/YYYY\') AS INVOICE_DATE2
		,TO_CHAR (EIH.FAKTUR_PJK_DATE,\'DD/MM/YYYY\') AS FAKTUR_PJK_DATE2
        ,TO_CHAR (EIH.CHDATE,\'DD/MM/YYYY\') AS CHDATE2
		,ETI.STATUS_DOC
		,ETI.POSISI
              --  ,(select name1 FROM ec_gr_sap WHERE EBELN = EIH.NO_SP_PO AND ROWNUM = 1) VEND_NAME
                ,VH.VENDOR_NAME VEND_NAME
                ,(select NO_EKSPEDISI FROM EC_EKSPEDISI WHERE ID_INVOICE = EIH.ID_INVOICE AND ROWNUM = 1) NO_EKSPEDISI
                ,(select TO_CHAR (CREATE_DATE,\'DD/MM/YYYY\') FROM EC_EKSPEDISI WHERE ID_INVOICE = EIH.ID_INVOICE AND ROWNUM = 1) TGL_KIRIM,
                EGS.BSART
                FROM EC_INVOICE_HEADER EIH
                JOIN VND_HEADER VH ON lpad(VH.VENDOR_NO,10,0) = EIH.VENDOR_NO
                JOIN (SELECT max("DATE") LAST_UPDATE,ID_INVOICE FROM EC_TRACKING_INVOICE GROUP BY ID_INVOICE) TT
                        ON TT.ID_INVOICE = EIH.ID_INVOICE
                JOIN EC_TRACKING_INVOICE ETI ON ETI.ID_INVOICE = TT.ID_INVOICE AND ETI."DATE" = TT.LAST_UPDATE  AND ETI.STATUS_TRACK = EIH.STATUS_HEADER
                LEFT JOIN EC_GR_SAP EGS ON EGS.EBELN=EIH.NO_SP_PO AND EGS.BELNR=EIH.FI_NUMBER_SAP
                ' . $where_str . '
                ' . $order . '
';

        $result = $this->db->query($sql);

        return (array) $result->result_array();
    }

    public function tracking($ID_INVOICE) {
        $this->db->select("EC_TRACKING_UM.*,EC_UM_HEADER.*,
		TO_CHAR (\"EC_TRACKING_UM\".\"DATE\",'dd/mm/yyyy hh24:mi:ss') AS TRACK_DATE", false);
        $this->db->from($this->tableTracking);
        $this->db->where("EC_TRACKING_UM.ID_UM", $ID_INVOICE, TRUE);
        $this->db->join('EC_UM_HEADER', 'EC_TRACKING_UM.ID_UM = EC_UM_HEADER.ID_UM', 'inner');
        $this->db->order_by('EC_TRACKING_UM.DATE', 'DESC');
        $result = $this->db->get();
        return (array) $result->result_array();
    }

    public function setStatus_Invoice($ID_INVOICE, $status, $NAMA) {
        $this->db->where("EC_UM_HEADER.ID_UM", $ID_INVOICE, TRUE);
        $this->db->update($this->tableHeader, array("STATUS_HEADER" => $status));

        $this->db->set('ID_UM', $ID_INVOICE, FALSE);
        $this->db->set('DATE','sysdate', FALSE);
        $this->db->set('STATUS_TRACK', $status, FALSE);
        $this->db->set('DESC', "EDIT", TRUE);
        $this->db->set('STATUS_DOC', "KIRIM", TRUE);
        $this->db->set('POSISI', "VERIFIKASI", TRUE);
        $this->db->set('USER', $NAMA, TRUE);
        $this->db->insert($this->tableTracking);
    }

    public function delete_Invoice($ID_INVOICE, $NAMA) {
        $this->db->where("EC_INVOICE_HEADER.ID_INVOICE", $ID_INVOICE, TRUE);
        $this->db->delete($this->tableHeader);

        $this->db->where("EC_GR.INV_NO", $ID_INVOICE, TRUE);
        $this->db->set('INV_NO', NULL, FALSE);
        $this->db->update($this->table, array("STATUS" => "0"));

        $this->db->set('ID_INVOICE', $ID_INVOICE, FALSE);
        $this->db->set('DATE', "TO_DATE('" . date("d-m-Y H:i:s") . "', 'dd-mm-yyyy hh24:mi:ss')", FALSE);
        $this->db->set('STATUS_TRACK', 9, FALSE);
        $this->db->set('DESC', "HAPUS", TRUE);
        $this->db->set('STATUS_DOC', "-", TRUE);
        $this->db->set('POSISI', "VENDOR", TRUE);
        $this->db->set('USER', $NAMA, TRUE);
        $this->db->insert($this->tableTracking);
    }

    function insertTDenda($data) {
        $this->db->insert($this->tableDenda, $data);
    }

    function insertTDoc($data) {
        $this->db->insert($this->tableDoc, $data);
    }

    public function getDenda($ID_INV) {
        $this->db->from("EC_T_DENDA_INV");
        $this->db->where("ID_INV", $ID_INV, TRUE);
        $this->db->join('EC_M_DENDA_INV', 'EC_T_DENDA_INV.ID_DENDA = EC_M_DENDA_INV.ID_JENIS', 'inner');
        $result = $this->db->get();
        return (array) $result->result_array();
    }

    public function getDOc($ID_INV) {
        $this->db->from("EC_T_DOC_INV");
        $this->db->where("ID_INV", $ID_INV, TRUE);
        $this->db->join('EC_M_DOC_INV', 'EC_T_DOC_INV.ID_DOC = EC_M_DOC_INV.ID_JENIS', 'inner');
        $result = $this->db->get();
        return (array) $result->result_array();
    }

    /* List GR yang boleh diedit */

    public function getGREdit($noPo) {
        $this->db->select("EC_GR.*,EC_M_STRATEGIC_MATERIAL.*,EC_INVOICE_HEADER.*,
							TO_CHAR (\"EC_INVOICE_HEADER\".\"INVOICE_DATE\",'DD/MM/YYYY') AS INVOICE_DATE2,
							TO_CHAR (\"EC_INVOICE_HEADER\".\"FAKTUR_PJK_DATE\",'DD/MM/YYYY') AS FAKTUR_PJK_DATE2", false);
        $this->db->from($this->table);
        $this->db->join('EC_M_STRATEGIC_MATERIAL', 'EC_GR.MATERIAL_NO = EC_M_STRATEGIC_MATERIAL.MATNR', 'left');
        $this->db->where("EC_GR.PO_NO", $noPo, true);

        $this->db->join('EC_INVOICE_HEADER', 'EC_GR.INV_NO = to_char(EC_INVOICE_HEADER.ID_INVOICE)', 'inner');
        //  $this->db->where("EC_INVOICE_HEADER.STATUS_HEADER", $status, true);
        $this->db->order_by("INV_NO,PO_NO");
        $result = $this->db->get();
        return (array) $result->result_array();
    }

}
