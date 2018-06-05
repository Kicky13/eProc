<?php
  $detailRR = array();
  $tinggi = '35px';
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
          <td style="height:'.$tinggi.'" align="center">'.$value['GR_ITEM_QTY'].'<br>'.$value['LGORT'].'</td>
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
<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      font-size: 8pt;
    }
    table {
      width : 100%;
      border : 1px solid;
      border-collapse: collapse;
    }
    table td {
      border : 1px solid;
      border-collapse: collapse;
    }
    table.noborder{
      width: 100%;
      border : 0px;
    }
    table.noborder td{
      border : 0px;
    }
    .mini {
      font-size:6pt
    }
    .vendor_name{
      font-size : 90%;
    }
    .small{font-size: 10px;}
    .bold{font-weight: bold;}
  </style>
  <title>Cetak RR</title>
</head>
<body>
  <table>
    <thead>
      <tr>
        <td colspan="4"  valign="top">
          <div style="min-height:200px;">
            <table class="noborder">
              <tr>
                <td>
                  <img src="<?php echo site_url('static/images/logo/'.$company_data['logo']) ?>" width="40" alt="Logo Perusahaan">
                </td>
                <td colspan="2" style="padding:5px" class="mini">
                  <div><?php echo $company_data['nama'] ?></div>
                  <div>NPWP : <?php echo $company_data['npwp'] ?> </div>
                </td>
              </tr>
              <?php
                foreach($company_data['alamat'] as $_k => $alamat){
                  echo '<tr>
                    <td class="mini" valign="top">
                      '.$_k.'
                    </td>
                    <td class="mini" valign="top"> : </td>
                    <td class="mini">'.$alamat['detail'].'</td>
                  </tr>';
                }
              ?>

            </table>
          </div>
          <hr style="width:101%;border : 1px solid black"/>
          <div>NAMA PEMASOK :</div>
          <div class="vendor_name mini">
            <div><?php echo $data['poAddress']['NAME1'] ?></div>
            <div><?php echo $data['poAddress']['STREET'] ?></div>
            <div><?php echo $data['poAddress']['CITY1'] ?></div>
            <div>Fax. <?php echo $data['poAddress']['FAX_NUMBER'] ?></div>
          </div>
          <br />
          <div style="width:150px;padding-left:60px">Kode : <?php echo $data['poHeader']['VENDOR'] ?></div>
        </td>
        <td valign="top" align="center" width="300px" >
          <div style="height:100px;font-weight:bold">
            <h2>LAPORAN <br > PENERIMAAN BARANG</h2>
            <br >
            ( Receiving Report )
          </div>
          <hr style="width:101%;border : 1px solid black"/>
          <div style="margin:0px">
            <table class="noborder" width="100%">
              <tr>
                <td>NO. RR</td>
                <td> : <?php echo $jenis_id != 'LOT' ? $no_rr : ''; ?></td>
              </tr>
              <tr>
                <td>TGL. RR</td>
                <td> : <?php echo $jenis_id != 'LOT' ? stringDate($tglRR) : ''; ?></td>
              </tr>
              <tr>
                <tr>
                <td>DOC. DATE</td>
                <td> : <?php echo $jenis_id != 'LOT' ? stringDate($tglDoc) : ''; ?></td>
              </tr>
              <tr>
                <td>KODE ANGGARAN</td>
                <td> : </td>
              </tr>
            </table>
          </div>
        </td>
        <td colspan="2">
          <div style="height:60px;">
            <div style>Halaman : 1</div>
          </div>
          <hr style="width:101%;border : 1px solid black"/>
          <div>
            <table class="noborder">
              <tr>
                <td>NOMOR OP</td>
                <td> : </td>
                <td><?php echo $data['poHeader']['PO_NUMBER'] ?></td>
              </tr>
              <tr>
                <td>TANGGAL OP</td>
                <td> : </td>
                <td><?php echo stringDate($data['poHeader']['DOC_DATE']) ?></td>
              </tr>
              <tr>
                <td>TGL. BATAS OP</td>
                <td> : </td>
                <td> <?php echo stringDate($data['poSchedules'][0]['DELIV_DATE'])?> </td>
              </tr>
              <tr>
                <td>NOMOR INVOICE</td>
                <td> : </td>
                <td>  </td>
              </tr>
              <tr>
                <td>NILAI OP</td>
                <td> : </td>
                <td><?php echo ribuan($totalOp) ?></td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
      <tr>
        <td align="center">No. Item</td>
        <td align="center">Nomor Stock</td>
        <td align="center">Sat.</td>
        <td align="center">Jumlah Barang</td>
        <td align="center">Nama Barang</td>
        <td align="center">Harga Satuan (Rp)</td>
        <td align="center">Jumlah Harga (Rp)</td>
      </tr>
    </thead>
    <tbody style="min-height:400px">
      <?php echo implode(' ',$detailRR) ?>
    </tbody>
  </table>
  
  <?php if($print_type == 'LOT'){
  echo '
  <br >
  <table width="100%">
    <tr>
      <td style="height:'.$tinggi.'>" align="center"><strong>Total GR</strong></td>
      <td style="height:'.$tinggi.'" align="center">'.$data['detailRR'][0]['MATERIAL_NO'].'</td>
      <td style="height:'.$tinggi.'" align="center">'.$data['detailRR'][0]['DESCRIPTION'].'</td>
      <td style="height:'.$tinggi.'" align="center">'.$totalQty.' '.$data['detailRR'][0]['GR_ITEM_UNIT'].'</td>
    </tr>
  </table>'
  ;
  }
  ?>
</body>

</html>
