<section class="content_section">
  	<div class="content_spacer">
    	<div class="content">
	    	<div class="row">
	    		<div class="col-lg-4">
	    			<h5 id="namaProduk"><?php echo $data_produk[0]['MAKTX']?></h5>
	    		</div>
	    		<div class="col-lg-8 pull-right">
				        	<?php echo form_open_multipart('EC_Ecatalog/compares/', array('method' => 'POST', 'class' => 'form-horizontal pull-right')); ?>
				        		<input type="hidden" id="arr" name="arr[]" />
				        		<a href="<?php echo base_url(); ?>EC_Ecatalog/listCatalog" type="button" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Kembali</a>
				        		<a href="javascript:void(0)"  data-toggle="modal" data-target="#modalbudget" type="button" class="btn btn-default" style="display: none;"><span class="" aria-hidden="true">IDR</span>&nbsp;<span class="budget">Loading...</span></a>
				        		<button type="submit"  style="display: none"  class="btn btn-default">Histori</button>
				        		<a href="<?php echo base_url(); ?>EC_Ecatalog/checkout" type="button" class="btn btn-default" onclick="openChart()"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Cart &nbsp;&nbsp;&nbsp;<span class="badge jml"></span></a>	
				        		<!-- <button type="submit" id="compare" class="btn btn-default">Perbandingan</button>				        		 -->
				        		<a href="<?php echo base_url(); ?>EC_Ecatalog/perbandingan" type="button" id="compare" class="btn btn-default">
									Compare &nbsp;<span class="badge jmlCompare"></span>
								</a>
				        	</form>
	        	</div>
	    	</div>
	    	<div class="row" style="padding-top: 5px">
	    		<div class="col-lg-3">
	    			<div class="row">
	    				<div class="col-md-3">
	    					<a href="javascript:void(0)" onclick="chgPic(0,'<?php echo $data_produk[0]['PICTURE'] ?>')"><?php echo '<img src="'.base_url(UPLOAD_PATH).'/EC_material_strategis/'.(($data_produk[0]['PICTURE']=="")?"default_post_img.png":$data_produk[0]['PICTURE']).'"  class="img-responsive">'?></a>	
	    					<p></p>
	    					<a href="javascript:void(0)" onclick="chgPic(1,'<?php echo $data_produk[0]['DRAWING'] ?>')" ><?php echo '<img src="'.base_url(UPLOAD_PATH).'/EC_material_strategis/'.(($data_produk[0]['DRAWING']=="")?"default_post_img.png":$data_produk[0]['DRAWING']).'" class="img-responsive">'?></a>
	    				</div>
	    				<div class="col-md-9">
	    					<?php echo '<img id="picSRC" src="'.base_url(UPLOAD_PATH).'/EC_material_strategis/'.(($data_produk[0]['PICTURE']=="")?"default_post_img.png":$data_produk[0]['PICTURE']).'" class="img-responsive">'?>
	    				</div>
	    			</div>
	    			<div class="row">
						<p></p>
		    			<center><?php echo $data_produk[0]['curr']?> <?php echo number_format(($data_produk[0]['netprice']*100),0,",",".")?> per <?php echo $data_produk[0]['per']?> <?php echo $data_produk[0]['uom']?></center>
						<p></p>
						 <div class="row">
						 	<div class="input-group col-md-8 col-md-offset-2">
						 		<!-- <i class="input-group-addon tangan" ><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></i> -->
						 		<input type="number" class="form-control text-center qtyy" value="0">
						 		<!-- <i class="input-group-addon tangan" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></i> -->
						 		<span class="input-group-addon"><?php echo $data_produk[0]['uom']?></span>
							</div>
						</div>
						<p></p>
		    			<center>
		    				<a href="javascript:void(0)" onclick="addCart(this,'<?php echo $data_produk[0]['MATNR']?>','<?php echo $data_produk[0]['contract_no']?>','<?php echo $data_produk[0]['ID_CAT']?>')" type="button" class="btn btn-default"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>&nbsp;<span class="add">Add to Cart</span></a>
		    				<!-- <button type="submit" onclick="buyOne(this,'<?php //echo $data_produk[0]['MATNR']?>','<?php //echo $data_produk[0]['contract_no']?>','<?php //echo $data_produk[0]['MATNR']?>')" id="buyyy" style="width: 80px;" class="btn btn-danger" disabled>Buy</button> -->
		    				<button type="submit" id="buyyy" data-toggle="modal" data-target="#modalBeli" style="width: 80px;" class="btn btn-danger">Buy</button>
		    			</center>
		    			<center>
		    				<p></p>
		    				<span id="statsPO"> </span>
		    			</center> 
		    			<div class="row"> 
		    				<!-- <div class="col-xs-10 col-xs-offset-2" style="border: 1px solid #ccc; width: 300px;"> -->
		    				<div class="col-lg-12" style="border: 1px solid #ccc; width: 300px; height: 110px; margin-left: 20px;">
								<?php echo form_open_multipart('EC_Ecatalog/confirm/', array('method' => 'POST', 'class' => 'form-horizontal')); ?>
								<input type="hidden" id="hid_current_budget" />
								<input type="hidden" id="hid_estimated_budget" />
								<input type="hidden" id="harga1" value="<?php echo ($data_produk[0]['netprice']*100)?>"/>
								<input type="hidden" id="curre" value="<?php echo $data_produk[0]['curr']?>"/>
								<input type="hidden" id="avl" value="<?php echo $data_produk[0]['t_qty']?>"/>
								<input type="hidden" id="sisa" value=""/>
								<table>
									<tr>
										<td>Total</td>
										<td><label id="totall" class="col-sm-8 control-label pull-right"><span><?php echo $data_produk[0]['curr']." "?></span><?php echo number_format(($data_produk[0]['netprice']*100),0,",",".")?></label></td>
									</tr>
									<tr>
										<td hidden="">Available</td>
										<td hidden=""><label id="budgett" class="col-lg-12 control-label pull-right">0</label></td>
									</tr>
									<tr>
										<td hidden="">Sisa</td>
										<td hidden=""><label id="totalsisa" class="col-lg-12 control-label pull-right">0</label></td>
									</tr>
								</table>
								<!-- <div class="form-group">
									<label for="totall" class="col-sm-3 control-label text-left">Total</label>
									<label id="totall" class="col-sm-8 control-label pull-right"><span><?php //echo $data_produk[0]['curr']." "?></span><?php //echo number_format(($data_produk[0]['netprice']*100),0,",",".")?></label>
									<label for="budgett" class="col-sm-3 control-label text-left">Available</label>
									<label id="budgett" class="col-sm-8 control-label pull-right">0</label>
									<label for="totalsisa" class="col-sm-5 control-label text-left">Sisa</label>
									<label id="totalsisa" class="col-sm-7 control-label pull-right">0</label>
								</div>  -->
								</form>
								</center>
							</div>
		    			</div>   				
	    			</div> 
	    		</div>
	    		<div class="col-lg-1">
	    		</div>
	    		<div class="col-lg-8"> 
			    	<div class="row">

				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 5px">
				    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Detail Produk</a></li>
				    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Syarat dan Kondisi</a></li>
				    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Feedback</a></li>
				    <!-- <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li> -->
				  </ul>
				  
				  <!-- Tab panes -->
				  <div class="tab-content">				    
				    <div role="tabpanel" class="tab-pane active" id="home">
				    	<div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
							  <div class="panel panel-default">
							    <div class="panel-heading" role="tab" id="accord-detailproduk">
							      <h4 class="panel-title">
							        <a role="button" data-toggle="collapse" data-parent="#accordion1" href="#detailproduk" aria-expanded="true" aria-controls="detailproduk">
							          Product Description
							        </a>							
							      </h4>
							    </div>
							    <div id="detailproduk" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="accord-detailproduk">
							      <div class="panel-body">
									<div class="row" style="background-color: #e3e9f2">
							    		<div class="col-lg-3">Long Text</div>	
							    		<div class="col-lg-9">: <?php echo $longteks?></div>	
							    	</div>
							    	<div class="row">
							    		<div class="col-lg-3">Base Unit Measure</div>	
							    		<div class="col-lg-9">: <?php echo $data_produk[0]['MEINS']?></div>	
							    	</div>
							    	<div class="row" style="background-color: #e3e9f2">
							    		<div class="col-lg-3">Material Group</div>	
							    		<div class="col-lg-9">: <?php echo $data_produk[0]['MATKL']?></div>	
							    	</div>
							    	<div class="row">
							    		<div class="col-lg-3">Material Type</div>	
							    		<div class="col-lg-9">: <?php echo $data_produk[0]['MTART']?></div>	
							    	</div>
							      </div>
							    </div>
							  </div>
							</div>
							<div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
							  <div class="panel panel-default">
							    <div class="panel-heading" role="tab" id="accord-detailContract">
							      <h4 class="panel-title">
							        <a role="button" data-toggle="collapse" data-parent="#accordion2" href="#detailContract" aria-expanded="true" aria-controls="detailContract">
							          Contract Description
							        </a>							
							      </h4>
							    </div>
							    <div id="detailContract" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="accord-detailContract">
							      <div class="panel-body">
									<div class="row" style="background-color: #e3e9f2">
							    		<div class="col-lg-3">Vendor</div>	
							    		<div class="col-lg-9">: <a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalpenyedia" data-vendor="<?php echo $data_produk[0]['vendorno']?>"><?php echo $data_produk[0]['vendorname'].' ('.$data_produk[0]['vendorno']?>)</a></div>	
							    	</div>
							    	<div class="row">
							    		<div class="col-lg-3">Principal</div>	
							    		<div class="col-lg-9">: <a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalprincipal" data-principal="<?php echo $data_produk[0]['PC_CODE']?>"><?php echo $data_produk[0]['PC_CODE']==null?'':$data_produk[0]['PC_NAME'].' ('.$data_produk[0]['PC_CODE'].')'?></a></div>	
							    	</div>
							    	<div class="row" style="background-color: #e3e9f2">
							    		<div class="col-lg-3">Nomor Kontrak</div>	
							    		<div class="col-lg-9">: <?php echo $data_produk[0]['contract_no']?></div>	
							    	</div>
							    	<div class="row">
							    		<div class="col-lg-3">Valid Price</div>	
							    		<div class="col-lg-9">: <?php echo substr($data_produk[0]['validstart'], 6, 2).'/'.substr($data_produk[0]['validstart'], 4, 2).'/'.substr($data_produk[0]['validstart'], 0, 4).' - '.substr($data_produk[0]['validend'], 6, 2).'/'.substr($data_produk[0]['validend'], 4, 2).'/'.substr($data_produk[0]['validend'], 0, 4)?></div>	
							    	</div>
							    	<div class="row" style="background-color: #e3e9f2">
							    		<div class="col-lg-3">Purchasing Organisasi</div>	
							    		<div class="col-lg-9">: <?php echo  $data_produk[0]['porg']?></div>	
							    	</div>
							    	<div class="row">
							    		<div class="col-lg-3">No Plant</div>	
							    		<div class="col-lg-9">: <?php echo $data_produk[0]['plant']?></div>	
							    	</div>
							    	<div class="row" style="background-color: #e3e9f2">
							    		<div class="col-lg-3">Contract Quantity</div>	
							    		<div class="col-lg-9">: <?php echo $data_produk[0]['t_qty'].' '.$data_produk[0]['uom']?></div>	
							    	</div>
							    	<div class="row">
							    		<div class="col-lg-3">Unit Price</div>	
							    		<div class="col-lg-9">: <?php echo number_format(($data_produk[0]['netprice']*100),0,",",".").' per '.$data_produk[0]['per'].' '.$data_produk[0]['uom']?></div>	
							    	</div>
							    	<div class="row" style="background-color: #e3e9f2">
							    		<div class="col-lg-3">Gross Price</div>	
							    		<div class="col-lg-9">: <?php echo number_format(($data_produk[0]['grossprice']*100),0,",",".")?></div>	
							    	</div>
							    	<div class="row">
							    		<div class="col-lg-3">Currency</div>	
							    		<div class="col-lg-9">: <?php echo $data_produk[0]['curr']?></div>	
							    	</div>
							    	<div class="row" style="background-color: #e3e9f2">
							    		<div class="col-lg-3">Term of Delivery</div>	
							    		<div class="col-lg-9">:</div>	
							    	</div>
							    	<div class="row">
							    		<div class="col-lg-3">Term of Payment</div>	
							    		<div class="col-lg-9">:</div>	
							    	</div>
							      </div>
							    </div>
							  </div>
							</div>
				    </div>

				    <div role="tabpanel" class="tab-pane" id="profile">
				    	<div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
							  <div class="panel panel-default">
							    <div class="panel-heading" role="tab" id="accor-pengiriman">
							      <h4 class="panel-title">
							        <a role="button" data-toggle="collapse" data-parent="#accordion2" href="#pengiriman" aria-expanded="true" aria-controls="pengiriman">
							          Info Pengiriman
							        </a>							
							      </h4>
							    </div>
							    <div id="pengiriman" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="accor-pengiriman">
							      <div class="panel-body">
									<!-- <div class="list-group">
									  <a href="#" class="list-group-item">First item<span class="badge">12</span></a>
									  <a href="#" class="list-group-item">Second item<span class="badge">12</span></a>
									  <a href="#" class="list-group-item">Third item<span class="badge">12</span></a>
									</div> -->
									<div class="row" style="background-color: #e3e9f2">
							    		<div class="col-lg-3">Pengiriman</div>	
							    		<div class="col-lg-9">: -)</div>	
							    	</div>
							    	<div class="row">
							    		<div class="col-lg-3">Vendor No</div>	
							    		<div class="col-lg-9">: -)</div>	
							    	</div>
							      </div>
							    </div>
							  </div>
							</div>
				    </div>
				    <div role="tabpanel" class="tab-pane" id="messages">
				    	<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
							  <div class="panel panel-default">
							    <div class="panel-heading" role="tab" id="accord-feedback">
							      <h4 class="panel-title">
							        <a role="button" data-toggle="collapse" data-parent="#accordion3" href="#feedback" aria-expanded="true" aria-controls="feedback">
							          Ulasan Barang
							        </a>							
							      </h4>
							    </div>
							    <div id="feedback" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="accord-feedback">
							      <div class="panel-body">
							      <?php										
										for ($i=0; $i < sizeof($feedback) ; $i++) { 											
									?>
										<div class="row">										
											<div class="col-lg-8">
												<font style="font-size: 16px;"><strong><?php echo $feedback[$i]['NAME_USER']?></strong></font>
												<br>
												<?php echo $feedback[$i]['TANGGAL']?>
											</div>
											<div class="col-lg-4">
												<div class="row" style="margin-left: 60px;">
													<input type="number" class="ratingstar1" value="<?php echo $feedback[$i]['RATING']?>"/>	
												</div>
												
											</div>
										</div>									
										<div class="row">
											<div class="col-lg-12">
												<?php echo $feedback[$i]['ULASAN']?>
											</div>
											
										</div>
										<hr>
									<?php
									}
									?>																			
							      </div>
							    </div>
							  </div>
							</div>

							<hr>
							<h5>Tulis Ulasan Anda</h5>
							<?php echo form_open_multipart('EC_Ecatalog/feedback/', array('method' => 'POST', 'class' => 'form-horizontal formUlasan')); ?>
	    						<input id="rating-input" name="rating-input" type="number"/>
	    						<input type="hidden" name="matno" value="<?php echo $data_produk[0]['MATNR']?>">
	    						<input type="hidden" name="contract_no" value="<?php echo $data_produk[0]['contract_no']?>">
	    						<textarea class="form-control" rows="4" id="ulasan" name="ulasan"></textarea> 
	    						<button type="submit" id="btn-submit" class="btn btn-success pull-right" style="margin-top: 10px;" disabled="">Submit</button>
    						</form>
				    </div>
				    <!-- <div role="tabpanel" class="tab-pane" id="settings">...</div> -->
				  </div>

				</div>
	    		</div>
	    	</div>



   	 	</div >
  	</div >
