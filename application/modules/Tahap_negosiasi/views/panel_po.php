<div class="panel panel-default">
    <div class="panel-heading">
        PO
    </div>
    <div class="panel-body" style="width: 100%; overflow-x: auto;">
        <table class="table table-striped">
             <thead>
                <tr>
                    <?php foreach ($tits as $val) : ?>
                        <th colspan="4" class="text-center"><span style="color:black"><?php echo $val['PPI_ID']; ?></span></th>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <?php foreach ($tits as $val) : ?>
                        <th class="text-center">Kode</th>
                        <th class="text-center">No PO</th>
                        <th class="text-center">Nilai</th>
                        <th class="text-center">Tanggal</th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php foreach ($tits as $val) : ?>
                        <td class="text-center"><?php echo $val['PPI_NOMAT']; ?></td>
                        <td class="text-center"><?php echo $val['NO_PO']; ?></td>
                        <td class="text-center"><?php echo number_format($val['NETPR']); ?></td>
                        <td class="text-center"><?php echo $val['TGL_PO']; ?></td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>