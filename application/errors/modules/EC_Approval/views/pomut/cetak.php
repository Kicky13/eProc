<!DOCTYPE html>
<html>
<head>
	<title>Cetak BA Potongan Mutu</title>
</head>
<style type="text/css">
	
	table {
    	border-collapse: collapse;
	}

	td {padding: 3px;}
	span{margin: 30px;}

	tr.all-border td{
		border-top:2 solid black;
	}

	.border {width: 100%; border: 1; border-spacing: 7px;}

	.c{text-align: center;}
	.l{text-align: left;}
	.r{text-align: right;}
	.xsmall{font-size: 8px;}
	.small{font-size: 10px;}
	.medium{font-size: 12px;}
	.big{font-size: 18px;}
	.bold{font-weight: bold;}

</style>
<body>
<table border="0" width="100%">
	<tr>
		<td class="l small"><?php echo $company['nama'];?><td>
		<td class="r small">
			<!--Tanggal Cetak : <?php //echo date("Y-m-d H:i:s")?><br>
			Hal : {literal}{PAGENO}{/literal} dari {nbpg}-->
		<td>
	</tr>
	<tr>
		<td class="l xsmall"><?php echo 'Seksi Pengadaan Bahan';?><td>
		<td></td>
	</tr>
</table>
<?php $mnt = $bulan[date('n')-1]?>
<table border="0" width="100%">	
	<tr>
		<td width="100%" class="c">
			<span class="bold small">BERITA ACARA PERHITUNGAN ANALISA MUTU</span>
		<td>
	</tr>
	<tr>
		<td width="100%" class="c">
			<span class="small">No : <?php echo $no_ba;?></span>
		<td>
	</tr>
</table>
<br><br>
<span class="small"><?php echo "Pada hari ".$tgl_ba['hari']." tanggal ".$tgl_ba['tanggal']." bulan ".$tgl_ba['bulan']." tahun ".$tgl_ba['tahun']." (".$tgl_ba['tanggal_angka'].") telah diterima perhitungan analisa mutu" ?></span>
<br><br>
<table border="0" width="100%">
	<tr>
		<td width="3%"></td>
		<td width="10%"><span class="small">Nama Vendor </span></td>
		<td width="5%"><span class="c">:</span></td>
		<td width="25%"><span class="small"><?php echo $header['NAME1'];?></span></td>

		<td width="20%"></td>
		
		<td width="10%"><span class="small">No. Fax </span></td>
		<td width="5%"><span class="c">:</span></td>
		<td width="25%"><span class="small"><?php echo $header['TELFX'];?></span></td>
	</tr>
	<tr>
		<td width="3%"></td>
		<td width="10%"><span class="small">No OP / Plant</span></td>
		<td width="5%"><span class="c">:</span></td>
		<td width="25%"><span class="small"><?php echo $header['EBELN'].' / '.$header['WERKS'];?></span></td>

		<td width="20%"></td>
		
		<td width="10%"><span class="small">Tgl. Calculate</span></td>
		<td width="5%"><span class="c">:</span></td>
		<td width="25%"><span class="small"><?php echo stringDate($detail[0]['LAST_CAL_DATE']);?></span></td>
	</tr>
	<tr>
		<td width="3%"></td>
		<td width="10%"><span class="small">Pengiriman</span></td>
		<td width="5%"><span class="c">:</span></td>
		<td width="25%"><span class="small"><?php echo stringDate($delivery['TGL_FROM']).' - '.stringDate($delivery['TGL_TO']);?></span></td>

		<td width="20%"></td>
		
		<td width="10%"><span class="small">Tgl. UD</span></td>
		<td width="5%"><span class="c">:</span></td>
		<td width="25%"><span class="small"><?php echo stringDate($detail[0]['LAST_UD_DATE']);?></span></td>
	</tr>
	<tr>
		<td width="3%"></td>
		<td width="10%"><span class="small">Nama Bahan</span></td>
		<td width="5%"><span class="c">:</span></td>
		<td width="25%"><span class="small bold"><?php echo $header['MAKTX'];?></span></td>

		<td width="20%"></td>
		
		<td width="10%"><span class="small"></span></td>
		<td width="5%"><span class="c"></span></td>
		<td width="25%"><span class="small"></span></td>
	</tr>
