<style>
	@media only screen and (min-width: 1200px) {
		.content, .container, .site_boxed #main_wrapper {
			max-width: 1200px
		}

	}
	/*
	 @media only screen and (min-width:1024px){
	 .content,.container,.site_boxed #main_wrapper{
	 max-width:1000px}

	 }
	 */
	@media only screen and (min-width: 1300px) {
		.content, .container, .site_boxed #main_wrapper {
			max-width: 1300px
		}

	} 
</style>
<section class="content_section" style="background-color: #F1F3F5;">
	<div class="content_spacer" style="padding-top: 15px">
	<!-- <div class="" style="margin-top: 15px"> -->
		<div class="content" style="margin-left: 10px;margin-right: 10px">
			<div class="row">
				<!-- <div class="col-lg-3"> -->
				<input type="hidden" id="kodeParent" value="<?php echo $kode; ?>"/>
				<input type="hidden" id="tag" value="<?php echo $tag; ?>"/>
				<!-- </div> -->
				<div class="col-lg-5 col-md-5 col-lg-offset-3 col-md-offset-3">
					<form id="formsearch" class="">
						<div class="input-group" >
							<div class="input-group-btn">
								<button class="btn btn-default" type="submit">
									<i class="glyphicon glyphicon-search"></i>
								</button>
							</div>
							<input type="text" class="form-control" id="txtsearch" placeholder="Cari produk, kategori atau merk...">
							<div class="input-group-btn">
								<button class="btn btn-default" type="button" id="removeTAG" >
									<i class="glyphicon glyphicon-remove"></i>
								</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-lg-4 col-md-4 pull-right">
					<?php echo form_open_multipart('EC_Ecatalog/compares/', array('method' => 'POST', 'class' => 'form-horizontal pull-right')); ?>
					<input type="hidden" id="arr" name="arr[]" />
					<input type="hidden" id="arrC" name="arrC[]" />
					<a href="javascript:void(0)" style="box-shadow: 1px 1px 1px #ccc"  data-toggle="modal" data-target="#modalbudget" type="button" class="btn btn-default"><span class="" aria-hidden="true">IDR</span>&nbsp;<span class="budget">Loading...</span></a>
					<button type="submit"  style="display: none"  class="btn btn-default">
						Histori
					</button>
					<a href="<?php echo base_url(); ?>EC_Ecatalog/checkout" style="box-shadow: 1px 1px 1px #ccc" type="button" class="btn btn-default" ><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Cart &nbsp;<span class="badge jml"></span></a>
					<!-- <button  -->
					<a href="<?php echo base_url(); ?>EC_Ecatalog/perbandingan" style="box-shadow: 1px 1px 1px #ccc" type="button" id="compare" class="btn btn-default"> Compare &nbsp;<span class="badge jmlCompare"></span> </a>
					<!-- </button> -->
					</form>

				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-lg-3 col-md-3">
					<div class="row" style="margin-bottom: 20px;margin-right: -5px">
						<div class="col-md-offset-2 col-lg-offset-2 col-lg-8 col-md-8">
							<select id="listmode" class="form-control">
								<option value="1">ECatalog</option> 
								<!--<option value="2">Pricelist</option>
								<option value="0">No-Price</option> -->
								<option value="3" selected="">Pembelian Langsung</option>
							</select>
						</div>
					</div>
					<div class="row" style="margin-right: -5px;padding-left: 10px">
						<!-- <div class="row" style="overflow: auto; max-height: 50vh"> -->
						<div class="col-lg-12">
							<center>
								<h5><strong>Kategori Produk</strong></h5>
							</center>
						</div> 
						<div class="col-lg-12" style="overflow-y: auto; background-color: white;box-shadow: 1px 1px 1px 1px #ccc; max-height: 65vh;">
							<ul id="tree1">

							</ul>
						</div>
						<div class="col-lg-12">
							<div class="row" style="background-color: white;border-top: 5px solid #ccc;box-shadow: 1px 1px 1px 1px #ccc;border-bottom: 1px solid #ccc;border-right: 1px solid #ccc; margin-top: 10px;">
								<div class="col-lg-12" style="margin-left: 15px">
									Filter Harga
									<p></p>
									<!-- Filter by price interval: <b>€ 10</b>  -->
									<input id="ex2" type="text" class="span2" value="" data-slider-min="10" data-slider-max="1000" data-slider-step="5" data-slider-value="[250,450]"/>
									<!-- <b>€ 1000</b> -->
									<input type="text" disabled id="txtharga" />
									<button type="submit" class="btn btn-default" id="btnTampilkan" style="margin-top: 5px;">
										Tampilkan
									</button>
									<p></p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-9 col-md-9">
					<div class="row" style="margin-bottom: 5px">
						<div class="col-lg-10" style="padding-left: 0px; padding-right: 0px">
							<ol class="breadcrumb"  style="font-size: 13px; margin-bottom: 0px;">
								<li>
									<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
									<a href="javascript:void(0)">&nbsp;&nbsp;Home</a>
								</li>
							</ol>
						</div>
						<div class="col-lg-2">
							<div class="btn-group pull-right">
								<button type="button" id="thlist"  style="box-shadow: 1px 1px 1px #ccc" onclick="modeList('list')" class="btn btn-default " title="Model Tampilan List" aria-label="Left Align">
									<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
								</button>
								<button type="button pull-right" style="box-shadow: 1px 1px 1px #ccc"  onclick="modeList('grid')" id="gridlist" class="btn btn-default"  title="Model Tampilan Grid" aria-label="Left Align">
									<span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
								</button>
							</div>
						</div>
					</div> 
					<div class="row">
						<div id="divAttributes" class="container" style="background-color: white;box-shadow: 1px 1px 1px #ccc; margin-bottom: 5px; border:2px solid #ccc; border-top: solid 10px #ccc;">

						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12">					
					<nav aria-label="Page navigation" class="pull-right">
						<ul class="pagination">
							<li>
								<a href="javascript:paginationPrev()" aria-label="Previous"> <span aria-hidden="true">&laquo;</span> </a>
							</li> 
						</ul>
					</nav>
				</div>
			</div>
		</div >
	</div >
</section>

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
