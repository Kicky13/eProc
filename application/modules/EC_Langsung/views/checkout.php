<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<!-- <div class="row">
			<div class="col-lg-12">
			<h5>Shopping Chart</h5>
			</div>
			</div> -->
			<div class="row">
				<div class="col-lg-3">
					<h5>Shopping Cart</h5>
				</div>
				<div class="col-lg-9 pull-right">
					<?php echo form_open_multipart('EC_Ecatalog/compares/', array('method' => 'POST', 'class' => 'form-horizontal pull-right')); ?>
					<input type="hidden" id="arr" name="arr[]" />
					<input type="hidden" id="avl" value=""/>
					<input type="hidden" id="sisa" value=""/>
					<a href="<?php echo base_url(); ?>EC_Ecatalog/listCatalog" type="button" style="box-shadow: 1px 1px 1px #ccc" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Kembali</a>
					<a href="<?php echo base_url(); ?>EC_Ecatalog/history" type="button" style="box-shadow: 1px 1px 1px #ccc" class="btn btn-default"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> History PO</a>
					<a href="javascript:void(0)"  data-toggle="modal" data-target="#modalbudget" style="box-shadow: 1px 1px 1px #ccc" type="button" class="btn btn-default"><span class="" aria-hidden="true">IDR</span>&nbsp;<span class="budget">Loading...</span></a>
					<button type="submit"  style="display: none" id="compare" style="box-shadow: 1px 1px 1px #ccc" class="btn btn-default">
						Histori
					</button>
					<!-- <a href="<?php echo base_url(); ?>EC_Ecatalog/checkout" type="button" class="btn btn-default" onclick="openChart()"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Chart &nbsp;&nbsp;&nbsp;<span class="badge jml"></span></a> -->
					<a href="<?php echo base_url(); ?>EC_Ecatalog/perbandingan" style="box-shadow: 1px 1px 1px #ccc" type="button" id="compare" class="btn btn-default"> Compare &nbsp;<span class="badge jmlCompare"></span> </a>
					</form>

				</div>
			</div>
			<div class="row" style="padding-top: 5px">
				<div class="col-lg-9 col-md-9">
					<div class="row" style="border-top: 1px solid #ccc;"></div>
					<br>
					<div id="goods"></div>
				</div>
				<div class="col-lg-3 col-md-3 pull-right" style="border-left: 1px solid #ccc;border-top: 1px solid #ccc;border-bottom: 1px solid #ccc;">
					<?php echo form_open_multipart('EC_Ecatalog/confirm/', array('method' => 'POST', 'class' => 'form-horizontal')); ?>
					<input type="hidden" id="hid_current_budget" />
					<input type="hidden" id="hid_estimated_budget" />
					<div class="form-group">
						<label for="budgett" class="col-sm-4 control-label text-left">Budget</label>
						<label id="budgett" class="col-sm-8 control-label pull-right">0</label>
						<label for="totall" class="col-sm-4 control-label text-left">Total</label>
						<label id="totall" class="col-sm-8 control-label pull-right">0</label>
						<label for="totalsisa" class="col-sm-6 control-label text-left">Sisa Budget</label>
						<label id="totalsisa" class="col-sm-6 control-label pull-right">0</label>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
							<button type="button" id="btn_confirm"  data-toggle="modal" data-target="#cnfrm" onclick="" class="btn btn-danger disabled">
								Konfirmasi Beli
							</button>
						</div>

						<div class="col-sm-12 text-center">
							<label id="pocreated" class="col-sm-12 control-label text-center"></label>
						</div>

					</div>
					</form>
					<!-- <button type="submit" id="compare" style="width: auto;" class="btn btn-danger">
					Konfirmasi Beli
					</button> -->
					</center>
				</div>
			</div>
		</div >
	</div >
</section>

<div class="modal fade" id="cnfrm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h6 class="modal-title" id="myModalLabel">Tiap nomer PO terbit berdasarkan barang dengan nomer kontrak sama</h6>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-4">
						<h6>PO yang akan terbit</h6>
					</div>
					<div class="col-xs-8">
						: <a id="jmlPO" >5</a>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<h6>Jumlah barang</h6>
					</div>
					<div class="col-xs-8">
						: <a id="jmlBrg" >7</a>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<h6>Total biaya</h6>
					</div>
					<div class="col-xs-8">
						: <a id="totalBiaya" >5.000.000</a>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					Cancel
				</button>
				<button type="button" class="btn btn-primary" id="btnCofirmmm" onclick="confirm(this,1)">
					Confirm
				</button>
			</div>
		</div>
	</div>
</div>

