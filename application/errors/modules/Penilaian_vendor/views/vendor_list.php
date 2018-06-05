		<section class="content_section">
			<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span>Penilaian Vendor</h2>
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
									Penilaian Vendor
								</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-md-4">
											<form id="form_filter">
												<input type="text" id="filter_vnd_list" name="search" class="form-control" placeholder="Filter">
												<br>
											</form>
										</div>
									</div>
									<table class="table table-hover" id="penilaian_vendor_list">
										<thead>
											<tr>
												<th class="text-center">Vendor No</th>
												<th class="text-left">Vendor Name</th>
												<th class="text-center">Point</th>
												<th class="text-center">Category</th>
												<th class="text-center" style="width: 170px">Aksi</th>
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