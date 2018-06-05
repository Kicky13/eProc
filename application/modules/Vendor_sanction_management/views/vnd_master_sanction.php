<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
			</div>
			<?php if ($this->session->flashdata('success') != ''): ?>
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Sukses.</strong> <?php echo $this->session->flashdata('success');?>
				</div>
			<?php endif ?>
			<?php if ($this->session->flashdata('failed')!=''): ?>
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>FAILED.</strong> <?php echo $this->session->flashdata('failed');?>
				</div>
			<?php endif ?>
			<form method="post" action="<?php echo base_url('Vendor_sanction_management/save_master_sanction') ?>">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">Form Master Sanksi Vendor</div>
						<div class="panel-body">
							<div class="col-md-2">
								<input type="hidden" id="id_master_sanksi" name="id_master_sanksi" value="<?php echo isset($M_SANCTION_ID)?$M_SANCTION_ID:'';?>"/>
								<input type="text" id="nama_sanksi" name="nama_sanksi" class="form-control" placeholder="Nama Sanksi" value="<?php echo isset($SANCTION_NAME)?$SANCTION_NAME:'';?>"/>
							</div>
							<div class="col-md-2">
							<select id="jenis_sanksi" name="jenis_sanksi"  class="form-control">
									<option disabled value="">Pilih Jenis Sanksi</option>
									<option value="UMUM" <?php echo (isset($CATEGORY)&&$CATEGORY=='UMUM')?'Selected="selected"':'';?>>UMUM</option>
									<option value="KHUSUS" <?php echo (isset($CATEGORY)&&$CATEGORY=='KHUSUS')?'Selected="selected"':'';?>>KHUSUS</option>
							</select>			
							</div>				
							<div class="col-md-2">
								<input type="text" id="batas_bawah" name="batas_bawah" class="form-control" placeholder="Batas Bawah" value="<?php echo isset($LOWER)?$LOWER:'';?>"/>
							</div>
							<div class="col-md-2">
								<input type="text" id="batas_atas" name="batas_atas" class="form-control" placeholder="Batas Atas" value="<?php echo isset($UPPER)?$UPPER:'';?>"/>
							</div>
							<div class="col-md-2">
								<input type="text" id="lama_sanksi" name="lama_sanksi" class="form-control" placeholder="Lama Sanksi (Hari)" value="<?php echo isset($DURATION)?$DURATION:'';?>"/>
							</div>
							<div class="col-md-1">
								<input type="checkbox" id="status" name="status" value="<?php echo isset($STATUS)?$STATUS:'0';?>" <?php echo (isset($STATUS)&&$STATUS==1)?'checked="checked"':'';?> />
								<label for="status"> Aktif</label>
							</div>
						</div>					
						<div class="panel-body text-center">
							<button type="reset" class="main_button color6 small_btn">Reset</button>
							<button type="submit" class="main_button color6 small_btn">Save</button>
						</div>
					</div>
					
				</div>
			</div>
			</form>
			<table class="table table-hover" id="vendor_sanction_list">
						<thead>
							<tr>
								<th class="text-left">Nama Sanksi</th>
								<th class="text-left">Jenis Sanksi</th>
								<th class="text-center">Batas Bawah</th>
								<th class="text-center">Batas Atas</th>
								<th class="text-center">Lama Sanksi (hari)</th>
								<th class="text-center">Aktif</th>
								<th class="text-center" style="width: 170px">Aksi</th>												
							</tr>
						</thead>
					</table>
		</div>
	</div>
</section>
