		<section class="content_section">
			<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
					</div>
					<div class="row">
						<div class="col-md-12">
							<!-- <?php //if($this->session->flashdata('success')) { ?>
							<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<strong>Success!</strong> <?php //echo $this->session->flashdata('success'); ?>
							</div>
							<?php //} ?> -->
							<div class="panel panel-default">
								<div class="panel-heading">
									Tender Invitation
								</div>
								<div class="panel-body">
									<table class="table table-hover" id="negotiation_list">
										<thead>
											<tr>
												<th class="text-center">No</th>
												<th class="text-center">Tender Number</th>
												<th class="text-center">Subject of Work</th>
												<th class="text-center">Pembukaan Negosiasi</th>
												<th class="text-center">Penutupan Negosiasi</th>
												<!-- <th class="text-center" style="min-width: 120px">Status</th> -->
												<th class="text-center">Aksi</th>
											</tr>
										</thead>
										<tbody>
										<?php 
											for ($i=0; $i < sizeof($auction) ; $i++) {												
										 ?>
											<tr style="border-bottom: 1px solid #ccc;">
												<th class="text-center"><?php echo $i+1 ?></th>
												<th class="text-center"><?php echo $auction[$i]['NO_TENDER']?></th>
												<th class="text-center"><?php echo $auction[$i]['DESC']?></th>
												<th class="text-center"><?php echo $auction[$i]['PEMBUKAAN']?></th>
												<th class="text-center"><?php echo $auction[$i]['PENUTUPAN']?></th>
												<th class="text-center">
													<?php if($auction[$i]['STAT']=='1'){?>
													<a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>EC_Auction_bobot_negotiation/detail_auction/<?php echo $auction[$i]['NO_TENDER']?>">Process</a>
													<?php } else if($auction[$i]['STAT']=='2'){?>
													<button type="button" class="btn btn-danger btn-xs">
													  Mengundurkan Diri
													</button>
													<?php } else{ ?>
													<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-backdrop="static" data-target="#myModal">
													  Proses
													</button>	
													<?php } ?>
												</th>	
											</tr>
										<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title text-center" id="myModalLabel">Pakta Integritas dan Ketentuan E-AUCTION</h4>
		      </div>
		      <div class="modal-body">
		        <div class="row" style="max-height: 60vh;overflow-y: auto; margin-left: 5px;margin-top: 15px;margin-right: 15px;margin-bottom: 15px">
		        	<div class="col-md-12">
		        		<h5><strong>PAKTA INTEGRITAS PENYEDIA BARANG / JASA DALAM PELAKSANAAN E-AUCTION</strong></h5>
		        		<p>Pakta Integritas adalah pernyataan / janji tentang komitmen untuk melaksanakan segala tugas dan tanggung 
						jawab sesuai dengan ketentuan yang berlaku, maka dengan ini kami menyatakan:</p>
						<ol style="margin-left: 30px">
						  	<li>Tidak akan melakukan praktek KKN dengan panitia e-auction atau sesama Penyedia Barang dan 
								Jasa dalam proses pelaksanaan e-auction.</li>
							<li>
								Sanggup  memenuhi  segala  persyaratan  pada  peraturan  Pengadaan  Barang  dan  Jasa  yang  telah  
								ditetapkan  oleh  PT.  Semen  Indonesia  (Persero)  Tbk  serta  peraturan  perundang-undangan  yang  
								berlaku.</li>
							<li>
								Dalam proses pelaksanaan e-auction, berjanji untuk menyampaikan informasi yang benar dan dapat 
								dipertanggung jawabkan serta melaksanakan tugas secara bersih, transparan, dan profesional dalam 
								arti akan mengerahkan segala kemampuan dan sumber daya secara optimal untuk memberikan hasil 
								kerja terbaik mulai dari pelaksanaan sampai dengan selesainya proses e-auction.</li>
							<li>
								PT.  Semen  Indonesia  (Persero)  Tbk  berhak  untuk  tidak  mengundang  Penyedia  Barang  dan  Jasa  
								apabila   tidak   dapat   memenuhi   atau   tidak   dapat   menyelesaikan   kewajibannya   sesuai   dengan   
								ketentuan dalam "Dokumen Perikatan".</li>
							<li>
								Apabila di kemudian hari kami mengingkari pernyataan di atas atau ditemui bahwa keterangan/data 
								yang  kami  berikan  tidak  benar,  maka  kami  bersedia  dituntut  di  muka  pengadilan  dan  bersedia  
								dikeluarkan dari Daftar Penyedia Barang dan Jasa serta dimasukkan.</li>
						</ol>
		        	</div>
		        	<div class="col-md-12"><br />
		        		<h5><strong>KETENTUAN PENGGUNAAN E-AUCTION OLEH PENYEDIA BARANG DAN JASA</strong></h5>
		        		<p>Setiap  Penyedia  Barang  dan  Jasa  sebagai  pengguna  aplikasi  E-Auction  diatur  oleh  ketentuan  yang  telah  
						dipersyaratkan di bawah ini.</p>
						<ol style="margin-top: 10px;margin-left: 30px">
						  	<li> <strong>KETENTUAN UMUM</strong>
						  		<ul style="margin-left: 40px;list-style-type: square;" >
								 	<li>
										Peserta e-auction adalah peserta yang sudah lulus evaluasi teknis / Spesifikasi.</li>
									<li>
										Jumlah yang dijinkan memasuki bilik maksimum 2 (dua) orang.</li>
									<li>
										Selama proses e-auction peserta dilarang mondar mandir.</li>
									<li>
										Waktu Pelaksanaan lebih kurang 10 (sepuluh) menit.</li>
									<li>
										Jumlah nilai 1 (satu) kali penurunan ditentukan atas kesepakatan peserta e-auction</li>
									<li>
										Harga  referensi/Owner  Estimate  (OE)  yang  dipakai  oleh  panitia  tidak  diinformasikan  kepada  
										peserta.</li>
									<li>
										Pemasukan  harga  penawaran,  disarankan  tidak  kurang  dari  60  (enam  puluh)  detik  sebelum  
										closing, karena tidak dijamin oleh PT. Semen Indonesia (Persero) Tbk.</li>
									<li>
										Calon Pemenang adalah Nilai Total tertinggi hasil e-auction</li>
									<li>
										Setiap Peserta wajib menandatangani berita acara e-auction</li>
									<li>
										Apabila tiba-tiba jaringan terputus, disepakati proses e-auction ditunda hingga jaringan normal</li>
								</ul>
						  	</li>
						  	<li> <strong>PERSYARATAN PENYEDIA BARANG DAN JASA DALAM PELAKSANAAN E-AUCTION</strong>
						  		<ul style="margin-left: 40px;list-style-type: square;" >
								 	<li>
										Harus berbadan hukum.</li>
									<li>
										Harus melakukan registrasi online dengan data yang benar dan akurat, sesuai keadaan yang 
										sebenarnya.</li>
									<li>
										Wajib memperbaharui data-data perusahaan, jika tidak sesuai lagi dengan keadaan yang 
										sebenarnya atau jika tidak sesuai dengan ketentuan ini.</li>
									<li>
										Menyetujui bahwa transaksi melalui e-auction tidak boleh menyalahi peraturan perundang - 
										undangan maupun asas sopan santun yang berlaku di Indonesia.</li>
									<li>
										Menyadari bahwa usaha apapun untuk dapat menembus sistem komputer dengan tujuan 
										PERUBAHAN KETENTUAN memanipulasi data E-Auction merupakan tindakan melanggar hukum.</li>
								</ul>
						  	</li>	
						  	<li> <strong>PERSYARATAN PENYEDIA BARANG DAN JASA DALAM PELAKSANAAN E-AUCTION</strong>
						  		<p>PT.  Semen  Indonesia  (Persero)  Tbk  dapat  memperbaiki,  menambah,  atau  mengurangi  ketentuan  ini  
								setiap  saat,  dengan  atau  tanpa  pemberitahuan  sebelumnya.  Setiap  Penyedia  Barang  dan  Jasa  serta  
								Panitia terikat dan tunduk kepada ketentuan yang telah diperbaiki/ditambah/dikurangi.</p>
						  	</li>						 
						</ol>
		        	</div>
		        </div>
		      </div>
		      <div class="modal-footer">
		      	<p class="pull-left" ><input type="checkbox" id="setuju"/> Saya telah membaca Pakta Integritas dan Ketentuan E-Auction tersebut diatas.</p>
		      	<p></p><br />
		      	<form method="post" action="<?php echo base_url(); ?>EC_Auction_bobot_negotiation/setuju" >
		      		<input type="hidden" name="notender" value="<?php echo $auction[0]['NO_TENDER']?>" />
			      	<button type="submit" name="setuju" value="2" class="btn btn-danger stj" disabled  data-toggle="tooltip" data-placement="top" title="Mengundurkan Diri">Tidak Setuju</button>
			        <button type="submit" name="setuju" value="1" class="btn btn-primary stj" disabled>Setuju</button>
		        </form>
		        </div>
		    </div>
		  </div>
		</div>