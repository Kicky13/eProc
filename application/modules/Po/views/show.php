<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Detail PO</div>
                        <table class="table table-hover">
                            <tr>
                                <td class="col-md-2 text-center">Vendor Code</td>
                                <td><?php echo $po['VND_CODE'] ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-2 text-center">Vendor Name</td>
                                <td class="col-md-10"><?php echo $po['VND_NAME'] ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-2 text-center">Created At</td>
                                <td><?php echo oracledate(oraclestrtotime($po['PO_CREATED_AT'])) ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-2 text-center">Delivery Date</td>
                                <td><?php echo $po['DDATE'] ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Detail Item</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                       <!-- <th>Aprrove</th>-->
                                        <th class="text-center" nowrap>No</th>
                                        <th class="text-center" nowrap>No Material</th>
                                        <th class="text-center" nowrap>Description</th>
                                        <th class="text-center" nowrap>Quantity</th>
                                        <th class="text-center" nowrap>Price</th>
                                        <th class="text-center" nowrap>Total</th>
                                    </thead>
                                    <tbody id="items_table">
                                    <?php foreach ($pod as $key => $each_pod): ?>
                                        <tr>
                                            <td class="text-center"><?php echo $key+1 ?></td>
                                            <td class="text-center"><?php echo $each_pod['POD_NOMAT'] ?></td>
                                            <td class="text-center"><?php echo $each_pod['POD_DECMAT'] ?></td>
                                            <td class="text-center satuan"><?php echo $each_pod['POD_QTY'] ?></td>
                                            <td class="text-center price"><?php echo $each_pod['POD_PRICE'] ?></td>
                                            <td class="text-center subtotal">0</td>
                                        </tr>
                                    <?php endforeach ?>
                                        <tr>
                                            <td colspan="5" class=" text-center"><strong>Total</strong></td>
                                            <td class="text-center" id="total"><strong>0</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
        </div>
    </div>
</section>