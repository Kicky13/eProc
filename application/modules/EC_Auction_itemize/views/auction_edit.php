<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
// print_r($itemBatch);
// die;

$sisa = count($items) - $itemBatch[0]['JML'];

?>
<style>
	.tablee > tbody > tr > td {
		padding: 4px;
	}
	/*@media print {
	 body * {
	 visibility: hidden;
	 }
	 #section-to-print, #section-to-print * {
	 visibility: visible;
	 }
	 #section-to-print {
	 position: absolute;
	 left: 0;
	 top: 0;
	 }
	}*/
</style>
<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
			</div>
			<div class="row">
				<div class="col-md-12">
					<!-- <form action="<?php echo base_url()?>EC_Auction_itemize/save" method="POST" class="submit"> -->
					<form action="<?php echo base_url()?>EC_Auction_itemize/importExcelEdit/<?php echo $NO_TENDER?>" method="POST" enctype="multipart/form-data" class="submit">
						<input type="text" name="ptm_number" value="" hidden>
						<div class="panel panel-default">
							<div class="panel-heading" style="padding-bottom: 20px;">
								List Item
								<a type="button" href="<?php echo base_url(); ?>EC_Auction_itemize/resetItemEdit/<?php echo $NO_TENDER?>" class="btn btn-danger btn-sm pull-right" aria-label="Left Align">
									<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
								</a>
							</div>
							<div class="panel-body">
								<div class="">

									<div class="form-group">
										<label for="new_pajak" class="col-sm-1 control-label" style="margin: 6px;width: auto;">Upload Item :</label>
										<div>
											<input type="file" name="import_excel" required>
										</div>
									</div>
									<div>
										<button type="submit" style="margin-left: 130px" class="btn btn-success btn-md btn-excel">
											Upload
										</button>
									</div>
									<div>
										<label class="col-sm-1 control-label" style="margin: 6px;width: auto;">
											Download Tamplate Upload Item
											<a href="<?php echo base_url(); ?>upload/format_itemize_download.xlsx">disini</a>
										</label>
									</div>

									<table class="table table-hover" id="example">
										<thead>
											<tr>
												<th>No</th>
												<th>Kode Item</th>
												<th>Deskripsi</th>
												<th>Kuantitas</th>
												<th>UoM</th>
												<th>Price</th>
												<th>Tipe Auction</th>
												<th>Currency</th>
												<th>HPS/OE</th>
											</tr>
										</thead>
										<tbody>
											<?php $i=0; foreach ($items as $value){?> 
											<tr>
												<td><?php echo ++$i?></td>
												<td><?php echo $value['KODE_BARANG']?></td>
												<td><?php echo $value['NAMA_BARANG']?></td>
												<td><?php echo number_format($value['JUMLAH'],0,",",".")?></td>
												<td><?php echo $value['UNIT']?></td>
												<td><?php echo number_format($value['PRICE'],0,",",".")?></td>
												<td><?php echo ($value['TIPE']=="t") ? "Harga Total" : "Harga Satuan"; ?></td>
												<td><?php echo $value['CURR']?></td>
												<td><?php echo number_format($value['HPS'],0,",",".")?></td>
											</tr>												
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</form>

					<form class="form-horizontal" action="<?php echo base_url()?>EC_Auction_itemize/addPesertaEdit/<?php echo $NO_TENDER?>" method="POST">
						<div class="panel panel-default">
							<div class="panel-heading">
								Tambah Peserta Auction
							</div>
							<table class="table table-hover">
								<tr>
									<td class="col-md-3">Pilih Vendor</td>
									<td>
										<select id="vendor" name="vendor" value="" class="form-control select2 vnd">
											<option disabled selected value>Pilih Vendor</option>
											<?php foreach ($vendor_data as $vendor ) :?>
												<option value="<?php echo $vendor['VENDOR_NO'];?>"><?php echo $vendor['VENDOR_NO']." - ".$vendor['VENDOR_NAME'];?></option>
											<?php endforeach ?>
										</select>
										<input type="hidden" name="kd_vnd" id="kd_vnd" value="">
										<input type="hidden" name="nama_vnd" id="nama_vnd" value="">
									</td>
								</tr>
								<tr>
									<td class="col-md-3">Inisial Vendor</td>
									<td>
										<input type="text" class="form-control" name="init_vnd" id="init_vnd" required="" placeholder="Inisial" maxlength="3">
										<span style="color: #E74C3C">HARUS 3 huruf</span>
									</td>
								</tr>
								<tr>
									<td class="col-md-3">Currency</td>
									<td>
										<select name="currency" class="currency">
											<option value="IDR">IDR - Indonesia Rupiah</option>
											<?php 
											foreach ($currency as $cr) {
												echo "<option value=".$cr['FROM_CURR'].">".$cr['FROM_CURR']." - ".$cr['CURR_NAME']." (".$cr['TO_CURRNCY']." ".number_format($cr['KONVERSI'],0,".",".").")</option>";
											}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-md-3">Username Login</td>
									<td>
										<input type="text" class="form-control" name="user" value="<?php echo $userid?>" id="user" placeholder="user" readonly>
									</td>
								</tr>
								<tr>
									<td class="col-md-3">Password</td>
									<td class="input-group">
										<input type="text" class="form-control" name="passw" id="passw" required="" placeholder="passw">
										<div class="input-group-addon"><a class="glyphicon glyphicon-refresh" href="javascript:void(0)" aria-hidden="true"></a></div>
									</td>
								</tr>
								<tr>
									<td>
										<button type="submit" class="btn btn-info">Tambah</button>
									</td>
									<td></td>
								</tr>
							</table>
						</div>
					</form>

					<div class="panel panel-default">
						<form action="<?php echo base_url(); ?>EC_Auction_itemize/resetPeserta1/<?php echo $NO_TENDER?>">
							<div class="panel-heading" style="padding-bottom: 20px;" >
								List Peserta Auction
								<button type="submit" class="btn btn-danger btn-sm pull-right">
									<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
								</button>
								<a target="_blank" href="<?php echo base_url();?>EC_Auction_itemize/print_e_auction_peserta_edit/<?php echo $NO_TENDER?>" type="button" style="margin-right: 20px" class="btn btn-default pull-right" aria-label="Left Align" >
									<span class="glyphicon glyphicon-print" aria-hidden="true"></span>
								</a>
								<a style="margin-right: 20px" class="btn btn-warning btn-sm pull-right btn-hasilawal" data-id="<?php echo $NO_TENDER?>" data-toggle="tooltip" title="View/Edit">Hasil</a>
								<!-- <button style="margin-right: 20px" type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#tbh-peserta">
									Tambah
								</button> -->
							</div>
							<div class="panel-body">
								<div class="table-responsive" id="printin">
									<table class="table tablee table-hover" >
										<thead>
											<th></th>
											<th>No</th>
											<th>Kode Peserta</th>
											<th>Nama Peserta</th>
											<th>Initial Peserta</th>
											<th>Currency</th>
											<!-- <th>Bea Masuk</th> -->
											<th>Username</th>
											<th>Password</th>
											<th>Input Harga</th>
										</thead>
										<tbody>
											<?php $i=0; foreach ($peserta as $value){?> 
											<tr>
												<td>
													<input type="checkbox" name="kd_ven[]" id="kd_ven[]" value="<?php echo $value['KODE_VENDOR']; ?>">
												</td>
												<td><?php echo ++$i?></td>
												<td><?php echo $value['KODE_VENDOR']?></td>
												<td><?php echo $value['NAMA_VENDOR']?></td>
												<td><?php echo $value['INITIAL']?></td>
												<td><?php echo $value['CURRENCY']?></td>
												<!-- <td><?php echo $value['BEA_MASUK']?>%</td> -->
												<td><?php echo $value['USERID']?></td>
												<td><?php echo $value['PASS']?></td>
												<?php if ($value['STATUS_UPLOAD']==1) { ?>
												<td>
													<a class="btn btn-info btn-sm btn-hargaawal" data-id="<?php echo $value['ID_HEADER'].'-'.$value['KODE_VENDOR']?>" data-toggle="tooltip" title="View/Edit">Lihat Harga
														<!-- <i class="fa fa-pencil-square-o" aria-hidden="true"></i> -->
													</a>
												</td>
												<?php } else { ?>
												<td>
													<a href="<?php echo base_url()?>EC_Auction_itemize/exportEdit?KODE_VENDOR=<?php echo $value['KODE_VENDOR']?>&NOTENDER=<?php echo $NO_TENDER?>" target="_blank" class="main_button color6 small_btn" id="idexcell" data-toggle="tooltip" title="Export Excel"><span class="glyphicon glyphicon-download-alt"></span></a>

													<a class="btn btn-success btn-sm btn-upload-hargaawal" data-id="<?php echo $value['KODE_VENDOR']?>" data-toggle="tooltip" title="Upload Harga">
														<i class="fa fa-upload" aria-hidden="true"></i>
													</a>
													<!-- <a class="btn btn-warning btn-sm btn-hargaawal" data-id="<?php echo $value['KODE_VENDOR']?>" data-toggle="tooltip" title="View/Edit">
														<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
													</a> -->
												</td>
												<?php } ?>
											</form>
										</tr>												
										<?php } ?>
									</tbody>
								</table>
							</div>
						</form>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading" style="padding-bottom: 20px;">
						List Batch
						<a type="button" href="<?php echo base_url(); ?>EC_Auction_itemize/resetBatch1/<?php echo $NO_TENDER?>" class="btn btn-danger btn-sm pull-right" aria-label="Left Align">
							<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
						</a>
						<?php if($sisa>0){ ?>
						<button style="margin-right: 20px" type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#tbh-batch">
							Tambah
						</button>
						<?php } else { 
							?>
							<button style="margin-right: 20px" type="button" class="btn btn-warning btn-sm pull-right">
								<b>Item Telah Habis</b>
							</button>
							<?php

						} ?>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<th class="col-md-1">No</th>
									<th>Batch</th>
									<th>Jumlah Item</th>
									<!-- <th>Aksi</th> -->
								</thead>
								<tbody>
									<?php $i=0; foreach ($batch as $value){?> 
									<tr>
										<td><?php echo ++$i?></td>
										<td><?php echo $value['NAME']?></td>
										<td><?php echo $value['QTY_ITEM']?></td>
									</tr>												
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div> 

				<form action="<?php echo base_url()?>EC_Auction_itemize/save" method="POST" class="submit">
					<input type="hidden" id="hargaSatu" value="<?php echo sizeof($items)>0?number_format($items[0]['PRICE'],0,",","."):'0'?>" />
					<input type="hidden" id="hargaTot" value="<?php echo number_format($HPS['HPS'],0,",",".") ?>" />
					<div class="panel panel-default">
						<div class="panel-heading">
							Deskripsi Auction
						</div>
						<?php foreach ($header as $value){?> 
						<table class="table table-hover">
							<tr>
								<td class="col-md-3">Nomor Tender</td>
								<td>
									<input type="text" class="form-control" name="idvn" placeholder="" value="<?php echo $value['NO_TENDER']; ?>" readonly>
								</td>
							</tr>
							<tr>
								<td class="col-md-3">Nomor Referensi</td>
								<td>
									<input type="text" class="form-control" required="" name="NO_REF" placeholder="No Referensi" value="<?php echo $value['NO_REF']; ?>" readonly>
								</td>
							</tr>
							<tr>
								<td>Deskripsi</td>
								<td>
									<input type="text" class="form-control" required="" name="DESC" placeholder="Deskripsi" value="<?php echo $value['DESC']; ?>" readonly>
								</td>
							</tr>
							<tr>
								<td>Lokasi Auction</td>
								<td>
									<input type="text" class="form-control" required="" name="LOCATION" placeholder="Lokasi" value="<?php echo $value['LOCATION']; ?>" readonly>
								</td>
							</tr>
							<tr>
								<td>Unit Peminta</td>
								<td>
									<select class="form-control" name="opco" readonly>
										<?php
										foreach ($company as $cp) {
											echo "<option value=".$cp['COMPANYID']." ".($cp['COMPANYID']==$value['COMPANYID']? 'selected':'disabled')." >".$cp['COMPANYID']." - ".$cp['COMPANYNAME']."</option>";
										} 
										?>
									</select>
								</td>
							</tr>

							<!-- <tr>
								<td>Tanggal Pembukaan</td>
								<td class="input-group date">
									<input type="text" name="TGL_BUKA" value="<?php echo $tanggal ?>" required="" class="auc_start form-control">
									<span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span></td>
								</tr>
								<tr>
									<td>Tanggal Penutupan</td>
									<td class="input-group date">
										<input type="text" id="TGL_TUTUP" name="TGL_TUTUP" required="" class="auc_end form-control">
										<span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span></td>
									</tr> -->

								<!-- <tr>
									<td>Nilai Pengurangan</td>
									<td>
										<input type="text" class="form-control format-koma" required="" id="NILAI_PENGURANGAN" name="NILAI_PENGURANGAN" placeholder="Pengurangan Harga">
									</td>
								</tr> -->
							<!-- <tr>
								<td>Currency</td>
								<td>
								<select name="CURR" id="paqh_price_type">
									<?php
									foreach ($curr as $key) {
										$selected = $key['CURR_CODE'] == 'IDR' ? 'selected' : '';
										echo '<option value="' . $key['CURR_CODE'] . '" ' . $selected . '>' . $key['CURR_CODE'] . '-' . $key['CURR_NAME'] . '</option>';
									}?>
								</select></td>
							</tr>
							<tr>
								<td>Tipe Auction</td>
								<td>
								<select name="TIPE" id="tipeHPS">
									<option value="S"<?php if(sizeof($items)>1) echo 'disabled' ?> >Harga Satuan</option>
									<option value="T" selected="">Harga Total</option>
								</select></td>
							</tr> -->
							<!-- <tr>
								<td>HPS/OE</td>
								<td>
									<input type="text" class="form-control nmr" name="HPS" id="HPS" value="<?php echo number_format($HPS['HPS'],0,",",".") ?>" readonly>
								</td> 
							</tr> -->
						</table>
						<?php } ?>
					</div>
					<input type="hidden" name="hargaSatu" value="<?php echo sizeof($items)>0?$items[0]['PRICE']:'0'?>" />
					<input type="hidden" name="hargaTot" value="<?php echo $HPS['HPS'] ?>" />
					<div class="panel panel-default">
						<div class="panel-body text-center">
							<!-- <a href="<?php echo base_url(); ?>Auction/index" class="main_button color7 small_btn">Kembali</a> -->
							<input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar">
						</input>
						<a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?>EC_Auction_itemize/" style="font-size: 15px">Kembali</a>
						<a class="btn btn-success btn-xs" onclick="buka(<?php echo $NO_TENDER?>)" style="font-size: 15px">Open</a>
						<!-- <button id="submit_button" type="submit" class="main_button color1 small_btn tombolsimpan">
							Simpan
						</button> -->
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
</section>
<div class="modal fade bs-example-modal-lg" tabindex="-1" id="tbh-item" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel">Tambah Item</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="<?php echo base_url()?>EC_Auction_itemize/addItems" method="POST">
					<div class="form-group">
						<label for="kd_itm" class="col-sm-3 control-label">Kode Item</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="kd_itm" id="kd_itm" required="" placeholder="Kode">
						</div>
					</div>  
					<div class="form-group">
						<label for="desc_itm" class="col-sm-3 control-label">Deskripsi</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="desc_itm" id="desc_itm" required="" placeholder="Deskripsi">
						</div>
					</div>  
					<div class="form-group">
						<label for="qty" class="col-sm-3 control-label">Kuantitas</label>
						<div class="col-sm-8">
							<input type="text" class="form-control format-koma" name="qty" id="qty" required="" placeholder="qty">
						</div>
					</div>  
					<div class="form-group">
						<label for="uom" class="col-sm-3 control-label">UoM</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="uom" id="uom" required="" placeholder="uom">
						</div>
					</div>  
					<div class="form-group">
						<label for="ece" class="col-sm-3 control-label">Price</label>
						<div class="col-sm-8">
							<input type="text" class="form-control format-koma" name="ece" id="ece" required="" placeholder="price per satuan uom">
						</div>
					</div>
					<div class="form-group">
						<label for="ece" class="col-sm-3 control-label">Tipe Auction</label>
						<div class="col-sm-8">
							<select name="TIPE" id="tipeHPS">
								<option value="S"<?php if(sizeof($items)>1) echo 'disabled' ?> >Harga Satuan</option>
								<option value="T" selected="">Harga Total</option>
							</select>
						</div>
					</div> 
					<div class="form-group">
						<label for="ece" class="col-sm-3 control-label">Currency</label>
						<div class="col-sm-8">
							<select name="CURR" id="paqh_price_type">
								<?php
								foreach ($curr as $key) {
									$selected = $key['CURR_CODE'] == 'IDR' ? 'selected' : '';
									echo '<option value="' . $key['CURR_CODE'] . '" ' . $selected . '>' . $key['CURR_CODE'] . '-' . $key['CURR_NAME'] . '</option>';
								}?>
							</select>
						</div>
					</div>   
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-10">
							<button type="submit" class="btn btn-info">Tambah</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" id="edit-hargaawal" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel">Harga Awal</h4>
			</div>
			<div class="row "> 
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<table class="table table-hover" id="negotiation_list">
							<thead>
								<tr>
									<th class="text-left">No</th>
									<th class="text-left">Kode Item</th>
									<th class="text-left">Deskripsi</th>
									<th class="text-center">Harga</th>
								</tr>
							</thead>
							<tbody id="formHargaAwal">

							</tbody>
						</table>

<!-- 						<table id="hargaawal" class="table table-striped">
							<thead>
								<tr>
									<th class="text-center ts0"><a href="javascript:void(0)">No.</a></th>
									<th class="text-center ts1"><a href="javascript:void(0)">Nomer Material</a></th>
									<th class="text-center ts2"><a href="javascript:void(0)">Teks Pendek</a></th>
									<th class="text-center ts3"><a href="javascript:void(0)">UoM</a></th>
								</tr>
								<tr>
									<th> </th>
									<th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
									<th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
									<th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table> -->
					</div>
				</div> 
			</div>
		</div>
	</div>
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" id="hasilall" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel">Hasil</h4>
			</div>
			<div class="modal-body" id="hasilawal">
				//hasil
			</div>
		</div>
	</div>
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" id="tbh-hargaawal" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel">Harga Awal</h4>
			</div>
			<div class="modal-body" id="resultHargaAwal">
				//hasil
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="edit-item">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel">Edit Item</h4>
			</div>
			<div class="modal-body">        	 	
				<!-- <form class="form-horizontal" id="formUp" action="E_Catalog/upload/" method="post" enctype="multipart/form-data"> -->
				<?php echo form_open_multipart('EC_Auction_itemize/updateItem/',array('method' => 'POST','id'=>'formUp','class' => 'form-horizontal')); ?>
				<div class="col-md-12 hidden">
					<input type="hidden" class="form-control" id="ID_ITEM" name="ID_ITEM">
				</div>

				<div class="form-group">
					<label for="KODE_BARANG" class="col-sm-3 control-label">Kode Item</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="KODE_BARANG" name="KODE_BARANG" >
					</div>
				</div> 

				<div class="form-group">
					<label for="NAMA_BARANG" class="col-sm-3 control-label">Deskripsi</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="NAMA_BARANG" name="NAMA_BARANG" >
					</div>
				</div> 

				<div class="form-group">
					<label for="JUMLAH" class="col-sm-3 control-label">Kuantitas</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" rows="5" id="JUMLAH" name="JUMLAH" >            
					</div>
				</div> 

				<div class="form-group">
					<label for="UNIT" class="col-sm-3 control-label">UoM</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="UNIT" name="UNIT" >
					</div>
				</div> 

				<div class="form-group">
					<label for="PRICE" class="col-sm-3 control-label">Price</label>
					<div class="col-sm-9">
						<input type="text" class="form-control format-koma" name="PRICE" id="PRICE">
					</div>
				</div> 


				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-10">
						<button type="submit" class="btn btn-info">Simpan</button>
					</div>
				</div>
			</form>
			<div class="text-right">
				<!-- <button class="btn btn-info" id="renewPR">Perbarui</button> -->
			</div>
		</div>
	</div>
</div>
</div>

<div class="modal fade" id="edit-peserta">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel">Edit Peserta</h4>
			</div>
			<div class="modal-body">        	 	
				<!-- <form class="form-horizontal" id="formUp" action="E_Catalog/upload/" method="post" enctype="multipart/form-data"> -->
				<?php echo form_open_multipart('EC_Auction_itemize/updateUser/',array('method' => 'POST','id'=>'formUp','class' => 'form-horizontal')); ?>
            	  <!-- <div class="col-md-12 hidden">
                    <input type="hidden" class="form-control" id="KODE_VENDOR" name="">
                </div> -->

                <div class="form-group">
                	<label for="KODE_BARANG" class="col-sm-3 control-label">Nama Vendor</label>
                	<div class="col-sm-9">
                		<input type="text" class="form-control" id="NAMA_VENDOR" readonly>
                	</div>
                </div> 

                <div class="form-group">
                	<label for="NAMA_BARANG" class="col-sm-3 control-label">Kode Peserta</label>
                	<div class="col-sm-9">
                		<input type="text" class="form-control" id="KODE_VENDOR" name="KODE_VENDOR" readonly>
                	</div>
                </div> 

                <!-- <div class="form-group">
                	<label for="JUMLAH" class="col-sm-3 control-label">Harga Awal</label>
                	<div class="col-sm-9">
                		<input type="text" class="form-control format-koma" rows="5" id="HARGAAWAL" name="HARGA">             
                	</div>
                </div> --> 

                <div class="form-group">
                	<label for="UNIT" class="col-sm-3 control-label">Username Login</label>
                	<div class="col-sm-9">
                		<input type="text" class="form-control" id="USERID" readonly>
                	</div>
                </div> 

                <div class="form-group">
                	<label for="PRICE" class="col-sm-3 control-label">Password</label>
                	<div class="col-sm-9">
                		<input type="text" class="form-control" name="PASS" id="PASS" required="" placeholder="passw" readonly>
                	</div>
                </div> 


                <div class="form-group">
                	<div class="col-sm-offset-3 col-sm-10">
                		<button type="submit" class="btn btn-info">Simpan</button>
                	</div>
                </div>
            </form>
            <div class="text-right">
            	<!-- <button class="btn btn-info" id="renewPR">Perbarui</button> -->
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" id="upload-harga" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel">Upload Harga Awal</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="<?php echo base_url()?>EC_Auction_itemize/do_uploadEdit/<?php echo $NO_TENDER?>" enctype="multipart/form-data" method="POST">
					<input type="hidden" name="KODE_VENDOR" class="id_peserta">
					<div class="form-group">
						<label for="new_pajak" class="col-sm-1 control-label" style="width: auto;">Upload Harga :</label>
						<div>
							<input type="file" name="import_excel" required>
						</div>
					</div>
					<div>
						<button type="submit" style="margin-left: 100px" class="btn btn-success btn-md btn-excel">
							Upload
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="tbh-peserta" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel">Tambah Peserta</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="<?php echo base_url()?>EC_Auction_itemize/addPeserta" method="POST">
					<div class="form-group">
						<label for="kd_vnd" class="col-sm-3 control-label">Kode Vendor</label>
						<div class="col-sm-8">
							<select id="vendor" name="vendor" value="" class="select2">
								<option disabled selected value>Pilih Vendor</option>
								<?php foreach ($vendor_data as $vendor ) :?>
									<option value="<?php echo $vendor['VENDOR_NO'];?>"><?php echo $vendor['VENDOR_NO']." - ".$vendor['VENDOR_NAME'];?></option>
								<?php endforeach ?>
							</select>
							<input type="" name="kd_vnd" id="kd_vnd" value="">
							<input type="" name="nama_vnd" id="nama_vnd" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="kd_vnd" class="col-sm-3 control-label">Kode Vendor</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="kd_vnd" id="kd_vnd" required="" placeholder="Kode">
						</div>
					</div>
					<div class="form-group">
						<label for="nama_vnd" class="col-sm-3 control-label">Nama Vendor</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="nama_vnd" id="nama_vnd" required="" placeholder="Nama">
						</div>
					</div>
					<div class="form-group">
						<label for="init_vnd" class="col-sm-3 control-label">Inisial Vendor</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="init_vnd" id="init_vnd" required="" placeholder="Inisial">
						</div>
					</div>
					<div class="form-group">
						<label for="init_vnd" class="col-sm-3 control-label">Currency</label>
						<div class="col-sm-8">
							<select name="currency" class="currency">
								<option value="IDR">IDR - Indonesia Rupiah</option>
								<?php 
								foreach ($currency as $cr) {
									echo "<option value=".$cr['FROM_CURR'].">".$cr['FROM_CURR']." - ".$cr['CURR_NAME']." (".$cr['TO_CURRNCY']." ".number_format($cr['KONVERSI'],0,".",".").")</option>";
								}
								?>
							</select>
						</div>
					</div> 
					<!-- <div class="form-group">
						<label for="init_vnd" class="col-sm-3 control-label">Bea Masuk</label>
						<div class="col-sm-3">
							<div class="input-group">
								<input name="bea_masuk" type="number" class="form-control bm" placeholder="Bea Masuk" disabled>
								<div class="input-group-addon"><i class="fa fa-percent"></i></div>
							</div>
						</div>
					</div>  -->  
					<!-- <div class="form-group">
						<label for="Harga" class="col-sm-3 control-label">Harga Awal</label>
						<div class="col-sm-8">
							<input type="text" class="form-control format-koma" name="Harga" id="Harga" required="" placeholder="Harga">
						</div>
					</div> -->  
					<!-- <div class="form-group">
						<label for="user" class="col-sm-3 control-label">Username Login</label>
						<div class="col-sm-8">
							<div class="input-group">
								<input type="text" class="form-control" readonly="" name="user" value="<?php echo $userid?>" id="user" placeholder="user">
								<!-- <div class="input-group-addon"><a class="glyphicon glyphicon-refresh" href="javascript:void(0)" aria-hidden="true"></a></div> -->
							<!-- </div>
						</div>
					</div>  
					<div class="form-group">
						<label for="passw" class="col-sm-3 control-label">Password</label>
						<div class="col-sm-8">
							<div class="input-group">
								<input type="text" class="form-control" name="passw" id="passw" required="" placeholder="passw">
								<div class="input-group-addon"><a class="glyphicon glyphicon-refresh" href="javascript:void(0)" aria-hidden="true"></a></div>
							</div>
						</div>
					</div>  
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-10">
							<button type="submit" class="btn btn-info">Tambah</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>  -->


<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="tbh-batch" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel">Tambah Batch</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="<?php echo base_url()?>EC_Auction_itemize/addBatch/<?php echo $NO_TENDER?>" method="POST">
					<div class="form-group">
						<label for="kd_vnd" class="col-sm-3 control-label">Kode Batch</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="nama_batch" id="nama_batch" required="" placeholder="Kode Batch">
						</div>
					</div>
					<div class="form-group">
						<label for="nama_vnd" class="col-sm-3 control-label">Kuantiti Per Batch</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="qty_batch" id="qty_batch" required="" placeholder="Quantiti">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-10">
							<button type="submit" class="btn btn-info">Tambah</button>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<div class="alert alert-warning" role="alert">
								<strong>sisa item <?php echo $sisa ?> / <?php echo count($items); ?></strong>
							</div> 
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

