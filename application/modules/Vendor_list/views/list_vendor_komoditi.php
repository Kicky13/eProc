
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="row "> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <!-- <div class="form-group">
                                <span class="label label-info">Filter Vendor Product</span>
                                <div class="col-sm-3">
                                    <select class="form-control set_product select2 alert" id="id_prod" name="id_prod">
                                        <option value=""> Pilih Product Type </option>
                                        <option value="1"> GOODS </option>
                                        <option value="2"> SERVICES </option>
                                        <option value="3"> GOODS AND SERVICES</option>
                                    </select>
                                </div>
                            </div>
                            <a href="<?=site_url('Vendor_list/get_vendor_exp')?>" target='_blank' style="float: right;" class="main_button color6 small_btn" id="idexcell">Export Excel&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-download-alt"></span></a> -->
                            <input type="hidden" name="list_vendor" id="list_vendor" value="list_vendor_komoditi">

                            <br>
                            <br>
                            <div class="panel panel-default">
                                <div class="panel-body" style="overflow: auto;" >
                                    <a id="" target="" href="javascript:exportKomoditi()" type="button" style="margin-right: 20px" class="printt btn btn-success pull-right" aria-label="Left Align" > Export

                                    </a>
                                    <table id="tbl_vendor_list_komoditi" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th><span class="invisible">a</span></th>
                                                
                                                <th class="text-center">Group Barang</th>
                                                <th class="text-center">Sub Group</th>
                                                <th class="text-center">Nama Produk</th>
                                                <th class="text-center">Merk</th>
                                                <th class="text-center">Sumber</th>
                                                <th class="text-center">Tipe</th>
                                                <th class="text-center">No. Agent</th>
                                                <th class="text-center">Sampai</th>

                                                <th class="text-center col-md-1">Vendor No</th>
                                                <th class="text-center col-md-4">Vendor Name</th>
                                                <th class="text-center col-md-4">Action</th>
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
            </div> 
        </div >
    </div >
</section>
