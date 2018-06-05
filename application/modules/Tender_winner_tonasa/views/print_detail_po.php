<html>
    <head>
        <style>
            body{
                font-size:8pt;
            }
            table {
                border-collapse: collapse;
            }

            table.bordered tr td, table.bordered th {
                border: 1px solid black;
                font-size:8pt;
            }

            .tableheader{
                margin:100px;
            }
            .col-md-3{
                width:25%;
            }
            .vendorsupply{
                width:20%;
                position: relative;
                top: 50%;
                transform: translateY(-50%);
            }
            .item{
                width:6%;
            }

            .pono{
                width:11%;
            }

            .shorttext{
                width:25%;   
            }
            .text-center{
                text-align: center;
            }

            .text-right{
                text-align: right;
            }

            .text-left{
                text-align: left;
            }

        </style>
    </head>
<body>
    <div style="text-align:center">
        <h2><?php echo $title ?></h2>
    </div>
    <table>
        <tr>
            <td class="col-md-3" ><strong>No PO</strong></td>
            <td>: <?php echo $NO_PO ?></td>
        </tr>
        <tr>
            <td class="col-md-3"><strong>No Pratender</strong></td>
            <td>: <?php echo $PTM_PRATENDER ?></td>
        </tr>
        <tr>
            <td class="col-md-3"><strong>Mekanisme Pengadaan</strong></td>
            <td>: <?php echo $PTP_JUSTIFICATION ?></td>
        </tr>
        <tr>
            <td class="col-md-3"><strong>Lokasi</strong></td>
            <td>: <?php echo $PLANT ?></td>
        </tr>
        <tr>
            <td class="col-md-3"><strong>Koordinator Anggaran</strong></td>
            <td>: <?php echo $PPR_REQUESTIONER ?></td>
        </tr>
    </table>
    <p>Bersama ini kami paparkan usulan penunjukan pemenangan dari penawaran barang/jasa sebagai berikut :</p>

    <table class="table table-bordered bordered" style="font-size: 10pt;">
        <thead>
            <tr>
                <th nowrap class="text-center vendorsupply tableheader" >Vendor</th>
                <th class="text-center item">Item</th>
                <th class="text-center pono">PO No</th>
                <th class="text-center shorttext">Short Text</th>
                <th class="text-center" style="width:50px">Qty</th>
                <th class="text-center" style="width:50px">UoM</th>
                <th class="text-center" style="width:50px">NetPrice</th>
                <th class="text-center" style="width:50px">Value</th>
                <th class="text-center" style="width:50px">Curr</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $item as $id => $val): ?>
                <?php if($id == 0): ?>
                    <tr>
                        <td rowspan="<?php echo count($item) ?>" nowrap class="vendorsupply" style="top: 50%;"><?php echo $po_header['VND_NAME'] ?></td>
                        <td class="text-right item"><?php echo $val['EBELP'] ?></td>
                        <td rowspan="<?php echo count($item) ?>" class="text-center pono"><?php echo $po_header['PO_NUMBER'] ?></td>
                        <td nowrap class=" shorttext"><?php echo $val['POD_DECMAT'] ?><br><?php if(!is_null($val['ITEM_TEXT'])){?><i>Note: <?php echo $val['ITEM_TEXT'] ?></i><?php } ?></td>
                        <td class="text-right"><?php echo $val['POD_QTY'] ?></td>
                        <td class="text-center"><?php echo $val['UOM'] ?></td>
                        <td class="text-right"><?php echo $val['POD_PRICE'] ?></td>
                        <td class="text-right"><?php echo intval($val['POD_PRICE']) * intval($val['POD_QTY']) ?></td>
                        <td class="text-center"><?php echo $val['CURR'] ?></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td class="text-right item"><?php echo $val['EBELP'] ?></td>
                        <td nowrap class="shorttext"><?php echo $val['POD_DECMAT'] ?><br><?php if(!is_null($val['ITEM_TEXT'])){?><i>Note: <?php echo $val['ITEM_TEXT'] ?></i><?php } ?></td>
                        <td class="text-right"><?php echo $val['POD_QTY'] ?></td>
                        <td class="text-center"><?php echo $val['UOM'] ?></td>
                        <td class="text-right"><?php echo $val['POD_PRICE'] ?></td>
                        <td class="text-right"><?php echo intval($val['POD_PRICE']) * intval($val['POD_QTY']) ?></td>
                        <td class="text-center"><?php echo $val['CURR'] ?></td>
                    </tr>
                <?php endif ?>
            <?php endforeach ?>
                    <tr>
                        <td class="text-right" colspan="7"><strong>TOTAL</strong></td>
                        <td class="text-right"><?php echo $po_header['TOTAL_HARGA'] ?></td>
                        <td class="text-center"><?php echo $val['CURR'] ?></td>
                    </tr>
        </tbody>
    </table>

    <table>
        <tr>
            <td class="col-md-3"><strong>Delivery Time</strong></td>
            <td>: <?php echo Date("d-m-Y",oraclestrtotime($po_header['PO_CREATED_AT'])) - Date("d-m-Y",oraclestrtotime($po_header['DDATE']))?> Hari</td>
        </tr>
        <tr>
            <td class="col-md-3"><strong>Header Text</strong></td>
            <td>: <?php echo nl2br(str_replace('  ', '&nbsp;&nbsp;&nbsp;', $po_header['HEADER_TEXT'])) ?></td>
        </tr>
    </table>

    <table class="table table-bordered" style="font-size: 10pt">
        <thead>
            <tr>
                <th nowrap class="text-center">Nama</th>
                <th class="text-center">Jabatan</th>
                <th class="text-center">Status</th>
                <th class="text-center">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($approval as $id => $val): ?>
                <tr>
                    <td><?php echo $val['NAMA'] ?></td>
                    <td><strong><?php echo $val['JABATAN'] ?></strong></td>
                    <td class="text-center"><?php if($val['IS_APPROVE'] >= $id+1) echo "Approved"; else echo "Waiting Approval"; ?></td>
                    <td class="text-center"><?php if($val['IS_APPROVE'] >= $id+1) echo Date("d-m-Y",oraclestrtotime($val['CREATED_DATE'])); else echo "-"; ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
        <?php if(!isset($is_print)): ?>
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body text-center">
                        <?php if($is_approval == "true"):?>
                            <a type="button" class="main_button color7 small_btn close-modal" href="<?php echo base_url("Tender_winner/listapprovalPO")?>">Kembali</a>
                            <a href="<?php echo base_url("Tender_winner/retender/".$po_header['PO_ID'])?>" class="btn btn-danger text-left" title="Retender"><i class="glyphicon glyphicon-remove"></i></a>
                            <a href="<?php echo base_url("Tender_winner/renego/".$po_header['PO_ID'])?>" class="btn btn-primary text-left" title="ReNego"><i class="glyphicon glyphicon-retweet"></i></a>
                            <a href="<?php echo base_url("Tender_winner/approve/".$po_header['PO_ID'])?>" class="btn btn-success text-left" title="Approve"><i class="glyphicon glyphicon-ok"></i></a>
                        <?php else: ?>
                            <a type="button" class="main_button color7 small_btn close-modal" href="<?php echo base_url("Tender_winner/listPO")?>">Kembali</a>
                        <?php endif ?>
                        
                    </div>
                </div>
            </div>
        </div>
        <?php endif ?>
    </div>
</body>
</html>