
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <br/>
                <div class="row">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a class="tab1" href="#pajak" aria-controls="pajak" role="tab" data-toggle="tab">Pajak</a></li>
                        <li role="presentation"><a class="tab2" href="#denda" aria-controls="denda" role="tab" data-toggle="tab">Denda</a></li>
                        <li role="presentation"><a class="tab3" href="#dokumen" aria-controls="dokumen" role="tab" data-toggle="tab">Dokumen Tambahan</a></li>
                        <li role="presentation"><a class="tab4" href="#doctype" aria-controls="doctype" role="tab" data-toggle="tab">Doc. Type</a></li>
                        <li role="presentation"><a class="tab5" href="#payblock" aria-controls="payblock" role="tab" data-toggle="tab">Payment Block</a></li>
                        <li role="presentation"><a class="tab6" href="#paymeth" aria-controls="paymeth" role="tab" data-toggle="tab">Payment Method</a></li>
                        <li role="presentation"><a class="tab7" href="#userrole" aria-controls="userrole" role="tab" data-toggle="tab">User Role</a></li>
                        <li role="presentation"><a class="tab8" href="#usermapping" aria-controls="usermapping" role="tab" data-toggle="tab">Mapping User</a></li>
                        <li role="presentation"><a class="tab9" href="#invoiceplant" aria-controls="invoiceplant" role="tab" data-toggle="tab">Invoice Plant</a></li>
                        <li role="presentation"><a class="tab10" href="#purchasinggroup" aria-controls="purchasinggroup" role="tab" data-toggle="tab">Purchasing Group</a></li>
                        <li role="presentation"><a class="tab11" href="#rangePO" aria-controls="rangePO" role="tab" data-toggle="tab">Range PO</a></li>
                        <li role="presentation"><a class="tab12" href="#roleGR" aria-controls="roleGR" role="tab" data-toggle="tab">Role Approval GR</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="pajak">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">
                                <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="row" style="border-bottom: 1px solid #ccc;">
                                        <br>
                                        <a href="<?php echo base_url('EC_Master_invoice/sapTax') ?>" type="button" style="margin-right: 20px" class="btn btn-info pjk btn-sm pull-right">
                                            Sync SAP
                                        </a>
                                        <br>
                                        <br>

                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <table id="tableMT" class="table table-striped nowrap" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center ts0"><strong>Kode Tax</strong></th>
                                                        <th class="text-center ts0"><strong>Deskripsi</strong></th>
                                                        <th class="text-center ts1"><strong>Publish</strong></th>
                                                        <!-- <th class="text-center ts2"><a href="javascript:void(0)">Edit</a></th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($i = 0; $i < sizeof($pajak); $i++) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $pajak[$i]['ID_JENIS'] ?></td>
                                                            <td class="text-center"><?php echo $pajak[$i]['JENIS'] ?></td>
                                                            <td class="text-center"><input type="checkbox" <?php echo $pajak[$i]['STATUS'] == "1" ? "checked" : "" ?> onclick="setPublished(this, '<?php echo $pajak[$i]['ID_JENIS'] ?>', 'EC_M_PAJAK_INV')" /></td>
                                                            <!-- <td class="text-center"><a href="javascript:void(0)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td> -->
                                                        </tr>
                                                        <?php }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="denda">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">
                                <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="row" style="border-bottom: 1px solid #ccc;">
                                        <br>
                                        <button type="button"style="margin-right: 20px" data-toggle="modal" data-target="#dendaBaru"  class="btn btn-success btn-sm pull-right">
                                            Tambah
                                        </button>
                                        <br>
                                        <br>

                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <table id="tableMT" class="table table-striped nowrap" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center ts0"><strong>Jenis</strong></th>
                                                    <th class="text-center ts1"><strong>GL Account</strong></th>
                                                    <th class="text-center ts1"><sttrong>Direct Action</sttrong></th>
                                            <th class="text-center ts1"><strong>Publish</strong></th>
                                            <th class="text-center ts2"><strong>Edit</strong></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php for ($i = 0; $i < sizeof($denda); $i++) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $denda[$i]['JENIS'] ?></td>
                                                        <td class="text-center"><?php echo $denda[$i]['GL_ACCOUNT'] ?></td>
                                                        <td class="text-center"><?php echo $denda[$i]['DIRECT_ACTION'] ?></td>
                                                        <td class="text-center"><input onclick="setPublished(this, '<?php echo $denda[$i]['ID_JENIS'] ?>', 'EC_M_DENDA_INV')" type="checkbox" <?php echo $denda[$i]['STATUS'] == "1" ? "checked" : "" ?> /></td>
                                                        <td class="text-center"><a href="javascript:void(0)" data-toggle="modal" data-target="#EditdendaBaru" data-jenis="<?php echo $denda[$i]['JENIS'] ?>" data-gl="<?php echo $denda[$i]['GL_ACCOUNT'] ?>" data-direct="<?php echo $denda[$i]['DIRECT_ACTION'] ?>" data-iddenda="<?php echo $denda[$i]['ID_JENIS'] ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
                                                    </tr>
                                                    <?php }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="dokumen">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">
                                <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="row" style="border-bottom: 1px solid #ccc;">
                                        <br>
                                        <button type="button"style="margin-right: 20px" data-toggle="modal" data-target="#docBaru" class="btn btn-success btn-sm pull-right">
                                            Tambah
                                        </button>
                                        <br>
                                        <br>

                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <table id="tableMT" class="table table-striped nowrap" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center ts0"><strong>Jenis</strong></th>
                                                    <th class="text-center ts1"><strong>Publish</strong></th>
                                                    <th class="text-center ts2"><strong>Edit</strong></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php for ($i = 0; $i < sizeof($doc); $i++) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $doc[$i]['JENIS'] ?></td>
                                                        <td class="text-center"><input onclick="setPublished(this, '<?php echo $doc[$i]['ID_JENIS'] ?>', 'EC_M_DOC_INV')" type="checkbox" <?php echo $doc[$i]['STATUS'] == "1" ? "checked" : "" ?> /></td>
                                                        <td class="text-center"><a href="javascript:void(0)" data-toggle="modal" data-target="#editdocBaru" data-jenis="<?php echo $doc[$i]['JENIS'] ?>" data-docid="<?php echo $doc[$i]['ID_JENIS'] ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
                                                    </tr>
                                                    <?php }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="doctype">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">
                                <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="row" style="border-bottom: 1px solid #ccc;">
                                        <br>
                                        <a href="<?php echo base_url('EC_Master_invoice/sapDoctype') ?>" type="button" style="margin-right: 20px" class="btn btn-info pjk btn-sm pull-right">
                                            Sync SAP
                                        </a>
                                        <br>
                                        <br>

                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <table id="tableMT" class="table table-striped nowrap" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center ts0"><strong>Jenis</strong></th>
                                                    <th class="text-center ts1"><strong>Deskripsi</strong></th>
                                                    <th class="text-center ts1"><strong>Publish</strong></th>
                                                    <!-- <th class="text-center ts2"><a href="javascript:void(0)">Edit</a></th>  -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php for ($i = 0; $i < sizeof($doctype); $i++) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $doctype[$i]['DOC_TYPE'] ?></td>
                                                        <td class="text-center"><?php echo $doctype[$i]['DOC_DESC'] ?></td>
                                                        <td class="text-center"><input onclick="setPublished(this, '<?php echo $doctype[$i]['ID_DOCTYPE'] ?>', 'EC_M_DOC_TYPE')" type="checkbox" <?php echo $doctype[$i]['STATUS'] == "1" ? "checked" : "" ?> /></td>
                                                        <!-- <td class="text-center"><a href="javascript:void(0)" data-toggle="modal" data-target="#editdocBaru" data-jenis="<?php echo $doc[$i]['JENIS'] ?>" data-docid="<?php echo $doc[$i]['ID_JENIS'] ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td> -->
                                                    </tr>
                                                    <?php }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="payblock">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">
                                <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="row" style="border-bottom: 1px solid #ccc;">
                                        <br>
                                        <a href="<?php echo base_url('EC_Master_invoice/sapPayblock') ?>" type="button" style="margin-right: 20px" class="btn btn-info pjk btn-sm pull-right">
                                            Sync SAP
                                        </a>
                                        <br>
                                        <br>

                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <table id="tableMT" class="table table-striped nowrap" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center ts0"><strong>Kode</strong></th>
                                                        <th class="text-center ts0"><strong>Deskripsi</strong></th>
                                                        <th class="text-center ts1"><strong>Publish</strong></th>
                                                        <!-- <th class="text-center ts2"><a href="javascript:void(0)">Edit</a></th>  -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($i = 0; $i < sizeof($payblock); $i++) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $payblock[$i]['PB_TYPE'] ?></td>
                                                            <td class="text-center"><?php echo $payblock[$i]['PB_DESC'] ?></td>
                                                            <td class="text-center"><input onclick="setPublished(this, '<?php echo $payblock[$i]['ID_PB'] ?>', 'EC_M_PAY_BLOCK')" type="checkbox" <?php echo $payblock[$i]['STATUS'] == "1" ? "checked" : "" ?> /></td>
                                                            <!-- <td class="text-center"><a href="javascript:void(0)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td> -->
                                                        </tr>
                                                        <?php }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="paymeth">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">
                                <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="row" style="border-bottom: 1px solid #ccc;">
                                        <br>
                                        <a href="<?php echo base_url('EC_Master_invoice/sapPaymeth') ?>" type="button" style="margin-right: 20px" class="btn btn-info pjk btn-sm pull-right">
                                            Sync SAP
                                        </a>
                                        <br>
                                        <br>

                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <table id="tableMT" class="table table-striped nowrap" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center ts0"><strong>Kode</strong></th>
                                                        <th class="text-center ts0"><strong>Deskripsi</strong></th>
                                                        <th class="text-center ts1"><strong>Publish</strong></th>
                                                        <!-- <th class="text-center ts2"><a href="javascript:void(0)">Edit</a></th>  -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($i = 0; $i < sizeof($paymeth); $i++) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $paymeth[$i]['PM_TYPE'] ?></td>
                                                            <td class="text-center"><?php echo $paymeth[$i]['PM_DESC'] ?></td>
                                                            <td class="text-center"><input onclick="setPublished(this, '<?php echo $paymeth[$i]['ID_PM'] ?>', 'EC_M_PAY_METHOD')" type="checkbox" <?php echo $paymeth[$i]['STATUS'] == "1" ? "checked" : "" ?> /></td>
                                                            <!-- <td class="text-center"><a href="javascript:void(0)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td> -->
                                                        </tr>
                                                        <?php }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="userrole">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">
                                <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="row" style="border-bottom: 1px solid #ccc;">
                                        <br>
                                        <button type="button"style="margin-right: 20px" data-toggle="modal" data-target="#UserRoleBaru" class="btn btn-success btn-sm pull-right">
                                            Tambah
                                        </button>
                                        <br>
                                        <br>

                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <table id="tableMT" class="table table-striped nowrap" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center ts0"><strong>No</strong></th>
                                                        <th class="text-center ts2"><strong>Username</strong></th>
                                                        <th class="text-center ts3"><strong>Role</strong></th>
                                                        <th class="text-center ts4"><strong>Status</strong></th>
                                                        <th class="text-center ts5"><strong>Aksi</strong></th>
                                                        <!-- <th class="text-center ts2"><a href="javascript:void(0)">Edit</a></th>  -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($i = 0; $i < sizeof($userrole); $i++) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"> <?php echo $i+1?></td>
                                                            <td class="text-center"><?php echo $userrole[$i]['USERNAME'] ?></td>
                                                            <td class="text-center" data-db="<?php echo $userrole[$i]['ROLE_AS'] ?>"><?php echo $userrole[$i]['ROLE_AS'] ?></td>
                                                            <td class="text-center" data-db="<?php echo $userrole[$i]['STATUS'] ?>"><?php
                                                                if($userrole[$i]['STATUS'] == 1){
                                                                    echo "ACTIVE";
                                                                }else{
                                                                    echo "NON ACTIVE";
                                                                }
                                                             ?></td>
                                                            <td class="text-center">
                                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#UserRoleUpdate" data-jenis="<?php echo $userrole[$i]['ID'] ?>" data-docid="<?php echo $userrole[$i]['ID'] ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                                            <a href="<?php echo 'EC_Master_invoice/UserRoleDelete/'.$userrole[$i]['ID'];?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                                            </td>
                                                            <!-- <td class="text-center"><a href="javascript:void(0)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td> -->
                                                        </tr>
                                                        <?php }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="usermapping">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">
                                <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="row" style="border-bottom: 1px solid #ccc;">
                                        <br>
                                        <button type="button"style="margin-right: 20px" data-toggle="modal" data-target="#userMappingBaru" class="btn btn-success btn-sm pull-right">
                                            Tambah
                                        </button>
                                        <br>
                                        <br>

                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <table id="tableMT" class="table table-striped nowrap" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center ts0"><strong>No</strong></th>
                                                        <th class="text-center ts1"><strong>Email</strong></th>
                                                        <th class="text-center ts2"><strong>Nama</strong></th>
                                                        <th class="text-center ts3"><strong>ID SAP</strong></th>
                                                        <th class="text-center ts4"><strong>Aksi</strong></th>
                                                        <!-- <th class="text-center ts2"><a href="javascript:void(0)">Edit</a></th>  -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($i = 0; $i < sizeof($usermapping); $i++) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"> <?php echo $i+1?></td>
                                                            <td class="text-center" data-db="<?php echo $usermapping[$i]['EMAIL1'] ?>"><?php echo $usermapping[$i]['EMAIL1'] ?></td>
                                                            <td class="text-center" data-db="<?php echo $usermapping[$i]['EMPLOYEE']?>"><?php echo $usermapping[$i]['EMPLOYEE'] ?></td>
                                                            <td class="text-center" data-db="<?php echo $usermapping[$i]['ID_SAP'] ?>"><?php echo $usermapping[$i]['ID_SAP'] ?></td>
                                                            <td class="text-center">
                                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#userMappingUpdate" data-jenis="<?php echo $usermapping[$i]['EMAIL1'] ?>" data-docid="<?php echo $usermapping[$i]['EMAIL1'] ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                                            <a href="#" data-email="<?php echo $usermapping[$i]['EMAIL1'] ?>" onclick="deleteMapping(this)"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                                            </td>
                                                            <!-- <td class="text-center"><a href="javascript:void(0)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td> -->
                                                        </tr>
                                                        <?php }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="invoiceplant">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">
                                <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="row" style="border-bottom: 1px solid #ccc;">
                                        <br>
                                        <button type="button"style="margin-right: 20px" data-toggle="modal" data-target="#invoicePlantForm" class="btn btn-success btn-sm pull-right">
                                            Tambah
                                        </button>
                                        <br>
                                        <br>

                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <table id="tableinvoicePlant" class="table table-striped nowrap" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center ts0"><strong>Plant</strong></th>
                                                        <th class="text-center ts1"><strong>Status</strong></th>
                                                        <th class="text-center ts2"><strong>Create Date</strong></th>
                                                        <th class="text-center ts3"><strong>Create By</strong></th>
                                                        <th class="text-center ts4"><strong>Aksi</strong></th>
                                                        <!-- <th class="text-center ts2"><a href="javascript:void(0)">Edit</a></th>  -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($i = 0; $i < sizeof($invoicePlant); $i++) {
                                                        ?>
                                                        <tr>
                                                            <td class="plant text-center" data-db="<?php echo $invoicePlant[$i]['PLANT'] ?>"><?php echo $invoicePlant[$i]['PLANT']  ?></td>
                                                            <td class="status text-center" data-db="<?php echo $invoicePlant[$i]['STATUS']?>"><?php echo $invoicePlant[$i]['STATUS'] ? 'AKTIF' : 'NON AKTIF' ?></td>
                                                            <td class="text-center" data-db="<?php echo $invoicePlant[$i]['CREATE_DATE'] ?>"><?php echo $invoicePlant[$i]['CREATE_DATE'] ?></td>
                                                            <td class="text-center" data-db="<?php echo $invoicePlant[$i]['CREATE_BY'] ?>"><?php echo $invoicePlant[$i]['CREATE_BY'] ?></td>
                                                            <td class="action text-center">
                                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#invoicePlantForm" data-status="<?php echo $invoicePlant[$i]['STATUS'] ?>" data-plant="<?php echo $invoicePlant[$i]['PLANT'] ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                                            <a href="#" data-plant="<?php echo $invoicePlant[$i]['PLANT'] ?>" onclick="deleteInvoicePlant(this)"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                                            </td>
                                                            <!-- <td class="text-center"><a href="javascript:void(0)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td> -->
                                                        </tr>
                                                        <?php }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div role="tabpanel" class="tab-pane" id="purchasinggroup">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">
                                <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="row" style="border-bottom: 1px solid #ccc;">
                                        <br>
                                        <button type="button"style="margin-right: 20px" data-toggle="modal" data-target="#purchasingGroupForm" class="btn btn-success btn-sm pull-right">
                                            Tambah
                                        </button>
                                        <br>
                                        <br>

                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <table id="tablepurchasinggroup" class="table table-striped nowrap" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center ts0"><strong>Purchasing Group</strong></th>
                                                        <th class="text-center ts1"><strong>Description</strong></th>
                                                        <th class="text-center ts4"><strong>Aksi</strong></th>
                                                        <!-- <th class="text-center ts2"><a href="javascript:void(0)">Edit</a></th>  -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($i = 0; $i < sizeof($purchasingGroup); $i++) {
                                                        ?>
                                                        <tr>
                                                            <td class="prchgrp text-center" data-db="<?php echo $purchasingGroup[$i]['PRCHGRP'] ?>" ><?php echo $purchasingGroup[$i]['PRCHGRP']  ?></td>
                                                            <td class="desc text-center"><?php echo $purchasingGroup[$i]['DESCRIPTION']?></td>
                                                            <td class="action text-center">
                                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#purchasingGroupForm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                                            <a href="javascript:void(0)" data-prchgrp="<?php echo $purchasingGroup[$i]['PRCHGRP'] ?>" onclick="deletePurchasingGroup(this)"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                                            </td>
                                                            <!-- <td class="text-center"><a href="javascript:void(0)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td> -->
                                                        </tr>
                                                        <?php }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                         <div role="tabpanel" class="tab-pane" id="rangePO">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">
                                <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="row" style="border-bottom: 1px solid #ccc;">
                                        <br>
                                        <button type="button"style="margin-right: 20px" onclick="tambahRPO()" class="btn btn-success btn-sm pull-right">
                                            Tambah
                                        </button>
                                        <br>
                                        <br>

                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <table id="tabelrangePO" class="table table-striped nowrap" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center ts0"><strong>Start Range</strong></th>
                                                        <th class="text-center ts1"><strong>End Range</strong></th>
                                                        <th class="text-center ts4"><strong>Status</strong></th>
                                                        <th class="text-center ts4"><strong>Aksi</strong></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($i = 0; $i < sizeof($rangePO); $i++) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center a"><?php echo $rangePO[$i]['START_RANGE']  ?></td>
                                                            <td class="text-center b"><?php echo $rangePO[$i]['END_RANGE']?></td>
                                                            <td class="text-center c" ><?php echo $rangePO[$i]['STATUS'] == 1 ? 'AKTIF' : 'TIDAK AKTIF'?></td>
                                                            <td class="action text-center">
                                                            <a href="javascript:void(0)" data-start="<?php echo $rangePO[$i]['START_RANGE'] ?>" data-end="<?php echo $rangePO[$i]['END_RANGE'] ?>" data-status="<?php echo $rangePO[$i]['STATUS'] ?>" onClick="updatePO(this)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                                            <a href="javascript:void(0)" data-rpo="<?php echo $rangePO[$i]['START_RANGE'] ?>" onclick="deleteRPO(this)"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                                            </td>
                                                        </tr>
                                                        <?php }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div role="tabpanel" class="tab-pane" id="roleGR">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #ccc; border-right: 1px solid #ccc; border-left: 1px solid #ccc;">
                                <div class="panel-group skrol" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="row" style="border-bottom: 1px solid #ccc;">
                                        <br>
                                        <button type="button" style="margin-right: 20px" onclick="tambahRoleGR()" class="btn btn-success btn-sm pull-right">
                                            Tambah
                                        </button>
                                        <br>
                                        <br>

                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <table id="tabelRoleGR" class="table table-striped nowrap" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center ts0"><strong>User AD</strong></th>
                                                        <th class="text-center ts1"><strong>User SAP</strong></th>
                                                        <th class="text-center ts4"><strong>Status</strong></th>
                                                        <th class="text-center ts4"><strong>Aksi</strong></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($i = 0; $i < sizeof($roleGR); $i++) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center a"><?php echo $roleGR[$i]['USERNAME']  ?></td>
                                                            <td class="text-center b"><?php echo $roleGR[$i]['ACCESS']?></td>
                                                            <td class="text-center c" ><?php echo $roleGR[$i]['STATUS'] == 1 ? 'AKTIF' : 'TIDAK AKTIF'?></td>
                                                            <td class="action text-center">
                                                            <a href="javascript:void(0)" data-username="<?php echo $roleGR[$i]['USERNAME'] ?>" data-access="<?php echo $roleGR[$i]['ACCESS'] ?>" data-status="<?php echo $roleGR[$i]['STATUS'] ?>" onClick="updateRoleGR(this)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                                            <a href="javascript:void(0)" data-username="<?php echo $roleGR[$i]['USERNAME'] ?>" data-access="<?php echo $roleGR[$i]['ACCESS'] ?>" access="<?php echo $roleGR[$i]['STATUS'] ?>" onclick="deleteRoleGR(this)"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                                            </td>
                                                        </tr>
                                                        <?php }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <br><br>
            </div>
        </div >
    </div >
