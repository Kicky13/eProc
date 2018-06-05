<!DOCTYPE html>
<html>
<head>
	<title>Rekap Penawaran</title>
	<style>
		body{
			font-family: Arial, Helvetica, sans-serif;
		}
		table{
			width: 100%;
		    border: 1px solid black;
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
			border-bottom: 1px solid black;
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
		.table.no-border{
			display: table;
			margin-top: 10px;
			margin-bottom: 10px;
			width: 100%;
		}
		.table-row{
			display: table-row;
			
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

		.cell.border: {
			border: 1px solid black;
			padding: 15px;
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
		.kiri.enter{
			padding: 15px;
		}

	</style>
</head>
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
                    <td class="kanan" colspan="7"><strong>TOTAL</strong></td>
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
					<th class="title kiri data enter"><strong>Pejabat Berwenang</strong></th>
					<th class="title tengah data enter"><strong>Paraf</strong></th>
					<th class="title tengah data enter"><strong>Tanggal</strong></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($approval as $id => $val): ?>
				<tr>
					<td class="kiri data enter"><?php echo $val['NAMA'] ?></td>
					<td class="tengah data enter"></td>
					<td class="tengah data enter"></td>
				</tr>
            <?php endforeach ?>
			</tbody>
		</table>

		<span style="display:block;margin-left:75%;margin-top:50px;font-size:10pt;">Gresik, <?php echo date('d-m-Y'); ?></span>
		<span style="display:block;margin-left:75%;font-size:10pt;">Petugas,</span><br><br><br>

		<span style="display:block;margin-left:75%;font-size:10pt;"><?php echo $this->session->userdata('FULLNAME');?></span>
		<!-- Page Break -->

	</div>