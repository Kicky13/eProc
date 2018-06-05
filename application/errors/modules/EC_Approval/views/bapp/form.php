<?php
$isReadonly = $bisaEdit ? '' : 'readonly';
?>
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-10">
        <?php echo form_open_multipart($urlAction, array('method' => 'POST', 'class' => 'form-horizontal', 'data-approval '=> 1)); ?>
        <div class="form-group">
            <label for="" class="col-sm-3 control-label">No. PO</label>
            <div class="col-sm-9">
                <input type="text" class="form-control"  required name="NO_PO" readonly value="<?php echo $dataBapp['NO_PO'] ?>">
                <input type="hidden" class="form-control"  name="COMPANY" readonly value="<?php echo $dataBapp['COMPANY'] ?>">
                <input type="hidden" class="form-control"  name="NO_VENDOR" readonly value="<?php echo $dataBapp['NO_VENDOR'] ?>">
            </div>

        </div>
        <div class="form-group">
            <label for="po_item" class="col-sm-3 control-label">PO. Item</label>
            <div class="col-sm-9">
                <input class="form-control" name="PO_ITEM" readonly value="<?php echo $dataBapp['PO_ITEM'] ?>" >
            </div>
        </div>
        <div class="form-group">
            <label for="pekerjaan" class="col-sm-3 control-label">Pekerjaan</label>
            <div class="col-sm-9">
                <textarea class="form-control" name="SHORT_TEXT" readonly><?php echo $dataBapp['SHORT_TEXT'] ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="Description" class="col-sm-3 control-label">Description</label>
            <div class="col-sm-9">
                <textarea class="form-control editor-html"  required name="DESCRIPTION" readonly ><?php echo $dataBapp['DESCRIPTION'] ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="pengawas" class="col-sm-3 control-label">Pengawas</label>
            <div class="col-sm-9">
                <input class="form-control" name="PENGAWAS" value="<?php echo $dataBapp['PENGAWAS'] ?>" readonly required>
            </div>

        </div>
        <div class="form-group">
            <label for="jabatan" class="col-sm-3 control-label">Jabatan</label>
            <div class="col-sm-9">
                <input class="form-control" name="JABATAN" readonly value="<?php echo $dataBapp['JABATAN'] ?>">
                <input class="form-control hide" name="EMAIL" value="<?php echo $dataBapp['EMAIL'] ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="lampiran" class="col-sm-3 control-label">Item BAPP</label>
            <div class="col-sm-9">
              <div class="col-sm-5">
                <select name="service_list" class="select2 col-sm-12">
                  <?php
                    if(!empty($listService)){
                      foreach($listService as $ls){
                        echo '<option value="'.$ls['SERVICE'].'">'.$ls['SERVICE'].' - '.$ls['SHORT_TEXT'].'</option>';
                      }
                    }
                  ?>
                </select>
              </div>
              <div class="col-sm-7">
                <input type="text" name="qty_tmp"/>
                <span class="btn btn-primary" id="tambah_qty">Tambah</span>
              </div>
            </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
              <table class="table table-bordered bappitem">
                  <thead>
                      <tr>
                          <th class="text-center">No</th>
                          <th class="text-center">Service</th>
                          <th class="text-center">Qty</th>
                          <th class="text-center">Aksi</th>
                      </tr>
                  </thead>
                  <tbody id="tbody-bappitem">
                    <?php
                    if(!empty($bappItem)){
                      $_index = 1;
                      foreach($bappItem as $bd){
                        echo '<tr>
                          <td>'.$_index.'</td>
                          <td class="text-center"><input type="hidden" name="SERVICE[]" value="'.$bd['SERVICE'].'"><span>'.$bd['SERVICE_DESC'].'</span> </td>
                          <td class="text-center"><input type="text" name="QTY[]" value="'.ribuan($bd['QTY'],2).'"> </td>
                          <td class="text-center"><a onclick="removeQty(this)" href="#"><span class="glyphicon glyphicon-trash"></span></a></td>
                        </tr>';
                        $_index++;
                      }
                    }
                    ?>
                  </tbody>
              </table>
          </div>
        </div>
        <div class="form-group">
            <label for="lampiran" class="col-sm-3 control-label">Lampiran</label>
            <div class="col-sm-9">
                <table class="table table-bordered tableDoc">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nomor Dokumen</th>
                            <th class="text-center">File</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody id="tbody-doc">
                      <?php
                      if(!empty($bappDoc)){
                        $_index = 1;
                        foreach($bappDoc as $bd){
                          $inputFile = '';
                          echo '<tr>
                            <td>'.$_index.'</td>
                            <td class="text-center"><input type="text" readonly name="lampiranBapp['.$_index.']" value="'.$bd['DESCRIPTION'].'"> </td>
                            <td class="text-center"><a target="_blank" href="'.site_url('upload/EC_invoice/'.$bd['PIC']).'">'.$bd['PIC'].'</a></td>
                          </tr>';
                          $_index++;
                        }
                      }
                      ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-offset-3 col-sm-9">
            <p class="help-block"><small>ukuran upload file maks 4MB, file: *.jpg / *.png / *.pdf</small></p>
        </div>
        <?php if($approve_reject) { ?>
            <div class="form-group">
                <label for="note" class="col-sm-3 control-label">Action </label>
                <div class="col-sm-2">
                    <select class="form-control" name="next_action">
                        <option value="1">Approve</option>
                        <option value="0">Reject</option>
                    </select>
                </div>
            </div>
            <div class="form-group" style="display:none">
                <div class="col-sm-12">
                    <textarea maxlength="255" name="ALASAN_REJECT" class="form-control" rows="3"><?php echo $dataBapp['ALASAN_REJECT'] ?></textarea>
                </div>
            </div>
        <?php } ?>
        <?php if($bisaEdit){ ?>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                <button class="btn btn-info preview-btn" data-urlpreview="<?php echo site_url('EC_Approval/Bapp/preview')?>" type="button">Preview</button>
                <button class="btn btn-info" type="submit">Simpan</button>
            </div>
        </div>
        <?php } ?>
        </form>
      </div>
      </div>
      </div >
      </div >
  </section>
