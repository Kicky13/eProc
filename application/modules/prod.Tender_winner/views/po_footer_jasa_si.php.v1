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