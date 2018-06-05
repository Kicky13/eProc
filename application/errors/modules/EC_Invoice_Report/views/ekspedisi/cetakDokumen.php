<?php date_default_timezone_set("Asia/Jakarta") ?>
<style>
    body{
        margin-top : 30px;
        font-size : 8pt;
    }
    .table{
      border : 1px solid gray;
      border-collapse: collapse;
    }
    .table tr, .table td, .table th{
      border : 1px solid gray;
    }
    .detail_table tr,.detail_table td,.detail_table th{
      border : none;
    }
</style>

<div style="text-align: center;margin-top:-30px">
  <div style="font-size:14pt;font-weight:bolder">CETAK EKSPEDISI PPL</div>
  <div>No. <?php echo $no_ekspedisi ?></div>
  <div><?php echo $company['nama']. ' - ( ' .$company_code.' )' ?></div>
</div>
<div style="position:absolute;right:50pxpx;top:30px">Tanggal Cetak : <?php echo date('d.m.Y H:i:s')?></div>

<div style="margin-top: 10px">
    <div class="col-md-12">
        <table style="width:100%;text-align:center">
            <thead>
              <tr>
                <th style="width:20px">No.</th>
                <th style="width:80px">Nomer Doc</th>
                <th style="width:50px">Nomer Batch</th>
                <th style="width:100px">Vendor</th>
                <th style="width:200px">Nama Vendor</th>
                <th style="width:100px">Jumlah</th>
                <th style="width:50px">Curr</th>
                <th style="width:40px">&nbsp;</th>
              </tr>
              <tr>
                <th colspan="8"><hr /></th>
              </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach($listEkspedisi as $key => $ld){
                    echo '<tr>';
                    echo '<td style="width:20px">'.$no++.'</td>';
                    echo '<td style="width:80px">RE '.$ld['ACCOUNTING_INVOICE'].'</td>';
                    echo '<td style="width:50px">#</td>';
                    echo '<td style="width:100px">'.$ld['VENDOR'].'</td>';
                    echo '<td style="width:100px">'.$ld['VENDOR_NAME'].'</td>';
                    echo '<td style="width:100px;text-align:right">'.ribuan($ld['JUMLAH']).'</td>';
                    echo '<td style="width:50px">'.$ld['CURR'].'</td>';
                    echo '<td style="width:40px"><div style="border:1px solid black;width:30px;">&nbsp;&nbsp;&nbsp;</div></td>';
                    echo '</tr>';
                }

                ?>
            </tbody>

        </table>
    </div>
</div>
<div style="margin-top:40px">&nbsp;</div>
<div style="position:absolute;left:200px">Penerima</div>
<div style="position:absolute;left:500px">Pengirim</div>
