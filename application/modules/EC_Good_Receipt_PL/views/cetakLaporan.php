<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      font-size: 10pt;
    }
    table {
      width : 100%;
      border : 1px solid;
      border-collapse: collapse;
    }
    table td {
      border : 1px solid;
      border-collapse: collapse;
      padding:5px;
    }
    table.noborder{
      width: 100%;
      border : 0px;
    }
    table.noborder td{
      border : 0px;
    }
    .mini {
      font-size:6pt
    }
    .vendor_name{
      font-size : 90%;
    }
    .small{font-size: 10px;}
    .bold{font-weight: bold;}
    table.header td, table.header, table.header tr, table.header table, table.header table td{
        border:0;
    }
    h1, h3{
        text-align:center;
        margin:0;
    }
    .body{
        margin-top:1cm;
        margin-bottom:1cm;
    }
    @page{	
	margin-bottom: 5cm;
    }
  </style>
  <title>Cetak Laporan Pembelian</title>
</head>
<body>
  <table class="header">
      <tr>
          <td style="width:25%;"><img src="<?php echo site_url('static/images/logo/'.$company_data['logo']) ?>" width="100" alt="Logo Perusahaan"></td>
          <td style="width:75%;">
              <table>
                     <tr>
                        <td colspan="3"><h2><?=$company_data['nama']?></h2></td>                        
                    </tr>
                    <tr>
                        <td style="width:100px;">User</td>
                        <td>:</td>
                        <td><?=$user;?></td>
                    </tr>
                    <tr>
                        <td>Periode</td>
                        <td>:</td>
                        <td><?=$periode;?></td>
                    </tr>
                    <tr>
                        <td>Halaman</td>
                        <td>:</td>
                        <td>{nb}</td>
                    </tr>
              </table>
          </td>
      </tr>
  </table>
    <hr>
  <h3><?=$ekspedisi?></h3>
  <table class="body">
    <thead>      
      <tr>
        <td align="center">No</td>
        <td align="center">Shipment No</td>
        <td align="center">GR No</td>
        <td align="center">Doc Date</td>
        <td align="center">Vendor</td>
        <td align="center">Material No.</td>
        <td align="center">Qty</td>
        <td align="center">Harga Qty</td>
        <td align="center">Total</td>                
      </tr>
    </thead>
    <tbody style="min-height:400px">  
        <?php 
        $no=1;
        
        foreach($data as $d => $v){?>
        <tr>
            <td><?=$no++?></td>
            <td><?=$v['NO_SHIPMENT'];?></td>
            <td><?=$v['GR_NO'];?></td>
            <td><?=$v['DOC_DATE'];?></td>
            <td><?=$v['VENDOR_NAME'];?></td>
            <td><?=$v['MATNO'];?></td>
            <td><?=$v['QTY_RECEIPT'];?></td>
            <td><?=ribuan($v['PRICE']);?></td>
            <td><?=ribuan($v['PRICE']*$v['QTY_RECEIPT']);?></td>
        </tr>
        <?php         
        }?>        
    </tbody>
  </table> 
</body>

</html>
