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
                    <div id="Invoiced">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="table_inv" class="table table-striped nowrap" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center ts0"><a href="javascript:void(0)">No.</th>
                                                <th class="text-center ts1"><a href="javascript:void(0)">No. Ekspedisi</a></th>
                                                <th class="text-center ts2"><a href="javascript:void(0)">Tanggal Kirim</a></th>
                                                <th class="text-center ts3"><a href="javascript:void(0)">No. Invoice</a></th>
                                                <th class="text-center ts4"><a href="javascript:void(0)">No. PO</a></th>
                                                <th class="text-center ts5"><a href="javascript:void(0)">Tipe PO</a></th>
                                                <th class="text-center ts6"><a href="javascript:void(0)">Vendor</a></th>
                                                <th class="text-center ts7"><a href="javascript:void(0)">Status</a></th>
                                                <th class="text-center ts8"><a href="javascript:void(0)"></a></th>
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
                        </div>
                    </div>
                </div>
                <br><br>
            </div>
        </div >
    </div >
</section>