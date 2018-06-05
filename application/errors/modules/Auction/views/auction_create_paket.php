<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo base_url()?>Auction/save" method="POST">
                    <input type="text" name="ptm_number" value="<?php echo $ptm['PTM_NUMBER']?>" hidden>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Auction
                        </div>
                        <table class="table table-hover">
                            <tr>
                                <td class="col-md-3">Nomor Tender</td>
                                <td><input type="text" class="form-control" name="" placeholder="" value="<?php echo $ptm['PTM_PRATENDER']?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Deskripsi</td>
                                <td><input type="text" class="form-control" name="paqh_subject_of_work" placeholder="" value="<?php echo $ptm['PTM_SUBJECT_OF_WORK']?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Lokasi Auction</td>
                                <td><input type="text" class="form-control" name="paqh_location" placeholder=""></td>
                            </tr>
                            <tr>
                                <td>Tanggal Pembukaan</td>
                                <td class="input-group date">
                                    <input type="text" name="paqh_auc_start" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal Penutupan</td>
                                <td class="input-group date">
                                    <input type="text" name="paqh_auc_end" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Nilai Pengurangan</td>
                                <td><input type="text" class="form-control must_autonumeric" name="paqh_decrement_value" placeholder=""></td>
                            </tr>
                            <tr>
                                <td>Tipe Auction</td>
                                <td>
                                    <select name="paqh_price_type" id="paqh_price_type">
                                        <option value="S">Harga Satuan</option>
                                        <option value="T">Harga Total</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>HPS/OE</td>
                                <td>
                                    <input type="hidden" class="form-control" id="paqh_hps" name="paqh_hps" placeholder="" readonly>
                                    <input type="text" class="form-control" id="paqh_hps_palsu" readonly>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <?php 
                        $hps_sebagian = 0;
                        $hps_total = 0;
                    ?>
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
                                        
                                        foreach ($item as $val) {
                                            echo '<tr>';
                                            echo '<td>'.$no.'</td>';
                                            echo '<td class="PPI_NOMAT">'.$val['PPI_ID'].'</td>';
                                            echo '<td>'.$val['PPI_DECMAT'].'</td>';
                                            echo '<td>'.$val['TIT_QUANTITY'].'</td>';
                                            echo '<input type="hidden" class="satuan'.$val['PPI_ID'].'" value='.$val['TIT_QUANTITY'].'>';
                                            echo '<td>'.$val['PPI_UOM'].'</td>';
                                            echo '<td>'.number_format($val['TIT_PRICE']).'</td>';
                                            echo '<input type="hidden" name="item_ikut['.$val['TIT_ID'].']" value="'.$val['PPI_ID'].'" class="checkuncheck">';
                                            echo '<input type="hidden" name="tender_item['.$val['TIT_ID'].']" value="'.$val['TIT_ID'].'">';
                                            echo '<tr>';
                                            $no++;
                                            $hps_sebagian = $hps_sebagian + $val['TIT_PRICE'];
                                            $hps_total = $hps_total + $val['TIT_PRICE'] * $val['TIT_QUANTITY'];
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                        <input type="text" id="hps_total" value="<?php echo $hps_total?>" hidden>
                        <input type="text" id="hps_sebagian" value="<?php echo $hps_sebagian?>" hidden>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Peserta Auction
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="col-md-1" rowspan="2">No</th>
                                            <th class="col-md-3" rowspan="2">Item</th>
                                            <!-- <th>Harga Awal</th>
                                            <th>Ikut</th> -->
                                            <?php foreach ($vendors as $vnd) { ?>
                                                <th class="text-center" colspan="2"><?php echo $vnd['VENDOR_NAME']?></th>
                                                <input type="hidden" class="vendor" value="<?php echo $vnd['PTV_VENDOR_CODE']?>">
                                            <?php } ?>
                                        </tr>
                                         <tr>
                                            <?php foreach ($vendors as $vnd) { ?>
                                            <th class="text-center">Qty</td>
                                            <th class="text-center">Harga</td>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($item as $no => $tit) { ?>
                                        <tr class="itemlist <?php echo $tit['PPI_ID'] ?>">
                                            <td><?php echo ($no+1) ?></td>
                                            <td><?php echo $tit['PPI_DECMAT'] ?></td>
                                            <?php foreach ($vendors as $vnd){ ?>
                                                <?php if (isset($vendor_item[$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']])) { ?>
                                                    <td class="penawaran_qty_vendor text-right qty<?php echo $tit['PPI_ID'].$vnd['PTV_VENDOR_CODE'] ?>"><?php echo $vendor_item[$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']]['PQI_QTY'];?></td>
                                                    <td class="penawaran_vendor text-right hrg<?php echo $vnd['PTV_VENDOR_CODE'] ?>"><?php echo $vendor_item[$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']]['PQI_FINAL_PRICE']==0?$vendor_item[$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']]['PQI_PRICE']:$vendor_item[$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']]['PQI_FINAL_PRICE'] ?></td>
                                                    <input type="hidden" class="hargasatuan<?php echo $tit['PPI_ID'].$vnd['PTV_VENDOR_CODE'] ?>" value="<?php echo $vendor_item[$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']]['PQI_FINAL_PRICE']==0?$vendor_item[$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']]['PQI_PRICE']:$vendor_item[$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']]['PQI_FINAL_PRICE'] ?>">
                                                    <input type="hidden" class="ppinomat <?php echo $vnd['PTV_VENDOR_CODE'] ?>" value="<?php echo $tit['PPI_ID'] ?>">
                                                <?php } else { ?>
                                                    <td class="penawaran_qty_vendor text-right qty<?php echo $tit['PPI_ID'].$vnd['PTV_VENDOR_CODE'] ?>">0</td>
                                                    <td class="penawaran_vendor text-right hrg<?php echo $vnd['PTV_VENDOR_CODE'] ?>">0</td>
                                                <?php } ?>
                                            <?php } ?>
                                        <tr>
                                        <?php } ?>
                                        <tr class="trtotal">
                                            <td></td>
                                            <td><strong>Total</strong></td>
                                            <?php foreach ($vendors as $vnd) {
                                                echo '<td class="text-right total'. $vnd['PTV_VENDOR_CODE'].'"  colspan="2">0';
                                                echo '</td>';
                                                echo '<input type="hidden" class="hargatotal'.$vnd['PTV_VENDOR_CODE'].'" name="total['.$vnd['PTV_VENDOR_CODE'].']" value="0">';
                                            }
                                            ?>
                                        </tr>
                                        <tr class="trtotal">
                                            <td></td>
                                            <td><strong>Ikut</strong>
                                                <label for="pilih-semua"> (Pilih Semua
                                                    <input type="checkbox" id="pilihsemua"/>)
                                                </label>
                                            </td>
                                            <?php foreach ($vendors as $vnd) {
                                                echo '<td class="text-center" colspan="2"><label><input type="checkbox" class="cekvendor vendor_ikut'.$vnd['PTV_VENDOR_CODE'].'" name="vendor_ikut['.$vnd['PTV_VENDOR_CODE'].']" value="'.$vnd['PTV_VENDOR_CODE'].'"></label></td>';
                                            }
                                            ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <a href="<?php echo base_url(); ?>Auction/index" class="main_button color7 small_btn">Kembali</a>
                            <button id="submit-form" type="submit" class="main_button color6 small_btn">Simpan</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>