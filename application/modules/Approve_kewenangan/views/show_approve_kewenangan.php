
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <select id="select_pgrp" name="pgrp">
                                        <option value="">Pilih Purchasing Group</option>
                                        <?php foreach ($pgrp as $val): ?>
                                            <option value="<?php echo $val['PURCH_GRP_CODE'] ?>">
                                                <?php echo $val['PURCH_GRP_CODE'] ?> - <?php echo $val['PURCH_GRP_NAME'] ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <a href="#!" id="button_tambah" class="btn btn-success btn-block">Tambah</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <table class="table table-bordered">
                            <thead>
                                <th class="text-center">Urutan</th>
                                <th class="text-center">PGRP</th>
                                <th class="text-center">CAT</th>
                                <th class="text-center col-md-3">Pejabat</th>
                                <th class="text-center">Rel Code</th>
                                <th class="text-center">Rel Group</th>
                                <th class="text-center col-md-2">Batas Harga</th>
                                <th class="text-center">Description Jabatan</th>
                                <th class="text-center">Aksi</th>
                            </thead>
                            <tbody id="tabelnya">
                                <tr><td colspan="7">Tidak ada data.</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<form id="form_edit">
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="edit_modal_label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span class="fa fa-close"></span></button>
                    <h4 class="modal-title" id="edit_modal_label">Edit Persetujuan Kewenangan</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 hidden">
                            <input type="hidden" class="form-control" id="modal_edit_pgrp" name="edit_pgrp">
                            <input type="hidden" class="form-control" id="modal_edit_id" name="edit_id">
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Urutan</label>
                                <input type="text" class="form-control" id="modal_edit_urutan" name="edit_urutan">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label>Batas Harga</label>
                                <input type="text" class="form-control must_autonumeric" id="modal_edit_harga" name="edit_harga">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Employee</label>
                                <select id="modal_edit_employee" name="edit_employee">
                                    <option>Pilih Employee</option>
                                    <?php foreach ($emp as $val): ?>
                                        <option value="<?php echo $val['ID'] ?>">
                                            [<?php echo $val['NO_PEG'] ?>] <?php echo $val['FULLNAME'] ?> (<?php echo $val['EM_COMPANY'] ?>)
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description Jabatan</label>
                                <input type="text" class="form-control" id="modal_edit_jabatan" name="edit_jabatan">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Rel Code</label>
                                <input type="text" class="form-control" id="modal_edit_relcode" name="edit_relcode">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Rel Group</label>
                                <input type="text" class="form-control" id="modal_edit_relgrp" name="edit_relgrp">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Categori</label>
                                <select name="edit_cat_prc" id="modal_edit_catprc">
                                    <option value="">-Pilih Categori-</option>
                                    <option value="DC">Pemilihan Langsung</option>
                                    <option value="PL">Penunjukan Langsung</option>
                                    <option value="PO">PO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="save_edit">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="form_new">
    <div class="modal fade" id="new_modal" tabindex="-1" role="dialog" aria-labelledby="new_modal_label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span class="fa fa-close"></span></button>
                    <h4 class="modal-title" id="new_modal_label">Tambah Persetujuan Kewenangan</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 hidden">
                            <input type="hidden" class="form-control" id="modal_new_pgrp" name="new_pgrp">
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Urutan</label>
                                <input type="text" class="form-control" id="modal_new_urutan" name="new_urutan">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label>Batas Harga</label>
                                <input type="text" class="form-control must_autonumeric" id="modal_new_harga" name="new_harga">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Employee</label>
                                <select id="modal_new_employee" name="new_employee">
                                    <option>Pilih Employee</option>
                                    <?php foreach ($emp as $val): ?>
                                        <option value="<?php echo $val['ID'] ?>">
                                            [<?php echo $val['NO_PEG'] ?>] <?php echo $val['FULLNAME'] ?> (<?php echo $val['EM_COMPANY'] ?>)
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description Jabatan</label>
                                <input type="text" class="form-control" id="modal_new_jabatan" name="new_jabatan">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Rel Code</label>
                                <input type="text" class="form-control" id="modal_new_relcode" name="new_relcode">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Rel Group</label>
                                <input type="text" class="form-control" id="modal_new_relgrp" name="new_relgrp">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Categori</label>
                                <select name="new_cat_prc">
                                    <option value="">-Pilih Categori-</option>
                                    <option value="DC">Pemilihan Langsung</option>
                                    <option value="PL">Penunjukan Langsung</option>
                                    <option value="PO">PO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="save_new">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    var selectize_pgrp = null;
    var selectize_edit_employee = null;

    function numberWithCommas(x) {
        var parts = x.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
    }

    function editrow(x) {
        $("#edit_modal").modal('show');
        
        e = $(x);
        tr = e.parent().parent();
        $("#modal_edit_pgrp").val(tr.find(".pgrp").html());
        $("#modal_edit_urutan").val(tr.find(".urutan").html());
        $("#modal_edit_harga").val(tr.find(".batas_harga").html());
        $("#modal_edit_id").val(tr.find(".persetujuan_id").html());
        $("#modal_edit_relcode").val(tr.find(".relcode").html());
        $("#modal_edit_relgrp").val(tr.find(".relgrp").html());
        $("#modal_edit_catprc").val(tr.find(".cat").html());
        $("#modal_edit_jabatan").val(tr.find(".jabatan").html());
        selectize_edit_employee.setValue(tr.find(".emp_id").html());
    }

    function hapusrow(x) {        
        e = $(x);
        tr = e.parent().parent();
        idnya = tr.find(".persetujuan_id").html();
        if (confirm('Apakah anda yakin akan menghapus data?')) {
            $.ajax({
                url: $("#base-url").val() + 'Approve_kewenangan/delete',
                type: 'post',
                dataType: 'json',
                data: {hapus_id: idnya},
            })
            .done(function(data) {
                if (data.status == 'success') {
                    alert('Berhasil mengubah data.');
                }
            })
            .fail(function() {
                console.log("error");
            })
            .always(function(data) {
                // console.log(data);
                populate_table();
            });
            
        }
    }

    function populate_table() {
        pgrp = $("#select_pgrp").val(); 
        $.ajax({
            url: $("#base-url").val() + 'Approve_kewenangan/get_data/' + pgrp,
            type: 'GET',
            dataType: 'json',
        })
        .done(function(data) {
            tabelnya = data.adm_approve_kewenangan;
            if (tabelnya.length <= 0) {
                $("#tabelnya").html('<tr><td colspan="7">Tidak ada data.</td></tr>');
            } else {
                $("#tabelnya").html('');
                for (var i = 0; i < tabelnya.length; i++) {
                    v = tabelnya[i];
                    td = ''
                    td += '<td class="text-center urutan">' + v.URUTAN+'</td>';
                    td += '<td class="text-center pgrp">' + v.PGRP + '</td>';
                    td += '<td class="text-center cat">' + (v.PRC_STATUS == null ? '' : v.PRC_STATUS) + '</td>';
                    td += '<td class="hidden persetujuan_id">' + v.PERSETUJUAN_ID + '</td>';
                    td += '<td class="hidden emp_id">' + v.EMP_ID + '</td>';
                    td += '<td>[' + v.NO_PEG + '] ' + v.FULLNAME + '</td>';
                    td += '<td class="text-center relcode">' + (v.REL_CODE == null ? '' : v.REL_CODE) + '</td>';
                    td += '<td class="text-center relgrp">' + (v.REL_GRP == null ? '' : v.REL_GRP) + '</td>';
                    td += '<td class="text-right batas_harga">' + (v.BATAS_HARGA == null? '' : numberWithCommas(v.BATAS_HARGA)) + '</td>';
                    td += '<td class="text-center jabatan">' + (v.JABATAN == null ? '' : v.JABATAN) + '</td>';
                    td += '<td class="text-center"><a href="#!" class="btn btn-xs btn-primary" onclick="editrow(this)">Edit</a> &nbsp;<a href="#!" class="btn btn-xs btn-danger" onclick="hapusrow(this)">Hapus</a></td>';
                    $tr = $('<tr>').html(td)
                    $("#tabelnya").append($tr);
                };
            }
        })
        .fail(function() {
            console.log("error");
        })
        .always(function(data) {
            // console.log(data);
        });
    }

    $(document).ready(function() {
        /* Activate selectize */
        if ($("#select_pgrp").length > 0) {
            $select_pgrp = $("#select_pgrp").selectize();
            selectize_pgrp = $select_pgrp[0].selectize;
        }
        if ($("#modal_edit_employee").length > 0) {
            $modal_edit_employee = $("#modal_edit_employee").selectize();
            selectize_edit_employee = $modal_edit_employee[0].selectize;
        }
        if ($("#modal_new_employee").length > 0) {
            $modal_new_employee = $("#modal_new_employee").selectize();
            selectize_new_employee = $modal_new_employee[0].selectize;
        }
        //*/

        /* Activate autonumeric */
        $(".must_autonumeric").autoNumeric('init', {lZero: 'deny', mDec: 0});
        //*/

        $("#select_pgrp").change(function() {
            if ($(this).val() == '') {
                $("#tabelnya").html('<tr><td colspan="7">Tidak ada data.</td></tr>');
                return;
            }
            populate_table();
        });

        $("#save_edit").click(function() {
            if (!confirm('Apakah anda yakin mau mengubah data?')) {
                return;
            }
            $.ajax({
                url: $("#base-url").val() + 'Approve_kewenangan/edit',
                type: 'post',
                dataType: 'json',
                data: $("#form_edit").serialize(),
            })
            .done(function(data) {
                if (data.status == 'success') {
                    alert('Berhasil mengubah data.');
                }
            })
            .fail(function() {
                alert('Gagal mengubah data.');
            })
            .always(function(data) {
                // console.log(data);
                populate_table();
                $(".modal").modal('hide');
            });
        });

        $("#save_new").click(function() {
            $.ajax({
                url: $("#base-url").val() + 'Approve_kewenangan/add',
                type: 'post',
                dataType: 'json',
                data: $("#form_new").serialize(),
            })
            .done(function(data) {
                if (data.status == 'success') {
                    alert('Berhasil menambah data.');
                }
            })
            .fail(function() {
                alert('Gagal menambah data.');
            })
            .always(function(data) {
                // console.log(data);
                populate_table();
                $(".modal").modal('hide');
            });
        });

        $("#button_tambah").click(function() {
            pgrp = $("#select_pgrp").val();
            if (pgrp == '') {
                return;
            }
            $("#new_modal").modal('show');
            $("#modal_new_pgrp").val(pgrp);
        });
    });
</script>
