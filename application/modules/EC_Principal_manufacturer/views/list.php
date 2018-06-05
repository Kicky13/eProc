
<section class="content_section">
  <div class="content_spacer">
    <div class="content">
      <div class="main_title centered upper">
        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
      </div>
      <div class="row">
      	<div class="row ">
      		<input type="hidden" id="btn2" value="Tambah" />
      		<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalholder" data-whatever="new">Tambah</button>
      	</div>
        <div class="row "> 
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <table id="tableMT" class="table table-striped">
                <thead>
                  <tr>
                    <th class="text-center ts0"><a href="javascript:void(0)">No.</a></th>
                    <th class="text-center ts1"><a href="javascript:void(0)">Kode Principal</a></th>
                    <th class="text-center ts2"><a href="javascript:void(0)">Nama Principal</a></th>
                    <th class="text-center ts3"><a href="javascript:void(0)">Negara</a></th>
                    <th class="text-center ts4"><a href="javascript:void(0)">No Telp.</a></th>
                    <th class="text-center ts5"><a href="javascript:void(0)">Website</th>
                    <th class="text-center ts6"><a href="javascript:void(0)">Email</th>
                    <th class="text-center">Aksi</th>
                    <th class="text-center">Partner</th> 
                  </tr>
                  <tr>
                    <th> </th>
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>  
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>                    
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
          <h4 class="modal-title text-center"><u>Tambah Principal Manufacturer</u></h4>
        </div>
        <div class="modal-body">        	 	
          	<?php echo form_open_multipart('EC_Principal_manufacturer/baru/', array('method' => 'POST', 'class' => 'form-horizontal')); ?>
				  <div class="form-group">
				    <label for="PC_CODE" class="col-sm-2 control-label">Kode Principal</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="PC_CODE" name="PC_CODE" value="<?php echo $pc_code ?>"  readonly>
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="PC_NAME" class="col-sm-2 control-label">Nama Principal</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="PC_NAME" name="PC_NAME"  required>
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="COUNTRY" class="col-sm-2 control-label">Negara</label>
				    <div class="col-sm-9">
				      <input class="form-control" id="COUNTRY" name="COUNTRY"  required>				      
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="ADDRESS" class="col-sm-2 control-label">Alamat</label>
				    <div class="col-sm-9">
				    	<textarea rows="3" class="form-control" id="ADDRESS" name="ADDRESS" required></textarea>
				      <!-- <input type="text" class="form-control" id="ADDRESS" name="ADDRESS"  required> -->
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="PHONE" class="col-sm-2 control-label">No Telp.</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="PHONE" name="PHONE"  required>
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="FAX" class="col-sm-2 control-label">No Fax</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="FAX" name="FAX"  required>
				    </div>
				  </div> 
				   
				  <div class="form-group">
				    <label for="MAIL" class="col-sm-2 control-label">Email</label>
				    <div class="col-sm-9">
				      <input type="email" class="form-control" id="MAIL" name="MAIL"  required>
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="WEBSITE" class="col-sm-2 control-label">Website</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="WEBSITE" name="WEBSITE"  required>
				    </div>
				  </div>
				  
				  <div class="form-group">	
				    <label for="picure" class="col-sm-2 control-label"><?php echo $baseLanguage ['principal_manufacturer_logo'] ; ?></label>			    
				    <div class="col-sm-offset-3 col-sm-9">				  
      					<img id="LOGO" class="thumbnail zoom" onerror="this.onerror=null;this.src='<?php echo base_url(UPLOAD_PATH) . '/EC_principal_manufacturer/default_post_img.png'; ?>'"
      					 src="<?php echo base_url(UPLOAD_PATH) . '/EC_principal_manufacturer/default_post_img.png'; ?>">
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <div class="col-sm-offset-3 col-sm-9">
				    <input type="file"  id="picure" name="LOGO"  required>
				    </div>
				    <div class="col-sm-offset-3 col-sm-9">
				    <p class="help-block"><small>ukuran file maks 500kb, bertipe jpg/png</small> </p>
				    </div>
				  </div>
				   
				  <div class="form-group">
				    <div class="col-sm-offset-4 col-sm-9">
				      <button type="submit" id="uploadButton" class="btn btn-primary">Simpan</button>
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

