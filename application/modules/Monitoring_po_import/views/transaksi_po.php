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
					<button class="btn btn-danger btn-md btn-update">
						SAP UPDATE
					</button>
					<div class="panel panel-default">
						<div class="panel-heading">
							Transaksi PO
						</div>
						<table class="table table-hover">
							<tr>
								<td>Company</td>
								<td>
									<select name="opco" id="opco" onchange="loadData()">
										<option value="2000">Semen Indonesia</option>
										<option value="5000">Semen Gresik</option>
									</select>
								</td>
							</tr>

							<tr>
								<td></td>
								<td>
									<button class="btn btn-warning btn-md btn-check">
										Check PO
									</button>
								</td>
							</tr>
						</table>
					</div>

					<!-- <form action="<?php echo base_url()?>Monitoring_po_import/saveAll" method="POST" class="submit"> -->
					<div class="panel panel-default">
						<div class="panel-heading">
							Transaksi PO yang dipilih
							<button type="submit" class="btn btn-danger btn-sm pull-right">
								<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
							</button>
						</div>
						<div class="table-responsive">

							<table id="example1" class="table table-striped table-hover responsive" >
								<thead>
									<tr>
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
										<th><input type="text" class="col-xs-12"></th>
										<th><input type="text" class="col-xs-12"></th>
										<th></th>
									</tr>
								</thead>
								<tbody id="resultPO">
								</tbody>
							</table>
						</div>
					</div>	
					<!-- </form> -->

<!-- 					<form action="<?php echo base_url()?>Monitoring_po_import/saveAll" method="POST" class="submit">
						<input type="hidden" class="company" name="company" value="">
						<div class="panel panel-default">
							<div class="panel-body text-center">
								<button id="submit_button" type="submit" class="btn btn-success btn-md tombolsimpan">
									Simpan
								</button>
							</div>
						</div>
					</form> -->
				</div>
			</div>
		</div>
	</div>
</section>



