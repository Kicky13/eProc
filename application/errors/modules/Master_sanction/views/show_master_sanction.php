
<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="#!" id="button_tambah" class="btn btn-success btn-block">Tambah</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">

                    <div class="panel panel-default">
                        <table class="table table-bordered">
                            <thead>
                                <th class="text-center">No</th>
                                <th class="text-center">Category Name</th>
                                <th class="text-center col-md-4">Start Point</th>
                                <th class="text-center">End Point</th>
                                <th class="text-center">Duration</th>
                                <th class="text-center">Can be Invited</th>
                                <th class="text-center">Priority</th>
                                <th class="text-center">Aksi</th>
                            </thead>
                            <tbody id="tabelnya">
                            <?php if($perf): ?>
                                <?php foreach ($perf as $key => $per) {?>
                                    <tr>
                                        <td><?php echo $key+1 ?></td>
                                        <td class="f_category"><?php echo $per['CATEGORY_NAME'] ?></td>
                                        <td class="f_start"><?php echo $per['START_POINT'] ?></td>
                                        <td class="f_end"><?php echo $per['END_POINT'] ?></td>
                                        <td class="f_duration"><?php echo $per['DURATION'] ?></td>
                                        <td class="f_invited"><?php echo ($per['CAN_BE_INVITED'] == "Y") ? "Yes" : "No" ?></td>
                                        <td class="f_priority"><?php echo ($per['IS_PRIORITY'] == "Y") ? "Yes" : "No" ?></td>
                                        <input type="hidden" class="f_id" value="<?php echo $per['ID_CATEGORY'] ?>">
                                        <td class="text-center">
                                            <a href="#!" class="btn btn-primary" onclick="editrow(this)">Edit</a> &nbsp;
                                            <a href="#!" class="btn btn-danger" onclick="hapusrow(this)">Hapus</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php else: ?>
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
                    <h4 class="modal-title" id="edit_modal_label">Edit Performance Category</h4>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="id_hidden" name="category_id">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text" class="form-control" id="category_name_edit" name="category_name">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Start Point</label>
                                <input type="text" class="form-control" id="start_point_edit" name="start_point">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>End Point</label>
                                <input type="text" class="form-control" id="end_point_edit" name="end_point">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Punishment Duration</label>
                                <div class="input-group">
                                    <input type="text" class="form-control col-md-3" id="duration_edit" name="duration">
                                    <div class="input-group-addon">Hari</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <!-- <div class="form-group"> -->
                                <input type="checkbox" id="invited_edit" name="invited" value="Yes"> Can be Invited
                            <!-- </div> -->
                        </div>
                        <div class="col-md-12">
                            <!-- <div class="form-group"> -->
                                <input type="checkbox" id="priority_edit" name="priority" value="Yes"> Priority
                            <!-- </div> -->
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
                    <h4 class="modal-title" id="new_modal_label">Add Performance Category</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text" class="form-control" id="category_name" name="category_name">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Start Point</label>
                                <input type="text" class="form-control " id="start_point" name="start_point">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>End Point</label>
                                <input type="text" class="form-control " id="end_point" name="end_point">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                    <label>Punishment Duration</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control col-md-3" id="duration" name="duration">
                                        <div class="input-group-addon">Hari</div>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <!-- <div class="form-group"> -->
                                <input type="checkbox" id="invited" name="invited" value="Yes"> Can be Invited
                            <!-- </div> -->
                        </div>
                        <div class="col-md-12">
                            <!-- <div class="form-group"> -->
                                <input type="checkbox" id="priority" name="priority" value="Yes"> Priority
                            <!-- </div> -->
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
        $("#id_hidden").val(tr.find(".f_id").val());
        $("#category_name_edit").val(tr.find(".f_category").html());
        $("#start_point_edit").val(tr.find(".f_start").html());
        $("#end_point_edit").val(tr.find(".f_end").html());
        $("#duration_edit").val(tr.find(".f_duration").html());
        if (tr.find(".f_invited").html() == "Yes"){
            $("#invited_edit").attr('checked',true);    
        } else {
            $("#invited_edit").attr('checked',false);    
        }
        if (tr.find(".f_priority").html() =="Yes"){
            $("#priority_edit").attr('checked',true);    
        } else {
            $("#priority_edit").attr('checked',false);    
        }
        $("#category_id").val(tr.find(".f_id").html());
    }

    function hapusrow(x) {        
        e = $(x);
        tr = e.parent().parent();
        idnya = tr.find(".f_id").val();
        if (confirm('Apakah anda yakin akan menghapus data?')) {
            $.ajax({
                url: $("#base-url").val() + 'Master_sanction/delete',
                type: 'post',
                dataType: 'json',
                data: {hapus_id: idnya},
            })
            .done(function(data) {
                if (data.status == 'success') {
                    alert('Berhasil menghapus data.');
                }
                location.reload();
            })
        }
    }

    $(document).ready(function() {
        $("#save_edit").click(function() {
            if (!confirm('Apakah anda yakin mau mengubah data?')) {
                return;
            }
            console.log($("#form_edit").serialize());
            $.ajax({
                url: $("#base-url").val() + 'Master_sanction/edit',
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
                console.log(data);
                $(".modal").modal('hide');
            });
        });

        $("#save_new").click(function() {
            $.ajax({
                url: $("#base-url").val() + 'Master_sanction/add',
                type: 'post',
                dataType: 'json',
                data: $("#form_new").serialize(),
            })
            .done(function(data) {
                if (data.status == 'success') {
                    alert('Berhasil menambah data.');
                }
                location.reload();
            })
            .fail(function() {
                alert('Gagal menambah data.');
            })
            .always(function(data) {
                console.log(data);
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
