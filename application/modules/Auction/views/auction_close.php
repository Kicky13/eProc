<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Error!</strong> <?php echo $this->session->flashdata('error') ?>
                        </div>
                    <?php endif ?>
                    <input type="hidden" value=<?php echo $status;?> id="status"></input>
                    <form action="<?php echo base_url()?>Auction/close" method="POST" class="submit">
                    <input type="text" name="ptm_number" value="<?php echo $ptm_number?>" hidden>
                    <input type="text" id="paqh_id" name="paqh_id" value="<?php echo $paqh['PAQH_ID']?>" hidden>
                    <!-- <input type="text" name="vendorwinner" value="<?php echo $min?>" hidden> -->
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
                                <td><input type="text" class="form-control" id="PAQH_AUC_START" name="paqh_location" placeholder="" value="<?php echo substr($paqh['PAQH_AUC_START'], 0, 19);?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Tanggal Penutupan</td>
                                <td><input type="text" id="PAQH_AUC_END" class="form-control" name="paqh_location" placeholder="" value="<?php echo substr($paqh['PAQH_AUC_END'], 0, 19);?>" readonly></td>
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
                                <td><input type="text" class="form-control" id="paqh_hps" name="paqh_hps" placeholder="" value="<?php echo number_format($paqh['PAQH_HPS']) ?>" readonly></td>
                            </tr>                            
                            <tr>
                                <td>Tipe Breakdown</td>
                                <td>
                                    <select name="breakdown_type" id="breakdown_type">
                                        <option value="">Pilih Tipe Breakdown</option>
                                        <option value="S" <?php echo ($paqh['PAQH_HPS']=='S')?'selected':'';?>>Breakdown Sendiri</option>
                                        <option value="V" <?php echo ($paqh['PAQH_HPS']=='V')?'selected':'';?>>Breakdown Oleh Vendor</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Waktu Tersisa
                        </div>
                        <div class="panel-body">
                            <div class="col-md-1 col-md-offset-4 text-center">
                                <div class="timer">0</div>
                                <div class="timer_subtitle">HARI</div>
                            </div>
                            <div class="col-md-1 text-center">
                                <div class="timer">0</div>
                                <div class="timer_subtitle">JAM</div>
                            </div>
                            <div class="col-md-1 text-center">
                                <div class="timer">0</div>
                                <div class="timer_subtitle">MENIT</div>
                                    </div>
                            <div class="col-md-1 text-center">
                                <div class="timer">0</div>
                                <div class="timer_subtitle">DETIK</div>
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
                                <table class="table table-hover">
                                    <thead>
                                        <th class="col-md-1">No</th>
                                        <th>Vendor</th>
                                        <th>Harga Awal</th>
                                        <th>Harga Akhir</th>
                                        <?php if(!empty($paqh['BOBOT_TEKNIS'])) { ?>
                                        <th>Nilai</th>
                                        <?php } ?>
                                        <th>Ikut</th>
                                        <th class="text-center">Pemenang</th>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $no = 1;
                                        foreach ($vendor as $vnd) {
                                            echo '<tr>';
                                            echo '<td>'.$no.'</td>';
                                            echo '<td>'.$vnd['VENDOR_NAME'].'</td>';
                                            echo '<td>'.number_format($vnd['PAQD_INIT_PRICE']).'</td>';
                                            echo '<td>'.number_format($vnd['PAQD_FINAL_PRICE']).'</td>';
                                            if(!empty($paqh['BOBOT_TEKNIS'])) { 
                                            echo '<td>'.$vnd['NILAI_GABUNG'].'</td>';
                                            }
                                            echo '<td>Ya</td>';
                                            echo '<input type="text" name="vendor_code'.$no.'" value="'.$vnd['PTV_VENDOR_CODE'].'" hidden>';
                                            echo '<input type="text" name="vendor_init_price'.$no.'" value="'.$vnd['PAQD_FINAL_PRICE'].'" hidden>';
                                            echo '<td class="text-center"><input type="radio" name="vendorwinner" value="'.$vnd['PTV_VENDOR_CODE'].'" '.(($min==$vnd['PTV_VENDOR_CODE'])?'checked':'').' /></td>';
                                            echo '<tr>';
                                            $no++;
                                        }
                                        echo '<input type="text" name="vendor_counter" value="'.$no.'" hidden>';
                                    ?>
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
                                    <td class="text-center"><?php echo $paqh['PAQH_HPS'] > $value['PRICE'] ? 'Ya' : '' ?></td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-body text-center">                            
                            <a href="<?php echo base_url(); ?>Auction/index/tutup" class="main_button color7 small_btn back-btn">Kembali</a>
                            <input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar"></input>
                            <button id="btn-close" type="submit" class="formsubmit main_button color6 small_btn" >Close</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>