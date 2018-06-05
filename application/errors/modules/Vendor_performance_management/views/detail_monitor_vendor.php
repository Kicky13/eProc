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
										<th class="text-center">Trigger By</th>
										<th class="text-center">Procurement/Non Procurement</th>
										<th class="text-center">Reference Code</th>
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
										<td class="text-center"><?php echo ($value['CRITERIA_ID']==NULL)?'Rekap':(($value['CRITERIA_TRIGGER_BY']==0)?'System':'Manual');?></td>
										<td class="text-center"><?php echo ($value['T_OR_V']=='T')?'Procurement':'Non Procurement';?></td>
										<td class="text-center"><?php echo $value['EXTERNAL_CODE']; ?></td>
										<td><?php echo $value['KETERANGAN']; ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					
					<div class="panel-footer text-center">	
						<a href="<?php echo site_url('Vendor_performance_management/monitor'); ?>" class="main_button small_btn color1">Kembali</a>
				
					</div>
				
					
				</div>
			</div>
		</div>
	</div>
</section>