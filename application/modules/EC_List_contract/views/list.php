
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
            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
              <table id="tableMT" class="table table-striped nowrap" width="100%">
                <thead>
                  <tr>
                    <th class="text-center ts0"><a href="javascript:void(0)">No.</a></th>
                    <th class="text-center ts1"><a href="javascript:void(0)"><?php echo $baseLanguage['list_contract_no']; ?></a></th>
                    <th class="text-center ts2"><a href="javascript:void(0)"><?php echo $baseLanguage['list_contract_itm']; ?></a></th>
                    <th class="text-center ts3"><a href="javascript:void(0)"><?php echo $baseLanguage['list_contract_doc']; ?></a></a></th>
                    <th class="text-center ts4"><a href="javascript:void(0)"><?php echo $baseLanguage['list_contract_vndno']; ?></a></th>
                    <th class="text-center ts5"><a href="javascript:void(0)"><?php echo $baseLanguage['list_contract_vndname']; ?></th>
                    <th class="text-center ts6"><a href="javascript:void(0)"><?php echo $baseLanguage['list_contract_valdtsr']; ?></th>
                    <th class="text-center ts7"><a href="javascript:void(0)"><?php echo $baseLanguage['list_contract_valdten']; ?></th>
                    <th class="text-center ts8"><a href="javascript:void(0)"><?php echo $baseLanguage['list_contract_matno']; ?></th>
                    <th class="text-center ts9"><a href="javascript:void(0)"><?php echo $baseLanguage['list_contract_shrt']; ?></th>
                    <th class="text-center ts10"><a href="javascript:void(0)"><?php echo $baseLanguage['list_contract_matg']; ?></th>
                    <th class="text-center ts11"><a href="javascript:void(0)"><?php echo $baseLanguage['list_contract_prog']; ?></th>
                    <th class="text-center ts12"><a href="javascript:void(0)"><?php echo $baseLanguage['list_contract_prgp']; ?></th>
                    <th class="text-center ts13"><a href="javascript:void(0)"><?php echo $baseLanguage['list_contract_plnt']; ?></th>
                    <th class="text-center ts14"><a href="javascript:void(0)"><?php echo $baseLanguage['list_contract_qty']; ?></th>
                    <th class="text-center ts15"><a href="javascript:void(0)"><?php echo $baseLanguage['list_contract_uom']; ?></th>
                    <th class="text-center ts16"><a href="javascript:void(0)"><?php echo $baseLanguage['list_contract_nprc']; ?></th>
                    <th class="text-center ts17"><a href="javascript:void(0)"><?php echo $baseLanguage['list_contract_per']; ?></th>
                    <th class="text-center ts18"><a href="javascript:void(0)"><?php echo $baseLanguage['list_contract_grpr']; ?></th>
                    <th class="text-center ts19"><a href="javascript:void(0)"><?php echo $baseLanguage['list_contract_curr']; ?></th>
                    <th class="text-center ts20"><a href="javascript:void(0)"><?php echo $baseLanguage['list_contract_ah']; ?></th>                     
                  </tr>
                  <tr>
                    <th> </th>
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th> 
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th> 
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th> 
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th> 
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th> 
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th> 
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>                     
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th> 
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th> 
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th> 
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>                     
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th> 
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>                     
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th> 
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th> 
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="min-width: 50px"></th>   
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
          	<?php echo form_open_multipart('Strategic_material/upload/', array('method' => 'POST', 'id' => 'formUp', 'class' => 'form-horizontal')); ?>
				  <div class="form-group">
				    <label for="MATNR" class="col-sm-2 control-label"><?php echo $baseLanguage['strategic_material_no']; ?></label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="MATNR" readonly>
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="MAKTX" class="col-sm-2 control-label"><?php echo $baseLanguage['strategic_material_shrt_txt']; ?></label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="MAKTX" readonly>
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="TDLINE" class="col-sm-2 control-label"><?php echo $baseLanguage['strategic_material_long_txt']; ?></label>
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
				    <label for="MATKL" class="col-sm-2 control-label"><?php echo $baseLanguage['strategic_material_group']; ?></label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="MATKL" readonly>
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="MTART" class="col-sm-2 control-label"><?php echo $baseLanguage['strategic_material_type']; ?></label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="MTART" readonly>
				    </div>
				  </div> 
				   
				  <div class="form-group">
				    <label for="created" class="col-sm-2 control-label"><?php echo $baseLanguage['strategic_material_created']; ?></label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="created" readonly>
				    </div>
				  </div> 
				  				 
				  <div class="form-group">	
				    <label for="picure" class="col-sm-2 control-label">Picure</label>			    
				    <div class="col-sm-offset-3 col-sm-9">				  
      					<img id="pic" class="thumbnail zoom" onerror="this.onerror=null;this.src='<?php echo base_url(UPLOAD_PATH) . '/EC_material_strategis/default_post_img.png'; ?>'"
      					 src="<?php echo base_url(UPLOAD_PATH) . '/EC_material_strategis/default_post_img.png'; ?>">
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <div class="col-sm-offset-3 col-sm-9">
				    <input type="file" name="picture" id="picure">
				    </div>
				    <div class="col-sm-offset-3 col-sm-9">
				    <p class="help-block"><small><?php echo $baseLanguage['ecat_file']; ?></small> </p>
				    </div>
				  </div>
				  
				  <div class="form-group">	
				    <label for="drawing" class="col-sm-2 control-label">Drawing</label>			    
				    <div class="col-sm-offset-3 col-sm-9">				  
      					<img id="draw" class="thumbnail zoom" onerror="this.onerror=null;this.src='<?php echo base_url(UPLOAD_PATH) . '/EC_material_strategis/default_post_img.png'; ?>'"
      					 src="<?php echo base_url(UPLOAD_PATH) . '/EC_material_strategis/default_post_img.png'; ?>">
				    </div>
				  </div> 
				  				  
				  <div class="form-group">
				    <div class="col-sm-offset-4 col-sm-8">
				      <!-- <button type="submit" id="uploadButton" class="btn btn-primary"><?php echo $baseLanguage['principal_manufacturer_save']; ?></button> -->
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
