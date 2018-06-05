<!DOCTYPE html>
<html>
<head>
</head>
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
    .Kanan{
        border-right:1px solid black;
    }
    .Kiri{
        border-left: 1px solid black;
    }
    .Bawah{
        border-bottom:1px solid black;
    }
    .Atas{
        border-top:1px solid black;
    }
    .border{
        border: 1px solid black;
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

    .title p{
        font-size: 12pt;
        text-align: center;
    }

    .shorttext{
        width:25%;   
    }
    .text-center, .centered{
        text-align: center;
    }
    .text-top{
        vertical-align: top;
    }

    .text-right{
        text-align: right;
    }

    .text-left{
        text-align: left;
    }

    .side-right{
        margin-left: 500px;
        /*border: solid 1px black;*/
    }

    .side-left{
        margin-left: 0px;
        /*border: solid 1px black;*/
    }

    .middle-right{
        margin-left: 450px;
        /*border: solid 1px black;*/
    }

    .middle-center{
        margin-left: 25%;
        /*border: solid 1px black;*/
    }

    .width-100{
        width: 100px;
    }

    .width-200{
        width: 200px;
    }

    .width-300{
        width: 300px;
    }

    .height-100{
        height: 100px;
    }

    .height-200{
        height: 200px;
    }

    .height-300{
        height: 300px;
    }

    .padding-100{
        padding-left: 100px;
    }

    .padding-200{
        padding-left: 200px;
    }

    .padding-300{
        padding-left: 300px;
    }

    .underline{
        text-decoration: underline;
    }

    .blok{
        display:inline;
    }

</style>
<body style="width: 1000px !important;">
    <div>   
        <table style="width:100%;" class="">
            <tr>
                <td>
                    <?php echo $ptv['VENDOR_NAME'] ?><br>
                    <?php echo $vnd['ADDRESS'] ?><br>
                    <?php echo $vnd['CITY'] ?><br>
                    FAX: <?php echo $vnd['FAX'] ?><br>
                    TLP: <?php echo $vnd['TELEPHONE1_NO'].(isset($vnd['TELEPHONE2_NO'])?" / ".$vnd['TELEPHONE2_NO']:""); ?>
                    <table>
                        <tr>
                            <td class="width-100"></td>                
                            <td class="text-right"><?php echo $vendor['VENDOR_NO'] ?></td>
                        </tr>
                    </table>

                </td>
                <td>
                    <div>
                        <table>
                            <tr>                             
                                <td class="text-center width-300"><?php echo $bank['ACCOUNT_NO']; ?></td>
                            </tr>
                            <tr>                             
                                <td class="text-center"><?php echo $bank['BANK_NAME']." ".$bank['BANK_BRANCH'] ?></td>
                            </tr>
                        </table>

                    </div>
                </td>
                <td class="text-left">
                    <?php $spasi = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; ?>
                    <?php echo $spasi.$po['PO_NUMBER']."/".$po['DOC_TYPE'];?><br>
                    <?php echo $spasi.Date("d.m.Y",oraclestrtotime($po['DOC_DATE'])) ?><br>
                    <?php echo $spasi.$PRNO."/".$RFQ_NO ?><br>
                    <?php echo $spasi.$po['PGRP'] ?> <?php echo $apg['PURCH_GRP_NAME'] ?><br>
                    <?php echo $spasi.Date("d.m.Y",oraclestrtotime($po['DDATE'])) ?>
                    <?php //echo $ppi['PPI_PLANT'] ?> <?php //echo $ppi['PLANT_NAME'] ?>
                    <?php //echo $ppi['PPI_CURR'] ?> <br>
                    <?php echo $spasi."<br>"; ?><br>
                    <?php echo $spasi.$po['DOC_TYPE'] ?><br>
                    <?php echo $spasi.$vendor['LOGIN_ID'] ?>
                </td>
            </tr>
        </table>
        <br>
        <br>


        <br>
        <br>
        <br>
        <br>
        <br>
        <div>

            <div class="col-md-12">
                <table>
                    <?php $no=1; $tot=0; foreach ($item as $key => $value): ?>
                    <tr>
                        <td width="5%"><?php echo $no++;?></td>
                        <td width="20%"><?php echo $value['POD_NOMAT']; ?></td>
                        <td width="40%"><?php echo $value['POD_DECMAT']; ?></td>
                        <td width="5%"><?php echo $value['POD_QTY']; ?></td>
                        <td><?php echo $ppi['PPI_UOM']; ?></td>
                        <td><?php echo "Rp. ".number_format($value['POD_PRICE'],2,",",".");?></td>
                        <td><?php echo "Rp. ".number_format($value['POD_QTY']*$value['POD_PRICE'],2,",","."); $tot+=$value['POD_QTY']*$value['POD_PRICE'];?></td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
        <br>
        <br>
        <br>

        <div>
            <table class="">         
                <tr>
                    <td>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>

                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>

                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        
                    </td>
                    <td></td>
                </tr>   

                <tr>
                    <td colspan="3"><hr></td>
                </tr>
                <tr>
                    <td><?php echo strtoupper($terbilang) ?> RUPIAH</td>
                    <td></td>
                    <td class="text-right"><?php echo "Rp. ".number_format($tot,2,",",".")."<br> Harga belum termasuk PPN";?></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;&nbsp;&nbsp;
                        <br>
                    </td>
                    <td class="middle-center border width-300 height-100" style="vertical-align: top;text-align: left;">
                        Catatan: 
                    </td>
                    <td rowspan="2" class="text-right">
                        &nbsp;&nbsp;&nbsp;
                        <?php echo $spasi2.$approval['NAMA'] ?><br>
                        <?php echo $spasi2.$approval['JABATAN'] ?> <br>
                        <?php echo $spasi2; ?><img src="<?php echo $qrpath ?>">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>                           
            </table>
        </div>


<!--     <div class="middle-center border width-300 height-100">
Catatan: 
</div> -->

</div>

</div>
</body>
</html>