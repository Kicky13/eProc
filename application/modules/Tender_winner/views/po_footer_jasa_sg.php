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
			</td>
			<td class="width-200"></td>
			<td style="font-size: 9px;" width="40%" class="text-left">
				Sesuai dengan ketentuan yang berlaku, PT. Semen Indonesia mengatur bahwa Perintah Kerja ini telah ditandatangani secara elektronik sehingga tidak diperlukan tanda tangan basah pada Perintah Kerja ini.
			</td>
		</tr>
	</table>
	<table class="">
		<tr>
			<td class="text-center text-top">

				<b>Disetujui Pemasok</b><br>
				nama & Jabatan  <br>                         
				<br>
				<br>
				<br>
				<table style="text-align: left !important;">
					<tr>
						<td style="font-size: 8px;" class="kiri atas kanan">
							Materai 6000
						</td>
					</tr>
					<tr>
						<td style="font-size: 8px;" class="kiri bawah kanan">
							ttd berstempel	
						</td>
					</tr>
				</table>
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
				<div class="side-right">
					<img src="<?php echo $qrpath ?>">
				</div>
				( <?php echo $approval['NAMA'] ?> )<br>
				<?php echo $approval['JABATAN'] ?> <br>


			</td>
		</tr>
	</table>
	<br>
	<table>
		<tr>
			<td style="font-size: 9px;" class="text-top">
				Office :
			</td>
			<td style="font-size: 9px;">
				- Gedung Utama Semen Indonesia, Jl. Veteran, Gresik 61122, Indonesia | T +62 31 3981731 | Fax +62 31 3972264, 3983209<br>
				- The East Tower lantai 18, Jl. DR Ide Anak Agung Gde Agung Kav. E.3.2 No.1, Jakarta-12950, Indonesia | T +62 21 5261174-5 | Fax
				+62 21 5261176
			</td>
		</tr>
	</table>
</div>