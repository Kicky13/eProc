<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
					<form action="<?php echo base_url()?>EC_Auction_bobot/save" method="POST" class="submit">
						<input type="text" name="ptm_number" value="" hidden>
						<div class="panel panel-default">
							<div class="panel-heading" style="padding-bottom: 20px;">
								List Item
								<a type="button" href="<?php echo base_url(); ?>EC_Auction_bobot/resetItem" class="btn btn-danger btn-sm pull-right" aria-label="Left Align">
									<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
								</a>
								<button type="button" style="margin-right: 20px" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#tbh-item">
									Tambah
								</button>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-hover">
										<thead>
											<th class="col-md-1">No</th>
											<th>Kode Item</th>
											<th>Deskripsi</th>
											<th>Kuantitas</th>
											<th>UoM</th>
											<th>Price</th>
											<th>Aksi</th>
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
												<td><button type="button" style="margin-right: 20px" class="btn btn-warning btn-sm" data-toggle="modal" onclick="openmodal('<?php echo $value['ID_ITEM']?>')">
													Edit<!-- <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> -->
												</button>
											</td>
										</tr>												
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<input type="hidden" id="hargaSatu" value="<?php echo sizeof($items)>0?number_format($items[0]['PRICE'],0,",","."):'0'?>" />
					<input type="hidden" id="hargaTot" value="<?php echo number_format($HPS['HPS'],0,",",".") ?>" />
					<div class="panel panel-default">
						<div class="panel-heading" style="padding-bottom: 20px;" >
							Peserta Auction
							<a type="button" href="<?php echo base_url(); ?>EC_Auction_bobot/resetPeserta"  class="btn btn-danger btn-sm pull-right">
								<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
							</a>
							<a target="_blank" href="<?php echo base_url();?>EC_Auction_bobot/print_e_auction_peserta_temp/" type="button" style="margin-right: 20px" class="btn btn-default pull-right" aria-label="Left Align" >
								<span class="glyphicon glyphicon-print" aria-hidden="true"></span>
							</a>
                            <!-- <button type="button" style="margin-right: 20px" class="printt btn btn-default pull-right" aria-label="Left Align">
							  <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
							</button> -->
							<button style="margin-right: 20px" type="button"class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#tbh-peserta">
								Tambah
							</button>
						</div>
						<div class="panel-body">
							<div class="table-responsive" id="printin">
								<table class="table tablee table-hover" >
									<thead>
										<th class="col-md-1">No</th>
										<th>Kode Peserta</th>
										<th>NamaPeserta</th>
										<th>Harga Awal</th>
										<th>Nilai Teknis</th>
										<th>Username</th>
										<th>Password</th>
										<th>Aksi</th>
									</thead>
									<tbody>
										<?php $i=0; foreach ($peserta as $value){?> 
										<tr>
											<td><?php echo ++$i?></td>
											<td><?php echo $value['KODE_VENDOR']?></td>
											<td><?php echo $value['NAMA_VENDOR']?></td>
											<td><?php echo number_format($value['HARGAAWAL'],0,",",".")?></td>
											<td><?php echo str_replace('.', ',', $value['NILAI_TEKNIS']) ?></td>
											<td><?php echo $value['USERID']?></td>
											<td><?php echo $value['PASS']?></td>
											<td><button type="button" style="margin-right: 20px" class="btn btn-warning btn-sm" data-toggle="modal" onclick="openmodal1('<?php echo $value['KODE_VENDOR']?>')">
												Edit<!-- <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> -->
											</button>
										</td>
									</tr>												
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						Deskripsi Auction
					</div>
					<table class="table table-hover">
						<tr>
							<td class="col-md-3">Nomor Tender</td>
							<td>
								<input type="text" class="form-control" name="idvn" placeholder="" value="<?php echo $NO_TENDER; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td class="col-md-3">Nomor Referensi</td>
							<td>
								<input type="text" class="form-control" required="" name="NO_REF" placeholder="No Referensi" value="">
							</td>
						</tr>
						<tr>
							<td>Deskripsi</td>
							<td>
								<input type="text" class="form-control" required="" name="DESC" placeholder="Deskripsi" value="">
							</td>
						</tr>
						<tr>
							<td>Lokasi Auction</td>
							<td>
								<input type="text" class="form-control" required="" name="LOCATION" placeholder="Lokasi">
							</td>
						</tr>
						<tr>
							<td>Tanggal Pembukaan</td>
							<td class="input-group date">
								<input type="text" name="TGL_BUKA" value="<?php echo $tanggal ?>" required="" class="auc_start form-control">
								<span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
							</td>
						</tr>
						<tr>
							<td>Tanggal Penutupan</td>
							<td class="input-group date">
								<input type="text" id="TGL_TUTUP" name="TGL_TUTUP" required="" class="auc_end form-control">
								<span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
							</td>
						</tr>
						<tr>
							<td>Nilai Pengurangan</td>
							<td>
								<input type="text" class="form-control format-koma" required="" id="NILAI_PENGURANGAN" name="NILAI_PENGURANGAN" placeholder="Pengurangan Harga">
							</td>
						</tr>
						<!-- <tr>
							<td>Bobot Teknis</td>
							<td>
								<div class="input-group col-sm-2">
									<input type="text" class="form-control format-koma" required="" id="BOBOT_TEKNIS" name="BOBOT_TEKNIS" placeholder="Bobot Teknis">
									<div class="input-group-addon"><i class="fa fa-percent"></i></div>
								</div>
							</td>
						</tr>
						<tr>
							<td>Bobot Harga</td>
							<td>
								<div class="input-group col-sm-2">
									<input type="text" class="form-control format-koma" required="" id="BOBOT_HARGA" name="BOBOT_HARGA" placeholder="Bobot Harga">
								</div>
							</td>
						</tr> -->
						
						<tr>
							<td>Bobot (Nilai Teknis : Nilai Harga)</td>
							<td>
								<select id="BOBOT" name="BOBOT" required="">
									<option value="60:40">60% : 40%</option>
									<option value="70:30">70% : 30%</option>
									<option value="80:20">80% : 20%</option>
									<option value="90:10">90% : 10%</option>
								</select>
							</td>
						</tr>

						<tr>
							<td>Currency</td>
							<td>
								<select name="CURR" id="paqh_price_type">
									<?php
									foreach ($curr as $key) {
										$selected = $key['CURR_CODE'] == 'IDR' ? 'selected' : '';
										echo '<option value="' . $key['CURR_CODE'] . '" ' . $selected . '>' . $key['CURR_CODE'] . '-' . $key['CURR_NAME'] . '</option>';
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Tipe Auction</td>
							<td>
								<select name="TIPE" id="tipeHPS">
									<option value="S"<?php if(sizeof($items)>1) echo 'disabled' ?> >Harga Satuan</option>
									<option value="T" selected="">Harga Total</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>HPS/OE</td>
							<td>
								<input type="text" class="form-control nmr" name="HPS" id="HPS" value="<?php echo number_format($HPS['HPS'],0,",",".") ?>" readonly>
							</td> 
						</tr>
					</table>
				</div>
				<input type="hidden" name="hargaSatu" value="<?php echo sizeof($items)>0?$items[0]['PRICE']:'0'?>" />
				<input type="hidden" name="hargaTot" value="<?php echo $HPS['HPS'] ?>" />
				<div class="panel panel-default">
					<div class="panel-body text-center">
						<!-- <a href="<?php echo base_url(); ?>Auction/index" class="main_button color7 small_btn">Kembali</a> -->
						<input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar">
					</input>
					<button id="submit_button" type="submit" class="main_button color1 small_btn tombolsimpan">
						Simpan
					</button>
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
				<form class="form-horizontal" action="<?php echo base_url()?>EC_Auction_bobot/addItems" method="POST">
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
						<div class="col-sm-offset-3 col-sm-10">
							<button type="submit" class="btn btn-info">Tambah</button>
						</div>
					</div>
				</form>
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
				<?php echo form_open_multipart('EC_Auction_bobot/updateItem/',array('method' => 'POST','id'=>'formUp','class' => 'form-horizontal')); ?>
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
				<?php echo form_open_multipart('EC_Auction_bobot/updateUser/',array('method' => 'POST','id'=>'formUp','class' => 'form-horizontal')); ?>
            	  <!-- <div class="col-md-12 hidden">
                    <input type="hidden" class="form-control" id="KODE_VENDOR" name="">
                </div> -->
                <div class="form-group">
                	<label for="NAMA_BARANG" class="col-sm-3 control-label">Kode Peserta</label>
                	<div class="col-sm-9">
                		<input type="text" class="form-control" id="KODE_VENDOR" name="KODE_VENDOR" readonly>
                	</div>
                </div> 

                <div class="form-group">
                	<label for="KODE_BARANG" class="col-sm-3 control-label">Nama Vendor</label>
                	<div class="col-sm-9">
                		<input type="text" class="form-control" id="NAMA_VENDOR" readonly>
                	</div>
                </div> 

                <div class="form-group">
                	<label for="JUMLAH" class="col-sm-3 control-label">Nilai Teknis</label>
                	<div class="col-sm-2">
                		<input type="number" class="form-control" maxlength="3" min="1" max="100" id="NILAI_TEKNIS" name="NILAI_TEKNIS">             
                	</div>
                	<p class="help-block"><small>Nilai 0 - 100</small></p>
                </div>

                <div class="form-group">
                	<label for="JUMLAH" class="col-sm-3 control-label">Harga Awal</label>
                	<div class="col-sm-9">
                		<input type="text" class="form-control format-koma" rows="5" id="HARGAAWAL" name="HARGA">             
                	</div>
                </div> 

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

<!-- <div class="modal fade bs-example-modal-lg" tabindex="-1" id="edit-item" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Edit Item</h4>
      </div>
      <div class="modal-body">
      	<form class="form-horizontal" action="<?php echo base_url()?>EC_Auction/addItems" method="POST">
      	<input type="text" class="hidden" name="idItem" id="idItem">
		  <div class="form-group">
		    <label for="kd_itm" class="col-sm-3 control-label">Kode Item</label>
		    <div class="col-sm-8">
		      <input type="text" class="form-control" name="kd_itm" id="kd_itm" required="" placeholder="">
		    </div>
		  </div>  
		  <div class="form-group">
		    <label for="desc_itm" class="col-sm-3 control-label">Deskripsi</label>
		    <div class="col-sm-8">
		      <input type="text" class="form-control" name="desc_itm" id="desc_itm" required="" placeholder="">
		    </div>
		  </div>  
		  <div class="form-group">
		    <label for="qty" class="col-sm-3 control-label">Kuantitas</label>
		    <div class="col-sm-8">
		      <input type="text" class="form-control format-koma" name="qty" id="qty" required="" placeholder="">
		    </div>
		  </div>  
		  <div class="form-group">
		    <label for="uom" class="col-sm-3 control-label">UoM</label>
		    <div class="col-sm-8">
			      <input type="text" class="form-control" name="uom" id="uom" required="" placeholder="">
		    </div>
		  </div>  
		  <div class="form-group">
		    <label for="ece" class="col-sm-3 control-label">Price</label>
		    <div class="col-sm-8">
			      <input type="text" class="form-control format-koma" name="ece" id="ece" required="" placeholder="">
		    </div>
		  </div>  
		  <div class="form-group">
		    <div class="col-sm-offset-3 col-sm-10">
		      <button type="submit" class="btn btn-info">Simpan</button>
		    </div>
		  </div>
		</form>
      </div>
    </div>
  </div>
</div> -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="tbh-peserta" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel">Tambah Peserta</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="<?php echo base_url()?>EC_Auction_bobot/addPeserta" method="POST">
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
						<label for="Harga" class="col-sm-3 control-label">Nilai Teknis</label>
						<div class="col-sm-2">
							<input type="number" class="form-control" maxlength="3" min="1" max="100" step="any" lang="en-150" pattern="-?[0-9]+[\,.]*[0-9]+" name="nilai_teknis" id="nilai_teknis" required="" placeholder="Nilai">
						</div>
						<label class="help-block"><small>Nilai Teknis antara 0 - 100</small></label>
					</div>
					<div class="form-group">
						<label for="Harga" class="col-sm-3 control-label">Harga Awal</label>
						<div class="col-sm-8">
							<input type="text" class="form-control format-koma" name="Harga" id="Harga" required="" placeholder="Harga">
						</div>
					</div>  
					<div class="form-group">
						<label for="user" class="col-sm-3 control-label">Username Login</label>
						<div class="col-sm-8">
							<div class="input-group">
								<input type="text" class="form-control" readonly="" name="user" value="<?php echo $userid?>" id="user" placeholder="user">
								<!-- <div class="input-group-addon"><a class="glyphicon glyphicon-refresh" href="javascript:void(0)" aria-hidden="true"></a></div> -->
							</div>
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
</div>

