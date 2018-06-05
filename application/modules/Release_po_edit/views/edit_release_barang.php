<?php
// echo "<pre>";
// print_r($po);
// die;
// var_dump($po);

// $coba = "<pre>".$po['HEADER_TEXT']."</pre>";
//die;
?>

<style type="text/css">
    #table-wrapper {
      position:relative;
  }
  #table-scroll {
      /*height:150px;*/
      overflow:auto;  
      margin-top:20px;
  }
  #table-wrapper table {
      width:100%;

  }
  #table-wrapper table * {
      /*background:yellow;*/
      color:black;
  }
  #table-wrapper table thead th .text {
      position:absolute;   
      top:-20px;
      z-index:2;
      /*height:20px;*/
      width:35%;
      border:1px solid red;
  }
</style>
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <form action="<?php echo base_url("Tender_winner/saveReleasePO/")?>" method="post" enctype="multipart/form-data">
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
                                FAX: <?php echo $vnd['FAX'] ?> <br>
                                <table>
                                    <tr>
                                        <td style="padding-left:1%">Dokument Perpanjangan PO</td>
                                        <td>
                                            <input name="DOC_PO_PERPANJANG" id="DOC_PO_PERPANJANG" type="file">
                                        </td>                            
                                    </tr>
                                    <?php if(!empty($po['DOC_PO_PERPANJANG'])){
                                        ?>
                                        <tr>
                                            <td style="padding-left:1%">Dokument Perpanjangan PO Lama</td>
                                            <td>
                                                <a href="<?php echo base_url()?>upload/temp/<?php echo $po['DOC_PO_PERPANJANG'];?>">ATTACHMENT</a>
                                            </td>                            
                                        </tr>
                                        <?php
                                    } ?>
                                </table>
                                Header Text : 
                                <!-- <textarea name="HEADER_TEXT" class="form-control HEADER_TEXT"><?php echo $po['HEADER_TEXT']; ?></textarea> -->
                                <?php echo $this->ckeditor->editor('HEADER_TEXT',(isset($po['HEADER_TEXT'])?$po['HEADER_TEXT']:''));?>
                                <input type="hidden" name="id" value="<?php echo $po['PO_ID']; ?>">                
                                <input type="hidden" name="PO_NUMBER" value="<?php echo $po['PO_NUMBER']; ?>">                
                            </p>

                            <div id="table-wrapper">
                              <div id="table-scroll">
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
                                        <td class="text-center">Delivery Date
                                        </td>
                                        <td class="text-center">Doc. Date
                                        </td>
                                        <td class="text-center">Item Text
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
                                            <td class="text-right col-md-1" style="border-left:1px solid #dddddd;"><?php echo number_format($value['POD_PRICE']) ?>,00
                                            </td>
                                            <td class="text-right col-md-1" style="border-left:1px solid #dddddd;"><?php echo number_format(intval($value['POD_PRICE'])*intval($value['POD_QTY'])) ?>,00
                                            </td>

                                            <td class="text-right col-md-2" style="border-left:1px solid #dddddd;">
                                                <input type="hidden" name="id_item[]" value="<?php echo $value['POD_ID']; ?>">                
                                                <div class="input-group date"> 
                                                    <input style="width: 100px;" value="<?php echo $value['NEWDDATE']; ?>" required name="DDATE[]" class="text-right form-control DDATE" type="text"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                </div>
                                            </td>

                                            <td class="text-right col-md-2" style="border-left:1px solid #dddddd;">

                                                <div class="input-group date"> 
                                                    <input style="width: 100px;" value="<?php echo $value['NEWDOC_DATE']; ?>" required name="DOC_DATE[]" class="text-right form-control DOC_DATE" type="text"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                </div>
                                            </td>
                                            <td class="text-right col-md-2" style="border-left:1px solid #dddddd;">
                                                <!-- <textarea style="width: 163px;height: 95px;" name="item_text[]" class="form-control"><?php echo $value['ITEM_TEXT']; ?></textarea> -->


                                                <!-- Trigger the modal with a button -->
                                                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal<?php echo $value['POD_ID']; ?>">Isi Item Text</button>

                                                <!-- Modal -->
                                                <div id="myModal<?php echo $value['POD_ID']; ?>" class="modal fade" role="dialog">
                                                    <div class="modal-dialog modal-lg">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title"><?php echo $item['POD_NOMAT'].' '.$item['POD_DECMAT'];?></h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>
                                                                    <?php echo $this->ckeditor->editor('item_text[]',(isset($value['ITEM_TEXT'])?$value['ITEM_TEXT']:''));?>
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
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
                            </div>
                        </div>

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
                        <button type="submit" class="main_button color2 small_btn close-modal" style="background-color: green;">Save PO</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="log">
            <div class="panel-group">
                <div class="panel panel-primary">
                <div class="panel-heading">Panel Log</div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <tr>
                                <td>No</td>
                                <td>Doc Lama</td>
                                <td>Doc Date</td>
                                <td>Delivery Date</td>
                                <td>Update By</td>
                                <td>Update Date</td>
                            </tr>
                            <?php
                            $no = 1;
                            foreach ($data_log as $dl) {
                                ?>
                                <tr>
                                    <td><?php echo $no;$no++; ?></td>
                                    <td><a href="<?php echo base_url()?>upload/temp/<?php echo $dl['DOC_PO_LAMA'];?>">ATTACHMENT</a></td>
                                    <td><?php echo date('d F Y',oraclestrtotime($dl['DOC_DATE'])); ?></td>
                                    <td><?php echo date('d F Y',oraclestrtotime($dl['DDATE'])); ?></td>
                                    <td><?php echo $dl['UPDATED_BY_NAME']; ?></td>
                                    <td><?php echo date('d F Y',oraclestrtotime($dl['UPDATED_AT'])); ?></td>
                                </tr>
                                <?php  
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
        </div>

    </div>
</div>
</section>
