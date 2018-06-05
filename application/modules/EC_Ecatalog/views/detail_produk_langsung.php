<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="row">
                <div class="col-lg-4">
                    <h5 id="maktx"><?php echo $data_produk[0]['MAKTX'] ?></h5>
                </div>
                <div class="col-lg-8 pull-right">
                    <input type="hidden" id="plant" value="<?php echo $dataHarga[0]['PLANTT'] ?>"/>
                    <?php echo form_open_multipart('EC_Ecatalog/compares/',
                        array('method' => 'POST', 'class' => 'form-horizontal pull-right')); ?>
                    <input type="hidden" id="arr" name="arr[]"/>

                    <a href="<?php echo base_url(); ?>EC_Ecatalog/listCatalogLsgs" type="button" class="btn btn-default"><span
                                class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Kembali</a>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modalbudgetDetail" type="button" class="btn btn-default"><span
                                class="" aria-hidden="true"><strong>Cost Center</strong></span><!--<span class="budget">Loading...</span>--></a>
                    <button type="submit" style="display: none" class="btn btn-default">Histori</button>
                    <a href="<?php echo base_url(); ?>EC_Ecatalog/checkout_lgsg" type="button" class="btn btn-default"
                       onclick="openChart()"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Cart &nbsp;&nbsp;&nbsp;<span
                                class="badge jml"></span></a>
                    <!-- <button type="submit" id="compare" class="btn btn-default">Perbandingan</button>				        		 -->
                    <a href="<?php echo base_url(); ?>EC_Ecatalog/perbandingan_pl" type="button" id="compare" class="btn btn-default">
                        Compare &nbsp;<span class="badge jmlCompare"></span>
                    </a>
                    </form>
                </div>
            </div>
            <div class="row" style="padding-top: 5px">
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="javascript:void(0)"
                               onclick="chgPic(0,'<?php echo $data_produk[0]['PICTURE'] ?>')"><?php echo '<img src="' . base_url(UPLOAD_PATH) . '/EC_material_strategis/' . (($data_produk[0]['PICTURE'] == "") ? "default_post_img.png" : $data_produk[0]['PICTURE']) . '"  class="img-responsive">' ?></a>
                            <p></p>
                            <a href="javascript:void(0)"
                               onclick="chgPic(1,'<?php echo $data_produk[0]['DRAWING'] ?>')"><?php echo '<img src="' . base_url(UPLOAD_PATH) . '/EC_material_strategis/' . (($data_produk[0]['DRAWING'] == "") ? "default_post_img.png" : $data_produk[0]['DRAWING']) . '" class="img-responsive">' ?></a>
                        </div>
                        <div class="col-md-9">
                            <?php echo '<img id="picSRC" src="' . base_url(UPLOAD_PATH) . '/EC_material_strategis/' . (($data_produk[0]['PICTURE'] == "") ? "default_post_img.png" : $data_produk[0]['PICTURE']) . '" class="img-responsive">' ?>
                        </div>
                    </div>
                    <div class="row">
                        <p></p>
                        <center> <?php echo $dataHarga[0]['CURRENCY'] ?> <?php echo number_format($dataHarga[0]['PRICE'], 0, ",", ".") ?>
                            per <?php echo $data_produk[0]['MEINS'] ?>
                        </center>
                        <p></p>
                        <div class="row">
                            <div class="input-group col-md-8 col-md-offset-2">
                                <i class="input-group-addon tangan" data-avl="" onclick="minqtycart()"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></i>
                                <input type="number" class="form-control text-center qtyy" value="1">
                                <i class="input-group-addon tangan" data-avl="" onclick="plsqtycart()"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></i>
                                <span class="input-group-addon"><?php echo $data_produk[0]['MEINS'] ?></span>
                            </div>
                        </div>
                        <p></p>
                        <center>
                            <a href="javascript:addCart(this,'<?php echo $matno ?>','PL2017','<?php echo $dataHarga[0]['KODE_DETAIL_PENAWARAN'] ?>')"
                               onclick="" type="button" class="btn btn-default"><span class="glyphicon glyphicon-shopping-cart"
                                                                                      aria-hidden="true"></span>&nbsp;<span class="add">Add to Cart</span></a>
                            <!-- <button type="submit" onclick="buyOne(this,'000','PL2017','<?php echo $matno ?>','<?php echo $dataHarga[0]['KODE_DETAIL_PENAWARAN'] ?>')" id="buyyys" style="width: 80px;" class="btn btn-danger" disabled>Buy</button>-->
                            <button type="submit" id="buyyy" data-toggle="modal" data-target="#modalBeli" style="width: 80px;"
                                    class="btn btn-danger">Buy
                            </button>

                        </center>
                        <center>
                            <p></p>
                            <span id="statsPO"> </span>
                        </center>
                        <div class="row">
                            <div class="col-xs-11 col-xs-offset-1" style="border: 1px solid #ccc;">
                                <?php echo form_open_multipart('EC_Ecatalog/confirm/',
                                    array('method' => 'POST', 'class' => 'form-horizontal')); ?>
                                <input type="hidden" id="KODE_DETAIL_PENAWARAN"
                                       value="<?php echo $dataHarga[0]['KODE_DETAIL_PENAWARAN'] ?>"/>
                                <input type="hidden" id="MEINS" value="<?php echo $data_produk[0]['MEINS'] ?>"/>
                                <input type="hidden" id="MATNO" value="<?php echo $matno ?>"/>
                                <input type="hidden" id="hid_current_budget"/>
                                <input type="hidden" id="hid_current_budget"/>
                                <input type="hidden" id="hid_estimated_budget"/>
                                <input type="hidden" id="harga1" value="<?php echo $dataHarga[0]['PRICE'] ?>"/>
                                <input type="hidden" id="curre" value="<?php echo $dataHarga[0]['CURRENCY'] ?>"/>
                                <!--
								<input type="hidden" id="avl" value="<?php //echo $data_produk[0]['t_qty']?>"/> -->
                                <input type="hidden" id="sisa" value=""/>
                                <div class="form-group" style="">
                                    <label for="totall" class="col-sm-3 control-label text-left">Total</label>
                                    <label id="totall"
                                           class="col-sm-8 control-label pull-right"><!-- <span><?php //echo $dataHarga[0]['CURRENCY'] . " " ?></span> --><?php echo number_format($dataHarga[0]['PRICE'],
                                            0, ",", ".") ?></label>
                                    <label for="budgett" class="col-sm-3 control-label text-left">Available</label>
