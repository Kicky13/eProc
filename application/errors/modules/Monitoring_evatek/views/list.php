
<section class="content_section">
  <div class="content_spacer">
    <div class="content">
      <div class="main_title centered upper">
        <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
      </div>
      <div class="row">
        <div class="row "> 
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
            <div class="table-responsive">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <table id="tbl_monitoring_evatek" class="table table-striped">
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

  <div class="modal fade" id="modalitemstatus">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Item Status</h4>
        </div>
        <div class="modal-body">
          <div class="panel panel-default">
            <table class="table table-striped">
              <thead>
                <th>Item Material</th>
                <th>Status</th>
              </thead>
              <tbody id="tableitemstatus">
              </tbody>
            </table>
          </div>
          <div class="text-right">
            
          </div>
        </div>
      </div>
    </div>
  </div>
