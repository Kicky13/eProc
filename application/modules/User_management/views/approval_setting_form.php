		<input type="text" class="hidden" id="base_url" value="<?php echo base_url(); ?>">
		<section class="content_section">
			<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span>Pengaturan Approval</h2>
					</div>
					<div class="row">
						<div class="col-md-12">
							<?php if($this->session->flashdata('success')) { ?>
							<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
							</div>
							<?php } ?>
							<?php
							$url = ($approval_setting) ? "User_management/do_update_approval_setting/".$approval_setting["COMPANYID"] : "User_management/do_create_approval_setting";
							echo form_open($url,array('class' => 'form-horizontal')); ?>
							<div class="panel panel-default">
								<div class="panel-heading">Company Information</div>
								<div class="panel-body">
									<div class="form-group">
										<label for="NPP" class="col-sm-3 control-label">Company ID</label>
										<label for="NPP" class="col-sm-9 control-label text-left"><strong><?php echo $approval_setting['COMPANYID']; ?></strong></label>
									</div>
									<div class="form-group">
										<label for="FIRSTNAME" class="col-sm-3 control-label">Company Name</label>
										<label for="FIRSTNAME" class="col-sm-9 control-label text-left"><strong><?php echo $approval_setting['COMPANYNAME']; ?></strong></label>
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<input type="text" class="hidden" name="COMPANYID" value="<?php echo $approval_setting["COMPANYID"]; ?>">
								<div class="panel-heading">
									<div class="panel-title pull-left">Setting Details</div>
									<div class="btn-group pull-right">
										<a data-toggle="collapse" href="#addPositionHolder" aria-expanded="false" aria-controls="addPositionHolder" class="btn btn-success btn-sm">Add Position</a>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="panel-body">
									<table class="table table-hover margin-top-5">
										<thead>
											<tr>
												<th class="text-center">Order</th>
												<th class="text-center">Department Name</th>
												<th class="text-center">Position Name</th>
												<th class="text-center">Action</th>
											</tr>
										</thead>
										<tbody id="apprv_set_detail">
										</tbody>
									</table>
								</div>
								<hr class="no_margin_bottom">
								<div class="collapse padding-top-20" id="addPositionHolder">
									<div class="panel-body">
										<div class="form-group">
											<label for="account_no" class="col-sm-3 control-label">Department</label>
											<div class="col-sm-7">
												<label for="DEPT" class="custom_select">
													<span class="lfc_alert"></span>
													<select id="DEPT">
														<option value="" selected="" disabled="">Department</option>
														<?php foreach ($dept as $key => $value) { ?>
															<option value="<?php echo $value["DEPT_ID"]."-".$value["DEPT_NAME"]; ?>"><?php echo $value["DEPT_NAME"]; ?></option>
														<?php } ?>
													</select>
												</label>
											</div>
										</div>
										<div class="form-group">
											<label for="account_no" class="col-sm-3 control-label">Position</label>
											<div class="col-sm-7">
												<label for="ADM_POS_ID" class="custom_select">
													<span class="lfc_alert"></span>
													<select id="ADM_POS_ID">
														<option value="" selected="" disabled="">Position</option>
													</select>
												</label>
											</div>
										</div>
									</div>
									<div class="panel-footer text-center">
										<a class="main_button small_btn" data-toggle="collapse" href="#addPositionHolder" aria-expanded="false" aria-controls="addPositionHolder">Close</a>
										<button id="add_apprv_set_det" class="main_button color1 small_btn" type="button">Add Data</button>
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-footer text-center">
									<a href="<?php echo site_url('User_management/approval_setting'); ?>" class="main_button small_btn reset_button">Cancel</a>
									<button class="main_button color1 small_btn" type="submit">Save</button>
								</div>
							</div>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
			</div>
		</section>