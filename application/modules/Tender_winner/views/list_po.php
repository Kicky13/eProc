<?php if (isset($status)) ?>
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">                
                <?php if ($this->session->flashdata('success')!=''): ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Success!</strong> <?php echo $this->session->flashdata('success');?>.
                    </div>
                <?php elseif ($this->session->flashdata('info')!=''): ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Info:</strong> <?php echo $this->session->flashdata('info');?>.
                    </div>
                <?php elseif ($this->session->flashdata('warning')!=''): ?>
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Warning!</strong> <?php echo $this->session->flashdata('warning');?>.
                    </div>
                <?php elseif ($this->session->flashdata('error')!=''): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Error!</strong> <?php echo $this->session->flashdata('error');?>.
                    </div>
                <?php endif ?>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="panel-group" id="accordionperbarui" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="button" data-toggle="collapse" data-parent="#accordionperbarui" href="#collapsePerbarui" aria-expanded="true" aria-controls="collapseOne">
                                    <h4 class="panel-title">
                                        <a >Search</a>
                                    </h4>
                                </div>
                                <div id="collapsePerbarui" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        <form method="post" action="<?php echo base_url() ?>Tender_winner/listPO/" novalidate>
                                            <div class="row">
                                                <div class="col-md-2" style="margin-right: 2%">
                                                    <input type="text" class="input-sm filterinput" name="nopo" placeholder="No PO" value="<?php if(isset($nopo)) echo $nopo; ?>">
                                                </div>
                                                <div class="col-md-2" style="margin-right: 2%">
                                                    <input type="text" class="input-sm filterinput" name="nolp3" placeholder="No LP3" value="<?php if(isset($nolp3)) echo $nolp3; ?>">
                                                </div>
                                                <div class="col-md-2" style="margin-right: 2%">
                                                    <input type="text" class="input-sm filterinput" name="pratender" placeholder="Pratender No" value="<?php if(isset($pratender)) echo $pratender; ?>">
                                                </div>
                                                <div class="col-md-2" style="margin-right: 2%">
                                                    <input type="text" class="input-sm filterinput" name="namevendor" placeholder="Nama Vendor" value="<?php if(isset($namevendor)) echo $namevendor; ?>">
                                                </div>
                                                <div class="col-md-2" style="margin-right: 5%">
                                                    <input type="text" class="input-sm filterinput" name="kodevendor" placeholder="Kode Vendor" value="<?php if(isset($kodevendor)) echo $kodevendor; ?>">
                                                </div>
                                                <div class="col-md-2" style="margin-right: 5%">
                                                    <input type="text" class="input-sm filterinput" name="creator" placeholder="creator lp3" value="<?php if(isset($creator)) echo $creator; ?>">
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-5" style="margin-right: 2%;padding-top: 5px;">
                                                    <input type="checkbox" class="form-input filtercek" placeholder="Include Full Release" value="1" name="release" <?php if(isset($release)) if($release) echo "checked"; ?>> Include Full Release
                                                    <a href="#!" class="btn btn-default refresh">Clear</a>
                                                    <button class="btn btn-default" id="renewPR">Search</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <div style="height: 500px; overflow: auto;">
                                <table class="table table-bordered table-hover" style="font-size: 10pt">
                                    <thead>
                                        <tr>
                                            <th class="text-center">PO No</th>
                                            <th class="text-center">LP3 No</th>
                                            <th class="text-center">Pratender No</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Rel Ind</th>
                                            <th class="text-center">Real Stat</th>
                                            <th class="text-center">Item</th>
                                            <th class="text-center">Plant</th>
                                            <th nowrap class="text-center">Vendor/supplying plant</th>
                                            <th class="text-center">Doc Date</th>
                                            <th class="text-center">Delivery Date</th>
                                            <th class="text-center">Released Date</th>
                                            <th nowrap class="text-center">Material</th>
                                            <th class="text-center">Short Text</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">UoM</th>
                                            <th class="text-center">NetPrice</th>
                                            <th class="text-center">Value</th>
                                            <th class="text-center">Curr</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($data) <= 0): ?>
                                            <tr><td colspan="17">Tidak ada data yang ditampilkan.</td></tr>
                                        <?php endif ?>
                                        <?php foreach ($data as $key => $value): ?>
                                            <?php if(isset($value['item'])): ?>
                                                <?php foreach ( $value['item'] as $id => $val): ?>
                                                    <?php if($id == 0): ?>
                                                        <tr>
                                                            <td rowspan="<?php echo $value['nitem'] ?>"><a href="<?php echo base_url("Tender_winner/releasePO/".$value['PO_ID'])?>" target="_blank" title="Click - view - print PO"><?php echo $value['PO_NUMBER'] ?></a></td>
                                                            <td rowspan="<?php echo $value['nitem'] ?>"><a href="<?php echo base_url("Tender_winner/detailPO/".$value['PO_ID'])?>" target="_blank" title="Click - view - print LP3"><?php echo $value['LP3_NUMBER'] ?></a></td>
                                                            <td rowspan="<?php echo $value['nitem'] ?>"><?php echo $value['PTM_PRATENDER'] ?></td>
                                                            
                                                            <?php
                                                            if($value['IS_SUBMIT']==1){
                                                                ?>
                                                                <td class="text-center <?php echo $value['IS_APPROVE']==0?'waiting':($value['IS_APPROVE']==1?'approved':($value['IS_APPROVE']==2?'rejected':($value['IS_APPROVE']==3?'renego':($value['IS_APPROVE']==4?'retender':'canceled')))); ?>" rowspan="<?php echo $value['nitem'] ?>"><a href="<?php echo base_url("Tender_winner/detailPO/".$value['PO_ID'])?>" target="_blank" title="Click - view - print LP3"><?php echo $value['status_po'] ?></a></td>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <td class="text-center" rowspan="<?php echo $value['nitem'] ?>"><a href="<?php echo base_url("Tender_winner/detailPO/".$value['PO_ID'])?>" target="_blank" title="Click - view - print LP3">DRAFT</a></td>
                                                                <?php
                                                            }
                                                            ?>

                                                            <td class="text-center" rowspan="<?php echo $value['nitem'] ?>"><?php echo $value['REL_IND'] ?></td>
                                                            <td class="text-center" rowspan="<?php echo $value['nitem'] ?>">
                                                                <?php for ($i=0; $i < $value['REAL_STAT'] ; $i++) {
                                                                    echo "X";
                                                                }?>
                                                            </td>
                                                            <td class="text-center"><?php echo $val['EBELP'] ?></td>
                                                            <td class="text-center"><?php echo $val['PLANT'] ?></td>
                                                            <td rowspan="<?php echo $value['nitem'] ?>" nowrap><?php echo $value['VND_NAME'] ?></td>
                                                            <td rowspan="<?php echo $value['nitem'] ?>" class="text-center">
                                                                <?php 
                                                                $time = oraclestrtotime($value['DOC_DATE']) ;
                                                                $tgl = date('d/m/Y',$time);
                                                                echo $tgl;
                                                                ?>
                                                            </td>
                                                            <td rowspan="<?php echo $value['nitem'] ?>" class="text-center">
                                                                <?php 
                                                                $time = oraclestrtotime($value['DDATE']) ;
                                                                $tgl = date('d/m/Y',$time);
                                                                echo $tgl;
                                                                ?>
                                                            </td>
                                                            <td rowspan="<?php echo $value['nitem'] ?>" class="text-center">
                                                                <?php echo (!empty($value['RELEASED_AT']))?date('d/m/Y',oraclestrtotime($value['RELEASED_AT'])):'-';?>
                                                            </td>
                                                            <td nowrap class="text-center"><?php echo $val['POD_NOMAT'] ?></td>
                                                            <td><?php echo $val['POD_DECMAT'] ?></td>
                                                            <td class="text-right"><?php echo $val['POD_QTY'] ?></td>
                                                            <td class="text-center"><?php echo $val['UOM'] ?></td>
                                                            <td class="text-right"><?php echo number_format($val['POD_PRICE']) ?></td>
                                                            <td class="text-right"><?php echo number_format(intval($val['POD_PRICE']) * intval($val['POD_QTY'])) ?></td>
                                                            <td class="text-center"><?php echo $val['CURR'] ?></td>
                                                        </tr>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $val['EBELP'] ?></td>
                                                            <td class="text-center"><?php echo $val['PLANT'] ?></td>
                                                            <td nowrap class="text-center"><?php echo $val['POD_NOMAT'] ?></td>
                                                            <td nowrap><?php echo $val['POD_DECMAT'] ?></td>
                                                            <td class="text-right"><?php echo $val['POD_QTY'] ?></td>
                                                            <td class="text-center"><?php echo $val['UOM'] ?></td>
                                                            <td class="text-right"><?php echo number_format($val['POD_PRICE']) ?></td>
                                                            <td class="text-right"><?php echo number_format(intval($val['POD_PRICE']) * intval($val['POD_QTY'])) ?></td>
                                                            <td class="text-center"><?php echo $val['CURR'] ?></td>
                                                        </tr>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</section>
