
<section class="content_section">
  <div class="content_spacer">
    <div class="content">
      <div class="main_title centered upper">
        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
      </div>
      <div class="row">
        <div class="row "> 
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
            <?php if ($success){ ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success!</strong>&nbsp; Tanggal berhasil di update
            </div>
            <?php } ?>
            <div class="table-responsive">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <table id="tbl_reschedule" class="table table-striped">
                    <thead>
                      <tr>
                        <th><span class="invisible">a</span></th>
                        <th class="text-center">Subpratender</th>
                        <th class="text-center">Pratender</th>
                        <th class="text-center">No PR</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Latest Activity</th>
                        <th class="text-center">Purchase Group</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                      </tr>
                      <tr>
                        <th> </th>
                        <th><input type="text" class="col-xs-12"></th>
                        <th><input type="text" class="col-xs-12"></th>
                        <th><input type="text" class="col-xs-12"></th>
                        <th><input type="text" class="col-xs-12"></th>
                        <th><input type="text" class="col-xs-12"></th>
                        <th><input type="text" class="col-xs-12"></th>
                        <th><input type="text" class="col-xs-12"></th>
                        <th></th>
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
    </div >
  </div >
</section>
