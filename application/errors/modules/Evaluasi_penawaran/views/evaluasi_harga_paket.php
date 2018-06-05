<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <input type="hidden" id="ptm_number" name="ptm_number" value="<?php echo $ptm_number; ?>">
            <input type="hidden" id="ptm_status" value="<?php echo $ptm['MASTER_ID']; ?>">
            <div class="row">
                <div class="col-md-12">
                    <form name="form_evaluasi_harga" id="form_evaluasi_harga" method="post" action="<?php echo base_url() ?>Evaluasi_penawaran/save_harga_paket" class="submit">
                    <?php echo $detail_ptm ?>
                    <?php echo $vendor_ptm ?>
                    <?php echo $evaluasi ?>
                    <div class="panel-group" id="accord" role="tablist">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="button" data-toggle="collapse" data-parent="#accord" href="#clps" aria-expanded="true">
                                <h4 class="panel-title">
                                    Evaluasi Harga
                                </h4>
                            </div>
                            <div id="clps" class="panel-collapse collapse in">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <th class="col-md-2 text-center"><strong>Item</strong></th>
                                            <th class="col-md-2 text-center"><strong>Price</strong></th>
                                            <th class="col-md-2 text-center"><strong>Qty</strong></th>
                                            <th class="col-md-2 text-center"><strong>UoM</strong></th>
                                            <th class="col-md-2 text-center"><strong>Net Price</strong></th>
                                            <?php foreach ($pqi[$tit[0]['TIT_ID']] as $key => $value) {?>
                                                <th colspan="2" nowrap class="text-center <?php if ($pqi[$tit[0]['TIT_ID']][$key]['LULUS_TECH']){
                                                            if (floatval($pqi[$tit[0]['TIT_ID']][$key]['PQI_PRICE']) > 0) {
                                                                echo "bg-success";
                                                            } else{
                                                                echo "bg-warning"; 
                                                            }
                                                        } else {
                                                            echo "bg-danger"; 
                                                        } ?>"><strong><?php echo $ptv[$key]['VENDOR_NAME'] ?></strong></th>
                                            <?php } ?>
                                        </thead>
                                        <tbody class="table_evaluasi_harga">
                                            <input type="hidden" name="hps_terendah" class="hps_terendah" value="<?php echo $item['TIT_PRICE']; ?>">

                                            <?php  $total = array();$total_satuan = array(); ?>
                                                <?php foreach ($pqi[$tit[0]['TIT_ID']] as $key => $value) {
                                                    $total[$key] = 0;
                                                    $total_satuan[$key] = 0;
                                                }?>
                                            <?php foreach ($tit as $item): ?>
                                            <tr class="harga">
                                                <td nowrap><strong><?php echo $item['PPI_DECMAT'] ?></strong></td>
                                                <td><?php echo number_format($item['TIT_PRICE']) ?></td>
                                                <td><?php echo $item['TIT_QUANTITY'] ?></td>
                                                <td class="text-center"><?php echo $item['PPI_UOM'] ?></td>
                                                <td class="text-right"><?php echo number_format($item['TIT_PRICE'] * $item['TIT_QUANTITY']) ?></td>
                                                <?php foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                    <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                        <td class="text-right <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                            if (floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > 0) {
                                                                echo "bg-success";
                                                            } else{
                                                                echo "bg-warning"; 
                                                            }
                                                        } else {
                                                            echo "bg-danger"; 
                                                        }
                                                        ?>">
                                                            <?php echo number_format($pqi[$item['TIT_ID']][$key]['PQI_PRICE']); ?>
                                                            <?php $total_satuan[$key] = floatval($total_satuan[$key]) + (floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE'])); ?>
                                                        </td>
                                                        <td class="text-right <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                            if (floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > 0) {
                                                                echo "bg-success";
                                                            } else{
                                                                echo "bg-warning"; 
                                                            }
                                                        } else {
                                                            echo "bg-danger"; 
                                                        }
                                                        ?>">
                                                            <?php echo number_format(floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) * floatval($pqi[$item['TIT_ID']][$key]['PQI_QTY'])) ?>
                                                            <?php $tot = (floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) * floatval($pqi[$item['TIT_ID']][$key]['PQI_QTY'])); ?>
                                                            <?php $total[$key] = floatval($total[$key]) + (floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) * floatval($pqi[$item['TIT_ID']][$key]['PQI_QTY'])); ?>
                                                        </td>
                                                    <?php else: ?>
                                                        <td>-</td>
                                                        <td>-</td>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </tr>
                                            <?php endforeach ?>
                                            <tr class="totalharga">
                                                <td colspan="5" class="warnung">Total</td>
                                                <?php foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                    <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                        <td class="text-right <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                            if (floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > 0) {
                                                                echo "bg-success";
                                                            } else{
                                                                echo "bg-warning"; 
                                                            }
                                                        } else {
                                                            echo "bg-danger"; 
                                                        }
                                                        ?>">
                                                            <?php echo number_format($total_satuan[$key]) ?>
                                                        </td>
                                                        <td class="text-right <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                            if (floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > 0) {
                                                                echo "bg-success";
                                                            } else{
                                                                echo "bg-warning"; 
                                                            }
                                                        } else {
                                                            echo "bg-danger"; 
                                                        }
                                                        ?>">
                                                            <input type="hidden" class="harga_vnd" value="<?php echo $total[$key] ?>" data-vnd="<?php echo $key ?>">
                                                            <?php echo number_format($total[$key]) ?>
                                                        </td>
                                                    <?php else: ?>
                                                        <td>-</td>
                                                        <td>-</td>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </tr>
                                            <tr class="validsampai">
                                                <td colspan="5" class="warnung">Valid Sampai</td>
                                                <?php foreach ($pqi[$tit[0]['TIT_ID']] as $key => $value) {?>
                                                    <?php if (isset($pqi[$tit[0]['TIT_ID']][$key])): ?>
                                                        <td colspan="2" class="text-center <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                            if (floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > 0) {
                                                                echo "bg-success";
                                                            } else{
                                                                echo "bg-warning"; 
                                                            }
                                                        } else {
                                                            echo "bg-danger"; 
                                                        }
                                                        ?>">

                                                        <?php echo date('d-M-Y', oraclestrtotime($pqi[$tit[0]['TIT_ID']][$key]['PQM_VALID_THRU'])) ?>
                                                        </td>
                                                    <?php else: ?>
                                                        <td>-</td>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </tr>
                                            <tr class="deliverytime">
                                                <td colspan="5" class="warnung">Delivery Time</td>
                                                <?php foreach ($pqi[$tit[0]['TIT_ID']] as $key => $value) {?>
                                                    <?php if (isset($pqi[$tit[0]['TIT_ID']][$key])): ?>
                                                        <td colspan="2" class="text-center <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH']){
                                                            if (floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > 0) {
                                                                echo "bg-success";
                                                            } else{
                                                                echo "bg-warning"; 
                                                            }
                                                        } else {
                                                            echo "bg-danger"; 
                                                        }
                                                        ?>">

                                                        <?php echo $pqi[$tit[0]['TIT_ID']][$key]['PQM_DELIVERY_TIME'] ?>
                                                        <?php switch ($pqi[$tit[0]['TIT_ID']][$key]['PQM_DELIVERY_UNIT']) {
                                                            case '1': echo 'Hari'; break;
                                                            case '3': echo 'Minggu'; break;
                                                            case '2': echo 'Bulan'; break;
                                                        } ?>
                                                        </td>
                                                    <?php else: ?>
                                                        <td>-</td>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </tr>
                                            <tr class="nilai_harga">
                                                <td colspan="5" class="info">Nilai Harga</td>
                                                <?php foreach ($pqi[$tit[0]['TIT_ID']] as $key => $value) {?>
                                                    <?php if (isset($pqi[$tit[0]['TIT_ID']][$key])): ?>
                                                        <td colspan="2" class="text-center info data_vnd" data-vnd="<?php echo $key ?>">
                                                            <?php $nilainya = floatval($pqi[$tit[0]['TIT_ID']][$key]['PQI_PRICE_VAL']); ?>
                                                            <span class="nilai_harga_vnd_span"><?php echo $nilainya ?></span>
                                                            <input type="hidden" class="nilai_harga_vnd" name="pqi[<?php echo $pqi[$item['TIT_ID']][$key]['PQM_ID'] ?>][priceval]" value="<?php echo $nilainya ?>">
                                                        </td>
                                                    <?php else: ?>
                                                        <td>-</td>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </tr>

                                            <tr class="range_harga">
                                                <td colspan="5" class="info active">Range 5%</td>
                                                <!-- <td class="active"></td> -->
                                                <?php foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                    <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                        <td colspan="2" class="text-center info data_vnd" data-vnd="<?php echo $key ?>">
                                                            <?php $nilainya = intval($pqi[$item['TIT_ID']][$key]['PQI_PRICE_VAL']); ?>
                                                            <span class="range_harga_vnd_span"><?php echo $nilainya ?></span>
                                                            <input type="hidden" class="range_harga_vnd" name="pqi[<?php echo $pqi[$item['TIT_ID']][$key]['PQI_ID'] ?>][priceval]" value="<?php echo $nilainya ?>">
                                                        </td>
                                                    <?php else: ?>
                                                        <td>-</td>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </tr>

                                            <tr class="penawaran_harga">
                                                <td colspan="5" class="info active">penawaran 5%</td>
                                                <!-- <td class="active"></td> -->
                                                <?php foreach ($pqi[$item['TIT_ID']] as $key => $value) {?>
                                                    <?php if (isset($pqi[$item['TIT_ID']][$key])): ?>
                                                        <td colspan="2" class="text-center info data_vnd" data-vnd="<?php echo $key ?>">
                                                            <?php $nilainya = intval($pqi[$item['TIT_ID']][$key]['PQI_PRICE_VAL']); ?>
                                                            <span class="penawaran_harga_vnd_span"><?php echo $nilainya ?></span>
                                                            <input type="hidden" class="penawaran_harga_vnd" name="pqi[<?php echo $pqi[$item['TIT_ID']][$key]['PQI_ID'] ?>][priceval]" value="<?php echo $nilainya ?>">
                                                        </td>
                                                    <?php else: ?>
                                                        <td>-</td>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </tr>

                                            <tr class="catatan">
                                                <td  colspan="5" class="info">Catatan</td>
                                                 <?php foreach ($pqi[$tit[0]['TIT_ID']] as $key => $value) {?>
                                                    <?php if (isset($pqi[$tit[0]['TIT_ID']][$key])): ?>
                                                        <td colspan="2" class="text-center info data_vnd" data-vnd="<?php echo $key ?>">
                                                            <textarea class="form-control" name="pqi[<?php echo $pqi[$tit[0]['TIT_ID']][$key]['PQM_ID'] ?>][note]"> <?php echo $pqi[$tit[0]['TIT_ID']][$key]['PRICE_NOTE'] ?></textarea>
                                                        </td>
                                                    <?php else: ?>
                                                        <td>-</td>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </tr>
                                            <tr class="validitaspenawaran">
                                                <td  colspan="5" class="info">Validitas penawaran &nbsp;<input type="checkbox" class="checkAllPaket" value="<?php echo $item['TIT_ID'] ?>"></td>
                                                <?php foreach ($pqi[$tit[0]['TIT_ID']] as $key => $value) {?>
                                                    <?php if (isset($pqi[$tit[0]['TIT_ID']][$key])): ?>
                                                        <td colspan="2" class="text-center info data_vnd" data-vnd="<?php echo $key ?>">
                                                            <?php if ($pqi[$item['TIT_ID']][$key]['LULUS_TECH'] && floatval($pqi[$item['TIT_ID']][$key]['PQI_PRICE']) > 0): ?>
                                                            <input type="checkbox" name="pqi[<?php echo $pqi[$tit[0]['TIT_ID']][$key]['PQM_ID'] ?>][validpnawaran]" class="validity form-control checkPaket_<?php echo $item['TIT_ID'] ?>" style="height: 1.9em;">
                                                            <?php endif ?>
                                                        </td>
                                                    <?php else: ?>
                                                        <td>-</td>
                                                    <?php endif ?>
                                                <?php } ?>
                                            </tr>
                                            <tr>
                                                <td colspan="<?php echo count($ptv) + 2 + 5 ?>" class="text-center">
                                                    <button type="button" class="btn btn-info hitung_nilai_paket">Hitung Nilai</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo $this->snippet->assignment($ptm_number) ?>
                    <div id="history_pesan">
                    <?php
                        echo $pesan;
                    ?>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Klarifikasi Penawaran Vendor</div>
                        <table class="table">
                            <tr>
                                <td class="col-md-3">Pilih Vendor <span style="color: #E74C3C">*</span></td>
                                <td>
                                    <select id="vendor_pesan" class="kosong">
                                        <option value="">--Pilih--</option>
                                        <?php foreach ((array)$vendor as $vnd): ?>
                                            <option value="<?php echo $vnd['PTV_VENDOR_CODE'] ?>"><?php echo $vnd['VENDOR_NAME'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Isi Klarifikasi <span style="color: #E74C3C">*</span></td>
                                <td><textarea class="form-control kosong" id="isi_pesan" /></textarea></td>
                            </tr>
                            <tr>
                                <td class="col-md-4">Lampiran (jika ada)</td>
                                <td>
                                    <input type="hidden" id="file_pesan" class="kosong">  
                                    <button type="button" required class="uploadAttachment btn btn-default">Upload File</button><span class="filenamespan"></span>
                                        &nbsp;&nbsp;
                                        <a class="btn btn-default del_upload_file glyphicon glyphicon-trash"></a>
                                    <div class="progress progress-striped active" style="margin: 10px 0px 0px; display: none;">
                                        <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-left">
                                    <button type="button" id="save_chat" class="btn small_btn btn-success">Kirim</button>
                                </td>
                            </tr>  
                        </table>
                    </div>
                    <?php echo $ptm_comment ?>
                    <input type="hidden" name="ptm_number" value="<?php echo $ptm_number; ?>">
                        <div class="panel panel-default">
                            <div class="panel-heading">Komentar Anda</div>
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <tr>
                                        <td class="col-md-3">Komentar</td>
                                        <td class="col-md-1 text-right">:</td>
                                        <td><textarea maxlength="1000" class="form-control" name ="ptc_comment" id="ptc_comment" /></textarea></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <select name="next_process" class="harusmilih_publicjs">
                                    <option value="false_public"></option>
                                    <!-- <option value="2">Simpan (tanpa lanjut proses)</option> -->
                                    <!-- update 26 mei 2016 -->
                                    <option value="2">Simpan Draft</option>
                                    <?php if ($can_continue): ?>
                                        <option value="1">Lanjut ke <?php echo $next_process['NAMA_BARU'] ?></option>
                                    <?php endif; ?>
                                    <option value="0">Retender</option>
                                    <?php if($ptm['SAMPUL'] != 3): ?>
                                        <option value="5">Re Evaluasi</option>
                                    <?php endif; ?>
                                    <option value="999">Batal</option>
                                </select>
                                <input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar"></input>
                                <button type="submit" class="formsubmit main_button color7 small_btn milihtombol_publicjs" disabled>OK</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
