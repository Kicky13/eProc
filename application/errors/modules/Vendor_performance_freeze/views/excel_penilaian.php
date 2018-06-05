<head>
	<title>Rekap Penilaian Vendor <?php echo $name_opco;?></title>
</head>
<style>
	body{
			font-family: Arial, Helvetica, sans-serif;
		}
		.tabel{
			width: 100%;
		    border: 1px solid black;
		    border-collapse: collapse;
		    margin-top: 7px;
		    margin-bottom: 7px;
			border-bottom: 1px solid black;
		    border-collapse: collapse;	
		}
		.thn{
			padding: 3px;
		    text-align: left;
		    font-size: 9pt;
			background-color:#dbdee5;
			font-size: 9pt;
			border-bottom: 1px solid black;
		    border-collapse: collapse;	
		}
		.tdn{
			padding: 3px;
		    text-align: left;
		    font-size: 9pt;
			border-bottom: 1px solid black;
		    border-collapse: collapse;
		}
		.data{
			border: 1px solid black;
			font-size: 7pt;
		}
		.container{
			margin-top: 1cm;
		}
		.judul{
			font-size: 12pt;
			font-weight: bold;
			text-align: center;
		    margin-bottom: 0px;

		}
		.child{
			font-size: 9pt;
			font-weight: bold;
			text-align: center;
			margin-top: 0px;
		}
		.tabel.no-border{
			display: table;
			margin-top: 10px;
			margin-bottom: 10px;
			width: 100%;
		}
		.tabel-row{
			display: table-row;
			
		}
		.img_nyo {
		    position:absolute;
		    top:20px;
		    left:380px;
		}
		td.title{
			background-color:#f0f1f4;
			text-align: center;
		}
		.mydiv{
		    position:relative
		    bottom:50px;
		    margin-bottom: 70px;
		}
</style>
<div class="container">
	<table style="width: 100%;">
		<tr>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th rowspan="4">
			<?php if ($idopco == '1') { ?>
				<img src="<?php echo base_url(); ?>static/images/logo/logo_sm_gresik.png">
			<?php } else if ($idopco == '2') { ?>
				<img src="<?php echo base_url(); ?>static/images/logo/logo_sm_padang.png">
			<?php } else if ($idopco == '3') { ?>
				<img src="<?php echo base_url(); ?>static/images/logo/logo_sm_tonasa.png">
			<?php } ?>
			</th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
		</tr>


		<tr>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
		</tr>

		<tr>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
		</tr>

		<tr>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
		</tr>

		<tr>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
		</tr>

		<tr>
			<th></th>
			<th colspan="7" align="center" class="judul"><strong>REKAP PENILAIAN VENDOR <?php echo $name_opco;?></strong></th>
			<th></th>
		</tr>

		<tr>
			<th></th>
			<th colspan="7" align="center" class="child"><?php echo $alamat;?></th>
			<th></th>
		</tr>

		
		<tr>
			<th width="30"></th>
			<th width="30"></th>
			<th width="200"></th>
			<th width="200"></th>
			<th width="300"></th>
			<th width="200"></th>
			<th width="200"></th>
			<th width="30"></th>
			<th width="30"></th>
		</tr>

	</table>
</div>
<div class="container">
	<table class="tabel">
		<tr>
		 	<th class="thn" colspan="2" align="center" bgcolor="#359AFF" width="30" >No</th>
			<th class="thn" colspan="2" align="center" bgcolor="#359AFF" width="200" >Vendor No</th>
			<th class="thn" bgcolor="#359AFF" width="300" >Vendor Name</th>
			<th class="thn" colspan="2" bgcolor="#359AFF" width="200" >Last Update</th>
			<th class="thn" colspan="2" bgcolor="#359AFF" width="30" >Poin</th>
		</tr>
	<?php $tbl=''; $no=1; foreach($data_his as $row){
			$bg=$no%2;
			$veno = $row['VENDOR_NO'];
			$vendor_no = "'".$veno;
			
			if($bg==0){$bg=' bgcolor="#E1F0FF" ';}else{$bg=' bgcolor="#FFFFFF" ';}
			$tbl.= '<tr>';
				$tbl.= '<td colspan="2" class="tdn" '.$bg.' align="center" width="30">'.$no.'</td>';
				$tbl.='<td colspan="2" class="tdn" '.$bg.' width="150" align="center" >'.$vendor_no.'</td>';
				$tbl.='<td class="tdn" '.$bg.' width="300" >'.$row['VENDOR_NAME'].'</td>';
				$tbl.='<td colspan="2" class="tdn" '.$bg.' align="center" width="200" >'.$row['DATE_CREATED'].'</td>';
				$tbl.='<td colspan="2" class="tdn" '.$bg.' align="center" width="80" >'.$row['POIN_CURR'].'</td>';
			$tbl.='</tr>';
			$no++;

			echo $tbl;
		}
	?>
	</table>
</div>