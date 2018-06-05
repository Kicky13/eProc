<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <!-- <div class="row">
            <div class="col-lg-12">
            <h5>Shopping Chart</h5>
            </div>
            </div> -->
            <div class="row">
                <div class="col-lg-3">
                    <h5>Shopping Cart</h5>
                </div>
                <div class="col-lg-9 pull-right">
                    <?php echo form_open_multipart('EC_Ecatalog/compares/',
                        array('method' => 'POST', 'class' => 'form-horizontal pull-right')); ?>
                    <input type="hidden" id="arr" name="arr[]"/>
                    <input type="hidden" id="avl" value=""/>
                    <input type="hidden" id="sisa" value=""/>
                    <a href="<?php echo base_url(); ?>EC_Ecatalog/listCatalogLsgs" type="button" style="box-shadow: 1px 1px 1px #ccc"
                       class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Kembali</a>
                    <a href="<?php echo base_url(); ?>EC_Ecatalog/history_pl" target="_blank" type="button" style="box-shadow: 1px 1px 1px #ccc"
                       class="btn btn-default"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> History PO</a>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modalbudget" style="box-shadow: 1px 1px 1px #ccc"
                       type="button" class="btn btn-default"><span class="" aria-hidden="true"><strong>Cost Center</strong></span>&nbsp;<!--<span class="budget">Loading...</span>--></a>
                    <button type="submit" style="display: none" id="compare" style="box-shadow: 1px 1px 1px #ccc" class="btn btn-default">
                        Histori
                    </button>
                    <!-- <a href="<?php echo base_url(); ?>EC_Ecatalog/checkout" type="button" class="btn btn-default" onclick="openChart()"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Chart &nbsp;&nbsp;&nbsp;<span class="badge jml"></span></a> -->
                    <a href="<?php echo base_url(); ?>EC_Ecatalog/perbandingan_pl" style="box-shadow: 1px 1px 1px #ccc" type="button"
                       id="compare" class="btn btn-default"> Compare &nbsp;<span class="badge jmlCompare"></span> </a>
                    </form>

                </div>
            </div>
            <div class="row" style="padding-top: 5px">
                <div class="col-lg-9 col-md-9">
                    <div class="row" style="border-top: 1px solid #ccc;"></div>
                    <br>
                    <div id="goods"></div>
                </div>
                <div class="col-lg-3 col-md-3 pull-right"
                     style="border-left: 1px solid #ccc;border-top: 1px solid #ccc;border-bottom: 1px solid #ccc;">
                    <?php echo form_open_multipart('EC_Ecatalog/confirm/', array('method' => 'POST', 'class' => 'form-horizontal')); ?>
                    <input type="hidden" id="hid_current_budget"/>
                    <input type="hidden" id="hid_estimated_budget"/>
                    <div class="form-group">
<!--                        <label for="budgett" class="col-sm-4 control-label text-left">Budget</label>-->
<!--                        <label id="budgett" class="col-sm-8 control-label pull-right">0</label>-->
                        <label for="totall" class="col-sm-4 control-label text-left">Total Cost</label>
                        <label id="totall" class="col-sm-8 control-label pull-right">0</label>
                        <!-- <label for="totalsisa" class="col-sm-4 control-label text-left">Sisa </label>
                       <label id="totalsisa" class="col-sm-8 control-label pull-right">0</label> -->
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="button" id="btn_confirm" data-toggle="modal" data-target="#cnfrm" onclick=""
                                    class="btn btn-danger disabled">
                                Konfirmasi Beli
                            </button>
                        </div>

                        <div class="col-sm-12 text-center">
                            <label id="pocreated" class="col-sm-12 control-label text-center"></label>
                        </div>

                    </div>
                    </form>
                    <!-- <button type="submit" id="compare" style="width: auto;" class="btn btn-danger">
                    Konfirmasi Beli
                    </button> -->
                    </center>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="cnfrmOLD" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h6 class="modal-title" id="myModalLabel">Tiap nomer PO terbit berdasarkan barang dengan nomer kontrak sama</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-4">
                        <h6>PO yang akan terbit</h6>
                    </div>
                    <div class="col-xs-8">
                        : <a id="jmlPO">5</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <h6>Jumlah barang</h6>
                    </div>
                    <div class="col-xs-8">
                        : <a id="jmlBrg">7</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <h6>Total biaya</h6>
                    </div>
                    <div class="col-xs-8">
                        : <a id="totalBiaya">5.000.000</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-primary" id="btnCofirmmm" onclick="confirm(this,1)">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url() . "static/css/pages/EC_miniTable.css" ?>"/>
