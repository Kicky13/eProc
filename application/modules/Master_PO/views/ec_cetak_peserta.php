<style>
	tr{
		margin: 5px; 
		padding: 10px; 
	}
	td{
		padding: 10px; 
	}
</style>
<head>
<title><?php echo $title ?></title>	
</head>

<body>
	<div style="width:700px;"> 
	<table style="width:100%;">
	<!-- <?php //$no = 1; foreach ($Peserta as $vnd) { ?> -->
		<tr>
		<?php $no = 0; foreach ($Peserta as $vnd) {
			 if ($no%3==0 && $no!=0) 
			 	echo '</tr>';
			 if ($no%3==0 || $no==0) 
			 	echo '<tr>';
			 ?>
			<td style="border-bottom: 2px dashed #ccc;border-left: 2px dashed #ccc;"><strong><?php echo $vnd['NAMA_VENDOR']; ?></strong>
			<br>
			Username : <strong><?php echo $vnd['USERID']; ?></strong>
			<br>
			Password &nbsp;: <strong><?php echo $vnd['PASS']; ?></strong>
			</td>		
			<?php $no++; } ?>
		</tr>
		<!-- <tr>
			<td><hr></td>
		</tr> -->
	<!-- <?php //} ?> -->
	</table>
	</div>
</body>