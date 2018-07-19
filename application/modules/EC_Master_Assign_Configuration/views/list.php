<section class="content_section">
    <div class="content_spacer">
        <div class="content">

            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row" style="display: none;">
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addNew">Add Configuration</button>
            </div>
            <div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="accord-addConfig">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion1" href="#addConfig"
                               aria-expanded="true" aria-controls="addConfig">
                                Add Configuration
                            </a>
                        </h4>
                    </div>
                    <div id="addConfig" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="accord-addConfig">
                        <div class="panel-body">
                            <div class="row" style="padding: 5px;">
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    Select User Employee
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input type="hidden" name="ID_USER" id="ID_USER" value="">
                                    <input type="text" id="txt_Nama" name="txt_Nama" class="nama" value="" size="30" placeholder="Select User Employee">
                                </div>
                            </div>
                            <div class="row" style="padding: 5px;">
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    Progress Approval Level
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <input type="text" name="lvl" id="lvl" placeholder="Progress Approval Level">
                                </div>
                            </div>
                            <div class="row" style="padding: 5px;">
                                <div class="col-sm-3 col-md-3 col-lg-3">

                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <button type="button" class="btn btn-primary" onclick="simpan()">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="row">
                    <div id="Invoiced">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table id="table_inv" class="table table-striped nowrap" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center ts0"><a href="javascript:void(0)">ID User</a></th>
                                            <th class="text-center ts1"><a href="javascript:void(0)">Username</a></th>
                                            <th class="text-center ts2"><a href="javascript:void(0)">Progress Approval Level</a></th>
                                            <th class="text-center ts2"><a href="javascript:void(0)">Date Created</a></th>
                                            <th class="text-center ts3"><a href="javascript:void(0)">Aksi</a></th>
                                        </tr>
                                        <tr class="sear">
                                            <!-- <th></th> -->
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th><input type="text" class="col-xs-10 col-xs-offset-1 srch" style="margin: 0px"></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="text-center ts0"><a href="javascript:void(0)">ID User</td>
                                            <td class="text-center ts1"><a href="javascript:void(0)">Username</a></td>
                                            <td class="text-center ts2"><a href="javascript:void(0)">Progress Aproval Level</a></td>
                                            <td class="text-center ts3"><a href="javascript:void(0)">Date Created</a></td>
                                            <td class="text-center ts7">
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>
                                                <a href="javascript:void(0)"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="modalDetil">
    <div class="modal-dialog modal-md" style="width:75%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>View Master Approval</u></strong></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="costCenter" id="costCenter">
                <input type="hidden" name="viewUserid" id="viewUserid">
                <input type="hidden" name="viewId" id="viewId">
                <input type="hidden" name="setLvl" id="setLvl">
                <div class="row" style="padding: 5px;">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        Username
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group" id="modalbudget">
                            <select class="form-control CC2" name="viewusername" id="viewusername" style="width: 250px;">
                                <option value="0" selected="">Pilih Username</option>
                                <?php foreach ($EMP as $value){ ?>
                                    <option value="<?php echo $value['ID']; ?>"><?php echo $value['FULLNAME']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding: 5px;">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        Progress Approval Level
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type="text" name="viewlvl" id="viewlvl" placeholder="Progress Level Approval">
                    </div>
                </div>
                <div class="row" style="padding: 5px;">
                    <div class="col-sm-3 col-md-3 col-lg-3">

                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <button type="button" class="btn btn-primary pull-right" onclick="update()">Update Data</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addNew">
    <div class="modal-dialog modal-md" style="width:75%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Add Configuration</u></strong></h4>
            </div>
            <div class="modal-body" id="tambahBaru">

                <!-- <form class="form-inline" action="<?php //echo base_url(); ?>EC_Master_Approval/simpan" method="post"> -->
                <div class="row" style="padding: 5px;">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        Pilih Cost Center
                    </div>
                    <div class="col-lg-7">
                        <!-- <div class="row"> -->
                        <div class="form-group" id="">
                            <!-- <label for="exampleInputName2">UBAH COST CENTER:&nbsp;&nbsp;&nbsp;</label> -->
                            <select name="cc" id="cc" required="" class="form-control CCnew1" style="width: 350px;">
                                <!-- <?php //$ccp = ($ccc["COSTCENTER"] == null || $ccc["COSTCENTER"] == "") ? "" : $ccc["COSTCENTER"];
                                //if ($ccp == "") ?> -->
                                <option value="" selected="selected">Pilih Cost Center</option>
                                <?php foreach ($CC as $key => $value) { ?>
                                    <option value="<?php echo $value["COSTCENTER"]; ?>"> <?php echo $value["COSTCENTER"]; ?> &mdash; <?php echo $value["NAME"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- </div> -->
                    </div>
                </div>
                <div class="row" style="padding: 5px;">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        User Akses
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group" id="modalbudget">
                            <select class="form-control CCnew3" name="userakses" id="userakses" style="width: 250px;">
                                <option value="0" selected="">Pilih User Akses</option>
                                <option value="KA">User KA</option>
                                <option value="GUDANG">User Gudang</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding: 5px;">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        Value From
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type="text" name="valueFrom" id="valueFrom" placeholder="Value From">
                    </div>
                </div>
                <div class="row" style="padding: 5px;">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        Value To
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type="text" name="valueTo" id="valueTo" placeholder="Value To">
                    </div>
                </div>
                <div class="row" style="padding: 5px;">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        Progress CNF
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <input type="text" name="cnf" id="cnf" placeholder="Progress CNF">
                    </div>
                </div>
                <div class="row" style="padding: 5px;">
                    <div class="col-sm-3 col-md-3 col-lg-3">

                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <button type="button" class="btn btn-primary pull-right" onclick="simpan()">Simpan</button>
                    </div>
                </div>
                <!-- </form> -->

            </div>
        </div>
    </div>
</div>