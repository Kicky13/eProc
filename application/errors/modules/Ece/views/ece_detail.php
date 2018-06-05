<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form name="approval-form" id="approval-form" method="post" action="<?php echo base_url() ?>Ece/save" class="submit" enctype="multipart/form-data">
                    <input type="hidden" name="ptm" value="<?php echo $id ?>">
                    <input type="hidden" name="ec_id_group" value="<?php echo $ec_id_group ?>">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Detail Tender
                        </div>
                        <table class="table">
                            <tr>
                                <td class="col-md-3">Nomor Tender</td>
                                <td>: <?php echo $ptm['PTM_PRATENDER']?></td>
                            </tr>
                            <tr>
                                <td>Deskripsi</td>
                                <td>: <?php echo $ptm['PTM_SUBJECT_OF_WORK']?></td>
                            </tr>
                            <tr>
                                <td>Buyer</td>
                                <td>: <?php echo $ptm['FULLNAME']?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Item
                        </div>
                        <table class="table">
                            <tr>
                                <th class="text-center">No PR</th>
                                <th class="text-center">Item</th>
                                <th class="text-center">No Material</th>
                                <th class="text-center">Deskripsi</th>
                                <th class="text-center" class="col-md-1">ECE <?php echo ($pec)?'Awal':''; ?></th>
                                <?php if($pec): ?>
                                    <th class="text-center" class="col-md-1">ECE Perubahan</th>
                                <?php endif; ?>
                                <th class="text-center" class="col-md-4">Dokumen</th>
                            <?php foreach ($pti as $key => $value) {?>
                                <tr>
                                    <td class="ppi hidden"><?php echo $value['PPI_ID'] ?></td>
                                    <td class="mrpc hidden"><?php echo $value['PPI_MRPC'] ?></td>
                                    <td class="plant hidden"><?php echo $value['PPI_PLANT'] ?></td>
                                    <td class="plant_detail hidden"><?php echo isset($plant_master[$value['PPI_PLANT']]) ? $plant_master[$value['PPI_PLANT']]['PLANT_NAME'] : '' ?></td>
                                    <td class="docat hidden"><?php echo $value['PPR_DOC_CAT'] ?></td>
                                    <td class="matgroup hidden"><?php echo $value['PPI_MATGROUP'] ?></td>
                                    <td class="matgroup_detail hidden"><?php echo isset($mat_group_master[$value['PPI_MATGROUP']]) ? $mat_group_master[$value['PPI_MATGROUP']]['MAT_GROUP_NAME'] : '' ?></td>
                                    <td class="note hidden"><?php echo $value['TIT_NOTE'] ?></td>

                                    <td class="prno text-center" nowrap><?php echo $value['PPI_PRNO'] ?></td>
                                    <td class="pritem text-center"nowrap><?php echo $value['PPI_PRITEM'] ?></td>
                                    <td class="nomat text-center" nowrap><?php echo $value['PPI_NOMAT'] ?></td>
                                    <td class=""><a href="#!" class="snippet_detail_item decmat"><?php echo $value['PPI_DECMAT'] ?></a></td>
                                    <td class="col-md-1 text-center">
                                        <?php if($pec): ?>
                                            <input type="hidden" name="ece_update" value="1">
                                            <?php echo number_format($value['TIT_PRICE']) ?>
                                        <?php else: ?>
                                            <input type="text" class="form-control text-right must_autonumeric"  name="price[<?php echo $value['TIT_ID'] ?>]" value="<?php echo $value['TIT_PRICE']?>" required>
                                        <?php endif; ?>     
                                    </td>   
                                    <?php if($pec): ?>
                                        <input type="hidden" class="form-control" name="ece_id[<?php echo $value['TIT_ID'] ?>]" value="<?php echo $pec[$value['TIT_ID']]['EC_ID'] ?>">
                                        <td><input type="text" class="form-control text-right must_autonumeric"  name="price[<?php echo $value['TIT_ID'] ?>]" value="<?php echo $pec[$value['TIT_ID']]['PRICE_AFTER']?>" required></td>
                                    <?php endif; ?>
                                    <td class="col-md-3"><input type="file" class="form-control text-right" name="file[<?php echo $value['TIT_ID'] ?>]" <?php echo ($pec)?'':'required'; ?>></td>
                                </tr>    
                            <?php } ?>
                        </table>
                    </div>
                    <?php echo $ece_comment; ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Komentar Anda</div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-1"></td>
                                    <td class="col-md-4">Komentar</td>
                                    <td>
                                        <textarea maxlength="200" name="comment" id="comment" class="form-control" style="resize:vertical"></textarea> 
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>                    
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <a href="<?php echo base_url(); ?>/Ece" class="main_button color7 small_btn">Kembali</a>
                            <select name="next_process" class="harusmilih_publicjs">
                                <option value="false_public"></option>
                                <option value="1"><?php echo $next_process['nama'] ?></option>
                            </select>
                            <input class="subjudul" type="hidden" value=""></input>
                            <button type="submit" class="formsubmit main_button color7 small_btn milihtombol_publicjs" disabled>OK</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal_detail_item_snippet">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">Detail Item</div>
      <div class="modal-body">
        <table class="table table-hover">
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
        </table>
        <div class="service_line_snippet_item"></div>
        <div class="long_text_snippet_item"></div>
        <div class="panel panel-default">
            <div class="panel-heading">Note Evaluasi ECE</div>
            <div class="panel-body">
                <table class="table table-hover">
                    <tr>
                        <td>Note </td>
                        <td class="snippet_modal_note"></td>
                    </tr>
                </table>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
