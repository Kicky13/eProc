		<section class="content_section">
			<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span>Manajemen Delivery Point</h2>
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
								<?php
								$url = ($del_point) ? "Master_data/do_update_del_point/".$del_point["DEL_POINT_ID"] : "Master_data/do_create_del_point";
								echo form_open($url,array('class' => 'form-horizontal')); ?>
								<div class="panel-heading">Detail Delivery Point</div>
								<div class="panel-body">
									<div class="form-group">
										<label for="DEL_POINT_CODE" class="col-sm-3 control-label">Kode Delivery Point</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="DEL_POINT_CODE" name="DEL_POINT_CODE" value="<?php if($del_point) echo $del_point['DEL_POINT_CODE'] ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="DEL_POINT_NAME" class="col-sm-3 control-label">Nama Delivery Point</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="DEL_POINT_NAME" name="DEL_POINT_NAME" value="<?php if($del_point) echo $del_point['DEL_POINT_NAME'] ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="city" class="col-sm-3 control-label">Plant</label>
										<div class="col-sm-3">
											<label for="PLANT_CODE" class="custom_select">
												<span class="lfc_alert"></span>
												<select name="PLANT_CODE" id="PLANT_CODE" required="">
													<option value="" selected="" disabled="">Plant</option>
													<?php foreach ($plant as $key => $value) { ?>
														<option value="<?php echo $value["PLANT_CODE"]; ?>" <?php if($value["PLANT_CODE"] == $del_point["PLANT_CODE"]) echo "selected=\"selected\"" ?>><?php echo $value["PLANT_NAME"]; ?></option>
													<?php } ?>
												</select>
											</label>
										</div>
									</div>
								</div>
								<div class="panel-footer text-center">
									<a href="<?php echo site_url('Master_data/del_point'); ?>" class="main_button small_btn reset_button">Cancel</a>
									<button class="main_button color1 small_btn" type="submit">Save</button>
								</div>
								<?php echo form_close(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>