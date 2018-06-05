<section>
<div class="content_spacer">
                <div class="content">
                    <div class="main_title centered upper">
                        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel">
                            	<div class="panel-heading">Payment</div>
                            	<div class="panel-body approve-payment">
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
                                        </div>

                                        <div class="panel-footer text-center">
                                            <button id="save_new" class="main_button color1 small_btn" type="submit">Submit</button>
                                            <a href="<?php echo base_url('Int_invoice') ?>" class="main_button color7 small_btn">Batal</a>
                                        </div>


                            </div>
                        </div>
                    </div>
                </div>
</div>
</section>