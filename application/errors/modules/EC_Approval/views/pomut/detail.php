<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
          <?php echo form_open_multipart($url, array('method' => 'POST', 'class' => 'form-horizontal formEdit', 'id' => 'formDetailGR')); ?>
            <div class="panel panel-default">
                <div class="panel-heading">Data Berita Acara Potongan Mutu No. <span style="font-size:100%;"><?php echo $ba_no;?></span></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-lg-12 col-lg-12">
                          <div class="col-md-6 col-sm-6 col-lg-6 col-lg-6">  
                            <div class="form-group">
                                <label class="col-md-4 control-label">PO</label>
                                <div class="col-md-8">
                                  <input type="text" readonly value="<?php echo $po_no ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" >NO. BERITA ACARA </label>
                                <div class="col-md-8">
                                  <input type="text" name="NO_BA" readonly value="<?php echo $ba_no ?>" />          
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">MATERIAL</label>
                                <div class="col-md-8">
                                  <input type="text" readonly value="<?php echo $material ?>" />    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">VENDOR</label>
                                <div class="col-md-8">
                                  <textarea readonly ><?php echo $vendor ?> </textarea>
                                </div>
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-6 col-lg-6 col-lg-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">TANGGAL BA</label>
                                <div class="col-md-4">
                                  <div class="input-group date startDate">
                                  <input readonly="" <?php echo $status==1 ? 'required="" id="TGL_BA"' : '';?>   class="form-control" name="TGL_BA"  type="text" value="<?php echo $status==1 ? date('d-m-Y') : $header['TGL_BA2'] ?>">
                                    <span class="input-group-addon">
                                        <a href="javascript:void(0)">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                        </a>
                                    </span>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">KOTA</label>
                                <div class="col-md-8">
                                  <input type="text" name="KOTA" <?php echo $status==1 ? 'required=""' : 'disabled=""';?>  value="<?php echo $header['KOTA'] == null ? 'Tuban' : $header['KOTA']?>" />          
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">KASI PENGADAAN BAHAN</label>
                                <div class="col-md-8">
                                  <input type="text" required="" <?php echo $status==1 ? 'required=""' : 'disabled=""';?> name="KASI_PENGADAAN" value="<?php echo $header['KASI_PENGADAAN'] == null ? 'MOH. MUHLIS ZAINUDDIN, ST.' : $header['KASI_PENGADAAN']?>" />    
                                </div>
                            </div>
                          </div>
                            <div class="col-md-12 col-sm-12 col-lg-12 col-lg-12">
                                <div class="col-md-12 text-center"><strong>DETAIL BERITA ACARA ANALISA MUTU</strong></div>
                                <div class="col-md-12 ">
                                  <div class="table-responsive" style="margin: 20px">
                                  <table class="table table-bordered table-collapse text-center">
                                    <thead>
                                      <tr>
                                        <th rowspan="2" class="text-center">Insp. Lot / No. Gr</th>
                                        <th rowspan="2" class="text-center">Qty</th>
                                        <th rowspan="2" class="text-center">Harga Satuan</th>
                                        <th rowspan="2" class="text-center">Total Harga</th>
                                        <th colspan="3" class="text-center">Hasil Analisa</th>
                                        <th colspan="3" class="text-center">Jumlah Potongan</th>
                                        <th rowspan="2" class="text-center">Harga Satuan / Stl Potongan</th>
                                        <th rowspan="2" class="text-center">Jumlah Pembayaran</th>
                                        <th rowspan="2" class="text-center">Status</th>
                                      </tr>
                                      <tr>
                                        <th class="text-center"><?php echo $detail[0]['MIC1'] == NULL ? '-' : $detail[0]['MIC1'];?></th>
                                        <th class="text-center"><?php echo $detail[0]['MIC2'] == NULL ? '-' : $detail[0]['MIC2'];?></th>
                                        <th class="text-center"><?php echo $detail[0]['MIC3'] == NULL ? '-' : $detail[0]['MIC3'];?></th>
                                        <th class="text-center"><?php echo $detail[0]['MIC1'] == NULL ? '-' : $detail[0]['MIC1'];?></th>
                                        <th class="text-center"><?php echo $detail[0]['MIC2'] == NULL ? '-' : $detail[0]['MIC2'];?></th>
                                        <th class="text-center"><?php echo $detail[0]['MIC3'] == NULL ? '-' : $detail[0]['MIC3'];?></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                  <?php
                                  $total_harga = 0;
                                  $total_Bayar = 0;
                                  $total_qty = 0;

                                    foreach($detail as $d){
                                      echo '<tr>
                                              <td>'.$d['PRUEFLOS'].'/'.$d['MBLNR'].'</td>
                                              <td>'.$d['LOTQTY'].'</td>
                                              <td>'.ribuan($d['HARSAT']).'</td>
                                              <td>'.ribuan($d['POVALUE']).'</td>
                                              <td>'.$d['ORI_INPUT1'].'</td>
                                              <td>'.$d['ORI_INPUT2'].'</td>
                                              <td>'.$d['ORI_INPUT3'].'</td>
                                              <td>'.ribuan($d['QLTDVALT1']).'</td>
                                              <td>'.ribuan($d['QLTDVALT2']).'</td>
                                              <td>'.ribuan($d['QLTDVALT3']).'</td>
                                              <td>'.ribuan($d['POT']).'</td>
                                              <td>'.ribuan($d['JML_BAYAR']).'</td>
                                              <td>'.$d['KURZTEXT'].'</td>
                                            </tr>';
                                          $total_qty += $d['LOTQTY'];
                                          $total_harga += $d['POVALUE'];
                                          $total_Bayar += $d['JML_BAYAR'];
                                    }
                                  ?>
                                    <tr>
                                      <td></td>
                                      <td class="r bold"><?php echo ribuan($total_qty); ?></td>
                                      <td></td>
                                      <td class="r bold"><?php echo ribuan($total_harga); ?></td>
                                      <td colspan="7"></td>
                                      <td class="r bold"><?php echo ribuan($total_Bayar); ?></td>
                                      <td></td>
                                    </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-md-2 control-label">&nbsp;</label>

                                <div class="col-md-1 text-center"><a href="<?php echo base_url('EC_Approval/Pomut');?>" class="btn btn-warning">Kembali</a></div>
                                <div class="col-md-2 text-center"><a href="#" data-no_ba="<?php echo $ba_no;?>" onClick="cetakDokumen(this)" class="btn btn-info">Print Preview</a></div>
                          <?php
                            if($act != 'view'){
                          ?>
                                <div class="col-md-1 text-center"><button type="submit" class="btn btn-success"><?php echo $status == 1 ? 'Create BA' : 'Approve'?></button></div>
                          <?php
                            echo $act;
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