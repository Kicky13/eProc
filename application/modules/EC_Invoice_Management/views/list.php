<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="hide" id="sudahTampilPesan"><?php echo $sudahTampil ?></div>
                <?php
                $pesannya = $this->session->flashdata('message');
                if (!empty($pesannya)) {
                    echo '<div class="alert alert-info">' . $pesannya . '</div>';
                }
                ?>

                <div class="panel-group">
                    <div class="panel panel-default">
                    <div class="panel-heading">Informasi Faktur Pajak</div>

                      <div class="panel-body">
                        Penyerahan Faktur Pajak WAPU yang berkode seri:<br>
                        1. 030 paling lambat diserahkan setiap tanggal 5 bulan berikutnya.<br>
                        Contoh :<br>
                        - Faktur Pajak tanggal April 2018 paling lambat disetorkan tanggal 5 Mei.<br>
                        - Faktur Pajak yang ada di E-Proc harus diekspedisi dari Seksi Verifikasi. jika terlambat.<br>
                        - Kurang dari 3 bulan, harus melampirkan surat pernyataan menanggung denda 2% X PPN X bulan.<br>
                        - Lebih dari 3 bulan, harus melampirkan surat pernyataan menanggung PPN dan denda 2 % X PPN X bulan.<br>
                        2. 010 paling lambat diserahkan setiap tanggal 5 3 bulan berikutnya.<br>
                        Contoh :<br>
                        - Faktur Pajak tanggal April 2018 paling lambat disetorkan tanggl 5 Agustus.<br>
                        - Faktur Pajak yang ada di E-Proc harus diekspedisi dari Seksi Verifikasi. jika terlambat :<br>
                        - Lebih dari 3 bulan, harus melampirkan surat pernyataan menanggung PPN.<br>
                        3. Apabila status "Approved", maka Vendor bertanggung jawab atas faktur pajak rekanan sendiri, dibuatkan ekspedisi, dan dikirim ke Biro Pajak, agar tidak terlambat dan tidak terkena denda pajak 2% per bulan.<br>
                    </div>
                </div>
            </div>

            <div class="row">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a class="tab1" href="#Unbilled" aria-controls="Unbilled" role="tab" data-toggle="tab">Unbilled</a></li>
                    <li role="presentation"><a class="tab2" href="#Invoiced" aria-controls="Invoiced" role="tab" data-toggle="tab">Invoiced</a></li>
                    <li role="presentation"><a class="tab2" href="#createDocument" aria-controls="Invoiced" role="tab" data-toggle="tab">My Document</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="Unbilled">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="row" style="border-bottom: 1px solid #ccc;">
                                    <br>
                                    <button type="button" onclick="createInvoice(this)" id="create" class="btn btn-info pull-right" style="margin-right: 20px;">Create Invoice</button>
                                    <br>
                                    <br>

                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <table id="tableMT" class="table table-striped nowrap" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center ts0"><a href="javascript:void(0)">System No</a></th>
                                                    <th class="text-center ts1"><a href="javascript:void(0)">GR Doc</a></th>
                                                    <th class="text-center ts2"><a href="javascript:void(0)">GR Line</a></th>
                                                    <th class="text-center ts3"><a href="javascript:void(0)">GR Doc Date</a></th>
                                                    <th class="text-center ts4"><a href="javascript:void(0)">Posting Date</a></th>
                                                    <th class="text-center ts5"><a href="javascript:void(0)">Deskripsi</a></th>
                                                    <th class="text-center ts6"><a href="javascript:void(0)">Qty</a></th>
                                                    <th class="text-center ts7"><a href="javascript:void(0)">UoM</a></th>
                                                    <th class="text-center ts8"><a href="javascript:void(0)">Value</a></th>
                                                    <th class="text-center ts9"><a href="javascript:void(0)">Curr</a></th>
                                                    <th class="text-center ts10"><a href="javascript:void(0)">PO</a></th>
                                                    <th class="text-center ts11"><a href="javascript:void(0)">PO Line</a></th>
                                                    <th class="text-center ts12"><a href="javascript:void(0)">LOT Number</a></th>
                                                    <th class="text-center ts13"><a href="javascript:void(0)">Check</a></th>
                                                </tr>
                                                <tr class="sear">
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="Invoiced">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="table_inv" class="table table-striped nowrap" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center ts0"><a href="javascript:void(0)">No.</th>
                                                <th class="text-center ts1"><a href="javascript:void(0)">Invoice Date</a></th>
                                                <th class="text-center ts2"><a href="javascript:void(0)">No. Invoice</a></th>
                                                <th class="text-center ts3"><a href="javascript:void(0)">No. PO</a></th>
                                                <th class="text-center ts4"><a href="javascript:void(0)">No. PPL</a></th>
                                                <th class="text-center ts5"><a href="javascript:void(0)">Base Amount</a></th>
                                                <th class="text-center ts7"><a href="javascript:void(0)">Last Edit</a></th>
                                                <th class="text-center ts7"><a href="javascript:void(0)">Status</a></th>
                                                <th class="text-center ts8"><a href="javascript:void(0)">Posisi Dokumen</a></th>
                                                <th class="text-center ts9"><a href="javascript:void(0)">Status Dokumen</a></th>
                                                <th class="text-center ts10"><a href="javascript:void(0)">Aksi</a></th>
                                            </tr>
                                            <tr class="sear">
                                                <th></th>
                                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                                <th></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="createDocument">
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">
                          <div class="panel-group skrol" role="tablist" aria-multiselectable="true">
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px">
                                <a href="<?php echo site_url('EC_Vendor/List_Enofa')?>" class="btn btn-primary">E-Nofa</a>
                                <a href="<?php echo site_url('EC_Vendor/Bapp')?>" class="btn btn-primary">BAPP</a>
                                <a href="<?php echo site_url('EC_Vendor/Bast')?>" class="btn btn-primary">BAST</a>
                                <a href="<?php echo site_url('EC_Vendor/Pomut')?>" class="btn btn-primary">BA ANALISA MUTU</a>
                                <a href="<?php echo site_url('EC_Vendor/Gr')?>" class="btn btn-primary">GR DOC</a>
                                <a href="<?php echo site_url('EC_Vendor/Faktur')?>" class="btn btn-primary">EKSPEDISI FAKTUR PAJAK</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <br><br>
    </div>
