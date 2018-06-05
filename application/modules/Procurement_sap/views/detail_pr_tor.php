<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <?php if ($success): ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Success!</strong> Upload Dokumen Berhasil.
                        </div>
                    <?php endif ?>
                    <?php if ($warning): ?>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Warning!</strong> Tidak ada item yang dipilih.
                        </div>
                    <?php endif ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Detail PR</div>
                        <table class="table table-hover">
                            <tr>
                                <td class="col-md-2 text-right">Nomor PR</td>
                                <td id="prno"><?php echo $prno ?></td>
                                <td class="col-md-2 text-right">Requestioner</td>
                                <td id="requestioner"><?php echo isset($cctr[$pr['PPR_REQUESTIONER']]) ? $cctr[$pr['PPR_REQUESTIONER']]['LONG_DESC'] : $pr['PPR_REQUESTIONER'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-right">Tipe Dokumen</td>
                                <td id="doctype"><?php echo $pr['PPR_DOCTYPE'] ?> <?php echo $doctype['DESC'] ?></td>
                                <td class="col-md-2 text-right">Plant</td>
                                <td id="plant"><?php echo $pr['PPR_PLANT'] ?> <?php echo $plant['PLANT_NAME'] ?></td>
                            </tr>
                        </table>
                    </div>

                    <?php if (count($verif) > 0): ?>
                    <div class="panel panel-danger">
                        <div class="panel-heading">Catatan Reject Dokumen</div>
                        <table class="table table-hover">
                            <tr>
                                <td class="text-center">PR No</td>
                                <td class="text-center">PR Item</td>
                                <td class="text-left">Note</td>
                                <td class="text-center">Date</td>
                            </tr>
                            <?php foreach ($verif as $val): ?>
                            <tr>
                                <td class="text-center"><?php echo $val['PIV_PRNO'] ?></td>
                                <td class="text-center"><?php echo $val['PIV_PRITEM'] ?></td>
                                <td class="text-left"><?php echo $val['PIV_NOTE'] ?></td>
                                <td class="text-center"><?php echo betteroracledate(oraclestrtotime($val['PPV_DATE'])) ?></td>
                            </tr>
                            <?php endforeach ?>
                        </table>
                    </div>
                    <?php endif ?>

                    <?php echo form_open_multipart('Procurement_sap/store_tor/' . $prno); ?>
                    <input id="doc_cat" type="hidden" value="<?php echo $pr['PPR_DOC_CAT'] ?>">
                    <div class="panel panel-default">
                        <div class="panel-heading">Dokumen Pengadaan</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="document_file">Kategori</label>
                                <select name="tipe" class="form-control" id="tipe_select"></select>
                            </div>
                            <div class="form-group">
                                <label for="document_file">Deskripsi</label>
                                <textarea name="desc" class="form-control" id="desc"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="document_file">File</label>
                                <input type="file" class="form-control" id="file_input" name="file" placeholder="Pilih file..">
                            </div>
                            <div class="form-group">
                                <label for="document_file">Pilih Item</label>
                                <div class="panel panel-default">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <th class="text-center" nowrap><input type="checkbox" id="checkAll" title="pilih semua"></th>
                                            <th class="text-center" nowrap>No</th>
                                            <th class="text-center" nowrap>PR Item</th>
                                            <!-- <th class="text-center" nowrap>Plant</th> -->
                                            <th class="text-center" nowrap>Kode Material</th>
                                            <th nowrap>Short Text</th>
                                            <th class="text-center" nowrap>Mat Group</th>
                                            <th class="text-center" nowrap>Unit</th>
                                            <th class="text-center" nowrap>PR Qty</th>
                                            <!-- <th class="text-center" nowrap>Open Qty</th> -->
                                            <!-- <th class="text-center" nowrap>PO Qty</th>
                                            <th class="text-center" nowrap><span title="On Hand">OH</span></th>
                                            <th class="text-center" nowrap>Tender Qty</th> -->
                                            <th class="text-center" nowrap>ECE</th>
                                            <th class="text-center" nowrap>Value</th>

                                            <!-- <th class="text-center" nowrap>Rata GI</th>
                                            <th class="text-center" nowrap><span title="Maximum Good Issued">Max GI</span></th>
                                            <th class="text-center" nowrap><span title="Last Good Issued">Last GI</th>
                                            <th class="text-center" nowrap>Post Date</th>
                                            <th class="text-center" nowrap><span title="Maximum Good Issued Year">Max GI year</span></th>
                                            <th class="text-center" nowrap><span title="Maximum Year Good Issued">Max year GI</span></th> -->
                                        </thead>
                                        <tbody id="items_table">
                                        <?php $i = 1; foreach ($items as $val): ?>
                                            <tr>
                                                <td class="text-center"><input type="checkbox" class="check-success chek_all" name="items[]" value="<?php echo $val['PPI_ID'] ?>"></td>
                                                <td class="text-center"><?php echo $i ?></td>
                                                <td class="text-center pritem"><?php echo $val['PPI_PRITEM'] ?></td>
                                                <!-- <td class="text-center plant"><?php echo $pr['PPR_PLANT'] ?></td> -->
                                                <td class="text-center nomat"><?php echo $val['PPI_NOMAT'] ?></td>
                                                <td nowrap>
                                                    <a href="#!" class="decmat" onclick="open_dokumen(this)" data-ppi="<?php echo $val['PPI_ID'] ?>"><?php echo $val['PPI_DECMAT'] ?></a>
                                                </td>
                                                <td class="text-left matgroup" nowrap><?php echo $val['PPI_MATGROUP'] ?> <?php echo $val['matgrp']['MAT_GROUP_NAME'] ?></td>
                                                <td class="text-center uom"><?php echo $val['PPI_UOM'] ?></td>
                                                <td class="text-center prquantity"><?php echo $val['PPI_PRQUANTITY'] ?></td>
                                                <!-- <td class="text-center quantopen"><?php echo $val['PPI_QUANTOPEN'] - $val['PPI_QTY_USED'] ?></td>
                                                <td class="text-center poquantity"><?php echo $val['PPI_PRQUANTITY'] - $val['PPI_QUANTOPEN'] ?></td>
                                                <td class="text-center handquantity"><?php echo $val['PPI_HANDQUANTITY'] ?></td>
                                                <td class="text-center qty_used"><?php echo $val['PPI_QTY_USED'] ?></td> -->
                                                <td class="text-center netprice"><?php echo number_format($val['PPI_NETPRICE'] * 100) ?></td>
                                                <td class="text-center netprice"><?php echo number_format(intval($val['PPI_NETPRICE'] * 100) * intval($val['PPI_PRQUANTITY'])); ?></td>
                                                <!-- <td class="text-center ratagi"><?php echo $val['PPI_RATAGI'] ?></td>
                                                <td class="text-center maxgi"><?php echo $val['PPI_MAXGI'] ?></td>
                                                <td class="text-center lastgi"><?php echo $val['PPI_LASTGI'] ?></td>
                                                <td class="text-center postdate"><?php echo $val['PPI_POSTDATE'] ?></td>
                                                <td class="text-center max_gi_year"><?php echo $val['PPI_MAX_GI_YEAR'] ?></td>
                                                <td class="text-center max_year_gi"><?php echo $val['PPI_MAX_YEAR_GI'] ?></td> -->
                                            </tr>
                                        <?php $i++; endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                            <!-- <div class="panel-body text-left"> -->
                            <button id="submit-form" type="submit" class="main_button color6 small_btn">Upload</button>
                            <!-- </div> -->
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                
                    <div class="panel panel-default">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <th>PR Item</th>
                                <th>Material</th>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                                <th>File</th>
                                <th>Tanggal</th>
                                <th>User</th>
                                <!-- <th>Status Verifikasi</th> -->
                            </thead>
                            <tbody>
                                <?php if (count($docs) <= 0): ?>
                                    <tr>
                                        <td colspan="7">Belum ada dokumen. Silahkan upload dokumen.</td>
                                    </tr>
                                <?php endif ?>
                                <?php foreach ($docs as $val): ?>
                                <tr>
                                    <td><?php echo $itemid[$val['PPI_ID']]['PPI_PRITEM'] ?></td>
                                    <td><?php echo $itemid[$val['PPI_ID']]['PPI_DECMAT'] ?></td>
                                    <td><?php echo $val['PDC_NAME'] ?></td>
                                    <td><?php echo $val['PPD_DESCRIPTION'] ?></td>
                                    <td><a href="<?php echo base_url('Procurement_sap') ?>/viewDok/<?php echo $val['PPD_FILE_NAME']; ?>" target="_blank">Download</a></td>
                                    <td><?php echo $val['PPD_CREATED_AT'] ?></td>
                                    <td><?php echo $val['PPD_CREATED_BY'] ?></td>
                                    <!-- <td>
                                        <?php if ($val['PPD_STATUS'] == ''): ?>
                                            <button type="button" class="main_button color2 small_btn acpt_doc" value="<?php echo $val['PPD_ID'] ?>">Terima</button>
                                            <button type="button" class="main_button color7 small_btn rejc_doc" value="<?php echo $val['PPD_ID'] ?>">Tolak</button>
                                        <?php elseif ($val['PPD_STATUS'] == '0'): ?>
                                            Ditolak
                                        <?php elseif ($val['PPD_STATUS'] == '1'): ?>
                                            Diterima
                                        <?php endif ?>
                                    </td> -->
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                    <?php echo form_open_multipart('Procurement_sap/store_tor_submit/' . $prno,array('method' => 'POST','class' => 'submit')); ?>
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <a href="<?php echo base_url('Procurement_sap/store_tor') ?>" class="main_button color7 small_btn">Simpan Draft</a>
                            <?php if (count($docs) > 0): ?>
                            <input class="subjudul" type="hidden" value="Pastikan dokumen yang Anda upload benar"></input>
                            <?php else: ?>
                            <input class="subjudul" type="hidden" value="Submit PR tanpa dokumen"></input>
                            <?php endif ?>
                            <button type="submit" class="formsubmit main_button color6 small_btn">Submit</button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal_dokumen">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">Informasi Tambahan</div>
            <div class="modal-body">
                <div class="modal_jasa"></div>
                <div class="modal_longtext"></div>
            </div>
        </div>
    </div>
</div>