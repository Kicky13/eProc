
<section class="content_section">
  <div class="content_spacer">
    <div class="content">
      <div class="main_title centered upper">
        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
      </div>
      <div class="row">
      	<div class="row">
      		<button type="button" class="col-xs-offset-2 col-sm-offset-2 col-md-offset-2 btn btn-default" data-toggle="modal" data-target="#modalnew" data-dt="new">Add new</button>
      	</div>
        <div class="row "> 
          <div class="col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2 col-xs-8 col-sm-8 col-md-8 col-lg-8"  >
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <table id="tableMT" class="table table-striped">
                <thead>
                  <tr>
                    <th class="text-center ts0"><a href="javascript:void(0)">No.</a></th>
                    <th class="text-center ts1"><a href="javascript:void(0)">Value</a></th> 
                    <th class="text-center">Status</th> 
                  </tr>
                  <tr>
                    <th> </th>
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th> 
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

<div class="modal fade" id="modalnew">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title text-center"><u>Add Purchase Organization</u></h4>
        </div>
        <div class="modal-body">        	 	
          	<?php echo form_open_multipart('EC_prog_org/baru/', array('method' => 'POST', 'class' => 'form-horizontal')); ?>
				  <div class="form-group">
				    <label for="CATEGORY" class="col-sm-2 control-label">Status</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="CATEGORY" name="CATEGORY" value="0"  readonly>
				    </div>
				  </div> 
				  
				  <div class="form-group">
				    <label for="TYPE" class="col-sm-2 control-label">Purchase Organization</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="TYPE" name="TYPE"  required>
				    </div>
				  </div> 
				  				   
				  <div class="form-group">
				    <div class="col-sm-offset-5 col-sm-6">
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