</section>

<div class="modal fade" id="modalpenyedia">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>INFORMASI PENYEDIA<!-- <?php //echo $baseLanguage ['principal_manufacturer_addTtl'] ; ?> --></u></strong></h4>
			</div>
			<div class="modal-body">
				<div class="row" style="border-bottom: 2px solid #ccc">
					<div class="col-lg-10">
						<h5 id="VENDOR_NAME"></h5>
					</div>
					<div class="col-lg-2">

					</div>
				</div>
				<!-- <div class="row"> -->
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						Alamat
					</div>
					<div class="col-lg-9" id="ADDRESS"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						Negara
					</div>
					<div class="col-lg-9" id="ADDRESS_COUNTRY"></div>
				</div>
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						E-mail
					</div>
					<div class="col-lg-9" id="EMAIL_ADDRESS"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						Website
					</div>
					<div class="col-lg-9" id="ADDRESS_WEBSITE"></div>
				</div>
				<!-- <div class="row" style="background-color: #e3e9f2">
				<div class="col-lg-3">No. Telp</div>
				<div class="col-lg-9" id="ADDRESS_PHONE_NO"></div>
				</div>
				<div class="row">
				<div class="col-lg-3">No. Fax</div>
				<div class="col-lg-9" id="alamat"></div>
				</div> -->
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						NPWP
					</div>
					<div class="col-lg-9" id="NPWP_NO"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						Contact Person
					</div>
					<div class="col-lg-9">
						<div class="row">
							<div class="col-lg-4">
								Nama
							</div>
							<div class="col-lg-3">
								No. Telp
							</div>
							<div class="col-lg-5">
								E-mail
							</div>
						</div>
						<div class="row" style="background-color: #e3e9f2"	>
							<div class="col-lg-4" id="CONTACT_NAME" style="word-wrap: break-word;"></div>
							<div class="col-lg-3" id="CONTACT_PHONE_NO" style="word-wrap: break-word;"></div>
							<div class="col-lg-5" id="CONTACT_EMAIL" style="word-wrap: break-word;"></div>
						</div>
					</div>
				</div>
				<!-- </div> -->
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalprincipal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>INFORMASI PRINCIPAL<!-- <?php //echo $baseLanguage ['principal_manufacturer_addTtl'] ; ?> --></u></strong></h4>
			</div>
			<div class="modal-body">
				<div class="row" style="border-bottom: 2px solid #ccc; padding-bottom: 10px">
					<div class="col-lg-10">
						<h5 id="PC_NAME"></h5>
					</div>
					<div class="col-lg-2">
						<img src="" id="LOGO" class="img-responsive">
					</div>
				</div>
				<!-- <div class="row"> -->
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						Alamat
					</div>
					<div class="col-lg-9" id="ADDRESS_P"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						Negara
					</div>
					<div class="col-lg-9" id="COUNTRY"></div>
				</div>
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						E-mail
					</div>
					<div class="col-lg-9" id="MAIL"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						Website
					</div>
					<div class="col-lg-9" id="WEBSITE"></div>
				</div>
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						No. Telp
					</div>
					<div class="col-lg-9" id="PHONE"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						No. Fax
					</div>
					<div class="col-lg-9" id="FAX"></div>
				</div>
				<!-- <div class="row" style="background-color: #e3e9f2">
				<div class="col-lg-3">NPWP</div>
				<div class="col-lg-9" id="NPWP_NO"></div>
				</div> -->
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-12 text-center">
						Partner Bisnis
					</div>
				</div>
				<div class="row" style="background-color: #f2b29b">
					<div class="col-lg-3 text-center">
						Penyedia
					</div>
					<div class="col-lg-1 text-center">
						Negara
					</div>
					<div class="col-lg-2 text-center">
						Website
					</div>
					<div class="col-lg-4 text-center">
						Email
					</div>
					<div class="col-lg-2 text-center">
						No. Telp
					</div>
				</div>
				<div id="divPartner">

				</div>
				<!-- </div> -->
			</div>
		</div>
	</div>
