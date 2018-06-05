<style type="text/css">
	.header{position:fixed;top:-30px;}
	.bawahgan{position:fixed;bottom:0px;}
</style>

<style type="text/css">
	.daftarisi { page-break-after: always; }
</style>
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
<div class="header">
	<table width="100%">
		<tr>
			<td class="text-right">
				<img class="logo_dark" width="100" height="20" src="http://int-eprocurement.semenindonesia.com/eproc/static/images/logo/semen_indonesia_list.png" alt="Logo eProcurement PT. Semen Gresik Tbk.">
				<br>
				<br>
				<br>
			</td>
		</tr>
	</table>
</div>

<div class="daftarisi">
	<br>
	<br>
	<br>
	<h2 class="text-center">DAFTAR ISI</h2><br>
	<table>
		<tr>
			<td colspan="2">DAFTAR ISI</td>
			<td></td>
			<td></td>
		</tr>

		<?php
		$i=1;
		for ($ulang=1;$ulang<8;$ulang++) {
			$judul = "";
			if($data_tor[0]['IS_SHOW1']==1 && $ulang==1){
				$judul = 'PENDAHULUAN';
			} else if($data_tor[0]['IS_SHOW2']==1 && $ulang==2){
				$judul = 'MAKSUD DAN TUJUAN';
			} else if($data_tor[0]['IS_SHOW3']==1 && $ulang==3){
				$judul = 'LINGKUP PEKERJAAN & SPESIFIKASI';
			} else if($data_tor[0]['IS_SHOW4']==1 && $ulang==4){
				$judul = 'WAKTU PELAKSANAAN';
			} else if($data_tor[0]['IS_SHOW5']==1 && $ulang==5){
				$judul = 'KRITERIA SDM';
			} else if($data_tor[0]['IS_SHOW6']==1 && $ulang==6){
				$judul = 'DELIVERABLE';
			} else if($data_tor[0]['IS_SHOW7']==1 && $ulang==7){
				$judul = 'KETENTUAN LAIN-LAIN';
			}

			if($judul!=""){
				if($i==1){
					$romawi = 'I';
				} else if($i==2){
					$romawi = 'II';
				} else if($i==3){
					$romawi = 'III';
				} else if($i==4){
					$romawi = 'IV';
				} else if($i==5){
					$romawi = 'V';
				} else if($i==6){
					$romawi = 'VI';
				} else if($i==7){
					$romawi = 'VII';
				}
				$i++;
				?>
				<tr>
					<td><?php echo $romawi; ?>.</td>
					<td><?php echo $judul; ?></td>
					<td></td>
					<td></td>
				</tr>
				<?php
			}
		}
		?>

<!-- 		<tr>
			<td>I. </td>
			<td>PENDAHULUAN</td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td>II. </td>
			<td>MAKSUD DAN TUJUAN</td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td>III </td>
			<td>LINGKUP PEKERJAAN & SPESIFIKASI</td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td>IV. </td>
			<td>WAKTU PELAKSANAAN</td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td>V. </td>
			<td>KRITERIA SDM</td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td>VI. </td>
			<td>DELIVERABLE</td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td>VII. </td>
			<td>KETENTUAN LAIN-LAIN</td>
			<td></td>
			<td></td>
		</tr> -->
	</table>
</div>