</table>

<table border='1' class="small">
	<tr>
		<th rowspan="2">NO</th>
		<th rowspan="2">Insp. Lot / No. Gr</th>
		<th rowspan="2">Jumlah</th>
		<th rowspan="2">Harga Satuan</th>
		<th rowspan="2">Total Harga</th>
		<th colspan="3">Hasil Analisa</th>
		<th colspan="3">Jumlah Potongan</th>
		<th rowspan="2">Harga Satuan / Stl Potongan</th>
		<th rowspan="2">Jumlah Pembayaran</th>
		<th rowspan="2">Status</th>
	</tr>
	<tr>
		<th class="c"><?php echo $detail[0]['MIC1'] == NULL ? '-' : $detail[0]['MIC1'];?></th>
        <th class="c"><?php echo $detail[0]['MIC2'] == NULL ? '-' : $detail[0]['MIC2'];?></th>
        <th class="c"><?php echo $detail[0]['MIC3'] == NULL ? '-' : $detail[0]['MIC3'];?></th>
        <th class="c"><?php echo $detail[0]['MIC1'] == NULL ? '-' : $detail[0]['MIC1'];?></th>
        <th class="c"><?php echo $detail[0]['MIC2'] == NULL ? '-' : $detail[0]['MIC2'];?></th>
        <th class="c"><?php echo $detail[0]['MIC3'] == NULL ? '-' : $detail[0]['MIC3'];?></th>
	</tr>

	<?php
        $total_harga = 0;
        $total_Bayar = 0;
        $total_qty = 0;

        $no = 1;

        foreach($detail as $d){
            echo '<tr>
            	<td class="r">'.$no.'</td>
                <td class="r">'.$d['PRUEFLOS'].'/'.$d['MBLNR'].'</td>
                <td class="r">'.ribuan($d['LOTQTY']).'</td>
                <td class="r">'.ribuan($d['HARSAT']).'</td>
                <td class="r">'.ribuan($d['POVALUE']).'</td>
                <td class="r">'.$d['ORI_INPUT1'].'</td>
                <td class="r">'.$d['ORI_INPUT2'].'</td>
                <td class="r">'.$d['ORI_INPUT3'].'</td>
                <td class="r">'.ribuan($d['QLTDVALT1']).'</td>
                <td class="r">'.ribuan($d['QLTDVALT2']).'</td>
                <td class="r">'.ribuan($d['QLTDVALT3']).'</td>
                <td class="r">'.ribuan($d['POT']).'</td>
                <td class="r">'.ribuan($d['JML_BAYAR']).'</td>
                <td class="r">'.$d['KURZTEXT'].'</td>
             </tr>';
            $no++;
            $total_qty += $d['LOTQTY'];
            $total_harga += $d['POVALUE'];
            $total_Bayar += $d['JML_BAYAR'];
         }
    ?>
        <tr>
            <td></td>
            <td></td>
            <td class="r bold"><?php echo ribuan($total_qty); ?></td>
            <td></td>
            <td class="r bold"><?php echo ribuan($total_harga); ?></td>
            <td colspan="7"></td>
            <td class="r bold"><?php echo ribuan($total_Bayar); ?></td>
            <td></td>
        </tr>
</table>

<br><br><br>
<?php
if($header['POT_PPH'] != null){
	echo '<span class="small bold">'.$header['POT_PPH'].'</span><br>';
}
?>

<span class="bold small">Pot Mutu  = <?php echo ribuan($total_harga-$total_Bayar);?> </span> <br>
<span class="small">Note:</span> <br>
<span class="small"><?php echo 'V/- : Diterima dengan Potongan'?> </span> <br>

<table width="60%" class="xsmall">	
<?php