<div class="modal fade" id="modalbudget">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>INFORMASI DETAIL BUDGET</u></strong></h4>
            </div>
            <div class="modal-body">
<!--                <table class="table table-hover table-striped">-->
<!--                    <thead>-->
<!--                    <tr>-->
<!--                        <th>CostCenter</th>-->
<!--                        <th>Description</th>-->
<!--                        <th>GLAccount</th>-->
<!--                        <th>GLDescription</th>-->
<!--                        <th>Current</th>-->
<!--                        <th>Commit</th>-->
<!--                        <th>Actual</th>-->
<!--                        <th>Available</th>-->
<!--                        <th>Cart</th>-->
<!--                    </tr>-->
<!--                    </thead>-->
<!--                    <tbody id="tbody"></tbody>-->
<!--                </table>-->
                <form class="form-inline" action="<?php echo base_url(); ?>EC_Ecatalog/simpanCC" method="post">
                    <input type="hidden" name="menu" value="checkout_lgsg">
                    <input type="hidden" id="budgetcc" value="<?php echo $ccc["COSTCENTER"]; ?>">
                    <div class="form-group">
                        <label for="exampleInputName2">COST CENTER :&nbsp;&nbsp;</label><?php echo $ccc["COSTCENTER"]; ?>&nbsp;-&nbsp;<?php echo $ccc["CC_NAME"]; ?>

                        <!-- <select name="cc" id="group_jasa_id" required="" class="form-control CC">
                            <?php //$ccp = ($ccc["COSTCENTER"] == null || $ccc["COSTCENTER"] == "") ? "" : $ccc["COSTCENTER"];
                            //if ($ccp == "") ?>
                                <option value="" selected="">Pilih Cost Center</option>
                            <?php //foreach ($CC as $key => $value) { ?>
                                <option value="<?php //echo $value["COSTCENTER"]; ?>:<?php //echo $value["NAME"]; ?>" <?php //echo ($value["COSTCENTER"] == $ccp) ? 'selected' : ''; ?>><?php //echo $value["COSTCENTER"]; ?> &mdash; <?php //echo $value["NAME"]; ?></option>
                            <?php //} ?>
                        </select> -->
                    </div>
                    <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
                </form>
                <hr/>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-hover table-striped" id="tableCCBG" style="font-size: 11px;" width="100%">
                            <thead>
                            <tr>
                                <th class="text-center">Year</th>
                                <th class="text-center">CostCenter</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">CommItm</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Commit</th>
                                <th class="text-center">Actual</th>
                                <th class="text-center">Current</th>
                                <th class="text-center">Available</th>
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

