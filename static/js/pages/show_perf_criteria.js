table_criteria = null;
function editrow(x) {
    $("#edit_modal").modal('show');
    e = $(x);
    tr = e.parent().parent();
        $("#modal_edit_id").val(tr.find(".id_criteria").html());
        $("#modal_edit_criteria_name").val(tr.find(".criteria_name").html());
        $("#modal_edit_criteria_detail").val(tr.find(".criteria_detail").html());
        $("#modal_edit_criteria_score").val(tr.find(".criteria_score").html());
        selectize_edit_criteria_trigger_by.setValue(tr.find(".criteria_trigger_by").html());
        selectize_edit_criteria_score_sign.setValue(tr.find(".criteria_score_sign").html());
        selectize_edit_t_or_v.setValue(tr.find(".t_or_v").html());
        selectize_edit_req_or_buyer.setValue(tr.find(".req_or_buyer").html());
        selectize_edit_special_sanction.setValue(tr.find(".id_special_sanction").html());
        selectize_edit_company.setValue(tr.find(".companyid").html());

    if ($(".criteria_trigger_by").html() == 0) {
        $("#modal_edit_criteria_name").prop('disabled', true);
        $("#modal_edit_criteria_detail").prop('disabled', true);

        $triger_by = $('#modal_edit_criteria_trigger_by').selectize();
        triger_by = $triger_by[0].selectize;
        triger_by.disable();

        $torv = $('#modal_edit_t_or_v').selectize();
        torv = $torv[0].selectize;
        torv.disable();

        $buyer = $('#modal_edit_req_or_buyer').selectize();
        buyer = $buyer[0].selectize;
        buyer.disable(); 

        $sanction = $('#modal_edit_special_sanction').selectize();
        sanction = $sanction[0].selectize;
        sanction.disable(); 

        $company = $('#modal_edit_company').selectize();
        company = $company[0].selectize;
        company.disable();
    }
}
function hapusrow(x) {
    e = $(x);
    tr = e.parent().parent();
    idnya = tr.find(".id_criteria").html();
    swal({
          title: 'Apakah anda yakin?',
          text: "Data akan dihapus!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Tidak, batal!',
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: false
        },function(confirm) {
            if(confirm){
                $.ajax({
                    url: $("#base-url").val() + 'Performance_criteria/delete',
                    type: 'post',
                    dataType: 'json',
                    data: {hapus_id: idnya},
                })
                .done(function(data) {
                    if (data.status == 'success') {
                        swal(
                            'Berhasil!',
                            'Data telah dihapus.',
                            'success'
                          );
                    } else {
                        swal(
                            'Gagal!',
                            'Data gagal dihapus.',
                            'error'
                          );
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
        });
}
function populate_table() {
    $.ajax({
        url: $("#base-url").val() + 'Performance_criteria/get_data/',
        type: 'GET',
        dataType: 'json',
    })
    .done(function(data) {
        tabelnya = data.vnd_perf_criteria;
        if (tabelnya.length <= 0) {
            $("#tabelnya").html('<tr><td colspan="7">Tidak ada data.</td></tr>');
        } else {
            $("#tabelnya").html('');
            for (var i = 0; i < tabelnya.length; i++) {
                v = tabelnya[i];
                // console.log(v);
                td = '';
                td += '<td class="companyid">' + v.COMPANYID + '</td>';
                td += '<td class="criteria_name">' + v.CRITERIA_NAME + '</td>';
                td += '<td class="criteria_detail">'; 
                    if(v.CRITERIA_DETAIL != null || v.CRITERIA_DETAIL != undefined)
                        td += v.CRITERIA_DETAIL;
                    else
                        td += '-';
                    td += '</td>';
                td += '<td class="text-center criteria_score">' + v.CRITERIA_SCORE + '</td>';
                td += '<td class="text-center criteria_score_sign">' + v.CRITERIA_SCORE_SIGN + '</td>';
                td += '<td class="text-center"><span class="hidden id_criteria">' + v.ID_CRITERIA + '</span><span class="hidden criteria_trigger_by">' + v.CRITERIA_TRIGGER_BY + '</span>' + (v.CRITERIA_TRIGGER_BY == '0' ? 'System' : 'Manual') +'</td>';
                td += '<td class="text-center t_or_v">' + v.T_OR_V + '</td>';
                td += '<td class="text-center req_or_buyer">' + v.REQ_OR_BUYER + '</td>';
                td += '<td class="text-center special_sanction"><span class="hidden id_special_sanction">' + v.SPECIAL_SANCTION + '</span>' + v.SANCTION_NAME + '</td>';  
                m = '';
                if(v.CRITERIA_TRIGGER_BY==1){
                    m = '<a href="#!" class="btn btn-danger btn-sm" onclick="hapusrow(this)">Hapus</a>';
                }
                td += '<td class="text-center"><a href="#!" class="btn btn-primary btn-sm" onclick="editrow(this)">Edit</a> &nbsp;'+m+'</td>';
                
                tr = '<tr>' + td + '</tr>';
                $("#tabelnya").append(tr);
            }
            if (table_criteria == null) {
                table_criteria = $('#table_criteria').DataTable({
                    "bSort": false,
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
    if ($("#modal_new_t_or_v").length > 0) {
        $modal_new_t_or_v = $("#modal_new_t_or_v").selectize();
        selectize_new_t_or_v = $modal_new_t_or_v[0].selectize;
    }
    if ($("#modal_new_req_or_buyer").length > 0) {
        $modal_new_req_or_buyer = $("#modal_new_req_or_buyer").selectize();
        selectize_new_req_or_buyer = $modal_new_req_or_buyer[0].selectize;
    }
    if ($("#modal_new_criteria_trigger_by").length > 0) {
        $modal_new_criteria_trigger_by = $("#modal_new_criteria_trigger_by").selectize();
        selectize_new_criteria_trigger_by = $modal_new_criteria_trigger_by[0].selectize;
    }
    if ($("#modal_new_criteria_score_sign").length > 0) {
        $modal_new_criteria_score_sign = $("#modal_new_criteria_score_sign").selectize();
        selectize_new_criteria_score_sign = $modal_new_criteria_score_sign[0].selectize;
    }
    if ($("#modal_new_special_sanction").length > 0) {
        $modal_new_special_sanction = $("#modal_new_special_sanction").selectize();
        selectize_new_special_sanction = $modal_new_special_sanction[0].selectize;
    }

    if ($("#modal_edit_t_or_v").length > 0) {
        $modal_edit_t_or_v = $("#modal_edit_t_or_v").selectize();
        selectize_edit_t_or_v = $modal_edit_t_or_v[0].selectize;
    }
    if ($("#modal_edit_req_or_buyer").length > 0) {
        $modal_edit_req_or_buyer = $("#modal_edit_req_or_buyer").selectize();
        selectize_edit_req_or_buyer = $modal_edit_req_or_buyer[0].selectize;
    }
    if ($("#modal_edit_criteria_trigger_by").length > 0) {
        $modal_edit_criteria_trigger_by = $("#modal_edit_criteria_trigger_by").selectize();
        selectize_edit_criteria_trigger_by = $modal_edit_criteria_trigger_by[0].selectize;
    }
    if ($("#modal_edit_criteria_score_sign").length > 0) {
        $modal_edit_criteria_score_sign = $("#modal_edit_criteria_score_sign").selectize();
        selectize_edit_criteria_score_sign = $modal_edit_criteria_score_sign[0].selectize;
    }
    if ($("#modal_edit_special_sanction").length > 0) {
        $modal_edit_special_sanction = $("#modal_edit_special_sanction").selectize();
        selectize_edit_special_sanction = $modal_edit_special_sanction[0].selectize;
    }
    if ($("#modal_edit_company").length > 0) {
        $modal_edit_company = $("#modal_edit_company").selectize();
        selectize_edit_company = $modal_edit_company[0].selectize;
    }
    


    $("#save_edit").click(function() {
        swal({
          title: 'Apakah anda yakin?',
          text: "Data akan disimpan!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, simpan!',
          cancelButtonText: 'Tidak, batal!',
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: false
        },function(confirm) {
            if(confirm){
                $.ajax({
                    url: $("#base-url").val() + 'Performance_criteria/edit',
                    type: 'post',
                    dataType: 'json',
                    data: $("#form_edit").serialize(),
                })
                .done(function(data) {
                    if (data.status == 'success') {
                       swal(
                            'Berhasil!',
                            'Data telah disimpan.',
                            'success'
                          );
                    } else {
                        swal(
                            'Gagal!',
                            'Data gagal disimpan.',
                            'error'
                          );
                    }
                })
                .fail(function() {
                    swal(
                            'Gagal!',
                            'Data gagal disimpan.',
                            'error'
                          );
                    })
                .always(function(data) {
                    populate_table();
                    $(".modal").modal('hide');
                });
            }
          
        });        
       
    });

    $("#save_new").click(function() {
         swal({
          title: 'Apakah anda yakin?',
          text: "Data akan disimpan!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, simpan!',
          cancelButtonText: 'Tidak, batal!',
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: false
        },function(confirm) {
            if(confirm){
                console.log($("#base-url").val());
                $.ajax({
                    url: $("#base-url").val() + 'Performance_criteria/add',
                    type: 'post',
                    dataType: 'json',
                    data: $("#form_new").serialize(),
                })
                .done(function(data) {
                    if (data.status == 'success') {                        
                         swal(
                            'Berhasil!',
                            'Data telah ditambahkan.',
                            'success'
                          );
                    } else {
                        swal(
                            'Gagal!',
                            'Data gagal ditambahkan.',
                            'error'
                          );
                    }
                })
                .fail(function() {
                    swal(
                            'Gagal!',
                            'Data gagal ditambahkan.',
                            'error'
                          );
                })
                .always(function(data) {
                    // console.log(data);
                    populate_table();
                    $(".modal").modal('hide');
                });
            }
        });
    });

    $("#button_tambah").click(function() {
        $("#new_modal").modal('show');
    });
});