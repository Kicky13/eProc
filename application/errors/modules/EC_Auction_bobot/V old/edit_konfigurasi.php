<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <form action="<?php echo base_url()?>Auction/simpan_edit" method="POST">
                    <input type="text" name="paqh_id" value="<?php echo $paqh['PAQH_ID']?>" hidden>
                    <input type="text" name="ptm" value="<?php echo $paqh['PTM_NUMBER']?>" hidden>
                    <input type="text" id="paqh_open_status" value="<?php echo $paqh['PAQH_OPEN_STATUS']?>" hidden>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Auction
                        </div>
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
                                <td><input type="text" class="form-control" name="paqh_location" placeholder="" value="<?php echo $paqh['PAQH_LOCATION'];?>"></td>
                            </tr>
                            <tr>
                                <td>Tanggal Pembukaan</td>
                                <td class="input-group date">                                   
                                    <input type="text" name="paqh_auc_start" class="auc_start form-control" value="<?php echo $paqh['PAQH_AUC_START'];?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal Penutupan</td>
                                <td class="input-group date">                                   
                                    <input type="text" name="paqh_auc_end" class="auc_end form-control" value="<?php echo $paqh['PAQH_AUC_END'];?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Nilai Pengurangan</td>
                                <td><input type="text" class="decrement_value form-control must_autonumeric" name="paqh_decrement_value" placeholder="" value="<?php echo $paqh['PAQH_DECREMENT_VALUE']?>"></td>
                            </tr>
                            <tr>
                                <td>Tipe Auction</td>
                                <td>
                                    <select name="paqh_price_type" id="paqh_price_type">
                                        <option value="S" <?php echo ($paqh['PAQH_PRICE_TYPE'] == 'S') ? 'selected' : ''?>>Harga Satuan</option>
                                        <option value="T" <?php echo ($paqh['PAQH_PRICE_TYPE'] == 'T') ? 'selected': '';?>>Harga Total</option>
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
                                        <th>Ikut Auction</th>
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
                                            echo '<td><label><input type="checkbox" name="item_ikut['.$val['TIT_ID'].']" value="'.$val['PPI_ID'].'" class="checkuncheck"></label></td>';
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
                                <table class="table table-hover">
                                    <thead>
                                        <th class="col-md-1">No</th>
                                        <th class="col-md-3">Item</th>
                                        <!-- <th>Harga Awal</th>
                                        <th>Ikut</th> -->
                                        <?php echo empty($vendors)?'Peserta tidak ditemukan':'';?>
                                        <?php foreach ($vendors as $vnd) { ?>
                                            <th class="text-center"><?php echo $vnd['VENDOR_NAME']?></th>
                                            <input type="hidden" class="vendor" value="<?php echo $vnd['PTV_VENDOR_CODE']?>">
                                        <?php } ?>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($item as $no => $tit) { ?>
                                        <tr class="itemlist <?php echo $tit['PPI_ID'] ?>">
                                            <td><?php echo ($no+1) ?></td>
                                            <td><?php echo $tit['PPI_DECMAT'] ?></td>
                                            <?php foreach ($vendors as $vnd){ ?>
                                                <?php if (isset($vendor_item[$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']])) { ?>
                                                    <td class="penawaran_vendor text-right hrg<?php echo $vnd['PTV_VENDOR_CODE'] ?>"><?php echo $vendor_item[$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']]['PQI_PRICE'] ?></td>
                                                    <input type="hidden" class="hargasatuan<?php echo $tit['PPI_ID'].$vnd['PTV_VENDOR_CODE'] ?>" value="<?php echo $vendor_item[$tit['TIT_ID']][$vnd['PTV_VENDOR_CODE']]['PQI_PRICE'] ?>">
                                                    <input type="hidden" class="ppinomat <?php echo $vnd['PTV_VENDOR_CODE'] ?>" value="<?php echo $tit['PPI_ID'] ?>">
                                                <?php } else { ?>
                                                    <td class="text-right <?php echo $vnd['PTV_VENDOR_CODE'] ?>"> 0 </td>
                                                <?php } ?>
                                            <?php } ?>
                                        <tr>
                                        <?php } ?>
                                        <tr class="trtotal">
                                            <td></td>
                                            <td><strong>Total</strong></td>
                                            <?php foreach ($vendors as $vnd) {
                                                echo '<td class="text-right total'. $vnd['PTV_VENDOR_CODE'].'">0';
                                                echo '</td>';
                                                echo '<input type="hidden" class="hargatotal'.$vnd['PTV_VENDOR_CODE'].'" name="total['.$vnd['PTV_VENDOR_CODE'].']" value="0">';
                                            }
                                            ?>
                                        </tr>
                                        <tr class="trtotal">
                                            <td></td>
                                            <td><strong>Ikut</strong></td>
                                            <?php foreach ($vendors as $vnd) {
                                                echo '<td class="text-center"><label><input type="checkbox" class="cekvendor" name="vendor_ikut['.$vnd['PTV_VENDOR_CODE'].']" value="'.$vnd['PTV_VENDOR_CODE'].'"></label></td>';
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
                            <a href="<?php echo base_url(); ?>Auction/index/proses" class="main_button color7 small_btn">Kembali</a>
                            <button id="submit-form" type="submit" class="main_button color6 small_btn">Simpan</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>