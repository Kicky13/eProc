<?php if (isset($status)) ?>
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>

            <div class="row">
                <?php if ($this->session->flashdata('success') != false): ?>                                    
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Success!</strong> <?php echo $this->session->flashdata('success');?>.
                    </div>                                    
                <?php endif?>
                <form method="post" action="<?php echo base_url() ?>Tender_winner_tonasa/detail/" novalidate>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            RFQ 
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                

                            <div class="alert alert-danger alert-dismissible hidden" id="cekvendor" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                Vendor yang dipilih berbeda !<strong> Pilih vendor yang sama.</strong> 
                            </div>
                                <div class="col-md-12">
                                    <table id="prc-tender-winner-list-table-rfq" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Usulan Pratender</th>
                                                <th>Pratender</th>
                                                <th>PR No</th>
                                                <th>RFQ</th>
                                                <th>Vendor Name</th>
                                                <th>Description</th>
                                                <th>Price</th>
                                                <th>Purch Grp</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <a href="<?php echo current_url(); ?>" class="main_button color7 small_btn">Batal</a>
                                <button id="submit-form" type="submit" class="main_button color6 small_btn">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <form method="post" action="<?php echo base_url() ?>Tender_winner_tonasa/detail/" novalidate>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Contract
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible hidden" id="cekvendor" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                Vendor yang dipilih berbeda !<strong> Pilih vendor yang sama.</strong> 
                            </div>
                                <div class="col-md-12">
                                    <table id="prc-tender-winner-list-table-contract" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>PR No</th>
                                                <th>Contract</th>
                                                <th>Vendor Name</th>
                                                <th>Description</th>
                                                <th>Price</th>
                                                <th>Purch Grp</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <a href="<?php echo current_url(); ?>" class="main_button color7 small_btn">Batal</a>
                                <button id="submit-form" type="submit" class="main_button color6 small_btn">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal_dokumen_dua">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">Detail Description</div>
      <div class="modal-body">
        <div id="idku"></div>
      </div>
    </div>
  </div>
</div>