</div >
</div >
</section>

<div class="modal fade" id="divCreateInvoice">
    <div class="row">
        <div class="col-sm-12 col-lg-12 col-lg-12">
            <?php echo form_open_multipart('EC_Invoice_Management/createInvoice/', array('method' => 'POST', 'class' => 'form-horizontal formCreate')); ?>
            <div class="form-group">
                <label for="Invoice Date" class="col-sm-3 control-label">Tanggal Invoice *</label>
                <div class="col-sm-4 tgll">
                    <div class="input-group date startDate">
                        <input readonly="" id="startdate" required=""  class="form-control start-date" name="invoice_date"  type="text" value="<?php echo date('d-m-Y') ?>">
                        <span class="input-group-addon">
                            <a href="javascript:void(0)">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="Invoice No" class="col-sm-3 control-label">No. Invoice *</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control"  required="" id="invoice_no" name="invoice_no" maxlength="50" >
                </div>
                <div class="col-sm-3">
                    <input  type="file" required="" name="fileInv" />
                </div>
            </div>
            <div class="form-group">
                <label for="Invoice No" class="col-sm-3 control-label">Bank Transfer*</label>
                <div class="col-sm-4">
                    <select name="partner_bank" required class="col-md-12">
                      <?php foreach($listBank as $lb){
                        echo '<option value="'.$lb['PARTNER_TYPE'].'">'.$lb['ACCOUNT_NO'].' - '.$lb['BANK_NAME'].' - '.$lb['ACCOUNT_HOLDER'].'</option>';
                    } ?>
                </select>
            </div>
            <div class="col-sm-3">

            </div>
        </div>
        <div class="form-group">
            <label for="faktur" class="col-sm-3 control-label">Jenis Pajak</label>
            <div class="col-sm-4">
                <select required="" class="form-control" name="pajak" id="pajak" onchange="setRequiredPajak(this,'VZ')">
                    <option value="">Pilih Jenis Pajak</option>
                    <?php
                    $nilaiPajakLama = 0;
