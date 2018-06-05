<!DOCTYPE html>
<html>
<head>
	<title>Rekap Penawaran</title>
	<style>
		body{
			font-family: Arial, sans-serif;
		}
		table{
			width: 100%;
          /*border: 1px solid black;*/
          border-collapse: collapse;
          margin-top: 7px;
          margin-bottom: 7px;
      }
      th{
         background-color:#dbdee5;
         font-size: 9pt;
     }

     th, td {
      /*padding: 3px;*/
      /*text-align: right;*/
      font-size: 8pt;
  }
  table, th, td{
     /*border-bottom: 1px solid black;*/
     border-collapse: collapse;
 }
 .data{
     border: 1px solid black;
     font-size: 8pt;
 }
 .container{
     margin-top: 1cm;
 }
 .judul{
     font-size: 12pt;
     font-weight: bold;
     text-align: center;
 }
 .cell{
    display: table-cell;
    font-size: 9;
}
.cell.head{
    background-color:#000000;
    color:#ffffff;
    text-align: center;
}
.table.no-border{
 display: table;
 margin-top: 10px;
 margin-bottom: 10px;
 width: 100%;
}
.table-row{
 display: table-row;

}
.title{
 background-color:#f0f1f4;
 text-align: center;
}
.kanan{
 text-align: right;
}
.kiri{
 text-align: left;
}
.tengah{
 text-align: center;
}

