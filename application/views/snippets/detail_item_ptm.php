
<div class="panel panel-default">
  <div class="panel-heading">
    Item Terpilih
  </div>
  <div class="panel-body" style="overflow: auto;">
    <div class="table-responsive">
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
            <?php if (!$for_vendor): ?>
            <th class="text-center col-md-2">PR No</th>
            <!-- <th class="text-center col-md-1"><?php echo $is_jasa==0? 'PR Item' : 'Svc Line Item'; ?></th> -->
            <th class="text-center col-md-1">PR Item</th>
            <?php endif ?>
            <?php if ($for_vendor): ?>
            <th>Mat Number</th>
            <?php endif ?>
            <th class="text-center">Short Text</th>
            <th class="text-center col-md-1" style="width:50px">T</th>
            <th class="text-center col-md-1">Quantity</th>
            <?php if($for_update_qty): ?>
              <th class="text-center col-md-1">Quantity Update</th>
              <th class="text-center col-md-1">File</th>
              <th class="text-center col-md-1">Note</th>
            <?php endif ?>
            <th class="text-center col-md-1">Uom</th>
            <?php if (!$for_vendor): ?>
            <th class="text-center col-md-1">Price</th>
            <th class="text-center col-md-1">Per</th>
            <th class="text-center col-md-1">Curr</th>
            <?php if(!$for_update_qty): ?>
              <th class="text-center col-md-1">Total Price</th>
            <?php endif; ?>
            <?php endif ?>
          </tr>
        </thead>
        <tbody id="tableItem">
          <?php $total = 0; ?>
          <?php foreach ($tit as $val): ?>
            <?php $total += $val['TIT_PRICE'] * $val['TIT_QUANTITY']; ?>
            <tr>
              <?php if (!$for_vendor): ?>
              <td class="prno text-center"><?php echo $val['PPI_PRNO'] ?></td>
              <td class="pritem text-center"><?php echo $val['PPI_PRITEM'] ?></td>
              <?php endif ?>
              <?php if ($for_vendor): ?>
              <td class=""><?php echo $val['PPI_NOMAT'] ?></td>
              <?php endif ?>
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
                ?>
                <input type="hidden" name="countTender[]" value="<?php echo $ct[$val['PPI_ID']]; ?>">
              </td>
              <td class="qty text-center"><?php echo $val['TIT_QUANTITY'] ?></td>
              <?php if($for_update_qty): ?>
                  <?php if($val['TIT_STATUS'] != 10): ?> <!-- 10=po release -->
                    <input type="hidden" name="tit_status[<?php echo $val['TIT_ID'] ?>]" value="<?php echo $val['TIT_STATUS'] ?>">
                    <input type="hidden" id="qtyLama_<?php echo $val['TIT_ID'] ?>" name="qtyLama[<?php echo $val['TIT_ID'] ?>]" value="<?php echo $val['TIT_QUANTITY'] ?>">
                    <td><input type="text" id="qtyBaru_<?php echo $val['TIT_ID'] ?>" onkeyup="cekUpdateQty(<?php echo $val['TIT_ID'] ?>, this.value)" name="qtyUpdate[<?php echo $val['TIT_ID'] ?>]" class="col-md-8 number" style="text-align:center"></td>
                    <td class="col-md-1"><input type="file" name="file[<?php echo $val['TIT_ID'] ?>]" ></td>
                    <td><textarea name="note[<?php echo $val['TIT_ID'] ?>]" style="resize:vertical"></textarea></td>
                <?php else: ?>
                    <td></td><td></td><td></td>
                <?php endif ?>
              <?php endif ?>
              <td class="uom text-center"><?php echo $val['PPI_UOM'] ?></td>
              <?php if (!$for_vendor): ?>
              <td class="price text-right"><?php echo number_format($val['TIT_PRICE']) ?></td>
              <td class="per text-center"><?php echo $val['PPI_PER'] ?></td>
              <td class="curr text-center"><?php echo $val['PPI_CURR'] ?></td>
              <?php if(!$for_update_qty): ?>
                <td class="subtotal text-right"><?php echo number_format( $val['TIT_QUANTITY'] * $val['TIT_PRICE']) ?></td>
              <?php endif; ?>
              <?php endif ?>
            </tr>
          <?php endforeach ?>
        </tbody>
        <?php if (!$for_vendor): ?>
          <?php if(!$for_update_qty): ?>
          <tfoot>
            <tr>
              <th class="text-center" colspan="9" style="text-align: right !important;">Total Price</th>
            <th id="total-price-perencanaan" class="text-center" style="text-align: right !important;"><?php echo number_format($total) ?></th>
            </tr>
          </tfoot>
        <?php endif ?>
        <?php endif ?>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_detail_item_snippet">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">Detail Item</div>
      <div class="modal-body">
        <table class="table table-hover">
          <?php if (!$for_vendor): ?>

          <tr>
            <td>PR Item</td>
            <td class="snippet_modal_pritem"></td>
          </tr>
          <tr>
            <td>PR No</td>
            <td class="snippet_modal_prno"></td>
          </tr>
          <tr>
            <td>Mat Number</td>
            <td class="snippet_modal_nomat"></td>
          </tr>
         <!--  <tr>
            <td>Short Text</td>
            <td class="snippet_modal_decmat"></td>
          </tr> -->
          <tr>
            <td>Mat Group</td>
            <td class="snippet_modal_matgroup"></td>
          </tr>
          <tr>
            <td>MRPC</td>
            <td class="snippet_modal_mrpc"></td>
          </tr>
          <tr>
            <td>Plant</td>
            <td class="snippet_modal_plant"></td>
          </tr>
          <?php endif ?>
        </table>
        <div class="service_line_snippet_item"></div>
        <div class="long_text_snippet_item"></div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $modal_item = $("#modal_detail_item_snippet");
    $modal_item.detach();
    $modal_item.appendTo('body');

    $(".snippet_detail_item").click(function() {
      $tr = $(this).parent().parent();
      ppi_id = $tr.find('.ppi').html();
      nomat = $tr.find('.nomat').html();

      $("#modal_detail_item_snippet").modal('show');

      /* populate detail item */
      $(".snippet_modal_pritem").html($tr.find('.pritem').html());
      $(".snippet_modal_prno").html($tr.find('.prno').html());
      $(".snippet_modal_nomat").html($tr.find('.nomat').html()+ ' ' + $tr.find('.decmat').html());
      // $(".snippet_modal_decmat").html($tr.find('.decmat').html());
      $(".snippet_modal_matgroup").html($tr.find('.matgroup').html()+ ' ' + $tr.find('.matgroup_detail').html());
      $(".snippet_modal_mrpc").html($tr.find('.mrpc').html());
      $(".snippet_modal_plant").html($tr.find('.plant').html() + ' ' + $tr.find('.plant_detail').html());
      //*/

      /* get long text */
      $.ajax({
        url: $("#base-url").val() + 'Snippet_ajax/getlongtext/' + ppi_id + '/' + nomat,
        type: 'GET',
        dataType: 'html',
      })
      .done(function(data) {
        $(".long_text_snippet_item").html(data);
      })
      .fail(function() {
        console.log("error");
      })
      .always(function(data) {
        console.log(data);
      });
      //*/

      docat = $tr.find('.docat').html();
      if (docat == '9') {
        /* get service line */
        $.ajax({
          url: $("#base-url").val() + 'Snippet_ajax/pr_doc_service/' + ppi_id,
          type: 'get',
          dataType: 'html',
          
        })
        .done(function(data) {
          $(".service_line_snippet_item").html(data);
        })
        .fail(function() {
          console.log("error");
        })
        .always(function(data) {
          console.log(data);
        });
        
      }
    });

    $(".number").keypress(function(data){
        if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)) 
        {
          return false;
        }
    });

  });

  function cekUpdateQty(titId,val){
      qtyLama = $('#qtyLama_'+titId).val();
      if(Number(val) > Number(qtyLama)){
        alert('Quantity update tidak boleh melebihi quantity sebelumnya.');
        $('#qtyBaru_'+titId).val('');
        $('#qtyBaru_'+titId).focus();
      }
      if(Number(val)==0){
        alert('Quantity update tidak boleh 0.');
        $('#qtyBaru_'+titId).val('');
        $('#qtyBaru_'+titId).focus();
      }
  }
</script>