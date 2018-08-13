<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
				<input type="hidden" id="Tanggal" value="<?php echo $tanggal ?>">
				<input type="hidden" id="Tanggal2" value="<?php echo $tanggal2 ?>">
				<input type="hidden" id="statusAuction" value="<?php echo $Detail_Auction['B_IS_ACTIVE'] ?>">
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							Auction
						</div>
						<div class="panel-body">
							<form action="<?php echo base_url()?>EC_Auction_itemize/edit" method="post" > 
								<div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px;">
									<div class="col-lg-2">
										Nomor Tender
									</div>
									<div class="col-lg-10">
										:&nbsp<strong id="NO_TENDER"><?php echo $Detail_Auction['NO_TENDER'] ?></strong>
									</div>
								</div>
								<div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px;">
									<div class="col-lg-2">
										Kode Batch
									</div>
									<div class="col-lg-10">
										:&nbsp<strong id="nobatch"><?php echo $nobatch ?></strong>
									</div>
								</div> 
								<div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px;">
									<div class="col-lg-2">
										Nomor Referensi
									</div>
									<div class="col-lg-10">
										:&nbsp<strong id="NO_TENDER"><?php echo $Detail_Auction['NO_REF'] ?></strong>
									</div>
								</div>  
								<div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px; padding-top: 3px;">
									<div class="col-lg-2">
										Deskripsi
									</div>
									<div class="col-lg-10">
										:&nbsp<strong><?php echo $Detail_Auction['DESC'] ?></strong>
									</div>
								</div>
								<div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px; padding-top: 3px;">
									<div class="col-lg-2">
										Lokasi Auction
									</div>
									<div class="col-lg-10">
										:&nbsp<strong><?php echo $Detail_Auction['LOCATION'] ?></strong>
									</div>
								</div>
								<div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px; padding-top: 3px;">
									<div class="col-lg-2">
										Type Ranking
									</div>
									<div class="col-lg-10">
										<input type="hidden" id="type_ranking" name="type_ranking" value="<?php echo $Detail_Auction['TIPE_RANKING']?>"/>
										:&nbsp<strong><?php echo $Detail_Auction['TIPE_RANKING'] == 1 ? 'Ranking Satuan' : 'Ranking Total' ?></strong>
									</div>
								</div>
								<div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px; padding-top: 3px;">
									<div class="col-lg-2">
										Unit Peminta
									</div>
									<div class="col-lg-10">
										:&nbsp<strong><?php echo $Detail_Auction['COMPANYNAME'] ?></strong>
									</div>
								</div> 
								<div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px; padding-top: 3px;">
									<div class="col-lg-2">
										Tanggal Pembukaan
									</div>                                
									<div class="col-lg-5">
										<div class="input-group date">
											<input type="text" id="TGL_BUKAedit" name="TGL_BUKA" value="<?php echo $Detail_Auction['PEMBUKAAN'] ?>" required="" class="auc_start form-control">
											<span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div><strong class="hidden" id="TGL_BUKA"><?php echo $Detail_Auction['PEMBUKAAN'] ?></strong>
									</div>
								</div>
								<div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px; padding-top: 3px;">
									<div class="col-lg-2">
										Tanggal Penutupan
									</div>
									<div class="col-lg-5">
										<div class="input-group date">
											<input type="text" id="TGL_TUTUPedit" name="TGL_TUTUP" value="<?php echo $Detail_Auction['PENUTUPAN'] ?>" required="" class="auc_start form-control">
											<span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div><strong class="hidden" id="TGL_TUTUP"><?php echo $Detail_Auction['PENUTUPAN'] ?></strong>
									</div>
								</div>

								<div class="row">
									<div class="col-md-12">
										<input type="hidden" name="NO_TENDER" value="<?php echo $Detail_Auction['NO_TENDER'] ?>" />
										<input type="hidden" name="NO_BATCH" value="<?php echo $nobatch ?>" />
										<button id="editBTN" style="margin-top: 15px " type="submit" class="main_button color2 small_btn pull-left">
											Simpan Perubahan
										</button>
										
										<a target="_blank" href="<?php echo base_url();?>EC_Auction_itemize/print_e_auction_peserta_detail/<?php echo $Detail_Auction['NO_TENDER']; ?>" type="button" style="margin-top: 15px; margin-left:10px;" class="btn btn-default pull-left" aria-label="Left Align" >
											Print Peserta <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
										</a>

										<a href="<?php echo base_url();?>EC_Auction_itemize/indexBatch/<?php echo $Detail_Auction['NO_TENDER']; ?>" type="button" style="margin-top: 15px; margin-left:10px;" class="btn btn-danger pull-left" aria-label="Left Align" >
											Pilih Batch
										</a>

										<!-- <?php if (count($check)==0){ ?>
											<a href="<?php echo base_url();?>EC_Auction_itemize/indexBatch/<?php echo $Detail_Auction['NO_TENDER']; ?>" type="button" style="margin-top: 15px; margin-left:10px;" class="btn btn-danger pull-left" aria-label="Left Align" >
											DONE
											</a>
											<?php }?> -->

										</div>
									</div>
								</form>                               
							</div>                
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Waktu Tersisa
							</div>
							<div class="panel-body">
								<div class="col-md-5 col-md-offset-4">
									<h3 id="BELUM">AUCTION BELUM DIMULAI</h3>
								</div>
								<div class="col-md-5 col-md-offset-4">
									<h3 id="SELESAI">AUCTION SELESAI</h3>
								</div>
								<div class="col-md-5 col-md-offset-4">
									<h3 id="CLOSED">AUCTION CLOSED</h3>
								</div>
								<div class="col-md-5 col-md-offset-4">
									<div class="my-clock"></div>
								</div>
								<div class="col-md-12">
									<form action="<?php echo base_url()?>EC_Auction_itemize/close" method="post" >
										<input type="hidden" name="NO_TENDER" value="<?php echo $Detail_Auction['NO_TENDER'] ?>" />
										<input type="hidden" name="NO_BATCH" value="<?php echo $nobatch ?>" />

										<button id="closeBTN" type="submit" class="main_button color1 small_btn pull-right">
											CLOSE AUCTION
										</button>
									</form>
								</div>
							</div>                
						</div>
					</div>
				</div>


				<div class="nav-tabs-custom">
					<?php if ($Detail_Auction['TIPE_RANKING'] == 1) {?>
					<ul class="nav nav-tabs">
						<li class="active"><a href="#ticket" data-toggle="tab" aria-expanded="false">Report Tab</a></li>
						<li><a href="#task" data-toggle="tab" aria-expanded="false">Item Tab</a></li>
						<li><a href="#task1" data-toggle="tab" aria-expanded="false">Peserta Tab</a></li>
					</ul>
					<?php } else {?>
					<ul class="nav nav-tabs">
						<!-- <li class="active"><a href="#ticket" data-toggle="tab" aria-expanded="false">Report Tab</a></li> -->
						<li class="active"><a href="#task1" data-toggle="tab" aria-expanded="false">Peserta Tab</a></li>
						<li><a href="#task" data-toggle="tab" aria-expanded="false">Item Tab</a></li>
					</ul>
					<?php } ?>
					<p>&nbsp;</p>

					<div class="tab-content">
						<?php if ($Detail_Auction['TIPE_RANKING'] == 1) {?>
						<div class="tab-pane active" id="ticket">
						<?php } else {?>
						<div class="tab-pane" id="ticket">
						<?php } ?>
							<div class="row">
								<div class="col-md-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											Akumulasi Perolehan Ranking Perpemasok
										</div>
										<div class="panel-body reportOlehRanking">

										</div>                
									</div>
								</div>
							</div>

						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="task">

							<div class="row">
								<div class="col-md-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											Item
										</div>
										<div class="panel-body">
											<table class="table table-hover" id="negotiation_list">
												<thead>
													<tr>
														<th class="text-left">No</th>
														<th class="text-left">Kode Item</th>
														<th class="text-left">Deskripsi</th>
														<th class="text-center">Kuantitas</th>
														<th class="text-center">Uom</th>
														<th class="text-center">Tipe</th>
														<th class="text-center">Price</th>
														<th class="text-center">HPS</th>
													</tr>
												</thead>
												<tbody id="item">

												</tbody>
											</table>
										</div>                
									</div>
								</div>
							</div>

						</div>
						<?php if ($Detail_Auction['TIPE_RANKING'] == 1) {?>
						<div class="tab-pane" id="task1">
						<?php } else {?>
						<div class="tab-pane active" id="task1">
						<?php } ?>
						<!-- <div class="tab-pane" id="task1"> -->

							<div class="row">
								<div class="col-md-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											Peserta
										</div>
										<div class="panel-body">
											<table class="table table-hover" id="negotiation_list">
												<thead>
													<tr>
														<th class="text-left">No</th>
														<th class="text-left">Kode Peserta</th>
														<th class="text-left">Nama Peserta</th>
														<th class="text-center">Initial</th>
														<th class="text-center">Currency</th>
														<!-- <th class="text-center">Bea Masuk</th> -->
														<th class="text-center">Nilai Tukar</th>
														<th class="text-center">Total Harga</th>
													</tr>
												</thead>
												<tbody id="peserta">

												</tbody>
											</table>
										</div>                
									</div>
								</div>
							</div>

						</div><!-- /.tab-pane -->
					</div><!-- nav-tabs-custom -->
				</div>

				<br>
				<br>




			<!-- <div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading" style="padding-bottom: 20px;">
							Peserta Auction
							<a target="_blank" href="<?php echo base_url();?>EC_Auction/print_e_auction_peserta/<?php echo $Detail_Auction['NO_TENDER']?>" type="button" style="margin-right: 20px" class="printt btn btn-default pull-right" aria-label="Left Align" >
								<span class="glyphicon glyphicon-print" aria-hidden="true"></span>
							</a>
						</div>
						<div class="panel-body">
							<table class="table table-hover" id="negotiation_list">
								<thead>
									<tr>
										<th class="text-left">No</th>
										<th class="text-left">Vendor Code</th>
										<th class="text-left">Nama Vendor</th>
										<th class="text-left">Initial</th>
										<th class="text-center">Harga Awal</th>
										<th class="text-center">Harga Terkini</th>
									</tr>
								</thead>
								<tbody id="Peserta">

								</tbody>
							</table>
						</div>                
					</div>
				</div>
			</div> -->


			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading" style="padding-bottom: 20px;">
							Ranking
							<a id="" target="_blank" href="<?php echo base_url();?>EC_Auction_itemize/print_auction_report/<?php echo $Detail_Auction['NO_TENDER']?>/<?php echo $nobatch ?>" type="button" style="margin-right: 20px" class="printt btn btn-default pull-right" aria-label="Left Align" >
								<span class="glyphicon glyphicon-print" aria-hidden="true"></span>
							</a>
							<a id="" target="_blank" href="<?php echo base_url();?>EC_Auction_itemize/exportReport/<?php echo $Detail_Auction['NO_TENDER']?>/<?php echo $nobatch ?>" type="button" style="margin-right: 20px" class="printt btn btn-success pull-right" aria-label="Left Align" > Export
								
							</a>
							<!-- <a target="_blank" href="<?php echo base_url();?>EC_Auction/print_e_auction_peserta/<?php echo $Detail_Auction['NO_TENDER']?>" type="button" style="margin-right: 20px" class="printt btn btn-default pull-right" aria-label="Left Align" >
								<span class="glyphicon glyphicon-print" aria-hidden="true"></span>
							</a> -->
						</div>
						
						<div class="panel-body" id="resultOlehRanking">

						</div>                
					</div>
				</div>
			</div>



			<div class="row" id="Cetak22">
				<div class="col-md-12">
					<div class="panel panel-default">
                        <!-- <div class="panel-heading">
                            Log Auction 
                        </div> -->
                        <div class="panel-body">
                        	Note :
                        	<br>
                        	<textarea class="form-control" rows="4" id="Note" name="Note"><?php echo $Detail_Auction['NOTE']?></textarea>
                        	<br>
                        	<!-- <a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>EC_Auction_itemize/print_e_auction/<?php echo $Detail_Auction['NO_TENDER']; ?>/<?php echo $nobatch['NAME']; ?>">CETAK</a> -->
                        	<a onclick="cetak('<?php echo $Detail_Auction['NO_TENDER']?>','<?php echo $nobatch; ?>')" href="javascript:void(0)" type="button"  class="main_button color3 small_btn pull-right">
                        		Berita Acara
                        	</a>

                        	<!-- <a onclick="cetak('<?php echo $Detail_Auction['NO_TENDER']?>','<?php echo $nobatch; ?>')" href="javascript:void(0)" type="button"  class="main_button color2 small_btn pull-right">
                        		Lampiran 1
                        	</a>
                        	
                        	<a onclick="cetak('<?php echo $Detail_Auction['NO_TENDER']?>','<?php echo $nobatch; ?>')" href="javascript:void(0)" type="button"  class="main_button color4 small_btn pull-right">
                        		Lampiran 2
                        	</a> -->
                            <!-- <a target="_blank" onclick="cetak('<?php //echo $Detail_Auction['NO_TENDER']?>')" href="<?php //echo base_url();?>EC_Auction/print_e_auction/<?php //echo $Detail_Auction['NO_TENDER']?>" type="button"  class="main_button color1 small_btn pull-right">
                                Cetak
                            </a>  -->
                        </div>                
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<div class="modal fade bs-example-modal-lg" tabindex="-1" id="tbh-Log" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel">Log Auction </h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="id_tender" id="id_tender">
				<input type="hidden" name="id_item" id="id_item">
				<input type="hidden" name="id_link" id="id_link" value="<?php echo base_url();?>EC_Auction_itemize/print_e_auction_log/<?php echo $Detail_Auction['NO_TENDER']?>/<?php echo $nobatch ?>">

				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading" style="padding-bottom: 20px;">
								Log Auction 
								<a id="yourlinkId" target="_blank" href="" type="button" style="margin-right: 20px" class="printt btn btn-default pull-right" aria-label="Left Align" >
									<span class="glyphicon glyphicon-print" aria-hidden="true"></span>
								</a>
							</div>
							<div class="panel-body">
								<table class="table table-hover" id="negotiation_list">
									<thead>
										<tr>
											<th class="text-left">No</th>
											<th class="text-left">Created At</th>
											<th class="text-left">Iter</th>
											<th class="text-center">Vendor</th>
											<th class="text-center">Price</th>
											<th class="text-center">Bawah ECE</th>
										</tr>
									</thead>
									<tbody id="Log"> 
									</tbody>
								</table>
							</div>                
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>