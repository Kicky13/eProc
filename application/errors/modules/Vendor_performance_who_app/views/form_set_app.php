<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
			</div>
			<?php if ($this->session->flashdata('success') == 'success'){?>
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Sukses.</strong> Data berhasil disimpan.
				</div>
			<?php }else{echo "kosong";}?>
			<div class="row">
				<div class="col-md-12">
					<form method="post" action="<?php echo base_url('Vendor_performance_who_app/save_who_app'); ?>">
					<div class="panel panel-default">
						<div class="panel-heading">Setting Rule Approve Vendor</div>	
                        <div class="panel-body">
									<div class="form-group">
										<label for="NPP" class="col-sm-3 control-label">Tahap 1</label>
										<label for="NPP" class="col-sm-9 control-label text-left"><div class="col-sm-6">
											<select class="form-control" id="tahap-1" required="required" name="tahap-1">
												<?php foreach ($list_tahap_1 as $key => $value) { ?>
												<option value="<?php echo $value["ID"]; ?>"><?php echo $value['FULLNAME']; ?></option>
												<?php } ?>
											</select>
										</div></label>
									</div>
									<div class="form-group">
										<label for="FIRSTNAME" class="col-sm-3 control-label">Tahap 2</label>
										<label for="FIRSTNAME" class="col-sm-9 control-label text-left"><div class="col-sm-6">
											<select class="form-control" id="tahap-2" required="required" name="tahap-2">
												<?php foreach ($list_tahap_2 as $key => $value) { ?>
												<option value="<?php echo $value["ID"]; ?>"><?php echo $value['FULLNAME']; ?></option>
												<?php } ?>
											</select>
										</div></label>
									</div>
								</div>
						<div class="panel-body text-center">
							<button name="aksi" class="btn btn-success submit_button" value="1">Simpan</button>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<script>

</script>