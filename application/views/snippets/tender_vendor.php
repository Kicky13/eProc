<div class="panel panel-default">
    <div class="panel-heading">Quotation</div>
    <table class="table table-hover">
        <tr>
            <td class="">No Surat</td>
            <td><?php echo $pqm['PQM_NUMBER'] ?>
                <?php if ($pqm['FILE_SURAT'] != ''): ?>
                <a href="<?php echo base_url('Quotation'); ?>/viewDok/<?php echo $pqm['FILE_SURAT']; ?>" target="_blank">
                    <i class="glyphicon glyphicon-download-alt"></i>
                </a>
                <?php else: ?>
                <?php endif ?>
            </td>
        </tr>
        <tr>
            <td class="">Kandungan Lokal</td>
            <td><?php echo $pqm['PQM_LOCAL_CONTENT'] ?></td>
        </tr>
        <tr>
            <td class="">Waktu Pengiriman</td>
            <td>
                <?php echo $pqm['PQM_DELIVERY_TIME'] ?>
                <?php switch ($pqm['PQM_DELIVERY_UNIT']) {
                    case '1':
                        echo 'Hari';
                        break;
                    case '2':
                        echo 'Bulan';
                        break;
                    case '3':
                        echo 'Minggu';
                        break;
                } ?>
            </td>
        </tr>
        <tr>
            <td class="">Berlaku Hingga</td>
            <td><?php echo date('d-M-Y', oraclestrtotime($pqm['PQM_VALID_THRU'])) ?></td>
        </tr>
        <tr>
            <td class="">Catatan</td>
            <td><?php echo $pqm['PQM_NOTES'] ?></td>
        </tr>
        <!-- <tr>
            <td class="">Inco Term</td>
            <td><?php echo $pqm['PQM_INCOTERM'] ?></td>
        </tr> -->
        <?php if ($ptp['PTP_PERSEN_PENAWARAN'] != ''): ?>
            <tr>
                <td class="">Jaminan Penawaran (<?php echo $ptp['PTP_PERSEN_PENAWARAN'] ?>%)</td>
                <td>
                    <?php if ($pqm['PQM_FILE_PENAWARAN'] != ''): ?>
                    <a href="<?php echo base_url('Quotation'); ?>/viewDok/<?php echo $pqm['PQM_FILE_PENAWARAN']; ?>" target="_blank">
                        YA
                        <i class="glyphicon glyphicon-download-alt"></i>
                    </a>
                    <?php else: ?>
                        TIDAK
                    <?php endif ?>
                </td>
            </tr>
        <?php endif ?>
        <?php if ($ptp['PTP_PERSEN_PEMELIHARAAN'] != ''): ?>
            <tr>
                <td class="">Jaminan Pemeliharaan (<?php echo $ptp['PTP_PERSEN_PEMELIHARAAN'] ?>%)</td>
                <td>
                    <?php if ($pqm['PQM_FILE_PEMELIHARAAN'] != ''): ?>
                    <a href="<?php echo base_url('Quotation'); ?>/viewDok/<?php echo $pqm['PQM_FILE_PEMELIHARAAN']; ?>" target="_blank">
                        YA
                        <i class="glyphicon glyphicon-download-alt"></i>
                    </a>
                    <?php else: ?>
                        TIDAK
                    <?php endif ?>
                </td>
            </tr>
        <?php endif ?>
        <?php if ($ptp['PTP_PERSEN_PELAKSANAAN'] != ''): ?>
            <tr>
                <td class="">Jaminan Pelaksanaan (<?php echo $ptp['PTP_PERSEN_PELAKSANAAN'] ?>%)</td>
                <td>
                    <?php if ($pqm['PQM_FILE_PELAKSANAAN'] != ''): ?>
                    <a href="<?php echo base_url('Quotation'); ?>/viewDok/<?php echo $pqm['PQM_FILE_PELAKSANAAN']; ?>" target="_blank">
                        YA
                        <i class="glyphicon glyphicon-download-alt"></i>
                    </a>
                    <?php else: ?>
                        TIDAK
                    <?php endif ?>
                </td>
            </tr>
        <?php endif ?>
    </table>
