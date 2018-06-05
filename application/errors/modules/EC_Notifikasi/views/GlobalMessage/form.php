
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <?php $msg = $this->session->flashdata('msg');?>
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-lg-12">
                    <div id='msg' class='alert alert-info text-center <?php echo !empty($msg) ? "" : "hide"?>' ><?php echo !empty($msg) ? $msg : ""?></div>
                </div>
                <div class="col-sm-12 col-lg-12 col-lg-12">
                    <?php 
                    echo form_open_multipart(base_url('EC_Notifikasi/Global_Message/sendNotif'), array('method' => 'POST', 'class' => 'form-horizontal formEdit'));
                    ?>

                    <div class="form-group">
                        <label for="Invoice No" class="col-sm-2 control-label">Send To</label>
                        <div class="col-sm-3">
                            <select multiple="" required="" name='send_to[]' class="select2" style="max-width: 400px;min-width: 400px;">
                                <?php
                                    for ($i=0; $i < count($vendor); $i++) { 
                                        echo "<option value='".$vendor[$i]['EMAIL']."'>".$vendor[$i]['VENDOR']."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Invoice No" class="col-sm-2 control-label">CC</label>
                        <div class="col-sm-3">
                            <select multiple="" name='cc[]' class="select2" style="max-width: 400px;min-width: 400px;">
                                <?php
                                    for ($i=0; $i < count($employee); $i++) { 
                                        echo "<option value='".$employee[$i]['EMAIL']."'>".$employee[$i]['FULLNAME']."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Invoice No" class="col-sm-2 control-label">BCC</label>
                        <div class="col-sm-3">
                            <select multiple="" name='bcc[]' class="select2" style="max-width: 400px;min-width: 400px;">
                                <?php
                                    for ($i=0; $i < count($employee); $i++) { 
                                        echo "<option value='".$employee[$i]['EMAIL']."'>".$employee[$i]['FULLNAME']."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subject" class="col-sm-2 control-label">Subject</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control"  required id="subject" name="subject">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="attachment" class="col-sm-2 control-label">File Attachment</label>
                        <div class="col-sm-5">
                            <input type="file" class="form-control"  id="attachment" name="attachment">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Invoice No" class="col-sm-2 control-label"></label>
                        <div class="col-sm-5">
                            <p class="help-block"><small>Ukuran upload file maks 4MB, file: *.jpg / *.png / *.pdf</small></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Invoice No" class="col-sm-2 control-label">Message</label>
                        <div class="col-sm-9">
                            <textarea class="form-control editor-html"  required id="message" name="message"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-5"></div>
                        <div class="col-sm-3 tgll text-center">
                            <button type="submit" class="btn btn-success">Kirim</button>
                        </div>
                    </div>
                </div>
            </div>
        </div >
    </div >
</section>
