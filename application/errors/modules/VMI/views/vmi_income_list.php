<style type="text/css">
    .dt-body-right{
        text-align:right;
    }
</style>
<?php //$this->load->view('vmi_menubar');?>
<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span>Receipt</h2>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?php if($this->session->flashdata('success')) { ?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
					</div>
					<?php } ?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title pull-left">List All VMI</div>
							<div class="btn-group pull-right">
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-body">
							<table class="table table-hover" id="vmi_cvendor_list">
								<thead>
									<tr>
										<th class="text-center">PO</th>
										<th class="text-center">Plant</th>
										<th class="text-center">Vendor</th>
										<th class="text-center">Material</th>
										<th class="text-center">Date Delivery</th>
										<!--<th class="text-center">Tanggal Kedatangan</th>
										<th class="text-center">Quantity Receive</th>
										<th class="text-center">Lead Time</th>-->
										<th class="text-center">Quantity Delivery</th>
										<th class="text-center">Quantity Receipt</th>
										<th class="text-center">Approve Income</th>
									</tr>
								</thead>
							</table>
							<form  action="<?= site_url('VMI/Company/GRMaterial')?>" method="POST">
							<p align = "right">
								<input type="hidden" value="" id="listreceive" name="listreceive">
								<input type="submit" class="btn btn-default" value = "Receive">
							</p>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade modal_addVMI" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New VMI Vendor</h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" action="<?=base_url('VMI/Company/addNewVMI')?>" method="POST">
                   <div class="form-group">
			  <div class="col-sm-3 col-sm-offset-1">
			  	<label for="inputPlant" class="control-label">Company</label>
			  </div>
			    <div class="col-sm-6">
                             <select style="width: 100%" class="form-control basicselect" name="NselectCompany" id="NselectCompany" >
                                 <option value="" selected="selected">Choose Company...</option>
                               <?php foreach ($listcompany as $key => $value) :?>
			      	<option value="<?=$value->COMPANYID?>" class="awal" ><?=$value->COMPANYID." - ".$value->COMPANYNAME?></option>
			      <?php endforeach ?>
			      </select>
			    </div>
		  </div>
			<div class="form-group">
			  	<div class="col-sm-3 col-sm-offset-1">
                                    <label for="inputPlant" class="control-label">Plant</label>
			  	</div>
			    <div class="col-sm-6">
			      <select style="width: 100%" name="NselectPlant" id="NselectPlant" class="form-control basicselect">
                                    <option value="" selected="selected">Choose Plant...</option>
			      </select>
			    </div>
		  </div>
		  <div class="form-group">
		  	<div class="col-sm-3 col-sm-offset-1">
		  	<label for="inputMaterial" class="control-label">Material</label>
		  	</div>  
		    <div class="col-sm-6">
		      <select name="NselectMaterial" id="NselectMaterial" class="form-control basicselect" style="width: 100%">
		      <option value="" selected="selected" class="awal">Choose Material...</option>
                            <?php foreach ($listmaterial as $key => $value) :?>
			      	<option value="<?=$value->SUBMATERIAL_CODE?>" class="awal" ><?=$value->SUBMATERIAL_NAME?></option>
                        <?php endforeach ?>
		      </select>
		    </div>
		  </div>
		  <div class="form-group">
		  	<div class="col-sm-3 col-sm-offset-1">
		  		<label for="inputVendor" class="control-label">Vendor</label>
		  	</div>
		    <div class="col-sm-6">
		      <select name="NselectVendor" id=" NselectVendor" class="form-control basicselect" style="width: 100%">
		      <option value="" selected="selected">Choose Vendor...</option>
                      <?php foreach ($listvendor as $key => $value) :?>
			     <option value="<?=$value->VENDOR_ID?>" class="awal"><?=$value->VENDOR_NAME?></option>
                        <?php endforeach ?>
		      </select>
		    </div>
		  </div>
		  <div class="form-group">
		  	<div class="col-sm-3 col-sm-offset-1">
		  		<label for="inputVendor" class="control-label">No. PO</label>
		  	</div>
		    <div class="col-sm-6">
                        <input type="text" class="form-control" id="NNOPO" name="NNOPO">
		    </div>
		  </div>
		  <div class="form-group">
		  	<div class="col-sm-3 col-sm-offset-1">
                <input type="hidden" class="form-control" id="Nstock" name="Nstock" value = '1000'>
		  	</div>
		    <div class="col-sm-3">
                <input type="text" class="form-control" id="Nmin" name="Nmin" placeholder = "Min">
		    </div>
		    <div class="col-sm-3">
                <input type="text" class="form-control" id="Nmax" name="Nmax" placeholder = "Max">
		    </div>
		  </div>
		  <div class="form-group">
			  <div class="col-sm-3 col-sm-offset-1">
			    <label for="inputPassword3" class="control-label">Active Contract</label>
			  </div>
		    <div class="col-sm-6">
		      <div class='input-group date' id='datetimepicker6'>
		                <input type='text' class="form-control" name="NActiveContract" />
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
		     </div>
		    </div>
		  </div>
		  <div class="form-group">
			  <div class="col-sm-3 col-sm-offset-1">
			    <label for="inputPassword3" class="control-label">End Contract</label>
			  </div>
		    <div class="col-sm-6">
		      <div class='input-group date' id='datetimepicker7'>
		                <input type='text' class="form-control" name="NEndContract" />
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
		            </div>
		    </div>
		  </div>
		  <div class="form-group">
			  <div class="col-sm-3 col-sm-offset-1">
			    <label for="inputPassword3" class="control-label">Lead Time</label>
			  </div>
		    <div class="col-sm-3">
                <input type='text' class="form-control" name="NLeadTime" />
		    </div>
		    <div class="col-sm-3">
                 days
		    </div>
		  </div>
		  <div class="form-group">
			  <div class="col-sm-3 col-sm-offset-1">
			    <label for="inputPassword3" class="control-label">Type Vendor</label>
			  </div>
		    <div class="col-sm-6">
				<select name="NselectType" id="NselectType" class="form-control basicselect" style="width: 100%">
					<option value="" selected="selected">Choose Type Vendor...</option>
					<option value="V">VMI</option>
					<option value="C">Consinyasi</option>
				</select>
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

