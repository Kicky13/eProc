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
                                        <th class="text-center">Pembukaan Negosiasi</th>
                                        <th class="text-center">Penutupan Negosiasi</th>
                                        <!-- <th class="text-center" style="min-width: 120px">Status</th> -->
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php 
                                  for ($i=0; $i < sizeof($aunction) ; $i++) {												
                                     ?>
                                     <tr style="border-bottom: 1px solid #ccc;">
                                        <th class="text-center"><?php echo $i+1 ?></th>
                                        <th class="text-center"><?php echo $aunction[$i]['NO_TENDER']?></th>
                                        <th class="text-left"><?php echo $aunction[$i]['DESC']?></th>
                                        <th class="text-center"><?php echo $aunction[$i]['PEMBUKAAN']?></th>
                                        <th class="text-center"><?php echo $aunction[$i]['PENUTUPAN']?></th>
                                        <th class="text-center <?php if($aunction[$i]['IS_ACTIVE']=='1') echo 'success'; else echo 'danger';?>"><?php if($aunction[$i]['IS_ACTIVE']=='1') echo 'ACTIVE'; else echo 'CLOSED';?></th>	
                                        <th class="text-center"><a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>EC_Auction_bobot/show_detail/<?php echo $aunction[$i]['NO_TENDER']?>">Process</a></th>	
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