<div class="modal fade" id="modaledit">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title text-center"><u>Edit Principal Manufacturer</u></h4>
        </div>
        <div class="modal-body">        	 	
          	<?php echo form_open_multipart('EC_Principal_manufacturer/edit/', array('method' => 'POST', 'class' => 'form-horizontal')); ?>
				  <div class="form-group">
				    <label for="PC_CODE_edit" class="col-sm-2 control-label">Kode Principal</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="PC_CODE_edit" name="PC_CODE_edit" value="<?php echo $pc_code ?>"  readonly>
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="PC_NAME_edit" class="col-sm-2 control-label">Nama Principal</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="PC_NAME_edit" name="PC_NAME_edit"  required>
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="COUNTRY_edit" class="col-sm-2 control-label">Negara</label>
				    <div class="col-sm-9">
				      <input class="form-control" id="COUNTRY_edit" name="COUNTRY_edit"  required>				      
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="ADDRESS_edit" class="col-sm-2 control-label">Alamat</label>
				    <div class="col-sm-9">
				    	<textarea rows="3" class="form-control" id="ADDRESS_edit" name="ADDRESS_edit" required></textarea>
				      <!-- <input type="text" class="form-control" id="ADDRESS" name="ADDRESS"  required> -->
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="PHONE_edit" class="col-sm-2 control-label">No Telp.</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="PHONE_edit" name="PHONE_edit"  required>
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="FAX_edit" class="col-sm-2 control-label">No Fax</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="FAX_edit" name="FAX_edit"  required>
				    </div>
				  </div> 
				   
				  <div class="form-group">
				    <label for="MAIL_edit" class="col-sm-2 control-label">Email</label>
				    <div class="col-sm-9">
				      <input type="email" class="form-control" id="MAIL_edit" name="MAIL_edit"  required>
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="WEBSITE_edit" class="col-sm-2 control-label">Website</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="WEBSITE_edit" name="WEBSITE_edit"  required>
				    </div>
				  </div>
				  
				  <div class="form-group">	
				    <label for="picure" class="col-sm-2 control-label"><?php echo $baseLanguage ['principal_manufacturer_logo'] ; ?></label>			    
				    <div class="col-sm-offset-3 col-sm-9">				  
      					<img id="LOGO_edit" class="thumbnail zoom" onerror="this.onerror=null;this.src='<?php echo base_url(UPLOAD_PATH) . '/EC_principal_manufacturer/default_post_img.png'; ?>'"
      					 src="<?php echo base_url(UPLOAD_PATH) . '/EC_principal_manufacturer/default_post_img.png'; ?>">
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <div class="col-sm-offset-3 col-sm-9">
				    <input type="file"  id="picure" name="LOGO_edit"  required>
				    </div>
				    <div class="col-sm-offset-3 col-sm-9">
				    <p class="help-block"><small>ukuran file maks 500kb, bertipe jpg/png</small> </p>
				    </div>
				  </div>
				   
				  <div class="form-group">
				    <div class="col-sm-offset-4 col-sm-9">
				      <button type="submit" id="uploadButton_edit" class="btn btn-primary">Simpan</button>
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

