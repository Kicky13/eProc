<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title; ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php echo $detail_ptm ?>
                    <?php echo $dokumen_pr ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Penawaran
                        </div>
                        <table class="table table-hover">
                            <tr>
                                <td class=" col-md-3">Surat</td>
                                <td class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-4">
                                        <?php  
                                            if($pqm_id != null) :
                                                if($pqm['FILE_SURAT'] != null){
                                        ?>
                                            <input type="hidden" class="delete" name="deletefilesurat" value="0">
                                            <a href="<?php echo base_url('Quotation'); ?>/viewDok/<?php echo $pqm['FILE_SURAT']; ?>" class="previousfile" target="_blank" >
                                                File Exist
                                            </a>
                                        <?php } else { ?>
                                            Tidak ada File
                                        <?php } ?>
                                        </div>
                                        <div class="col-md-8">
                                            <?php echo $pqm['PQM_NUMBER'] ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php foreach (array('penawaran', 'pelaksanaan', 'pemeliharaan') as $jam): ?>
                                <?php if ($ptp['PTP_PERSEN_'.strtoupper($jam)] != ''): ?>
                                <tr>
                                    <td class="">Jaminan <?php echo ucfirst($jam) ?> <?php echo $ptp['PTP_PERSEN_'.strtoupper($jam)] ?>%</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <?php if ($pqm_id != null && !empty($pqm['PQM_FILE_'.strtoupper($jam)])): ?>
                                                    <input type="hidden" class="delete" name="deletejaminan[<?php echo strtoupper($jam) ?>] ?>]" value="0">
                                                    <a href="<?php echo base_url('Quotation'); ?>/viewDok/<?php echo $pqm['PQM_FILE_'.strtoupper($jam)]; ?>" class="previousfile" target="_blank" >
                                                        File Exist
                                                    </a>
                                                    <a href="#!" onclick="deletefile(this)" class="previousfile"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                                <?php else: ?>
                                                    Tidak ada file
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endif ?>
                            <?php endforeach ?>
                            <tr>
                                <td class="">Kandungan Lokal</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <?php echo $pqm_id == null ? '' : $pqm['PQM_LOCAL_CONTENT'].' %' ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="">Waktu Pengiriman</td>
                                <td>
                                    <?php if($pqm_id != null) : ?>
                                        <?php echo $pqm['PQM_DELIVERY_TIME'] ?>
                                        <?php echo $pqm['PQM_DELIVERY_UNIT'] == 1 ? 'HARI' : '' ?>
                                        <?php echo $pqm['PQM_DELIVERY_UNIT'] == 2 ? 'BULAN' : '' ?>
                                        <?php echo $pqm['PQM_DELIVERY_UNIT'] == 3 ? 'Minggu' : '' ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="" title="Tanggal validity harga">Berlaku Hingga</td>
                                <td>
                                    <?php echo $pqm_id == null ? '' : date('Y-m-d', oraclestrtotime($pqm['PQM_VALID_THRU'])) ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="">Catatan</td>
                                <td><?php echo $pqm_id == null ? '' : $pqm['PQM_NOTES'] ?></td>
                            </tr>
                            <tr class="hidden">
                                <td class="">Inco Term</td>
                                <td>
                                    <select name="pqm_incoterm" id="pqm_incoterm">
                                        <option value="1">FRC</option>
                                        <option value="2">Dunno..</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Masukkan Penawaran Item Komersial</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <th title="Centang untuk memilih item yang ditawarkan">No</th>
                                        <th>Kode</th>
                                        <th>Deskripsi</th>
                                        <th>Jumlah</th>
                                        <th>UoM</th>
                                        <th>Spesifikasi</th>
                                        <th class="<?php echo $ptp['PTP_EVALUATION_METHOD_ORI'] == 3 ? "hidden" : "" ?>">Harga Satuan</th>
                                        <th class="<?php echo $ptp['PTP_EVALUATION_METHOD_ORI'] == 3 ? "hidden" : "" ?>" nowrap>Sub Total</th>
                                        <th class="<?php echo $ptp['PTP_EVALUATION_METHOD_ORI'] == 3 ? "hidden" : "" ?>">Currency</th>
                                    </thead>
                                    <tbody id="itemtable">
                                        <?php $num=0;foreach ($tits as $row){ ?>
                                        <!--?php $thispqi = (isset($pqi[$row['TIT_ID']])) ? $pqi[$row['TIT_ID']] : null; ?-->
                                        <?php if (isset($pqi[$row['TIT_ID']])) { $thispqi = $pqi[$row['TIT_ID']]; ?>
                                        <tr id="tritem<?php echo $row['TIT_ID']; ?>" class="tritem">
                                            <td>
                                                <?php $checked = (($pqm_id == null) || ($thispqi != null)) ? 'checked' : ''; ?>
                                                    <input type="checkbox" name="check[]" class="cekitem <?php echo $ptp['PTP_IS_ITEMIZE'] == 0 ? 'hidden' : '' ?>" value="<?php echo $row['TIT_ID'] ?>" <?php echo $checked ?>>
                                            </td>
                                            <td>
                                                <?php echo $row['PPI_NOMAT']; ?>
                                                <input name="ptqi[<?php echo $row['TIT_ID'] ?>][tit_id]" class="hidden tit_id" value="<?php echo $row['TIT_ID']; ?>">
                                                <input name="ptqi[<?php echo $row['TIT_ID'] ?>][pqi_id]" class="hidden pqi_id" value="<?php echo $thispqi['PQI_ID']; ?>">
                                                <input type="hidden" class="PPI_NOMAT" value="<?php echo $row['PPI_NOMAT']; ?>">
                                                <input type="hidden" class="PPI_ID" value="<?php echo $row['PPI_ID']; //$ptm_detail['IS_JASA']==1? $row['PPI_ID_ORI']: $row['PPI_ID']; ?>">
                                                <input type="hidden" class="cek_dordor" value="false">
                                                <input type="hidden" class="cek_warning">
                                            </td>
                                            <td class="open-material">
                                                <a href="#!"><?php echo $row['PPI_DECMAT']; ?></a>
                                            </td>
                                            <td>
                                                <?php if ($is_itemize == "1"):?>
                                                    <span class="text-center"><?php echo $row['TIT_QUANTITY'] ?></span>
                                                    <input type="hidden" name="qty[<?php echo $row['TIT_ID']; ?>]" value="<?php echo $row['TIT_QUANTITY'] ?>" class="pqi_quan text-center qtywow col-xs-12">
                                                <?php else: ?>
                                                    <span><?php echo $row['TIT_QUANTITY'] ?></span>
                                                    <input type="hidden" name="qty[<?php echo $row['TIT_ID']; ?>]" value="<?php echo $row['TIT_QUANTITY'] ?>" class="pqi_quan text-center qtywow col-xs-12">
                                                <?php endif ?>
                                                <input type="hidden" class="defprice" value="<?php echo $row['TIT_QUANTITY'] ?>">
                                            </td>
                                            <td>
                                                <span><?php echo $row['PPI_UOM'] == '10' ? 'D' : $row['PPI_UOM'] ?></span>
                                            </td>
                                            <td>
                                                <?php echo $thispqi['PQI_DESCRIPTION'] ?>
                                            </td>
                                            <td class="<?php echo $ptp['PTP_EVALUATION_METHOD_ORI'] == 3 ? "hidden" : "" ?>">
                                                <div class="pqi_price" value="<?php echo $thispqi['PQI_PRICE'] ?>" align="center"><?php echo number_format($thispqi['PQI_PRICE']); ?></div>
                                            </td>
                                            <td class="<?php echo $ptp['PTP_EVALUATION_METHOD_ORI'] == 3 ? "hidden" : "" ?> text-right">
                                                <span class="subtot hidden">0</span><span class="subtot_tampil">0</span>
                                            </td>
                                            <td class="<?php echo $ptp['PTP_EVALUATION_METHOD_ORI'] == 3 ? "hidden" : "" ?>">
                                                <div align="center"><?php echo $ptm_detail['PTM_CURR']; ?></div>
                                            </td>
                                        </tr>
                                        <?php }} ?>
                                        <input type="hidden" id="sum_tech_row" name="sum_tech_row" value="<?php echo $num ?>">
                                    </tbody>
                                    <tfoot>
                                        <input type="hidden" id="ptp_ev_met" value="<?php echo $ptp['PTP_EVALUATION_METHOD']; ?>"/>
                                        <?php if($ptp['PTP_EVALUATION_METHOD'] != "2 Tahap 2 Sampul"){ ?>
                                                <tr>
                                                    <td colspan="7" class="text-right"><strong>Total Sebelum PPN</strong></td>
                                                    <td colspan="2" class="text-right"><strong id="total_before_ppn">0</strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7" class="text-right"><strong>Total Sesudah PPN</strong></td>
                                                    <td colspan="2" class="text-right"><strong id="total_after_ppn">0</strong></td>
                                                </tr>
                                        <?php } else{ ?>
                                                <tr>
                                                    <td colspan="7" class="text-right hidden"><strong>Total Sebelum PPN</strong></td>
                                                    <td colspan="2" class="text-right hidden"><strong id="total_before_ppn">0</strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7" class="text-right hidden"><strong>Total Sesudah PPN</strong></td>
                                                    <td colspan="2" class="text-right hidden"><strong id="total_after_ppn">0</strong></td>
                                                </tr>
                                        <?php }?>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">File Penawaran Harga</div>
                        <table class="table table-hover">
                            <tr>
                                <td class="col-md-4 form-required"><strong>File Upload</strong></td>
                                <td id="fileView">
                                    <?php if($vendor_data[0]['FILE_HARGA']): ?>
                                        <a href="<?php echo base_url('Additional_document'); ?>/viewDok/<?php echo $vendor_data[0]['FILE_HARGA']; ?>" class="previousfile" target="_blank" >File Exist</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="panel-group" id="history_pesan" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                            <!-- <div class="panel-heading" id="headingOne" role="button" data-toggle="collapse" data-parent="#history_pesan" href="#pesanCollapse" aria-expanded="true" aria-controls="collapseOne"> -->
                                <h4 class="panel-title">History Klarifikasi Teknis dan Harga</h4>
                            </div>
                            <!-- <div id="pesanCollapse" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne"> -->
                                <div class="panel-body">
                                    <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal/Jam</th>
                                                <th>Dari</th>
                                                <th>Untuk</th>
                                                <th>Pesan</th>
                                                <th>file</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1; foreach ($pesan as $val): ?>
                                            <input type="hidden" id="ptm_status" value="<?php echo $val['STATUS_PROSES'] ?>">
                                            <input type="hidden" id="user_id" value="<?php echo $val['USER_ID'] ?>">  
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo betteroracledate(oraclestrtotime($val['TGL'])); ?></td>
                                                <td><?php echo $val['STATUS']=='SENT'?$val['FULLNAME']:$val['VENDOR_NAME']; ?></td>
                                                <td><?php echo $val['STATUS']=='REPLAY'?$val['FULLNAME']:$val['VENDOR_NAME']; ?></td>
                                                <td><?php echo $val['PESAN']; ?></td>
                                                <td>
                                                    <?php if (!empty($val['FILE_UPLOAD'])): ?>
                                                        <a href="<?php echo base_url('Evaluasi_penawaran'); ?>/viewDok/<?php echo $val['FILE_UPLOAD']; ?>" target="_blank"><span class="glyphicon glyphicon-file"></span></a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                                <!-- <div class="panel-footer">
                                    <a role="button" data-toggle="collapse" data-parent="#history_pesan" href="#pesanCollapse" aria-expanded="true" aria-controls="collapseOne">Tutup</a>
                                </div> -->
                            <!-- </div> -->
                        </div>
                    </div>
                    <input type="hidden" id="ptm_number" value="<?php echo $ptm ?>">
                    <div class="panel panel-default">
                        <div class="panel-heading">Klarifikasi Teknis dan Harga</div>
                        <table class="table">
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
                    <div class="well well-sm text-center">
                        <a href="<?php echo base_url('Proc_chat_vendor') ?>" class="main_button color7 small_btn">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="detail-material">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detail Material</h4>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>