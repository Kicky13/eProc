<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <?php
            $pesannya = $this->session->flashdata('message');
            if (!empty($pesannya)) {
                echo '<div class="alert alert-info">' . $pesannya . '</div>';
            }
            ?>

            <div class="row">
                <div class="row">
                    <div id="Invoiced">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="max-width:98%;overflow:auto">
                                    <form id="etor-form" enctype="multipart/form-data" method="post" >
                                            <!-- <input type="submit" name="submit" value="Expedisikan Faktur"> -->
                                            <button class="btn btn-info pull-right" type="submit" style="margin:auto;display:block;" formaction="<?php echo base_url()?>EC_Invoice_fp_pjk/approveFaktur">APPROVE</button>
                                            <button class="btn btn-info pull-right" type="cancel" style="margin:auto;display:block;" formaction="<?php echo base_url()?>EC_Invoice_fp_pjk/rejectFaktur">REJECT</button>
                                        <table id="table_inv" class="table table-striped nowrap" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center ts"><a href="javascript:void(0)">NO</a></th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">COMPANY</th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">TANGGAL EKSPEDISI</th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">NO EKSPEDISI</th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">FAKTUR PAJAK</th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">DASAR PENGENAAN PAJAK</th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">PPN</th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">TGL TERIMA</th>
                                                    <th class="text-center ts"><a href="javascript:void(0)">ACTION</a></th>
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
                                                    <th></th>
                                                </tr>
                                            </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </form>
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

    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <center><h4>Create Invoice</h4></center>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12 col-lg-12">
                                <?php echo form_open_multipart('EC_Invoice_Management/createInvoice/', array('method' => 'POST', 'class' => 'form-horizontal formCreate')); ?>
                                <div class="form-group">
                                    <label for="Invoice Date" class="col-sm-3 control-label">Tanggal Invoice</label>
                                    <div class="col-sm-4 tgll">
                                        <div class="input-group date startDate">
                                            <input readonly="" id="startdate" required=""  class="form-control start-date" name="invoice_date"  type="text">
                                            <span class="input-group-addon">
                                                <a href="javascript:void(0)">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                            <!-- <div class="col-sm-3">
                              <input type="text" class="form-control" id="invoice_date" name="invoice_date" readonly>
                          </div> -->
                      </div>
                      <div class="form-group">
                        <label for="Invoice No" class="col-sm-3 control-label">No. Invoice</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"  required="" id="invoice_no" name="invoice_no" >
                        </div>
                        <div class="col-sm-3">
                            <input  type="file" required="" name="fileInv" />
                        </div>
                    </div>
                        <!-- <div class="form-group">
                                          <label for="Invoice Date" class="col-sm-3 control-label">Posting Date</label>
                                          <div class="col-sm-4 tgll">
                                              <div class="input-group date startDate">
                                                      <input readonly="" id="PostingDate"  class="form-control start-date" name="PostingDate" required="" type="text">
                                                      <span class="input-group-addon">
                                                              <a href="javascript:void(0)">
                                                                      <i class="glyphicon glyphicon-calendar"></i>
                                                              </a>
                                                      </span>
                                              </div>
                                          </div>
                                      </div> -->
                                      <div class="form-group">
                                        <label for="Invoice Date" class="col-sm-3 control-label">Tanggal Faktur Pajak</label>
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
                                        <label for="faktur" class="col-sm-3 control-label">No. Faktur Pajak</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control format-pajak" id="faktur" data-mask="999.999-99.9999999"  required name="faktur_no" >
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="file" id="file_faktur" required="" name="fileFaktur" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="faktur" class="col-sm-3 control-label">Jenis Pajak</label>
                                        <div class="col-sm-4">
                                            <select class="form-control">
                                                <option>Pilih Jenis Pajak</option>
                                                <option>PPN 10%</option>
                                                <option>PPN 100%</option>
                                                <option>PPN 1000%</option>
                                                <option>PPN 10000%</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                          <!-- <input type="file" id="file_faktur" required="" name="fileFaktur" /> -->

                                      </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="Invoice No" class="col-sm-3 control-label">No. SP/PO</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" required="" id="sppo_no" name="sppo_no" >
                                    </div>
                            <!-- <div class="col-sm-3">
                              <input type="file" required="" name="fileInv" />
                          </div> -->
                      </div>

                      <div class="form-group">
                        <label for="bapp no" class="col-sm-3 control-label">No. BAPP</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" required="" id="bapp_no" name="bapp_no" >
                        </div>
                        <div class="col-sm-3">
                            <input type="file" required="" name="fileBapp" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bapp no" class="col-sm-3 control-label">No. BAST</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" required="" id="bast_no" name="bast_no" >
                        </div>
                        <div class="col-sm-3">
                            <input type="file" required="" name="fileBast" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bapp no" class="col-sm-3 control-label">No. Kwitansi</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" required="" id="kwitansi_no" name="kwitansi_no" >
                        </div>
                        <div class="col-sm-3">
                            <input type="file" required="" name="fileKwitansi" />
                        </div>
                    </div>

                        <!-- <div class="form-group">
                          <label for="faktur" class="col-sm-3 control-label"></label>
                          <div class="col-sm-4">
                            <input type="checkbox" id="no_tax" name="no_tax" onchange="noTax(this)" />&nbsp;&nbsp;No Tax
                          </div>
                          <div class="col-sm-3">
                          </div>
                      </div>  -->
                      <div class="form-group">
                        <label for="bapp no" class="col-sm-3 control-label">K3</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="K3" name="K3" >
                        </div>
                        <div class="col-sm-3">
                            <input type="file" name="fileK3" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bapp no" class="col-sm-3 control-label">Potongan Mutu</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="potmut_no" name="potmut_no" >
                        </div>
                        <div class="col-sm-3">
                            <input type="file" name="filePotMutu" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bapp no" class="col-sm-3 control-label">Surat Permohonan Pembayaran</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" required="" id="spbyr_no" name="spbyr_no" >
                        </div>
                        <div class="col-sm-3">
                            <input type="file" required="" name="filespbyr" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bapp no" class="col-sm-3 control-label">Denda</label>
                        <div class="col-sm-2">
                            <select class="form-control" id="denda" name="denda">
                                <option value="0">Pilih Jenis Denda</option>
                                <option value="D001">K3</option>
                                <option value="D002">Potongan Mutu</option>
                                <option value="D003">Potongan Lainnya</option>
                                <option value="D004">PPn</option>
                                <option value="D005">Keterlambatan pengiriman</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="Nominal" name="Nominal" placeholder="Nominal Denda">
                        </div>
                        <div class="col-sm-3">
                          <!-- <input type="file" name="fileDenda" /> -->
                      </div>
                  </div>
                  <div class="form-group">
                    <label for="bapp no" class="col-sm-3 control-label"></label>
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-info" onclick="addDenda()">Tambah</button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="faktur" class="col-sm-3 control-label"></label>
                    <div class="col-sm-8">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Jenis Denda</th>
                                    <th class="text-center">Nominal</th>
                                    <th class="text-center">File</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-denda">
                                            <!-- <tr>
                                                    <td class="text-center">K3</td>
                                                    <td class="text-center">1.000.000</td>
                                                    <td class="text-center"><input type="file" name="fileDenda" /></td>
                                                </tr> -->

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                        <!-- <div class="form-group">
                          <label for="bapp no" class="col-sm-3 control-label">Denda K3</label>
                          <div class="col-sm-4">
                            <input type="text" class="form-control" required="" id="bapp_no" name="bapp_no" >
                          </div>
                          <div class="col-sm-3">
                            <input type="file" required="" name="fileBapp" />
                          </div>
                      </div> -->

                        <!-- <div class="form-group">
                          <label for="bapp no" class="col-sm-3 control-label">No. SPK</label>
                          <div class="col-sm-4">
                            <input type="text" class="form-control" required="" id="bapp_no" name="bapp_no" >
                          </div>
                          <div class="col-sm-3">
                            <input type="file" required="" name="fileBapp" />
                          </div>
                      </div> -->
                      <div class="form-group">
                        <label for="bapp no" class="col-sm-3 control-label">Dokumen Tambahan</label>
                        <div class="col-sm-2">
                            <select class="form-control">
                                <option>Pilih Jenis Dokumen</option>
                                <option>RR</option>
                                <option>BAPB</option>
                                <option>Analisa Mutu</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="Nomor_Dokumen" name="Nomor_Dokumen" placeholder="Nomor Dokumen">
                        </div>
                        <div class="col-sm-3">
                            <input type="file" name="fileDokumen" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bapp no" class="col-sm-3 control-label"></label>
                        <div class="col-sm-3">
                            <button class="btn btn-info" type="submit">Tambah</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="faktur" class="col-sm-3 control-label"></label>
                        <div class="col-sm-7">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Jenis Dokumen</th>
                                        <th class="text-center">Nomor Dokumen</th>
                                        <th class="text-center">File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">BAPB</td>
                                        <td class="text-center">24254654737</td>
                                        <td class="text-center">uvuuuevuuewwuu.jpg</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="faktur" class="col-sm-3 control-label">Amount</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="Amount" required="" id="totalview" readonly="">
                        </div>
                        <div class="col-sm-3">
                          <!-- <input type="file" required name="fileAmount" /> -->
                      </div>
                  </div>
                  <div class="form-group">
                    <label for="faktur" class="col-sm-3 control-label">Total Amount</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="totalAmount" required="" id="totalAmount" readonly="">
                    </div>
                    <div class="col-sm-3">
                      <!-- <input type="file" required name="fileAmount" /> -->
                  </div>
              </div>
              <div class="col-sm-offset-3 col-sm-9">
                <p class="help-block"><small>ukuran upload file maks 500kb, tipe file: *.jpg / *.png / *.pdf</small></p>
            </div>
            <div class="form-group">
                <label for="note" class="col-sm-3 control-label">Note</label>
                <div class="col-sm-9">
                    <textarea name="note" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="hidden" id="arrGR" name="arrgr[]" />
                    <input type="hidden" id="curr" name="curr" />
                    <input type="hidden" id="total" name="total" />
                    <input type="hidden" id="arrGRL" name="arrgrl[]" />
                    <button class="btn btn-info pull-right" type="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="text-right">
    <!-- <button class="btn btn-info" id="renewPR">Perbarui</button> -->
</div>
</div>
</div>
</div>
</div>

<div class="modal fade" id="modalInvoinceNo">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>INVOICE<!-- <?php //echo $baseLanguage ['principal_manufacturer_addTtl'] ;   ?> --></u></strong></h4>
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
                    <h4 class="modal-title text-center"><strong><u>Faktur Pajak<!-- <?php //echo $baseLanguage ['principal_manufacturer_addTtl'] ;   ?> --></u></strong></h4>
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
        <div class="modal-dialog modal-md">
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
                                        <th class="text-center ts0"><a href="javascript:void(0)">No</a></th>
                                        <th class="text-center ts1"><a href="javascript:void(0)">Tanggal</a></th>
                                        <th class="text-center ts2"><a href="javascript:void(0)">Status</a></th>
                                        <th class="text-center ts2"><a href="javascript:void(0)">Keterangan</a></th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTableTrack">
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td class="text-center">1-1-2011</td>
                                        <td class="text-center">Draft</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <td class="text-center">2-1-2011</td>
                                        <td class="text-center">Submitted</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">3</td>
                                        <td class="text-center">3-1-2011</td>
                                        <td class="text-center">Rejected</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
