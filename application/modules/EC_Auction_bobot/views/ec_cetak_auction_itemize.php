<style type="text/css">
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
.pagebreak{
	page-break-before: always;
}
</style>
<head>
<title><?php echo $title ?></title>	
</head>
<div style="width:700px;">
	
<table style="width:100%;" >
	<!-- <tr>
		<th align="right"><?php echo "BA" . str_pad($Detail_Auction['NO_TENDER'], 8, "0", STR_PAD_LEFT); ?></th>
	</tr> -->
	<tr>
		<th align="center"><h2>BERITA ACARA E-AUCTION<p>Nomor:<?php echo "BA" . str_pad($Detail_Auction['NO_TENDER'], 8, "0", STR_PAD_LEFT); ?></p></h2></th>
	</tr>
	<tr>
		<td style="padding-top:-20px"><hr></hr></td>
	</tr>
</table>
<table style="width:100%;font-size: 12pt;" >
	<!-- <tr>
		<td width="200px">No. Tender</td>
		<td width="8px">:</td>
		<td></td>
	</tr> -->
	<tr>
		<td width="200px">No. Referensi</td>
		<td width="8px">:</td>
		<td><?php echo $Detail_Auction['NO_REF']; ?></td>
	</tr>
	<tr>
		<td>Deskripsi e-Auction</td>
		<td>:</td>
		<td><?php echo $Detail_Auction['DESC']; ?></td>
	</tr>
	<tr>
		<td>Tanggal Pembukaan</td>
		<td>:</td>
		<td><?php echo $Detail_Auction['PEMBUKAAN']; ?></td>
	</tr>
	<tr>
		<td>Tanggal Penutupan</td>
		<td>:</td>
		<td><?php echo $Detail_Auction['PENUTUPAN']; ?></td>
	</tr>
	<tr>
		<td>Tempat</td>
		<td>:</td>
		<td><?php echo $Detail_Auction['LOCATION']; ?></td>
	</tr>
	<tr>
		<td>Tipe Auction</td>
		<td>:</td>		
		<td><?php echo ($Detail_Auction['TIPE'] == 'T') ? 'Harga Total' : 'Harga Satuan';; ?></td>
	</tr>
	<tr>
		<td height="10px"></td>
	</tr>
	<tr>
		<td>Barang / Pekerjaan</td>
		<td>:</td>
		<td></td>
	</tr>
	<tr>
		<td colspan="3">
		<table width="100%">
			<tr>
				<th align="center">No</th>
				<th align="center">Kode Barang/Jasa</th>
				<th align="center">Nama Barang/Jasa</th>
				<th align="center">Kuantitas</th>
				<th align="center">UoM</th>
			</tr>
			<?php  $no = 1; foreach ($Itemlist as $item) { ?>
			<tr>
				<td align="center"><?php echo $no++.'.'; ?></td>
				<td align="center"><?php echo $item['KODE_BARANG']; ?></td>
				<td align="center"><?php echo $item['NAMA_BARANG']; ?></td>
				<td align="center"><?php echo $item['JUMLAH']; ?></td>
				<td align="center"><?php echo $item['UNIT']; ?></td>
			</tr>
			<?php } ?>
		</table>
		</td>
	</tr>
	<tr>
		<td height="10px"></td>
	</tr>
	<tr>
		<td colspan="3">Dalam pelaksanaan E-Auction Barang/Jasa seperti tersebut di atas, telah dihasilkan calon pemenang dengan urutan nominasi sebagai berikut :</td>
	</tr>
	<tr>
		<td colspan="3">
		<table width="100%">
			<tr>
				<th align="center">No</th>
				<th align="left">Nama Vendor</th>
				<th align="center">Mata Uang</th>
				<th align="center">Harga</th>
			</tr>
			<?php $no = 1; foreach ($Peserta as $vnd) { ?>
			<tr>
				<td align="center"><?php echo $no++.'.'; ?></td>
				<td align="left"><?php echo $vnd['NAMA_VENDOR']; ?></td>
				<td align="center"><?php echo $Detail_Auction['CURR']; ?></td>
				<td align="center"><?php echo number_format($vnd['HARGATERKINI']); ?></td>
			</tr>
			<?php } ?>
		</table>
		</td>
	</tr>
	<tr>
		<td height="10px"></td>
	</tr>
	<tr>
		<td colspan="3">Vendor yang mengundurkan diri sebagai berikut :</td>
	</tr>
	<tr>
		<td colspan="3">
		<?php if (!empty($undurdiri)) { ?>
		<table width="100%">
			<tr>
				<th align="center">No</th>
				<th align="left">Nama Vendor</th>
			</tr>
			<?php $no = 1; foreach ($undurdiri as $vnd) { ?>
			<tr>
				<td align="center"><?php echo $no++.'.'; ?></td>
				<td align="left"><?php echo $vnd['NAMA_VENDOR']; ?></td>
			</tr>
			<?php } ?>
			</table>
			<?php } else { ?>
				<div>
				TIDAK ADA	
				</div>
			<?php } ?>
		</td>
	</tr>
	<tr>
		<td colspan="3">Catatan :</td>
	</tr>
	<tr>
		<td colspan="3" height="50px"><?php echo $Detail_Auction['NOTE']; ?></td>
	</tr>
	<tr>
		<td colspan="3">Demikian Berita Acara ini dibuat untuk dapat dipergunakan seperlunya.</td>
	</tr>
	<tr>
		<td colspan="3" align="right"><?php 
			//$timestamp = $paqh['PAQH_AUC_END'];
			$date = date("d F Y", strtotime($tanggal));
			echo $date;
		?></td>
	</tr>
	<tr>
		<td><b><u>Rekanan :</u></b></td>
	</tr>
	<tr>
		<td colspan="3">
		<table width="100%" border="0" cellspacing="0">
			<tr>
				<th width="5px" class="Kiri Bawah Atas Kanan">No.</th>
				<th width="100px" class="Kiri Bawah Atas Kanan">Nama</th>
				<th width="160px" class="Kiri Bawah Atas Kanan">Instansi</th>
				<th width="50px" class="Kiri Bawah Atas Kanan">Tanda Tangan</th>
			</tr>
			<?php $no = 1; foreach ($Peserta as $vnd) { ?>
			<tr >
				<td align="center" class="Kiri Bawah Atas Kanan"><?php echo $no++; ?></td>
				<td class="Kiri Bawah Atas Kanan"></td>
				<td class="Kiri Bawah Atas Kanan">&nbsp;&nbsp;<?php echo $vnd['NAMA_VENDOR']; ?></td>
				<td height="30px" class="Kiri Bawah Atas Kanan"></td>
			</tr>
			<?php } ?>
		</table>
		</td>
	</tr>
	<tr>
		<td height="10px"></td>
	</tr>
	<tr>
		<td colspan="3"><b><u>Semen Indonesia Group :</u></b></td>
	</tr>
	<tr>
		<td colspan="3">
		<table width="100%" border="0" cellspacing="0">
			<tr>
				<th width="5px" class="Kiri Bawah Atas Kanan">No.</th>
				<th width="100px" class="Kiri Bawah Atas Kanan">Nama</th>
				<th width="160px" class="Kiri Bawah Atas Kanan">Unit Kerja / Instansi</th>
				<th width="50px" class="Kiri Bawah Atas Kanan">Tanda Tangan</th>
			</tr>
			<?php for ($i=1; $i <= 5 ; $i++) { ?>
			<tr>
				<td class="Kiri Bawah Atas Kanan">&nbsp;</td>
				<td class="Kiri Bawah Atas Kanan"></td>
				<td class="Kiri Bawah Atas Kanan"></td>
				<td height="30px" class="Kiri Bawah Atas Kanan"></td>
			</tr>
			<?php } ?>
		</table>
		</td>
	</tr>
