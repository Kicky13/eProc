
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <?php echo form_open_multipart(base_url('Procurement_undang_harga/save_bidding'), array('method' => 'POST','class' => 'submit')); ?>
            <input type="hidden" name="ptm_number" id="ptm_number" value="<?php echo $ptm['PTM_NUMBER'] ?>">
            <div class="row">
                <div class="col-md-12">
                    <?php echo $detail_ptm_snip ?>
                    <?php echo $dokumen_pr ?>
                    <?php echo $vendor_ptm ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Batas Tanggal Memasukkan Penawaran Harga</div>
                        <table class="table">
                            <tr>
                                <td class="col-md-3">Batas</td>
                                <td>
                                    <div class="input-group date">
                                        <input type="text" id="batas_vendor_harga" name="batas_vendor_harga" class="form-control" value="<?php echo empty($ptm['BATAS_VENDOR_HARGA']) ? '' : betteroracledate(oraclestrtotime($ptm['BATAS_VENDOR_HARGA'])) ?>">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-th"></i>
                                        </span>
                                    </div>
                                </td>
                                <td class="col-md-4"></td>
                            </tr>
                        </table>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Catatan Untuk Vendor</div>
                        <table class="table">
                            <tr>
                                <td class="col-md-3">Note :</td>
                                <td>
                                    <textarea name="NOTE_UNTUK_VENDOR"><?php echo empty($ptm['NOTE_UNTUK_VENDOR']) ? '' : $ptm['NOTE_UNTUK_VENDOR'] ?></textarea>
                                </td>
                                <td class="col-md-4"></td>
                            </tr>
                        </table>
                    </div>
                    <?php echo $evaluasi ?>
                    <div id="history_pesan">
                        <?php echo $pesan; ?>
                    </div>
                    <?php echo $ptm_comment ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Komentar Anda</div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-6">Komentar</td>
                                    <td>
                                        <textarea maxlength="1000" name="ptc_comment" class="form-control" style="resize:vertical"></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <select name="next_process" id="next_process_select" class="harusmilih_publicjs">
                                    <option value="false_public"></option>
                                   <!--  <?php if ($can_continue): ?>
                                        <option value="1">Lanjut ke <?php echo $next_process['NAMA_BARU']; ?></option>
                                    <?php endif ?> -->
                                    <?php if ($ptm['PTM_STATUS'] == 19 && $ptm['PENAWARAN_KE'] != '' ) {?>
                                        <option value="4"><?php echo $next_process['nama'] ?></option>
                                    <?php } elseif ($can_continue) { ?>
                                         <option value="1">Lanjut ke <?php echo $next_process['NAMA_BARU']; ?></option>
                                    <?php } ?>
                                    <?php echo (isset($next_process['NAMA_BARU']) && $is_staff)?'<option value="0">Retender</option>':''; ?>
                                    
                                    <?php if($ptm['MASTER_ID']==11): ?>
                                        <option value="5">Re Evaluasi</option>
                                    <?php endif; ?>
                            </select>
                                <input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar"></input>
                                <button type="submit" class="main_button color7 small_btn milihtombol_publicjs" disabled>OK</button>

                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>

<div class="modal fade" id="modal_dokumen">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">Informasi Tambahan PR <span class="pr"></span></div>
            <div class="modal-body">
                <table class="table table-hover">
                    <thead>
                        <th>Pilih</th>
                        <th>Tipe</th>
                        <th>Nama</th>
                        <th>File</th>
                        <th>Tanggal</th>
                        <th>User</th>
                    </thead>
                    <tbody id="dokumentable">
                    </tbody>
                </table>
                <div class="panel panel-default">
                </div>
            </div>
        </div>
    </div>
</div>