<?php 
// echo "<pre>";
// print_r ($this->session->userdata('COMPANYID'));die;
// print_r($vnd_address);die;
// print_r($vendor);die;
// print_r($vnd);die;
// print_r($city);die;
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

</style>

<div>   
	<br>
	<br>
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
			<?php echo $ptv['VENDOR_NAME'] ?><br>
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
			<table>
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
							echo $value['ITEM_TEXT'];
							?>
						</td>
					</tr>
					<?php
				}
				?>
			</table>
		</div>
		<hr>
		<table>
			<tr>
				<td>
					<pre><?php echo $po['HEADER_TEXT'] ?></pre>
				</td>
			</tr>
		</table>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<div id="footer">
			<table class="setting_bold spasisijisetengah">
				<tr>
					<td>Tanggal Order</td>
					<td>:</td>
					<td><?php echo Date("d F Y",oraclestrtotime($po['DOC_DATE'])) ?> s/d <?php echo Date("d F Y",oraclestrtotime($po['DDATE'])) ?></td>
				</tr>
				<tr>
					<td>Lokasi</td>
					<td>:</td>
					<td> <?php echo $ppi['PPI_PLANT'] ?> /  <?php echo $ppi['PLANT_NAME'] ?> </td>
				</tr>
				<tr>
					<td>Harga Total</td>
					<td>:</td>
					<td>Rp. <?php echo number_format($total,2,",",".") ?>&nbsp;&nbsp;(Harga ini belum termasuk PPN)</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td><?php echo $terbilang ?> Rupiah</td>
				</tr>
				<tr>
					<td>NPWP</td>
					<td>:</td>
					<td>
						<?php if ($this->session->userdata('COMPANYID') == 2000) {?>
						01.001.631.9-051.000
						<?php } ?> &nbsp;&nbsp;<b>KETENTUAN UMUM (LIHAT DI BALIK HALAMAN INI)</b>
					</td>
				</tr>                
			</table>            
			<hr>
			<table class="">
				<tr>
					<td class="text-center text-top">

						<b>Disetujui Pemasok</b><br>
						nama & Jabatan  <br>                         
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						(
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						)
					</td>
					<td class="width-200"></td>
					<td class="text-center">

						<b>PT Semen Indonesia (Persero) Tbk.</b><br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						( <?php echo $approval['NAMA'] ?> )<br>
						<?php echo $approval['JABATAN'] ?> <br>


					</td>
				</tr>
			</table>
			<br>
			<br>
			<br>
			<br>
		</div>
	</div>
</div>