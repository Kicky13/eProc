        <style>
            body,p,table td{
                font-size:8pt;
                font-family: Courier,verdana,arial;
            }
            table {
                border-collapse: collapse;
                width: 100%;
            }

            table.bordered tr td, table.bordered th {
                border: 1px solid black;
                font-size:8pt;
            }

            .bordered td{
                border: 1px solid black;
                margin-left: 10px;
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

            .pono p{
                font-size: 14pt;
                text-align: center;
            }

            .shorttext{
                width:25%;   
            }
            .text-center, .centered{
                text-align: center;
            }

            .text-right{
                text-align: right;
            }

            .text-left{
                text-align: left;
            }

            .side-right{
                margin-left: 580px;
                /*border: solid 1px black;*/
            }

            .middle-right{
                margin-left: 450px;
                /*border: solid 1px black;*/
            }

        </style>
   
<div>   
    <div class="side-right">
        <span class="">R/5125/004</span>
    </div>
    <div class="middle-right">
        <span><?php echo $PRNO ?></span><br>
        <span><?php echo $RFQ_NO ?></span><br>
        <span><?php echo $PTM_PRATENDER ?></span><br>        
    </div>
    <div class="pono">
        <p><strong><?php echo $po['CONTRACT_NUMBER'] ?> / <?php echo $ppi['PPI_PLANT'] ?></strong></p>
    </div>
    <div>
         <p class="text-left" >            
            <?php echo $ptv['VENDOR_NAME'] ?><br>
            <?php echo $vnd['ADDRESS'] ?><br>
            <?php echo $vnd['CITY'] ?><br>
            FAX: <?php echo $vnd['FAX'] ?>
        </p>
    </div>
    <div>
        <span><?php echo $vendor['LOGIN_ID'] ?></span>
        <span><?php echo $ptv['PTV_VENDOR_CODE'] ?></span>
    </div>

    <div class="panel-body">
        <table class="table table">
                <tr style="border:0">
                    <td colspan="4" style="border:0"></td>
                    <td class="text-center" style="border:0"><?php echo Date("d.m.Y",oraclestrtotime($po['DOC_DATE'])) ?>
                    </td>
                    <td class="text-center" style="border:0"><?php echo Date("d.m.Y",oraclestrtotime($po['DDATE'])) ?>
                    </td>
                </tr>
                <tr class="bordered">
                    <td class="text-center">Quantity
                    </td>
                    <td class="text-center">UoM
                    </td>
                    <td class="text-center">Nomor Material
                    </td>
                    <td class="text-center">Description
                    </td>
                    <td class="text-center">IDR
                    </td>
                    <td class="text-center">IDR
                    </td>
                </tr>
            <?php foreach ($item as $key => $value): ?>
                <tr  class="bordered">
                    <td><?php echo $value['POD_QTY'] ?>
                    </td>
                    <td><?php echo $value['UOM'] ?>
                    </td>
                    <td><?php echo $value['POD_NOMAT'] ?>
                    </td>
                    <td><?php echo $value['POD_DECMAT'] ?>
                    </td>
                    <td class="text-right"><?php echo number_format($value['POD_PRICE'],2,",",".") ?>
                    </td>
                    <td class="text-right"><?php echo number_format(intval($value['POD_PRICE'])*intval($value['POD_QTY']),2,",",".") ?>
                    </td>
                </tr>
            <?php endforeach ?>
                <tr  class="bordered">
                    <td colspan="4"><?php echo $terbilang ?> Rupiah
                    </td>
                    <td class="text-center col-md-2" style="border-left:1px solid #dddddd;">IDR
                    </td>
                    <td class="text-right col-md-2" style="border-left:1px solid #dddddd;"><?php echo number_format($total,2,",",".") ?>
                    </td>
                </tr>
        </table>
        <div class="col-md-12">
            <p class="no_margin_bottom">
                NOTE : <br>
                BARANG YANG READY HARAP SEGERA DIKIRIM
            </p>
        </div>
        <div class="middle-right">
            <p class="text-center">
               <?php echo $approval['NAMA'] ?> <br>
                <?php echo $approval['JABATAN'] ?> <br>
                <img src="<?php echo $qrpath ?>">
            </p>
        </div>
    </div>

</div>