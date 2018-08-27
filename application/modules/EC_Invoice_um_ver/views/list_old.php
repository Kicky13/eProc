
<section class="content_section">
  <div class="content_spacer">
    <div class="content">
      <div class="main_title centered upper">
        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
      </div>
      <div class="row">
      	<div class="row ">
        	<button type="button" class="btn btn-default" onclick="sapUpdate()" style="margin-right: 30px">SAP (dev)</button>
        	 <button type="button" id="create" class="btn btn-info pull-right" data-toggle="modal" data-target="#myModal" style="margin-right: 30px">Create Invoice</button>      		
      	</div><br /> 
        <div class="row">
        	 <ul class="nav nav-tabs" role="tablist">
			    <li role="presentation" class="active"><a class="tab1" href="#home" aria-controls="home" role="tab" data-toggle="tab">Open</a></li>
			    <li role="presentation"><a class="tab2" href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Proposal</a></li>
			    <li role="presentation"><a class="tab2" href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Approved</a></li>
			    <li role="presentation"><a class="tab2" href="#rejected" aria-controls="rejected" role="tab" data-toggle="tab">Rejected</a></li>
			 </ul>
			 <div class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="home">
			    	 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">          		      	
			            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
			              <table id="tableMT" class="table table-striped nowrap" width="100%">
			                <thead>
			                  <tr>
			                    <th class="text-center ts0"><a href="javascript:void(0)">GR Documnet</a></th>
			                    <th class="text-center ts1"><a href="javascript:void(0)">GR Line</a></th> 
			                    <th class="text-center ts2"><a href="javascript:void(0)">GR's Date</a></th>
			                    <th class="text-center ts3"><a href="javascript:void(0)">Posting Date</a></th>
			                    <th class="text-center ts4"><a href="javascript:void(0)">Material</a></th>
			                    <th class="text-center ts5"><a href="javascript:void(0)">QTY</a></th>
			                    <th class="text-center ts6"><a href="javascript:void(0)">UoM</a></th>
			                    <th class="text-center ts7"><a href="javascript:void(0)">Value</a></th>
			                    <th class="text-center ts8"><a href="javascript:void(0)">Curr</a></th>
			                    <th class="text-center ts9"><a href="javascript:void(0)">PO</a></th>
			                    <th class="text-center ts10"><a href="javascript:void(0)">PO LIne</a></th>
			                    <th class="text-center ts11"><a href="javascript:void(0)">Check</a></th>
			                  </tr>
			                  <tr class="sear">
			                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th> 
			                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th> 
			                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th> 
			                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th> 
			                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th> 
			                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th> 
			                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th> 
			                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>                     
			                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
			                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
			                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
			                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th> 
			                  </tr>
			                </thead>
			                <tbody>
			                </tbody>
			              </table> 
			            </div>
			          </div>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="profile">
			    <br>
			    	<div class="row">
				<div class="col-lg-5 col-md-5">
					<div class="row">
						<h5>Header Data</h5>
					</div>
					<div class="row">
						<table class="table table-condensed">
						 	<thead>
						 		<tr>
								    <th style="text-align: center;">Invoice Date</th>
								    <th style="text-align: center;">Days</th>
								    <th style="text-align: center;">Invoice No</th>
								    <th style="text-align: center;">Faktur Pajak</th>
								    <th style="text-align: center;">Total Ammount</th>
								    <th style="text-align: center;">Currency</th>
								    <th style="text-align: center;"></th>
							  	</tr>
						 	</thead>
						 	<tbody id="divAttributes">
						 		
						 	</tbody>
						</table> 	
					</div>
					
				</div>
				<div class="col-lg-6 col-lg-offset-1 col-md-5 col-md-offset-1">
					<div class="row">
						<div class="col-lg-4 col-md-4">
							<h5>Detail Data</h5	>

						</div>
						<!-- <div class="col-lg-8 col-md-8">
							<a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalReject"><button type="button" class="btn btn-danger pull-right">Reject</button></a>
							<a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalApprove"><button type="button" class="btn btn-success pull-right" style="margin-right: 10px;">Approve</button></a>
							
						</div> -->
						
						
					</div>
					<div class="row">
					<br>
						<table class="table table-condensed">
						 	<thead>
						 		<tr>
								    <th>Amount</th>
								    <th>Qty</th>
								    <th>Uom</th>
								    <th>PO</th>
								    <th>PO Item</th>
								    <th>GR No</th>
								    <th>GR Item</th>
								    <th>Tax</th>								    
							  	</tr>
						 	</thead>
						 	<tbody id="InvoiceDetail">
						 		
						 	</tbody>
						</table> 	
					</div>
				</div>
			</div>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="messages">
			    	<br>
			    	<div class="row">
				<div class="col-lg-5 col-md-5">
					<div class="row">
						<h5>Header Data</h5>
					</div>
					<div class="row">
						<table class="table table-condensed">
						 	<thead>
						 		<tr>
								    <th style="text-align: center;">Invoice Date</th>
								    <th style="text-align: center;">Days</th>
								    <th style="text-align: center;">Invoice No</th>
								    <th style="text-align: center;">Faktur Pajak</th>
								    <th style="text-align: center;">Total Ammount</th>
								    <th style="text-align: center;">Currency</th>
								    <th style="text-align: center;"></th>
							  	</tr>
						 	</thead>
						 	<tbody id="divAttributesApp">
						 		
						 	</tbody>
						</table> 	
					</div>
					
				</div>
				<div class="col-lg-6 col-lg-offset-1 col-md-5 col-md-offset-1">
					<div class="row">
						<div class="col-lg-4 col-md-4">
							<h5>Detail Data</h5	>

						</div>
						<!-- <div class="col-lg-8 col-md-8">
							<a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalReject"><button type="button" class="btn btn-danger pull-right">Reject</button></a>
							<a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalApprove"><button type="button" class="btn btn-success pull-right" style="margin-right: 10px;">Approve</button></a>
							
						</div> -->
						
						
					</div>
					<div class="row">
					<br>
						<table class="table table-condensed">
						 	<thead>
						 		<tr>
								    <th>Amount</th>
								    <th>Qty</th>
								    <th>Uom</th>
								    <th>PO</th>
								    <th>PO Item</th>
								    <th>GR No</th>
								    <th>GR Item</th>
								    <th>Tax</th>								    
							  	</tr>
						 	</thead>
						 	<tbody id="InvoiceDetailApp">
						 		
						 	</tbody>
						</table> 	
					</div>
				</div>
			</div>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="rejected">
			    	<br>
			    	<div class="row">
				<div class="col-lg-6 col-md-6">
					<div class="row">
						<h5>Header Data</h5>
					</div>
					<div class="row">
						<table class="table table-condensed">
						 	<thead>
						 		<tr>
								    <th style="text-align: center;">Invoice Date</th>
								    <th style="text-align: center;">Days</th>
								    <th style="text-align: center;">Invoice No</th>
								    <th style="text-align: center;">Faktur Pajak</th>
								    <th style="text-align: center;">Total Ammount</th>
								    <th style="text-align: center;">Currency</th>
								    <th style="text-align: center;"></th>
							  	</tr>
						 	</thead>
						 	<tbody id="divAttributesReject">
						 		
						 	</tbody>
						</table> 	
					</div>
					
				</div>
				<div class="col-lg-5 col-lg-offset-1 col-md-5 col-md-offset-1">
					<div class="row">
						<div class="col-lg-4 col-md-4">
							<h5>Alasan Reject</h5	>

						</div>
						<!-- <div class="col-lg-8 col-md-8">
							<a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalReject"><button type="button" class="btn btn-danger pull-right">Reject</button></a>
							<a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalApprove"><button type="button" class="btn btn-success pull-right" style="margin-right: 10px;">Approve</button></a>
							
						</div> -->
						
						
					</div>
					<div class="row">
					<textarea class="form-control" rows="3" id="alasanreject" name="alasanreject" required></textarea>
					<!-- <br>
						<table class="table table-condensed">
						 	<thead>
						 		<tr>
								    <th>Amount</th>
								    <th>Qty</th>
								    <th>Uom</th>
								    <th>PO</th>
								    <th>PO Item</th>
								    <th>GR No</th>
								    <th>GR Item</th>
								    <th>Tax</th>								    
							  	</tr>
						 	</thead>
						 	<tbody id="InvoiceDetailReject">
						 		
						 	</tbody>
						</table> 	 -->
					</div>
				</div>
			</div>
			    </div>
			  </div>
          
        </div>   
      </div> 
    </div >
  </div >
