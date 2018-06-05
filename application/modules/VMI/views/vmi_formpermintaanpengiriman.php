<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		table {border-collapse: collapse;}
		td    {padding: 6px;}
		.lowertext{
			font-size: small;
		}
	</style>
</head>
<body>
	<table border="0" style="width: 100%;" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td rowspan="2" align="center" width="100px">
					<img src="<?php echo site_url('static/images/logo/semenindonesia.png')?>" alt="" width="100px">
				</td>
			</tr>
			<tr>
				<td><strong>PT. SEMEN INDONESIA (PERSERO) Tbk</strong><br>Section of Inventory Planning</td>
			</tr>
	</table>
	<br>
	<br>
	<table  border="0" style="width: 100%;" align="center">
		<tr>
			<td align="center"><strong><u>PERMINTAAN PENGIRIMAN BARANG</u></strong></td>
		</tr>
		<tr>
			<td align="center">PO <?=$dataVendor['NO_PO']?> TAHUN <?=$dataVendor['TAHUN_CONTRACT']?></td>
		</tr>
		<tr>
			<td> Kepada :</td>
		</tr>
		<tr>
			<td><?=ucwords(strtolower($dataVendor['NAMA_VENDOR']))?><br>
				<?=$dataVendor['ADDRESS_STREET']." ".$dataVendor['ADDRESS_CITY']?>
				<br>
				<?=$dataVendor['ADDRESS_PHONE_NO']?>
			</td>
		</tr>
		<tr>
			<td><br>Dari: Seksi Perencanaan Persediaan</td>
		</tr>
		<tr>
			<td><em><strong>Perihal: Permintaan Pengiriman Barang</strong></em></td>
		</tr>
	</table>
	<br>
	<table  border="1" style="width: 100%" align="center">
		<thead>
			<tr style="background-color:#C0BCB6 ">
				<th>NO</th>
				<th>KODE MATERIAL</th>
				<th>NAMA BARANG</th>
				<th>JUMLAH</th>
				<th>NOMER PO</th>
				<th>SISA PO</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$i=1;
				foreach ($dataPengiriman as $key => $value) :?>
					<tr>
						<td><?=$i?></td>
						<td><?=$value['KODE_MATERIAL']?></td>
						<td><?=$value['NAMA_MATERIAL']?></td>
						<td><?=$value['QUANTITY']?></td>
						<td><?=$value['NO_PO']?></td>
						<td><?=$value['SISA_PO']?></td>
					</tr>
				<?php $i++;?>
				<?php endforeach;?>
		</tbody>
	</table>
	<br>
	<table  border="0" style="width: 100%;" align="center">
		<tr>
			<td>Demikian atas kerjasamanya, kami ucapkan Terima kasih.</td>
		</tr>
		<tr>
			<td><div class="lowertext"><strong>CATATAN : </strong></div></td>
		</tr>
		<tr>
			<td><div class="lowertext"> - Mohon pengiriman paling lambat 7 hari setelah surat ini diterima <br>
										- Sertakan bukti permintaan ini diwaktu pengiriman barang 
			</div></td>
		</tr>
	</table>
	<br>
	<br>
	<table border="0" align="right" style="margin-right: 5%;">
		<tr>
			<td align="center"><strong>Tuban, <?= date('d')." ".$month." ".date('Y')?></strong></td>
		</tr>
		<tr>
			<td>Kasi Perencanaan Persediaan</td>
		</tr>
		<tr>
			<td height="100px"></td>
		</tr>
		<tr>
			<td align="center"><strong>( Choliq Saifullah )</strong></td>
		</tr>
	</table>
</body>
</html>