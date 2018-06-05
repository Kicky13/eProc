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
					
				</div>
			</div>
			</form>
			<div class="row">
			<div class="form-group">
                    <span class="label label-info">Filter Vendor Product</span>
                  <div class="col-sm-3">
                    <select class="form-control set_product select2 alert" id="id_prod" name="id_prod">
                      <option value=""> Pilih Product Type </option>
                      <option value="1"> GOODS </option>
                      <option value="2"> SERVICES </option>
                      <option value="3"> GOODS AND SERVICES</option>
                    </select>
                  </div>
              </div>
              <br>
				<div class="panel panel-default">
					<div class="panel-body">	
						<table class="table table-hover" id="vendor_sanction_list">
							<thead>
								<tr>
									<th><span class="invisible">a</span></th>
									<th class="text-center col-md-1">Vendor Kode</th>
									<th class="text-center col-md-4">Nama Vendor</th>
									<th class="text-center col-md-2">Nama Sanksi</th>
									<th class="text-center col-md-2">Tanggal Mulai</th>
									<th class="text-center col-md-2">Tanggal Selesai</th>
									<th class="text-center col-md-1">Lama Sanksi (hari)</th>
									<th class="text-center col-md-1">Aktif</th>
									<th class="text-center">Aksi</th>												
								</tr>
								<tr>
									<th></th>
			                        <th><input type="text" class="col-xs-12"></th>
			                        <th><input type="text" class="col-xs-12"></th>
			                        <th><input type="text" class="col-xs-12"></th>
			                        <th><input type="text" class="col-xs-12"></th>
			                        <th><input type="text" class="col-xs-12"></th>
			                        <th><input type="text" class="col-xs-12"></th>
			                        <th><input type="text" class="col-xs-12"></th>
			                        <th></th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
