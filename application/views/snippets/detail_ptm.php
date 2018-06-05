
<div class="panel panel-default">
    <div class="panel-heading">Data Pengadaan</div>
    <table class="table table-hover">
        <?php if (!$for_vendor): ?>
            <input type="hidden" name="master_id" value="<?php echo $ptm_detail['MASTER_ID']; ?>">
        <tr>
            <td class="col-md-4"><strong>Creator</strong></td>
            <td><?php echo $ptm_detail['PTM_REQUESTER_NAME'];?></td>
        </tr>
        <tr>
            <td class="col-md-4"><strong>No Usulan Pratender</strong></td>
            <td><?php echo $ptm_detail['PTM_SUBPRATENDER'] ?></td>
        </tr>
        <?php endif ?>
        <?php if ($buyer != null): ?>
        <tr>
            <td class="col-md-4"><strong>Buyer</strong></td>
            <td><?php echo $buyer['FULLNAME'] ?></td>
        </tr>
        <?php endif ?>
        <tr>
            <td class="col-md-4"><strong>No Pratender</strong></td>
            <td><?php echo $ptm_detail['PTM_PRATENDER'] ?></td>
        </tr>
        <tr>
            <td class="col-md-4"><strong>Nama Pengadaan</strong></td>
            <td><?php echo $ptm_detail['PTM_SUBJECT_OF_WORK'] ?></td>
        </tr>
        <tr>
            <td class="col-md-4"><strong>Jenis Pengadaan</strong></td>
            <td><?php echo $ptm_detail['IS_JASA'] == 0 ? 'Barang' : 'Jasa' ?></td>
        </tr>
        <?php if (!$for_vendor): ?>
        <tr>
            <td class="col-md-4"><strong>Status</strong></td>
            <td>
                <?php echo ($ptm_detail['TAMBAHAN_APPROVAL_NAME']!="") ? $ptm_detail['TAMBAHAN_APPROVAL_NAME'] : $ptm_detail['PROCESS_NAME']; ?>
                <?php //echo $ptm_detail['PROCESS_NAME'] ?>
                <input type="text" name="process_name" class="hidden" value="<?php echo $ptm_detail['PROCESS_NAME']; ?>">
            </td>
        </tr>
        <tr>
            <td class="col-md-4"><strong>Requestioner</strong></td>
            <?php $reqarray = array(); ?>
            <?php foreach ($tit as $val): ?>
                <?php $reqarray[] = $val['PPR_REQUESTIONER'] . (isset($cctr[$val['PPR_REQUESTIONER']]) ? ' '.$cctr[$val['PPR_REQUESTIONER']]['LONG_DESC'] : ''); ?>
            <?php endforeach ?>
            <td><?php echo implode(', ', array_unique($reqarray)) ?></td>
        </tr>
        <?php endif ?>
        <?php if ($rfq != null): ?>
        <tr>
            <td class="col-md-4"><strong>RFQ No</strong></td>
            <td><?php echo $rfq ?></td>
        </tr>
        <?php endif ?>
        <?php if($ptm_detail['PTM_STATUS']==13): ?> <!-- status Evaluasi Harga -->
        <?php if (!$for_vendor): ?> 
        <tr>
            <td><strong>Hasil Evaluasi</strong></td>
            <td>
                <a href="<?php echo base_url('Export_pdf'); ?>/evaluasi_teknis/<?php echo $ptm_detail['PTM_NUMBER']; ?>" target="_blank" title='print'><span class="glyphicon glyphicon-print"></a>
            </td>
        </tr>
        <?php endif ?>
        <?php endif ?>
    </table>
