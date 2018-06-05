<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <?php
            $pesannya = $this->session->flashdata('message');
            if (!empty($pesannya)) {
                echo '<div class="alert alert-danger">' . $pesannya . '</div>';
            }
            ?>

          <?php echo form_open_multipart($urlsubmit, array('method' => 'POST', 'class' => 'form-horizontal formEdit', 'id' => 'formDetailGR')); ?>
            <div class="panel panel-default">
                <div class="panel-heading">Data PO <span style="font-size:100%;"><?php echo $po_no.' tahun '.$gr_year  ?></span></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-lg-12 col-lg-12">
                            <?php 
                    if($reject_by != null){
                        echo '                    
                            <div class="form-group">
                                <label class="col-md-2 control-label">Rejected By</label>
                                <div class="col-md-6">
                                  <input type="text" disabled value="'.$reject_by.'" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Note Reject</label>
                                <div class="col-md-6">
                                <textarea class="form-control" disabled>"'.$note_reject.'"</textarea>
                                </div>
                            </div>';
                    }
                  ?>

                            <div class="form-group">
                                <label class="col-md-2 control-label">PO</label>
                                <div class="col-md-6">
                                  <input type="text" readonly name="PO_NO" value="<?php echo $po_no ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" >YEAR</label>
                                <div class="col-md-6">
                                  <input type="text" name="GR_YEAR" readonly value="<?php echo $gr_year ?>" />
                            <?php if($levelAcess != 0){ 
                                  echo '<input type="text" class="hide" name="LOT_NUMBER" readonly value="'.$lot_number.'" />
                                        <input type="text" name="status" value="1" class="hide">';
                            }?>                               
                                </div>
                            </div>
                  <?php 
                    if($detail_type == 'rr'){
                        echo '                    
                            <div class="form-group">
                                <label class="col-md-2 control-label">RR NO</label>
                                <div class="col-md-6">
                                  <input type="text" readonly name="NO_RR" value="'.$rr.'" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">DESCRIPTION</label>
                                <div class="col-md-6">
                                  <input type="text" readonly value="'.$desc.'" />
                                </div>
                            </div>';
                    }
                  ?>
                            <div class="form-group">
                                <label class="col-md-2 control-label">VENDOR</label>
                                <div class="col-md-6">
                                  <textarea readonly ><?php echo $vendor ?> </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">DETAIL GR</label>
                                <div class="col-md-10">
                                  <table class="table table-bordered table-collapse text-center">
                                    <thead>
                                      <tr>
                                        <th class="text-center">PO ITEM NO</th>
                                        <th class="text-center">PLANT</th>
                                        <th class="text-center">DESCRIPTION</th>
                                        <th class="text-center">MATERIAL NO</th>                                        
                                        <th class="text-center">GR NO</th>
                                        <th class="text-center">GR ITEM NO</th>
                                        <th class="text-center">DOC DATE</th>
                                        <th class="text-center">QTY</th>
                                        <th class="text-center">AMOUNT</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                  <?php
                                  $total_amount = 0;
                                  $total_qty = 0;
                                    foreach($detail as $d){
                                      echo '<tr>
                                              <td>'.$d['PO_ITEM_NO'].'</td>
                                              <td>'.$d['WERKS'].'</td>
                                              <td>'.$d['DESCRIPTION'].'</td>
                                              <td>'.$d['MATERIAL_NO'].'</td>
                                              <td><input class="hide" name="GR_NO[]" value="'.$d['GR_NO'].'" />'.$d['GR_NO'].'</td>
                                              <td><input class="hide" name="GR_ITEM_NO[]" value="'.$d['GR_ITEM_NO'].'" />'.$d['GR_ITEM_NO'].'</td>
                                              <td><input class="hide" name="GR_YEAR[]" value="'.$d['GR_YEAR'].'" />'.$d['CREATE_ON2'].'</td>
                                              <td>'.$d['GR_ITEM_QTY'].'</td>
                                              <td>'.ribuan($d['GR_AMOUNT_IN_DOC']).'</td>
                                            </tr>';
                                          $total_amount += $d['GR_AMOUNT_IN_DOC'];
                                          $total_qty += $d['GR_ITEM_QTY'];
                                    }
                                  ?>
                                    <tr>
                                      <td colspan="7" class="text-center">JUMLAH TOTAL</td>
                                      <td><?php echo ribuan($total_qty)?></td>
                                      <td><?php echo ribuan($total_amount)?></td>
                                    </tr>
                                    </tbody>
                                  </table>
                                </div>
                            </div>

                            <div class="form-group">
                              <label class="col-md-2 control-label">&nbsp;</label>
                                
                            <?php
                                
                                $url = site_url('EC_Approval/Gr');
                                
                                if($act == 'view'){
                                    $url = site_url('EC_Approval/Gr/cetak');
                                }
                                echo '<div class="col-md-1"><a href="'.$url.'" class="btn btn-warning">Kembali</a></div>';
                                
                                if($levelAcess != 0 && $act != 'view'){
                                    echo '<div class="col-md-1"><button class="btn btn-info" type="submit" >Approve</button></div>';
                                    echo '<div class="col-md-1"><a class="btn btn-danger" onclick="reject(this)">Reject</a></div>';
                                }
                            ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          <?php echo form_close() ?>
        </div>
    </div>
</section>

<div id="rejectNote" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reject Note</h4>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart(base_url('EC_Approval/Gr/approve'), array('method' => 'POST', 'class' => 'form-horizontal formEdit')); ?>
        <div class="form-group">
            <div class="form-group">
                <input type="text" name="LOT_NUMBER" class="hide">
                <input type="text" name="status" value="0" class="hide">
                <label for="Invoice No" class="col-sm-3 control-label">Alasan Reject</label>
                <div class="col-sm-8">
                    <textarea class="form-control" required="" id="msg" name="msg"></textarea>
                </div>
            </div>
            <div class="col-sm-12 text-center">
                <button type="submit" class="btn btn-success">Submit</button>
                <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>