<div class="data">
	<br>
	<br>
	<br>
	<?php
	$i=1;
	for ($ulang=1;$ulang<8;$ulang++) {
		$judul = "";
		if($data_tor[0]['IS_SHOW1']==1 && $ulang==1){
			$judul = 'PENDAHULUAN';
			$isi = $data_tor[0]['LATAR_BELAKANG'];
		} else if($data_tor[0]['IS_SHOW2']==1 && $ulang==2){
			$judul = 'MAKSUD DAN TUJUAN';
			$isi = $data_tor[0]['MAKSUD_TUJUAN'];
		} else if($data_tor[0]['IS_SHOW3']==1 && $ulang==3){
			$judul = 'LINGKUP PEKERJAAN & SPESIFIKASI';
			$isi = $data_tor[0]['PENJELASAN_APP'];
		} else if($data_tor[0]['IS_SHOW4']==1 && $ulang==4){
			$judul = 'WAKTU PELAKSANAAN';
			$isi = $data_tor[0]['RUANG_LINGKUP'];
		} else if($data_tor[0]['IS_SHOW5']==1 && $ulang==5){
			$judul = 'KRITERIA SDM';
			$isi = $data_tor[0]['PRODUK'];
		} else if($data_tor[0]['IS_SHOW6']==1 && $ulang==6){
			$judul = 'DELIVERABLE';
			$isi = $data_tor[0]['KUALIFIKASI'];
		} else if($data_tor[0]['IS_SHOW7']==1 && $ulang==7){
			$judul = 'KETENTUAN LAIN-LAIN';
			$isi = $data_tor[0]['TIME_FRAME'];
		}

		if($judul!=""){
			if($i==1){
				$romawi = 'I';
			} else if($i==2){
				$romawi = 'II';
			} else if($i==3){
				$romawi = 'III';
			} else if($i==4){
				$romawi = 'IV';
			} else if($i==5){
				$romawi = 'V';
			} else if($i==6){
				$romawi = 'VI';
			} else if($i==7){
				$romawi = 'VII';
			}
			$i++;
			?>
			<table>
				<thead>
					<tr>
						<td><b><?php echo $romawi; ?>. </b></td>
						<td><b><?php echo $judul; ?></b></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
						<td><?php echo html_entity_decode($isi); ?></td>
					</tr>
				</tbody>
			</table>
			<?php
		}
	}
	?>
<!-- 	<table>
		<thead>
			<tr>
				<td><b>I. </b></td>
				<td><b>PENDAHULUAN</b></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td></td>
				<td><?php echo html_entity_decode($data_tor[0]['LATAR_BELAKANG']); ?></td>
			</tr>
		</tbody>
	</table>
	<table>
		<thead>
			<tr>
				<td><b>II. </b></td>
				<td><b>MAKSUD DAN TUJUAN</b></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td></td>
				<td><?php echo html_entity_decode($data_tor[0]['MAKSUD_TUJUAN']); ?></td>
			</tr>	
		</tbody>
	</table>
	<table>
		<thead>
			<tr>
				<td><b>III. </b></td>
				<td><b>LINGKUP PEKERJAAN & SPESIFIKASI</b></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td></td>
				<td><?php echo html_entity_decode($data_tor[0]['PENJELASAN_APP']); ?></td>
			</tr>
		</tbody>
	</table>
	<table>
		<thead>
			<tr>
				<td><b>IV. </b></td>
				<td><b>WAKTU PELAKSANAAN</b></td>
			</tr>	
		</thead>
		<tbody>
			<tr>
				<td></td>
				<td><?php echo html_entity_decode($data_tor[0]['RUANG_LINGKUP']); ?></td>
			</tr>		
		</tbody>
	</table>	
	<table>
		<thead>
			<tr>
				<td><b>V. </b></td>
				<td><b>KRITERIA SDM</b></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td></td>
				<td><?php echo html_entity_decode($data_tor[0]['PRODUK']); ?></td>
			</tr>
		</tbody>
	</table>
	<table>
		<thead>
			<tr>
				<td><b>VI. </b></td>
				<td><b>DELIVERABLE</b></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td></td>
				<td><?php echo html_entity_decode($data_tor[0]['KUALIFIKASI']); ?></td>
			</tr>
		</tbody>
	</table>
	<table>
		<thead>
			<tr>
				<td><b>VII. </b></td>
				<td><b>KETENTUAN LAIN-LAIN</b></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td></td>
				<td><?php echo html_entity_decode($data_tor[0]['TIME_FRAME']); ?></td>
			</tr>
		</tbody>
	</table> -->
</div>