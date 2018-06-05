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
		    padding: 3px;
		    text-align: right;
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
<!-- page-break-after:always; -->
<body>
	<div class="container">
    <div class="judul"><strong>LEMBAR PERSETUJUAN PENUNJUKAN PEMENANG</strong></div><br>
        <div class="table no-border">
            <div class="table-row">
                <div class="cell" style="width: 150px;">No LP3</div>
                <div class="cell">: <?php echo $po_header['LP3_NUMBER'] ?></div>
            </div>
            <div class="table-row">
                <div class="cell" style="width: 150px;">No Pratender</div>
                <div class="cell">: <?php echo $PTM_PRATENDER ?></div>
            </div>
            <div class="table-row">
                <div class="cell" style="width: 150px;">Mekanisme Pengadaan</div>
                <div class="cell">: <?php echo $PTP_JUSTIFICATION ?></div>
            </div>
            <div class="table-row">
                <div class="cell" style="width: 150px;">Lokasi</div>
                <div class="cell">: <?php echo $PLANT." ".$PLANT_NAME ?></div>
            </div>
            <div class="table-row">
                <div class="cell" style="width: 150px;">Koordinator Anggaran</div>
                <div class="cell">: <?php echo $PPR_REQUESTIONER." ".$LONG_DESC ?></div>
            </div>
        </div>

        <span style="display:block;padding-bottom:1px;font-size:9pt;">Bersama ini kami paparkan usulan penunjukan pemenangan dari penawaran barang/jasa sebagai berikut :</span>

        <table>
            <thead>
                <tr>
                    <th class="title data" nowrap>Vendor Name</th>
                    <th class="title data" >Item</th>
                    <th class="title data" >No PR</th>
                    <th class="title data" >Nama Barang</th>
                    <th class="title data" >Qty</th>
                    <th class="title data" >UoM</th>
                    <th class="title data" >NetPrice</th>
                    <th class="title data" >NetValue</th>
                    <th class="title data" >Currency</td>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($item as $id => $val){ ?>
                <?php if($id == 0){ ?>
                <tr>
                    <td class="data kiri" rowspan="<?php echo count($item) ?>" nowrap><?php echo $po_header['VND_NAME'] ?></td>
                    <td class="data tengah"><?php echo $val['EBELP'] ?></td>
                    <td rowspan="<?php echo count($item) ?>" class="data tengah no_po"><?php echo $val['PPR_PRNO'] ?></td>
                    <td class="data kiri" nowrap><?php echo $val['POD_DECMAT'] ?><br><?php if(!is_null($val['ITEM_TEXT'])){?><i>Note: <?php echo $val['ITEM_TEXT'] ?></i><?php } ?></td>
                    <td class="data kanan"><?php echo $val['POD_QTY'] ?></td>
                    <td class="data tengah"><?php echo $val['UOM'] ?></td>
                    <td class="data kanan"><?php echo number_format($val['POD_PRICE'],2,",",".") ?></td>
                    <td class="data kanan"><?php echo number_format((intval($val['POD_PRICE']) * intval($val['POD_QTY'])),2,",",".") ?></td>
                    <td class="data tengah"><?php echo $val['CURR'] ?></td>
                </tr>
                <?php } else {?>
                <tr>
                    <td class="data tengah"><?php echo $val['EBELP'] ?></td>
                    <td class="data kiri" nowrap><?php echo $val['POD_DECMAT'] ?><br><?php if(!is_null($val['ITEM_TEXT'])){?><i>Note: <?php echo $val['ITEM_TEXT'] ?></i><?php } ?></td>
                    <td class="data kanan"><?php echo $val['POD_QTY'] ?></td>
                    <td class="data tengah"><?php echo $val['UOM'] ?></td>
                    <td class="data kanan"><?php echo number_format($val['POD_PRICE'],2,",",".") ?></td>
                    <td class="data kanan"><?php echo number_format((intval($val['POD_PRICE']) * intval($val['POD_QTY'])),2,",",".") ?></td>
                    <td class="data tengah"><?php echo $val['CURR'] ?></td>
                </tr>
                <?php } } ?>
                <tr>
                    <td class="data kanan" colspan="7"><strong>TOTAL</strong></td>
                    <td class="data kanan"><?php echo number_format($po_header['TOTAL_HARGA'],2,",",".") ?></td>
                    <td class="data tengah"><?php echo $val['CURR'] ?></td>
                </tr>
            </tbody>
        </table>

        <div class="table no-border">
            <div class="table-row">
                <div class="cell" style="width: 150px;">Delivery Time</div>
                <div class="cell">: <?php echo day_difference(oraclestrtotime($po_header['PO_CREATED_AT']), oraclestrtotime($po_header['DDATE'])) ?> Hari</div>
            </div>
            <div class="table-row">
                <div class="cell" style="width: 150px;">Header Text</div>
                <div class="cell">: <?php echo nl2br(str_replace('  ', '&nbsp;&nbsp;&nbsp;', $po_header['HEADER_TEXT'])) ?></div>
            </div>
            <div class="table-row">
                <div>
                    <textarea style="font-size:8pt;padding: 10px;">Note : <br><?php if(!empty($COMMENT)): ?><?php foreach ($COMMENT as $key => $value): ?><?php echo nl2br(str_replace('  ', '&nbsp;&nbsp;&nbsp;', $value['PHC_COMMENT'])); break;?><?php endforeach ?><?php endif ?></textarea>
                </div>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th height="15" class="title kiri data"><strong>Pejabat Berwenang</strong></th>
                    <th class="title tengah data"><strong>Paraf</strong></th>
                    <th class="title tengah data"><strong>Tanggal</strong></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($approval as $id => $val): ?>
                <tr>
                    <td height="35" class="kiri data"><?php echo $val['NAMA'] ?></td>
                    <td class="tengah data"></td>
                    <td class="tengah data"></td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>

        <span style="display:block;margin-left:75%;margin-top:50px;font-size:10pt;">Tonasa, <?php echo date('d-m-Y'); ?></span>
        <span style="display:block;margin-left:75%;font-size:10pt;">Petugas,</span><br><br><br>

        <span style="display:block;margin-left:75%;font-size:10pt; page-break-after:always;"><?php echo $po_header['FULLNAME']; ?></span>

		<div class="judul"><strong>Lampiran Kronologi Lembar Persetujuan Penunjukan Pemenang</strong></div>
		<p style="font-size:9pt;">I. Undangan Penawaran: <?php echo date('d M Y',strtotime($ptm['PTM_CREATED_DATE'])); ?> - <?php echo date('d M Y',$releaseComplete); ?></p>
        
        <table border="1" class="table table-bordered data">
            <tr>
                <td>
                        <div class="col-md-12 kiri">Peserta Tender :</div><br>
                        <?php
                            $nvendor = count($pesertavendor);
                            $half = (int)($nvendor / 2);
                        ?>
                        <?php if(($nvendor % 2) == 1){ ?>
                            <?php for ($i=0; $i < $half ; $i++) { ?>
                                <div class="col-md-6 kiri">
                                    <?php echo ($i+1).". ".$pesertavendor[$i]['VENDOR_NAME']; ?>
                                </div>
                                <div style="padding-left: 400px; padding-top: -15px" class="kiri">
                                    <?php echo ($half+1+$i+1).". ".$pesertavendor[$half+$i]['VENDOR_NAME']; ?>
                                </div>
                            <?php } ?>
                                <div class="col-md-6 kiri">
                                    <?php echo ($half+1).". ".@$pesertavendor[$half+$i]['VENDOR_NAME']; ?>
                                </div>
                        <?php  } else { ?>
                            <?php for ($i=0; $i < $half ; $i++) { ?>
                                <div class="col-md-6 kiri">
                                    <?php echo ($i+1).". ".$pesertavendor[$i]['VENDOR_NAME']; ?>
                                </div>
                                <div style="padding-left: 400px; padding-top: -15px" class="kiri">
                                    <?php echo ($half+$i+1).". ".$pesertavendor[$half+$i]['VENDOR_NAME']; ?>
                                </div>
                            <?php } ?>
                        <?php  } ?>
                </td>
            </tr>
        </table>

    <p style="font-size:9pt;">II. Rekap Penawaran Yang Respon: <?php echo ($verifikasiPenawaran!='')?date('d M Y',$verifikasiPenawaran):''; ?></p>
    <div class="row">
        <div class="table-responsive">
            <div class="col-md-12" style="margin-bottom: 1%">
                    <table class="table">
                        <thead>
                            <tr>
                                <td nowrap class="title tengah data" rowspan="3">No</td>
                                <td nowrap class="title tengah data" rowspan="3">Nama Barang</td>
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
                                            <?php foreach ($pesertavendor as $vnd): ?>
                                                <?php 
                                                    if(isset($ptqi[$val['TIT_ID']][$vnd['PTV_VENDOR_CODE']]['PQI_FINAL_PRICE'])){ ?>
                                                <td class="kanan data">
                                                     <?php   echo number_format($ptqi[$val['TIT_ID']][$vnd['PTV_VENDOR_CODE']]['PQI_PRICE']); ?>
                                                </td>
                                                    <?php } 
                                                ?>
                                            <?php endforeach ?>
                                        </tr>
                                    <?php $no++; endif ?>
                                <?php endforeach ?>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<!-- START EVATEK -->
        <p style="font-size:9pt;">III. Evaluasi Teknis: <?php echo date('d M Y',$appevatek); ?> - <?php echo date('d M Y',$appeval); ?></p>
        <div class="row">
            <div class="col-md-12" style="margin-bottom: 1%">
                <div class="panel panel-default">
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
                </div>
            </div>
        </div>
