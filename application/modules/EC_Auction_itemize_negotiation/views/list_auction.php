<!-- <style>
	.swal-wide{
    	width:850px ;
    	align-content: center;
	}

	.sweet-alert1 { margin: auto; transform: translateY(-50%) !important; }
	.sweet-alert1.sweetalert1-lg { width: 850px !important; }
</style> -->

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
												<th class="text-center">Jumlah Batch</th>
												<!-- <th class="text-center">Penutupan Negosiasi</th> -->
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
												<th class="text-center"><?php echo $auction[$i]['HITUNG_BATCH']?></th>
												<!-- <th class="text-center"><?php echo $auction[$i]['PENUTUPAN']?></th> -->
												<th class="text-center">
													<?php if($auction[$i]['STAT']=='1'){?>
													<a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>EC_Auction_itemize_negotiation/indexBatch/<?php echo $auction[$i]['NO_TENDER']?>">Process</a>
													<?php } else if($auction[$i]['STAT']=='2'){?>
													<button type="button" class="btn btn-danger btn-xs">
													  Mengundurkan Diri
													</button>
													<?php } else{ ?>
													<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-backdrop="static" data-target="#myModal">
													  Lanjut
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
		        <h4 class="modal-title text-center" id="myModalLabel">KETENTUAN PENGGUNAAN E-AUCTION OLEH PENYEDIA BARANG DAN JASA</h4>
		      </div>
		      <div class="modal-body">
		        <div class="row" style="max-height: 60vh;overflow-y: auto; margin-left: 5px;margin-top: 15px;margin-right: 15px;margin-bottom: 15px">
		        	<!-- <div class="col-md-12">
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
		        	</div> -->
		        	<div class="col-md-12"><br />
		        		<!-- <h5><strong>KETENTUAN PENGGUNAAN E-AUCTION OLEH PENYEDIA BARANG DAN JASA</strong></h5> -->
		        		<p>Setiap  Penyedia  Barang  dan  Jasa  sebagai  pengguna  aplikasi  <i>e-Auction</i>  diatur  oleh  ketentuan  yang  telah  
						dipersyaratkan di bawah ini.</p>
						<ol style="margin-top: 10px;margin-left: 30px">
						  	 <strong>KETENTUAN UMUM</strong>
						  		<ul style="margin-left: 40px;list-style-type: decimal;" >
								 	<li>
										Forum <i>e-Auction</i> ini diselenggarakan untuk mendapatkan nominasi ranking calon pemenang dengan harga terbaik.</li>
								 	<li>
										Peserta <i>e-Auction</i> adalah calon penyedia barang/jasa dengan item barang/jasa yang sudah lulus evaluasi teknis.</li>
									<li>
										Peserta <i>e-Auction</i> dilarang melakukan hal - hal yang mengganggu peserta lain atau menghambat proses <i>e-Auction</i>.</li>
									<li>
										Harga Perkiraan Sendiri (HPS) yang telah ditetapkan oleh PT Semen Indonesia (Persero) Tbk tidak diumumkan/diberitahukan kepada peserta <i>e-Auction</i>.</li>
									<li>
										Harga yang diinputkan pada <i>e-Auction</i> harus lebih rendah atau sama dengan harga penawaran awal.</li>
									<li>
										Penentuan calon penyedia barang/jasa ranking pertama dan seterusnya didasarkan atas harga terendah berturut turut sampai dengan harga tertinggi.</li>
									<li>
										Dalam hal terdapat calon Penyedia barang/jasa yang bermaksud mengundurkan diri maka berlaku ketentuan sebagai berikut :
										<ul style="margin-left: 40px;list-style-type: upper-alpha;" >
											<li>
												Pengunduran diri dilakukan sebelum proses <i>e-Auction</i> dimulai, maka calon Penyedia barang/jasa melakukan hal-hal sebagai berikut : 
												<ul style="margin-left: 40px;list-style-type: disc;" >
												<li>
													Pengunduran diri atas semua item calon penyedia barang/jasa, <strong>cukup pilih tidak setuju pada halaman ini.</strong></li>
												<li>
													Pengunduran diri atas beberapa item calon penyedia barang/jasa melaporkan kepada petugas, atas item - item yang dimaksud dengan terlebih dahulu mengisi form pernyataan mengundurkan diri yang telah disiapkan oleh PT Semen Indonesia (Persero) Tbk.</li>
												</ul>
												</li>
											<li>
												Pengunduran diri dilakukan setelah proses <i>e-Auction</i> / penetapan ranking calon penyedia barang/jasa selesai, maka calon penyedia barang/jasa tersebut harus menyampaikan <strong>surat pernyataan resmi yang ditandangani oleh pimpinan perusahaan diatas materai senilai 6000 yang dapat diterima oleh PT Semen Indonesia (Persero) Tbk dalam waktu yang akan ditetapkan kemudian.</strong></li><br>
													<p>Calon penyedia barang/jasa yang <strong>mengundurkan diri setelah proses e-auction / penetapan ranking calon penyedia barang/jasa selesai</strong> tersebut <strong>akan tidak diundang lagi sesuai peraturan yang berlaku di PT Semen Indonesia (Persero) Tbk.</strong></p>
										</ul>
									</li>
									<li>
										Hasil <i>e-Auction</i>, selanjutnya akan dilakukan evaluasi atau penilaian kewajaran harga oleh PT Semen Indonesia (Persero) Tbk yang merupakan satu kesatuan aktivitas dari proses ini sebagai dasar tahapan tender selanjutnya.</li>
									<li>
										Nominasi ranking pertama penyedia barang/jasa atas hasil e-auction merupakan calon pemenang dan dapat dilakukan negosiasi ulang.</li><br>
										<p>Apabila setelah dilakukan negosiasi ulang kepada calon penyedia barang/jasa ranking pertama masih belum sesuai dengan harga yang dipersyaratkan PT Semen Indonesia (Persero) Tbk maka, calon pemenang beralih kepada calon penyedia barang/jasa ranking selanjutnya dan dapat dilakukan negosiasi ulang.</p>
									<li>
										Apabila ditemukan harga tidak wajar atas item tertentu dari calon penyedia barang/jasa maka calon penyedia barang/jasa dinyatatakan gugur atas item itu.</li>
									<li>
										Harga hasil negosiasi yang diinputkan pada saat proses <i>e-Auction</i> berlangsung namun harga tersebut tidak tercantum dalam database sistem <i>e-Auction</i> maka, harga yang diakui adalah harga yang tercantum dalam database sistem <i>e-Auction</i></li>
									<li>
										Apabila tiba-tiba jaringan terputus, disepakati proses <i>e-Auction</i> ditunda hingga jaringan kembali normal</li>
								</ul>
						  	
						  	<!-- <li> <strong>PERSYARATAN PENYEDIA BARANG DAN JASA DALAM PELAKSANAAN E-AUCTION</strong>
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
						  	</li> -->						 
						</ol>
		        	</div>
		        </div>
		      </div>
		      <div class="modal-footer">
		      	<p class="pull-left" ><input type="checkbox" id="setuju"/> Saya telah membaca dan memahami Ketentuan E-Auction tersebut diatas.</p>
		      	<p></p><br />
			      	<button style="margin-right: 9%;margin-bottom: -6%;" onclick="undurdiri1()" name="setuju" value="2" class="btn btn-danger stj tidak_setuju" disabled  data-toggle="tooltip" data-placement="top" title="Mengundurkan Diri">Tidak Setuju</button>
		      	<form method="post" action="<?php echo base_url(); ?>EC_Auction_itemize_negotiation/setuju" >
		      		<input class="notender" type="hidden" name="notender" value="<?php echo $auction[0]['NO_TENDER']?>" />
			      	<!-- <a title="tidak setuju" href="#!" class="btn btn-danger stj" onclick="undurdiri1()" disabled>Tidak Setuju</a> -->
			        <button type="submit" name="setuju" value="1" class="btn btn-primary stj setuju" disabled>Setuju</button>
		        </form>

		      		<!-- <input type="hidden" name="notender" value="<?php echo $auction[0]['NO_TENDER']?>" />
		      		<a title="tdksetuju" href="#!" class="btn btn-default btn-sm" onclick="undurdiri1()">Tidak Setuju</a>
		      		<a title="setuju" href="EC_Auction_itemize_negotiation/setuju" class="btn btn-default btn-sm">Setuju</a> -->
			      	<!-- a type="submit" name="setuju" value="2" class="btn btn-danger stj" disabled  data-toggle="tooltip" data-placement="top" title="Mengundurkan Diri">Tidak Setuju</a>
			        <a type="submit" name="setuju" value="1" class="btn btn-primary stj" disabled>Setuju</a> -->
		        </div>
		    </div>
		  </div>
		</div>
		