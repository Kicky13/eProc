<section class="content_section">
    <div class="content_spacer">
        <div class="content" style="margin-bottom:100px;">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>            
            <?php
            $pesannya = $this->session->flashdata('message');
            if (!empty($pesannya)) {
                echo '<div class="alert alert-danger">' . $pesannya . '</div>';
            }
            ?>
            <div class="row">
                <?php //echo form_open($urlAction, array('method' => 'POST')); ?>    
                <form action="<?php echo $urlAction ?>" enctype="multipart/form-data" id="formID" method="post">

                    <div class="col-md-12 col-xs-12">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="company">Company</label>
                                    <select class="form-control" name="company" id="company" required>                                    
                                        <option value=''>Pilih Company</option>
                                        <option value="2000">PT. Semen Indonesia (Persero) Tbk. - Gresik</option>                                                                        
                                        <option value="7000">PT. Semen Indonesia (Persero) Tbk. - Tuban</option>                                                                        
                                        <option value="5000">PT. Semen Gresik</option>                                                                        
                                    </select>
                                </div>                            
                            </div>                        
                        </div>
                        <hr>
                    </div>
                    <div class="col-md-6 col-xs-12">                    
                        <div class="form-group">
                            <label for="no_faktur">Nomor Faktur Pajak</label>
                            <input type="text" class="form-control" id="no_faktur" placeholder="0301234567891234" required maxlength="16" >
                        </div>  
                        <div class="form-group">
                            <label for="tgl_faktur">Tanggal Faktur Pajak</label>
                            <div class="input-group date">
                                <input type="text" class="form-control startDate" id="tgl_faktur" required readonly="readonly">
                                <span class="input-group-addon">
                                    <a href="javascript:void(0)">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tgl_bast">Tanggal BAST/BAPP</label>
                            <div class="input-group date">                        
                                <input type="text" class="form-control startDate" id="tgl_bast" required readonly="readonly">
                                <span class="input-group-addon">
                                    <a href="javascript:void(0)">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                    </a>
                                </span>
                            </div>
                        </div>  
                        <div class="form-group">
                            <label for="dasar_pajak">Nilai Dasar Pengenaan Pajak</label>
                            <input type="text" class="form-control" id="dasar_pajak" required>
                        </div>                  
                    </div>

                    <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                            <label for="po">Nomor PO/SPK/OP</label>
                            <input type="text" class="form-control" id="po" required placeholder="6610001321">
                        </div>
                        <div class="form-group">
                            <label for="po">Nama</label>
                            <input type="text" class="form-control" id="nama" placeholder="Shobikh Sahirar" required>
                        </div>
                        <div class="form-group">
                            <label for="po">Email</label>
                            <input type="text" class="form-control" id="email" placeholder="shobikhs@gmail.com" required>
                        </div>
                        <div class="form-group">
                            <label for="po">Upload File Faktur Pajak</label>
                            <input type="file" name="GAMBAR" required>
                            <input type="hidden" id="GAMBAR">
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12">
                        <button class="btn btn-info" onclick="addFaktur(this,'#tbody-doc')" type="button">Tambah</button>
                    </div>
                    <div class="col-md-12 col-xs-12" style="margin-top:10px;margin-bottom:50px;overflow-x:auto;">
                        <table class="table table-bordered tableDoc">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nomor Faktur Pajak</th>
                                    <th class="text-center">Tanggal Faktur Pajak</th>
                                    <th class="text-center">Tanggal BAST</th>
                                    <th class="text-center">Nilai Dasar Pengenaan Pajak</th>
                                    <th class="text-center">Nomor PO</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">File Faktur Pajak</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody id="tbody-doc">                          
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12 col-xs-12">
                        <button class="btn btn-info" type="submit" style="margin:auto;display:block;">Ekspedisi</button>
                    </div>
                </form> 
                <?php //echo form_close(); ?>                                                  
            </div>
        </div >
    </div >
</section>
