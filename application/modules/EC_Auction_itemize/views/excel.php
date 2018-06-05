<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Transaction Report</title>
</head>
<body>
	<table border="1">
		<tr>
			<th align="center" bgcolor="#ccccff" width="30" >No</th>
			<th align="center" bgcolor="#ccccff" width="30" >Kode_Item</th>
			<th align="center" bgcolor="#ccccff" width="30" >Deskripsi_Item</th>
			<th bgcolor="#ccccff" width="150" >Kuantiti</th>
			<th bgcolor="#ccccff" width="80" >Uom</th>
			<th bgcolor="#ccccff" width="200" >Currency</th>
			<th bgcolor="#ccccff" width="70" >Harga_Awal</th>
		</tr>
		<?php $no=1;
		foreach($data_vendor as $row){
			echo '<tr>';
			echo '<td width="30">'.$no.'</td>';
			echo '<td width="150" align="center">'.$row['ID_ITEM'].'</td>';
			echo '<td width="150" align="center">'.$row['NAMA_BARANG'].'</td>';
			echo '<td width="200">'.$row['JUMLAH'].'</td>';
			echo '<td width="200">'.$row['UNIT'].'</td>';
			echo '<td width="200">'.$row['CURR'].'</td>';
			echo '<td width="200">0</td>';
			echo '</tr>';
			$no++;
		}
		?>
	</table>
</body>
</html>