<section>
<div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel">
                                <div class="panel-heading">Invoice Vendor</div>
                                <div class="panel-body">
                                <form id="submitInv" method="post" accept-charset="utf-8" action="<?php echo site_url("Int_invoice/updateInvoice"); ?>" class="form-horizontal general_form">
                                    <div class="col-md-12 hidden">
                                        <input type="hidden" class="form-control" id="edit_id" name="edit_id" value="<?php echo $ver['ID_INVOICE']?>">
                                        <input type="hidden" class="form-control" id="vnd_no" name="vnd_no" value="<?php echo $ver['VENDOR_NO']?>">
                                    </div>

                                    
                                    <div class="form-group" style="display: flex; margin-top: 15px;">                                
                                        <label for="VENDOR_NO" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">No. Vendor</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="VENDOR_NO" name="VENDOR_NO" value="<?php echo $ver['VENDOR_NO']?>" disabled="disabled">
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group" style="display: flex; margin-top: 15px;">
                                        <label for="new_tgl" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">Tanggal Invoice</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="new_tgl_inv" id="new_tgl_inv" class="form-control" value="<?php echo $ver['TGL_INV']?>" disabled="disabled"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" style="display: flex; margin-top: 15px;">                                
                                        <label for="new_po" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">No. PO</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="new_po" name="new_po" value="<?php echo $ver['NO_PO']?>" disabled="disabled">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group" style="display: flex; margin-top: 15px;">                                
                                        <label for="new_po" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">No. GR</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="new_gr" name="new_gr" value="<?php echo $ver['NO_GR']?>" disabled="disabled">
                                        </div>
                                    </div>

                                    <div class="form-group" style="display: flex; margin-top: 15px;">                                
                                        <label for="new_invoice" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">No. Invoice</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="new_invoice" name="new_invoice" value="<?php echo $ver['NO_INVOICE']?>" disabled="disabled">
                                        </div>
                                    </div>

                                    <div class="form-group" style="display: flex; margin-top: 15px;">
                                        <label for="new_pajak" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">Faktur Pajak</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="new_pajak" name="new_pajak" value="<?php echo $ver['F_PAJAK']?>" disabled="disabled">
                                        </div>
                                        <div class="col-sm-3">
                                                <?php
                                                if (!empty($ver["FILE_PAJAK"])) { ?>
                                                    <label class="control-label"><span class="messageUpload"><a style="color: #666; text-decoration: underline" target="_blank" href="<?php echo base_url('Int_invoice')."/viewDok/".$ver["FILE_PAJAK"]; ?>" title="File Attachment">File Attachment</a></span></label>
                                                <?php
                                                } ?>
                                        </div>
                                    </div>

                                    <div class="form-group" style="display: flex; margin-top: 15px;">
                                        <label for="new_bapp" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">BAPP</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="new_bapp" name="new_bapp" value="<?php echo $ver['FIK_BAPP']?>" disabled="disabled">
                                        </div>
                                        <div class="col-sm-3">
                                                <?php
                                                if (!empty($ver["FILE_BAPP"])) { ?>
                                                    <label class="control-label"><span class="messageUpload"><a style="color: #666; text-decoration: underline" target="_blank" href="<?php echo base_url('Int_invoice')."/viewDok/".$ver["FILE_BAPP"]; ?>" title="File Attachment">File Attachment</a></span></label>
                                                <?php
                                                } ?>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group" style="display: flex; margin-top: 15px;">
                                        <label for="new_bast" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">BAST</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="new_bast" name="new_bast" value="<?php echo $ver['FIK_BAST']?>" disabled="disabled">
                                        </div>
                                        <div class="col-sm-3">
                                                <?php
                                                if (!empty($ver["FILE_BAST"])) { ?>
                                                    <label class="control-label"><span class="messageUpload"><a style="color: #666; text-decoration: underline" target="_blank" href="<?php echo base_url('Int_invoice')."/viewDok/".$ver["FILE_BAST"]; ?>" title="File Attachment">File Attachment</a></span></label>
                                                <?php
                                                } ?>
                                        </div>
                                    </div>

                                    <div class="form-group" style="display: flex; margin-top: 15px;">                                
                                        <label for="new_ket" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">Keterangan</label>
                                        <div class="col-sm-3">
                                            <textarea name="new_ket" style="margin: 0px; width: 440px; height: 96px;" placeholder="<?php echo $ver['FIK_BAST']?>" disabled="disabled"></textarea>
                                        </div>
                                    </div>
                                
                                        <div class="form-group" style="display: flex; margin-top: 15px;">
                                            <select class="form-control action-option" id="new_status" name="new_status" style="width: initial; margin:auto;">
                                                <!-- <option value="0">-Pilih aksi-</option> -->
                                                <option value="1">Approve</option>
                                                <option value="2">Revisi</option>
                                            </select>
                                        </div>

                                        <div class="form-group" style="display: flex; margin-top: 15px;">
                                            <textarea class="form-control reject-reason" style="margin-top: 10px" placeholder="Alasan Revisi" name="revisi"></textarea>
                                        </div>


                                        <!-- <div class="panel-body approve-payment">
                                        <div class="panel-heading">Payment</div>
                                        	<div class="form-group" style="display: flex; margin-top: 15px;">                                
                                        		<label for="tax_type" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">Tax Type<span style="color: #E74C3C">*</span></label>
                                        	<div class="col-sm-6">
                                            	<select class="form-control" id="tax_type" name="tax_type">
                                                	<option value="CK">CK (PPN Keluaran 10% - PPH 1.5%)</option>
                                                	<option value="CM">CM (PPN Keluaran 10% + PPH 0.25%)</option>
                                                	<option value="CN">CN (PPN Keluaran 10%)</option>
                                                	<option value="CR">CR (PPN Keluaran 0% + PPH 0.25%)</option>
                                                	<option value="CV">CV (PPN Keluaran 10% - Dipungut (21520005))</option>
                                                	<option value="CW">CW (PPN Keluaran 10% + PPH 0.25% Dipungut)</option>
                                                	<option value="CX">CX (PPN Keluaran 0% - Dibebaskan)</option>
                                                	<option value="CY">CY (PPN Keluaran 10% - Dibebaskan)</option>
                                                	<option value="CZ">CZ (PPN Keluaran 10% - Dipungut)</option>
                                                	<option value="DN">DN (PPN Keluaran WAPU 10% - Dpt dikreditkan (Dlm Negri))</option>
                                                	<option value="H4">H4 (0.25% PPH 22 Pembelian Semen)</option>
                                                	<option value="H5">H5 (0,30% PPH 22 BBM Non Pertamina)</option>
                                                	<option value="K1">K1 (PPN WAPU Konsinyasi)</option>
                                                	<option value="K2">K2 (PPN Masukan Konsinyasi)</option>
                                                	<option value="K3">K3 (PPN Invoice Konsinyasi)</option>
                                                	<option value="PN">PN (PPN Masukan 10% - Proyek)</option>
                                                	<option value="UM">UM (PPN Masukan 10% - Dapat dikreditkan (UM Valas))</option>
                                                	<option value="UN">UN (PPN Masukan UM WAPU 10% - Dpt dikredit (Dlm Negeri))</option>
                                                	<option value="UT">UT (PPN Masukan UM WAPU 10% - Tdk dapat dikreditkan)</option>
                                                	<option value="UX">UX (PPN Masukan UM WAPU 1% - Tdk dpt dikredit (Dlm Neg))</option>
                                                	<option value="V1">V1 (PPN Masukan 10% + 2,5% PPH 22 Impor)</option>
                                                	<option value="V2">V2 (PPN Masukan 10% + 0,1% PPH 22 Pembelian Kertas)</option>
                                                	<option value="V3">V3 (PPN Masukan 10% + 0,25% PPH 22 Pembelian Semen)</option>
                                                	<option value="V4">V4 (PPN Masukan 10% + 0,25% PPH 22 BBM Pertamina)</option>
                                                	<option value="V5">V5 (PPN Masukan 10% + 0,30% PPH 22 BBM Non Pertamina)</option>
                                                	<option value="V6">V6 (PPN Masukan 10% + 0,30% PPH 22 Pembelian Baja)</option>
                                                	<option value="V7">V7 (PPN Masukan 10% + 0,3% PPH 22 BBM Import)</option>
                                                	<option value="VL">VL (PPN Masukan 10% - Dapat dikreditkan (Luar Negeri))</option>
                                                	<option value="VN">VN (PPN Masukan 10% - Dapat dikreditkan (Dalam Negeri))</option>
                                                	<option value="VQ">VQ (PPN Masukan 1% - Dapat dikreditkan)</option>
                                                	<option value="VT">VT (PPN Masukan 10% - Tidak dapat dikreditkan)</option>
                                                	<option value="VV">VV (PPN Masukan 10% PO Pertamina Franco)</option>
                                                	<option value="VX">VX (PPN Masukan 1% Tidak Dapat dikreditkan)</option>
                                                	<option value="VY">VY (PPN Masukan 10% Dibebaskan)</option>
                                                	<option value="VZ" selected>VZ (PPN Masukan 0%)</option>
                                                	<option value="W2">W2 (PPN Masukan WAPU10% + 0,1% PPH 22 Pembelian Kertas)</option>
                                                	<option value="W3">W3 (PPN Masukan WAPU10% + 0,25% PPH 22 Pembelian Semen)</option>
                                                	<option value="W6">W6 (PPN Masukan WAPU 10% + 0,30% PPH 22 Pembelian Baja)</option>
                                                	<option value="W7">W7 (PPN Masukan WAPU10% + 0,3% PPH 22 BBM Import)</option>
                                                	<option value="WN">WN (PPN Masukan WAPU 10% - Dpt dikreditkan (Dlm Negri))</option>
                                                	<option value="WT">WT (PPN Masukan WAPU 10% - Tidak dapat dikreditkan)</option>
                                                	<option value="WW">WW (PPN Masukan WAPU 1% - Tidak dapat dikreditkan)</option>
                                                	<option value="WX">WX (PPN Masukan WAPU 1% Tdk Dapat dikreditkan)</option>
                                                	<option value="ZZ">ZZ (PPN 10% - TEST ONLY)</option>
                                            	</select>
                                        	</div>
                                    		</div>

                                        	<div class="form-group" style="display: flex; margin-top: 15px;">                                
                                        		<label for="text" class="col-sm-3 control-label" style="text-align: end;margin: 0px;">Text<span style="color: #E74C3C">*</span></label>
                                        	<div class="col-sm-6">
                                            	<input type="text" class="form-control" id="text" name="text">
                                        	</div>
                                    		</div>
                                        </div> -->
                                        
                                        <div class="panel-footer text-center">
                                            <button id="save_new" class="main_button color1 small_btn" type="submit">Submit</button>
                                            <a href="<?php echo base_url('Int_invoice') ?>" class="main_button color7 small_btn">Batal</a>
                                        </div>
                                
                                </form>
                            </div>
                    </div>
                </div>
            </div>           
        </div>                 
    </div>
</section>