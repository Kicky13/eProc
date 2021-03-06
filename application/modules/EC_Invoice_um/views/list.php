<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="hide" id="sudahTampilPesan"><?php echo $sudahTampil ?></div>
                <?php
                $pesannya = $this->session->flashdata('message');
                if (!empty($pesannya)) {
                    echo '<div class="alert alert-info">' . $pesannya . '</div>';
                }
                ?>


                <?php if($this->session->flashdata('success')) { ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php } ?>
                <div class="panel-group" id="accordionperbarui" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" id="headingOne" role="button" data-toggle="collapse" data-parent="#accordionperbarui" href="#collapsePerbarui" aria-expanded="true" aria-controls="collapseOne">
                            <h4 class="panel-title">Refresh</h4>
                        </div>
                        <div id="collapsePerbarui" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <form id="etor-form" enctype="multipart/form-data" method="post" action="<?php echo base_url()?>EC_Invoice_um/refreshPO">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <select id="berdasarkan" class="input-sm">
                                                <option value="pr">Nomor PO</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input name="no_po" type="text" class="input-sm" placeholder="Filter" maxlength="10" required>
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-default" id="renewPR">Refresh</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a class="tab1" href="#Unbilled" aria-controls="Unbilled" role="tab" data-toggle="tab">DP Request</a></li>
                        <li role="presentation"><a class="tab2" href="#Invoiced" aria-controls="Invoiced" role="tab" data-toggle="tab">OutStand DP</a></li>
                        <li role="presentation"><a class="tab2" href="#createDocument" aria-controls="Invoiced" role="tab" data-toggle="tab">PJK</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="Unbilled">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">
                                <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="row" style="border-bottom: 1px solid #ccc;">
                                        <br>
                                        <button type="button" onclick="createInvoice(this)" id="create" class="btn btn-info pull-right" style="margin-right: 20px;">Create DP Request</button>
                                        <br>
                                        <br>

                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <table id="tableMT" class="table table-striped nowrap" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center ts0"><a href="javascript:void(0)">no po</a></th>
                                                        <th class="text-center ts1"><a href="javascript:void(0)">po date</a></th>
                                                        <th class="text-center ts2"><a href="javascript:void(0)">material number</a></th>
                                                        <th class="text-center ts3"><a href="javascript:void(0)">deskripsi material</a></th>
                                                        <th class="text-center ts4"><a href="javascript:void(0)">net price</a></th>
                                                        <th class="text-center ts5"><a href="javascript:void(0)">currency</a></th>
                                                        <th class="text-center ts6"><a href="javascript:void(0)">Aksi</a></th>                                                        
                                                    </tr>
                                                    <tr class="sear">
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

                        <div role="tabpanel" class="tab-pane" id="Invoiced">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">
                                <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <table id="table_inv" class="table table-striped nowrap" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center ts1"><a href="javascript:void(0)">Invoice Date</a></th>
                                                    <th class="text-center ts2"><a href="javascript:void(0)">No. Uang muka</a></th>
                                                    <th class="text-center ts3"><a href="javascript:void(0)">No. PO</a></th>
                                                    <th class="text-center ts4"><a href="javascript:void(0)">No. PPL</a></th>
                                                    <th class="text-center ts5"><a href="javascript:void(0)">Base Amount</a></th>
                                                    <th class="text-center ts6"><a href="javascript:void(0)">Nilai Uang Muka</a></th>
                                                    <th class="text-center ts7"><a href="javascript:void(0)">Last Edit</a></th>
                                                    <th class="text-center ts8"><a href="javascript:void(0)">Status</a></th>
                                                    <th class="text-center ts9"><a href="javascript:void(0)">Posisi Dokumen</a></th>
                                                    <th class="text-center ts10"><a href="javascript:void(0)">Status Dokumen</a></th>
                                                    <th class="text-center ts11"><a href="javascript:void(0)">Aksi</a></th>
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
                        <div role="tabpanel" class="tab-pane" id="createDocument">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">
                                <div class="panel-group skrol" role="tablist" aria-multiselectable="true">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px">
                                        <a href="<?php echo site_url('EC_Vendor/List_Enofa')?>" class="btn btn-primary">E-Nofa</a>
                                        <a href="<?php echo site_url('EC_Vendor/Bapp')?>" class="btn btn-primary">BAPP</a>
                                        <a href="<?php echo site_url('EC_Vendor/Bast')?>" class="btn btn-primary">BAST</a>
                                        <a href="<?php echo site_url('EC_Vendor/Pomut')?>" class="btn btn-primary">BA ANALISA MUTU</a>
                                        <a href="<?php echo site_url('EC_Vendor/Gr')?>" class="btn btn-primary">GR DOC</a>
                                        <a href="<?php echo site_url('EC_Vendor/Faktur')?>" class="btn btn-primary">EKSPEDISI FAKTUR PAJAK</a>
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

<div class="modal fade" id="divCreateInvoice">
    <div class="row">
        <div class="col-sm-12 col-lg-12 col-lg-12">
            <?php echo form_open_multipart('EC_Invoice_um/createInvoice/', array('method' => 'POST', 'class' => 'form-horizontal formCreate')); ?>
            <div class="form-group">
                <label for="Invoice Date" class="col-sm-3 control-label">Tanggal Invoice *</label>
                <div class="col-sm-4 tgll">
                    <div class="input-group date startDate">
                        <input readonly="" id="startdate" required=""  class="form-control start-date" name="invoice_date"  type="text" value="<?php echo date('d-m-Y') ?>">
                        <span class="input-group-addon">
                            <a href="javascript:void(0)">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="Invoice No" class="col-sm-3 control-label">Bank Transfer*</label>
                <div class="col-sm-4">
                    <select name="partner_bank" required class="col-md-12">
                        <?php foreach($listBank as $lb){
                            echo '<option value="'.$lb['PARTNER_TYPE'].'">'.$lb['ACCOUNT_NO'].' - '.$lb['BANK_NAME'].' - '.$lb['ACCOUNT_HOLDER'].'</option>';
                        } ?>
                    </select>
                </div>
                <div class="col-sm-3">

                </div>
            </div>
            <div class="form-group">
                <label for="faktur" class="col-sm-3 control-label">Jenis Pajak</label>
                <div class="col-sm-4">
                    <select required="" class="form-control" name="pajak" id="pajak" onchange="setRequiredPajak(this,'VZ')">
                        <option value="">Pilih Jenis Pajak</option>
                        <?php
                        $nilaiPajakLama = 0;
