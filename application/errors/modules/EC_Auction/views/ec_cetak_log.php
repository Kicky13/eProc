<style type="text/css">
.Kanan{
    border-right:1px solid black;
}
.Kiri{
    border-left: 1px solid black;
}
.Bawah{
    border-bottom:1px solid black;
}
.Atas{
    border-top:1px solid black;
}
.pagebreak{
	page-break-before: always;
}
</style>
<head>
<title><?php echo $title ?></title>	
</head>
<body>
	<div style="width:700px;">
		<table style="width:100%;" >
			<tr>
				<th align="center"><h2>LOG AUCTION</h2></th>
			</tr>
			<tr>
				<td style="padding-top:-20px"><hr></hr></td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="0">
			<tr>
				<th align="center" class="Kiri Bawah Atas Kanan">No</th>
				<th align="center" class="Kiri Bawah Atas Kanan">Created at</th>
				<th align="center" class="Kiri Bawah Atas Kanan">Iter</th>
				<th align="center" class="Kiri Bawah Atas Kanan">Nama Vendor</th>
				<th align="center" class="Kiri Bawah Atas Kanan">Harga</th>
			</tr>
			<?php $no = 1; foreach ($Detail_Auction as $log){ ?>
			<tr>
				<td align="center" class="Kiri Bawah Atas Kanan"><?php echo $no++.'.'; ?></td>
				<td align="center" class="Kiri Bawah Atas Kanan"><?php echo $log['TGL']; ?></td>
				<td align="center" class="Kiri Bawah Atas Kanan"><?php echo $log['ITER']; ?></td>
				<td align="center" class="Kiri Bawah Atas Kanan"><?php echo $log['NAMA_VENDOR'].'('.$log['VENDOR_NO'].')'; ?></td>
				<td align="center" class="Kiri Bawah Atas Kanan"><?php echo $curr['CURR'] .' ' .number_format($log['PRICE']); ?></td>
			</tr>
			<?php } ?>
		</table>
	</div>	
</body>