if($header['MIC1']!= null){
	echo "
		<tr>
			<td width='8%'>".$header['MIC1']."</td> 
			<td width='2%'></td> 
			<td width='15%'>".$header['MIC_DESC1']."</td> 
			<td width='8%' class='r'>".$header['ZCOND1']."</td> 
			<td width='15%'>".$header['QLTLMT1']."</td>
		</tr>";
}
if($header['MIC2']!= null){
	echo "
		<tr>
			<td width='8%'>".$header['MIC2']."</td> 
			<td width='2%'></td> 
			<td width='15%'>".$header['MIC_DESC2']."</td> 
			<td width='8%' class='r'>".$header['ZCOND2']."</td> 
			<td width='15%'>".$header['QLTLMT2']."</td>
		</tr>";
}
if($header['MIC3']!= null){
	echo "
		<tr>
			<td width='8%'>".$header['MIC3']."</td> 
			<td width='2%'></td> 
			<td width='15%'>".$header['MIC_DESC3']."</td> 
			<td width='8%' class='r'>".$header['ZCOND3']."</td> 
			<td width='15%'>".$header['QLTLMT3']."</td>
		</tr>";
}

foreach ($formula as $value) {
	echo "
		<tr>
			<td width='8%'>".$value['JENIS_FORMULA']."</td> 
			<td width='2%'> </td> 
			<td width='15%'>".$value['MKMNR']."</td> 
			<td width='18%'>".$value['OPERATOR']."</td> 
			<td width='15%'>".$value['FORMULA']."</td>
		</tr>";
}

?>

</table>
<br><br>
<span class="small">Harga bahan = _ </span><br>
<?php
if($header['KETR1'] != null){
	echo '<span class="small">'.$header['KETR1'].'</span><br>';
}
?>
<span class="small">Demikian berita acara ini dibuat dengan sebenarnya dan ditandatangani pada hari dan tanggal tersebut diatas</span><br>
<br><br><br>
<table width="100%">
	<tr>
		<td width="25%" class="small" ></td>
		<td width="45%" class="small" ></td>
		<td width="30%" class="small" ><?php echo $kota.', '.$tgl_ba['tanggal_lengkap'];?></td>
	</tr>
	<tr>
		<td width="25%" class="small" >Diterima</td>
		<td width="45%" class="small" ></td>
		<td width="30%" class="small" ><?php echo $company['nama'];?></td>
	</tr>
	<tr>
		<td width="25%" class="small" ><?php echo $header['NAME1'];?></td>
		<td width="45%" class="small" ></td>
		<td width="30%" class="small" >Yang Menyerahkan</td>
	</tr>
	<tr>
		<?php
			if ($header['STATUS'] > 2){
				echo '
				<td width="25%" class="small" >
					<barcode code=" APPROVED BY '.$header['VENDOR_APPROVED'].' - '.$header['NAME1'].' AT '.$header['VENDOR_APPROVED_AT2'].'" size="0.7" type="QR" error="M" class="barcode" />
				</td>
				';
			}else{
				echo '
				<td width="30%" class="small" height="50px"><strong>UNAPPROVED</strong></td>
				';
			}
			
			?>
		<td width="25%" class="small" > </td>
			<?php
			if ($header['STATUS'] > 1){
				echo '
				<td width="30%" class="small" >
					<barcode code=" APPROVED BY '.$header['APPROVED_BY'].' AT '.$header['APPROVED_AT2'].'" size="0.7" type="QR" error="M" class="barcode" />
				</td>
				';
			}else{
				echo '
				<td width="30%" class="small" height="50px"><strong>UNAPPROVED</strong></td>
				';
			}
			
			?>
			
	</tr>
	<tr>
		<td width="25%" class="small" >...................</td>
		<td width="45%" class="small" ></td>
		<td width="30%" class="small" ><?php echo $kasi;?></td>
	</tr>
	<tr>
		<td width="25%" class="small" ></td>
		<td width="45%" class="small" ></td>
		<td width="30%" class="small" >Kasi Pengadaan Barang</td>
	</tr>
</table>

<div class='small bold' style="margin-top:50px;"><strong>Berita Acara Perhitungan Analisa Mutu ini telah disetujui secara sistem atau elektronik sehingga tidak diperlukan tanda tangan basah sebagai pengesahan</strong></div>
</body>
</html>