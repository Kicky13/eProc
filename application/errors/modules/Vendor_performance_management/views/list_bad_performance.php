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
							<form action="<?php echo base_url()?>Vendor_performance_management/submit_adj" method="POST">
								<div class="panel panel-default">
				                    <div class="panel-body text-center">
										<table class="table table-hover">
											<thead>
												<tr>
													<th class="text-center col-md-2">Vendor No</th>
													<th class="text-center col-md-3">Vendor Name</th>
													<th class="text-center col-md-1">Point</th>
													<th class="text-center col-md-2">Point Adjustment</th>
													<th class="text-center col-md-4">Reason</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($vendor as $key => $value) {?>
													<tr>
														<td class="text-center"><?php echo $value['VENDOR_NO'] ?></td>
														<td><?php echo $value['VENDOR_NAME'] ?></td>
														<td class="text-center"><?php echo $value['TOTAL'] ?></td>
														<td><input type="text" name="poin_adj[<?php echo $value['VENDOR_NO'] ?>]" class="form-control" placeholder="Poin"></td>
														<td><textarea  style="resize:vertical;" name="reason_adj[<?php echo $value['VENDOR_NO'] ?>]" class="form-control col-xs-12" placeholder="Reason"></textarea></td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>

								<div class="panel panel-default">
				                    <div class="panel-body text-center">
				                        <button id="submit-form" type="submit" class="main_button color1 small_btn tombolsimpan">Submit</button>
				                    </div>
				                </div> 
			                </form>

								
						</div>
					</div>
				</div>
			</div>
		</section>