<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* ini milik webservice untuk ptpn */
class Resume_model extends CI_Model {
  function detail($_where = NULL){
    $where = !empty($_where) ? $_where : '';
    $sql = <<<SQL
    select  t.CHITNO,
 	          t.PLANT,
 	 	        t.WB,
  	        t.JENISTRANSAKSI,
  	        t.SPBS,
           	t.VENDORNO,
           	t.VENDORDESC,
           	t.NOKENDARAAN,
           	t.NAMASUPIR,
           	t.NOKONTRAK,
    --       	t.NOPO,
    --       	t.NOPOITM,
           	t.MATERIALNO,
           	t.MATERIALDESC,
    --       	t.RECIPIENT,
    --       	t.QTYMASUK,
    --       	t.QTYBRONDOLAN,
    --       	t.QTYKELUAR,
            (t.QTYMASUK - t.QTYKELUAR)  - ((t.QTYMASUK - t.QTYKELUAR) * (t.POTONGAN/100)) QTY,
           	t.UOM,
    --       	t.TGLMASUK,
    --       	t.TGLBRONDOLAN,
    --       	t.TGLKELUAR,
    --       	t.JAMMASUK,
    ---       	t.JAMBRONDOLAN,
    --       	t.JAMKELUAR,
    --       	t.PETUGASMASUK,
    --       	t.PETUGASBRONDOLAN,
    --       	t.PETUGASKELUAR,
    --       	t.CREATEBY,
    --       	t.CREATEDATE,
    --       	t.CREATETIME,
    --       	t.LASTUPDATEBY,
    --       	t.LASTUPDATEDATE,
    --       	t.LASTUPDATETIME,
           	t.STATUSSAP,
            t.COUNTER_SEND,
            ts.MAT_DOC,
	          ts.DOC_YEAR,
	          ts.MVT,
	          ts.QTY QTY_SAP
	  --        ts.UOM
    from timbangan t
    left join timbangan_sap ts on t.chitno = ts.chitno
    {$where}
SQL;

    return $this->db->query($sql)->result_array();
  }

  function resumeHarian($_where = NULL){
    $where = !empty($_where) ? $_where : '';
    $sql = <<<SQL
    select  t.PLANT,
 	 	        t.WB,
  	        t.JENISTRANSAKSI,
           	t.MATERIALNO,
           	t.MATERIALDESC,
           	t.TGLKELUAR,
           	sum((t.QTYMASUK - t.QTYKELUAR)  - ((t.QTYMASUK - t.QTYKELUAR) * (t.POTONGAN/100))) QTY,
           	t.UOM,
	          sum(ts.QTY) QTY_SAP
    from timbangan t
    left join timbangan_sap ts on t.chitno = ts.chitno
    {$where}
    group by t.TGLKELUAR,
            t.PLANT,
            t.WB,
            t.JENISTRANSAKSI,
            t.MATERIALNO,
            t.MATERIALDESC,
            t.UOM
SQL;
    return $this->db->query($sql)->result_array();
  }
}
