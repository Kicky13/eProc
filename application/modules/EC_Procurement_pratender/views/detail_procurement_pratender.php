<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span>Konfigurasi Perencanaan Baru</h2>
            </div>
            <?php echo form_open_multipart(base_url() . 'EC_Procurement_pratender/get_detail', array('method' => 'POST','class' => 'submit')) ?>
            <?php if($cegatan == "true") { ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Metode penunjukan langsung hanya boleh mimilih 1 vendor.</strong>
            </div>
            <?php } ?>
            <div class="row">
                <div class="col-md-12">
                <?php if ($this->session->flashdata('warning_slb')) { ?>
                    <div class="alert alert-danger"><strong>Error! </strong><?php echo $this->session->flashdata('warning_slb') ?> </div>
                <?php } ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Informasi Perencanaan</div>
                        <table class="table table-hover">
                            <tr>
                                <td>User</td>
                                <td><?php echo $this->session->userdata['FULLNAME'] ?></td>
                            </tr>
                            <tr>
                                <td>Biro / Unit</td>
                                <td><?php echo $this->session->userdata['POS_NAME'] ?></td>
                            </tr>
                            <tr>
                                <td class="form-required">Nama Pengadaan</td>
                                <td>
                                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Nama singkat pengadaan" size="40" maxlength="200">
                                </td>
                            </tr>
                            <tr>
                                <td class="form-required">Jenis Pengadaan</td>
                                <td>
                                    <select id="jenis_perencanaan" name="jenis_perencanaan">
                                        <option value="0">Barang</option>
                                        <option value="1">Jasa</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>                   
                    <div class="panel panel-default">
                        <div class="panel-heading">Pilih item</div>
                        <div class="panel-body" style="overflow: auto;">
                            <table id="pr-list-table-perencanaan" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor PR</th>
                                        <th>PR Item</th>
                                        <th title="Material Number">Mat Number</th>
                                        <th>Description</th>
                                        <th>Material Group</th>
                                        <th title="Keterangan">PR Qty</th>
                                        <th title="Keterangan">Tender Qty</th>
                                        <th title="Keterangan">PO Qty</th>
                                        <th title="Keterangan">Open Qty</th>
                                        <th title="Keterangan">Doc Type</th>
                                        <th>Plant</th>
                                        <th>Purch Grp</th>
                                        <th>MRPC</th>
                                        <th>CT</th>
                                        <th>MT</th>
                                    </tr>
                                    <tr>
                                        <!-- <th><input type="checkbox" id="checkAll"></th> -->
                                        <th></th>
                                        <th><input type="text" class="col-xs-12 input"></th>
                                        <th><input type="text" class="col-xs-12 input"></th>
                                        <th><input type="text" class="col-xs-12 input"></th>
                                        <th><input type="text" class="col-xs-12 input"></th>
                                        <th><input type="text" class="col-xs-12 input"></th>
                                        <th><input type="text" class="col-xs-12 input"></th>
                                        <th><input type="text" class="col-xs-12 input"></th>
                                        <th><input type="text" class="col-xs-12 input"></th>
                                        <th><input type="text" class="col-xs-12 input"></th>
                                        <th><input type="text" class="col-xs-12 input"></th>
                                        <th><input type="text" class="col-xs-12 input"></th>
                                        <th><input type="text" class="col-xs-12 input"></th>
                                        <th><input type="text" class="col-xs-12 input"></th>
                                        <th><input type="text" class="col-xs-12 input"></th>
                                        <th><input type="text" class="col-xs-12 input"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <font color="red"><?php echo form_error('item'); ?></font>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Item Terpilih
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <th class="text-center col-md-2">PR No</th>
                                    <th class="text-center col-md-1">PR Item</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center col-md-1" style="width:50px">T</th>
                                    <th class="text-center col-md-1">Quantity</th>
                                    <th class="text-center col-md-1">Uom</th>
                                    <th class="text-center col-md-1">Price</th>
                                    <th class="text-center col-md-1">Per</th>
                                    <th class="text-center col-md-1">Curr</th>
                                    <th class="text-center col-md-1">Total Price</th>
                                </thead>
                                <tbody id="tableItem-perencanaan">
                                </tbody>
                                <tfoot>
                                    <th class="text-center" colspan="9" style="text-align: right !important;">Total Price</th>
                                    <th id="total-price-perencanaan" class="text-center" style="text-align: right !important;">0.00</th>
                                </tfoot>
                            </table>
                            </div>
                        </div>
                    </div>          

                    <div class="panel panel-default">
                        <div class="panel-heading">Metode Perencanaan</div>
                        <table class="table table-hover">
                            <tr>
                                <td class="col-md-3 form-required">Metode Perencanaan</td>
                                <td>
                                    <select name="ptp_justification" id="ptp_justification">
                                        <option value="3">Lelang Terbuka</option>
                                        <option value="1" selected="selected">Pemilihan Langsung</option>
                                        <option value="4">Pembelian Langsung</option>
                                        <option value="2">Penunjukan Langsung</option>
                                    </select>
                                </td>
                            </tr>
                            <tr id="detail_justification">
                                <td class="form-required">Metode Penunjukan</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="radio" value="3" id="RO" name="detail_justification" class="sub_detail_justification">
                                            Repeat Order (RO)
                                        </div>
                                        <div class="col-md-4">
                                            <input type="radio" value="4" name="detail_justification" class="vnd sub_detail_justification">
                                            Sole Agent (SA) / Manufacture (MA)
                                        </div>
                                        <div class="col-md-4">
                                            <input type="radio" value="6" name="detail_justification"  class="vnd sub_detail_justification">
                                            Other (OT)
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <!-- <tr id="is_itemize">
                                <td class="form-required">Metode Penawaran</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="radio" value="1" name="is_itemize" checked>
                                            Itemize
                                        </div>
                                        <div class="col-md-4">
                                            <input type="radio" value="0" name="is_itemize">
                                            Paket
                                        </div>
                                    </div>
                                </td>
                            </tr> -->
                            <tr>
                                <td class="col-md-3 form-required">Sistem Peringatan pada Penawaran</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select name="ptp_warning">
                                                <option value="1">Tidak ada pesan</option>
                                                <option value="2">Warning</option>
                                                <option value="3">Error</option>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Prosentase Batas Atas Penawaran ECE/HPS/OE</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input type="text" name="ptp_batas_penawaran_atas" class="form-control r_number" value="100">
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3">Prosentase Batas Bawah Penawaran ECE/HPS/OE</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input type="text" name="ptp_batas_penawaran_bawah" class="form-control r_number" value="20">
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Template Evaluasi</div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-3 form-required">Template Evaluasi</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-7">
                                                <select class="form-control" name="ptp_template_evaluasi" id="ptp_template_evaluasi">
                                                    <option value="" selected="" disabled="">-Pilih-</option> 
                                                    <!-- <?php //var_dump($evatek); ?> -->
                                                    <?php foreach ($evatek['data'] as $value) { ?>
                                                        <option value="<?php echo $value['EVT_ID']; ?>"><?php echo $value['EVT_NAME']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>                                        
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Detail Template Evatek</div>
                                        <div class="panel-body">
                                            <table class="table table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center col-md-1"><strong>No</strong></th>
                                                        <th class="text-center col-md-3"><strong>Nama</strong></th>
                                                        <th class="text-center col-md-1"><strong>Bobot</strong></th>
                                                        <th class="text-center col-md-1"><strong>Mode</strong></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbl_detail_template">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>            
                                </div>                                    
                            </div>
                        </div>
                    </div>
                    
                    <div class="panel panel-default panelvendor_barang pnl_satu">
                        <div class="panel-heading">
                            Pilih Vendor
                            <button class="btn btn-sm btn-default invisible">G</button>
                            <div class="pull-right">
                                <button type="button" class="btn btn-sm btn-default generate_vendor">Generate</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table id="pr-list-table-vendor" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>No Vendor</th>
                                        <th>Nama Vendor</th>
                                        <th>Mat Grp</th>
                                        <th>Sub Grp</th>
                                        <th>Tipe Vendor</th>
                                        <th>Performance</th>
                                        <th>Kategori Vendor</th>
                                        <th>PO Collected</th>
                                        <th>PO Outstanding</th>
                                    </tr>
                                    <tr>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <font color="red"><?php echo form_error('item'); ?></font>
                        </div>
                    </div>

                    <div class="panel panel-default form-horizontal panelvendor_jasa">
                        <div class="panel-heading">Filter Jasa</div>
                        <div class="panel-body">
                            <tr>
                                <td>  
                                    <div class="form-group">                              
                                        <div class="col-md-10">
                                            <div class="col-md-4">
                                                <select style="width:250px" name="group_jasa_id" id="group_jasa_id" class="form-control select2" >
                                                    <option value="" selected="">Pilih Grup Jasa</option>
                                                    <?php foreach ($group_jasa as $key => $value) { ?>
                                                        <option value="<?php echo $value["ID"]; ?>"><?php echo $value["NAMA"]; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <select style="width:250px" name="subGroup_jasa_id" id="subGroup_jasa_id" class="form-control select2">
                                                    <option value="" selected="">Pilih Sub Grup Jasa</option>
                                                </select>                                             
                                            </div>
                                            <div class="col-md-4">
                                                <select style="width:250px" name="klasifikasi_jasa_id" id="klasifikasi_jasa_id" class="form-control select2">
                                                    <option value="" selected="">Pilih Klasifikasi</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <div class="col-md-10">
                                            <div class="col-md-5">
                                                <div id="subKlasifikasi_ganjil"></div>
                                            </div> 
                                            <div class="col-md-5">
                                                <div id="subKlasifikasi_genap"></div>
                                            </div> 
                                        </div>                                   
                                        <div class="col-md-10">
                                            <div class="col-md-2">
                                                <button id="search" class="btn btn-success" type="button">Search</button>
                                            </div>
                                        </div>
                                    </div>                                    
                                </td>
                            </tr>
                            <table id="table_vendor_jasa" class="table table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Pilih</th>
                                        <th>No Vendor</th>
                                        <th>Nama Vendor</th>
                                        <th>Group</th>
                                        <th>Klasifikasi</th>
                                        <th>Kualifikasi</th>
                                        <th class="text-center">Performance</th>
                                        <th class="text-center">Kategori Vendor</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <font color="red"><?php echo form_error('item'); ?></font>
                        </div>
                    </div>

                    <div class="panel panel-default panelvendor_barang pnl_dua">                    
                        <div class="panel-heading" style="background-color: #96999A;">
                            Pilih Vendor Non Dirven
                            <button class="btn btn-sm btn-default invisible">G</button>
                            <div class="pull-right">
                                <button type="button" class="btn btn-sm btn-default" id="generate_vnd_brg_tmbhn">Generate</button>
                            </div>
                        </div>
                        <div class="panel-body" style="overflow: auto;" id="grdBarang">
                            <table id="table_vendor_barang_tambahan" class="table table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Pilih</th>
                                        <th>No Vendor</th>
                                        <th>Nama Vendor</th>
                                        <th>Mat Grp</th>
                                        <th>Sub Grp</th>
                                        <th>Tipe Vendor</th>
                                        <th>Performance</th>
                                        <th>Kategori Vendor</th>
                                        <th>PO Collected</th>
                                        <th>PO Outstanding</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <font color="red"><?php echo form_error('item'); ?></font>
                        </div>
                    </div>

                    
                    
                    <!-- <div class="panel panel-default panelvendor_jasa">
                        <div class="panel-heading">
                            Pilih Vendor
                        </div>
                        <div class="panel-body">
                            <table id="table_vendor_jasa" class="table table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Pilih</th>
                                        <th>No Vendor</th>
                                        <th>Nama Vendor</th>
                                        <th>Group</th>
                                        <th>Klasifikasi</th>
                                        <th>Kualifikasi</th>
                                        <th class="text-center">Performance</th>
                                        <th class="text-center">Kategori Vendor</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                        <th><input type="text" class="col-xs-12"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <font color="red"><?php echo form_error('item'); ?></font>
                        </div>
                    </div> -->  
                    <div class="panel panel-default ">
                        <div class="panel-heading">Vendor Terpilih</div>
                        <table class="table table-stripped" id="table_vendor_terpilih">
                            <thead>
                                <th class="col-md-1"></th>
                                <th>No Vendor</th>
                                <th>Nama Vendor</th>
                            </thead>
                            <tbody class="vendor_terpilih"></tbody>
                        </table>
                    </div>
                    <div class="panel panel-default panelvendor_barang">
                        <div class="panel-heading" style="background-color: #96999A;">Vendor Terpilih Non Dirven</div>
                        <table class="table table-stripped" id="table_vendor_terpilih_nonDirven">
                            <thead>
                                <th class="col-md-1"></th>
                                <th>No Vendor</th>
                                <th>Nama Vendor</th>
                                <th>Tender Type</th>
                                <th>Nama Principal</th>
                            </thead>
                            <tbody class="vendor_terpilih_tambahan"></tbody>
                        </table>
                    </div>
                    <div class="panel panel-default" id="panelpo" hidden>
                        <div class="panel-heading">
                            Pilih PO
                            <button class="btn btn-sm btn-default invisible">G</button>
                            <div class="pull-right">
                                <button type="button" class="btn btn-sm btn-default generate_po">Generate</button>
                            </div>
                        </div>
                        <div class="panel-body" style="width: 100%; overflow-x: auto;">
                            <table id="pr-list-table-po" class="table table-striped">
                                <tbody>
                                    <td colspan="6">Pilih item lalu klik generate untuk menampilkan list PO</td>
                                </tbody>
                            </table>
                            <font color="red"><?php echo form_error('item'); ?></font>
                        </div>
                    </div>
                    <?php echo $ptm_comment ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Komentar Anda</div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-4">Komentar</td>
                                    <td>
                                        <textarea maxlength="1000" name="comment" class="form-control" style="resize:vertical"></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <select class="harusmilih_publicjs">
                                <option value="false_public"></option>
                                <!-- <option>Lanjut ke aproval Subpratender.</option> -->
                                <option>Lanjut ke <?php echo $next_process['NAMA_BARU']; ?></option>
                            </select>
                            <input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar"></input>
                            <button type="submit" class="main_button color7 small_btn milihtombol_publicjs" disabled id="tombol">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>

<div class="modal fade" id="modal_dokumen">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">Informasi Tambahan PR <span class="pr"></span></div>
            <div class="modal-body">
                <table class="table table-hover">
                    <thead>
                        <th>Pilih</th>
                        <th>Tipe</th>
                        <th>Nama</th>
                        <th>File</th>
                        <th>Tanggal</th>
                        <th>User</th>
                    </thead>
                    <tbody id="dokumentable">
                    </tbody>
                </table>
                <div class="panel panel-default">
                    <div class="panel-body text-center">
                        <button type="button" id="savedoc" class="main_button color2 small_btn">Simpan</button>
                        <button type="button" class="main_button color7 small_btn close-modal">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_dokumen_dua">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">Detail Description</div>
      <div class="modal-body">
        <div id="idku"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_view_pr">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">Dokumen PR</div>
      <div class="modal-body">
        <div id="dokumen_pr"></div>
      </div>
    </div>
  </div>
</div>     