</div>
<div class="panel panel-default">
    <div class="panel-heading">Metode Pengadaan</div>
    <table class="table table-hover">
        <tr>
            <td class="col-md-4"><strong>Mekanisme Pengadaan</strong></td>
            <td><?php echo $ptp['PTP_JUSTIFICATION'] ?>
            <input type="hidden" name="ptp_justification" value="<?php echo $ptp['PTP_JUSTIFICATION_ORI']; ?>">
            </td>
        </tr>
        <tr>
            <td class="col-md-4"><strong>Metode Penawaran</strong></td>
            <td><?php echo $ptp['PTP_IS_ITEMIZE'] == null ? '' : ($ptp['PTP_IS_ITEMIZE'] == 1 ? 'Itemize' : 'Paket') ?></td>
        </tr>
        <tr>
            <td class="col-md-4"><strong>Sistem Sampul</strong></td>
            <td><?php echo $ptp['PTP_IS_ITEMIZE'] == null ? '' : $ptp['PTP_EVALUATION_METHOD'] ?></td>
        </tr>
        <?php if (!$for_vendor): ?>
        <tr>
            <td class="col-md-4"><strong>Sistem Peringatan pada Penawaran</strong></td>
            <td><?php echo $ptp['PTP_WARNING'] ?></td>
        </tr>
        <tr>
            <td class="col-md-4"><strong>Prosentase Batas Atas Penawaran ECE/HPS/OE</strong></td>
            <td><?php echo $ptp['PTP_BATAS_PENAWARAN'] == '' ? '' : $ptp['PTP_BATAS_PENAWARAN'].'%' ?></td>
        </tr>
        <tr>
            <td class="col-md-4"><strong>Prosentase Batas Bawah Penawaran ECE/HPS/OE</strong></td>
            <td><?php echo $ptp['PTP_BAWAH_PENAWARAN'] == '' ? '' : $ptp['PTP_BAWAH_PENAWARAN'].'%' ?></td>
        </tr>
        <tr>
            <td class="col-md-4"><strong>Sistem Peringatan pada Negosiasi</strong></td>
            <td><?php echo $ptp['PTP_WARNING_NEGO'] ?></td>
        </tr>
        <tr>
            <td class="col-md-4"><strong>Prosentase Batas Atas Nego ECE/HPS/OE</strong></td>
            <td><?php echo $ptp['PTP_BATAS_NEGO'] == '' ? '' : $ptp['PTP_BATAS_NEGO'].'%' ?></td>
        </tr>
        <!-- <tr>
            <td class="col-md-4"><strong>Template Evaluasi</strong></td>
            <td><?php echo $ptp['EVT_NAME'] ?></td>
        </tr> -->
        <tr>
            <td class="col-md-4"><strong>Tipe RFQ</strong></td>
            <td><?php echo $ptm_detail['PTM_RFQ_TYPE'] == '0' ? '' : $ptm_detail['PTM_RFQ_TYPE'] ?> <?php echo isset($doctype['DESC']) ? $doctype['DESC'] : '' ?></td>
        </tr>
        <?php endif ?>
        <tr>
            <td class="col-md-4"><strong>Currency</strong></td>
            <td><?php echo $ptm_detail['PTM_CURR'] ?></td>
        </tr>
    </table>