<!-- END EVATEK -->
<!-- START NEGO -->
        <?php foreach ($history as $nomor => $data): ?>
	        <?php if($data['NEGOSIASI'] == "1"){ ?>
		    	<p style="font-size:9pt;"><?php echo $data['ROMAWI'] ?>. Undangan Negosiasi: <?php if($data['NEGOSIASI'] == "3") echo date('d M Y H:i:s',$data['DATE']); else echo date('d M Y',$data['DATE']);  ?></p>
				<table class="table table-bordered data" style="margin-bottom: 1%">
		        	<tr>
		            	<td>
		                    <div class="kiri col-md-12">
		                        Peserta Negosiasai :
		                    </div>
		                    <?php
		                        $vendor_name = array_unique($data['DATA']['VENDOR_NAME']);
		                        $vendor_code = array_unique($data['DATA']['VENDOR_CODE']);
		                        $nvendor = count($vendor_name);
		                        $half = (int)($nvendor / 2);
		                    ?>

		                    <?php $no=1; foreach ($vendor_name as $vnd) { ?>
		                        <div class="kiri col-md-6">
		                            <?php echo $no++.". ".$vnd; ?>
		                        </div>
		                    <?php } ?>
                            <?php if(($nvendor % 2) == 1){ ?>
                                <?php for ($i=0; $i < $half ; $i++) { ?>
                                    <div class="col-md-6 kiri">
                                        <?php echo ($i+1).". ".$vendor_name[$i]; ?>
                                    </div>
                                    <div style="padding-left: 400px; padding-top: -15px" class="kiri">
                                        <?php echo ($half+1+$i+1).". ".$vendor_name[$half+$i]; ?>
                                    </div>
                                <?php } ?>
                                    <div class="col-md-6 kiri">
                                        <?php echo ($half+1).". ".@$vendor_name[$half+$i]; ?>
                                    </div>
                            <?php  } else { ?>
                                <?php for ($i=0; $i < $half ; $i++) { ?>
                                    <div class="col-md-6 kiri">
                                        <?php echo ($i+1).". ".$vendor_name[$i]; ?>
                                    </div>
                                    <div style="padding-left: 400px; padding-top: -15px" class="kiri">
                                        <?php echo ($half+$i+1).". ".$pesertavendor[$half+$i]; ?>
                                    </div>
                                <?php } ?>
                            <?php  } ?>
		                </td>
		            </tr>
		        </table>
                <div class="row">
                    <div class="col-md-12" style="margin-bottom: 1%">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <td height="45" class="kiri" colspan="8">
                                        <p style="font-size:9pt;"><?php echo $data['ROMAWI_II'] ?>. Rekap Negosiasi: <?php echo date('d M Y',$data['DATA']['NEGO_END']); ?></p>
                                    </td>
                                </tr>
                                    <tr>
                                        <td nowrap class="title tengah data" rowspan="3">No</td>
                                        <td nowrap class="title tengah data" rowspan="3">Nama Barang</td>
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
                        </div>
                    </div>
                </div>
        	<?php } else if($data['NEGOSIASI'] == "2"){ ?>
            <table class="table" style="margin-bottom: 1%">
                <tr>
                    <td height="45" class="kiri" colspan="">
        	<p style="font-size:9pt;"><?php echo $data['ROMAWI'] ?>. Undangan Auction: <?php if($data['NEGOSIASI'] == "3") echo date('d M Y H:i:s',$data['DATE']); else echo date('d M Y',$data['DATE']);  ?></p>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="kiri">
                            Peserta Negosiasi:
                        </div>
                        <div class="kiri">
                            <?php
                                $vendor_name = array_unique($data['DATA']['VENDOR_NAME']);
                                $nvendor = count($vendor_name);
                                $half = (int)($nvendor / 2);
                            ?>
                            <?php $no=1; foreach ($vendor_name as $vnd) { ?>
                                <div class="kiri">
                                    <?php echo $no++.". ".$vnd; ?>
                                </div>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="row">
                <div class="col-md-12" style="margin-bottom: 1%">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td height="45" class="kiri" colspan="5">
            <p style="font-size:9pt;"><?php echo $data['ROMAWI_II'] ?>. Rekap Auction: <?php echo date('d M Y',$data['DATA']['PAQH_AUC_END']); ?></p>

                                    </td>
                                </tr>
                                <tr>
                                    <td nowrap class="title tengah data" rowspan="3">No</td>
                                    <td nowrap class="title tengah data" rowspan="3">Nama Barang</td>
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
                    </div>
                </div>
            </div>
            <?php } else if($data['NEGOSIASI'] == "3"){ ?>
                 <div class="row">
                    <div class="col-md-12" style="margin-bottom: 1%">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td height="45" class="kiri" colspan="6">
            <p style="font-size:9pt;"><?php echo $data['ROMAWI'] ?>. Revisi ECE: <?php if($data['NEGOSIASI'] == "3") echo date('d M Y H:i:s',$data['DATE']); else echo date('d M Y',$data['DATE']);  ?></p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td nowrap class="title tengah data">No</td>
                                        <td nowrap class="title tengah data">Nama Barang</td>
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
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php endforeach ?>
<!-- END NEGO -->
	</div>
</body>
</html>