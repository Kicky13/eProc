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
        <div class="judul"><strong>LEMBAR PERSETUJUAN PENUNJUKAN PEMENANG</strong></div><br>
        <table>
            <tr>
                <td width="150px">No LP3</td>
                <td width="15px">:</td>
                <td><?php echo $po_header['LP3_NUMBER'] ?></td>
            </tr>
            <tr>
                <td>No Pratender</td>
                <td>:</td>
                <td><?php echo $PTM_PRATENDER ?></td>
            </tr>
            <tr>
                <td>Mekanisme Pengadaan</td>
                <td>:</td>
                <td><?php echo $PTP_JUSTIFICATION ?></td>
            </tr>
            <tr>
                <td>Lokasi</td>
                <td>:</td>
                <td><?php echo $PLANT." ".$PLANT_NAME ?></td>
            </tr>
            <tr>
                <td>Koordinator Anggaran</td>
                <td>:</td>
                <td><?php echo $PPR_REQUESTIONER." ".$LONG_DESC ?></td>
            </tr>
        </table>

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

        <table>
            <tr>
                <td width="100px">Delivery Time</td>
                <td width="15px">:</td>
                <td><?php echo day_difference(oraclestrtotime($po_header['PO_CREATED_AT']), oraclestrtotime($po_header['DDATE'])) ?> Hari</td>
            </tr>
            <tr>
                <td valign="top">Header Text</td>
                <td valign="top">:</td>
                <td valign="top"><?php echo nl2br(str_replace('  ', '&nbsp;&nbsp;&nbsp;', $po_header['HEADER_TEXT'])) ?></td>
            </tr>
            <tr>
                <td valign="top">Note</td>
                <td valign="top">:</td>
                <td valign="top">
                    <?php if(!empty($COMMENT)): 
                            foreach ($COMMENT as $key => $value): 
                                echo '- '.nl2br(str_replace('  ', '&nbsp;&nbsp;&nbsp;', $value['PHC_COMMENT'])); 
                                echo "<br>";
                            endforeach ;
                        endif ;
                    ?>
                </td>
            </tr>
        </table>

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
            <tr>
                <td height="20px"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>Gresik, <?php echo date('d-m-Y'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>Petugas,</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td valign="bottom" height="70px" width="150px"><?php echo $po_header['FULLNAME']; ?></td>
            </tr>
        </table>
    </div>
</body>
</html>