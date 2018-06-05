<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>

            <div class="row">
            	<div class="col-md-12">
                <div class="row">
                    <div class="row">
                        <div>
                          <?php
                          $pesannya = $this->session->flashdata('message');
                          if (!empty($pesannya)) {
                              echo '<div class="alert alert-info">' . $pesannya . '</div>';
                          }
                          ?>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                  <ul class="nav nav-tabs" role="tablist">
                                      <li role="presentation" class="active"><a class="tab1" href="#request" aria-controls="Request" role="tab" data-toggle="tab">Request</a></li>
                                      <li role="presentation"><a class="tab2" href="#approved" aria-controls="Approved" role="tab" data-toggle="tab">Approved</a></li>
                                  </ul>
                                  <div class="tab-content">
                                      <div role="tabpanel" class="tab-pane active" id="request">
                                          <div class="row" style="border-bottom: 1px solid #ccc;">
                                                  <br>
                                                  <a href="<?php echo base_url('EC_Vendor/Bapp/form') ?>" class="btn btn-info pull-right" style="margin: 0 15px 10px 0;" onclick="createBapp(this)">Create BAPP</a>
                                                  <br>
                                          </div>
                                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="overflow : auto">
                                              <table class="table table-striped table_bapp nowrap" width="100%">
                                                  <thead>
                                                          <tr>
                                                              <th class="text-center ts"><a href="javascript:void(0)">No.</th>
                                                              <th class="text-center ts"><a href="javascript:void(0)">No. PO</a></th>
                                                              <th class="text-center ts"><a href="javascript:void(0)">No. BAPP</a></th>
                                                              <th class="text-center ts"><a href="javascript:void(0)">Tanggal Dibuat</a></th>
                                                              <th class="text-center ts"><a href="javascript:void(0)">Description</a></th>
                                                              <th class="text-center ts"><a href="javascript:void(0)">Status</a></th>
                                                              <th class="text-center ts"><a href="javascript:void(0)">Aksi</a></th>
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
                                      <div role="tabpanel" class="tab-pane" id="approved">

                                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="overflow : auto">
                                              <table  class="table table-striped nowrap table_bapp" width="100%">
                                                  <thead>
                                                          <tr>
                                                              <th class="text-center ts"><a href="javascript:void(0)">No.</th>
                                                              <th class="text-center ts"><a href="javascript:void(0)">No. PO</a></th>
                                                              <th class="text-center ts"><a href="javascript:void(0)">No. BAPP</a></th>
                                                              <th class="text-center ts"><a href="javascript:void(0)">Tanggal Dibuat</a></th>
                                                              <th class="text-center ts"><a href="javascript:void(0)">Description</a></th>
                                                              <th class="text-center ts"><a href="javascript:void(0)">Status</a></th>
                                                              <th class="text-center ts"><a href="javascript:void(0)">Aksi</a></th>
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
                            </div>
                        </div>
                    </div>

                </div>
            	</div>
            </div>
        </div>
    </div>
</section>
