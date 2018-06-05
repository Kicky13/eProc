<?php if (isset($status)) ?>
<section class="content_section">
    <input type="hidden" id="status" value="<?php echo $status; ?>">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Error!</strong> <?php echo $this->session->flashdata('error') ?>
                            </div>
                        <?php endif ?>
                    <!--<table id="auction-list-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Usulan Pratender </th>
                                    <th>No Pratender</th>
                                    <th>Subject</th>
                                    <th>Requester Name</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>    -->
                        <!-- <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <a href="<?php echo base_url(); ?>EC_Auction_itemize/create/" class="btn btn-success btn-block">Tambah</a>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                               Undangan Tender
                           </div>
                           <div class="panel-body">
                            <table class="table table-hover" id="negotiation_list">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nomer Tender</th>
                                        <th class="text-left">Deskrripsi</th>
                                        <th class="text-left">Tanggal Buat</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php 
                                  for ($i=0; $i < sizeof($aunction) ; $i++) {												
                                     ?>
                                     <!-- <input type="hidden" id="notender" value="$aunction[$i]['NO_TENDER']?"> -->
                                     <tr style="border-bottom: 1px solid #ccc;">
                                        <th class="text-center"><?php echo $i+1 ?></th>
                                        <th class="text-center"><?php echo $aunction[$i]['NO_TENDER']?></th>
                                        <th class="text-left"><?php echo $aunction[$i]['DESC_NEW']?></th>
                                        <th class="text-left"><?php echo $aunction[$i]['CREATED']?></th>
                                        <th class="text-center <?php if($aunction[$i]['ACTIVE_NEW']=='0') echo 'danger'; else if ($aunction[$i]['ACTIVE_NEW']=='1') echo 'warning'; else if ($aunction[$i]['ACTIVE_NEW']=='2') echo 'success'; else echo 'danger'?>"><?php if($aunction[$i]['ACTIVE_NEW']=='0') echo 'CLOSE'; else if ($aunction[$i]['ACTIVE_NEW']=='1') echo 'DRAFT'; else if ($aunction[$i]['ACTIVE_NEW']=='2') echo 'OPEN'; else echo 'BATAL';?></th>	
                                        <th class="text-center">
                                            <?php if($aunction[$i]['ACTIVE_NEW']=='1'){ ?>
                                            <!-- <a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>EC_Auction_itemize/setBatch/<?php echo $aunction[$i]['NO_TENDER']?>" style="font-size: 15px">Proses</a> -->
                                            <a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>EC_Auction_itemize/editData/<?php echo $aunction[$i]['NO_TENDER']?>" style="font-size: 15px">Proses</a>
                                            <!-- <a class="btn btn-warning btn-xs" href="<?php echo base_url(); ?>EC_Auction_itemize/editDraft/<?php echo $aunction[$i]['NO_TENDER']?>" style="font-size: 15px">edit</a> -->
                                            <button class="btn btn-danger btn-xs" onclick="batal(<?php echo $aunction[$i]['NO_TENDER']?>)" style="font-size: 15px">Batal</button>
                                            <?php } else if($aunction[$i]['ACTIVE_NEW']=='2'){ ?>
                                            <a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>EC_Auction_itemize/indexBatch/<?php echo $aunction[$i]['NO_TENDER']?>" style="font-size: 15px">Process</a>
                                            <?php } else { ?>
                                            <a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>EC_Auction_itemize/indexBatch/<?php echo $aunction[$i]['NO_TENDER']?>" style="font-size: 15px">Detail</a>
                                            <?php }?>                                            
                                        </th>
                                        <!-- <th class="text-center"><a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>EC_Auction_itemize/indexBatch/<?php echo $aunction[$i]['NO_TENDER']?>">Process</a></th> -->	
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</section>