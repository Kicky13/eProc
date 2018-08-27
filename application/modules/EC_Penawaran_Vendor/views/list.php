<style type='text/css'>
	input[type="text"]:disabled {
		background-color: #eee;
	}
</style>
<section class="content_section">
	<div class=""><!--        content_spacer  -->
            <div class="hide" id="sudahTampilPesan"><?php echo $alertHarga ?></div>
		<div class="content" style="margin-bottom:200px;">
            <br/><br/>
			<div class="main_title centered upper">
		        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
		    </div>
			
			<!-- AJAX DATA TABLE --><!--<ul class="nav nav-tabs">
			  <li id="stokLI" style="cursor:pointer;" class="active" onclick="ubahTab('stok', 'dest');"><a><b>Stock</b></a></li>
			  <li id="destLI" style="cursor:pointer;" onclick="ubahTab('dest', 'stok');"><a><b>Destination</b></a></li>
			</ul>--><!-- AJAX DATA TABLE -->
			
			<!--<div id="stokOnly">-->
                         <div class="panel-group">
                    <div class="panel panel-default">
                    <div class="panel-heading" style="font-weight:600;">INFORMASI DAN KETENTUAN</div>

                      <div class="panel-body">
                          <ol style="margin-left:50px;">
                              <li>Harga untuk produk yang dikirimkan sudah termasuk <span style="font-weight:bold;">PPH</span> dan <span style="font-weight:bold;">ongkos kirim</span> namun belum termasuk <span style="font-weight:bold;">PPN</span></li>
                              <li>Harga untuk produk pengambilan sendiri sudah termasuk <span style="font-weight:bold;">PPH</span> namun tidak termasuk <span style="font-weight:bold;">PPN</span> dan <span style="font-weight:bold;">ongkos kirim</span></li>
                              <li>Update Harga dan Delivery Time hanya dapat dilakukan ketika <span style="font-weight:bold;">Tanggal Sekarang</span> sudah mencapai <span style="font-weight:bold;">Next Update</span></li>
                              <li>Barang yang dikirimkan harus sesuai dengan informasi barang yang telah tertera (keterangan dan foto)</li>
                              <li>Khusus Harga <span style="font-weight:bold;">Pengambilan Sendiri (2901 dan 7901)</span> memiliki harga yang sama berdasarkan satu produk.</li>
                              <li><span style="font-weight:bold;">Userguide</span> bisa di unduh di button unduh <a href="<?=base_url()?>upload/userguide/UG-E-Catalog-Pembelian-Langsung-Vendor.pdf" class='btn btn-primary' target="new_blank">Unduh</a></li>
                          </ol>                                                                        
                    </div>
                </div>
            </div>
			<form method='post' action='<?php echo base_url(); ?>EC_Penawaran_Vendor/simpanHarga' id='form_simpan'>
				<button type='button' class='btn btn-primary pull-right' onclick='konfirmasiSimpan();'>Save</button>
				<br/>
				<br/>
				<br/>
				<div id="divAttributes" style="margin-bottom: 5px;"></div>
				<div class="col-lg-12 col-md-12">                   
					<nav aria-label="Page navigation" class="pull-right">
						<ul class="pagination" id="pagination_1">
							<li>
								<a href="javascript:paginationPrev()" aria-label="Previous"> <span aria-hidden="true">&laquo;</span> </a>
							</li> 
						</ul>
					</nav>
				</div>
			</form>
			<!--</div>-->
			
			<!-- AJAX DATA TABLE -->
			<!--<div id="destOnly">
				<table class='table table-bordered table-hover' style='width:100%;' id='data_destination'>
					<thead>
						<tr>
							<th>Mat No</th>
							<th>Name</th>
							<th>Destination</th>
							<th style='width:70px;'>Currency</th>
							<th style='width:70px;'>Price</th>
							<th>Delivery Time</th>
							<th>Last Update</th>
							<th>Next Update</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>-->
			<!-- AJAX DATA TABLE -->

			<!-- <nav aria-label="Page navigation" class="pull-right">
			  <ul class="pagination">
			    <li>
			      <a href="javascript:paginationPrev()" aria-label="Previous">
			        <span aria-hidden="true">&laquo;</span>
			      </a>
			    </li> -->
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
			  <!-- </ul>
			</nav> -->
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
                        Short Text
                    </div>
                    <div class="col-lg-9" id="detail_MAKTX"></div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        Long Text
                    </div>
                    <div class="col-lg-9" id="detail_LNGTX"></div>
                </div>
                <div class="row" style="background-color: #e3e9f2">
                    <div class="col-lg-3">
                        UoM
                    </div>
                    <div class="col-lg-9" id="detail_MEINS"></div>
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