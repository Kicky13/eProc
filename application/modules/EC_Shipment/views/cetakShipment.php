<?php
  $detailPO = array();
  $tinggi = '35px'; 
  $totalPO=0;
    $no = 1;
    foreach ($po as $key => $value) {         
    $barang=$value['QTY']-($value['QTY_RECEIPT']+$value['QTY_REJECT']);
    $tr = '<tr>
          <td style="height:'.$tinggi.'" align="center">'.$no++.'</td>                  
          <td style="height:'.$tinggi.'" align="center">'.$value['MATNO'].'</td>
          <td style="height:'.$tinggi.'" align="center">'.$value['MAKTX'].'</td>          
          <td style="height:'.$tinggi.'" align="center">'.$value['MEINS'].'</td>
          <td style="height:'.$tinggi.'" align="center">'.$value['QTY_ORDER'].'</td>                            
          <td style="height:'.$tinggi.'" align="center">'.$barang.'</td>                
          <td style="height:'.$tinggi.'" align="center"></td> 
          <td style="height:'.$tinggi.'" align="center"></td>  
          <td style="height:'.$tinggi.'" align="center">'.$value['PRICE'].'</td>
          <td style="height:'.$tinggi.'" align="center">'.$barang*$value['PRICE'].'</td>
        </tr>';       
        array_push($detailPO,$tr);              
    }
?>
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
  </style>
  <title>Cetak Shipment Pembelian Langsung</title>
</head>
<body>
  <table>
    <thead>
      <tr>
        <td colspan="2"  valign="top">
          <div style="min-height:200px;">
            <table class="noborder">
              <tr>
                <td>
                  <img src="<?php echo site_url('static/images/logo/'.$company['logo']) ?>" width="40" alt="Logo Perusahaan">
                </td>
                <td colspan="2" style="padding:5px" class="mini">
                  <div><?php echo $company['nama'] ?></div>
                  <div>NPWP : <?php echo $company['npwp'] ?> </div>
                </td>
              </tr>
              <?php
                foreach($company['alamat'] as $_k => $alamat){
                  echo '<tr>
                    <td class="mini" valign="top">
                      '.$_k.'
                    </td>
                    <td class="mini" valign="top"> : </td>
                    <td class="mini">'.$alamat['detail'].'</td>
                  </tr>';
                }
              ?>

            </table>
          </div>
          <hr style="width:101%;border : 1px solid black"/>
          <div>NAMA PEMASOK :</div>
          <div class="vendor_name mini">
            <div><?php echo $vendor[0]['VENDOR_NAME'] ?></div>
            <div>PHONE: <?php echo $vendor[0]['CONTACT_PHONE_NO']?></div>
            <div>EMAIL: <?php echo $vendor[0]['EMAIL_ADDRESS']?></div>
            <div>ALAMAT: <?php echo $vendor[0]['ADDRESS_STREET'].', '.$vendor[0]['ADDRESS_CITY'];?></div>            
          </div>                    
        </td>
        <td valign="top" align="center" colspan="8">
          <div style="height:100px;font-weight:bold">
            <h2>SHIPMENT PEMBELIAN LANGSUNG</h2>
            <br >
<!--            ( Receiving Report )-->
          </div>
          <hr style="width:101%;border : 1px solid black"/>
          <div style="margin:0px">
            <table class="noborder" width="100%">
              <tr>
                <td>NO. PO</td>                
                <td> : <?=$detail[0]['PO_NO']?></td>                
              </tr>              
              <tr>
                <td>NO. SHIPMENT</td>                
                <td> : <?=$detail[0]['NO_SHIPMENT']?></td>                
              </tr>                    
              <tr>
                <td>TUJUAN</td>                
                <td> : <?=$detail[0]['PLANT']." - ".$detail[0]['DESC']?></td>                
              </tr>      
              <tr>
                <td>TANGGAL PEMBELIAN</td>                
                <td> : <?php 
                $date=date_create($detail[0]['DATE_BUY']);

                echo date_format($date,"d-m-Y");?></td>                
              </tr>
              <tr>
                <td>TANGGAL PENGIRIMAN</td>                
                <td> : <?php 
                $date=date_create($detail[0]['SEND_DATE']);

                echo date_format($date,"d-m-Y");?></td>                
              </tr>
            </table>
          </div>
        </td>        
      </tr>
      <tr>
        <td align="center">No</td>                        
        <td align="center">Material No</td>  
        <td align="center">Nama Barang</td>      
        <td align="center">Sat.</td>
        <td align="center">Jumlah Order</td>                
        <td align="center">Jumlah Pengiriman</td>        
        <td align="center">Jumlah Reject</td>  
        <td align="center">Jumlah Receipt</td>  
        <td align="center">Harga Satuan (Rp)</td>
        <td align="center">Jumlah Harga (Rp)</td>
      </tr>
    </thead>
    <tbody style="min-height:400px">
      <?php echo implode(' ',$detailPO) ?>
    </tbody>
  </table>
   
</body>

</html>
