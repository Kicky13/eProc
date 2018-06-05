<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table class="table table-hover">
                                <thead>
                                    <th>Created At</th>
                                    <th>PRNO</th>
                                    <th>Material</th>
                                    <th>Vendor Name</th>
                                    <th>RFQ</th>
                                    <th>Quantity</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                </thead>
                                <tbody>
                                    <?php $total = 0; ?>
                                    <?php foreach ($winner as $val): ?>
                                    <tr>
                                        <td><?php echo str_replace('.000000', '', $val['PTW_CREATED_AT']) ?></td>
                                        <td><?php echo $val['PPI_PRNO'] ?></td>
                                        <td><?php echo $val['PPI_DECMAT'] ?></td>
                                        <td><?php echo $val['VENDOR_NAME'] ?></td>
                                        <td><?php echo $val['PTV_RFQ_NO'] ?></td>
                                        <td><?php echo $val['TIT_QUANTITY'] ?></td>
                                        <td><?php echo $val['PQI_PRICE'] ?></td>
                                        <td><?php echo $val['PQI_PRICE'] * $val['TIT_QUANTITY'] ?></td>
                                    </tr>
                                    <?php $total += $val['PQI_PRICE'] * $val['TIT_QUANTITY'] ?>
                                    <?php endforeach ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="7">Total</th>
                                        <th><strong><?php echo $total ?></strong></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <?php echo $ptm_comment ?>
                </div>
            </div>
        </div>
    </div>
</section>