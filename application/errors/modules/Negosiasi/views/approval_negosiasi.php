<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span>Negosiasi</h2>
            </div>
            <form name="quotation-form" id="quotation-form" method="post" action="<?php echo base_url() ?>Negosiasi/save_approval">
                <input type="hidden" id="ptm_number" name="ptm_number" value="<?php echo $ptm_detail['PTM_NUMBER'] ?>">
                <div class="row">
                    <div class="col-md-12">
                        <?php if ($success): ?>
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Success!</strong> Data berhasil disimpan.
                            </div>
                        <?php endif ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">Konfigurasi Negosiasi</div>
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-3">Tanggal Selesai</td>
                                    <td>
                                        <?php echo empty($nego['NEGO_END']) ? '' : betteroracledate(oraclestrtotime($nego['NEGO_END'])) ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php $no = 1; foreach ((array)$vendors as $v) { ?>
                        <div class="panel panel-default">
                            <table class="table table-hover">
                                <tr class="info">
                                    <td class="col-md-1"></td>
                                    <td><?php echo $v['VENDOR_NAME'] ?> (<?php echo $v['PTV_VENDOR_CODE'] ?>)</td>
                                </tr>
                            </table>
                            <table class="table table-hover">
                                <thead>
                                    <th></th>
                                    <th>No PR</th>
                                    <th>Material</th>
                                    <th>Qty</th>
                                    <th class="text-right">ECE</th>
                                    <th class="text-right">Penawaran</th>
                                    <th class="text-right">Nego</th>
                                    <th class="text-right">Total ECE</th>
                                    <th class="text-right">Total Penawaran</th>
                                    <th class="text-right">Total Nego</th>
                                </thead>
                                <tbody>
                                    <?php $totalhps = 0; ?>
                                    <?php $totalpen = 0; ?>
                                    <?php $totalneg = 0; ?>
                                    <?php foreach ($tits as $val): ?>
                                        <?php if (isset($ptqi[$v['PTV_VENDOR_CODE']][$val['TIT_ID']])): ?>
                                            <?php $thispqi = $ptqi[$v['PTV_VENDOR_CODE']][$val['TIT_ID']]; ?>
                                            <tr>
                                                <td></td>
                                                <td><?php echo $thispqi['PPI_PRNO'] ?></td>
                                                <td><?php echo $thispqi['PPI_DECMAT'] ?></td>
                                                <td><?php echo $thispqi['TIT_QUANTITY'] ?></td>
                                                <td class="text-right"><?php echo number_format($thispqi['TIT_PRICE']) ?></td>
                                                <td class="text-right"><?php echo number_format($thispqi['PQI_PRICE']) ?></td>
                                                <?php 
                                                    if ($thispqi['PQI_FINAL_PRICE'] < $thispqi['PQI_PRICE'] && $thispqi['PQI_FINAL_PRICE'] > 0) {
                                                        $textdecor = 'text-success';
                                                    } else if ($thispqi['PQI_FINAL_PRICE'] > $thispqi['PQI_PRICE']) {
                                                        $textdecor = 'text-danger';
                                                    } else {
                                                        $textdecor = '';
                                                    }
                                                 ?>
                                                <td class="text-right <?php echo $textdecor ?>"><?php echo number_format($thispqi['PQI_FINAL_PRICE']) ?></td>
                                                <td class="text-right"><?php echo number_format($thispqi['TIT_PRICE'] * $thispqi['TIT_QUANTITY']) ?></td>
                                                <td class="text-right"><?php echo number_format($thispqi['PQI_PRICE'] * $thispqi['TIT_QUANTITY']) ?></td>
                                                <td class="text-right"><?php echo number_format($thispqi['PQI_FINAL_PRICE'] * $thispqi['TIT_QUANTITY']) ?></td>
                                                <?php $totalhps += $thispqi['TIT_PRICE'] * $thispqi['TIT_QUANTITY']; ?>
                                                <?php $totalpen += $thispqi['PQI_PRICE'] * $thispqi['TIT_QUANTITY']; ?>
                                                <?php $totalneg += $thispqi['PQI_FINAL_PRICE'] * $thispqi['TIT_QUANTITY']; ?>
                                            </tr>
                                        <?php else: ?>
                                            <tr class="hidden">
                                                <td colspan="5">Vendor tidak memasukkan penawaran atas item ini</td>
                                            </tr>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </tbody>
                                <tfoot>
                                    <tr class="active">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Total</td>
                                        <td class="text-right"><?php echo number_format($totalhps) ?></td>
                                        <td class="text-right"><?php echo number_format($totalpen) ?></td>
                                        <td class="text-right"><?php echo number_format($totalneg) ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="panel-body">
                                <div class="panel panel-default">
                                    <table class="table table-hover">
                                        <thead>
                                            <th class="col-md-1 text-center">No</th>
                                            <th class="col-md-2 text-center">Tanggal</th>
                                            <th class="col-md-2">Dari</th>
                                            <th class="">Pesan</th>
                                        </thead>
                                        <tbody>
                                            <?php $no=1; foreach ((array)$negos[$v['PTV_VENDOR_CODE']] as $nego) { ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no?></td>
                                                <td class="text-center"><?php echo betteroracledate(oraclestrtotime($nego['PTNS_CREATED_DATE'])) ?></td>
                                                <?php if ($nego['PTNS_CREATED_BY'] != '') { ?>
                                                <td><?php $emp = $this->adm_employee->find($nego['PTNS_CREATED_BY']); echo $emp['FULLNAME']; ?></td>
                                                <?php } else { ?>
                                                <td>Vendor</td>
                                                <?php } ?>
                                                <td><?php echo $nego['PTNS_NEGO_MESSAGE'];?></td>
                                            </tr>
                                            <?php $no++; } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php $no++; } ?>
                        <?php echo $evaluasi ?>
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
                                <a href="<?php echo base_url('Negosiasi') ?>" class="main_button color7 small_btn">Kembali</a>
                                <select name="next_process">
                                    <option value="0">Setuju</option>
                                    <option value="1">Buka Lagi Negosiasi</option>
                                </select>
                                <button type="submit" class="main_button color6 small_btn">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>