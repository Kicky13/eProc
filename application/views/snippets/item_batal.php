<div class="panel panel-default">
  <div class="panel-heading">
    Item Batal
  </div>
  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
         
            <th class="text-center col-md-2">PR No</th>
            <th class="text-center col-md-1">PR Item</th>      
         
            <th class="text-center">Short Text</th>
            <th class="text-center col-md-1" style="width:50px">T</th>
            <th class="text-center col-md-1">Quantity</th>
            <th class="text-center col-md-1">Uom</th>
           
            <th class="text-center col-md-1">Price</th>
            <th class="text-center col-md-1">Per</th>
            <th class="text-center col-md-1">Curr</th>
            <th class="text-center col-md-1">Total Price</th>
           
          </tr>
        </thead>
        <tbody id="tableItem">
          <?php $total = 0; ?>
          <?php //var_dump($tit);?>
          <?php foreach ($tit as $val): ?>
            <?php $total += $val['TIT_PRICE'] * $val['TIT_QUANTITY']; ?>
            <tr>
           
              <td class="prno text-center"><?php echo $val['PPI_PRNO'] ?></td>
              <td class="pritem text-center"><?php echo $val['PPI_PRITEM'] ?></td>
           
              <td class="nomat hidden"><?php echo $val['PPI_NOMAT'] ?></td>
              <td class="ppi hidden"><?php echo $val['PPI_ID'] ?></td>
              <td class="mrpc hidden"><?php echo $val['PPI_MRPC'] ?></td>
              <td class="plant hidden"><?php echo $val['PPI_PLANT'] ?></td>
              <td class="plant_detail hidden"><?php echo isset($plant_master[$val['PPI_PLANT']]) ? $plant_master[$val['PPI_PLANT']]['PLANT_NAME'] : '' ?></td>
              <td class="docat hidden"><?php echo $val['PPR_DOC_CAT'] ?></td>
              <td class="matgroup hidden"><?php echo $val['PPI_MATGROUP'] ?></td>
              <td class="matgroup_detail hidden"><?php echo isset($mat_group_master[$val['PPI_MATGROUP']]) ? $mat_group_master[$val['PPI_MATGROUP']]['MAT_GROUP_NAME'] : '' ?></td>
              <td class=""><a href="#!" class="snippet_detail_item decmat"><?php echo $val['PPI_DECMAT'] ?></a></td>
              <td class="text-center"><?php 
                if(isset($ct[$val['PPI_ID']])){
                  // echo $ppi[$val['PPI_ID']]+1;
                  echo $ct[$val['PPI_ID']];
                }
              ?></td>
              <td class="qty text-right"><?php echo $val['TIT_QUANTITY'] ?></td>
              <td class="uom text-center"><?php echo $val['PPI_UOM'] ?></td>
              
              <td class="price text-right"><?php echo number_format($val['TIT_PRICE']) ?></td>
              <td class="per text-center"><?php echo $val['PPI_PER'] ?></td>
              <td class="curr text-center"><?php echo $val['PPI_CURR'] ?></td>
              <td class="subtotal text-right"><?php echo number_format( $val['TIT_QUANTITY'] * $val['TIT_PRICE']) ?></td>
              
            </tr>
          <?php endforeach ?>
        </tbody>        
      </table>
    </div>
  </div>
</div>