</section>

<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-lg"> 
    <div class="modal-content">
      <div class="modal-header">
      	<center>Invoice</center>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button> 
        </div>
        <div class="modal-body">
        	<div class="row">
        		<div class="col-sm-12 col-lg-12 col-lg-12">
        			<?php echo form_open_multipart('EC_Open_invoice/createINV/', array('method' => 'POST', 'class' => 'form-horizontal formCreate')); ?>
				  <div class="form-group">
				    <label for="Invoice Date" class="col-sm-3 control-label">Invoice Date</label>
				    <div class="col-sm-4 tgll">
				    	<div class="input-group date startDate">
				    		<input readonly="" id="startdate" required=""  class="form-control start-date" name="invoice_date"  type="text">
				    		<span class="input-group-addon">
				    			<a href="javascript:void(0)">
				    				<i class="glyphicon glyphicon-calendar"></i>
				    			</a>
				    		</span> 
				    	</div>
				    </div> 
				    <!-- <div class="col-sm-3">
				      <input type="text" class="form-control" id="invoice_date" name="invoice_date" readonly>
				    </div> -->
				  </div> 
				  <div class="form-group">
						    <label for="Invoice Date" class="col-sm-3 control-label">Posting Date</label>
						    <div class="col-sm-4 tgll">
						    	<div class="input-group date startDate">
						    		<input readonly="" id="PostingDate"  class="form-control start-date" name="PostingDate" required="" type="text">
						    		<span class="input-group-addon">
						    			<a href="javascript:void(0)">
						    				<i class="glyphicon glyphicon-calendar"></i>
						    			</a>
						    		</span> 
						    	</div>
						    </div> 
				   </div>
				   <div class="form-group">
						    <label for="Invoice Date" class="col-sm-3 control-label">Tanggal Faktur Pajak</label>
						    <div class="col-sm-4 tgll">
						    	<div class="input-group date startDate">
						    		<input readonly="" id="FakturDate"  class="form-control start-date" name="FakturDate" required="" type="text">
						    		<span class="input-group-addon">
						    			<a href="javascript:void(0)">
						    				<i class="glyphicon glyphicon-calendar"></i>
						    			</a>
						    		</span> 
						    	</div>
						    </div> 
				   </div>
				   <div class="form-group">
				    <label for="Invoice No" class="col-sm-3 control-label">Invoice No</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" required="" id="invoice_no" name="invoice_no" >
				    </div>
				    <div class="col-sm-3">
				      <input type="file" required="" name="fileInv" />
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="bapp no" class="col-sm-3 control-label">No. BAPP</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" required="" id="bapp_no" name="bapp_no" >
				    </div>
				    <div class="col-sm-3">
				      <input type="file" required="" name="fileBapp" />
				    </div>
				  </div>
				   <div class="form-group">
				    <label for="faktur" class="col-sm-3 control-label">Faktur Pajak</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control format-pajak" id="faktur" data-mask="999.999-99.9999999"  required name="faktur" >
				    </div>
				    <div class="col-sm-3">
				      <input type="file" required="" name="fileFaktur" />
				    </div>
				  </div> 
				  <div class="form-group">
				    <label for="bapp no" class="col-sm-3 control-label">Potongan Mutu</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" required="" id="bapp_no" name="bapp_no" >
				    </div>
				    <div class="col-sm-3">
				      <input type="file" required="" name="fileBapp" />
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="bapp no" class="col-sm-3 control-label">Denda K3</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" required="" id="bapp_no" name="bapp_no" >
				    </div>
				    <div class="col-sm-3">
				      <input type="file" required="" name="fileBapp" />
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="bapp no" class="col-sm-3 control-label">No. Kwitansi</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" required="" id="bapp_no" name="bapp_no" >
				    </div>
				    <div class="col-sm-3">
				      <input type="file" required="" name="fileBapp" />
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="bapp no" class="col-sm-3 control-label">No. SPK</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" required="" id="bapp_no" name="bapp_no" >
				    </div>
				    <div class="col-sm-3">
				      <input type="file" required="" name="fileBapp" />
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="bapp no" class="col-sm-3 control-label">No. Surat Permohonan Pembayaran</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" required="" id="bapp_no" name="bapp_no" >
				    </div>
				    <div class="col-sm-3">
				      <input type="file" required="" name="fileBapp" />
				    </div>
				  </div>
				   <div class="form-group">
				    <label for="faktur" class="col-sm-3 control-label">Total Amount</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" name="total" required="" id="totalview" readonly="">
				    </div>
				  </div> 
				   <div class="form-group">
				    <label for="note" class="col-sm-3 control-label">Note</label>
				    <div class="col-sm-9"> 
				      <textarea name="note" class="form-control" rows="2"></textarea>
				    </div>
				  </div>  
				  <div class="form-group">
				    <div class="col-sm-offset-5 col-sm-3">
				  <input type="hidden" id="arrGR" name="arrgr[]" />
				  <input type="hidden" id="curr" name="curr" />
				  <input type="hidden" id="total" name="total" />
				  <input type="hidden" id="arrGRL" name="arrgrl[]" />	
				      <button class="btn btn-info" type="submit">Create</button>
				    </div>
				  </div>
				</form>
        		</div>
        	</div>        	 	
          <div class="text-right">
            <!-- <button class="btn btn-info" id="renewPR">Perbarui</button> -->
          </div>
        </div>
      </div>
    </div>
  </div>

