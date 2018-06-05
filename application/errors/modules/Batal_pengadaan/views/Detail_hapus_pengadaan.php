<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span>Persetujuan Release Complete</h2>
            </div>
            <form name="quotation-form" id="quotation-form" method="post" action="<?php echo base_url() ?>Hapus_pengadaan/submit">
                <input type="hidden" id="ptm_number" name="ptm_number" value="<?php echo $ptm_number ?>">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Data Pengadaan</div>
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-4"><strong>Creator</strong></td>
                                    <td><?php echo $ptm_detail['PTM_REQUESTER_NAME'];?></td>
                                </tr>
                                <tr>
                                    <td><strong>No Subpratender</strong></td>
                                    <td><?php echo $ptm_detail['PTM_SUBPRATENDER'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Deskripsi Pengadaan</strong></td>
                                    <td><?php echo $ptm_detail['PTM_SUBJECT_OF_WORK'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td><?php echo $ptm_detail['PROCESS_NAME'] ?></td>
                                </tr>
                                <?php if ($ptp != null): ?>
                                <tr>
                                    <td><strong>Metode Pengadaan</strong></td>
                                    <td><?php echo $ptp['PTP_JUSTIFICATION'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Metode Penawaran</strong></td>
                                    <td><?php echo $ptp['PTP_IS_ITEMIZE'] == 1 ? 'Itemize' : 'Paket' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Sistem Sampul</strong></td>
                                    <td><?php echo $ptp['PTP_EVALUATION_METHOD'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Sistem Peringatan pada Penawaran</strong></td>
                                    <td>
                                        <?php echo $ptp['PTP_WARNING'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Prosentase Batas Penawaran ECE</strong></td>
                                    <td>
                                        <div class="input-group col-xs-4">
                                            <?php echo $ptp['PTP_BATAS_PENAWARAN'] ?> %
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Sistem Peringatan pada Negosiasi</strong></td>
                                    <td>
                                        <?php echo $ptp['PTP_WARNING_NEGO'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Prosentase Batas Nego ECE</strong></td>
                                    <td>
                                        <div class="input-group col-xs-4">
                                            <?php echo $ptp['PTP_BATAS_NEGO'] ?> %
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Template Evaluasi</strong></td>
                                    <td><?php echo $ptp['EVT_NAME'] ?></td>
                                </tr>
                                <!-- <tr>
                                    <td><strong>Keterangan Tambahan</strong></td>
                                    <td><?php echo $ptp['EVT_DESCRIPTION'] ?></td>
                                </tr> -->
                                <tr>
                                    <td><strong>RFQ Date</strong></td>
                                    <td>
                                        <?php echo oracledate(oraclestrtotime($ptp['PTP_REG_OPENING_DATE'])) ?>                                    
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Quotation Deadline</strong></td>
                                    <td>
                                        <?php echo oracledate(oraclestrtotime($ptp['PTP_REG_CLOSING_DATE'])) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Aanwijing</strong></td>
                                    <td>
                                        <?php echo oracledate(oraclestrtotime($ptp['PTP_PREBID_DATE'])) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Lokasi Aanwijing</strong></td>
                                    <td><?php echo $ptp['PTP_PREBID_LOCATION'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Term of Delivery</strong></td>
                                    <td><?php echo $ptp['PTP_TERM_DELIVERY'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Term of Payment</strong></td>
                                    <td><?php echo $ptp['PTP_TERM_PAYMENT'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Delivery Date</strong></td>
                                    <td>
                                        <?php echo oracledate(oraclestrtotime($ptp['PTP_DELIVERY_DATE'])) ?>
                                    </td>
                                </tr>
                                <?php endif ?>
                            </table>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Item</div>
                            <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <th class="text-center">No</th>
                                    <th class="text-center">No PR</th>
                                    <th class="text-center">PR Item</th>
                                    <th class="text-center">Kode Material</th>
                                    <th>Nama Material</th>
                                    <th class="text-center">Mat Group</th>
                                    <th class="text-center">Unit</th>
                                    <th class="text-center">Jumlah Awal</th>
                                    <th class="text-center">Jumlah Baru</th>
                                    <th class="text-center">PO Qty</th>
                                    <th class="text-center">PR Qty</th>
                                    <th class="text-center">Harga</th>
                                </thead>
                                <tbody id="items_table">
                                    <?php $no = 0; foreach ($tit as $val): ?>
                                    <tr>
                                        <td class="text-center"><?php echo ($no + 1) ?></td>
                                        <td class="text-center"><?php echo $val['PPI_PRNO'] ?></td>
                                        <td class="text-center"><?php echo $val['PPI_PRITEM'] ?></td>
                                        <td class="text-center"><?php echo $val['PPI_NOMAT'] ?></td>
                                        <td><?php echo $val['PPI_DECMAT'] ?></td>
                                        <td class="text-center"><?php echo $val['PPI_MATGROUP'] ?></td>
                                        <td class="text-center"><?php echo $val['PPI_UOM'] ?></td>
                                        <td class="text-center"><?php echo $val['PPI_QUANTOPEN'] ?></td>
                                        <td class="text-center"><?php echo $val['TIT_QUANTITY'] ?></td>
                                        <td class="text-center"><?php echo $val['PPI_POQUANTITY'] ?></td>
                                        <td class="text-center"><?php echo $val['PPI_PRQUANTITY'] ?></td>
                                        <td class="text-center"><?php echo $val['TIT_PRICE'] ?></td>
                                    </tr>
                                    <?php $no++; endforeach ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <?php echo $dokumen_pr ?>
                        <?php echo $this->snippet->assignment($ptm_number) ?><?php echo $ptm_comment ?>
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <button type="submit" class="main_button color6 small_btn">Batal</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
