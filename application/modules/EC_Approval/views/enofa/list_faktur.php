<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class='alert alert-info hide' id="msg"></div>
            <div class="row">
            <div class='col-lg-12'>
                <div class="col-lg-8">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a class="tab1" href="#Unreported" aria-controls="Unreported" role="tab" data-toggle="tab">Unreported</a></li>
                    <li role="presentation"><a class="tab2" href="#Reported" aria-controls="Reported" role="tab" data-toggle="tab">Reported</a></li>
                </ul>
                </div>
                <div class="col-lg-4">
                
                <a class='btn btn-success' data-company='<?php echo $company;?>' href='javascript:void(0)' onClick='downloadFaktur(this)' title='Laporkan Faktur'><span class='glyphicon glyphicon-download' aria-hidden='true'> List Faktur</span></a>
                <a class='btn btn-warning' data-company='<?php echo $company;?>' href='javascript:void(0)' onClick='downloadImage(this)' title='Laporkan Faktur'><span class='glyphicon glyphicon-download' aria-hidden='true'> Image Faktur</span></a>

                </div>
                <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="Unreported">
                    <div class="col-lg-12 table-responsive">
                    <table id="table_unreported" class="table table-striped table-responsive" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center"><a href="javascript:void(0)">No.</th>
                                <th class="text-center"><a href="javascript:void(0)">No. Faktur</a></th>
                                <th class="text-center"><a href="javascript:void(0)">Tanggal Faktur</a></th>
                                <th class="text-center"><a href="javascript:void(0)">No. Invoice</a></th>
                                <th class="text-center"><a href="javascript:void(0)">No. Mir7</a></th>
                                <th class="text-center"><a href="javascript:void(0)">Vendor</a></th>
                                <th class="text-center"><a href="javascript:void(0)">Amount</a></th>
                                <th class="text-center"><a href="javascript:void(0)">Approved On</a></th>
                                <th class="text-center"><a href="javascript:void(0)">Aksi</a></th>
                            </tr>
                        </thead>
                        <thead class='search-row' data-stat='0'>
                            <tr>
                                <th></th>
                                <th><input class="form-control input-sm search-input-text a" name='U_noFaktur' data-column="1" type="text"></th>
                                <th><input class="form-control input-sm search-input-text tgl U1" readonly="" name='U_tglFaktur' data-column="2" type="text"></th>
                                <th><input class="form-control input-sm search-input-text a" name='U_noInv' data-column="3" type="text"></th>
                                <th><input class="form-control input-sm search-input-text a" name='U_noMir' data-column="4" type="text"></th>
                                <th><input class="form-control input-sm search-input-text a" name='U_Vendor' data-column="5" type="text"></th>
                                <th><input class="form-control input-sm search-input-text a" name='U_Amount' data-column="6" type="text"></th>
                                <th><input class="form-control input-sm search-input-text tgl U2" readonly="" name='U_aprOn' data-column="7" type="text"></th>
                                <th style="width:125px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    </div>
                </div>


                <div role="tabpanel" class="tab-pane" id="Reported">
                    <div class="col-lg-12 table-responsive">
                    <table id="table_reported" class="table table-striped table-responsive" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center"><a href="javascript:void(0)">No.</th>
                                <th class="text-center"><a href="javascript:void(0)">No. Faktur</a></th>
                                <th class="text-center"><a href="javascript:void(0)">Tanggal Faktur</a></th>
                                <th class="text-center"><a href="javascript:void(0)">No. Invoice</a></th>
                                <th class="text-center"><a href="javascript:void(0)">No. Mir7</a></th>
                                <th class="text-center"><a href="javascript:void(0)">Vendor</a></th>
                                <th class="text-center"><a href="javascript:void(0)">Amount</a></th>
                                <th class="text-center"><a href="javascript:void(0)">Approved On</a></th>
                                <th class="text-center"><a href="javascript:void(0)">Aksi</a></th>
                            </tr>
                        </thead>
                        <thead class='search-row' data-stat='0'>
                            <tr >
                                <th></th>
                                <th><input class="form-control input-sm search-input-text b" name='R_noFaktur' data-column="1" type="text"></th>
                                <th><input class="form-control input-sm search-input-text tgl R1" name='R_tglFaktur' readonly="" data-column="2" type="date"></th>
                                <th><input class="form-control input-sm search-input-text b" name='R_noInv' data-column="3" type="text"></th>
                                <th><input class="form-control input-sm search-input-text b" name='R_noMir' data-column="4" type="text"></th>
                                <th><input class="form-control input-sm search-input-text b" name='R_Vendor' data-column="5" type="text"></th>
                                <th><input class="form-control input-sm search-input-text b" name='R_Amount' data-column="6" type="text"></th>
                                <th><input class="form-control input-sm search-input-text tgl R2" name='R_aprOn' readonly="" data-column="7" type="text"></th>
                                <th style="width:125px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    </div>
                </div>

                </div>
                </div>
                <br><br>
            </div>
        </div >
    </div >
</section>

<div id="detailFaktur" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail Faktur</h4>
      </div>
      <div class="modal-body">
        <table class="table table-responsive" id="header_data">
            <!--Filled By JS-->
        </table>
        <table class="table table-responsive" id="item_data">
            <!--Filled By JS-->
        </table>
      </div>
      <div class="modal-footer text-center">
      </div>
    </div>
  </div>
</div>