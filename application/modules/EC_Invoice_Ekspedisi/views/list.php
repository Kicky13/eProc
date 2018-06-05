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

                        <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation"><a class="tab1" href="#Request" aria-controls="Request" role="tab" data-toggle="tab">Request Approval</a></li>
                            <li role="presentation"><a class="tab1" href="#Rejected" aria-controls="Rejected" role="tab" data-toggle="tab">Rejected <span class="label label-danger" style="border-radius: 1em;"><?php echo $reject?></span></a></li>
                            <li role="presentation" class="active"><a class="tab2" href="#Ready" aria-controls="Ready" role="tab" data-toggle="tab">Ready</a></li>
                        </ul>
                        <div class="tab-content">

                        <div role="tabpanel" class="tab-pane active" id="Ready">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="row" style="border-bottom: 1px solid #ccc;">
                                        <br>
                                        <button type="button" onclick="createEkspedisi(this)" id="create" class="btn btn-info pull-right" style="margin-right: 20px;">Ekspedisikan Berkas</button>
                                        <button type="button" data-toggle="modal" data-target="#cetakLembar" id="create" class="btn btn-info pull-right btn-warning" style="margin-right: 20px;">Cetak Ulang Lembar Verifikasi</button>
                                        <br>
                                        <br>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="table_inv" class="table table-striped nowrap" width="100%">
                                        <thead>
                                                <tr>
                                                    <th class="text-center ts"><a href="javascript:void(0)">No.</th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">Invoice Date</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">No. Invoice</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">No. Document</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">Company</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">Tahun</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">Vendor</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">No. PO</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">Tipe PO</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">Total Amount</a></th>
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


                        <div role="tabpanel" class="tab-pane" id="Request">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="table_Request" class="table table-striped nowrap" width="100%">
                                        <thead>
                                                <tr>
                                                    <th class="text-center ts1"><a href="javascript:void(0)">No.</th>
                                                    <th class="text-center ts1"><a href="javascript:void(0)">Invoice Date</a></th>
                                                    <th class="text-center ts1"><a href="javascript:void(0)">No. Invoice</a></th>
                                                    <th class="text-center ts1"><a href="javascript:void(0)">No. Document</a></th>
                                                    <th class="text-center ts1"><a href="javascript:void(0)">Company</a></th>
                                                    <th class="text-center ts1"><a href="javascript:void(0)">Tahun</a></th>
                                                    <th class="text-center ts1"><a href="javascript:void(0)">Vendor</a></th>
                                                    <th class="text-center ts1"><a href="javascript:void(0)">No. PO</a></th>
                                                    <th class="text-center ts1"><a href="javascript:void(0)">Tipe PO</a></th>
                                                    <th class="text-center ts1"><a href="javascript:void(0)">Total Amount</a></th>
                                                    <th class="text-center ts1"><a href="javascript:void(0)">Status Approval</a></th>
                                                    <th class="text-center ts1"><a href="javascript:void(0)">Aksi</a></th>
                                                </tr>
                                                <tr class="sear1">
                                                    <th></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch1" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch1" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch1" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch1" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch1" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch1" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch1" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch1" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch1" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch1" style="margin: 0px"></th>
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


                        <div role="tabpanel" class="tab-pane" id="Rejected">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="table_Rejected" class="table table-striped nowrap" width="100%">
                                        <thead>
                                                <tr>
                                                    <th class="text-center ts2"><a href="javascript:void(0)">No.</th>
                                                    <th class="text-center ts2"><a href="javascript:void(0)">Invoice Date</a></th>
                                                    <th class="text-center ts2"><a href="javascript:void(0)">No. Invoice</a></th>
                                                    <th class="text-center ts2"><a href="javascript:void(0)">No. Document</a></th>
                                                    <th class="text-center ts2"><a href="javascript:void(0)">Company</a></th>
                                                    <th class="text-center ts2"><a href="javascript:void(0)">Tahun</a></th>
                                                    <th class="text-center ts2"><a href="javascript:void(0)">Vendor</a></th>
                                                    <th class="text-center ts2"><a href="javascript:void(0)">No. PO</a></th>
                                                    <th class="text-center ts2"><a href="javascript:void(0)">Tipe PO</a></th>
                                                    <th class="text-center ts2"><a href="javascript:void(0)">Total Amount</a></th>
                                                    <th class="text-center ts2"><a href="javascript:void(0)">Status Approval</a></th>
                                                    <th class="text-center ts2"><a href="javascript:void(0)">Aksi</a></th>
                                                </tr>
                                                <tr class="sear2">
                                                    <th></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch2" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch2" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch2" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch2" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch2" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch2" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch2" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch2" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch2" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch2" style="margin: 0px"></th>
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
                                    <th class="text-center">Status Dokumen</th>
                                    <th class="text-center">Posisi</th>
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


<div class="modal fade" id="cetakLembar">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Cetak Ulang Lembar Verifikasi</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <strong>PERHATIAN!</strong> Fitur Cetak Ulang Hanya Dapat Digunakan untuk Invoice yang Mendapatkan Approval Pejabat Terkait Melalui Sistem E-Invoice
                </div>
                <?php echo form_open_multipart('', array('method' => 'POST', 'class' => 'form-horizontal formCetak'));?>
                    <div class="form-group">
                        <label for="Invoice Date" class="col-sm-4 control-label">No. Dokumen</label>
                        <div class="col-sm-8 tgll">
                            <div class="input-group date startDate">
                                <input required id="noDoc" value="" class="form-control start-date" name="noDoc" type="number">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Invoice Date" class="col-sm-4 control-label">Tahun Dokumen</label>
                        <div class="col-sm-8 tgll">
                            <div class="input-group date startDate">
                                <input required id="tahunDoc" value="<?php echo date('Y');?>" class="form-control start-date" name="tahunDoc" type="number">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 tgll text-center">
                            <button type="submit" class="btn btn-success">Cetak</button>
                            <button data-dismis='modal' class="btn btn-danger">Batal</button>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
