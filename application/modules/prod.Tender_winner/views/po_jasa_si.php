<?php 
// echo "<pre>";
// print_r ($this->session->userdata('COMPANYID'));die;
// print_r($vnd_address);die;
// print_r($vendor);die;
// print_r($vnd);die;
// print_r($city);die;
// print_r($ptm);die;
?>
<style>
	body,p,table td{
		font-size:8pt;
		/*font-family: Courier,verdana,arial;*/
		font-family: "Times New Roman", Times, serif;
	}
	table {
		border-collapse: collapse;
		width: 100%;
	}

	table.bordered tr td, table.bordered th {
		border: 1px solid black;
		font-size:8pt;
	}

	.border{
		border: 1px solid black;
	}

	.bordered td{
		border: 1px solid black;
		margin-left: 10px;
	}

	.tableheader{
		margin:100px;
	}
	.col-md-3{
		width:25%;
	}
	.vendorsupply{
		width:20%;
		position: relative;
		top: 50%;
		transform: translateY(-50%);
	}
	.item{
		width:6%;
	}

	.title p{
		font-size: 16pt;
		text-align: center;
	}

	.title2 p{
		font-size: 12pt;
		text-align: center;
	}

	.title{
		font-size: 16pt;
		text-align: center;
	}

	.title2{
		font-size: 12pt;
		text-align: center;
	}

	.title8px{
		font-size: 8pt;
	}

	.shorttext{
		width:25%;   
	}
	.text-center, .centered{
		text-align: center;
	}
	.text-top{
		vertical-align: top;
	}

	.text-right{
		text-align: right;
	}

	.text-left{
		text-align: left;
	}

	.side-right{
		margin-left: 500px;
		/*border: solid 1px black;*/
	}

	.side-left{
		margin-left: 0px;
		/*border: solid 1px black;*/
	}

	.middle-right{
		margin-left: 450px;
		/*border: solid 1px black;*/
	}

	.width-100{
		width: 100px;
	}

	.width-200{
		width: 200px;
	}

	.width-300{
		width: 300px;
	}

	.padding-100{
		padding-left: 100px;
	}

	.padding-200{
		padding-left: 200px;
	}

	.padding-300{
		padding-left: 300px;
	}

	.underline{
		text-decoration: underline;
	}

	.blok{
		display:inline;
	}

	.setting_bold{
		font-weight: bold;
	}

	.footer {
		position: absolute;
		right: 0;
		bottom: 0;
		left: 0;
		padding: 1rem;
		text-align: center;
	}

	.spasisijikurang{
		line-height: 0.5em;
	}

	.spasisiji{
		line-height: 1em;
	}

	.spasisijisetengah{
		line-height: 1.5em;
	}

	#footer {
		position: relative;
		margin-bottom: 90px;
		/*bottom: 1px !important;*/
		/* negative value of footer height */
		clear: both;
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
<img style="height: 60px;width: 65px;" class="logo_dark" src="https://eprocurement.semenindonesia.com/eproc/static/images/logo/semenindonesia.png" alt="Logo eProcurement PT. Semen Gresik">
<b>PT Semen Indonesia (Persero) Tbk.</b>
<div>   
	<br>
	<br>

	<div class="title">
		<strong class="underline">PERINTAH KERJA</strong><br>
	</div>
	<div class="title2">
		<b>No:<?php echo $po['PO_NUMBER'] ?></b>
	</div>    
	<hr>
	<div style="width: 50%;">
		<p class="text-left" ><b>KEPADA : </b><br>
			Yth.      
			<?php echo $vendorPrefix." ".$vendor['VENDOR_NAME'];//echo $ptv['VENDOR_NAME']; ?><br>
			<?php echo $npwp[0]['NPWP_ADDRESS'] ?><br>
			<?php echo $city[0]['NAMA'];//echo $npwp[0]['KOTA'] ?><br>
			<?php echo $prop[0]['NAMA'];//$npwp[0]['PROPINSI'] ?><br>
			<?php echo $npwp[0]['NPWP_POSTCODE'] ?><br>
			TELP: <?php 
			if($vendor['ADDRESS_PHONE_NO']!=""){
				echo $vendor['ADDRESS_PHONE_NO'];
			} else {
				echo $vnd_address[0]['TELEPHONE1_NO'];
			}
			?>
		</p>
	</div>
	<div>
		<table>
			<tr>
				<td class="width-300"></td>
				<td class="width-200">Kode <?php echo $ptv['PTV_VENDOR_CODE'] ?></td>
				<td class="text-right">
					<?php 
//echo $vendor['LOGIN_ID'];
					echo $po['PO_CREATED_BY'];
					?>

				</td>
			</tr>
		</table>

	</div>
	<hr>
	<div class="panel-body">

		<div class="col-md-12">
			<p class="no_margin_bottom setting_bold">
				URAIAN PEKERJAAN :
			</p>
			<table class="spasisiji">
				<!-- <table class="bordered"> -->
				<?php
                // $i=0;
				foreach ($item as $key => $value){
					?>
					<tr>
						<td class="text-left" width="5%"><?php echo $value['POD_QTY'] ?></td>
						<td class="text-left" width="20%"><?php echo $value['POD_NOMAT'] ?></td>
						<td class="text-left">
							<?php
                            // echo "INI JASA JUDUL".$value['POD_DECMAT'];
                            // echo "<br>";
                            //echo $value['POD_DECMAT'];
                            // $i++;
							echo $ppi['KTEXT1'];
							?>

						</td>
					</tr>
					<tr>
						<td></td>
						<td colspan="2">
							<?php
							// echo $value['POD_DECMAT'];
							if($po['PO_NUMBER']==6400003920){
								echo "<pre>".$value['ITEM_TEXT']."</pre>";
							} else {
								echo $value['ITEM_TEXT'];
							}
							?>
						</td>
					</tr>
					<?php
				}
				?>

				<?php
				if($this->session->userdata('COMPANYID')==5000){
					?>
					<tr>
						<td colspan="4">
							Nama Pengadaan : <?php echo $ptm['PTM_SUBJECT_OF_WORK']; ?>
						</td>
					</tr>
					<?php
				}
				?>

				<tr>
					<td colspan="4">
						<hr>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<?php
						if($po['PO_NUMBER']==6400003949 || $po['PO_NUMBER']==6400003952 || $po['PO_ID']>=170){
							?>
							<font size="14" style="line-height: 1.5em;">
								<?php echo html_entity_decode($po['HEADER_TEXT']) ?>
							</font>
							<?php
						} else {
							?>
							<pre><?php echo $po['HEADER_TEXT'] ?></pre>
							<?php
						}
						?>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>

<br><br>