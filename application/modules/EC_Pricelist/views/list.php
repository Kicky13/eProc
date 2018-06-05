<section class="content_section">
	<div class="content_spacer">
		<div class="content">
			<div class="row">
				<!-- <div class="col-lg-3"> -->
				<input type="hidden" id="kodeParent" value="<?php echo $kode; ?>"/>
				<input type="hidden" id="tag" value="<?php echo $tag; ?>"/>
				<!-- </div> -->
				<div class="col-lg-9 col-md-9 col-lg-offset-3 col-md-offset-3">
					<form id="formsearch" class="">
						<div class="input-group">
							<div class="input-group-btn">
								<button class="btn btn-default" type="submit">
									<i class="glyphicon glyphicon-search"></i>
								</button>
							</div>
							<input type="text" class="form-control" id="txtsearch" placeholder="Cari produk atau material...">
							<div class="input-group-btn">
								<button class="btn btn-default" type="button" id="removeTAG" >
									<i class="glyphicon glyphicon-remove"></i>
								</button>
							</div>
						</div>
					</form>
				</div>
				<!-- <div class="col-lg-4 col-md-4 pull-right">
					<?php //echo form_open_multipart('EC_Ecatalog/compares/', array('method' => 'POST', 'class' => 'form-horizontal pull-right')); ?>
					<input type="hidden" id="arr" name="arr[]" />
					<input type="hidden" id="arrC" name="arrC[]" />
					<a href="javascript:void(0)"  data-toggle="modal" data-target="#modalbudget" type="button" class="btn btn-default"><span class="" aria-hidden="true">IDR</span>&nbsp;<span class="budget">4000</span></a>
					<button type="submit"  style="display: none"  class="btn btn-default">
						Histori
					</button>
					<a href="<?php //echo base_url(); ?>EC_Ecatalog/checkout" type="button" class="btn btn-default" onclick="openChart()"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Chart &nbsp;<span class="badge jml"></span></a>
					
					<a href="<?php //echo base_url(); ?>EC_Ecatalog/index7" type="button" id="compare" class="btn btn-default">
						Compare &nbsp;<span class="badge jmlCompare"></span>
					</a>
					
					</form>

				</div> -->
			</div>
			<br>
			<div class="row">
				<div class="col-lg-3 col-md-3">
					<div class="row">
						<!-- <div class="row" style="overflow: auto; max-height: 50vh"> -->
						<div class="col-lg-12">
							<center>
								<h5><strong>Kategori Produk</strong></h5>
							</center>
						</div>
						<div class="col-lg-12" style="overflow-y: auto;  max-height: 100vh; margin-left: -0px;">
							<ul id="tree1">

							</ul>
						</div>						
					</div>
				</div>
				<div class="col-lg-9 col-md-9">
					<div class="row">
						<div class="col-lg-12" style="padding-left: 0px; padding-right: 0px">
							<ol class="breadcrumb"  style="font-size: 13px; margin-bottom: 0px;">
								<li>
									<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
									<a href="javascript:void(0)">&nbsp;&nbsp;Home</a>
								</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div id="divAttributes" class="container" style="  margin-bottom: 5px; border:2px solid #ccc; border-top: solid 10px #ccc;padding-left: 0px;padding-right: 0px;">

						</div>
					</div>
					<!-- <div class="row">
						<div id="tes"><input type="text" class="form-control"></div>
					</div> -->
				</div>
			</div>
			<nav aria-label="Page navigation" class="pull-right">
			  <ul class="pagination">
			    <li>
			      <a href="javascript:paginationPrev()" aria-label="Previous">
			        <span aria-hidden="true">&laquo;</span>
			      </a>
			    </li>
			    <!-- 
			    <li><a href="javascript:pagination(0,10)">1</a></li>
			    <li><a href="javascript:pagination(10,20)">2</a></li>
			    <li><a href="#">3</a></li>
			    <li><a href="#">4</a></li>
			    <li><a href="#">5</a></li>
			    <li>
			      <a href="javascript:paginationNext()" aria-label="Next">
			        <span aria-hidden="true">&raquo;</span>
			      </a>
			    </li> -->
			  </ul>
			</nav>
		</div >
	</div >
</section>

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