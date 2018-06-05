
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <?php echo form_open_multipart(base_url() . 'Proc_assign_pengadaan/assign', array('method' => 'POST','class' => 'submit')); ?>
            <input type="hidden" id="ptm_number" name="ptm_number" value="<?php echo $ptm['PTM_NUMBER'] ?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Assign Process</div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-4 form-required">Assign to</td>
                                    <td>
                                        <select name="assign" id="assign">
                                            <option disabled selected value>Pilih user</option>
                                            <?php foreach ($emp as $val): ?>
                                            <option value="<?php echo $val['ID'] ?>" data-data="<?php echo html_escape(json_encode($val)) ?>"> <?php echo $val['FULLNAME'] ?>
                                            <?php endforeach ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Informasi Perencanaan</div>
                        <table class="table table-hover">
                            <tr>
                                <td class="col-md-4">Creator</td>
                                <td><?php echo $ptm['PTM_REQUESTER_NAME'] ?></td>
                            </tr>
                            <!-- <tr>
                                <td>Biro / Unit</td>
                                <td><?php echo $this->session->userdata['POS_NAME'] ?></td>
                            </tr> -->
                            <tr>
                                <td>Nama Perencanaan</td>
                                <td>
                                    <?php echo $ptm['PTM_SUBJECT_OF_WORK']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Nomor Usulan Pratender</td>
                                <td>
                                    <?php echo $ptm['PTM_SUBPRATENDER']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Jenis Perencanaan</td>
                                <td>
                                    <?php if($ptm['IS_JASA'] == "0") echo "Barang"; else echo "Jasa"; ?>
                                </td>
                            </tr>
                            <?php if(!empty($ptp['PTP_UPLOAD_USULAN_VENDOR'])): ?>
                                <tr>
                                    <td>Upload Usulan Vendor</td>
                                    <td>
                                        <a href="<?php echo base_url('Monitoring_prc'); ?>/viewDok/<?php echo $ptp['PTP_UPLOAD_USULAN_VENDOR']; ?>" target="_blank" title='print usulan vendor'><span class="glyphicon glyphicon-print"></a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>

                    <?php echo $detail_item_ptm ?>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Dokumen PR
                        </div>
                        <?php if (count($dokumen) <= 0): ?>
                            <div class="panel-body">Tidak ada dokumen.</div>
                        <?php else: ?>
                        <table class="table table-hover">
                            <thead>
                                <th class="text-center col-md-1">No</th>
                                <th class="col-md-5">Nama Dokumen</th>
                                <th class="col-md-2">Tipe Dokumen</th>
                            </thead>
                            <tbody id="items_table">
                                <?php $no = 0; foreach ($dokumen as $item): ?>
                                <tr>
                                    <td class="text-center"><?php echo ($no + 1) ?></td>
                                    <td>
                                    <li style="list-style-type: none;">
                                        <a href="<?php echo base_url('Procurement_sap'); ?>/viewDok/<?php echo $item['nama']; ?>" target="_blank">
                                        <span class="glyphicon glyphicon-file"></span> <?php echo $item['PPD_DESCRIPTION']; ?></a>
                                    </li>
                                    </td>
                                    <td><?php echo $item['PDC_NAME']; ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="3">
                                    <ul>
                                        <?php foreach ($item['item'] as $key => $value): ?>
                                            <li>
                                                <?php echo $value['NOMAT'];?>
                                                <?php echo $value['DECMAT'];?>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                    </td>
                                </tr>
                                <?php $no++; endforeach ?>
                            </tbody>
                        </table>
                        <?php endif ?>
                    </div>
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">Metode Perencanaan</div>
                        <table class="table table-hover">
                            <tr>
                                <td class="col-md-3">Metode Perencanaan</td>
                                <td>
                                    <?php echo $ptp['PTP_JUSTIFICATION'] ?>
                                </td>
                            </tr>

                            <tr>
                                <td class="col-md-3">Sistem Peringatan pada Penawaran</td>
                                <td>
                                    <?php echo $ptp['PTP_WARNING'] ?>
                                    <!-- <div class="row">
                                        <div class="col-md-4">
                                            <select name="ptp_warning">
                                                <option value="1" <?php echo $ptp['PTP_WARNING'] == 1 ? 'selected' : '' ?>>Tidak ada pesan</option>
                                                <option value="2" <?php echo $ptp['PTP_WARNING'] == 2 ? 'selected' : '' ?>>Warning</option>
                                                <option value="3" <?php echo $ptp['PTP_WARNING'] == 3 ? 'selected' : '' ?>>Error</option>
                                            </select>
                                        </div>
                                    </div> -->
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Prosentase Batas Atas Penawaran ECE/HPS/OE</td>
                                <td>
                                    <?php if($ptp['PTP_BATAS_PENAWARAN']) echo $ptp['PTP_BATAS_PENAWARAN']; else echo '0'; echo '%' ?>
                                    <!-- <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input type="text" name="ptp_batas_penawaran_atas" class="form-control" value="<?php echo $ptp['PTP_BATAS_PENAWARAN'] ?>">
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div> -->
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Prosentase Batas Bawah Penawaran ECE/HPS/OE</td>
                                <td>
                                    <?php if($ptp['PTP_BAWAH_PENAWARAN']) echo $ptp['PTP_BAWAH_PENAWARAN']; else echo '0'; echo '%' ?>
                                    <!-- <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input type="text" name="ptp_batas_penawaran_bawah" class="form-control" value="<?php echo $ptp['PTP_BAWAH_PENAWARAN']; ?>">
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div> -->
                                </td>
                            </tr>
                        </table>
                    </div>
                    <?php echo $ptm_comment ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Komentar Anda</div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-6">Komentar</td>
                                    <td>
                                        <textarea maxlength="1000" name="comment" class="form-control" style="resize:vertical"></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <select class="harusmilih_publicjs" name="harus_pilih">
                                <option value="false_public"></option>
                                <option value="accept">Lanjut ke <?php echo $next_process['NAMA_BARU']; ?></option>
                                <option value="reject">Reject</option>
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

<script>
    $(document).ready(function() {
        /* Activate selectize */
        selectize_assign = null;
        if ($("#assign").length > 0) {
            $assign = $("#assign").selectize({
                render: {
                    option: function(item, escape) {
                        return '<div>' +
                            '<span>' +
                                escape(item.FULLNAME) +
                            '</span>' +
                            '<br><small class="text-muted"><strong>' + escape(item.COUNT) + '</strong> Current Job' +
                            '&nbsp;&nbsp;&nbsp;&nbsp;<strong>' + escape(item.COUNT_ASSIGN) + '</strong> Current Tender</small>' +
                        '</div>';
                    }
                },
            });
            selectize_assign = $assign[0].selectize;
        }
        //*/
    });
</script>