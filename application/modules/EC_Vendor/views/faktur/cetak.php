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
    table.header{
        margin-top: 1cm;
        margin-bottom: 2cm;
    }
    h1, h3{
        text-align:center;
        margin:0;
    }
    .body{
        margin-top:1cm;
        margin-bottom:1cm;
    }
  </style>
  <title>Cetak Ekspedisi</title>
</head>
<body>
  <table class="header">
      <tr>
          <td style="width:65%;"><?=$company_data['nama']?></td>
          <td style="width:35%;">
              <table>
                    <tr>
                        <td style="width:100px;">Print Date</td>
                        <td>:</td>
                        <td><?=date("d.m.Y - h:i")?></td>
                    </tr>
                    <tr>
                        <td>Page</td>
                        <td>:</td>
                        <td>{nb}</td>
                    </tr>
              </table>
          </td>
      </tr>
  </table>
  <h1>EKSPEDISI FAKTUR PAJAK</h1>
  <h3><?=$ekspedisi?></h3>
  <table class="body">
    <thead>      
      <tr>
        <td align="center">No</td>
        <td align="center">No Faktur Pajak</td>
        <td align="center">Vendor</td>
        <td align="center">TGL Faktur</td>
        <td align="center">NPWP</td>
        <td align="center">DPP</td>
        <td align="center">PPN</td>
      </tr>
    </thead>
    <tbody style="min-height:400px">  
        <?php 
        $no=1;
        
        foreach($data as $d => $v){
            $time = strtotime($v['TGL_FAKTUR']);
            $newformat = date('d.m.Y',$time);?>
        <tr>
            <td><?=$no++?></td>
            <td><?=$v['NO_FAKTUR'];?></td>
            <td style="text-align:center;"><?=$vendor_no."<br/>".$vendor_name."<br/>".$nation[0]['VENDOR_TYPE'];?></td>
            <td><?=$newformat?></td>
            <td><?=$v['NPWP']?></td>
            <td><?=ribuan($v['DPP'])?></td>
            <td><?=ribuan($v['PPN'])?></td>
        </tr>
        <?php }?>
    </tbody>
  </table> 
</body>

</html>
