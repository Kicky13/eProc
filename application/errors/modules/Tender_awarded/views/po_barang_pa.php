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

            .width-100{
                width: 100px;
            }

            .width-200{
                width: 200px;
            }

            .width-300{
                width: 300px;
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
    <table>
        <tr>
            <td>
    <div>
         <p class="text-left" >   
            <?php echo $ptv['VENDOR_NAME'] ?><br>
            <?php echo $vnd['ADDRESS'] ?><br>
            <?php echo $vnd['CITY'] ?><br>
            FAX: <?php echo $vnd['FAX'] ?>
        </p>
    </div>
    <div>
        <table>
            <tr>
                <td class="width-300"></td>                
                <td class="text-right"><?php echo $vendor['LOGIN_ID'] ?></td>
            </tr>
        </table>
        
    </div>
</td>
<td></td>
<td class="text-left">
    <?php echo $po['PO_NUMBER'];?><br>
    <?php echo Date("d.m.Y",oraclestrtotime($po['DOC_DATE'])) ?><br>
    <?php echo $ppi['PPI_PLANT'] ?> <?php echo $ppi['PLANT_NAME'] ?><br>
    <?php echo $po['PGRP'] ?> <?php echo $apg['PURCH_GRP_NAME'] ?><br>
    <?php echo $ppi['PPI_CURR'] ?> <br>
    <?php echo $po['DOC_TYPE'] ?><br>
    <?php echo Date("d.m.Y",oraclestrtotime($po['DDATE'])) ?><br>
</td>
</tr>
</table>
<br>
<br>
    <div class="panel-body">
     
        <div class="col-md-12">
            <table class="bordered">
                 <?php $no=1; $tot=0; foreach ($item as $key => $value): ?>
                <tr>
                    <td><?php echo $no++;?></td>
                    <td><?php echo $value['POD_NOMAT']; ?></td>
                    <td><?php echo $value['POD_DECMAT']; ?></td>
                    <td><?php echo $value['POD_QTY']; ?></td>
                    <td><?php echo $ppi['PPI_UOM']; ?></td>
                    <td class="text-right"><?php echo "Rp. ".number_format($value['POD_PRICE'],2,",","."); ?></td>
                    <td class="text-right"><?php echo "Rp. ".number_format($value['POD_QTY']*$value['POD_PRICE'],2,",",".");$tot+=$value['POD_QTY']*$value['POD_PRICE']; ?></td>

                </tr>
            <?php endforeach ?>
            </table>
        </div>
        <br>
        <br>
        <br>
        <hr>
        <div>
            <table class="bordered">                
                <tr>
                    <td colspan="7"><?php echo strtoupper($terbilang) ?> RUPIAH</td>
                    <td class="text-right"><?php echo "Rp. ".number_format($tot,2,",",".");?></td>
                </tr>                           
            </table>            
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
            </table>
             <br>
            <br>
            <br>
            <br>
            <br>
            <div class="side-right">
                <img src="<?php echo $qrpath ?>">
            </div>
        </div>
    </div>

</div>