<div class="modal fade modal_manual_input" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Perencanaan</h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" action="<?=base_url('VMI/Company/SavePerencanaan')?>" method="POST">
			<!--<div class="form-group">
			  <div class="col-sm-2 col-sm-offset-1">
			  	<label for="inputPlant" class="control-label">Company</label>
			  </div>
			    <div class="col-sm-6">
                             <select style="width: 100%" class="form-control basicselect" name="PselectCompany" id="PselectCompany" >
                                 <option value="" selected="selected">Choose Company...</option>
                               <?php foreach ($listcompany as $key => $value) :?>
			      	<option value="<?=$value->COMPANYID?>" class="awal" ><?=$value->COMPANYID." - ".$value->COMPANYNAME?></option>
			      <?php endforeach ?>
			      </select>
			    </div>
			</div>-->
			<div class="form-group">
			  	<div class="col-sm-2 col-sm-offset-1">
                                    <label for="inputPlant" class="control-label">Plant</label>
			  	</div>
			    <div class="col-sm-6">
			      <select style="width: 100%" name="PselectPlant" id="PselectPlant" class="form-control basicselect">
			      <option value="" selected="selected">Choose Plant...</option>
                              <?php foreach ($listpplant as $key => $value) :?>
			      	<option value="<?=$value->ID_PLANT?>" class="awal" ><?=$value->ID_PLANT." - ".$value->PLANT_NAME?></option>
			      <?php endforeach ?>
			      </select>
			      </select>
			    </div>
			</div>
			<div class="form-group">
				<div class="col-sm-2 col-sm-offset-1">
				<label for="inputMaterial" class="control-label">Material</label>
				</div>  
				<div class="col-sm-6">
				  <select name="NselectMaterial" id="PselectMaterial" class="form-control basicselect" style="width: 100%">
				  <option value="" selected="selected" class="awal">Choose Material...</option>
                                            <?php // foreach ($listmaterial as $key => $value) :?>
						<!--<option value="<?=$value->SUBMATERIAL_CODE?>" class="awal" ><?=$value->SUBMATERIAL_NAME?></option>-->
                                            <?php // endforeach ?>
				  </select>
				</div>
			</div>
			<!--<div class="form-group">
				<div class="col-sm-2 col-sm-offset-1">
					<label for="inputVendor" class="control-label">Vendor</label>
				</div>
				<div class="col-sm-6">
				  <select name="NselectVendor" id=" PselectVendor" class="form-control basicselect" style="width: 100%">
				  <option value="" selected="selected">Choose Vendor...</option>
						  <?php foreach ($listvendor as $key => $value) :?>
					 <option value="<?=$value->VENDOR_ID?>" class="awal"><?=$value->VENDOR_NAME?></option>
							<?php endforeach ?>
				  </select>
				</div>
			</div>-->
			<div class="form-group">
				  <div class="col-sm-2 col-sm-offset-1">
					<label for="inputPassword3" class="control-label">Quantity</label>
				  </div>
				<div class="col-sm-6">
				  <input type="number" name="quantity" class="form-control">
				</div>
			</div>
		  <div class="form-group">
		  <div class="col-sm-2 col-sm-offset-1">
		    <label for="inputPassword3" class="control-label">Periode</label>
		  </div>
			    <div class='col-md-4'>
		            <div class='input-group date' id='datetimepickerp6'>
		                <input type='text' class="form-control" name="ptglawal"/>
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
		            </div>
			    </div>
			    <div class='col-md-1'>
			    	<label class="control-label">TO</label>
			    </div>
			    <div class='col-md-4'>
		            <div class='input-group date' id='datetimepickerp7'>
		                <input type='text' class="form-control" name="ptglakhir"/>
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
		            </div>
			    </div>
		  </div>
		  <div class="form-group">
		  	<div class="col-sm-6 col-sm-offset-3">
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

<div class="modal fade modal_upload" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Perencanaan</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
		    <label for="Upload_file">Upload File</label>
		    <input type="file" id="Upload_file">
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Upload</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>