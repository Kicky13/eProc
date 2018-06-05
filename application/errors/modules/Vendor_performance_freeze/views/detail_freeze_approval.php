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
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Failed!</strong> <?php echo $this->session->flashdata('failed'); ?>
					</div>
					<?php } ?>
					<?php echo form_open("#",array('class' => 'form-horizontal')); ?>
					<div class="panel panel-default">
						<div class="panel-heading">Vendor Information</div>
						<div class="panel-body">
							<div class="form-group">
								<label for="NPP" class="col-sm-3 control-label">Vendor No</label>
								<label for="NPP" class="col-sm-9 control-label text-left"><strong><?php echo $vendor_information['VENDOR_NO']; ?></strong></label>
							</div>
							<div class="form-group">
								<label for="FIRSTNAME" class="col-sm-3 control-label">Vendor Name</label>
								<label for="FIRSTNAME" class="col-sm-9 control-label text-left"><strong><?php echo $vendor_information['VENDOR_NAME']; ?></strong></label>
							</div>
						</div>
					</div>
					<?php echo form_close(); ?>
					<div class="panel panel-default">
						<div class="panel-heading">Performance History</div>
						<div class="panel-body">
							<table class="table table-hover">
								<thead>
									<tr>
										<th class="text-center">Time Occured</th>
										<th class="text-center">Sign</th>
										<th class="text-center">Point</th>
										<th class="text-center">Point Previous</th>
										<th class="text-center">Point Current</th>
										<th class="text-left">Reason</th>
									</tr>
								</thead>
								<tbody>
									<?php if (count($vendor_performance) <= 0): ?>
									<tr>
										<td colspan="4" class="text-center">Tidak ada data</td>
									</tr>
									<?php endif ?>
									<?php $tot = 0; ?>
									<?php foreach ((array) $vendor_performance as $key => $value) { ?>
									<tr>
										<td class="text-center"><?php echo date('d F Y H:i:s', oraclestrtotime($value['DATE_CREATED'])) ?></td>
										<td class="text-center"><?php echo $value['SIGN']; ?></td>
										<td class="text-center"><?php echo $value['POIN_ADDED']; ?></td>
										<td class="text-center"><?php echo $value['POIN_PREV'];?></td>
										<td class="text-center <?php echo ($key==(count($vendor_performance)-1))?'info':'';?>"><?php echo $value['POIN_CURR']; $tot=($key==(count($vendor_performance)-1))?$value['POIN_CURR']:0; ?></td>
										<td><?php echo $value['KETERANGAN']; ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					<?php echo form_open("Vendor_performance_freeze/approve",array('class' => 'form-horizontal form_simpan')); ?>
					<input type="hidden" name="id_rekap_approve" class="" id="id_rekap_approve" value="<?php echo $id_rekap_approve; ?>">
					<input type="hidden" name="id_rekap" class="" id="id_rekap" value="<?php echo $id_rekap; ?>">
					<input type="hidden" name="id_hist" class="" id="id_hist" value="<?php echo $id_hist; ?>">
					<div class="panel panel-default">
					<div class="panel-heading">Adjustment</div>
						<div class="panel-body">
							<div class="form-group additional">
								<label for="REASON" class="col-sm-3 control-label">Total Point</label>
								<div class="col-sm-1">
									<input type="text" placeholder="Total Poin" class="form-control" name="total_point" id="total_point" value="<?php echo $rekap['POIN_PREV'];?>" readonly="readonly">
								</div>
							</div>
							<div class="form-group additional">
								<label for="SIGN" class="col-sm-3 control-label">Arithmatic Sign</label>
								<div class="col-sm-2">
									<select class="form-control" name="sign" id="sign" required="required">
										<option value="0" disabled="disabled">Select Sign</option>
										<option value="+" <?php echo ($rekap['SIGN']=='+')?'selected="selected"':''?> >Add (+)</option>
										<option value="-" <?php echo ($rekap['SIGN']=='-')?'selected="selected"':''?> >Substract (-)</option>
										<option value="=" <?php echo ($rekap['SIGN']=='=')?'selected="selected"':''?> >Equal (=)</option>
									</select>
								</div>
							</div>
							<div class="form-group additional">
								<label for="VALUE" class="col-sm-3 control-label">Adjustment Value</label>
								<div class="col-sm-1">
									<input type="text" placeholder="Value" name="value" id="value" class="form-control" value="<?php echo $rekap['POIN_ADDED'];?>" required="required">
								</div>
							</div>
							<div class="form-group additional">
								<label for="VALUE" class="col-sm-3 control-label">Adjusted Point</label>
								<div class="col-sm-1">
									<input type="text" placeholder="Value" name="adj_point" id="adj_point" class="form-control" value="<?php echo $rekap['POIN_CURR'];?>" readonly="readonly">
								</div>
								<div class="col-sm-3 ">
									<span id="span_sanction" name="span_sanction"></span>
								</div>
							</div>
							<div class="form-group additional">
								<label for="VALUE" class="col-sm-3 control-label">Reason</label>
								<div class="col-sm-6">
									<input type="text" name="Reason" id="Reason" class="form-control" value="<?php echo $rekap['KETERANGAN'];?>" required="required" readonly="readonly">
								</div>
							</div>
						</div>
						<div class="panel-footer text-center">	
							<a href="<?php echo site_url('Vendor_performance_freeze/rekap_approval'); ?>" class="main_button small_btn color1">Cancel</a>
							<button class="main_button color6 small_btn simpan" type="button">Approve</button>
						</div>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</section>