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
            <div class="col-sm-12 col-md-8 col-lg-8">
        <?php echo form_open_multipart($urlAction, array('method' => 'POST', 'class' => 'form-horizontal','data-id' => $id,'data-urlkonfirmasi'=> site_url('EC_Vendor/Bapp/kofirmasiVendor'))); ?>
        <div class="form-group" style="visibility:<?php echo $dataBast['STATUS'] != '4' ? "hidden" : ''; ?>">
            <label for="Invoice No" class="col-sm-3 control-label">Alasan Reject</label>
            <div class="col-sm-9">
                <textarea  readonly class="form-control" rows="2"><?php echo $dataBast['ALASAN_REJECT'] ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-3 control-label">No. PO</label>
            <div class="col-sm-7">
                <input type="text" class="form-control"  required name="NO_PO" readonly value="<?php echo $dataBast['NO_PO'] ?>">
                <input type="hidden" class="form-control"  name="COMPANY" readonly value="<?php echo $dataBast['COMPANY'] ?>">
            </div>
            <div class="col-sm-2">
                <span class="btn btn-info" data-url="<?php echo site_url('EC_Vendor/Bapp/openPOJasa')?>" onclick="modalSearchPO(this)" >Pilih PO</span>
            </div>
        </div>
        <div class="form-group">
            <label for="po_item" class="col-sm-3 control-label">PO. Item</label>
            <div class="col-sm-9">
                <input class="form-control" name="PO_ITEM" readonly value="<?php echo $dataBast['PO_ITEM'] ?>" >
            </div>
        </div>
        <div class="form-group">
            <label for="pekerjaan" class="col-sm-3 control-label">Pekerjaan</label>
            <div class="col-sm-9">
                <textarea class="form-control" name="SHORT_TEXT" readonly><?php echo $dataBast['SHORT_TEXT'] ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="Description" class="col-sm-3 control-label">Description</label>
            <div class="col-sm-9">
                <textarea class="form-control editor-html"  required name="DESCRIPTION" <?php echo $isReadonly ?> ><?php echo $dataBast['DESCRIPTION'] ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="pengawas" class="col-sm-3 control-label">Pengawas</label>
            <div class="col-sm-7">
                <input class="form-control" name="PENGAWAS" value="<?php echo $dataBast['PENGAWAS'] ?>" readonly required>
            </div>
            <div class="col-sm-2">
                <span class="btn btn-info" data-url="<?php echo site_url('EC_Vendor/Bapp/listPegawai')?>" onclick="modalSearchPegawai(this)" >Pilih Pengawas</span>
            </div>
        </div>
        <div class="form-group">
            <label for="jabatan" class="col-sm-3 control-label">Jabatan</label>
            <div class="col-sm-9">
                <input class="form-control" name="JABATAN" value="<?php echo $dataBast['JABATAN'] ?>">
                <input class="form-control hide" name="EMAIL" value="<?php echo $dataBast['EMAIL'] ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="lampiran" class="col-sm-3 control-label">Lampiran</label>
            <div class="col-sm-7">
                <input class="form-control" placeholder="nama document" />
            </div>
            <div class="col-sm-2">
                <button class="btn btn-info" onclick="addDoc(this,'#tbody-doc')" type="button">Tambah</button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-3">
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
                      if(!empty($bastDoc)){
                        $_index = 1;
                        $sampah = $bisaEdit ? '<span  onclick="removeRow(this)" class="link glyphicon glyphicon-trash" aria-hidden="true"></span>' : '';
                        foreach($bastDoc as $bd){
                          $inputFile = $bisaEdit ? '<input type="file" name="fileLampiranBast_'.$_index.'">' : '';
                          echo '<tr>
                            <td>'.$_index.'</td>
                            <td class="text-center"><input type="text" readonly name="lampiranBast['.$_index.']" value="'.$bd['DESCRIPTION'].'"> </td>
                            <td class="text-center">'.$inputFile.'<input type="hidden" name="oldFileLampiranBast['.$_index.']" value="'.$bd['PIC'].'"><a target="_blank" href="'.site_url('upload/EC_invoice/'.$bd['PIC']).'">'.$bd['PIC'].'</a></td>
                            <td class="text-center">'.$sampah.'</td>
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
        <?php if($bisaEdit){ ?>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                <button class="btn btn-info preview-btn" data-urlpreview="<?php echo site_url('EC_Vendor/Bast/preview')?>" type="button">Preview</button>
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
