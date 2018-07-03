<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" value=<?php echo $status;?> id="status"></input>
                    <form action="<?php echo base_url()?>Auction/open" method="POST" class="submit">
                    <input type="text" name="ptm_number" value="<?php echo $ptm_number?>" hidden>
                    <input type="text" id="paqh_id" name="paqh_id" value="<?php echo $paqh['PAQH_ID']?>" hidden>
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
                                <td><input type="text" class="form-control" name="paqh_location" placeholder="" value="<?php echo $paqh['PAQH_LOCATION'];?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Tanggal Pembukaan</td>
                                <td><input type="text" class="form-control" name="paqh_auc_start" placeholder="" value="<?php echo $paqh['PAQH_AUC_START'];?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Tanggal Penutupan</td>
                                <td><input type="text" class="form-control" id="" name="paqh_auc_end" placeholder="" value="<?php echo $paqh['PAQH_AUC_END'];?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Tipe Bobot (Teknis : Harga)</td>
                                <td>
                                    <select name="bobot_type" id="bobot_type" disabled="">
                                        <option value="0" <?php echo ($paqh['BOBOT_TEKNIS'] == '') ? 'selected' : ''?>>Harga Terendah</option>
                                        <option value="1" <?php echo ($paqh['BOBOT_TEKNIS'] == '60') ? 'selected' : ''?>>60 : 40</option>
                                        <option value="2" <?php echo ($paqh['BOBOT_TEKNIS'] == '70') ? 'selected' : ''?>>70 : 30</option>
                                        <option value="3" <?php echo ($paqh['BOBOT_TEKNIS'] == '80') ? 'selected' : ''?>>80 : 20</option>
                                        <option value="4" <?php echo ($paqh['BOBOT_TEKNIS'] == '90') ? 'selected' : ''?>>90 : 10</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Nilai Pengurangan</td>
                                <td><input type="text" class="form-control" name="paqh_decrement_value" placeholder="" value="<?php echo number_format($paqh['PAQH_DECREMENT_VALUE'])?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Tipe Auction</td>
                                <td><input type="text" class="form-control" name="paqh_decrement_value" placeholder="" value="<?php echo ($paqh['PAQH_PRICE_TYPE'] == 'T') ? 'Harga Total' : 'Harga Satuan';?>" readonly></td>
                            </tr>
                            <tr>
                                <td>HPS/OE</td>
                                <td><input type="text" class="form-control" id="paqh_hps" name="paqh_hps" placeholder="" value="<?php echo number_format($paqh['PAQH_HPS']);?>" readonly></td>
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
                                <table class="table table-hover">
                                    <thead>
                                        <th class="col-md-1">No</th>
                                        <th>RFQ</th>
                                        <th>Vendor Code</th>
                                        <th>Nama</th>
                                        <th class="text-right">Harga Awal</th>
                                        <?php if(!empty($paqh['BOBOT_TEKNIS'])) { ?>
                                        <th>Nilai</th>
                                        <?php } ?>

                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($vendor as $vnd) { ?>
                                        <tr class="tr_vnd">
                                            <td><?php echo $no ?></td>
                                            <td><?php echo $vnd['PTV_RFQ_NO'] ?></td>
                                            <td><?php echo $vnd['PTV_VENDOR_CODE'] ?></td>
                                            <td><?php echo $vnd['VENDOR_NAME'] ?></td>
                                            <td class="text-right"><?php echo number_format($vnd['PAQD_INIT_PRICE']) ?></td>
                                            <?php if(!empty($paqh['BOBOT_TEKNIS'])) { ?>
                                            <td><?php echo $vnd['NILAI_GABUNG'] ?></td>
                                            <?php } ?>
                                            <td class="hidden">
                                                <input type="text" class="vendor_code" name="vendor_code<?php echo $no ?>" value="<?php echo $vnd['PTV_VENDOR_CODE'] ?>" hidden>
                                                <input type="text" name="vendor_init_price<?php echo $no ?>" value="<?php echo $vnd['PAQD_INIT_PRICE'] ?>" hidden>
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
                        <div class="panel-body text-center">
                            <a href="<?php echo base_url(); ?>Auction/index/proses" class="main_button color7 small_btn">Kembali</a>
                            <input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar"></input>
                            <button id="submit-form" type="submit" class="formsubmit main_button color6 small_btn">Open</button>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>