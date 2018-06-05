<?php

// echo "<pre>";
// print_r($ptv);
// print_r($vnd);
// print_r($vendor);
// print_r($ppi);
// print_r($bank);
// print_r($po);
// print_r($item);
// print_r($prc_tender_prep);
// die;
?>
<style>
    .kecilkan{
        font-size:6pt;
        font-family: Courier,verdana,arial;
    }

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

    .width-200{
        width: 200px;
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

    .font16{
        font-size: 16px;
    }

    .tebalkepala{
        border: 2px solid black;
    }


    .setting_bold{
        font-weight: bold;
    }

    .footer {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        padding: 1rem;
        text-align: center;
    }

    .spasisijisetengah{
        line-height: 1.5em;
    }

    #footer {
        position: relative;
        margin-bottom: 90px;
        /*bottom: 1px !important;*/
        /* negative value of footer height */
        clear: both;
    }

</style>

<div>   
<!--     <table style="width:100%;">
        <tr>
            <td rowspan="2">
                <img src="http://10.15.5.150/dev/eproc/static/images/logo/logo_tonasa.png" width="50" height="50">
            </td>
            <td class="text-left" rowspan="2">
                PT SEMEN TONASA<br>
                BIRING ERE PANGKEP SUL-SEL<br>  
                FAX (0410) 310020<br>  
                TLP. (0410) 312345 (HUNTING)<br>  
            </td>
            <td></td>
            <td align="center"><b>PURCHASE ORDER</b></td>
        </tr>
        <tr>
            <td></td>
            <td class="text-center">
                <img src="http://10.15.5.150/dev/eproc/static/images/logo/tender_winner_tonasa.png" width="230" height="40">
            </td>
        </tr>
    </table> -->
    <br>
    <br>
    <br>
    <br>
    <br>
    
    <table style="width:100%;" class="" border="1">
        <tr>
            <td width="40%">
                <font class="kanan bawah">To &nbsp;&nbsp;</font><br><br>
                <?php echo $ptv['VENDOR_NAME'] ?><br>
                <?php echo $npwp[0]['NPWP_ADDRESS'] ?> <?php echo $npwp[0]['KOTA'] ?><br>
                <?php echo $npwp[0]['PROPINSI'] ?><br>
                <?php echo $npwp[0]['NPWP_POSTCODE'] ?><br>
                TELP: <?php echo $vendor['ADDRESS_PHONE_NO'] ?><br>
                FAX: <?php echo $vnd['FAX'] ?><br>
                Nomor NPWP : <?php echo $vendor['NPWP_NO'] ?><br>

                <b>No. Reference Bank :</b><?php echo $bank['ACCOUNT_NO']; ?><br>
                <?php echo $bank['BANK_NAME']." ".$bank['BANK_BRANCH'] ?><br>
                Your Vendor Number With Us : <?php echo $vendor['VENDOR_NO'] ?>
            </td>
            <td class="text-left" width="60%" style="vertical-align: text-top;">
                <font class="font16">ORDER PEKERJAAN</font><br><br>
                PO Number&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $po['PO_NUMBER']."/".$po['DOC_TYPE'];?><br>
                PO Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo Date("d.m.Y",oraclestrtotime($po['DOC_DATE'])) ?><br>
                RFQ/PR Number&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $RFQ_NO."/".$PRNO ?><br>
                UK Peminta&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $ppi['PPR_REQUESTIONER']." / ".$LONG_DESC; ?><br>
                Delivery Date&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo Date("d.m.Y",oraclestrtotime($po['DDATE'])) ?><br>
                <?php //echo $po['PGRP'] ?> <?php //echo $apg['PURCH_GRP_NAME'] ?>
                <?php //echo $ppi['PPI_CURR'] ?> 
                Term Of Payment&nbsp;&nbsp;: <?php echo "ZG30 / Overdue 30 Days ";//$po['DOC_TYPE'] ?><br>
                Incoterms&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                <?php //echo $ppi['PPI_PLANT']
                //echo $ppi['PLANT_NAME']
                echo $prc_tender_prep['PTP_TERM_DELIVERY']." / ".$prc_tender_prep['PTP_DELIVERY_NOTE'];
                ?><br>
                <!-- User ID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $po['PO_CREATED_BY']; //echo $vendor['LOGIN_ID'] ?> -->
            </td>
        </tr>
    </table>
    <br>
    <br>
    <div class="panel-body">

        <div class="col-md-12">
            <table class="" border="1">
                <tr class="tebalkepala">
                    <th>No. Item</th>
                    <th>Material Number</th>
                    <th>Description</th>
                    <th>Quantity Uom</th>
                    <th>Price Per Unit</th>
                    <th>Amount</th>
                </tr>
                <?php $no=1; $tot=0; foreach ($item as $key => $value): ?>
                <tr>
                    <td><?php echo $no++;?></td>
                    <td><?php echo $value['POD_NOMAT']; ?></td>
                    <td>
                        <?php echo $value['POD_DECMAT']; ?>
                        <br>
                        <?php if(!is_null($value['ITEM_TEXT'])){?><i> <?php echo $value['ITEM_TEXT'] ?></i><?php } ?>
                    </td>
                    <td><?php echo $value['POD_QTY']; ?> <?php echo $ppi['PPI_UOM']; ?></td>
                    <!-- <td></td> -->
                    <td class="text-right"><?php echo "Rp. ".number_format($value['POD_PRICE'],2,",",".");?></td>
                    <td class="text-right"><?php echo "Rp. ".number_format($value['POD_QTY']*$value['POD_PRICE'],2,",","."); $tot+=$value['POD_QTY']*$value['POD_PRICE'];?></td>

                </tr>
            <?php endforeach ?>
            <tr class="tebalkepala">
                <td colspan="4"> Terbilang : <?php echo strtoupper($terbilang) ?> RUPIAH</td>
                <td></td>
                <td class="text-right"><?php echo "Rp. ".number_format($tot,2,",",".")."<br> Harga belum termasuk PPN";?></td>
            </tr>
        </table>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

<!--         <br>
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
        <br> -->
<!--         <br>
        <br>
        <br> -->

<!--         <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br> -->

<!--         <br>
        <br>
        <br> -->
    </div>

</div>