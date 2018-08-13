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

							<div class="panel-group" id="accordionperbarui" role="tablist" aria-multiselectable="true">
								<div class="panel panel-default">
									<div class="panel-heading" id="headingOne" role="button" data-toggle="collapse" data-parent="#accordionperbarui" href="#collapsePerbarui" aria-expanded="true" aria-controls="collapseOne">
										<h4 class="panel-title">Refresh</h4>
									</div>
									<div id="collapsePerbarui" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
										<div class="panel-body">
											<form id="etor-form" enctype="multipart/form-data" method="post" action="<?php echo base_url()?>Tender_awarded_spb/refreshPO">
												<div class="row">
													<div class="col-md-2">
														<select id="berdasarkan" class="input-sm">
															<option value="pr">Nomor PO</option>
														</select>
													</div>
													<div class="col-md-3">
														<input name="no_po" type="text" class="input-sm" placeholder="Filter" maxlength="10">
													</div>
													<div class="col-md-1">
														<button class="btn btn-default" id="renewPR">Refresh</button>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>

							<div class="panel panel-default">
								<div class="panel-heading">
									Daftar PO
								</div>
								<div class="panel-body">
									<table class="table table-hover" id="tender_awarded_list" width="100%">
										<thead>
											<th class="">Action</th>
											<th class="">PO Number</th>
											<th class="">Vendor</th>
											<!-- <th class="">No RFQ</th>
											<th class="">DOC Date</th>
											<th class="">Delivery Date</th>
											<th class="">Release Date</th>											
											<th class="">No Material</th>
											<th class="">Short Text</th>
											<th class="">Qty</th>
											<th class="">UoM</th>
											<th class="">Net Price</th>
											<th class="">Total Price</th>
											<th class="">Currency</th> -->
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