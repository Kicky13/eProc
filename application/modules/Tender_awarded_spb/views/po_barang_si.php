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

<div class="text-center">
    <h3>SURAT PENGANTAR BARANG</h3>
</div>


<div> 
    <table>
        <tr>
            <td>No. Truk : <?php echo $po['PLAT'] ?></td>
            <td class="width-200"></td>
            <td>Tujuan : <?php echo $po['TUJUAN'] ?></td>
        </tr>
        <tr>
            <td>Driver &nbsp;&nbsp;: <?php echo $po['DRIVER'] ?></td>
            <td class="width-200"></td>
            <td></td>
        </tr>
    </table>
</div>
<br>
<div class="panel-body">
    <table class="table table">

        <tr class="bordered">
            <td class="text-center"><b>Nomor PO</b>
            </td>
            <td class="text-center"><b>Material</b>
            </td>
            <td class="text-center"><b>Quantity</b>
            </td>
        </tr>
        <tr class="bordered">
            <td class="text-center"><?php echo $po['PO_NUMBER'] ?>
            </td>
            <td class="text-center"><?php echo $po['MATNR']."<br>".$po['MAKTX']; ?>
            </td>
            <td class="text-center"><?php echo $po['QTY'] ?>
            </td>
        </tr>
    </table>
</div>

<div id="footer">    
    <hr>
    <table class="">
        <tr>
            <td class="text-center text-top">
                <b>Pengirim</b><br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                (<?php echo $po['VENDOR_NAME']; ?>)
            </td>
            <td class="text-center">
                <b>Pengemudi</b><br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                (<?php echo $po['DRIVER']; ?>)
            </td>
            <td class="text-center">
                <b>QR Code SPB</b><br>
                <div class="side-right">
                    <img src="<?php echo $qrpath ?>">
                </div>
            </td>
        </tr>
    </table>
</div>