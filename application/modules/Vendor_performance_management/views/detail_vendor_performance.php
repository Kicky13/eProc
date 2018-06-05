		<section class="content_section">
			<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span>Detail Nilai Vendor non Procurement</h2>
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
									<div class="form-group">
										<label for="FIRSTNAME" class="col-sm-3 control-label">Vendor Point</label>
										<label for="FIRSTNAME" class="col-sm-9 control-label text-left"><strong>
											<?php if (count($point_vendor) != '') {
											echo $point_vendor[0]['POIN_CURR'];
										}else{
											echo "Belum Memiliki Point";
										} ?></strong></label>
									</div>
								</div>
							</div>
							<?php echo form_close(); ?>

							<?php echo form_open("Vendor_performance_management/do_insert_performance",array('class' => 'form-horizontal')); ?>
							<input type="text" name="VENDOR_NO" class="hidden" id="vendor_no" value="<?php echo $vendor_information['VENDOR_NO']; ?>">
							<div class="panel panel-default">
							<div class="panel-heading">Add Performance Criteria</div>
								<div class="panel-body">
									<div class="form-group">
										<label for="Kriteria" class="col-sm-3 control-label">Kriteria</label>
										<div class="col-sm-6">
											<select  class="form-control select2" id="criteria" name="criteria" required="required">
												<option value="0" selected="selected" disabled="disabled">Select Criteria</option>
												<?php foreach ($performance_criteria as $key => $value) { ?>
												<option value="<?php echo $value["ID_CRITERIA"]; ?>"><?php echo $value['CRITERIA_NAME']." | ".$value['CRITERIA_DETAIL']." | ".$value['CRITERIA_SCORE_SIGN']." | ".$value['CRITERIA_SCORE']; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group additional" style="display: none">
										<label for="REASON" class="col-sm-3 control-label">Criteria Name</label>
										<div class="col-sm-6">
											<input type="text" placeholder="Criteria Name" id="REASON" class="form-control" value="" required="required" title="">
											<input type="text" name="KETERANGAN" id="REASON2" class="hidden">
										</div>
									</div>
									<div class="form-group additional" style="display: none">
										<label for="SIGN" class="col-sm-3 control-label">Arithmatic Sign</label>
										<div class="col-sm-6">
											<select class="form-control" id="SIGN" required="required">
												<option value="0" selected="selected" disabled="disabled">Select Sign</option>
												<option value="+">Add (+)</option>
												<option value="-">Substract (-)</option>
												<option value="=">Equal (=)</option>
											</select>
											<input type="text" name="SIGN" id="SIGN2" class="hidden">
										</div>
									</div>
									<div class="form-group additional" style="display: none">
										<label for="VALUE" class="col-sm-3 control-label">Value</label>
										<div class="col-sm-6">
											<input type="text" placeholder="Value" name="VALUE" id="VALUE" class="form-control" value="" required="required" title="">
											<input type="text" name="VALUE" id="VALUE2" class="hidden">
										</div>
									</div>
									
								</div>
								<div class="panel-footer text-center">
									<a href="<?php echo site_url('Vendor_performance_management'); ?>" class="main_button small_btn reset_button">Back</a>
									<button class="main_button color6 small_btn" type="submit">Save</button>									
								</div>
								<?php echo form_close(); ?>
							</div>

							<div class="panel panel-default">
								<div class="panel-heading">Performance Data</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-hover">
											<thead>
												<tr>
													<th class="text-center">Time Occured</th>
													<th class="text-center">Sign</th>
													<th class="text-center">Point</th>
													<th class="text-left">Reason</th>
													<th class="text-center">Action</th>
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
													<td class="text-center"><?php echo $value['POIN']; ?></td>
													<td><?php echo $value['KETERANGAN']; ?></td>
													<?php if(count($cek_approval) <= 0) {?>
													<td class="text-center"><a class="btn btn-default" href="<?php echo base_url(); ?>Vendor_performance_management/do_delete_vendor_performance/<?php echo $value["PERF_TMP_ID"]."/".$vendor_information['VENDOR_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a></td>
													<?php } else { ?>
													<!-- <td class="text-center"><span class="label label-success">Approval</span></td> -->
													<?php } ?>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>