<div class="modal fade" id="modaldetail">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><u>Data Principal Manufacturer</u></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-7">
						<?php echo form_open("", array('class' => 'form-horizontal')); ?>
							<div class="form-group">
							    <label for="PC_CODE"	 class="col-sm-3 control-label">Kode Principal</label>
							    <div class="col-sm-8">
							      <input type="text" class="form-control" id="PC_CODE_detail" name="PC_CODE" value=""  readonly>
							    </div>
							  </div> 
							  
							  <div class="form-group">
							    <label for="PC_NAME" class="col-sm-3 control-label">Nama Principal</label>
							    <div class="col-sm-8">
							      <input type="text" class="form-control" id="PC_NAME_detail" name="PC_NAME"  readonly>
							    </div>
							  </div> 
							  
							  <div class="form-group">
							    <label for="CREATED" class="col-sm-3 control-label">Dibuat</label>
							    <div class="col-sm-8">
							      <input type="text" class="form-control" id="CREATED_detail" name="CREATED"  readonly>
							    </div>
							  </div> 
							  
							  <div class="form-group">
							    <label for="LASTCHG" class="col-sm-3 control-label">Diubah</label>
							    <div class="col-sm-8">
							      <input type="text" class="form-control" id="LASTCHG_detail" name="LASTCHG"  readonly>
							    </div>
							  </div>  
							  
							  <div class="form-group">
							    <label for="LASTCHG" class="col-sm-3 control-label">Kontak</label>
							    <div class="col-sm-8">
							      <?php echo form_open("", array('class' => 'form-horizontal')); ?>
							      
									  <div class="form-group">
									    <label for="COUNTRY" class="col-sm-3 control-label">Negara</label>
									    <div class="col-sm-8">
									      <input class="form-control" id="COUNTRY_detail" name="COUNTRY"  readonly>				      
									    </div>
									  </div> 
									  
									  <div class="form-group">
									    <label for="ADDRESS" class="col-sm-3 control-label">Alamat</label>
									    <div class="col-sm-8">
									      <input type="text" class="form-control" id="ADDRESS_detail" name="ADDRESS"  readonly>
									    </div>
									  </div> 
									  
									  <div class="form-group">
									    <label for="PHONE" class="col-sm-3 control-label">No Telp.</label>
									    <div class="col-sm-8">
									      <input type="text" class="form-control" id="PHONE_detail" name="PHONE"  readonly>
									    </div>
									  </div> 
									  
									  <div class="form-group">
									    <label for="FAX" class="col-sm-3 control-label">No Fax</label>
									    <div class="col-sm-8">
									      <input type="text" class="form-control" id="FAX_detail" name="FAX"  readonly>
									    </div>
									  </div> 
									   
									  <div class="form-group">
									    <label for="MAIL" class="col-sm-3 control-label">Email</label>
									    <div class="col-sm-8">
									      <input type="text" class="form-control" id="MAIL_detail" name="MAIL"  readonly>
									    </div>
									  </div> 
									  
									  <div class="form-group">
									    <label for="WEBSITE" class="col-sm-3 control-label">Website</label>
									    <div class="col-sm-8">
									      <input type="text" class="form-control" id="WEBSITE_detail" name="WEBSITE"  readonly>
									    </div>
									  </div>
									</form>	
							    </div>
							  </div> 							  
							</form>				  
						</div>
						<div class="col-sm-5">
							<?php echo form_open_multipart('EC_Principal_manufacturer/upload/', array('method' => 'POST', 'id' => 'formUp', 'class' => 'form-horizontal')); ?>
							
							  <div class="form-group">	
							    <div class="col-sm-8">				  
			      					<img id="LOGO_detail" class="thumbnail zoom" onerror="this.onerror=null;this.src='<?php echo base_url(UPLOAD_PATH) . '/EC_principal_manufacturer/default_post_img.png'; ?>'"
			      					 src="<?php echo base_url(UPLOAD_PATH) . '/EC_principal_manufacturer/default_post_img.png'; ?>">
							    </div>
							  </div> 
							  
							  <div class="form-group">
							    <div class="col-sm-9">
							    <input type="file"  id="LOGO_detail" name="LOGO"  required>
							    </div>
							    <div class="col-sm-9">
							    <p class="help-block"><small>ukuran file maks 500kb, bertipe jpg/png</small> </p>
							    </div>
							  </div>
							   
							  <div class="form-group">
							    <div class="col-sm-offset-2 col-sm-9">
							      <button type="submit" id="uploadButton" class="btn btn-primary">Simpan</button>
							    </div>
							  </div>
							</form>
						</div>					
				</div>
				<div class="row"><!-- col-sm-offset-1 col-md-offset-1 col-lg-offset-1  -->
					<div class="col-sm-12 col-lg-12">
						<table id="tableDetail" class="table table-striped" style="">
			                <thead>
			                	<tr>
				                    <th class="text-center" colspan="5"><?php echo $baseLanguage ['principal_manufacturer_business_partner'] ; ?></a></th>
				                </tr>				                
				                <tr>
				                    <th class="text-center"><?php echo $baseLanguage ['principal_manufacturer_supplier'] ; ?></a></th>
				                    <th class="text-center">Negara</a></th>
				                    <th class="text-center">Website</a></th>
				                    <th class="text-center">Email</a></th>
				                    <th class="text-center">No Telp.</a></th>
				                </tr>
			                </thead>
			                <tbody>
			                </tbody>
			             </table>	
					</div>
				</div>
					
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modaladdpartner">
	<div class="modal-dialog modal-lg modal-guwede">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><u><?php echo $baseLanguage ['principal_manufacturer_title3'] ; ?></u></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-10 ">
						<h6 class="text-left"><?php echo $baseLanguage ['principal_manufacturer_principal'] ; ?> : <b><u id="principal">SHAEFLER BEARING</u></b></h6>						
					</div>					
				</div>
				<div class="row">
					<div class="col-sm-12 col-lg-12 ">
						<table id="tableBPA" class="table table-striped">
							<thead>
								<tr>
									<th class="text-center sts0"><a href="javascript:void(0)">No.</a></th>
									<th class="text-center sts1"><a href="javascript:void(0)"><?php echo $baseLanguage ['principal_manufacturer_vendor_no'] ; ?></a></th>
									<th class="text-center sts2"><a href="javascript:void(0)">Nama Principal</a></th>
									<th class="text-center sts3"><a href="javascript:void(0)">Negara</a></th>
									<th class="text-center sts4"><a href="javascript:void(0)">No Telp.</a></th> 
									<th class="text-center sts6"><a href="javascript:void(0)">Website</th>
									<th class="text-center sts6"><a href="javascript:void(0)">Email</th>
									<th class="text-center">Partner</th>
								</tr>
								<tr>
									<th></th>
									<th>
										<input type="text" class="col-xs-10 col-xs-offset-1 srch">
									</th>
									<th>
										<input type="text" class="col-xs-10 col-xs-offset-1 srch">
									</th>
									<th>	
										<input type="text" class="col-xs-10 col-xs-offset-1 srch">
									</th>
									<th>
										<input type="text" class="col-xs-10 col-xs-offset-1 srch">
									</th>
									<th>
										<input type="text" class="col-xs-10 col-xs-offset-1 srch">
									</th> 
									<th>
										<input type="text" class="col-xs-10 col-xs-offset-1 srch">
									</th> 
									<th>
										<!-- <label style="padding-top: 0px" class="checkbox-inline col-md-10 col-md-offset-1  col-xs-10 col-lg-offset-1  col-xs-10 col-lg-offset-1 text-center">
										<input type="checkbox" id="checkAll" onclick="" value="option1">
										Check All </label> -->
									</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>												
					</div>					
				</div>
				
			</div>
		</div>
	</div>
</div>
