<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
	        	<h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
	      	</div>
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
						<div class="col-lg-8 col-md-8">
							<a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalReject"><button type="button" class="btn btn-danger pull-right btnShow">Reject</button></a>
							<a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalApprove"><button type="button" class="btn btn-success pull-right btnShow" style="margin-right: 10px;">Approve</button></a>
							
						</div>
						
						
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
		</div >
	</div >
</section>

<div class="modal fade" id="modalReject">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>ALASAN REJECT<!-- <?php //echo $baseLanguage ['principal_manufacturer_addTtl'] ; ?> --></u></strong></h4>
			</div>
			<div class="modal-body">
				<?php echo form_open_multipart('EC_Invoice_ver/reject/', array('method' => 'POST', 'class' => 'form-horizontal formReject')); ?>
					<div class="row">
						<div class="col-lg-12">
							Alasan Reject:				
							<textarea class="form-control" rows="3" id="reject" name="reject" required></textarea>
							<input type="hidden" name="InvoiceNo" id="InvoiceNo">
							<button type="submit" id="btn-smpn" class="btn btn-danger pull-right" style="margin-top: 10px;">Reject</button>
						</div>					
					</div>
				</form>
				
				<!-- </div> -->
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalApprove">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>APPROVE<!-- <?php //echo $baseLanguage ['principal_manufacturer_addTtl'] ; ?> --></u></strong></h4>
			</div>
			<div class="modal-body">
				<?php echo form_open_multipart('EC_Invoice_ver/ApproveInv/', array('method' => 'POST', 'class' => 'form-horizontal formApprove')); ?>
					<input type="hidden" name="InvoiceNoApp" id="InvoiceNoApp">
						<div class="form-group">
						    <label for="Invoice Date" class="col-sm-3 control-label">Document Date</label>
						    <div class="col-sm-4 tgll">
						    	<div class="input-group date startDate">
						    		<input readonly="" id="DocumentDate"  class="form-control start-date" name="DocumentDate"  type="text">
						    		<span class="input-group-addon">
						    			<a href="javascript:void(0)">
						    				<i class="glyphicon glyphicon-calendar"></i>
						    			</a>
						    		</span> 
						    	</div>
						    </div> 
						  </div>
					
						<div class="form-group">
						    <label for="Invoice Date" class="col-sm-3 control-label">Posting Date</label>
						    <div class="col-sm-4 tgll">
						    	<div class="input-group date startDate">
						    		<input readonly="" id="PostingDate"  class="form-control start-date" name="PostingDate"  type="text">
						    		<span class="input-group-addon">
						    			<a href="javascript:void(0)">
						    				<i class="glyphicon glyphicon-calendar"></i>
						    			</a>
						    		</span> 
						    	</div>
						    </div> 
						  </div>
					
						<div class="form-group">
						    <label for="Invoice Date" class="col-sm-3 control-label">Payment Block</label>
						    <div class="col-sm-3">
						      <input type="text" name="PaymentBlock" id="PaymentBlock" value="3"> 
						    </div>
						  </div>
					
						<div class="form-group">
						    <label for="Invoice Date" class="col-sm-3 control-label">Note Verifikasi</label>						    
						    <div class="col-sm-9">
						      <textarea class="form-control" rows="3" id="Note" name="Note"></textarea> 
						    </div>
						  </div>
					<div class="row">
						<div class="col-lg-12">
							<button type="submit" id="btn-smpn_app" class="btn btn-success pull-right" style="margin-top: 10px;">Approve</button>
						</div>						
						
					</div>
				</form>
				
				<!-- </div> -->
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