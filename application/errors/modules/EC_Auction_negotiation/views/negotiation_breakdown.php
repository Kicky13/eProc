<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <?php if ($this->session->flashdata('rfc_ft_return') != false): ?>
                <?php $rfc_ft_return = $this->session->flashdata('rfc_ft_return'); ?>
                <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <p>FT_RETURN:</p>
                    <ul>
                        <?php foreach ($rfc_ft_return as $key => $value): ?>
                            <li>&nbsp;&nbsp;&nbsp;<?php echo $value->MESSAGE ?></li>
                        <?php endforeach ?>
                    </ul>
                    <div class="hidden hasil rfc">
                        <?php echo var_dump($rfc_ft_return) ?>
                    </div>
                </div>
                <?php endif ?>
                <?php if ($this->session->flashdata('error') !== false): ?>
                <?php $error = $this->session->flashdata('error');?>
                <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <p>ERROR:</p>
                    <ul>
                        <?php if(is_array($error)){?>
                        <?php foreach ($error as $value){ ?>
                            <li>&nbsp;&nbsp;&nbsp;<?php echo $value; ?></li>
                        <?php }
                            } else {
                                echo $error;
                            }
                        ?>
                    </ul>
                </div>
                <?php endif ?>
                <div class="col-md-12">
                    <form action="<?php echo base_url()?>Auction_negotiation/save_breakdown" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="paqh" name="paqh" value="<?php echo $paqh['PAQH_ID']?>">
                    <input type="hidden" id="ptm_number" name="ptm_number" value="<?php echo $ptm_number?>">
                    <input type="hidden" id="tipeauction" name="tipeauction" value="<?php echo $paqh['PAQH_PRICE_TYPE']?>">
                    <input type="hidden" id="paqd_final_price" name="paqd_final_price" value="<?php echo $breakdown['PAQD_FINAL_PRICE'];?>">
                    <input type="hidden" id="is_jasa" name="is_jasa" value="<?php echo $is_jasa?>">
                    <?php if(empty($paqh['BREAKDOWN_TYPE']) || $paqh['BREAKDOWN_TYPE']=='V'){?>
                        <input type="hidden" id="vendor_code" name="vendor" value="<?php echo $this->session->userdata('VENDOR_NO')?>">
                    <?php }else{?>
                        <input type="hidden" id="vendor_code" name="vendor" value="<?php echo $paqh['VENDOR_WINNER']?>">
                    <?php }?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Auction
                        </div>
                        <table class="table table-hover">
                            <tr>
                                <td class="col-md-3">Nomor Tender</td>
                                <td><input type="text" class="form-control" name="" placeholder="" value="<?php echo $paqh['PTM_PRATENDER']?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Deskripsi</td>
                                <td><input type="text" class="form-control" name="paqh_subject_of_work" placeholder="" value="<?php echo $paqh['PAQH_SUBJECT_OF_WORK']?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Lokasi Auction</td>
                                <td><input type="text" class="form-control" name="paqh_location" placeholder="" value="<?php echo $paqh['PAQH_LOCATION'];?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Tanggal Pembukaan</td>
                                <td><input type="text" id="PAQH_AUC_START" class="form-control" name="paqh_location" placeholder="" value="<?php echo substr($paqh['PAQH_AUC_START'], 0, 19);?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Tanggal Penutupan</td>
                                <td><input type="text" id="PAQH_AUC_END" class="form-control" name="paqh_location" placeholder="" value="<?php echo substr($paqh['PAQH_AUC_END'], 0, 19);?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Nilai Pengurangan</td>
                                <td>
                                    <input type="hidden" class="form-control" id="dec_val" name="paqh_decrement_value" placeholder="" value="<?php echo $paqh['PAQH_DECREMENT_VALUE']?>" readonly>
                                    <input type="text" class="form-control" value="<?php echo number_format($paqh['PAQH_DECREMENT_VALUE']) ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>Tipe Auction</td>
                                <td><input type="text" class="form-control" name="paqh_decrement_value" placeholder="" value="<?php echo ($paqh['PAQH_PRICE_TYPE'] == 'T') ? 'Harga Total' : 'Harga Satuan';?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Tipe Breakdown</td>
                                <td><input type="text" class="form-control" name="breakdown_type" placeholder="" value="<?php echo ($paqh['BREAKDOWN_TYPE'] == 'S') ? 'Breakdown Sendiri' : 'Breakdown oleh Vendor';?>" readonly></td>
                            </tr>
                        </table>
                    </div>
                    <?php if(empty($paqh['BREAKDOWN_TYPE']) || $paqh['BREAKDOWN_TYPE']=='V'){?>
                    <div class="panel panel-default panel_bidder panel-eproc-success" id="bidderContainer">
                        <div class="panel-heading">
                            
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <h3 class="text-center no_margin_bottom">Congratulation !</h3>
                                </div>
                            </div>
                            <br>
                            <div class="row" id="win">
                                <div class="col-sm-12 text-center">
                                    <h4><img class="logo_dark" src="<?php echo base_url(); ?>static/images/trophy.jpg"></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-sm-offset-3">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3 col-xs-12 text-center  bottom_space">
                                            <div id="hargapenawaran">
                                            Harga Awal: <?php echo number_format($vendor['PAQD_INIT_PRICE'])?><br>
                                            </div>
                                            <input type="text" style="font-size: 20px;color:black;font-weight: bold;" id="harga_bids" class=" text-center col-xs-12" value="<?php echo number_format($vendor['PAQD_FINAL_PRICE'])?>" readonly>
                                            <input type="hidden" style="font-size: 20px" id="harga_bid" class="form-control text-center bottom_space" value="<?php echo $vendor['PAQD_FINAL_PRICE']?>" readonly>
                                            <input type="hidden" style="font-size: 20px" id="time" class="form-control text-center bottom_space" value="<?php echo $timenow ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Breakdown Item
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <th class="col-md-1">No</th>
                                        <th class="text-center">Kode Item</th>
                                        <th class="text-center">Deskripsi</th>
                                        <th class="text-center">Kuantitas</th>
                                        <th class="text-center">Uom</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Subprice</th>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $no = 1;
                                        // echo number_format($vendor['PAQD_FINAL_PRICE']);                                        
                                        foreach ($item as $item) {
                                            echo '<tr>';
                                            echo '<td>'.$no.'</td>';
                                            echo '<td class="text-center">'.$item['PPI_NOMAT'].'</td>';
                                            echo '<td>'.$item['PPI_DECMAT'].'</td>';
                                            echo '<td class="text-right quantity">'.$item['TIT_QUANTITY'].'</td>';
                                            echo '<input type="hidden" name="qty['.$item['PQI_ID'].']" value="'.$item['TIT_QUANTITY'].'">';
                                            echo '<td class="text-center">'.$item['PPI_UOM'].'</td>';                                            
                                            echo '<td class="col-md-2"><input type="text" name="price['.$item['PQI_ID'].']" class="text-right form-control breakdown_price must_autonumeric" data-toggle="tooltip"  value="'.((!empty($paqh['BREAKDOWN_TYPE']) && $paqh['BREAKDOWN_TYPE']=='S')?$breakdown[$item['PQI_ID']]:'').'" placeholder="0" onKeyUp="qty(this)"></td>';
                                            echo '<td class="col-md-2 subtotal text-right">0.00</td>';
                                            echo '<input type="hidden" class="subtot">';
                                            echo '<tr>';
                                            $no++;
                                        }
                                    ?>
                                    <tfoot>
                                        <th colspan="5" class="text-center"><strong>Total</strong></th>
                                        <th class="text-right" id="subsatuantotal">0.00</th>
                                        <th class="text-right" id="total">0.00</th>
                                        <input type="hidden" class="total">
                                    </tfoot>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                            <div class="panel-heading">File Breakdown Harga</div>
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-2 <?php echo ($is_jasa==1)?'form-required':''?>"><strong>File Upload</strong></td>
                                    <td id="fileUpload"> 
                                    <label class="btn btn-default" style="float: left" for="file_breakdown">Pilih File</label> 
                                    <div style=" width: 500px;height:30px; position: relative;float: left;  overflow: hidden;margin-left: 0px;margin-top:0px;" >                                        
                                        <input type="file" id="file_breakdown" name="file_breakdown" style="position: absolute;  left: 0; top: 0; margin-left: -80px; padding: 0px; cursor: pointer;">  
                                    </div> 
                                    </td>                                    
                                </tr>
                            </table>
                        </div>
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <?php if(!empty($paqh['BREAKDOWN_TYPE']) && $paqh['BREAKDOWN_TYPE']=='S'){?>
                            <a href="<?php echo site_url('Auction/monitor/'.$paqh['PAQH_ID']); ?>" class="main_button color7 small_btn">Kembali</a>
                            <?php }else{?>
                            <a href="<?php echo site_url('Auction_negotiation'); ?>" class="main_button color7 small_btn">Kembali</a>
                            <?php }?>
                            <button id="submit-form" type="submit" class="main_button color6 small_btn submit_btn">Submit</button>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
     $(document).ready(function() {
        /* Activate autonumeric */
        $(".must_autonumeric").autoNumeric('init', {lZero: 'deny', mDec: 0});
    });

</script>