<link rel="stylesheet" href="<?php echo base_url()."static/css/pages/EC_miniTable.css"?>" />
<div class="modal fade" id="modalbudget">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>INFORMASI DETAIL BUDGET</u></strong></h4>
			</div>
			<div class="modal-body">
				<table class="table table-hover table-striped" >
					<thead>
						<tr>
							<th>CostCenter</th>
							<th>Description</th>
							<th>GLAccount</th>
							<th>GLDescription</th>
							<th>Current</th>
							<th>Commit</th>
							<th>Actual</th>
							<th>Available</th>
							<th>Cart</th>
						</tr>
					</thead>
					<tbody id="tbody"></tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modaldetail">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>INFORMASI PRODUK<!-- <?php //echo $baseLanguage ['principal_manufacturer_addTtl'] ; ?> --></u></strong></h4>
			</div>
			<div class="modal-body">
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						Nomor Material
					</div>
					<div class="col-lg-9" id="detail_MATNR"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						Teks Pendek
					</div>
					<div class="col-lg-9" id="detail_MAKTX"></div>
				</div>
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						Teks Panjang
					</div>
					<div class="col-lg-9" id="detail_LNGTX"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						UoM
					</div>
					<div class="col-lg-9" id="detail_MEINS"></div>
				</div>
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						Group
					</div>
					<div class="col-lg-9" id="detail_MATKL"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						Tipe
					</div>
					<div class="col-lg-9" id="detail_MTART"></div>
				</div>
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						Dibuat
					</div>
					<div class="col-lg-9" id="detail_created"></div>
				</div>
				<div class="row">
					<div class="form-group">
						<label for="picure" class="col-sm-2 control-label">Picure</label>
						<div class="col-sm-offset-3 col-sm-9">
							<img id="pic" class="thumbnail zoom" onerror="this.onerror=null;this.src='<?php echo base_url(UPLOAD_PATH) . '/material_strategis/default_post_img.png'; ?>'"
							src="<?php echo base_url(UPLOAD_PATH) . '/EC_material_strategis/default_post_img.png'; ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<label for="drawing" class="col-sm-2 control-label">Drawing</label>
						<div class="col-sm-offset-3 col-sm-9">
							<img id="draw" class="thumbnail zoom" onerror="this.onerror=null;this.src='<?php echo base_url(UPLOAD_PATH) . '/material_strategis/default_post_img.png'; ?>'"
							src="<?php echo base_url(UPLOAD_PATH) . '/EC_material_strategis/default_post_img.png'; ?>">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalpenyedia">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>INFORMASI PENYEDIA<!-- <?php //echo $baseLanguage ['principal_manufacturer_addTtl'] ; ?> --></u></strong></h4>
			</div>
			<div class="modal-body">
				<div class="row" style="border-bottom: 2px solid #ccc">
					<div class="col-lg-10">
						<h5 id="VENDOR_NAME"></h5>
					</div>
					<div class="col-lg-2">

					</div>
				</div>
				<!-- <div class="row"> -->
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						Alamat
					</div>
					<div class="col-lg-9" id="ADDRESS"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						Negara
					</div>
					<div class="col-lg-9" id="ADDRESS_COUNTRY"></div>
				</div>
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						E-mail
					</div>
					<div class="col-lg-9" id="EMAIL_ADDRESS"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						Website
					</div>
					<div class="col-lg-9" id="ADDRESS_WEBSITE"></div>
				</div>
				<!-- <div class="row" style="background-color: #e3e9f2">
				<div class="col-lg-3">No. Telp</div>
				<div class="col-lg-9" id="ADDRESS_PHONE_NO"></div>
				</div>
				<div class="row">
				<div class="col-lg-3">No. Fax</div>
				<div class="col-lg-9" id="alamat"></div>
				</div> -->
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						NPWP
					</div>
					<div class="col-lg-9" id="NPWP_NO"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						Contact Person
					</div>
					<div class="col-lg-9">
						<div class="row">
							<div class="col-lg-4">
								Nama
							</div>
							<div class="col-lg-3">
								No. Telp
							</div>
							<div class="col-lg-5">
								E-mail
							</div>
						</div>
						<div class="row" style="background-color: #e3e9f2"	>
							<div class="col-lg-4" id="CONTACT_NAME"></div>
							<div class="col-lg-3" id="CONTACT_PHONE_NO"></div>
							<div class="col-lg-5" id="CONTACT_EMAIL"></div>
						</div>
					</div>
				</div>
				<!-- </div> -->
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalprincipal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>INFORMASI PRINCIPAL<!-- <?php //echo $baseLanguage ['principal_manufacturer_addTtl'] ; ?> --></u></strong></h4>
			</div>
			<div class="modal-body">
				<div class="row" style="border-bottom: 2px solid #ccc; padding-bottom: 10px">
					<div class="col-lg-10">
						<h5 id="PC_NAME"></h5>
					</div>
					<div class="col-lg-2">
						<img src="" id="LOGO" class="img-responsive">
					</div>
				</div>
				<!-- <div class="row"> -->
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						Alamat
					</div>
					<div class="col-lg-9" id="ADDRESS_P"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						Negara
					</div>
					<div class="col-lg-9" id="COUNTRY"></div>
				</div>
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						E-mail
					</div>
					<div class="col-lg-9" id="MAIL"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						Website
					</div>
					<div class="col-lg-9" id="WEBSITE"></div>
				</div>
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-3">
						No. Telp
					</div>
					<div class="col-lg-9" id="PHONE"></div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						No. Fax
					</div>
					<div class="col-lg-9" id="FAX"></div>
				</div>
				<!-- <div class="row" style="background-color: #e3e9f2">
				<div class="col-lg-3">NPWP</div>
				<div class="col-lg-9" id="NPWP_NO"></div>
				</div> -->
				<div class="row" style="background-color: #e3e9f2">
					<div class="col-lg-12 text-center">
						Partner Bisnis
					</div>
				</div>
				<div class="row" style="background-color: #f2b29b">
					<div class="col-lg-3 text-center">
						Penyedia
					</div>
					<div class="col-lg-1 text-center">
						Negara
					</div>
					<div class="col-lg-2 text-center">
						Website
					</div>
					<div class="col-lg-4 text-center">
						Email
					</div>
					<div class="col-lg-2 text-center">
						No. Telp
					</div>
				</div>
				<div id="divPartner">

				</div>
				<!-- </div> -->
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalPO">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>INFORMASI PO</u></strong></h4>
			</div>
			<div class="modal-body">
				<table class="table table-hover table-striped" >
					<thead>
						<tr>
							<th>PO</th>
							<th>Matrial</th>
							<th>Harga</th>
						</tr>
					</thead>
					<tbody id="tbodyPO"></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
