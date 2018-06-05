<div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label class="col-md-2 control-label">PRINT TYPE </label>
        <div class="col-md-3">
          

          <select <?php echo $count > 1 ? 'disabled' : 'name="PRINT_TYPE"'; ?>>
            <option value="SINGLE">Print Single GR</option>
            <option value="LOT" <?php echo $count > 1 ? 'selected' : ''; ?>>Print Lotted GR</option>
          </select> 

          <?php
          if($count > 1) echo "<input type='text' class='hide' name='PRINT_TYPE' value='LOT'>";
          ?>

        </div>
      </div>
    </div>
    <br/><br/>
    <div class="col-md-12">
      <table class="table table-bordered">
      <thead>
          <tr>
              <th class="text-center">NO</th>
              <th class="text-center">NO RR</th>
              <th class="text-center">DOC DATE</th>
              <th class="text-center">PO ITEM NO</th>
              <th class="text-center">NO MATERIAL</th>
              <th class="text-center">MATERIAL</th>
              <th class="text-center">QTY</th>
              <th class="text-center">AMOUNT</th>
          </tr>
      </thead>
      <tbody>
        
        <?php
        $total_amount = 0;
        $total_qty = 0; 
        $no = 0;
        foreach($detail as $in => $val){
          foreach ($val as $val2) {
            $no++;
            echo '
                <tr>
                  <td class="text-center">'.$no.'</td>
                  <td>'.$val2['GR_NO'].'</td>
                  <td>'.$val2['CREATE_ON2'].'</td>
                  <td class="text-center">'.$val2['PO_ITEM_NO'].'</td>
                  <td>'.$val2['MATERIAL_NO'].'</td>
                  <td>'.$val2['DESCRIPTION'].'</td>
                  <td>'.ribuan($val2['GR_ITEM_QTY']).'</td>
                  <td>'.ribuan($val2['GR_AMOUNT_IN_DOC']).'</td>
                </tr>
            ';
            $total_amount += $val2['GR_AMOUNT_IN_DOC'];
            $total_qty += $val2['GR_ITEM_QTY']; 
          }
        }
        ?>
            <tr>
              <td colspan="6" class="text-center">JUMLAH TOTAL</td>
              <td><?php echo ribuan($total_qty);?></td>
              <td><?php echo ribuan($total_amount);?></td>
            </tr>

          </tbody>
          
          <tfoot>
            <tr>
              <td colspan="8" class="text-center"><span data-gr='<?php echo $gr ?>' class="btn btn-primary" onclick="SubmitLot(this)">Submit</span></td>
            </tr>
          </tfoot>
        </table>

    </div>
</div>
