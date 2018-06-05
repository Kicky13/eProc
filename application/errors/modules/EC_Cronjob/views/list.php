<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>


            <div class="row">
                <div class="row">
                    <div id="Invoiced">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="row" style="border-bottom: 1px solid #ccc;">
                                        <br>
                                        <a data-hariini="<?php echo date('Ymd') ?>" data-href="<?php echo base_url('EC_Cronjob/Pomut/setDataPomut') ?>" onclick="manualRefreshPomut(this); return false" class="btn btn-info pull-right" style="margin: 0 15px 10px 0;">Refresh Potongan Mutu</a>
                                        <a data-hariini="<?php echo date('Ymd') ?>" data-href="<?php echo base_url('EC_Cronjob/setDataLanded') ?>" onclick="manualRefreshLandedCost(this); return false" class="btn btn-info pull-right" style="margin: 0 15px 10px 0;">Set Landed Cost</a>
                                        <a data-hariini="<?php echo date('Ymd') ?>" data-href="<?php echo base_url('EC_Cronjob/refreshGR') ?>" onclick="manualRefreshGR(this); return false" class="btn btn-info pull-right" style="margin: 0 15px 10px 0;">Refresh GR</a>
                                        <a href="<?php echo base_url('EC_Cronjob/setStatusDokumenEkspedisiBendahara') ?>" class="btn btn-warning pull-right" style="margin: 0 15px 10px 0;">Set Ekspedisi Terima Bendahara</a>
                                        <a href="<?php echo base_url('EC_Cronjob/setStatusDokumenBendaharaPaid') ?>" class="btn btn-warning pull-right" style="margin: 0 15px 10px 0;">Set Ekspedisi Bayar</a>
                                        <br>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="table_log" class="table table-striped nowrap" width="100%">
                                        <thead>
                                                <tr>
                                                    <th class="text-center ts"><a href="javascript:void(0)">No. </th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">Date</th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">Tanggal Transaksi</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">Aksi</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">Dilakukan Oleh</a></th>
                                                </tr>
                                                <tr class="sear">
                                                    <th></th>
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
                <br><br>
            </div>
        </div >
    </div >
</section>
