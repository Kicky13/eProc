<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $this->session->flashdata('success'); ?>
                        </div>
                    <?php endif ?>
                    <div class="col-md-12">
                        <table id="ece-list-monitoring" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Pratender</th>
                                    <th>Subject</th>
                                    <th>Buyer</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modalholder">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">List Holder</h4>
        </div>
        <div class="modal-body">
          <div class="panel panel-default">
            <table class="table table-striped">
              <thead>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
              </thead>
              <tbody id="tableholder">
              </tbody>
            </table>
          </div>
          <div class="text-right">
            <!-- <button class="btn btn-info" id="renewPR">Perbarui</button> -->
          </div>
        </div>
      </div>
    </div>
  </div>