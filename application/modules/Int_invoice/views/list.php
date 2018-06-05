<section class="content_section">
  <div class="content_spacer" >
    <div class="content" style="overflow-y:auto">
      <div class="main_title centered upper">
        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
      </div>
      <div class="row">
        <div class="row "> 
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
          <!-- <div class="panel panel-default">
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-2">
                      <a href="<?php echo base_url('Invoice/add') ?>" id="button_tambah" class="btn btn-success btn-block">Tambah</a>
                  </div>
                </div>
            </div>
          </div> -->
          <!-- <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">  
                      <label>Status</label>
                      <div class="field">
                        <select name="stat" id="stat" class="form-control filterStatus">
                          <option value="0">Submited</option>
                          <option value="1">Approved</option>
                          <option value="2">Rejected</option>
                        </select>
                        <span class="help-block"></span>
                      </div>
          </div> -->
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <table id="tableMT" class="table table-striped">
                <thead>
                  <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">No. Vendor</th>
                    <th class="text-center">No. PO</th>
                    <th class="text-center">No. GR</th>
                    <th class="text-center">No. Invoice</th>
                    <th class="text-center">Faktur Pajak</th>
                    <th class="text-center">BAPP</th>
                    <th class="text-center">BAST</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Tgl Submit</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                  <tr>
                    <th> </th>
                    <th><input type="text" class="col-xs-12"></th>
                    <th><input type="text" class="col-xs-12"></th>
                    <th><input type="text" class="col-xs-12"></th>
                    <th><input type="text" class="col-xs-12"></th>
                    <th><input type="text" class="col-xs-12"></th>
                    <th><input type="text" class="col-xs-12"></th>
                    <th><input type="text" class="col-xs-12"></th>
                    <th><input type="text" class="col-xs-12"></th> 
                    <th><input type="text" class="col-xs-12"></th> 
                    <th><input type="text" class="col-xs-12"></th>
                    <th> </th>                 
                  </tr>
                </thead>
                <tbody id="tabelnya">  
                    <tr><td colspan="5">Tidak ada data.</td></tr>                             
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
          <h4 class="modal-title text-center"><u>FORM UBAH INVOICE</u></h4>
        </div>
        <div class="modal-body">  
        <!-- <?php if(isset($progress_status[$container]) && $progress_status[$container]['STATUS'] == 'Rejected'):?> -->
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="alert alert-warning" role="alert"><strong>Keterangan Revisi! </strong></div> 
                                            </div>
                                        </div>
                                        <hr>
                                    <!-- <?php endif ?> -->          
          <!-- <form class="form-horizontal" id="formUp" action="E_Catalog/upload/" method="post" enctype="multipart/form-data"> -->
            <?php echo form_open_multipart('Ubah_email_vnd/updateEmail/',array('method' => 'POST','id'=>'formUp','class' => 'form-horizontal')); ?>
                <div class="col-md-12 hidden">
                    <input type="hidden" class="form-control" id="edit_id" name="edit_id">
                  </div>

                                <div class="form-group" style="display: flex; margin-top: 15px;">
                                        <label for="new_tgl" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">Tanggal Invoice</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="new_tgl_inv" id="new_tgl_inv" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
          
          
                                    <div class="form-group" style="display: flex; margin-top: 15px;">                                
                                        <label for="VENDOR_NO" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">No. Vendor</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="VENDOR_NO" name="VENDOR_NO">
                                        </div>
                                    </div>
          
          
                                    <div class="form-group" style="display: flex; margin-top: 15px;">                                
                                        <label for="new_po" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">No. PO</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="new_po" name="new_po">
                                        </div>
                                    </div>
          
                                    <div class="form-group" style="display: flex; margin-top: 15px;">                                
                                        <label for="new_po" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">No. GR</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="new_gr" name="new_gr">
                                        </div>
                                    </div>

                                    <div class="form-group" style="display: flex; margin-top: 15px;">                                
                                        <label for="new_invoice" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">No. Invoice</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="new_invoice" name="new_invoice">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="new_pajak" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">Faktur Pajak</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="new_pajak" name="new_pajak">
                                        </div>
                                        <div class="colm-sm-6">
                                            <input type="text" id="akta_no_doc" class="hidden" name="new_file_pajak">
                                            <button type="button" class="uploadAttachment btn btn-default">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="new_bapp" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">BAPP</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="new_bapp" name="new_bapp">
                                        </div>
                                        <div class="colm-sm-6">
                                            <input type="text" id="akta_no_doc" class="hidden" name="new_file_bapp">
                                            <button type="button" class="uploadAttachment btn btn-default">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="new_bast" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">BAST</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="new_bast" name="new_bast">
                                        </div>
                                        <div class="colm-sm-6">
                                            <input type="text" id="akta_no_doc" class="hidden" name="new_file_bast">
                                            <button type="button" class="uploadAttachment btn btn-default">Upload File (2MB Max)</button><span class="filenamespan"></span>
                                            <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" style="display: flex; margin-top: 15px;">                                
                                        <label for="new_ket" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">Keterangan</label>
                                        <div class="col-sm-3">
                                            <textarea name="new_ket" style="margin: 0px; width: 440px; height: 96px;"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-center">
                                    <button id="save_new" class="main_button color1 small_btn" type="submit">Updates</button>
                                    <a href="<?php echo base_url('Invoice') ?>" class="main_button color7 small_btn">Batal</a>
                                </div>
                                <!-- </form> -->
      </div>
    </div>
  </div>