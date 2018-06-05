<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <form action="<?php echo base_url()?>Auction/simpan_baru" method="POST">
                    <!--<input type="text" name="paqh_id" value="<?php echo $paqh['PAQH_ID']?>" hidden>
                    <input type="text" name="ptm" value="<?php echo $paqh['PTM_NUMBER']?>" hidden>
                    <input type="text" id="paqh_open_status" value="<?php echo $paqh['PAQH_OPEN_STATUS']?>" hidden>-->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Auction Baru
                        </div>
                        <table class="table table-hover">
                            <tr>
                                <td class="col-md-3">Nomor Tender</td>
                                <td><input type="text" class="form-control" name="no_ten" placeholder="" ></td>
                            </tr>
                            <tr>
                                <td>Deskripsi</td>
                                <td><input type="text" class="form-control" name="desauc" placeholder="" ></td>
                            </tr>
                            <tr>
                                <td>Lokasi Auction</td>
                                <td><input type="text" class="form-control" name="lokasi" placeholder="" ></td>
                            </tr>
                            <tr>
                                <td>Tanggal Pembukaan</td>
                                <td class="input-group date">                                   
                                    <input type="text" name="tanggalbuka" class="auc_start form-control" ><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal Penutupan</td>
                                <td class="input-group date">                                   
                                    <input type="text" name="tanggaltutup" class="auc_end form-control" ><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Nilai Pengurangan</td>
                                <td><input type="text" class="decrement_value form-control must_autonumeric" name="nilaipeng" placeholder="" ></td>
                            </tr>
                            <tr>
                                <td>Tipe Auction</td>
                                <td>
                                    <select name="tipeauc" id="paqh_price_type">
                                        <option value="S">Harga Satuan</option>
                                        <option value="T">Harga Total</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>HPS/OE</td>
                                <td>
                                    <input type="text" class="form-control" id="hps" name="hps">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <?php 
                        $hps_sebagian = 0;
                        $hps_total = 0;
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Item
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <th class="col-md-1">No</th>
                                        <th>Kode Item</th>
                                        <th>Deskripsi</th>
                                        <th>Kuantitas</th>
                                        <th>Uom</th>
                                        <th>ECE</th>
                                        <!--<th>Ikut Auction</th>-->
                                    </thead>
                                    
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" class="col-md-10" name="no_item[]" value="1" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="kode[]">
                                            </td> 
                                            <td>
                                                <input type="text" name="desitem[]">
                                            </td> 
                                            <td>
                                                <input type="text" name="kuantitas[]">
                                            </td> 
                                            <td>
                                                <input type="text" name="uom[]">
                                            </td> 
                                            <td>
                                                <input type="text" name="ece[]">
                                            </td> 
                                        </tr>
                                        
                                        <tr>
                                            <td>
                                                <input type="text" class="col-md-10" name="no_item[]" value="2" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="kode[]">
                                            </td> 
                                            <td>
                                                <input type="text" name="desitem[]">
                                            </td> 
                                            <td>
                                                <input type="text" name="kuantitas[]">
                                            </td> 
                                            <td>
                                                <input type="text" name="uom[]">
                                            </td> 
                                            <td>
                                                <input type="text" name="ece[]">
                                            </td> 
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="text" class="col-md-10" name="no_item[]" value="3" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="kode[]">
                                            </td> 
                                            <td>
                                                <input type="text" name="desitem[]">
                                            </td> 
                                            <td>
                                                <input type="text" name="kuantitas[]">
                                            </td> 
                                            <td>
                                                <input type="text" name="uom[]">
                                            </td> 
                                            <td>
                                                <input type="text" name="ece[]">
                                            </td> 
                                        </tr>
                                        
                                    <?php 
                                    /*    $no = 1;
                                        
                                        foreach ($item as $val) {
                                            echo '<tr>';
                                            echo '<td>'.$no.'</td>';
                                            echo '<td class="PPI_NOMAT">'.$val['PPI_ID'].'</td>';
                                            echo '<td>'.$val['PPI_DECMAT'].'</td>';
                                            echo '<td>'.$val['TIT_QUANTITY'].'</td>';
                                            echo '<input type="hidden" class="satuan'.$val['PPI_ID'].'" value='.$val['TIT_QUANTITY'].'>';
                                            echo '<td>'.$val['PPI_UOM'].'</td>';
                                            echo '<td>'.number_format($val['TIT_PRICE']).'</td>';
                                            echo '<td><label><input type="checkbox" name="item_ikut['.$val['TIT_ID'].']" value="'.$val['PPI_ID'].'" class="checkuncheck"></label></td>';
                                            echo '<input type="hidden" name="tender_item['.$val['TIT_ID'].']" value="'.$val['TIT_ID'].'">';
                                            echo '<tr>';
                                            $no++;
                                            $hps_sebagian = $hps_sebagian + $val['TIT_PRICE'];
                                            $hps_total = $hps_total + $val['TIT_PRICE'] * $val['TIT_QUANTITY'];
                                        }
                                     
                                     */
                                    ?>
                                                                             
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                        <input type="text" id="hps_total"  hidden>
                        <input type="text" id="hps_sebagian" hidden>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Peserta Auction
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr><th class="col-md-1 text-left">No</th>
                                          <th class="col-md-1">RFQ</th>
                                          <th>Vendor Code</th>
                                          <th>Nama</th>
                                          <th>Harga Awal</th>
                                          <th>Harga Terkini</th>
                                          <!--<th><span class="label label-primary invisible">new ece</span></th>-->
                                        </tr>
                                    
                                        <!--<th class="col-md-1">No</th>
                                        <th class="col-md-3">Item</th>
                                        <th>Harga Awal</th>
                                        <th>Ikut</th> -->
                                    </thead>
                                                                        
                                    
                                    <tbody>
                                        
                                        <tr>
                                            <td>
                                                <input type="text" class="col-md-10" name="no_pes[]" value="1" readonly>
                                            </td> 
                                            <td>
                                                <input type="text" name="rfq[]">
                                            </td> 
                                            <td>
                                                <input type="text" name="vendorcode[]">
                                                <input type="hidden" name="password[]" value="tes">
                                            </td> 
                                            <td>
                                                <input type="text" name="nama[]">
                                            </td> 
                                            <td>
                                                <input type="text" name="hargaawal[]">
                                            </td> 
                                            <td>
                                                <input type="text" name="hargaterkini[]">
                                            </td> 
                                        </tr>
                                        
                                        <tr>
                                            <td>
                                                <input type="text" class="col-md-10" name="no_pes[]" value="2" readonly>
                                            </td> 
                                            <td>
                                                <input type="text" name="rfq[]">
                                            </td> 
                                            <td>
                                                <input type="text" name="vendorcode[]">
                                                <input type="hidden" name="password[]" value="tes">
                                            </td> 
                                            <td>
                                                <input type="text" name="nama[]">
                                            </td> 
                                            <td>
                                                <input type="text" name="hargaawal[]">
                                            </td> 
                                            <td>
                                                <input type="text" name="hargaterkini[]">
                                            </td>  
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="text" class="col-md-10" name="no_pes[]" value="3" readonly>
                                            </td> 
                                            <td>
                                                <input type="text" name="rfq[]">
                                            </td> 
                                            <td>
                                                <input type="text" name="vendorcode[]">
                                                <input type="hidden" name="password[]" value="tes">
                                            </td> 
                                            <td>
                                                <input type="text" name="nama[]">
                                            </td> 
                                            <td>
                                                <input type="text" name="hargaawal[]">
                                            </td> 
                                            <td>
                                                <input type="text" name="hargaterkini[]">
                                            </td>  
                                        </tr>

                                    </tbody>
                                </table>
                                
                                
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <a href="<?php echo base_url(); ?>Auction/index/proses" class="main_button color7 small_btn">Kembali</a>
                            <button id="submit-form" type="submit" class="main_button color6 small_btn">Simpan</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>