//                                        var_dump($pajak);
                        for ($i = 0; $i < sizeof($pajak); $i++) { ?>
                            <option value="<?php echo $pajak[$i]['ID_JENIS'] ?>" data-pajak="<?php echo $pajak[$i]['PAJAK'] ?>">
                                <?php
                                if($pajak[$i]['ID_JENIS'] == "VN"){
                                    echo "PPN";
                                }else{ echo "Tanpa PPN";} }?>

                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="Invoice Date" class="col-sm-3 control-label">Tanggal Faktur Pajak </label>
                    <div class="col-sm-4 tgll">
                        <div class="input-group date startDate">
                            <input readonly="" id="FakturDate"  class="form-control start-date" name="FakturDate" required="" type="text">
                            <span class="input-group-addon">
                                <a href="javascript:void(0)">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="faktur" class="col-sm-3 control-label">No. Faktur Pajak </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control format-pajak" id="faktur" data-mask="999.999-99.99999999"  name="faktur_no" >
                    </div>
                    <div class="col-sm-3">
                        <input type="file" id="file_faktur" name="fileFaktur" />
                    </div>
                </div>


                <div class="form-group">
                    <label for="Invoice No" class="col-sm-3 control-label">No. SP/PO *</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" readonly="" id="sppo_no" name="sppo_no" >
                    </div>
                    <div class="col-sm-3">
                        <input type="file" required name="filePO" />
                    </div>

                </div>

                <div class="form-group">
                    <label for="bapp no" class="col-sm-3 control-label">No. Kwitansi</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" maxlength="50" onchange="setRequired(this,'fileKwitansi')" id="kwitansi_no" name="kwitansi_no" >
                    </div>
                    <div class="col-sm-3">
                        <input type="file" name="fileKwitansi" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="bapp no" class="col-sm-3 control-label">No LPB</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="K3" maxlength="20" name="K3" onchange="setRequired(this,'fileK3')" >
                    </div>
                    <div class="col-sm-3">
                        <input type="file" name="fileK3" />
                    </div>
                </div>


                <div class="form-group">
                    <label for="faktur" class="col-sm-3 control-label">Base Amount</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="Amount" required="" id="totalview" readonly="">
                        <input type="hidden" id="base_amount" name="base_amount" />
                    </div>
                    <div class="col-sm-3">
                        <!-- <input type="file" required name="fileAmount" /> -->
                    </div>
                </div>
                <div class="form-group hide">
                    <label for="faktur" class="col-sm-3 control-label">Total Amount</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="totalAmount" required="" id="totalAmount" readonly="">
                        <input type="hidden" id="total" name="total" />
                    </div>
                    <div class="col-sm-3">
                        <!-- <input type="file" required name="fileAmount" /> -->
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="note" class="col-sm-3 control-label">DP Req Amount</label>
                    <div class="col-sm-4">
                        <input name="dp_req_amount" id="dp_req_amount" class="form-control format-koma" />
                    </div>
                </div>

                <div class="col-sm-offset-3 col-sm-9">
                    <p class="help-block"><small>ukuran upload file maks 4MB, file: *.jpg / *.png / *.pdf</small></p>
                </div>

                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="hidden" id="arrGR" name="arrgr" />
                        <input type="hidden" id="curr" name="curr" />
                        <input type="hidden" id="itemCat" name="itemCat" />
                        <input type="hidden" id="jmlDenda" name="jmlDenda" />
                        <input type="hidden" id="jmlDoc" name="jmlDoc" />
                        <button class="btn btn-info pull-right" type="submit">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<div class="modal " id="modalInvoinceNo">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>INVOICE<!-- <?php //echo $baseLanguage ['principal_manufacturer_addTtl'] ;  ?> --></u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- <div class="form-group"> -->
                        <!-- <label for="picure" class="col-sm-2 control-label">Picure</label> -->
                        <div class="col-md-8 col-md-offset-2">
                            <br><br>
                            <img id="picInvoince" class="thumbnail zoom" onerror="this.onerror=null;this.src='<?php echo base_url(UPLOAD_PATH) . '/material_strategis/default_post_img.png'; ?>'"
                            src="<?php echo base_url(UPLOAD_PATH) . '/EC_material_strategis/default_post_img.png'; ?>">
                        </div>
                        <!-- </div> -->
                    </div>

                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalFaktur">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title text-center"><strong><u>Faktur Pajak<!-- <?php //echo $baseLanguage ['principal_manufacturer_addTtl'] ;  ?> --></u></strong></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <br><br>
                            <img id="picFaktur" class="thumbnail zoom" onerror="this.onerror=null;this.src='<?php echo base_url(UPLOAD_PATH) . '/material_strategis/default_post_img.png'; ?>'"
                            src="<?php echo base_url(UPLOAD_PATH) . '/EC_material_strategis/default_post_img.png'; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                                        <th class="text-center">Keterangan</th> 
                                        <th class="text-center">Posisi Dokumen</th>
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
