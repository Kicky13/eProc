<section class="content_section">
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
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                List Batch
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover" id="negotiation_list">
                                    <thead>
                                        <tr>
                                            <th class="col-md-1">No</th>
                                            <th>Batch</th>
                                            <th>Jumlah Item</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($batch as $value){?> 
                                        <tr>
                                            <td><?php echo ++$i?></td>
                                            <td><?php echo $value['NAME']?></td>
                                            <td><?php echo $value['QTY_ITEM']?></td>
                                            <th class="text-center <?php if($value['IS_ACTIVE']=='1') echo 'success'; else echo 'danger';?>"><?php if($value['IS_ACTIVE']=='1') echo 'ACTIVE'; else echo 'CLOSED';?></th> 
                                            <td>
                                                <a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>EC_Auction_itemize_negotiation/detail_auction/<?php echo $notender; ?>/<?php echo $value['NAME']; ?>">Process</a>
                                            </td>
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