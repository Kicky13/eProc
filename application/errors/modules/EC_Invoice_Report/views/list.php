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
                                <a class="btn btn-primary" download="invoice_report.xls" href="#" onclick="return ExcellentExport.excel(this, 'table_inv', 'Invoice Report');">Export to Excel</a>
                                    <table id="table_inv" class="table table-striped nowrap" width="100%">
                                        <thead>
                                                <tr>
                                                    <th class="text-center ts0"><a href="javascript:void(0)">No.</th>
                                                    <th class="text-center ts1"><a href="javascript:void(0)">Invoice Date</a></th>
                                                    <th class="text-center ts2"><a href="javascript:void(0)">No. Invoice</a></th>
                                                    <th class="text-center ts3"><a href="javascript:void(0)">No. Mir</a></th>
                                                    <th class="text-center ts4"><a href="javascript:void(0)">No. Document</a></th>
                                                    <th class="text-center ts5"><a href="javascript:void(0)">Tahun</a></th>
                                                    <th class="text-center ts6"><a href="javascript:void(0)">Vendor</a></th>
                                                    <th class="text-center ts7"><a href="javascript:void(0)">No. PO</a></th>
                                                    <th class="text-center ts8"><a href="javascript:void(0)">Total Amount</a></th>
                                                    <th class="text-center ts9"><a href="javascript:void(0)">Status</a></th>
                                                    <th class="text-center ts10"><a href="javascript:void(0)">Posisi Dokumen</a></th>
                                                    <th class="text-center ts11"><a href="javascript:void(0)">Status Dokumen</a></th>
                                                    <th class="text-center"><a href="javascript:void(0)">Aksi</a></th>
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


<div class="modal fade" id="modalTracking">
    <div class="modal-dialog modal-md" style="width:75%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Tracking Invoice</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <table id="tableTrack" class="table table-striped nowrap" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Status</th>
                                <!--    <th class="text-center">Keterangan</th>  -->                                    
                                    <th class="text-center">Posisi</th>
                                    <th class="text-center">Status Dokumen</th>
                                    <th class="text-center">User</th>
                                </tr>
                            </thead>
                            <tbody id="bodyTableTrack">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
