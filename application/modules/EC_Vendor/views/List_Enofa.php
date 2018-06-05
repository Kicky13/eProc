<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <?php $msg = $this->session->flashdata('error');?>
            
            <div class="row">
                <div class="row">
                    <div id="Invoiced">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="row" style="border-bottom: 1px solid #ccc;">
                                        <div class="col-md-12">
                                            <div id='msg' class='alert alert-info <?php echo !empty($msg) ? "" : "hide"?>' ><?php echo !empty($msg) ? $msg : ""?></div>
                                        
                                                <a href="<?php echo base_url('EC_Vendor/Form_Enofa') ?>" class="btn btn-info pull-right" style="margin: 0 15px 10px 0;">Daftarkan E-Nofa</button>
                                        <br></a>
                                        <br>
                                        </div>
                                </div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a class="tab1" href="#Request" aria-controls="Request" role="tab" data-toggle="tab">Request</a></li>
                                    <li role="presentation"><a class="tab2" href="#Approved" aria-controls="Approved" role="tab" data-toggle="tab">Approved</a></li>
                                </ul>
                                <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="Request">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="table_enofa" class="table table-striped nowrap" width="100%">
                                        <thead>
                                                <tr>
                                                    <th class="text-center ts0"><a href="javascript:void(0)">No.</th>
                                                    <th class="text-center ts1"><a href="javascript:void(0)">Tangal Mulai Aktif</a></th>
                                                    <th class="text-center ts2"><a href="javascript:void(0)">Tangal Expired</a></th>
                                                    <th class="text-center ts3"><a href="javascript:void(0)">No. Awal</a></th>
                                                    <th class="text-center ts4"><a href="javascript:void(0)">No. Akhir</a></th>
                                                    <th class="text-center ts5"><a href="javascript:void(0)">Tanggal Dibuat</a></th>
                                                    <th class="text-center ts6"><a href="javascript:void(0)">Diverifikasi Oleh</a></th>
                                                    <th class="text-center ts7"><a href="javascript:void(0)">Status</a></th>
                                                    
                                                    <th class="text-center ts8"><a href="javascript:void(0)">Aksi</a></th>
                                                </tr>
                                                <tr class="sear">
                                                    <th></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
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
                                <div role="tabpanel" class="tab-pane" id="Approved">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="table_enofa2" class="table table-striped nowrap" width="100%">
                                        <thead>
                                                <tr>
                                                    <th class="text-center te0"><a href="javascript:void(0)">No.</th>
                                                    <th class="text-center te1"><a href="javascript:void(0)">Tangal Mulai Aktif</a></th>
                                                    <th class="text-center te2"><a href="javascript:void(0)">Tangal Expired</a></th>
                                                    <th class="text-center te3"><a href="javascript:void(0)">No. Awal</a></th>
                                                    <th class="text-center te4"><a href="javascript:void(0)">No. Akhir</a></th>
                                                    <th class="text-center te6"><a href="javascript:void(0)">Diverifikasi Oleh</a></th>                                                
                                                </tr>
                                                <tr class="sear2">
                                                    <th></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
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
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>