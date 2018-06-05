<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php
// print_r($tod);
?>
<style>
	.tablee > tbody > tr > td {
		padding: 4px;
	}
	/*@media print {
	 body * {
	 visibility: hidden;
	 }
	 #section-to-print, #section-to-print * {
	 visibility: visible;
	 }
	 #section-to-print {
	 position: absolute;
	 left: 0;
	 top: 0;
	 }
	}*/
</style>

<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="main_title centered upper">
				<h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							Transaksi PO yang dipilih
							<input type="hidden" name="opco" id="opco" value="<?php echo $COMPANYID ?>">
							<button type="submit" class="btn btn-danger btn-sm pull-right">
								<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
							</button>
						</div>
						<table id="example2" class="table tablee table-hover" >
							<thead>
								<th class="no-sort">No</th>
								<th>No PO</th>
								<th>No ITEM</th>
								<th>Description</th>
								<th>Vendor</th>
								<th>Quantity</th>
								<th>Nilai PO</th>
								<th>Status Approval</th>
								<th>Satuan</th>
								<th>TOD</th>
								<th>Aksi</th>
							</thead>
							<tbody id="resultPO">
							</tbody>
						</table>
					</div>
				</div>
			</div>


			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							Transaksi PO yang dipilih
							<input type="hidden" name="opco" id="opco" value="<?php echo $COMPANYID ?>">
							<button type="submit" class="btn btn-danger btn-sm pull-right">
								<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
							</button>
						</div>
						
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#home">Biaya I</a></li>
							<li><a data-toggle="tab" href="#menu1">Biaya II</a></li>
							<!-- <li><a data-toggle="tab" href="#menu2">Menu 2</a></li> -->
						</ul>

						<form class="form-horizontal" enctype="multipart/form-data" method="POST" id="formrooms">
							<div class="tab-content">
								<div id="home" class="tab-pane fade in active">
									<p>
										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												NO_PO
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="col-sm-3">
												<input type="text" readonly="readonly" class="form-control" id="NO_PO" name="NO_PO">
											</div>
											<div class="colm-sm-6">
											</div>
										</div>

										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												HS_CODE
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="col-sm-3">
												<input type="text" class="form-control" id="HS_CODE" name="HS_CODE">
											</div>
											<div class="colm-sm-6">
											</div>
										</div>

										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												NO_LS
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="col-sm-3">
												<input type="text" class="form-control" id="NO_LS" name="NO_LS">
											</div>
											<div class="colm-sm-6">
											</div>
										</div>

										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												NO_CERT
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="col-sm-3">
												<input type="text" class="form-control" id="NO_CERT" name="NO_CERT">
											</div>
											<div class="colm-sm-6">
											</div>
										</div>


										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												DOC_PPL
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="colm-sm-6">
												<input name="DOC_PPL" id="DOC_PPL" onchange="return ValidateFileUploadDOC_PPL()" accept="application/msword, application/pdf" type="file">
											</div>
										</div>

										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												DOC_BILLING
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="colm-sm-6">
												<input name="DOC_BILLING" id="DOC_BILLING" onchange="return ValidateFileUploadDOC_BILLING()" accept="application/msword, application/pdf" type="file">
											</div>
										</div>

										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												DOC_BPN
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="colm-sm-6">
												<input name="DOC_BPN" id="DOC_BPN" onchange="return ValidateFileUploadDOC_BPN()" accept="application/msword, application/pdf" type="file">
											</div>
										</div>

										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												DOC_MANIFEST
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="colm-sm-6">
												<input name="DOC_MANIFEST" id="DOC_MANIFEST" onchange="return ValidateFileUploadDOC_MANIFEST()" accept="application/msword, application/pdf" type="file">
											</div>
										</div>

										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												DOC_LS
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="colm-sm-6">
												<input name="DOC_LS" id="DOC_LS" onchange="return ValidateFileUploadDOC_LS()" accept="application/msword, application/pdf" type="file">
											</div>
										</div>

										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												DOC_INSURANCE
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="colm-sm-6">
												<input name="DOC_INSURANCE" id="DOC_INSURANCE" onchange="return ValidateFileUploadDOC_INSURANCE()" accept="application/msword, application/pdf" type="file">
											</div>
										</div>

										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												DOC_SPPB
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="colm-sm-6">
												<input name="DOC_SPPB" id="DOC_SPPB" onchange="return ValidateFileUploadDOC_SPPB()" accept="application/msword, application/pdf" type="file">
											</div>
										</div>

										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												DOC_SPTNP
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="colm-sm-6">
												<input name="DOC_SPTNP" id="DOC_SPTNP" onchange="return ValidateFileUploadDOC_SPTNP()" accept="application/msword, application/pdf" type="file">
											</div>
										</div>

										<div class="form-group">
											<label for="date_creation" class="col-sm-3 control-label">TGL
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="col-sm-3 end">
												<div class="input-group date">
													<input type="text" id="TGL" name="TGL" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label for="date_creation" class="col-sm-3 control-label">TGL_SPPB
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="col-sm-3 end">
												<div class="input-group date">
													<input type="text" id="TGL_SPPB" name="TGL_SPPB" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label for="date_creation" class="col-sm-3 control-label">TGL_PIB
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="col-sm-3 end">
												<div class="input-group date">
													<input type="text" id="TGL_PIB" name="TGL_PIB" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label for="date_creation" class="col-sm-3 control-label">TGL_DO
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="col-sm-3 end">
												<div class="input-group date">
													<input type="text" id="TGL_DO" name="TGL_DO" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label for="date_creation" class="col-sm-3 control-label">TGL_MAN
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="col-sm-3 end">
												<div class="input-group date">
													<input type="text" id="TGL_MAN" name="TGL_MAN" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label for="date_creation" class="col-sm-3 control-label">TGL_TA
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="col-sm-3 end">
												<div class="input-group date">
													<input type="text" id="TGL_TA" name="TGL_TA" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												NILAI_LS
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="col-sm-3">
												<input type="text" class="form-control format-koma" id="NILAI_LS" name="NILAI_LS">
											</div>
											<div class="colm-sm-6">
											</div>
										</div>
									</p>
								</div>
								<div id="menu1" class="tab-pane fade">
									<p>
										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												DOC_PPL1
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="colm-sm-6">
												<input name="DOC_PPL1" id="DOC_PPL1" onchange="return ValidateFileUploadDOC_PPL1()" accept="application/msword, application/pdf" type="file">
											</div>
										</div>

										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												DOC_INVOICE1
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="colm-sm-6">
												<input name="DOC_INVOICE1" id="DOC_INVOICE1" onchange="return ValidateFileUploadDOC_INVOICE1()" accept="application/msword, application/pdf" type="file">
											</div>
										</div>

										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												TOT_TAGIHAN_KONTRAK
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="col-sm-3">
												<input type="text" class="form-control format-koma" id="TOT_TAGIHAN_KONTRAK" name="TOT_TAGIHAN_KONTRAK">
											</div>
											<div class="colm-sm-6">
											</div>
										</div>

										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												NILAI_ONGKOS_ANGKUT
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="col-sm-3">
												<input type="text" class="form-control format-koma" id="NILAI_ONGKOS_ANGKUT" name="NILAI_ONGKOS_ANGKUT">
											</div>
											<div class="colm-sm-6">
											</div>
										</div>

										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												NILAI_LAIN_KONTRAK
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="col-sm-3">
												<input type="text" class="form-control format-koma" id="NILAI_LAIN_KONTRAK" name="NILAI_LAIN_KONTRAK">
											</div>
											<div class="colm-sm-6">
											</div>
										</div>

										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												TOTAL_TAGIHAN_COST
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="col-sm-3">
												<input type="text" class="form-control format-koma" id="TOTAL_TAGIHAN_COST" name="TOTAL_TAGIHAN_COST">
											</div>
											<div class="colm-sm-6">
											</div>
										</div>

										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												STORAGE
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="col-sm-3">
												<input type="text" class="form-control format-koma" id="STORAGE" name="STORAGE">
											</div>
											<div class="colm-sm-6">
											</div>
										</div>

										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												OTHER
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="col-sm-3">
												<input type="text" class="form-control format-koma" id="OTHER" name="OTHER">
											</div>
											<div class="colm-sm-6">
											</div>
										</div>

										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												NILAI_LAIN
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="col-sm-3">
												<input type="text" class="form-control format-koma" id="NILAI_LAIN" name="NILAI_LAIN">
											</div>
											<div class="colm-sm-6">
											</div>
										</div>

										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												FEE
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="col-sm-3">
												<input type="text" class="form-control format-koma" id="FEE" name="FEE">
											</div>
											<div class="colm-sm-6">
											</div>
										</div>

										<div class="form-group">
											<label for="akta_no" class="col-sm-3 control-label">
												KET
												<span style="color: #FFFFFF">*</span>
											</label>
											<div class="col-sm-3">
												<textarea id="KET" name="KET"></textarea>
											</div>
											<div class="colm-sm-6">
											</div>
										</div>

									</p>
								</div>
								<div id="menu2" class="tab-pane fade">
									<h3>Menu 2</h3>
									<p>Some content in menu 2.</p>
								</div>
							</div>


							<button type="button" class="btn btn-success update-detail">Update</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>