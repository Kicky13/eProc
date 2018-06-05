<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Detail Item PR</div>
                        <table class="table table-hover">
                            <tr>
                                <td class="col-md-3 text-right">PR No</td>
                                <td colspan="3" class="col-md-3"><?php echo $item['PPI_PRNO'] ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3 text-right"><?php if($item['PPR_DOC_CAT'] == 9) echo 'Service'; else echo 'Material';?></td>
                                <td class="col-md-3"><a href="#modal_getlong" onclick="getlong(this)" data-ppi="<?php echo $item['PPI_ID']?>" data-nomat="<?php echo $item['PPI_NOMAT']?>"><?php echo $item['PPI_NOMAT'] . " & " .$item['PPI_DECMAT'] ?>
                                     </a></td>
                                <td class="text-right">PR QTY</td>
                                <td><?php echo $item['PPI_PRQUANTITY'].' &nbsp; '.$item['PPI_UOM'] ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3 text-right" valign="top">Mat Group</td>
                                <td class="col-md-4"><?php echo $item['PPI_MATGROUP'].' &nbsp; '.$item['MAT_GROUP_NAME'] ?></td>
                                <td class="text-right">Open QTY</td>
                                <td><?php echo $item['PPI_QUANTOPEN'] - $item['PPI_QTY_USED'].' &nbsp; '.$item['PPI_UOM'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-right">Plant</td>
                                <td><?php echo $ppr_plant.' &nbsp; '.$item['PLANT_NAME'] ?></td>
                                <td class="col-md-3 text-right">Purch Group</td>
                                <td class="col-md-3"><?php echo $item['PPR_PGRP'] ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <form method="post" action="<?php echo base_url()?>Create_po/submit/<?php echo $id ?>/<?php echo $ppr_plant ?>">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Assign Ke</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                       <!-- <th>Aprrove</th>-->
                                        <th class="text-center" nowrap>Assign</th>
                                        <th class="text-center" nowrap>No Kontrak</th>
                                        <th class="text-center col-md-2" nowrap>Vendor</th>
                                        <?php if($item['PPR_DOC_CAT'] == 9) echo '<th class="text-center col-md-2" nowrap>Description</th>';?>
                                        <th class="text-center" nowrap>Start Date</th>
                                        <th class="text-center" nowrap>End Date</th>
                                        <th class="text-center col-md-1" nowrap>Qty</th>
                                        <th class="text-center" nowrap>Uom</th>
                                        <th class="text-center" nowrap>Net Price</th>
                                        <th class="text-center" nowrap>Curr</th>
                                        <th class="text-center" nowrap>Target Qty</th>
                                        <th class="text-center" nowrap>Net Price Cont</th>
                                    </thead>
                                    <tbody id="items_table">
                                    <?php $i = 1; foreach ($pcs as $each_pcs): ?>
                                        <tr>
                                            <!--<td class="text-center"><input type="checkbox" class="check-success" name="items[]" value="<?php echo $val['PPI_PRITEM'] ?>" checked></td>-->
                                            <td class="text-center"><input type="radio" name="assign" value="<?php echo $each_pcs['LIFNR'] ?>"></td>
                                            <td class="text-center"><?php echo $each_pcs['EBELN'] ?></td>
                                            <td class="text-center col-md-3"><?php echo $each_pcs['LIFNR'].' - '.$each_pcs['NAME1'] ?></td>
                                            <?php if($item['PPR_DOC_CAT'] == 9) 
                                            echo '<td nowrap>
                                                    <a href="#items_table" class="btn_history decmat" onclick="open_dokumen(this)" data-ppi="'.$item['PPI_ID'].'">'.$item['PPI_DECMAT'].'</a>
                                                </td>';
                                            ;?>
                                            <td class="text-center"><?php echo date("d M Y",strtotime($each_pcs['KDATB'])) ?></td>
                                            <td class="text-center"><?php echo date("d M Y",strtotime($each_pcs['KDATE'])) ?></td>
                                            <td class="text-center">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="text" class="form-control col-md-2 text-right jumlah[<?php echo $each_pcs['LIFNR'] ?>] jumlahnya" name="jumlah<?php echo $each_pcs['LIFNR'] ?>" value="<?php echo $item['PPI_QUANTOPEN'] - $item['PPI_QTY_USED'] ?>">
                                                        <span class="error text-danger"></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <input type="hidden" name="quantopen" value="<?php echo $item['PPI_QUANTOPEN']?>" >
                                            <input type="hidden" name="qtyused" value="<?php echo $item['PPI_QTY_USED']?>" >
                                            <td class="text-center"><?php echo $each_pcs['MEINS'] ?></td>
                                            <td class="text-center"><?php echo number_format($item['PPI_NETPRICE']*100) ?></td>
                                            <td class="text-center"><?php echo $item['PPI_CURR'] ?></td>
                                            <td class="text-center"><?php echo $each_pcs['KTMNG'] ?></td>
                                            <td class="text-center"><?php echo number_format($each_pcs['NETPR']*100) ?></td>
                                        </tr>
                                    <?php $i++; endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <!--<div class="panel-heading">Komentar</div>-->
                        <table id="tablecomment" class="table table-hover">
                        </table>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <button class="main_button color6 small_btn">Simpan</button>
                            </form>
                            <a href="<?php echo base_url(); ?>Create_po/view" class="main_button color7 small_btn">Batal</a>
                        </div>
                    </div>
                </div>
                <!-- <button id="dummy">Click</button> -->
            </div>
        </div>
    </div>
</section>
 <div class="modal fade" id="modal_getlong">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
       <div class="modal-header">Detail</div>
       <div class="modal-body">
         <div id="idgetlong"></div>
       </div>
     </div>
   </div>
 </div>
<?php if($item['PPR_DOC_CAT'] == 9) {
echo '<div class="modal fade" id="modal_dokumen">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">Informasi Tambahan PR <span class="pr"></span></div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>';}
?>