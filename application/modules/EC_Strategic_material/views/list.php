
<section class="content_section">
  <div class="content_spacer">
    <div class="content">
      <div class="main_title centered upper">
        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
      </div>
      <div class="row">
      	<div class="row ">
      		<button type="button" class="btn btn-default" onclick="SAPsUpdate()">SAP's Update</button>
      	</div>
        <div class="row "> 
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <table id="tableMT" class="table table-striped">
                <thead>
                  <tr>
                    <th class="text-center ts0"><a href="javascript:void(0)">No.</a></th>
                    <th class="text-center ts1"><a href="javascript:void(0)">Nomer Material</a></th>
                    <th class="text-center ts2"><a href="javascript:void(0)">Teks Pendek</a></th>
                    <th class="text-center ts3"><a href="javascript:void(0)">UoM</a></th>
                    <th class="text-center ts4"><a href="javascript:void(0)">Grup</a></th>
                    <th class="text-center ts5"><a href="javascript:void(0)">Tipe</th>
                    <th class="text-center ts6"><a href="javascript:void(0)">Status</th>
                    <th class="text-center">Ubah Status</th> 
                    <th class="text-center">Kategori</th> 
                    <th class="text-center">Assign Kategori</th> 
                  </tr>
                  <tr>
                    <th> </th>
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>  
                    <th></th>
                    <th>
                    	<label style="padding-top: 0px" class="checkbox-inline col-md-10 col-md-offset-1  col-xs-10 col-lg-offset-1  col-xs-10 col-lg-offset-1 text-center">
  						<input type="checkbox" id="checkAll" onclick="" value="option1">Tandai Semua
						</label>
					</th>
					<th></th>
					<th></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div> 
        </div>   
      </div> 
    </div >
  </div >
</section>

<div class="modal fade" id="modalholder">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title text-center"><u>MASTER DATA - MATERIAL</u></h4>
        </div>
        <div class="modal-body">        	 	
          <!-- <form class="form-horizontal" id="formUp" action="E_Catalog/upload/" method="post" enctype="multipart/form-data"> -->
          	<?php echo form_open_multipart('EC_Strategic_material/upload/',array('method' => 'POST','id'=>'formUp','class' => 'form-horizontal')); ?>
				  <div class="form-group">
				    <label for="MATNR" class="col-sm-2 control-label"><?php echo $baseLanguage ['strategic_material_no'] ; ?></label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="MATNR" readonly>
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="MAKTX" class="col-sm-2 control-label"><?php echo $baseLanguage ['strategic_material_shrt_txt'] ; ?></label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="MAKTX" readonly>
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="TDLINE" class="col-sm-2 control-label"><?php echo $baseLanguage ['strategic_material_long_txt'] ; ?></label>
				    <div class="col-sm-9">
				      <textarea class="form-control" rows="5" id="TDLINE" readonly></textarea>				      
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="MEINS" class="col-sm-2 control-label">UoM</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="MEINS" readonly>
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="MATKL" class="col-sm-2 control-label"><?php echo $baseLanguage ['strategic_material_group'] ; ?></label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="MATKL" readonly>
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="MTART" class="col-sm-2 control-label"><?php echo $baseLanguage ['strategic_material_type'] ; ?></label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="MTART" readonly>
				    </div>
				  </div> 
				   
				  <div class="form-group">
				    <label for="created" class="col-sm-2 control-label"><?php echo $baseLanguage ['strategic_material_created'] ; ?></label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="created" readonly>
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="lastChg" class="col-sm-2 control-label"><?php echo $baseLanguage ['strategic_material_lastchg'] ; ?></label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="lastChg" readonly>
				    </div>
				  </div>
				  
				  <div class="form-group">
				    <label for="lastChg" class="col-sm-2 control-label">TAG</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" name="TAG"  id="TAG" >
				    </div>
				    <div class="col-sm-offset-2 col-sm-9">
				      <p class="help-block"><small>pisahkan setiap tag dengan koma (,)</small></p>
				    </div>
				    
				  </div>
				  
				  <div class="form-group">	
				    <label for="picure" class="col-sm-2 control-label">Picure</label>			    
				    <div class="col-sm-offset-3 col-sm-9">				  
      					<img id="pic" class="thumbnail zoom" onerror="this.onerror=null;this.src='<?php echo base_url(UPLOAD_PATH).'/EC_material_strategis/default_post_img.png'; ?>'"
      					 src="<?php echo base_url(UPLOAD_PATH).'/EC_material_strategis/default_post_img.png'; ?>">
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <div class="col-sm-offset-3 col-sm-9">
				    <input type="file" name="picture" id="picure">
				    </div>
				    <div class="col-sm-offset-3 col-sm-9">
				    <p class="help-block"><small><?php echo $baseLanguage ['ecat_file'] ; ?></small> </p>
				    </div>
				  </div>
				  
				  <div class="form-group">	
				    <label for="drawing" class="col-sm-2 control-label">Drawing</label>			    
				    <div class="col-sm-offset-3 col-sm-9">				  
      					<img id="draw" class="thumbnail zoom" onerror="this.onerror=null;this.src='<?php echo base_url(UPLOAD_PATH).'/EC_material_strategis/default_post_img.png'; ?>'"
      					 src="<?php echo base_url(UPLOAD_PATH).'/EC_material_strategis/default_post_img.png'; ?>">
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <div class="col-sm-offset-3 col-sm-9">
				    <input type="file" name="drawing" id="drawing">
				    </div>
				    <div class="col-sm-offset-3 col-sm-9">
				    <p class="help-block"><small><?php echo $baseLanguage ['ecat_file'] ; ?></small></p>
				    </div>
				  </div>
				  
				  <div class="form-group">
				    <div class="col-sm-offset-4 col-sm-8">
				      <button type="submit" id="uploadButton" class="btn btn-primary"><?php echo $baseLanguage ['principal_manufacturer_save'] ; ?></button>
				    </div>
				  </div>
				</form>
          <div class="text-right">
            <!-- <button class="btn btn-info" id="renewPR">Perbarui</button> -->
          </div>
        </div>
      </div>
    </div>
  </div>

