<?php if($is_print=='true'){?>
<html>
    <head>
        <style>
            body{
                font-size:8pt;
            }
            table {
                border-collapse: collapse;
            }

            .table-bordered tr td, .table-bordered th, .table-responsive tr td {
                border: 1px solid black;
                font-size:8pt;
            }

            .tableheader{
                margin:100px;
            }
            .col-md-3{
                width:25%;
            }
            .vendorsupply{
                width:20%;
                position: relative;
                top: 50%;
                transform: translateY(-50%);
            }
            .item{
                width:6%;
            }

            .pono{
                width:11%;
            }

            .shorttext{
                width:25%;   
            }
            .text-center, .centered{
                text-align: center;
            }

            .text-right{
                text-align: right;
            }

            .text-left{
                text-align: left;
            }

            .hidden{
                display: none;
            }

            


        </style>
    </head>
<body>
<?php }?>
<section class="content_section">
<form id="form_po_approval" name="form_po_approval" action="<?php echo base_url()?>Tender_winner/approve" method="POST">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="panel-body">
                    <?php if($is_approval == 'true') {?>
                    <table>
                            <tr>
                                <td class="col-md-3"><strong>Kepada Yth.</strong></td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><?php echo $this->session->userdata['FULLNAME']; ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><?php echo $this->session->userdata['POS_NAME']; ?></td>
                            </tr>
                    </table>
                    <br>
                    <?php } else if($is_print == 'true') { ?>
                    <table>
                        <?php 
                            $leng  = count($approval)-1;
                            for ($i=0; $i <= $leng; $i++) {
                                if ($leng == $i) { ?>
                                    <tr>
                                        <td class="col-md-3"><strong>Kepada Yth.</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3"><?php echo $approval[$i]['NAMA']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3"><?php echo $approval[$i]['JABATAN']; ?></td>
                                    </tr>
                                <?php } ?>
                        <?php } ?>
                    </table>
                    <br>
                    <br>
                    <?php } ?>
                    <table>
                        <tr>
                            <td class="col-md-3"><strong>No LP3</strong></td>
                            <td>: <?php echo $po_header['LP3_NUMBER'] ?></td>
                            <td rowspan="2" style="font-size:16px; color:red; text-align:center; border:2px solid red; vertical-align:middle;">
                                <?php echo strtoupper($status_po);?></td>
                        </tr>
                        <tr>
                            <td class="col-md-3"><strong>No Pratender</strong></td>
                            <td>: <?php echo $PTM_PRATENDER ?></td>
                        </tr>
                        <tr>
                            <td class="col-md-3"><strong>Mekanisme Pengadaan</strong></td>
                            <td>: <?php echo $PTP_JUSTIFICATION ?></td>
                        </tr>
                        <tr>
                            <td class="col-md-3"><strong>Lokasi</strong></td>
                            <td>: <?php echo $PLANT." ".$PLANT_NAME ?></td>
                        </tr>
                        <tr>
                            <td class="col-md-3"><strong>UK Peminta</strong></td>
                            <td>: <?php echo $PPR_REQUESTIONER." ".$LONG_DESC ?></td>
                        </tr>
                    </table>
                    <br>
                    <?php if($is_print=='false'){?>
                    <div id="panel_return_createpo_approve" class="alert alert-info alert-dismissible" role="alert">
                        <table class="table table-bordered">
                            <thead>
                                <th>ID</th>
                                <th>TYPE</th>
                                <th>MESSAGE</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>                    
                    <?php } ?>
                    <p class="col-md-12">Bersama ini kami paparkan usulan penunjukan pemenang atas pengadaan barang/jasa sebagai berikut :</p>
                    
                    <div class="col-md-12" style="margin-bottom: 2%">
                        <table class="table table-bordered" style="font-size: 10pt">
                            <thead>
                                <tr>
                                    <th nowrap class="text-center">Vendor/supplying plant</th>
                                    <th class="text-center">PR Item</th>
                                    <th class="text-center">PR No</th>
                                    <th class="text-center">Short Text</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">UoM</th>
                                    <th class="text-center">NetPrice</th>
                                    <th class="text-center">Value</th>
                                    <th class="text-center">Curr</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($item as $id => $val): ?>
                                    <input type="hidden" name="EBELP" value="<?php echo $val['EBELP'] ?>">
                                    <?php if($id == 0): ?>
                                        <tr>
                                            <td rowspan="<?php echo count($item) ?>" nowrap><?php echo $po_header['VND_NAME'] ?></td>
                                            <td class="text-center"><?php echo $val['PR_ITEM'] ?></td>
                                            <td rowspan="<?php echo count($item) ?>" class="text-center no_po"><?php echo $val['PPR_PRNO'] ?></td>
                                            <td nowrap><?php echo $val['POD_DECMAT'] ?><br><?php if(!is_null($val['ITEM_TEXT'])){?><i>Note: <?php echo $val['ITEM_TEXT'] ?></i><?php } ?></td>
                                            <td class="text-right"><?php echo $val['POD_QTY'] ?></td>
                                            <td class="text-center"><?php echo $val['UOM'] ?></td>
                                            <td class="text-right"><?php echo number_format($val['POD_PRICE'],2,",",".") ?></td>
                                            <td class="text-right"><?php echo number_format((intval($val['POD_PRICE']) * intval($val['POD_QTY'])),2,",",".") ?></td>
                                            <td class="text-center"><?php echo $val['CURR'] ?></td>
                                        </tr>
                                    <?php else: ?>
                                        <tr>
                                            <td class="text-center"><?php echo $val['PR_ITEM'] ?></td>
                                            <td nowrap><?php echo $val['POD_DECMAT'] ?><br><?php if(!is_null($val['ITEM_TEXT'])){?><i>Note: <?php echo $val['ITEM_TEXT'] ?></i><?php } ?></td>
                                            <td class="text-right"><?php echo $val['POD_QTY'] ?></td>
                                            <td class="text-center"><?php echo $val['UOM'] ?></td>
                                            <td class="text-right"><?php echo number_format($val['POD_PRICE'],2,",",".") ?></td>
                                            <td class="text-right"><?php echo number_format((intval($val['POD_PRICE']) * intval($val['POD_QTY'])),2,",",".") ?></td>
                                            <td class="text-center"><?php echo $val['CURR'] ?></td>
                                        </tr>
                                    <?php endif ?>
                                <?php endforeach ?>
                                        <tr>
                                            <td class="text-right" colspan="7"><strong>TOTAL</strong></td>
                                            <td class="text-right"><?php echo number_format($po_header['TOTAL_HARGA'],2,",",".") ?></td>
                                            <td class="text-center"><?php echo $val['CURR'] ?></td>
                                        </tr>
                            </tbody>
                        </table>
                    </div>
                    <table>
                        <tr>
                            <td class="col-md-2"><strong>Delivery Time</strong></td>
                            <td class="col-md-1 text-right">:</td>
                            <td><?php echo day_difference(oraclestrtotime($po_header['PO_CREATED_AT']), oraclestrtotime($po_header['DDATE'])) ?> Hari</td>
                        </tr>
                        <tr>
                            <td class="col-md-2"><strong>Header Text</strong></td>
                            <td class="col-md-1 text-right">:</td>
                            <td><?php echo nl2br(str_replace('  ', '&nbsp;&nbsp;&nbsp;', $po_header['HEADER_TEXT'])) ?></td>
                        </tr>
                    </table>
                    <br>
                    <div class="col-md-12" style="margin-bottom: 2%">
                        <table class="table table-bordered" style="font-size: 10pt">
                            <thead>
                                <tr>
                                    <th nowrap class="text-center">Nama</th>
                                    <th class="text-center">Jabatan</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($approval as $id => $val): ?>
                                    <tr>
                                        <td><?php echo $val['NAMA'] ?></td>
                                        <td><strong><?php echo $val['JABATAN'] ?></strong></td>
                                        <td class="text-center">
                                        <?php if($val['IS_APPROVE'] == 1 && $po_header['REAL_STAT'] > $val['STATUS']){ echo "Approved";} else if($val['IS_APPROVE'] == 2){ echo "Rejected"; } else { echo "Waiting Approval"; }?></td>
                                        <td class="text-center"><?php if(isset($val['CREATED_DATE'])) echo Date("d-m-Y",oraclestrtotime($val['CREATED_DATE'])); else echo "-"; ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                        
                        <br>
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
                                            <?php echo nl2br(str_replace('  ', '&nbsp;&nbsp;&nbsp;', $value['PHC_COMMENT']));?>
                                        </td>
                                    </tr>
                                    <?php }}?>

                                    <?php if ($is_approval == "true"): ?>
                                    <tr>                                    
                                        <td class="col-md-12" colspan="3">
                                            <input type="hidden" name="is_approve" id="is_approve" title="is_approve" value="1"/>
                                            <input type="hidden" name="po_id" id="po_id" title="po_id" value="<?php echo $po_header['PO_ID'];?>"/>
                                            <input type="hidden" name="po_no" id="po_no" title="po_no" value="<?php echo $po_header['PO_NUMBER'];?>"/>
                                            <input type="hidden" name="max_approve" id="max_approve" title="max_approve" value="<?php echo count($approval);?>"/>
                                            <input type="hidden" name="real_stat" id="real_stat" title="real_stat" value="<?php echo $po_header['REAL_STAT']+1;?>"/>
                                            <input type="hidden" name="doctype" id="doctype" title="doctype" value="<?php echo $po_header['DOC_TYPE'];?>"/>
                                            <?php 
                                            if($winner[1]['PTM_NUMBER'] != null) {
                                                echo  "<input type=\"hidden\" name = \"is_contract\" value=\"0\">";
                                            }else{
                                                echo  "<input type=\"hidden\" name = \"is_contract\" value=\"1\">";
                                            }
                                            foreach ($winner as $win) {                                            
                                                echo '<input type="hidden" name="winner[]" value="'.$win['PTW_ID'].'">';
                                            }
                                            ?>
                                            <textarea name="note" id="note" class="col-md-12" placeholder="tulis disini"></textarea>
                                        </td>
                                    </tr>
                                    <?php endif ?>
                        <?php  ?>

                                </table>
                            </div>
                        </div>

                        <?php if ($is_approval == "true"): ?>
                        <br>
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <input type="hidden" name="is_ajax" id="is_ajax" value="1"/>
                                <button type="button" class="btn btn-danger text-left btn_reject_po" title="Reject" value="Reject"><i class="glyphicon glyphicon-remove"></i></button>
                                <button type="button" class="btn btn-success text-left btn_approve_po" title="Approve" value="Approve"><i class="glyphicon glyphicon-ok"></i></button>
                            </div>
                        </div>
                        <?php endif ?>
                        <hr>
                    </div>

                    <div class="col-md-12" style="margin-bottom: 2%">
                        <p><strong>Lampiran Kronologi Lembar Persetujuan Penunjukan Pemenang:</strong></p>
                        <p>I. Undangan Penawaran: <?php echo date('d M Y',strtotime($ptm['PTM_CREATED_DATE'])); ?> - <?php echo date('d M Y',$releaseComplete); ?></p>
                        <table class="table table-bordered">
                            <tr>
                                <td>
                                        <div class="col-md-12">
                                            Peserta Tender :
                                        </div>
                                        <div class="col-md-12">
                                            <?php
                                                // unset($pesertavendor[6]);
                                                $nvendor = count($pesertavendor);
                                                $half = (int)($nvendor / 2);
                                            ?>

                                            <?php if(($nvendor % 2) == 1){ ?>
                                                <?php for ($i=0; $i < $half ; $i++) { ?>
                                                    <div class="col-md-6">
                                                        <?php echo ($i+1).". ".$pesertavendor[$i]['VENDOR_NAME']; ?>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <?php echo ($half+1+$i+1).". ".$pesertavendor[$half+$i]['VENDOR_NAME']; ?>
                                                    </div>
                                                <?php } ?>
                                                    <div class="col-md-6">
                                                        <?php echo ($half+1).". ".@$pesertavendor[$half+$i]['VENDOR_NAME']; ?>
                                                    </div>
                                            <?php  } else { ?>
                                                <?php for ($i=0; $i < $half ; $i++) { ?>
                                                    <div class="col-md-6">
                                                        <?php echo ($i+1).". ".$pesertavendor[$i]['VENDOR_NAME']; ?>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <?php echo ($half+$i+1).". ".$pesertavendor[$half+$i]['VENDOR_NAME']; ?>
                                                    </div>
                                                <?php } ?>
                                            <?php  } ?>
                                        </div>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <p>II. Rekap Penawaran Yang Respon: <?php echo ($verifikasiPenawaran!='')?date('d M Y',$verifikasiPenawaran):''; ?></p>
                        <div class="row">
                            <div class="col-md-12" style="margin-bottom: 2%">
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="font-size: 9pt">
                                        <thead>
                                            <tr>
                                                <td nowrap class="text-center" rowspan="3" style="">No</td>
                                                <td nowrap class="text-center" rowspan="3">Nama Barang</td>
                                                <td nowrap class="text-center" rowspan="3">Qty</td>
                                                <td nowrap class="text-center" rowspan="3">UoM</td>
                                                <td nowrap class="text-center" rowspan="3">ECE<br>(Unit Price)</td>
                                                <td nowrap class="text-center" colspan="<?php echo count($nyo); ?>">Vendor / RFQ</td>
                                            </tr>
                                            <tr>
                                                <?php foreach ($nyo as $key => $value): ?>
                                                    <td nowrap class="text-center"><?php echo $value['VENDOR_NAME']; ?></td>
                                                <?php endforeach ?>
                                            </tr>
                                            <tr>
                                                <?php foreach ($nyo as $vendor):?>
                                                    <?php foreach ($pesertavendor as $vnd):?>
                                                        <?php if($vendor['PTV_VENDOR_CODE'] == $vnd['PTV_VENDOR_CODE']):?>
                                                        <td nowrap class="text-center"><?php echo $vnd['PTV_RFQ_NO']?></td>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                <?php endforeach ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=0; foreach ($pti as $id => $val): ?>
                                                <?php foreach ($item as $key => $value):?>
                                                    <?php if($val['PPI_DECMAT'] == $value['POD_DECMAT']): ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $no+1; ?></td>
                                                            <td nowrap><?php echo $val['PPI_DECMAT'] ?></td>
                                                            <td class="text-center"><?php echo $val['TIT_QUANTITY'] ?></td>
                                                            <td class="text-center"><?php echo $val['PPI_UOM'] ?></td>
                                                            <td class="text-right"><?php echo number_format($val['TIT_PRICE']) ?></td>
                                                            <?php foreach ($pesertavendor as $vnd): ?>
                                                                <?php 
                                                                    if(isset($ptqi[$val['TIT_ID']][$vnd['PTV_VENDOR_CODE']]['PQI_FINAL_PRICE'])){ ?>
                                                                <td class="text-right">
                                                                     <?php   echo number_format($ptqi[$val['TIT_ID']][$vnd['PTV_VENDOR_CODE']]['PQI_PRICE']); ?>
                                                                </td>
                                                                    <?php } 
                                                                ?>
                                                            <?php endforeach ?>
                                                        </tr>
                                                    <?php $no++; endif ?>
                                                <?php endforeach ?>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <br>
                        <p>III. Evaluasi Teknis: <?php echo date('d M Y',$appevatek); ?> - <?php echo date('d M Y',$appeval); ?></p>
                        <div class="row">
                            <div class="col-md-12" style="margin-bottom: 2%">
                                <div class="panel panel-default">
                                    <table class="table">
                                        <tr>
                                            <td>
                                                Hasil Evaluasi Teknis
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Evaluator : <?php echo $evaluator['FULLNAME']." ( ".$evaluator['DEPT_NAME']." )" ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0;">
                                                <?php echo $evaluasi; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php foreach ($history as $nomor => $data): ?>
                            <?php if($data['NEGOSIASI'] == "1"){ ?>
                                <p><?php echo $data['ROMAWI'] ?>. Undangan Negosiasi: <?php if($data['NEGOSIASI'] == "3") echo date('d M Y H:i:s',$data['DATE']); else echo date('d M Y',$data['DATE']);  ?></p>
                                <table class="table table-bordered">
                                <tr>
                                    <td>
                                            <div class="col-md-12">
                                                Peserta Negosiasai :
                                            </div>
                                            <div class="col-md-12">
                                            <?php
                                                // unset($pesertavendor[6]);
                                                $vendor_name = array_unique($data['DATA']['VENDOR_NAME']);
                                                $vendor_code = array_unique($data['DATA']['VENDOR_CODE']);
                                                $nvendor = count($vendor_name);
                                                $half = (int)($nvendor / 2);
                                            ?>

                                            <?php $no=1; foreach ($vendor_name as $vnd) { ?>
                                                <div class="col-md-6">
                                                    <?php echo $no++.". ".$vnd; ?>
                                                </div>
                                            <?php } ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <br>
                                <p><?php echo $data['ROMAWI_II'] ?>. Rekap Negosiasi: <?php echo date('d M Y',$data['DATA']['NEGO_END']); ?></p>
                                <div class="row">
                                    <div class="col-md-12" style="margin-bottom: 2%">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="font-size: 9pt">
                                                <thead>
                                                    <tr>
                                                        <td nowrap class="text-center" rowspan="3" style="">No</td>
                                                        <td nowrap class="text-center" rowspan="3">Nama Barang</td>
                                                        <td nowrap class="text-center" rowspan="3">Qty</td>
                                                        <td nowrap class="text-center" rowspan="3">UoM</td>
                                                        <td nowrap class="text-center" rowspan="3">ECE<br>(Unit Price)</td>
                                                        <td nowrap class="text-center" colspan="<?php echo count($vendor_name); ?>">Vendor / RFQ</td>
                                                    </tr>
                                                    <tr>
                                                        <?php foreach ($vendor_name as $key => $value): ?>
                                                            <td nowrap class="text-center"><?php echo $value; ?></td>
                                                        <?php endforeach ?>
                                                    </tr>
                                                    <tr>
                                                        <?php foreach ($vendor_code as $key => $value):?>
                                                            <?php foreach ($pesertavendor as $vnd):?>
                                                                <?php if ($value == $vnd['PTV_VENDOR_CODE']): ?>
                                                                    <td nowrap class="text-center"><?php echo $vnd['PTV_RFQ_NO']; ?></td>
                                                                <?php endif ?>
                                                            <?php endforeach ?>
                                                        <?php endforeach ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no=0; foreach ($data['M_ITEM'] as $id => $val): ?>
                                                        <?php foreach ($item as $key => $value): ?>
                                                            <?php if($val['PPI_DECMAT'] == $value['POD_DECMAT']): ?>
                                                                <tr>
                                                                    <td class="text-center"><?php echo $no+1; ?></td>
                                                                    <td nowrap><?php echo $val['PPI_DECMAT'] ?></td>
                                                                    <td class="text-right"><?php echo $val['TIT_QUANTITY'] ?></td>
                                                                    <td class="text-center"><?php echo $val['PPI_UOM'] ?></td>
                                                                    <td class="text-right"><?php echo number_format($val['TIT_PRICE']) ?></td>
                                                                    <?php foreach ($vendor_code as $vnd): ?>
                                                                        <td class="text-right">
                                                                        <?php
                                                                            if(isset($data['DATA']['ITEM'][$val['TIT_ID']][$vnd])){
                                                                                if(number_format($data['DATA']['ITEM'][$val['TIT_ID']][$vnd]) == "0"){
                                                                                    echo number_format($data['DATA']['ITEM'][$val['TIT_ID']][$vnd]);
                                                                                } else {
                                                                                    echo number_format($data['DATA']['ITEM'][$val['TIT_ID']][$vnd]);
                                                                                }
                                                                            } else {
                                                                                echo "-";
                                                                            }
                                                                        ?>
                                                                        </td>
                                                                    <?php endforeach ?>
                                                                </tr>
                                                            <?php $no++; endif ?>
                                                        <?php endforeach ?>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php } else if($data['NEGOSIASI'] == "2"){ ?>
                                <p><?php echo $data['ROMAWI'] ?>. Undangan Auction: <?php if($data['NEGOSIASI'] == "3") echo date('d M Y H:i:s',$data['DATE']); else echo date('d M Y',$data['DATE']);  ?></p>
                                <table class="table table-bordered">
                                <tr>
                                    <td>
                                            <div class="col-md-12">
                                                Peserta Negosiasi:
                                            </div>
                                            <div class="col-md-12">
                                                <?php
                                                    // unset($pesertavendor[6]);
                                                    $vendor_name = array_unique($data['DATA']['VENDOR_NAME']);
                                                    $nvendor = count($vendor_name);
                                                    $half = (int)($nvendor / 2);
                                                ?>
                                                <?php $no=1; foreach ($vendor_name as $vnd) { ?>
                                                    <div class="col-md-6">
                                                        <?php echo $no++.". ".$vnd; ?>
                                                    </div>
                                                <?php } ?>
                                                <!-- 
                                                <?php if(($nvendor % 2) == 1){ ?>
                                                    <?php for ($i=0; $i < $half ; $i++) { ?>
                                                        <div class="col-md-6">
                                                            <?php echo ($i+1).". ".$vendor_name[$i]; ?>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <?php echo ($half+1+$i+1).". ".$vendor_name[$half+$i]; ?>
                                                        </div>
                                                    <?php } ?>
                                                        <div class="col-md-6">
                                                            <?php echo ($half+1).". ".$vendor_name[$half+$i]; ?>
                                                        </div>
                                                <?php  } else { ?>
                                                    <?php for ($i=0; $i < $half ; $i++) { ?>
                                                        <div class="col-md-6">
                                                            <?php echo ($i+1).". ".$vendor_name[$i]; ?>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <?php echo ($half+$i+1).". ".$vendor_name[$half+$i]; ?>
                                                        </div>
                                                    <?php } ?>
                                                <?php  } ?>
                                                 -->
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <br>
                                <p><?php echo $data['ROMAWI_II'] ?>. Rekap Auction: <?php echo date('d M Y',$data['DATA']['PAQH_AUC_END']); ?></p>
                                <div class="row">
                                    <div class="col-md-12" style="margin-bottom: 2%">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="font-size: 9pt">
                                                <thead>
                                                    <tr>
                                                        <td nowrap class="text-center" rowspan="3" style="">No</td>
                                                        <td nowrap class="text-center" rowspan="3">Nama Barang</td>
                                                        <td nowrap class="text-center" rowspan="3">Qty</td>
                                                        <td nowrap class="text-center" rowspan="3">UoM</td>
                                                        <td nowrap class="text-center" rowspan="3">ECE<br>(Unit Price)</td>
                                                        <td nowrap class="text-center" colspan="<?php echo count($vendor_name); ?>">Vendor / RFQ</td>
                                                    </tr>
                                                    <tr>
                                                        <?php foreach ($vendor_name as $key => $value): ?>
                                                            <td nowrap class="text-center"><?php echo $value; ?></td>
                                                        <?php endforeach ?>
                                                    </tr>
                                                    <tr>
                                                        <?php foreach ($data['DATA']['ITEM'] as $key => $value): ?>
                                                            <td nowrap class="text-center"><?php echo $key; ?></td>
                                                        <?php endforeach ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $count = 1; ?>
                                                    <?php $no=0; foreach ($data['M_ITEM'] as $id => $val): ?>
                                                        <?php foreach ($item as $key => $value): ?>
                                                            <?php if($val['PPI_DECMAT'] == $value['POD_DECMAT']): ?>
                                                                <tr>
                                                                    <td class="text-center"><?php echo $no+1; ?></td>
                                                                    <td nowrap><?php echo $val['PPI_DECMAT'] ?></td>
                                                                    <td class="text-center"><?php echo $val['TIT_QUANTITY'] ?></td>
                                                                    <td class="text-center"><?php echo $val['PPI_UOM'] ?></td>
                                                                    <td class="text-right"><?php echo number_format($val['TIT_PRICE']) ?></td>
                                                                    <?php if($count == 1): ?>
                                                                        <?php foreach ($data['DATA']['ITEM'] as $vnd): ?>
                                                                            <td class="text-right" rowspan="<?php echo count($data['DATA']['ITEM']) ?>">
                                                                            <?php 
                                                                                if(isset($data['DATA']['ITEM'])){
                                                                                        echo number_format($vnd);
                                                                                } else {
                                                                                    echo "-";
                                                                                }
                                                                            ?>
                                                                            </td>
                                                                        <?php endforeach ?>
                                                                        <?php $count++; ?>
                                                                    <?php endif ?>
                                                                </tr>
                                                            <?php $no++; endif ?>
                                                        <?php endforeach ?>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php } else if($data['NEGOSIASI'] == "3"){ ?>
                                 <p><?php echo $data['ROMAWI'] ?>. Revisi ECE: <?php if($data['NEGOSIASI'] == "3") echo date('d M Y H:i:s',$data['DATE']); else echo date('d M Y',$data['DATE']);  ?></p>
                                 <div class="row">
                                    <div class="col-md-12" style="margin-bottom: 2%">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="font-size: 9pt">
                                                <thead>
                                                    <tr>
                                                        <td nowrap class="text-center" style="">No</td>
                                                        <td nowrap class="text-center">Nama Barang</td>
                                                        <td nowrap class="text-center">Qty</td>
                                                        <td nowrap class="text-center">UoM</td>
                                                        <td nowrap class="text-center">ECE<br>(Unit Price)</td>
                                                        <td nowrap class="text-center">New ECE<br>(Unit Price)</td>
                                                        <td nowrap class="text-center">Dokumen</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        <tr>
                                                            <td><?php echo $id+1; ?></td>
                                                            <td nowrap><?php echo $data['M_ITEM'][$data['DATA']['TIT_ID']]['PPI_DECMAT'] ?></td>
                                                            <td class="text-right"><?php echo $data['M_ITEM'][$data['DATA']['TIT_ID']]['TIT_QUANTITY'] ?></td>
                                                            <td class="text-center"><?php echo $data['M_ITEM'][$data['DATA']['TIT_ID']]['PPI_UOM'] ?></td>
                                                            <td class="text-right"><?php echo number_format($data['DATA']['PRICE_BEFORE']) ?></td>
                                                            <td class="text-right"><?php echo number_format($data['DATA']['PRICE_AFTER']) ?></td>
                                                            <td class="text-center"><a href="<?php echo base_url(UPLOAD_PATH.'ece').'/'.$data['DATA']['DOKUMEN'] ?>" target="_blank">View</a></td>
                                                        </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php endforeach ?>
                    </div>
                </div>
                <?php if($is_print=='false'): ?>
                <div class="col-md-12">
                    <div class="col-md-12">
                         <?php if($po_header['IS_APPROVE']==2 && $po_header['PO_CREATED_BY']==$this->session->userdata['ID']):?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Follow Up Rejected PO
                            </div>
                            <div class="panel-body text-center">
                                <a type="button" class="main_button color2 small_btn btn-edit" href="<?php echo base_url("Tender_winner/detail/".($po_header['PO_ID']))?>" title="Dikembalikan ke Form LP3">Edit</a>
                                <a type="button" class="main_button color5 small_btn btn-renego" href="<?php echo base_url("Tender_winner/renego/".($po_header['PO_ID']))?>" title="Dikembalikan ke Tahap Negosiasi">Renegosiasi</a>
                                <a type="button" class="main_button color4 small_btn btn-retender" href="<?php echo base_url("Tender_winner/retender/".($po_header['PO_ID']))?>" title="Dilakukan Tender ulang">Retender</a>
                                <a type="button" class="main_button color3 small_btn btn-cancel" href="<?php echo base_url("Tender_winner/cancel/".($po_header['PO_ID']))?>" title="Pembatalan (cancel) tender secara permanen">Batal</a>
                            </div>
                        </div>
                        <?php endif ?>
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <?php if ($is_approval == "true"): ?>
                                    <a type="button" class="main_button color7 small_btn close-modal" href="<?php echo base_url("Tender_winner/listapprovalPO")?>">Kembali</a>
                                <?php else: ?>
                                    <a type="button" class="main_button color7 small_btn close-modal" href="javascript:window.close()">Tutup</a>
                                    <a type="button" class="main_button color7 small_btn close-modal" href="<?php echo base_url("Tender_winner/detailPO/".($po_header['PO_ID'])."/false/true")?>">Print LP3</a>
                                   
                                     
                                <?php endif ?>                                
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</form>
</section>
<?php if($is_print=='true'){ ?>
</body>
</html>
<?php }?>