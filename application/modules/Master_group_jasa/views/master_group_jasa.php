
<section class="content_section">
<div class="content_spacer">
    <div class="content">
        <div class="main_title centered upper">
            <h2><span class="line"><i class="ico-users"></i></span><?php echo $title; ?></h2>
        </div>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading  ">Form</div>
                <div class="panel-body">
                    <?php echo form_open('Master_group_jasa/',array('class' => 'form-horizontal form_valid')); ?>
                      <input type="hidden" name="jasa_id" id="jasa_id" class=" form-control" />
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Parent Jasa</label>
                          <div class="col-sm-9">
                              <div class="col-sm-5">
                                  <input type="hidden" name="parent_id" id="parent_id" class=" form-control" />
                                  <input type="text" id="parent_name" class=" form-control" disabled/>                                      
                              </div>
                              <div class="col-sm-5">
                                  <div class="field">
                                      <button id="getKode" type="button" class="btn btn-primary">Kode</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Nama<span style="color: #E74C3C">*</span></label>
                          <div class="col-sm-9">
                              <div class="col-sm-5">
                                  <input type="text" name="nama" id="nama" class=" form-control" />
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Kategori</label>
                          <div class="col-sm-9">
                              <div class="col-sm-5">
                                  <input type="hidden" name="kategori_id" id="kategori_id" value="1" class=" form-control" /> 
                                  <input type="text" id="kategori" class=" form-control" value="GROUP" disabled/> 
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="description" class="col-sm-3 control-label">Description</label>
                          <div class="col-sm-9">
                              <div class="col-sm-5">
                                  <textarea type="text" name="description" id="description" class=" form-control" style="resize: vertical"> </textarea>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-sm-9" align="center">
                              <input type="submit" id="simpan" class="btn btn-success" value="Simpan">&nbsp;&nbsp;
                              <input  type="reset"  id="batal" class="btn btn-info" value="Batal">&nbsp;&nbsp;
                          </div>
                      </div>
                    <?php echo form_close(); ?>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading">
                  Daftar Jasa
                </div>
                <div class="panel-body" style="overflow: auto;">
                    <table class="table table-hover" id="list_jasa">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                            <tr>
                                <th> </th>
                                <th><input type="text" class="col-xs-12"></th>
                                <th><input type="text" class="col-xs-12"></th>
                                <th><input type="text" class="col-xs-12"></th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div >
    </div >
</div >
</section >

<div class="modal fade bs-example-modal-lg"  role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="myModalLabel">Tree Parent Jasa</h4>
          </div>
          <div class="modal-body">
              <div class="container-fluid">
                  <div id="tampilbody"></div>
              </div>
          </div>           
        </div>
    </div>
</div>