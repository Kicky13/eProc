<?php $company = $companyCode ?>
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-lg-12">
                    <?php
                    echo form_open_multipart($url, array('method' => 'POST', 'class' => 'form-horizontal formEdit'));

                    if(isset($value[0]['NOTE_REJECT'])){
                    ?>
                    <div class="form-group">
                        <label for="Invoice No" class="col-sm-3 control-label">Alasan Reject</label>
                        <div class="col-sm-3">
                            <textarea class="form-control" disabled=""><?php echo $value[0]['NOTE_REJECT'];?></textarea>
                        </div>

                        <?php if(isset($value[0]['PIC_REJECT'])){
                            $url = base_url('upload/EC_invoice/E_Nova').'/'.$value[0]['PIC_REJECT'];
                            echo "
                        <div class='col-sm-2'>
                            <a href='$url'>FILE ATTACHMENT</a>
                        </div>";

                            }?>
                    </div>
                    <?php
                    }
                    ?>

                    <div class="form-group">
                        <label for="Invoice No" class="col-sm-3 control-label">Company</label>
                        <div class="col-sm-4">
                            <select required name='company'>
                                <option value=''>Pilih Company</option>
                    <?php
                        //$company = '3000';
                        //$value[0]['company'] = '3000';
                        $sel = '';
                        $sel_si = '';
                        $sel_kso = '';
                        if(isset($value[0]['COMPANY'])){
                            $sel = 'selected="selected"';
                            $sel_si = $value[0]['COMPANY'] == '2000' ? 'selected="selected"' : '';
                            $sel_kso = $value[0]['COMPANY'] == '7000' ? 'selected="selected"' : '';
                        }

                        if($company == '2000' || $company == '7000'){
                            echo "<option value='2000' $sel_si>Semen Indonesia (SI)</option>
                                  <option value='7000' $sel_kso>Kerjasama Operasi (KSO)</option>";
                        }else if($company == '3000'){
                            echo "<option value='3000' $sel>Semen Padang (SP)</option>";
                        }else if($company == '4000'){
                            echo "<option value='4000' $sel>Semen Tonasa (ST)</option>";
                        }else if($company == '5000'){
                            echo "<option value='5000' $sel>Semen Gresik (SG)</option>";
                        }

                    ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Invoice No" class="col-sm-3 control-label">Awal No E-Nofa</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo isset($value[0]['START_NO']) ? $value[0]['START_NO'] : '';?>" data-mask="999-99.99999999" required="" id="no_awal" name="no_awal">
                            <input type="text" class="hide" value="<?php echo isset($value[0]['START_NO']) ? $value[0]['START_NO'] : '';?>" name="old_start">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Invoice No" class="col-sm-3 control-label">Akhir No E-Nofa</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo isset($value[0]['END_NO']) ? $value[0]['END_NO'] : '';?>" data-mask="999-99.99999999" required="" id="no_akhir" name="no_akhir">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Invoice No" class="col-sm-3 control-label">Upload Gambar E-Nofa</label>
                        <div class="col-sm-3">
                            <input type="file" id="file" <?php echo isset($value[0]['IMAGE']) ? 'value="'.$value[0]['IMAGE'].'"' : 'required=""';?>  class="filestyle" data-buttonText="Find file" name="img_enova" id="img_enova">
                        </div>
                        <?php if(isset($value[0]['IMAGE'])){
                            $url = base_url('upload/EC_invoice/E_Nova').'/'.$value[0]['IMAGE'];
                            echo "
                        <div class='col-sm-2'>
                            <a href='$url'>FILE ATTACHMENT</a>
                        </div>";

                            }?>
                    </div>

                    <div class="form-group">
                        <label for="Invoice Date" class="col-sm-3 control-label">Tanggal Mulai Aktif No. Seri E-Nofa</label>
                        <div class="col-sm-3 tgll">
                            <div class="input-group date startDate">
                                <input required readonly id="startDate" data-mask="99-99-9999" value="<?php echo isset($value[0]['START_DATE2']) ? $value[0]['START_DATE2'] : '';?>" class="form-control start-date" name="startDate" type="text">
                                <span class="input-group-addon">
                                    <a href="javascript:void(0)">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Invoice Date" class="col-sm-3 control-label">Tanggal Berakhir No. Seri E-Nofa</label>
                        <div class="col-sm-3 tgll">
                            <div class="input-group date endDate">
                                <input required readonly id="endDate" data-mask="99-99-9999" value="<?php echo isset($value[0]['END_DATE2']) ? $value[0]['END_DATE2'] : '';?>" class="form-control start-date" name="endDate" type="text">
                                <span class="input-group-addon">
                                    <a href="javascript:void(0)">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-3 tgll text-center">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href = "<?php echo base_url('EC_Vendor/List_Enofa');?>" class="btn btn-danger">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div >
    </div >
</section>
