<?php if (isset($status)) ?>
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <?php if ($this->session->flashdata('success') != false): ?>
                    <?php if ($this->session->flashdata('success') == 'success'): ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Success!</strong> Approve PO berhasil.
                        </div>
                    <?php elseif ($this->session->flashdata('success') == 'warning'): ?>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Warning!</strong> Approve PO tidak berhasil.
                        </div>
                    <?php elseif ($this->session->flashdata('success') == 'error'): ?>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Warning!</strong> PO tidak ditemukan di E-Proc.
                        </div>
                    <?php endif ?>
                <?php endif ?>
                <?php if ($this->session->flashdata('ret_approve_po_dump') != false): ?>
                    <div class="hidden">
                        <?php var_dump($this->session->flashdata('ret_approve_po_dump')) ?>
                    </div>
                <?php endif ?>
                <?php if ($this->session->flashdata('ret_approve_po') != false): ?>
                    <?php $ret_approve_po = $this->session->flashdata('ret_approve_po'); ?>
                    <div class="alert alert-info alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <p>RETURN:</p>
                        <ul>
                            <?php foreach ($ret_approve_po as $key => $value): ?>
                                <li>&nbsp;&nbsp;&nbsp;<?php echo $key . ': ' . $value ?></li>
                            <?php endforeach ?>
                        </ul>
                        <div class="hidden hasil rfc">
                            <?php echo var_dump($ret_approve_po) ?>
                        </div>
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
                                        <form method="post" action="<?php echo base_url() ?>Tender_winner/listapprovalPO" novalidate>
                                            <div class="col-md-2" style="margin-right: 2%">
                                                <input type="text" class="input-sm filterinput" name="nolp3" placeholder="No LP3" value="<?php if(isset($nolp3)) echo $nolp3; ?>">
                                            </div>
                                            <div class="col-md-2" style="margin-right: 2%">
                                                <input type="text" class="input-sm filterinput" name="namevendor" placeholder="Nama Vendor" value="<?php if(isset($namevendor)) echo $namevendor; ?>">
                                            </div>
                                            <div class="col-md-2" style="margin-right: 2%">
                                                <input type="text" class="input-sm filterinput" name="kodevendor" placeholder="Kode Vendor" value="<?php if(isset($kodevendor)) echo $kodevendor; ?>">
                                            </div>  
                                            <div class="col-md-2" style="margin-right: 2%">
                                                <input type="text" class="input-sm filterinput" name="pratender" placeholder="Pratender No" value="<?php if(isset($pratender)) echo $pratender; ?>">
                                            </div>                           
                                            <div class="col-md-2" style="margin-right: 2%">  
                                                <a href="#!" class="btn btn-default refresh">Clear</a>
                                                <button class="btn btn-default" id="renewPR">Search</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" style="font-size: 10pt">
                                <thead>
                                    <tr>
                                        <th class="text-center">Print</th>
                                        <th class="text-center">Detail</th>
                                        <th class="text-center">LP3 No</th>
                                        <th class="text-center col-md-2">Doc Date</th>
                                        <th class="text-center col-md-2">Delivery Date</th>
                                        <th class="text-center">Value</th>
                                        <th nowrap class="text-center">Vendor/supplying plant</th>
                                        <th class="text-center">Rel Ind</th>
                                        <th class="text-center">Real Stat</th>
                                        <th class="text-center">Pratender No</th>
                                        <th class="text-center">Item</th>
                                        <th class="text-center">Plant</th>
                                        <th nowrap class="text-center">Material</th>
                                        <th class="text-center">Short Text</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">UoM</th>
                                        <th class="text-center">NetPrice</th>
                                        <th class="text-center">Curr</th>
                                    </tr>
                                </thead>
                                <tbody>                                                                       
                                    <?php foreach ($data as $key => $value): ?>                                    
                                        <?php
                                        $state=true;
                                        $poid=$value['PO_ID'];                                                                
                                        ?>
                                        <?php $no = 1; foreach ($value['item'] as $val): ?>
                                        <?php if($no == 1): ?>
                                            <tr>
                                                <td class="text-center" rowspan="<?php echo $value['nitem'] ?>">
                                                    <button type="button" class="btn btn-success btn-xs col-md-12 text-left" title="Approve" onClick="po_approve(<?php echo $value['PO_ID']?>)"><i class="glyphicon glyphicon-ok"></i></button>
                                                    <button type="button" class="btn btn-danger btn-xs col-md-12 text-left" title="Reject" onClick="po_reject(<?php echo $value['PO_ID']?>)"><i class="glyphicon glyphicon-remove"></i></button>
                                                </td>
                                                <td class="text-center" rowspan="<?php echo $value['nitem'] ?>">
                                                    <a href="<?php echo base_url("Tender_winner/detailPO/".$poid."/true") ?>" class="btn btn-default col-md-12 <?php echo $state?'':'hidden';?>"><i class="glyphicon glyphicon-search"></i></a>
                                                    <br>
                                                    <a class="btn btn-default col-md-12" href="<?php echo base_url("Tender_winner/releasePO/".$value['PO_ID'])?>" target="_blank" title="Draft PO"><i class="glyphicon glyphicon-print"></i></a>
                                                </td>
                                                <td rowspan="<?php echo $value['nitem'] ?>"><?php echo $value['LP3_NUMBER'] ?></td>
                                                <td nowrap rowspan="<?php echo $value['nitem'] ?>" class="text-center">
                                                    <?php echo date('d M y H:i:s',oraclestrtotime($value['DOC_DATE'])) ?>
                                                </td>
                                                <td nowrap rowspan="<?php echo $value['nitem'] ?>" class="text-center">
                                                    <?php echo date('d M y H:i:s',oraclestrtotime($value['DDATE'])) ?>
                                                </td>
                                                <td class="text-right"><?php echo number_format(intval($val['POD_PRICE']) * intval($val['POD_QTY'])) ?></td>
                                                <td rowspan="<?php echo $value['nitem'] ?>" nowrap><?php echo $value['VND_NAME'] ?></td>
                                                <td class="text-center" rowspan="<?php echo $value['nitem'] ?>"><?php echo $value['REL_IND'] ?></td>
                                                <td class="text-center" rowspan="<?php echo $value['nitem'] ?>"><?php echo $value['REAL_STAT'] ?></td>
                                                <td rowspan="<?php echo $value['nitem'] ?>"><?php echo $value['PTM_PRATENDER'] ?></td>
                                                <td class="text-right"><?php echo $val['POD_NUMBER'] ?></td>
                                                <td class="text-center"><?php echo $val['PLANT'] ?></td>
                                                <td nowrap class="text-center"><?php echo $val['POD_NOMAT'] ?></td>
                                                <td nowrap><?php echo $val['POD_DECMAT'] ?></td>
                                                <td class="text-right"><?php echo number_format($val['POD_QTY']) ?></td>
                                                <td class="text-center"><?php echo $val['UOM'] ?></td>
                                                <td class="text-right"><?php echo number_format($val['POD_PRICE']) ?></td>

                                                <td class="text-center"><?php echo $val['CURR'] ?></td>
                                            </tr>
                                        <?php else: ?>
                                            <tr>
                                                <td class="text-right"><?php echo number_format(intval($val['POD_PRICE']) * intval($val['POD_QTY'])) ?></td>
                                                <td class="text-right"><?php echo $val['POD_NUMBER'] ?></td>
                                                <td class="text-center"><?php echo $val['PLANT'] ?></td>
                                                <td nowrap class="text-center"><?php echo $val['POD_NOMAT'] ?></td>
                                                <td nowrap><?php echo $val['POD_DECMAT'] ?></td>
                                                <td class="text-right"><?php echo number_format($val['POD_QTY']) ?></td>
                                                <td class="text-center"><?php echo $val['UOM'] ?></td>
                                                <td class="text-right"><?php echo number_format($val['POD_PRICE']) ?></td>
                                                <td class="text-center"><?php echo $val['CURR'] ?></td>
                                            </tr>
                                        <?php endif ?>
                                        <?php $no++; endforeach ?>                                        
                                    <?php endforeach ?>
                                    <?php //endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="comment_modal" class="modal" role="dialog">
  <div class="modal-dialog">
    <form name="form_list_approve" id="form_list_approve" action="<?php echo base_url()?>Tender_winner/approve" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Approval</h4>
        </div>
        <div class="modal-body">
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
            <p>Catatan:</p>
            <table class="table table-hover table-comment">  

            </table>
            <table class="table">
                <tr>
                    <td class="inputan">
                        <input type="hidden" name="is_approve" id="is_approve" title="is_approve" value="1"/>
                        <input type="hidden" name="po_id" id="po_id" title="po_id"/>
                        <input type="hidden" name="po_no" id="po_no" title="po_no"/>
                        <input type="hidden" name="max_approve" id="max_approve" title="max_approve"/>
                        <input type="hidden" name="real_stat" id="real_stat" title="real_stat"/>
                        <input type="hidden" name="doctype" id="doctype" title="doctype"/>
                        <input type="hidden" name="is_contract" id="is_contract"/>
                        <input type="hidden" name="is_ajax" id="is_ajax" value="1"/>
                        <textarea name="note" id="note" class="col-md-12" placeholder="tulis disini"></textarea>    
                    </td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary save-approve">Approve</button>
        </div>
    </div>
</form>
</div>
</div>


