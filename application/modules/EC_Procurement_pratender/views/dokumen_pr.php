<div class="panel panel-default">
    <div class="panel-heading">
        <?php if($dokumen): ?>
            <?php echo $dokumen[0]['PPI_NOMAT'].' '.$dokumen[0]['PPI_DECMAT']; ?>
        <?php endif; ?>
    </div>
    <table class="table table-hover">
        <thead>
            <th class="text-center">No</th>
            <th>Kategori</th>
            <th class="text-center">Nama</th>
        </thead>
        <tbody>
            <?php if($dokumen): ?>
                <?php $no = 1; foreach ($dokumen as $val): ?>
                    <tr>
                        <td class="text-center"><?php echo $no++ ?></td>
                        <td><?php echo $val['PDC_NAME']; ?></td>
                        <td class="text-center"><a href="<?php echo base_url('Procurement_sap'); ?>/viewDok/<?php echo $val['PPD_FILE_NAME']; ?>" target="_blank"><span class="glyphicon glyphicon-file"></span> <?php echo $val['PPD_DESCRIPTION']; ?></a></td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Tidak ada dokumen PR.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>