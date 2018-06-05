<head>
	<title>Daftar Vendor <?php echo $opco;?></title>
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
		</tr>

		<tr>
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
		</tr>

		<tr>
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
		</tr>

		<tr>
			<th></th>
			<th></th>
			<th></th>
			<th colspan="3" align="center" class="judul"><strong>DAFTAR VENDOR <?php echo $opco;?></strong></th>
			<th></th>
		</tr>
		<tr>
			<th></th>
			<th></th>
			<th></th>
			<th colspan="3" align="center" class="child"><?php echo $alamat;?></th>
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
		</tr>
		<tr>
			<th width="30"></th>
			<th width="30"></th>
			<th width="30"></th>
			<th width="150"></th>
			<th width="80"></th>
			<th width="200"></th>
			<th width="70"></th>
		</tr>
	</table>
</div>
	<table class="tabel">
		<tr>
			<th class="thn" align="center" bgcolor="#ccccff" width="30" >No</th>
			<th class="thn" align="center" bgcolor="#ccccff" width="30" >Vendor No</th>
			<th class="thn" align="center" bgcolor="#ccccff" width="30" >Product Type</th>
			<th class="thn" bgcolor="#ccccff" width="150" >Vendor Name</th>
			<th class="thn" bgcolor="#ccccff" width="80" >Status Update Profile</th>
			<th class="thn" bgcolor="#ccccff" width="200" >Status Registrasi</th>
			<th class="thn" bgcolor="#ccccff" width="70" >Email</th>
		</tr>
		<?php $no=1;
			foreach($data_vendor as $row){
				$veno = $row['VENDOR_NO'];
				$vendor_no = "'".$veno;
				$bg=$no%2;
				if($bg==0){
					$bg=' bgcolor="#E1F0FF" ';
				} else {
					$bg=' bgcolor="#FFFFFF" ';
				}

		echo '<tr>';
			echo '<td class="tdn" '.$bg.' align="center" width="30">'.$no.'</td>';
			echo '<td class="tdn" '.$bg.' width="150" align="center" >'.$vendor_no.'</td>';
			echo '<td class="tdn" '.$bg.' width="150" align="center" >'.$produk_type.'</td>';
			echo '<td class="tdn" '.$bg.'  width="200" >'.$row['VENDOR_NAME'].'</td>';
					
			if (!empty($row['STATUS_PERUBAHAN'])) {
				
				$status_per = $row['STATUS_PERUBAHAN'];
				
				if ($status_per == "8"){
					echo '<td class="tdn" '.$bg.'  width="200" >Persetujuan New Update Profile</td>';
                } else if($status_per == "4") {
					echo '<td class="tdn" '.$bg.'  width="200" >Approve Update Profile Kasi</td>'; 
                } else if($status_per == "5"){
					echo '<td class="tdn" '.$bg.'  width="200" >Approve Update Profile Kabiro</td>';
                } else if($status_per == "9"){
					echo '<td class="tdn" '.$bg.'  width="200" >Update Data Ditolak</td>';
                } else if($status_per == "0"){
					echo '<td class="tdn" '.$bg.'  width="200" >Vendor Updated</td>';
                } else {
					echo '<td class="tdn" '.$bg.'  width="200" ></td>';
                }
			}else {
				echo '<td class="tdn" '.$bg.'  width="200" ></td>';
			} 
				$status = $row['STATUS'];
                if ($status == "1" || $status == "2"){
					echo '<td class="tdn" '.$bg.'  width="200" >New Registrasi</td>';
                } else if($status == "3") {
					echo '<td class="tdn" '.$bg.'  width="200" >Vendor Aktif</td>';
                } else if($status == "-1"){
					echo '<td class="tdn" '.$bg.'  width="200" >Registrasi Ditolak</td>';
                } else if($status == "99"){
					echo '<td class="tdn" '.$bg.'  width="200" >Dikembalikan ke Vendor</td>';
                } else if($status == "5"){
					echo '<td class="tdn" '.$bg.'  width="200" >Approve Registrasi Kasi Perencanaan</td>';
                } else if($status == "6"){
					echo '<td class="tdn" '.$bg.'  width="200" >Approve Registrasi Kasi Kabiro</td>';
                } else if($status == "7"){
					echo '<td class="tdn" '.$bg.'  width="200" >Approve New Registrasi Ditolak</td>';
                } else if($status == "0"){
					echo '<td class="tdn" '.$bg.'  width="200" >Registrasi Akun</td>';
                } else {
					echo '<td class="tdn" '.$bg.'  width="200" ></td>';
                }

                if (!empty($row['EMAIL_ADDRESS'])) {
					echo '<td class="tdn" '.$bg.'  width="200" >'.$row['EMAIL_ADDRESS'].'</td>';
                }else{
					echo '<td class="tdn" '.$bg.'  width="200" ></td>';
                }
				echo '</tr>';
				$no++;
			}
			?>
	</table>