<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ec_gr_status extends MY_Model {
    public $table = 'EC_GR_STATUS';
    protected $timestamps = FALSE;
    public $increments = FALSE;
  //  public $primary_key = 'ID_BAPP';
    public function update($data = NULL, $where = NULL){
      $this->db->where($where);
      return $this->db->update($this->table,$data);
    }


    public function update_item($detail_item,$data_update){
      $this->db->where(array('GR_NO'=>$detail_item['GR_NO'],'GR_YEAR'=>$detail_item['GR_YEAR']));
      return $this->db->update('EC_GR_STATUS',$data_update);
    }


    /* approve tidaknya dilihat dari statusnya , 1 jika sudah approve */
    public function detailGrNotApprove($item){
      /* buat query temporary untuk dijoinkan dengan ec_gr_status */
      $_tmp = array();
      foreach($item as $i){
        $_t = array();
        foreach($i as $_k => $_v){
          array_push($_t,$_v .' as '.$_k);
        }
        array_push($_tmp,'select '.implode(',',$_t).' from dual');
      }
      $sql_tmp =  implode(' union ',$_tmp);
      $sql = <<<SQL
      select EGS.*
      from EC_GR_STATUS EGS
      join ({$sql_tmp})TT
        on TT.GR_NO = EGS.GR_NO and TT.GR_YEAR = EGS.GR_YEAR and TT.GR_ITEM_NO = EGS.GR_ITEM_NO
      where EGS.STATUS = 0
SQL;
      //log_message('ERROR',$sql);
      return $this->db->query($sql)->result_array();
    }

    public function detailGrBahan($no_rr,$no_po,$po_item = NULL){
      $filter_po_item = $po_item == NULL ? '' : 'AND EBELP = '.$po_item;
      $sql = <<<SQL
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
               SUBSTR(XX.CREATE_ON,7,2)||'/'||SUBSTR(XX.CREATE_ON,5,2)||'/'||SUBSTR(XX.CREATE_ON,0,4) CREATE_ON2,
               XX.DESCRIPTION,
               XX.YEAR_REF,
               XX.DOC_GR_REF,
               XX.GR_ITEM_REF,
               XX.WERKS,
               'BAHAN' JENISPO,
               XX.LGORT,
               XX.LGPLA --tambahan iw
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
                     GR.LGORT,
                     EGS.LGPLA
                  FROM
                     (
                        SELECT
                           GJAHR GR_YEAR,
                           BELNR GR_NO,
                           BUZEI GR_ITEM_NO,
                           LGORT, --tambahan iw
                           SUM(MENGE) GR_ITEM_QTY,
                           SUM(WRBTR) GR_AMOUNT_IN_DOC,
                           SUM(DMBTR) GR_AMOUNT_LOCAL
                        FROM
                           EC_GR_SAP
                        WHERE
                    --       STATUS = 0
                           SHKZG = 'S'
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
                           AND LFBNR = '{$no_rr}'
                           AND EBELN = '{$no_po}'
                           {$filter_po_item}
                        GROUP BY
                           GJAHR,
                           BELNR,
                           BUZEI,
                           LGORT,
                           LGPLA
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
                              LFPOS GR_ITEM_REF,
			      LGORT,
                              LGPLA
                           FROM
                              EC_GR_SAP
                           WHERE
                          --    STATUS = 0
                              SHKZG = 'H'
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
                              AND LFBNR = '{$no_rr}'
                              AND EBELN = '{$no_po}'
                              {$filter_po_item}
                           GROUP BY
                              LFGJA,
                              LFBNR,
                              LFPOS,
			      LGORT,
                              LGPLA
                        )
                        GR_BATAL
                        ON GR_BATAL.YEAR_REF = GR.GR_YEAR
                        AND GR_BATAL.DOC_GR_REF = GR.GR_NO
                        AND GR_BATAL.GR_ITEM_REF = GR.GR_ITEM_NO
               )
               XX
            WHERE
               XX.GR_ITEM_QTY > 0
SQL;

      return $this->db->query($sql,false)->result_array();
    }

    public function detailGrSparepart($no_rr,$no_po,$po_item = NULL){
      $filter_po_item = $po_item == NULL ? '' : 'AND EBELP = '.$po_item;
      $sql = <<<SQL
        SELECT
            A .*
        FROM
	(SELECT
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
               SUBSTR(RR.BUDAT,7,2)||'/'||SUBSTR(RR.BUDAT,5,2)||'/'||SUBSTR(RR.BUDAT,0,4) CREATE_ON2,
               AA.TXZ01 DESCRIPTION,
               AA.LFGJA YEAR_REF,
               AA.LFBNR DOC_GR_REF,
               AA.LFPOS GR_ITEM_REF,
               AA.WERKS,
               'SPARE_PART' JENISPO,
              RR.LGORT,
              RR.LGPLA
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
                              --      AND STATUS = 0
                                    AND PSTYP != '9'
                                    AND EKGRP IN
                                    (
                                       SELECT
                                          PRCHGRP
                                       FROM
                                          EC_INVOICE_PRCHGRP
                                    )
                                    AND EBELN = '{$no_po}'
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
                          --             AND STATUS = 0
                                       AND PSTYP != '9'
                                       AND EBELN = '{$no_po}'
                                 )
                                 B
                                 ON A.GJAHR = B.LFGJA
                                 AND A.BELNR = B.LFBNR
                                 AND A.BUZEI = B.LFPOS
                           WHERE
                              NVL( A.WESBS, 0 ) - NVL( B.WESBS, 0 ) > 0
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
                        --         AND STATUS = 0
                                 AND PSTYP != '9'
                                 AND BWART = '105'
                                 AND EBELN = '{$no_po}'
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
                  --               AND STATUS = 0
                                 AND PSTYP != '9'
                                 AND EBELN = '{$no_po}'
                                 {$filter_po_item}
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
                        LGORT,
                        LGPLA
                     FROM
                        EC_GR_SAP
                     WHERE
                        BWART = 105
              --          AND STATUS = 0
                        AND PSTYP != '9'
                        AND EBELN = '{$no_po}'
                        {$filter_po_item}
                        AND LFBNR IS NOT NULL
                     GROUP BY
                        BELNR,
                        LFGJA,
                        LFBNR,
                        LFPOS,
                        BLDAT,
                        BUDAT,
                        LGORT,
                        LGPLA
                  )
                  RR
                  ON RR.LFGJA = AA.GJAHR
                  AND RR.LFBNR = AA.BELNR AND RR.BELNR = '{$no_rr}'
                  AND RR.LFPOS = AA.BUZEI
            WHERE PSTYP != '9'
               --AA.STATUS = 0
              -- AND PSTYP != '9'
        )A
        LEFT JOIN EC_GR_SAP E ON PO_NO = E .EBELN
        AND GR_YEAR = E .GJAHR
        AND E .BELNR = RR_NO
        AND E .BELNR = GR_NO
        AND E .BUZEI = GR_ITEM_NO
        AND E .MATNR = MATERIAL_NO
        AND E .EBELP = PO_ITEM_NO
        AND E .LFGJA = YEAR_REF
        AND E .LFBNR = DOC_GR_REF
        AND E .LFPOS = GR_ITEM_REF
        AND E .WAERS = GR_CURR
SQL;
      return $this->db->query($sql,false)->result_array();
    }
}
