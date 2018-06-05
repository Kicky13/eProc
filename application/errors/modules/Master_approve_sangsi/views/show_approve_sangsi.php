
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
                                <div class="col-md-2">
                                    <a href="#!" id="button_tambah" class="btn btn-success btn-block">Tambah</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <table class="table table-bordered">
                            <thead>
                                <th class="text-center col-md-1">Urutan</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center col-md-4">Jabatan</th>
                                <th class="text-center">Aksi</th>
                            </thead>
                            <tbody id="tabelnya">
                            <?php  if($app): ?>
                                <?php foreach ($app as $key => $value) {?>
                                    <tr>
                                        <td class="urutan"><?php echo $value['URUTAN'] ?></td>
                                        <td class="hidden">
                                        <input type="hidden" class="emp_id" value="<?php echo $value['EMP_ID'] ?>">
                                        <input type="hidden" class="id" value="<?php echo $value['ID'] ?>">
                                        </td>
                                        <td><?php echo $value['NAMA'] ?></td>
                                        <td><?php echo $value['JABATAN'] ?></td>
                                        <td class="text-center">
                                            <a href="#!" class="btn btn-primary" onclick="editrow(this)">Edit</a> &nbsp;
                                            <a href="#!" class="btn btn-danger" onclick="hapusrow(this)">Hapus</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php  else: ?>
                                <tr><td colspan="7">Tidak ada data.</td></tr>
                            <?php endif ?>
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
                    <h4 class="modal-title" id="edit_modal_label">Edit Approve Adjustment</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Urutan</label>
                                <input type="text" class="form-control" id="modal_edit_urutan" name="edit_urutan">
                                <input type="hidden" class="form-control" id="modal_edit_id" name="edit_id">
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
                    <h4 class="modal-title" id="new_modal_label">Add Approve Adjustment</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Urutan</label>
                                <input type="text" class="form-control" id="modal_new_urutan" name="new_urutan">
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
        $("#modal_edit_urutan").val(tr.find(".urutan").html());
        $("#modal_edit_id").val(tr.find(".id").val());
        selectize_edit_employee.setValue(tr.find(".emp_id").val());
    }

    function hapusrow(x) {        
        e = $(x);
        tr = e.parent().parent();
        idnya = tr.find(".id").val();
        if (confirm('Apakah anda yakin akan menghapus data?')) {
            $.ajax({
                url: $("#base-url").val() + 'Master_approve_sangsi/delete',
                type: 'post',
                dataType: 'json',
                data: {hapus_id: idnya},
            })
            .done(function(data) {
                if (data.status == 'success') {
                    alert('Berhasil menghapus data.');
                    location.reload();
                }
            })
            .fail(function() {
                console.log("error");
            })
            .always(function(data) {
            });
            
        }
    }


    $(document).ready(function() {
        
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

        $("#save_edit").click(function() {
            if (!confirm('Apakah anda yakin mau mengubah data?')) {
                return;
            }
            $.ajax({
                url: $("#base-url").val() + 'Master_approve_sangsi/edit',
                type: 'post',
                dataType: 'json',
                data: $("#form_edit").serialize(),
            })
            .done(function(data) {
                if (data.status == 'success') {
                    alert('Berhasil mengubah data.');
                    location.reload();
                }
            })
            .fail(function() {
                alert('Gagal mengubah data.');
            })
            .always(function(data) {
                $(".modal").modal('hide');
            });
        });

        $("#save_new").click(function() {
            $.ajax({
                url: $("#base-url").val() + 'Master_approve_sangsi/add',
                type: 'post',
                dataType: 'json',
                data: $("#form_new").serialize(),
            })
            .done(function(data) {
                if (data.status == 'success') {
                    alert('Berhasil menambah data.');
                    location.reload();
                }
            })
            .fail(function() {
                alert('Gagal menambah data.');
            })
            .always(function(data) {
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
