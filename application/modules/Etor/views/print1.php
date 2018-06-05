<?php 
// echo "<pre>";
// print_r($data_tor);die;
?>

<style type="text/css">

	.text-right{
		text-align: right;
	}

	.text-center{
		text-align: center;
	}

	.equalDivide tr td { width:33%; }
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