<?php
  $detailRR = array();
  $tinggi = '50px';
  $totalOp = 0;
  $totalQty = 0;
  $tglRR = '';
  $tglDoc = '';
  $no_rr = '';
  if(!empty($data['detailRR'])){
    $no = 1;
    
    foreach ($data['detailRR'] as $key => $value) {
    $t_jum = count($data['landed_cost'][$value['GR_NO']][$value['PO_ITEM_NO']])+1;
    $desc = $print_type != 'LOT' ? $value['DESCRIPTION'] : $value['DESCRIPTION'].'<br>
    '.stringDate($value['GR_DATE']).' '.$value['GR_NO'].' '.stringDate($value['CREATE_ON']);

    $tr = '<tr>
          <td style="vertical-align: top; padding-top:18px; height:'.$tinggi.'" align="center" rowspan="'.$t_jum.'">'.$no++.'</td>
          <td style="height:'.$tinggi.'" align="center">'.$value['MATERIAL_NO'].'</td>
          <td style="height:'.$tinggi.'" align="center">'.$value['GR_ITEM_UNIT'].'</td>
          <td style="height:'.$tinggi.'" align="center">'.$value['GR_ITEM_QTY'].'</td>
          <td style="height:'.$tinggi.'" align="center">'.$desc.'</td>
          <td style="height:'.$tinggi.'" align="center">'.ribuan($value['GR_AMOUNT_IN_DOC']/$value['GR_ITEM_QTY']).'</td>
          <td style="height:'.$tinggi.'" align="center">'.ribuan($value['GR_AMOUNT_IN_DOC']).'</td>
        </tr>';
        $totalOp += $value['GR_AMOUNT_IN_DOC'];
        $totalQty += $value['GR_ITEM_QTY'];
        if(empty($tglRR)){
          $tglRR = $value['GR_DATE'];
        }
        if(empty($tglDoc)){
          $tglDoc = $value['CREATE_ON'];
        }
        if(empty($no_rr)){
          $no_rr = $value['RR_NO'];
        }
        array_push($detailRR,$tr);
        foreach ($data['landed_cost'][$value['GR_NO']][$value['PO_ITEM_NO']] as $val) {
            $tr = '<tr>
                <td style="height:'.$tinggi.'" align="center" colspan="3">'.$val['KSCHL'].' - '.$val['VTEXT'].'</td>
                <td style="height:'.$tinggi.'" align="center">'.$val['LIFNR'].' - '.$val['NAME1'].'</td>
                <td style="height:'.$tinggi.'" align="center"></td>
                <td style="height:'.$tinggi.'" align="center">'.ribuan($val['DMBTR']).'</td>
            </tr>';
            array_push($detailRR,$tr);
        }
    }
  }
?>

<table class="noborder">
    <tr>
      <td>&nbsp;&nbsp;Dengan Huruf,</td>
      <td style="width:400px;height:25px;border:1px solid black"><div>&nbsp;<?php echo terbilang($totalOp,4) ?></div></td>
      <td>Rp.</td>
      <td style="width:170px;height:25px;border:1px solid black"><div>&nbsp;<?php echo ribuan($totalOp) ?></div></td>
    </tr>
</table>
<table class="noborder" widht='100%' style="margin-top:10px">
    <tr>
      <td style="width:150px;"></td>
      <td>Kabiro. Pengelolaan Persediaan</td>
      <td style="width:30px"></td>
      <td>Kasi. Penerimaan Barang</td>
    </tr>
    <tr>
      <td style="width:150px;"></td>
      <td><barcode code="<?php echo $data['barcode']['kabiro'] ?>" size="0.7" type="QR" error="M" class="barcode" /></td>
      <td style="width:30px"></td>
      <td><barcode code="<?php echo $data['barcode']['kasi'] ?>" size="0.7" type="QR" error="M" class="barcode" /></td>
    </tr>

    <tr>
      <td style="width:150px"></td>
      <td>_______________________________</td>
      <td style="width:30px"></td>
      <td>___________________________</td>
    </tr>
  </table>
  <table style="width:100%;height:50px;border:1px solid black;margin-top: 20px;"><tr><td> &nbsp;</td></tr></table>
  <div style="text-align:right">Pemasok</div>
  <div class='small bold' style="margin-top:15px;"><strong>Receiving Report ini telah disetujui secara sistem atau elektronik sehingga tidak diperlukan tanda tangan basah sebagai pengesahan</strong></div>