<div class="modal fade" id="modalInvoinceNo">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>INVOICE<!-- <?php //echo $baseLanguage ['principal_manufacturer_addTtl'] ; ?> --></u></strong></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<!-- <div class="form-group"> -->
						<!-- <label for="picure" class="col-sm-2 control-label">Picure</label> -->
						<div class="col-md-8 col-md-offset-2">
						<br><br>
							<img id="picInvoince" class="thumbnail zoom" onerror="this.onerror=null;this.src='<?php echo base_url(UPLOAD_PATH) . '/material_strategis/default_post_img.png'; ?>'"
							src="<?php echo base_url(UPLOAD_PATH) . '/EC_material_strategis/default_post_img.png'; ?>">
						</div>
					<!-- </div> -->
				</div>
				
				<!-- </div> -->
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalFaktur">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>Faktur Pajak<!-- <?php //echo $baseLanguage ['principal_manufacturer_addTtl'] ; ?> --></u></strong></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<!-- <div class="form-group"> -->
						<!-- <label for="picure" class="col-sm-2 control-label">Picure</label> -->
						<div class="col-md-8 col-md-offset-2">
						<br><br>
							<img id="picFaktur" class="thumbnail zoom" onerror="this.onerror=null;this.src='<?php echo base_url(UPLOAD_PATH) . '/material_strategis/default_post_img.png'; ?>'"
							src="<?php echo base_url(UPLOAD_PATH) . '/EC_material_strategis/default_post_img.png'; ?>">
						</div>
					<!-- </div> -->
				</div>
				
				<!-- </div> -->
			</div>
		</div>
	</div>
</div>