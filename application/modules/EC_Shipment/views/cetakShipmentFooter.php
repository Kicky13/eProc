<?php  
foreach($po as $d => $v){
  $totalOp+=$v['PRICE']*($v['QTY']-($v['QTY_RECEIPT']+$v['QTY_REJECT']));
}
?>
<hr>
<table class="noborder">
    <tr>
      <td>&nbsp;&nbsp;Dengan Huruf,</td>
      <td style="width:400px;height:25px;border:1px solid black"><div>&nbsp;<?php echo terbilang($totalOp,4) ?></div></td>
      <td>Rp.</td>
      <td style="width:170px;height:25px;border:1px solid black"><div>&nbsp;<?php echo ribuan($totalOp) ?></div></td>
    </tr>
</table>
<table class="noborder" widht='100%' style="margin-top:10px">
    <tr>      
      <td style="width:550px"></td>
      <td>Vendor</td>
    </tr>
    <tr>      
      <td style="width:550px"></td>
      <td><barcode code="<?php echo $barcode ?>" size="0.7" type="QR" error="M" class="barcode" /></td>
    </tr>
 
    <tr>      
      <td style="width:550px"></td>
      <td>___________________________</td>
    </tr>
  </table>