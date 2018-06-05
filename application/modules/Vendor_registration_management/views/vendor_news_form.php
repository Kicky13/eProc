		<section class="content_section">
			<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span>Manajemen Berita</h2>
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
								echo form_open("Vendor_registration_management/do_create_vendor_news/",array('class' => 'form-horizontal')); ?>
							<div class="panel panel-default">
								<div class="panel-heading">Detail Berita</div>
								<div class="panel-body">
									<div class="form-group">
										<label for="NEWS_TITLE" class="col-sm-3 control-label">Judul Berita</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="NEWS_TITLE" name="NEWS_TITLE">
										</div>
									</div>
								</div>
							</div>
							<textarea name="NEWS_CONTENT" id="news">
							</textarea>
							<div class="panel panel-default">
								<div class="panel-footer text-center">
									<a href="<?php echo site_url('Vendor_registration_management/news'); ?>" class="main_button small_btn reset_button">Cancel</a>
									<button class="main_button color1 small_btn" type="submit">Save</button>
								</div>
								<?php echo form_close(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>