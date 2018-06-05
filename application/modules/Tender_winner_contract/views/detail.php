<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form id="form_po" action="<?php echo base_url()?>Tender_winner_contract/submit" method="POST">
                    <div id="panel_return_createpo" class="alert alert-info alert-dismissible" role="alert">
                        <table class="table table-bordered">
                            <thead>
                                <th>ID</th>
                                <th>TYPE</th>
                                <th>MESSAGE</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Detail Contract</div>
                        <!-- <div class="panel-body"> -->
                        <table class="table table-hover">
                            <tr hidden>
                                <td class="col-md-2"  style="padding-left:1%">Nomor PO</td>
                                <td class="col-md-10">
                                    <input type="hidden" name="no_po" class="text-right form-control no_po">
                                    <input type="hidden" name="po_id" class="text-right form-control" value="<?php echo @$po_id;?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2" style="padding-left:1%">Doc Type</td>
                                <td class="col-md-10">
                                    <input type="hidden" id="hide_doctype" value="<?php echo @$DOC_TYPE;?>"/>
                                    <select name="doctype" class="" id="tiperfq">
                                        <option value="">Pilih tipe dokumen</option>
                                        <?php foreach($doctype as $key => $type) { ?>
                                        <option value="<?php echo $type['TYPE']?>"><?php echo $type['TYPE'].' ('.$type['DESC'].')'?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <input type="hidden" name="pdtime" class="pdtime" value="<?php echo $winner[1]['PQM_DELIVERY_TIME'] ?>">
                            <tr>
                                <td class="col-md-2"  style="padding-left:1%">Doc Date</td>
                                <td class="col-md-10">
                                    <div class="input-group date col-md-2"> 
                                        <input type="text" name="docdate" value="<?php echo isset($docdate)?$docdate:date('Y-m-d'); ?>" class="text-right form-control docdate"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2"  style="padding-left:1%">Start Contract Date</td>
                                <td class="col-md-10">
                                    <div class="input-group date col-md-2"> 
                                        <input type="text" name="startdate" value="<?php //echo isset($docdate)?$docdate:date('Y-m-d'); ?>" class="text-right form-control docdate"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2"  style="padding-left:1%">End Contract Date</td>
                                <td class="col-md-10">
                                    <div class="input-group date col-md-2"> 
                                        <input type="text" name="enddate" value="<?php //echo isset($docdate)?$docdate:date('Y-m-d'); ?>" class="text-right form-control docdate"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                            <!-- </div> -->
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Item
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <th class="col-md-1">No</th>
                                        <th>PR No</th>
                                        <?php if($winner[1]['PTM_NUMBER'] != null) {
                                            echo  "<th> RFQ </th> 
                                                   <input type=\"hidden\" name = \"is_contract\" value=\"0\">
                                                ";

                                        }else{
                                            echo  "<th>Contract</th>
                                                <input type=\"hidden\" name = \"is_contract\" value=\"1\">
                                             ";
                                        }?>
                                       
                                        <th>Vendor Name</th>
                                        <th>Description</th>
                                        <th>Item Text</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Currency</th>
                                        <th>Purc GRP</th>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $no = 1;

                                        foreach ($winner as $key=> $item) {
                                            echo '<input type="hidden" name="winner[]" value="'.$item['PTW_ID'].'">';
                                            echo '<tr>';
                                            echo '<td>'.$no.'</td>';
                                            echo '<td>'.$item['PPI_PRNO'].'</td>';
                                            echo '<td>'.$item['PTV_RFQ_NO'].'</td>';
                                            echo '<td>'.$item['PTV_VENDOR_CODE']. ' '.$item['VENDOR_NAME'].'</td>';
                                            echo '<td>'.$item['PPI_NOMAT'].' '.$item['PPI_DECMAT'].'</td>';
                                            if (!isset($itemtext[$item['PTW_ID']])) {
                                                echo '<td><textarea name="itemtext['.$item['PTW_ID'].']" class="col-md-12" placeholder="Item Text">'.$return_sap[$key].'</textarea></td>';
                                            } else {
                                                echo '<td><textarea name="itemtext['.$item['PTW_ID'].']" class="col-md-12" placeholder="Item Text">'.(isset($itemtext[$item['PTW_ID']])?$itemtext[$item['PTW_ID']]:'').'</textarea></td>';
                                            }
                                            echo '<td class="text-center">'.number_format($item['TIT_QUANTITY']).'</td>';
                                            echo '<td>'.number_format($item['PQI_PRICE']).'</td>';
                                            echo '<td>'.$item['PPI_CURR'].'</td>';
                                            echo '<td>'.$item['PPR_PGRP'].'</td>';
                                            echo '<tr>';
                                            $no++;
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Catatan Approval
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <?php if(!empty($COMMENT)){
                                        foreach ($COMMENT as $key => $value) { ?>
                                    <tr>                                    
                                        <td class="col-md-3">
                                           <?php echo $value['PHC_NAME']; ?>                                                                                      
                                        </td>
                                        <td class="col-md-2">
                                           <?php echo "[".betteroracledate(strtotime($value['PHC_START_DATE']))."]"; ?>   :
                                        </td>
                                        <td class="col-md-7">
                                            <?php echo $value['PHC_COMMENT'];?>
                                        </td>
                                    </tr>
                                    <?php }}?>
                                <tr>                                    
                                    <td class="col-md-12" colspan="3">
                                        <textarea name="note" class="col-md-12" placeholder="tulis disini"></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    

                    <div class="panel panel-default panel_submit">
                        <div class="panel-body text-center">
                            <a href="<?php echo base_url()."Tender_winner_contract/"; ?>" class="main_button color7 small_btn">Kembali</a>
                            <button id="submit-form" type="submit" class="main_button color6 small_btn">Simpan</button>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>