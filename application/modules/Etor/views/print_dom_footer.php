<style type="text/css">
	.approval { page-break-before: always; }
</style>
<div class="approval">
	<br>
	<br>
	<br>
	<table border="1" width="100%">
		<tr>
			<td width="15%">
				<center>
					<img class="logo_dark" width="60" height="60" src="<?php echo base_url(); ?>static/images/logo/semenindonesia.png" alt="Logo eProcurement PT. Semen Gresik Tbk.">
				</center>
			</td>
			<td width="55%">
				<center>

					PT. SEMEN INDONESIA (PERSERO) Tbk.
				</center>
			</td>
			<td width="30%"><img class="logo_dark" width="200" height="40" src="<?php echo base_url(); ?>static/images/logo/semen_indonesia_list.png" alt="Logo eProcurement PT. Semen Gresik Tbk."></td>
		</tr>
	</table>
	<table border="1" width="100%">
		<tr>
			<td colspan="3">Persetujuan</td>
		</tr>

		<tr>
			<td width="30%" style="vertical-align: text-top;">Dibuat Oleh,<br><?php echo $data_tor[0]['POS_NAME'] ?></td>
			<td width="30%" style="vertical-align: text-top;">Diperiksa Oleh,<br><?php echo $data_tor[1]['POS_NAME'] ?></td>
			<td width="30%" style="vertical-align: text-top;">Disetujui Oleh,<br><?php echo $data_tor[2]['POS_NAME'] ?></td>
		</tr>

		<tr>
			<td style="vertical-align: text-top;">
				Signature, <?php if($data_tor_appv[0]['APPROVED_AT']!="") echo Date("d-m-Y",oraclestrtotime($data_tor_appv[0]['APPROVED_AT'])) ?>
				<center>
					<br>
					<br>
					<br>
					<br>
					<?php echo $data_tor[0]['FULLNAME'] ?>
				</center>
			</td>
			<td style="vertical-align: text-top;">
				Signature, <?php 
				$jml_data 	= count($data_tor_appv);
				if($jml_data<2){
					$diperiksa 	= 0;
					$disetujui 	= 0;
				} else if($jml_data==2){
					$diperiksa 	= 0;
					$disetujui 	= 1;
				} else {
					// jml 3
					$diperiksa 	= $jml_data - 2; //3-2=1
					$disetujui 	= $jml_data - 1; //3-1=2
				}

				if($data_tor_appv[$diperiksa]['APPROVED_AT']!="") echo Date("d-m-Y",oraclestrtotime($data_tor_appv[$diperiksa]['APPROVED_AT'])) ?>
				<center>
					<br>
					<br>
					<?php 
					if($data_tor_appv[$diperiksa]['IS_APPROVE']!=""){
						echo "APPROVE";
					} 
					?>
					<br>
					<br>
					<?php echo $data_tor_appv[$diperiksa]['FULLNAME'] ?>
				</center>
			</td>
			<td style="vertical-align: text-top;">
				Signature, <?php
				if($data_tor_appv[$disetujui]['APPROVED_AT']!="") echo Date("d-m-Y",oraclestrtotime($data_tor_appv[$disetujui]['APPROVED_AT'])) ?>
				<center>
					<br>
					<br>
					<?php 
					if($data_tor_appv[$disetujui]['IS_APPROVE']!=""){
						echo "APPROVE";
					} 
					?>
					<br>
					<br>
					<?php echo $data_tor_appv[$disetujui]['FULLNAME'] ?>
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