</div>
<div class="panel panel-default">
    <div class="panel-heading">Jadwal Pengadaan</div>
    <table class="table table-hover">
        <tr>
            <td class="col-md-4"><strong><?php echo $for_vendor ? 'Pemasukan Penawaran' : 'RFQ Date' ?></strong></td>
            <td><?php echo empty($ptp['PTP_REG_OPENING_DATE']) ? '' : betteroracledate(oraclestrtotime($ptp['PTP_REG_OPENING_DATE'])) ?></td>
        </tr>
        <tr>
            <td class="col-md-4"><strong><?php echo $for_vendor ? 'Deadline Pemasukan Penawaran' : 'Quotation Deadline' ?></strong></td>
            <td><?php echo empty($ptp['PTP_REG_CLOSING_DATE']) ? '' : betteroracledate(oraclestrtotime($ptp['PTP_REG_CLOSING_DATE'])) ?></td>
        </tr>
        <tr>
            <td class="col-md-4"><strong>Delivery Date</strong></td>
            <td><?php echo empty($ptp['PTP_DELIVERY_DATE']) ? '' : betteroracledate(oraclestrtotime($ptp['PTP_DELIVERY_DATE'])) ?></td>
        </tr>
        <tr>
            <td class="col-md-4"><strong>Tanggal Aanwijing</strong></td>
            <td><?php echo empty($ptp['PTP_PREBID_DATE']) ? '' : betteroracledate(oraclestrtotime($ptp['PTP_PREBID_DATE'])) ?></td>
        </tr>
        <tr>
            <td class="col-md-4"><strong>Lokasi Aanwijing</strong></td>
            <td><?php echo $ptp['PTP_PREBID_LOCATION'] ?></td>
        </tr>
        <tr>
            <td class="col-md-4"><strong>Term of Delivery</strong></td>
            <td><?php echo $ptp['PTP_TERM_DELIVERY'] ?></td>
        </tr>
        <tr>
            <td class="col-md-4"><strong>Term of Delivery Description</strong></td>
            <td><?php echo $ptp['PTP_DELIVERY_NOTE'] ?></td>
        </tr>
        <tr>
            <td class="col-md-4"><strong>Term of Payment</strong></td>
            <td><?php echo $ptp['PTP_TERM_PAYMENT'] == 'TT'? 'Telegraphic Transfer' : $ptp['PTP_TERM_PAYMENT']; ?></td>
        </tr>
        <tr>
            <td class="col-md-4"><strong>Term of Payment Description</strong></td>
            <td><?php echo $ptp['PTP_PAYMENT_NOTE'] ?></td>
        </tr>
        <tr>
            <td class="col-md-4"><strong>Validity Harga</strong></td>
            <td><?php echo empty($ptp['PTP_VALIDITY_HARGA']) ? '' : betteroracledate(oraclestrtotime($ptp['PTP_VALIDITY_HARGA'])) ?></td>
        </tr>
        <?php if(!empty($ptm_detail['BATAS_VENDOR_HARGA'])){ ?>
        <tr>
            <td class="col-md-4"><strong>Batas Penawaran Harga</strong></td>
            <td><?php echo betteroracledate(oraclestrtotime($ptm_detail['BATAS_VENDOR_HARGA'])); ?></td>
        </tr>
        <?php } ?>
    </table>
</div>
<div class="panel panel-default">
    <div class="panel-heading">Jaminan</div>
    <table class="table table-hover">
        <tr>
            <td class="col-md-4"><strong>Jaminan Penawaran</strong></td>
            <td><?php echo $ptp['PTP_PERSEN_PENAWARAN'] > 0 ? $ptp['PTP_PERSEN_PENAWARAN'].'%' : '-' ?></td>
        </tr>
        <tr>
            <td class="col-md-4"><strong>Jaminan Pelaksanaan</strong></td>
            <td><?php echo $ptp['PTP_PERSEN_PELAKSANAAN'] > 0 ? $ptp['PTP_PERSEN_PELAKSANAAN'].'%' : '-' ?></td>
        </tr>
        <tr>
            <td class="col-md-4"><strong>Jaminan Pemeliharaan</strong></td>
            <td><?php echo $ptp['PTP_PERSEN_PEMELIHARAAN'] > 0 ? $ptp['PTP_PERSEN_PEMELIHARAAN'].'%' : '-' ?></td>
        </tr>
    </table>
</div>
<div class="panel panel-default">
    <div class="panel-heading">Catatan Untuk Vendor</div>
    <div class="panel-body">
        <table class="table table-hover">
            <tr>
                <td class="col-md-3">Catatan</td>
                <td>:</td>
                <td>
                    <?php echo $ptp['PTP_VENDOR_NOTE']; ?>
                </td>
            </tr>

            <tr>
                <td class="col-md-3">Catatan Undang Harga</td>
                <td>:</td>
                <td>
                    <?php echo empty($ptm_detail['NOTE_UNTUK_VENDOR']) ? '' : $ptm_detail['NOTE_UNTUK_VENDOR'] ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<?php if (!$for_vendor): ?>
    <?php if (isset($detail_item_ptm)): ?>
        <?php echo $detail_item_ptm ?>
    <?php endif ?>
    <?php if (isset($retender_item)): ?>
        <?php echo $retender_item ?>
    <?php endif ?>
    <?php if (isset($batal_item)): ?>
        <?php echo $batal_item ?>
    <?php endif ?>
<?php endif ?>