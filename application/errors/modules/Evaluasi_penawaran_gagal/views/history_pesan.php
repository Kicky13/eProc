<div class="panel-group" id="history_pesan" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <!-- <div class="panel-heading" id="headingOne" role="button" data-toggle="collapse" data-parent="#history_pesan" href="#pesanCollapse" aria-expanded="true" aria-controls="collapseOne"> -->
        <div class="panel-heading">
            <h4 class="panel-title">History Klarifikasi Penawaran Vendor</h4>
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
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach ($pesan as $val): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo betteroracledate(oraclestrtotime($val['TGL'])); ?></td>
                            <td><?php echo $val['STATUS']=='SENT'?$val['FULLNAME']:$val['VENDOR_NAME']; ?></td>
                            <td><?php echo $val['STATUS']=='REPLAY'?$val['FULLNAME']:$val['VENDOR_NAME']; ?></td>
                            <td><?php echo $val['PESAN']; ?></td>
                            <td><?php echo $val['STATUS']; ?>
                                <?php if (!empty($val['FILE_UPLOAD'])): ?>
                                    <a href="<?php echo base_url('Evaluasi_penawaran'); ?>/viewDok/<?php echo $val['FILE_UPLOAD']; ?>" target="_blank"><span class="glyphicon glyphicon-file"></span>
                                <?php endif; ?>
                            </td>
                            <?php if($balas): ?>
                                <?php if ($val['STATUS'] == 'REPLAY'): ?>
                                <td>
                                    <a style="cursor:pointer" class="main_button small_btn" title="balas pesan" onclick="replay(<?php echo $val['ID']; ?>)"><i class="ico-edit no_margin_right"></i></a>
                                </td>
                                <?php endif; ?>
                            <?php endif; ?>
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