<div class="modal fade" id="modalkategori">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title text-center"><u>Pilih Kategori Material<!-- <?php //echo $baseLanguage ['principal_manufacturer_addTtl'] ; ?> --></u></h4>
        </div>
        <div class="modal-body">
        	<div class="row"> 
			    <div class="col-lg-4" style="overflow-x: auto; max-height:60vh; border-right:2px solid #ccc;">
						<ul>
							<!-- <a href="javascript:void(0)" onclick="setCode('root',this)" class="lvl0">/ROOT</a> -->
						</ul>
						<ul id="tree1"> 
						</ul> 
					</div>
			    <div class="col-lg-8">
				    <?php echo form_open_multipart('EC_Strategic_material/setKategori/', array('method' => 'POST', 'class' => 'form-horizontal')); ?> 
				    <!-- <form class="form-horizontal"> -->

				    	<div class="form-group">
					    <label for="CODE_M" class="col-sm-3 control-label">Kode Material<!-- <?php //echo $baseLanguage ['principal_manufacturer_name'] ; ?> --></label>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="CODE_M" name="CODE_M"  readonly>
					    </div>
					  </div> 

					  <div class="form-group">
					    <label for="nama_material" class="col-sm-3 control-label">Nama Material<!-- <?php //echo $baseLanguage ['principal_manufacturer_code'] ; ?> --></label>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="nama_material" readonly>
					    </div>
					  </div> 
					  
					  <div class="form-group">
					    <label for="Category" class="col-sm-3 control-label">Nama Kategori<!-- <?php //echo $baseLanguage ['principal_manufacturer_name'] ; ?> --></label>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="Category" name="Category"  readonly>
					    </div>
					  </div> 
					  <div class="form-group">
					    <label for="CODE_Category" class="col-sm-3 control-label">Kode Kategori<!-- <?php //echo $baseLanguage ['principal_manufacturer_name'] ; ?> --></label>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="CODE_Category" name="CODE_Category"  readonly>
					      <input type="hidden" class="form-control" id="ID_Category" name="ID_Category">
					    </div>
					  </div> 
					  <div class="form-group">
						  <div class="col-sm-3">
						  </div>
					    <div class="col-sm-9">
					      <button type="submit" id="uploadButton" class="btn btn-default">Simpan</button>
					    </div>
					  </div> 
					  
					</form>
			    </div>
          	</div>
        </div>
      </div>
    </div>
</div>