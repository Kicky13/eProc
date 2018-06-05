<form action="<?php echo base_url() ?>Procurement_sap/store" method="post">
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Detail PR</div>
                        <table class="table table-hover">
                            <tr>
                                <td class="col-md-3 text-right">Nomor PR</td>
                                <td id="prno"><?php echo $prno ?></td>
                                <td class="text-right">Tanggal Release</td>
                                <td id="reldate"><?php echo date(bettertimeformat(), oraclestrtotime($pr['PPR_DATE_RELEASE'])) ?></td>
                            </tr>
                            <tr>
                                <td class="text-right">Tipe Dokumen</td>
                                <td id="doctype"><?php echo $pr['PPR_DOCTYPE'] ?> <?php echo $doctype['DESC'] ?></td>
                                <td class="text-right">Tanggal Submit</td>
                                <td id="reldate"><?php echo date(bettertimeformat(), oraclestrtotime($pr['DOC_UPLOAD_DATE'])) ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3 text-right">Requestioner</td>
                                <td id="requestioner"><?php echo isset($cctr[$pr['PPR_REQUESTIONER']]) ? $cctr[$pr['PPR_REQUESTIONER']]['LONG_DESC'] : $pr['PPR_REQUESTIONER'] ?></td>
                                <td class="col-md-3 text-right">Plant</td>
                                <td><?php echo $pr['PPR_PLANT'] ?> <?php echo $plant['PLANT_NAME'] ?></td>
                            </tr>
                        </table>
                        <input id="doc_cat" type="hidden" value="<?php echo $pr['PPR_DOC_CAT'] ?>">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Verifikasi Item (Approve untuk menandai item yang diverifikasi)</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <th>Aprrove</th>
                                        <th class="text-center" nowrap></th>
                                        <th class="text-center" nowrap>Usulan</th>
                                        <th class="text-center" nowrap>PR Item</th>
                                        <!-- <th class="text-center" nowrap>Plant</th> -->
                                        <?php if ($pr['PPR_DOC_CAT'] != '9'): ?>
                                        <th class="text-center" nowrap>Kode Material</th>
                                        <?php endif ?>
                                        <th nowrap>Short Text</th>
                                        <th class="text-left" nowrap>Mat Group</th>
                                        <th class="text-center" nowrap>Unit</th>
                                        <th class="text-center" nowrap>PR Qty</th>
                                        <th class="text-center" nowrap>Open Qty</th>
                                        <th class="text-center" nowrap>PO Qty</th>
                                        <th class="text-center" nowrap><span title="On Hand">OH</span></th>
                                        <th class="text-center" nowrap>Tender Qty</th>
                                        <th class="text-center" nowrap>ECE</th>
                                        <?php if ($pr['PPR_DOC_CAT'] != '9'): ?>
                                        <th class="text-center" nowrap>Rata GI</th>
                                        <th class="text-center" nowrap><span title="Maximum Good Issued">Max GI</span></th>
                                        <th class="text-center" nowrap><span title="Last Good Issued">Last GI</th>
                                        <th class="text-center" nowrap>Post Date</th>
                                        <th class="text-center" nowrap><span title="Maximum Good Issued Year">Max GI year</span></th>
                                        <th class="text-center" nowrap><span title="Maximum Year Good Issued">Max year GI</span></th>
                                        <?php endif ?>
                                    </thead>
                                    <tbody id="items_table">
                                    <?php $i = 1; foreach ($items as $val): ?>
                                        <tr>
                                            <td class="text-center"><input type="checkbox" class="check-success ppi_id" name="items[]" value="<?php echo $val['PPI_ID'] ?>" checked></td>
                                            <td class="text-center">
                                                <?php if($val['doc']) {?>
                                                    <a href="#!" onclick="dokumen_by_pr(this)" data-itemid="<?php echo $val['PPI_ID'] ?>"><i class="glyphicon glyphicon-file"></i></a>
                                                <?php } else {?>
                                                    <i class="glyphicon glyphicon-file"></i>
                                                <?php } ?>
                                            </td>
                                            <td class="text-center">
                                                <select name='metode[]'>
                                                    <option value='' selected></option>
                                                    <option value='PL'>PL</option>
                                                    <option value='RO'>RO</option>
                                                    <option value='SA'>SA</option>
                                                    <option value='OT'>OT</option>
                                                </select>
                                            </td>
                                            <td class="text-center pritem"><?php echo $val['PPI_PRITEM'] ?></td>
                                            <!-- <td class="text-center plant"></td> -->
                                            <?php if ($pr['PPR_DOC_CAT'] != '9'): ?>
                                            <td class="text-center nomat"><?php echo $val['PPI_NOMAT'] ?></td>
                                            <?php endif ?>
                                            <td nowrap><a href="#!" class="btn_history decmat" data-ppi="<?php echo $val['PPI_ID'] ?>"><?php echo $val['PPI_DECMAT'] ?></a></td>
                                            <td class="text-center matgroup" nowrap><?php echo $val['PPI_MATGROUP'] ?> <?php echo $val['matgrp']['MAT_GROUP_NAME'] ?></td>
                                            <td class="text-center uom"><?php echo $val['PPI_UOM'] ?></td>
                                            <td class="text-center prquantity"><?php echo $val['PPI_PRQUANTITY'] ?></td>
                                            <td class="text-center quantopen"><?php echo $val['PPI_QUANTOPEN'] - $val['PPI_QTY_USED'] ?></td>
                                            <td class="text-center poquantity"><?php echo $val['PPI_PRQUANTITY'] - $val['PPI_QUANTOPEN'] ?></td>
                                            <td class="text-center handquantity"><?php echo $val['PPI_HANDQUANTITY'] ?></td>
                                            <td class="text-center qty_used"><?php echo $val['PPI_QTY_USED'] ?></td>
                                            <td class="text-center netprice"><?php echo number_format($val['PPI_NETPRICE'] * 100) ?></td>
                                            <?php if ($pr['PPR_DOC_CAT'] != '9'): ?>
                                            <td class="text-center ratagi"><?php echo $val['PPI_RATAGI'] ?></td>
                                            <td class="text-center maxgi"><?php echo $val['PPI_MAXGI'] ?></td>
                                            <td class="text-center lastgi"><?php echo $val['PPI_LASTGI'] ?></td>
                                            <td class="text-center postdate"><?php echo $val['PPI_POSTDATE'] ?></td>
                                            <td class="text-center max_gi_year"><?php echo $val['PPI_MAX_GI_YEAR'] ?></td>
                                            <td class="text-center max_year_gi"><?php echo $val['PPI_MAX_YEAR_GI'] ?></td>
                                            <?php endif ?>
                                        </tr>
                                    <?php $i++; endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Komentar</div>
                        <table id="tablecomment" class="table table-hover">
                        </table>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <a href="<?php echo base_url(); ?>Procurement_sap" class="main_button color7 small_btn">Kembali</a>
                            <button id="submit-form" type="button" class="main_button color6 small_btn">Submit</button>
                        </div>
                    </div>
                </div>
                <!-- <button id="dummy">Click</button> -->
            </div>
        </div>
    </div>
