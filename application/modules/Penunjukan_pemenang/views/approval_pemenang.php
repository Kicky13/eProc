<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span>Penunjukan Pemenang</h2>
            </div>
            <form method="post" action="<?php echo base_url() ?>Penunjukan_pemenang/save_approval">
                <input type="hidden" id="ptm_number" name="ptm_number" value="<?php echo $ptm_detail['PTM_NUMBER'] ?>">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <?php $valid = true; ?>
                            <div class="panel-heading">Pilih Pemenang</div>
                            <?php if (count($tits) <= 0): $valid = false; ?>
                            <div class="panel-body">
                                Tidak ada item yang terpilih untuk penunjukan pemenang.
                            </div>
                            <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <?php $total = 0; ?>
                                    <?php $subtotal = 0; ?>
                                    <?php $no = 1; foreach ($tits as $tit): ?>
                                        <?php if ($tit['PEMENANG'].'' == '') { $valid = false; } ?>
                                        <tr>
                                            <td class="text-right"><?php echo $no ?></td>
                                            <td colspan="2" nowrap=""><strong><?php echo $tit['PPI_DECMAT'] ?></strong> (Qty: <span class="itemqty"><?php echo $tit['TIT_QUANTITY'] ?></span>)</td>
                                            <td class="text-right">Harga ECE</td>
                                            <td class="text-right">Harga Penawaran</td>
                                            <td class="text-right">Harga Akhir</td>
                                            <td class="col-md-2"></td>
                                        </tr>
                                            <?php foreach ($vendor_data as $val): ?>
                                                <?php if (isset($pqiall[$val['PTV_VENDOR_CODE']][$tit['TIT_ID']])): ?>
                                                <?php $pqi = $pqiall[$val['PTV_VENDOR_CODE']][$tit['TIT_ID']]; ?>
                                                <?php if ($tit['PEMENANG'] == $val['PTV_VENDOR_CODE']) {
                                                    $subtotal = $pqi['PQI_FINAL_PRICE'] * $tit['TIT_QUANTITY'];
                                                    // echo 'aaa'; var_dump($val); exit();
                                                    // var_dump($pqi['PQI_FINAL_PRICE'] * $tit['TIT_QUANTITY']);
                                                    // var_dump($subtotal);
                                                    $total += $subtotal;
                                                } ?>
                                                <tr>
                                                    <td class="col-md-1"></td>
                                                    <td class="col-md-1 text-right">
                                                        <?php if ($pqi['PQI_FINAL_PRICE'] != 0): ?>
                                                        <input type="radio" class="winradio" name="win[<?php echo $tit['TIT_ID'] ?>]" value="<?php echo $val['PTV_VENDOR_CODE'] ?>" <?php echo $tit['PEMENANG'] == $val['PTV_VENDOR_CODE'] ? 'checked' : '' ?> disabled>
                                                        <?php endif ?>
                                                    </td>
                                                    <td><?php echo $val['VENDOR_NAME'] ?> (RFQ <?php echo $val['PTV_RFQ_NO'] ?>)</td>
                                                    <td class="col-md-2 text-right"><?php echo number_format($tit['TIT_PRICE']) ?></td>
                                                    <td class="col-md-2 text-right"><?php echo number_format($pqi['PQI_PRICE']) ?></td>
                                                    <td class="col-md-2 text-right">
                                                        <span class="winprice hidden"><?php echo $pqi['PQI_FINAL_PRICE'] ?></span>
                                                        <span class=""><?php echo number_format($pqi['PQI_FINAL_PRICE']) ?></span>
                                                    </td>
                                                    <td><span class="itemqty hidden"><?php echo $tit['TIT_QUANTITY'] ?></span></td>
                                                </tr>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                        <tr class="tritemprice active">
                                            <td class="col-md-1"></td>
                                            <td colspan="5" class="text-right">Subtotal</td>
                                            <td class="text-right">
                                                <span class="itemprice hidden">0</span>
                                                <span class="itempriceshow"><?php echo number_format($subtotal) ?></span>
                                            </td>
                                        </tr>
                                    <?php $no++; endforeach ?>
                                    <tr class="success">
                                        <td colspan="6" class="text-center"><strong>Total</strong></td>
                                        <td id="totalprice" class="text-right text-bold"><?php echo number_format($total) ?></td>
                                    </tr>
                                </table>
                                <input type="hidden" id="itemcount" value="<?php echo count($tits) ?>">
                            </div>
                            <?php endif ?>
                        </div>
                        <?php echo ($ptp['PTP_JUSTIFICATION_ORI']!=5)?$evaluasi:'';?>
                        <?php echo $this->snippet->assignment($ptm_number) ?>
                        <?php echo $ptm_comment ?>
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
                                <a href="<?php echo base_url('Penunjukan_pemenang') ?>" class="main_button color7 small_btn">Kembali</a>&nbsp;
                                <button type="submit" class="main_button color1 small_btn submit" name="submit" value="2">Reject</button>&nbsp;
                                <?php if ($valid): ?>
                                <button type="submit" class="main_button color6 small_btn submit" name="submit" value="1">Approve</button>&nbsp;
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>