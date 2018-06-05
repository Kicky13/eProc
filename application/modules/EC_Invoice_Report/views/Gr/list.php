<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <?php
            $pesannya = $this->session->flashdata('message');
            if (!empty($pesannya)) {
                echo '<div class="alert alert-info">' . $pesannya . '</div>';
            }
            ?>
            <div class="row">
                <div class="row">
                    <div id="">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="datatable_ajax" class="table table-striped nowrap text-center" width="100%" data-urlsource="<?php echo site_url('EC_Invoice_Report/Gr/datatable') ?>" data-urlform="<?php echo site_url('EC_Invoice_Report/Gr/cetak') ?>">
                                      <thead>
                                              <tr>
                                                  <th class="text-center ts"><a href="javascript:void(0)">NO</a></th>
                                                  <th class="text-center ts"><a href="javascript:void(0)">PO NO</a></th>
                                                  <th class="text-center ts"><a href="javascript:void(0)">PO ITEM NO</a></th>
                                                  <th class="text-center ts"><a href="javascript:void(0)">NO RR</a></th>
                                                  <th class="text-center ts"><a href="javascript:void(0)">GR YEAR</a></th>
                                                  <th class="text-center ts"><a href="javascript:void(0)">MATERIAL</a></th>
                                                  <th class="text-center ts"><a href="javascript:void(0)">VENDOR</a></th>
                                                  <th class="text-center ts"><a href="javascript:void(0)">STATUS</a></th>
                                                  <th class="text-center ts"><a href="javascript:void(0)">ACTION</a></th>
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
        </div >
    </div >
</section>
