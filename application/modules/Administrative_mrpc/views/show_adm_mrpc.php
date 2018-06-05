
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
                                    <a href="#" id="button_tambah" class="btn btn-success btn-block">Tambah</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table id="table_mrpc" class="table table-condensed table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="10%">MRPC</th>
                                        <th class="text-center" width="30%">Nama Plant</th>
                                        <th class="text-center">Pejabat</th>
                                        <th class="text-center">Eselon</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tabelnya">  
                                    <tr><td colspan="5">Tidak ada data.</td></tr>                             
                                </tbody>
                            </table>
                        </div>
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
                    <h4 class="modal-title" id="edit_modal_label">Edit Administrative MRPC</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 hidden">
                            <input type="hidden" class="form-control" id="modal_edit_id" name="edit_id">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>MRPC</label>
                                <input type="number" class="form-control" id="modal_edit_mrpc" name="mrpc" maxlength="3">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Eselon</label>
                                <input type="text" class="form-control" id="modal_edit_eselon" name="eselon">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Plant</label>
                                <select id="modal_edit_plant" name="plant">
                                    <option value="">Pilih Plant</option>
                                    <?php foreach ($plant as $val): ?>
                                        <option value="<?php echo $val['PLANT_CODE'] ?>">
                                            [<?php echo $val['PLANT_CODE'] ?>] <?php echo $val['PLANT_NAME'] ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Pejabat</label>
                                <select id="modal_edit_emp" name="emp">
                                    <option value="">Pilih Pejabat</option>
                                    <?php foreach ($emp as $val): ?>
                                        <option value="<?php echo $val['ID'] ?>">
                                            [<?php echo $val['ID'] ?>] <?php echo $val['FULLNAME'] ?>
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
                    <h4 class="modal-title" id="new_modal_label">Tambah Administrative MRPC</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>MRPC</label>
                                <input type="number" class="form-control" id="modal_new_mrpc" name="new_mrpc" maxlength="3">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Eselon</label>
                                <input type="text" class="form-control" id="modal_new_eselon" name="new_eselon">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Plant</label>
                                <select id="modal_new_plant" name="new_plant">
                                    <option value="">Pilih Plant</option>
                                    <?php foreach ($plant as $val): ?>
                                        <option value="<?php echo $val['PLANT_CODE'] ?>">
                                            [<?php echo $val['PLANT_CODE'] ?>] <?php echo $val['PLANT_NAME'] ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Pejabat</label>
                                <select id="modal_new_emp" name="new_emp">
                                    <option value="">Pilih Pejabat</option>
                                    <?php foreach ($emp as $val): ?>
                                        <option value="<?php echo $val['ID'] ?>">
                                            [<?php echo $val['ID'] ?>] <?php echo $val['FULLNAME'] ?>
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
    table_mrpc = null;
    function editrow(x) {
        $("#edit_modal").modal('show');
        
        e = $(x);
        tr = e.parent().parent();
        $("#modal_edit_id").val(tr.find(".id_adm").html());
        $("#modal_edit_mrpc").val(tr.find(".mrpc").html());
        $("#modal_edit_eselon").val(tr.find(".eselon").html());
        selectize_edit_plant.setValue(tr.find(".id_plant").html());
        selectize_edit_emp.setValue(tr.find(".id_emp").html());
    }
    function hapusrow(x) {        
        e = $(x);
        tr = e.parent().parent();
        idnya = tr.find(".id_adm").html();
        if (confirm('Apakah anda yakin akan menghapus data?')) {
            $.ajax({
                url: $("#base-url").val() + 'Administrative_mrpc/delete',
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
        $.ajax({
            url: $("#base-url").val() + 'Administrative_mrpc/get_data/',
            type: 'GET',
            dataType: 'json',
        })
        .done(function(data) {
            tabelnya = data.adm_mrpc;
            console.log(tabelnya);
            if (tabelnya.length <= 0) {
                $("#tabelnya").html('<tr><td colspan="7">Tidak ada data.</td></tr>');
            } else {
                $("#tabelnya").html('');
                for (var i = 0; i < tabelnya.length; i++) {
                    v = tabelnya[i];
                    console.log(v);
                    td = '';
                    td += '<td class="text-center mrpc">' + v.MRPC + '</td>';
                    td += '<td><span class="plant_name hidden">' + v.PLANT_NAME + '</span>['+v.PLANT+'] ' +v.PLANT_NAME+ '<span class="hidden id_plant">' + v.PLANT + '</span><span class="hidden id_adm">' + v.ID + '</span><span class="hidden id_emp">' + v.EMP_ID + '</span></td>';
                    td += '<td class="text-left fullname">' + v.FULLNAME + '</td>';
                    td += '<td class="text-center eselon">' + v.ESELON + '</td>';
                    td += '<td class="text-center"><a href="#!" class="btn btn-primary" onclick="editrow(this)">Edit</a> &nbsp;<a href="#!" class="btn btn-danger" onclick="hapusrow(this)">Hapus</a></td>';
                    $tr = $('<tr>').html(td)
                    $("#tabelnya").append($tr);
                };
                if (table_mrpc == null) {
                    table_mrpc = $('#table_mrpc').DataTable({
                        // "bSort": false,
                        "paging": false,
                        "scrollCollapse": true,
                        "scrollY": "500px",
                        "dom": 'frtip',
                    });
                }
            }
        })
        .fail(function() {
            console.log("error");
        })
        .always(function(data) {
        });
    }
    $(document).ready(function() {
        populate_table();
        if ($("#modal_new_plant").length > 0) {
            $modal_new_plant = $("#modal_new_plant").selectize();
            selectize_new_plant = $modal_new_plant[0].selectize;
        }
        if ($("#modal_new_emp").length > 0) {
            $modal_new_emp = $("#modal_new_emp").selectize();
            selectize_new_emp = $modal_new_emp[0].selectize;
        }
        if ($("#modal_edit_plant").length > 0) {
            $modal_edit_plant = $("#modal_edit_plant").selectize();
            selectize_edit_plant = $modal_edit_plant[0].selectize;
        }
        if ($("#modal_edit_emp").length > 0) {
            $modal_edit_emp = $("#modal_edit_emp").selectize();
            selectize_edit_emp = $modal_edit_emp[0].selectize;
        }

        $("#save_edit").click(function() {
            if (!confirm('Apakah anda yakin mau mengubah data?')) {
                return;
            }
            $.ajax({
                url: $("#base-url").val() + 'Administrative_mrpc/edit',
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
                populate_table();
                $(".modal").modal('hide');
            });
        });

        $("#save_new").click(function() {
            console.log($("#base-url").val());
            $.ajax({
                url: $("#base-url").val() + 'Administrative_mrpc/add',
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
            $("#new_modal").modal('show');
        });
    });
</script>