<div class="modal fade" id="modaldetail">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>INFORMASI PRODUK
                            <!-- <?php //echo $baseLanguage ['principal_manufacturer_addTtl'] ; ?> --></u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row" style="background-color: #e3e9f2">
                    <div class="col-lg-3">
                        Nomor Material
                    </div>
                    <div class="col-lg-9" id="detail_MATNR"></div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        Short Text
                    </div>
                    <div class="col-lg-9" id="detail_MAKTX"></div>
                </div>
                <div class="row" style="background-color: #e3e9f2">
                    <div class="col-lg-3">
                        Long Text
                    </div>
                    <div class="col-lg-9" id="detail_LNGTX"></div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        UoM
                    </div>
                    <div class="col-lg-9" id="detail_MEINS"></div>
                </div>
                <!-- <div class="row" style="background-color: #e3e9f2">
                    <div class="col-lg-3">
                        Group
                    </div>
                    <div class="col-lg-9" id="detail_MATKL"></div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        Tipe
                    </div>
                    <div class="col-lg-9" id="detail_MTART"></div>
                </div>
                <div class="row" style="background-color: #e3e9f2">
                    <div class="col-lg-3">
                        Dibuat
                    </div>
                    <div class="col-lg-9" id="detail_created"></div>
                </div> -->
                <div class="row">
                    <div class="form-group">
                        <label for="picure" class="col-sm-2 control-label">Picure</label>
                        <div class="col-sm-offset-3 col-sm-9">
                            <img id="pic" class="thumbnail zoom"
                                 onerror="this.onerror=null;this.src='<?php echo base_url(UPLOAD_PATH) . '/material_strategis/default_post_img.png'; ?>'"
                                 src="<?php echo base_url(UPLOAD_PATH) . '/EC_material_strategis/default_post_img.png'; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="drawing" class="col-sm-2 control-label">Drawing</label>
                        <div class="col-sm-offset-3 col-sm-9">
                            <img id="draw" class="thumbnail zoom"
                                 onerror="this.onerror=null;this.src='<?php echo base_url(UPLOAD_PATH) . '/material_strategis/default_post_img.png'; ?>'"
                                 src="<?php echo base_url(UPLOAD_PATH) . '/EC_material_strategis/default_post_img.png'; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPO">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>INFORMASI PO</u></strong></h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-striped">
                    <thead>
                    <!-- <tr>
                        <th>PO</th>
                        <th>Matrial</th>
                        <th>Harga</th>
                    </tr> -->
                    </thead>
                    <tbody id="tbodyPO">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <small>Halaman akan otomatis refresh dalam <span id="dtk">15</span> detik....</small>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPO-OLD">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>INFORMASI PO</u></strong></h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th>PO</th>
                        <th>Matrial</th>
                        <th>Harga</th>
                    </tr>
                    </thead>
                    <tbody id="tbodyPOs"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cnfrm">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>INFORMASI ORDER</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-hover table-striped" id="tableMat" style="font-size: 11px;">
                            <thead>
                            <tr>
                                <th class="text-center">Matno</th>
                                <th class="text-center">Plant</th>
                                <th class="text-center">Teks</th>
                                <th class="text-center">Assign Budget</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Sub Total</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyMat">
                            </tbody>
                        </table>
                    </div>
                </div>
                <br/>
                <form class="form-inline" method="post">
                    <input type="hidden" name="menu" value="listCatalogLsgs">
                    <div class="form-group">
                        <label for="exampleInputName2">Pilih Cost Center:&nbsp;&nbsp;&nbsp;</label>
                        <select name="cc" id="CCopt" required="" class="form-control select2">
                            <?php $ccp = ($ccc["COSTCENTER"] == null || $ccc["COSTCENTER"] == "") ? "" : $ccc["COSTCENTER"];
                            if ($ccp == "") ?>
                                <!-- <option value="" selected="">Pilih Cost Center</option> -->
                            <?php foreach ($CC as $key => $value) { ?>
                                <option value="<?php echo $value["COSTCENTER"]; ?>:<?php echo $value["NAME"]; ?>" <?php echo ($value["COSTCENTER"] == $ccp) ? 'selected' : ''; ?>><?php echo $value["COSTCENTER"]; ?> &mdash; <?php echo $value["NAME"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </form>
                <div class="row" style="margin-top: 10px; display: none;">
                    <div class="col-sm-1 col-md-1 col-lg-1">
                        Company:
                    </div>
                    <div class="col-md-4" style="margin-left: 55px;">
                        <select class="form-control" id="selComp">
                            <option value='' selected disabled>Select Company</option>
                            <?php
                                // var_dump($company);
                                foreach ($company as $value) { ?>
                                    <option value='<?php echo $value['COMPANYID']?>' <?php //if(substr($value['COMPANYID'],0,1)==substr($dataHarga[0]['PLANTT'],0,1)){ echo 'selected';} ?>><?php echo $value['COMPANYNAME']?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-hover table-striped" id="tableCC" style="font-size: 11px;" width="100%">
                            <thead>
                            <tr>
                                <th class="text-center">Year</th>
                                <th class="text-center">CostCenter</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">CommItm</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Commit</th>
                                <th class="text-center">Actual</th>
                                <th class="text-center">Current</th>
                                <th class="text-center">Available</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="buyOne" class="btn btn-success" data-dismiss="modal" onclick="confirm(this,1)">Buy</button>
            </div>
        </div>
    </div>
</div>