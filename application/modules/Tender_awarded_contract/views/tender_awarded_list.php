		<section class="content_section">
			<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span>Daftar Contract</h2>
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
									Daftar Contract
								</div>
								<div class="panel-body">
									<table class="table table-hover" id="tender_awarded_list">
										<thead>
											<th class="">Action</th>
											<th class="">Contract Number</th>
											<th class="">No RFQ</th>
											<th class="">DOC Date</th>
											<th class="">Valid Start Date</th>
											<th class="">Valid End Date</th>											
											<th class="">No Material</th>
											<th class="">Short Text</th>
											<th class="">Qty</th>
											<th class="">UoM</th>
											<th class="">Net Price</th>
											<th class="">Total Price</th>
											<th class="">Currency</th>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>