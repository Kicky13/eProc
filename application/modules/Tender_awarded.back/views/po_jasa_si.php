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
    
    <div class="title">
        <p class="underline"><strong>PERINTAH KERJA</strong></p>
        <p>No:<?php echo $po['PO_NUMBER'] ?></p>
    </div>    
    <hr>
    <div>
         <p class="text-left" >KEPADA : <br>
            Yth.      
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
                <td class="width-200">Kode <?php echo $ptv['PTV_VENDOR_CODE'] ?></td>
                <td class="text-right"><?php echo $vendor['LOGIN_ID'] ?></td>
            </tr>
        </table>
        
    </div>
    <hr>
    <div class="panel-body">
     
        <div class="col-md-12">
            <p class="no_margin_bottom">
                URAIAN PEKERJAAN :
            </p>
            <table class="bordered">
                 <?php foreach ($item as $key => $value): ?>
                <tr>
                    <td><?php echo $value['POD_QTY'] ?></td>
                    <td><?php echo $value['POD_NOMAT'] ?></td>
                    <td><?php echo $value['POD_DECMAT'] ?></td>
                </tr>
            <?php endforeach ?>
            </table>
        </div>
        <br>
        <br>
        <br>
        <div>
            <table>
                <tr>
                    <td>Tanggal Order</td>
                    <td>:</td>
                    <td><?php echo Date("d.m.Y",oraclestrtotime($po['DOC_DATE'])) ?> s/d <?php echo Date("d.m.Y",oraclestrtotime($po['DDATE'])) ?></td>
                </tr>
                <tr>
                    <td>Lokasi</td>
                    <td>:</td>
                    <td> <?php echo $ppi['PPI_PLANT'] ?> /  <?php echo $ppi['PLANT_NAME'] ?> </td>
                </tr>
                <tr>
                    <td>Harga Total</td>
                    <td>:</td>
                    <td>Rp. <?php echo number_format($total,2,",",".") ?>(Harga ini belum termasuk PPN)</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><?php echo $terbilang ?> Rupiah</td>
                </tr>
                 <tr>
                    <td>NPWP</td>
                    <td>:</td>
                    <td><?php echo $vendor['NPWP_NO'] ?> <b>KETENTUAN UMUM (LIHAT DI BALIK HALAMAN INI)</b></td>
                </tr>                
            </table>            
        </div>
        <hr>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div>
            <table class="">
                <tr>
                    <td class="text-center text-top">
                        
                            Disetujui Pemasok<br>
                            nama & Jabatan  <br>                         
                          <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                (
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                )
                    </td>
                    <td class="width-200"></td>
                    <td class="text-center">
                        
                                PT Semen Indonesia (Persero) Tbk.<br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                            ( <?php echo $approval['NAMA'] ?> )<br>
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