<section class="content_section">
  	<div class="content_spacer">
    	<div class="content">
	    	<div class="row">
	    		<div class="col-lg-4">
	    			<h5><?php echo $data_produk[0]['MAKTX']?></h5>
	    		</div>
	    		<div class="col-lg-8 pull-right">
				        	<?php echo form_open_multipart('EC_Ecatalog/compares/', array('method' => 'POST', 'class' => 'form-horizontal pull-right')); ?>
				        		<input type="hidden" id="arr" name="arr[]" />
				        		<a href="<?php echo base_url(); ?>EC_Ecatalog/listCatalog" type="button" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Kembali</a>
				        		<a href="javascript:void(0)"  data-toggle="modal" data-target="#modalbudget" type="button" class="btn btn-default"><span class="" aria-hidden="true">IDR</span>&nbsp;<span class="budget">Loading...</span></a>
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
		    			<center><?php echo $data_produk[0]['curr']?> <?php echo number_format($data_produk[0]['netprice'],0,",",".")?> per <?php echo $data_produk[0]['per']?> <?php echo $data_produk[0]['uom']?></center>
						<p></p>
						 <div class="row">
						 	<div class="input-group col-md-8 col-md-offset-2">
						 		<!-- <i class="input-group-addon tangan" ><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></i> -->
						 		<input type="number" class="form-control text-center qtyy" value="1">
						 		<!-- <i class="input-group-addon tangan" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></i> -->
						 		<span class="input-group-addon"><?php echo $data_produk[0]['uom']?></span>
							</div>
						</div>
						<p></p>
		    			<center>
		    				<a href="javascript:void(0)" onclick="addCart(this,'<?php echo $data_produk[0]['MATNR']?>','<?php echo $data_produk[0]['contract_no']?>')" type="button" class="btn btn-default"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>&nbsp;<span class="add">Add to Cart</span></a>
		    				<button type="submit" onclick="buyOne(this,'<?php echo $data_produk[0]['MATNR']?>','<?php echo $data_produk[0]['contract_no']?>','<?php echo $data_produk[0]['MATNR']?>')" id="buyyy" style="width: 80px;" class="btn btn-danger" disabled>Buy</button>
		    			</center>
		    			<center>
		    				<p></p>
		    				<span id="statsPO"> </span>
		    			</center> 
		    			<div class="row"> 
		    				<div class="col-xs-10 col-xs-offset-2" style="border: 1px solid #ccc;">
								<?php echo form_open_multipart('EC_Ecatalog/confirm/', array('method' => 'POST', 'class' => 'form-horizontal')); ?>
								<input type="hidden" id="hid_current_budget" />
								<input type="hidden" id="hid_estimated_budget" />
								<input type="hidden" id="harga1" value="<?php echo $data_produk[0]['netprice']?>"/>
								<input type="hidden" id="curre" value="<?php echo $data_produk[0]['curr']?>"/>
								<input type="hidden" id="avl" value="<?php echo $data_produk[0]['t_qty']?>"/>
								<input type="hidden" id="sisa" value=""/>
								<div class="form-group">
									<label for="totall" class="col-sm-3 control-label text-left">Total</label>
									<label id="totall" class="col-sm-8 control-label pull-right"><span><?php echo $data_produk[0]['curr']." "?></span><?php echo number_format($data_produk[0]['netprice'],0,",",".")?></label>
									<label for="budgett" class="col-sm-3 control-label text-left">Available</label>
									<label id="budgett" class="col-sm-8 control-label pull-right">0</label>
									<label for="totalsisa" class="col-sm-5 control-label text-left">Sisa</label>
									<label id="totalsisa" class="col-sm-7 control-label pull-right">0</label>
								</div> 
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
							    		<div class="col-lg-9">: <a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalprincipal" data-principal="<?php echo $data_produk[0]['PC_CODE']?>"><?php echo $data_produk[0]['PC_NAME'].' ('.$data_produk[0]['PC_CODE']?>)</a></div>	
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
							    		<div class="col-lg-9">: <?php echo number_format($data_produk[0]['netprice'],0,",",".").' per '.$data_produk[0]['per'].' '.$data_produk[0]['uom']?></div>	
							    	</div>
							    	<div class="row" style="background-color: #e3e9f2">
							    		<div class="col-lg-3">Gross Price</div>	
							    		<div class="col-lg-9">: <?php echo number_format($data_produk[0]['grossprice'],0,",",".")?></div>	
							    	</div>
							    	<div class="row">
							    		<div class="col-lg-3">Currency</div>	
							    		<div class="col-lg-9">: <?php echo $data_produk[0]['curr']?></div>	
							    	</div>
							    	<div class="row" style="background-color: #e3e9f2">
							    		<div class="col-lg-3">Term of Delivery</div>	
							    		<div class="col-lg-9">: ...</div>	
							    	</div>
							    	<div class="row">
							    		<div class="col-lg-3">Term of Payment</div>	
							    		<div class="col-lg-9">: ...</div>	
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
												<?php echo $feedback[$i]['DATETIME']?>
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
	<div class="modal-dialog modal-md">
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
							<div class="col-lg-4" id="CONTACT_NAME"></div>
							<div class="col-lg-3" id="CONTACT_PHONE_NO"></div>
							<div class="col-lg-5" id="CONTACT_EMAIL"></div>
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