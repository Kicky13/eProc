<style type="text/css">
    .dt-body-right{
        text-align:right;
    }
</style>
<?php $this->load->view('vmi_menubar');?>
<section class="content_section">
			<div class="content_spacer">
				<div class="content">
					<div class="main_title centered upper">
						<h2><span class="line"><i class="ico-users"></i></span>Goods Issued</h2>
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
									<div class="panel-title pull-left">List All VMI</div>
									<div class="btn-group pull-right">
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="panel-body">
									<table class="table table-hover" id="vmi_list_gi">
										<thead>
											<tr>
												<th class="text-center">No Reservation</th>
												<th class="text-center">Posting Date</th>
												<th class="text-center">Document Date</th>
                                                                                                <th class="text-center">Mat Doc</th>
												<th class="text-center">Plant</th>
												<th class="text-center">Storage Location</th>
												<th class="text-center">Material Code</th>
                                                                                                <th class="text-center">Material Name</th>
												<th class="text-center">Quantity</th>
											</tr>
										</thead>
                                                                                <tbody>
                                                                                    <?php 
                                                                                        foreach ($data_gi as $key => $value) {
                                                                                            echo '<tr>';
                                                                                            echo "<td>".$value->NO_RESERVASI."</td>";
                                                                                            echo "<td>".$value->POSTING_DATE."</td>";
                                                                                            echo "<td>".$value->DOC_DATE."</td>";
                                                                                            echo "<td>".$value->MAT_DOC."</td>";
                                                                                            echo "<td>".$value->PLANT."</td>";
                                                                                            echo "<td>".$value->SLOC."</td>";
                                                                                            echo "<td>".$value->KODE_MATERIAL."</td>";
                                                                                            echo "<td>".$value->DESCRIPTION."</td>";
                                                                                            echo "<td>".$value->QUANTITY."</td>";
                                                                                            echo '</tr>';
                                                                                        }
                                                                                    ?>
                                                                                </tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>