</section>

<div class="modal fade" id="pajakBaru">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Tambah Master Pajak Baru</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-11 col-md-offset-1">
                        <form class="form-horizontal" action="<?php echo base_url() ?>EC_Master_invoice/pajakBaru" method="post">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Jenis</label>
                                <div class="col-sm-8 upl">
                                    <input type="text" class="form-control" required="" name="jenis" id="inputEmail3" placeholder="VZ (PPN masukan 0%)">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="dendaBaru">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Tambah Master Danda</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-11 col-md-offset-1">
                        <form class="form-horizontal" action="<?php echo base_url() ?>EC_Master_invoice/dendaBaru" method="post">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Jenis</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="jenis" required="" id="inputEmail3" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-3 control-label">GL Account</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="glacc" required="" id="inputGl" placeholder="97000012">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-10">
                                    <div class="checkbox">
                                        <label>
                                            <input name="direct" onclick="setDirect(this)" type="checkbox"> Direct Amount
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="EditdendaBaru">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><strong><u>Edit Master Denda</u></strong></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						<form class="form-horizontal" action="<?php echo base_url()?>EC_Master_invoice/EditdendaBaru" method="post" onsubmit="return false">
						  <div class="form-group">
						  	<input type="hidden" id="ID_JENIS" name="ID_JENIS" />
						    <label for="inputEmail3" class="col-sm-3 control-label">Jenis</label>
						    <div class="col-sm-8">
						      <input type="text" class="form-control" name="jenis" required="" id="inputjenis" placeholder="">
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="inputPassword3" class="col-sm-3 control-label">GL Account</label>
						    <div class="col-sm-8">
						      <input type="text" class="form-control" name="glacc" required="" id="glAccount" placeholder="97000012">
						    </div>
						   </div>
						  <div class="form-group">
						    <div class="col-sm-offset-3 col-sm-10">
						      <div class="checkbox">
						        <label>
						          <input name="direct" onclick="setDirect2(this)" id="checkboxdenda" type="checkbox"> Direct Amount
						        </label>
						      </div>
						    </div>
						  </div>
						  <div class="form-group">
						    <div class="col-sm-offset-2 col-sm-10">
						      <span class="btn btn-primary" onclick="updateDenda(this)">Simpan</span>
						    </div>
						  </div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="docBaru">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Tambah Jenis Dokumen Baru</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-11 col-md-offset-1">
                        <form class="form-horizontal" action="<?php echo base_url() ?>EC_Master_invoice/docBaru" method="post">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Jenis</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="jenis" required="" id="inputEmail3" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="UserRoleBaru">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Tambah User Role Baru</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-11 col-md-offset-1">
                        <form class="form-horizontal" action="<?php echo base_url() ?>EC_Master_invoice/UserRoleBaru" method="post">
                            <div class="form-group">
                                <label for="username" class="col-sm-3 control-label">Username</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="username" required="" id="username" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role" class="col-sm-3 control-label">Role</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="role">

                                        <?php foreach ($mrole as $r) {
                                        echo "<option value='".$r['ROLE_AS']."'>".$r['DESCRIPTION']."</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role" class="col-sm-3 control-label">Status</label>
                                <div class="col-sm-8">
                                    <label><input type="checkbox" name="status" value="1">Aktif</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="UserRoleUpdate">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Ubah User Role</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-11 col-md-offset-1">
                        <form class="form-horizontal" action="<?php echo base_url() ?>EC_Master_invoice/UserRoleUpdate/" method="post">
                            <div class="form-group">
                                <label for="username" class="col-sm-3 control-label">Username</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="username" required="" id="username" placeholder="Username">
                                    <input type="hidden" class="form-control" name="id">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role" class="col-sm-3 control-label">Role</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="role">

                                        <?php foreach ($mrole as $r) {
                                        echo "<option value='".$r['ROLE_AS']."'>".$r['DESCRIPTION']."</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role" class="col-sm-3 control-label">Status</label>
                                <div class="col-sm-8">
                                    <label><input type="checkbox" name="status" value="1">Aktif</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Ubah</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="userMappingBaru">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Tambah Mapping User Baru</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-11 col-md-offset-1">
                        <form class="form-horizontal" action="<?php echo base_url() ?>EC_Master_invoice/UserMappingBaru" method="post" id="CreateMapping">
                            <div class="form-group">
                                <label for="username" class="col-sm-3 control-label">EMAIL</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control" name="email" required="" id="email" placeholder="EMAIL">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role" class="col-sm-3 control-label">NAMA</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="nama" required="" id="nama" placeholder="Nama Lengkap">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role" class="col-sm-3 control-label">ID SAP</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="id_sap" required="" id="id_sap" placeholder="ID SAP">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="userMappingUpdate">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Ubah Data Mapping</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-11 col-md-offset-1">
                        <form class="form-horizontal" action="<?php echo base_url() ?>EC_Master_invoice/UserMappingUpdate" method="post" id="CreateMapping">
                            <div class="form-group">
                                <label for="username" class="col-sm-3 control-label">EMAIL</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control" name="email" required="" id="email" placeholder="EMAIL" readonly="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role" class="col-sm-3 control-label">NAMA</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="nama" required="" id="nama" placeholder="Nama Lengkap">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role" class="col-sm-3 control-label">ID SAP</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="id_sap" required="" id="id_sap" placeholder="ID SAP">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Ubah</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="invoicePlantForm">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Plant Invoice</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-11 col-md-offset-1">
                        <form class="form-horizontal" action="<?php echo base_url() ?>EC_Master_invoice/simpanPlant" method="post">
                            <div class="form-group">
                                <label for="username" class="col-sm-3 control-label">Plant</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="plant" required="" placeholder="Plant" maxlength="4">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role" class="col-sm-3 control-label">Status</label>
                                <div class="col-sm-8">
                                  <div class="checkbox">
                                      <label>
                                          <input name="status_plant" type="checkbox"> Aktif
                                      </label>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="purchasingGroupForm">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Purchasing Group</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-11 col-md-offset-1">
                        <form class="form-horizontal" action="<?php echo base_url() ?>EC_Master_invoice/simpanPurchasing" method="post">
                            <div class="form-group">
                                <label for="prchgrp" class="col-sm-3 control-label">Purchasing Group</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="PRCHGRP" required onchange="setDescription(this)">
                                      <option value="">Pilih group</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-sm-3 control-label">Description</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="DESCRIPTION" required >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editdocBaru">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><strong><u>Edit Jenis Dokumen</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-11 col-md-offset-1">
                        <form class="form-horizontal" action="<?php echo base_url() ?>EC_Master_invoice/EditdocBaru" method="post">
                            <div class="form-group">
                                <input type="hidden" id="ID_DOC" name="ID_DOC">
                                <label for="inputEmail3" class="col-sm-3 control-label">Jenis</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="jenis" required="" id="DokumenType" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="rangePOFrom">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center" id='headerpo'><strong><u>Range PO</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-11 col-md-offset-1">
                        <form class="form-horizontal" action="<?php echo base_url() ?>EC_Master_invoice/simpanRangePO" method="post">
                            <div class="form-group">
                                <label for="description" class="col-sm-3 control-label">Start Range</label>
                                <div class="hide">
                                    <input type="text" value='' class="form-control" name="AKSI">
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" pattern="\d*" placeholder="0000000001" class="form-control" name="START_RANGE" maxlength="10">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-sm-3 control-label">End Range</label>
                                <div class="col-sm-8">
                                    <input type="text" required class="form-control" name="END_RANGE" placeholder="9999999999" type="text" pattern="\d*" maxlength="10">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role" class="col-sm-3 control-label">Status</label>
                                <div class="col-sm-8">
                                    <label><input type="checkbox" name="STATUS">Aktif</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="roleGRForm">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center" id='headerRoleGR'><strong><u>Role Approval GR</u></strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-11 col-md-offset-1">
                        <form class="form-horizontal" action="<?php echo base_url() ?>EC_Master_invoice/simpanRoleGR" method="post">
                            <div class="form-group">
                                <label for="description" class="col-sm-3 control-label">Username</label>
                                <div class="hide">
                                    <input type="text" value='' class="form-control" name="AKSI">
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" required placeholder="Username"  class="form-control" name="Username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-sm-3 control-label">Access</label>
                                <div class="col-sm-8">
                                    <input type="text" required placeholder="Access" class="form-control" name="Access" type="text" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role" class="col-sm-3 control-label">Status</label>
                                <div class="col-sm-8">
                                    <label><input type="checkbox" name="Status">Aktif</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>