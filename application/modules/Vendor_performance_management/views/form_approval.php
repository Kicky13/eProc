<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
			</div>
			<?php if ($this->session->flashdata('success') == 'success'): ?>
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Sukses.</strong> Data berhasil disimpan.
				</div>
			<?php endif ?>
			<div class="row">
				<div class="col-md-12">
					<div class="form-horizontal">
						<div class="panel panel-default">
							<div class="panel-heading">Vendor Information</div>
							<div class="panel-body">
								<div class="form-group">
									<label for="NPP" class="col-sm-3 control-label">Vendor No</label>
									<label for="NPP" class="col-sm-9 control-label text-left"><strong><?php echo $non_proc[0]['VENDOR_NO']; ?></strong></label>
								</div>

								<div class="form-group">
									<label for="FIRSTNAME" class="col-sm-3 control-label">Vendor Name</label>
									<label for="FIRSTNAME" class="col-sm-9 control-label text-left"><strong><?php echo $non_proc[0]['VENDOR_NAME']; ?></strong></label>
								</div>

								<div class="form-group">
									<label for="FIRSTNAME" class="col-sm-3 control-label">Vendor Point</label>
									<label for="FIRSTNAME" class="col-sm-9 control-label text-left"><strong>
										<?php if (count($hist_vendor) != '') {
											echo $hist_vendor[0]['POIN_CURR'];
										}else{
											echo "Belum Memiliki Point";
										} ?></strong></label>
								</div>

							</div>
						</div>
					</div>

					<form method="post" action="<?php echo base_url('Vendor_performance_management/approve_manual') ?>">
                  	<input value="<?php echo $emplo[0]['LEVEL']; ?>" id="level" type="hidden">
					<div class="panel panel-default">
						<div class="panel-heading">Persetujuan Penilaian Vendor</div>
						<table class="table table-hover">
							<thead>
								<th>Approve</th>
								<th>Date Created</th>
								<th>External Code</th>
								<th>Criteria</th>
								<th>Point</th>
							</thead>
							<tbody>
								<form>
								<?php if (count($non_proc) <= 0): ?>
									<tr><td class="text-center" colspan="5">Data tidak ada</td></tr>
								<?php endif ?>
								<?php foreach ($non_proc as $val): ?>
									<tr>
										<td align="center"><input type="checkbox" class="cek_tmp" name="tmp_id" value="<?php echo $val['PERF_TMP_ID'] ?>"checked></td>
										<td><?php echo vendorfromdate($val['DATE_CREATED']) ?></td>
										<td><?php echo $val['EXTERNAL_CODE'] ?></td>
										<td><?php echo $val['KETERANGAN'] ?></td>
										<td><?php echo $val['SIGN']." ".$val['POIN'] ?></td>
									</tr>
								<?php endforeach ?>
								</form>
							</tbody>
						</table>
						<?php if (count($non_proc) > 0): ?>
						<div class="panel-body text-center">
                  			<a href="<?php echo base_url(); ?>Vendor_management/job_list" class="main_button small_btn">Back</a>
							<button id="approve_penilaian" class="btn btn-success submit_button">Submit</button>
						</div>
						<?php endif ?>
					</div>
					</form>
					<input type="text" class="hidden vendor_no" id="vendor_no" name="vendor_no" value="<?php echo set_value('vendor_no', $vendor_detail[0]["VENDOR_NO"]); ?>">
				</div>
			</div>
		</div>
	</div>
</section>