</div>

<link rel="stylesheet" href="<?php echo base_url()."static/css/pages/EC_miniTable.css"?>" />
<div class="modal fade" id="modalbudget">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>INFORMASI DETAIL BUDGET</u></strong></h4>
			</div>
			<div class="modal-body">
				<table class="table table-hover table-striped" >
					<thead>
						<tr>
							<th>CostCenter</th>
							<th>Description</th>
							<th>GLAccount</th>
							<th>GLDescription</th>
							<th>Current</th>
							<th>Commit</th>
							<th>Actual</th>
							<th>Available</th>
							<th>Cart</th>
						</tr>						
					</thead>
					<tbody id="tbody">						
					</tbody>
				</table>				
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalPO">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>INFORMASI PO</u></strong></h4>
			</div>
			<div class="modal-body">
				<table class="table table-hover table-striped" >
					<thead>
						<tr>
							<th>PO</th>
							<th>Matrial</th>
							<th>Harga</th>
						</tr>						
					</thead>
					<tbody id="tbodyPO">						
					</tbody>
				</table>				
			</div>
			<div class="modal-footer">
				<small>Halaman akan otomatis refresh dalam <span id="dtk">15</span> detik....</small>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalBeli">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>INFORMASI ORDER</u></strong></h4>
            </div>
            <div class="modal-body">
            	<!-- <div class="row" style="padding: 2px;">
                    <div class="col-sm-2 col-md-2 col-lg-2">
                        Document Type
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" id="sel1">
                            <?php
                                // if($this->session->userdata['COMPANYID']==2000){
                                //     echo "<option value='ZG01'>ZG01 PO Stock Lokal SMI</option>";
                                //     echo "<option value='ZG02'>ZG02 PO NonStock Lokal SMI</option>";
                                //     echo "<option value='ZG03'>ZG03 PO Stock Import SMI</option>";
                                //     echo "<option value='ZG04'>ZG04 PO NonStock Import SMI</option>";
                                //     echo "<option value='ZG05'>ZG05 PO Investasi SMI</option>";
                                //     echo "<option value='ZG08'>ZG08 PO Curah Lokal SMI</option>";
                                //     echo "<option value='ZG09'>ZG09 PO Curah Import SMI</option>";
                                // }elseif ($this->session->userdata['COMPANYID']==3000) {
                                //     echo "<option value='ZP01'>ZP01 PO Stock Lokal SP</option>";
                                //     echo "<option value='ZP02'>ZP02 PO NonStock Lokal SP</option>";
                                //     echo "<option value='ZP03'>ZP03 PO Stock Import SP</option>";
                                //     echo "<option value='ZP04'>ZP04 PO NonStock Import SP</option>";
                                //     echo "<option value='ZP05'>ZP05 PO Investasi SP</option>";
                                //     echo "<option value='ZP08'>ZP08 PO Curah Lokal SP</option>";
                                //     echo "<option value='ZP09'>ZP09 PO Curah Import SP</option>";
                                // }elseif ($this->session->userdata['COMPANYID']==4000) {
                                //     echo "<option value='ZT01'>ZT01 PO Stock Lokal ST</option>";
                                //     echo "<option value='ZT02'>ZT02 PO NonStock Lokal ST</option>";
                                //     echo "<option value='ZT03'>ZT03 PO Stock Import ST</option>";
                                //     echo "<option value='ZT04'>ZT04 PO NonStock Import ST</option>";
                                //     echo "<option value='ZT05'>ZT05 PO Investasi ST</option>";
                                //     echo "<option value='ZT08'>ZT08 PO Curah Lokal ST</option>";
                                //     echo "<option value='ZT09'>ZT09 PO Curah Import ST</option>";
                                // }elseif ($this->session->userdata['COMPANYID']==7000) {
                                //     echo "<option value='ZK01'>ZK01 PO Stock Lokal KSO</option>";
                                //     echo "<option value='ZK02'>ZK02 PO NonStock Lokal KSO</option>";
                                //     echo "<option value='ZK03'>ZK03 PO Stock Import KSO</option>";
                                //     echo "<option value='ZK04'>ZK04 PO NonStock Import KSO</option>";
                                //     echo "<option value='ZK05'>ZK05 PO Investasi KSO</option>";
                                //     echo "<option value='ZK08'>ZK08 PO Curah Lokal KSO</option>";
                                //     echo "<option value='ZK09'>ZK09 PO Curah Import KSO</option>";
                                // }
                            ?>
                        </select>
                    </div>
                </div> -->
                <div class="row" style="padding: 2px;">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        Company
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" id="selComp">
                        	<option value='' selected disabled>Select Company</option>
                        	<?php
                        		// var_dump($company);
                        		foreach ($company as $value) { ?>
                        			<option value='<?php echo $value['COMPANYID']?>' <?php if(substr($value['COMPANYID'],0,1)==substr($data_produk[0]['plant'],0,1)){ echo 'selected';} ?>><?php echo $value['COMPANYNAME']?></option>
                        	<?php
                        		}
                        	?>
                        </select>
                    </div>
                </div>
                <div class="row" style="padding: 2px; margin-top: 15px;">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        Purchasing Organization
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" id="selOrg">
                        	<option value='' selected disabled>Select Purchasing Organization</option>
                        	<option value='HC01'>HC01 Purchasing Organization SMI</option>
                            <option value='SP01'>SP01 Purc Org SP</option>
                            <option value='ST01'>ST01 Purc Org ST</option>
                            <option value='KS01'>KS01 Purc Org KSO</option>
                            <option value='OP01'>OP01 Purc Org SG</option>           
                        </select>
                    </div>
                </div>
                <div class="row" style="padding: 2px; margin-top: 15px;">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        Purchasing Group
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" id="selGroup">
                        	<option value='' disabled>Select Purchasing Group</option>
                        	<option value='101' selected>Pembelian Kontrak</option>
                            <option value='P01'>P01 Bahan Baku SP</option>
                            <option value='P02'>P02 Mesin&Suku Cadang SP</option>
                            <option value='T01'>T01 Bahan Baku ST</option>
                            <option value='T02'>T02 Mesin&Suku Cadang ST</option>
                            <option value='K01'>K01 Bahan Baku KSO</option>
                            <option value='K02'>K02 Mesin&Suku Cadang KSO</option>
                            <option value='O01'>O01 Bahan Baku SG</option>
                            <option value='O02'>O02 Mesin&Suku Cadang SG</option>               
                        </select>
                    </div>
                </div>
            	<div class="row" style="padding: 2px; margin-top: 15px;">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        Document Type
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" id="sel1">
                        	<option value='' selected disabled>Select Document Type</option>
                            <option value='ZG01'>ZG01 PO Stock Lokal SMI</option>
                            <option value='ZG02'>ZG02 PO NonStock Lokal SMI</option>
                            <option value='ZG03'>ZG03 PO Stock Import SMI</option>
                            <option value='ZG04'>ZG04 PO NonStock Import SMI</option>
                            <option value='ZG05'>ZG05 PO Investasi SMI</option>
                            <option value='ZG08'>ZG08 PO Curah Lokal SMI</option>
                            <option value='ZG09'>ZG09 PO Curah Import SMI</option>
                            <option value='ZP01'>ZP01 PO Stock Lokal SP</option>
                            <option value='ZP02'>ZP02 PO NonStock Lokal SP</option>
                            <option value='ZP03'>ZP03 PO Stock Import SP</option>
                            <option value='ZP04'>ZP04 PO NonStock Import SP</option>
                            <option value='ZP05'>ZP05 PO Investasi SP</option>
                            <option value='ZP08'>ZP08 PO Curah Lokal SP</option>
                            <option value='ZP09'>ZP09 PO Curah Import SP</option>                                
                            <option value='ZT01'>ZT01 PO Stock Lokal ST</option>
                            <option value='ZT02'>ZT02 PO NonStock Lokal ST</option>
                            <option value='ZT03'>ZT03 PO Stock Import ST</option>
                            <option value='ZT04'>ZT04 PO NonStock Import ST</option>
                            <option value='ZT05'>ZT05 PO Investasi ST</option>
                            <option value='ZT08'>ZT08 PO Curah Lokal ST</option>
                            <option value='ZT09'>ZT09 PO Curah Import ST</option>                               
                            <option value='ZK01'>ZK01 PO Stock Lokal KSO</option>
                            <option value='ZK02'>ZK02 PO NonStock Lokal KSO</option>
                            <option value='ZK03'>ZK03 PO Stock Import KSO</option>
                            <option value='ZK04'>ZK04 PO NonStock Import KSO</option>
                            <option value='ZK05'>ZK05 PO Investasi KSO</option>
                            <option value='ZK08'>ZK08 PO Curah Lokal KSO</option>
                            <option value='ZK09'>ZK09 PO Curah Import KSO</option>                   
                        </select>
                    </div>
                </div>
                <div class="row" style="padding: 2px; margin-top: 15px;">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        Document Date
                    </div>
                   <!-- <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type="text" name="viewtglShipment" id="viewtglShipment" placeholder="Tanggal">
                    </div>-->
                    <div class="col-md-3">
                        <div class="form-group">
                        	<input type="hidden" id="tanggalNow" value="<?php echo $tanggal; ?>" name="">
                            <div class="input-group date"><input readonly id="docdate" type="text" class="form-control" ><span class="input-group-addon"><a href="javascript:void(0)"><i class="glyphicon glyphicon-calendar"></i></a></span></div>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding: 2px;">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        Delivery Date
                    </div>
                   <!-- <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type="text" name="viewtglShipment" id="viewtglShipment" placeholder="Tanggal">
                    </div>-->
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="input-group date"><input readonly id="delivdate" type="text" class="form-control" ><span class="input-group-addon"><a href="javascript:void(0)"><i class="glyphicon glyphicon-calendar"></i></a></span></div>
                        </div>
                    </div>
                </div>
                <!-- <h6><span id="modalProduk">1000 EA</span></h6>
                <h6><small>Sebanyak:  <span id="jmlItm">1000 EA</span></small></h6>
                <h6><small>Total Biaya: <span id="totalBiaya">IDR 2.000.000</span></small></h6> -->
                <!-- <h5><strong>INFORMASI ITEM</strong></h5><hr> --> 
            </div>
            <div class="modal-footer">
                <button type="button" onclick="buyOne(this,'<?php echo $data_produk[0]['MATNR']?>','<?php echo $data_produk[0]['contract_no']?>','<?php echo $data_produk[0]['MATNR']?>')" id="buyOne" class="btn btn-success">Buy</button>
            </div>
        </div>
    </div>
