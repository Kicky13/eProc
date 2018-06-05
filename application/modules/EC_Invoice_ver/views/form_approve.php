<div class="form-group">
    <label  class="col-sm-2 control-label">Doc. Type</label>
    <div class="col-sm-3 tgll">
        <select class="form-control" name="doc_type" data-static="RE" onclick="Invoice.dropdownStatic(this)">
            <?php
                foreach($doc_type as $key => $val){
                    $selected = $key == $default_doc_type ? 'selected' : '';
                    echo '<option value="'.$key.'" '.$selected.'>'.$key.' - '.$val.'</option>';
                }
            ?>
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Posting Date</label>
    <div class="col-sm-3 tgll">
        <div class="input-group date">
            <input readonly="" required=""  class="form-control" name="posting_date"  type="text" value="<?php echo $posting_date ?>">
            <span class="input-group-addon">
                <a href="javascript:void(0)">
                    <i class="glyphicon glyphicon-calendar"></i>
                </a>
            </span>
        </div>
    </div>
</div>

<div class="form-group">
    <label  class="col-sm-2 control-label">Baseline Date</label>
    <div class="col-sm-3 tgll">
        <div class="input-group date">
            <input readonly="" required="" class="form-control" name="baseline_date"  type="text" value="<?php echo $baseline_date ?>">
            <span class="input-group-addon">
                <a href="javascript:void(0)">
                    <i class="glyphicon glyphicon-calendar"></i>
                </a>
            </span>
        </div>
    </div>
</div>

<div class="form-group">
    <label  class="col-sm-2 control-label">Payment Block</label>
    <div class="col-sm-3 tgll">
        <select class="form-control" name="payment_block">
            <?php
                foreach($pay_block as $key => $val){
                    echo '<option value="'.$key.'">'.$key.' - '.$val.'</option>';
                }
            ?>
        </select>
    </div>
    <?php if(isset($pph_inv)){ ?>
    <p class="help-block">** Ketika diapprove otomatis payment block akan diset menjadi payment proposal </p>
    <?php } ?>
</div>

<div class="form-group">
    <label  class="col-sm-2 control-label">Payment Method</label>
    <div class="col-sm-3 tgll">
        <select class="form-control"  name="payment_method">
            <?php
                foreach($pay_method as $key => $val){
                    echo '<option value="'.$key.'">'.$key.' - '.$val.'</option>';
                }
            ?>
        </select>
    </div>
</div>

<?php if(isset($pph_inv)){ ?>
  <div class="form-group">
      <label for="faktur" class="col-sm-2 control-label">DPP</label>
      <?php
      $baseAmount = 0;
      foreach($GR as $g){
          $baseAmount += $g['GR_AMOUNT_IN_DOC'];
      }

      ?>
      <div class="col-sm-3">
          <input type="text" class="form-control" id="text_amount_help" value="<?php echo ribuan($baseAmount) ?>" data-baseamount="<?php echo $baseAmount ?>" readonly>
      </div>
</div>
<div class="form-group">
    <label  class="col-sm-2 control-label">With Tax Holding</label>
    <div class="col-sm-10 col-md-9">
        <label class="glyphicon glyphicon-plus control-label" onclick="Invoice.showPajak(this)"></label>
        <div class="row list_pajak" style="display: none">
            <?php
            if(!empty($pph_inv)){
                echo '<table class="table table-bordered">';
                echo '<thead>'
                        . '<tr>'
                            . '<th>Wtax Type</th>'
                            . '<th>Wtax Type Desc</th>'
                            . '<th>Wtax Code</th>'
                            . '<th>Base Amount</th>'
                        . '</tr>'
                    . '</thead>'
                    . '<tbody>';
                foreach($pph_inv as $pph){
                  $pajakTersimpan = isset($withtaxdata[$pph['WITHT']]) ? $withtaxdata[$pph['WITHT']] : array();
                  echo '<tr>'
                    . '<td><input type="hidden"  name="WTAX_TYPE['.$pph['WITHT'].']" value="'.$pph['WITHT'].'">'.$pph['WITHT'].'</td>'
                    . '<td>'.$pph['TEXT40'].'</td>'
                    . '<td><select name="WTAX_CODE['.$pph['WITHT'].']">';
                    if(!empty($list_child_tax)){
                      foreach($list_child_tax[$pph['WITHT']] as $_tc){
                          $selected = '';
                          if(isset($pajakTersimpan['WI_TAX_CODE'])){
                            $selected = $pajakTersimpan['WI_TAX_CODE'] == $_tc['WT_WITHCD'] ? 'selected' : '';
                          }

                          echo '<option '.$selected.' value="'.$_tc['WT_WITHCD'].'">'.$_tc['WT_WITHCD'].'  - '.$_tc['TEXT40'].'</option>';
                      }
                    }
                   echo '</select></td>'
                    . '<td><input type="text" value="'.(isset($pajakTersimpan['WI_TAX_BASE']) ? $pajakTersimpan['WI_TAX_BASE'] : '').'" name="WTAX_AMOUNT['.$pph['WITHT'].']"></td>'
                    . '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            }
            ?>

        </div>


    </div>
</div>
<?php } ?>
