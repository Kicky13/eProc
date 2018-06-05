<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
                <input type="hidden" id="Tanggal" value="<?php echo $tanggal ?>">
                <input type="hidden" id="Tanggal2" value="<?php echo $tanggal2 ?>">
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Auction
                </div>
                <div class="panel-body">
                    <div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px;">
                        <div class="col-lg-2">
                            Tender Number
                        </div>
                        <div class="col-lg-10">
                            :&nbsp<strong id="no_tender"><?php echo $auction['NO_TENDER'] ?></strong>
                        </div>
                    </div>  
                    <div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px;">
                        <div class="col-lg-2">
                            Nomor Refrensi
                        </div>
                        <div class="col-lg-10">
                            :&nbsp<strong id="no_tender"><?php echo $auction['NO_REF'] ?></strong>
                        </div>
                    </div>  
                    <div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px; padding-top: 3px;">
                        <div class="col-lg-2">
                            Deskripsi
                        </div>
                        <div class="col-lg-10">
                            :&nbsp<strong><?php echo $auction['DESC'] ?></strong>
                        </div>
                    </div>
                    <div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px; padding-top: 3px;">
                        <div class="col-lg-2">
                            Lokasi Auction
                        </div>
                        <div class="col-lg-10">
                            :&nbsp<strong><?php echo $auction['LOCATION'] ?></strong>
                        </div>
                    </div> 
                    <div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px; padding-top: 3px;">
                        <div class="col-lg-2">
                            Tanggal Pembukaan
                        </div>
                        <div class="col-lg-10">
                            :&nbsp<strong id="TGL_BUKA"><?php echo $auction['PEMBUKAAN'] ?></strong>
                        </div>
                    </div>
                    <div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px; padding-top: 3px;">
                        <div class="col-lg-2">
                            Tanggal Penutupan
                        </div>
                        <div class="col-lg-10">
                            :&nbsp<strong id="TGL_TUTUP"><?php echo $auction['PENUTUPAN'] ?></strong>
                        </div>
                    </div>
                    <div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 3px; padding-top: 3px;">
                        <div class="col-lg-2">
                            Nilai Pengurangan
                        </div>
                        <div class="col-lg-10">
                            :&nbsp<strong><?php echo $auction['CURR'] ?></strong><strong> <?php echo number_format($auction['NILAI_PENGURANGAN'],0,",",".") ?></strong>
                        </div>
                    </div>
                    <div class="row" style="padding-top: 3px;">
                        <div class="col-lg-2">
                            Tipa Auction
                        </div>
                        <div class="col-lg-10">
                            :&nbsp<strong><?php if ($auction['TIPE']=='T') {
                                        echo 'Harga Total';
                                    }else{
                                        echo 'Harga Satuan';
                                    }?></strong>
                        </div>
                    </div>  
                </div>                
            </div>

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
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                for ($i=0; $i < sizeof($item) ; $i++) {                                             
                            ?>
                                <tr style="border-bottom: 1px solid #ccc;">
                                    <td class="text-left"><?php echo $i+1 ?></td>
                                    <td class="text-left"><?php echo $item[$i]['KODE_BARANG'] ?></td>
                                    <td class="text-left"><?php echo $item[$i]['NAMA_BARANG'] ?></td>
                                    <td class="text-center"><?php echo $item[$i]['JUMLAH'] ?></td>
                                    <td class="text-center"><?php echo $item[$i]['UNIT'] ?></td>                                   
                                </tr>   
                            <?php } ?>         
                        </tbody>
                    </table>
                </div>                
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo $baseLanguage ['peserta']; ?>
                </div>
                <div class="panel-body">
                    <table class="table table-hover" id="negotiation_list">
                        <thead>
                            <tr>
                                <th class="text-left">Vendor</th>
                                <th class="text-left">Harga Awal</th>
                                <th class="text-left">Harga Akhir</th>
                                <th class="text-center">STATUS</th>                                
                            </tr>
                        </thead>
                        <tbody> 
                            <tr style="border-bottom: 1px solid #ccc;">
                                <th class="text-left"><?php echo $vendor['NAMA_VENDOR'] ?></th>
                                <th class="text-left"><?php echo $auction['CURR'].' '.number_format($vendor['HARGAAWAL'],0,",",".") ?></th>
                                <th class="text-left"><?php echo $auction['CURR'].' ';?> <span class="hraga_terakhir"><?php echo number_format($vendor['HARGATERKINI'],0,",",".") ?></span></th>
                                <th class="text-center"><img width="15%" class="label_ece <?php if($vendor['HARGATERKINI']>$auction['HPS'])echo 'hidden'?>" height="15%" src="<?php echo base_url() ?>/upload/EC_auction/giphy.gif" /> <!-- <span class="label label-warning label_ece --> <!-- " >ECE</span> --></th>                                                                
                            </tr>            
                        </tbody>
                    </table>
                </div>                
            </div>

                    <div class="panel panel-default panel_bidder" id="bidderContainer">
                        <div class="panel-heading">
                            Bidder
                        </div>
                        <div class="panel-body">
                        	<div class="row">  
                                <div class="col-md-5 col-md-offset-4">
                                    <h3 id="BELUM">AUCTION BELUM DIMULAI</h3>
                                </div>
                                <div class="col-md-5 col-md-offset-4">
                                    <h3 id="SUDAH">AUCTION SUDAH SELESAI</h3>
                                </div>
                        		<div class="col-md-6 col-md-offset-4">
                        			<div class="your-clock"></div>
                        		</div>
                        		<div class="col-md-6 col-md-offset-5 piala hidden">
                        			<img class="logo_dark" src="<?php echo base_url() ?>/upload/EC_auction/piala.gif">
                        			<!-- http://10.15.5.150/dev/eproc/static/images/trophy.jpg -->
                        		</div>
                        		<div class="col-md-3 col-md-offset-5">
                        			<span id="hargapenawaran" style="margin-top: 6px;display: inline-block;">
                        				Harga Terakhir: <?php echo $auction['CURR'].' '?><span class="hraga_terakhir"><?php echo number_format($vendor['HARGATERKINI'],0,",",".") ?></span>                                           
                                    </span>
                                    <!-- <span class="label label-warning label_ece <?php //if($vendor['HARGATERKINI']>$auction['HPS'])echo 'hidden'?>" >ece</span> -->
                                    <img width="15%" class="label_ece <?php if($vendor['HARGATERKINI']>$auction['HPS'])echo 'hidden'?>" height="15%" src="<?php echo base_url() ?>/upload/EC_auction/giphy.gif" />            
                        		</div>
                        		<div class="col-md-4 col-md-offset-4"style="margin-top: 15px">
                        			<input type="text" readonly="" value="<?php echo number_format($vendor['HARGATERKINI'],0,",",".") ?>" style="font-size: 18px;font-weight:bold" id="penawaran" class="form-control text-center"/>                        		
                        		</div>
                        		<div class="col-md-3 col-md-offset-5"style="margin-top: 15px">
                        			<span>Nilai Pengurangan: <?php echo $auction['CURR'].' '?><span id="pengurangan"><?php echo number_format($auction['NILAI_PENGURANGAN'],0,",",".") ?></span> </span>
                        		</div>
                        		<div class="col-md-6 col-md-offset-3"style="margin-top: 15px">
                        			 <div class="row" id="decrease_button">
                                        <div class="col-sm-12" style="text-align: center">
                                            <a class="btn btn-primary btn-circle btn_decrease bid_button">1</a>
                                            <a class="btn btn-primary btn-circle btn_decrease bid_button">2</a>
                                            <a class="btn btn-primary btn-circle btn_decrease bid_button">3</a>
                                            <a class="btn btn-primary btn-circle btn_decrease bid_button">4</a>
                                            <a class="btn btn-primary btn-circle btn_decrease bid_button">5</a>
                                            <a class="btn btn-primary btn-circle btn_decrease bid_button">6</a>
                                            <a class="btn btn-primary btn-circle btn_decrease bid_button">7</a>
                                            <a class="btn btn-primary btn-circle btn_decrease bid_button">8</a>
                                            <a class="btn btn-primary btn-circle btn_decrease bid_button">9</a>
                                            <a class="btn btn-primary btn-circle btn_decrease bid_button">10</a>
                                        </div>
                                    </div>
                        		</div>
                        		<div class="col-md-4 col-md-offset-5" style="margin-top: 15px">
                        			<form class="form-inline">
									  <div class="form-group" style="margin-right: 35px">
									    <button type="button" class="btn btn-danger btn-lg" id="undo">Undo</button>
									  </div>
									  <div class="form-group">
									    <button type="button" class="btn btn-success btn-lg" id="submit">Submit</button>
									  </div>
									</form>
                        		</div>
                        	</div>
                        	
						</div>
                    </div>

                     </div>
    </div>
</section>