</div>

<script>
	jQuery(document).ready(function() {
		$("#input-21f").rating({
			starCaptions : function(val) {
				if (val < 3) {
					return val;
				} else {
					return 'high';
				}
			},
			starCaptionClasses : function(val) {
				if (val < 3) {
					return 'label label-danger';
				} else {
					return 'label label-success';
				}
			},
			hoverOnClear : false
		});

		$('.ratingstar1').rating({
			size : 'xs',
			showClear : false,
			showCaption : false,
			readonly : true
		});

		$('#rating-input').rating({
			min : 0,
			max : 5,
			step : 1,
			size : 'xs',
			showClear : false

		});

		$('#btn-rating-input').on('click', function() {
			$('#rating-input').rating('refresh', {
				showClear : true,
				disabled : !$('#rating-input').attr('disabled')
			});
		});

		$('.btn-danger').on('click', function() {
			$("#kartik").rating('destroy');
		});

		$('.btn-success').on('click', function() {
			$("#kartik").rating('create');
		});

		$('#rating-input').on('rating.change', function() {
			//alert($('#rating-input').val());
			$('#btn-submit').removeAttr('disabled');
		});

		$('.rb-rating').rating({
			'showCaption' : true,
			'stars' : '3',
			'min' : '0',
			'max' : '3',
			'step' : '1',
			'size' : 'xs',
			'starCaptions' : {
				0 : 'status:nix',
				1 : 'status:wackelt',
				2 : 'status:geht',
				3 : 'status:laeuft'
			}
		});
	});
</script>