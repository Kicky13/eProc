<!-- <div class="panel panel-default">
    <div class="panel-heading">
        Dokumen PR
    </div>
    <?php if (!empty($docs)): ?>
    <table class="table table-hover">
        <thead>
            <th class="text-center col-md-1">No</th>
            <th>PR no</th>
            <th>Jenis</th>
            <th>Deskripsi</th>
            <th>File</th>
        </thead>
        <tbody id="items_table">
            <?php $no = 0; foreach ($docs as $val): ?>
            <tr>
                <td class="text-center"><?php echo ($no + 1) ?></td>
                <td><?php echo $val['PPD_PRNO'] ?></td>
                <td><?php echo $val['PDC_NAME'] ?></td>
                <td><?php echo $val['PPD_DESCRIPTION'] ?></td>
                <td><a href="<?php echo base_url(UPLOAD_PATH.'ppm_document/' . $val['PPD_FILE_NAME']) ?>" target="_blank">Download</a></td>
            </tr>
            <?php $no++; endforeach ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="panel-body">
        Tidak ada dokumen tersedia
    </div>
    <?php endif ?>
</div> -->
<div class="panel panel-default">
    <?php if ($user_vendor == ''){ ?>
    <div class="panel-heading">
        Detail Jasa
    </div>
    <?php if (!empty($service)): ?>
    <div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <th class="text-center col-md-1">No</th>
            <th>Line No</th>
            <th>Service No</th>
            <th>Short Text</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Gross Price</th>
            <th>Net Value</th>
        </thead>
        <tbody id="items_table">
            <?php $no = 0; foreach ($service as $val): ?>
            <tr>
                <td class="text-center"><?php echo ($no + 1) ?></td>
                <td><?php echo $val['EXTROW'] ?></td>
                <td><?php echo $val['SRVPOS'] ?></td>
                <td><?php echo $val['KTEXT1'] ?></td>
                <td><?php echo $val['MENGE'] ?></td>
                <td><?php echo $val['MEINS'] == '10' ? 'D' : $val['MEINS'] ?></td>
                <td class="text-right"><?php echo number_format($val['TBTWR'] * 100) ?></td>
                <td class="text-right"><?php echo number_format($val['NETWR'] * 100) ?></td>
            </tr>
            <?php $no++; endforeach ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total</td>
                <td class="text-right"><?php echo number_format($service[0]['PPI_NETPRICE'] * 100) ?></td>
            </tr>
        </tbody>
    </table>
    </div>
    <?php else: ?>
    <div class="panel-body">
        Tidak ada detail jasa
    </div>
    <?php endif ?>
    <?php }else{?>
        <div class="panel-body">
            <!-- kosong untuk vendor -->
        </div>
    <?php }?>
</div>