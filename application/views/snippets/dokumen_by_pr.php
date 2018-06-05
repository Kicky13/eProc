<div class="panel panel-default">
    <div class="panel-heading">
        <?php if ($vendor): ?>
            Dokumen PR
        <?php else: ?>
            Dokumen PR
        <?php endif ?>
    </div>
    <div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <th>Kategori</th>
            <th>Deskripsi</th>
            <th>File</th>
            <th>Tanggal</th>
            <th>Uploader</th>
        </thead>
        <tbody id="items_table">
            <?php $no = 0; foreach ($items as $item): ?>
            <?php if (count($itemdoc[$item['PPI_ID']]) <= 0): ?>
                <tr>
                    <td colspan="5">Tidak ada item</td>
                </tr>
            <?php else: ?>
            <?php foreach ($itemdoc[$item['PPI_ID']] as $val): ?>
                <tr>
                    <td><?php echo $val['PDC_NAME'] ?></td>
                    <td><?php echo $val['PPD_DESCRIPTION'] ?></td>
                    <td><a href="<?php echo base_url('Procurement_sap') ?>/viewDok/<?php echo $val['PPD_FILE_NAME']; ?>" target="_blank">Download</a></td>
                    <td><?php echo $val['PPD_CREATED_AT'] ?></td>
                    <td><?php echo $val['PPD_CREATED_BY'] ?></td>
                </tr>
            <?php endforeach ?>
            <?php endif ?>
            <?php $no++; endforeach ?>
        </tbody>
    </table>
    </div>
</div>