</div>
<div class="panel panel-default">
    <div class="panel-heading">Detail Teknis</div>
    <table id="evalteknis" class="table table-hover">
        <?php foreach ($pqi as $tit): ?>
        <tr>
            <td>
                <strong><?php echo $tit["PPI_NOMAT"].' | '.$tit['PPI_DECMAT'] ?></strong>
                <ul class="row">
                <?php if (isset($ef[$tit['TIT_ID']])): ?>
                <?php foreach ($ef[$tit['TIT_ID']] as $val): ?>
                    <li class="col-md-offset-1">
                        <a href="<?php echo base_url('Quotation'); ?>/viewDok/<?php echo $val['EF_FILE']; ?>" target="_blank">
                            <i class="glyphicon glyphicon-download-alt"></i>
                            <?php //echo $val['ET_NAME'] ?>
                        </a>
                    </li>
                    <?php if (isset($eu[$tit['TIT_ID']][$val['ET_ID']])): ?>
                        <!-- <ul class="col-md-offset-2 list-circle">
                        <?php foreach ($eu[$tit['TIT_ID']][$val['ET_ID']] as $eut): ?>
                            <li><?php echo $eut['EU_NAME'] ?></li>
                        <?php endforeach ?>
                        </ul> -->
                    <?php endif ?>
                <?php endforeach ?>
                <?php else: ?>
                <li class="col-md-offset-1 text-muted">Tidak ada attachment detail teknis.</li>
                <?php endif ?>
                </ul>
            </td>
        </tr>
        <?php endforeach ?>
    </table>
</div>

<?php if ($show_harga): ?>
<div class="panel panel-default">
    <div class="panel-heading">Barang</div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <th class="text-center col-md-1">No</th>
                <th>Kode Material</th>
                <th>Short Text</th>
                <th>Spesifikasi Penawaran</th>
                <th class="text-center Kiri">Jumlah</th>
                <th class="text-right Kanan">Harga HPS</th>
                <th class="text-center Kiri">Jumlah</th>
                <th class="text-right Kanan">Harga Vendor</th>
            </thead>
            <tbody id="barang_vendor">
            <?php $no = 1; $tothps = 0; $totvnd = 0; ?>
            <?php foreach ($pqi as $val): ?>
            <tr>
                <td class="text-center text-top"><?php echo $no ?></td>
                <td class="text-center text-top"><?php echo $val['PPI_NOMAT'] ?></td>
                <td class="text-top"><?php echo $val['PPI_DECMAT'] ?></td>
                <td class="text-top"><small><?php echo nl2br($val['PQI_DESCRIPTION']) ?></small></td>
                <td class="text-center text-top Kiri"><?php echo $val['TIT_QUANTITY'] ?></td>
                <td class="text-right text-top Kanan"><?php echo number_format($val['TIT_PRICE']) ?></td>
                <td class="text-center text-top Kiri"><?php echo $val['PQI_QTY'] ?></td>
                <td class="text-right text-top Kanan"><?php echo number_format($val['PQI_PRICE']) ?></td>
                <?php $tothps += $val['TIT_PRICE'] * $val['TIT_QUANTITY'] ?>
                <?php $totvnd += $val['PQI_PRICE'] * $val['PQI_QTY'] ?>
            </tr>
            <?php $no++; endforeach ?>
            </tbody>
            <tfoot>
                <tr class="info">
                    <td colspan="4" class="text-center"><strong>Total</strong></td>
                    <td colspan="2" id="hargahps" class="text-center Kiri Kanan"><?php echo number_format($tothps) ?></td>
                    <td colspan="2" id="hargavnd" class="text-center Kanan"><?php echo number_format($totvnd) ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<?php endif ?>
<?php if($batas_penawaran){ ?>
<div class="panel panel-default">
    <div class="panel-heading">File Penawaran Harga</div>
    <table id="evalteknis" class="table table-hover">
        <tr>
            <td class=" col-md-3">File Upload</td>
            <td class="col-md-9">
                <div class="row">
                <?php if( $ptv['FILE_HARGA']){ ?>
                    <div class="col-md-4">
                        <a href="<?php echo base_url('Additional_document'); ?>/viewDok/<?php echo $ptv['FILE_HARGA']; ?>" target="_blank" >
                           <span class="glyphicon glyphicon-file">
                        </a>
                    </div>
                <?php } else { ?>
                    <div class="glyphicon glyphicon-file"></div>
                <?php } ?>
                </div>
            </td>
        </tr>
    </table>
</div>
<?php } ?>

<style type="text/css">
.Kanan{
    border-right:2px solid #E5E2E2;
}
.Kiri{
    border-left: 2px solid #E5E2E2;
}
.Bawah{
    border-bottom:1px solid black;
}
.Atas{
    border-top:1px solid black;
}
</style>