//                                        var_dump($pajak);
                    for ($i = 0; $i < sizeof($pajak); $i++) { ?>
                    <option value="<?php echo $pajak[$i]['ID_JENIS'] ?>" data-pajak="<?php echo $pajak[$i]['PAJAK'] ?>">
                        <?php
                        if($pajak[$i]['ID_JENIS'] == "VN"){
                            echo "PPN";
                        }else{ echo "Tanpa PPN";} }?>

                    </option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="Invoice Date" class="col-sm-3 control-label">Tanggal Faktur Pajak </label>
            <div class="col-sm-4 tgll">
                <div class="input-group date startDate">
                    <input readonly="" id="FakturDate"  class="form-control start-date" name="FakturDate" required="" type="text">
                    <span class="input-group-addon">
                        <a href="javascript:void(0)">
                            <i class="glyphicon glyphicon-calendar"></i>
                        </a>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="faktur" class="col-sm-3 control-label">No. Faktur Pajak </label>
            <div class="col-sm-4">
                <input type="text" class="form-control format-pajak" id="faktur" data-mask="999.999-99.99999999"  name="faktur_no" >
            </div>
            <div class="col-sm-3">
                <input type="file" id="file_faktur" name="fileFaktur" />
            </div>
        </div>
        
        <div class="form-group" id='ref_fp'>
            <label for="faktur" class="col-sm-3 control-label">Referensi No. Faktur Pajak </label>
            <div class="col-sm-4">
                <input type="text" class="form-control format-pajak" readonly="" id="ref_faktur" name="ref_faktur_no" >
            </div>
            <div class="col-sm-3" id='link_ref_fp'>
            </div>
        </div>

        <div class="form-group">
            <label for="Invoice No" class="col-sm-3 control-label">No. SP/PO *</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" readonly="" id="sppo_no" name="sppo_no" >
            </div>
            <div class="col-sm-3">
                <input type="file" required name="filePO" />
            </div>

        </div>

        <div class="form-group">
            <label for="bapp no" class="col-sm-3 control-label">No. BAPP</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="bapp_no" name="bapp_no" maxlength="40"  onchange="setRequired(this,'fileBapp')" >
            </div>
            <div class="col-sm-3">
                <input type="file" name="fileBapp" />
            </div>
        </div>
        <div class="form-group">
            <label for="bapp no" class="col-sm-3 control-label">No. BAST / RR / PP</label>
            <div class="col-sm-4">
                <input type="text" class="form-control"  maxlength="40" onchange="setRequired(this,'fileBast')" id="bast_no" name="bast_no" >
            </div>
            <div class="col-sm-3">
                <input type="file"  name="fileBast" />
            </div>
        </div>
        <div class="form-group">
            <label for="bapp no" class="col-sm-3 control-label">No. Kwitansi</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" maxlength="50" onchange="setRequired(this,'fileKwitansi')" id="kwitansi_no" name="kwitansi_no" >
            </div>
            <div class="col-sm-3">
                <input type="file" name="fileKwitansi" />
            </div>
        </div>

        <div class="form-group">
            <label for="bapp no" class="col-sm-3 control-label">K3</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="K3" maxlength="20" name="K3" onchange="setRequired(this,'fileK3')" >
            </div>
            <div class="col-sm-3">
                <input type="file" name="fileK3" />
            </div>
        </div>
        <div class="form-group">
            <label for="bapp no" class="col-sm-3 control-label">Lampiran Mutu</label>
            <div class="col-sm-4">
                <input type="text" class="form-control"  maxlength="50" onchange="setRequired(this,'filePotMutu')" id="potmut_no" name="potmut_no" >
            </div>
            <div class="col-sm-3">
                <input type="file"  name="filePotMutu" />
            </div>
        </div>
        <div class="form-group">
            <label for="bapp no" class="col-sm-3 control-label">Surat Permohonan Pembayaran</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" maxlength="50" id="spbyr_no" name="spbyr_no"  onchange="setRequired(this,'filespbyr')" >
            </div>
            <div class="col-sm-3">
                <input type="file" name="filespbyr" />
            </div>
        </div>
        <div class="form-group">
            <label for="bapp no" class="col-sm-3 control-label">Denda</label>
            <div class="col-sm-2">
                <select class="form-control" id="denda">
                    <?php for ($i = 0; $i < sizeof($denda); $i++) {
                        if ($denda[$i]['STATUS'] == "1")

                            ?>
                        <option value="<?php echo $denda[$i]['ID_JENIS'] ?>"><?php echo $denda[$i]['JENIS'] ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="Nominal" name="Nominal" placeholder="1234567890">
                </div>
                <div class="col-sm-3">
                    <button type="button" class="btn btn-info" onclick="addDenda(this)">Tambah</button>
                </div>
            </div>
            <div class="form-group">
                <label for="faktur" class="col-sm-1 control-label"></label>
                <div class="col-sm-10">
                    <table class="table table-bordered tableDenda">
                        <thead>
                            <tr>
                                <th class="text-center">Jenis Denda</th>
                                <th class="text-center">Nominal</th>
                                <th class="text-center">File</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-denda">
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="form-group">
                <label for="bapp no" class="col-sm-3 control-label">Dokumen Tambahan</label>
                <div class="col-sm-2">
                    <select class="form-control" id="doc">
                        <?php for ($i = 0; $i < sizeof($doc); $i++) {
                            if ($doc[$i]['STATUS'] == "1")

                                ?>
                            <option value="<?php echo $doc[$i]['ID_JENIS'] ?>"><?php echo $doc[$i]['JENIS'] ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="Nomor_Dokumen" name="Nomor_Dokumen" placeholder="Nomor Dokumen">
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-info" onclick="addDoc(this)" type="button">Tambah</button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="faktur" class="col-sm-1 control-label"></label>
                    <div class="col-sm-10">
                        <table class="table table-bordered tableDoc">
                            <thead>
                                <tr>
                                    <th class="text-center">Jenis Dokumen</th>
                                    <th class="text-center">Nomor Dokumen</th>
                                    <th class="text-center">File</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-doc">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group">
                    <label for="faktur" class="col-sm-3 control-label">Base Amount</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="Amount" required="" id="totalview" readonly="">
                        <input type="hidden" id="base_amount" name="base_amount" />
                    </div>
                    <div class="col-sm-3">
                      <!-- <input type="file" required name="fileAmount" /> -->
                  </div>
              </div>
              <div class="form-group hide">
                <label for="faktur" class="col-sm-3 control-label">Total Amount</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="totalAmount" required="" id="totalAmount" readonly="">
                    <input type="hidden" id="total" name="total" />
                </div>
                <div class="col-sm-3">
                  <!-- <input type="file" required name="fileAmount" /> -->
              </div>
          </div>
          <div class="col-sm-offset-3 col-sm-9">
            <p class="help-block"><small>ukuran upload file maks 4MB, file: *.jpg / *.png / *.pdf</small></p>
        </div>
        <div class="form-group">
            <label for="note" class="col-sm-3 control-label">Deskripsi Pekerjaan</label>
            <div class="col-sm-9">
                <input name="note" class="form-control" maxlength="40" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <input type="hidden" id="arrGR" name="arrgr" />
                <input type="hidden" id="curr" name="curr" />
                <input type="hidden" id="itemCat" name="itemCat" />
                <input type="hidden" id="jmlDenda" name="jmlDenda" />
                <input type="hidden" id="jmlDoc" name="jmlDoc" />
                <button class="btn btn-info pull-right" type="submit">Simpan</button>
            </div>
        </div>
    </form>
</div>
</div>

</div>

<div class="modal " id="modalInvoinceNo">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>INVOICE<!-- <?php //echo $baseLanguage ['principal_manufacturer_addTtl'] ;  ?> --></u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- <div class="form-group"> -->
                    <!-- <label for="picure" class="col-sm-2 control-label">Picure</label> -->
                    <div class="col-md-8 col-md-offset-2">
                        <br><br>
                        <img id="picInvoince" class="thumbnail zoom" onerror="this.onerror=null;this.src='<?php echo base_url(UPLOAD_PATH) . '/material_strategis/default_post_img.png'; ?>'"
                        src="<?php echo base_url(UPLOAD_PATH) . '/EC_material_strategis/default_post_img.png'; ?>">
                    </div>
                    <!-- </div> -->
                </div>

                <!-- </div> -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFaktur">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Faktur Pajak<!-- <?php //echo $baseLanguage ['principal_manufacturer_addTtl'] ;  ?> --></u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <br><br>
                        <img id="picFaktur" class="thumbnail zoom" onerror="this.onerror=null;this.src='<?php echo base_url(UPLOAD_PATH) . '/material_strategis/default_post_img.png'; ?>'"
                        src="<?php echo base_url(UPLOAD_PATH) . '/EC_material_strategis/default_post_img.png'; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTracking">
    <div class="modal-dialog modal-md" style="width:75%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Tracking Invoice</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <table id="tableTrack" class="table table-striped nowrap" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Keterangan</th> 
                                    <th class="text-center">Posisi Dokumen</th>
                                    <th class="text-center">Status Dokumen</th>
                                    <th class="text-center">User</th>
                                </tr>
                            </thead>
                            <tbody id="bodyTableTrack">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
