<div class="modal fade" id="document_shipping" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit PO</h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" enctype="multipart/form-data" method="POST" id="formrooms2">
                    <input type="hidden" name="id" class="id" value="<?php echo $id; ?>">

                    <div class="row">
                        <div class="col-md-4">

                            DOC_DATE
                        </div>
                        <div class="col-md-2">
                            :

                        </div>
                        <div class="col-md-6">
                            <!-- <input required  type="text" name="DOC_DATE" class="form-control DOC_DATE"> -->

                            <div class="input-group date"> 
                                <input required name="DOC_DATE" class="text-right form-control DOC_DATE" type="text"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                            </div>

                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-4">

                            DELIVERY DATE
                        </div>
                        <div class="col-md-2">
                            :
                        </div>
                        <div class="col-md-6">
                            <!-- <input required type="text" name="DDATE" class="form-control DDATE"> -->
                            <div class="input-group date"> 
                                <input required name="DDATE" class="text-right form-control DDATE" type="text"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-4">

                            HEADER_TEXT
                        </div>
                        <div class="col-md-2">
                            :
                        </div>
                        <div class="col-md-6">
                            <textarea required name="HEADER_TEXT" class="form-control HEADER_TEXT"></textarea>                
                        </div>
                    </div>

                    <br>
                    <div class="form-group">
                        <div class="col-sm-3">
                        </div>
                        <div class="col-sm-3">
                        </div>
                        <div class="colm-sm-6">
                            <button type="button" class="btn btn-success save-custom">Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p class="text-right no_margin_bottom">R/5125/004</p>
                        <div class="row text-right">
                            <div class="col-md-8 col-md-offset-2">
                                <!-- <div class="col-md-5"> -->
                                <table class="text-right">
                                    <tr>
                                        <td>
                                            <p class="text-center no_margin_bottom" style="padding-top:2%;font-size:21px"><strong><?php echo $po['PO_NUMBER'] ?> / <?php echo $item[0]['PLANT'] ?></strong></p>
                                        </td>
                                    </tr>
                                </table>
                                <!-- </div> -->
                            </div>
                            <div class="col-md-2">
                                <!-- <div class="col-md-5"> -->
                                <table class="text-right">
                                    <tr>
                                        <td><?php echo $PRNO ?>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $RFQ_NO ?> 
                                        </td>
                                        <td>&nbsp;<?php echo $PTM_PRATENDER ?>
                                        </td>
                                    </tr>
                                </table>
                                <!-- </div> -->
                            </div>
                        </div>
                        
                        <p class="no_margin_bottom" >
                            <?php echo $ptv['PTV_VENDOR_CODE'] ?><br>
                            <?php echo $ptv['VENDOR_NAME'] ?><br>
                            <?php echo $vnd['ADDRESS'] ?><br>
                            <?php echo $vnd['CITY'] ?><br>
                            FAX: <?php echo $vnd['FAX'] ?>
                        </p>
                        <table class="table table">
                            <tr style="border:0">
                                <td colspan="4" style="border:0"></td>
                                <td class="text-center" style="border:0"><?php echo Date("d.m.Y",oraclestrtotime($po['DOC_DATE'])) ?>
                                </td>
                                <td class="text-center" style="border:0"><?php echo Date("d.m.Y",oraclestrtotime($po['DDATE'])) ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">Quantity
                                </td>
                                <td class="text-center">UoM
                                </td>
                                <td class="text-center">Nomor Material
                                </td>
                                <td class="text-center">Description
                                </td>
                                <td class="text-center">IDR
                                </td>
                                <td class="text-center">IDR
                                </td>
                            </tr>
                            <?php foreach ($item as $key => $value): ?>
                                <tr style="border-left:1px solid #dddddd;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;">
                                    <td class="text-right col-md-1" style="border-left:1px solid #dddddd;"><?php echo $value['POD_QTY'] ?>
                                    </td>
                                    <td class="text-center col-md-1" style="border-left:1px solid #dddddd;"><?php echo $value['UOM'] ?>
                                    </td>
                                    <td class="text-center col-md-2" style="border-left:1px solid #dddddd;"><?php echo $value['POD_NOMAT'] ?>
                                    </td>
                                    <td nowrap style="border-left:1px solid #dddddd;"><?php echo $value['POD_DECMAT'] ?>
                                    </td>
                                    <td class="text-right col-md-2" style="border-left:1px solid #dddddd;"><?php echo number_format($value['POD_PRICE']) ?>,00
                                    </td>
                                    <td class="text-right col-md-2" style="border-left:1px solid #dddddd;"><?php echo number_format(intval($value['POD_PRICE'])*intval($value['POD_QTY'])) ?>,00
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            <tr style="border-left:1px solid #dddddd;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;">
                                <td colspan="4" class="text-right col-md-1" style="border-left:1px solid #dddddd;"><?php echo $terbilang ?> Rupiah
                                </td>
                                <td class="text-center col-md-2" style="border-left:1px solid #dddddd;">IDR
                                </td>
                                <td class="text-right col-md-2" style="border-left:1px solid #dddddd;"><?php echo number_format($total) ?>,00
                                </td>
                            </tr>
                        </table>
                        <div class="col-md-12">
                            <p class="no_margin_bottom">
                                NOTE : <br>
                                BARANG YANG READY HARAP SEGERA DIKIRIM
                            </p>
                        </div>
                        <div class="col-md-3 col-md-offset-9">
                            <p class="text-center">
                             <?php echo $approval['NAMA'] ?> <br>
                             <?php echo $approval['JABATAN'] ?> <br>
                             <img src="<?php echo $qrpath ?>">
                         </p>
                     </div>
                 </div>
                 <div class="panel-body text-center">
                    
                 </div>
             </div>
             <div class="panel panel-default">
                <div class="panel-body text-center">
                    <a type="button" class="main_button color7 small_btn close-modal" href="javascript:window.close()">Tutup</a>
                    <a type="button" class="main_button color2 small_btn close-modal" href="<?php echo base_url("Tender_winner/printPO/".$po['PO_ID']."/true")?>">Print PO</a>
                    <!-- <button type="button" class="main_button color2 small_btn close-modal btn-check" style="background-color: green;">Edit PO</button> -->
                    
                </div>
            </div>
        </div>
    </div>
</div>
</section>
