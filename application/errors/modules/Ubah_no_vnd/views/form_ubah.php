
<section class="content_section">
  <div class="content_spacer">
    <div class="content">
      <div class="main_title centered upper">
        <h2><span class="line"><i class="ico-users"></i></span><?php echo $baseLanguage [$title] ?></h2>
      </div>
      <div class="row">
        <div class="row "> 
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <table id="tableMT" class="table table-striped">
                <thead>
                  <tr>
                    <th class="text-center ts0">No.</th>
                    <th class="text-center ts1"><?php echo $baseLanguage['vendor_no']; ?></th></th>
                    <th class="text-center ts2"><?php echo $baseLanguage['vendor_name']; ?></th>
                    <th class="text-center ts3"><?php echo $baseLanguage['vendor_city']; ?></th>
                    <th class="text-center ts4"><?php echo $baseLanguage['vendor_type']; ?></th>
                    <th class="text-center ts5"><?php echo $baseLanguage['vendor_email']; ?></th>
                    <th class="text-center ts6"><?php echo $baseLanguage['action']; ?></th>
                  </tr>
                  <tr>
                    <th> </th>
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
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

<div class="modal fade" id="modalholder">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title text-center"><u><?php echo $baseLanguage ['form_edit_no']; ?></u></h4>
        </div>
        <div class="modal-body">            
          <!-- <form class="form-horizontal" id="formUp" action="E_Catalog/upload/" method="post" enctype="multipart/form-data"> -->
            <?php echo form_open_multipart('Ubah_no_vnd/updateNo/',array('method' => 'POST','id'=>'formUp','class' => 'form-horizontal')); ?>
                <div class="col-md-12 hidden">
                    <input type="hidden" class="form-control" id="VENDOR_ID" name="VENDOR_ID">
                  </div>

          <div class="form-group">
            <label for="VENDOR_NO" class="col-sm-3 control-label"><?php echo $baseLanguage['vendor_no']; ?></label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="VENDOR_NO" name="VENDOR_NO">
            </div>
          </div> 
          
          <div class="form-group">
            <label for="VENDOR_NAME" class="col-sm-3 control-label"><?php echo $baseLanguage['vendor_name']; ?></label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="VENDOR_NAME" readonly>
            </div>
          </div> 
          
          <div class="form-group">
            <label for="ADDRESS_CITY" class="col-sm-3 control-label"><?php echo $baseLanguage['vendor_city']; ?></label>
            <div class="col-sm-9">
              <input type="text" class="form-control" rows="5" id="ADDRESS_CITY" readonly></textarea>             
            </div>
          </div> 
          
          <div class="form-group">
            <label for="VENDOR_TYPE" class="col-sm-3 control-label"><?php echo $baseLanguage['vendor_type']; ?></label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="VENDOR_TYPE" readonly>
            </div>
          </div> 
          
          <div class="form-group">
            <label for="EMAIL_ADDRESS" class="col-sm-3 control-label"><?php echo $baseLanguage['vendor_email']; ?></label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="EMAIL_ADDRESS" id="EMAIL_ADDRESS" readonly>
            </div>
          </div> 
          
          
          <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
              <button type="submit" id="uploadButton" class="btn btn-primary"><?php echo $baseLanguage['save']; ?></button>
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
