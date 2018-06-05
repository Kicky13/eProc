<?php

// echo "<pre>";
// print_r($ptv);
// print_r($vnd);
// print_r($vendor);
// print_r($ppi);
// print_r($bank);
// print_r($po);
// die;
?>
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

        <div>   
            <table style="width:100%;" class="" border="1">
                <tr>
                    <td>
                        <font class="kanan bawah">To &nbsp;&nbsp;</font><br><br>
                        <?php echo $ptv['VENDOR_NAME'] ?><br>
                        <?php echo $vnd['ADDRESS'] ?><br>
                        <?php echo $vnd['CITY'] ?><br>
                        FAX: <?php echo $vnd['FAX'] ?><br>
                        TLP: <?php echo $vnd['TELEPHONE1_NO'].(isset($vnd['TELEPHONE2_NO'])?" / ".$vnd['TELEPHONE2_NO']:""); ?><br>
                        <?php echo $vendor['VENDOR_NO'] ?><br>

                        <?php echo $bank['ACCOUNT_NO']; ?><br>
                        <?php echo $bank['BANK_NAME']." ".$bank['BANK_BRANCH'] ?><br>
                    </td>
                    <td class="text-left">
                        Po Number : <?php echo $po['PO_NUMBER']."/".$po['DOC_TYPE'];?><br>
                        Po Date : <?php echo Date("d.m.Y",oraclestrtotime($po['DOC_DATE'])) ?><br>
                        RFQ/PR Number : <?php echo $RFQ_NO."/".$PRNO ?><br>
                        UK Peminta : <?php echo $ppi['PPR_REQUESTIONER'] ?><br>
                        Delivery Date : <?php echo Date("d.m.Y",oraclestrtotime($po['DDATE'])) ?><br>
                        <?php //echo $po['PGRP'] ?> <?php //echo $apg['PURCH_GRP_NAME'] ?>
                        <?php //echo $ppi['PPI_CURR'] ?> 
                        Term Of Payment : <?php echo $po['DOC_TYPE'] ?><br>
                        Incoterms : <?php echo $ppi['PPI_PLANT'] ?> <?php echo $ppi['PLANT_NAME'] ?><br>
                        User ID : <?php echo $vendor['LOGIN_ID'] ?>
                    </td>
                </tr>
            </table>
            <br>
            <br>
            <div class="panel-body">

                <div class="col-md-12">
                    <table class="">
                     <?php $no=1; $tot=0; foreach ($item as $key => $value): ?>
                     <tr>
                        <td><?php echo $no++;?></td>
                        <td><?php echo $value['POD_NOMAT']; ?></td>
                        <td><?php echo $value['POD_DECMAT']; ?></td>
                        <td><?php echo $value['POD_QTY']; ?></td>
                        <td><?php echo $ppi['PPI_UOM']; ?></td>
                        <td class="text-right"><?php echo "Rp. ".number_format($value['POD_PRICE'],2,",",".");?></td>
                        <td class="text-right"><?php echo "Rp. ".number_format($value['POD_QTY']*$value['POD_PRICE'],2,",","."); $tot+=$value['POD_QTY']*$value['POD_PRICE'];?></td>

                    </tr>
                <?php endforeach ?>
            </table>
        </div>
        <br>
        <br>
        <br>
        <hr>
        <div>
            <table class="">                
                <tr>
                    <td colspan="7"><?php echo strtoupper($terbilang) ?> RUPIAH</td>
                    <td class="text-right"><?php echo "Rp. ".number_format($tot,2,",",".")."<br> Harga belum termasuk PPN";?></td>
                </tr>                           
            </table>            
        </div>
        <div class="middle-center border width-300 height-100">
            Catatan: 
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div>
            <table class="">
                <tr>
                    <td class="text-center text-top">

                    </td>
                    <td class="width-200"></td>
                    <td class="text-center">                        

                        <?php echo $approval['NAMA'] ?><br>
                        <?php echo $approval['JABATAN'] ?> <br>


                    </td>
                </tr>
                <tr>
                    <td class="height-100"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td align="center">
                        <img src="<?php echo $qrpath ?>">

                    </td>                    
                </tr>
            </table>             

        </div>
    </div>

</div>