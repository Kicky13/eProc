<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" value=<?php echo $status;?> id="status"></input>
                    <form action="<?php echo base_url()?>Auction/close" method="POST">
                    <input type="text" name="ptm_number" value="<?php echo $paqh['PTM_NUMBER']?>" hidden>
                    <input type="hidden" id="paqh_id" name="paqh_id" value="<?php echo $paqh['PAQH_ID']?>">
                    <div class="panel panel-default">
                        <div class="panel-heading">Auction</div>
                        <table class="table table-hover">
                            <tr>
                                <td class="col-md-3">Nomor Tender</td>
                                <td><input type="text" class="form-control" name="" placeholder="" value="<?php echo $paqh['PTM_PRATENDER'] ?>" readonly></td>
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
                                <td><input type="text" class="form-control" id="PAQH_AUC_START" placeholder="" value="<?php echo $paqh['PAQH_AUC_START'];?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Tanggal Penutupan</td>
                                <td><input type="text" class="form-control" id="PAQH_AUC_END" placeholder="" value="<?php echo $paqh['PAQH_AUC_END'];?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Nilai Pengurangan</td>  
                                <td>
                                    <input type="hidden" name="paqh_decrement_value" value="<?php echo $paqh['PAQH_DECREMENT_VALUE']?>" readonly>
                                    <input type="text" class="form-control" value="<?php echo number_format($paqh['PAQH_DECREMENT_VALUE'])?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>Tipe Auction</td>
                                <td><input type="text" class="form-control" name="paqh_decrement_value" placeholder="" value="<?php echo ($paqh['PAQH_PRICE_TYPE'] == 'T') ? 'Harga Total' : 'Harga Satuan';?>" readonly></td>
                            </tr>
                            <tr>
                                <td>HPS/OE</td>
                                <td><input type="text" class="form-control" id="paqh_hps" name="paqh_hps" placeholder="" value="<?php echo number_format($paqh['PAQH_HPS']);?>" readonly></td>
                                <td><input type="hidden" class="form-control ece" name="ece" placeholder="" value="<?php echo $paqh['PAQH_HPS'];?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Status Breakdown</td>
                                <td><input type="text" class="form-control" id="paqh_is_breakdown" name="paqh_is_breakdown" placeholder="" value="<?php echo ($paqh['IS_BREAKDOWN'] == '1') ? 'Sudah Breakdown' : 'Belum Breakdown'; ?>" readonly></td>
                            </tr>
                            <?php if(!empty($paqh['BREAKDOWN_TYPE'])){?>
                            <tr>
                                <td>Tipe Breakdown</td>
                                <td><input type="text" class="form-control" name="breakdown_tipe" placeholder="" value="<?php echo ($paqh['BREAKDOWN_TYPE'] == 'S') ? 'Breakdown Sendiri' : 'Breakdown Oleh Vendor';?>" readonly></td>
                            </tr>
                            <?php }?>
                        </table>
                    </div>

                    <div class="panel panel-default mulaimonitor">
                        <div class="panel-body">
                            <div class="col-md-12 text-center">
                                <h1 style="margin-bottom:0;color:green;">Auction belum dimulai</h1>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default countdownmonitor">
                        <div class="panel-heading">
                            Waktu Tersisa
                        </div>
                        <div class="panel-body">
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
                                <div class="col-sm-1 col-xs-2 text-center">
                                    <div class="timer">0</div>
                                    <div class="timer_subtitle">DETIK</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default selesaimonitor">
                        <div class="panel-body">
                            <div class="col-md-12 text-center">
                                <h1 style="margin-bottom:0;color:red;">Auction selesai</h1>
                            </div>
                        </div>
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
                                        <th>ECE</th>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $no = 1;
                                        
                                        foreach ($item as $item) {
                                            echo '<tr>';
                                            echo '<td>'.$no.'</td>';
                                            echo '<td>'.$item['PPI_NOMAT'].'</td>';
                                            echo '<td>'.$item['PPI_DECMAT'].'</td>';
                                            echo '<td>'.$item['TIT_QUANTITY'].'</td>';
                                            echo '<td>'.$item['PPI_UOM'].'</td>';
                                            echo '<td>'.number_format($item['TIT_PRICE']).'</td>';
                                            echo '<tr>';
                                            $no++;
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Peserta Auction
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-vendor">
                                    <thead>
                                        <th class="col-md-1 text-center">No</th>
                                        <th>RFQ</th>
                                        <th>Vendor Code</th>
                                        <th>Nama</th>
                                        <th class="text-right">Harga Awal</th>
                                        <th class="text-right">Harga Terkini</th>
                                        <th><span class="label label-primary invisible">new ece</span></th>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($vendor as $vnd) { ?>
                                        <tr class="tr_vnd">
                                            <td class="text-center"><?php echo $no ?></td>
                                            <td><?php echo $vnd['PTV_RFQ_NO'] ?></td>
                                            <td><?php echo $vnd['PTV_VENDOR_CODE'] ?></td>
                                            <td><?php echo $vnd['VENDOR_NAME'] ?></td>
                                            <td class="text-right"><?php echo number_format($vnd['PAQD_INIT_PRICE']) ?></td>
                                            <td class="text-right harga_terkini"><?php echo number_format($vnd['PAQD_FINAL_PRICE']) ?></td>
                                            <td class="hidden">
                                                <input type="text" class="vendor_code" name="vendor_code<?php echo $no ?>" value="<?php echo $vnd['PTV_VENDOR_CODE'] ?>" hidden>
                                                <input type="text" name="vendor_init_price<?php echo $no ?>" value="<?php echo $vnd['PAQD_FINAL_PRICE'] ?>" hidden>
                                            </td>
                                            <td><span class="label label-warning hidden label_ece">ece</span> <span class="label label-primary hidden label_new" data-counter="0">new</span>
                                            </td>
                                        <tr>
                                        <?php $no++; } ?>
                                        <input type="text" name="vendor_counter" value="<?php echo $no ?>" hidden>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Log Auction</div>
                        <table class="table table-stripped">
                            <thead>
                                <th class="text-center">No</th>
                                <th>Created At</th>
                                <th class="text-center">Iter</th>
                                <th>Vendor</th>
                                <th class="text-right">Price</th>
                                <th class="text-center">Bawah ECE</th>
                            </thead>
                            <tbody>
                                <?php foreach ($log as $key => $value): ?>
                                <tr>
                                    <td class="text-center"><?php echo $key+1 ?></td>
                                    <td><?php echo betteroracledate(oraclestrtotime($value['CREATED_AT'])) ?></td>
                                    <td class="text-center"><?php echo $value['ITER'] ?></td>
                                    <td><?php echo $value['VENDOR_NAME'] ?></td>
                                    <td class="text-right"><?php echo number_format($value['PRICE']) ?></td>
                                    <td class="text-center"><?php echo $paqh['PAQH_HPS'] >= $value['PRICE'] ? 'Ya' : '' ?></td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="panel panel-default tombolmonitor">
                        <div class="panel-body text-center">
                            <!-- <button id="submit-form" type="submit" class="main_button color6 small_btn">closed</button> -->
                            <a href="<?php echo base_url(); ?>Auction/index/proses" class="main_button color7 small_btn back-btn">Kembali</a>
                            <?php if(!empty($paqh['BREAKDOWN_TYPE']) && $paqh['BREAKDOWN_TYPE']=='S'){?>
                            <a href="<?php echo base_url(); ?>Auction_negotiation/breakdown/<?php echo $paqh['PAQH_ID']?>" class="main_button color5 small_btn">Breakdown Sendiri</a>
                            <?php }?>
                            <?php if ($paqh['IS_BREAKDOWN'] != '1') {?>
                                <a href="<?php echo base_url();?>Auction/print_auction/<?php echo $paqh['PAQH_ID']?>" class="btn btn-warning" target="_blank">Cetak Auction</a>
                            <?php }?>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>