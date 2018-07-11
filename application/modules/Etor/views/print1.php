<?php 
// echo "<pre>";
// print_r($data_tor);die;
?>
<style>
    .kecilkan{
        font-size:6pt;
        font-family: Courier,verdana,arial;
    }

    body,p,table td{
        font-size:8pt;
        font-family: Courier,verdana,arial;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }

    table.bordered tr td, table.bordered th {
        border: 1px solid black;
        font-size:8pt;
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

    .middle-center{
        margin-left: 25%;
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

    .width-200{
        width: 200px;
    }

    .height-100{
        height: 100px;
    }

    .height-200{
        height: 200px;
    }

    .height-300{
        height: 300px;
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

    .font16{
        font-size: 16px;
    }

    .font12{
        font-size: 8px;
    }

    .font14{
        font-size: 14px;
    }

    .kecil12{
        font-size: 12px;
    }

    .tebalkepala{
        border: 2px solid black;
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

<div class="daftarisi">
	<h2 class="text-center">DAFTAR ISI</h2><br>
	<table>
		<tr>
			<td colspan="2">DAFTAR ISI</td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td>1. </td>
			<td>LATAR BELAKANG</td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td>2. </td>
			<td>MAKSUD DAN TUJUAN</td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td>3 </td>
			<td>PENJELASAN SINGKAT APLIKASI</td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td>4. </td>
			<td>RUANG LINGKUP PEKERJAAN</td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td>5. </td>
			<td>PRODUK YANG DISERAHKAN</td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td>6. </td>
			<td>KUALIFIKASI PESERTA</td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td>7. </td>
			<td>TIME FRAME</td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td>8. </td>
			<td>PROSES PEMBAYARAN</td>
			<td></td>
			<td></td>
		</tr>
	</table>
	<br>
</div>


<div class="data" style="page-break-before: always;">
	<table>
		<tr>
			<td><b>1. </b></td>
			<td><b>LATAR BELAKANG</b></td>
		</tr>
		<tr>
			<td></td>
			<td><?php echo html_entity_decode($data_tor[0]['LATAR_BELAKANG']); ?></td>
		</tr>


		<tr>
			<td><b>2. </b></td>
			<td><b>MAKSUD DAN TUJUAN</b></td>
		</tr>
		<tr>
			<td></td>
			<td><?php echo html_entity_decode($data_tor[0]['MAKSUD_TUJUAN']); ?></td>
		</tr>


		<tr>
			<td><b>3. </b></td>
			<td><b>PENJELASAN SINGKAT APLIKASI</b></td>
		</tr>
		<tr>
			<td></td>
			<td><?php echo html_entity_decode($data_tor[0]['PENJELASAN_APP']); ?></td>
		</tr>


		<tr>
			<td><b>4. </b></td>
			<td><b>RUANG LINGKUP PEKERJAAN</b></td>
		</tr>
		<tr>
			<td></td>
			<td><?php echo html_entity_decode($data_tor[0]['RUANG_LINGKUP']); ?></td>
		</tr>


		<tr>
			<td><b>5. </b></td>
			<td><b>PRODUK YANG DISERAHKAN</b></td>
		</tr>
		<tr>
			<td></td>
			<td><?php echo html_entity_decode($data_tor[0]['PRODUK']); ?></td>
		</tr>


		<tr>
			<td><b>6. </b></td>
			<td><b>KUALIFIKASI PESERTA</b></td>
		</tr>
		<tr>
			<td></td>
			<td><?php echo html_entity_decode($data_tor[0]['KUALIFIKASI']); ?></td>
		</tr>


		<tr>
			<td><b>7. </b></td>
			<td><b>TIME FRAME</b></td>
		</tr>
		<tr>
			<td></td>
			<td><?php echo html_entity_decode($data_tor[0]['TIME_FRAME']); ?></td>
		</tr>


		<tr>
			<td><b>8. </b></td>
			<td><b>PROSES PEMBAYARAN</b></td>
		</tr>
		<tr>
			<td></td>
			<td><?php echo html_entity_decode($data_tor[0]['PROSES_BAYAR']); ?></td>
		</tr>
	</table>
</div>

<div class="approval" style="page-break-before: always;">
	<table border="1" width="100%">
		<tr>
			<td><img class="logo_dark" width="60" height="60" src="<?php echo base_url(); ?>static/images/logo/semenindonesia.png" alt="Logo eProcurement PT. Semen Gresik Tbk."></td>
			<td>
				<center>

					PT. SEMEN INDONESIA (PERSERO) Tbk.
				</center>
			</td>
			<td><img class="logo_dark" width="200" height="40" src="<?php echo base_url(); ?>static/images/logo/semen_indonesia_list.png" alt="Logo eProcurement PT. Semen Gresik Tbk."></td>
		</tr>
		<tr>
			<td colspan="3">Persetujuan</td>
		</tr>

		<tr>
			<td style="vertical-align: text-top;">Dibuat Oleh,<br><?php echo $data_tor[0]['POS_NAME'] ?></td>
			<td style="vertical-align: text-top;">Dibuat Oleh,<br><?php echo $data_tor[1]['POS_NAME'] ?></td>
			<td style="vertical-align: text-top;">Dibuat Oleh,<br><?php echo $data_tor[2]['POS_NAME'] ?></td>
		</tr>

		<tr>
			<td style="vertical-align: text-top;">
				Signature, <?php if($data_tor_appv[0]['APPROVED_AT']!="") echo Date("d-m-Y",oraclestrtotime($data_tor_appv[0]['APPROVED_AT'])) ?>
				<center>
					<br>
					<br>
					
					<?php 
					if($data_tor_appv[0]['IS_APPROVE']!=""){
						echo "APPROVE";
					} 
					?>
					<br>
					<br>
					<?php echo $data_tor_appv[0]['FULLNAME'] ?>
				</center>
			</td>
			<td style="vertical-align: text-top;">
				Signature, <?php if($data_tor_appv[1]['APPROVED_AT']!="") echo Date("d-m-Y",oraclestrtotime($data_tor_appv[1]['APPROVED_AT'])) ?>
				<center>
					<br>
					<br>
					<?php 
					if($data_tor_appv[1]['IS_APPROVE']!=""){
						echo "APPROVE";
					} 
					?>
					<br>
					<br>
					<?php echo $data_tor_appv[1]['FULLNAME'] ?>
				</center>
			</td>
			<td style="vertical-align: text-top;">
				Signature, <?php if($data_tor_appv[2]['APPROVED_AT']!="") echo Date("d-m-Y",oraclestrtotime($data_tor_appv[2]['APPROVED_AT'])) ?>
				<center>
					<br>
					<br>
					<?php 
					if($data_tor_appv[2]['IS_APPROVE']!=""){
						echo "APPROVE";
					} 
					?>
					<br>
					<br>
					<?php echo $data_tor_appv[2]['FULLNAME'] ?>
				</center>
			</td>
		</tr>
	</table>

	<?php
	// foreach ($data_tor as $key) {
	// 	echo $key['FULLNAME'];
	// }
	?>
</div>