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
							<?php if($this->session->flashdata('failed')) { ?>
							<div class="alert alert-warning alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<strong>Failed!</strong> <?php echo $this->session->flashdata('failed'); ?>
							</div>
							<?php } ?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<?php echo $title ?>
								</div>
								<div class="panel-body">
											<form id="form_approve" action="Vendor_performance_freeze/approve_selected" method="POST" >
												<!-- <input type="text" id="filter_vnd_freeze" name="search" class="form-control" placeholder="Filter"> -->
												<!-- <br> -->
											
									<table class="table table-hover" id="vendor_freeze_approval_list">
										<thead>
											<tr>
												<th class="text-center">Vendor No</th>
												<th class="text-left">Vendor Name</th>
												<th class="text-left">Start</th>
												<th class="text-left">End</th>
												<th class="text-left">Date Created</th>
												<th class="text-center">Point</th>
												<th class="text-center" style="width: 70px">Aksi</th>
												<th class="text-center" style="width: 50px">
													<input type="button" class="main_button color6" disabled="disabled" id="approve_checked" name="approve_checked" value="Approve Selected"/>
													<input type="checkbox" id="check_all" name="check_all" title="Select All"/>													
												</th>
											</tr>
										</thead>
									</table>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>