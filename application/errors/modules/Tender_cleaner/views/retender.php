<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
              <div class="col-md-12">
                  <?php 
                  if ($this->session->flashdata('rfc_ft_return') != false): ?>
                      <div class="alert alert-danger alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <strong>Error SAP!</strong> <?php echo $this->session->flashdata('rfc_ft_return'); ?>
                      </div>
                  <?php //$rfc_ft_return = json_decode($this->session->flashdata('rfc_ft_return')); ?>
                  <!--<div class="alert alert-info alert-dismissible" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <p>FT_RETURN:</p>
                      <ul>
                          <?php foreach ($rfc_ft_return as $key => $value): ?>
                              <li>&nbsp;&nbsp;&nbsp;<?php echo $value->MESSAGE ?></li>
                          <?php endforeach ?>
                      </ul>
                      <div class="hidden hasil rfc">
                          <?php echo var_dump($rfc_ft_return) ?>
                      </div> 
                  </div>-->
                  <?php endif ?>              
              </div>
            </div>
            <div class="row">
                <form method="post" action="<?php echo base_url() ?>Tender_cleaner/save" class="submit">
                    <input type="hidden" name="ptm" value="<?php echo $ptm ?>"></input>
                    <input type="hidden" name="proses" value="<?php echo $proses ?>"></input>
                    <?php echo $detailptm ;?>
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        Pilih item yang akan di retender
                      </div>
                      <div class="panel-body">
                        <div class="table-responsive">
                          <table class="table table-hover table-bordered">
                            <thead>
                              <tr>
                                <th class="text-center"></th>
                                <th class="text-center col-md-2">PR No</th>
                                <th class="text-center col-md-1">PR Item</th>
                                <th class="text-center">Short Text</th>
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
                              <?php foreach ($tit as $val): ?>
                                <?php $total += $val['TIT_PRICE'] * $val['TIT_QUANTITY']; ?>
                                <tr>
                                  <td><input type="checkbox" class="cekitem" name="item[]" value="<?php echo $val['TIT_ID'] ?>"></td>
                                  <td class="prno text-center"><?php echo $val['PPI_PRNO'] ?></td>
                                  <td class="pritem text-center"><?php echo $val['PPI_PRITEM'] ?></td>
                                  <td class="nomat hidden"><?php echo $val['PPI_NOMAT'] ?></td>
                                  <td class="ppi hidden"><?php echo $val['PPI_ID'] ?></td>
                                  <td class="mrpc hidden"><?php echo $val['PPI_MRPC'] ?></td>
                                  <td class="plant hidden"><?php echo $val['PPI_PLANT'] ?></td>
                                  <td class="docat hidden"><?php echo $val['PPR_DOC_CAT'] ?></td>
                                  <td class="matgroup hidden"><?php echo $val['PPI_MATGROUP'] ?></td>
                                  <td class=""><a href="#!" class="snippet_detail_item decmat"><?php echo $val['PPI_DECMAT'] ?></a></td>
                                  <td class="qty text-right"><?php echo $val['TIT_QUANTITY'] ?></td>
                                  <td class="uom text-center"><?php echo $val['PPI_UOM'] ?></td>
                                  <td class="price text-right"><?php echo number_format($val['TIT_PRICE']) ?></td>
                                  <td class="per text-center"><?php echo $val['PPI_PER'] ?></td>
                                  <td class="curr text-center"><?php echo $val['PPI_CURR'] ?></td>
                                  <td class="subtotal text-right"><?php echo number_format( $val['TIT_QUANTITY'] * $val['TIT_PRICE']) ?></td>
                                </tr>
                              <?php endforeach ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <th class="text-center" colspan="9" style="text-align: right !important;">Total Price</th>
                              <th id="total-price-perencanaan" class="text-center" style="text-align: right !important;"><?php echo number_format($total) ?></th>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Komentar Anda</div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-3">Komentar</td>
                                    <td class="col-md-1 text-right">:</td>
                                    <td><textarea class="form-control" name="ptc_comment" id="ptc_comment"></textarea></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <a href="<?php echo base_url(); ?>Job_list/view" class="main_button color7 small_btn">Kembali</a>
                            <button id="submit-form" type="submit" class="main_button color6 small_btn">Retender</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>