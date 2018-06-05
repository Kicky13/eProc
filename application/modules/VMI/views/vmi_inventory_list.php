<section class="content_section">
    <?php //$this->load->view('vmi_menuvendor');?>
			<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span>Stock Management 
						<?php 
							// $username = $this->session->userdata("VENDOR_NO");
							// $username = $this->session->userdata(['logged_in']['username']);
							// echo "$username";
						?>
							</h2>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<div class="panel-title pull-left" >Stock Management <?php // echo "$vendors";?></div>
									<div class="btn-group pull-right">
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="panel-body">
									<table class="table table-hover" id="vmi_list">
										<thead>
											<tr>
												<th class="text-center">No PO</th>
												<th class="text-center">PO Item</th>
												<th class="text-center">Material</th>
												<th class="text-center">Unit</th>
												<th class="text-center">Quantity Open</th>
												<th class="text-center">Good Receipt</th>
												<th class="text-center">Good Issued</th>
												<th class="text-center" title = "Stok Vendor dalam Gudang SMI">Stock Intransit</th>
												<th class="text-center" title = "Stok Vendor dalam perjalanan">Stock On Delivery</th>
												<th class="text-center" title = "Stok Vendor dalam Gudang Vendor">Stock Vendor</th>
												<th class="text-center">Min</th>
												<th class="text-center">Max</th>
												<th class="text-center" style="width: 170px">View Detail</th>
												<th class="text-center" style="width: 170px">Re-Stock VMI</th>
												<th class="text-center" style="width: 170px">Re-Stock Vendor</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		
<div class="modal fade" id="modal_maintenanceStock" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Maintanance Stock <div id="namaVendor"></div></h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" action="<?=base_url('VMI/Vendor/InsertStock')?>" method="POST">
              <input type="hidden" id="Nid_list" name="Nid_list">
			<div class="form-group">
			  <div class="col-sm-3 col-sm-offset-1">
			  	<label for="inputPlant" class="control-label">Company</label>
			  </div>
			    <div class="col-sm-6">
<!--                             <select style="width: 100%" class="form-control basicselect" name="NselectCompany" id="NselectCompany" >
                                 <option value="" selected="selected">Choose Company...</option>
                               <?php foreach ($listcompany as $key => $value) :?>
			      	<option value="<?=$value->COMPANYID?>" class="awal" ><?=$value->COMPANYID." - ".$value->COMPANYNAME?></option>
			      <?php endforeach ?>
			      </select>-->
                                <input type="text" class="form-control" readonly id="NselectCompany" name="NselectCompany">
			    </div>
			</div>
			<div class="form-group">
			  	<div class="col-sm-3 col-sm-offset-1">
                                    <label for="inputPlant" class="control-label">Plant</label>
			  	</div>
			    <div class="col-sm-6">
<!--			      <select style="width: 100%" name="NselectPlant" id="NselectPlant" class="form-control basicselect">
                                    <option value="" selected="selected">Choose Plant...</option>
			      </select>-->
                                <input type="text" class="form-control" readonly id="NselectPlant" name="NselectPlant">
			    </div>
		  </div>
			<div class="form-group">
			  	<div class="col-sm-3 col-sm-offset-1">
                                    <label for="inputPlant" class="control-label">Vendor</label>
			  	</div>
			    <div class="col-sm-6">
<!--			      <select style="width: 100%" name="NselectPlant" id="NselectPlant" class="form-control basicselect">
                                    <option value="" selected="selected">Choose Plant...</option>
			      </select>-->
                                <input type="text" class="form-control" readonly id="NselectVendor" name="NselectVendor">
			    </div>
		  </div>
		  <div class="form-group">
		  	<div class="col-sm-3 col-sm-offset-1">
		  	<label for="inputMaterial" class="control-label">Material</label>
		  	</div>  
		    <div class="col-sm-6">
