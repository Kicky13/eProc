<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
			</div>
			<div class="row">
				<div class="row">
					<?php if(isset($_GET["upload"]) && ($_GET["upload"] == "berhasil" || $_GET["upload"] == "gagal")) { ?>
					<div class="col-lg-12">
						<div class="alert alert-<?php echo $_GET["upload"] == "berhasil" ? "success" : "danger"; ?>">
						  <strong><?php echo ucfirst($_GET["upload"]); ?>!</strong> mengubah initial marketplace.
						</div>
					</div>
					<?php } ?>
					<div class="col-lg-offset-1 col-lg-3" style="overflow: auto; max-height: 80vh;">
						<ul>
							<a href="javascript:void(0)" onclick="setCode('lvl0',this)" class="lvl0">/ROOT</a>
						</ul>
						<ul id="tree1"> 
						</ul> 
					</div>
					<div class="col-lg-8">
					  <!-- Nav tabs -->
					  <ul class="nav nav-tabs" role="tablist">
					    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Tambah Baru</a></li>
					    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Edit Data</a></li>
					    <li role="presentation"><a href="#picture" aria-controls="picture" role="tab" data-toggle="tab">Upload Initial Marketplace</a></li>
					  </ul>
					
					  <!-- Tab panes -->
					  <div class="tab-content">
					    <div role="tabpanel" class="tab-pane active" id="home"><br />
							<?php echo form_open_multipart('EC_Master_category/baru/', array('method' => 'POST', 'class' => 'form-horizontal formBaru')); ?>
								<div class="form-group">
									<label for="parent" class="col-sm-2 control-label">Parent</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="parent" id="parent" required readonly="">
									</div>
								</div>
								<div class="form-group">
									<label for="kode" class="col-sm-2 control-label">Kode</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="kode" id="kode" required readonly="">
									</div>
								</div>
								<div class="form-group">
									<label for="desc" class="col-sm-2 control-label">Deskripsi</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="desc" id="desc" placeholder="Deskripsi" required="">
									</div>
								</div> 
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" id="btn-smpn" class="btn btn-default">
											Tambah
										</button>
									</div>
								</div>
							</form>
					    </div>
					    <div role="tabpanel" class="tab-pane" id="profile"><br />
							<?php echo form_open_multipart('EC_Master_category/edit/', array('method' => 'POST', 'class' => 'form-horizontal formEdit')); ?>
								<div class="form-group">
									<label for="parentEdit" class="col-sm-2 control-label">Kode Category</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="parent" id="kodeEdit" required readonly="">
										<input type="hidden" name="idEdit" id="idEdit" />
									</div>
								</div>
								<!-- <div class="form-group">
									<label for="kodeEdit" class="col-sm-2 control-label">Kode</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="kode" id="kodeEdit" required readonly="">
									</div>
								</div> -->
								<div class="form-group">
									<label for="descEdit" class="col-sm-2 control-label">Deskripsi</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="descEdit" id="descEdit" placeholder="Deskripsi" required="">
									</div>
								</div> 
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="button" id="btnEdit" value="ubah" name="submit" class="btn btn-info">
											Ubah
										</button>
										<button type="button" value="hapus" id="btnDelete" name="submit" class="btn btn-danger">
											Hapus
										</button>
									</div>
								</div>
							</form>
					    </div>
					    <div role="tabpanel" class="tab-pane" id="picture"><br />
							<?php echo form_open_multipart('EC_Master_category/upload/', array('method' => 'POST', 'class' => 'form-horizontal formUpload')); ?>
								<div class="form-group">
									<label for="parentEdit" class="col-sm-2 control-label">Kode Category</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="parent" id="kodeUpload" required readonly="">
										<input type="hidden" name="idUpload" id="idUpload" />
									</div>
								</div>
								<div class="form-group">
									<label for="descEdit" class="col-sm-2 control-label">Gambar</label>
									<div class="col-sm-10">
										<div class='input-group' style='width:100%;'>
											<span class='input-group-btn'>
												<span class='btn btn-primary btn-file'>
													<i class='glyphicon glyphicon-file'></i><input type='file' name='gambar' id='file_input' onchange='cek(this);'>
												</span>
											</span>
											<input type='text' class='form-control' style='padding:3px 8px 3px 8px;font-family:Menlo,Monaco,Consolas,"Courier New",monospace;font-weight:bold;' id='nama_file_input' value='Pilih file...' readonly='readonly'>
										</div>
                                                                                <div class="alert alert-danger" role="alert"> <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Tipe File: JPG,JPEG,PNG || Size File Maksimal 2mb</div>
									</div>
								</div> 
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" value="upload" name="submit" id='dis_up' class="btn btn-info">
											Ubah
										</button>
										<button type="submit" value="hapus" name="submit" id='dis_dl' class="btn btn-danger">
											Hapus
										</button>
									</div>
								</div>
							</form>					    	
					    </div>
					  </div>

					</div>
				</div>
				<div class="row">
					
				</div>
			</div>
		</div >
	</div >
</section>