<!-- Modal -->
<div class="modal fade" id="transaksi_po" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">List Transaksi PO</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="<?php echo base_url()?>Monitoring_po_import/saveSelected" enctype="multipart/form-data" method="POST">
					<div class="table-responsive">
						<table id="example" class="table table-striped table-hover responsive" width="100%" cellspacing="0">
							<thead>
								<tr>
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
									<th><input type="text" class="col-xs-12"></th>
									<th><input type="text" class="col-xs-12"></th>
								</tr>
							</thead>
							<tbody id="resultPOSap">
							</tbody>
						</table>
					</div>
					<button class="btn btn-success btn-md">
						Save Selected
					</button>
				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="edit_transaksi_po" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Transaksi PO</h4>
			</div>
			<div class="modal-body">

				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#home">PO</a></li>
					<li><a data-toggle="tab" href="#menu1">Document Shipping</a></li>
					<li><a data-toggle="tab" href="#menu2">Custom</a></li>
				</ul>

				<div class="tab-content">
					<div id="home" class="tab-pane fade in active">
						<form class="form-horizontal" enctype="multipart/form-data" method="POST" id="formrooms">
							<p>
								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										Dokumen PO
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input readonly="readonly" type="text" class="form-control NO_PO" name="NO_PO">
									</div>
									<div class="colm-sm-6">
										<input name="DOC_PO" id="DOC_PO" onchange="return ValidateFileUploadDOC_PO()" accept="application/msword, application/pdf" type="file">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										No. LC
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="NO_LC" name="NO_LC">
									</div>
									<div class="colm-sm-6">
										<input name="DOC_LC" id="DOC_LC" onchange="return ValidateFileUploadDOC_LC()" accept="application/msword, application/pdf" type="file">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										LSD
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="LSD" name="LSD">
									</div>
									<label for="akta_no" class="col-sm-3">
										APPROVE_PEMENANG
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input name="APPROVE_PEMENANG" id="APPROVE_PEMENANG" onchange="return ValidateFileUploadAPPROVE_PEMENANG()" accept="application/msword, application/pdf" type="file">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										EXPIRY
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="EXPIRY" name="EXPIRY">
									</div>
									<label for="akta_no" class="col-sm-3">
										DOC_OK
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input name="DOC_OK" id="DOC_OK" onchange="return ValidateFileUploadDOC_OK()" accept="application/msword, application/pdf" type="file">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										FORWARDER
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="FORWARDER" name="FORWARDER">
									</div>
									<div class="colm-sm-6">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										KET
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<textarea name="KET" id="KET"></textarea>
										<!-- <input type="text" class="form-control" id="KET" name="KET"> -->
									</div>
									<div class="colm-sm-6">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_type" class="col-sm-3">TOP
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3 end">
										<label for="akta_type" class="custom_select">
											<span class="lfc_alert"></span>
											<select name="TOP" id="TOP" required="">
												<option value="L/C">L/C</option>
												<option value="TT">TT</option>
												<option value="CAD">CAD</option>
											</select>
										</label>
									</div>
								</div>

								<div class="form-group">
									<label for="akta_type" class="col-sm-3">TOD
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3 end">
										<label for="akta_type" class="custom_select">
											<span class="lfc_alert"></span>
											<select name="TOD" id="TOD" required="">
												<?php foreach ($tod as $t): ?>
													<option value="<?php echo $t['CODE']; ?>"><?php echo $t['DESC']; ?> (<?php echo $t['CODE']; ?>)</option>
												<?php endforeach ?>
											</select>
										</label>
									</div>
								</div>

								<div class="form-group">
									<label for="date_creation" class="col-sm-3">DELIVERY_DATE
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3 end">
										<div class="input-group date">
											<input type="text" id="DELIVERY_DATE" name="DELIVERY_DATE" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div>
									</div>
									<label for="date_creation" class="col-sm-3">TGL_NEGO
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3 end">
										<div class="input-group date">
											<input type="text" id="TGL_NEGO" name="TGL_NEGO" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="date_creation" class="col-sm-3">TGL_AMEND
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3 end">
										<div class="input-group date">
											<input type="text" id="TGL_AMEND" name="TGL_AMEND" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div>
									</div>
									<label for="akta_no" class="col-sm-3">
										AKHIR_NEGO
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<div class="input-group date">
											<input type="text" id="AKHIR_NEGO" name="AKHIR_NEGO" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="date_creation" class="col-sm-3">TGL_RELEASE
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3 end">
										<div class="input-group date">
											<input type="text" id="TGL_RELEASE" name="TGL_RELEASE" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										NILAI
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control format-koma" id="NILAI" name="NILAI">
									</div>
									<div class="colm-sm-6">
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-3">
									</div>
									<div class="col-sm-3">
										<button type="button" class="btn btn-success update-detail">Update</button>
									</div>
									<div class="colm-sm-6">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>
							</p>
						</form>

					</div>
					<div id="menu1" class="tab-pane fade">
						<form class="form-horizontal" enctype="multipart/form-data" method="POST" id="formrooms2">
							<input readonly="readonly" type="hidden" class="form-control NO_PO" name="NO_PO">
							<input readonly="readonly" type="hidden" class="form-control ID" name="ID">
							<p>
								<div class="table-responsive">
									<table id="example2" class="table table-striped table-hover responsive" width="100%" cellspacing="0">
										<thead>
											<th class="no-sort">No</th>
											<th>NO_PO</th>
											<th>NILAI_INV</th>
											<th>NEGARA_ASAL</th>
											<th>TGL_BL</th>
											<th>TGL_ETA</th>
											<th>DOC_PPL</th>
											<th>DOC_SHIPPING</th>
											<th>Aksi</th>
										</thead>
										<tbody id="resultDocShip">
										</tbody>
									</table>
								</div>

								<br>
								<br>
								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										NO_PPL_BARANG
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="NO_PPL_BARANG" name="NO_PPL_BARANG" readonly="readonly">
									</div>
									<div class="colm-sm-6">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										JENIS_KEMASAN
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<label for="akta_type" class="custom_select">
											<select name="JENIS_KEMASAN" id="JENIS_KEMASAN" required="">
												<option value="FCL">FCL</option>
												<option value="LCL">LCL</option>
												<option value="BULK">BULK</option>
												<option value="OTHER">OTHER</option>
											</select>
										</label>
									</div>
									<div class="colm-sm-6">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										SATUAN
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<label for="akta_type" class="custom_select">
											<select name="SATUAN" id="SATUAN" required="">
												<option value="KGM">KGM</option>
												<option value="TNE">TNE</option>
												<option value="EA">EA</option>
												<option value="OTHER">OTHER</option>
											</select>
										</label>
									</div>
									<div class="colm-sm-6">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										DOC_PPL
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="colm-sm-6">
										<input name="DOC_PPL" id="DOC_PPL" onchange="return ValidateFileUploadDOC_PPL()" accept="application/msword, application/pdf" type="file">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										DOC_SHIPPING
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="colm-sm-6">
										<input name="DOC_SHIPPING" id="DOC_SHIPPING" onchange="return ValidateFileUploadDOC_SHIPPING()" accept="application/msword, application/pdf" type="file">
									</div>
								</div>

								<div class="form-group">
									<label for="date_creation" class="col-sm-3">TGL_BL
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3 end">
										<div class="input-group date">
											<input type="text" id="TGL_BL" name="TGL_BL" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div>
									</div>

									<label for="date_creation" class="col-sm-3">TGL_ETA
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3 end">
										<div class="input-group date">
											<input type="text" id="TGL_ETA" name="TGL_ETA" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div>
									</div>
								</div>


								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										NO_BL
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="NO_BL" name="NO_BL">
									</div>
									<div class="colm-sm-6">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										NAMA_ANGKUT
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="NAMA_ANGKUT" name="NAMA_ANGKUT">
									</div>
									<div class="colm-sm-6">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										POL
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="POL" name="POL">
									</div>
									<div class="colm-sm-6">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										POD
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="POD" name="POD">
									</div>
									<div class="colm-sm-6">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										NEGARA_ASAL
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<label for="akta_type" class="custom_select">
											<select name="NEGARA_ASAL" id="NEGARA_ASAL" required="">
												<?php foreach ($country as $c): ?>
													<option value="<?php echo $c['COUNTRY_CODE']; ?>"><?php echo $c['COUNTRY_NAME']; ?> (<?php echo $c['COUNTRY_CODE']; ?>)</option>
												<?php endforeach ?>
											</select>
										</label>
									</div>
									<div class="colm-sm-6">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										NILAI_INV
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control format-koma" id="NILAI_INV" name="NILAI_INV">
									</div>
									<div class="colm-sm-6">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										KUANTITAS_BL
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control format-koma" id="KUANTITAS_BL" name="KUANTITAS_BL">
									</div>
									<div class="colm-sm-6">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										JML_CONTAINER
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control format-koma" id="JML_CONTAINER" name="JML_CONTAINER">
									</div>
									<div class="colm-sm-6">
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-3">
									</div>
									<div class="col-sm-3">
										<button type="button" class="btn btn-success save-detail">Save</button>
									</div>
									<div class="colm-sm-6">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>
							</p>
						</form>
					</div>
					<div id="menu2" class="tab-pane fade">
						<form class="form-horizontal" enctype="multipart/form-data" method="POST" id="formrooms3">
							<input readonly="readonly" type="hidden" class="form-control NO_PO" name="NO_PO">
							<input readonly="readonly" type="hidden" class="form-control IDC" name="IDC">
							<p>
								<div class="table-responsive">
									<table id="example3" class="table table-striped table-hover responsive" width="100%" cellspacing="0">
										<thead>
											<th class="no-sort">No</th>
											<th>NO_PO</th>
											<th>HS_CODE</th>
											<th>TGL_DO</th>
											<th>DOC_PPL</th>
											<th>DOC_BILLING</th>
											<th>DOC_BPN</th>
											<th>DOC_MANIFEST</th>
											<th>DOC_LS</th>
											<th>DOC_INSURANCE</th>
											<th>DOC_SPPB</th>
											<th>DOC_SPTNP</th>
											<th>Aksi</th>
										</thead>
										<tbody id="resultCustom">
										</tbody>
									</table>
								</div>

								<br>
								<br>
								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										HS_CODE
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="HS_CODE" name="HS_CODE">
									</div>
									<label for="akta_no" class="col-sm-3">
										DOC_PPL
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input name="DOC_PPL2" id="DOC_PPL2" onchange="return ValidateFileUploadDOC_PPL2()" accept="application/msword, application/pdf" type="file">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										NO_PPL_BM
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="NO_PPL_BM" name="NO_PPL_BM">
									</div>
									<label for="akta_no" class="col-sm-3">
										DOC_BILLING
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input name="DOC_BILLING" id="DOC_BILLING" onchange="return ValidateFileUploadDOC_BILLING()" accept="application/msword, application/pdf" type="file">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										NO_PPL_PDRI
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="NO_PPL_PDRI" name="NO_PPL_PDRI">
									</div>
									<label for="akta_no" class="col-sm-3">
										DOC_BPN
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input name="DOC_BPN" id="DOC_BPN" onchange="return ValidateFileUploadDOC_BPN()" accept="application/msword, application/pdf" type="file">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										NO_PI_IP
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="NO_PI_IP" name="NO_PI_IP">
									</div>
									<label for="akta_no" class="col-sm-3">
										DOC_MANIFEST
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input name="DOC_MANIFEST" id="DOC_MANIFEST" onchange="return ValidateFileUploadDOC_MANIFEST()" accept="application/msword, application/pdf" type="file">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										NO_SPTNP
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="NO_SPTNP" name="NO_SPTNP">
									</div>
									<label for="akta_no" class="col-sm-3">
										DOC_LS
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input name="DOC_LS" id="DOC_LS" onchange="return ValidateFileUploadDOC_LS()" accept="application/msword, application/pdf" type="file">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										NO_LS
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="NO_LS" name="NO_LS">
									</div>
									<label for="akta_no" class="col-sm-3">
										DOC_INSURANCE
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input name="DOC_INSURANCE" id="DOC_INSURANCE" onchange="return ValidateFileUploadDOC_INSURANCE()" accept="application/msword, application/pdf" type="file">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										NO_CERT
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="NO_CERT" name="NO_CERT">
									</div>
									<label for="akta_no" class="col-sm-3">
										DOC_SPPB
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input name="DOC_SPPB" id="DOC_SPPB" onchange="return ValidateFileUploadDOC_SPPB()" accept="application/msword, application/pdf" type="file">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										NO_PIB
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="NO_PIB" name="NO_PIB">
									</div>
									<label for="akta_no" class="col-sm-3">
										DOC_SPTNP
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input name="DOC_SPTNP" id="DOC_SPTNP" onchange="return ValidateFileUploadDOC_SPTNP()" accept="application/msword, application/pdf" type="file">
									</div>
								</div>

								<div class="form-group">
									<label for="date_creation" class="col-sm-3">TGL_BAYAR
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3 end">
										<div class="input-group date">
											<input type="text" id="TGL_BAYAR" name="TGL_BAYAR" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div>
									</div>
									<label for="date_creation" class="col-sm-3">TGL_BERLAKU_LS
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3 end">
										<div class="input-group date">
											<input type="text" id="TGL_BERLAKU_LS" name="TGL_BERLAKU_LS" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="date_creation" class="col-sm-3">TGL_BERLAKU
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3 end">
										<div class="input-group date">
											<input type="text" id="TGL_BERLAKU" name="TGL_BERLAKU" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div>
									</div>
									<label for="date_creation" class="col-sm-3">TGL_SPPB
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3 end">
										<div class="input-group date">
											<input type="text" id="TGL_SPPB" name="TGL_SPPB" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="date_creation" class="col-sm-3">TGL_SPTNP
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3 end">
										<div class="input-group date">
											<input type="text" id="TGL_SPTNP" name="TGL_SPTNP" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div>
									</div>
									<label for="date_creation" class="col-sm-3">TGL_CERT
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3 end">
										<div class="input-group date">
											<input type="text" id="TGL_CERT" name="TGL_CERT" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="date_creation" class="col-sm-3">TGL_MANIFEST
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3 end">
										<div class="input-group date">
											<input type="text" id="TGL_MANIFEST" name="TGL_MANIFEST" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div>
									</div>
									<label for="date_creation" class="col-sm-3">TGL_PIB
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3 end">
										<div class="input-group date">
											<input type="text" id="TGL_PIB" name="TGL_PIB" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="date_creation" class="col-sm-3">TGL_TA
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3 end">
										<div class="input-group date">
											<input type="text" id="TGL_TA" name="TGL_TA" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div>
									</div>
									<label for="date_creation" class="col-sm-3">TGL_DO
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3 end">
										<div class="input-group date">
											<input type="text" id="TGL_DO" name="TGL_DO" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										OTHER (NON LARTAS)
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="OTHER" name="OTHER">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										KUOTA_LARTAS
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control format-koma" id="KUOTA_LARTAS" name="KUOTA_LARTAS">
									</div>
									<div class="colm-sm-6">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										SISA_KUOTA
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control format-koma" id="SISA_KUOTA" name="SISA_KUOTA">
									</div>
									<div class="colm-sm-6">
									</div>
								</div>

								<div class="form-group">
									<label for="akta_no" class="col-sm-3">
										NILAI_LS
										<span style="color: #FFFFFF">*</span>
									</label>
									<div class="col-sm-3">
										<input type="text" class="form-control format-koma" id="NILAI_LS" name="NILAI_LS">
									</div>
									<div class="colm-sm-6">
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-3">
									</div>
									<div class="col-sm-3">
										<button type="button" class="btn btn-success save-custom">Save</button>
									</div>
									<div class="colm-sm-6">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>
							</p>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer">
			<!-- 				<button type="button" class="btn btn-success update-detail">Update</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
		</div>
	</div>
</div>
</div>