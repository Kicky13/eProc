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
											<form id="form_filter">
												<!-- <input type="text" id="filter_vnd_freeze" name="search" class="form-control" placeholder="Filter"> -->
												<!-- <br> -->
												<?php
												if($this->session->flashdata('start')){
													$start = $this->session->flashdata('start');
												}
												if($this->session->flashdata('end')){
													$end = $this->session->flashdata('end');
												}
												?>
												<div class="row">
													<div class="col-md-2">
														Periode Rekap:
													</div>
													<div class="col-md-2">
														<div class="input-group date">												
						                                	<input type="text" name="periode_awal" value="<?php echo isset($start)?$start:''; ?>" placeholder="Tanggal Awal" id="periode_awal" class="periode_awal form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
						                            	</div>
						                            </div>
						                            <div class="col-md-2">
							                            <div class="input-group date">
							                                <input type="text" name="periode_akhir" value="<?php echo isset($end)?$end:''; ?>"  placeholder="Tanggal Akhir" id="periode_akhir" class="periode_akhir form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
							                            </div>
						                        	</div>
						                            <div class="col-md-2">
						                            	<button id="btn_tampilkan_vendor" type="submit" name="Tampilkan Vendor" class="main_button color2">Tampilkan Vendor</button>
						                            </div>
						                            <div calss="col-md-2">
														<a href="<?=site_url('Vendor_performance_freeze/get_all_vendor_freeze_excel')?>" target='_blank' class="main_button color6" id="idexcell">Export Excel&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-download-alt"></span></a>
						                            </div>
					                            
					                            </div>
											</form>
									<table class="table table-hover" id="vendor_freeze_list">
										<thead>
											<tr> 
                        						<th><span class="invisible">a</span></th>
												<th class="text-center">Vendor No</th>
												<th class="text-left">Vendor Name</th>
												<th class="text-left">LAST UPDATE</th>
												<th class="text-center">Point</th>
												<th class="text-center" style="width: 170px">Action</th>												
											</tr>
											<tr>
						                        <th></th>
						                        <th><input type="text"></th>
						                        <th><input type="text"></th>
						                        <th><input type="text"></th>
						                        <th><input type="text"></th>
						                        <th style="width: 170px"></th>
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