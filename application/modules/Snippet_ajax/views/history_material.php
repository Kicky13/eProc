<table class="table table-hover">
    <tr>
        <td class="col-md-3 text-right">Kode Material</td>
        <td id="hist_nomat"><?php echo $item['PPI_NOMAT'] ?></td>
    </tr>
    <tr>
        <td class="col-md-3 text-right">Nama Material</td>
        <td id="hist_decmat"><?php echo $item['PPI_DECMAT'] ?></td>
    </tr>
    <tr>
        <td class="col-md-3 text-right">Plant</td>
        <td id="hist_plant"><?php echo $item['PPI_PLANT'] ?></td>
    </tr>
</table>
<div class="panel panel-default">
    <div class="panel-heading">History pada Material</div>
    <table class="table table-hover">
        <thead>
            <th class="text-center" nowrap>No</th>
            <th class="text-center" nowrap>Fiscal Year</th>
            <th class="text-center" nowrap>Quantity</th>
            <th class="text-center" nowrap>UOM</th>
        </thead>
        <tbody id="hist_list">
            <?php $no = 1; foreach ($history as $val): ?>
                <tr>
                    <td class="text-center"><?php echo $no++ ?></td>
                    <td class="text-center"><?php echo $val['GJAHR'] ?></td>
                    <td class="text-center"><?php echo $val['GSV01'] ?></td>
                    <td class="text-center"><?php echo $val['MEINS'] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>