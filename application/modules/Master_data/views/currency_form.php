		<section class="content_section">
			<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span>Manajemen Mata Uang</h2>
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
								$url = ($currency) ? "Master_data/do_update_currency/".$currency["CURR_ID"] : "Master_data/do_create_currency";
								echo form_open($url,array('class' => 'form-horizontal')); ?>
								<div class="panel-heading">Detail Mata Uang</div>
								<div class="panel-body">
									<div class="form-group">
										<label for="CURR_CODE" class="col-sm-3 control-label">Kode Mata Uang</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="CURR_CODE" name="CURR_CODE" value="<?php if($currency) echo $currency['CURR_CODE'] ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="CURR_NAME" class="col-sm-3 control-label">Nama Mata Uang</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="CURR_NAME" name="CURR_NAME" value="<?php if($currency) echo $currency['CURR_NAME'] ?>">
										</div>
									</div>
								</div>
								<div class="panel-footer text-center">
									<a href="<?php echo site_url('Master_data/currency'); ?>" class="main_button small_btn reset_button">Cancel</a>
									<button class="main_button color1 small_btn" type="submit">Save</button>
								</div>
								<?php echo form_close(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>