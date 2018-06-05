<?php  
foreach($data as $d => $v){
  $totalOp+=$v['PRICE']*$v['QTY_RECEIPT'];
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