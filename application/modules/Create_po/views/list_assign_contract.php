
        <section class="content_section">
            <div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php if (!empty($success)): ?>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Success!</strong> <?php echo $success ?>
                                </div>
                            <?php endif ?>

                            <?php if (!empty($warning)): ?>
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Warning!</strong> <?php echo $warning ?>
                                </div>
                            <?php endif ?>
							<table id="job-list-table" class="table table-striped">
								<thead>
									<tr>
										<th>No</th>
                                        <th>Nomor PR</th>
                                        <th>PR Item</th>
                                        <th>Mat Number</th>
                                        <th>Description</th>
                                        <th>Material Group</th>
                                        <th>PR Qty</th>
                                        <th>Tender Qty</th>
                                        <th>PO Qty</th>
                                        <th>Open Qty</th>
                                        <th>Doc Type</th>
                                        <th>Plant</th>
                                        <th>Purch Grp</th>
                                        <th>MRPC</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</section>