<!--		      <select name="NselectMaterial" id="NselectMaterial" class="form-control basicselect" style="width: 100%">
		      <option value="" selected="selected" class="awal">Choose Material...</option>
                            <?php foreach ($listmaterial as $key => $value) :?>
			      	<option value="<?=$value->ID_MATERIAL?>" class="awal" ><?=$value->NAMA_MATERIAL?></option>
                        <?php endforeach ?>
		      </select>-->
                        <input type="text" class="form-control" readonly id="NselectMaterial" name="NselectMaterial">
                        <input type="hidden" class="form-control" readonly id="NkodeMaterial" name="NkodeMaterial">
                        <input type="hidden" class="form-control" readonly id="idVendor" name="idVendor">
                        <input type="hidden" class="form-control" readonly id="Nstock" name="Nstock">
		    </div>
		  </div>
			<div class="form-group">
			  <div class="col-sm-3 col-sm-offset-1">
			  	<label for="inputPlant" class="control-label">Nomor PO</label>
			  </div>
			    <div class="col-sm-3">
                    <input type="text" class="form-control" id="Npo" name="Npo" autofocus>
			    </div>
			</div>
		  <div class="form-group">
		  	<div class="col-sm-3 col-sm-offset-1">
		  		<label for="inputVendor" class="control-label">Quantity</label>
		  	</div>
		    <div class="col-sm-3">
                <input type="text" class="form-control" id="Nquantity" name="Nquantity" placeholder = "Quantity">
		    </div>
		  </div>
		  <div class="form-group">
			  <div class="col-sm-3 col-sm-offset-1">
			    <label for="inputPassword3" class="control-label">Send Date</label>
			  </div>
		    <div class="col-sm-6">
		      <div class='input-group date' id='datetimepicker6'>
		                <input type='text' class="form-control" name="NTanggalKirim" value = <?php echo date('d-m-Y');?> />
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
		     </div>
		    </div>
		  </div>
		  <div class="form-group">
		  	<div class="col-sm-6 col-sm-offset-4">
		  		<!--<button type="button" class="btn btn-primary">Submit</button>-->
                                <input type="submit" class="btn btn-primary" value="Submit">
		  	</div>
		  </div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_maintenanceStock2" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Stock Pusat <div id="namaVendor2"></div></h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" action="<?=base_url('VMI/Vendor/UpdateStockPusat')?>" method="POST">
              <input type="hidden" id="Nid_list2" name="Nid_list">
              <input type="hidden" id="idVendor2" name="idVendor2">
              <input type="hidden" id="idMaterial2" name="idMaterial2">
                   <div class="form-group">
			  <div class="col-sm-3 col-sm-offset-1">
			  	<label for="inputPlant" class="control-label">Company</label>
			  </div>
			    <div class="col-sm-6">
<!--                             <select style="width: 100%" class="form-control basicselect" name="NselectCompany" id="NselectCompany" >
                                 <option value="" selected="selected">Choose Company...</option>
                               <?php foreach ($listcompany as $key => $value) :?>
			      	<option value="<?=$value->COMPANYID?>" class="awal" ><?=$value->COMPANYID." - ".$value->COMPANYNAME?></option>
			      <?php endforeach ?>
			      </select>-->
                             <input type="text" class="form-control" readonly id="NselectCompany2" name="NselectCompany2">
			    </div>
		  </div>
			<div class="form-group">
			  	<div class="col-sm-3 col-sm-offset-1">
                                    <label for="inputPlant" class="control-label">Plant</label>
			  	</div>
			    <div class="col-sm-6">
<!--			      <select style="width: 100%" name="NselectPlant" id="NselectPlant" class="form-control basicselect">
                                    <option value="" selected="selected">Choose Plant...</option>
			      </select>-->
                                <input type="text" class="form-control" readonly id="NselectPlant2" name="NselectPlant2">
			    </div>
		  </div>
		  <div class="form-group">
		  	<div class="col-sm-3 col-sm-offset-1">
		  	<label for="inputMaterial" class="control-label">Material</label>
		  	</div>  
		    <div class="col-sm-6">
                        <input type="text" class="form-control" readonly id="NselectMaterial2" name="NselectMaterial2">
		    </div>
		  </div>
		  <div class="form-group">
		  	<div class="col-sm-3 col-sm-offset-1">
		  	<label for="inputMaterial" class="control-label">Vendor</label>
		  	</div>  
		    <div class="col-sm-6">
                        <input type="text" class="form-control" readonly id="NselectVendor2" name="NselectVendor2">
		    </div>
		  </div>
		  <div class="form-group">
		  	<div class="col-sm-3 col-sm-offset-1">
		  		<label for="inputVendor" class="control-label">Quantity</label>
		  	</div>
		    <div class="col-sm-6">
                    <input type="text" class="form-control" id="Nquantity2" name="Nquantity" placeholder = "Quantity">
		    </div>
		  </div>
<!--		  <div class="form-group">
			  <div class="col-sm-3 col-sm-offset-1">
			    <label for="inputPassword3" class="control-label">Tanggal Kirim</label>
			  </div>
		    <div class="col-sm-6">
		      <div class='input-group date' id='datetimepicker6'>
		                <input type='text' class="form-control" name="NTanggalKirim" value = <?php echo date('d-m-Y');?> />
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
		     </div>
		    </div>
		  </div>-->
		  <div class="form-group">
		  	<div class="col-sm-6 col-sm-offset-4">
		  		<!--<button type="button" class="btn btn-primary">Submit</button>-->
                                <input type="submit" class="btn btn-primary" value="Submit">
		  	</div>
		  </div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>