</section>

    <div class="modal fade" id="modal-verifikasi">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Verifikasi Item</h4>
                </div>
                <div class="modal-body">
                    <p>Dari <span id="all"></span> item, ada <span id="bye"></span> item yang direject.</p>
                    <p>Jika ada salah satu item yang direject, PR yang bersangkutan dianggap <i>direject</i>.
                    Jika anda melanjutkan, maka <i>tidak akan bisa diubah lagi</i>.</p>
                    <p><strong>Apakah anda yakin akan <strong id="apakah"></strong> PR ini?</strong></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="prno" value="<?php echo $prno ?>">
                    <input type="hidden" name="ppr_doctype" value="<?php echo $pr['PPR_DOCTYPE'] ?>">
                    <input type="hidden" name="ppr_doc_cat" value="<?php echo $pr['PPR_DOC_CAT'] ?>">
                    <input type="hidden" name="ppr_del" value="<?php echo $pr['PPR_DEL'] ?>">
                    <input type="hidden" name="ppr_plant" value="<?php echo $pr['PPR_PLANT'] ?>">
                    <input type="hidden" name="ppr_porg" value="<?php echo $pr['PPR_PORG'] ?>">
                    <input type="hidden" id="isverify" name="isverify">
                    <button type="submit" class="main_button color1 small_btn">Ya</button>
                    <button type="button" class="main_button color7 small_btn close-modal">Tidak</a>
                </div>
            </div>
        </div>
    </div>

       <div class="modal fade" id="modal-verifikasi-cek">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Verifikasi Item</h4>
                </div>
                <div class="modal-body">
                    <!-- <p>Dari <span id="all"></span> item, ada <span id="bye"></span> item yang tidak diverifikasi.</p>
                    <p>Jika salah satu item saja tidak terverifikasi, PR yang bersangkutan dianggap <i>direject</i>.
                    Jika anda melanjutkan, maka <i>tidak akan bisa diubah lagi</i>.</p> -->
                    <p><strong>Apakah anda yakin akan <strong id="apakah"></strong>memproses PR ini?</strong></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="prno" value="<?php echo $prno ?>">
                    <input type="hidden" name="ppr_doctype" value="<?php echo $pr['PPR_DOCTYPE'] ?>">
                    <input type="hidden" name="ppr_doc_cat" value="<?php echo $pr['PPR_DOC_CAT'] ?>">
                    <input type="hidden" name="ppr_del" value="<?php echo $pr['PPR_DEL'] ?>">
                    <input type="hidden" name="ppr_plant" value="<?php echo $pr['PPR_PLANT'] ?>">
                    <input type="hidden" name="ppr_porg" value="<?php echo $pr['PPR_PORG'] ?>">
                    <!-- <input type="hidden" id="isverify" name="isverify"> -->
                    <button type="submit" class="main_button color1 small_btn">Ya</button>
                    <button type="button" class="main_button color7 small_btn close-modal">Tidak</a>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal fade" id="modal_history">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">History<span></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="history_material"></div>
                <div class="long_text"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_dokumen">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">Informasi Tambahan PR <span class="pr"></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="dokumen_by_pr">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">Dokumen PR.<span></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
