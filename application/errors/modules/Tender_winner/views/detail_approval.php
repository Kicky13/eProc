<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo base_url()?>Tender_winner/submit_approval" method="POST">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            PO Header
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tr>
                                        <td class="col-md-2">Nomor Vendor</td>
                                        <td>: <?php echo $po_header['VND_CODE']; ?> </td>
                                    </tr>
                                    <tr>
                                        <td>Vendor Name</td>
                                        <td>: <?php echo $po_header['VND_NAME']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Delivery Date</td>
                                        <td>: <?php echo date(bettertimeformat(), oraclestrtotime($po_header['DDATE'])) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Created At</td>
                                        <td>: <?php echo date(bettertimeformat(), oraclestrtotime($po_header['PO_CREATED_AT'])) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Doc Type</td>
                                        <td>: <?php echo $po_header['DOC_TYPE']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>PGRP</td>
                                        <td>: <?php echo $po_header['PGRP']; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Item
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <th class="col-md-1">No</th>
                                        <th>PPR_PRNO</th>
                                        <th>RFQ_NO</th>
                                        <th>Material Number</th>
                                        <th>Description</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>POD Number</th>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $no = 1;
                                        
                                        foreach ($items as $item) {
                                            echo '<tr>';
                                            echo '<td>'.$no.'</td>';
                                            echo '<td>'.$item['PPR_PRNO'].'</td>';
                                            echo '<td>'.$item['RFQ_NO'].'</td>';
                                            echo '<td>'.$item['POD_NOMAT'].'</td>';
                                            echo '<td>'.$item['POD_DECMAT'].'</td>';
                                            echo '<td>'.$item['POD_QTY'].'</td>';
                                            echo '<td>'.number_format($item['POD_PRICE']).'</td>';
                                            echo '<td>'.$item['POD_NUMBER'].'</td>';
                                            echo '<tr>';
                                            $no++;
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <input type="hidden" name="id" value="<?php echo $po_header['PO_ID']; ?>">
                            <a href="<?php echo base_url()."Tender_winner/"; ?>" class="main_button color7 small_btn">Kembali</a>
                            <button id="submit-form" type="submit" name="approve" value="0" class="main_button color1 small_btn">Reject</button>
                            <button id="submit-form" type="submit" name="approve" value="1" class="main_button color6 small_btn">Accept</button>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>