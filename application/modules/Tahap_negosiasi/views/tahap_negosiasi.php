<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><span id="title"><?php echo $title ?></span></h2>
            </div>
            <form name="quotation-form" id="quotation-form" method="post" action="<?php echo base_url() ?>Tahap_negosiasi/save_bidding" class="submit">
                <input type="hidden" id="ptm_number" name="ptm_number" value="<?php echo $ptm_number; ?>">
                <div class="row">
                    <div class="col-md-12">
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Error!</strong> <?php echo $this->session->flashdata('error') ?>
                            </div>
                        <?php endif ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Pilih metode negosiasi yang digunakan pada setiap material
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <th><strong>Material</strong></th>
                                    <th><strong>Status</strong></th>
                                    <th><strong>Action</strong>
                                        <?php 
                                        $statusp = false;
                                        $is_itemize = ($ptp['PTP_IS_ITEMIZE']==1);
                                        if(!$is_itemize){?>
                                        <?php
                                        foreach ($tits as $tit){
                                            if (in_array($tit['TIT_STATUS'], array(0, null, 5, 16, 48, 96, 112))){
                                                $statusp = true;
                                            }
                                        }
                                        ?>
                                        <select name="pilih_metode_paket" class="pilih_metode_paket">
                                            <option value="">Pilih metode nego</option>
                                            <?php //if (in_array($tits[0]['TIT_STATUS'], array(0, null, 5, 16, 48, 96, 112))): ?>
                                            <?php if($statusp): ?>
                                                <option value="16">Negosiasi</option>
                                                <?php //if ($tit['TIT_STATUS'] == 0): ?>
                                                <option value="48">Auction</option>
                                                <option value="112">Analisa Kewajaran Harga</option>
                                            <?php endif ?>
                                            <?php if (($ptp['PTP_JUSTIFICATION_ORI']==5 && ($tits[0]['TIT_STATUS']!=6 && $tits[0]['TIT_STATUS']!=8))||(in_array($tits[0]['TIT_STATUS'], array(5, 16, 48, 96, 112)))): ?>
                                                <option value="6">Tunjuk Pemenang</option>
                                            <?php endif ?>                                            
                                        </select>
                                        <?php }?>
                                    </th>
                                </thead>
                                <tbody> 

                                    <?php foreach ($tits as $tit): ?>
                                        <tr>
                                            <td><?php echo $tit['PPI_PRNO'].' | '.$tit['PPI_PRITEM'].' | '.$tit['PPI_DECMAT'] ?></td>
                                            <td><?php echo $status[$tit['TIT_STATUS']] ?></td>
                                            <td class="">
                                                <input type="hidden" id="tit_id" value="<?php echo $tit['TIT_ID'] ?>"/>
                                                <select name="metode[<?php echo $tit['TIT_ID'] ?>]" class="pilih_metode <?php echo ($is_itemize?'':'hidden')?>">
                                                    <option value="">Pilih metode nego</option>
                                                    <?php if (in_array($tit['TIT_STATUS'], array(0, null, 5, 16, 48, 96, 112))): 
                                                    $statusp = true;
                                                    ?>
                                                    <option value="16">Negosiasi</option>
                                                    <?php //if ($tit['TIT_STATUS'] == 0): ?>
                                                    <option value="48">Auction</option>
                                                    <option value="112">Analisa Kewajaran Harga</option>
                                                <?php endif ?>
                                                <?php //else: ?>
                                                <?php //endif ?>
                                                <?php if (($ptp['PTP_JUSTIFICATION_ORI']==5 && ($tit['TIT_STATUS']!=6 && $tit['TIT_STATUS']!=8))||(in_array($tit['TIT_STATUS'], array(5, 16, 48, 96, 112)))): ?>
                                                    <option value="6">Tunjuk Pemenang</option>
                                                <?php endif ?>
                                            </select>

                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>


                    <?php
                    if($this->authorization->getCompanyId()==5000 || $this->authorization->getCompanyId()==7000){
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading"><strong>Rekap Pesan Nego</strong></div>
                            <div class="table-responsive">
                                <table class="table table-hover" style="font-size:9pt" border="1px">
                                    <tr>
                                        <td align="center"><strong>Proses</strong></td>
                                        <td align="center"><strong>Action</strong></td>
                                        <td align="center"><strong>User</strong></td>
                                        <td align="center"><strong>Tgl Selesai</strong></td>
                                        <td align="center"><strong>Pesan</strong></td>
                                        <?php if($tndr_nego){
                                            foreach ($tndr_nego as $val) {
                                                echo "<td align='center'><strong>".$val[0]['PPI_DECMAT']."</strong></td>";
                                            }
                                        } ?>
                                        <td align="center"><strong>File Negosiasi Harga</strong></td>
                                        <td align="center"><strong>Komentar</strong></td>
                                        <td align="center"><strong>IP Address</strong></td>
                                        <td align="center"><strong>Time Action</strong></td>
                                    </tr>
                                    <?php foreach ($v_log_main as $val) : ?>
                                        <?php if($val['PROCESS']=='Buka Negosiasi' || $val['PROCESS']=='Nego Invitation' || $val['PROCESS']=='Tutup Negosiasi'): ?> 
                                            <?php
                                            $ptc_comment='';$tglSelesai='';$pesanNego='';$negoPerItem=array();$fileNego='';$fileNama='';
                                            foreach ($detail[$val['LM_ID']] as $dtl){
                                                $encd = json_decode($dtl['DATA']);  
                                                $encd2 = json_decode($dtl['CONDITION']);
                                                
                                                if(!empty($encd->NEGO_END)){
                                                    $tglSelesai = $encd->NEGO_END;
                                                }
                                                if(!empty($encd->PTNS_NEGO_MESSAGE)){
                                                    $pesanNego = $encd->PTNS_NEGO_MESSAGE;
                                                }
                                                if(!empty($encd->HARGA) && !empty($encd2->TIT_ID)){
                                                    $negoPerItem[$encd2->TIT_ID] = $encd->HARGA;
                                                }
                                                if($dtl['TABLE_AFFECTED']=='prc_tender_nego_vendor_doc' && !empty($encd->FILE_UPLOAD)){
                                                    $fileNego = $encd->PTNV_ID;
                                                    $fileNama = $encd->FILE_UPLOAD;
                                                    $fileVendor = $encd->PTV_VENDOR_CODE;
                                                }
                                                if(isset($encd->PTC_COMMENT) && !empty($encd->PTC_COMMENT)){
                                                    $ptc_comment = str_replace("'", "", $encd->PTC_COMMENT);
                                                }
                                            } 
                                            ?>
                                            <tr>
                                                <td><?php echo $val['PROCESS']; ?></td>
                                                <td align="center"><?php echo $val['LM_ACTION']; ?></td>
                                                <td><?php echo $val['USER']; ?></td>
                                                <td><?php echo $tglSelesai; ?></td>
                                                <td><?php echo $pesanNego; ?></td>
                                                <?php if($tndr_nego){
                                                    foreach ($tndr_nego as $t => $v) {
                                                        if(!empty($negoPerItem[$t])){
                                                            echo "<td align='right'>".number_format($negoPerItem[$t])."</td>";
                                                        }else{
                                                            echo "<td></td>";
                                                        }
                                                    }
                                                } ?>
                                                <?php 
                                                if(!empty($fileNego)){
                                                    echo '<td><a href="'.base_url('Nego_invitation').'/download_file/'.$fileNego.'/'.$fileVendor.'" target="_blank" title="File Nego">
                                                    <i class="glyphicon glyphicon-file"></i>
                                                </a> '.$fileNama.'</td>';
                                            }else{
                                                echo "<td></td>";
                                            }
                                            ?>
                                            <td><?php echo $ptc_comment; ?></td>
                                            <td><?php echo $val['IP_ADDRESS']; ?></td>
                                            <td><?php echo $val['LM_DATETIME']; ?></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <div class="panel panel_rekap"></div>
                <?php echo ($ptp['PTP_JUSTIFICATION_ORI']!=5)?$evaluasi:'';?>
                <?php echo $detail_ptm_snip ?>
                <?php echo $this->snippet->assignment($ptm_number) ?>
                <?php if($ptp['PTP_JUSTIFICATION_ORI'] == 5) : ?> <!-- Penunjukan Langsung - Repeat Order (RO) -->
                    <?php echo $tit_po; ?>
                <?php endif; ?>
                <?php echo $vendor_ptm ?>
                <div id="history_pesan">
                    <?php echo $pesan; ?>
                </div>
                <?php echo $ptm_comment ?>
                <?php if($statusp): ?>
                    <div class="panel panel-default panel_lanjut">
                        <div class="panel-heading">Komentar Anda</div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tr>
                                    <td class="col-md-3">Komentar</td>
                                    <td class="col-md-1 text-right">:</td>
                                    <td><textarea maxlength="1000" class="form-control" name ="ptc_comment" id="ptc_comment" /></textarea></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="panel panel-default panel_lanjut">
                        <div class="panel-body text-center">
                            <select name="next_process" id="next_process" class="harusmilih_publicjs">
                                <option value="false_public"></option>
                                <option value="1">Lanjutkan</option>                                
                                <option value="0">Retender</option>
                                <option value="999">Batal</option>
                            </select>
                            <input class="subjudul" type="hidden" value="Pastikan data yang Anda masukkan sudah benar"></input>
                            <button type="button" id="submit_button" class="formsubmit_ main_button color7 small_btn milihtombol_publicjs" disabled>OK</button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>
</div>
</section>

<div class="modal fade" id="att_teknis">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>