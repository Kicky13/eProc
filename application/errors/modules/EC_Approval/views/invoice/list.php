<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <?php
            $pesannya = $this->session->flashdata('msg');
            if (!empty($pesannya)) {
                echo '<div class="alert alert-info">' . $pesannya . '</div>';
            }
            ?>
            <div class='alert alert-info hide' id="msg"></div>
            <div class="row">
                <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="table_invoice" class="table table-striped nowrap" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center ts0"><a href="javascript:void(0)">No.</th>
                                                <th class="text-center ts3"><a href="javascript:void(0)">No. Invoice</a></th>
                                                <th class="text-center ts3"><a href="javascript:void(0)">Tanggal Dibuat</a></th>
                                                <th class="text-center ts3"><a href="javascript:void(0)">No. Faktur</a></th>
                                                <th class="text-center ts6"><a href="javascript:void(0)">Total Payment</a></th>
                                                <th class="text-center ts6"><a href="javascript:void(0)">Vendor</a></th>
                                                <th class="text-center ts9"><a href="javascript:void(0)">Aksi</a></th>
                                            </tr>
                                            <tr class="sear">
                                                <th></th>
                                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
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
                <br><br>
            </div>
        </div >
    </div >
</section>


<div id="viewEnofa" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">View E-Nofa</h4>
      </div>
      <div class="modal-body">
        <table class="table table-responsive" id="tabel_view">
            
        </table>
      </div>
      <div class="modal-footer text-center">
      </div>
    </div>

  </div>
</div>

<div id="rejectNote" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reject Note</h4>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart(base_url('EC_Approval/E_Nofa/verEnofa'), array('method' => 'POST', 'class' => 'form-horizontal formEdit')); ?>
        <div class="form-group">
            <div class="form-group">
                <input type="text" name="id_enova" class="hide">
                <input type="text" name="status" class="hide">
                <label for="Invoice No" class="col-sm-3 control-label">Alasan Reject</label>
                <div class="col-sm-8">
                    <textarea class="form-control" required="" id="msg" name="msg"></textarea>
                </div>
            </div>
                <div class="form-group">
                    <label for="Invoice No" class="col-sm-3 control-label">Attachment</label>
                    <div class="col-sm-8">
                        <input type="file" id="file" class="filestyle" data-buttonText="Find file" name="img" id="img">
                    </div>
                </div>
            <div class="col-sm-12 text-center">
                <button type="submit" class="btn btn-success">Submit</button>
                <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>