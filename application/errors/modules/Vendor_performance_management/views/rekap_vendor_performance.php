		<section class="content_section">
			<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
					</div>
					<div class="row">
						<div class="col-md-12">
							<?php if($this->session->flashdata('success')) { ?>
							<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
							</div>
							<?php } ?>
							<?php echo form_open("#",array('class' => 'form-horizontal')); ?>
							<div class="panel panel-default">
								<div class="panel-heading">Vendor Information</div>
								<div class="panel-body">
									<div class="form-group">
										<label for="NPP" class="col-sm-3 control-label">Vendor No</label>
										<label for="NPP" class="col-sm-9 control-label text-left"><strong><?php echo $vendor_information['VENDOR_NO']; ?></strong></label>
									</div>
									<div class="form-group">
										<label for="FIRSTNAME" class="col-sm-3 control-label">Vendor Name</label>
										<label for="FIRSTNAME" class="col-sm-9 control-label text-left"><strong><?php echo $vendor_information['VENDOR_NAME']; ?></strong></label>
									</div>
								</div>
							</div>
							<?php echo form_close(); ?>
							<div class="panel panel-default">
								<div class="panel-heading">Performance History</div>
								<div class="panel-body">
									<table class="table table-hover">
										<thead>
											<tr>
												<th class="text-center">Time Occured</th>
												<th class="text-center">Sign</th>
												<th class="text-center">Point</th>
												<th class="text-left">Reason</th>
											</tr>
										</thead>
										<tbody>
											<?php if (count($vendor_performance) <= 0): ?>
											<tr>
												<td colspan="4" class="text-center">Tidak ada data</td>
											</tr>
											<?php endif ?>
											<?php $tot = 0; ?>
											<?php foreach ((array) $vendor_performance as $key => $value) { ?>
											<tr>
												<td class="text-center"><?php echo date('d F Y H:i:s', oraclestrtotime($value['DATE_CREATED'])) ?></td>
												<td class="text-center"><?php echo $value['SIGN']; ?></td>
												<td class="text-center"><?php echo $value['POIN_ADDED']; ?></td>
												<td><?php echo $value['KETERANGAN']; ?></td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
							<?php echo form_open("Vendor_performance_management/submit_rekap_vendor",array('class' => 'form-horizontal')); ?>
							<input type="text" name="VENDOR_NO" class="hidden" id="vendor_no" value="<?php echo $vendor_information['VENDOR_NO']; ?>">
							<div class="panel panel-default">
							<div class="panel-heading">Adjustment</div>
								<div class="panel-body">
									
									<div class="form-group additional">
										<label for="REASON" class="col-sm-3 control-label">Criteria Name</label>
										<div class="col-sm-6">
											<input type="text" placeholder="Criteria Name" class="form-control" name="criteria_name" required="required">
										</div>
									</div>
									<div class="form-group additional">
										<label for="SIGN" class="col-sm-3 control-label">Arithmatic Sign</label>
										<div class="col-sm-6">
											<select class="form-control" name="sign" id="sign" required="required">
												<option value="0" selected="selected" disabled="disabled">Select Sign</option>
												<option value="+">Add (+)</option>
												<option value="-">Substract (-)</option>
												<option value="=">Equal (=)</option>
											</select>
										</div>
									</div>
									<div class="form-group additional">
										<label for="VALUE" class="col-sm-3 control-label">Value</label>
										<div class="col-sm-6">
											<input type="text" placeholder="Value" name="value" id="value" class="form-control" required="required">
										</div>
									</div>
									<div class="form-group additional">
										<label for="VALUE" class="col-sm-3 control-label">Reason</label>
										<div class="col-sm-6">
											<input type="text" placeholder="Reason" name="Reason" id="Reason" class="form-control" required="required">
										</div>
									</div>
								</div>
								<div class="panel-footer text-center">
									<a href="<?php echo site_url('Vendor_performance_management/detail_vendor_performance/'.$vendor_information['VENDOR_NO']); ?>" class="main_button small_btn reset_button">Cancel</a>
									<button class="main_button color1 small_btn" type="submit">Save</button>
								</div>
							</div>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
			</div>
		</section>