<!--                                    <label id="budgett" class="col-sm-8 control-label pull-right">0</label>-->
                                    <input type="hidden" id="budgettt" value="<?php echo (int)$AVAILBUDGET*100 ?>" />    
                                    <label id="" class="col-sm-8 control-label pull-right"><?php echo number_format(((int)$AVAILBUDGET*100), 0, ",", ".") ?></label>
                                    <label for="totalsisa" class="col-sm-3 control-label text-left">Sisa</label>
                                    <label id="totalsisa" class="col-sm-8 control-label pull-right">0</label>
                                    <label id="excd" class="col-sm-12 control-label text-center" style="color: #990000"></label>

                                </div>
                                </form>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1">
                </div>
                <div class="col-lg-8">
                    <div class="row">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 5px">
                            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Detail
                                    Produk</a></li>
                            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Syarat dan
                                    Kondisi</a></li>
                            <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Feedback</a>
                            </li>
                            <!-- <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li> -->
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="home">
                                <div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="accord-detailproduk">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion1" href="#detailproduk"
                                                   aria-expanded="true" aria-controls="detailproduk">
                                                    Product Description
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="detailproduk" class="panel-collapse collapse in" role="tabpanel"
                                             aria-labelledby="accord-detailproduk">
                                            <div class="panel-body">
                                                <div class="row" style="background-color: #e3e9f2">
                                                    <div class="col-lg-3">Nomor Material</div>
                                                    <div class="col-lg-9">: <?php echo $data_produk[0]['MATNR'] ?></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3">Short Text</div>
                                                    <div class="col-lg-9">: <?php echo $data_produk[0]['MAKTX'] ?></div>
                                                </div>
                                                <div class="row" style="background-color: #e3e9f2">
                                                    <div class="col-lg-3">Long Text</div>
                                                    <div class="col-lg-9">: <?php echo $longteks ?></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3">UoM</div>
                                                    <div class="col-lg-9">: <?php echo $data_produk[0]['MEINS'] ?></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3">Plant</div>
                                                    <div class="col-lg-9">: <?php echo $dataHarga[0]['PLANTT'] ?> &mdash; <?php echo $dataHarga[0]['NAMA_PLANT'] ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="profile">
                                <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="accor-pengiriman">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion2" href="#pengiriman"
                                                   aria-expanded="true" aria-controls="pengiriman">
                                                    Info Pengiriman
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="pengiriman" class="panel-collapse collapse in" role="tabpanel"
                                             aria-labelledby="accor-pengiriman">
                                            <div class="panel-body">
                                                <!-- <div class="list-group">
                                                  <a href="#" class="list-group-item">First item<span class="badge">12</span></a>
                                                  <a href="#" class="list-group-item">Second item<span class="badge">12</span></a>
                                                  <a href="#" class="list-group-item">Third item<span class="badge">12</span></a>
                                                </div> -->
                                                <div class="row" style="background-color: #e3e9f2">
                                                    <div class="col-lg-3">Pengiriman</div>
                                                    <div class="col-lg-9">: -)</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3">Vendor No</div>
                                                    <div class="col-lg-9">: -)</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="messages">
                                <div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="accord-feedback">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion3" href="#feedback"
                                                   aria-expanded="true" aria-controls="feedback">
                                                    Ulasan Barang
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="feedback" class="panel-collapse collapse in" role="tabpanel"
                                             aria-labelledby="accord-feedback">
                                            <div class="panel-body">
                                                <?php
                                                for ($i = 0; $i < sizeof($feedback); $i++) {
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <font style="font-size: 16px;"><strong><?php echo $feedback[$i]['NAME_USER'] ?></strong></font>
                                                            <br>
                                                            <?php echo $feedback[$i]['DATETIME'] ?>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="row" style="margin-left: 60px;">
                                                                <input type="number" class="ratingstar1"
                                                                       value="<?php echo $feedback[$i]['RATING'] ?>"/>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <?php echo $feedback[$i]['ULASAN'] ?>
                                                        </div>

                                                    </div>
                                                    <hr>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <h5>Tulis Ulasan Anda</h5>
                                <?php echo form_open_multipart('EC_Ecatalog/feedback_pl/',
                                    array('method' => 'POST', 'class' => 'form-horizontal formUlasan')); ?>
                                <input id="rating-input" name="rating-input" type="number"/>
                                <input type="hidden" name="matno" value="<?php echo $data_produk[0]['MATNR'] ?>">
                                <input type="hidden" id="KODE_PENAWARAN" value="<?php echo $this->uri->segment(4) ?>">

                                <!-- <input type="hidden" name="contract_no" value="<?php //echo $data_produk[0]['contract_no']?>"> -->
                                <textarea class="form-control" rows="4" id="ulasan" name="ulasan"></textarea>
                                <button type="submit" id="btn-submit" class="btn btn-success pull-right" style="margin-top: 10px;"
                                        disabled="">Submit
                                </button>
                                </form>
                            </div>
                            <!-- <div role="tabpanel" class="tab-pane" id="settings">...</div> -->
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
</section>


<link rel="stylesheet" href="<?php echo base_url() . "static/css/pages/EC_miniTable.css" ?>"/>
<div class="modal fade" id="modalbudgetDetail">
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
<!--                    <tbody id="tbody">-->
<!--                    </tbody>-->
<!--                </table>-->
                <!-- <form class="form-inline"  method="post">
                    <input type="hidden" name="menu" value="detail_prod_langsung/<?php //echo $this->uri->segment(3) ?>/<?php //echo $this->uri->segment(4) ?>">
                    <div class="form-group">
                        <label for="exampleInputName2">COST CENTER:&nbsp;&nbsp;&nbsp;</label>
                            <?php //$ccp = ($ccc["COSTCENTER"] == null || $ccc["COSTCENTER"] == "") ? "" : $ccc["COSTCENTER"];
                            //if ($ccp == "") ?>
                            <?php //foreach ($CC as $key => $value) { ?>
                                  <?php //if($value["COSTCENTER"] == $ccp) $CCCC= ($value["COSTCENTER"]."&mdash;".$value["NAME"]); ?>
                            <?php //} echo $CCCC;?>
                    </div>
                </form><br/> -->

                <form class="form-inline" action="<?php echo base_url(); ?>EC_Ecatalog/simpanCC" method="post">
                    <input type="hidden" name="menu" value="detail_prod_langsung/<?php echo $this->uri->segment(3) ?>/<?php echo $this->uri->segment(4) ?>">
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
                    <div class="col-xs-12">
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

<div class="modal fade" id="modalBeli">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>INFORMASI ORDER</u></strong></h4>
            </div>
            <div class="modal-body">                
                <h6><span id="maktx2">1000 EA</span></h6>
                <h6><small>Sebanyak:  <span id="jmlItm">1000 EA</span></small></h6>
                <h6><small>Total Biaya: <span id="totalBiaya">IDR 2.000.000</span></small></h6>
                <h6><small>Plant Tujuan: <?php echo $dataHarga[0]['PLANTT'] ?> &mdash; <?php echo $dataHarga[0]['NAMA_PLANT'] ?></small></h6>
                <!-- <h6><small>Cost Center Digunakan: <?php //echo $CCCC ?>  </small></h6> -->
                <form class="form-inline" method="post">
                    <input type="hidden" name="menu" value="listCatalogLsgs">
                    <div class="form-group">
                        <label for="exampleInputName2">Assign budget ke:&nbsp;&nbsp;&nbsp;<span id="kdcmtn"></span></label>
                    </div>
                </form>
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
                    <!-- <button type="button" id="simpanCCBeforeBuy" class="btn btn-primary">Simpan</button> -->
                </form>
                <div class="row" style="margin-top: 10px;">
                    <div class="col-sm-1 col-md-1 col-lg-1">
                        Company:
                    </div>
                    <div class="col-md-4" style="margin-left: 55px;">
                        <select class="form-control" id="selComp">
                            <option value='' selected disabled>Select Company</option>
                            <?php
                                // var_dump($company);
                                foreach ($company as $value) { ?>
                                    <option value='<?php echo $value['COMPANYID']?>' <?php if(substr($value['COMPANYID'],0,1)==substr($dataHarga[0]['PLANTT'],0,1)){ echo 'selected';} ?>><?php echo $value['COMPANYNAME']?></option>
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
                <button type="button" id="buyOne" class="btn btn-success" data-dismiss="modal">Buy</button>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function () {
        $("#input-21f").rating({
            starCaptions: function (val) {
                if (val < 3) {
                    return val;
                } else {
                    return 'high';
                }
            },
            starCaptionClasses: function (val) {
                if (val < 3) {
                    return 'label label-danger';
                } else {
                    return 'label label-success';
                }
            },
            hoverOnClear: false
        });

        $('.ratingstar1').rating({
            size: 'xs',
            showClear: false,
            showCaption: false,
            readonly: true
        });

        $('#rating-input').rating({
            min: 0,
            max: 5,
            step: 1,
            size: 'xs',
            showClear: false

        });

        $('#btn-rating-input').on('click', function () {
            $('#rating-input').rating('refresh', {
                showClear: true,
                disabled: !$('#rating-input').attr('disabled')
            });
        });

        $('.btn-danger').on('click', function () {
            $("#kartik").rating('destroy');
        });

        $('.btn-success').on('click', function () {
            $("#kartik").rating('create');
        });

        $('#rating-input').on('rating.change', function () {
            //alert($('#rating-input').val());
            $('#btn-submit').removeAttr('disabled');
        });

        $('.rb-rating').rating({
            'showCaption': true,
            'stars': '3',
            'min': '0',
            'max': '3',
            'step': '1',
            'size': 'xs',
            'starCaptions': {
                0: 'status:nix',
                1: 'status:wackelt',
                2: 'status:geht',
                3: 'status:laeuft'
            }
        });
    });
</script>