</table>
</div>

<div style="width:700px;" class="pagebreak"></div>
<table style="width:100%;font-size: 12pt;" >
	<tr>
		<td align="right">Lampiran : 1</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><b>PAKTA INTEGRITAS PENYEDIA BARANG / JASA DALAM PELAKSANAAN E-AUCTION</b></td>
	</tr>
	<tr>
		<td style="padding-top:10px" align="justify">Pakta Integritas adalah pernyataan / janji tentang komitmen untuk melaksanakan segala tugas dan tanggung jawab sesuai dengan ketentuan yang berlaku, maka dengan ini kami menyatakan:</td>
	</tr>
	<tr>
		<td style="padding-top:10px" >
			<table>
				<tr>
					<td style="padding-left:20px" valign="top">1.</td>
					<td align="jstifuy">Tidak akan melakukan praktek KKN dengan panitia e-auction atau sesama Penyedia Barang dan Jasa dalam proses pelaksanaan e-auction.</td>
				</tr>
				<tr>
					<td style="padding-top:10px; padding-left:20px" valign="top">2.</td>
					<td style="padding-top:10px" align="justify">Sanggup memenuhi segala persyaratan pada peraturan Pengadaan Barang dan Jasa yang telah ditetapkan oleh PT. Semen Indonesia (Persero) Tbk serta peraturan perundang-undangan yang berlaku.</td>
				</tr>
				<tr>
					<td style="padding-top:10px; padding-left:20px" valign="top">3.</td>
					<td style="padding-top:10px" align="justify">Dalam proses pelaksanaan e-auction, berjanji untuk menyampaikan informasi yang benar dan dapat dipertanggung jawabkan serta melaksanakan tugas secara bersih, transparan, dan profesional dalam arti akan mengerahkan segala kemampuan dan sumber daya secara optimal untuk memberikan hasil kerja terbaik mulai dari pelaksanaan sampai dengan selesainya proses e-auction.</td>
				</tr>
				<tr>
					<td style="padding-top:10px; padding-left:20px" valign="top">4.</td> 
					<td style="padding-top:10px" align="justify">PT. Semen Indonesia (Persero) Tbk berhak untuk tidak mengundang Penyedia Barang dan Jasa apabila tidak dapat memenuhi atau tidak dapat menyelesaikan kewajibannya sesuai dengan ketentuan dalam "Dokumen Perikatan".</td>
				</tr>
				<tr>
					<td style="padding-top:10px; padding-left:20px" valign="top">5.</td>
					<td style="padding-top:10px" align="justify">Apabila di kemudian hari kami mengingkari pernyataan di atas atau ditemui bahwa keterangan/data yang kami berikan tidak benar, maka kami bersedia dituntut di muka pengadilan dan bersedia dikeluarkan dari Daftar Penyedia Barang dan Jasa serta dimasukkan.</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding-top:20px"><b>KETENTUAN PENGGUNAAN E-AUCTION OLEH PENYEDIA BARANG DAN JASA</b></td>
	</tr>
	<tr>
		<td style="padding-top:10px" align="justify">Setiap Penyedia Barang dan Jasa sebagai pengguna aplikasi E-Auction diatur oleh ketentuan yang telah dipersyaratkan di bawah ini.</td>
	</tr>
	<tr>
		<td style="padding-top:20px" >
			<table>
				<tr>
					<td>1.</td>
					<td><b>KETENTUAN UMUM</b></td>
				</tr>
				<tr>
					<td></td>
					<td style="padding-top:5px" >
						<table>
							<tr>
								<td style="padding-left:20px" valign="top">-</td>
								<td align="justify">Peserta e-auction adalah peserta yang sudah lulus evaluasi teknis / Spesifikasi.</td>
							</tr>
							<tr>
								<td style="padding-left:20px;" valign="top">-</td>
								<td align="justify">Jumlah yang dijinkan memasuki bilik maksimum 2 (dua) orang.</td>
							</tr>
							<tr>
								<td style="padding-left:20px;" valign="top">-</td>
								<td align="justify">Selama proses e-auction peserta dilarang mondar mandir.</td>
							</tr>
							<tr>
								<td style="padding-left:20px;" valign="top">-</td>
								<td align="justify">Waktu Pelaksanaan lebih kurang 10 (sepuluh) menit.</td>
							</tr>
							<tr>
								<td style="padding-left:20px;" valign="top">-</td>
								<td align="justify">Jumlah nilai 1 (satu) kali penurunan ditentukan atas kesepakatan peserta e-auction</td>
							</tr>
							<tr>
								<td style="padding-left:20px;" valign="top">-</td>
								<td align="justify">Harga referensi/Owner Estimate (OE) yang dipakai oleh panitia tidak diinformasikan kepada peserta.</td>
							</tr>
							<tr>
								<td style="padding-left:20px;" valign="top">-</td>
								<td align="justify">Pemasukan harga penawaran, disarankan tidak kurang dari 60 (enam puluh) detik sebelum closing, karena tidak dijamin oleh PT. Semen Indonesia (Persero) Tbk.</td>
							</tr>
							<tr>
								<td style="padding-left:20px;" valign="top">-</td>
								<td align="justify">Calon Pemenang adalah penawar terendah hasil e-auction</td>
							</tr>
							<tr>
								<td style="padding-left:20px;" valign="top">-</td>
								<td align="justify">Setiap Peserta wajib menandatangani berita acara e-auction</td>
							</tr>
							<tr>
								<td style="padding-left:20px;" valign="top">-</td>
								<td align="justify">Apabila tiba-tiba jaringan terputus, disepakati proses e-auction ditunda hingga jaringan normal</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding-top:20px" >
			<table>
				<tr>
					<td valign="top">2.</td>
					<td><b>PERSYARATAN PENYEDIA BARANG DAN JASA DALAM PELAKSANAAN E-AUCTION</b></td>
				</tr>
				<tr>
					<td></td>
					<td style="padding-top:5px" >
						<table>
							<tr>
								<td style="padding-left:20px" valign="top">-</td>
								<td valign="top">Harus berbadan hukum.</td>
							</tr>
							<tr>
								<td style="padding-left:20px" valign="top">-</td>
								<td valign="top">Harus melakukan registrasi online dengan data yang benar dan akurat, sesuai keadaan yang sebenarnya.</td>
							</tr>
							<tr>
								<td style="padding-left:20px" valign="top">-</td>
								<td valign="top">Wajib memperbaharui data-data perusahaan, jika tidak sesuai lagi dengan keadaan yang sebenarnya atau jika tidak sesuai dengan ketentuan ini.</td>
							</tr>
							<tr>
								<td style="padding-left:20px" valign="top">-</td>
								<td valign="top">Menyetujui bahwa transaksi melalui e-auction tidak boleh menyalahi peraturan perundang - undangan maupun asas sopan santun yang berlaku di Indonesia.</td>
							</tr>
							<tr>
								<td style="padding-left:20px" valign="top">-</td>
								<td valign="top">Menyadari bahwa usaha apapun untuk dapat menembus sistem komputer dengan tujuan PERUBAHAN KETENTUAN memanipulasi data E-Auction merupakan tindakan melanggar hukum.</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding-top:20px" >
			<table>
				<tr>
					<td valign="top">3.</td>
					<td><b>PERUBAHAN KETENTUAN</b></td>						
				</tr>
				<tr>
					<td></td>
					<td style="padding-top:5px" align="justify">PT. Semen Indonesia (Persero) Tbk dapat memperbaiki, menambah, atau mengurangi ketentuan ini setiap saat, dengan atau tanpa pemberitahuan sebelumnya. Setiap Penyedia Barang dan Jasa serta Panitia terikat dan tunduk kepada ketentuan yang telah diperbaiki/ditambah/dikurangi.</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="right" style="font-size:10pt; padding-top:30px"><i>Lampiran ini bagian yang tidak terpisahkan dengan Berita Acara e-Auction</i></td>
	</tr>
</table>
