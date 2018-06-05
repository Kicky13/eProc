<style>
	.tooltip1 {
		position: relative;
		display: inline-block;
		border-bottom: 1px dotted black;
	}

	.tooltip1 .tooltiptext {
		visibility: hidden;
		width: 300px;
		background-color: #555;
		color: #fff;
		text-align: center;
		border-radius: 6px;
		padding: 5px 0;
		position: absolute;
		z-index: 1;
		bottom: 125%;
		left: 50%;
		margin-left: -150px;
	}

	.tooltip1 .tooltiptext::after {
		content: "";
		position: absolute;
		top: 100%;
		left: 50%;
		margin-left: -5px;
		border-width: 5px;
		border-style: solid;
		border-color: #555 transparent transparent transparent;
	}

	.tooltip1:hover .tooltiptext {
		visibility: visible;
	}
	.label{
		color: black;
	}
	.label-merah{
		background-color: #ff4545;
		color: white;
		/font-size: 12px;/
	}
	.label-kuning{
		background-color: #fef536;
		/font-size: 12px;/
	}
	.label-hijau{
		background-color: #49ff56;
		/font-size: 12px;/
	}
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
</style>
<head>
	<title><?php echo $title ?></title>	
</head>
<body>
	<div style="width:700px;">
		<table style="width:100%;" >
			<tr>
				<th align="center"><h2>Report</h2></th>
			</tr>
			<tr>
				<td style="padding-top:-20px"><hr></hr></td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="0">
			<thead>
				<tr>
					<th rowspan="2" class="col-md-1 Kiri Bawah Atas Kanan">No</th>
					<th rowspan="2" class="Kiri Bawah Atas Kanan">Kode Item</th>
					<th rowspan="2" class="Kiri Bawah Atas Kanan">Merk</th>
					<th rowspan="2" class="Kiri Bawah Atas Kanan">HPS</th>
					<th rowspan="2" class="Kiri Bawah Atas Kanan">Harga Ranking 1</th>
					<th rowspan="2" class="Kiri Bawah Atas Kanan">Prosentase</th>
					<th colspan="<?php echo count($Peserta);?>" class="Kiri Bawah Atas Kanan"><center>Ranking</center></th>
				</tr>
				<tr>
					<?php for ($i=0; $i < count($Peserta); $i++) {?>
					<th class="Kiri Bawah Atas Kanan"><?php echo ($i+1) ?></th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>

		<?php 
				$i=0;
				$persen_warning = 0;
				$persen_sukses =0;
				$harga = "";
				$MERK = "";
				foreach ($urutkanRanking as $UR) {	
					if($harga==""){
						$MERK = $UR['MERK'];
						$harga = $UR['CURRENCY']." ".number_format($UR['HARGATERKINI'],0,".",".");
						$persen = ($UR['BM_HB']/$value['HPS'])*100;
					}
		    		if($UR['HARGA']){ //jika tidak lolos
		    			$initialR = $UR['INITIAL'];
		    		} else {
		    			$initialR = '';
		    		}

		    		if($persen>100){
		    			$label = '<span class="label label-merah">'.number_format($persen,1,",",".").' %</span>';
		    			$persen_sukses = $persen_sukses+1;
		    		} else {
		    			$label = '<span class="label label-hijau">'.number_format($persen,1,",",".").' %</span>';
		    			$persen_warning = $persen_warning+1;
		    		} ?>

			    	<tr>
			    		<td align="center" class="Kiri Bawah Atas Kanan"><?php echo ++$i ?></td>
			    		<td align="center" class="Kiri Bawah Atas Kanan"><?php echo $dataItem['KODE_BARANG'] ?></td>
			    		<td align="center" class="Kiri Bawah Atas Kanan"><?php echo $MERK ?></td>
			    		<td align="center" class="Kiri Bawah Atas Kanan"><?php echo $dataItem['CURR']." ".number_format($dataItem['HPS'],0,".",".")?></td>
			    		<td align="center" class="Kiri Bawah Atas Kanan"><?php echo $harga ?></td>
			    		<td align="center" class="Kiri Bawah Atas Kanan"><?php echo $label ?></td>
			    		<td align="center" class="Kiri Bawah Atas Kanan"><?php echo $initialR ?></td>
			    	</tr>

			    	<?php } ?>

    </tbody>

</table>


<?php echo $tampil;?>

</div>	
</body>
