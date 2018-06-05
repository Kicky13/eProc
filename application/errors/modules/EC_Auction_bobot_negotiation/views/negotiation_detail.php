<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <form action="<?php echo base_url()?>Auction/buka" method="POST">
                    <input type="hidden" id="paqh" value="<?php echo $paqh['PAQH_ID']?>">
                    <input type="hidden" name="ptm_number" id="ptm_number" value="<?php echo $ptm_number?>">
                    <input type="hidden" id="vendor_code" value="<?php echo $this->session->userdata('VENDOR_NO')?>">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Auction
                        </div>
                        <table class="table table-hover">
                            <tr>
                                <td class="col-md-3">Tender Number</td>
                                <!-- <td><input type="text" class="form-control" name="" placeholder="" value="20150001" readonly></td> -->
                                <td><input type="text" class="form-control" name="" placeholder="" value="<?php echo $paqh['PTM_PRATENDER']?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Deskripsi</td>
                                <td><input type="text" class="form-control" name="paqh_subject_of_work" placeholder="" value="<?php echo $paqh['PAQH_SUBJECT_OF_WORK']?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Lokasi Auction</td>
                                <td><input type="text" class="form-control" name="paqh_location" placeholder="" value="<?php echo $paqh['PAQH_LOCATION'];?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Tanggal Pembukaan</td>
                                <td><input type="text" id="PAQH_AUC_START" class="form-control" name="paqh_location" placeholder="" value="<?php echo substr($paqh['PAQH_AUC_START'], 0, 19);?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Tanggal Penutupan</td>
                                <td><input type="text" id="PAQH_AUC_END" class="form-control" name="paqh_location" placeholder="" value="<?php echo substr($paqh['PAQH_AUC_END'], 0, 19);?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Nilai Pengurangan</td>
                                <td>
                                    <input type="hidden" class="form-control" id="dec_val" name="paqh_decrement_value" placeholder="" value="<?php echo $paqh['PAQH_DECREMENT_VALUE']?>" readonly>
                                    <input type="text" class="form-control" value="<?php echo number_format($paqh['PAQH_DECREMENT_VALUE']) ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>Tipe Auction</td>
                                <td><input type="text" class="form-control" id="paqh_price_type" name="paqh_price_type" placeholder="" value="<?php echo ($paqh['PAQH_PRICE_TYPE'] == 'T') ? 'Harga Total' : 'Harga Satuan';?>" readonly></td>
                            </tr>
                        </table>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Item
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <th class="col-md-1">No</th>
                                        <th>Kode Item</th>
                                        <th>Deskripsi</th>
                                        <th>Kuantitas</th>
                                        <th>Uom</th>
                                    </thead>
                                    <tbody>
                                    <?php                                     
                                        $no = 1;
                                        $tot_tit_price=0;
                                        $tot_sat_price=0;
                                        foreach ($item as $item) {
                                            echo '<tr>';
                                            echo '<td>'.$no.'</td>';
                                            echo '<td>'.$item['PPI_NOMAT'].'</td>';
                                            echo '<td>'.$item['PPI_DECMAT'].'</td>';
                                            echo '<td>'.$item['TIT_QUANTITY'].'</td>';
                                            echo '<td>'.$item['PPI_UOM'].'</td>';
                                            echo '<tr>';
                                            $no++;
                                            $tot_tit_price+=($item['TIT_QUANTITY']*$item['TIT_PRICE']);
                                            $tot_sat_price+=($item['TIT_PRICE']);
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Auction
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <!-- <th class="col-md-1">No</th> -->
                                        <th>Vendor</th>
                                        <th>Harga Awal</th>
                                        <th>Last Price</th>
                                        <th>STATUS</th>
                                        <!-- <th>Ikut</th> -->
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $no = 1;
                                            echo '<tr>';
                                            echo '<td>'.$vendor['VENDOR_NAME'].'</td>';
                                            echo '<td id="penawaran_awal">'.number_format($vendor['PAQD_INIT_PRICE']).'</td>';
                                            echo '<td id="penawaran_akhir">'.number_format($vendor['PAQD_FINAL_PRICE']).'</td>';
                                            if($paqh['PAQH_PRICE_TYPE'] == 'S'){
                                                echo '<td id="status"><span class="label label-warning label_ece '.(($vendor['PAQD_FINAL_PRICE'] < $tot_sat_price || $vendor['PAQD_FINAL_PRICE']==$tot_sat_price)?'':'hidden').'">ece</span></td>';
                                            }else if($paqh['PAQH_PRICE_TYPE'] == 'T'){
                                                echo '<td id="status"><span class="label label-warning label_ece '.(($vendor['PAQD_FINAL_PRICE'] < $tot_tit_price || $vendor['PAQD_FINAL_PRICE']==$tot_tit_price)?'':'hidden').'">ece</span></td>';
                                            }
                                            echo '<tr>';                                            
                                            echo '<input type="hidden" name="tit_price" id="tit_price" value="'.$item['TIT_PRICE'].'">';
                                            echo '<input type="hidden" name="tot_tit_price" id="tot_tit_price" value="'.$tot_tit_price.'">';
                                            echo '<input type="hidden" name="tot_sat_price" id="tot_sat_price" value="'.$tot_sat_price.'">';
                                            echo '<input type="text" name="vendor_code" value="'.$vendor['PTV_VENDOR_CODE'].'" hidden>';
                                            echo '<input type="text" name="vendor_init_price" value="'.$vendor['PAQD_FINAL_PRICE'].'" hidden>';

                                            $no++;
                                        echo '<input type="text" name="vendor_counter" value="'.$no.'" hidden>';
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default panel_bidder" id="bidderContainer">
                        <div class="panel-heading">
                            Bidder
                        </div>
                        <div class="panel-body">
                            <div class="row" id="status_auction">
                                <div class="col-xs-12">
                                    <?php if($status_auction == 'auction belum mulai') { ?>
                                        <h3 class="text-center">Auction belum dimulai</h2>
                                    <?php } else if($status_auction == 'auction sudah selesai'){ ?>
                                        <h3 class="text-center">Auction sudah selesai</h3>
                                    <?php }?>
                                </div>
                            </div>
                            <?php if($status_auction != 'auction sudah selesai'){ ?>
                            <div class="row hidden" id="countdown">
                                <div class="col-xs-12">
                                        <div class="col-sm-1 col-sm-offset-4 col-xs-2 col-xs-offset-2 text-center hidden" hidden>
                                            <div class="timer">0</div>
                                            <div class="timer_subtitle">HARI</div>
                                        </div>
                                        <div class="col-sm-1 col-xs-2 col-sm-offset-4 col-xs-offset-3 text-center">
                                            <div class="timer">0</div>
                                            <div class="timer_subtitle">JAM</div>
                                        </div>
                                        <div class="col-sm-1 col-xs-2 text-center">
                                            <div class="timer">0</div>
                                            <div class="timer_subtitle">MENIT</div>
                                        </div>
                                        <div class="col-sm-1 col-xs-2   text-center">
                                            <div class="timer">0</div>
                                            <div class="timer_subtitle">DETIK</div>
                                        </div>
                                </div>
                            </div>
                            <?php } ?>
                            <br>
                            <div class="row" id="win" style="display: none">
                                <div class="col-sm-12 text-center">
                                    <h4><img class="logo_dark" src="<?php echo base_url(); ?>static/images/trophy.jpg"></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-sm-offset-3">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3 col-xs-12 text-center  bottom_space">
                                            <span id="hargapenawaran">
                                            Harga Terakhir: <?php echo number_format($vendor['PAQD_FINAL_PRICE']);?>                                           
                                            </span>
                                            <?php echo '<span class="label label-warning label_ece '.(($vendor['PAQD_FINAL_PRICE'] < $item['TIT_PRICE'] || $vendor['PAQD_FINAL_PRICE']==$item['TIT_PRICE'])?'':'hidden').'" >ece</span>'?>
                                             <br>
                                            <input type="text" style="font-size: 20px;color:black;font-weight: bold;" id="harga_bids" class=" text-center col-xs-12" value="<?php echo number_format($vendor['PAQD_FINAL_PRICE'])?>" readonly>
                                            Nilai Pengurangan: <?php echo number_format($paqh['PAQH_DECREMENT_VALUE']) ?>
                                            <input type="hidden" style="font-size: 20px" id="harga_bid" class="form-control text-center bottom_space" value="<?php echo $vendor['PAQD_FINAL_PRICE']?>" readonly>
                                            <input type="hidden" style="font-size: 20px" id="time" class="form-control text-center bottom_space" value="<?php echo $timenow ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if($status_auction != 'auction sudah selesai'){ ?>
                            <div class="row hidden" id="buttonsubmit">
                                <div class="col-sm-6 col-sm-offset-3">
                                    <div class="row" id="decrease_button">
                                        <div class="col-sm-12" style="text-align: center">
                                            <a class="btn btn-primary btn-circle btn_decrease bid_button">1</a>
                                            <a class="btn btn-primary btn-circle btn_decrease bid_button">2</a>
                                            <a class="btn btn-primary btn-circle btn_decrease bid_button">3</a>
                                            <a class="btn btn-primary btn-circle btn_decrease bid_button">4</a>
                                            <a class="btn btn-primary btn-circle btn_decrease bid_button">5</a>
                                            <a class="btn btn-primary btn-circle btn_decrease bid_button">6</a>
                                            <a class="btn btn-primary btn-circle btn_decrease bid_button">7</a>
                                            <a class="btn btn-primary btn-circle btn_decrease bid_button">8</a>
                                            <a class="btn btn-primary btn-circle btn_decrease bid_button">9</a>
                                            <a class="btn btn-primary btn-circle btn_decrease bid_button">10</a>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6 col-md-offset-3 text-center" id="placeCenter">
                                            <div class="row">
                                                <div class="col-xs-4 text-center no_padding_right">
                                                    <button class="btn_increase main_button bid_button color1 small_btn btn-block" id="btn_increase" type="button">Undo</button>
                                                </div>
                                                <div class="col-xs-8 text-center ">
                                                    <button class="main_button color6 small_btn btn-block bid_button" id="btn_bid_submit" type="button">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-body text-right">
                            <!-- <button id="submit-form" type="submit" class="main_button color6 small_btn">Buka</button> -->
                            <a href="<?php echo site_url('Auction_negotiation'); ?>" class="main_button color7 small_btn">Kembali</a>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>