</style>
</head>
<body>
	<div class="container">
        <div class="judul"><strong>Lampiran Kronologi Lembar Persetujuan Penunjukan Pemenang</strong></div><br>
        
        <span style="display:block;padding-bottom:1px;font-size:9pt;">
            I. Tanggal Aanwijing : <?php echo empty($ptp['PTP_PREBID_DATE']) ? '' : betteroracledate(oraclestrtotime($ptp['PTP_PREBID_DATE'])) ?>
        </span>
        <br>
        <span style="display:block;padding-bottom:1px;font-size:9pt;">
            II. Undangan Penawaran Teknis : 
            <!-- <?php echo empty($ptp['PTP_REG_OPENING_DATE']) ? '' : betteroracledate(oraclestrtotime($ptp['PTP_REG_OPENING_DATE'])) ?> -->
            <?php echo empty($ptp['PTP_PREBID_DATE']) ? '' : betteroracledate(oraclestrtotime($ptp['PTP_PREBID_DATE'])) ?>
            s/d <?php echo empty($ptp['PTP_REG_CLOSING_DATE']) ? '' : betteroracledate(oraclestrtotime($ptp['PTP_REG_CLOSING_DATE'])) ?>
        </span>
        <br>
        <span style="display:block;padding-bottom:1px;font-size:9pt;">
            III. Evaluasi Teknis: <?php echo date('d M Y',$appevatek); ?> - <?php echo date('d M Y',$appeval); ?>
        </span>
        <table class="table data">
            <tr>
                <td class="title kiri">
                    Hasil Evaluasi Teknis
                </td>
            </tr>
            <tr>
                <td class="kiri">
                    Evaluator : <?php echo $evaluator['FULLNAME']." ( ".$evaluator['DEPT_NAME']." )" ?>
                </td>
            </tr>
        </table>
        <?php echo $evaluasi; ?>
        <br/>
        <span style="display:block;padding-bottom:1px;font-size:9pt;">
            IV. Undangan Penawaran: <?php echo date('d M Y',strtotime($ptm['PTM_CREATED_DATE'])); ?> - <?php echo date('d M Y',$releaseComplete); ?>
        </span>
        <br>
        <table border="1" class="table table-bordered data">
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>Peserta Tender :</td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <?php
                        $nvendor = count($pesertavendor);
                        $half = (int)($nvendor / 2);
                        ?>
                        <?php if(($nvendor % 2) == 1): ?>
                            <?php for ($i=0; $i < $half ; $i++) { ?>
                            <tr>
                                <td>
                                    <?php echo ($i+1).". ".$pesertavendor[$i]['VENDOR_NAME']; ?>
                                </td>
                                <td style="padding-left: 400px;">
                                    <?php echo ($half+1+$i+1).". ".$pesertavendor[$half+$i]['VENDOR_NAME']; ?>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td class="col-md-6 kiri">
                                    <?php echo ($half+1).". ".@$pesertavendor[$half+$i]['VENDOR_NAME']; ?>
                                </td>
                            </tr>
                        <?php else:?>
                            <?php for ($i=0; $i < $half ; $i++) { ?>
                            <tr>
                                <td>
                                    <?php echo ($i+1).". ".$pesertavendor[$i]['VENDOR_NAME']; ?>
                                </td>
                                <td style="padding-left: 400px;">
                                    <?php echo ($half+$i+1).". ".$pesertavendor[$half+$i]['VENDOR_NAME']; ?>
                                </td>
                            </tr>
                            <?php } ?>
                        <?php endif; ?>
                    </table>
                </td>
            </tr>
        </table>
        <br/>
        <span style="display:block;padding-bottom:1px;font-size:9pt;">
            V. Rekap Penawaran Yang Respon: <?php echo ($verifikasiPenawaran!='')?date('d M Y',$verifikasiPenawaran):''; ?>
        </span>
        <table class="table">
            <thead>
                <tr>
                    <td nowrap class="title tengah data" rowspan="3">No</td>
                    <td nowrap class="title tengah data" rowspan="3">Nama Barang/Pekerjaan</td>
                    <td nowrap class="title tengah data" rowspan="3">Qty</td>
                    <td nowrap class="title tengah data" rowspan="3">UoM</td>
                    <td nowrap class="title tengah data" rowspan="3">ECE<br>(Unit Price)</td>
                    <td nowrap class="title tengah data" colspan="<?php echo count($nyo); ?>">Vendor / RFQ</td>
                </tr>
                <tr>
                    <?php foreach ($nyo as $vendor):?>
                        <td nowrap class="title tengah data"><?php echo str_replace(' ','<br>', $vendor['VENDOR_NAME']);?></td>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <?php foreach ($nyo as $vendor):?>
                        <?php foreach ($pesertavendor as $vnd):?>
                            <?php if($vendor['PTV_VENDOR_CODE'] == $vnd['PTV_VENDOR_CODE']):?>
                                <td nowrap class="title tengah data"><?php echo $vnd['PTV_RFQ_NO']?></td>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endforeach ?>
                </tr>
            </thead>
            <tbody>
                <?php $no=0; foreach ($pti as $id => $val): ?>
                <?php foreach ($item as $key => $value):?>
                    <?php if($val['PPI_DECMAT'] == $value['POD_DECMAT']): ?>
                        <tr>
                            <td class="tengah data"><?php echo $no+1; ?></td>
                            <td class="kiri data" nowrap><?php echo $val['PPI_DECMAT'] ?></td>
                            <td class="tengah data"><?php echo $val['TIT_QUANTITY'] ?></td>
                            <td class="tengah data"><?php echo $val['PPI_UOM'] ?></td>
                            <td class="kanan data"><?php echo number_format($val['TIT_PRICE']) ?></td>
                            <?php foreach ($nyo as $vnd): ?>
                                <td class="kanan data">
                                    <?php 
                                    if(isset($ptqi[$val['TIT_ID']][$vnd['PTV_VENDOR_CODE']]['PQI_FINAL_PRICE'])){ ?>
                                    <?php   echo number_format($ptqi[$val['TIT_ID']][$vnd['PTV_VENDOR_CODE']]['PQI_PRICE']); ?>
                                    <?php } 
                                    ?>
                                </td>
                            <?php endforeach ?>
                        </tr>
                        <?php $no++; endif ?>
                    <?php endforeach ?>
                <?php endforeach ?>
            </tbody>
        </table>
        <br/>
        <?php foreach ($history as $nomor => $data): ?>
            <?php if($data['NEGOSIASI'] == "1"): ?>
                <span style="display:block;padding-bottom:1px;font-size:9pt;">
                    <?php echo $data['ROMAWI'] ?>. Undangan Negosiasi: <?php if($data['NEGOSIASI'] == "3") echo date('d M Y H:i:s',$data['DATE']); else echo date('d M Y',$data['DATE']);  ?>
                </span>
                <table border="1" class="table table-bordered data">
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td>Peserta Negosiasi :</td>
                                </tr>
                                <tr><td>&nbsp;</td></tr>
                                <?php
                                $vendor_name = array_unique($data['DATA']['VENDOR_NAME']);
                                $vendor_code = array_unique($data['DATA']['VENDOR_CODE']);
                                $nvendor = count($vendor_name);
                                $half = (int)($nvendor / 2);
                                ?>
                                <?php if(($nvendor % 2) == 1): ?>
                                    <?php for ($i=0; $i < $half ; $i++) { ?>
                                    <tr>
                                        <td>
                                            <?php echo ($i+1).". ".$pesertavendor[$i]['VENDOR_NAME']; ?>
                                        </td>
                                        <td style="padding-left: 400px;">
                                            <?php echo ($half+1+$i+1).". ".$pesertavendor[$half+$i]['VENDOR_NAME']; ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="col-md-6 kiri">
                                            <?php echo ($half+1).". ".@$pesertavendor[$half+$i]['VENDOR_NAME']; ?>
                                        </td>
                                    </tr>
                                <?php else:?>
                                    <?php for ($i=0; $i < $half ; $i++) { ?>
                                    <tr>
                                        <td>
                                            <?php echo ($i+1).". ".$pesertavendor[$i]['VENDOR_NAME']; ?>
                                        </td>
                                        <td style="padding-left: 400px;">
                                            <?php echo ($half+$i+1).". ".$pesertavendor[$half+$i]['VENDOR_NAME']; ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                <?php endif; ?>
                            </table>                            
                        </td>
                    </tr>
                </table>
                <br/>
                <table class="table">
                    <thead>
                        <tr>
                            <td height="45" class="kiri" colspan="8">
                                <span style="display:block;padding-bottom:1px;font-size:9pt;">
                                    <?php echo $data['ROMAWI_II'] ?>. Rekap Negosiasi: <?php echo date('d M Y',$data['DATA']['NEGO_END']); ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td nowrap class="title tengah data" rowspan="3">No</td>
                            <td nowrap class="title tengah data" rowspan="3">Nama Barang/Pekerjaan</td>
                            <td nowrap class="title tengah data" rowspan="3">Qty</td>
                            <td nowrap class="title tengah data" rowspan="3">UoM</td>
                            <td nowrap class="title tengah data" rowspan="3">ECE<br>(Unit Price)</td>
                            <td nowrap class="title tengah data" colspan="<?php echo count($vendor_name); ?>">Vendor / RFQ</td>
                        </tr>
                        <tr>
                            <?php foreach ($vendor_name as $key => $value): ?>
                                <td nowrap class="title tengah data"><?php echo $value; ?></td>
                            <?php endforeach ?>
                        </tr>
                        <tr>
                            <?php foreach ($vendor_code as $key => $value):?>
                                <?php foreach ($pesertavendor as $vnd):?>
                                    <?php if ($value == $vnd['PTV_VENDOR_CODE']): ?>
                                        <td nowrap class="title tengah data"><?php echo $vnd['PTV_RFQ_NO']; ?></td>
                                    <?php endif ?>
                                <?php endforeach ?>
                            <?php endforeach ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=0; foreach ($data['M_ITEM'] as $id => $val): ?>
                        <?php foreach ($item as $key => $value): ?>
                            <?php if($val['PPI_DECMAT'] == $value['POD_DECMAT']): ?>
                                <tr>
                                    <td class="tengah data"><?php echo $no+1; ?></td>
                                    <td class="kiri data" nowrap><?php echo $val['PPI_DECMAT'] ?></td>
                                    <td class="tengah data"><?php echo $val['TIT_QUANTITY'] ?></td>
                                    <td class="tengah data"><?php echo $val['PPI_UOM'] ?></td>
                                    <td class="kanan data"><?php echo number_format($val['TIT_PRICE']) ?></td>
                                    <?php foreach ($vendor_code as $vnd): ?>
                                        <td class="kanan data">
                                            <?php
                                            if(isset($data['DATA']['ITEM'][$val['TIT_ID']][$vnd])){
                                            if(number_format($data['DATA']['ITEM'][$val['TIT_ID']][$vnd]) == "0"){
                                            echo number_format($data['DATA']['ITEM'][$val['TIT_ID']][$vnd]);
                                        } else {
                                        echo number_format($data['DATA']['ITEM'][$val['TIT_ID']][$vnd]);
                                    }
                                } else {
                                echo "-";
                            }
                            ?>
                        </td>
                    <?php endforeach ?>
                </tr>
                <?php $no++; endif ?>
            <?php endforeach ?>
        <?php endforeach ?>
    </tbody>
</table>
<?php elseif($data['NEGOSIASI'] == "2"): ?>
    <span style="display:block;padding-bottom:1px;font-size:9pt;">
        <?php echo $data['ROMAWI'] ?>. Undangan Auction: <?php if($data['NEGOSIASI'] == "3") echo date('d M Y H:i:s',$data['DATE']); else echo date('d M Y',$data['DATE']);  ?>
    </span>
    <table border="1" class="table table-bordered data">
        <tr>
            <td>
                <table>
                    <tr>
                        <td>Peserta Negosiasi :</td>
                    </tr>
                    <tr><td>&nbsp;</td></tr>
                    <?php
                    $vendor_name = array_unique($data['DATA']['VENDOR_NAME']);
                    $nvendor = count($vendor_name);
                    $half = (int)($nvendor / 2);
                    ?>
                    <?php if(($nvendor % 2) == 1): ?>
                        <?php for ($i=0; $i < $half ; $i++) { ?>
                        <tr>
                            <td>
                                <?php echo ($i+1).". ".$pesertavendor[$i]['VENDOR_NAME']; ?>
                            </td>
                            <td style="padding-left: 400px;">
                                <?php echo ($half+1+$i+1).". ".$pesertavendor[$half+$i]['VENDOR_NAME']; ?>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td class="col-md-6 kiri">
                                <?php echo ($half+1).". ".@$pesertavendor[$half+$i]['VENDOR_NAME']; ?>
                            </td>
                        </tr>
                    <?php else:?>
                        <?php for ($i=0; $i < $half ; $i++) { ?>
                        <tr>
                            <td>
                                <?php echo ($i+1).". ".$pesertavendor[$i]['VENDOR_NAME']; ?>
                            </td>
                            <td style="padding-left: 400px;">
                                <?php echo ($half+$i+1).". ".$pesertavendor[$half+$i]['VENDOR_NAME']; ?>
                            </td>
                        </tr>
                        <?php } ?>
                    <?php endif; ?>
                </table>                            
            </td>
        </tr>
    </table>
    <br/>
    <table class="table">
        <thead>
            <tr>
                <td height="45" class="kiri" colspan="5">
                    <span style="display:block;padding-bottom:1px;font-size:9pt;">
                        <?php echo $data['ROMAWI_II'] ?>. Rekap Auction: <?php echo date('d M Y',$data['DATA']['PAQH_AUC_END']); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td nowrap class="title tengah data" rowspan="3">No</td>
                <td nowrap class="title tengah data" rowspan="3">Nama Barang/Pekerjaan</td>
                <td nowrap class="title tengah data" rowspan="3">Qty</td>
                <td nowrap class="title tengah data" rowspan="3">UoM</td>
                <td nowrap class="title tengah data" rowspan="3">ECE<br>(Unit Price)</td>
                <td nowrap class="title tengah data" colspan="<?php echo count($vendor_name); ?>">Vendor / RFQ</td>
            </tr>
            <tr>
                <?php foreach ($vendor_name as $key => $value): ?>
                    <td nowrap class="title tengah data"><?php echo $value; ?></td>
                <?php endforeach ?>
            </tr>
            <tr>
                <?php foreach ($data['DATA']['ITEM'] as $key => $value): ?>
                    <td nowrap class="title tengah data"><?php echo $key; ?></td>
                <?php endforeach ?>
            </tr>
        </thead>
        <tbody>
            <?php $count = 1; ?>
            <?php $no=0; foreach ($data['M_ITEM'] as $id => $val): ?>
            <?php foreach ($item as $key => $value): ?>
                <?php if($val['PPI_DECMAT'] == $value['POD_DECMAT']): ?>
                    <tr>
                        <td class="tengah data"><?php echo $no+1; ?></td>
                        <td class="kiri data" nowrap><?php echo $val['PPI_DECMAT'] ?></td>
                        <td class="tengah data"><?php echo $val['TIT_QUANTITY'] ?></td>
                        <td class="tengah data"><?php echo $val['PPI_UOM'] ?></td>
                        <td class="kanan data"><?php echo number_format($val['TIT_PRICE']) ?></td>
                        <?php if($count == 1): ?>
                            <?php foreach ($data['DATA']['ITEM'] as $vnd): ?>
                                <td class="kanan data" rowspan="<?php echo count($data['DATA']['ITEM']) ?>">
                                    <?php 
                                    if(isset($data['DATA']['ITEM'])){
                                    echo number_format($vnd);
                                } else {
                                echo "-";
                            }
                            ?>
                        </td>
                    <?php endforeach ?>
                    <?php $count++; ?>
                <?php endif ?>
            </tr>
            <?php $no++; endif ?>
        <?php endforeach ?>
    <?php endforeach ?>
</tbody>
</table>
<?php elseif($data['NEGOSIASI'] == "3"): ?>
    <table class="table">
        <thead>
            <tr>
                <td height="45" class="kiri" colspan="6">
                    <span style="display:block;padding-bottom:1px;font-size:9pt;">
                        <?php echo $data['ROMAWI'] ?>. Revisi ECE: <?php if($data['NEGOSIASI'] == "3") echo date('d M Y H:i:s',$data['DATE']); else echo date('d M Y',$data['DATE']);  ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td nowrap class="title tengah data">No</td>
                <td nowrap class="title tengah data">Nama Barang/Pekerjaan</td>
                <td nowrap class="title tengah data">Qty</td>
                <td nowrap class="title tengah data">UoM</td>
                <td nowrap class="title tengah data">ECE<br>(Unit Price)</td>
                <td nowrap class="title tengah data">New ECE<br>(Unit Price)</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $id+1; ?></td>
                <td class="kiri data" nowrap><?php echo $data['M_ITEM'][$data['DATA']['TIT_ID']]['PPI_DECMAT'] ?></td>
                <td class="tengah data"><?php echo $data['M_ITEM'][$data['DATA']['TIT_ID']]['TIT_QUANTITY'] ?></td>
                <td class="tengah data"><?php echo $data['M_ITEM'][$data['DATA']['TIT_ID']]['PPI_UOM'] ?></td>
                <td class="kanan data"><?php echo number_format($data['DATA']['PRICE_BEFORE']) ?></td>
                <td class="kanan data"><?php echo number_format($data['DATA']['PRICE_AFTER']) ?></td>
            </tr>
        </tbody>
    </table>
<?php endif; ?>
<br/>
<?php endforeach; ?>
</div>
</body>
</html>