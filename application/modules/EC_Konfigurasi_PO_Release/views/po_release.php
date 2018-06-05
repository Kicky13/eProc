<style>
	.datepicker{z-index:1151 !important;}
	.startDate{z-index:1151 !important;}
  .padding10px{padding: 5px;}
</style>
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="panel-group" id="accordion">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#search-po">Filter Search PO</a>
                          </h4>
                        </div>
                        <div id="search-po" class="panel-collapse collapse in">
                          <div class="panel-body">
                            <div class="row padding10px">
                              <div class="col-sm-2 col-md-2 col-lg-2">
                                Purc. Organization
                              </div>
                              <div class="col-sm-10 col-md-10 col-lg-10">
                                <select id="selOrganization" class="selectpicker" data-live-search="true" title="Pilih Purc. Organization...">
                                  <option>a</option>
                                  <option>b</option>
                                  <option>aa</option>
                                  <option>bc</option>
                                  <option>bcv</option>
                                </select>
                              </div>
                            </div>
                            <div class="row padding10px">
                              <div class="col-sm-2 col-md-2 col-lg-2">
                                Purc. Group
                              </div>
                              <div class="col-sm-10 col-md-10 col-lg-10">
                                <select id="selGroupn" class="selectpicker" data-live-search="true" title="Pilih Purc. Group...">
                                  <option>a</option>
                                  <option>b</option>
                                  <option>aa</option>
                                  <option>bc</option>
                                  <option>bcv</option>
                                </select>
                              </div>
                            </div>
                            <div class="row padding10px">
                              <div class="col-sm-2 col-md-2 col-lg-2">
                                Document Type
                              </div>
                              <div class="col-sm-10 col-md-10 col-lg-10">
                                <select id="selDocType" class="selectpicker" data-live-search="true" title="Pilih Document Type...">
                                  <option>a</option>
                                  <option>b</option>
                                  <option>aa</option>
                                  <option>bc</option>
                                  <option>bcv</option>
                                </select>
                              </div>
                            </div>
                            <div class="row padding10px">
                              <div class="col-sm-2 col-md-2 col-lg-2">
                                Document Date
                              </div>
                              <div class="col-sm-2 col-md-2col-lg-2">
                                <div class="form-group">
                                    <div class="input-group date"><input readonly id="docdate" type="text" class="form-control" ><span class="input-group-addon"><a href="javascript:void(0)"><i class="glyphicon glyphicon-calendar"></i></a></span></div>
                                </div>
                              </div>
                            </div>
                            <div class="row padding10px">
                              <div class="col-sm-2 col-md-2 col-lg-2">
                                Vendor
                              </div>
                              <div class="col-sm-10 col-md-10 col-lg-10">
                                <select id="selVendor" class="selectpicker" data-live-search="true" title="Pilih Vendor...">
                                  <option>a</option>
                                  <option>b</option>
                                  <option>aa</option>
                                  <option>bc</option>
                                  <option>bcv</option>
                                </select>
                              </div>
                            </div>
                            <div class="row padding10px">
                              <div class="col-sm-2 col-md-2 col-lg-2">
                                
                              </div>
                              <div class="col-sm-10 col-md-10 col-lg-10">
                                <button type="button" id="" class="btn btn-danger">Search</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>    					
                </div>
            </div> 
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title">List PO</h3>
                    </div>
                    <div class="panel-body">
                      <button type="button" id="" class="btn btn-info pull-right">Share PO</button><br><br>
                      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <table id="tableMT" class="table table-striped">
                          <thead>
                            <tr>
                              <th class="text-center ts0"><a href="javascript:void(0)">Vendor</a></th>
                              <th class="text-center ts1"><a href="javascript:void(0)">PO Number</a></th>
                              <th class="text-center ts2"><a href="javascript:void(0)">Purc. Organization</a></th>
                              <th class="text-center ts3"><a href="javascript:void(0)">Purc. Group</a></th>
                              <th class="text-center ts4"><a href="javascript:void(0)">Document Type</a></th>
                              <th class="text-center ts5"><a href="javascript:void(0)">Document Date</th>
                              <th class="text-center">Share PO</th>
                            </tr>
                            <tr>
                              <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
                              <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
                              <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
                              <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
                              <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>  
                              <th><input type="text" class="col-xs-10 col-xs-offset-1 srch"></th>
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
        </div>
    </div>
</section>