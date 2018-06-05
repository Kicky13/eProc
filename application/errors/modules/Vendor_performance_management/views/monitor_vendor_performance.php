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
							<div class="panel panel-default">
								<div class="panel-heading">
									<?php echo $title ?>
								</div>
								<div class="panel-body">
									<table class="table table-hover" id="vendor_monitor_list">
										<thead>
											<tr>
                        						<th><span class="invisible">a</span></th>
												<th class="text-center col-md-2">Vendor No</th>
												<th class="text-left col-md-4">Vendor Name</th>
												<th class="text-left col-md-3">LAST UPDATE</th>
												<th class="text-center col-md-1">Point</th>
												<th class="text-center col-md-2">Status Rekap</th>
												<th class="text-center col-md-1">Aksi</th>												
											</tr>
											<tr>
						                        <th></th>
						                        <th><input type="text" class="col-xs-12"></th>
						                        <th><input type="text" class="col-xs-12"></th>
						                        <th><input type="text" class="col-xs-12"></th>
						                        <th><input type="text" class="col-xs-12"></th>
						                        <th><input type="text" class="col-xs-12"></th>
						                        <th></th>
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