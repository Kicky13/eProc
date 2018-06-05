<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
                <input type="hidden" id="Tanggal" value="<?php echo $tanggal ?>">
                <input type="hidden" id="Tanggal2" value="<?php echo $tanggal2 ?>">
                <input type="hidden" id="statusAuction" value="<?php echo $Detail_Auction['IS_ACTIVE'] ?>">
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Auction
                        </div>
                        <div class="panel-body">
                            <form action="<?php echo base_url()?>EC_Auction_bobot/edit" method="post" > 
                            <div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px;">
                                <div class="col-lg-2">
                                    Nomor Tender
                                </div>
                                <div class="col-lg-10">
                                    :&nbsp<strong id="NO_TENDER"><?php echo $Detail_Auction['NO_TENDER'] ?></strong>
                                </div>
                            </div> 
                            <div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px;">
                                <div class="col-lg-2">
                                    Nomor Referensi
                                </div>
                                <div class="col-lg-10">
                                    :&nbsp<strong id="NO_TENDER"><?php echo $Detail_Auction['NO_REF'] ?></strong>
                                </div>
                            </div>  
                            <div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px; padding-top: 3px;">
                                <div class="col-lg-2">
                                    Deskripsi
                                </div>
                                <div class="col-lg-10">
                                    :&nbsp<strong><?php echo $Detail_Auction['DESC'] ?></strong>
                                </div>
                            </div>
                            <div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px; padding-top: 3px;">
                                <div class="col-lg-2">
                                    Lokasi Auction
                                </div>
                                <div class="col-lg-10">
                                    :&nbsp<strong><?php echo $Detail_Auction['LOCATION'] ?></strong>
                                </div>
                            </div> 
                            <div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px; padding-top: 3px;">
                                <div class="col-lg-2">
                                    Tanggal Pembukaan
                                </div>                                
                                <div class="col-lg-5">
                                    <div class="input-group date">
                                    <input type="text" id="TGL_BUKAedit" name="TGL_BUKA" value="<?php echo $Detail_Auction['PEMBUKAAN'] ?>" required="" class="auc_start form-control">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div><strong class="hidden" id="TGL_BUKA"><?php echo $Detail_Auction['PEMBUKAAN'] ?></strong>
                                </div>
                            </div>
                            <div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px; padding-top: 3px;">
                                <div class="col-lg-2">
                                    Tanggal Penutupan
                                </div>
                                <div class="col-lg-5">
                                    <div class="input-group date">
                                    <input type="text" id="TGL_TUTUPedit" name="TGL_TUTUP" value="<?php echo $Detail_Auction['PENUTUPAN'] ?>" required="" class="auc_start form-control">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div><strong class="hidden" id="TGL_TUTUP"><?php echo $Detail_Auction['PENUTUPAN'] ?></strong>
                                </div>
                            </div>
                            <div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px; padding-top: 3px;">
                                <div class="col-lg-2">
                                    Bobot Teknis
                                </div>
                                <div class="col-lg-10">
                                    :&nbsp<strong><?php echo $Detail_Auction['BOBOT_TEKNIS'] ?> %</strong>
                                </div>
                            </div> 
                            <div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px; padding-top: 3px;">
                                <div class="col-lg-2">
                                    Bobot harga
                                </div>
                                <div class="col-lg-10">
                                    :&nbsp<strong><?php echo $Detail_Auction['BOBOT_HARGA'] ?> %</strong>
                                </div>
                            </div> 
                            <div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px; padding-top: 3px;">
                                <div class="col-lg-2">
                                    Nilai Pengurangan
                                </div> 
                                <div class="col-lg-10">
                                    :&nbsp<strong id="CURR"><?php echo $Detail_Auction['CURR'] ?></strong><strong> <?php echo number_format($Detail_Auction['NILAI_PENGURANGAN'],0,",",".") ?></strong>
                                </div>
                            </div>
                            <div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px; padding-top: 3px;">
                                <div class="col-lg-2">
                                    Tipe Auction
                                </div>
                                <div class="col-lg-10">
                                    :&nbsp<strong><?php if ($Detail_Auction['TIPE']=='T') {
                                        echo 'Harga Total';
                                    }else{
                                        echo 'Harga Satuan';
                                    }?></strong>
                                </div>
                            </div>
                            <div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px; padding-top: 3px;">
                                <div class="col-lg-2">
                                    HPS/OE
                                </div>
                                <div class="col-lg-10">
                                    :&nbsp<strong><?php echo $Detail_Auction['CURR'] ?></strong><strong id="hps"> <?php echo number_format($Detail_Auction['HPS'],0,",",".") ?></strong>
                                </div>
                            </div>
                            <input type="hidden" id="tipeHPS" value="<?php echo $Detail_Auction['TIPE'] ?>" />  
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="NO_TENDER" value="<?php echo $Detail_Auction['NO_TENDER'] ?>" />
                                    <button id="editBTN" style="margin-top: 15px" type="submit" class="main_button color2 small_btn pull-left">
                                    Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                            </form>                               
                        </div>                
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Waktu Tersisa
                        </div>
                        <div class="panel-body">
                            <div class="col-md-5 col-md-offset-4">
                                <h3 id="BELUM">AUCTION BELUM DIMULAI</h3>
                            </div>
                            <div class="col-md-5 col-md-offset-4">
                                <h3 id="SELESAI">AUCTION SELESAI</h3>
                            </div>
                            <div class="col-md-5 col-md-offset-4">
                                <h3 id="CLOSED">AUCTION CLOSED</h3>
                            </div>
                            <div class="col-md-5 col-md-offset-4">
                                <div class="my-clock"></div>
                            </div>
                            <div class="col-md-12">
                                <form action="<?php echo base_url()?>EC_Auction_bobot/close" method="post" >
                                <input type="hidden" name="NO_TENDER" value="<?php echo $Detail_Auction['NO_TENDER'] ?>" />
                                <button id="closeBTN" type="submit" class="main_button color1 small_btn pull-right">
                                CLOSE AUCTION
                                </button>
                               </form>
                            </div>
                        </div>                
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Item
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover" id="negotiation_list">
                                <thead>
                                    <tr>
                                        <th class="text-left">No</th>
                                        <th class="text-left">Kode Item</th>
                                        <th class="text-left">Deskripsi</th>
                                        <th class="text-center">Kuantitas</th>
                                        <th class="text-center">Uom</th>
                                        <th class="text-center">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="item">
                                             
                                </tbody>
                            </table>
                        </div>                
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="padding-bottom: 20px;">
                            Peserta Auction
                            <a target="_blank" href="<?php echo base_url();?>EC_Auction_bobot/print_e_auction_peserta/<?php echo $Detail_Auction['NO_TENDER']?>" type="button" style="margin-right: 20px" class="printt btn btn-default pull-right" aria-label="Left Align" >
                              <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                            </a>
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover" id="negotiation_list">
                                <thead>
                                    <tr>
                                        <th class="text-left">No</th>
                                        <th class="text-left">Vendor Code</th>
                                        <th class="text-left">Nama Vendor</th>
                                        <th class="text-center">Nilai Teknis</th>
                                        <th class="text-center">Harga Awal</th>
                                        <th class="text-center">Harga Terkini</th>
                                        <th class="text-center">Nilai Total</th>
                                    </tr>
                                </thead>
                                <tbody id="Peserta">
                                             
                                </tbody>
                            </table>
                        </div>                
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="padding-bottom: 20px;">
                            Log Auction 
                            <a target="_blank" href="<?php echo base_url();?>EC_Auction_bobot/print_e_auction_log/<?php echo $Detail_Auction['NO_TENDER']?>" type="button" style="margin-right: 20px" class="printt btn btn-default pull-right" aria-label="Left Align" >
                              <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                            </a>
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover" id="negotiation_list">
                                <thead>
                                    <tr>
                                        <th class="text-left">No</th>
                                        <th class="text-left">Created At</th>
                                        <th class="text-left">Iter</th>
                                        <th class="text-center">Vendor</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Bawah ECE</th>
                                    </tr>
                                </thead>
                                <tbody id="Log"> 
                                </tbody>
                            </table>
                        </div>                
                    </div>
                </div>
            </div>

            <div class="row" id="Cetak22">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <!-- <div class="panel-heading">
                            Log Auction 
                        </div> -->
                        <div class="panel-body">
                            Note :
                            <br>
                            <textarea class="form-control" rows="4" id="Note" name="Note"><?php echo $Detail_Auction['NOTE']?></textarea>
                            <br>
                            <a onclick="cetak('<?php echo $Detail_Auction['NO_TENDER']?>')" href="javascript:void(0)" type="button"  class="main_button color1 small_btn pull-right">
                                Cetak
                            </a>
                            <!-- <a target="_blank" onclick="cetak('<?php //echo $Detail_Auction['NO_TENDER']?>')" href="<?php //echo base_url();?>EC_Auction_bobot/print_e_auction/<?php //echo $Detail_Auction['NO_TENDER']?>" type="button"  class="main_button color1 small_btn pull-right">
                                Cetak
                            </a>  -->
                        </div>                
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
